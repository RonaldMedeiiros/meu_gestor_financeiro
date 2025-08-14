<?php
// database/migrations/2025_08_14_000000_create_transactions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Esta migration cria a tabela que armazenará todas as movimentações financeiras
     * baseada na estrutura da sua planilha original
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // Chave primária auto-incremento
            
            // Campos principais baseados na sua planilha
            $table->string('description'); // Ex: "ALUGUEL", "Kikker", "CARTAO NEON"
            $table->decimal('amount', 10, 2); // Valor com 2 casas decimais
            $table->enum('type', ['ENTRADA', 'SAIDA']); // Tipo da movimentação
            $table->enum('status', ['PAGO', 'PENDENTE'])->default('PENDENTE'); // Status do pagamento
            
            // Campos para organização temporal (igual sua planilha por mês)
            $table->string('month', 2); // '01' a '12'
            $table->string('year', 4); // '2024', '2025', etc.
            
            // Campos de controle do Laravel
            $table->timestamps(); // created_at e updated_at
            
            // Índices para melhor performance nas consultas
            $table->index(['month', 'year']); // Consultas por período
            $table->index(['type', 'month', 'year']); // Consultas por tipo e período
            $table->index('status'); // Consultas por status
        });
    }

    /**
     * Reverse the migrations.
     * Remove a tabela se precisarmos reverter a migration
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};