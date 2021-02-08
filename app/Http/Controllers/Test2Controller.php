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
            $chunks = array_chunk($csv,1);
            $header = [];
            foreach ($chunks as $key => $chunk) {
            $data = array_map('str_getcsv', $chunk);
                if($key == 0){
                    $header = $data[0];
                    unset($data[0]);
                }
                SaleCsvProcess::dispatch($data, $header);
            }
            return "stored";
        }
        return "please upload csv file";
    }

}
