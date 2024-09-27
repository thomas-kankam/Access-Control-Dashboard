<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\User;
use App\Models\Staff;
use App\Models\Client;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function getUsers()
    {
        $users = User::where('id', '!=', auth()->user()->id)->get();
        return view('users.index', compact('users'));
    }

    public function editUser($id)
    {
        $user = User::find($id);
        return view('users.edit', compact('user'));
    }

    public function updateUser(User $user, Request $request)
    {
        // Validation rules
        $rules = [
            'name' => 'nullable|string',
            'email' => 'nullable|email|unique:users,email,' . $user->id, // Allow the same email for the current staff
            'role' => 'nullable|string',
        ];

        // Validate the input
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }


        // Update other staff details if provided
        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'role' => $request->role ?? $user->role,
        ]);

        // Redirect back to the staff list with a success message
        return redirect()->route('get.users')->with('success', "Successfully updated user details");
    }

    public function saveUser(Request $request)
    {
        // Validation rules
        $rules = [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',  // Corrected table name
            'password' => 'required',  // Use 'confirmed' to check password confirmation
            'role' => 'required|string',
        ];

        // Validate the input
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        // Create the user and hash the password if provided
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : null,  // Hash password
            'role' => $request->role,
        ]);

        // Redirect with success message
        return redirect()->route('get.users')->with('success', "Successfully created user.");
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
        $codes = Code::all();
        return view('staffs.edit', compact('staff', 'codes'));
    }

    public function updateStaff(Staff $staff, Request $request)
    {
        // Validation rules
        $rules = [
            'full_name' => 'nullable|string',
            'email' => 'nullable|email|unique:staff,email,' . $staff->id, // Allow the same email for the current staff
            'code_id' => 'nullable|string',
            'msisdn' => 'nullable|string',
        ];

        // Validate the input
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        // If a new code_id is provided and it is different from the current one
        if ($request->code_id && $request->code_id != $staff->code_id) {
            // Set the previous code_id to 'inactive' if it exists
            if ($staff->code_id) {
                DB::table('codes')->where('id', $staff->code_id)->update([
                    'status' => 'inactive',
                    'updated_at' => now(),
                ]);
            }

            // Update the new code_id to 'active'
            DB::table('codes')->where('id', $request->code_id)->update([
                'status' => 'active',
                'updated_at' => now(),
            ]);

            // Update the staff's code_id to the new one
            $staff->code_id = $request->code_id;
        }

        // Update other staff details if provided
        $staff->update([
            'full_name' => $request->full_name ?? $staff->full_name,
            'email' => $request->email ?? $staff->email,
            'msisdn' => $request->msisdn ?? $staff->msisdn,
        ]);

        // Redirect back to the staff list with a success message
        return redirect()->route('get.staffs')->with('success', "Successfully updated staff details");
    }

    public function destroyStaff(Staff $staff)
    {
        // Check if the student has a code_id and set it to inactive
        if ($staff->code_id) {
            DB::table('codes')->where('id', $staff->code_id)->update([
                'status' => 'inactive',
                'updated_at' => now(),
            ]);
        }

        $staff->delete();

        return redirect(route('get.staffs'))->with("success", "Staff deleted successfully");
    }

    public function saveStaff(Request $request)
    {
        $rules = [
            'full_name' => 'required|string',
            'email' => 'nullable|email|unique:staff,email',
            'code_id' => 'nullable|string',
            'msisdn' => 'nullable|string',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        Staff::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'code_id' => $request->code_id,
            'msisdn' => $request->msisdn,
            'user_type' => "staff"
        ]);

        DB::table('codes')->where(['id' => $request->code_id])->update([
            'status' => "active", // Example field update
            'updated_at' => now(), // Example field update
        ]);

        return redirect()->route('get.staffs')->with('success', "Successfully added staff details");
    }

    public function getStudents()
    {
        $students = Student::get();
        $codes = Code::where('status', 'inactive')->get();
        return view('students.index', compact('students', 'codes',));
    }

    public function saveStudent(Request $request)
    {
        $rules = [
            'full_name' => 'required|string',
            'email' => 'nullable|email|unique:staff,email',
            'code_id' => 'nullable|string',
            'msisdn' => 'nullable|string',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $student_count = DB::table('students')->count();
        $index_no = "GCTU04090" . $student_count + 1;

        Student::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'code_id' => $request->code_id,
            'msisdn' => $request->msisdn,
            'index_no' => $index_no,
            'user_type' => "student"
        ]);

        DB::table('codes')->where(['id' => $request->code_id])->update([
            'status' => "active", // Example field update
            'updated_at' => now(), // Example field update
        ]);


        return redirect()->route('get.students')->with('success', "Successfully updated student details");
    }

    public function editStudent($id)
    {
        $student = Student::find($id);
        $codes = Code::all();
        return view('students.edit', compact('student', 'codes'));
    }

    public function updateStudent(Student $student, Request $request)
    {
        // Validation rules
        $rules = [
            'full_name' => 'nullable|string',
            'email' => 'nullable|email|unique:students,email,' . $student->id, // Allow the same email for the current staff
            'uuid' => 'nullable|string',
            'msisdn' => 'nullable|string',
        ];

        // Validate the input
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        // If a new code_id is provided and it is different from the current one
        if ($request->code_id && $request->code_id != $student->code_id) {
            // Set the previous code_id to 'inactive' if it exists
            if ($student->code_id) {
                DB::table('codes')->where('id', $student->code_id)->update([
                    'status' => 'inactive',
                    'updated_at' => now(),
                ]);
            }

            // Update the new code_id to 'active'
            DB::table('codes')->where('id', $request->code_id)->update([
                'status' => 'active',
                'updated_at' => now(),
            ]);

            // Update the student's code_id to the new one
            $student->code_id = $request->code_id;
        }

        // Update staff details if provided
        $student->update([
            'full_name' => $request->full_name ?? $student->full_name,
            'email' => $request->email ?? $student->email,
            'msisdn' => $request->msisdn ?? $student->msisdn
        ]);

        // Redirect back to the staff list with a success message
        return redirect()->route('get.students')->with('success', "Successfully updated student details");
    }

    public function destroyStudent(Student $student)
    {
        // Check if the student has a code_id and set it to inactive
        if ($student->code_id) {
            DB::table('codes')->where('id', $student->code_id)->update([
                'status' => 'inactive',
                'updated_at' => now(),
            ]);
        }

        // Delete the student
        $student->delete();

        // Redirect back to the students list with a success message
        return redirect(route('get.students'))->with("success", "Student deleted successfully");
    }
}
