<?php

namespace App\Http\Controllers;

use App\Holding;
use App\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HoldingController extends Controller
{
    protected $clazz = Holding::class;
    protected $resource ="holdings";
    protected $rules =[
        "nombre" => "required|unique:ma_holding,nombre,{id},id",
        'logo_file' => 'file|image| max:1000',
        'descripcion' => 'max:255',
    ];


    public function getHoldings(){
    	$allHoldings = Holding::get();
    	$result = array();
    	if(count($allHoldings)>0)
    		foreach ($allHoldings as $holding) {
    			$result[$holding->id] = $holding->nombre; 
    		}

    	return response()->json($result,200);
    }

    public function getEmpresasByHolding($holdingId){
    	$empresas = Empresa::where('id_holding',$holdingId)->get();
    	$result = array();
    	if(count($empresas)>0)
    		foreach ($empresas as $empresa) {
    			$result[$empresa->id] = $empresa->nombre; 
    		}

    	return response()->json($result,200);
    }
}
