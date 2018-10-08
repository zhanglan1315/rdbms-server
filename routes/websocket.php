<?php

use Illuminate\Http\Request;
use SwooleTW\Http\Websocket\Facades\Websocket;

/*
|--------------------------------------------------------------------------
| Websocket Routes
|--------------------------------------------------------------------------
|
| Here is where you can register websocket events for your application.
|
*/

Websocket::on('open', function ($websocket, Request $request) {
    $websocket->emit('test', 'testing');
});

Websocket::on('getUser', function ($websocket, $request) {
    return ['id' => 1, 'name' => 'laric'];
});
