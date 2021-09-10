<?php

namespace App\Exceptions;

use Exception;

class UserNotRegisteredException extends Exception
{
    protected $code = 500;
    protected $message = "User could not be registered.";
}
