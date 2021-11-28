<?php

namespace App\Http\Controllers;

use App\Services\BikeReportService;
use Illuminate\Http\Request;

class BikeReportController extends Controller
{
    private $report;
    public function __construct(BikeReportService $bikeReportService)
    {
        $this->report = $bikeReportService;
    }
    public function meanReport(){


        $get_data = $this->report->get_mean_file();
        return $get_data;


    }
}
