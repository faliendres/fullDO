<?php

namespace App\Http\Controllers;

use App\Cargo;
use App\Exceptions\SelfDeleteException;
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
    protected $rules = [
        "email" => "required|email|unique:users,email,{id},id",
        "rut" => 'required|max:12|unique:users,rut,{id},id',
        'holding_id' => 'required|exists:ma_holding,id',
        'empresa_id' => 'required|exists:ma_empresa,id',
        'gerencia_id' => 'required|exists:ma_gerencia,id',
        'cargo_id' => 'nullable|exists:ma_cargo,id',
        'foto_file' => 'file|image| max:1000',
    ];

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
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

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'password' => 'nullable|confirmed',
        ]);
        if ($request->get("password"))
            $request->merge(["password" => Hash::make($request->get("password"))]);
        $result = parent::update($id, $request);

        $cargo_anterior = User::find($id)->cargo;
        //REMOVE from last cargo
        if ($cargo_anterior && $cargo_anterior->id != $request->get("cargo_id")) {
            if ($cargo_anterior) {
                $cargo_anterior->id_funcionario = null;
                $cargo_anterior->update();
            }
        }
        //Add to new Cargo
        $cargo = Cargo::find($request->get("cargo_id"));
        if ($cargo && $cargo->id_funcionario != $id) {
            $cargo->id_funcionario = $id;
            $cargo->update();
        }
        return $result;
    }

    public function changepassword(Request $request)
    {
        $data = $request->only(['password', 'repassword']);
        $user = Auth::user();
        $user->password = Hash::make($data['password']);
        $user->password_changed_at = date('Y-m-d H:i:s');
        return response()->json(['success' => $user->save()], 200);

    }

    public function destroy($id, Request $request)
    {
        if ($id == auth()->user()->id) {
            throw new SelfDeleteException();
        }
        return parent::destroy($id, $request);
    }

}
