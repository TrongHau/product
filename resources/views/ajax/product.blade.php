@if(count($productList) > 0)
    @foreach($productList as $key => $item)
        <div class="cursor-pointer w-full @if($key == count($productList) - 1) border-b @endif border-[#E7EAEE] border-t hover:bg-[#f5f7fa] selectOption selectOption_{{ $item->id }}" data-id="{{ $item->id }}">
            <div class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-[#f5f7fa]">
                <div class="w-full items-center flex">
                    <div class="mx-2 -mt-1" >{{ $item->sku }} - {{ $item->name }}</div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="text-left"><span class="text-[#A0ABBB] Inter-Regular p-4">Không tìm thấy sản phẩm</span></div>
@endif
