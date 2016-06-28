$.fn.jValidate = function (options) {

    var form = $(this);
    var defaults =
    {
        url: '',
        persona: '',
        pattern: /(\w+@\w+\.[a-z]{2,5})|(\w+@\w+\.[a-z]{2,5}\.[a-z]{2,5})/,
        docId: -1,
        emailUser: '@',
        elements: '.numero, .correo, .obligatorio, .telefono, .documento, .clave',
        events: 'keyup keypress change click'
    };
    options = $.extend(defaults, options);

    form.on(options.events, options.elements, function () {
        validateFields($(this), event, options);
    });

    form.on('submit', function () {
        if (validateForm(options)) {
            SavePost();
        }
        else event.preventDefault()
    });
    form.find('#send-ajax').click(function () {

        if (validateForm(options)) {
            if (options.persona != '') {
                var doc = form.find('input.documento').val();
                var email = form.find('input.correo_unico').val();

                if (doc.length && doc != options.docId) {
                    $.post(options.url, {
                        'DOCUMENTO': doc,
                        PERSONA: options.persona
                    }, function (data) {
                        if (data == 'no') {
                            doc.closest('div').addClass('has-error error_documento');
                            $('body,html').animate({scrollTop: 0}, 200);
                        }
                        else {
                            if (email.length && options.emailUser != email) {
                                $.post(options.url, {
                                    'CORREO': email,
                                    PERSONA: options.persona
                                }, function (data) {
                                    if (data == 'no') {
                                        doc.closest('div').addClass('has-error error_documento');
                                        $('body,html').animate({scrollTop: 0}, 200);
                                    }
                                    else Save();
                                });
                            }
                            else Save();
                        }
                    });
                }
                else {
                    if (email.length && options.emailUser != email) {
                        $.post(options.url, {
                            'CORREO': email,
                            PERSONA: options.persona
                        }, function (data) {
                            if (data == 'no') {
                                doc.closest('div').addClass('has-error error_documento');
                                $('body,html').animate({scrollTop: 0}, 200);
                            }
                            else Save();
                        });
                    }
                    else Save();
                }
            }
            else {
                Save();
            }
        }
    });
}

function Alerta(message, callback, type, title) {
    if (!callback) {
        callback = function (dialogItself) {
            dialogItself.close();
        }
    }
    if (!type) type = BootstrapDialog.TYPE_SUCCESS;
    if (!title || title === true) title = '<span style="color: #ffffff;font-size: 20pt;"class="ion ion-checkmark-round"></span>&nbsp;&nbsp; <span style="font-size: 18pt;">Bien hecho...</span>'

    BootstrapDialog.show({
        title: title,
        message: message,
        draggable: true,
        type: type,
        buttons: [{
            label: 'Cerrar',
            action: callback
        }]
    });
}

function validateFields(field, event, options) {
    //Se elige la etiqueta div padre
    var div = field.closest('div');
    var validate = true;

    if ((field.val() == '' || field.val() == null)) {
        if (field.hasClass('obligatorio')) div.addClass('has-error error');
        else div.removeClass('has-error error_correo');
        validate = false;
    }
    else div.removeClass('error');

    if (field.hasClass('clave') && field.val() != '') {
        if ($('.confirmar').val() != $('.claveinicial').val()) {
            div.addClass('has-error error_clave');
        }
        else {
            $('.confirmar').closest('div').removeClass('has-error error_clave');
            $('.claveinicial').closest('div').removeClass('has-error error_clave');
        }
    }
    else if (field.hasClass('numero')) {
        if (field.hasClass('documento') && (event.type == 'change' || event.type == 'click')) {
            if (field.val() != '' && field.val() != options.docId) {
                $.post(options.url, {'DOCUMENTO': field.val(), PERSONA: options.persona}, function (data) {
                    if (data == 'no') {
                        validate = false;
                        div.addClass('has-error error_documento');
                    }
                    else if (field.val().length >= 5 && field.val().length <= 15) {
                        div.removeClass('has-error error_documento');
                    }
                });
            }
        }

        else if (field.hasClass('dinero')) {
            field.priceFormat({
                prefix: '$ ',
                thousandsSeparator: ','
            });
            div.removeClass('has-error');
        }
        else if (event.type == 'keypress') {
            var key = event.keyCode;
            if (key < 48 || key > 57) {
                if (field.hasClass('telefono') || field.hasClass('documento')) {
                    event.preventDefault();
                }
                else if (key == 46 || key == 8) {
                    if (field.hasClass('porcentaje')) {
                        if (field.val().indexOf('.') != -1) {
                            event.preventDefault();
                        }
                    }
                }
                else {
                    validate = false;
                    event.preventDefault();
                }
            }
            else {
                div.removeClass('has-error');
                if (field.hasClass('porcentaje')) {
                    if (!((field.val().length < 4 && field.val().indexOf('.') != -1) || field.val().length < 2)) {
                        event.preventDefault();
                    }
                    else {
                        div.removeClass('has-error');
                    }
                }
                else if (field.hasClass('telefono')) {
                    if (field.val().length < 6) {
                        validate = false;
                        div.addClass('error_telefono has-error');
                    }
                    else if (field.val().length >= 6 && field.val().length < 10) {
                        div.removeClass('error_telefono has-error');
                    }
                    else {
                        div.removeClass('error_telefono has-error');
                        event.preventDefault();
                    }
                }
                else if (field.hasClass('documento')) {
                    if (field.val().length < 4) {
                        div.addClass('error_documento_longitud has-error');
                        validate = false;
                    }
                    else if (field.val().length >= 4 && field.val().length <= 15) {
                        div.removeClass('error_documento_longitud has-error');
                    }
                    else {
                        div.removeClass('error_documento_longitud has-error');
                        event.preventDefault();
                    }
                }
            }
        }
    }
    else if (field.hasClass('correo')) {
        if (event.type == 'change' || event.type == 'click') {
            if (field.hasClass('correo_unico') && field.val() != '' && field.val() != options.emailUser) {
                $.post(options.url, {'CORREO': field.val(), PERSONA: options.persona}, function (data) {
                    if (data == 'no') {
                        validate = false;
                        div.addClass('has-error error_correo_existe');
                    }
                    else div.removeClass('has-error error_correo_existe');
                });
            }
        }
        else if (event.type == 'keyup') {
            if (field.val() == '') {
                div.removeClass('has-error error_correo_existe');
            }
            else if (!field.val().match(options.pattern)) {
                div.addClass('has-error error_correo');
                validate = false;
            }
            else div.removeClass('error_correo has-error');
        }
    }
    else if (validate) div.removeClass('error_correo has-error error_documento error_correo_existe error error_telefono error_documento_longitud');

    return validate;

}

function validateForm(options) {
    var pass = true;

    $('.obligatorio').each(function (index, element) {
            element = $(element);

            if (element.val() == '' || element.val() == null) {
                element.closest('div').addClass('has-error error');
                $('body,html').animate({scrollTop: 0}, 200);
                pass = false;
            }
            else if (element.hasClass('claveinicial') && element.val() != $('.confirmar').val()) {
                element.closest('div').addClass('has-error error_clave');
                $('body,html').animate({scrollTop: 0}, 200);
                pass = false;
            }
            else if (element.hasClass('correo')) {
                if (!element.val().match(options.pattern)) {
                    element.closest('div').addClass('has-error error_correo');
                    $('body,html').animate({scrollTop: 0}, 200);
                    pass = false;
                }
                else element.closest('div').removeClass('error_correo has-error');
            }
            else if (element.hasClass('correo_unico') && element.val() != '') {
                if (element.val() != '' && options.emailUser != element.val()) {
                    $.post(url, {'CORREO': element.val(), PERSONA: options.persona}, function (data) {
                        if (data == 'no') {
                            pass = false;
                            element.closest('div').removeClass('has-error error_correo_existe');
                        }
                        else element.closest('div').addClass('has-error error_correo_existe');
                    });
                }
            }
            else if (element.hasClass('documento')) {
                if (element.val().length < 5 || element.val().length > 15) {
                    element.closest('div').addClass('error_documento_longitud has-error');
                    pass = false;
                    $('body,html').animate({scrollTop: 0}, 200);
                }
            }
            else if (element.hasClass('telefono')) {
                if (element.val().length < 7 || element.val().length > 10) {
                    element.closest('div').addClass('error_telefono has-error');
                    pass = false;
                    $('body,html').animate({scrollTop: 0}, 200);
                }
            }
        }
    );
    if (!pass)Message();
    else killMessage();
    return pass;
}

function killMessage() {
    $('#jmsg').next('br').remove().end().remove();
}

function Message(Msg, Type, Element, Time) {
    if (!Element) Element = 'form.form-horizontal';

    if (!Msg)Msg = 'El formulario contiene los siguientes errores...';
    if (!Time && Time != 0)Time = 500;

    var icon = 'close-circled';
    switch (Type) {
        case 'danger':
            icon = 'close-circled';
            break;
        case 'warning':
            icon = 'close-circled';
            break;
        case 'info':
            icon = 'checkmark-round';
            break;
        case 'success':
            icon = 'checkmark-round';
            break;
        default :
            Type = 'danger';
            break;
    }
    $('#jmsg').next('br').remove().end().remove();
    $(Element).prepend($('<div id="jmsg"  style="font-size: 12pt;" class="callout callout-' + Type + ' no-margin">' +
        '<span style="cursor:pointer" onclick="killMessage()" class="ion ion-' + icon + '"></span>&nbsp;' + Msg + '</div><br>')).hide().show(Time);
}

/**
 * Generates fake data on inputs for faster
 * @Clue Call from Console
 */
function fakeData() {
    $('input:radio').iCheck('check');
    $('.numero').val(12);
    $('.correo').val('noreplay@hotmail.com');
    $('input:text, textarea').val(Math.random().toString(36).replace(/[^1-9a-z]+/g, '').substr(0, 9));
    $('#send-ajax').trigger('click');
}
