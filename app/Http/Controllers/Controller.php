<?php

namespace App\Http\Controllers;

use App\Traits\FileUploader;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, FileUploader;

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


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->clazz::query();
            $f = $request->get("filter", []);
            foreach ($f as $filter)
                $query = $query->where($filter["field"], $filter["op"] ?? "=", $filter["value"]);
            if (!$request->get("draw", false))
                return response()->json(["data" => $query->get()]);
            return (new \Yajra\DataTables\DataTables)->eloquent($query)
                ->make(true);
        }
        return view("$this->resource.index");
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

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update($id, Request $request)
    {
        $rules = collect($this->rules)->map(function ($item) use ($id) {
            return str_replace("{id}", $id, $item);
        })->all();
        $this->validate($request, $rules);
        $instance = $this->clazz::find($id);
        $this->uploadFiles($request, $instance, $this->resource);
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);
        $new = $this->clazz::create($request->except(["_token"]));
        $this->uploadFiles($request, $new, $this->resource);
        if ($new && $new->id)
            $request->merge(["new_id" => $new->id]);
        return redirect()->route("$this->resource.index");
    }


    public function destroy($id, Request $request)
    {
        //TODO DELETE FILES WHEN DELETE
        $id = $this->clazz::find($id);
        if ($id) {
            $id->delete();
            return response()->json([], 204);
        }
        throw new ResourceNotFoundException("$this->clazz with id " . $request->route()->parameter("id"));
    }
}
