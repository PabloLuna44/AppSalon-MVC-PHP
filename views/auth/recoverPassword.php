<h1 class="name-page">Recuperar Password</h1>
<p class="description-page">A continuacion escribe tu nueva password</p>


<?php  

include_once __DIR__ .'/../templates/alerts.php';

?>
<?php  if($error) return null ?>
<form class="form" method="POST">


<div class="field">
    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="Passoword">

</div>


<input type="submit" class="button" value="Restablecer" >

</form>



<div class="accions">
    <a href="/register">¿Aun no tienes una cuenta? Crea Una</a>
    <a href="/">¿Ya tienes una cuenta? Inicia Sesion</a>

</div>
