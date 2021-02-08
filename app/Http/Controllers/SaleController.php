<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Jobs\SaleCsvProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;

class SaleController extends Controller
{
    public function upload()
    {
        if(request()->has('csv'))
        {
            $csv = file(request()->csv);
            $chunks = array_chunk($csv,1);
            $header = [];
            $batch = Bus::batch([])->dispatch();
            foreach ($chunks as $key => $chunk) {
            $data = array_map('str_getcsv', $chunk);
                if($key == 0){
                    $header = $data[0];
                    unset($data[0]);
                }
                $batch->add(new SaleCsvProcess($data, $header));
            }
            return $batch;
        }
        return "please upload csv file";
    }
    
    public function batch()
    {
        $batchId = request('id');
        return Bus::findBatch($batchId);
    }
}
