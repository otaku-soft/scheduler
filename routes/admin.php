<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\StoresController;
use App\Http\Controllers\Admin\RoomsController;
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
    $urlRooms = new UrlBuilder("/admin/rooms/");
    Route::get($urlRooms->url(""), [RoomsController::class, 'index'])->name("rooms_index");
    Route::post($urlRooms->url("addRoomModal"), [RoomsController::class, 'addRoomModal'])->name("rooms_addRoomModal");
    Route::post($urlRooms->url("addRoom"), [RoomsController::class, 'addRoom'])->name("rooms_addRoom");
    Route::post($urlRooms->url("editRoomModal"), [RoomsController::class, 'editRoomModal'])->name("rooms_editRoomModal");
    Route::post($urlRooms->url("editRoom"), [RoomsController::class, 'editRoom'])->name("rooms_editRoom");
    Route::post($urlRooms->url("deleteRoomModal"), [RoomsController::class, 'deleteRoomModal'])->name("rooms_deleteRoomModal");
    Route::post($urlRooms->url("deleteRoom"), [RoomsController::class, 'deleteRoom'])->name("rooms_deleteRoom");
    Route::post($urlRooms->url("restoreRoom"), [RoomsController::class, 'restoreRoom'])->name("rooms_restoreRoom");
    Route::post($urlRooms->url("updateRoomPricingModal"), [RoomsController::class, 'updateRoomPricingModal'])->name("rooms_updateRoomPricingModal");
    Route::post($urlRooms->url("updateRoomPricing"), [RoomsController::class, 'updateRoomPricing'])->name("rooms_updateRoomPricing");
    Route::get($urlRooms->url("storeList/{id}"), [RoomsController::class, 'storeList'])->name("rooms_storeList");
    Route::post($urlRooms->url("storeListConfigureModal"), [RoomsController::class, 'storeListConfigureModal'])->name("rooms_storeListConfigureModal");
    Route::post($urlRooms->url("storeListConfigureSave"), [RoomsController::class, 'storeListConfigureSave'])->name("rooms_storeListConfigureSave");
});
