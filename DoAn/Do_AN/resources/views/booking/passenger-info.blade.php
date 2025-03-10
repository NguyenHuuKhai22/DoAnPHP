@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold text-teal-700 mb-6">Thông Tin Hành Khách</h1>
        
        <!-- Flight details -->
        <div class="bg-gray-100 p-4 rounded-md mb-6">
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
                            @if($seatType == 'pho_thong')
                                Phổ thông
                            @elseif($seatType == 'pho_thong_dac_biet')
                                Phổ thông đặc biệt
                            @elseif($seatType == 'thuong_gia')
                                Thương gia
                            @endif
                        </span>
                    </div>
                    <div class="font-semibold">{{ \Carbon\Carbon::parse($flight->ngay_gio_khoi_hanh)->format('d/m/Y') }}</div>
                </div>
            </div>
        </div>
        
        <!-- Passenger form -->
        <form action="{{ route('booking.review') }}" method="POST">
            @csrf
            
            <h2 class="text-lg font-semibold mb-4">Nhập thông tin {{ $numPassengers }} hành khách</h2>
            
            @for($i = 0; $i < $numPassengers; $i++)
                <div class="mb-6 p-4 border rounded-lg">
                    <h3 class="font-semibold mb-3">Hành khách {{ $i + 1 }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="passenger_name_{{ $i }}" class="block text-gray-700 mb-1">Họ tên</label>
                            <input type="text" id="passenger_name_{{ $i }}" name="passenger_name[]" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                            @error('passenger_name.'.$i)
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="passenger_email_{{ $i }}" class="block text-gray-700 mb-1">Email</label>
                            <input type="email" id="passenger_email_{{ $i }}" name="passenger_email[]" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                            @error('passenger_email.'.$i)
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div>
                        <label for="passenger_phone_{{ $i }}" class="block text-gray-700 mb-1">Số điện thoại</label>
                        <input type="tel" id="passenger_phone_{{ $i }}" name="passenger_phone[]" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                        @error('passenger_phone.'.$i)
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @endfor
            
            <div class="flex items-center justify-between mt-8">
                <div>
                    <div class="text-gray-600">Tổng tiền:</div>
                    <div class="text-2xl font-bold text-teal-700">
                        {{ number_format($totalPrice, 0, ',', '.') }} VND
                    </div>
                </div>
                
                <div>
                    <button type="submit" class="bg-teal-700 text-white py-2 px-6 rounded-md hover:bg-teal-800 transition">
                        Tiếp tục
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection