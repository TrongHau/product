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
                                <select disabled data-te-select-init data-te-select-filter="true" id="warehouse" name="warehouse">
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
                                <select disabled data-te-select-init data-te-select-filter="true" id="supplier" name="supplier">
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
                                    <input datepicker disabled type="text" datepicker-format="yyyy-mm-dd" required id="purchase_date" name="purchase_date" value="{{old('purchase_date') ?? $enterWarehouse->purchase_date}}" placeholder="yyyy-mm-dd" class="pl-10 w-full rounded border {{$errors->has('purchase_date') ? 'border-red-500' : 'border-gray-300'}} focus:outline-none text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                        </div>
                        <div class="text-[#ef4444] text-sm"  data-validate-for="purchase_date">{{ $errors->first('purchase_date') }}</div>
                    </div>
                    <div class="p-2 mt-4 w-1/3">
                        <div class="relative">
                            <label for="code_receipt" class="leading-5 text-base text-[#191D23] Inter-Regular">Mã phiếu nhập</label>
                            <input  type="text" disabled id="code_receipt" name="code_receipt" value="{{old('code_receipt') ?? $enterWarehouse->code_receipt}}" placeholder="Mã phiếu nhập hàng" class="mt-1 w-full rounded border {{$errors->has('code_receipt') ? 'border-red-500' : 'border-gray-300'}} focus:outline-none text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="text-[#ef4444] text-sm"  data-validate-for="code_receipt">{{ $errors->first('code_receipt') }}</div>
                    </div>
                    <div class="p-2 mt-4 w-1/3">
                        <div class="relative">
                            <label for="shipment" class="leading-5 text-base text-[#191D23] Inter-Regular">Lô hàng</label>
                            <input  type="text" disabled id="shipment" name="shipment" value="{{old('shipment') ?? $enterWarehouse->shipment}}" placeholder="Nhập lo hàng" class="mt-1 w-full rounded border {{$errors->has('shipment') ? 'border-red-500' : 'border-gray-300'}} focus:outline-none text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
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
                                    <input datepicker disabled type="text" datepicker-format="yyyy-mm-dd" id="expired_date" required name="expired_date" value="{{old('expired_date') ?? $enterWarehouse->expired_date}}" placeholder="yyyy-mm-dd" class="pl-10 w-full rounded border {{$errors->has('expired_date') ? 'border-red-500' : 'border-gray-300'}} focus:outline-none text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                        </div>
                        <div class="text-[#ef4444] text-sm"  data-validate-for="expired_date">{{ $errors->first('expired_date') }}</div>
                    </div>
                    <div class="p-2 mt-4 w-full">
                        <div class="relative">
                            <label for="note" class="leading-5 text-base text-[#191D23] Inter-Regular">Ghi chú</label><div style="margin-top: 5px"></div>
                            <div class="mt-1">
                                <textarea rows="2" id="note" disabled name="note" placeholder="Ghi chú nhập kho" class="p-3 rounded w-full border">{{old('note') ?? $enterWarehouse->note}}</textarea>
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
                                    @include('ajax.product_detail', ['productAble' => $productAble, 'product' => $product, 'action' => 'detail'])
                                @endforeach
                            </div>
                        </div>
                </div>
            </div>
            <input type="hidden" name="action_input" id="action_input">
            <div class="mt-10">
                <a
                    href="javascript:history.back()"
                    id="cancel_warehouse_form"
                    type="button"
                    class="mr-5 float-right Inter-SemiBold flex items-center inline-block rounded bg-[#E7EAEE] px-6 pb-2 pt-2.5 text-base font-semibold leading-normal text-dark shadow-[0_4px_9px_-4px_#e5e5e5]
         transition duration-150 ease-in-out hover:bg-[#E7EAEE] hover:shadow-[0_4px_18px_0_rgba(220,76,100,0.2)]
        focus:bg-[#E7EAEE] focus:outline-none
        focus:ring-0 active:bg-[#E7EAEE]">
                    Trở lại
                </a>
                <div style="clear: both"></div>
            </div>
        </form>
    </div>
@endsection



