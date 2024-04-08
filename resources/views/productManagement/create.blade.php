@extends('layout.app')

@section('template_title')
    J&T - Thêm mới sản phẩm
@endsection
@section('title_header')
    <div class="ml-5 mt-5 text-2xl font-semibold">
        Thêm sản phẩm
    </div>
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        input[type=text] {
            height: 44px;
        }
        #drop-area {
            border: 2px dashed #ffbcbc;
            padding: 20px;
            cursor: pointer;
            padding-top: 35px;
            width: 160px;
            text-align: center;
            height: 161px;
        }
        #drop-area.highlight {
            background: #fef2f2;
            color: red;
        }
        #gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: left;
            margin-left: -10px;
            margin-right: -10px;
        }
        .image-preview-add {
            position: relative;
            max-width: 200px;
            margin: 10px;
            border: 1px solid #ccc;
            padding: 5px;
            display: inline-block;
            cursor: pointer;
        }
        .image-preview {
            position: relative;
            max-width: 200px;
            margin: 10px;
            border: 1px solid #ccc;
            padding: 5px;
            display: inline-block;
            cursor: pointer;
        }
        .image_zone img {
            height: 150px;
            max-width: 100%;
        }
        .delete-button {
            position: absolute;
            top: -6px;
            right: -5px;
            background-color: #ebe8e8;
            color: red;
            font-weight: bold;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            cursor: pointer;
            justify-content: center;
            align-items: center;
            display: none;
        }
        .image-preview:hover .delete-button {
            display: block;
        }
        .hashtag-input {
            border: 1px solid #ccc;
            padding-left: 6px;
            border-radius: 4px;
            display: flex;
            align-items: center; /* Align items vertically */
        }

        .tag {
            background-color: #0079ED;
            color: white;
            padding: 5px;
            margin: 2px;
            border-radius: 3px;
            display: inline-block;
        }
        .fa-times {
            color: white;
        }

        .hashTagInput {
            border: none;
            outline: none;
            padding: 5px;
            flex-grow: 1; /* Take up remaining space */
            height: 42px!important;
        }
        .tag-text {
            margin-right: 5px;
        }

        .tag-remove {
            color: #888;
            cursor: pointer;
        }
        .image-box {
            margin: 10px;
            cursor: grab;
            user-drag: none;
            user-select: none;
            transition: transform 0.2s;
        }

        .image-box:active {
            cursor: grabbing;
        }
    </style>
@endsection

@section('content')
    <div class="breadcrumb">
        <nav class="bg-grey-light w-full rounded-md">
            <ol class="list-reset flex items-center">
                <li>
                    <a href="/product" style="display: flex" class="ml-5 transition duration-150 ease-in-out hover:text-primary-600 focus:text-primary-600
                        active:text-primary-700 dark:text-primary-400 dark:hover:text-primary-500 dark:focus:text-primary-500 dark:active:text-primary-600
                        Inter-SemiBold text-lg tracking-[-0.02em] text-[#000000]"> <img class="cursor-pointer mr-2 -mt-[2px] mb-[2px]" src="{{ '/assets/images/building-bank.png' }}" alt="">
                        Quản lý sản phẩm</a>
                </li>
                <li>
                    <svg class="mx-2 Inter-SemiBold text-lg tracking-[-0.02em] text-[#000000]" width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.589844 11.09L5.16984 6.5L0.589844 1.91L1.99984 0.5L7.99984 6.5L1.99984 12.5L0.589844 11.09Z" fill="#0D0F11"></path>
                    </svg>
                </li>
                <li class="Inter-SemiBold text-lg tracking-[-0.02em] text-[#F20000]">Thêm sản phẩm</li>
            </ol>
        </nav>
    </div>
    <div class="mt-4 py-4">
        <form class="" action="/create-product" method="POST" id="frm-product" data-request="onSubmitCreate" enctype="multipart/form-data">
            <div class="rounded-2xl bg-white p-5 mx-5">
                @if(session()->has('error'))
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        {!! session()->get('error') !!}
                    </div>
                @endif
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="bg-red-50 rounded flex p-3 items-center">
                    <span class="ml-2 Inter-SemiBold text-[#CC0000] text-lg font-medium leading-[22px]">1. Thông tin chung</span>
                </div>
                <div class="flex flex-wrap -ml-2 -mr-2">
                    <div class="p-2 mt-4 w-1/4">
                        <div class="relative">
                            <label for="name" class="leading-5 text-base text-[#191D23] Inter-Regular">Tên sản phẩm <span class="text-[#DC2626]">*</span></label>
                            <input  type="text" id="name" name="name" value="{{old('name')}}" placeholder="Nhập tên sản phẩm" class="mt-1 w-full rounded border {{$errors->has('name') ? 'border-red-500' : 'border-gray-300'}} focus:outline-none text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="text-[#ef4444] text-sm"  data-validate-for="name">{{ $errors->first('name') }}</div>
                    </div>
                    <div class="p-2 mt-4 w-1/4">
                        <div class="relative">
                            <div class="flex items-center gap-2">
                                <label for="sku" class="leading-5 text-base text-[#191D23] Inter-Regular">Mã sản phẩm SKU <span class="text-[#DC2626]">*</span></label>
                                <div class="icon help" style="display: inline-block;">
                                    <div class="tooltip p-2" style="left: -178px; top: -52px;">
                                        <p class="text-xs text-[#191d23]">Mã sản phẩm định danh không trùng lặp của shop riêng cho sản phẩm này</p>
                                    </div>
                                    <span><img class="cursor-pointer" src="{{ '/assets/images/help.svg' }}" alt=""></span>
                                </div>
                            </div>
                            <div class="relative flex flex-wrap items-stretch">
                                <input  type="text" id="sku" value="{{old('sku')}}" name="sku" placeholder="Nhập mã sản phẩm SKU" class="w-full rounded border {{$errors->has('sku') ? 'border-red-500' : 'border-gray-300'}} focus:outline-none text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                <div class="text-[#ef4444] text-sm"  data-validate-for="sku">{{ $errors->first('sku') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="p-2 mt-4 w-1/4">
                        <div class="relative">
                            <label for="status" class="leading-5 text-base text-[#191D23] Inter-Regular">Trạng thái <span class="text-[#DC2626]">*</span></label>
                            <div class="mt-1">
                                <select data-te-select-init id="status" class="mt-1" name="status">
                                    <option {{old('status') == null || old('status') == '1' ? 'selected' : '' }} value="1">Đang Hoạt động</option>
                                    <option {{old('status') == '0' ? 'selected' : '' }} value="0">Ngừng hoạt động</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-[#ef4444] text-sm" data-validate-for="status"></div>
                    </div>
                    <div class="p-2 mt-4 w-1/4">
                        <div class="relative">
                            <div class="flex items-center gap-2">
                                <label for="sku" class="leading-5 text-base text-[#191D23] Inter-Regular">Barcode</label>
                                <div class="icon help" style="display: inline-block;">
                                    <div class="tooltip p-3" style="left: -178px; top: -48px;">
                                        <p class="text-xs text-[#191d23]">Mã barcode được nhà sản xuất in trên sản phẩm</p>
                                    </div>
                                    <span><img class="cursor-pointer" src="{{ '/assets/images/help.svg' }}" alt=""></span>
                                </div>
                            </div>
                            <div class="relative flex flex-wrap items-stretch">
                                <input  type="text" id="barcode" value="{{old('barcode')}}" name="barcode" placeholder="Nhập Barcode" class=" w-full rounded border {{$errors->has('barcode') ? 'border-red-500' : 'border-gray-300'}} focus:outline-none text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                <div class="text-[#ef4444] text-sm"  data-validate-for="sku">{{ $errors->first('barcode') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap -ml-2 -mr-2">
                    <div class="p-2 mt-4 w-1/4">
                        <div class="relative">
                            <label for="weight" class="leading-5 text-base text-[#191D23] Inter-Regular">Khối lượng (kg) <span class="text-[#DC2626]">*</span></label>
                            <input  type="text" id="weight" name="weight" value="{{old('weight')}}" placeholder="Nhập khối lượng" class="mt-1 w-full rounded border {{$errors->has('weight') ? 'border-red-500' : 'border-gray-300'}} focus:outline-none text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="text-[#ef4444] text-sm"  data-validate-for="weight">{{ $errors->first('weight') }}</div>
                    </div>
                    <div class="p-2 mt-4 w-1/4">
                        <div class="relative">
                            <label for="unit" class="leading-5 text-base text-[#191D23] Inter-Regular">Đơn vị <span class="text-[#DC2626]">*</span></label>
                            <div class="mt-1">
                                <select data-te-select-init data-te-select-filter="true" id="unit" name="unit">
                                    <option value=" ">--Chọn--</option>
                                    @foreach($unitList as $key => $item)
                                        <option {{(old('unit') == $item->id) ? 'selected' : ''}}
                                                {{(old('name_unit_modal') != null && $key == 0) ? 'selected' : ''}}
                                                value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                    <option value="new_unit">
                                        + Thêm đơn vị mới
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="text-[#ef4444] text-sm"  data-validate-for="unit">{{ $errors->first('unit') }}</div>
                    </div>
                    <div class="p-2 mt-4 w-1/4">
                        <div class="relative">
                            <div class="flex items-center gap-2">
                                <label for="category" class="leading-5 text-base text-[#191D23] Inter-Regular">Danh mục <span class="text-[#DC2626]">*</span></label>
                                <div class="icon help" style="display: inline-block;">
                                    <div class="tooltip p-2" style="left: -178px; top: -58px;">
                                        <p class="text-xs text-[#191d23]">Xếp loại sản phẩm váo các nhóm danh mục chung, dễ dàng quản lý</p>
                                    </div>
                                    <span><img class="cursor-pointer" src="{{ '/assets/images/help.svg' }}" alt=""></span>
                                </div>
                            </div>
                            <select data-te-select-init data-te-select-filter="true" id="category" name="category">
                                <option value=" ">--Chọn--</option>
                                @foreach($categoryList as $key => $item)
                                    <option {{(old('category') == $item->id) ? 'selected' : ''}}
                                            {{(old('name_category_modal') != null && $key == 0) ? 'selected' : ''}}
                                            value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                                <option value="new_category">
                                    + Thêm danh mục mới
                                </option>
                            </select>
                            <div class="text-[#ef4444] text-sm"  data-validate-for="category">{{ $errors->first('category') }}</div>
                        </div>
                    </div>
                    <div class="p-2 mt-4 w-1/4">
                        <div class="relative">
                            <label for="branch" class="leading-5 text-base text-[#191D23] Inter-Regular">Thương hiệu</label>
                            <div class="mt-1">
                                <select data-te-select-init data-te-select-filter="true" id="branch" name="branch">
                                    <option value=" ">--Chọn--</option>
                                    @foreach($branchList as $key => $item)
                                        <option {{(old('branch') == $item->id) ? 'selected' : ''}}
                                                {{(old('name_branch_modal') != null && $key == 0) ? 'selected' : ''}}
                                                value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                    <option value="new_branch">
                                        + Thêm thương hiệu mới
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="text-[#ef4444] text-sm"  data-validate-for="branch">{{ $errors->first('branch') }}</div>
                    </div>
                </div>
                <div class="flex flex-wrap -ml-2 -mr-2">
                    <div class="p-2 mt-4 w-2/4">
                        <div class="relative">
                            <label for="branch" class="leading-5 text-base text-[#191D23] Inter-Regular">Mã chốt đơn</label>
                            <div class="hashtag-input mt-1">
                                <div class="tag-list" id="tagList_">
                                    <?php
                                    $tag_live_stream = old('tag_live_stream');
                                    if($tag_live_stream) {
                                    $tag_live_stream = explode('||', $tag_live_stream);
                                    foreach ($tag_live_stream as $item) {
                                    ?>
                                    <div class="tag"><span class="tag-text">{{$item}}</span><span class="tag-remove"><i class="fas fa-times"></i></span></div>
                                    <?php
                                    }
                                    }
                                    ?>
                                </div>
                                <input type="text" id="hashTagInput_" class="hashTagInput tag_key" placeholder="Nhập mã chốt đơn và đóng mã bằng nút enter hoặc tab" />
                                <input type="hidden" id="valTagInput_" value="{{old('tag_live_stream')}}" name="tag_live_stream" />
                            </div>
                        </div>
                        <div class="text-[#ef4444] text-sm"  data-validate-for="tag"></div>
                    </div>
                </div>
                <div class="mt-4 w-full">
                    <div class="relative">
                        <label for="content" class="leading-5 text-base text-[#191D23] Inter-Regular">Mô tả sản phẩm</label><div style="margin-top: 5px"></div>
                        <div class="mt-1">
                            <textarea name="content" class="bg-gray-500">{{old('content')}}</textarea>
                            <div class="text-[#ef4444] text-sm"  data-validate-for="content">{{ $errors->first('content') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl bg-white p-5 mx-5 mt-8">
                <div class="bg-red-50 rounded flex p-3 items-center flex-grow justify-between">
                    <span class="ml-2 Inter-SemiBold text-[#CC0000] text-lg font-medium leading-[22px]">2. Ảnh sản phẩm</span>
                    <div class="bg-white flex p-1 -mt-[5px] -mb-[5px] rounded-2xl text-red-500 delete_all_image hidden px-4 cursor-pointer font-medium">
                        <svg class="mr-2" width="18" height="23" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_10313_40706)">
                                <path d="M10.6693 6.5V13.1667H5.33594V6.5H10.6693ZM9.66927 2.5H6.33594L5.66927 3.16667H3.33594V4.5H12.6693V3.16667H10.3359L9.66927 2.5ZM12.0026 5.16667H4.0026V13.1667C4.0026 13.9 4.6026 14.5 5.33594 14.5H10.6693C11.4026 14.5 12.0026 13.9 12.0026 13.1667V5.16667Z" fill="Red"></path>
                            </g>
                            <defs>
                                <clipPath id="clip0_10313_40706">
                                    <rect width="16" height="16" fill="white" transform="translate(0 0.5)"></rect>
                                </clipPath>
                            </defs>
                        </svg>
                        Xóa tất cả</div>
                </div>
                <div class="image_zone flex flex-wrap mt-2">
                    <div id="gallery">
                        <div id="drop-area" class="highlight image-preview-add">
                            <p style="font-size: 50px">+</p>
                            <input type="file" id="file-input" multiple style="display: none;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl bg-white p-5 mx-5 mt-8">
                <div class="bg-red-50 rounded flex p-3 items-center">
                    <span class="ml-2 Inter-SemiBold text-[#CC0000] text-lg font-medium leading-[22px]">3. Giá sản phẩm</span>
                </div>
                <div class="flex flex-wrap items-center flex-grow justify-between gap-4">
                    <div class="p-2 mt-4" style="width: 40%;">
                        <div class="relative">
                            <label for="cost" class="leading-5 text-base text-[#191D23] Inter-Regular">
                                <span>Giá vốn</span> <span class="text-[#DC2626]">*</span>
                            </label>
                            <div class="relative flex flex-wrap items-stretch mt-1">
                                <input value="{{old('cost')}}" id="cost" name="cost" type="text" class="{{$errors->has('cost') ? 'border-red-500' : 'border-gray-300'}} relative m-0 block w-[1px] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-8 text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:text-neutral-700 focus:outline-none" placeholder="Nhập số tiền..." aria-label="Nhập số tiền..." aria-describedby="basic-addon2">
                                <span class="flex items-center whitespace-nowrap rounded-r border border-l-0 border-solid border-neutral-300 px-3 py-[0.25rem] text-center text-base font-normal leading-8 text-neutral-700 dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200">VNĐ</span>
                            </div>
                            <div class="text-[#ef4444] text-sm"  data-validate-for="cost">{{ $errors->first('cost') }}</div>
                        </div>
                    </div>
                    <div class="p-2 mt-4 w-1/7 flex text-center">
                        <div class="w-5 mt-2" style="border-top: 1px solid darkblue; "></div>
                    </div>
                    <div class="p-2 mt-4" style="width: 40%;">
                        <div class="relative">
                            <label for="price" class="leading-5 text-base text-[#191D23] Inter-Regular">
                                <span>Giá bán</span> <span class="text-[#DC2626]">*</span>
                            </label>
                            <div class="relative flex flex-wrap items-stretch mt-1">
                                <input value="{{old('price')}}" id="price" name="price" type="text" class="{{$errors->has('price') ? 'border-red-500' : 'border-gray-300'}} relative m-0 block w-[1px] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-8 text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:text-neutral-700 focus:outline-none" placeholder="Nhập số tiền..." aria-label="Nhập số tiền..." aria-describedby="basic-addon2">
                                <span class="flex items-center whitespace-nowrap rounded-r border border-l-0 border-solid border-neutral-300 px-3 py-[0.25rem] text-center text-base font-normal leading-8 text-neutral-700 dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200">VNĐ</span>
                            </div>
                            <div class="text-[#ef4444] text-sm"  data-validate-for="cost">{{ $errors->first('price') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl bg-white p-5 mx-5 mt-8">
                <div class="bg-red-50 rounded flex p-3 items-center">
                    <span class="ml-2 Inter-SemiBold text-[#CC0000] text-lg font-medium leading-[22px]">4. Thuộc tính</span>
                    <div class="icon help ml-3" style="display: inline-block;">
                        <div class="tooltip p-3" style="left: -178px; top: -65px;">
                            <p class="text-xs text-[#191d23]">"Tạo các thuộc tính để phân biệt các phiên bản (biến thể) khác nhau của sản phẩm. Ví dụ: Kích thước, Màu sắc, Chất liệu,..."</p>
                        </div>
                        <span><img class="cursor-pointer" src="{{ '/assets/images/help.svg' }}" alt=""></span>
                    </div>
                </div>
                <input type="hidden" id="count_properties" name="count_properties" value="0">
                <div class="flex flex-wrap -ml-2 -mr-2" id="zone_properties">

                </div>
                <button type="button" id="create_properties" data-te-ripple-color="light" class="mt-3 -ml-3 Inter-Regular text-base leading-5 text-[#0079ED] h-10f px-[16px] py-[8px] flex items-center rounded  text-[#007FF9] transition duration-150 ease-in-out hover:border-[#007FF9] hover:bg-white hover:bg-opacity-10 hover:text-[#007FF9] focus:border-[#007FF9] focus:text-[#007FF9] focus:outline-none focus:ring-0 active:border-[#007FF9] active:text-[#007FF9]" data-te-ripple-init="" style="">
                    <svg class="mr-3" width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 8.5H8V14.5H6V8.5H0V6.5H6V0.5H8V6.5H14V8.5Z" fill="#0079ED"></path>
                    </svg>
                    Thêm thuộc tính mới
                </button>
                <div style="clear: both; height: 1.5px; background: #ffa1a1; margin-top: 30px;" class="hr-properties hidden"></div>
                <input type="hidden" id="count_properties_prod" name="count_properties_prod" value="0">
                <div class="w-full" id="zone_properties_prod">
                </div>
            </div>
            <div class="mt-10">
                <button
                    id="submit_form"
                    type="submit"
                    data-value="product"
                    class="submit_form mx-5 float-right Inter-SemiBold flex items-center inline-block rounded bg-[#FF0000] px-6 pb-2 pt-2.5 text-base font-medium leading-normal text-white shadow-[0_4px_9px_-4px_#dc4c64]
        transition duration-150 ease-in-out hover:bg-[#FF0000] hover:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)]
        focus:bg-[#FF0000] focus:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] focus:outline-none
        focus:ring-0 active:bg-[#FF0000] active:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] ">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512" style="margin-right: 10px">
                        <path fill="white" d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>
                    Lưu sản phẩm
                </button>
                <button
                    type="button"
                    id="reset-form"
                    class="float-right Inter-SemiBold flex items-center inline-block rounded bg-[#19B88B] px-6 pb-2 pt-2.5 text-base font-medium leading-normal text-white Inter-Regular
        shadow-[0_4px_9px_-4px_#14a44d] transition duration-150 ease-in-out hover:bg-[#19B88B]
        hover:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.3),0_4px_18px_0_rgba(20,164,77,0.2)] focus:bg-[#19B88B] focus:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.3),0_4px_18px_0_rgba(20,164,77,0.2)]
        focus:outline-none focus:ring-0 active:bg-[#19B88B]">
                    <svg class="mr-2" width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_10818_7527)">
                            <path d="M11.7667 4.73329C10.8 3.76663 9.47334 3.16663 8.00001 3.16663C5.05334 3.16663 2.67334 5.55329 2.67334 8.49996C2.67334 11.4466 5.05334 13.8333 8.00001 13.8333C10.4867 13.8333 12.56 12.1333 13.1533 9.83329H11.7667C11.22 11.3866 9.74001 12.5 8.00001 12.5C5.79334 12.5 4.00001 10.7066 4.00001 8.49996C4.00001 6.29329 5.79334 4.49996 8.00001 4.49996C9.10667 4.49996 10.0933 4.95996 10.8133 5.68663L8.66667 7.83329H13.3333V3.16663L11.7667 4.73329Z" fill="white"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_10818_7527">
                                <rect width="16" height="16" fill="white" transform="translate(0 0.5)"/>
                            </clipPath>
                        </defs>
                    </svg>

                    Làm mới
                </button>
                <div style="clear: both"></div>
            </div>
            <div
                data-te-modal-init
                class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
                id="createBranchModal"
                data-te-backdrop="static"
                data-te-keyboard="false"
                tabindex="-1"
                aria-labelledby="createBranchModal"
                aria-modal="true"
                role="dialog">
                <div
                    data-te-modal-dialog-ref
                    class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px]">
                    <div class="min-[576px]:shadow-[0_0.5rem_1rem_rgba(#000, 0.15)] pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
                        <div class="relative p-4 text-center bg-white rounded-lg  dark:bg-gray-800 sm:p-5">
                            <button data-te-modal-dismiss onclick="closeBranch()" type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <div class="p-5">
                                <label for="name" class="leading-5 text-base text-[#191D23] Inter-Regular">Thêm mới thương hiệu</label>
                                <input  type="text" name="name_branch_modal" value="" maxlength="100" placeholder="Nhập tên thương hiệu" class="mt-5 w-full rounded border focus:outline-none text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>
                            <div class="flex justify-center items-center space-x-4">
                                <button onclick="closeBranch()" data-te-modal-dismiss type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                    Đóng
                                </button>
                                <button type="submit" data-value="branch" class="submit_form py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                    Thêm mới thương hiệu
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div
                data-te-modal-init
                class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
                id="createUnitModal"
                data-te-backdrop="static"
                data-te-keyboard="false"
                tabindex="-1"
                aria-labelledby="createUnitModal"
                aria-modal="true"
                role="dialog">
                <div
                    data-te-modal-dialog-ref
                    class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px]">
                    <div class="min-[576px]:shadow-[0_0.5rem_1rem_rgba(#000, 0.15)] pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
                        <div class="relative p-4 text-center bg-white rounded-lg  dark:bg-gray-800 sm:p-5">
                            <button onclick="closeUnit()" data-te-modal-dismiss type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <div class="p-5">
                                <label for="name" class="leading-5 text-base text-[#191D23] Inter-Regular">Thêm mới đơn vị</label>
                                <input  type="text" name="name_unit_modal" value="" maxlength="100" placeholder="Nhập tên đơn vị" class="mt-5 w-full rounded border focus:outline-none text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>
                            <div class="flex justify-center items-center space-x-4">
                                <button onclick="closeUnit()" data-te-modal-dismiss type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                    Đóng
                                </button>
                                <button type="submit" data-value="unit" class="submit_form py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                    Thêm mới đơn vị
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div
                data-te-modal-init
                class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
                id="createCategoryModal"
                data-te-backdrop="static"
                data-te-keyboard="false"
                tabindex="-1"
                aria-labelledby="createCategoryModal"
                aria-modal="true"
                role="dialog">
                <div
                    data-te-modal-dialog-ref
                    class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px]">
                    <div class="min-[576px]:shadow-[0_0.5rem_1rem_rgba(#000, 0.15)] pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
                        <div class="relative p-4 text-center bg-white rounded-lg  dark:bg-gray-800 sm:p-5">
                            <button data-te-modal-dismiss onclick="closeCategory()" type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <div class="p-5">
                                <label for="name" class="leading-5 text-base text-[#191D23] Inter-Regular">Thêm mới danh mục</label>
                                <input  type="text" name="name_category_modal" value="" maxlength="100" placeholder="Nhập tên danh mục" class="mt-5 w-full rounded border focus:outline-none text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>
                            <div class="flex justify-center items-center space-x-4">
                                <button onclick="closeCategory()" data-te-modal-dismiss type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                    Đóng
                                </button>
                                <button type="submit" data-value="category" class="submit_form py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                    Thêm mới danh mục
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="actionModal" name="action" value="product">
        </form>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

    </div>
    <div
        data-te-modal-init
        class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
        id="imageModal"
        tabindex="-1"
        aria-labelledby="imageModal"
        aria-hidden="true">
        <div
            data-te-modal-dialog-ref
            class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[1000px]">
            <div class="min-[576px]:shadow-[0_0.5rem_1rem_rgba(#000, 0.15)] pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
                <img id="modalImage" class="modal-content">
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('content');
    </script>
    <script>
        $('#branch, #category, #unit').on('change', function () {
            if($(this).val() == 'new_branch') {
                $('#createBranchModal').modal('show');
            }
            if($(this).val() == 'new_unit') {
                $('#createUnitModal').modal('show');
            }
            if($(this).val() == 'new_category') {
                $('#createCategoryModal').modal('show');
            }
        })

        const dropArea = document.getElementById('drop-area');
        const fileInput = document.getElementById('file-input');
        const gallery = document.getElementById('gallery');

        var droppedFiles = [];

        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });

        // Highlight drop area when file is dragged over
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });

        // Remove highlight when file is dragged out
        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });

        // Handle dropped files
        dropArea.addEventListener('drop', handleDrop, false);

        // Open file dialog when drop area is clicked
        dropArea.addEventListener('click', () => {
            fileInput.click();
        });

        // Handle file selection from file input
        fileInput.addEventListener('change', handleFiles, false);


        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        function highlight() {
            dropArea.classList.add('highlight');
        }

        function unhighlight() {
            dropArea.classList.remove('highlight');
        }

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;

            droppedFiles.push(...files);
            updateGallery();



        }

        function handleFiles(e) {
            const files = e.target.files;

            droppedFiles.push(...files);
            updateGallery();

        }

        function updateGallery() {
            // gallery.innerHTML = '';
            $('.image-preview').remove();
            const formData = document.getElementById('frm-product');
            $('.frm-input-image').remove(); // Clear all input image into the form
            $('')
            if(droppedFiles.length > 0) {
                $('.delete_all_image').removeClass('hidden')
            }else{
                $('.delete_all_image').addClass('hidden')
            }
            for (const file of droppedFiles) {
                if (file.type.startsWith('image/')) {
                    const img = document.createElement('img');
                    var base64Url = '';
                    const fileInput = document.createElement('input');
                    fileInput.type = 'hidden';
                    fileInput.className = 'frm-input-image';
                    fileInput.name = 'uploaded_files[]';


                    if(file.lastModified === undefined) {
                        base64Url = file.src;
                        fileInput.value = file.src;
                    }else{
                        base64Url = URL.createObjectURL(file);
                        const reader = new FileReader();
                        reader.onload = function () {
                            const dataURL = reader.result;
                            fileInput.value = dataURL;
                        };
                        reader.readAsDataURL(file);
                    }
                    img.src = base64Url;




                    formData.appendChild(fileInput);



                    const imagePreview = document.createElement('div');
                    imagePreview.classList.add('image-preview', 'image-box');
                    imagePreview.appendChild(img);

                    const deleteButton = document.createElement('button');
                    deleteButton.classList.add('delete-button');
                    deleteButton.textContent = 'X';
                    deleteButton.addEventListener('click', () => {
                        deleteImage(file);
                    });

                    imagePreview.appendChild(deleteButton);

                    gallery.appendChild(imagePreview);
                }
            }
        }

        function deleteImage(fileToDelete) {
            const index = droppedFiles.indexOf(fileToDelete);
            if (index !== -1) {
                droppedFiles.splice(index, 1);
                updateGallery();
            }
        }
        function addImageUrl(imageUrl) {
            if (imageUrl) {
                // Add the URL image to the droppedFiles array
                droppedFiles.push({
                    type: 'image/url',
                    src: imageUrl
                });
                updateGallery();
            }
        }
        $('.delete_all_image').on('click', function () {
            droppedFiles = [];
            updateGallery();
        });




        const imageGallery = document.getElementById('gallery');
        let activeImage = null;

        // Add event listeners to enable drag-and-drop
        imageGallery.addEventListener('dragstart', (e) => {
            activeImage = e.target.closest('.image-box');
            activeImage.style.opacity = '0.5';
        });

        imageGallery.addEventListener('dragover', (e) => {
            e.preventDefault();
        });

        imageGallery.addEventListener('drop', (e) => {
            if (activeImage) {
                e.preventDefault();
                const targetImage = e.target.closest('.image-box');
                if (targetImage && targetImage !== activeImage) {
                    // Swap the positions of the active image and the target image
                    const temp = document.createElement('div');
                    targetImage.parentNode.insertBefore(temp, targetImage);
                    activeImage.parentNode.insertBefore(targetImage, activeImage);
                    temp.parentNode.insertBefore(activeImage, temp);
                    temp.parentNode.removeChild(temp);
                }
                activeImage.style.opacity = '1';
                activeImage = null;

                // Update the droppedFiles array to reflect the new order
                const imageElements = Array.from(imageGallery.querySelectorAll('.image-box img'));
                droppedFiles.length = 0; // Clear the array
                imageElements.forEach((img) => {
                    const src = img.getAttribute('src');
                    droppedFiles.push({
                        type: 'image/url',
                        src: src
                    });
                });
                updateGallery();
            }
        });




        <?php
        $uploaded_files = old('uploaded_files');
        if($uploaded_files) {
            foreach ($uploaded_files as $item) {
                ?>
                addImageUrl('{{$item}}')
                <?php
            }
        }
        ?>


        $('.delete-button').on('click', function () {
            var srcDelete = $(this).parent().find('img').attr('src');
            const index = droppedFiles.indexOf(srcDelete);
            console.log(index);

            if (index !== -1) {
                droppedFiles.splice(index, 1);
                updateGallery();
            }
            return false;
        })
        const imageModal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        const modalClose = document.getElementsByClassName('close')[0];

        gallery.addEventListener('click', openModal);

        // modalClose.addEventListener('click', closeModal);

        function openModal(event) {
            if (event.target.tagName === 'IMG') {
                const imageUrl = event.target.src;
                modalImage.src = imageUrl;
                $("#imageModal").modal('show');
            }
        }

        function closeModal() {
            imageModal.style.display = 'none';
        }

        window.addEventListener('click', (event) => {
            if (event.target === imageModal) {
                closeModal();
            }
        });
        // hashtag
        function setupTagInput(hashtagInputId, tagListId, hiddenInputId) {
            const hashtagInput = document.getElementById(hashtagInputId);
            const tagList = document.getElementById(tagListId);
            const hiddenInput = document.getElementById(hiddenInputId);

            hashtagInput.addEventListener('keydown', function(event) {
                if (event.key === 'Enter' || event.keyCode  === 9) {
                    const tagValue = hashtagInput.value.trim();
                    if (tagValue !== '') {
                        addTag(tagValue.replace(':', '').replace('|', ''));
                    }
                }
            });
            function addTag(tagValue) {
                const tagElement = document.createElement('div');
                tagElement.classList.add('tag');

                const tagText = document.createElement('span');
                tagText.classList.add('tag-text');
                tagText.textContent = tagValue;
                tagElement.appendChild(tagText);

                const tagRemove = document.createElement('span');
                tagRemove.classList.add('tag-remove');
                tagRemove.innerHTML = '<i class="fas fa-times"></i>';
                tagRemove.addEventListener('click', () => removeTag(tagValue, tagElement, hiddenInput, tagList));
                tagElement.appendChild(tagRemove);

                tagList.appendChild(tagElement);

                // Clear input
                hashtagInput.value = '';

                // Update hidden input value
                updateHiddenInput();
            }
            function updateHiddenInput() {
                const allTags = Array.from(tagList.querySelectorAll('.tag-text')).map(tagText => tagText.textContent);
                hiddenInput.value = allTags.join('||');
                if(hiddenInput.className == 'properties_value')
                    changePropertiesProd();
            }
        }

        function removeTag(tagValue, tagElement, hiddenInput, tagList) {
            const tagsArray = hiddenInput.value.split('||');
            const updatedTags = tagsArray.filter(tag => tag !== tagValue);

            // Update hidden input value and tag list
            hiddenInput.value = updatedTags.join('||');
            tagList.removeChild(tagElement);
            if(hiddenInput.className == 'properties_value')
                changePropertiesProd();
        }

        setupTagInput('hashTagInput_', 'tagList_', 'valTagInput_'); // mã chốt đơn

        // tạo thuộc tính
        $('#create_properties').on('click', function () {
            createProperties();
        })
        function createProperties(nameProp = '', valProp = '', required = false) {
            var tagList = '';
            var nameProp_error = '';
            var valProp_error = '';
            var class_nameProp_error = 'border-gray-300';
            var class_valProp_error = 'border-gray-300';
            if(valProp) {
                const valPropArray = valProp.split('||');
                valPropArray.forEach(function (index) {
                    tagList = tagList + '<div class="tag"><span class="tag-text">' + index + '</span><span class="tag-remove"><i class="fas fa-times"></i></span></div>\n';
                });
            }
            if(required) {
                if(!nameProp){
                    nameProp_error = 'Vui lòng nhập tên thuộc tính';
                    class_nameProp_error = 'border-red-500';
                }
                if(!valProp) {
                    valProp_error = 'Vui lòng nhập giá trị thuộc tính';
                    class_valProp_error = 'border-red-500';
                }
            }
            let count = $('#count_properties').val();
            count = parseFloat(count) + 1;
            const newProperties = '<div class="w-full flex"><div class="p-2 mt-4 w-1/3">\n' +
                '                    <div class="relative">\n' +
                '                        <label for="name" class="leading-5 text-base text-[#191D23] Inter-Regular">Tên thuộc tính <span class="text-[#DC2626]">*</span></label>\n' +
                '                        <input  type="text" value="' + nameProp + '" id="properties' + count + '" name="properties[]" data-count="' + count + '" placeholder="Nhập tên thuộc tính mới" class="tag_key properties_name w-full rounded border ' + class_nameProp_error + ' focus:outline-none text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">\n' +
                '                    </div>\n' +
                '                    <div class="text-[#ef4444] text-sm"  data-validate-for="properties">' + nameProp_error + '</div>\n' +
                '                </div>\n' +
                '                <div class="p-2 mt-4 w-3/4">\n' +
                '                    <div class="relative">\n' +
                '                        <label for="name" class="leading-5 text-base text-[#191D23] Inter-Regular">Giá trị <span class="text-[#DC2626]">*</span></label>\n' +
                '                         <div class="hashtag-input ' + class_valProp_error + '">\n' +
                '                            <div class="tag-list" id="tagList' + count + '">'+tagList+'</div>\n' +
                '                            <input type="text" id="hashTagInput' + count + '" class="hashTagInput tag_key" placeholder="Nhập giá trị thuộc tính và đóng giá trị bằng nút enter hoặc tab" />\n' +
                '                            <input type="hidden" id="valTagInput' + count + '" value="' + valProp + '" class="properties_value" name="properties_value[]" /></div>\n' +
                '                    </div>\n' +
                '                    <div class="text-[#ef4444] text-sm"  data-validate-for="properties_value">' + valProp_error + '</div>\n' +
                '                </div>\n' +
                '                <div class="p-2 mt-4 w-1/7">\n' +
                '                    <div class="relative">\n' +
                '                        <button type="button" onclick="deleteProp(this)" class=" w-10 mt-5 h-11 Inter-SemiBold flex items-center rounded bg-red-50 pl-2 pt-[0.1rem] font-medium leading-normal text-[#A0ABBB] transition duration-150 ease-in-out hover:border-primary-accent-100 hover:bg-red-700 hover:bg-opacity-10 focus:border-primary-accent-100 focus:outline-none focus:ring-0 active:border-primary-accent-200 dark:text-primary-100 dark:hover:bg-neutral-100 dark:hover:bg-opacity-10" data-te-ripple-init="">\n' +
                '                          <img src="/assets/images/transh.png"/>\n' +
                '                        </button>\n' +
                '                    </div>\n' +
                '                </div></div>';
            $('#count_properties').val(count);
            $('#zone_properties').append(newProperties);
            // changePropertiesProd('#valTagInput' + count + '');
            setupTagInput('hashTagInput' + count, 'tagList' + count, 'valTagInput' + count);
            if($('#zone_properties .properties_value').length >= 3) {
                $('#create_properties').addClass('hidden');
            }
            setupInput();
        }
        function deleteProp(prop) {
            $(prop).parent().parent().parent().remove();
            changePropertiesProd();
            $('#create_properties').removeClass('hidden');
            if($('#zone_properties .properties_value').length == 0) {
                $('.hr-properties').addClass('hidden');
            }
        }
        function deleteProp_zone(prop) {
            // var count = $('#count_properties_prod').val();
            // count = parseFloat(count) - 1;
            // $('#count_properties_prod').val(count);
            $(prop).parent().parent().remove();
            if($('#zone_properties_prod .properties_prod').length == 0) {
                $('.hr-properties').addClass('hidden');
            }
        }
        // định dạng tiền input
        $('input#cost, input#price').on('input', function(e){
            $(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
        }).on('keypress',function(e){
            if(!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
        }).on('paste', function(e){
            var cb = e.originalEvent.clipboardData || window.clipboardData;
            if(!$.isNumeric(cb.getData('text'))) e.preventDefault();
        });
        // tạo các trường biến thể
        function addPropertiesProd(name_input, count) {
            let sku = $('#sku').val();
            let barcode = $('#barcode').val();
            let cost = $('#cost').val();
            let price = $('#price').val();
            const newPropertiesProd = '<div class="flex flex-wrap -ml-2 -mr-2 properties_prod_'+count+'">\n' +
                '                    <div class="p-2 mt-4 w-1/5">\n' +
                '                        <div class="relative">\n' +
                '                            <label for="properties_prod_name_' + count + '" class="leading-5 text-base text-[#191D23] Inter-Regular">Tên sản phẩm biến thể <span class="text-[#DC2626]">*</span></label>\n' +
                '                            <input value="' + name_input + '" type="text" id="properties_prod_name_' + count + '" name="properties_prod_name_' + count + '" placeholder="Nhập tên sản phẩm biến thể" class="mt-1 properties_prod_name_' + count + ' properties_prod w-full rounded border border-gray-300 focus:outline-none text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">\n' +
                '                        </div>\n' +
                '                        <div class="text-[#ef4444] text-sm"  data-validate-for="properties_prod_name_' + count + '"></div>\n' +
                '                    </div>\n' +
                '                    <div class="p-2 mt-4 w-1/5">\n' +
                '                        <div class="relative">\n' +
                '                            <label for="properties_prod_sku_' + count + '" class="leading-5 text-base text-[#191D23] Inter-Regular">Mã sản phẩm SKU <span class="text-[#DC2626]">*</span></label>\n' +
                '                            <input value="' + sku + '_' + count + '" type="text" id="properties_prod_sku_' + count + '" name="properties_prod_sku_' + count + '" placeholder="Nhập mã SKU biến thể" class="mt-1 properties_prod_sku_' + count + ' w-full rounded border border-gray-300 focus:outline-none text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">\n' +
                '                        </div>\n' +
                '                        <div class="text-[#ef4444] text-sm"  data-validate-for="properties_prod_sku_' + count + '"></div>\n' +
                '                    </div>\n' +
                '                    <div class="p-2 mt-4 w-1/5">\n' +
                '                        <div class="relative">\n' +
                '                            <label for="properties_prod_barcode_' + count + '" class="leading-5 text-base text-[#191D23] Inter-Regular">Barcode</label>\n' +
                '                            <input value="' + barcode + '" id="properties_prod_barcode_' + count + '"  type="text" name="properties_prod_barcode_' + count + '" placeholder="Nhập Barcode biến thể" class="mt-1 properties_prod_barcode_' + count + ' w-full rounded border border-gray-300 focus:outline-none text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">\n' +
                '                        </div>\n' +
                '                        <div class="text-[#ef4444] text-sm"  data-validate-for="properties_prod_barcode_' + count + '"></div>\n' +
                '                    </div>\n' +
                '                    <div class="p-2 mt-4" style="width: 18%">\n' +
                '                        <div class="relative">\n' +
                '                            <label for="properties_prod_cost_' + count + '" class="leading-5 text-base text-[#191D23] Inter-Regular">\n' +
                '                                <span>Giá vốn</span> <span class="text-[#DC2626]">*</span>\n' +
                '                            </label>\n' +
                '                            <div class="relative flex flex-wrap items-stretch mt-1">\n' +
                '                                <input value="' + cost + '" id="properties_prod_cost_' + count + '" name="properties_prod_cost_' + count + '" type="text" class="properties_prod_cost_' + count + ' relative m-0 block w-[1px] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-8 text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:text-neutral-700 focus:outline-none" placeholder="Nhập số tiền..." aria-label="Nhập số tiền..." aria-describedby="basic-addon2">\n' +
                '                                <span class="flex items-center whitespace-nowrap rounded-r border border-l-0 border-solid border-neutral-300 px-3 py-[0.25rem] text-center text-base font-normal leading-8 text-neutral-700 dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200">VNĐ</span>\n' +
                '                            </div>\n' +
                '                            <div class="text-[#ef4444] text-sm"  data-validate-for="properties_prod_cost_' + count + '"></div>\n' +
                '                        </div>\n' +
                '                    </div>\n' +
                '                    <div class="p-2 mt-4" style="width: 22%">\n' +
                '                        <div class="relative" style="width: 85%; display: inline-block">\n' +
                '                            <label for="properties_prod_price_' + count + '" class="leading-5 text-base text-[#191D23] Inter-Regular">\n' +
                '                                <span>Giá bán</span> <span class="text-[#DC2626]">*</span>\n' +
                '                            </label>\n' +
                '                            <div class="relative flex flex-wrap items-stretch mt-1">\n' +
                '                                <input value="' + price + '" id="properties_prod_price_' + count + '" name="properties_prod_price_' + count + '" type="text" class="properties_prod_price_' + count + ' relative m-0 block w-[1px] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-8 text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:text-neutral-700 focus:outline-none" placeholder="Nhập số tiền..." aria-label="Nhập số tiền..." aria-describedby="basic-addon2">\n' +
                '                                <span class="flex items-center whitespace-nowrap rounded-r border border-l-0 border-solid border-neutral-300 px-3 py-[0.25rem] text-center text-base font-normal leading-8 text-neutral-700 dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200">VNĐ</span>\n' +
                '                            </div>\n' +
                '                            <div class="text-[#ef4444] text-sm"  data-validate-for="properties_prod_price_' + count + '"></div>\n' +
                '                        </div>\n' +
                '                        <button type="button" onclick="deleteProp_zone(this)" class="w-10 mt-5 h-11 Inter-SemiBold flex items-center rounded bg-red-50 pl-2 pt-[0.1rem] font-medium leading-normal text-[#A0ABBB] transition duration-150 ease-in-out hover:border-primary-accent-100 hover:bg-red-700 hover:bg-opacity-10 focus:border-primary-accent-100 focus:outline-none focus:ring-0 active:border-primary-accent-200 dark:text-primary-100 dark:hover:bg-neutral-100 dark:hover:bg-opacity-10" data-te-ripple-init="" style="display: inline-block; margin-top: 24px; margin-left: 10px; position: absolute; }">\n' +
                '                          <img src="/assets/images/transh.png"/>\n' +
                '                        </button>\n' +
                '                    </div>\n' +
                '                </div>';
            $('#zone_properties_prod').append(newPropertiesProd);
            $('#count_properties_prod').val(count);
            $('#properties_prod_cost_' + count + ', #properties_prod_price_' + count + '').on('input', function(e){
                $(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
            }).on('keypress',function(e){
                if(!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
            }).on('paste', function(e){
                var cb = e.originalEvent.clipboardData || window.clipboardData;
                if(!$.isNumeric(cb.getData('text'))) e.preventDefault();
            });
            setupInput();
        }

        // thay đổi biến thể
        function changePropertiesProd() {
            $('#zone_properties_prod').html('');
            let name = $('#name').val();
            const prop_count = [];
            const prop_name = [];
            const prop = [];
            $( ".properties_name" ).each(function( index ) {
                if($( this ).val()) {
                    prop_name[index] = $( this ).val();
                    prop_count[index] = $( this ).data('count');
                }
            });
            $( ".properties_value" ).each(function( index ) {
                if($( this ).val()) {
                    prop[index] = $( this ).val().split("||");
                }
            });
            if(prop.length > 0 && name) {
                $('.hr-properties').removeClass('hidden');
                $('#zone_properties_prod').html('');
                let prop_index_1 = prop[0];
                let prop_index_2 = [];
                let prop_key_result = [];
                let prod_name_result = [];
                if(prop.length > 1) {
                    prop_index_2 = prop.slice(1)
                }
                let key = 0;
                prop_index_1.forEach(function( index_1, key_1 ) {
                    if(prop_index_2.length > 0) {
                        let prop_key_array = [];
                        let prod_name_array = [];
                        let prop_key = prop_count[key];
                        let prod_name = name + ' ' + index_1;
                        let prop_name_key = $('#properties' + prop_key).val() + ':' + index_1.replace(':', '');
                        prod_name_array.push(prod_name);
                        prop_key_array.push(prop_name_key);

                        prop_index_2.forEach(function( index_2, key_2 ) {
                            prop_key = prop_count[++key];
                            if ($('#properties' + prop_key).val()) {
                                const result = prodName_arr(index_2, prod_name_array, prop_key, prop_key_array);
                                prod_name_array = result[0];
                                prop_key_array = result[1];
                            }
                        })
                        prod_name_result.push(prod_name_array);
                        prop_key_result.push(prop_key_array);
                    }else{
                        let prop_key = prop_count[key];
                        if($('#properties'+prop_key).val()) {
                            let prop_name_key = $('#properties' + prop_key).val() + ':' + index_1;
                            let prop_name = name + ' ' + index_1;
                            prod_name_result.push([prop_name]);
                            prop_key_result.push([prop_name_key]);
                        }
                    }
                    key = 0;
                });
                let count = 1;
                if(prod_name_result.length > 0) {
                    prod_name_result.forEach(function( index, key ) {
                        index.forEach(function( index_1, key_1 ) {
                            addPropertiesProd(index_1, count++);
                        });
                    });
                }
                count = 1;
                if(prop_key_result.length > 0) {
                    prop_key_result.forEach(function( index, key ) {
                        index.forEach(function (index_1, key_1) {
                            $('.properties_prod_' + count).append('<input type="hidden" class="properties_' + count + '" name="properties_' + count + '" value="' + index_1 + '" />');
                            count++
                        });
                    });
                }
            }
        }
        function prodName_arr(arr_, prod_arr, prop_key, prop_key_array) {
            let prod_name_result = [];
            let prod_key_result = [];
            prod_arr.forEach(function( index, key ) {
                arr_.forEach(function( index_1, key_1 ) {
                    prod_name_result.push(index + ' ' + index_1);
                })
            });
            prop_key_array.forEach(function( index, key ) {
                arr_.forEach(function( index_1, key_1 ) {
                    prod_key_result.push(index + '|' + $('#properties' + prop_key).val() + ':'+index_1);
                })
            })
            return [prod_name_result, prod_key_result];
        }
        var typingTimer;
        $( "#name, #sku, #barcode, #cost, #price" ).on( "keydown", function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function () {
                changePropertiesProd()
            }, 1000);
        } );
        $('#reset-form').on('click', function () {
            window.location.reload();
        })
        document.getElementById('frm-product').addEventListener('keypress', function(e) {
            if (e.keyCode === 13) {
                e.preventDefault();
            }
        });
        <?php
            $old_count_properties = old('count_properties');
            $old_properties = old('properties');
            $properties_value = old('properties_value');
            if($old_count_properties > 0) {
                foreach($old_properties as $key => $item) {
                    ?>
                    createProperties('{{$item}}', '{{$properties_value[$key] ?? ''}}', true);
                    <?php
                }
            }
        ?>
        // remove tag sumbit form
        $('.tag-remove').on('click', function () {
            const parentDiv = $(this).parent().parent().parent();
            const tagValue = $(this).parent().find('.tag-text').html();
            const hiddenInput = parentDiv.find('input[type=hidden]');
            const tagsArray = hiddenInput.val().split('||');
            const updatedTags = tagsArray.filter(tag => tag !== tagValue);
            console.log(tagValue, '----',updatedTags.join('||'));
            hiddenInput.val(updatedTags.join('||'));
            $(this).parent().remove();
            if(hiddenInput.attr("class") == 'properties_value')
                changePropertiesProd();
        })
        changePropertiesProd();
        function closeBranch() {
            $('#branch').val(' ').attr('selected', true).change()
        }
        function closeCategory() {
            $('#category').val(' ').attr('selected', true).change()
        }
        function closeUnit() {
            $('#unit').val(' ').attr('selected', true).change()
        }
        $('.submit_form').on('click', function (e) {
            $('#actionModal').val($(this).data('value'));
        });
        function setupInput() {
            jQuery(function($) {
                var input = $('.tag_key');
                input.on('keydown', function() {
                    var key = event.keyCode || event.charCode;
                    if( key == 186 || key == 220 )
                        return false;
                });
            });
        }
        setupInput();
        <?php
        $old_count_properties_prod = old('count_properties_prod') ?? 0;
        if($old_count_properties_prod > 0) {
            for($i = 1; $i <= $old_count_properties_prod; $i ++) {
                if(old('properties_prod_name_' . $i) == null && old('properties_prod_sku_' . $i) == null && old('properties_prod_barcode_' . $i) == null && old('properties_prod_cost_' . $i) == null && old('properties_prod_price_' . $i) == null) {
                    // xóa biến thể
                    ?>
                    $('.properties_prod_{{$i}}').remove();
                    <?php
                }else{
                    ?>
                    $('.properties_prod_name_{{$i}}').val('{{old('properties_prod_name_' . $i) ?? ''}}');
                    $('.properties_prod_sku_{{$i}}').val('{{old('properties_prod_sku_' . $i) ?? ''}}');
                    $('.properties_prod_barcode_{{$i}}').val('{{old('properties_prod_barcode_' . $i) ?? ''}}');
                    $('.properties_prod_cost_{{$i}}').val('{{old('properties_prod_cost_' . $i) ?? ''}}');
                    $('.properties_prod_price_{{$i}}').val('{{old('properties_prod_price_' . $i) ?? ''}}');
                    $('.properties_prod_price_{{$i}}').val('{{old('properties_prod_price_' . $i) ?? ''}}');
                    $('.properties_{{$i}}').val('{{old('properties_' . $i) ?? ''}}');
                    <?php
                        if($errors->has('properties_prod_name_'.$i)) {
                        ?>
                        $('#properties_prod_name_{{$i}}').addClass('border-red-500');
                        $('div[data-validate-for="properties_prod_name_{{$i}}"]').html('{{$errors->first('properties_prod_name_'.$i)}}');
                        <?php
                    }
                    if($errors->has('properties_prod_barcode_'.$i)) {
                        ?>
                        $('#properties_prod_barcode_{{$i}}').addClass('border-red-500');
                        $('div[data-validate-for="properties_prod_barcode_{{$i}}"]').html('{{$errors->first('properties_prod_barcode_'.$i)}}');
                        <?php
                    }
                    if($errors->has('properties_prod_cost_'.$i)) {
                        ?>
                        $('#properties_prod_cost_{{$i}}').addClass('border-red-500');
                        $('div[data-validate-for="properties_prod_cost_{{$i}}"]').html('{{$errors->first('properties_prod_cost_'.$i)}}');
                        <?php
                    }
                    if($errors->has('properties_prod_price_'.$i)) {
                        ?>
                        $('#properties_prod_price_{{$i}}').addClass('border-red-500');
                        $('div[data-validate-for="properties_prod_price_{{$i}}"]').html('{{$errors->first('properties_prod_price_'.$i)}}');
                        <?php
                    }
                    if($errors->has('properties_prod_sku_'.$i)) {
                        ?>
                        $('#properties_prod_sku_{{$i}}').addClass('border-red-500');
                        $('div[data-validate-for="properties_prod_sku_{{$i}}"]').html('{{$errors->first('properties_prod_sku_'.$i)}}');
                    <?php
                    }
                }
            }
        }
        ?>
    </script>

@endsection


