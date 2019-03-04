<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cargo;
use App\User;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Illuminate\Support\Facades\DB;

class CargoController extends Controller
{
    protected $clazz = Cargo::class;
    protected $resource ="cargos";
    protected $rules =[
        "nombre" => "required|unique:ma_empresa",
        'descripcion' => 'max:255',
        'id_gerencia' => 'required|exists:ma_gerencia,id',
        'id_funcionario' => 'nullable|exists:users,id',
        'id_jefatura' => 'nullable|exists:ma_cargo,id',
        'desde' => 'nullable|date',
        'hasta' => 'nullable|date',
    ];

    public function getEstructura(Request $request){
        $empresa = $request->get('e');
    	$cargo = Cargo::query()
                ->whereIn('id_gerencia', function ($q) use ($empresa){
                    $q->from('ma_gerencia')->select('id')->where('id_empresa',$empresa);
                })
                ->where('id_jefatura',null)->first();
    	$result = $this->getArbol($cargo);
    	return response()->json($result, 200);
    }

    protected function getArbol($cargo){
    	if(isset($cargo->id_funcionario)){
    		$func = User::where('id',$cargo->id_funcionario)->first();
    		$name = $func->nombre . ' ' . $func->apellido;
    		$avatar = $func->foto;
    	}else{
    		$name = "Vacante";
    		$avatar = 'nobody.png';
    	}
    	$node = array(
            'id' => $cargo->id_funcionario ?: "-1",
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


    public function destroy($id, Request $request)
    {
        $id = Cargo::find($id);
        $counter =  Cargo::query()->where('id_jefatura',$id->id)->count();

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
