<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Models\Rooms;
use App\Models\RoomPricing;
use App\Http\Controllers\Admin\Rooms\RoomPricingData;
use App\Models\Stores;
use App\Models\RoomStoreLink;
use App\Models\RoomStoreLinkPrices;
class RoomsController extends Controller
{
    const MAX_ROOMS = 10;
    const PUBLIC_ROOM = "public";
    const PRIVATE_ROOM = "private";

    const MIN_PER_ROOM = 1;
    const MAX_PER_ROOM = 12;

    /**
     * @return View
     */
    public function index(): View
    {
        $rooms = Rooms::paginate(self::MAX_ROOMS);
        $deletedRooms = Rooms::onlyTrashed()->get();
        return view('admin.rooms.index', ["rooms" => $rooms, "deletedRooms" => $deletedRooms]);
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
        return view('admin.rooms.edit-room-modal', ['room' => $room]);
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
        return view('admin.rooms.delete-room-modal', ['room' => $room]);
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

    public function updateRoomPricingModal(Request $request): View
    {
        $prices = $this->pricesRoom($request->get("id"));
        return view('admin.rooms.update-room-pricing-modal', ['pricesPublic' => $prices[self::PUBLIC_ROOM],'pricesPrivate' => $prices[self::PRIVATE_ROOM], 'room' => Rooms::find($request->get("id"))]);
    }



    public function updateRoomPricing(Request $request): JsonResponse
    {
        $prices = $request->get("prices");
        $roomId = $request->get("room_id");
        foreach ($prices as $price)
        {
            $roomPrice = RoomPricing::where(["room_id" => $roomId, "type" => $price['type'], "person_number" => $price['personNumber']])->first();
            if (!$roomPrice)
            {
                $roomPrice = new RoomPricing();
                $roomPrice->room_id = $roomId;
            }
            $roomPrice->type = $price['type'];
            $roomPrice->person_number = $price['personNumber'];
            $roomPrice->price = $price['price'];
            $roomPrice->save();
        }
        return new JsonResponse(["success" => true]);
    }
    public function storeList($id) : View
    {
        $room = Rooms::find($id);
        $storeLink = RoomStoreLink::where("room_id",$id)->get();
        $linkedStoreIds = [];
        foreach ($storeLink as $link)
        {
            if ($link->active)
            {
                $linkedStoreIds[$link->store_id] = true;
            }
        }
        $stores = Stores::paginate(Stores::PAGINATE_DEFAULT);
        return view('admin.rooms.link-stores.store-list',['stores' => $stores,'room' => $room,'linkedStoreIds' => $linkedStoreIds]);
    }

    public function storeListConfigureModal(Request $request) : View
    {
        $storeLink = RoomStoreLink::where("room_id",$request->get("roomId"))->where("store_id",$request->get("storeId"))->first();
        $active = $storeLink && $storeLink->active;
        $prices = $this->pricesRoom($request->get("roomId"));
        if ($storeLink)
        foreach ($storeLink->prices as $price)
        {
            $pricingDataPrivate = new RoomPricingData($request->get("roomId"),self::PRIVATE_ROOM, $price->person_number);
            $pricingDataPrivate->copyFromEntity($price);
            $prices[$price->type][$price->person_number] = $pricingDataPrivate;
        }
        return view('admin.rooms.link-stores.store-list-configure-modal',['active' => $active,"roomId" => $request->get("roomId"),"storeId" => $request->get("storeId"),'pricesPublic' => $prices[self::PUBLIC_ROOM],'pricesPrivate' => $prices[self::PRIVATE_ROOM],'defaultScoring' => !$storeLink || !count($storeLink->prices)]);
    }
    public function storeListConfigureSave(Request $request) : JsonResponse
    {
        $storeLink = RoomStoreLink::where("room_id",$request->get("roomId"))->where("store_id",$request->get("storeId"))->first();
        if (!$storeLink)
        {
            $storeLink = new RoomStoreLink();
            $storeLink->room_id = $request->get("roomId");
            $storeLink->store_id = $request->get("storeId");
        }
        $storeLink->active = $request->get("active");
        $storeLink->save();
        if ($request->get("defaultScoring"))
        {
            $prices = RoomStoreLinkPrices::where(["storeLinkId" => $storeLink->id])->get();
            foreach($prices as $price)
            {
                $price->delete();
            }
        }
        else
        {
            $prices = $request->get("prices");
            foreach ($prices as $price)
            {
                $roomPrice = RoomStoreLinkPrices::where(["storeLinkId" => $storeLink->id, "type" => $price['type'], "person_number" => $price['personNumber']])->first();
                if (!$roomPrice)
                {
                    $roomPrice = new RoomStoreLinkPrices();
                    $roomPrice->storeLinkId = $storeLink->id;
                }
                $roomPrice->type = $price['type'];
                $roomPrice->person_number = $price['personNumber'];
                $roomPrice->price = $price['price'];
                $roomPrice->save();
            }
        }
        return new JsonResponse(["success" => true]);
    }

    private function hashPrices( $prices)
    {
        $returnedPrices = [];
        foreach ($prices as $price)
        {
            $returnedPrices[$price->person_number] = $price;
        }
        return $returnedPrices;
    }
    private function pricesRoom($roomId) : array
    {
        $pricesPrivate = RoomPricing::where(["room_id" => $roomId, "type" => self::PRIVATE_ROOM])->get();
        $pricesPublic =  RoomPricing::where(["room_id" => $roomId, "type" => self::PUBLIC_ROOM])->get();
        $prices =
            [
                self::PUBLIC_ROOM => [],
                self::PRIVATE_ROOM => []
            ];
        $pricesPrivate = $this->hashPrices($pricesPrivate);
        $pricesPublic = $this->hashPrices($pricesPublic);
        for ($i = self::MIN_PER_ROOM; $i <= self::MAX_PER_ROOM; $i++)
        {
            $pricingDataPrivate = new RoomPricingData($roomId,self::PRIVATE_ROOM, $i);
            if ( array_key_exists($i,$pricesPrivate))
                $pricingDataPrivate->copyFromEntity($pricesPrivate[$i]);
            $prices[self::PRIVATE_ROOM][$i] = $pricingDataPrivate;

            $pricingDataPublic = new RoomPricingData($roomId,self::PUBLIC_ROOM, $i);
            if (array_key_exists($i,$pricesPublic))
                $pricingDataPublic->copyFromEntity($pricesPublic[$i]);
            $prices[self::PUBLIC_ROOM][$i] = $pricingDataPublic;
        }
        return $prices;
    }
}