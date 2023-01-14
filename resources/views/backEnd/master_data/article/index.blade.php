@extends('layouts.main')
@section('title', config('app.name'))
@section('content')
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Data Article</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Article</li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        @if (Auth::user()->can('delete'))
                                            <div class="mt-2">
                                                <a href="#" class="hidden" id="btn-destroy"><i class="fa fa-trash text-red"></i></a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    @if (Auth::user()->can('create'))
                                        <button class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-create"><i class="nav-icon fa fa-plus"></i>  Tambah Article</button>
                                    @endif
                                </div>
                            </div>
						</div>
						<div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="table">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="allCheckbox" class="form-control"></th>
                                            <th>Actions</th>
                                            <th>Title</th>
                                            <th>Categories</th>
                                            <th>Author</th>
                                            <th>Created Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($stories as $story)
                                        <tr>
                                            <td><input type="checkbox" class="form-control checbox" value="{{ $story->id }}"></td>
                                            <td>
                                                @if (Auth::user()->can('update'))
                                                    <a href="#" class="edit" data-url="{{ route('story.update', $story->id) }}" data-id="{{ $story->id }}" data-get="{{ route('story.show', $story->id) }}">
                                                        <i class="fa fa-pen mr-3 text-dark"></i>
                                                    </a>
                                                @endif

                                                @if (Auth::user()->can('read'))
                                                    <a href="#" class="show" data-url="{{ route('story.show', $story->id) }}" data-id="{{ $story->id }}">
                                                        <i class="fa fa-eye text-dark"></i>
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{ $story->name }}</td>
                                            <td>{{ $story->category->name }}</td>
                                            <td>{{ $story->user->name }}</td>
                                            <td>{{ date("d M Y H:i", strtotime($story->created_at))}}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Data Tidak Ada</td>
                                        </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                                {{ $stories->links() }}
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
    @include('backEnd.master_data.article.create')
    @include('backEnd.master_data.article.edit')
    @include('backEnd.master_data.article.show')
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#allCheckbox').click(function(e){
            let table= $(e.target).closest('table');
            if(this.checked){
                $("#btn-destroy").removeClass("hidden");
            }else{
                $("#btn-destroy").addClass("hidden");
            }
            $('td input:checkbox',table).prop('checked',this.checked);
        });
        $('.checbox').click(function(e){
            if($('.checbox:checked').length == 0){
                $("#btn-destroy").addClass("hidden");
            }else{
                $("#btn-destroy").removeClass("hidden");
            }
        });
        $('#btn-destroy').click(function(e){
            let is_checked = $('.checbox:checked').length;
            if(is_checked > 0){
                let arrId = []
                $('.checbox:checked').each(function (i){
                    arrId.push($(this).val());
                });
                Swal.fire({
                    title: "Are you sure delete it?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                }).then((result) => {
                    if (result.isConfirmed){
                        $.ajax({
                            url: "{{ route('story.destroy') }}",
                            type: "POST",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": arrId
                            },
                            success: function (response) {
                                if(response.status){
                                    Swal.fire("Done!", "It was succesfully deleted!", "success").then(function(){
                                        location.reload();
                                    });
                                }else{
                                    Swal.fire("Error deleting!", "Please try again", "error").then(function(){
                                        location.reload();
                                    });
                                }
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                Swal.fire("Error deleting!", "Please try again", "error").then(function(){
                                    location.reload();
                                });
                        }
                        });
                    }
                });
            }
        });
        $('#table tbody').on('click', '.show', function () {
            var id = $(this).data('id');
            var url = $(this).data('url');
            $.ajax({
                url: url,
                type: 'GET',
            })
            .done(function (response) {
                if(response.status){
                    $('#id_show').text(response.data.id);
                    $('#name_show').text(response.data.name);
                    $('#slug_show').text(response.data.slug);
                    $('#category_show').text(response.data.category.name);
                    $('#author_show').text(response.data.user.name);
                    $('#content_show').text(response.data.content);
                    $('#log_show').text(response.data.created_at);
                    $("#image_show").attr("src",response.data.image_url);
                    $('#modal-show').modal('show');

                }
            })
            .fail(function () {
                console.log("error");
            });
        });
        $('#table tbody').on('click', '.edit', function () {
            let id = $(this).data('id');
            let url = $(this).data('url');
            let url_hit = $(this).data('get');
            $.ajax({
                url: url_hit,
                type: 'GET',
            })
            .done(function (response) {
                if(response.status){
                    $('#name_edit').val(response.data.name);
                    $('#content_edit').val(response.data.name);
                    let option_kategori = "<option value='' disabled selected>Pilih Kategori</option>";
                    for (let i = 0; i < response.categories.length; i++) {
                        option_kategori += "<option value='"+response.categories[i].id+"' selected='"+response.categories[i].selected+"'>"+response.categories[i].name+"</option>";
                    }
                    $('#category_id_edit').html(option_kategori);
                    let option_user = "<option value='' disabled selected>Pilih Author</option>";
                    for (let i = 0; i < response.users.length; i++) {
                        option_user += "<option value='"+response.users[i].id+"' selected='"+response.users[i].selected+"'>"+response.users[i].name+"</option>";
                    }
                    $('#user_id_edit').html(option_user);
                    $("#image_edit").attr("src",response.data.image_url);
                    $("#form-edit").attr('action', url);
                    $('#modal-edit').modal('show');

                }
            })
            .fail(function () {
                console.log("error");
            });
        });

    });
</script>
@endpush
