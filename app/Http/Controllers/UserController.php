<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\User;
use App\Models\Staff;
use App\Models\Client;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::get();
        return view('users.index', compact('users'));
    }

    public function getStaffs()
    {
        $staffs = Staff::all();
        $codes = Code::where('status', 'inactive')->get();
        return view('staffs.index', compact('staffs', 'codes'));
    }

    public function saveStaff(Request $request)
    {
        $rules = [
            'full_name' => 'required|string',
            'email' => 'required|email|unique:staff,email',
            'uuid' => 'required|string',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        Staff::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'uuid' => $request->uuid,
        ]);

        DB::table('codes')->where(['uuid' => $request->uuid])->update([
            'status' => "active", // Example field update
            'updated_at' => now(), // Example field update
        ]);

        return redirect()->route('get.staffs')->with('success', "Successfully added staff details");
    }

    public function getStudents()
    {
        $students = Student::get();
        $unassigned = Student::where('uuid', 'N/A')->get();
        $codes = Code::where('status', 'inactive')->get();
        return view('students.index', compact('students', 'codes', 'unassigned'));
    }

    public function saveStudent(Request $request)
    {
        $rules = [
            'uuid' => 'required|string',
            'full_name' => 'required|string',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $full_name = $request->full_name;

        DB::table('students')->where(['full_name' => $full_name])->update([
            'full_name' => $request->full_name, // Example field update
            'uuid' => $request->uuid, // Example field update
            'updated_at' => now(), // Example field update
        ]);

        DB::table('codes')->where(['uuid' => $request->uuid])->update([
            'status' => "active", // Example field update
            'updated_at' => now(), // Example field update
        ]);

        return redirect()->route('get.students')->with('success', "Successfully updated student details");
    }
}
