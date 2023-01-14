<div class="modal fade" id="modal-edit" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Article</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="" method="POST" class="form-horizontal" id="form-edit" enctype="multipart/form-data">
                @csrf
                @method("PUT")
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name" class="form-label">Title</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name_edit" placeholder="Masukan Title" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="role" class="form-label">Kategori</label>
                                <select name="category_id" id="category_id_edit" class="form-control @error('category_id') is-invalid @enderror">
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name" class="form-label">Author</label>
                                <select name="user_id" id="user_id_edit" class="form-control @error('user_id') is-invalid @enderror">
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name" class="form-label">Content</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" name="content" id="content_edit" cols="30" rows="10" placeholder="Masukan Isi Content"></textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Image Profile</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="image" accept="image/*">
                                 @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <img src="" class="img-responsive img-thumbnail" id="image_edit">
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update changes</button>
                </div>
            </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
