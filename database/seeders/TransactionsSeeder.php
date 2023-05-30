<?php

namespace Database\Seeders;

use App\Models\Tansactions;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i=0; $i < 15; $i++) {
            $transactions = new Transactions;

            $transactions->member_id = $faker->member_id;

            $transactions->save();
        }
    }
}
