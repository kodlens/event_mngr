<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Legend;

class AndroidLegendController extends Controller
{
    //

    public function loadLegends(){
        $data = Legend::orderBy('rating', 'asc')
            ->get();
        return $data;
    }
}
