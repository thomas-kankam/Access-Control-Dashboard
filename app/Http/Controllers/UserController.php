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

    public function editStaff($id)
    {
        $staff = Staff::find($id);
        $codes = Code::where('status', 'inactive')->get();
        return view('staffs.edit', compact('staff', 'codes'));
    }

    public function updateStaff(Staff $staff, Request $request)
    {
        // Validation rules
        $rules = [
            'full_name' => 'nullable|string',
            'email' => 'nullable|email|unique:staff,email,' . $staff->id, // Allow the same email for the current staff
            'uuid' => 'nullable|string',
            'msisdn' => 'nullable|string',
        ];

        // Validate the input
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        // Update staff details if provided
        $staff->update([
            'full_name' => $request->full_name ?? $staff->full_name,
            'email' => $request->email ?? $staff->email,
            'uuid' => $request->uuid ?? $staff->uuid,
            'msisdn' => $request->msisdn ?? $staff->msisdn
        ]);

        // If UUID is provided, update the related code's status
        if ($request->uuid) {
            DB::table('codes')->where(['uuid' => $request->uuid])->update([
                'status' => "active", // Example field update
                'updated_at' => now(), // Example field update
            ]);
        }

        // Redirect back to the staff list with a success message
        return redirect()->route('get.staffs')->with('success', "Successfully updated staff details");
    }


    public function destroyStaff(Staff $staff)
    {
        // $user->smsLogs()->delete();
        $staff->delete();

        return redirect(route('get.staffs'))->with("success", "Staff deleted successfully");
    }

    public function saveStaff(Request $request)
    {
        $rules = [
            'full_name' => 'nullable|string',
            'email' => 'nullable|email|unique:staff,email',
            'uuid' => 'nullable|string',
            'msisdn' => 'nullable|string',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        Staff::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'uuid' => $request->uuid,
            'msisdn' => $request->msisdn
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
