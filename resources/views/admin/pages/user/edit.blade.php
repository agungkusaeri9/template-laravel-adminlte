@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="text-center">Edit User</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.users.update', $item->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <div class="form-group row">
                                <label for="name" class="col-md-2 col-form-label">Name</label>
                                <div class="col-md-10">
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                        id="name" value="{{ $item->name ?? old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="username" class="col-md-2 col-form-label">Username</label>
                                <div class="col-md-10">
                                    <input type="text" name="username"
                                        class="form-control @error('username') is-invalid @enderror" id="username"
                                        value="{{ $item->username ?? old('username') }}">
                                    @error('username')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-2 col-form-label">Email</label>
                                <div class="col-md-10">
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror" id="email"
                                        value="{{ $item->email ?? old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-2 col-form-label">Password</label>
                                <div class="col-md-10">
                                    <input type="text" name="password"
                                        class="form-control @error('password') is-invalid @enderror" id="password"
                                        value="{{ old('password') }}" placeholder="Abaikan jika tidak ingin merubah password">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="role" class="col-md-2 col-form-label">Role</label><br>
                                <div class="col-md-10">
                                    @foreach ($roles as $role)
                                    <div class="form-check form-check-inline">
                                        <input @if($role->name == $item->getRoleNames()->first()) checked @endif class="form-check-input @error('role') is-invalid @enderror" type="radio" name="role" id="{{ $role->name }}" value="{{ $role->name }}">
                                        <label class="form-check-label" for="{{ $role->name }}">{{ $role->name }}</label>
                                    </div>
                                    @endforeach
                                    @error('role')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="avatar" class="col-md-2 col-form-label">Avatar</label>
                                <div class="col-10 align-self-center">
                                    <img src="{{ $item->avatar() }}" alt="" class="img-fluid mb-2"
                                        style="height: 80px">
                                    <input type="file" name="avatar"
                                        class="form-control @error('avatar') is-invalid @enderror" id="avatar"
                                        value="{{ old('avatar') }}">
                                    @error('avatar')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group d-flex justify-content-between">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-warning">Batal</a>
                                <button class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
