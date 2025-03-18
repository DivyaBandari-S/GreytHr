<?php

namespace App\Http\Controllers;

abstract class Controller
{
    //
    public const SUCCESS_MESSAGE     = 'Request processed successfully!';
    public const FAILED_MESSAGE      = 'Unable to process the request. Please try again!';
    public const EXCEPTION_MESSAGE   = 'Exception occurred. Please try again!';
    public const INVALID_CREDENTIALS = 'Unable to process the login request due to invalid credentials.';
    public const USER_NOT_FOUND      = 'User not found!';
    public const USER_LOGGED_OUT     = 'User logged out successfully!';

    public const LOGIN_REQUIRED      = 'Employee ID or email is required.';
    public const INACTIVE_USER       = 'You are inactive. Please contact HR.';
    public const INTERNAL_SERVER_ERROR = 'Server error. Please try again later.';

    # STATUS KEYWORDS
    public const SUCCESS_STATUS = 'success';
    public const ERROR_STATUS   = 'error';

    # STATUS CODES
    public const SUCCESS          = 200;
    public const ERROR            = 400;
    public const VALIDATION_ERROR = 422;
    public const UNAUTHORIZED     = 401;
    public const NOT_FOUND        = 404;
    public const FORBIDDEN        = 403;
    public const SERVER_ERROR     = 500;
    public const NO_CONTENT       = 204;
}
