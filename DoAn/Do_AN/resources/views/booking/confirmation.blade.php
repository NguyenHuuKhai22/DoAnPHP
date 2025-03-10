@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto">
        <div class="text-center mb-8">
            <div class="inline-block p-3 rounded-full bg-green-100 text-green-600 mb-4">
                <i class="fas fa-check-circle text-4xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-teal-700">Đặt vé thành công</h1>
            <p class="text-gray-600 mt-2">Cảm ơn bạn đã sử dụng dịch vụ của Vietnam Airlines</p>
        </div>
        
        <!-- Ticket details -->
        <div class="border border-teal-200 rounded-lg p-6 mb-6 bg-teal-50">
            <div class="flex justify-between items-start border-b border-teal-200 pb-4 mb-4">
                <div>
                    <div class="text-sm text-gray-600">Mã đặt chỗ</div>
                    <div class="text-xl font-bold text-teal-700">{{ $ticket->ma_ve }}</div>
                </div>
                
                <div class="text-right">
                    <div class="text-sm text-gray-600">Ngày đặt</div>
                    <div>{{ \Carbon\Carbon::parse($ticket->ngay_dat)->format('d/m/Y H:i') }}</div>
                </div>
            </div>
            
            <div class="mb-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div class="mb-2 md:mb-0">
                        <div class="font-semibold text-lg">{{ $ticket->chuyenBay->ma_chuyen_bay }}</div>
                        <div>{{ $ticket->chuyenBay->hangBay ? $ticket->chuyenBay->hangBay->ten_hang_bay : 'Vietnam Airlines' }}</div>
                    </div>
                    
                    <div class="flex-1 text-center mb-2 md:mb-0">
                        <div class="flex items-center justify-center">
                            <div class="text-right mr-3">
                                <div class="font-bold">{{ \Carbon\Carbon::parse($ticket->chuyenBay->ngay_gio_khoi_hanh)->format('H:i') }}</div>
                                <div class="text-sm">{{ $ticket->chuyenBay->diem_di }}</div>
                            </div>
                            
                            <div class="flex flex-col items-center mx-2">
                                <div class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($ticket->chuyenBay->ngay_gio_khoi_hanh)->diff(\Carbon\Carbon::parse($ticket->chuyenBay->ngay_gio_den))->format('%hh %im') }}
                                </div>
                                <div class="w-20 h-px bg-gray-300 my-1"></div>
                                <div class="text-xs text-gray-500">Bay thẳng</div>
                            </div>
                            
                            <div class="text-left ml-3">
                                <div class="font-bold">{{ \Carbon\Carbon::parse($ticket->chuyenBay->ngay_gio_den)->format('H:i') }}</div>
                                <div class="text-sm">{{ $ticket->chuyenBay->diem_den }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="text-sm">
                            Hạng ghế: 
                            <span class="font-semibold">
                                @if($ticket->loai_ghe == 'pho_thong')
                                    Phổ thông
                                @elseif($ticket->loai_ghe == 'pho_thong_dac_biet')
                                    Phổ thông đặc biệt
                                @elseif($ticket->loai_ghe == 'thuong_gia')
                                    Thương gia
                                @endif
                            </span>
                        </div>
                        <div class="font-semibold">{{ \Carbon\Carbon::parse($ticket->chuyenBay->ngay_gio_khoi_hanh)->format('d/m/Y') }}</div>
                    </div>
                </div>
            </div>
            
            <div class="mb-6">
                <h3 class="font-semibold mb-2">Thông tin hành khách</h3>
                <div class="p-3 bg-white rounded">
                    <div class="font-semibold">{{ $ticket->nguoiDung->ho_ten }}</div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-gray-600">
                        <div>Email: {{ $ticket->nguoiDung->email }}</div>
                        <div>Điện thoại: {{ $ticket->nguoiDung->so_dien_thoai }}</div>
                    </div>
                </div>
            </div>
            
            <div>
                <h3 class="font-semibold mb-2">Thông tin thanh toán</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <div class="text-sm text-gray-600">Phương thức thanh toán</div>
                        <div>{{ ucfirst($ticket->thanhToan->phuong_thuc) }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-600">Tổng tiền đã thanh toán</div>
                        <div class="font-bold text-teal-700">{{ number_format($ticket->gia_ve, 0, ',', '.') }} VND</div>
                    </div>
                </div>
            </div>
        </div>
        
        @if(count($tickets) > 1)
            <div class="mb-6">
                <h3 class="font-semibold mb-3">Vé đã đặt cho các hành khách khác</h3>