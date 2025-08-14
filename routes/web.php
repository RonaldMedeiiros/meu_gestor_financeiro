<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

// Dashboard principal
Route::get('/', [TransactionController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [TransactionController::class, 'index'])->name('dashboard.show');

// Página de transações
Route::get('/transactions', [TransactionController::class, 'transactions'])->name('transactions.index');

// Criar novas transações
Route::post('/entries', [TransactionController::class, 'storeEntry'])->name('entries.store');
Route::post('/expenses', [TransactionController::class, 'storeExpense'])->name('expenses.store');

// Manipular transações existentes
Route::patch('/transactions/{transaction}/toggle-status', [TransactionController::class, 'toggleStatus'])->name('transactions.toggle-status');
Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

// Rotas AJAX/API
Route::get('/api/dashboard-data', [TransactionController::class, 'getDashboardData'])->name('api.dashboard-data');

// Relatórios e funcionalidades avançadas
Route::get('/reports/monthly', [TransactionController::class, 'monthlyReport'])->name('reports.monthly');
Route::post('/import', [TransactionController::class, 'importSpreadsheet'])->name('import.spreadsheet');

// Navegação rápida por período
Route::get('/month/{month}/{year}', function ($month, $year) {
    return redirect()->route('dashboard', ['month' => $month, 'year' => $year]);
})->name('month.show')->where(['month' => '[0-1][0-9]', 'year' => '[0-9]{4}']);

Route::get('/current-month', function () {
    return redirect()->route('dashboard', [
        'month' => now()->format('m'),
        'year' => now()->format('Y')
    ]);
})->name('current-month');

// Rotas de teste e debug (apenas em desenvolvimento)
Route::get('/test-data', function () {
    if (app()->environment('local')) {
        App\Models\Transaction::create([
            'description' => 'Teste Entrada',
            'amount' => 1000.00,
            'type' => 'ENTRADA',
            'status' => 'PAGO',
            'month' => now()->format('m'),
            'year' => now()->format('Y')
        ]);
        return 'Dados de teste criados!';
    }
    return 'Disponível apenas em desenvolvimento.';
})->name('test.data');

Route::get('/clear-data', function () {
    if (app()->environment('local')) {
        App\Models\Transaction::truncate();
        return 'Dados limpos!';
    }
    return 'Disponível apenas em desenvolvimento.';
})->name('clear.data');
