<?php
// database/seeders/TransactionSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transaction;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    /**
     * Seed the database with initial transactions based on your original spreadsheet.
     * 
     * Este seeder popula o banco com os dados da sua planilha original,
     * criando as transações exatamente como você tinha organizado.
     */
    public function run(): void
    {
        // Limpar dados existentes (opcional - remova se não quiser)
        Transaction::truncate();

        // Dados baseados na sua planilha original
        $currentMonth = Carbon::now()->format('m');
        $currentYear = Carbon::now()->format('Y');

        // Entradas baseadas na sua planilha
        $entradas = [
            [
                'description' => 'Kikker',
                'amount' => 2630.00,
                'type' => 'ENTRADA',
                'status' => 'PAGO',
                'month' => $currentMonth,
                'year' => $currentYear,
                'created_at' => Carbon::now()->subDays(15),
                'updated_at' => Carbon::now()->subDays(15)
            ],
            [
                'description' => 'Dakila',
                'amount' => 3500.00,
                'type' => 'ENTRADA',
                'status' => 'PAGO',
                'month' => $currentMonth,
                'year' => $currentYear,
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(10)
            ],
            [
                'description' => 'Plano de Saúde',
                'amount' => 0.00, // Conforme sua planilha
                'type' => 'ENTRADA',
                'status' => 'PAGO',
                'month' => $currentMonth,
                'year' => $currentYear,
                'created_at' => Carbon::now()->subDays(8),
                'updated_at' => Carbon::now()->subDays(8)
            ],
            [
                'description' => 'João',
                'amount' => 681.00, // Valor da coluna ENTRADA da planilha
                'type' => 'ENTRADA',
                'status' => 'PAGO',
                'month' => $currentMonth,
                'year' => $currentYear,
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5)
            ]
        ];

        // Saídas baseadas na sua planilha
        $saidas = [
            [
                'description' => 'ALUGUEL',
                'amount' => 2100.00,
                'type' => 'SAIDA',
                'status' => 'PENDENTE', // Na planilha não estava marcado como pago
                'month' => $currentMonth,
                'year' => $currentYear,
                'created_at' => Carbon::now()->subDays(20),
                'updated_at' => Carbon::now()->subDays(20)
            ],
            [
                'description' => 'CARTAO NU CPF',
                'amount' => 0.00, // Conforme sua planilha
                'type' => 'SAIDA',
                'status' => 'PENDENTE',
                'month' => $currentMonth,
                'year' => $currentYear,
                'created_at' => Carbon::now()->subDays(18),
                'updated_at' => Carbon::now()->subDays(18)
            ],
            [
                'description' => 'CARTAO NU CNPJ',
                'amount' => 0.00, // Conforme sua planilha
                'type' => 'SAIDA',
                'status' => 'PENDENTE',
                'month' => $currentMonth,
                'year' => $currentYear,
                'created_at' => Carbon::now()->subDays(16),
                'updated_at' => Carbon::now()->subDays(16)
            ],
            [
                'description' => 'CARTAO NEON',
                'amount' => 1400.00,
                'type' => 'SAIDA',
                'status' => 'PENDENTE', // Na planilha não estava marcado
                'month' => $currentMonth,
                'year' => $currentYear,
                'created_at' => Carbon::now()->subDays(14),
                'updated_at' => Carbon::now()->subDays(14)
            ],
            [
                'description' => 'CARTAO ATACADAO',
                'amount' => 820.00,
                'type' => 'SAIDA',
                'status' => 'PAGO', // Na planilha estava marcado como "PAGO"
                'month' => $currentMonth,
                'year' => $currentYear,
                'created_at' => Carbon::now()->subDays(12),
                'updated_at' => Carbon::now()->subDays(12)
            ],
            [
                'description' => 'CARTAO PICPAY',
                'amount' => 0.00, // Conforme sua planilha
                'type' => 'SAIDA',
                'status' => 'PAGO', // Na planilha estava marcado como "PAGO"
                'month' => $currentMonth,
                'year' => $currentYear,
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(10)
            ],
            [
                'description' => 'Davi',
                'amount' => 150.00,
                'type' => 'SAIDA',
                'status' => 'PAGO', // Na planilha estava marcado como "PAGO"
                'month' => $currentMonth,
                'year' => $currentYear,
                'created_at' => Carbon::now()->subDays(8),
                'updated_at' => Carbon::now()->subDays(8)
            ],
            [
                'description' => 'VIP',
                'amount' => 160.00,
                'type' => 'SAIDA',
                'status' => 'PAGO', // Na planilha estava marcado como "PAGO"
                'month' => $currentMonth,
                'year' => $currentYear,
                'created_at' => Carbon::now()->subDays(6),
                'updated_at' => Carbon::now()->subDays(6)
            ],
            [
                'description' => 'Oferta',
                'amount' => 50.00,
                'type' => 'SAIDA',
                'status' => 'PAGO', // Na planilha estava marcado como "PAGO"
                'month' => $currentMonth,
                'year' => $currentYear,
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subDays(4)
            ]
        ];

        // Inserir entradas
        foreach ($entradas as $entrada) {
            Transaction::create($entrada);
        }

        // Inserir saídas
        foreach ($saidas as $saida) {
            Transaction::create($saida);
        }

        // Dados adicionais para outros meses (para demonstração)
        $this->seedAdditionalMonths();

        $this->command->info('✅ Transações da planilha inseridas com sucesso!');
        $this->command->info('📊 Total de entradas inseridas: ' . count($entradas));
        $this->command->info('📊 Total de saídas inseridas: ' . count($saidas));
    }

    /**
     * Cria dados adicionais para outros meses para demonstração completa
     */
    private function seedAdditionalMonths(): void
    {
        // Dados para mês anterior
        $lastMonth = Carbon::now()->subMonth();
        
        $lastMonthData = [
            // Entradas mês anterior
            [
                'description' => 'Kikker',
                'amount' => 2500.00,
                'type' => 'ENTRADA',
                'status' => 'PAGO',
                'month' => $lastMonth->format('m'),
                'year' => $lastMonth->format('Y'),
                'created_at' => $lastMonth->copy()->addDays(5),
                'updated_at' => $lastMonth->copy()->addDays(5)
            ],
            [
                'description' => 'Dakila',
                'amount' => 3200.00,
                'type' => 'ENTRADA',
                'status' => 'PAGO',
                'month' => $lastMonth->format('m'),
                'year' => $lastMonth->format('Y'),
                'created_at' => $lastMonth->copy()->addDays(10),
                'updated_at' => $lastMonth->copy()->addDays(10)
            ],
            // Saídas mês anterior
            [
                'description' => 'ALUGUEL',
                'amount' => 2100.00,
                'type' => 'SAIDA',
                'status' => 'PAGO',
                'month' => $lastMonth->format('m'),
                'year' => $lastMonth->format('Y'),
                'created_at' => $lastMonth->copy()->addDays(1),
                'updated_at' => $lastMonth->copy()->addDays(1)
            ],
            [
                'description' => 'CARTAO NEON',
                'amount' => 1350.00,
                'type' => 'SAIDA',
                'status' => 'PAGO',
                'month' => $lastMonth->format('m'),
                'year' => $lastMonth->format('Y'),
                'created_at' => $lastMonth->copy()->addDays(15),
                'updated_at' => $lastMonth->copy()->addDays(15)
            ],
            [
                'description' => 'CARTAO ATACADAO',
                'amount' => 750.00,
                'type' => 'SAIDA',
                'status' => 'PAGO',
                'month' => $lastMonth->format('m'),
                'year' => $lastMonth->format('Y'),
                'created_at' => $lastMonth->copy()->addDays(18),
                'updated_at' => $lastMonth->copy()->addDays(18)
            ]
        ];

        // Dados para próximo mês (planejamento)
        $nextMonth = Carbon::now()->addMonth();
        
        $nextMonthData = [
            [
                'description' => 'ALUGUEL',
                'amount' => 2100.00,
                'type' => 'SAIDA',
                'status' => 'PENDENTE',
                'month' => $nextMonth->format('m'),
                'year' => $nextMonth->format('Y'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'description' => 'Planejamento Kikker',
                'amount' => 2630.00,
                'type' => 'ENTRADA',
                'status' => 'PENDENTE',
                'month' => $nextMonth->format('m'),
                'year' => $nextMonth->format('Y'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        // Inserir dados dos meses adicionais
        foreach (array_merge($lastMonthData, $nextMonthData) as $transaction) {
            Transaction::create($transaction);
        }

        $this->command->info('📅 Dados adicionais para outros meses criados!');
    }

    /**
     * Seed com dados aleatórios para testes (método alternativo)
     */
    public function seedRandomData(): void
    {
        $descriptions_entradas = [
            'Freelance Web', 'Consultoria', 'Venda Produto', 'Rendimento Investimento',
            'Trabalho Extra', 'Comissão', 'Bonificação', 'Reembolso'
        ];

        $descriptions_saidas = [
            'Supermercado', 'Gasolina', 'Restaurante', 'Farmácia', 'Internet',
            'Academia', 'Streaming', 'Transporte', 'Médico', 'Roupas'
        ];

        // Criar 20 transações aleatórias para teste
        for ($i = 0; $i < 10; $i++) {
            // Entrada aleatória
            Transaction::create([
                'description' => $descriptions_entradas[array_rand($descriptions_entradas)],
                'amount' => rand(100, 5000),
                'type' => 'ENTRADA',
                'status' => 'PAGO',
                'month' => Carbon::now()->format('m'),
                'year' => Carbon::now()->format('Y'),
                'created_at' => Carbon::now()->subDays(rand(1, 30)),
                'updated_at' => Carbon::now()
            ]);

            // Saída aleatória
            Transaction::create([
                'description' => $descriptions_saidas[array_rand($descriptions_saidas)],
                'amount' => rand(50, 1500),
                'type' => 'SAIDA',
                'status' => rand(0, 1) ? 'PAGO' : 'PENDENTE',
                'month' => Carbon::now()->format('m'),
                'year' => Carbon::now()->format('Y'),
                'created_at' => Carbon::now()->subDays(rand(1, 30)),
                'updated_at' => Carbon::now()
            ]);
        }

        $this->command->info('🎲 Dados aleatórios criados para teste!');
    }
}