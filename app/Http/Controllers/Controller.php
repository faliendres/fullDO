<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Log;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $clazz;
    protected $resource;
    protected $rules = [];

    /**
     * Execute an action on the controller.
     *
     * @param  string $method
     * @param  array $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function callAction($method, $parameters)
    {
        $response = call_user_func_array([$this, $method], $parameters);
        if ($response instanceof View)
            return $response->with(["resource" => $this->resource]);
        return $response;
    }


    public function index(Request $request, $query=null)
    {
        $noEdit = false;
        if($request->getPathInfo()=='/solicitudes')
            $noEdit = true;
        
        if ($request->ajax()) {
            if(!$query)
                $query = $this->clazz::query();
            $f = $request->get("filter");
            if (isset($f["resource"]) && $f["resource"]=='usuarios')
                $query = $query->where(function($q)  use ($f){
                  $q->where('name', "LIKE", '%'.$f["value"].'%')
                    ->orWhere('apellido', "LIKE", '%'.$f["value"].'%');
              });
            if($request->getPathInfo()=='/solicitudes/buzon')
                $query = $query->where('destinatario_id', auth()->user()->id);
            if ($f)
                foreach ($f as $filter) {
                    if (is_array($filter) && array_key_exists("field", $filter) && array_key_exists("op", $filter) && array_key_exists("value", $filter))
                        $query = $query->where($filter["field"], $filter["op"] ?? "=", $filter["value"]);
                }
            if (!$request->get("draw", false))
                return response()->json(["data" => $query->get()]);
            return (new \Yajra\DataTables\DataTables)->eloquent($query)
                ->make(true);
        }
        return view("$this->resource.index",compact('noEdit'));
    }

    public function create(Request $request)
    {
        return view("$this->resource.create");
    }

    public function show($id, Request $request)
    {
        $instance = $this->clazz::find($id);
        $readonly = true;
        if ($instance) {
            if ($request->ajax())
                return response()->json($instance, 200);
            return view("$this->resource.show", compact("instance", "readonly"));
        }
        throw new ResourceNotFoundException("$this->clazz with id " . $request->route()->parameter("id"));
    }

    public function edit($id, Request $request)
    {
        $instance = $this->clazz::find($id);
        if ($instance) {
            if ($request->ajax())
                return response()->json($instance, 200);
            return view("$this->resource.edit", compact("instance"));
        }
        throw new ResourceNotFoundException("$this->clazz with id " . $request->route()->parameter("id"));
    }

    public function update($id, Request $request)
    {
        $rules = collect($this->rules)->map(function ($item) use ($id) {
            return str_replace("{id}", $id, $item);
        })->all();
        $this->validate($request, $rules);
        $this->uploadFile($request);
        $instance = $this->clazz::find($id);
        if ($instance) {
            if ($instance instanceof Model)
                $data = collect($request->only($instance->getFillable()))->filter(function ($item) {
                    return isset($item);
                })->all();
            foreach ($data as $field => $value)
                if ($instance->$field != $value)
                    $instance->$field = $value;
            $instance->update();
            if ($request->ajax())
                return response()->json($instance, 200);
            return redirect()->route("$this->resource.show", ["id" => $instance->id]);
        }
        throw new ResourceNotFoundException("$this->clazz with id " . $request->route()->parameter("id"));
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->rules);
        $this->uploadFile($request);
        $new = $this->clazz::create($request->except(["_token"]));
        if ($new && $new->id)
            $request->merge(["new_id" => $new->id]);
        return redirect()->route("$this->resource.index");
    }

    protected function uploadFile(Request &$request)
    {
        $files = $request->files;

        foreach ($files as $name => $nameF) {
            $file = $request->file($name);
            $field = str_replace("_file", "", $name);
            $value = $request->get($field, "");
            $rename = $request->get("${field}_rename", false);
            if (!is_array($file))
                $file = [$file];
            foreach ($file as $uploadedFile) {
                if($rename)
                    $foto = uniqid() . "." . $uploadedFile->extension();
                else
                    $foto=$uploadedFile->getClientOriginalName();
                Storage::disk($this->resource)->put($foto, $uploadedFile->get());
                if (!empty($value))
                    $value .= "/";
                $value .= $foto;
                $request->merge([$field => $value]);
            }
        }
    }


    public function destroy($id, Request $request)
    {
        $id = $this->clazz::find($id);
        if ($id) {
            $id->delete();
            return response()->json([], 204);
        }
        throw new ResourceNotFoundException("$this->clazz with id " . $request->route()->parameter("id"));
    }
}
