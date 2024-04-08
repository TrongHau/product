<html lang="en">

<head>
    <title>@hasSection('template_title')@yield('template_title')@endif</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="@hasSection('template_description')@yield('template_description')@endif">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layout.meta')
    @yield('css')
    <meta name="turbo-visit-control" content="reload" />
</head>

<body class="font-sans">
<!-- Header -->
<header id="layout-header" class="pt-[80px]">
    @include('layout.header_top')
</header>
<!-- Content -->
<section id="layout-content">
    @yield('content')
</section>
<div
    data-te-modal-init
    class="fixed top-0 left-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
    id="imageModal"
    tabindex="-1"
    data-te-backdrop="static"
    data-te-keyboard="false"
    aria-labelledby="imageModalTitle"
    aria-modal="true"
    role="dialog">
    <div data-te-modal-dialog-ref class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
        <div class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
            <div class="flex flex-shrink-0 items-center rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                <button
                    type="button"
                    class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
                    data-te-modal-dismiss
                    aria-label="Close">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="h-6 w-6">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="relative p-4">
                <img id="modalImage" class="modal-content">
            </div>
        </div>
    </div>
</div>
<script src="{{ 'assets/js/jquery.min.js' }}"></script>
<script type="module" src="{{ 'assets/lib/tw-elements/js/tw-elements.umd.min.js' }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ 'assets/lib/jquery-validate/js/jquery.validate.min.js' }}"></script>
<script src="https://unpkg.com/alpinejs@3.10.5/dist/cdn.min.js" defer></script>
</body>
<script>
    var loaded = false;
    var csrfToken = "{{csrf_token()}}";
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        statusCode: {
        },
    });
    $( document ).ajaxStop(function() {
        // clearTimeout(timeOutLoading);
        // waitingDialog.hide();
        loaded = false;
    });
</script>
<script>
</script>
@yield('scripts')
</html>


