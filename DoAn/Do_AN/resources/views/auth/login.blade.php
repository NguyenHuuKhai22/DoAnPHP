@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 shadow-md rounded-md">
    <h2 class="text-xl font-semibold mb-4">Đăng Nhập</h2>

    <form id="login-form">
        @csrf
        <input type="email" name="email" id="email" placeholder="Email" class="w-full border p-2 mb-2">
        <input type="password" name="password" id="password" placeholder="Mật khẩu" class="w-full border p-2 mb-2">
        <button type="submit" class="w-full bg-blue-500 text-white py-2">Đăng Nhập</button>
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

    document.getElementById('login-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Ngăn load lại trang

        let formData = new FormData(this);

        fetch("{{ route('login') }}", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastr.success("Đăng nhập thành công!", "Thành công");
                setTimeout(() => {
                    window.location.href = "{{ route('vietnam-airlines') }}";
                }, 1000);
            } else if (data.errors) {
                // Nếu có lỗi validation, hiển thị từng lỗi
                Object.values(data.errors).forEach(messages => {
                    messages.forEach(message => {
                        toastr.error(message, "Lỗi");
                    });
                });
            } else {
                toastr.error(data.message, "Lỗi");
            }
        })
        .catch(error => {
            console.error("Lỗi:", error);
            toastr.error("Có lỗi xảy ra, vui lòng thử lại sau!", "Lỗi hệ thống");
        });
    });
});
</script>







@endsection
