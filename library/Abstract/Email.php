<?php

Class Abstract_Email {

    public static $ASSUNTO_CADASTRO = '[Sistema de Gerenciamento de Projetos] Confirmação de Cadastro';
    public static $ASSUNTO_CONFIRMACAO = '[Sistema de Gerenciamento de Projetos] Validação de Cadastro';
    public static $MSG_CADASTRO = ' <p>
            Prezado <b>FULANO</b>,
            <br/>
            <br/>
            Seu cadastro foi realizado com <span style="color: green"><b>sucesso</b></span> no <b>::LINC::Sistema de Gerenciamento de Projetos</b>.
            <br/>
            Para utilizar o sistema, seu cadastro <span style="color: red">precisa ser aprovado</span> por nossos administradores. Quando isto acontecer você será notificado por e-mail e terá acesso ao sistema.
            <br/>
            <br/>
            Agradecemos a compreensão.
        </p>';
    public static $MSG_CONFIRMACAO = '
        <p>
            Prezado <b>FULANO</b>,
            <br/>
            <br/>
            Seu cadastro foi <b style="color: green">aprovado</b> e você já possui acesso ao sistema <b>::LINC::Sistema de Gerenciamento de Projetos</b>.
            <br/>
            Clique <a href="#">aqui</a> ou cole a url _URL na barra de endereços do seu navegador.
            <br/>
            Caso tenha alguma dúvida de como utilizar o sistema, envie um email para <a href="linc.ufpa@gmail.com">linc.ufpa@gmail.com</a>
            <br/>
            <br/>
            Obrigado!
        </p>
        ';
    public static $MSG_CONVITE = '
        <p>
            Prezado <b>FULANO</b>,
            <br/>
            <br/>
            Seu cadastro foi <b style="color: green">aprovado</b> e você já possui acesso ao sistema <b>::LINC::Sistema de Gerenciamento de Projetos</b>.
            <br/>
            Clique <a href="#">aqui</a> ou cole a url _URL na barra de endereços do seu navegador.
            <br/>
            Caso tenha alguma dúvida de como utilizar o sistema, envie um email para <a href="linc.ufpa@gmail.com">linc.ufpa@gmail.com</a>
            <br/>
            <br/>
            Obrigado!
        </p>
        ';

    // um método estático que permite verificar a validade
    // de um número de CPF
    public static function send($email_, $nome_, $assunto, $msg) {
        $email = "linc.ufpa@gmail.com";
        $pass = "linc13579";
        $settings = array('ssl' => 'ssl',
            'port' => 465,
            'auth' => 'login',
            'username' => $email,
            'password' => $pass);
        $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $settings);
        $email_from = $email;
        $name_from = utf8_decode("::LINC::Sistema de Gerenciamento de Projetos");
        $email_to = $email_;
        $name_to = utf8_decode($nome_);

        $mail = new Zend_Mail ();
        $mail->setReplyTo($email_from, $name_from);
        $mail->setFrom($email_from, $name_from);
        $mail->addTo($email_to, $name_to);
        $mail->setSubject(utf8_decode($assunto));
        $mail->setBodyHtml(utf8_decode($msg));
        $mail->send($transport);
    }

}

?>
