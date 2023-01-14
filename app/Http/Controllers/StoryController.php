<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoryRequest;
use App\Models\Category;
use App\Models\Story;
use App\Models\User;
use App\Services\StoryService;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class StoryController extends Controller
{
    private Story $stories;
    private Category $categories;
    private User $users;
    private StoryService $storyService;


    public function __construct(Story $stories, Category $categories, User $users, StoryService $storyService)
    {
        $this->stories      = $stories;
        $this->users        = $users;
        $this->categories   = $categories;
        $this->storyService = $storyService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View|Factory
    {
        $stories = $this->stories->with(['category','user'])->paginate(10);
        $categories = $this->categories->all();
        $users = $this->users->all();
        return view('backEnd.master_data.article.index', compact('stories', 'categories','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoryRequest;  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoryRequest $request): RedirectResponse
    {
        return $this->storyService->saveStory($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Story  $stories
     * @return \Illuminate\Http\Response
     */
    public function show(Story $story)
    {
        if(!empty($story)){
            $categories = $this->categories->all();
            $users = $this->users->all();
            if(!empty($categories)){
                foreach($categories as $key => $category){
                    if($category->id == $story->category_id){
                        $categories[$key]->selected = 'selected';
                    }else{
                        $categories[$key]->selected = '';
                    }
                }
            }
            if(!empty($users)){
                foreach($users as $key => $user){
                    if($user->id == $story->user_id){
                        $users[$key]->selected = 'selected';
                    }else{
                        $users[$key]->selected = '';
                    }
                }
            }
            $story?->category;
            $story?->user;
            return response()->json([
                'status'        => true,
                'data'          => $story,
                'categories'    => $categories,
                'users'         => $users,
                'message'       => 'Data berhasil diambil.',
            ], JsonResponse::HTTP_OK);
        }else{
            return response()->json([
                'message'      => 'Data Tidak Ada.',
                'data'         => [],
                'categories'   => [],
                'users'   => [],
                'status'       => false,
            ], JsonResponse::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoryRequest  $request
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function update(StoryRequest $request, Story $story)
    {
        return $this->storyService->saveStory($request, $story);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stories  $stories
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request): JsonResponse
    {
        $service = $this->storyService->deleteStory($request);
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
