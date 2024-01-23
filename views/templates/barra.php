
<div class="bar">

<p>Hola <?php  echo $nombre??''; ?></p>

<a class="button" href="/logout">Log Out</a>

</div>


<?php  

if(isset($_SESSION['admin'])){?>

<div class="services-bar">
    <a class="button" href="/admin">Ver citas</a>
    <a class="button" href="/services">Servicios</a>
    <a class="button" href="/services/create">Agregar Servicio</a>

</div>


<?php  
}

?>