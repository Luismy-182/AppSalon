<?php 

namespace Controllers;


USE Model\Usuario;
USE MVC\Router;
use Classes\Email;
use Error;

class LoginController{
    public static function Login(Router $router){
        $alertas=[];


        if($_SERVER['REQUEST_METHOD']==='POST'){
            $auth=new Usuario($_POST);

            
            $alertas=$auth->validarLogin();
            
            if(empty($alertas)){
                //comprueba que exista el usuario

                $usuario = Usuario::where('email', $auth->email);
                
                if($usuario){

                    //verificando el password
                    if($usuario->comprobarPasswordAndVerificado($auth->password)){
                        //inicia las sesiones
                        session_start();

                        $_SESSION['id']=$usuario->id;
                        $_SESSION['nombre']=$usuario->nombre." ".$usuario->apellido;
                        $_SESSION['email']=$usuario->email;
                        $_SESSION['login']=true;
                        //redireccionamiento
                        if($usuario->admin==="1"){
                            
                            $_SESSION['admin']=$usuario->admin ?? null;
                            header('Location: /admin');
                        }else{
                            header('Location: /cita');
                        }
                        
                    }
                }else{
                    Usuario::setAlerta('error', 'Usuario no encontrado o password incorrecto');
                    
                }
            }
        }
        $alertas=Usuario::getAlertas();
        $router->render('auth/login', [
            'alertas'=>$alertas
        ]);
        
    }

    public static function Logout(){
        session_start();
        $_SESSION=[];
        header('Location: /');

    }

    //metodo de olvide :)
    public static function olvide(Router $router){
        $alertas=[];

        if($_SERVER['REQUEST_METHOD']==='POST'){
            $auth=new Usuario($_POST);
            $alertas= $auth->validarEmail();

            if(empty($alertas)){
                $usuario=Usuario::where('email', $auth->email);
              
                if ($usuario && $usuario->confirmado==='1'){
                //generar un token 

                $usuario->crearToken();
                $usuario->guardar();
                //TODO: ENVIAR EL EMAIL

                $email=new Email($usuario->nombre, $usuario->email, $usuario->token);
                $email->enviarInstrucciones();

                $usuario::setAlerta('exito', 'Se han mandado las instruciones, revista tu email');
                $alertas=Usuario::getAlertas();

            }else{
                $usuario::setAlerta('error', 'EL Usuario no existe o no esta confirmado ALV');
                $alertas=Usuario::getAlertas();
            }
        }
    }
        
        $router ->render('auth/olvide-password', [
            'alertas'=> $alertas
        ]);
    }
    
    
    //desde la vista de recuperar
    public static function recuperar(Router $router){
        $alertas=[];
        $error=false;
        $token=s($_GET['token']);

        //buscar usuario por su token en la BD

        $usuario=Usuario::where('token', $token);

        if (empty($usuario)){
            Usuario::setAlerta('error', 'Token no valido');
            $error=true;
        }

        if($_SERVER['REQUEST_METHOD']=='POST'){
            //LEEE EL NUEVO PASSWORD Y GUARDA

            $password= New Usuario($_POST);
            $alertas=$password->validarPassword();


            if(empty($alertas)){
                $usuario->password=null;
                $usuario->password=$password->password;
                $usuario->hashPassword();
                $usuario->token=null;
                $resultado=$usuario->guardar();

                if($resultado){
                    header('Location: /');
                }

            }
        }
        
        $alertas=Usuario::getAlertas();
        $router->render('auth/recuperar-password',[
            'alertas'=>$alertas,
            'error'=>$error
        ]);



    }


    //
    public static function crear(Router $router){
        
        $usuario = new Usuario;

       $alertas=[];
        if($_SERVER['REQUEST_METHOD']=== 'POST'){
            //instanciamos el objeto usuario
            
           
            
            $usuario->sincronizar($_POST);
            $alertas=$usuario->validarNuevaCuenta();

            //revisar que los arrores esten vacios
            if(empty($alertas)){
                //verificar que el usuario no exista
                $resultado= $usuario->existeUsuario();
                if($resultado->num_rows){
                    $alertas=usuario::getAlertas();
                }else{

                    //no esta registrado
                    
                    //hashear el password
                    $usuario->hashPassword();
                    
                    //crear token
                    $usuario->crearToken();
                    
                    //enviar email
                   $email=new Email($usuario->nombre, $usuario->email, $usuario->token);
                   $email->enviarConfirmacion();
                    

                   
                    //crear el usuario
                    
                    $resultado=$usuario->guardar();
                    
                    
                    if($resultado){
                        header('Location: /mensaje');
                    }
            
                }
            }
            
        }
        /*CUANDO TU MANDAS A RENDERIZAR EN LA 
        VISTA DESDE EL CONTROLADOR Y SE ABREN UNOS CORCHETES, 
        JUSTO AHI ES DONDE PUEDES MANDAR VARIABLES POR LA VISTA*/
        $router ->render('auth/crear-cuenta',[
            //pasamos unos valores a la vista, en este caso la variable
            'usuario'=>$usuario,
            'alertas'=>$alertas
        ]);

    }

    public static function mensaje(Router $router){
        $router->render('auth/mensaje');
    }
    public static function confirmar (Router $router){
        $alertas=[];

        $token=s($_GET['token']);

        $usuario=Usuario::where('token', $token);

        if(empty($usuario)){
            //mostrar mensaje de error
            Usuario::setAlerta('error', 'Token no valido');

        }else{
        //modificar a usuario confirmado
        $usuario->confirmado="1";
        $usuario->token=null;
        $usuario->guardar();
        Usuario::setAlerta('exito', 'Cuenta comprobada correctamente');


        }

        //obtener alertas
        $alertas=Usuario::getAlertas();
        //renderizar la vista
        $router->render('auth/confirmar-cuenta', [
        'alertas'=>$alertas
    ]);
}
  
}
?>