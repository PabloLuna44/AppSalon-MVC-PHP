<?php  

namespace Controllers;

use Model\Cita;
use Model\CitaServicios;
use Model\Servicio;

class APIController{

public static function index(){
    $services=Servicio::all();

    echo json_encode($services);
}

public static function save(){
  
    //Almacena la cita y devuelve el ID
    $cita=new Cita($_POST);
    $resultado=$cita->guardar();

    // //Almacena la cita y el servicio
    
    $id=$resultado['id'];

    //Almacena los servicios con el id de la cita
    $idServicios=explode(",",$_POST['servicios']);
    
    foreach($idServicios as $servicioId){

        $args=[
            'citaId'=>$id,
            'servicioId'=>$servicioId
        ];

        $citaServicios=new CitaServicios($args);    
        $citaServicios->guardar();
    }
    

    echo json_encode(['resultado'=>$resultado]);
}



public static function delete(){

if($_SERVER['REQUEST_METHOD']==='POST'){
    
    $id=$_POST['id'];

    $cita=Cita::find($id);

    $cita->eliminar();
    

    header('Location:'.$_SERVER["HTTP_REFERER"]);

}

}

}