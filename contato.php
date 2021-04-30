<?php

// o email que aparece como remetente
$from = 'rodolfo@demaio.dev.br';

// o email que recebe as informações
$sendTo = 'rodolfo@demaio.dev.br';

// assunto do email
$subject = 'Novo cadastro';

// campos do form com suas respectivas informações.
// nome da variavel => Como irá aparecer no email
$fields = array('cpf' => 'CPF:', 'fullname' => 'Nome completo:', 'nasc' => 'Data de nascimento:', 'sexo' => 'Sexo:', 'tel' => 'Telefone:', 'email' => 'Email:', 'cep' => 'CEP:', 'rua' => 'Rua:', 'numero' => 'Número:', 'bairro' => 'Bairro:', 'comple' => 'Complemento:', 'refer' => 'Referência:', 'cidade' => 'Cidade:', 'uf' => 'Estado:', 'ibge' => 'Código IBGE:', 'prof' => 'Profissão:', 'empresa' => 'Empresa:', 'cnpj' => 'CNPJ Empregador:', 'renda' => 'Renda Mensal:', 'livre' => 'Campo Livre:'); 

// Se tudo estiver certo, essa mensagem irá aparecer
$okMessage = 'Cadastro enviado para analise, aguarde a resposta em seu email.';

// Se algo estiver errado, essa mensagem irá aparecer
$errorMessage = 'Houve um erro ao enviar as informações, tente novamente em breve.';

error_reporting(E_ALL & ~E_NOTICE);

try
{

    if(count($_POST) == 0) throw new \Exception('Informações incompletas');
            
    $emailText = "Novo cadastro para análise\n=============================\n";

    foreach ($_POST as $key => $value) {
        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }

    // Cabeçalhos do email
    $headers = array('Content-Type: text/plain; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
    );
    
    // Código que envia o email
    mail($sendTo, $subject, $emailText, implode("\n", $headers));

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}


// Se a requisição AJAX voltar com um JSON de resposta
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
    echo " <meta http-equiv='refresh' content='3;URL=index.html'>";
}
// Se não, apenas exibe:
else {
    echo $responseArray['message'];
    echo " <meta http-equiv='refresh' content='3;URL=index.html'>";
}
