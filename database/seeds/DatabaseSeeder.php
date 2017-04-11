<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // For Farid
        DB::table('users')->insert([
          'city' => 'Bakı',
          'username' => "Farid",
          'phone' => '+994553014933',
          'name' => 'Farid Babayev',
          'email' => 'farid.b@code.edu.az',
          'password' => bcrypt('foralfagen123'),
          'avatar' => 'prof.png',
          'isAdmin' => '1',
          'activated' => '1',
        ]);
        // For Lale
        DB::table('users')->insert([
          'city' => 'Bakı',
          'username' => "Lala",
          'phone' => '+994550000000',
          'name' => 'Lale Memmedova',
          'email' => 'lale.m@code.edu.az',
          'password' => bcrypt('foralfagen123'),
          'avatar' => 'prof.png',
          'isAdmin' => '1',
          'activated' => '1',
        ]);
        // For Naseh
        DB::table('users')->insert([
          'city' => 'Bakı',
          'username' => "Naseh",
          'phone' => '+994550000000',
          'name' => 'Naseh Badalov',
          'email' => 'naseh.b@code.edu.az',
          'password' => bcrypt('foralfagen123'),
          'avatar' => 'prof.png',
          'isAdmin' => '1',
          'activated' => '1',
        ]);
        // For Gunel
        DB::table('users')->insert([
          'city' => 'Bakı',
          'username' => "Gunel",
          'phone' => '+994550000000',
          'name' => 'Gunel Ismayilova',
          'email' => 'gunel.i@code.edu.az',
          'password' => bcrypt('foralfagen123'),
          'avatar' => 'prof.png',
          'isAdmin' => '1',
          'activated' => '1',
        ]);

        DB::table('elantypes')->insert([
           'name' => 'destek',
        ]);

        DB::table('elantypes')->insert([
           'name' => 'istek',
        ]);
    }
}
