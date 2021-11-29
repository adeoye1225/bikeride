<?php

namespace App\Concrete;


use App\Interfaces\ProcessFileInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ProcessReport implements ProcessFileInterface
{



    
    public function process_report($data){

        //count collection
        
        if(count($data) <= 0 ){

            return "No data in report";
        }

        
        $get_data = $this->sanitize_data($data);

        if(count($get_data) <= 0){

            return "No sanitized data in report";
        }

        //get unique bike id
        $bikes = $get_data->unique('bike_id')->pluck('bike_id')->toArray();

        $get_journey = $this->build_journey_collection($get_data, $bikes);

        if(count($get_journey) <= 0){
            return "No complete journey found in file";

        }
        

        $average = $get_journey->avg('duration');

        return $this->convert_to_hours_min_sec($average);
    }

    private function sanitize_data($data){

        //valid data
        //station_id 1 -1000
        //bike_id 1 - 10000
    
        $get_data = $data->where('station_id', '>=', '1')
                        ->where('station_id', '<=', '1000')
                        ->where('bike_id', '>=', '1')
                        ->where('bike_id', '<=', '10000');

                        return $get_data;


    }


    private function build_journey_collection($data, $bikes){

        $get_collection = collect();
        
        foreach ($bikes as $bike){

            
            $get_data = $data->where('bike_id', $bike)->sortby('arrived_at');
            
            //with one record you cannot tell the journey duration
            if(count($get_data) > 1){

                $result = $this->loop_bike_journey($get_data);
                
                $get_collection = $get_collection->concat($result);
                
            }
            
        }

        return $get_collection;


    }


    private function loop_bike_journey($data){

        $journey = collect();
        $left_at = "";
        $count = 1;
        foreach($data as $datum){

            
            
                if($count > 1){
                    $journey->push((object)['bike_id'=> $datum->bike_id,
                    'back_at'=> $datum->arrived_at,
                    'left_at'=> $left_at ,
                    'duration'=> $this->date_difference($left_at, $datum->arrived_at)
                    ]);
            }
  
                $left_at = $datum->departed_at;
            

        $count++;

            
        }

        return $journey;

    }

    

    private function convert_to_hours_min_sec($totalDuration){

        $seconds = round($totalDuration);
 
        return sprintf('%02d:%02d:%02d', ($seconds/ 3600),($seconds/ 60 % 60), $seconds% 60);
    }
   
    

    private function date_difference($departed_at, $arrived_at){

        $start_time = Carbon::parse($departed_at);
        $end_time = Carbon::parse($arrived_at);
        $duration = $end_time->diffInSeconds($start_time); 
        return $duration;


    }
}