<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Holding;
use App\Empresa;

class HoldingController extends Controller
{
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
