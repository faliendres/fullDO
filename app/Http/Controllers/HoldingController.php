<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Holding;
use App\Empresa;

class HoldingController extends Controller
{
    protected $clazz = Holding::class;
    protected $resource ="holdings";

    public function store(Request $request)
    {
        $this->validate($request, [
            "nombre" => "required|unique:ma_holding",
            'logo_file' => 'file|image| max:1000',
            'descripcion' => 'max:255',
        ]);

        $file = $request->file("foto_file");
        if ($file) {
            $foto = uniqid().".".$file->extension();
            Storage::disk('logo')->put("holdings/".$foto, $file->get());
            $request->merge(["logo" => $foto]);
        }

        $user = Holding::create($request->all());
        return redirect()->route("holdings.index");
    }

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
