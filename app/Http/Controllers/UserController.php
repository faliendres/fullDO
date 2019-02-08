<?php

namespace App\Http\Controllers;

use App\Cargo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    protected $clazz = User::class;
    protected $resource = "users";

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function store(Request $request)
    {
            $this->validate($request, [
                "email" => "required|email|unique:users",
                "rut" => 'required|max:12|unique:users',
                'foto_file' => 'file|image| max:1000',
                'password' => 'confirmed',
            ]);

        $request->merge(["password" => Hash::make($request->get("password", "123456"))]);
        $file = $request->file("foto_file");
        if ($file) {
            $foto = uniqid().".".$file->extension();
            Storage::disk('avatar')->put($foto, $file->get());
            $request->merge(["foto" => $foto]);
        }

        $user = User::create($request->all());
        $cargo = Cargo::find($request->get("cargo_id"));
        if($cargo){
            $cargo->id_funcionario = $user->id;
            $cargo->update();
        }
        return redirect()->route("users.index");
    }

}
