<?php

namespace App\Http\Controllers;

use App\Cargo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

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
            $foto = uniqid() . "." . $file->extension();
            Storage::disk('users')->put($foto, $file->get());
            $request->merge(["foto" => $foto]);
        }

        $user = User::create($request->all());
        $cargo = Cargo::find($request->get("cargo_id"));
        if ($cargo) {
            $cargo->id_funcionario = $user->id;
            $cargo->update();
        }
        return redirect()->route("users.index");
    }

    public function changepassword(Request $request)
    {
        $data = $request->only(['password', 'repassword']);
        $user = Auth::user();
        $user = User::find($user->getAuthIdentifier());

        $user->password = Hash::make($data['password']);
        $user->password_changed_at = date('Y-m-d H:i:s');

        return response()->json(['success' => $user->save()], 200);

    }

    public function destroy($id, Request $request)
    {
        $id = $this->clazz::find($id);
        if ($id && $id->id !== auth()->user()->id) {
            $id->delete();
            return response()->json([], 204);
        }
        throw new ResourceNotFoundException("$this->clazz with id " . $request->route()->parameter("id"));
    }

    public function update($id, Request $request)
    {
        $instance = $this->clazz::find($id);
        $this->validate($request, [
            "email" => "required|email|unique:users",
            "rut" => 'required|max:12|unique:users',
            'foto_file' => 'file|image| max:1000',
        ]);

        if ($instance) {
            $data=$request->except(["_token","_method"]);
            $file = $request->file("foto_file");
            if ($file) {
                $foto = uniqid() . "." . $file->extension();
                Storage::disk('users')->put($foto, $file->get());
                $request->merge(["foto" => $foto]);
            }

            foreach ($data as $field=>$value)
                if($instance->$field!=$value)
                    $instance->$field=$value;
            $instance->update();
            if($request->ajax())
                return response()->json($instance, 200);
            return redirect()->route("$this->resource.show",["id"=>$instance->id]);
        }
        throw new ResourceNotFoundException("$this->clazz with id " . $request->route()->parameter("id"));
    }
}
