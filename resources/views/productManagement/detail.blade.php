@extends('layout.app')

@section('template_title')
    J&T - {{$product->name}}
@endsection
@section('title_header')
    <div class="ml-5 mt-5 text-2xl font-semibold">
        Chi tiết sản phẩm
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
    <script src="{{ '/assets/js/jssor.slider-28.1.0.min.js'}}" type="text/javascript"></script>
    <script type="text/javascript">
        window.jssor_1_slider_init = function() {

            var jssor_1_SlideshowTransitions = [
                {$Duration:800,x:0.25,$Zoom:1.5,$Easing:{$Left:$Jease$.$InWave,$Zoom:$Jease$.$InCubic},$Opacity:2,$ZIndex:-10,$Brother:{$Duration:800,x:-0.25,$Zoom:1.5,$Easing:{$Left:$Jease$.$InWave,$Zoom:$Jease$.$InCubic},$Opacity:2,$ZIndex:-10}},
                {$Duration:1200,x:0.5,$Cols:2,$ChessMode:{$Column:3},$Easing:{$Left:$Jease$.$InOutCubic},$Opacity:2,$Brother:{$Duration:1200,$Opacity:2}},
                {$Duration:600,x:0.3,$During:{$Left:[0.6,0.4]},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2,$Brother:{$Duration:600,x:-0.3,$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2}},
                {$Duration:800,x:0.25,y:0.5,$Rotate:-0.1,$Easing:{$Left:$Jease$.$InQuad,$Top:$Jease$.$InQuad,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InQuad},$Opacity:2,$Brother:{$Duration:800,x:-0.1,y:-0.7,$Rotate:0.1,$Easing:{$Left:$Jease$.$InQuad,$Top:$Jease$.$InQuad,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InQuad},$Opacity:2}},
                {$Duration:1000,x:1,$Rows:2,$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2,$Brother:{$Duration:1000,x:-1,$Rows:2,$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2}},
                {$Duration:1000,y:-1,$Cols:2,$ChessMode:{$Column:12},$Easing:{$Top:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2,$Brother:{$Duration:1000,y:1,$Cols:2,$ChessMode:{$Column:12},$Easing:{$Top:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2}},
                {$Duration:800,y:1,$Easing:{$Top:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2,$Brother:{$Duration:800,y:-1,$Easing:{$Top:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2}},
                {$Duration:1000,x:-0.1,y:-0.7,$Rotate:0.1,$During:{$Left:[0.6,0.4],$Top:[0.6,0.4],$Rotate:[0.6,0.4]},$Easing:{$Left:$Jease$.$InQuad,$Top:$Jease$.$InQuad,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InQuad},$Opacity:2,$Brother:{$Duration:1000,x:0.2,y:0.5,$Rotate:-0.1,$Easing:{$Left:$Jease$.$InQuad,$Top:$Jease$.$InQuad,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InQuad},$Opacity:2}},
                {$Duration:800,x:-0.2,$Delay:40,$Cols:12,$During:{$Left:[0.4,0.6]},$SlideOut:true,$Formation:$JssorSlideshowFormations$.$FormationStraight,$Assembly:260,$Easing:{$Left:$Jease$.$InOutExpo,$Opacity:$Jease$.$InOutQuad},$Opacity:2,$Outside:true,$Round:{$Top:0.5},$Brother:{$Duration:800,x:0.2,$Delay:40,$Cols:12,$Formation:$JssorSlideshowFormations$.$FormationStraight,$Assembly:1028,$Easing:{$Left:$Jease$.$InOutExpo,$Opacity:$Jease$.$InOutQuad},$Opacity:2,$Round:{$Top:0.5},$Shift:-200}},
                {$Duration:700,$Opacity:2,$Brother:{$Duration:700,$Opacity:2}},
                {$Duration:800,x:1,$Easing:{$Left:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2,$Brother:{$Duration:800,x:-1,$Easing:{$Left:$Jease$.$InOutQuart,$Opacity:$Jease$.$Linear},$Opacity:2}}
            ];

            var jssor_1_options = {
                $AutoPlay: 1,
                $FillMode: 5,
                $SlideshowOptions: {
                    $Class: $JssorSlideshowRunner$,
                    $TransitionsOrder: 1
                },
                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$
                },
                $BulletNavigatorOptions: {
                    $Class: $JssorBulletNavigator$,
                    $SpacingX: 16,
                    $SpacingY: 16
                }
            };

            var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

            /*#region responsive code begin*/

            var MAX_WIDTH = 400;

            function ScaleSlider() {
                var containerElement = jssor_1_slider.$Elmt.parentNode;
                var containerWidth = containerElement.clientWidth;

                if (containerWidth) {

                    var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);

                    jssor_1_slider.$ScaleWidth(expectedWidth);
                }
                else {
                    window.setTimeout(ScaleSlider, 30);
                }
            }

            ScaleSlider();

            $Jssor$.$AddEvent(window, "load", ScaleSlider);
            $Jssor$.$AddEvent(window, "resize", ScaleSlider);
            $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
            /*#endregion responsive code end*/
        };
    </script>
    <style>
        /*jssor slider loading skin spin css*/
        .jssorl-009-spin img {
            animation-name: jssorl-009-spin;
            animation-duration: 1.6s;
            animation-iteration-count: infinite;
            animation-timing-function: linear;
        }

        @keyframes jssorl-009-spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /*jssor slider bullet skin 072 css*/
        .jssorb072 .i {position:absolute;color:#000;font-family:"Helvetica neue",Helvetica,Arial,sans-serif;text-align:center;cursor:pointer;z-index:0;}
        .jssorb072 .i .b {fill:#fff;opacity:.3;}
        .jssorb072 .i:hover {opacity:.7;}
        .jssorb072 .iav {color:#fff;}
        .jssorb072 .iav .b {fill:#000;opacity:.5;}
        .jssorb072 .i.idn {opacity:.3;}

        /*jssor slider arrow skin 073 css*/
        .jssora073 {display:block;position:absolute;cursor:pointer;}
        .jssora073 .a {fill:#ddd;fill-opacity:.7;stroke:#000;stroke-width:160;stroke-miterlimit:10;stroke-opacity:.7;}
        .jssora073:hover {opacity:.8;}
        .jssora073.jssora073dn {opacity:.4;}
        .jssora073.jssora073ds {opacity:.3;pointer-events:none;}
    </style>
@endsection

@section('content')
    <div class="breadcrumb flex justify-between">
        <nav class="flex bg-grey-light rounded-md">
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
                <li class="Inter-SemiBold text-lg tracking-[-0.02em] text-[#F20000]">Chỉnh sửa sản phẩm</li>
            </ol>
        </nav>
        <div class="flex">
            <a  href="/product"
                type="button"
                id="reset-form"
                class="cursor-pointer float-right Inter-SemiBold flex items-center inline-block rounded bg-gray-200 px-6 pb-2 pt-2.5 text-base font-semibold leading-normal text-black
        shadow-[0_4px_9px_-4px_#95959559] transition duration-150 ease-in-out
        hover:shadow-[0_8px_9px_-4px_#95959559,0_4px_18px_0_#95959559]
        focus:outline-none focus:ring-0">
                Hủy
            </a>
            <a href="/edit-product/{{$product->id}}"
                id="submit_form"
                type="submit"
                class="mx-5 float-right Inter-SemiBold flex items-center inline-block rounded bg-[#FF0000] px-6 pb-2 pt-2.5 text-base font-medium leading-normal text-white shadow-[0_4px_9px_-4px_#dc4c64]
        transition duration-150 ease-in-out hover:bg-[#FF0000] hover:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)]
        focus:bg-[#FF0000] focus:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] focus:outline-none
        focus:ring-0 active:bg-[#FF0000] active:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] ">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 2px;margin-left: -10px;margin-top: -8px;margin-bottom: -6px;">
                    <g clip-path="url(#clip0_10313_43843)">
                        <path d="M17.3733 14.0133L17.9867 14.6267L11.9467 20.6667H11.3333V20.0533L17.3733 14.0133ZM19.7733 10C19.6067 10 19.4333 10.0667 19.3067 10.1933L18.0867 11.4133L20.5867 13.9133L21.8067 12.6933C22.0667 12.4333 22.0667 12.0133 21.8067 11.7533L20.2467 10.1933C20.1133 10.06 19.9467 10 19.7733 10ZM17.3733 12.1267L10 19.5V22H12.5L19.8733 14.6267L17.3733 12.1267Z" fill="white"></path>
                    </g>
                </svg>
                Chỉnh sửa
            </a>
        </div>
    </div>
    <div class="mt-2 py-4">
        <div class="rounded-2xl bg-white py-1 px-0 mx-5">
            <?php $img = explode(',', $product->image); $img = array_filter($img); ?>
            <style>
                .slides-image {
                    margin-left: auto;
                    margin-right: auto;
                }
            </style>
            <div class="flex flex-wrap mt-4 pb-5">
                @if($img)
                    <div class="flex" style="width: 27%">
                        <div class="pl-5" style="overflow: hidden;">
                            <div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:600px;height:500px;overflow:hidden;visibility:hidden;">
                                <!-- Loading Screen -->
                                <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
                                    <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="/assets/images/spin.svg" />
                                </div>
                                <div data-u="slides" class="slides-image" style="cursor:default;position:relative;top:0px;left:0px;width:600px;height:500px;overflow:hidden;">
                                    <?php $img = explode(',', $product->image); ?>
                                    @foreach($img as $item)
                                        <div onclick="openModal('{{$item}}')" ><img class="slides-image" src="{{$item}}" /></div>
                                    @endforeach
                                </div><a data-scale="0" href="https://www.jssor.com" style="display:none;position:absolute;">design web</a>
                                <!-- Bullet Navigator -->
                                <div data-u="navigator" class="jssorb072" style="position:absolute;bottom:16px;right:16px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
                                    <div data-u="prototype" class="i" style="width:24px;height:24px;font-size:12px;line-height:24px;">
                                        <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;z-index:-1;">
                                            <circle class="b" cx="8000" cy="8000" r="6666.7"></circle>
                                        </svg>
                                        <div data-u="numbertemplate" class="n"></div>
                                    </div>
                                </div>
                                <!-- Arrow Navigator -->
                                <div data-u="arrowleft" class="jssora073" style="width:40px;height:50px;top:0px;left:30px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
                                    <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                                        <path class="a" d="M4037.7,8357.3l5891.8,5891.8c100.6,100.6,219.7,150.9,357.3,150.9s256.7-50.3,357.3-150.9 l1318.1-1318.1c100.6-100.6,150.9-219.7,150.9-357.3c0-137.6-50.3-256.7-150.9-357.3L7745.9,8000l4216.4-4216.4 c100.6-100.6,150.9-219.7,150.9-357.3c0-137.6-50.3-256.7-150.9-357.3l-1318.1-1318.1c-100.6-100.6-219.7-150.9-357.3-150.9 s-256.7,50.3-357.3,150.9L4037.7,7642.7c-100.6,100.6-150.9,219.7-150.9,357.3C3886.8,8137.6,3937.1,8256.7,4037.7,8357.3 L4037.7,8357.3z"></path>
                                    </svg>
                                </div>
                                <div data-u="arrowright" class="jssora073" style="width:40px;height:50px;top:0px;right:30px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
                                    <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                                        <path class="a" d="M11962.3,8357.3l-5891.8,5891.8c-100.6,100.6-219.7,150.9-357.3,150.9s-256.7-50.3-357.3-150.9 L4037.7,12931c-100.6-100.6-150.9-219.7-150.9-357.3c0-137.6,50.3-256.7,150.9-357.3L8254.1,8000L4037.7,3783.6 c-100.6-100.6-150.9-219.7-150.9-357.3c0-137.6,50.3-256.7,150.9-357.3l1318.1-1318.1c100.6-100.6,219.7-150.9,357.3-150.9 s256.7,50.3,357.3,150.9l5891.8,5891.8c100.6,100.6,150.9,219.7,150.9,357.3C12113.2,8137.6,12062.9,8256.7,11962.3,8357.3 L11962.3,8357.3z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <img src="/assets/images/img_default.jpg" alt="Hình ảnh mặt định" style="margin-left: 10px; width: 27%">
                @endif
                <div class="flex" style="width: 72%">
                    <div class="w-3/5 pl-3 pr-5">
                        <div class="flex flex-wrap mt-1 relative">
                            <b style="font-size: 20px">{{$product->name}}</b>
                        </div>
                        <div class="flex flex-wrap mt-3 relative">
                            @if($product->status == 1)
                                <span style="padding: 6px 10px;" class="bg-green-50 text-green-500 text-xs font-semibold mr-2 px-2.5  rounded-2xl">Đang Hoạt động</span>
                            @else
                                <span style="padding: 6px 10px;" class="bg-red-50 text-red-500 text-xs font-semibold mr-2 px-2.5 rounded-2xl">Ngừng hoạt động</span>
                            @endif
                        </div>
                        <?php
                        $properties = explode('|', $product->properties);
                        $properties = array_filter($properties);
                        if($properties) {
                        ?>
                        <div class="flex flex-wrap mt-3 relative">
                            <?php
                            foreach ($properties as $key => $item) {
                            $prop = explode(':', $item);
                            $prop = array_filter($prop);
                            ?>
                            <div class="flex mr-5 relative">
                                <div class="font-bold">
                                    {{$prop[0]}}
                                </div>
                                <div class=" pr-5 @if($key < count($properties) - 1) border-r @endif">
                                    : {{$prop[1] ?? ''}}
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                        <?php
                        }
                        ?>
                        <div class="flex flex-wrap mt-1 relative p-4 rounded-[0.6rem]" style="background: #f0fdf4a6;">
                            <div class="flex-wrap pr-8 border-r">
                                <div>Giá vốn</div>
                                <div class="font-semibold">{{number_format($product->cost)}} VNĐ</div>
                            </div>
                            <div class="flex-wrap pl-8">
                                <div>Giá bán</div>
                                <div class="font-semibold">{{number_format($product->price)}} VNĐ</div>
                            </div>
                        </div>
                        <div class="flex flex-wrap mt-1 relative p-4 pl-0">
                            <div class="border-b w-full pb-3 font-semibold" style="color: #64748B">Mô tả sản phẩm</div>
                            <div class="w-full py-3 short_content text-sm">
                                <?php
                                // strip tags to avoid breaking any html
                                $string = strip_tags($product->description);
                                if (strlen($string) > 250) {

                                    // truncate string
                                    $stringCut = substr($string, 0, 250);
                                    $endPoint = strrpos($stringCut, ' ');

                                    //if the string doesn't contain any space then it will cut without word basis.
                                    $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                    $string .= '... <a class="font-medium text-blue-600 dark:text-blue-500 hover:underline" href="javascript:void(0);" onclick="reaMore()">Xem thêm</a>';
                                }
                                echo $string;
                                ?>
                            </div>
                            <div class="w-full py-3 full_content text-sm hidden">
                                <?php echo $product->description ?>
                                <a class="font-medium text-blue-600 dark:text-blue-500 hover:underline" href="javascript:void(0);" onclick="shortContent()">Thu gọn</a>
                            </div>
                            <script>
                                function reaMore() {
                                    $('.short_content').addClass('hidden');
                                    $('.full_content').removeClass('hidden');
                                }
                                function shortContent() {
                                    $('.short_content').removeClass('hidden');
                                    $('.full_content').addClass('hidden');
                                }
                            </script>
                        </div>
                    </div>
                    <div class=" rounded-[0.6rem] w-2/5 p-5" style="background: #f0fdf4a6;">
                        <div class="w-full pb-2 font-semibold" style="color: #64748B; border-bottom: 1px solid #0080001c">Thông tin sản phẩm</div>
                        <div class="flex mr-5 mt-5 text-sm relative">
                            <div class="font-bold">
                                Mã sản phẩm SKU
                            </div>
                            <div class="pr-5">
                                : {{$product->sku}}
                            </div>
                        </div>
                        <div class="flex mr-5 mt-5 text-sm relative">
                            <div class="font-bold">
                                Barcode
                            </div>
                            <div class="pr-5">
                                : {{$product->barcode}}
                            </div>
                        </div>
                        <div class="flex mr-5 mt-5 text-sm relative">
                            <div class="font-bold">
                                Khối lượng (kg)
                            </div>
                            <div class="pr-5">
                                : {{$product->weight}}
                            </div>
                        </div>
                        <div class="flex mr-5 mt-5 text-sm relative">
                            <div class="font-bold">
                                Đơn vị tính
                            </div>
                            <div class="pr-5">
                                : {{$product->unit->name ?? ''}}
                            </div>
                        </div>
                        <div class="flex mr-5 mt-5 text-sm relative">
                            <div class="font-bold">
                                Danh mục
                            </div>
                            <div class="pr-5">
                                : {{$product->category->name ?? ''}}
                            </div>
                        </div>
                        <div class="flex mr-5 mt-5 text-sm relative">
                            <div class="font-bold">
                                Thương hiệu
                            </div>
                            <div class="pr-5">
                                : {{$product->branch->name ?? ''}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if($inventoryProd)
            <div class="flex flex-wrap mt-4 pb-5 pl-5">
                <div class=" relative flex w-full mb-5"><h4><b>Thông tin tồn kho</b></h4></div>
                <div class="rounded bg-gray-50 relative flex w-full mr-5">
                    <div class="relative sm:rounded-lg w-full px-5">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                            <tr>
                                <th scope="col" class="px-6 py-3 pl-0">
                                    Tên kho
                                </th>
                                <th scope="col" class="px-6 py-3 pl-0">
                                    Tổng tồn kho
                                </th>
                                <th scope="col" class="px-6 py-3 pl-0">
                                    Giá vốn
                                </th>
                                <th scope="col" class="px-6 py-3 pl-0">
                                    Giá bán
                                </th>
                                <th scope="col" class="px-6 py-3 pl-0">
                                    Giá sàn
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($inventoryProd as $item)
                            <tr class="bg-gray-50 dark:bg-gray-800 dark:border-gray-700 border-t">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white pl-0">
                                    {{$item->warehouse->name}}
                                </th>
                                <td class="px-6 py-4 pl-7">
                                    {{number_format($item->inv_number)}}
                                </td>
                                <td class="px-6 py-4 pl-0">
                                    {{number_format($item->cost)}} đ
                                </td>
                                <td class="px-6 py-4 pl-0">
                                    {{number_format($item->price)}} đ
                                </td>
                                <td class="px-6 py-4 pl-0">
                                    {{$item->price_floor ? number_format($item->price_floor) . 'đ' : ''}}
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
            @if(count($relateProduct) > 0)
                <div class="flex flex-wrap mt-4 pb-5 pl-5">
                    <h4><b>Phiên bản liên quan</b></h4><br/><br/>
                    @foreach($relateProduct as $item)
                        <div class="flex w-full border-b py-4 mr-5 pb-2.5 justify-between">
                            <a href="/detail-product/{{$item->id}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{$item->sku}} - {{$item->name}}</a>
                            <a href="/detail-product/{{$item->id}}" class="bg-gray-200 font-medium font-sm px-2.5 py-1 rounded-2xl">Xem chi tiết</a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
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
    <script>
        jssor_1_slider_init();
        function openModal(img) {
            console.log(123);
            const modalImage = document.getElementById('modalImage');
            modalImage.src = img;
            $("#imageModal").modal('show');
        }
    </script>
@endsection

