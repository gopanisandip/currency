<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $array = [];
        for($i = 0; $i < 10; $i++) {
            $date = Carbon::now()->subDays(rand(1, 100))->toDateString();
            $a = [
                'curr_id' => getToken(rand(7, 10)),
                'date' => $date,
                'name' => 'Foreign Currency Market',
                'NumCode' => rand(10, 999),
                'CharCode' => getToken(3, true),
                'Nominal' => 100,
                'CurrName' => getToken(50),
                'Value' => rand(999, 99999),
            ];
            array_push($array, $a);
        }
//        dd($array);

        DB::table('currencies')->insert($array);
    }
}
