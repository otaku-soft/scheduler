<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Middleware\AuthAdmin;
use App\Routes\UrlBuilder;

Route::middleware(AuthAdmin::class)->group(function ()
{
    $urlRoles = new UrlBuilder("/admin/roles/");
    Route::get($urlRoles->url(""), [RolesController::class, 'index'])->name("roles_index");
    Route::post($urlRoles->url("/addRole"), [RolesController::class, 'addRole'])->name("roles_addRole");
    Route::post($urlRoles->url("/editRoleModal"), [RolesController::class, 'editRoleModal'])->name("roles_editRoleModal");
    Route::post($urlRoles->url("/editRole"), [RolesController::class, 'editRole'])->name("roles_editRole");
    $urlUsers = new UrlBuilder("/admin/users/");
    Route::get($urlUsers->url(""), [UsersController::class, 'index'])->name("users_index");
    Route::post($urlUsers->url("/editModal"), [UsersController::class, 'editModal'])->name("users_editModal");
    Route::post($urlUsers->url("/edit"), [UsersController::class, 'edit'])->name("users_edit");
});
