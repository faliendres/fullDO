<?php

namespace App\Http\Controllers;

use App\Cargo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $clazz = User::class;
    protected $resource ="users";

    public function store(Request $request)
    {
        $request->merge(["password"=>Hash::make($request->get("password","123456"))]);
        $user = User::create($request->all());
        $cargo = Cargo::find($request->get("cargo_id"));
        $cargo->id_funcionario = $user->id;
        $cargo->update();
        return redirect()->route("users.index");
    }

}
