<?php

namespace App\Services;


use App\Interfaces\ReadFileInterface;
use App\Interfaces\ProcessFileInterface;

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

                return $this->process_file->process_report($get_data);
            }
            return $get_data;
        } catch (\Exception $exception) {
            return $exception->getMessage();
            

        }
    }


}
