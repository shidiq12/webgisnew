<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
   
    public function __construct()
    {
        //$this->middleware('auth:api');
    }
    public function index()
    {
        return User::latest()->paginate(8); 
    }

    public function store(Request $request)
    {
        $this -> validate($request,[
            'name' => 'required|string|max:20',
            'email' => 'required|email|max:30|unique:users',
            'password' => 'required|string|min:6',

        ]);
        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'type' => $request['type'],
            'password' => Hash::make($request['password']),
        ]); 
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $this -> validate($request,[
            'name' => 'required|string|max:20',
            'email' => 'required|email|max:30',
            'password' => 'sometimes|min:6',

        ]);

        $user->update($request->all());
        return ['message' => 'updated user'];
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return ['message' => 'User deleted successfully'];
    }


    public function search(){

        if ($search = \Request::get('q')) {
            $users = User::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")->orWhere('email','LIKE',"%$search%");
            })->paginate(20);
        }else{
            $users = User::latest()->paginate(8);
        }

        return $users;

    }
}
