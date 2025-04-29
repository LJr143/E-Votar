<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('user-logged-in', function ($user) {
    return true;
});

Broadcast::channel('table-updates', function ($user) {
    return true;
});
Broadcast::channel('election-status', function ($user) {
    return true;
});
Broadcast::channel('vote-tally', function ($user) {
    return true;
});
