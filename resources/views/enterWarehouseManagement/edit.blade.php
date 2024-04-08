@extends('layout.app')

@section('template_title')
    J&T - Chỉnh sửa nhập kho
@endsection
@section('title_header')
    <div class="ml-5 mt-5 text-2xl font-semibold">
        Chỉnh sửa nhập kho
    </div>
@endsection
@section('css')
    <script src="{{ '/assets/lib/datetimepicker/datepicker.min.js' }}"></script>
    <style>
        input[type=text] {
            height: 44px;
        }
    </style>
    <script>
        const arrSelectProd = [];
    </script>
@endsection

@section('content')
    <div class="breadcrumb">
        <nav class="bg-grey-light w-full rounded-md">
            <ol class="list-reset flex items-center">
                <li>
                    <a href="/enter_warehouse" style="display: flex" class="ml-5 transition duration-150 ease-in-out hover:text-primary-600 focus:text-primary-600
                        active:text-primary-700 dark:text-primary-400 dark:hover:text-primary-500 dark:focus:text-primary-500 dark:active:text-primary-600
                        Inter-SemiBold text-lg tracking-[-0.02em] text-[#000000]">
                        <svg fill="gray" width="24" height="24" version="1.2" baseProfile="tiny" id="inventory" style="margin-right: 8px; margin-top: 1px"
                             xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 256 230"
                             xml:space="preserve">
                        <path d="M61.2,106h37.4v31.2H61.2V106z M61.2,178.7h37.4v-31.2H61.2V178.7z M61.2,220.1h37.4v-31.2H61.2V220.1z M109.7,178.7H147
                            v-31.2h-37.4V178.7z M109.7,220.1H147v-31.2h-37.4V220.1z M158.2,188.9v31.2h37.4v-31.2H158.2z M255,67.2L128.3,7.6L1.7,67.4
                            l7.9,16.5l16.1-7.7v144h18.2V75.6h169v144.8h18.2v-144l16.1,7.5L255,67.2z"/>
                        </svg>
                        Quản lý nhập kho</a>
                </li>
                <li>
                    <svg class="mx-2 Inter-SemiBold text-lg tracking-[-0.02em] text-[#000000]" width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.589844 11.09L5.16984 6.5L0.589844 1.91L1.99984 0.5L7.99984 6.5L1.99984 12.5L0.589844 11.09Z" fill="#0D0F11"></path>
                    </svg>
                </li>
                <li class="Inter-SemiBold text-lg tracking-[-0.02em] text-[#F20000]">Chỉnh sửa nhập kho</li>
            </ol>
        </nav>
    </div>

    <div class="mt-4 py-4">
        @if(session()->has('success'))
            <div class="ml-5 p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                {{ session()->get('success') }}
            </div>
        @endif
        @if(session()->has('error'))
            <div class="ml-5 p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                {{ session()->get('error') }}
            </div>
        @endif
        <form class="" action="/edit-enter_warehouse/{{$enterWarehouse->id}}" method="POST" id="frm-enterWarehouse" enctype="multipart/form-data">
            <div class="rounded-2xl bg-white p-5 mx-5">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="bg-red-50 rounded flex p-3 items-center">
                    <span class="ml-2 Inter-SemiBold text-[#CC0000] text-lg font-medium leading-[22px]">1. Thông tin chung</span>
                </div>
                <div class="flex flex-wrap -ml-2 -mr-2">
                    <div class="p-2 mt-4 w-1/3">
                        <div class="relative">
                            <label for="warehouse" class="leading-5 text-base text-[#191D23] Inter-Regular">Kho hàng <span class="text-[#DC2626]">*</span></label>
                            <div class="mt-1">
                                <select data-te-select-init data-te-select-filter="true" id="warehouse" name="warehouse">
                                    @foreach($warehouseList as $item)
                                        <option {{((old('warehouse') ?? $enterWarehouse->warehouse_id) == $item->id) ? 'selected' : ''}} value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="text-[#ef4444] text-sm"  data-validate-for="warehouse"></div>
                    </div>
                    <div class="p-2 mt-4 w-1/3">
                        <div class="relative">
                            <label for="supplier" class="leading-5 text-base text-[#191D23] Inter-Regular">Nhà cung cấp <span class="text-[#DC2626]">*</span></label>
                            <div class="mt-1">
                                <select data-te-select-init data-te-select-filter="true" id="supplier" name="supplier">
                                    @foreach($supplierList as $item)
                                        <option {{((old('supplier') ?? $enterWarehouse->supplier_id) == $item->id) ? 'selected' : ''}} value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="text-[#ef4444] text-sm"  data-validate-for="supplier"></div>
                    </div>
                    <div class="p-2 mt-4 w-1/3">
                        <div class="relative">
                            <label for="purchase_date" class="leading-5 text-base text-[#191D23] Inter-Regular">Ngày mua hàng </label>
                            <div class="mt-1">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                        </svg>
                                    </div>
                                    <input datepicker type="text" datepicker-format="yyyy-mm-dd" required id="purchase_date" name="purchase_date" value="{{old('purchase_date') ?? $enterWarehouse->purchase_date}}" placeholder="yyyy-mm-dd" class="pl-10 w-full rounded border {{$errors->has('purchase_date') ? 'border-red-500' : 'border-gray-300'}} focus:outline-none text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                        </div>
                        <div class="text-[#ef4444] text-sm"  data-validate-for="purchase_date">{{ $errors->first('purchase_date') }}</div>
                    </div>
                    <div class="p-2 mt-4 w-1/3">
                        <div class="relative">
                            <label for="code_receipt" class="leading-5 text-base text-[#191D23] Inter-Regular">Mã phiếu nhập</label>
                            <input  type="text" id="code_receipt" name="code_receipt" value="{{old('code_receipt') ?? $enterWarehouse->code_receipt}}" placeholder="Mã phiếu nhập hàng" class="mt-1 w-full rounded border {{$errors->has('code_receipt') ? 'border-red-500' : 'border-gray-300'}} focus:outline-none text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="text-[#ef4444] text-sm"  data-validate-for="code_receipt">{{ $errors->first('code_receipt') }}</div>
                    </div>
                    <div class="p-2 mt-4 w-1/3">
                        <div class="relative">
                            <label for="shipment" class="leading-5 text-base text-[#191D23] Inter-Regular">Lô hàng</label>
                            <input  type="text" id="shipment" name="shipment" value="{{old('shipment') ?? $enterWarehouse->shipment}}" placeholder="Nhập lo hàng" class="mt-1 w-full rounded border {{$errors->has('shipment') ? 'border-red-500' : 'border-gray-300'}} focus:outline-none text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="text-[#ef4444] text-sm"  data-validate-for="code_receipt">{{ $errors->first('shipment') }}</div>
                    </div>
                    <div class="p-2 mt-4 w-1/3">
                        <div class="relative">
                            <label for="expired_date" class="leading-5 text-base text-[#191D23] Inter-Regular">Ngày hết hạn </label>
                            <div class="mt-1">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                        </svg>
                                    </div>
                                    <input datepicker type="text" datepicker-format="yyyy-mm-dd" id="expired_date" required name="expired_date" value="{{old('expired_date') ?? $enterWarehouse->expired_date}}" placeholder="yyyy-mm-dd" class="pl-10 w-full rounded border {{$errors->has('expired_date') ? 'border-red-500' : 'border-gray-300'}} focus:outline-none text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                        </div>
                        <div class="text-[#ef4444] text-sm"  data-validate-for="expired_date">{{ $errors->first('expired_date') }}</div>
                    </div>
                    <div class="p-2 mt-4 w-full">
                        <div class="relative">
                            <label for="note" class="leading-5 text-base text-[#191D23] Inter-Regular">Ghi chú</label><div style="margin-top: 5px"></div>
                            <div class="mt-1">
                                <textarea rows="2" id="note" name="note" placeholder="Ghi chú nhập kho" class="p-3 rounded w-full border">{{old('note') ?? $enterWarehouse->note}}</textarea>
                                <div class="text-[#ef4444] text-sm"  data-validate-for="note">{{ $errors->first('note') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl bg-white p-5 mx-5 mt-8">
                <div class="bg-red-50 rounded flex p-3 items-center">
                    <span class="ml-2 Inter-SemiBold text-[#CC0000] text-lg font-medium leading-[22px]">2. Thông tin sản phẩm</span>
                </div>
                <div class="flex flex-col items-center relative districts-address">
                    <div class="w-full">
                        <div class="selectOptionsProduct bg-white top-[100%] left-0 min-[420px] rounded ">
                            <div class="flex flex-col w-full mt-4">
                                <div class="relative mb-4 flex flex-wrap items-stretch search_zone">
                                            <span class="flex items-center whitespace-nowrap rounded-l border border-r-0 border-solid border-neutral-300 p-3 py-[0.25rem] text-center text-base font-normal leading-[1.6] text-neutral-700"
                                                  id="basic-addon2">
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_11464_16391)">
                                                    <path d="M10.3333 9.33333H9.80667L9.62 9.15333C10.2733 8.39333 10.6667 7.40667 10.6667 6.33333C10.6667 3.94 8.72667 2 6.33333 2C3.94 2 2 3.94 2 6.33333C2 8.72667 3.94 10.6667 6.33333 10.6667C7.40667 10.6667 8.39333 10.2733 9.15333 9.62L9.33333 9.80667V10.3333L12.6667 13.66L13.66 12.6667L10.3333 9.33333V9.33333ZM6.33333 9.33333C4.67333 9.33333 3.33333 7.99333 3.33333 6.33333C3.33333 4.67333 4.67333 3.33333 6.33333 3.33333C7.99333 3.33333 9.33333 4.67333 9.33333 6.33333C9.33333 7.99333 7.99333 9.33333 6.33333 9.33333Z" fill="#0D0F11"/>
                                                    </g>
                                                    <defs>
                                                    <clipPath id="clip0_11464_16391">
                                                    <rect width="16" height="16" fill="white"/>
                                                    </clipPath>
                                                    </defs>
                                                    </svg>
                                            </span>
                                    <input
                                        type="text"
                                        class="relative m-0 block min-h-[37px] min-w-0 flex-auto rounded-r border-l-0 border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 pl-0 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:text-neutral-700 focus:outline-none"
                                        placeholder="Nhập từ khóa để tìm kiếm theo mã - tên sản phẩm"
                                        aria-label="Nhập từ khóa để tìm kiếm theo mã - tên sản phẩm"
                                        aria-describedby="basic-addon2"
                                        id="search-product"
                                        autofocus
                                    />
                                    <label class="text-[#0D0F11] w-8 py-1 pl-2 pr-1 flex items-center rotate-180 cursor-pointer -ml-8">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up w-6 h-6">
                                            <polyline points="18 15 12 9 6 15"></polyline>
                                        </svg>
                                    </label>
                                </div>
                                <div id="list-option-product" class="flex flex-col w-full max-h-[300px] overflow-y-auto absolute bg-white z-50 mt-11 shadow">
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(old('product'))
                        <div class="w-full">
                            <?php
                            $product = old('product') ?? [];
                            ?>
                            <div class="table-title Inter-SemiBold text-xl leading-6 tracking-[-0.02em] my-4 total-product @if(!$product) hidden @endif">
                                @if($product)
                                    Hiện có <span><b>{{count($product)}}</b></span> sản phẩm
                                @endif
                            </div>
                            <div class="flex flex-col w-full mt-4 list-product-option">
                                @foreach($product as $id)
                                    <script>
                                        arrSelectProd.push('{{$id}}');
                                    </script>
                                    <div class="flex flex-wrap pt-4 pb-4 -mr-2 border-t product_item_{{$id}}">
                                        <div class="p-2" style="width: 28%">
                                            <div class="relative border-r">
                                                @if(old('prod_image_'.$id))
                                                    <img src="{{old('prod_image_'.$id)}}" width="80px" class="rounded float-left mr-2" style="margin-left: 10px">
                                                    <input type="hidden" value="{{old('prod_image_'.$id)}}" name="prod_image_{{$id}}">
                                                @endif
                                                <div class="float-left" style="display: contents;">
                                                    {{old('prod_name_'.$id)}} <br/>
                                                    <b>SKU</b>: {{old('prod_sku_'.$id)}} <br/>
                                                    @if(old('prod_prop_'.$id))
                                                        <b>Thuộc tính</b>: {{old('prod_prop_'.$id)}}
                                                    @endif
                                                </div>
                                                <input type="hidden" name="prod_name_{{$id}}" value="{{old('prod_name_'.$id) ?? ''}}">
                                                <input type="hidden" name="prod_sku_{{$id}}" value="{{old('prod_sku_'.$id) ?? ''}}">
                                                <input type="hidden" name="prod_prop_{{$id}}" value="{{old('prod_prop_'.$id) ?? ''}}">
                                            </div>
                                        </div>
                                        <div class="p-2" style="width: 18%">
                                            <div class="relative">
                                                <label for="cost_{{$id}}" class="leading-5 text-base text-[#191D23] Inter-Regular">
                                                    <span>Giá vốn</span> <span class="text-[#DC2626]">*</span>
                                                </label>
                                                <div class="relative flex flex-wrap items-stretch mt-1">
                                                    <input value="{{old('cost_'.$id)}}" id="cost_{{$id}}" name="cost_{{$id}}" type="text" class="number_price cost_{{$id}} relative m-0 block w-[1px] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-8 text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:text-neutral-700 focus:outline-none" placeholder="Nhập số tiền..." aria-label="Nhập số tiền..." aria-describedby="basic-addon2">
                                                    <span class="flex items-center whitespace-nowrap rounded-r border border-l-0 border-solid border-neutral-300 px-3 py-[0.25rem] text-center text-base font-normal leading-8 text-neutral-700 dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200">VNĐ</span>
                                                </div>
                                                <div class="text-[#ef4444] text-sm" data-validate-for="cost_{{$id}}"></div>
                                            </div>
                                        </div>
                                        <div class="p-2" style="width: 18%">
                                            <div class="relative">
                                                <label for="price_{{$id}}" class="leading-5 text-base text-[#191D23] Inter-Regular">
                                                    <span>Giá bán</span> <span class="text-[#DC2626]">*</span>
                                                </label>
                                                <div class="relative flex flex-wrap items-stretch mt-1">
                                                    <input value="{{old('price_'.$id)}}" id="price_{{$id}}" name="price_{{$id}}" type="text" class="number_price price_{{$id}} relative m-0 block w-[1px] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-8 text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:text-neutral-700 focus:outline-none" placeholder="Nhập số tiền..." aria-label="Nhập số tiền..." aria-describedby="basic-addon2">
                                                    <span class="flex items-center whitespace-nowrap rounded-r border border-l-0 border-solid border-neutral-300 px-3 py-[0.25rem] text-center text-base font-normal leading-8 text-neutral-700 dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200">VNĐ</span>
                                                </div>
                                                <div class="text-[#ef4444] text-sm" data-validate-for="price_{{$id}}"></div>
                                            </div>
                                        </div>
                                        <div class="p-2" style="width: 18%">
                                            <div class="relative" style="width: 85%; display: inline-block">
                                                <label for="price_floor_{{$id}}" class="leading-5 text-base text-[#191D23] Inter-Regular">
                                                    <span>Giá sàn</span>
                                                </label>
                                                <div class="relative flex flex-wrap items-stretch mt-1">
                                                    <input value="{{old('price_floor_'.$id)}}" id="price_floor_{{$id}}" name="price_floor_{{$id}}" type="text" class="number_price price_floor_{{$id}} relative m-0 block w-[1px] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-8 text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:text-neutral-700 focus:outline-none" placeholder="Nhập số tiền..." aria-label="Nhập số tiền..." aria-describedby="basic-addon2">
                                                    <span class="flex items-center whitespace-nowrap rounded-r border border-l-0 border-solid border-neutral-300 px-3 py-[0.25rem] text-center text-base font-normal leading-8 text-neutral-700 dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200">VNĐ</span>
                                                </div>
                                                <div class="text-[#ef4444] text-sm" data-validate-for="price_floor_{{$id}}"></div>
                                            </div>
                                        </div>
                                        <div class="p-2" style="width: 18%">
                                            <div class="relative" style="width: 85%; display: inline-block">
                                                <label for="count_{{$id}}" class="leading-5 text-base text-[#191D23] Inter-Regular">
                                                    <span>Số lượng</span> <span class="text-[#DC2626]">*</span>
                                                </label>
                                                <div class="relative flex flex-wrap items-stretch mt-1">
                                                    <input value="{{old('count_'.$id)}}" id="count_{{$id}}" name="count_{{$id}}" type="text" class="number_price count_{{$id}} relative m-0 block w-[1px] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-8 text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:text-neutral-700 focus:outline-none" placeholder="Nhập số lượng..." aria-label="Nhập số lượng..." aria-describedby="basic-addon2">
                                                </div>
                                                <div class="text-[#ef4444] text-sm" data-validate-for="count_{{$id}}"></div>
                                            </div>
                                            <button type="button" onclick="deleteProd('{{$id}}')" class="w-10 mt-5 h-11 Inter-SemiBold flex items-center rounded bg-red-50 pl-2 pt-[0.1rem] font-medium leading-normal text-[#A0ABBB] transition duration-150 ease-in-out hover:border-primary-accent-100 hover:bg-red-700 hover:bg-opacity-10 focus:border-primary-accent-100 focus:outline-none focus:ring-0 active:border-primary-accent-200 dark:text-primary-100 dark:hover:bg-neutral-100 dark:hover:bg-opacity-10" data-te-ripple-init="" style="display: inline-block; margin-top: 24px; margin-left: 10px; position: absolute; }">
                                                <img src="/assets/images/transh.png">
                                            </button>
                                            <input type="hidden" class="product_{{$id}}" name="product[]" value="{{$id}}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="w-full">
                            <?php
                            $productIds = old('product') ?? $productAbles->pluck('product_id')->toArray();
                            ?>
                            <div class="table-title Inter-SemiBold text-xl leading-6 tracking-[-0.02em] my-4 total-product @if(!$productIds) hidden @endif">
                                @if($productIds)
                                    Hiện có <span><b>{{count($productIds)}}</b></span> sản phẩm
                                @endif
                            </div>
                            <div class="flex flex-col w-full mt-4 list-product-option">
                                @foreach($productIds as $id)
                                    @php
                                        $product = $products->where('id', $id)->first();
                                        $productAble = $productAbles->where('product_id', $id)->first();
                                    @endphp
                                    <script>
                                        arrSelectProd.push('{{$id}}');
                                    </script>
                                    @include('ajax.product_detail', ['productAble' => $productAble, 'product' => $product])
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <input type="hidden" name="action_input" id="action_input">
            <div class="mt-10">
                <button
                    id="cancel_warehouse_form"
                    type="button"
                    class="mr-5 float-right Inter-SemiBold flex items-center inline-block rounded bg-[#E7EAEE] px-6 pb-2 pt-2.5 text-base font-semibold leading-normal text-dark shadow-[0_4px_9px_-4px_#e5e5e5]
         transition duration-150 ease-in-out hover:bg-[#E7EAEE] hover:shadow-[0_4px_18px_0_rgba(220,76,100,0.2)]
        focus:bg-[#E7EAEE] focus:outline-none
        focus:ring-0 active:bg-[#E7EAEE]">
                    <svg xmlns="http://www.w3.org/2000/svg" height="14" width="14" fill="dark" viewBox="0 0 384 512" style="margin-right: 5px"><path d="M376.6 84.5c11.3-13.6 9.5-33.8-4.1-45.1s-33.8-9.5-45.1 4.1L192 206 56.6 43.5C45.3 29.9 25.1 28.1 11.5 39.4S-3.9 70.9 7.4 84.5L150.3 256 7.4 427.5c-11.3 13.6-9.5 33.8 4.1 45.1s33.8 9.5 45.1-4.1L192 306 327.4 468.5c11.3 13.6 31.5 15.4 45.1 4.1s15.4-31.5 4.1-45.1L233.7 256 376.6 84.5z"/></svg>
                    Hủy phiếu
                </button>
                <button
                    id="create_warehouse_form"
                    type="button"
                    class="mx-5 float-right Inter-SemiBold flex items-center inline-block rounded bg-[#FF0000] px-6 pb-2 pt-2.5 text-base font-medium leading-normal text-white shadow-[0_4px_9px_-4px_#dc4c64]
        transition duration-150 ease-in-out hover:bg-[#FF0000] hover:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)]
        focus:bg-[#FF0000] focus:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] focus:outline-none
        focus:ring-0 active:bg-[#FF0000] active:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] ">
                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 448 512" fill="white" style="margin-right: 5px">
                        <path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/>
                    </svg>
                    Lưu nháp
                </button>
                <button
                    type="button"
                    id="enter_warehouse_form"
                    class="float-right Inter-SemiBold flex items-center inline-block rounded bg-[#19B88B] px-6 pb-2 pt-2.5 text-base font-medium leading-normal text-white Inter-Regular
        shadow-[0_4px_9px_-4px_#14a44d] transition duration-150 ease-in-out hover:bg-[#19B88B]
        hover:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.3),0_4px_18px_0_rgba(20,164,77,0.2)] focus:bg-[#19B88B] focus:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.3),0_4px_18px_0_rgba(20,164,77,0.2)]
        focus:outline-none focus:ring-0 active:bg-[#19B88B]">
                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 448 512" fill="white" style="margin-right: 5px">
                        <path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/>
                    </svg>
                    Tạo mới và nhập hàng
                </button>
                <div style="clear: both"></div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        function removeItemOnce(arr, value) {
            var index = arr.indexOf(value);
            if (index > -1) {
                arr.splice(index, 1);
            }
            return arr;
        }

        function removeItemAll(arr, value) {
            var i = 0;
            while (i < arr.length) {
                if (arr[i] == value) {
                    arr.splice(i, 1);
                } else {
                    ++i;
                }
            }
            return arr;
        }
        function deleteProd(id) {
            removeItemAll(arrSelectProd, id);
            $('.selectOption_'+id).removeClass('hidden');
            $('.product_item_'+id).remove();
            $('.total-product').html('Hiện có <span><b>' + arrSelectProd.length + '</b></span> sản phẩm')
            if(arrSelectProd.length == 0){
                $('.total-product').addClass('hidden')
            }
        }
        //setup before functions
        var typingTimer;                //timer identifier
        var doneTypingInterval = 1000;  //time in ms, 5 seconds for example
        var $input = $('#search-product');

        //on keyup, start the countdown
        $input.on('keyup', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        //on keydown, clear the countdown
        $input.on('keydown', function () {
            clearTimeout(typingTimer);
        });
        $input.on('click', function () {
            $("#list-option-product").removeClass('hidden');
        })
        //user is "finished typing," do something
        function doneTyping () {
            if ($input.val().length != 0) {
                $.ajax({
                    url: '/search-product',
                    data: {key: $input.val(), not_ids: arrSelectProd},
                    type: "post",
                    success: function (response) {
                        $("#list-option-product").empty().html(response);
                    }
                });
            }else{
                $("#list-option-product").empty().html('');
            }
            $("#list-option-product").removeClass('hidden');
        }
        $(document).on("click", function(event){
            var $trigger = $(".search_zone");
            if($trigger !== event.target && !$trigger.has(event.target).length){
                $("#list-option-product").addClass('hidden');
            }
        });
        // định dạng tiền input
        $('input.number_price').on('input', function(e){
            $(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
        }).on('keypress',function(e){
            if(!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
        }).on('paste', function(e){
            var cb = e.originalEvent.clipboardData || window.clipboardData;
            if(!$.isNumeric(cb.getData('text'))) e.preventDefault();
        });
        $(document).on('click',"#list-option-product div.selectOption", function(){
            var idProd = $(this).data('id');
            $(this).addClass('hidden');
            $.ajax({
                url: '/product-detail-search',
                data: {id: idProd},
                type: "post",
                success: function (response) {
                    arrSelectProd.push(idProd);
                    $(".list-product-option").append(response);
                    // $('.total-product').removeClass('hidden').html('Hiện có <span><b>' + arrSelectProd.length + '</b></span> sản phẩm');
                    // // định dạng tiền input
                    // $('input.number_price').on('input', function(e){
                    //     $(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
                    // }).on('keypress',function(e){
                    //     if(!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
                    // }).on('paste', function(e){
                    //     var cb = e.originalEvent.clipboardData || window.clipboardData;
                    //     if(!$.isNumeric(cb.getData('text'))) e.preventDefault();
                    // });
                }
            });
        });
        $('#create_warehouse_form').on('click', function () {
            $('#action_input').val('create');
            $('#frm-enterWarehouse').submit();
        });
        $('#cancel_warehouse_form').on('click', function () {
            $('#action_input').val('cancel');
            $('#frm-enterWarehouse').submit();
        });
        $('#enter_warehouse_form').on('click', function () {
            $('#action_input').val('enter');
            $('#frm-enterWarehouse').submit();
        });

        <?php
        $productIds = old('product') ?? $productIds;
        if($productIds) {
            foreach($productIds as $id) {
                if($errors->has('cost_'.$id)) {
                    ?>
                    $('.cost_{{$id}}').addClass('border-red-500');
                    $('div[data-validate-for="cost_{{$id}}"]').html('{{$errors->first('cost_'.$id)}}');
                    <?php
                }
                if($errors->has('price_'.$id)) {
                    ?>
                    $('.price_{{$id}}').addClass('border-red-500');
                    $('div[data-validate-for="price_{{$id}}"]').html('{{$errors->first('price_'.$id)}}');
                    <?php
                }
                if($errors->has('price_floor_'.$id)) {
                    ?>
                    $('.price_floor_{{$id}}').addClass('border-red-500');
                    $('div[data-validate-for="price_floor_{{$id}}"]').html('{{$errors->first('price_floor_'.$id)}}');
                    <?php
                }
                if($errors->has('count_'.$id)) {

                    ?>
                    $('.count_{{$id}}').addClass('border-red-500');
                    $('div[data-validate-for="count_{{$id}}"]').html('{{$errors->first('count_'.$id)}}');
                    <?php
                }
            }
        }
        ?>
    </script>
@endsection


