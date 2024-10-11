<?php 
//el namespace que se configuro en composer
namespace Model;
//heredamos todo de la clse padre ActiveRecord, contiene todos los metodos para interactuar con la bd
//va a crear un objeto en memorai exactamente igual como en el que tenemos en la bd, por lo cual creamos los atributos iguala como en la clase
class Usuario extends ActiveRecord{

        //BD
    protected static $tabla ='usuarios';
    protected static $columnasDB=['id', 'nombre', 'apellido', 'email',
    'password', 'telefono', 'admin', 'confirmado', 'token'];
//volvemos publicos los atributos por cada uno de ellos
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;
//creamos contructor que pide unos argumentos pero por default comienza vacio
//se estacia el objeto que crea una nueva instancia de usuario, agregando argumentos con los atributos de la clase

        public function __construct($args = []){
            $this->id=$args['id'] ?? null; 
            $this->nombre=$args['nombre'] ?? ''; 
            $this->apellido=$args['apellido'] ?? ''; 
            $this->email=$args['email'] ?? ''; 
            $this->password=$args['password'] ?? ''; 
            $this->telefono=$args['telefono'] ?? ''; 
            $this->admin=$args['admin'] ?? '0'; 
            $this->confirmado=$args['confirmado'] ?? '0'; 
            $this->token=$args['token'] ?? ''; 
        }


        public function validarNuevaCuenta(){
            if(!$this->nombre){
                self::$alertas['error'][]='El nombre es obligatorio';
            }
            if(!$this->apellido){
                self::$alertas['error'][]='El apellido es obligatorio';
            }if(!$this->telefono){
                self::$alertas['error'][]='El telefono es obligatorio';
            }
            if(!$this->email){
                self::$alertas['error'][]='El email es obligatorio';
            }if(!$this->password){
                self::$alertas['error'][]='El password es obligatorio';
            }if(strlen($this->password)<6){
                self::$alertas['error'][]='El password debe contener al menos 6 caracteres';
            }

            return self::$alertas;
        }

        public function validarLogin(){
            if(!$this->email){
                self::$alertas['error'][]='El email es obligatorio';
            }
            if(!$this->password){
                self::$alertas['error'][]='El password es obligatorio';
            }
        
            return self::$alertas;
        }

        public function ValidarEmail(){
            if(!$this->email){
                self::$alertas['error'][]='El email es obligatorio';
            }
            return self::$alertas;
        }


        public function validarPassword(){
            if(!$this->password){
                self::$alertas['error'][]='El password es obligatorio';
            }
            if(strlen($this->password)<6){
                self::$alertas['error'][]='El password debe tenener minimo 6 caracteres';
            }
            return self::$alertas;

        }
       


        public function existeUsuario(){
            $query =" SELECT * FROM ". self::$tabla . " WHERE email = '" . $this->email . "' LIMIT
            1";

            $resultado =self::$db->query($query);

            
            if($resultado->num_rows){
                self::$alertas['error'][]="el usuario ya esta registrado";

            }return $resultado;



        }


        public function hashPassword(){

            $this->password = password_hash($this->password, PASSWORD_BCRYPT);
        }

        public function crearToken(){
            $this->token=uniqid();
        }

        public function comprobarPasswordAndVerificado($password){
            $resultado=password_verify($password, $this->password);

            if (!$resultado||!$this->confirmado){
                self::$alertas['error'][]='password incorrecto o tu cuenta no a sido verificada';

            }else{
                return true;
                 }
        }
 
    }

?>