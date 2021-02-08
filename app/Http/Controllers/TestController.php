<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Jobs\SaleCsvProcess;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function upload()
    {
        if(request()->has('csv'))
        {
            $csv = file(request()->csv);

            //chunking file
            $chunks = array_chunk($csv,1);
            $path = resource_path('temp');

            //convert chunk to new csv file
            foreach ($chunks as $key => $chunk) {
                $name = "/tmp{$key}.csv";
                file_put_contents($path.$name,$chunk);
            }

            //getting all the file inside the directories
            $files = glob("$path/*.csv");

            $header = [];
            foreach ($files as $key => $file) {
                $data = array_map('str_getcsv', file($file));
                if($key == 0)
                {
                    $header = $data[0];
                    unset($data[0]);
                }
                
                SaleCsvProcess::dispatch($data, $header);

                unlink($file);
            }

            return "stored";

        }
        return "please upload csv file";
    }

}
