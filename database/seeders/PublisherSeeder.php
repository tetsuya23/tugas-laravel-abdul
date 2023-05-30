<?php

namespace Database\Seeders;

use App\Models\Publisher;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i=0; $i < 17; $i++) {
            $publisher = new Publisher;

            $publisher->name = $faker->name;
            $publisher->gender = $faker->randomElement(['L','P']);
            $publisher->phone_number = '0823'.$faker->randomNumber(8);
            $publisher->address = $faker->address;
            $publisher->email = $faker->email;

            $publisher-> save(); 
        }
    }
}
