<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Models\Rooms;

class RoomsController extends Controller
{
    const MAX_ROOMS = 10;

    /**
     * @return View
     */
    public function index(): View
    {
        $rooms = Rooms::paginate(self::MAX_ROOMS);
        $deletedRooms = Rooms::onlyTrashed()->get();
        return view('admin.rooms.index', ["rooms" => $rooms,"deletedRooms" => $deletedRooms]);
    }

    /**
     * @return View
     */
    public function addRoomModal(): View
    {
        return view('admin.rooms.add-room-modal');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addRoom(Request $request): JsonResponse
    {
        $room = new Rooms();
        $room->name = $request->get("name");
        $room->slug = uniqid();
        $room->save();
        return new JsonResponse(["success" => true]);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function editRoomModal(Request $request): View
    {
        $room = Rooms::find($request->get("id"));
        return view('admin.rooms.edit-room-modal',['room' => $room]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function editRoom(Request $request): JsonResponse
    {
        $room = Rooms::find($request->get("id"));
        $room->name = $request->get("name");
        $room->save();
        return new JsonResponse(["success" => true]);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function deleteRoomModal(Request $request): View
    {
        $room = Rooms::find($request->get("id"));
        return view('admin.rooms.delete-room-modal',['room' => $room]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteRoom(Request $request): JsonResponse
    {
        $room = Rooms::find($request->get("id"));
        $room->delete();
        return new JsonResponse(["success" => true]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function restoreRoom(Request $request): JsonResponse
    {
        Rooms::onlyTrashed()->find($request->get("id"))->restore();
        return new JsonResponse(["success" => true]);
    }
}