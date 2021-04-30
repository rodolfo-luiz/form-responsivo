$(function () {

    $('#form-contato').validator();


    // quando o formulário é enviado
    $('#form-contato').on('submit', function (e) {

        // Se o validador não impedir o envio:
        if (!e.isDefaultPrevented()) {
            var url = "contato.php";

            $.ajax({
                type: "POST",
                url: url,
                data: $(this).serialize(),
                success: function (data)
                {
                    // data = objeto JSON que o contato.php retorna

                    var messageAlert = 'alert-' + data.type;
                    var messageText = data.message;

                    // Bootstrap html box (alerta)
                    var alertBox = '<div class="alert ' + messageAlert + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + messageText + '</div>';
                    
                    // Se tivermos messageAlert e messageText
                    if (messageAlert && messageText) {
                        // Adiciona o alerta a .messages div no formulário
                        $('#form-contato').find('.messages').html(alertBox);
                        // limpar o formulário
                        $('#form-contato')[0].reset();
                    }
                }
            });
            return false;
        }
    })
});