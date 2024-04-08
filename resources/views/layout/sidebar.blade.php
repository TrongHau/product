@php
    $user = \Illuminate\Support\Facades\Auth::user();
@endphp
<header id="layout-header">
    <nav aria-label="menu nav" class="bg-white py-0 px-6 mt-0 min-h-[80px] w-full z-20 top-0 pl-[300px] flex justify-between">
        <div class="flex">
            @hasSection('title_header')@yield('title_header')@endif
        </div>
        <div class="flex">
            @if($user)
                @php
                    $role = \App\Models\Role_User::where('user_id', $user->id)->first();
                @endphp
            <div class="relative inline-block drop-button cursor-pointer" onclick="toggleDD('myDropdown')">
                <div class="flex items-center justify-center mt-3">
                    <img class="w-12 h-12 object-cover rounded-full mx-2" src="https://lendon.jtexpress.vn/themes/jt-len-don/assets/images/default-avatar.png" alt="">
                    <div class="text-left">
                        <span class="Inter-SemiBold text-sm text-[#000000]">{{$user->name}}</span>
                        <br>
                        <span class="Inter-SemiBold text-sm text-[#F20000]">{{$role->role->name ?? ''}}</span>
                    </div>
                    <div class="h-12 -mt-5">
                        <svg class="h-12" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_10448_20169)">
                                <path d="M16.59 8.59L12 13.17L7.41 8.59L6 10L12 16L18 10L16.59 8.59Z" fill="#0D0F11"></path>
                            </g>
                            <defs>
                                <clipPath id="clip0_10448_20169">
                                    <rect width="24" height="24" fill="white"></rect>
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                </div>
            </div>
            <div id="myDropdown" class="dropdownlist absolute bg-white shadow-[0_12px_24px_0_rgba(0,0,0,0.10)] text-[#323A46] right-0 mt-10 p-3 overflow-auto z-30 invisible rounded">
                <a href="/logout"
                   class="p-2 hover:text-[#F20000] text-[#323A46] text-sm no-underline hover:no-underline block cursor-pointer flex items-center dropdown-item">
                    <span>Đăng xuất</span>
                </a>
            </div>
            <script>
                function toggleDD(myDropMenu) {
                    document.getElementById(myDropMenu).classList.toggle("invisible");
                }
                $(document).on("mouseleave", "#myDropdown", function(){
                    document.getElementById('myDropdown').classList.toggle("invisible");
                })
            </script>
            @endif
        </div>
    </nav>
</header>
<aside id="sidebar-multi-level-sidebar" class="fixed w-[300px] top-0 left-0 z-40 h-screen open-sidebar" aria-label="Sidebar">
    <div class="h-full px-7 py-4 overflow-y-auto bg-white" style="padding-top: 0px">
        <a href="{{ '/' }}" aria-label="Home">
            <svg class="logo_menu_open min-h-[4.8rem] logo-nav ml-5 mt-2" width="165" height="45" viewBox="0 0 149 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_10343_20113)">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M23.6071 0.0971121H32.5565L31.5867 4.34689H31.5982L25.5046 31.1149L1.50781 31.1255L2.23053 29.8101L3.07764 28.1745L4.76134 24.8972H18.0006L23.6089 0.0971121H23.6071ZM61.6342 0.0988897L97.8785 0.0784454L95.8339 2.12467H86.8031L85.644 3.27311H94.6872L93.6684 4.29089H93.6719L93.0219 4.94067H83.8754L82.7278 6.08555H91.8735L89.3829 8.56555H79.405L73.8055 31.1158H65.0804L66.0029 27.1068H66.0098L70.6545 8.56645H57.0325L61.6351 0.0980004L61.6342 0.0988897ZM40.5747 24.4188C43.7678 27.9016 49.2718 24.4188 49.2718 24.4188L43.5567 17.5976C43.201 18.0224 37.379 20.9371 40.5738 24.4181L40.5747 24.4188ZM57.3987 24.5621L62.7467 31.1068H54.6436L52.9274 29.2508C48.7471 31.242 44.2504 31.242 44.2504 31.242C37.4972 31.3736 34.0974 28.2029 34.0974 28.2029C27.3241 20.2518 39.3666 12.7638 39.3666 12.7638C35.3213 8.21801 36.2656 3.92645 36.2656 3.92645C37.1319 0.116667 37.1224 0.0891122 37.1224 0.0891122H57.0614L52.38 8.61889C52.3484 8.56823 52.4973 6.97889 52.464 6.93355C52.5998 5.12733 50.655 4.21623 48.6797 4.21623C46.3021 4.21623 44.3731 6.11845 44.3153 8.48289C44.2995 8.62511 44.2951 8.77 44.3066 8.91578C44.3171 9.08111 44.3503 9.25355 44.3916 9.42778C44.5133 10.0429 44.7612 10.61 45.1055 11.1024C47.2473 14.7647 52.9283 19.0883 52.9283 19.0883C53.7063 18.9461 54.5612 14.1148 54.5612 14.1148L60.7328 15.8901C60.166 20.7246 57.3987 24.5621 57.3987 24.5621ZM90.2029 25.9469H85.8665L85.3077 28.8936H90.167L89.7509 31.1158H82.2916L84.6024 18.9317H91.8094L91.3759 21.1548H86.7882L86.2835 23.7594H90.6172L90.2029 25.946V25.9469ZM97.8611 31.1167L97.0296 28.6597C96.7958 27.9176 96.5978 27.3389 96.3806 26.5797H96.3455C95.9478 27.2668 95.6219 27.8811 95.099 28.7487L93.671 31.1167H90.548L95.099 24.8972L92.9667 18.9317H95.7121L96.4524 21.2634C96.6688 22.0242 96.8326 22.5655 97.0131 23.2891H97.0664C97.5185 22.4571 97.8252 21.8775 98.2228 21.2278L99.6323 18.9317H102.739L98.2946 24.9166L100.625 31.1167H97.8611ZM105.684 24.6092C105.955 24.6624 106.243 24.698 106.676 24.698C108.249 24.698 109.278 23.6855 109.278 22.4758C109.278 21.3006 108.429 20.9202 107.418 20.9202C106.93 20.9202 106.586 20.9558 106.37 21.0108L105.684 24.6092ZM104.166 19.1656C104.943 18.9673 106.172 18.8402 107.346 18.8402C108.429 18.8402 109.693 19.0225 110.578 19.6544C111.39 20.2144 111.897 21.066 111.897 22.2403C111.897 23.7781 111.192 24.9335 110.235 25.6749C109.242 26.4535 107.834 26.7967 106.352 26.7967C105.919 26.7967 105.557 26.7611 105.286 26.7237L104.455 31.1167H101.908L104.166 19.1656ZM115.963 24.3548H117.046C118.454 24.3548 119.484 23.5061 119.484 22.3122C119.484 21.3362 118.652 20.9015 117.624 20.9015C117.136 20.9015 116.828 20.938 116.613 20.9923L115.963 24.3548ZM114.39 19.1665C115.204 18.9682 116.433 18.8411 117.641 18.8411C118.798 18.8411 119.991 19.0225 120.839 19.5478C121.633 20.0163 122.194 20.794 122.194 21.9327C122.194 23.7416 120.983 24.8616 119.429 25.3682V25.4412C120.153 25.7486 120.46 26.5612 120.586 27.6634C120.729 29.0198 120.839 30.6117 121.056 31.1167H118.383C118.275 30.7922 118.148 29.7434 118.021 28.2421C117.913 26.7602 117.407 26.3077 116.378 26.3077H115.584L114.679 31.1167H112.097L114.39 19.1665ZM130.54 25.9469H126.205L125.645 28.8936H130.502L130.088 31.1158H122.63L124.94 18.9317H132.148L131.714 21.1548H127.126L126.622 23.7594H130.954L130.54 25.946V25.9469ZM132.489 28.1585C133.209 28.5923 134.235 28.9353 135.353 28.9353C136.361 28.9353 137.28 28.4668 137.28 27.5095C137.28 26.8251 136.757 26.3753 135.641 25.7984C134.342 25.0944 133.119 24.1558 133.119 22.57C133.119 20.1175 135.264 18.6207 137.91 18.6207C139.388 18.6207 140.252 18.9461 140.774 19.2341L139.963 21.3975C139.566 21.1825 138.703 20.8393 137.695 20.8571C136.488 20.8571 135.857 21.4705 135.857 22.1371C135.857 22.8411 136.595 23.2722 137.621 23.85C139.1 24.6243 140.036 25.6172 140.036 27.0588C140.036 29.7646 137.802 31.1514 135.101 31.1514C133.407 31.1514 132.201 30.7194 131.623 30.2874L132.489 28.1585ZM141.311 28.1585C142.03 28.5923 143.057 28.9353 144.174 28.9353C145.183 28.9353 146.102 28.4668 146.102 27.5095C146.102 26.8251 145.579 26.3753 144.463 25.7984C143.166 25.0944 141.941 24.1558 141.941 22.57C141.941 20.1175 144.085 18.6207 146.731 18.6207C148.209 18.6207 149.073 18.9461 149.595 19.2341L148.785 21.3975C148.389 21.1825 147.525 20.8393 146.516 20.8571C145.309 20.8571 144.678 21.4705 144.678 22.1371C144.678 22.8411 145.417 23.2722 146.444 23.85C147.921 24.6243 148.858 25.6172 148.858 27.0588C148.858 29.7646 146.624 31.1514 143.923 31.1514C142.229 31.1514 141.022 30.7194 140.446 30.2874L141.311 28.1585Z" fill="#FF0000"/>
                </g>
                <defs>
                    <clipPath id="clip0_10343_20113">
                        <rect width="148.923" height="32" fill="white"/>
                    </clipPath>
                </defs>
            </svg>
            <svg class="logo_menu_close hidden min-h-[4.8rem] logo-nav -ml-3 mt-2" width="80" height="60" viewBox="0 0 149 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_10343_20113)">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M23.6071 0.0971121H32.5565L31.5867 4.34689H31.5982L25.5046 31.1149L1.50781 31.1255L2.23053 29.8101L3.07764 28.1745L4.76134 24.8972H18.0006L23.6089 0.0971121H23.6071ZM61.6342 0.0988897L97.8785 0.0784454L95.8339 2.12467H86.8031L85.644 3.27311H94.6872L93.6684 4.29089H93.6719L93.0219 4.94067H83.8754L82.7278 6.08555H91.8735L89.3829 8.56555H79.405L73.8055 31.1158H65.0804L66.0029 27.1068H66.0098L70.6545 8.56645H57.0325L61.6351 0.0980004L61.6342 0.0988897ZM40.5747 24.4188C43.7678 27.9016 49.2718 24.4188 49.2718 24.4188L43.5567 17.5976C43.201 18.0224 37.379 20.9371 40.5738 24.4181L40.5747 24.4188ZM57.3987 24.5621L62.7467 31.1068H54.6436L52.9274 29.2508C48.7471 31.242 44.2504 31.242 44.2504 31.242C37.4972 31.3736 34.0974 28.2029 34.0974 28.2029C27.3241 20.2518 39.3666 12.7638 39.3666 12.7638C35.3213 8.21801 36.2656 3.92645 36.2656 3.92645C37.1319 0.116667 37.1224 0.0891122 37.1224 0.0891122H57.0614L52.38 8.61889C52.3484 8.56823 52.4973 6.97889 52.464 6.93355C52.5998 5.12733 50.655 4.21623 48.6797 4.21623C46.3021 4.21623 44.3731 6.11845 44.3153 8.48289C44.2995 8.62511 44.2951 8.77 44.3066 8.91578C44.3171 9.08111 44.3503 9.25355 44.3916 9.42778C44.5133 10.0429 44.7612 10.61 45.1055 11.1024C47.2473 14.7647 52.9283 19.0883 52.9283 19.0883C53.7063 18.9461 54.5612 14.1148 54.5612 14.1148L60.7328 15.8901C60.166 20.7246 57.3987 24.5621 57.3987 24.5621ZM90.2029 25.9469H85.8665L85.3077 28.8936H90.167L89.7509 31.1158H82.2916L84.6024 18.9317H91.8094L91.3759 21.1548H86.7882L86.2835 23.7594H90.6172L90.2029 25.946V25.9469ZM97.8611 31.1167L97.0296 28.6597C96.7958 27.9176 96.5978 27.3389 96.3806 26.5797H96.3455C95.9478 27.2668 95.6219 27.8811 95.099 28.7487L93.671 31.1167H90.548L95.099 24.8972L92.9667 18.9317H95.7121L96.4524 21.2634C96.6688 22.0242 96.8326 22.5655 97.0131 23.2891H97.0664C97.5185 22.4571 97.8252 21.8775 98.2228 21.2278L99.6323 18.9317H102.739L98.2946 24.9166L100.625 31.1167H97.8611ZM105.684 24.6092C105.955 24.6624 106.243 24.698 106.676 24.698C108.249 24.698 109.278 23.6855 109.278 22.4758C109.278 21.3006 108.429 20.9202 107.418 20.9202C106.93 20.9202 106.586 20.9558 106.37 21.0108L105.684 24.6092ZM104.166 19.1656C104.943 18.9673 106.172 18.8402 107.346 18.8402C108.429 18.8402 109.693 19.0225 110.578 19.6544C111.39 20.2144 111.897 21.066 111.897 22.2403C111.897 23.7781 111.192 24.9335 110.235 25.6749C109.242 26.4535 107.834 26.7967 106.352 26.7967C105.919 26.7967 105.557 26.7611 105.286 26.7237L104.455 31.1167H101.908L104.166 19.1656ZM115.963 24.3548H117.046C118.454 24.3548 119.484 23.5061 119.484 22.3122C119.484 21.3362 118.652 20.9015 117.624 20.9015C117.136 20.9015 116.828 20.938 116.613 20.9923L115.963 24.3548ZM114.39 19.1665C115.204 18.9682 116.433 18.8411 117.641 18.8411C118.798 18.8411 119.991 19.0225 120.839 19.5478C121.633 20.0163 122.194 20.794 122.194 21.9327C122.194 23.7416 120.983 24.8616 119.429 25.3682V25.4412C120.153 25.7486 120.46 26.5612 120.586 27.6634C120.729 29.0198 120.839 30.6117 121.056 31.1167H118.383C118.275 30.7922 118.148 29.7434 118.021 28.2421C117.913 26.7602 117.407 26.3077 116.378 26.3077H115.584L114.679 31.1167H112.097L114.39 19.1665ZM130.54 25.9469H126.205L125.645 28.8936H130.502L130.088 31.1158H122.63L124.94 18.9317H132.148L131.714 21.1548H127.126L126.622 23.7594H130.954L130.54 25.946V25.9469ZM132.489 28.1585C133.209 28.5923 134.235 28.9353 135.353 28.9353C136.361 28.9353 137.28 28.4668 137.28 27.5095C137.28 26.8251 136.757 26.3753 135.641 25.7984C134.342 25.0944 133.119 24.1558 133.119 22.57C133.119 20.1175 135.264 18.6207 137.91 18.6207C139.388 18.6207 140.252 18.9461 140.774 19.2341L139.963 21.3975C139.566 21.1825 138.703 20.8393 137.695 20.8571C136.488 20.8571 135.857 21.4705 135.857 22.1371C135.857 22.8411 136.595 23.2722 137.621 23.85C139.1 24.6243 140.036 25.6172 140.036 27.0588C140.036 29.7646 137.802 31.1514 135.101 31.1514C133.407 31.1514 132.201 30.7194 131.623 30.2874L132.489 28.1585ZM141.311 28.1585C142.03 28.5923 143.057 28.9353 144.174 28.9353C145.183 28.9353 146.102 28.4668 146.102 27.5095C146.102 26.8251 145.579 26.3753 144.463 25.7984C143.166 25.0944 141.941 24.1558 141.941 22.57C141.941 20.1175 144.085 18.6207 146.731 18.6207C148.209 18.6207 149.073 18.9461 149.595 19.2341L148.785 21.3975C148.389 21.1825 147.525 20.8393 146.516 20.8571C145.309 20.8571 144.678 21.4705 144.678 22.1371C144.678 22.8411 145.417 23.2722 146.444 23.85C147.921 24.6243 148.858 25.6172 148.858 27.0588C148.858 29.7646 146.624 31.1514 143.923 31.1514C142.229 31.1514 141.022 30.7194 140.446 30.2874L141.311 28.1585Z" fill="#FF0000"/>
                </g>
                <defs>
                    <clipPath id="clip0_10343_20113">
                        <rect width="148.923" height="32" fill="white"/>
                    </clipPath>
                </defs>
            </svg>
        </a>
        <div data-sidebar-target="icon" onclick="collapseSideBar(this)" data-value="open" id="collapse_sidebar" class="absolute right-2 top-2 cursor-pointer bg-gray-50 p-1" style="top: 87px;right: -12px;">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
        </div>
        <ul class="space-y-4 font-medium sidebar-menu mt-5">
            <li class="{{(Request::is('product') || Request::is('edit-product')) ? 'active' : ''}} rounded-[0.8rem] px-2 py-2 hover:bg-gray-100">
                <a href="/product" class="flex items-center p-2 text-gray-900 dark:text-white dark:hover:bg-gray-700 group">
{{--                    <svg fill="gray" width="20" xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 0 512 512">--}}
{{--                        <path d="M234.5 5.7c13.9-5 29.1-5 43.1 0l192 68.6C495 83.4 512 107.5 512 134.6V377.4c0 27-17 51.2-42.5 60.3l-192 68.6c-13.9 5-29.1 5-43.1 0l-192-68.6C17 428.6 0 404.5 0 377.4V134.6c0-27 17-51.2 42.5-60.3l192-68.6zM256 66L82.3 128 256 190l173.7-62L256 66zm32 368.6l160-57.1v-188L288 246.6v188z"/>--}}
{{--                    </svg>--}}
                    <svg fill="gray" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="28" height="30" viewBox="0 0 128 128" style="margin-right: -5px; margin-left: -1px;">
                        <path stroke="gray" stroke-width="4" d="M63,14.2l-48,17c-1.2,0.4-2,1.6-2,2.8v60c0,1.3,0.8,2.4,2,2.8l48,17c0.3,0.1,0.7,0.2,1,0.2c0.2,0,0.3,0,0.5,0 c0,0,0.1,0,0.1,0c0.1,0,0.2-0.1,0.3-0.1c0,0,0,0,0,0l48-17c1.2-0.4,2-1.6,2-2.8V34c0,0,0-0.1,0-0.1c0-0.1,0-0.3,0-0.4 c0,0,0-0.1,0-0.1c-0.2-1-0.9-1.9-1.9-2.2l-24-8.5c0,0-0.1,0-0.1,0c-0.6-0.2-1.4-0.3-2.1,0L40,39.2c-1.2,0.4-2,1.6-2,2.8v11 c0,1.7,1.3,3,3,3s3-1.3,3-3v-8.9l43.8-15.5L103,34L63,48.2c-1.2,0.4-2,1.5-2,2.8c0,0,0,0,0,0.1v55.8L19,91.9V36.1l46-16.3 c1.6-0.6,2.4-2.3,1.8-3.8C66.3,14.4,64.6,13.6,63,14.2z M67,53.1l42-14.9v53.6l-42,14.9V53.1z"></path>
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">Quản lý Sản phẩm</span>
                </a>
            </li>
            <li class="{{Request::is('create-product') ? 'active' : ''}} rounded-[0.8rem] px-2 py-2 hover:bg-gray-100">
                <a href="/create-product" class="flex items-center p-2 text-gray-900 dark:text-white dark:hover:bg-gray-700 group">
                    <svg fill="gray" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="32" height="32" viewBox="2 -1 28 28" style="margin-right: -11px; margin-left: -1px;">
                        <path stroke="gray" stroke-width="0.2" d="M 12 2 C 6.4889971 2 2 6.4889971 2 12 C 2 17.511003 6.4889971 22 12 22 C 17.511003 22 22 17.511003 22 12 C 22 6.4889971 17.511003 2 12 2 z M 12 4 C 16.430123 4 20 7.5698774 20 12 C 20 16.430123 16.430123 20 12 20 C 7.5698774 20 4 16.430123 4 12 C 4 7.5698774 7.5698774 4 12 4 z M 11 7 L 11 11 L 7 11 L 7 13 L 11 13 L 11 17 L 13 17 L 13 13 L 17 13 L 17 11 L 13 11 L 13 7 L 11 7 z"></path>
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">Thêm Sản phẩm</span>
                </a>
            </li>
            <li class="{{Request::is('supplier') ? 'active' : ''}} rounded-[0.8rem] px-2 py-2 hover:bg-gray-100">
                <a href="/supplier" class="flex items-center p-2 text-gray-900 dark:text-white dark:hover:bg-gray-700 group">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="32" height="32" viewBox="0,0,256,256" style="gray">
                        <defs><clipPath id="clip-1"><path stroke="gray" stroke-width="2" d="M0,256v-256h256v256zM164.79521,219.63077c0.78769,9.45231 1.57538,11.81538 1.96923,14.17846v0.78769c1.96923,7.48308 8.27077,12.60308 15.36,12.60308h56.32c9.45231,0 16.93538,-7.08923 16.93538,-16.93538v-46.08c0,-7.48308 -4.72615,-13.39077 -12.20923,-15.75385c-1.18154,-0.39385 -2.36308,-0.39385 -3.54462,-0.39385c-0.39385,0 -0.78769,0 -1.18154,0c0,0 -2.36308,0.39385 -5.51385,0.39385c0,-0.39385 0,-0.78769 0,-1.18154c0,-12.60308 -10.24,-22.44923 -22.84308,-22.44923c-12.20923,0 -22.44923,10.24 -22.44923,22.44923c0,0.39385 0,0.78769 0,1.18154c-1.18154,0 -2.36308,0 -3.54462,-0.39385c-0.78769,0 -1.57538,0 -2.36308,0c-3.15077,0 -6.30154,1.18154 -8.66462,2.75692c-2.36308,1.96923 -5.51385,5.12 -6.30154,11.42154c-0.39385,1.96923 -0.78769,7.08923 -1.96923,18.90462c-0.39385,1.96923 0,3.54462 0,4.33231c0.39385,1.96923 0.78769,3.54462 1.57538,4.72615c-0.39385,0.39385 -0.39385,1.18154 -0.78769,1.57538c-0.78769,2.75692 -0.78769,5.90769 -0.78769,7.87692z" id="overlayBgMask" fill="none"></path></clipPath></defs><g clip-path="url(#clip-1)" fill="gray" fill-rule="nonzero" stroke="gray" stroke-width="2" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(5.12,5.12)" fill="#000000"><path d="M24.96289,1.05469c-0.20987,0.00724 -0.41214,0.08036 -0.57812,0.20898l-23,17.94727c-0.43579,0.33978 -0.51361,0.96851 -0.17383,1.4043c0.33978,0.43579 0.96851,0.51361 1.4043,0.17383l1.38477,-1.08008v26.29102c0.00006,0.55226 0.44774,0.99994 1,1h13.83203c0.10799,0.01785 0.21818,0.01785 0.32617,0h11.67383c0.10799,0.01785 0.21818,0.01785 0.32617,0h13.8418c0.55226,-0.00006 0.99994,-0.44774 1,-1v-26.29102l1.38477,1.08008c0.2819,0.21983 0.65967,0.27257 0.991,0.13833c0.33133,-0.13423 0.56586,-0.43504 0.61526,-0.7891c0.0494,-0.35406 -0.09386,-0.70757 -0.37579,-0.92736l-7.61523,-5.94141v-7.26953h-6v2.58594l-9.38477,-7.32227c-0.18607,-0.14428 -0.41707,-0.21828 -0.65234,-0.20898zM25,3.32227l19,14.82617v26.85156h-12v-19h-14v19h-12v-26.85156zM37,8h2v3.70898l-2,-1.5625zM20,28h10v17h-10z"></path></g></g><g fill="gray" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="translate(172.58462,152.48) scale(3.93846,3.93846)" id="overlay"><g id="Слой_2" font-family="Inter, apple-system, BlinkMacSystemFont, &quot;Helvetica Neue&quot;, &quot;Segoe UI&quot;, &quot;Fira Sans&quot;, Roboto, Oxygen, Ubuntu, &quot;Droid Sans&quot;, Arial, sans-serif" font-weight="400" font-size="16" text-anchor="start" visibility="hidden"></g><g id="Android_x5F_4" font-family="Inter, apple-system, BlinkMacSystemFont, &quot;Helvetica Neue&quot;, &quot;Segoe UI&quot;, &quot;Fira Sans&quot;, Roboto, Oxygen, Ubuntu, &quot;Droid Sans&quot;, Arial, sans-serif" font-weight="400" font-size="16" text-anchor="start" visibility="hidden"></g><g id="Android_x5F_5" font-family="Inter, apple-system, BlinkMacSystemFont, &quot;Helvetica Neue&quot;, &quot;Segoe UI&quot;, &quot;Fira Sans&quot;, Roboto, Oxygen, Ubuntu, &quot;Droid Sans&quot;, Arial, sans-serif" font-weight="400" font-size="16" text-anchor="start" visibility="hidden"></g><g fill="gray" id="Windows_x5F_8" font-family="Inter, apple-system, BlinkMacSystemFont, &quot;Helvetica Neue&quot;, &quot;Segoe UI&quot;, &quot;Fira Sans&quot;, Roboto, Oxygen, Ubuntu, &quot;Droid Sans&quot;, Arial, sans-serif" font-weight="400" font-size="16" text-anchor="start" visibility="hidden"></g><g fill="gray" id="Windows_x5F_10" font-family="Inter, apple-system, BlinkMacSystemFont, &quot;Helvetica Neue&quot;, &quot;Segoe UI&quot;, &quot;Fira Sans&quot;, Roboto, Oxygen, Ubuntu, &quot;Droid Sans&quot;, Arial, sans-serif" font-weight="400" font-size="16" text-anchor="start" visibility="hidden"></g><g id="Color" stroke="gray" stroke-width="2" font-family="Inter, apple-system, BlinkMacSystemFont, &quot;Helvetica Neue&quot;, &quot;Segoe UI&quot;, &quot;Fira Sans&quot;, Roboto, Oxygen, Ubuntu, &quot;Droid Sans&quot;, Arial, sans-serif" font-weight="400" font-size="16" text-anchor="start" visibility="hidden"></g><g id="IOS" font-family="Inter, apple-system, BlinkMacSystemFont, &quot;Helvetica Neue&quot;, &quot;Segoe UI&quot;, &quot;Fira Sans&quot;, Roboto, Oxygen, Ubuntu, &quot;Droid Sans&quot;, Arial, sans-serif" font-weight="400" font-size="16" text-anchor="start" visibility="hidden"></g><g id="IOS_copy"><path d="M17.4,5.9c-0.1,0 -0.3,0 -0.4,0c0,0 -3.3,0.3 -4.6,0.5c0,-0.1 0.1,-0.2 0.2,-0.4c0.5,-0.8 0.8,-1.3 0.8,-2.3c0,-2.1 -1.7,-3.7 -3.8,-3.7c-2.1,0 -3.8,1.7 -3.8,3.7c0,0.9 0.3,1.6 0.9,2.4c0.1,0.1 0.1,0.2 0.2,0.3c-1.2,-0.1 -4.3,-0.5 -4.3,-0.5c-0.6,-0.1 -1.1,0.1 -1.3,0.3c-0.4,0.3 -0.7,0.9 -0.8,1.6c0,0.3 -0.2,1.4 -0.5,4.8c0,0.2 0,0.4 0,0.6c0,0.2 0.2,0.9 0.8,1.2c0.7,0.2 1.2,-0.2 1.6,-0.5c0.1,-0.1 0.3,-0.2 0.5,-0.4c0.5,-0.4 0.9,-0.5 1.3,-0.5c1,0 1.8,0.8 1.8,1.7c0,1 -0.8,1.7 -1.8,1.7c-0.5,0 -0.8,-0.1 -1.3,-0.5c-0.1,-0.1 -0.3,-0.2 -0.4,-0.3c-0.3,-0.3 -0.8,-0.8 -1.5,-0.6c-0.3,0.1 -0.7,0.3 -0.9,0.9c-0.1,0.2 -0.1,0.7 -0.1,0.9c0.2,2.5 0.4,3 0.5,3.4v0.2c0.2,1 1,1.7 1.9,1.7h14.3c1.3,0 2.3,-0.9 2.3,-2.3v-11.8c0,-0.6 -0.2,-1.6 -1.6,-2.1zM17,19.8c0,0.2 0,0.3 -0.3,0.3h-14.2v-0.1v-0.2c-0.1,-0.3 -0.1,-0.6 -0.3,-1.9c0.7,0.4 1.3,0.6 2.1,0.6c2.1,0 3.8,-1.7 3.8,-3.7c0,-2.1 -1.7,-3.7 -3.8,-3.7c-0.9,0 -1.6,0.3 -2.1,0.7c0.2,-2.7 0.4,-3.3 0.4,-3.4v-0.1c0,-0.1 0,-0.1 0,-0.2c0.7,-0.1 3.1,0.2 4.1,0.3c0.9,0.1 1.6,-0.3 2,-0.9c0.3,-0.5 0.5,-1.4 -0.4,-2.5c-0.4,-0.6 -0.5,-0.9 -0.5,-1.3c0,-1 0.8,-1.7 1.8,-1.7c1,0 1.8,0.8 1.8,1.7c0,0.4 -0.1,0.5 -0.6,1.3c-0.8,1.3 -0.5,2.2 -0.2,2.6c0.4,0.6 1.1,0.9 1.9,0.8c1,-0.1 3.6,-0.4 4.4,-0.5v0v0c0,0 0,0 0,0.1v11.8z"></path></g></g></g>
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap ">Quản lý nhà cung cấp</span>
                </a>
            </li>
            <li class="{{Request::is('warehouse') ? 'active' : ''}} rounded-[0.8rem] px-2 py-2 hover:bg-gray-100">
                <a href="/warehouse" class="flex items-center p-2 text-gray-900 dark:text-white dark:hover:bg-gray-700 group">
                    <svg fill="gray" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 512 512" style="margin-top: -2px;">
                        <path stroke="gray" stroke-width="1" d="M243.4 2.6l-224 96c-14 6-21.8 21-18.7 35.8S16.8 160 32 160v8c0 13.3 10.7 24 24 24H456c13.3 0 24-10.7 24-24v-8c15.2 0 28.3-10.7 31.3-25.6s-4.8-29.9-18.7-35.8l-224-96c-8-3.4-17.2-3.4-25.2 0zM128 224H64V420.3c-.6 .3-1.2 .7-1.8 1.1l-48 32c-11.7 7.8-17 22.4-12.9 35.9S17.9 512 32 512H480c14.1 0 26.5-9.2 30.6-22.7s-1.1-28.1-12.9-35.9l-48-32c-.6-.4-1.2-.7-1.8-1.1V224H384V416H344V224H280V416H232V224H168V416H128V224zM256 64a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/>
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap ">Quản lý kho</span>
                </a>
            </li>
            <li class="{{Request::is('enter_warehouse') ? 'active' : ''}} rounded-[0.8rem] px-2 py-2 hover:bg-gray-100">
                <a href="/enter_warehouse" class="flex items-center p-2 text-gray-900 dark:text-white dark:hover:bg-gray-700 group">
                    <svg fill="gray" width="24" height="24" version="1.2" baseProfile="tiny" id="inventory" style="margin-top: -2px;"
                                             xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 256 230"
                                             xml:space="preserve">
                    <path d="M61.2,106h37.4v31.2H61.2V106z M61.2,178.7h37.4v-31.2H61.2V178.7z M61.2,220.1h37.4v-31.2H61.2V220.1z M109.7,178.7H147
                        v-31.2h-37.4V178.7z M109.7,220.1H147v-31.2h-37.4V220.1z M158.2,188.9v31.2h37.4v-31.2H158.2z M255,67.2L128.3,7.6L1.7,67.4
                        l7.9,16.5l16.1-7.7v144h18.2V75.6h169v144.8h18.2v-144l16.1,7.5L255,67.2z"/>
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap ">Nhập kho</span>
                </a>
            </li>

{{--            <li class="rounded-[0.8rem] px-2 py-1">--}}
{{--                <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">--}}

{{--                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">--}}
{{--                        <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>--}}
{{--                    </svg>--}}
{{--                    <span class="flex-1 ml-3 text-left whitespace-nowrap">Kho/Kho hàng</span>--}}
{{--                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">--}}
{{--                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>--}}
{{--                    </svg>--}}
{{--                </button>--}}
{{--                <ul id="dropdown-example" class="hidden py-2 space-y-2">--}}
{{--                    <li>--}}
{{--                        <a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Điều chỉnh tồn kho</a>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Dịch chuyển kho</a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>--}}
        </ul>
    </div>
</aside>

