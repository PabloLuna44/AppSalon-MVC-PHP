<?php  

namespace Model;

class Servicio extends ActiveRecord{
    //Base de datos


    protected static $tabla='servicios';
    protected static $columnasDB=['id','nombre','precio'];


    public $id;
    public $nombre;
    public $precio;

    public function __construct($args=[])
    {
        $this->id=$args['id']??null;
        $this->nombre=$args['nombre']??'';
        $this->precio=$args['precio']??'';

    }


    public function validate(){

        if(!$this->nombre){
            self::$alertas['error'][]='El campo de nombre es obligatorio';
        }

        
        if(!$this->precio){
            self::$alertas['error'][]='El campo de precio es obligatorio';
        }

        
        if(!is_numeric($this->precio)){
            self::$alertas['error'][]='El formato del precio no es valido';
        }

        return self::$alertas;
    }

    
}