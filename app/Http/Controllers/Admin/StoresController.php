<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Models\Stores;
use App\Models\States;

class StoresController extends Controller
{
    const MAX_STORES = 10;

    /**
     * @return View
     */
    public function index(): View
    {
        $stores = Stores::paginate(self::MAX_STORES);
        $deletedStores = Stores::onlyTrashed()->get();
        return view('admin.stores.index', ["stores" => $stores,'deletedStores' => $deletedStores]);
    }

    /**
     * @return View
     */
    public function addStoreModal(): View
    {
        return view('admin.stores.add-store-modal',['states'=> States::$states]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addStore(Request $request): JsonResponse
    {
        try
        {
            $request->validate(Stores::$rules);
            $store = new Stores();
            $this->copyFormFields($store, $request);
            $store->slug = uniqid();
            $store->order = 0;
            $store->save();
        }
        catch (\Exception $e)
        {
            return new JsonResponse(["success" => false, "message" => $e->getMessage()]);
        }
        return new JsonResponse(["success" => true]);
    }

    /**
     * @param Stores $store
     * @param Request $request
     * @return void
     */
    private function copyFormFields(Stores $store, Request $request)
    {
        $store->name = $request->get("name");
        $store->address = $request->get("address");
        $store->address2 = $request->get("address2");
        $store->phone = $request->get("phone");
        $store->city = $request->get("city");
        $store->state = $request->get("state");
        $store->zip = $request->get("zip");
        $store->zip2 = $request->get("zip2");
        $store->email = $request->get("email");
    }

    /**
     * @param Request $request
     * @return View
     */
    public function editStoreModal(Request $request): View
    {
        $store = Stores::find($request->get("id"));
        return view('admin.stores.edit-store-modal', ['store' => $store,'states'=> States::$states]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function editStore(Request $request): JsonResponse
    {
        try
        {
            $request->validate(Stores::$rules);
            $store = Stores::find($request->get("id"));
            $this->copyFormFields($store, $request);
            $store->save();
        }
        catch (\Exception $e)
        {
            return new JsonResponse(["success" => false, "message" => $e->getMessage()]);
        }
        return new JsonResponse(["success" => true]);
    }
    /**
     * @param Request $request
     * @return View
     */
    public function deleteStoreModal(Request $request): View
    {
        $store = Stores::find($request->get("id"));
        return view('admin.stores.delete-store-modal', ['store' => $store]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteStore(Request $request) : JsonResponse
    {
        $store = Stores::find($request->get("id"));
        $store->delete();
        return new JsonResponse(["success"=>true]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function restoreStore(Request $request) : JsonResponse
    {
        Stores::onlyTrashed()->find($request->get("id"))->restore();
        return new JsonResponse(["success" => true]);
    }
}