<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class studentController extends Controller
{
    public function displayStudent(){
        $patients = DB::select('select * from patients'); // fetch all student records
        return view('students.index', [
            'patients' => $patients
        ]); 
    }
    public function patientsList(){
        $patients = DB::select('select * from patients'); // fetch all student records

        return DataTables::of($patients)->make(true);
        /*return view('students.index', [
            'patients' => $patients
        ]); */
    }
    public function addStudent(){
        return view('Students.addStudent');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_initial' => 'nullable|string|max:5',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string',
        ]);

        Patient::create($validated);

        return redirect()->back()->with('success', 'Patient added successfully!');
    }

}
