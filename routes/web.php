<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    ray('Hola  desde hola');
    return view('welcome');
});
