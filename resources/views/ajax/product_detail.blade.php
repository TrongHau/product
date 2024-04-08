<div class="flex flex-wrap pt-4 pb-4 -mr-2 border-t product_item_{{$product->id}}">
    <div class="p-2" style="width: 28%">
        <div class="relative border-r">
            @php
                $prop_string = '';
                $imgArr = explode(',', $product->image);
                $imgArr = array_filter($imgArr);
            @endphp
            @if($imgArr)
                <img src="{{$imgArr[0]}}" width="80px" class="rounded float-left mr-2" style="margin-left: 10px">
                <input type="hidden" value="{{$imgArr[0]}}" name="prod_image_{{$product->id}}">
            @else
                <img src="/assets/images/img_default.jpg" width="80px" class="rounded float-left mr-2" style="margin-left: 10px">
                <input type="hidden" value="/assets/images/img_default.jpg" name="prod_image_{{$product->id}}">
            @endif
            <div class="float-left" style="display: contents;">
                {{$product->name}} <br/>
                <b>SKU</b>: {{$product->sku}} <br/>
                @if($product->properties)
                <?php
                    $properties = explode('|', $product->properties);
                    $properties = array_filter($properties);
                ?>
                <b>Thuộc tính</b>:
                <?php
                    foreach ($properties as $key => $item) {
                        $prop = explode(':', $item);
                        $prop = array_filter($prop);
                        $prop_string = $prop_string . ($prop[0] .': '. $prop[1] . ($key < count($properties) - 1 ? ', ' : ''));
                    }
                    echo $prop_string;
                    ?>
                @endif
            </div>
            <input type="hidden" name="prod_name_{{$product->id}}" value="{{$product->name}}">
            <input type="hidden" name="prod_sku_{{$product->id}}" value="{{$product->sku}}">
            <input type="hidden" name="prod_prop_{{$product->id}}" value="{{$prop_string}}">
        </div>
    </div>
    <div class="p-2" style="width: 18%">
        <div class="relative">
            <label for="cost_{{$product->id}}" class="leading-5 text-base text-[#191D23] Inter-Regular">
                <span>Giá vốn</span> <span class="text-[#DC2626]">*</span>
            </label>
            <div class="relative flex flex-wrap items-stretch mt-1">
                <input {{isset($action) && $action == 'detail' ? 'disabled' : ''}} value="{{number_format($productAble->cost ?? $product->cost)}}" id="cost_{{$product->id}}" name="cost_{{$product->id}}" type="text" class="number_price cost_{{$product->id}} relative m-0 block w-[1px] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-8 text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:text-neutral-700 focus:outline-none" placeholder="Nhập số tiền..." aria-label="Nhập số tiền..." aria-describedby="basic-addon2">
                <span class="flex items-center whitespace-nowrap rounded-r border border-l-0 border-solid border-neutral-300 px-3 py-[0.25rem] text-center text-base font-normal leading-8 text-neutral-700 dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200">VNĐ</span>
            </div>
            <div class="text-[#ef4444] text-sm" data-validate-for="cost_{{$product->id}}"></div>
        </div>
    </div>
    <div class="p-2" style="width: 18%">
        <div class="relative">
            <label for="price_{{$product->id}}" class="leading-5 text-base text-[#191D23] Inter-Regular">
                <span>Giá bán</span> <span class="text-[#DC2626]">*</span>
            </label>
            <div class="relative flex flex-wrap items-stretch mt-1">
                <input {{isset($action) && $action == 'detail' ? 'disabled' : ''}} value="{{number_format($productAble->price ?? $product->price)}}" id="price_{{$product->id}}" name="price_{{$product->id}}" type="text" class="number_price price_{{$product->id}} relative m-0 block w-[1px] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-8 text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:text-neutral-700 focus:outline-none" placeholder="Nhập số tiền..." aria-label="Nhập số tiền..." aria-describedby="basic-addon2">
                <span class="flex items-center whitespace-nowrap rounded-r border border-l-0 border-solid border-neutral-300 px-3 py-[0.25rem] text-center text-base font-normal leading-8 text-neutral-700 dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200">VNĐ</span>
            </div>
            <div class="text-[#ef4444] text-sm" data-validate-for="price_{{$product->id}}"></div>
        </div>
    </div>
    <div class="p-2" style="width: 18%">
        <div class="relative">
            <label for="price_floor_{{$product->id}}" class="leading-5 text-base text-[#191D23] Inter-Regular">
                <span>Giá sàn</span>
            </label>
            <div class="relative flex flex-wrap items-stretch mt-1">
                <input {{isset($action) && $action == 'detail' ? 'disabled' : ''}} value="{{isset($productAble->price_floor) ? number_format($productAble->price_floor) : ''}}" id="price_floor_{{$product->id}}" name="price_floor_{{$product->id}}" type="text" class="number_price price_floor_{{$product->id}} relative m-0 block w-[1px] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-8 text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:text-neutral-700 focus:outline-none" placeholder="Nhập số tiền..." aria-label="Nhập số tiền..." aria-describedby="basic-addon2">
                <span class="flex items-center whitespace-nowrap rounded-r border border-l-0 border-solid border-neutral-300 px-3 py-[0.25rem] text-center text-base font-normal leading-8 text-neutral-700 dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200">VNĐ</span>
            </div>
            <div class="text-[#ef4444] text-sm" data-validate-for="price_floor_{{$product->id}}"></div>
        </div>
    </div>
    <div class="p-2" style="width: 18%">
        <div class="relative" style="width: 85%; display: inline-block">
            <label for="count_{{$product->id}}" class="leading-5 text-base text-[#191D23] Inter-Regular">
                <span>Số lượng</span> <span class="text-[#DC2626]">*</span>
            </label>
            <div class="relative flex flex-wrap items-stretch mt-1">
                <input {{isset($action) && $action == 'detail' ? 'disabled' : ''}} value="{{isset($productAble->count) ? number_format($productAble->count) : ''}}" id="count_{{$product->id}}" name="count_{{$product->id}}" type="text" class="number_price count_{{$product->id}} relative m-0 block w-[1px] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-8 text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:text-neutral-700 focus:outline-none" placeholder="Nhập số lượng..." aria-label="Nhập số lượng..." aria-describedby="basic-addon2">
            </div>
            <div class="text-[#ef4444] text-sm" data-validate-for="price_floor_{{$product->id}}"></div>
        </div>

        <button type="button" onclick="deleteProd('{{$product->id}}')" class="w-10 mt-5 h-11 Inter-SemiBold flex items-center rounded bg-red-50 pl-2 pt-[0.1rem] font-medium leading-normal text-[#A0ABBB] transition duration-150 ease-in-out hover:border-primary-accent-100 hover:bg-red-700 hover:bg-opacity-10 focus:border-primary-accent-100 focus:outline-none focus:ring-0 active:border-primary-accent-200 dark:text-primary-100 dark:hover:bg-neutral-100 dark:hover:bg-opacity-10" data-te-ripple-init="" style="display: inline-block; margin-top: 24px; margin-left: 10px; position: absolute; }">
            <img src="/assets/images/transh.png">
        </button>
        <input type="hidden" class="product_{{$product->id}}" name="product[]" value="{{$product->id}}">
    </div>
</div>
