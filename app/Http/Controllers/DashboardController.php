<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Code;
use App\Models\User;
use App\Models\Staff;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $student_count = Student::count() ?? 0;
        $staff_count = Staff::count() ?? 0;
        $users_count = User::count() ?? 0;
        $uuid_count = Code::count() ?? 0;
        $logs = Log::all();
        return view('dashboard.index', compact('student_count', 'staff_count', 'users_count', 'uuid_count', 'logs'));
    }

    public function index()
    {
        $rfids = Code::all();
        return view('rfid.index', compact('rfids'));
    }

    public function logs()
    {
        $logs = Log::all();
        return view('logs.index', compact('logs'));
    }

    public function store(Request $request)
    {
        $rules = [
            "uuid" => "required|string",
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $code = new Code();
        $code->uuid = $request->uuid;
        $code->status = "inactive";
        $code->save();

        return redirect()->route('settings.index')->with('success', "Successfully added new uuid");
    }

    public function update(Request $request, $id)
    {
        $code = Code::find($id);
        $code->uuid = $request->uuid;
        $code->save();

        return redirect()->route('settings.index')->with('success', "Successfully updated status");
    }
}
