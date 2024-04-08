class Register {
    verifyOTP() {
        const otp_inputs = document.querySelectorAll(".otp__digit");
        const myKey = "0123456789".split("");
        let wrong_number_of_times = 0;
        otp_inputs.forEach((_) => {
            _.addEventListener("keyup", handle_next_input)
        })

        function handle_next_input(event) {
            let current = event.target
            let index = parseInt(current.classList[1].split("__")[2])
            current.value = event.key

            if (event.keyCode === 8 && index > 1) {
                current.previousElementSibling.focus()
            }
            if (index < 6 && myKey.indexOf("" + event.key + "") !== -1) {
                const next = current.nextElementSibling;
                next.focus()
            }
            let _finalKey = "";
            for (let {value} of otp_inputs) {
                _finalKey += value
            }

            //gọi api check
            if(_finalKey.length === 6) {
                //call check
                oc.ajax('onOtpVerify', {
                    data: { otp: _finalKey }
                }).done((response) => {
                    let rs = $.parseJSON(response.result);

                    if (rs.error === 1) {
                        $('input.otp__digit').addClass('input-error');
                        wrong_number_of_times = wrong_number_of_times + 1;
                    } else {
                        $('input.otp__digit').removeClass('input-error');

                        //submit form
                        $("button#register2").trigger("click");
                    }
                });

                // TODO:: huỷ mã OTP khi nhập sai quá 5 lần
                // if(wrong_number_of_times === 5){
                //     return false;
                // }
            }
        }
    }

    onRegister() {
        $("button#register").on('click', function () {
            if (register.formValidate()) {

                let on_off_otp = $('input[name="is-otp"]').val();

                if ($.trim(on_off_otp).length !== 0) {
                    // OTP on
                    // handling send otp
                    register.onSubmitRegister();
                } else {
                    // OTP off
                    $("button#register2").trigger("click");
                }

                return false;
            }
        });
    }

    formValidate() {
        const form = $('#frm-register');

        jQuery.validator.addMethod("laxUsername", function(value, element) {
            // allow any non-whitespace characters as the host part
            return this.optional( element ) || /^[a-zA-Z0-9]([._-](?![._-])|[a-zA-Z0-9]){3,18}[a-zA-Z0-9]$/.test( value );
        }, 'Tên đăng nhập không đúng định dạng.');

        form.validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 255
                },
                surname: {
                    required: true,
                    maxlength: 255
                },
                email: {
                    required: true,
                    maxlength: 255,
                    email: true
                },
                phone: {
                    required: true,
                    maxlength: 15,
                    minlength: 10,
                    number: true
                },
                username: {
                    required: true,
                    maxlength: 255,
                    minlength: 3,
                    laxUsername: true
                },
                password: {
                    required: true,
                    minlength: 8
                },
                password_confirmation: {
                    required: true,
                    minlength: 8,
                    equalTo: "#password"
                },
                postal_code: {
                    required: true,
                    maxlength: 6,
                    minlength: 6
                }
            },
            messages: {
                name: {
                    required: "Vui lòng nhập tên.",
                    maxlength: 'Tên tối đa 255 ký tự.'
                },
                surname: {
                    required: "Vui lòng nhập họ.",
                    maxlength: 'Họ tối đa 255 ký tự.'
                },
                email: {
                    required: "Vui lòng nhập email.",
                    maxlength: 'Email tối đa 255 ký tự.',
                    email: 'Vui lòng nhập một địa chỉ email hợp lệ.'
                },
                phone: {
                    required: "Vui lòng nhập số điện thoại.",
                    maxlength: "Số điện thoại tối đa 15 ký tự.",
                    minlength: "Số điện thoại ít nhất 10 ký tự.",
                    number: "Vui lòng nhập một số hợp lệ."
                },
                username: {
                    required: "Vui lòng nhập tên đăng nhập.",
                    maxlength: "Tên đăng nhập tối đa 255 ký tự.",
                    minlength: "Tên đăng nhập ít nhất 3 ký tự.",
                    laxUsername: "Tên đăng nhập không đúng định dạng."
                },
                password: {
                    required: "Vui lòng cung cấp mật khẩu.",
                    minlength: "Mật khẩu của bạn phải dài ít nhất 8 ký tự."
                },
                password_confirmation: {
                    required: "Vui lòng cung cấp mật khẩu.",
                    minlength: "Mật khẩu của bạn phải dài ít nhất 8 ký tự.",
                    equalTo: "Mật khẩu không khớp."
                },
                postal_code: {
                    required: "Vui lòng nhập mã bưu cục.",
                    maxlength: "Mã bưu cục tối đa 6 ký tự.",
                    minlength: "Mã bưu cục ít nhất 6 ký tự."
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback text-[#EF4444] Inter-Regular text-sm leading-4');
                element.parent().append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid input-error');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid input-error');
            }
        });

        return (form.valid());
    }

    onSubmitRegister() {
        let phone = $("input[name=phone]").val();
        $(".last-three-numbers").text(phone.slice(-4));
        $("#otp_verification").modal('show');
        // Count down timer
        register.countDownTimer();

        //xử lý gửi mã xác thực OTP
        oc.ajax('onSendOtp', {
            data: { mobile: phone }
        }).done(function (response) {
            // console.log(response);
        });
    }

    countDownTimer() {
        let timeLeft = 180;
        const downloadTimer = setInterval(function () {
            timeLeft--;
            document.getElementById("countdowntimer").textContent = String(timeLeft);
            if (timeLeft <= 0) {
                clearInterval(downloadTimer);
                $(".message-resend-code").removeClass('hidden');
                $(".countdown").addClass('hidden');
                // gọi api xoá session opt khi timeout
                oc.ajax('onOtpRemove').done((response) => {
                    // console.log(response);
                });
            }
        }, 1000);
    }

    resendOtp() {
        $(".resend-code").on('click', (event) => {
            $(".message-resend-code").addClass('hidden');
            $(".countdown").removeClass('hidden');
            // Count down timer
            register.countDownTimer();

            //xử lý gửi mã xác thực OTP
            let phone = $("input[name=phone]").val();
            oc.ajax('onSendOtp', {
                data: { mobile: phone }
            }).done(function (response) {
                // console.log(response);
            });
        });
    }

    handleChangeGroups() {
        $("select[name='groups']").on('change',(event) => {
            let value = event.target.value;
            if(value === 'nhan-vien-buu-cuc') {
                $('div.postal-code').removeClass('hidden');
            }else{
                $('#postal_code').val('');
                $('#postal_code-error').remove();
                $('#postal_code').removeClass('is-invalid input-error');
                $('#postal_code').removeAttr('aria-describedby aria-invalid data-gtm-form-interact-field-id');
                $('div.postal-code').addClass('hidden');
            }
        });
    }

    checkProvince() {
        $("#postal_code").on('blur change',function(){
            let value = $(this).val();
            if (value.length > 0) {
                oc.ajax('onCheckProvince', {
                    data: { postal_code: value }
                }).done(function(response){
                    if (response.province_id != 0) {
                        $('input[name="province_id"]').val(response.province_id);

                        $('button#register').removeAttr('disabled');
                        $('button#register').removeClass('cursor-not-allowed');

                        $('#postal_code').removeClass('is-invalid input-error');
                        $('#postal_code-error').remove();
                    } else {
                        $('input[name="province_id"]').val(0);

                        $('button#register').attr('disabled', 'disabled');
                        $('button#register').addClass('cursor-not-allowed');

                        $('#postal_code').addClass('is-invalid input-error');
                        $('#postal_code').attr('aria-describedby', 'postal_code-error');
                        $('#postal_code').attr('aria-invalid', 'true');

                        $('#postal_code-error').remove();
                        $('#postal_code').parent().append('<span id="postal_code-error" class="error invalid-feedback text-[#EF4444] Inter-Regular text-sm leading-4">' + response.message + '</span>');

                    }
                });
            }
        });
    }
    checkEmployeeCode(){
        $("#frm-register #username").on('keyup',function(e){
            let username = $(this).val();
            if(register.checkLiveFirstname(username)){
                $('#username-error').remove();
                $('#username').removeClass('is-invalid input-error');
            }else{
                $('#username').addClass('is-invalid input-error');
                $('#username-error').remove();
                $("#username").parent().append('<span id="username-error" class="error invalid-feedback text-[#EF4444] Inter-Regular text-sm leading-4">Tên đăng nhập không đúng định dạng.</span>');
            }
        }).on('paste', function(e){
            var cb = e.originalEvent.clipboardData || window.clipboardData;
            let username = cb.getData('text');
            if(register.checkLiveFirstname(username)){
                $('#username-error').remove();
                $('#username').removeClass('is-invalid input-error');
            } else {
                $('#username').addClass('is-invalid input-error');
                $('#username-error').remove();
                $("#username").parent().append('<span id="username-error" class="error invalid-feedback text-[#EF4444] Inter-Regular text-sm leading-4">Tên đăng nhập không đúng định dạng.</span>');
            }
        });
    }

    checkLiveFirstname(username){
        var liveStrongPtrn = /^[A-Za-z0-9_-]{5,15}$/;
        if(liveStrongPtrn.test(username)){
            return true;
        }else{
            return false;
        }
    }
}

let register;
export default register = new Register();
