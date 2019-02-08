<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $clazz;
    protected $resource;

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
        $readonly=true;
        if ($instance) {
            if($request->ajax())
                return response()->json($instance, 200);
            return view("$this->resource.show",compact("instance","readonly"));
        }
        throw new ResourceNotFoundException("$this->clazz with id " . $request->route()->parameter("id"));
    }

    public function edit($user, Request $request)
    {
        $user = $this->clazz::find($user);
        if ($user) {
            return response()->json($user, 200);
        }
        throw new ResourceNotFoundException("$this->clazz with id " . $request->route()->parameter("id"));
    }

    public function store(Request $request)
    {
        $this->clazz::create($request->all());
        return redirect()->route("$this->resource.index");
    }

    public function destroy($user, Request $request)
    {
        $user = $this->clazz::find($user);
        if ($user && $user->id !== auth()->user()->id) {
            $user->delete();
            return response()->json([], 204);
        }
        throw new ResourceNotFoundException("$this->clazz with id " . $request->route()->parameter("id"));
    }
}
