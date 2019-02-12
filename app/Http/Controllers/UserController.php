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
        $result = parent::store($request);
        $cargo = Cargo::find($request->get("cargo_id"));
        if ($cargo) {
            $cargo->id_funcionario = $request->new_id;
            $cargo->update();
        }
        return $result;
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
        $this->validate($request, [
            "id" => "required|unique:users",
            "email" => "required|email|unique:users",
            "rut" => 'required|max:12|unique:users',
            'foto_file' => 'file|image| max:1000',
        ]);
        parent::update($id, $request);
    }
}
