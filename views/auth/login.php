<h1 class="name-page">Login</h1>
<p class="description-page">Inicia session con tu cuenta</p>

<?php  

include_once __DIR__ . '/../templates/alerts.php';

?>


<form class="form" action="/" method="POST">

<div class="field">
    <label for="">Email</label>
    <input type="email" id="email" placeholder="Email" name="email" >
</div>

<div class="field">
    <label for="">Password</label>
    <input type="password" id="password" placeholder="Password" name="password">
</div>


<input type="submit" name="" id="" class="button" value="Iniciar Session">

</form>


<div class="accions">
    <a href="/register">¿Aun no tienes una cuenta? Crea Una</a>
    <a href="/forgetpassword">¿Olvidaste tu password?</a>

</div>