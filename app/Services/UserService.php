<?php

namespace App\Services;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function saveUser(UserRequest $request, ?User $users = null): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $path = $image->storeAs('public/user', $image->hashName());

                $data['image'] = basename($path);
            }
            if ($users) {
                if (Storage::disk('public')->exists('user') && !empty($users->image) && $request->hasFile('image')) {
                    Storage::disk('public')->delete("user/{$users->image}");
                }
                if($data['password'] == $users->password){
                    unset($data['password']);
                }else{
                    $data['password'] = bcrypt($data['password']);
                }
                $users->update($data);
            } else {
                $users = User::create($data);
            }
            DB::commit();
            return redirect()->route('user.index')->with('success', 'Data berhasil ' . ($users->wasRecentlyCreated ? 'ditambahkan!' : 'diubah!'));

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    public function deleteUser(Request $request): bool
    {
        DB::beginTransaction();
        try {
            $users = User::whereIn("id", $request->id)->get();
            if(!empty($users)){
                foreach($users as $user){
                    if (Storage::disk('public')->exists('user') && !empty($user->image)) {
                        Storage::disk('public')->delete("user/{$user->image}");
                    }
                }
                User::whereIn("id", $request->id)->delete();
                DB::commit();
                return TRUE;
            }
        } catch (\Exception $e) {
            DB::rollback();
            return FALSE;
        }
    }
}
