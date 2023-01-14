<?php

namespace App\Services;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryService
{
    public function saveCategory(CategoryRequest $request, ?Category $categories = null): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['slug'] = \Str::slug($request->name);
            if ($categories) {
                $categories->update($data);
            } else {
                $categories = Category::create($data);
            }
            DB::commit();
            return redirect()->route('category.index')->with('success', 'Data berhasil ' . ($categories->wasRecentlyCreated ? 'ditambahkan!' : 'diubah!'));

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    public function deleteCategory(Request $request): bool
    {
        DB::beginTransaction();
        try {
            Category::whereIn("id", $request->id)->delete();
            DB::commit();
            return TRUE;
        } catch (\Exception $e) {
            DB::rollback();
            return FALSE;
        }
    }
}
