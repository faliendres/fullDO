<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax())
            return (new \Yajra\DataTables\DataTables)->eloquent(User::query()->with(["holding","empresa","gerencia"]))
                ->make(true);
        return view("users.index");
    }
}
