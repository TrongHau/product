<form id="frm-register" method="post" action="{{ '/login' }}" data-request-flash="error,validate">
    <input type="hidden" name="_handler" value="register">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="grid gap-4 mb-3">
        <div class="relative">
            <label for="name" class="Inter-Regular text-base text-[#191D23]">Họ và Tên<span class="text-[#FF0000]">*</span></label>
            <input type="text" id="name" name="name" placeholder="Nhập họ và tên" class="w-full px-4 py-2 border rounded focus:outline-none h-11 {{ $errors->first('name') ? 'input-error' : '' }}">
            <span class="invalid-feedback text-[#EF4444] Inter-Regular text-sm leading-4">{{ $errors->first('name') }}</span>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4 mb-3">
        <div class="relative">
            <label for="email" class="Inter-Regular text-base text-[#191D23]">Email <span class="text-[#FF0000]">*</span></label>
            <input type="email" placeholder="Nhập email" id="email" name="email" class="w-full px-4 py-2 border rounded focus:outline-none h-11 {{ $errors->first('name') ? 'input-error' : '' }}" >
            <span class="invalid-feedback text-[#EF4444] Inter-Regular text-sm leading-4">{{ $errors->first('name') }}</span>
        </div>
        <div class="relative">
            <label for="phone" class="Inter-Regular text-base text-[#191D23]">Số điện thoại <span class="text-[#FF0000]">*</span></label>
            <input type="text" placeholder="Nhập số điện thoại" id="phone" name="phone" class="w-full px-4 py-2 border rounded focus:outline-none h-11" >
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4 mb-3">
        <div class="relative mb-4">
            <label for="password" class="Inter-Regular text-base text-[#191D23]">Mật khẩu <span class="text-[#FF0000]">*</span></label>
            <div class="relative">
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" class="w-full px-4 py-2 border rounded focus:outline-none h-11 {{ $errors->first('password') ? 'input-error' : '' }}">
                <i class="toggle-password fa fa-fw fa-eye top-3.5"></i>
            </div>
            <span class="invalid-feedback text-[#EF4444] Inter-Regular text-sm leading-4">{{ $errors->first('password') }}</span>
        </div>
        <div class="relative mb-4">
            <label for="password_confirmation" class="Inter-Regular text-base text-[#191D23]">Nhập lại mật khẩu <span class="text-[#FF0000]">*</span></label>
            <div class="relative">
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Nhập lại mật khẩu" class="w-full px-4 py-2 border rounded focus:outline-none h-11 {{ $errors->first('password_confirmation') ? 'input-error' : '' }}" >
                <i class="toggle-password fa fa-fw fa-eye top-3.5"></i>
            </div>
            <span class="invalid-feedback text-[#EF4444] Inter-Regular text-sm leading-4">{{ $errors->first('password_confirmation') }}</span>
        </div>
    </div>
    <button
        data-callback='onSubmit'
        data-action='submit'
        id="register2"
        class="g-recaptcha hidden inline-block w-full rounded bg-[#FF0000] px-6 pb-2 pt-2.5 text-base font-normal leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out focus:outline-none"
        data-te-ripple-init
        data-te-ripple-color="light">
        Đăng ký tài khoản
    </button>
    <button
        type="button"
        id="register"
        class="inline-block w-full rounded bg-[#FF0000] px-6 pb-2 pt-2.5 text-base font-normal leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out focus:outline-none"
        data-te-ripple-init
        data-te-ripple-color="light">
        Đăng ký tài khoản
    </button>
</form>
<div
    data-te-modal-init
    class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
    id="otp_verification"
    data-te-backdrop="static"
    data-te-keyboard="false"
    tabindex="-1"
    aria-labelledby="otpVerificationModalCenterTitle"
    aria-modal="true"
    role="dialog">
    <div
        data-te-modal-dialog-ref
        class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
        <div
            class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
            <div
                class="flex flex-shrink-0 items-center justify-between rounded-t-md p-4 pb-0">
                <!--Modal title-->
                <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200 w-full text-center"
                    id="otpVerificationModalScrollableLabel">
                </h5>
                <!--Close button-->
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

            <!--Modal body-->
            <div class="relative p-4 pt-0 pb-7">
                <form action="javascript: void(0)" class="otp-form" name="otp-form">
                    <div class="w-full m-auto text-center Inter-Regular">
                        <p class="Inter-SemiBold font-bold text-lg mb-4">Nhập mã xác thực</p>
                        <p class="text-lg">Nhập mã gồm 6 chữ số được gửi tới ******<span class="last-three-numbers">9876</span></p>
                    </div>
                    <div class="m-auto bg-white w-full flex justify-center gap-2.5 p-6 otp-input-fields">
                        <input type="number" class="otp__digit otp__field__1 w-12 h-14 bg-[#E7EAEE] rounded-lg text-center outline-none text-[19px] font-extrabold text-[#19B88B]" maxlength="1">
                        <input type="number" class="otp__digit otp__field__2 w-12 h-14 bg-[#E7EAEE] rounded-lg text-center outline-none text-[19px] font-extrabold text-[#19B88B]" maxlength="1">
                        <input type="number" class="otp__digit otp__field__3 w-12 h-14 bg-[#E7EAEE] rounded-lg text-center outline-none text-[19px] font-extrabold text-[#19B88B]" maxlength="1">
                        <input type="number" class="otp__digit otp__field__4 w-12 h-14 bg-[#E7EAEE] rounded-lg text-center outline-none text-[19px] font-extrabold text-[#19B88B]" maxlength="1">
                        <input type="number" class="otp__digit otp__field__5 w-12 h-14 bg-[#E7EAEE] rounded-lg text-center outline-none text-[19px] font-extrabold text-[#19B88B]" maxlength="1">
                        <input type="number" class="otp__digit otp__field__6 w-12 h-14 bg-[#E7EAEE] rounded-lg text-center outline-none text-[19px] font-extrabold text-[#19B88B]" maxlength="1">
                    </div>
                    <p class="text-[#4B5768] Inter-Regular countdown text-center">Gửi lại mã sau: <span class="font-bold"><span id="countdowntimer" class="Inter-SemiBold">180</span> giây</span></p>
                    <p class="Inter-SemiBold hidden message-resend-code text-center">Mã xác thực đã hết hạn: <span class="resend-code text-[#0066C7] font-extrabold cursor-pointer">Gửi lại mã</span></p>
                </form>
            </div>
        </div>
    </div>
</div>
