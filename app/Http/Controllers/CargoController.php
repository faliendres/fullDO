<?php

namespace App\Http\Controllers;

use App\Cargo;
use App\Empresa;
use App\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class CargoController extends Controller
{
    protected $clazz = Cargo::class;
    protected $resource = "cargos";
    protected $rules = [
        "nombre" => "required|unique:ma_empresa",
        'descripcion' => 'max:255',
        'id_gerencia' => 'required|exists:ma_gerencia,id',
        'id_funcionario' => 'nullable|exists:users,id',
        'id_jefatura' => 'nullable|exists:ma_cargo,id',
        'desde' => 'nullable|date',
        'hasta' => 'nullable|date',
    ];

    public function index(Request $request, $query=null)
    {
        if ($request->has("holding_id")) {
            $this->validate($request, [
                "holding_id" => "nullable|exists:ma_holding,id"
            ]);
            $query=null;
            if ($request->ajax()&&$request->get("holding_id")) {
                $query = Cargo::query()
                    ->join("ma_gerencia","ma_cargo.id_gerencia","=","ma_gerencia.id")
                    ->join("ma_empresa","ma_gerencia.id_empresa","=","ma_empresa.id")
                    ->where("ma_empresa.id_holding","=", \DB::raw($request->get("holding_id")))
                ;
            }
            return parent::index($request,$query);
        }

        return view("holdings.select");

    }

    public function getEstructura(Request $request)
    {
        $empresa = $request->get('e');
        if (!isset($empresa)) {
            $empresa = Empresa::first()->id;
        }
        $data = $request->only('id');
        if (count($data) && $data['id'] != 'null')
            $cargo = Cargo::where('id', $data['id'])->first();
        else {
            $cargo = Cargo::whereIn('id_gerencia', function ($q) use ($empresa) {
                $q->from('ma_gerencia')->select('id')->where('id_empresa', $empresa);
            })->where('id_jefatura', null)->first();
        }
        $result = $this->getArbol($cargo);
        return response()->json($result, 200);
    }

    protected function getArbol($cargo)
    {
        if (isset($cargo->id_funcionario)) {
            $func = User::where('id', $cargo->id_funcionario)->first();
            $name = $func->name . ' ' . $func->apellido;
            $avatar = $func->foto;
        } else {
            $name = "Vacante";
            $avatar = 'nobody.png';
        }
        //$collapsed = false;
        //if($cargo->nombre == 'Gerente TI')
        //$collapsed = true;
        $node = array(
            'id' => $cargo->id_funcionario ?: "-1",
            'avatar' => $avatar,
            'name' => $name,
            'title' => $cargo->nombre,
            'office' => $cargo->area,
            'color' => $cargo->gerencia->color,
            'dotacion' => count($cargo->subCargos) > 0 ? ' (' . count($cargo->subCargos) . ')' : '',
            //'collapsed' => $collapsed,
        );
        $childrens = Cargo::where('id_jefatura', $cargo->id)->get();
        if (count($childrens) > 0)
            foreach ($childrens as $child) {
                $node['children'][] = $this->getArbol($child);
            }

        return $node;
    }


    public function destroy($id, Request $request)
    {
        $id = Cargo::find($id);
        $counter = Cargo::query()->where('id_jefatura', $id->id)->count();

        if ($counter == 0) {
            if ($id) {
                $id->delete();
                return response()->json([], 204);
            } else {
                throw new ResourceNotFoundException("$this->clazz with id " . $request->route()->parameter("id"));
            }
        }
        throw new \RuntimeException("El id especificado tiene " . $counter . " registros asociados ");
    }
}
