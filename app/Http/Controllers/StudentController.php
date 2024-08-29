<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Students;
use Illuminate\Http\Request;

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

        return to_route('Get_Student', ['students' => $students, 'message' => $student->name.' Delete successfully']);
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

        return to_route('Get_Student', ['students' => $students, 'message' => $student->name.' Update successfully']);
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
            if (!empty($studentIds)) {
            Students::whereIn('id', $studentIds)->delete();
            return redirect()->back()->with('message', 'Selected students have been deleted.');
        }
        $students = Students::paginate(3);
        // return redirect()->back()->with('message', 'No students selected for deletion.');
        return to_route('Get_Student', ['students' => $students, 'message' => 'Selected Record Delete successfully']);

    }
}
