<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Kasir Tridig') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- SweetAlert2 -->
        <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
        
        <!-- Flash Messages -->
        @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            </script>
        @endif

        @if(session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        @if(session('warning'))
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: '{{ session('warning') }}',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        @if(session('info'))
            <script>
                Swal.fire({
                    icon: 'info',
                    title: 'Informasi',
                    text: '{{ session('info') }}',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        @if($errors->any())
            <script>
                let errors = @json($errors->all());
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: errors.map(error => '• ' + error).join('<br>'),
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        <!-- Global notification function -->
        <script>
            window.showNotification = function(type, title, message) {
                Swal.fire({
                    icon: type,
                    title: title,
                    text: message,
                    timer: type === 'success' ? 3000 : 0,
                    showConfirmButton: type !== 'success'
                });
            };

            window.showConfirmDialog = function(title, text, confirmCallback) {
                Swal.fire({
                    title: title,
                    text: text,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, lanjutkan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed && confirmCallback) {
                        confirmCallback();
                    }
                });
            };
        </script>
    </body>
</html>
