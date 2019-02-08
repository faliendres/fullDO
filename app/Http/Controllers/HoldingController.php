<?php

namespace App\Http\Controllers;

use App\Holding;
use Illuminate\Http\Request;

class HoldingController extends Controller
{
    protected $clazz = Holding::class;
    protected $resource ="holdings";
}
