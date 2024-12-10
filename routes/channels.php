<?php

use App\Models\EmployeeDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;
/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Broadcast::channel('chat.{receiver}', function (EmployeeDetails $user, $receiver) {

//     #check if user is same as receiver

//     return (int) $user->emp_id === (int) $receiver;
// });
//or
// Broadcast::channel('chat.{empId}', function ($user, $empId) {
//     return (int) $user->emp_id === (int) $empId;
// });

// Broadcast::channel('chat.{receiver}', function (EmployeeDetails $user, $receiver) {
//     // Ensure both user ID and receiver ID are compared as strings
//     return $user->emp_id === $receiver;
// });

Broadcast::channel('chat.{empId}', function ($user, $empId) {
    return $user->emp_id === $empId;
});
