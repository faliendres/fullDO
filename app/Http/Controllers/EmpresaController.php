<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Empresa;
use App\Gerencia;

class EmpresaController extends Controller
{
	protected $clazz = Empresa::class;
    protected $resource ="empresas";
    protected $rules =[
        "rut" => "required|unique:ma_empresa,rut,{id},id",
        "nombre" => "required|unique:ma_empresa,nombre,{id},id",
        'logo_file' => 'file|image| max:1000',
        'descripcion' => 'max:255',
        'id_holding' => 'required|exists:ma_holding,id',
        'desde' => 'nullable|date',
        'hasta' => 'nullable|date',
    ];

    public function getGerenciasbyEmpresa($empresaId){
    	$gerencias = Gerencia::query()->where('id_empresa',$empresaId)->get();
    	$result = array();
    	if(count($gerencias)>0)
    		foreach ($gerencias as $gerencia) {
    			$result[$gerencia->id] = $gerencia->nombre;
    		}

    	return response()->json($result,200);
    }


    public function destroy($id, Request $request)
    {
        $id = Empresa::find($id);
        $counter =  Gerencia::where('id_empresa',$id->id)->count();

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
