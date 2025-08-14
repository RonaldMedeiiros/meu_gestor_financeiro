<?php
// app/Models/Transaction.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Transaction extends Model
{
    use HasFactory;

    /**
     * Os campos que podem ser preenchidos em massa
     */
    protected $fillable = [
        'description',
        'amount',
        'type',
        'status',
        'month',
        'year'
    ];

    /**
     * Casts para os campos
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Scopes
    public function scopeByMonth(Builder $query, string $month, string $year): Builder
    {
        return $query->where('month', $month)->where('year', $year);
    }
    public function scopeEntries(Builder $query): Builder
    {
        return $query->where('type', 'ENTRADA');
    }
    public function scopeExpenses(Builder $query): Builder
    {
        return $query->where('type', 'SAIDA');
    }
    public function scopePaid(Builder $query): Builder
    {
        return $query->where('status', 'PAGO');
    }
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'PENDENTE');
    }

    // Métodos estáticos para totais
    public static function getTotalEntries(string $month, string $year): float
    {
        return static::byMonth($month, $year)
                    ->entries()
                    ->sum('amount');
    }
    public static function getTotalExpenses(string $month, string $year): float
    {
        return static::byMonth($month, $year)
                    ->expenses()
                    ->sum('amount');
    }
    public static function getBalance(string $month, string $year): float
    {
        $entries = static::getTotalEntries($month, $year);
        $expenses = static::getTotalExpenses($month, $year);
        return $entries - $expenses;
    }
    public static function getPaidExpenses(string $month, string $year): float
    {
        return static::byMonth($month, $year)
                    ->expenses()
                    ->paid()
                    ->sum('amount');
    }
    public static function getPendingExpenses(string $month, string $year): float
    {
        return static::byMonth($month, $year)
                    ->expenses()
                    ->pending()
                    ->sum('amount');
    }

    // Accessors
    public function getFormattedAmountAttribute(): string
    {
        return 'R$ ' . number_format($this->amount, 2, ',', '.');
    }
    public function getMonthNameAttribute(): string
    {
        $months = [
            '01' => 'Janeiro',   '02' => 'Fevereiro', '03' => 'Março',
            '04' => 'Abril',     '05' => 'Maio',      '06' => 'Junho',
            '07' => 'Julho',     '08' => 'Agosto',    '09' => 'Setembro',
            '10' => 'Outubro',   '11' => 'Novembro',  '12' => 'Dezembro'
        ];
        return $months[$this->month] ?? 'Mês Inválido';
    }

    // Métodos utilitários
    public function toggleStatus(): void
    {
        $this->status = $this->status === 'PAGO' ? 'PENDENTE' : 'PAGO';
        $this->save();
    }
    public function isPaid(): bool
    {
        return $this->status === 'PAGO';
    }
    public function isEntry(): bool
    {
        return $this->type === 'ENTRADA';
    }
    public function isExpense(): bool
    {
        return $this->type === 'SAIDA';
    }
    public static function createBatch(array $transactions): void
    {
        foreach ($transactions as $transaction) {
            static::create($transaction);
        }
    }
}
