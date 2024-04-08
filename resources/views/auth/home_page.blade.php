@extends('layout.app_login')

@section('template_title')
    Đăng nhập | Sản phẩm livestream
@endsection

@section('css')
    <link href="{{ "assets/css/login.css" }}" rel="stylesheet">
    <script type="module" src="{{ 'assets/js/login.js' }}"></script>
    <style>
        body {
            background-image: url('{{ "assets/images/background.svg" }}');
            background-repeat: no-repeat;
            height: 100vh;
        }
    </style>
@endsection

@section('content')
<div class="container mx-auto flex flex-wrap py-6 max-xl:w-full home-page-container">
    <section class="w-full md:w-[35%] flex flex-col items-center px-3 mt-2">
        <p class="Inter-Regular text-[28px] font-bold leading-9 tracking-[-0.56px] mb-8 title-form">Đăng nhập</p>
        <!--Tabs navigation-->
        <ul
            class="mb-1 flex list-none flex-row flex-wrap border-b-0 pl-0 w-[510px]" id="tabsNav"
            role="tablist"
            data-te-nav-ref>
            <li role="presentation" class="flex-grow basis-0 text-center">
                <a
                    href="#tabs-login"
                    class="my-2 Inter-Regular text-[#1F2937] font-normal py-[12px] px-[16px] block border-x-0 border-y-[1.5px] border-t-transparent border-[#E7EAEE] hover:isolate hover:border-transparent hover:bg-neutral-100"
                    data-te-toggle="pill"
                    data-te-target="#tabs-sigin"
                    role="tab"
                    aria-controls="tabs-sigin"
                    @if($type != 'register') data-te-nav-active aria-selected="true" @else aria-selected="false" @endif
                    onclick="trackingUrl('login')"
                >Đăng nhập</a>
            </li>
            <li role="presentation" class="flex-grow basis-0 text-center">
                <a
                    href="#tabs-register"
                    class="my-2 Inter-Regular text-[#1F2937] font-normal py-[12px] px-[16px] block border-x-0 border-y-[1.5px] border-t-transparent border-[#E7EAEE] hover:isolate hover:border-transparent hover:bg-neutral-100"
                    data-te-toggle="pill"
                    data-te-target="#tabs-register"
                    role="tab"
                    aria-controls="tabs-register"
                    @if($type == 'register') data-te-nav-active aria-selected="true" @else aria-selected="false" @endif
                onclick="trackingUrl('register')"
                >Đăng ký tài khoản</a>
            </li>
        </ul>

        <!--Tabs content-->
        <div class="mb-6 w-full tabs-content">
            <div
                class="hidden @if($type != 'register') opacity-100 @else opacity-0 @endif transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
                id="tabs-sigin"
                role="tabpanel"
                aria-labelledby="tabs-sigin"
                @if($type != 'register') data-te-tab-active @endif>
                @include('auth.login')
            </div>
            <div
                class="hidden @if($type == 'register') opacity-100 @else opacity-0 @endif transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
                id="tabs-register"
                role="tabpanel"
                aria-labelledby="tabs-register"
                @if($type == 'register') data-te-tab-active @endif>
                @include('auth.registration')
            </div>
        </div>
    </section>
</div>
@include('auth.forgot_password')
<div data-te-modal-init
     class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
     id="newFeatureModal" tabindex="-1" aria-labelledby="newFeatureModalCenterTitle" aria-modal="true" role="dialog">
    <div data-te-modal-dialog-ref
         class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
        <div
            class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
            <div class="flex flex-shrink-0 items-center justify-between rounded-t-md p-4">
                <!--Modal title-->
                <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200"
                    id="newFeatureModalScrollableLabel">
                </h5>
                <!--Close button-->
                <button type="button"
                        class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
                        data-te-modal-dismiss aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!--Modal body-->
            <div class="relative p-4 flex items-center justify-center flex-col">
                <img class="object-cover" src="{{ 'assets/images/inComlete_dialog.gif' }}" alt=""
                     width="180px" height="180px">
                <p class="Inter-SemiBold text-[#0d0f11] text-lg leading-6 tracking-[-0.02rem] mt-5 mb-2">Chức năng
                    đang được phát triển</p>
                <p class="Inter-Regular text-[#4b5768] text-sm leading-4">Chúng tôi đang cố gắng cập nhật sớm nhất
                </p>
            </div>

            <!--Modal footer-->
            <div class="flex flex-shrink-0 flex-wrap items-center justify-center rounded-b-md p-4">
                <button type="button"
                        class="inline-block rounded bg-primary-100 px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-primary-700 transition duration-150 ease-in-out hover:bg-primary-accent-100 focus:bg-primary-accent-100 focus:outline-none focus:ring-0 active:bg-primary-accent-200"
                        data-te-modal-dismiss data-te-ripple-init data-te-ripple-color="light">
                    Đóng
                </button>
            </div>
        </div>
    </div>
</div>
@if(isset($error))
    <p class="hidden" data-control="flash-message" data-type="{{ $type }}" data-interval="5">
        {{ $message }}
    </p>
@endif
@endsection
@section('scripts')
    <script>
        function showMaintenance() {
            $('#newFeatureModal').modal('show');
        }
    </script>
    <script>
        function trackingUrl(url){

            if(url == 'login'){
                $('.title-form').text('Đăng nhập');
            }else {
                $('.title-form').text('Đăng ký tài khoản');
            }

            const urlstring = window.location.origin + window.location.pathname;
            window.history.pushState('', '', replaceUrlParam(urlstring, 'type', url));
        }

        function replaceUrlParam(url, paramName, paramValue)
        {
            if (paramValue == null) {
                paramValue = '';
            }
            var pattern = new RegExp('\\b('+paramName+'=).*?(&|#|$)');
            if (url.search(pattern)>=0) {
                return url.replace(pattern,'$1' + paramValue + '$2');
            }
            url = url.replace(/[?#]$/,'');
            return url + (url.indexOf('?')>0 ? '&' : '?') + paramName + '=' + paramValue;
        }
    </script>
@endsection


