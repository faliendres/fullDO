<?php

namespace App\Http\Controllers;

use App\Cargo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $clazz = User::class;
    protected $resource = "users";

    public function store(Request $request)
    {
        $request->merge(["password" => Hash::make($request->get("password", "123456"))]);
        $file = $request->file("foto_file");
        if ($file) {
            $foto = uniqid().".".$file->extension();
            Storage::disk('avatar')->put($foto, $file->get());
            $request->merge(["foto" => $foto]);
        }

        $user = User::create($request->all());
        $cargo = Cargo::find($request->get("cargo_id"));
        $cargo->id_funcionario = $user->id;
        $cargo->update();
        return redirect()->route("users.index");
    }

    public function changepassword(Request $request)
    {
        $data = $request->only(['password','repassword'] );
        $user = Auth::user();
        $user = User::find($user->getAuthIdentifier());

        $user->password = Hash::make($data['password']);
        $user->password_changed_at = date('Y-m-d H:i:s');

        return response()->json(['success' =>  $user->save()], 200);

    }

}
