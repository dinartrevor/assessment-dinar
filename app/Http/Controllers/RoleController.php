<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\Permission;
use App\Models\Role;
use Auth;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    private Permission $permissions;
    private Role $roles;
    private RoleService $roleService;

    public function __construct(Permission $permissions, Role $roles, RoleService $roleService)
    {
        $this->permissions = $permissions;
        $this->roles = $roles;
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View|Factory
    {

        $roles = $this->roles->paginate(10);
        $permissions = $this->permissions->get();
        return view('backEnd.user_management.role.index', compact('roles','permissions'));

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\RoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request): RedirectResponse
    {
        return $this->roleService->saveRole($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role): JsonResponse
    {
        if(!empty($role)){
            $idPermission = [];
            if(!empty($role->permissions)){
                foreach($role->permissions as $role_permission){
                    $idPermission[] = $role_permission->id;
                }
            }
            $permissions = $this->permissions->get();

            if(!empty($permissions)){
                foreach($permissions as $key => $permission){
                    $permissions[$key]->checked = '-';
                    if(in_array($permission->id, $idPermission)){
                        $permissions[$key]->checked = 'checked';
                    }
                }
            }
            return response()->json([
                'status'  => true,
                'data'    => $role,
                'permissions' => $permissions,
                'message' => 'Data berhasil diambil.',
            ], JsonResponse::HTTP_OK);
        }else{
            return response()->json([
                'message' => 'Data Tidak Ada.',
                'data'    => [],
                'roles'   => [],
                'permissions' => [],
                'status' => false,
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role): RedirectResponse
    {
        return $this->roleService->saveRole($request, $role);
    }

    public function destroy(Request $request)
    {
        $service = $this->roleService->deleteRole($request);
        if($service){
            return response()->json([
                'message' => 'Data berhasil dihapus.',
                'status' => true,
            ], JsonResponse::HTTP_OK);
        }else{
            return response()->json([
                'message' => 'Data Gagal Di hapus.',
                'status' => false,
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}
