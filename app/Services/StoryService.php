<?php

namespace App\Services;

use App\Http\Requests\StoryRequest;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StoryService
{
    public function saveStory(StoryRequest $request, ?Story $stories = null): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['slug'] = \Str::slug($request->name);
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $path = $image->storeAs('public/story', $image->hashName());

                $data['image'] = basename($path);
            }
            if ($stories) {
                if (Storage::disk('public')->exists('story') && !empty($stories->image) && $request->hasFile('image')) {
                    Storage::disk('public')->delete("story/{$stories->image}");
                }
                $stories->update($data);
            } else {
                $stories = Story::create($data);
            }
            DB::commit();
            return redirect()->route('story.index')->with('success', 'Data berhasil ' . ($stories->wasRecentlyCreated ? 'ditambahkan!' : 'diubah!'));

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    public function deleteStory(Request $request): bool
    {
        DB::beginTransaction();
        try {
            $stories = Story::whereIn("id", $request->id)->get();
            if(!empty($stories)){
                foreach($stories as $story){
                    if (Storage::disk('public')->exists('story') && !empty($story->image)) {
                        Storage::disk('public')->delete("story/{$story->image}");
                    }
                }
                Story::whereIn("id", $request->id)->delete();
                DB::commit();
                return TRUE;
            }
        } catch (\Exception $e) {
            DB::rollback();
            return FALSE;
        }
    }
}
