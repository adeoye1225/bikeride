<?php

namespace App\Concrete;


use App\Interfaces\ProcessFileInterface;
use Carbon\Carbon;

class ProcessReport implements ProcessFileInterface
{



    public function process_report($data){

        $total_duration = $this->loop_data($data);
        if(count($total_duration) > 0){

            return $this->average_calculation($total_duration);
        }
        return "No valid data to process";

    }

    private function loop_data($data){

        $duration = [];
        foreach ($data as $datum) {

            $duration_in_secconds = $this->validate_data($datum[0], $datum[1],$datum[2],$datum[3]);

            if($duration_in_secconds){

                $duration[] = $duration_in_secconds;
            }


        }

        return $duration;

    }

    private function average_calculation(array $duration){

        $average = $this->calcute_avarage($duration);
        if($average){

            return $this->convert_to_hours_min_sec($average);
        }

    }

    private function calcute_avarage(array $duration){

        $a = array_filter($duration);
        if(count($a) > 0){


            return array_sum($a)/count($a);
        }

    }

    private function convert_to_hours_min_sec($totalDuration){

        return gmdate('H:i:s', $totalDuration);
    }
   
    private function validate_data($station_id, $bike_id, $arrived_at, $departed_at){

        if($this->validate_station($station_id) && $this->validate_bike($bike_id) && $this->validate_dates($departed_at, $arrived_at) && $this->date_difference($departed_at, $arrived_at) > 0){

            return $this->date_difference($departed_at, $arrived_at);
        }


    }

    private function validate_station(int $station_id){

        if($station_id && $station_id >= 1 && $station_id <= 1000){

            return true;
        }
    }

    private function validate_bike(int $bike_id){

        if($bike_id && $bike_id >= 1 && $bike_id <= 10000){

            return true;
        }
    }

    private function validate_dates ($departed_at, $arrived_at) {

        if($departed_at && $arrived_at) {

            return true;
        }
    }

    private function date_difference($departed_at, $arrived_at){

        $start_time = Carbon::parse($departed_at);
        $end_time = Carbon::parse($arrived_at);
        $duration = $end_time->diffInSeconds($start_time); 
        return $duration;


    }
}