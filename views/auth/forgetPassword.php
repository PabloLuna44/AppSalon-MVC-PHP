<h1 class="name-page">Olvide Password</h1>
<p class="description-page">Restablece tu password escribiendo tu email a continuacion</p>


<?php  

include_once __DIR__ .'/../templates/alerts.php';

?>

<form class="form" method="POST" action="/forgetpassword">


<div class="field">
    <label for="email">Email</label>
    <input type="email" id="name" name="email" placeholder="email">

</div>


<input type="submit" class="button" value="Restablecer" >

</form>

<div class="accions">
    <a href="/register">¿Aun no tienes una cuenta? Crea Una</a>
    <a href="/">¿Ya tienes una cuenta? Inicia Sesion</a>

</div>
