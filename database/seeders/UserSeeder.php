<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {






        DB::transaction(function(){

            //admin
            $user = User::create([
                'national_code' => '5555555555',
                'mobile' => 1111111111,
                'password' => '00000000',
                'firstname' => 'admin',
                'lastname' => 'admin',
                'birth_date' => '1990-01-01',
             ]);

             $user->personnel()->create([
                'firstname' => 'hossein',
                'lastname' => 'azimi',
             ]);

            //user for patient
            $user = User::create([
                'national_code' => '0000000000',
                'mobile' => 9369422072,
                'password' => '00000000',
                'firstname' => 'patient',
                'lastname' => 'patient',
                'birth_date' => '1990-01-01',
             ]);

             $user->patient()->create([
                'firstname' => 'ali',
                'lastname' => 'torabi',
                'age' => '34',
                'gender' => 'MALE'
             ]);


            // user for resource
             $user = User::create([
                'national_code' => '11111111',
                'mobile' => 9166666666,
                'password' => '00000000',
                 'firstname' => 'userResource',
                 'lastname' => 'userResource',
                 'birth_date' => '1990-01-01',
             ]);

             $user->resource()->create([
                'firstname' => 'reza',
                'lastname' => 'mirzaei',
             ]);


            //resource for both

             $user = User::create([
                'national_code' => '2222222222',
                'mobile' => 9167777777,
                'password' => '00000000',
                 'firstname' => 'bothResource',
                 'lastname' => 'bothResource',
                 'birth_date' => '1990-01-01',
             ]);

             $user->patient()->create([
                'firstname' => 'mona',
                'lastname' => 'tavasoli',
                'age' => '34',
                'gender' => 'MALE'
             ]);

             $user->resource()->create([
                'firstname' => 'mona',
                'lastname' => 'tavasoli',
             ]);




        });

    }
}
