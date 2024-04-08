
<!-- modal forget password -- start -->
<div
    data-te-modal-init
    class="fixed top-0 left-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
    id="forgetPasswordModal"
    tabindex="-1"
    data-te-backdrop="static"
    data-te-keyboard="false"
    aria-labelledby="forgetPasswordModalTitle"
    aria-modal="true"
    role="dialog">
    <div data-te-modal-dialog-ref class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
        <div class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
            <div class="flex flex-shrink-0 items-center rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                <h5 class="Inter-SemiBold text-xl text-[#0D0F11] w-full text-center"
                    id="exampleModalScrollableLabel">
                    Xác nhận thay đổi mật khẩu
                </h5>
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
                <div class="relative mb-4">
                    <label for="phone_id" class="Inter-Regular text-base text-[#191D23]">Email</label>
                    <input type="email" placeholder="Vui lòng nhập địa chỉ email" id="email_forgot_password" name="email" class="w-full px-4 py-2 mt-2 border rounded focus:outline-none h-11" autocomplete="off">
                    <p id="email_error" class="text-red-500 text-xs pt-1"></p>
                </div>
                <div class="justify-between text-center">
                    <button type="button"
                            class="w-50 h-11 px-6 py-2 mt-4 rounded bg-[#FF0000] text-white Inter-SemiBold text-base"
                            id="button_forget_password">Gửi yêu cầu</button>
                    <button type="submit" class="hidden" id="button_submit_forget_password"></button>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- modal forget password -- end -->
<!-- modal otp forget password -- start -->
<div
    data-te-modal-init
    class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
    id="fgp_otp_verification"
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
            <div class="flex flex-shrink-0 items-center justify-between rounded-t-md p-4 pb-0">
                <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200 w-full text-center"
                    id="otpVerificationModalScrollableLabel">
                </h5>
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
                <form action="javascript: void(0)" class="forget-otp-form" name="forget-otp-form">
                    <div class="w-full m-auto text-center Inter-Regular">
                        <p class="Inter-SemiBold font-bold text-lg mb-4">Nhập mã xác thực</p>
                        <p class="text-lg">Nhập mã gồm 6 chữ số được gửi tới ******<span class="last-four-numbers">9876</span></p>
                    </div>
                    <div id="otp_input" class="m-auto bg-white w-full flex justify-center gap-2.5 p-6 otp-input-fields">
                        <input type="number" class="fg__otp__digit otp__field__1 w-12 h-14 bg-[#E7EAEE] rounded-lg text-center outline-none text-[19px] font-extrabold text-[#19B88B]" maxlength="1">
                        <input type="number" class="fg__otp__digit otp__field__2 w-12 h-14 bg-[#E7EAEE] rounded-lg text-center outline-none text-[19px] font-extrabold text-[#19B88B]" maxlength="1">
                        <input type="number" class="fg__otp__digit otp__field__3 w-12 h-14 bg-[#E7EAEE] rounded-lg text-center outline-none text-[19px] font-extrabold text-[#19B88B]" maxlength="1">
                        <input type="number" class="fg__otp__digit otp__field__4 w-12 h-14 bg-[#E7EAEE] rounded-lg text-center outline-none text-[19px] font-extrabold text-[#19B88B]" maxlength="1">
                        <input type="number" class="fg__otp__digit otp__field__5 w-12 h-14 bg-[#E7EAEE] rounded-lg text-center outline-none text-[19px] font-extrabold text-[#19B88B]" maxlength="1">
                        <input type="number" class="fg__otp__digit otp__field__6 w-12 h-14 bg-[#E7EAEE] rounded-lg text-center outline-none text-[19px] font-extrabold text-[#19B88B]" maxlength="1">
                    </div>
                    <p id="otp_error" class="text-red-500 text-xs text-center"></p>
                    <p class="text-[#4B5768] Inter-Regular countdown text-center">Gửi lại mã sau: <span class="font-bold"><span id="forger-countdowntimer" class="Inter-SemiBold">180</span> giây</span></p>
                    <p class="Inter-SemiBold hidden forget-message-resend-code text-center">Mã xác thực đã hết hạn: <span id="resend-code" class="resend-code text-[#0066C7] font-extrabold cursor-pointer">Gửi lại mã</span></p>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- modal otp forget password -- end -->

<!-- modal set login forget password -- start -->
<div
    data-te-modal-init
    class="fixed top-0 left-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
    id="setLoginForgetPasswordModal"
    tabindex="-1"
    data-te-backdrop="static"
    data-te-keyboard="false"
    aria-labelledby="setLoginForgetPasswordModalTitle"
    aria-modal="true"
    role="dialog">
    <div data-te-modal-dialog-ref class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
        <div class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
            <div class="flex flex-shrink-0 items-center rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                <h5 class="Inter-SemiBold text-xl text-[#0D0F11] w-full text-center"
                    id="exampleModalScrollableLabel">
                    Thiết lập mật khẩu mới
                </h5>
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
                <div class="relative mb-4">
                    <input type="hidden" id="fg_key">
                    <label for="password_fg" class="Inter-Regular text-base text-[#191D23]">Mật khẩu</label>
                    <input type="password" placeholder="Vui lòng nhập mật khẩu" id="password_fg" name="login" class="w-full px-4 py-2 my-2 border rounded focus:outline-none h-11" autocomplete="off" tabindex="1">
                    <label for="retype_password_fg" class="Inter-Regular text-base text-[#191D23]">Nhập lại mật khẩu</label>
                    <input type="password" placeholder="Vui lòng nhập lại mật khẩu" id="retype_password_fg" name="login" class="w-full px-4 py-2 mt-2 border rounded focus:outline-none h-11" autocomplete="off" tabindex="2">
                    <p id="password_fg_error" class="text-red-500 text-xs pt-1"></p>
                </div>
                <div class="justify-between text-center">
                    <button type="button"
                            class="w-50 h-11 px-6 py-2 mt-4 rounded bg-[#FF0000] text-white Inter-SemiBold text-base"
                            id="button_new_password">Gửi yêu cầu</button>
                    <button type="submit" class="hidden" id="button_submit_new_password"></button>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- modal set login forget password -- end -->

<!-- modal complete forget password -- start -->
<div
    data-te-modal-init
    class="fixed top-0 left-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
    id="completeForgetPasswordModal"
    tabindex="-1"
    data-te-backdrop="static"
    data-te-keyboard="false"
    aria-labelledby="completeForgetPasswordModalTitle"
    aria-modal="true"
    role="dialog">
    <div data-te-modal-dialog-ref class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
        <div class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
            <div class="flex flex-shrink-0 items-center rounded-t-md border-none border-neutral-100 border-opacity-100 p-2 dark:border-opacity-50">
                <h5 class="Inter-SemiBold text-xl text-[#0D0F11] w-full text-center"
                    id="exampleModalScrollableLabel">
                </h5>
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
            <div class="relative p-4 text-center items-center justify-center">
                <h1 class="Inter-Regular countdown text-center text-sm mb-0 mt-0">
                    <svg class="h-50 w-50 m-auto" style="color: rgb(16, 185, 129);" xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16"> <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" fill="#10b981"></path> <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" fill="#10b981"></path></svg>
                </h1>
                <h2 class="pt-2 Inter-Regular countdown text-center text-base">Mật khẩu đã được thiết lập lại</h2>
                <p class="pt-2 pb-4 Inter-Regular countdown text-center text-sm">Bạn vui lòng ghi nhớ mật khẩu nhé</p>
            </div>

        </div>
    </div>
</div>
<!-- modal complete forget password -- end -->
