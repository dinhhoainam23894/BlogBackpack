<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i=0 ; $i<= 1500000;$i++){
            DB::table('persons')->insert([
            'seq' => $i,
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
                'term' => '199'.rand(0,9).'-201'.rand(0,9),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
             ]);
        }
    }
}
