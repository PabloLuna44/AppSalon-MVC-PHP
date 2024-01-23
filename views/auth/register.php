<h1 class="name-page">Crear Cuenta</h1>
<p class="description-page">LLene el siguiente formulario para crear una cuenta</p>


<?php  

include_once __DIR__ . '/../templates/alerts.php';

?>


<form class="form" action="/register" method="POST">


<div class="field" >
    <label for="name">Nombre</label>
    <input type="text" id="name" name="nombre" placeholder="Nombre" value="<?php echo s($user->nombre) ?>">
</div>


<div class="field" >
    <label for="apellido">Apellido</label>
    <input type="text" id="apellido" name="apellido" placeholder="Apellido" value="<?php echo s($user->apellido) ?>">
</div>


<div class="field" >
    <label for="telefono">Telefono</label>
    <input type="text" id="telefono" name="telefono" placeholder="Telefono" value="<?php echo s($user->telefono) ?>">
    
</div>

<div class="field" >
    <label for="email">Email</label>
    <input type="text" id="email" name="email" placeholder="Email" value="<?php echo s($user->email) ?>" >
    
</div>

<div class="field" >
    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="Password"">
    
</div>



<input type="submit" class="button" value="Crear Cuenta">


</form>

<div class="accions">
    <a href="/">Ya tienes una cuenta? Inicia Session</a>
    <a href="/forgetpassword">¿Olvidaste tu password?</a>

</div>