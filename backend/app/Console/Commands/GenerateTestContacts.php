<?php

namespace App\Console\Commands;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Console\Command;
use Faker\Factory as Faker;

class GenerateTestContacts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contacts:generate {--user_id=1 : ID do usuário} {--count=30 : Quantidade de contatos a criar}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gera contatos de teste para um usuário específico';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userId = (int) $this->option('user_id');
        $count = (int) $this->option('count');

        // Validar quantidade
        if ($count < 1 || $count > 1000) {
            $this->error('A quantidade deve estar entre 1 e 1000');
            return 1;
        }

        // Verificar se o usuário existe
        $user = User::find($userId);
        if (!$user) {
            $this->error("Usuário com ID {$userId} não encontrado!");
            if ($this->confirm('Deseja criar um usuário de teste?', true)) {
                $user = User::create([
                    'name' => 'Usuário Teste',
                    'email' => "teste{$userId}@example.com",
                    'password' => \Hash::make('123456'),
                ]);
                $this->info("✓ Usuário criado com ID {$user->id}");
            } else {
                return 1;
            }
        }

        $this->info("Gerando {$count} contatos de teste para o usuário: {$user->name} (ID: {$userId})...");

        $faker = Faker::create('pt_BR');
        $bar = $this->output->createProgressBar($count);
        $bar->start();

        for ($i = 0; $i < $count; $i++) {
            Contact::create([
                'user_id' => $userId,
                'name' => $faker->name(),
                'phone' => $faker->numerify('###########'), // 11 dígitos
                'email' => $faker->unique()->safeEmail(),
            ]);

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("✓ {$count} contatos criados com sucesso para o usuário ID {$userId}!");

        return 0;
    }
}

