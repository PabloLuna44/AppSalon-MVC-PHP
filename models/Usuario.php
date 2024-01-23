<?php  


namespace Model;


class Usuario extends ActiveRecord{

//Base de datos
protected static $tabla='usuarios';
protected static $columnasDB=['id','nombre','apellido','email','password','telefono','admin','confirmado','token'];


public $id;
public $nombre;
public $apellido;
public $email;
public $password;
public $telefono;
public $admin;
public $confirmado;
public $token;


public function __construct($args=[]) {
    $this->id=$args['id']??null;
    $this->nombre=$args['nombre']??'';
    $this->email=$args['email']??'';
    $this->password=$args['password']??'';
    $this->telefono=$args['telefono']??'';
    $this->admin=$args['admin']??'0';
    $this->confirmado=$args['confirmado']??'0';
    $this->token=$args['token']??null;
    
}


public function validate(){

 if(!$this->nombre){
    self::$alertas['error'][]='Es obligatorio el nombre';
 }   
 if(!$this->apellido){
    self::$alertas['error'][]='Es obligatorio el apellido';
 }   
 if(!$this->email){
    self::$alertas['error'][]='Es obligatorio el email';
 }   
 if(!$this->password){
    self::$alertas['error'][]='Es obligatoria una contraseña';
 }   

 if((strlen($this->password))< 6){
    self::$alertas['error'][]='El password debe contener al menos 6 caracteres';
 }   
 if(!$this->telefono){
    self::$alertas['error'][]='Es obligatorio el numero de telefono';
 }   
    

return self::$alertas;

}


public function ValidateLogin(){

if(!$this->email){
self::$alertas['error'][]='El email es Obligatorio';
}

if(!$this->password){
   self::$alertas['error'][]='El password es Obligatorio';
}


return self::$alertas;

}

public function ValidateEmail(){
   if(!$this->email){
      self::$alertas['error'][]='El email es obligatorio';
   }
}

public function ValidatePassword(){
   if(!$this->password ){
      self::$alertas['error'][]='El Password es obligatorio';
   }
   if(strlen($this->password)<6 ){
      self::$alertas['error'][]='El Password debe tener al menos 6 caracteres';
   }


   return self::$alertas;
}


//Revisa si ya existe 
public function findUserByEmail(){

$query="SELECT * FROM ". self::$tabla ." WHERE email='".$this->email."' LIMIT 1";
$result=Usuario::consultarSQL($query);

if($result){

    self::$alertas['error'][]='El usuario ya esta registrado';

}

return $result;
}


public function hashPassword(){

    $this->password=password_hash($this->password,PASSWORD_BCRYPT);

}

public function GenerateToken(){
    $this->token=uniqid();

}


public function validatePasswordAndConfirmated($password){

   $resultado=password_verify($password,$this->password);
   
   if(!$this->confirmado || !$resultado){
      self::$alertas['error'][]='EL usuario no esta confirmado o la contraseña es incorrecta';
   }else{
      return TRUE;
   }

}



} 