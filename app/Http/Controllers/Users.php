<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Access;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class Users extends Controller
{
    //
    function getUsers($dynamicName)
    {
        $array = [1, 2, 3];
        return view('firstPage', ['var' => $dynamicName, 'array' => $array]);
    }

    function addUser(Request $req)
    {
        $req->validate([
            'email' => 'required | min:5 | max:8',
            'password' => 'required',
            'name' => 'required',
        ], [
            'email.required' => "email is required"
        ]);

        DB::insert(
            'INSERT INTO users (name, email, password) VALUES (?, ?, ?)',
            [$req->name, $req->email,bcrypt($req->input('password'))]
        );

        $req->session()->put('userName' ,$req->input('name'));
        echo session('name');

        $users = DB::select('SELECT * FROM users');
        return view('Form', [
            'message' => 'User added successfully',
            'users' => $users
        ]);
    }

    function getUsersFromDb(Request $req)
    {
        return DB::select('select * from users');
    }

    function getDataFromAPi()
    {
        // $response = Http::withHeaders([
        //     'Authorization' => 'Bearer your-token',
        // ])->get('https://dummyjson.com/c/3029-d29f-4014-9fb4', [
        //     'param1' => 'value1',
        //     'param2' => 'value2',
        // ]);

        $response = Http::get('https://dummyjson.com/c/3029-d29f-4014-9fb4');
        return $response;
    }

    public function update(Request $request, $id)
    {
        // Validate request
        $request->validate([
            'email' => 'required | min:5 | max:8',
            'name' => 'required'
        ], [
            'email.required' => "email is required"
        ]);

        // Update user in the database
        $data = [
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            
        ];

        if($request->has('password') && $request->input('password')){
            $data['password']  = bcrypt($request->input('password'));
        }

        Db::table('users')->where('id',$id)->update($data);

        return redirect()->route('form')->with('message', 'User updated successfully');
    }

    public function edit($id)
    {

        $user = DB::select('SELECT * FROM users WHERE id = ?', [$id]);
        if (empty($user)) {
            return redirect()->route('form')->with('message', 'User not found');
        }

        return view('edit', ['user' => $user[0]]);
    }

    public function destroy($id)
    {   

        // Delete user from the database
        DB::delete('DELETE FROM users WHERE id = ?', [$id]);

        return redirect()->route('form')->with('message', 'User deleted successfully');
    }
}
