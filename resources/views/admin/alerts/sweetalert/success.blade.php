@if(session('swal-success'))

    <script>
        $(document).ready(function (){
            Swal.fire({
                 text: '{{ session('swal-success') }}',
                 icon: 'success',
                showConfirmButton: false,
                timer: 3000
      });
        });
    </script>

@endif
