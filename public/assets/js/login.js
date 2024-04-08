import forgetPass from "./forget-password.js";
import register from "./register.js";

$(document).ready(function(){
   $('#whoAreYou').select2({
       minimumResultsForSearch: Infinity
   });

    init();
    $("select[name='groups'] option[value='nhan-vien-buu-cuc']").attr("selected", true);
    $("select[name='groups']").trigger('change');
});

function init(){
    showHidePasswords();
    btnLogin();
    forgetPassword();
    handleRegister();
    hamburger();
}

function showHidePasswords() {
    $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        let input = $(this).parent().find("input");
        if (input.attr("type") === "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
}

function btnLogin() {
    $("#button_login_v2").on('click', function (e) {
        e.preventDefault();
        // Validate input
        if(validateFormLogin()){
            $('#form-login').submit();
        }
    });

    $('#password-lg').keypress(function(event){
        var id = event.which;
        if (id == 13) {
            $('#form-login').submit();
            return false;
        }
    });

    $("#username-lg").on('input', function (){
        validateFormLoginUsername();
    }).on('keypress', function(event){
        validateFormLoginUsername();
    });

    $("#password-lg").on('input', function (){
        validateFormLoginPassword();
    }).on('keypress', function(event){
        validateFormLoginPassword();
    });

}

function validateFormLogin() {
    let input_Login = $("#username-lg");
    let flag = true;

    if (input_Login.val().length === 0) {
        input_Login.parent().find('span.invalid-feedback').remove();
        input_Login.parent().append('<span class="invalid-feedback text-[#EF4444] Inter-Regular text-sm leading-4">Vui lòng nhập mã khách hàng</span>');
        input_Login.addClass('input-error');
        flag = false;
    } else {
        input_Login.parent().find('span.invalid-feedback').remove();
        input_Login.removeClass('input-error');
        flag = true;
    }

    let input_Password = $("#password-lg");

    if (input_Password.val().length === 0) {
        input_Password.parent().find('span.invalid-feedback').remove();
        input_Password.parent().append('<span class="invalid-feedback text-[#EF4444] Inter-Regular text-sm leading-4">Vui lòng nhập mật khẩu</span>');
        input_Password.addClass('input-error');
        flag = false;
    } else if (input_Password.val().length < 8) {
        input_Password.parent().find('span.invalid-feedback').remove();
        input_Password.parent().append('<span class="invalid-feedback text-[#EF4444] Inter-Regular text-sm leading-4">Mật khẩu ít nhất 8 ký tự</span>');
        input_Password.addClass('input-error');
        flag = false;
    } else if (input_Password.val().length > 40) {
        input_Password.parent().find('span.invalid-feedback').remove();
        input_Password.parent().append('<span class="invalid-feedback text-[#EF4444] Inter-Regular text-sm leading-4">Mật khẩu tối đa 40 ký tự</span>');
        input_Password.addClass('input-error');
        flag = false;
    } else {
        input_Password.parent().find('span.invalid-feedback').remove();
        input_Password.removeClass('input-error');
        flag = true;
    }

    return flag;
}

function validateFormLoginUsername() {
    let input_Login = $("#username-lg");
    let flag = true;

    if (input_Login.val().length === 0) {
        input_Login.parent().find('span.invalid-feedback').remove();
        input_Login.parent().append('<span class="invalid-feedback text-[#EF4444] Inter-Regular text-sm leading-4">Vui lòng nhập mã khách hàng</span>');
        input_Login.addClass('input-error');
        flag = false;
    } else {
        input_Login.parent().find('span.invalid-feedback').remove();
        input_Login.removeClass('input-error');
        flag = true;
    }

    return flag;
}

function validateFormLoginPassword() {
    let flag;
    let input_Password = $("#password-lg");

    if (input_Password.val().length === 0) {
        input_Password.parent().find('span.invalid-feedback').remove();
        input_Password.parent().append('<span class="invalid-feedback text-[#EF4444] Inter-Regular text-sm leading-4">Vui lòng nhập mật khẩu</span>');
        input_Password.addClass('input-error');
        flag = false;
    } else if (input_Password.val().length < 8) {
        input_Password.parent().find('span.invalid-feedback').remove();
        input_Password.parent().append('<span class="invalid-feedback text-[#EF4444] Inter-Regular text-sm leading-4">Mật khẩu ít nhất 8 ký tự</span>');
        input_Password.addClass('input-error');
        flag = false;
    } else if (input_Password.val().length > 40) {
        input_Password.parent().find('span.invalid-feedback').remove();
        input_Password.parent().append('<span class="invalid-feedback text-[#EF4444] Inter-Regular text-sm leading-4">Mật khẩu tối đa 40 ký tự</span>');
        input_Password.addClass('input-error');
        flag = false;
    } else {
        input_Password.parent().find('span.invalid-feedback').remove();
        input_Password.removeClass('input-error');
        flag = true;
    }

    return flag;
}

function forgetPassword() {

    forgetPass.onForgetPassword();


    forgetPass.onSubmitNewPassword();

}

function handleRegister() {
    // thay đổi group
    register.handleChangeGroups();
    // sự kiện click button đăng ký
    register.onRegister();

    register.verifyOTP();

    register.resendOtp();

    register.checkProvince();
    register.checkEmployeeCode();
}

function hamburger(){
    const button = document.querySelector('#menu-button');
    const menu = document.querySelector('#mobile-menu');

    button.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });
}
