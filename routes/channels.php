<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
// app/Providers/BroadcastServiceProvider.php

// Broadcast::channel('private.chat.{emp_id}', function ($emp, $emp_id) {
//     return (string) $emp->emp_id === $emp_id;
// });
Broadcast::channel('chat.{empId}', function ($user, $empId) {
    return (string) $user->emp_id === $empId;
});
