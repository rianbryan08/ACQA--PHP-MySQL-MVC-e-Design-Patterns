<?php

class SendMail {

    private $Subject;
    private $Message;
    private $To;
    private $ToName;

    public function EnvioMail($Subject, $Message, $To, $ToName) {
        include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/conexao/Helpers/class.smtp.php';
        include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/conexao/Helpers/class.phpmailer.php';
        $this->Subject = $Subject;
        $this->Message = $Message;
        $this->To = $To;
        $this->ToName = $ToName;

        $Email = new PHPMailer();
        $Email->IsSMTP(); // Habilita o SMTP 
        $Email->SMTPAuth = true; //Ativa e-mail autenticado
        $Email->Host = MAILHOST; // Servidor de envio # verificar qual o host correto com a hospedagem as vezes fica como smtp.
        $Email->Port = MAILPORT; // Porta de envio
        $Email->Username = MAILUSER; //e-mail que serÃ¡ autenticado
        $Email->Password = MAILPASS; // senha do email
        $Email->SMTPSecure = MAILSECURE;
        // email do remetente da mensagem
        $Email->From =  $this->To;
        // nome do remetente do email
        $Email->FromName =  $this->ToName;
        // EndereÃ§o de destino do emaail, ou seja, pra onde vocÃª quer que a mensagem do formulÃ¡rio vÃ¡?
        $Email->AddReplyTo( $this->To,  $this->ToName);
        $Email->AddAddress(MAILUSER, SITENAME); // para quem serÃ¡ enviada a mensagem
        // ativa o envio de e-mails em HTML, se false, desativa.
        $Email->IsHTML(true);
        $Email->CharSet = 'utf-8';
        // informando no email, o assunto da mensagem
        $Email->Subject = $this->Subject;
        $Email->Body = $this->Message;
        $Email->AltBody = strip_tags($this->Message);
        return $Email->Send();
        //$email = new Mail($assunto, $Email->Body, $etConfig->config_title, $etConfig->config_user, $ler->msg_name, $ler->msg_email);
        //$email->send();
        //if (!$Email->Send()):
        //     WLMsg("<strong>Erro:</strong> Falha ao enviar mensagem!", WS_ERROR);
        //    WLMsg("{$Email->ErrorInfo}", WS_ERROR);
        // else:
        //    WLMsg("<strong>Sucesso!</strong> Mensagem enviada.", WS_ACCEPT);
        // endif;
    }

}
