@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h6 class="text-center">Role Permission</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.roles.permissions-update', $role->id) }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="name">Role Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $role->name }}"
                                    readonly>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label>Permission</label>
                                <div class="check">
                                    <input type="checkbox" class="form-check-input" id="checkedAll" name="checkedAll">
                                    <label class="form-check-label" for="checkedAll">Semua</label>
                                </div>
                            </div>
                            <br>
                            <div class="form-group form-check">
                                @foreach ($role->permissions as $rp)
                                    <span class="mr-5">
                                        <input type="checkbox" class="form-check-input permissionClass"
                                            id="permissions{{ $rp->id }}" name="permissions[]" checked
                                            value="{{ $rp->name }}">
                                        <label class="form-check-label"
                                            for="permissions{{ $rp->id }}">{{ $rp->name }}</label>
                                    </span>
                                @endforeach
                                @foreach ($permissions as $permission)
                                    <span class="mr-5">
                                        <input type="checkbox" class="form-check-input permissionClass"
                                            id="permissions{{ $permission->id }}" name="permissions[]"
                                            value="{{ $permission->name }}">
                                        <label class="form-check-label"
                                            for="permissions{{ $permission->id }}">{{ $permission->name }}</label>
                                    </span>
                                @endforeach
                            </div>
                            <div class="form-group d-flex justify-content-between">
                                <a href="{{ route('admin.roles.index') }}" class="btn btn-warning">Batal</a>
                                <button class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            var cekAll = $('#checkedAll').val();
            $('#checkedAll').on('change', function() {
                if ($(this).is(":checked")) {
                    $('.permissionClass').prop("checked", true);
                } else if ($(this).is(":not(:checked)")) {
                    $('.permissionClass').prop("checked", false);
                }
            })
        });
    </script>
@endpush
