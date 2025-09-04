<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class doctorsController extends Controller
{
    public function displayDoctor(){
        $doctors = DB::select("select * from doctors");
        return view('Doctors.index',['doctors' => $doctors]);
    }
}
