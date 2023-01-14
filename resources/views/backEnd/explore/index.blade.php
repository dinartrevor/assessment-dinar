@extends('layouts.main')
@section('title', config('app.name'))
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Explore Now</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @if (Auth::user()->can('create'))
                        <li class="breadcrumb-item"><a href="{{ route('story.index') }}" class="btn btn-primary">Create Article <i class="ml-2 fa fa-pen"></i></a></li>
                    @endif
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-9">
                <div class="row">
                    @forelse ($stories as $story)
                        <div class="col-md-6">
                            <div class="card shadow-sm">
                                <img src="{{ $story->image_url }}" width="100%" height="225" class="bd-placeholder-img card-img-top">
                                <div class="card-body">
                                    <a href="{{ route('explore.show', $story->slug) }}" class="text-dark"><h3>{{ $story->name }}</h3></a>
                                    <p class="card-text">{{  Str::of($story->content)->limit(125) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                        <span class="badge bg-secondary fs-4">{{ $story->category->name }}</span>
                                        </div>
                                        <small class="text-muted">{{ $story->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-md-12">
                            <div class="card shadow-sm">
                                <img src="https://t4.ftcdn.net/jpg/02/51/95/53/360_F_251955356_FAQH0U1y1TZw3ZcdPGybwUkH90a3VAhb.jpg" width="100%" height="500" class="bd-placeholder-img card-img-top">
                                <div class="card-body">
                                    <p class="card-text text-center">DATA KOSONG</p>
                                </div>
                            </div>
                        </div>

                    @endforelse
                </div>
                @if($stories->count() >= 4)
                    <center><a href="{{ route('story.index') }}">Show All...</a></center>
                @endif
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5>You Article</h5>
                        <ul class="list-group list-group-flush">
                            @forelse ($storiesByAuthor as $storyByAuthor)
                                <li class="list-group-item">
                                    <img src="{{ $storyByAuthor->image_url }}" width="30%" class="bd-placeholder-img">
                                    <a href="{{ route('explore.show', $storyByAuthor->slug) }}">
                                        <span class="text-dark bold">{{ $storyByAuthor->name }}</span>
                                    </a>
                                </li>
                                @empty
                                    <li class="list-group-item">
                                        <img src="https://t4.ftcdn.net/jpg/02/51/95/53/360_F_251955356_FAQH0U1y1TZw3ZcdPGybwUkH90a3VAhb.jpg" width="30%"  class="bd-placeholder-img">
                                        <span class="text-dark bold">DATA KOSONG</span>
                                    </li>
                            @endforelse
                          </ul>
                          <hr>
                          <div class="mr-2">
                            <h5>All Categories</h5>
                            @foreach ($categories as $category)
                                <span class="badge bg-secondary fs-4">{{ $category->name }}</span></span>
                            @endforeach
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
