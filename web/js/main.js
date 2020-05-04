$(document).ready(function() {
    multiSelect();
    maskInput();
    formValidate();
});

function multiSelect() {
    var multiselect = $('#products-multiselect');

    multiselect.multiselect({
        buttonText: function(options, select) {
            if (options.length === 0) {
                return 'Товары не выбраны ...';
            }
            else if (options.length === multiselect.find('option').length) {
                return 'Выбраны все товары ...'
            }
            else if (options.length > 3) {
                return 'Выбрано больше 3 товаров ...';
            }
            else {
                var labels = [];
                options.each(function() {
                    if ($(this).attr('label') !== undefined) {
                        labels.push($(this).attr('label'));
                    }
                    else {
                        labels.push($(this).html());
                    }
                });
                return labels.join(', ') + '';
            }
        }
    });
}

function maskInput() {
    $('input#phone').inputmask("+7 999-999-9999");
    $('input#email').inputmask("email");
}

function formValidate() {
    $('#form-bx24').on('submit', function (e) {

        var phone = $(this).find('#phone').val();
        var regPhone = /^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/i;
        var validPhone = regPhone.test(phone);


        var email = $(this).find('#email').val();
        var regEmail = /[\.a-z0-9_\-]+[@][a-z0-9_\-]+([.][a-z0-9_\-]+)+[a-z]{1,4}/i;
        var validEmail = regEmail.test(email);

        var error = $('.alert-wrapper');

        error.empty();

        if (!validPhone) {
            e.preventDefault();
            var str = '<div class="alert alert-danger" role="alert"> Неправильный номер телефона </div>';
            error.append(str);
        }

        if (!validEmail) {
            e.preventDefault();
            var str = '<div class="alert alert-danger" role="alert"> Неправильный Email </div>';
            error.append(str);
        }
    });
}

