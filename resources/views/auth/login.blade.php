
<form id="form-login" method="post" action="{{ '/login' }}" data-request-flash="error">
    <input type="hidden" name="_handler" value="login">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="relative mb-4">
        <label for="username-lg" class="Inter-Regular text-base text-[#191D23]">Nhập địa chỉ email</label>
        <input type="email" placeholder="Nhập mã số nhân viên" id="username-lg" value="{{old('email') ?? ''}}" name="email" required
               class="w-full px-4 py-2 mt-2 border rounded focus:outline-none h-11 {{(session('error') || $errors->first('email')) ? 'input-error' : ''}}" autocomplete="off" tabindex="1">
        <span class="invalid-feedback text-[#EF4444] Inter-Regular text-sm leading-4">{{session('error')}} {{ $errors->first('email') }}</span>
    </div>
    <div class="relative mb-4">
        <div class="flex items-center justify-between">
            <label for="password-lg" class="Inter-Regular text-base text-[#191D23]">Mật khẩu</label>
            <button
                type="button"
                data-te-toggle="modal"
                data-te-target="#forgetPasswordModal"
                data-te-ripple-init
                data-te-ripple-color="light"
                class="Inter-SemiBold text-sm leading-4 text-[#0079ED] cursor-pointer">
                <span>Quên mật khẩu</span>
            </button>
        </div>
        <div class="relative">
            <input type="password" placeholder="Nhập mật khẩu" id="password-lg" name="password" required
                   class="w-full px-4 py-2 mt-2 border rounded focus:outline-none h-11" autocomplete="off" tabindex="2">
            <i class="toggle-password fa fa-fw fa-eye"></i>
        </div>
        <p id="email_error" class="text-red-500 text-xs pt-1">{{ $errors->first('password') }}</p>
    </div>
    <div class="flex items-baseline justify-between">
        <button type="button" id="button_login_v2" class="w-full px-6 pb-2 pt-2.5 mt-4 rounded bg-[#FF0000] text-white Inter-SemiBold text-base">
            Đăng nhập
        </button>
    </div>
</form>
