<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Models\Role;

class RolesController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $roles = Role::all();
        return view('admin.roles.index', ["roles" => $roles]);
    }
    /**
     * @param Request $request
     * @return View
     */
    public function addRoleModal(Request $request) : View
    {
        return view('admin.roles.add-role-modal');
    }
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addRole(Request $request): JsonResponse
    {
        if ($request->get("name") !== "admin")
        {
            $role = new Role();
            $role->name = $request->request->get("name");
            $role->guard_name = "web";
            $role->save();
        }
        return new JsonResponse(["success" => true]);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function editRoleModal(Request $request) : View
    {
        $role = Role::find($request->get("id"));
        return view('admin.roles.edit-role-modal', ["role" => $role]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function editRole(Request $request): JsonResponse
    {
        $role = Role::find($request->get("id"));
        $role->name = $request->get("name");
        $role->save();
        return new JsonResponse(["success" => true]);
    }
}
