<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ContactSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('pt_BR');
        $userId = 1;
        $count = 30;

        if (!\App\Models\User::find($userId)) {
            $this->command->error("Usuário com ID {$userId} não encontrado!");
            $this->command->info("Criando usuário de teste...");
            \App\Models\User::create([
                'name' => 'Usuário Teste',
                'email' => 'teste@example.com',
                'password' => \Illuminate\Support\Facades\Hash::make('123456'),
            ]);
        }

        $this->command->info("Criando {$count} contatos de teste para o usuário ID {$userId}...");

        for ($i = 0; $i < $count; $i++) {
            Contact::create([
                'user_id' => $userId,
                'name' => $faker->name(),
                'phone' => $faker->numerify('###########'),
                'email' => $faker->unique()->safeEmail(),
            ]);

            if (($i + 1) % 10 == 0) {
                $this->command->info("Criados " . ($i + 1) . " contatos...");
            }
        }

        $this->command->info("{$count} contatos criados com sucesso!");
    }
}

