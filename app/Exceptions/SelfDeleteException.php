<?php

namespace App\Exceptions;

use RuntimeException;

class SelfDeleteException extends RuntimeException
{
    protected $message="User is trying to delete it self";
}
