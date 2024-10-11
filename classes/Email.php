<?php 
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{

    public $email;
    public $nombre;
    public $token;

    public function __construct($nombre, $email, $token)
    {
        $this->nombre=$nombre;
        $this->email=$email;
        $this->token=$token;
    }


    public function enviarConfirmacion(){
        $mail=new PHPMailer();
        $mail->isSMTP();
        $mail->Host=$_ENV['EMAIL_HOST'];
        $mail->SMTPAuth=true;
        $mail->Port=$_ENV['EMAIL_PORT'];
        $mail->Username=$_ENV['EMAIL_USER'];
        $mail->Password=$_ENV['EMAIL_PASS'];
        $mail->SMTPSecure='ssl';
        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject='Confirma tu cuenta';
        $mail->SMTPDebug = false; 
        
        
        //set HTML
        $mail->isHTML(TRUE);
        
        $contenido="<html>";
        $contenido.= "<p><strong>Hola! ".$this->nombre."</strong> Has creado tu cuenta en AppSalon, solo debes confirmarla presionando el siguiente enlace</p>";
        $contenido.="<p>Presiona aqui: <a href='". $_ENV['APP_URL'] ."/confirmar-cuenta?token="
        .$this->token. "'>Confirmar cuenta</a> </p>";
        $contenido.="<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .="</html>";
        
        $mail->Body=$contenido;
        //enviar email
        $mail->send();

    }


    public function enviarInstrucciones(){

        $mail=new PHPMailer();
        $mail->isSMTP();
        $mail->Host=$_ENV['EMAIL_HOST'];
        $mail->SMTPAuth=true;
        $mail->Port=$_ENV['EMAIL_PORT'];
        $mail->Username=$_ENV['EMAIL_USER'];
        $mail->Password=$_ENV['EMAIL_PASS'];
        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject='Restablece tu cuenta';
        $mail->SMTPDebug = false; 
        
        
        //set HTML
        $mail->isHTML(TRUE);
        
        $contenido="<html>";
        $contenido.= "<p><strong>Hola ".$this->nombre."</strong> Has solicitado restablecer tu password,
        continua presionando el siguiente enlace para restablecer</p>";
        $contenido.="<p>Presiona aqui: <a href='". $_ENV['APP_URL'] ."/recuperar?token="
        .$this->token. "'>Restablecer password</a> </p>";
        $contenido.="<p>Si tú no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .="</html>";
        
        $mail->Body=$contenido;
        //enviar email
        $mail->send();



    }

}




?>
