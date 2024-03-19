<?php

namespace App\Exceptions;

use Exception;

class DatabaseConnectionException extends Exception
{
    public function render($request)
    {
        return response()->view('errors.database-connection', [], 500);
    }
    //
}
