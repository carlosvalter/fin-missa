$(function () {
    $("form").submit(function (e) {
        e.preventDefault();

        var form = $(this);
        var action = form.attr("action");
        var data = form.serialize();

        $.ajax({
            url: action,
            data: data,
            type: "post",
            dataType: "json",
            beforeSend: function (load) {
                // code here
            },
            success: function (su) {

                if (su.message) {
                    var type = {
                        info: 'Informação',
                        warning: 'Atenção',
                        danger: 'Erro',
                        success: 'Sucesso'
                    };

                    var animateType = {
                        info: 'animated fadeInDown',
                        warning: 'animated bounce',
                        danger: 'animated bounce',
                        success: 'animated fadeInDown'
                    };

                    $.notify({
                        // options
                        icon: 'flaticon-alarm-1',
                        title: type[su.message.type],
                        message: su.message.message
                    }, {
                        // settings
                        type: su.message.type,
                        placement: {
                            from: 'top',
                            align: 'center'
                        },
                        animate: {
                            enter: animateType[su.message.type],
                            exit: 'animated fadeOutUp'
                        },
                    });

                    if (su.message.type === "success") {
                        document.getElementById('form').reset();
                        if (typeof reLoad === 'function') {
                            setTimeout(reLoad, 3000);
                        }
                    }
                    return;
                }

                if (su.redirect) {
                    window.location.href = su.redirect.url;
                }
            }
        });
    });
});