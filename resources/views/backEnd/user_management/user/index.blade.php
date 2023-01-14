@extends('layouts.main')
@section('title', config('app.name'))
@section('content')
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Data User</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">User</li>
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
                                        <button class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-create"><i class="nav-icon fa fa-plus"></i>  Tambah User</button>
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
                                            <th>Username</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($users as $user)
                                        <tr>
                                            <td><input type="checkbox" class="form-control checbox" value="{{ $user->id }}"></td>
                                            <td>
                                                @if (Auth::user()->can('update'))
                                                    <a href="#" class="edit" data-url="{{ route('user.update', $user->id) }}" data-id="{{ $user->id }}" data-get="{{ route('user.show', $user->id) }}">
                                                        <i class="fa fa-pen mr-3 text-dark"></i>
                                                    </a>
                                                @endif

                                                @if (Auth::user()->can('read'))
                                                    <a href="#" class="show" data-url="{{ route('user.show', $user->id) }}" data-id="{{ $user->id }}">
                                                        <i class="fa fa-eye text-dark"></i>
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->role->name }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Data Tidak Ada</td>
                                        </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                                {{ $users->links() }}
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
    @include('backEnd.user_management.user.create')
    @include('backEnd.user_management.user.edit')
    @include('backEnd.user_management.user.show')
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
                            url: "{{ route('user.destroy') }}",
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
                    console.log(response.data.image_url);
                    $("#image_show").attr("src",response.data.image_url);
                    $('#id_show').text(response.data.id);
                    $('#name_show').text(response.data.name);
                    $('#username_show').text(response.data.username);
                    $('#email_show').text(response.data.email);
                    $('#role_show').text(response.data.role.name);
                    $('#log_show').text(response.data.created_at);
                    $('#modal-show').modal('show');

                }
            })
            .fail(function () {
                console.log("error");
            });
        });
        $('#table tbody').on('click', '.edit', function () {
            var id = $(this).data('id');
            var url = $(this).data('url');
            var url_hit = $(this).data('get');
            $.ajax({
                url: url_hit,
                type: 'GET',
            })
            .done(function (response) {
                if(response.status){
                    $('#name_edit').val(response.data.name);
                    $('#username_edit').val(response.data.username);
                    $('#email_edit').val(response.data.email);
                    $('#password_edit').val(response.data.password);

                    let option_role = "<option value='' disabled selected>Pilih Role</option>";
                    for (let i = 0; i < response.roles.length; i++) {
                        option_role += "<option value='"+response.roles[i].id+"' selected='"+response.roles[i].selected+"'>"+response.roles[i].name+"</option>";
                    }
                    $('.role_id_edit').html(option_role);


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
