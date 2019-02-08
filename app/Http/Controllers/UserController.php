<?php

namespace App\Http\Controllers;

use App\Cargo;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $clazz = User::class;
    protected $resource ="users";

    public function store(Request $request)
    {
        $user = User::create($request->all());
        $cargo = Cargo::find($request->get("cargo_id"));
        $cargo->id_funcionario = $user->id;
        $cargo->update();
        return redirect()->route("users.index");
    }

}
