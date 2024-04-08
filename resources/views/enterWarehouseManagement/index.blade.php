@extends('layout.app')

@section('template_title')
    J&T - Quản lý kho hàng
@endsection
@section('title_header')
    <div class="ml-5 mt-5 text-2xl font-semibold">
        Quản lý kho hàng
    </div>
@endsection
@section('css')
    <link href="{{ '/assets/lib/datetimepicker/jquery.datetimepicker.min.css' }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ '/assets/lib/daterangepicker/daterangepicker.css' }}" />

    <script type="text/javascript" src="{{ '/assets/lib/daterangepicker/moment.min.js' }}"></script>
    <script type="text/javascript" src="{{ '/assets/lib/daterangepicker/daterangepicker.js' }}"></script>
    <script type="text/javascript" src="{{ '/assets/lib/daterangepicker/moment-with-locales.js' }}"></script>
    <script src="{{ '/assets/lib/datetimepicker/jquery.datetimepicker.full.min.js'}}"></script>

    <style>
        input[type=text] {
            height: 44px;
        }
        input[type=text] ~ span {
            margin-top: 4px;
        }
    </style>
@endsection

@section('content')
    <div class="mt-4 py-2 pr-6 bg-[#F7F8F9]">
        <form class="gap-5 flex flex-wrap mb-0" id="frm-searching-v2" data-request="onSubmitSearch">
            <div class="relative xl:w-80 h-11" data-te-input-wrapper-init>
                <div id="reportrange-order-search"
                     class="bg-white cursor-pointer py-[5px] px-[10px] border border-solid border-[#ccc] w-full flex items-center h-[44px]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 448 512" style="margin-right: 5px;margin-top: -2px">
                        <path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"/>
                    </svg>
                    <span class="w-full">{{ $start_date }} - {{ $end_date }}</span>
                    <i class="fa fa-caret-down"></i>
                </div>
                <input type="text" id="start_date" name="start_date" class="hidden" value="{{$start_date}}">
                <input type="text" id="end_date" name="end_date" class="hidden" value="{{$end_date}}">
            </div>
            <div class="relative xl:w-[12.95rem] print-status h-11 bg-white rounded">
                <select class="" data-te-select-init data-te-select-filter="true" id="warehouse_id" name="warehouse_id">
                    <option value="all">Tất cả</option>
                    @foreach($warehouseList as $item)
                        <option {{$warehouse_id == $item->id ? 'selected' : ''}} value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
                <label data-te-select-label-ref for="warehouse_id">Kho hàng nhập</label>
            </div>
            <div class="relative xl:w-[12.95rem] print-status h-11 bg-white rounded">
                <select class="" data-te-select-init data-te-select-filter="true" id="supplier_id" name="supplier_id">
                    <option value="all">Tất cả</option>
                    @foreach($supplierList as $item)
                        <option {{$supplier_id == $item->id ? 'selected' : ''}} value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
                <label data-te-select-label-ref for="supplier_id">Nhà cung cấp</label>
            </div>
            <div class="relative xl:w-80 h-11" data-te-input-wrapper-init>
                <input type="text" class="peer block min-h-[auto] h-full w-full rounded border-0 bg-white py-[0.32rem] px-3 leading-[1.6] focus:outline-none transition-all
                duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none
                [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0" id="productName" name="productName" value="{{$productName}}" />
                <label for="productName"
                       class="pointer-events-none absolute top-0 left-3 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.6rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-neutral-200">Mã
                    Mã SKU, Tên sản phẩm</label>
            </div>
            <div class="relative xl:w-[12.95rem] print-status h-11 bg-white rounded">
                <select data-te-select-init id="status" name="status">
                    <option {{$status == 'all' ? 'selected' : ''}} value="all">Tất cả</option>
                    <option {{$status == '1' ? 'selected' : ''}} value="1">Tạo mới</option>
                    <option {{$status == '2' ? 'selected' : ''}} value="2">Đã nhập hàng</option>
                    <option {{$status == '0' ? 'selected' : ''}} value="0">Đã hủy</option>
                </select>
                <label data-te-select-label-ref>Trạng thái</label>
            </div>
            <div class="relative h-11 flex items-center">
                <button
                    type="submit"
                    id="btn-searching-order"
                    data-te-ripple-init data-te-ripple-color="light"
                    data-request-progress-bar="false"
                    data-attach-loading
                    style="background: red"
                    class="flex items-center gap-[8px] h-11 rounded bg-[#F00] px-[18px] py-3 Inter-Regular text-base font-extrabold text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-[#F00] hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-[#F00] focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-[#F00] active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]">
                    <svg width="22" height="22" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7.33333 13.1667C10.2789 13.1667 12.6667 10.7789 12.6667 7.83333C12.6667 4.88781 10.2789 2.5 7.33333 2.5C4.38781 2.5 2 4.88781 2 7.83333C2 10.7789 4.38781 13.1667 7.33333 13.1667Z"
                            stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M13.9996 14.5001L11.0996 11.6001" stroke="white" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
        </form>

    </div>
    @if(session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            {!! session()->get('success') !!}
        </div>
    @endif
    @if(session()->has('error'))
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            {!! session()->get('error') !!}
        </div>
    @endif
    <div class="flex flex-grow justify-between  items-center my-2">
        <div class="table-title Inter-SemiBold text-xl leading-6 tracking-[-0.02em] my-4">Hiện có
            <span class="total-order-v2">
    <b>{{$enterWarehouseList->total()}}</b>
    </span> danh sách nhập kho
            <button id="reset-frm-search-order" class="bg-white font-medium text-sm px-2.5 py-1 rounded-2xl border ml-3 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-[#F00] focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]">Xóa lọc</button>
        </div>
        <div class="hidden flex justify-center" id="notice-tick-all"></div>
        <div class="" style="display: inherit;">
            <button type="button"
                    id="cancelProductV2"
                    class="hidden Inter-SemiBold flex items-center rounded-lg border-2 border-gray-200 px-4 pt-2 pb-[6px] font-semibold  leading-normal text-red-500 transition duration-150 ease-in-out hover:border-red-500 focus:border-[#FF0000] focus:outline-none focus:ring-0 active:border-[#FF0000]  cursor-pointer"
                    data-te-ripple-init>
                <img class="mr-2" src="/assets/images/transh.png">
                Xóa kho hàng
            </button>
            <a
                href="/enter_warehouse/create"
                type="button"
                data-te-ripple-color="light"
                class="ml-4 Inter-Regular text-base leading-5 text-[#0079ED] h-10f px-[16px] py-[8px] flex items-center font-semibold rounded-lg border-2 border-gray-200 text-[#007FF9] transition duration-150 ease-in-out hover:border-[#007FF9] hover:bg-white hover:bg-opacity-10 hover:text-[#007FF9] focus:border-[#007FF9] focus:text-[#007FF9] focus:outline-none focus:ring-0 active:border-[#007FF9] active:text-[#007FF9]"
                data-te-ripple-init>
                <svg class="mr-3" width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 8.5H8V14.5H6V8.5H0V6.5H6V0.5H8V6.5H14V8.5Z" fill="#0079ED"/>
                </svg>
                Thêm mới nhập kho
            </a>
        </div>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left">
            <thead class="text-gray-500 bg-white">
            <tr class="text-gray-500">
                <th scope="col" class="px-4 py-4 border-b font-thin">
                    Kho hàng
                </th>
                <th scope="col" class="px-4 py-4 border-b font-thin">
                    Nhà cung cấp
                </th>
                <th scope="col" class="px-4 py-4 border-b font-thin">
                    Ngày lập phiếu
                </th>
                <th scope="col" class="px-4 py-4 border-b font-thin">
                    Ngày nhập kho
                </th>
                <th scope="col" class="px-4 py-4 border-b font-thin">
                    Người lập phiếu
                </th>
                <th scope="col" class="px-4 py-4 border-b font-thin">
                    Trạng thái
                </th>
                <th scope="col" class="px-4 py-4 border-b font-thin">
                    Thao tác
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($enterWarehouseList as $item)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-4 py-4 whitespace-nowrap">
                        {{$item->warehourse->name ?? ''}}
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        {{$item->supplier->name ?? ''}}
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        {{date('Y/m/d', strtotime($item->created_at))}}
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        {{str_replace('-', '/', $item->receipt_created_date)}}
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        {{$item->user->name ?? ''}}
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        @if($item->status == 1)
                            <span style="padding: 6px 10px;" class="bg-blue-50 text-blue-500 text-xs font-semibold mr-2 px-2.5 rounded-2xl">Tạo mới</span>
                        @elseif($item->status == 2)
                            <span style="padding: 6px 10px;" class="bg-green-50 text-green-500 text-xs font-semibold mr-2 px-2.5  rounded-2xl">Đã nhập hàng</span>
                        @else
                            <span style="padding: 6px 10px;" class="bg-red-50 text-red-500 text-xs font-semibold mr-2 px-2.5 rounded-2xl">Đã hủy</span>
                        @endif
                    </td>
                    <td class="px-4 py-4">
                        <a href="/detail-enter_warehouse/{{$item->id}}" type="button" data-te-ripple-color="light" data-te-toggle="tooltip" title="Xem chi tiết sản phẩm" data-te-placement="top" class="show-details mr-3 inline-block rounded-full leading-normal text-white shadow-md transition ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]">
                            <svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_1576_73161)">
                                    <path d="M16.5013 12C19.028 12 21.2813 13.42 22.3813 15.6667C21.2813 17.9133 19.028 19.3333 16.5013 19.3333C13.9746 19.3333 11.7213 17.9133 10.6213 15.6667C11.7213 13.42 13.9746 12 16.5013 12ZM16.5013 10.6667C13.168 10.6667 10.3213 12.74 9.16797 15.6667C10.3213 18.5933 13.168 20.6667 16.5013 20.6667C19.8346 20.6667 22.6813 18.5933 23.8346 15.6667C22.6813 12.74 19.8346 10.6667 16.5013 10.6667ZM16.5013 14C17.4213 14 18.168 14.7467 18.168 15.6667C18.168 16.5867 17.4213 17.3333 16.5013 17.3333C15.5813 17.3333 14.8346 16.5867 14.8346 15.6667C14.8346 14.7467 15.5813 14 16.5013 14ZM16.5013 12.6667C14.848 12.6667 13.5013 14.0133 13.5013 15.6667C13.5013 17.32 14.848 18.6667 16.5013 18.6667C18.1546 18.6667 19.5013 17.32 19.5013 15.6667C19.5013 14.0133 18.1546 12.6667 16.5013 12.6667Z" fill="#007FF9"></path>
                                </g>
                                <rect x="1" y="0.5" width="31" height="31" rx="15.5" stroke="#007FF9"></rect>
                                <defs>
                                    <clipPath id="clip0_1576_73161">
                                        <rect width="16" height="16" fill="white" transform="translate(8.5 8)"></rect>
                                    </clipPath>
                                </defs>
                            </svg>
                        </a>
                        @if($item->status == 1)
                        <a data-te-ripple-color="light" href="edit-enter_warehouse/{{$item->id}}" class="mr-2 edit-user inline-block rounded-full leading-normal text-white shadow-md transition ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_10313_43843)">
                                    <path d="M17.3733 14.0133L17.9867 14.6267L11.9467 20.6667H11.3333V20.0533L17.3733 14.0133ZM19.7733 10C19.6067 10 19.4333 10.0667 19.3067 10.1933L18.0867 11.4133L20.5867 13.9133L21.8067 12.6933C22.0667 12.4333 22.0667 12.0133 21.8067 11.7533L20.2467 10.1933C20.1133 10.06 19.9467 10 19.7733 10ZM17.3733 12.1267L10 19.5V22H12.5L19.8733 14.6267L17.3733 12.1267Z" fill="gray"></path>
                                </g>
                                <rect x="0.5" y="0.5" width="31" height="31" rx="15.5" stroke="gray"></rect>
                            </svg>
                        </a>
                        @endif
                    </td>
                </tr>
            @endforeach
            @if(count($enterWarehouseList) == 0)
                <tr class="">
                    <td colspan="6" class="text-center px-4 py-4 dark:border-neutral-500 nosort text-center">
                        <img src="/assets/images/no_data.png">
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
        @if(count($enterWarehouseList) > 0)
            <div class="row mt-4">
                <div class="flex p-4 bottom-0 flex-grow justify-between">
                    <select  id="select-per-page"
                             class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="25" {{$per_page == '25' ? 'selected' : ''}}>25</option>
                        <option value="50" {{$per_page == '50' ? 'selected' : ''}}>50</option>
                        <option value="100" {{$per_page == '100' ? 'selected' : ''}}>100</option>
                        <option value="300" {{$per_page == '300' ? 'selected' : ''}}>300</option>
                        <option value="500" {{$per_page == '500' ? 'selected' : ''}}>500</option>
                    </select>
                    @if($search)
                        {{ $enterWarehouseList->appends($search)->links('vendor.pagination.tailwind') }}
                    @else
                        {{ $enterWarehouseList->links('vendor.pagination.tailwind') }}
                    @endif
                </div>
            </div>
        @endif
    </div>

@endsection
@section('scripts')
    <script>
        $("#reset-frm-search-order").on('click', function(){
            window.location.href = '/enter_warehouse';
        });
        $('#select-all').on('click', function () {
            $('input[type="checkbox"]').prop('checked', this.checked);
        });
        $('#select-per-page').change(function () {
            let urlCurrent = window.location.search;
            if (urlCurrent.indexOf("?") == -1) {
                urlCurrent = urlCurrent + '?per_page=' + $(this).val();
            } else {
                urlCurrent = urlCurrent + '&per_page=' + $(this).val();
            }
            window.location.href = urlCurrent;
        });

    </script>
    <script type="module">
        const start = moment().subtract(7, 'days');
        const end = moment();
        const element = '#reportrange-order-search';
        let search_picker;
        (function () {
            search_picker = $('#reportrange-order-search').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    '7 ngày gần nhất': [moment().subtract(7, 'days'), moment()],
                    '30 ngày gần nhất': [moment().subtract(29, 'days'), moment()],
                    'Tháng này': [moment().startOf('month'), moment().endOf('month')]
                }
            }, cb);
        })();
        function cb(start, end) {
            $(element+' span').html(start.format('YYYY/MM/DD') + ' - ' + end.format('YYYY/MM/DD'));
        }
        $(element).on('apply.daterangepicker', function(ev, picker) {
            let start_date = picker.startDate.format('YYYY/MM/DD');
            let end_date = picker.endDate.format('YYYY/MM/DD');
            $('#start_date').val(start_date)
            $('#end_date').val(end_date)
        });
    </script>
@endsection

