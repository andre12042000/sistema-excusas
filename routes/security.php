<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\UserController;
use Spatie\Permission\Middlewares\PermissionMiddleware;

Route::middleware([ PermissionMiddleware::class.':Acceso Gestion Usuario'])->group(function () {

});
Route::resource('users', UserController::class)->names('usuarios');
Route::middleware([ PermissionMiddleware::class.':Acceso Gestion Roles'])->group(function () {

});
Route::resource('role', RoleController::class)->names('roles');
