@extends('layout.app')

@section('template_title')
    J&T - Danh sách sản phẩm
@endsection
@section('title_header')
    <div class="ml-5 mt-5 text-2xl font-semibold">
        Danh sách sản phẩm
    </div>
@endsection
@section('css')
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
                <input type="text" class="peer block min-h-[auto] h-full w-full rounded border-0 bg-white py-[0.32rem] px-3 leading-[1.6] focus:outline-none transition-all
                duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none
                [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0" id="name" name="name" value="{{$name}}" />
                <label for="name"
                       class="pointer-events-none absolute top-0 left-3 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.6rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-neutral-200">Mã
                    Tên sản phẩm, Mã SKU, Barcode</label>
            </div>
            <div class="relative xl:w-[12.95rem] print-status h-11 bg-white rounded">
                <select class="" data-te-select-init data-te-select-filter="true" id="category" name="category">
                    <option value="all">Tất cả</option>
                    @foreach($categoryList as $item)
                    <option {{$category == $item->id ? 'selected' : ''}} value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
                <label data-te-select-label-ref>Danh Mục</label>
            </div>
            <div class="relative xl:w-[12.95rem] print-status h-11 bg-white rounded">
                <select data-te-select-init data-te-select-filter="true" id="branch" name="branch">
                    <option value="all">Tất cả</option>
                    @foreach($branchList as $item)
                        <option {{$branch == $item->id ? 'selected' : ''}} value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
                <label data-te-select-label-ref>Thương hiệu</label>
            </div>
            <div class="relative xl:w-[12.95rem] print-status h-11 bg-white rounded">
                <select data-te-select-init id="status" name="status">
                    <option {{$status == 'all' ? 'selected' : ''}} value="all">Tất cả</option>
                    <option {{$status == '1' ? 'selected' : ''}} value="1">Đang Hoạt động</option>
                    <option {{$status == '0' ? 'selected' : ''}} value="0">Ngừng hoạt động</option>
                </select>
                <label data-te-select-label-ref>Trạng thái</label>
            </div>
            <div class="relative xl:w-[12.95rem] print-status h-11 bg-white rounded">
                <select data-te-select-init id="properties" name="properties">
                    <option {{$properties == 'all' ? 'selected' : ''}} value="all">Tất cả</option>
                    <option {{$properties == '1' ? 'selected' : ''}} value="1">Có</option>
                    <option {{$properties == '2' ? 'selected' : ''}} value="2">Không</option>
                </select>
                <label data-te-select-label-ref>Phiên bảng khác</label>
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
    <div class="flex flex-grow justify-between  items-center my-2">
        <div class="table-title Inter-SemiBold text-xl leading-6 tracking-[-0.02em] my-4">Hiện có
            <span class="total-order-v2">
    <b>{{$productList->total()}}</b>
    </span> sản phẩm
            <button id="reset-frm-search-order" class="bg-white font-medium text-sm px-2.5 py-1 rounded-2xl border ml-3 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-[#F00] focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]">Xóa lọc</button>
        </div>
        <div class="hidden flex justify-center" id="notice-tick-all"></div>
        <div class="" style="display: inherit;">
            <button type="button"
                    id="cancelProductV2"
                    class="hidden Inter-SemiBold flex items-center rounded-lg border-2 border-gray-200 px-4 pt-2 pb-[6px] font-semibold  leading-normal text-red-500 transition duration-150 ease-in-out hover:border-red-500 focus:border-[#FF0000] focus:outline-none focus:ring-0 active:border-[#FF0000]  cursor-pointer"
                    data-te-ripple-init>
                <img class="mr-2" src="/assets/images/transh.png">
                Xóa sản phẩm
            </button>
            <a
                href="/create-product"
                type="button"
                data-te-ripple-color="light"
                class="ml-4 Inter-Regular text-base leading-5 text-[#0079ED] h-10f px-[16px] py-[8px] flex items-center font-semibold rounded-lg border-2 border-gray-200 text-[#007FF9] transition duration-150 ease-in-out hover:border-[#007FF9] hover:bg-white hover:bg-opacity-10 hover:text-[#007FF9] focus:border-[#007FF9] focus:text-[#007FF9] focus:outline-none focus:ring-0 active:border-[#007FF9] active:text-[#007FF9]"
                data-te-ripple-init>
                <svg class="mr-3" width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 8.5H8V14.5H6V8.5H0V6.5H6V0.5H8V6.5H14V8.5Z" fill="#0079ED"/>
                </svg>
                Thêm sản phẩm mới
            </a>
        </div>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left">
            <thead class="text-gray-500 bg-white">
            <tr class="text-gray-500">
                <th scope="col" class="border-b px-4 py-4 dark:border-neutral-500 nosort text-center" >
                    <input
                        class="relative mt-[0.15rem] h-[1.125rem] w-[1.125rem]
                                appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300
                                outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem]
                                before:scale-0 before:rounded-full before:bg-transparent before:opacity-0
                                before:shadow-[0px_0px_0px_13px_transparent] before:content-['']
                                checked:border-[#FF0000] checked:bg-[#FF0000] checked:before:opacity-[0.16] checked:after:absolute
                                checked:after:-mt-px checked:after:ml-[0.25rem] checked:after:block checked:after:h-[0.8125rem]
                                checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-l-0
                                checked:after:border-t-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent
                                checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04]
                                focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12]
                                focus:before:transition-[box-shadow_0.2s,transform_0.2s]
                                focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem]
                                focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100
                                checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:-mt-px checked:focus:after:ml-[0.25rem]
                                checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none
                                checked:focus:after:border-[0.125rem] checked:focus:after:border-l-0 checked:focus:after:border-t-0 checked:focus:after:border-solid
                                checked:focus:after:border-white checked:focus:after:bg-transparent"
                        aria-label="check all"
                        type="checkbox"
                        value="1"
                        name="select_all"
                        id="select-all" />
                </th>
                <th scope="col" class="px-4 py-5 border-b font-thin">
                    Ảnh sản phẩm
                </th>
                <th scope="col" class="px-4 py-4 border-b font-thin">
                    Tên sản phẩm
                </th>
                <th scope="col" class="px-4 py-4 border-b font-thin">
                    Mã sản phẩm
                </th>
                <th scope="col" class="px-4 py-4 border-b font-thin">
                    Đơn vị
                </th>
                <th scope="col" class="px-4 py-4 border-b font-thin">
                    Giá
                </th>
                <th scope="col" class="px-4 py-4 border-b font-thin">
                    Danh mục
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
            @foreach($productList as $item)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-4 py-4 dark:border-neutral-500 nosort text-center">
                    <input aria-label="check record"
                           class="relative mt-[0.15rem] h-[1.125rem] w-[1.125rem]
                                appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300
                                outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem]
                                before:scale-0 before:rounded-full before:bg-transparent before:opacity-0
                                before:shadow-[0px_0px_0px_13px_transparent] before:content-['']
                                checked:border-[#FF0000] checked:bg-[#FF0000] checked:before:opacity-[0.16] checked:after:absolute
                                checked:after:-mt-px checked:after:ml-[0.25rem] checked:after:block checked:after:h-[0.8125rem]
                                checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-l-0
                                checked:after:border-t-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent
                                checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04]
                                focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12]
                                focus:before:transition-[box-shadow_0.2s,transform_0.2s]
                                focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem]
                                focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100
                                checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:-mt-px checked:focus:after:ml-[0.25rem]
                                checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none
                                checked:focus:after:border-[0.125rem] checked:focus:after:border-l-0 checked:focus:after:border-t-0 checked:focus:after:border-solid
                                checked:focus:after:border-white checked:focus:after:bg-transparent"
                           type="checkbox"
                           value="{{$item->id}}"
                           name="id-row">
                </td>
                <td scope="row" class="py-4 px-4 font-medium text-gray-900 whitespace-nowrap dark:text-white" style="width: 180px;">
                    @php
                        $imgArr = explode(',', $item->image);
                        $imgArr = array_filter($imgArr);
                    @endphp
                    @if($imgArr)
                        <img src="{{$imgArr[0]}}" width="80px" style="margin-left: 10px">
                    @else
                        <img src="/assets/images/img_default.jpg" width="80px" alt="Hình ảnh mặt định" style="margin-left: 10px">
                    @endif
                </td>
                <td class="px-4 py-4 break-all max-w-[250px]">
                    <a href="/detail-product/{{$item->id}}" class="font-medium hover:text-blue-600 dark:text-blue-500 hover:underline">{{$item->name}}</a>
                    <?php
                    $inventoryProd = App\Models\InventoryModel::select(\DB::raw('sum(inv_number) as inv_number, product_id'))->where('product_id', $item->id)->groupBy('product_id')->pluck('inv_number')->first() ?? 0;
                    ?>
                    <br/>
                    <b>Tồn kho</b>: {{$inventoryProd ?? 0}}
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    <span class="font-bold">SKU</span>: {{$item->sku}}<br/>
                    <span class="font-bold">Barcode</span>: {{$item->barcode}}
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    <span class="font-bold">Khối lượng (kg)</span>: {{$item->weight}}<br/>
                    <span class="font-bold">Đơn vị tính</span>: {{$item->Unit->name}}
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    <span class="font-bold">Giá vốn</span>: {{number_format($item->cost)}} VNĐ<br/>
                    <span class="font-bold">Giá bán</span>: {{number_format($item->price)}} VNĐ
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    <span class="font-bold">Danh mục</span>: {{$item->category->name ?? ''}}<br/>
                    <span class="font-bold">Thương hiệu</span>: {{$item->branch->name ?? ''}}
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    @if($item->status == 1)
                        <span style="padding: 6px 10px;" class="bg-green-50 text-green-500 text-xs font-semibold mr-2 px-2.5  rounded-2xl">Đang Hoạt động</span>
                    @else
                        <span style="padding: 6px 10px;" class="bg-red-50 text-red-500 text-xs font-semibold mr-2 px-2.5 rounded-2xl">Ngừng hoạt động</span>
                    @endif
                </td>
                <td class="px-4 py-4">
                    <a href="/detail-product/{{$item->id}}" type="button" data-te-ripple-color="light" data-te-toggle="tooltip" title="Xem chi tiết sản phẩm" data-te-placement="top" class="show-details mr-3 inline-block rounded-full leading-normal text-white shadow-md transition ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]">
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
                    <a href="/edit-product/{{$item->id}}" data-te-ripple-color="light" data-edit="433" class="mr-2 edit-user inline-block rounded-full leading-normal text-white shadow-md transition ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_10313_43843)">
                                <path d="M17.3733 14.0133L17.9867 14.6267L11.9467 20.6667H11.3333V20.0533L17.3733 14.0133ZM19.7733 10C19.6067 10 19.4333 10.0667 19.3067 10.1933L18.0867 11.4133L20.5867 13.9133L21.8067 12.6933C22.0667 12.4333 22.0667 12.0133 21.8067 11.7533L20.2467 10.1933C20.1133 10.06 19.9467 10 19.7733 10ZM17.3733 12.1267L10 19.5V22H12.5L19.8733 14.6267L17.3733 12.1267Z" fill="#19B88B"></path>
                            </g>
                            <rect x="0.5" y="0.5" width="31" height="31" rx="15.5" stroke="#19B88B"></rect>
                        </svg>
                    </a>
                    <button onclick="deleteProduct('{{$item->id}}')" data-te-ripple-color="light" data-edit="433" class="mr-2 edit-user inline-block rounded-full leading-normal text-white shadow-md transition ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="33" height="33" viewBox="0,0,256,256"
                             style="fill:#000000;">
                            <g transform="translate(46.08,46.08) scale(0.64,0.64)"><g fill="none" fill-rule="nonzero" stroke="#ff0000" stroke-width="10.66667" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M126.12942,315.05765c-102.276,0 -185.18708,-82.91108 -185.18708,-185.18708v-3.74115c0,-102.276 82.91108,-185.18708 185.18708,-185.18708h3.74115c102.276,0 185.18708,82.91108 185.18708,185.18708v3.74115c0,102.276 -82.91108,185.18708 -185.18708,185.18708z" id="shape"></path></g><g fill="#ff0000" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(10.66667,10.66667)"><path d="M10,2l-1,1h-5v2h1v15c0,0.52222 0.19133,1.05461 0.56836,1.43164c0.37703,0.37703 0.90942,0.56836 1.43164,0.56836h10c0.52222,0 1.05461,-0.19133 1.43164,-0.56836c0.37703,-0.37703 0.56836,-0.90942 0.56836,-1.43164v-15h1v-2h-5l-1,-1zM7,5h10v15h-10zM9,7v11h2v-11zM13,7v11h2v-11z"></path></g></g></g>
                        </svg>
                    </button>
                </td>
            </tr>
            @endforeach
            @if(count($productList) == 0)
                <tr class="">
                    <td colspan="8" class="text-center px-4 py-4 dark:border-neutral-500 nosort text-center">
                        <img src="/assets/images/no_data.png">
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
        @if(count($productList) > 0)
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
                        {{ $productList->appends($search)->links('vendor.pagination.tailwind') }}
                    @else
                        {{ $productList->links('vendor.pagination.tailwind') }}
                    @endif
                </div>
            </div>
        @endif
    </div>
    <div
        data-te-modal-init
        class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
        id="deleteModal"
        tabindex="-1"
        aria-labelledby="deleteModal"
        aria-hidden="true">
        <div
            data-te-modal-dialog-ref
            class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px]">
            <div class="min-[576px]:shadow-[0_0.5rem_1rem_rgba(#000, 0.15)] pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
                <form method="post" action="/product-delete">
                    <div class="relative p-4 text-center bg-white rounded-lg  dark:bg-gray-800 sm:p-5">
                        <button data-te-modal-dismiss type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        <p class="mb-4 text-gray-500 dark:text-gray-300">Bạn có chắc chắn xóa sản phẩm này không?</p>
                        <div class="flex justify-center items-center space-x-4">
                            <button data-te-modal-dismiss type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                Hủy bỏ
                            </button>
                            <button type="submit" class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                Chắc chắn, có
                            </button>
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" id="id_delete" name="id" value="">
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

@endsection
@section('scripts')
<script>
    $("#reset-frm-search-order").on('click', function(){
        $('#name').val('');
        $("#category option[value='all']").attr("selected", 'selected');
        $("#branch option[value='all']").attr("selected", 'selected');
        $("#status option[value='all']").attr("selected", 'selected');
        $('#btn-searching-order').trigger('click');h
    });
    $('#select-all').on('click', function () {
        $('input[type="checkbox"]').prop('checked', this.checked);
    });
    $('input[type="checkbox"]').on('click', function () {
        countChecked()
    });
    var list_checked_ids = [];
    function countChecked() {
        let number_of_lines_selected = 0;
        list_checked_ids = [];
        $('input:checkbox[name=id-row]').each(function () {
            if ($(this).is(':checked')) {
                number_of_lines_selected++;
                list_checked_ids.push($(this).val());
            }
        });
        if (number_of_lines_selected > 0) {
            // Cancel order
            $('#cancelProductV2').removeClass('hidden');
        } else {
            // Cancel order
            $('#cancelProductV2').addClass('hidden');
        }
    }
    $('#cancelProductV2').on('click', function () {
        if(list_checked_ids.length > 0) {
            $('#id_delete').val('');
            $('#deleteModal').modal('show');
            $('#id_delete').val(list_checked_ids.toString());
        }
    })
    $('#select-per-page').change(function (){
        let urlCurrent = window.location.search;
        if(urlCurrent.indexOf("?") == -1) {
            urlCurrent = urlCurrent + '?per_page=' + $(this).val();
        }else{
            urlCurrent = urlCurrent + '&per_page=' + $(this).val();
        }
        window.location.href = urlCurrent;
    })
    function deleteProduct(id) {
        $('#id_delete').val('');
        $('#deleteModal').modal('show');
        $('#id_delete').val(id);
    }
</script>
@endsection


