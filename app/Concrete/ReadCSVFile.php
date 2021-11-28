<?php

namespace App\Concrete;


use App\Interfaces\ReadFileInterface;



class ReadCSVFile implements ReadFileInterface
{



    public function open_read_file($path){

        if (!$this->validate_csv_file($path)) {

            return "File must be CSV";

        }     
        return $this->read_file($path);

    }

    public function read_file($path)
    {
        
        $handle = fopen($path, "r");
            if($handle){
            $data = $this->get_csv_data($handle);
            fclose($handle);
            return $data;
            }
        return "File not found";
    }

    private function get_csv_data ($handle) {


        while (($raw_string = fgets($handle)) !== false) {
            
            $row []= str_getcsv($raw_string);
            
        }
        
        return $row;

    }


    private function validate_csv_file ($path){

            $filename = basename($path);
            $ext_file = explode('.', $filename);
            $file_ext = strtolower(end($ext_file));
            $extensions = array(
                "csv"
            );
            return in_array($file_ext, $extensions);
        
            
    }
   
}