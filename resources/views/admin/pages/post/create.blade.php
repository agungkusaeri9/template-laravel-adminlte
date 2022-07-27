@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="text-center">Tambah Artikel</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.posts.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="image" class="col-md-2 col-form-label">Gambar</label>
                                <div class="col-md-10">
                                    <input type="file" name="image"
                                        class="form-control @error('image') is-invalid @enderror" id="image"
                                        value="{{ old('image') }}">
                                    @error('image')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="title" class="col-md-2 col-form-label">Judul</label>
                                <div class="col-md-10">
                                    <input type="text" name="title"
                                        class="form-control @error('title') is-invalid @enderror" id="title"
                                        value="{{ old('title') }}">
                                    @error('title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="post_category_id" class="col-md-2 col-form-label">Kategori</label>
                                <div class="col-md-10">
                                    <select name="post_category_id" id="post_category_id"
                                        class="form-control @error('post_category_id') is-invalid @enderror">
                                        <option value="" selected disabled>-Pilih Kategori-</option>
                                        @foreach ($post_categories as $category)
                                            <option value="{{ $category->id }}"
                                                @if ($category->id == old('post_category_id')) selected @endif>{{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('post_category_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="short_description" class="col-md-2 col-form-label">Deskripsi Singkat</label>
                                <div class="col-md-10">
                                    <textarea name="short_description" id="short_description" cols="30" rows="4"
                                        class="form-control @error('short_description') is-invalid @enderror">{{ old('short_description') }}</textarea>
                                    @error('short_description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="is_active" class="col-md-2 col-form-label">Status</label>
                                <div class="col-md-10">
                                    <select name="is_active" id="is_active"
                                        class="form-control @error('is_active') is-invalid @enderror">
                                        <option value="" selected disabled>-Pilih Status-</option>
                                        <option value="1" @if (old('post_category_id') == 1) selected @endif>Aktif</option>
                                        <option value="0" @if (old('post_category_id') == 0) selected @endif>Tidak Aktif</option>
                                    </select>
                                    @error('is_active')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description">Deskripsi</label>
                                <textarea name="description" id="description" cols="30" rows="4"
                                    class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group d-flex justify-content-between">
                                <a href="{{ route('admin.posts.index') }}" class="btn btn-warning">Batal</a>
                                <button class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $(function() {
            $('#description').summernote({
                placeholder: 'Deskripsi Artikel...',
                disableDragAndDrop: true,
                tabDisable: true,
                height: 300,
                lineHeights: ['0.5', '1.0','1.5','2','2.5','3'],
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph','height']],
                    ['media',['table','picture','video','hr']],
                    ['misc', ['redo','undo','fullscreen','codeview']]
                ],
            });
        })
    </script>
@endpush
