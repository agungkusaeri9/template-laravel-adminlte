@extends('admin.layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h6>Data Kategori</h6>
                       @can('post-category-create')
                            <a href="{{ route('admin.post-categories.create') }}" class="btn btn-primary btn-sm">Tambah Kategori</a>
                       @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table id="table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th  style="width:20px">No</th>
                                <th>Nama Kategori</th>
                                @canany(['post-category-edit','post-category-delete'])
                                <th style="width:80px;text-align:center">Aksi</th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                @canany(['post-category-edit','post-category-delete'])
                                <td class="text-center">
                                    @can('post-category-edit')
                                    <a href="{{ route('admin.post-categories.edit',$item->id) }}" class="btn btn-sm btn-info" title="Edit"><i class="fas fa-edit"></i></a>
                                    @endcan
                                   @can('post-category-delete')
                                   <form method="post" class="d-inline" id="formDelete">
                                    @csrf
                                    @method('delete')
                                    <button title="Hapus" class="btn btn-sm btn-danger btnDelete" data-action="{{ route('admin.post-categories.destroy',$item->id) }}"><i class="fas fa-trash"></i></button>
                                </form>
                                   @endcan
                                </td>
                                @endcanany
                            </tr>
                            @endforeach
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
@endpush
@push('scripts')
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
@include('admin.layouts.partials.sweetalert')
<script>
    $(function () {
        $('#table').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true
        });
    });
</script>
@endpush
