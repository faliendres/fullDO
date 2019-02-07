<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax())
            return (new \Yajra\DataTables\DataTables)->eloquent(User::query())
                ->make(true);
        return view("users.index");
    }
    public function create(Request $request)
    {
        return view("users.create");
    }
    public function show(User $user,Request $request)
    {
        $user->load("cargo");
        if($user){
            return response()->json($user,200);
        }
        throw new ResourceNotFoundException("User with id ".$request->route()->parameter("user"));
    }
    public function edit(User $user,Request $request)
    {
        if($user){
            return response()->json($user,200);
        }
        throw new ResourceNotFoundException("User with id ".$request->route()->parameter("user"));
    }
    public function store(Request $request)
    {
        User::create($request->all());
        return view("users.index");
    }
    public function destroy(User $user,Request $request)
    {
        if($user){
            $user->delete();
            return response()->json([],204);
        }
        throw new ResourceNotFoundException("User with id ".$request->route()->parameter("user"));
    }
}
