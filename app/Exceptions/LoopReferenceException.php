<?php

namespace App\Exceptions;

use Exception;

class LoopReferenceException extends Exception
{
    protected $message="Loop you cannot add a child as parent";
}
