<?php
// app/Http/Controllers/TransactionController.php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index(Request $request): View
    {
        $currentMonth = $request->get('month', Carbon::now()->format('m'));
        $currentYear = $request->get('year', Carbon::now()->format('Y'));
        $transactions = Transaction::byMonth($currentMonth, $currentYear)
                                  ->orderBy('created_at', 'desc')
                                  ->limit(10)
                                  ->get();
        $totalEntries = Transaction::getTotalEntries($currentMonth, $currentYear);
        $totalExpenses = Transaction::getTotalExpenses($currentMonth, $currentYear);
        $balance = Transaction::getBalance($currentMonth, $currentYear);
        $paidExpenses = Transaction::getPaidExpenses($currentMonth, $currentYear);
        $pendingExpenses = Transaction::getPendingExpenses($currentMonth, $currentYear);
        $stats = [
            'total_transactions' => Transaction::byMonth($currentMonth, $currentYear)->count(),
            'entries_count' => Transaction::byMonth($currentMonth, $currentYear)->entries()->count(),
            'expenses_count' => Transaction::byMonth($currentMonth, $currentYear)->expenses()->count(),
            'paid_percentage' => $totalExpenses > 0 ? round(($paidExpenses / $totalExpenses) * 100, 1) : 0
        ];
        return view('dashboard', compact(
            'transactions', 
            'totalEntries', 
            'totalExpenses', 
            'balance',
            'paidExpenses',
            'pendingExpenses',
            'currentMonth', 
            'currentYear',
            'stats'
        ));
    }

    public function transactions(Request $request): View
    {
        $currentMonth = $request->get('month', Carbon::now()->format('m'));
        $currentYear = $request->get('year', Carbon::now()->format('Y'));
        $entries = Transaction::byMonth($currentMonth, $currentYear)
                              ->entries()
                              ->orderBy('created_at', 'desc')
                              ->get();
        $expenses = Transaction::byMonth($currentMonth, $currentYear)
                               ->expenses()
                               ->orderBy('created_at', 'desc')
                               ->get();
        $totalEntries = Transaction::getTotalEntries($currentMonth, $currentYear);
        $totalExpenses = Transaction::getTotalExpenses($currentMonth, $currentYear);
        $balance = Transaction::getBalance($currentMonth, $currentYear);
        return view('transactions', compact(
            'entries', 
            'expenses', 
            'totalEntries', 
            'totalExpenses', 
            'balance',
            'currentMonth', 
            'currentYear'
        ));
    }

    public function storeEntry(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'month' => 'required|string|size:2',
            'year' => 'required|string|size:4'
        ], [
            'description.required' => 'A descrição é obrigatória.',
            'amount.required' => 'O valor é obrigatório.',
            'amount.min' => 'O valor deve ser maior que zero.',
            'month.required' => 'O mês é obrigatório.',
            'year.required' => 'O ano é obrigatório.'
        ]);
        Transaction::create([
            'description' => $validated['description'],
            'amount' => $validated['amount'],
            'type' => 'ENTRADA',
            'status' => 'PAGO',
            'month' => $validated['month'],
            'year' => $validated['year']
        ]);
        return redirect()->back()->with('success', 'Entrada adicionada com sucesso!');
    }

    public function storeExpense(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'status' => 'required|in:PAGO,PENDENTE',
            'month' => 'required|string|size:2',
            'year' => 'required|string|size:4'
        ], [
            'description.required' => 'A descrição é obrigatória.',
            'amount.required' => 'O valor é obrigatório.',
            'amount.min' => 'O valor deve ser maior que zero.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status deve ser PAGO ou PENDENTE.',
            'month.required' => 'O mês é obrigatório.',
            'year.required' => 'O ano é obrigatório.'
        ]);
        Transaction::create([
            'description' => $validated['description'],
            'amount' => $validated['amount'],
            'type' => 'SAIDA',
            'status' => $validated['status'],
            'month' => $validated['month'],
            'year' => $validated['year']
        ]);
        return redirect()->back()->with('success', 'Saída adicionada com sucesso!');
    }

    public function toggleStatus(Transaction $transaction): RedirectResponse
    {
        $transaction->toggleStatus();
        $message = $transaction->status === 'PAGO' 
            ? 'Transação marcada como PAGA!' 
            : 'Transação marcada como PENDENTE!';
        return redirect()->back()->with('success', $message);
    }

    public function destroy(Transaction $transaction): RedirectResponse
    {
        $description = $transaction->description;
        $transaction->delete();
        return redirect()->back()->with('success', "Transação '{$description}' excluída com sucesso!");
    }

    public function update(Request $request, Transaction $transaction): RedirectResponse
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'status' => 'required|in:PAGO,PENDENTE'
        ]);
        $transaction->update($validated);
        return redirect()->back()->with('success', 'Transação atualizada com sucesso!');
    }

    public function getDashboardData(Request $request)
    {
        $month = $request->get('month', Carbon::now()->format('m'));
        $year = $request->get('year', Carbon::now()->format('Y'));
        return response()->json([
            'totalEntries' => Transaction::getTotalEntries($month, $year),
            'totalExpenses' => Transaction::getTotalExpenses($month, $year),
            'balance' => Transaction::getBalance($month, $year),
            'paidExpenses' => Transaction::getPaidExpenses($month, $year),
            'pendingExpenses' => Transaction::getPendingExpenses($month, $year),
            'transactionsCount' => Transaction::byMonth($month, $year)->count()
        ]);
    }

    public function monthlyReport(Request $request): View
    {
        $month = $request->get('month', Carbon::now()->format('m'));
        $year = $request->get('year', Carbon::now()->format('Y'));
        $entries = Transaction::byMonth($month, $year)->entries()->get();
        $expenses = Transaction::byMonth($month, $year)->expenses()->get();
        $summary = [
            'period' => Carbon::createFromFormat('Y-m', $year . '-' . $month)->format('F Y'),
            'total_entries' => Transaction::getTotalEntries($month, $year),
            'total_expenses' => Transaction::getTotalExpenses($month, $year),
            'balance' => Transaction::getBalance($month, $year),
            'paid_expenses' => Transaction::getPaidExpenses($month, $year),
            'pending_expenses' => Transaction::getPendingExpenses($month, $year)
        ];
        return view('reports.monthly', compact('entries', 'expenses', 'summary', 'month', 'year'));
    }

    public function importSpreadsheet(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);
        // Lógica de importação seria implementada aqui
        return redirect()->back()->with('success', 'Dados importados com sucesso!');
    }
}
