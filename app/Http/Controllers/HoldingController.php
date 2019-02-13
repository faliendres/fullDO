<?php

namespace App\Http\Controllers;

use App\Holding;
use App\Empresa;
use App\User;
use GuzzleHttp\Promise\CancellationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class HoldingController extends Controller
{
    protected $clazz = Holding::class;
    protected $resource ="holdings";
    protected $rules =[
        "nombre" => "required|unique:ma_holding",
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



    public function destroy($id, Request $request)
    {
        $id = Holding::find($id);
        $counter =  Empresa::where('id_holding',$id->id)->count();

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
