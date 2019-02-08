<?php

namespace App\Http\Controllers;

use App\Gerencia;
use Illuminate\Http\Request;

class GerenciaController extends Controller
{
    protected $clazz = Gerencia::class;
    protected $resource ="gerencias";
}
