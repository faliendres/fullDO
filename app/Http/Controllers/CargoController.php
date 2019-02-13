<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cargo;
use App\User;

class CargoController extends Controller
{
    protected $clazz = Cargo::class;
    protected $resource ="cargos";
    protected $rules =[
        "nombre" => "required|unique:ma_empresa",
        'descripcion' => 'max:255',
        'id_gerencia' => 'required|exists:ma_empresa,id',
        'id_funcionario' => 'nullable|exists:users,id',
        'id_jefatura' => 'nulllable|exists:ma_cargo,id',
        'desde' => 'nullable|date',
        'hasta' => 'nullable|date',
    ];

    public function getEstructura(){
    	$cargo = Cargo::query()->where('id_jefatura',null)->get()->first();
    	$result = $this->getArbol($cargo);
    	return response()->json($result, 200);
    }

    protected function getArbol($cargo){
    	if(isset($cargo->id_funcionario)){
    		$func = User::query()->where('id',$cargo->id_funcionario)->first();
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
    	$childrens = Cargo::query()->where('id_jefatura',$cargo->id)->get();
    	if(count($childrens)>0)
    		foreach ($childrens as $child) {
    			$node['children'][] = $this->getArbol($child);
    		}

    	return $node;
    }
}
