<?php

namespace App\Services;

use App\Http\Requests\RoleRequest;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RoleService
{
    public function saveRole(RoleRequest $request, ?Role $roles = null): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $data = $request->all();

            if ($roles) {
                $roles->update($data);
                RolePermission::where('role_id', $roles->id)->delete();
            } else {
                $roles = Role::create($data);
            }
            if(!empty($roles['id'])){
                if(!empty($data['permission_id'])){
                    $role_permissions = [];
                    foreach($data['permission_id'] as $key => $permission){
                        $role_permissions[] = [
                            "role_id"       => $roles['id'],
                            "permission_id" => $permission,
                        ];
                    }

                    RolePermission::insert($role_permissions);
                }
                DB::commit();
                return redirect()->route('role.index')->with('success', 'Data berhasil ' . ($roles->wasRecentlyCreated ? 'ditambahkan!' : 'diubah!'));
            }

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    public function deleteRole(Request $request): bool
    {
        DB::beginTransaction();
        try {
            Role::whereIn("id", $request->id)->delete();
            DB::commit();
            return TRUE;
        } catch (\Exception $e) {
            DB::rollback();
            return FALSE;
        }
    }
}
