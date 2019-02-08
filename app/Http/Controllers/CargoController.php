<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cargo;
use App\User;

class CargoController extends Controller
{
    protected $clazz = Cargo::class;
    protected $resource ="cargos";

    public function getEstructura(){
    	$cargo = Cargo::where('id_jefatura',null)->first();
    	$result = $this->getArbol($cargo);
    	return response()->json($result, 200);
    }

    public function getArbol($cargo,$father = null){
    	if(isset($cargo->id_funcionario)){
    		$func = User::where('id',$cargo->id_funcionario)->first();
    		$name = $func->nombre . ' ' . $func->apellido;
    		$avatar = $func->foto;
    	}else{
    		$name = "Vacante";
    		$avatar = 'nobody.png';
    	}
    	$node = array(
    		'avatar' => $avatar,
			'name' => $name,
			'title' => $cargo->nombre,
			'office' => $cargo->area,
    	);
    	$childrens = Cargo::where('id_jefatura',$cargo->id)->get();
    	if(count($childrens)>0)
    		foreach ($childrens as $child) {
    			$node['children'][] = $this->getArbol($child);
    		}

    	return $node;
    }
}
