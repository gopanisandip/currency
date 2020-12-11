<?php

namespace App\Console\Commands;

use App\Models\Curruncy;
use Illuminate\Console\Command;
use GuzzleHttp;
use Illuminate\Support\Facades\File;

class ReadCurrencyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ReadCurrencyData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ReadCurrencyData';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {


        $fileContents= file_get_contents('http://www.cbr.ru/scripts/XML_daily.asp');
        $fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
        $fileContents = trim(str_replace('"', "'", $fileContents));
        $simpleXml = simplexml_load_string($fileContents);
        $json = json_encode($simpleXml);
        $json = json_decode($json, true);

//dd($json);

        $date = explode('.', $json['@attributes']['Date']);



        $name = $json['@attributes']['name'];

        foreach($json['Valute'] as $index => $j){

//            dd($date);
            $currency = new Curruncy;
            $currency->curr_id = $j['@attributes']['ID'];
            $currency->date = $date[2].'-'.$date[1].'-' .$date[0];
            $currency->name = $name;
            $currency->NumCode = $j['NumCode'];
            $currency->CharCode = $j['CharCode'];
            $currency->Nominal = $j['Nominal'];
            $currency->CurrName = $j['Name'];
            $currency->Value = filter_var($j['Value'], FILTER_SANITIZE_NUMBER_INT);
            $currency->save();


        }


    }
}
