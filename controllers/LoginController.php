<?php


namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{

    //iniciar Session
    public static function login(Router $router)
    {

        $alert=[];
        
        if($_SERVER['REQUEST_METHOD']==='POST'){

            $auth=new Usuario($_POST);

            $alert=$auth->ValidateLogin();

            if(empty($alert)){

                $user=Usuario::where('email',$auth->email);
                

                if($user){
                    
                    if($user->validatePasswordAndConfirmated($auth->password)){
                        
                        session_start();
                        $_SESSION['id']=$user->id;
                        $_SESSION['nombre']=$user->nombre .' '. $user->apellido;
                        $_SESSION['email']=$user->email;
                        $_SESSION['login']=true;


                        if($user->admin==='1'){
                            $_SESSION['admin']=$user->admin??null;
                            
                            header('Location: /admin');
                        }else{
                            
                            header('Location: /cita');
                        }
                        

                    }


                }else{
                    Usuario::setAlerta('error','Usuario no encontrado');
                }

            }
            
        }

        $alert=Usuario::getAlertas();

        $router->render('auth/login',[
            'alert'=>$alert,
            
        ]);
    }


    public static function logout()
    {
        
        $_SESSION=[];

        header('Location: /');
    }

    public static function register(Router $router)
    {

        $user = new Usuario();
        $alert = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->sincronizar($_POST);
            $alert = $user->validate();


            //Revisar que alertas este vacio
            if (empty($alert)) {
                //Verificar que el usuario no este registrado
                $result = $user->findUserByEmail();


                if ($result) {
                    $alert = Usuario::getAlertas();
                } else {
                    //Hashear el Password

                    $user->hashPassword();


                    //Generar un token inico
                    $user->GenerateToken();


                    //Enviar el Email
                    $email = new Email($user->email, $user->nombre, $user->token);



                    $email->SendConfirmation();


                    //Crear el usuario
                    $result = $user->guardar();

                    if ($result) {
                        header('Location: /message');
                    }
                }
            }
        }



        $router->render('auth/register', [
            'user' => $user,
            'alert' => $alert
        ]);
    }


    public static function message(Router $router)
    {

        $router->render('auth/message');
    }

    public static function confirmAccount(Router $router)
    {

        $alert = [];
        $token = s($_GET['token']);

        $user = Usuario::where("token", $token);

        if (empty($user)) {

            //Mostrar mensaje de errore
            Usuario::setAlerta('error', 'Token No valido');
        } else {
            //Modificar a usuario confirmado
            $user->confirmado = '1';
            $user->token = null;
            $user->guardar();
            Usuario::setAlerta('sucess', 'Cuenta confirmada correctamente');
        }

        $alert = Usuario::getAlertas();
        $router->render('auth/confirm-account', [
            'alert' => $alert

        ]);
    }

    public static function forgetPassword(Router $router)
    {
        $alert=[];

        if($_SERVER['REQUEST_METHOD']==='POST'){
            $auth=new Usuario($_POST);
            $auth->validateEmail();


            if(empty($alertas)){
                $user=Usuario::where('email',$auth->email);

                if($user && $user->confirmado==='1'){
                    $user->GenerateToken();
                    $user->guardar();

                    //Enviar Email
                    $email=new Email($user->email,$user->nombre,$user->token);
                    $email->recoverPassword();

                    // Alerta exito
                    Usuario::setAlerta('success','revisa tu email');
                      
                }else{
                   Usuario::setAlerta('error','El usuario no existe o no esta confirmado');
                }
            }
        }

        $alert=Usuario::getAlertas();
        $router->render('auth/forgetPassword',[
            'alert'=>$alert
        ]);
    }


    public static function recoverPassword(Router $router)
    {
        $alert=[];
        $error=FALSE;

        $token=s($_GET['token']);
        $user=Usuario::where('token',$token);
        
        if(empty($user)){
            Usuario::setAlerta('error','Token no valido');
            $error=TRUE;
        }

        if($_SERVER['REQUEST_METHOD']==='POST'){

            $password=new Usuario($_POST);
            $alert=$password->ValidatePassword();

            if(empty($alert)){
                $user->password=null;
                
                $user->password=$password->password;
                $user->hashPassword();
                $user->token=null;

                $result=$user->guardar();

                if($result){
                    header('Location: /');
                }else{
                    Usuario::setAlerta('error','Ha ocurrido un error intentalo mas tarde');
                }

                
            }
        }

        
        $alert=Usuario::getAlertas();
        $router->render('auth/recoverPassword',[
        'alert'=>$alert,
        'error'=>$error,
        'token'=>$token
        ]);



    }
}
