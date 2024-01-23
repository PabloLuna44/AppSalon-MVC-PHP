<h1 class="name-page">Servicios</h1>
<p class="description-page">Administracion de Servicios</p>


<?php  

include_once __DIR__ . '/../templates/barra.php';
?>


<ul class="services" >

<?php  
foreach($services as $service){
?>

<li>
    <p>Nombre: <span><?php  echo $service->nombre ?></span></p>
    <p>Precio: $<span><?php  echo $service->precio ?></span></p>

    <div class="actions" >
        <a class="button" href="/services/update?id=<?php echo $service->id ?>">Actualizar</a>

        <form action="/services/delete" method="POST"s>
            <input type="hidden" name="id" value="<?php echo $service->id ?>">

            <input type="submit" value="Borrar" class="button-delete">
        </form>

        

    </div>
    
</li>

<?php   
}
?>


</ul>