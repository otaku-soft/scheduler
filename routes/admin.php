<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\StoresController;
use App\Http\Middleware\AuthAdmin;
use App\Routes\UrlBuilder;

Route::middleware(AuthAdmin::class)->group(function ()
{
    $urlRoles = new UrlBuilder("/admin/roles/");
    Route::get($urlRoles->url(""), [RolesController::class, 'index'])->name("roles_index");
    Route::post($urlRoles->url("/addRole"), [RolesController::class, 'addRole'])->name("roles_addRole");
    Route::post($urlRoles->url("/addRoleModal"), [RolesController::class, 'addRoleModal'])->name("roles_addRoleModal");
    Route::post($urlRoles->url("/editRoleModal"), [RolesController::class, 'editRoleModal'])->name("roles_editRoleModal");
    Route::post($urlRoles->url("/editRole"), [RolesController::class, 'editRole'])->name("roles_editRole");
    $urlUsers = new UrlBuilder("/admin/users/");
    Route::get($urlUsers->url(""), [UsersController::class, 'index'])->name("users_index");
    Route::post($urlUsers->url("/editModal"), [UsersController::class, 'editModal'])->name("users_editModal");
    Route::post($urlUsers->url("/edit"), [UsersController::class, 'edit'])->name("users_edit");
    $urlStores = new UrlBuilder("/admin/stores/");
    Route::get($urlStores->url(""), [StoresController::class, 'index'])->name("stores_index");
    Route::post($urlStores->url("addStoreModal"), [StoresController::class, 'addStoreModal'])->name("stores_addStoreModal");
    Route::post($urlStores->url("addStore"), [StoresController::class, 'addStore'])->name("stores_addStore");
    Route::post($urlStores->url("editStoreModal"), [StoresController::class, 'editStoreModal'])->name("stores_editStoreModal");
    Route::post($urlStores->url("editStore"), [StoresController::class, 'editStore'])->name("stores_editStore");
    Route::post($urlStores->url("deleteStoreModal"), [StoresController::class, 'deleteStoreModal'])->name("stores_deleteStoreModal");
    Route::post($urlStores->url("deleteStore"), [StoresController::class, 'deleteStore'])->name("stores_deleteStore");
    Route::post($urlStores->url("restoreStore"), [StoresController::class, 'restoreStore'])->name("stores_restoreStore");
});
