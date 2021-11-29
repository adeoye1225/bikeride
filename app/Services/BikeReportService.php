<?php

namespace App\Services;


use App\Interfaces\ReadFileInterface;
use App\Interfaces\ProcessFileInterface;
use Illuminate\Support\Collection;

class BikeReportService
{

    
    private $read_file;
    private $process_file;
    private $path;

    
    

    public function __construct(ReadFileInterface $readFileInterface, ProcessFileInterface $processFileInterface)
    {
        $this->read_file = $readFileInterface;
        $this->process_file = $processFileInterface;
        $this->file = env('DATA_FILE');
        $this->path = base_path($this->file);


    }

    public function get_mean_file(){

        try{
            $get_data = $this->read_file->open_read_file($this->path);
            if(is_array($get_data)){

                $collection = $this->make_collection($get_data);
                //dd($collection);
                return $this->process_file->process_report($collection);
            }
            return $get_data;
        } catch (\Exception $exception) {
            return $exception->getMessage();
            

        }
    }


    private function make_collection($data) {

        $collection = new Collection();
        foreach($data as $item){
                $collection->push((object)['station_id' => $item[0],
                                           'bike_id'=>$item[1],
                                           'arrived_at'=>$item[2],
                                           'departed_at'=>$item[3],

                ]);

            
        }
        return $collection;

    }


}
