<?php

namespace App\Services;

use App\Http\Requests\PermissionRequest;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PermissionService
{
    public function savePermission(PermissionRequest $request, ?Permission $permissions = null): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['slug'] =  \Str::slug($request->name);
            if ($permissions) {
                $permissions->update($data);
            } else {
                $permissions = Permission::create($data);
            }
            DB::commit();
            return redirect()->route('permission.index')->with('success', 'Data berhasil ' . ($permissions->wasRecentlyCreated ? 'ditambahkan!' : 'diubah!'));

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    public function deletePermission(Request $request): bool
    {
        DB::beginTransaction();
        try {
            Permission::whereIn("id", $request->id)->delete();
            DB::commit();
            return TRUE;
        } catch (\Exception $e) {
            DB::rollback();
            return FALSE;
        }
    }
}
