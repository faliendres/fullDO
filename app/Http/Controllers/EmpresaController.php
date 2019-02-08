<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Empresa;
use App\Gerencia;

class EmpresaController extends Controller
{
	protected $clazz = Empresa::class;
    protected $resource ="empresas";

    public function getGerenciasbyEmpresa($empresaId){
    	$gerencias = Gerencia::where('id_empresa',$empresaId)->get();
    	$result = array();
    	if(count($gerencias)>0)
    		foreach ($gerencias as $gerencia) {
    			$result[$gerencia->id] = $gerencia->nombre; 
    		}

    	return response()->json($result,200);
    }
}
