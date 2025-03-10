@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold text-teal-700 mb-6">Xác Nhận Thông Tin Đặt Vé</h1>
        
        <!-- Flight details -->
        <div class="border-b pb-4 mb-4">
            <h2 class="text-lg font-semibold mb-3">Thông tin chuyến bay</h2>
            
            <div class="bg-gray-100 p-4 rounded-md">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div class="mb-2 md:mb-0">
                        <div class="font-semibold text-lg">{{ $flight->ma_chuyen_bay }}</div>
                        <div>{{ $flight->hangBay ? $flight->hangBay->ten_hang_bay : 'Vietnam Airlines' }}</div>
                    </div>
                    
                    <div class="flex-1 text-center mb-2 md:mb-0">
                        <div class="flex items-center justify-center">
                            <div class="text-right mr-3">
                                <div class="font-bold">{{ \Carbon\Carbon::parse($flight->ngay_gio_khoi_hanh)->format('H:i') }}</div>
                                <div class="text-sm">{{ $flight->diem_di }}</div>
                            </div>
                            
                            <div class="flex flex-col items-center mx-2">
                                <div class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($flight->ngay_gio_khoi_hanh)->diff(\Carbon\Carbon::parse($flight->ngay_gio_den))->format('%hh %im') }}
                                </div>
                                <div class="w-20 h-px bg-gray-300 my-1"></div>
                                <div class="text-xs text-gray-500">Bay thẳng</div>
                            </div>
                            
                            <div class="text-left ml-3">
                                <div class="font-bold">{{ \Carbon\Carbon::parse($flight->ngay_gio_den)->format('H:i') }}</div>
                                <div class="text-sm">{{ $flight->diem_den }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="text-sm">
                            Hạng ghế: 
                            <span class="font-semibold">
                                @if($bookingDetails['seat_type'] == 'pho_thong')
                                    Phổ thông
                                @elseif($bookingDetails['seat_type'] == 'pho_thong_dac_biet')
                                    Phổ thông đặc biệt
                                @elseif($bookingDetails['seat_type'] == 'thuong_gia')
                                    Thương gia
                                @endif
                            </span>
                        </div>
                        <div class="font-semibold">{{ \Carbon\Carbon::parse($flight->ngay_gio_khoi_hanh)->format('d/m/Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Passenger details -->
        <div class="border-b pb-4 mb-4">
            <h2 class="text-lg font-semibold mb-3">Thông tin hành khách</h2>
            
            <div class="space-y-3">
                @foreach($bookingDetails['passengers'] as $index => $passenger)
                    <div class="p-3 bg-gray-50 rounded">
                        <div class="font-semibold">Hành khách {{ $index + 1 }}: {{ $passenger['name'] }}</div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-gray-600">
                            <div>Email: {{ $passenger['email'] }}</div>
                            <div>Điện thoại: {{ $passenger['phone'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Price summary -->
        <div class="border-b pb-4 mb-4">
            <h2 class="text-lg font-semibold mb-3">Chi tiết giá vé</h2>
            
            <div class="space-y-2">
                <div class="flex justify-between">
                    <div>Giá vé cơ bản ({{ count($bookingDetails['passengers']) }} x {{ number_format($bookingDetails['price_per_seat'], 0, ',', '.') }} VND)</div>
                    <div>{{ number_format($bookingDetails['total_price'], 0, ',', '.') }} VND</div>
                </div>
                <div class="flex justify-between">
                    <div>Thuế và phí</div>
                    <div>Đã bao gồm</div>
                </div>
                <div class="flex justify-between font-bold pt-2 text-teal-700">
                    <div>Tổng tiền</div>
                    <div>{{ number_format($bookingDetails['total_price'], 0, ',', '.') }} VND</div>
                </div>
            </div>
        </div>
        
        <!-- Payment methods -->
        <form action="{{ route('payment.process') }}" method="POST">
            @csrf
            
            <h2 class="text-lg font-semibold mb-3">Phương thức thanh toán</h2>
            
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-6">
                @foreach($paymentMethods as $key => $method)
                    <div class="border rounded-lg p-3 hover:shadow-md transition cursor-pointer payment-option {{ $key === 'visa' ? 'border-teal-500' : '' }}" data-method="{{ $key }}">
                        <input type="radio" name="payment_method" id="payment_{{ $key }}" value="{{ $key }}" {{ $key === 'visa' ? 'checked' : '' }} class="hidden payment-radio">
                        <label for="payment_{{ $key }}" class="cursor-pointer flex flex-col items-center">
                            <div class="h-10 flex items-center justify-center mb-2">
                                <i class="fas fa-{{ $key === 'visa' || $key === 'mastercard' || $key === 'jcb' ? 'credit-card' : 'wallet' }} text-2xl text-gray-700"></i>
                            </div>
                            <div class="text-center">{{ $method }}</div>
                        </label>
                    </div>
                @endforeach
            </div>
            
            <div class="flex items-center justify-between mt-8">
                <a href="{{ url()->previous() }}" class="text-teal-700 hover:underline">
                    &larr; Quay lại
                </a>
                
                <button type="submit" class="bg-teal-700 text-white py-2 px-6 rounded-md hover:bg-teal-800 transition">
                    Thanh toán {{ number_format($bookingDetails['total_price'], 0, ',', '.') }} VND
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentOptions = document.querySelectorAll('.payment-option');
        
        paymentOptions.forEach(option => {
            option.addEventListener('click', function() {
                // Reset all options
                paymentOptions.forEach(opt => {
                    opt.classList.remove('border-teal-500');
                    opt.querySelector('.payment-radio').checked = false;
                });
                
                // Select this option
                const paymentMethod = this.dataset.method;
                this.classList.add('border-teal-500');
                this.querySelector('.payment-radio').checked = true;
            });
        });
    });
</script>
@endsection