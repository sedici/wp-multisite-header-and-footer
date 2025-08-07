jQuery(document).ready(function ($) {
    if ($('#wp_multisite_hyf_form').length > 0) {
        $.ajax({
            type: "POST",
            url: ajax_var.url,
            data : {
                action: ajax_var.action,
            },
            success: function () {
                console.log('¡Exito!');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error en AJAX');
                console.error('Estado:', textStatus);
                console.error('Error:', errorThrown);
                console.error('Respuesta completa:', jqXHR.responseText);
            }
        });
    }
});