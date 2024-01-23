<h1 class="name-pagea">Panel de administrador</h1>

<?php
include_once __DIR__ . '/../templates/barra.php';
?>


<h2>Buscar citas</h2>

<div class="search">

    <form class="form" method="POST">

        <div class="field">

            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" id="fecha" value="<?php echo $fecha  ?>">

        </div>

    </form>

</div>

<?php

if (count($citas) === 0) {

    echo "<h2>No hay Citas en esta fecha </h2>";
}


?>

<div class="citas-admin">

    <ul>
        <?php
        $idCita = '';
        $total = 0;

        foreach ($citas as $key => $cita) {


            if ($idCita !== $cita->id) {
                $total = 0;
        ?>
                <li>

                    <h3>Informacion del Cliente</h3>
                    <p>ID:<span><?php echo $cita->id ?></span></p>
                    <p>Hora:<span><?php echo $cita->hora ?></span></p>
                    <p>Cliente:<span><?php echo $cita->cliente ?></span></p>
                    <p>Email:<span><?php echo $cita->email ?></span></p>
                    <p>Telefono:<span><?php echo $cita->telefono ?></span></p>
                    <h3>Servicios</h3>
                </li>

            <?php
                $idCita = $cita->id;
            } //FIn de if
            else {
                $total += $cita->precio;
            ?>

                <div class="servicio">
                    <p><span> <?php echo "-" . $cita->servicio . " $" . $cita->precio ?></span></p>
                </div>

            <?php
            }

            $actual = $cita->id;
            $proximo = $citas[$key + 1]->id ?? 0;


            if ($actual !== $proximo) {
            ?>

                <div class="precio">
                    <p>Total:<span>$<?php echo $total ?><span></p>

                </div>

                <form action="/api/delete" method="POST">

                    <input type="hidden" name="id" value="<?php echo $cita->id; ?>">

                    <input type="submit" class="button-delete" value="Eliminar">


                </form>
        <?php


            }
        } //Fin de foreach
        ?>

    </ul>

</div>

<?php $script = "<script src='build/js/buscador.js'></script>

" ?>