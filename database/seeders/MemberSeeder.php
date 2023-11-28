<?php

namespace Database\Seeders;

use App\Models\Member;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i=0; $i<20; $i++){
            $members = new Member;

            $members->name = $faker->name;
            $members->gender = $faker->randomElement(['L', 'P']);
            $members->phone_number = '0821'. $faker->randomNumber(8);
            $members->address = $faker->address;
            $members->email = $faker->email;

            

            $members->save();
        }
    }
}
