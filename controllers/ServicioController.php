<?php  

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController{


    public static function index(Router $router){

        isAdmin();

        $services=Servicio::all();
        $nombre=$_SESSION['nombre'];
        $router->render('services/index',[
            'nombre'=>$nombre,
            'services'=>$services
        ]);

    }


    public static function create(Router $router){

        isAdmin();
        $nombre=$_SESSION['nombre'];
        $service=new Servicio();
        $alert=[];

        if($_SERVER['REQUEST_METHOD']==='POST'){


            $service->sincronizar($_POST);
            $alert=$service->validate();

            if(empty($alert)){

                $service->guardar();
                header('Location: /services');

            }

        }

        $router->render('services/create',[
            'nombre'=>$nombre,
            'service'=>$service,
            'alert'=>$alert
        ]);

    }

    public static function update(Router $router){

        isAdmin();
        $nombre=$_SESSION['nombre'];
        
        if(!is_numeric($_GET['id']))return;
        $service=Servicio::find($_GET['id']);
        $alert=[];


        if($_SERVER['REQUEST_METHOD']==='POST'){

            $service->sincronizar($_POST);
            $alert=$service->validate();
           

            if(empty($alert)){
                $service->guardar();
                header('Location: /services');
            }

        }

        $router->render('services/update',[
            'nombre'=>$nombre,
            'service'=>$service,
            'alert'=>$alert
        ]);

    }

    public static function delete(){
       
        isAdmin();
        if($_SERVER['REQUEST_METHOD']==='POST'){

            $id=$_POST['id'];

            $service=Servicio::find($id);

            $service->eliminar();
            header('Location: /services');


            
        }
       

    }

}