class ForgetPassword {
    onForgetPassword() {
        $(document).on('click', "button#button_forget_password", async (event) => {
            $("#email_error").html('');
            const email = $('#email_forgot_password').val();
            if(!email) {
                $("#email_error").text('Vui lòng nhập địa chỉ email');
                return false;
            }
            if (forgetPassword.formValidate()) {
                $.ajax({
                    url: "/reset-password",
                    method: "POST",
                    data: {
                        email: email
                    },
                }).done(function() {
                    if (result.success) {
                        forgetPassword.onSubmitForgetPassword();
                        forgetPassword.countDownTimer();
                    } else {
                        $("#email_error").text(result.mesage);
                    }
                });

            }
        })
    }


    formValidate() {
        const fg_form = $("#phone_id")
        return true;
    }

    onSubmitForgetPassword() {
        const phone = $("#phone_id").val();
        $(".last-four-numbers").text(phone.slice(-4));
        $("#forgetPasswordModal").modal('hide');
        $("#fgp_otp_verification").modal('show');
        $("input.fg__otp__digit").first().focus();

    }

    countDownTimer() {
        let time = 180;
        document.getElementById("forger-countdowntimer").textContent = String(time);
        const downTimeRun = setInterval(function () {
            time--;
            document.getElementById("forger-countdowntimer").textContent = String(time);
            if (time <= 0) {
                clearInterval(downTimeRun);
                $(".forget-message-resend-code").removeClass('hidden');
                oc.ajax("onOtpRemove").done(res => {
                })
            }
        }, 1000)
    }

    resendOtp() {
        $('#resend-code').on("click", async (event) => {
            const resendOtpAjax = await oc.ajax('onResendOtp', {
            });
            const result = JSON.parse(resendOtpAjax.result)
            if (result.error === 1) {
                $('#otp_error').text("Đã có lỗi khi lấy lại OTP vui lòng tải lại trang");
            } else {
                $(".forget-message-resend-code").hide();
                $('#otp_error').text("");
                forgetPassword.countDownTimer();
            }
        })
    }

    onSubmitNewPassword() {
        $("button#button_new_password").on("click", async (event) => {
            const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d).{8,}$/;
            const new_password = $("#password_fg").val();
            const key = $("#fg_key").val();
            if (passwordRegex.test(new_password)) {
                $("#password_fg_error").text("");
                const retype_new_password = $("#retype_password_fg").val();
                if (new_password != retype_new_password) {
                    $("#password_fg_error").text("Mật khẩu không không khớp! ");
                } else {
                    const ocAjax = await oc.ajax('onSubmitChangePassword', {
                        data: { password: new_password, retype_password: retype_new_password, fg_key: key }
                    });
                    $("#setLoginForgetPasswordModal").modal("hide");
                    $('input').val('');
                    $("#completeForgetPasswordModal").modal("show");
                }
            } else {
                $("#password_fg_error").text("Mật khẩu vui lòng có ít nhất 8 kí tự bao gồm cả chữ và số! ");
            }
        })

    }
}
let forgetPassword;
export default forgetPassword = new ForgetPassword();
