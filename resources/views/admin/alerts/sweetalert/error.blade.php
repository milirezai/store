@if(session('swal-error'))

    <script>
        $(document).ready(function (){
            Swal.fire({
                 text: '{{ session('swal-error') }}',
                 icon: 'error',
                showConfirmButton: false,
                timer: 3000
      });
        });
    </script>

@endif
