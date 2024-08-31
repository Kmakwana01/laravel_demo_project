<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Students;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    function Get_Student(Request $req)
    {


        $students = Students::paginate(3);

        return view('student', [
            'students' => $students
        ]);
    }

    function Add_Student(Request $req)
    {

        $req->validate([
            'name' => 'required | string | max:255',
            'email' => 'required | email | max:255',
            'roll_no' => 'required | integer',
        ]);

        $student = new Students();
        $student->name = $req->name;
        $student->email = $req->email;
        $student->roll_no = $req->roll_no;
        $student->save();

        $students = Students::paginate(3);
        return to_route('Get_Student', ['students' => $students, 'message' => 'User added successfully']);
    }

    function Delete_Student($id)
    {
        $student = Students::find($id);

        if ($student) {
            $student->delete();
            $message = 'Student removed successfully';
        } else {
            $message = 'Student not found or failed to delete';
        }

        $students = Students::paginate(3);

        return to_route('Get_Student', ['students' => $students, 'message' => $student->name . ' Delete successfully']);
    }

    function Edit_Student($id)
    {
        $students = Students::find($id);

        if (!$students) {
            die('student not found');
        }

        return view('Edit_Student', [
            'student' => $students
        ]);
    }

    function Update_Student(Request $req, $id)
    {
        $req->validate([
            'name' => 'required | string | max:255',
            'email' => 'required | email | max:255',
            'roll_no' => 'required | integer',
        ]);

        $student = Students::find($id);

        if ($student) {
            $student->name = $req->input('name');
            $student->email = $req->input('email');
            $student->roll_no = $req->input('roll_no');
            $student->save();
        } else {
            $message = 'Student not found or failed to delete';
        }

        $students = Students::paginate(3);

        return to_route('Get_Student', ['students' => $students, 'message' => $student->name . ' Update successfully']);
    }

    function search(Request $req)
    {

        $req->validate([
            'search' => 'nullable|string|max:255',
        ]);

        $students = Students::where('name', 'like', "%$req->search%")
            ->orWhere('email', 'like', "%$req->search%")
            ->paginate(3);

        return view('student', [
            'students' => $students,
            'search' => $req->search
        ]);
    }

    public function deleteMultiple(Request $req)
    {
        $studentIds = $req->input('student_ids');
        $students = Students::paginate(3);
        if (!empty($studentIds)) {
            Students::whereIn('id', $studentIds)->delete();
            return to_route('Get_Student', ['students' => $students, 'message' => 'Selected Record Delete successfully']);
        }
        // return redirect()->back()->with('message', 'No students selected for deletion.');
        return to_route('Get_Student', ['students' => $students, 'message' => 'Selected Record Delete successfully']);
    }

    public function Add_Student_Api(Request $req)
    {
        try {

            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:students,email|max:255', // Ensure email is unique
                'roll_no' => 'required|integer|unique:students,roll_no' // Ensure roll_no is unique
            ];

            $validation = Validator::make($req->all(), $rules);

            if ($validation->fails()) {
                // Return validation errors with a 422 Unprocessable Entity status
                return response()->json([
                    'status' => 422,
                    'errors' => $validation->errors()
                ], 422);
            }

            $student = new Students();
            $student->name = $req->name;
            $student->email = $req->email;
            $student->roll_no = $req->roll_no;
            $student->save();

            return response()->json([
                'status' => 201,
                'message' => 'Student created successfully',
                'data' => $student
            ], 201);
        } catch (\Exception $e) {
            // Log the error for debugging
            LOG::error('Error creating student: ' . $e->getMessage());
            // Return error response with a 500 Internal Server Error status
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while creating the student',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function Get_Student_Api(Request $req)
    {
        try {

            $students = Students::all();
            $currentUser = Auth::user();

            return response()->json([
                'status' => 200,
                'message' => 'Student get successfully',
                'data' => $students,
                'currentUser' => $currentUser
            ], 200);
            
        } catch (\Exception $e) {
            // Log the error for debugging
            LOG::error('Error creating student: ' . $e->getMessage());
            // Return error response with a 500 Internal Server Error status
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while creating the student',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function Update_Student_Api(Request $req, $id)
    {
        try {

            $findStudent = Students::find($id);

            if (!$findStudent) {
                throw new \Illuminate\Database\Eloquent\ModelNotFoundException('Student not found');
            }

            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:students,email,' . $id, // Ensure email is unique except for the current student
                'roll_no' => 'required|integer|unique:students,roll_no,' . $id // Ensure roll_no is unique except for the current student
            ];

            $validation = Validator::make($req->all(), $rules);

            if ($validation->fails()) {
                return response()->json([
                    'status' => 422,
                    'errors' => $validation->errors()
                ], 422);
            }

            // Update the student record
            $findStudent->name = $req->name;
            $findStudent->email = $req->email;
            $findStudent->roll_no = $req->roll_no;
            $findStudent->save();

            return response()->json([
                'status' => 200,
                'message' => 'Student update successfully',
                'data' => $findStudent
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging
            LOG::error('Error creating student: ' . $e->getMessage());
            // Return error response with a 500 Internal Server Error status
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while creating the student',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function Delete_Student_Api(Request $req, $id)
    {
        try {

            $students = Students::find($id);

            if (!$students) {
                throw new \Illuminate\Database\Eloquent\ModelNotFoundException('Student not found');
            }

            Students::destroy($id);

            return response()->json([
                'status' => 200,
                'message' => 'Student delete successfully'
            ], 201);
        } catch (\Exception $e) {
            // Log the error for debugging
            LOG::error('Error creating student: ' . $e->getMessage());
            // Return error response with a 500 Internal Server Error status
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while creating the student',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
