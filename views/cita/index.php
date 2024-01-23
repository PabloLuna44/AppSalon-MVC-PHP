<h1 class="name-page">Crear Nueva Cita</h1>
<p class="description-page ">Elige tus servicios a continuacion y coloca tus datos</p>

<?php  
include_once __DIR__ .'/../templates/barra.php';
?>


<div id="app">

    <nav class="tabs">

        <button type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Informacion</button>
        <button type="button" data-paso="3">Cita</button>

    </nav>

    <div id="paso-1" class="section">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios a continuacion</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>


    <div id="paso-2" class="section">
        <h2>Tus datos y Cita</h2>
        <p class="text-center">Coloca tus datos y fecha de tu cita</p>

        <form action="form" class="form">

            <div class="field">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" placeholder="Nombre" value="<?php echo $nombre ?>" disabled>
            </div>
            <div class="field">
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" placeholder="fecha" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
            </div>

            <div class="field">
                <label for="hora">Hora</label>
                <input type="time" id="hora" placeholder="hora" min="0900" max="2100">
            </div>

            
            
            <input type="hidden" id="id" value="<?php echo $id; ?>" >
            

        </form>

    </div>


    <div id="paso-3" class="section summary-content">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que la informacion sea correcta</p>

    </div>


    <div class="pagination">

        <button id="previous" class="previous button">&laquo;Anterior</button>

        <button id="next" class="next button">Siguiente&raquo;</button>


    </div>

</div>

<?php $script = "<script src='build/js/app.js'></script>
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
" ?>