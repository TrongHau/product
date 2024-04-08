<html lang="en">

<head>
    <title>@hasSection('template_title')@yield('template_title')@endif</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="@hasSection('template_description')@yield('template_description')@endif">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    @include('layout.meta')
    @yield('css')
    <meta name="turbo-visit-control" content="reload" />
    <style>
        body {
            font-family: 'Montserrat';
        }
    </style>
</head>

<body class="font-montserrat">
<!-- Header -->
@include('layout.sidebar')
<!-- Content -->
<section id="layout-content">
    <div id="body-content" class="p-4 ml-[300px] bg-gray-50">
        @yield('content')
    </div>
</section>
<footer class="w-full h-[150px]">

</footer>
<button
    type="button"
    data-te-toggle="modal"
    data-te-target="#forgetPasswordModal"
    data-te-ripple-init
    data-te-ripple-color="light"
    class="Inter-SemiBold text-sm leading-4 text-[#0079ED] cursor-pointer">
</button>
<script type="module" src="{{ '/assets/lib/tw-elements/js/tw-elements.umd.min.js' }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ '/assets/lib/jquery-validate/js/jquery.validate.min.js' }}"></script>
<script src="https://unpkg.com/alpinejs@3.10.5/dist/cdn.min.js" defer></script>
{{--<link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" />--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
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
@yield('scripts')
<script>
    $('.sidebar-menu').find('.active a').css('color', 'red');
    $('.sidebar-menu').find('.active a').css('font-weight', 'bold');
    $('.sidebar-menu').find('.active').css('background', 'rgb(249 250 251 / var(--tw-bg-opacity))');
    $('.sidebar-menu').find('.active').find('path').attr('fill', 'red');
    $('.sidebar-menu').find('.active').find('path').attr('stroke', 'red');
    $('.sidebar-menu').find('.active a').removeClass('hover:bg-gray-100');
    function collapseSideBar(e) {
        var dataCollapse = $(e).data('value');
        if(dataCollapse == 'open') {
            $(e).css('transform', 'rotate(180deg)');
            $(e).data('value', 'close');
            $('.sidebar-menu').find('.whitespace-nowrap').addClass('hidden');
            $('.logo_menu_open').addClass('hidden');
            $('.logo_menu_close').removeClass('hidden');
            $('#sidebar-multi-level-sidebar').css('width', '112px');
            $('#body-content').css('margin-left', '112px');
            $('#layout-header nav').css('padding-left', '112px');
        }else{
            $(e).css('transform', 'rotate(0deg)');
            $(e).data('value', 'open');
            $('.sidebar-menu').find('.whitespace-nowrap').removeClass('hidden');
            $('.logo_menu_open').removeClass('hidden');
            $('.logo_menu_close').addClass('hidden');
            $('#sidebar-multi-level-sidebar').css('width', '300px');
            $('#body-content').css('margin-left', '300px');
            $('#layout-header nav').css('padding-left', '300px');
        }
        localStorage.setItem("collapse_sidebar", dataCollapse);
    }
    if(localStorage.getItem("collapse_sidebar") == 'open') {
        $('#collapse_sidebar').trigger('click');
        $('#body-content').css('margin-left', '112px');
    }
    setTimeout(() => {
        $('#body-content').addClass('transition-all duration-300');
    }, 500);
</script>
</html>


