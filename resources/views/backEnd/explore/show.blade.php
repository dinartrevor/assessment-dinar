@extends('layouts.main')
@section('title', config('app.name'))
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Detail <Article></Article></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('explore') }}" class="btn btn-secondary"><i class="mr-2 fa fa-arrow-left"></i>Kembali</a></li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-9">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="card shadow-sm">
                            <img src="{{ $story->image_url }}" width="100%" height="300" class="bd-placeholder-img card-img-top">
                            <div class="card-body">
                                <a href="{{ route('explore.show', $story->slug) }}" class="text-dark"><h3>{{ $story->name }}</h3></a>
                                <p class="card-text">{{  $story->content }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                    <span class="badge bg-secondary fs-4">{{ $story->category->name }}</span>
                                    </div>
                                    <small class="text-muted">{{ $story->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h5 class="bold">Recomendation For You</h5>
                <div class="row mt-3">
                    @foreach ($stories as $story)
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
                    @endforeach
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5>You Article</h5>
                        <ul class="list-group list-group-flush">
                            @foreach ($storiesByAuthor as $storyByAuthor)
                                <li class="list-group-item">
                                    <img src="{{ $storyByAuthor->image_url }}" width="30%" class="bd-placeholder-img">
                                    <a href="{{ route('explore.show', $storyByAuthor->slug) }}">
                                        <span class="text-dark bold">{{ $storyByAuthor->name }}</span>
                                    </a>
                                </li>
                            @endforeach
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
