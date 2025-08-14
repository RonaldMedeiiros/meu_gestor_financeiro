<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * Este é o seeder principal que coordena todos os outros seeders.
     * É executado quando você roda o comando: php artisan db:seed
     */
    public function run(): void
    {
        $this->command->info('🚀 Iniciando processo de seed do banco de dados...');
        $this->command->line('');

        // Executar o seeder de transações (baseado na sua planilha)
        $this->call([
            TransactionSeeder::class,
        ]);

        $this->command->line('');
        $this->command->info('✨ Processo de seed concluído com sucesso!');
        $this->command->info('');
        $this->command->line('📱 Sua aplicação está pronta para uso!');
        $this->command->line('🌐 Acesse: http://localhost:8000');
        $this->command->line('');
        $this->command->comment('💡 Dica: Use "php artisan serve" para iniciar o servidor');
    }
}