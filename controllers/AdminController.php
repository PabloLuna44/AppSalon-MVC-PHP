<?php


namespace Controllers;

use Model\AdminCita;
use MVC\Router;



class AdminController
{



    public static function index(Router $router)
    {

        

        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        $fechas = explode('-', $fecha);
        
        if (count($fechas) === 3 && is_numeric($fechas[0]) && is_numeric($fechas[1]) && is_numeric($fechas[2])) {
            $anio = (int)$fechas[0];
            $mes = (int)$fechas[1];
            $dia = (int)$fechas[2];
        
            if (checkdate($mes, $dia, $anio)) {
                // La fecha es válida
                // Tu lógica aquí
            } else {
                // La fecha no es válida
                header('Location: /404');  // Cambia la URL según tus necesidades
                exit();
            }
        } else {
            // La fecha no tiene el formato esperado
            header('Location: /404');  // Cambia la URL según tus necesidades
            exit();
        }
        
        




        //Consultar la base de datos
        $query = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $query .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $query .= " FROM citas  ";
        $query .= " LEFT OUTER JOIN usuarios ";
        $query .= " ON citas.usuarioId=usuarios.id  ";
        $query .= " LEFT OUTER JOIN citasServicios ";
        $query .= " ON citasServicios.citaId=citas.id ";
        $query .= " LEFT OUTER JOIN servicios ";
        $query .= " ON servicios.id=citasServicios.servicioId ";
        $query .= " WHERE fecha =  '${fecha}'";



        $cita = AdminCita::SQL($query);




        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'],
            'citas' => $cita,
            'fecha' => $fecha
        ]);
    }
}
