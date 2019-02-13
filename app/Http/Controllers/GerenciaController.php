<?php

namespace App\Http\Controllers;

use App\Gerencia;
use Illuminate\Http\Request;

class GerenciaController extends Controller
{
    protected $clazz = Gerencia::class;
    protected $resource ="gerencias";
    protected $rules =[
        "nombre" => "required|unique:ma_empresa",
        'descripcion' => 'max:255',
        'id_empresa' => 'required|exists:ma_empresa,id',
        'desde' => 'nullable|date',
        'hasta' => 'nullable|date',
    ];

}
