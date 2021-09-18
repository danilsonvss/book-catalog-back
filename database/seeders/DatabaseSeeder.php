<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        (new User)->create([
            'name' => 'Usuário do Sistema',
            'email' => 'usuario@bookcatalog.com',
            'password' => bcrypt('senha'),
        ]);
    }
}
