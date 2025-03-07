@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 shadow-md rounded-md">
    <h2 class="text-xl font-semibold mb-4">Đăng Ký</h2>
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <input type="text" name="ho_ten" placeholder="Họ Tên" class="w-full border p-2 mb-2">
        <input type="email" name="email" placeholder="Email" class="w-full border p-2 mb-2">
        <input type="password" name="password" placeholder="Mật khẩu" class="w-full border p-2 mb-2">
        <input type="text" name="so_dien_thoai" placeholder="Số điện thoại" class="w-full border p-2 mb-2">
        <button type="submit" class="w-full bg-blue-500 text-white py-2">Đăng Ký</button>
    </form>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "timeOut": "5000"
    };

    document.querySelector("form").addEventListener("submit", function(event) {
        event.preventDefault(); // Ngăn form gửi mặc định

        let formData = new FormData(this);

        fetch("{{ route('register') }}", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastr.success("Đăng ký thành công!");
                setTimeout(() => {
                    window.location.href = "{{ route('vietnam-airlines') }}";
                }, 1000);
            } else if (data.errors) {
                // Nếu có lỗi validation, hiển thị từng lỗi một
                Object.values(data.errors).forEach(messages => {
                    messages.forEach(message => {
                        toastr.error(message);
                    });
                });
            } else {
                toastr.error(data.message);
            }
        })
        .catch(error => {
            console.error("Lỗi:", error);
            toastr.error("Có lỗi xảy ra, vui lòng thử lại!");
        });
    });
});
</script>


@endsection
