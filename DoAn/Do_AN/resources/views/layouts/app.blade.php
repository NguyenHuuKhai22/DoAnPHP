<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Trang chủ')</title>
   
<!-- Tải jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

     <!-- Bootstrap CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
     <!-- Thư viện Toastr -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>
<body>
    <header>
        @include('partials.header')
    </header>

    <main class="container mx-auto mt-4">
        @yield('content')
    </main>

    <footer class="text-center mt-4">
        <p>&copy; {{ date('Y') }} - Hệ thống đặt vé máy bay</p>
    </footer>
</body>
</html>
