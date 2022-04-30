@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Sukses',
            showConfirmButton: true,
            text: '{{ session('success') }}',
            timer: 1500
        })
    </script>
@elseif(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            showConfirmButton: true,
            text: '{{ session('error') }}',
            timer: 1500
        })
    </script>
@endif

<script>
    $(function() {
        $('body').on('click', '.btnDelete', function(e) {
            e.preventDefault();
            var action = $(this).data('action');
            Swal.fire({
                title: 'Yakin ingin menghapus data ini?',
                text: "Data yang sudah dihapus tidak bisa dikembalikan lagi",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Yakin'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#formDelete').attr('action', action);
                    $('#formDelete').submit();
                }
            })
            console.log('ok');
        })
    })
</script>
