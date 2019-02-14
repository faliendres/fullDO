<?php

namespace App\Http\Controllers;

use App\Gerencia;
use App\Cargo;
use Illuminate\Http\Request;

class GerenciaController extends Controller
{
    protected $clazz = Gerencia::class;
    protected $resource ="gerencias";
    protected $rules =[
        "nombre" => "required|unique:ma_empresa,nombre,{id},id",
        'descripcion' => 'max:255',
        //'id_empresa' => 'required|exists:ma_empresa,id',
        'desde' => 'nullable|date',
        'hasta' => 'nullable|date',
    ];

    public function destroy($id, Request $request)
    {
        $id = Gerencia::find($id);
        $counter =  Cargo::where('id_gerencia',$id->id)->count();

        if ($counter == 0 ) {
            if ($id) {
                $id->delete();
                return response()->json([], 204);
            } else {
                throw new ResourceNotFoundException("$this->clazz with id " . $request->route()->parameter("id"));
            }
        }
        throw new \RuntimeException("El id especificado tiene ".$counter." registros asociados ");
    }

}
