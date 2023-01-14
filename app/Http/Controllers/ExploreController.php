<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Story;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
class ExploreController extends Controller
{
    private Story $stories;
    private Category $categories;

    public function __construct(Story $stories, Category $categories)
    {
        $this->stories      = $stories;
        $this->categories   = $categories;
    }

    public function index(): View|Factory
    {
        $stories            = $this->stories->with(['category'])->latest()->limit(4)->get();
        $storiesByAuthor    = $this->stories->where('user_id', Auth::user()->id)->latest()->limit(4)->get();
        $categories         = $this->categories->latest()->get();
        return view ('backEnd.explore.index', compact('stories', 'categories','storiesByAuthor'));
    }

    public function show($slug): View|Factory|RedirectResponse
    {
        $story    = $this->stories->with(['category'])->where("slug", $slug)->first();
        if(empty($story)){
            return redirect()->route('explore')->with('error', 'Data Article Tidak Ada');
        }

        $stories  = $this->stories->with(['category'])->where("category_id", $story->category_id)->where('id', '!=' , $story->id)->latest()->limit(2)->get();
        $storiesByAuthor    = $this->stories->where('user_id', Auth::user()->id)->latest()->limit(4)->get();
        $categories         = $this->categories->latest()->get();


        return view('backEnd.explore.show', compact('story', 'storiesByAuthor', 'categories','stories'));
    }
}
