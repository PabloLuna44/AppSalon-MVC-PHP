<h1 class="name-page">Servicios</h1>
<p class="description-page">LLena todo los campos para añadir un servicio</p>


<?php  

// include_once __DIR__ . '/../templates/barra.php';
include_once __DIR__ . '/../templates/alerts.php';
?>


<form action="/services/create" method="POST" class="form">


<?php  

include_once __DIR__ .'/form.php'

?>

<input type="submit" class="button" value="Guardar Servicio">
</form>