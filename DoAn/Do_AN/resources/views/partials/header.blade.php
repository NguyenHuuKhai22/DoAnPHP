<header class="bg-white shadow-md">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <img src="https://storage.googleapis.com/a1aa/image/jy_WetrVFJx9_BsIHJscZSM2UO6S2R6N1xfhkrZmKpY.jpg" alt="Vietnam Airlines Logo" class="h-12">
        
        <nav class="flex space-x-4">
            <a class="text-gray-600 hover:text-blue-600" href="#">Lên kế hoạch</a>
            <a class="text-gray-600 hover:text-blue-600" href="#">Thông tin hành trình</a>
            <a class="text-gray-600 hover:text-blue-600" href="#">Mua vé &amp; Sản phẩm khác</a>
            <a class="text-gray-600 hover:text-blue-600" href="#">Lotusmiles</a>
        </nav>

        <div class="flex space-x-4">
            <a class="text-gray-600 hover:text-blue-600" href="#">TRỢ GIÚP</a>

            @auth
                <span class="text-gray-600">Chào, {{ Auth::user()->ho_ten }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="text-gray-600 hover:text-blue-600">ĐĂNG XUẤT</button>
                </form>
            @else
                <a class="text-gray-600 hover:text-blue-600" href="{{ route('login') }}">ĐĂNG NHẬP</a>
                <a class="text-gray-600 hover:text-blue-600" href="{{ route('register') }}">ĐĂNG KÝ</a>
            @endauth
        </div>
    </div>
</header>
