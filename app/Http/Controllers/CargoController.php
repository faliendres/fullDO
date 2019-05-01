<?php

namespace App\Http\Controllers;

use App\Cargo;
use App\Holding;
use App\Imports\CargosImport;
use App\Jobs\NotifyUserOfCompletedImport;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    protected $importer = CargosImport::class;

    public function index(Request $request, $query = null)
    {
        if ($request->has("holding_id")) {
            $this->validate($request, [
                "holding_id" => "nullable|exists:ma_holding,id"
            ]);
            $query = null;
            if ($request->ajax() && $request->get("holding_id")) {
                $query = Cargo::query()
                    ->join("ma_gerencia", "ma_cargo.id_gerencia", "=", "ma_gerencia.id")
                    ->join("ma_empresa", "ma_gerencia.id_empresa", "=", "ma_empresa.id")
                    ->where("ma_empresa.id_holding", "=", DB::raw($request->get("holding_id")));
            }
            return parent::index($request, $query);
        }
        if ($request->ajax())
            return parent::index($request, $query);
        return view("holdings.select");

    }

    public function getEstructura(Request $request)
    {


        if ($request->has("id")) {
            $data = $request->only('id');
            if (count($data) && $data['id'] != 'null')
                $cargo = Cargo::where('id', $data['id'])->first();

            $result = $this->getArbol($cargo);
            return response()->json($result, 200);
        }


        $user = auth()->user();
        $holding_id = $request->get("holding_id");
        if (!$holding_id)
            $holding_id = $user->holding_id;

        $query = Cargo::join("ma_gerencia", "id_gerencia", "=", "ma_gerencia.id")
            ->join("ma_empresa", "id_empresa", "=", "ma_empresa.id")
            ->where('id_jefatura', null)
            ->select(["ma_cargo.*", "id_empresa"]);

        if ($holding_id) {
            $query = $query->where("ma_empresa.id_holding", $holding_id);
        }
        $holding = Holding::find($holding_id);
        if (!$holding)
            return response()->json();
        $query = $query->get()->groupBy("id_empresa");
        $result = array(
            'id' => $holding->id,
            'avatar' => $holding->logo,
            'name' => $holding->nombre,
            'title' => "",
            'color' => $holding->color,
            'office' => "",
            'dotacion' => "",
            'tipo' => "holdings",
            'children' => []
        );
        foreach ($query as $empresa_id => $cargos) {
            foreach ($cargos as $cargo)
                $result['children'][] = $this->getArbol($cargo);
        }
        return response()->json($result);
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
        $node = array(
            'id' => $cargo->id_funcionario ?: "-1",
            'avatar' => $avatar,
            'tipo' => "avatar",
            'name' => $name,
            'title' => $cargo->nombre,
            'office' => $cargo->area ?? "",
            'color' => $cargo->gerencia->color,
            'dotacion' => count($cargo->subCargos) > 0 ? ' (' . count($cargo->subCargos) . ')' : ''
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

    public function import(Request $request)
    {
        if (strtoupper($request->getMethod()) == "GET") {
            return view("$this->resource.import")->with(["resource" => $this->resource]);
        } else {
            $file = $request->file("file_file");
            $filename = uniqid() . ".xlsx";
            $file->move("/tmp/", $filename);
            $import = new $this->importer;
            $antes = $this->clazz::count();
            $import->queue("/tmp/$filename")->chain([
                new NotifyUserOfCompletedImport(auth()->user(), $antes, $this->clazz, $this->resource),
            ]);

            return redirect()->route("$this->resource.index")
                ->with(["message" => "La carga masiva se esta ejecutando en segundo plano"]);
        }
    }

}
