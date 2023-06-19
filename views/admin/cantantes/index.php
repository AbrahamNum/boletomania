<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/cantantes/crear">
        <i class="fa-solid fa-circle-plus"></i>
        Añandir Cantante
    </a>
</div>
<div class="dashboard__contenedor">
    <?php if (!empty($cantantes)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Ubicacion</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach ($cantantes as $cantante) {  ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $cantante->nombre; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $cantante->ciudad . ", " . $cantante->pais; ?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/cantantes/editar?id=<?php echo $cantante->id ?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form method="POST" action='/admin/cantantes/eliminar' class="table__formulario" action="">
                                <input type="hidden" name="id" value="<?php echo $cantante->id; ?>">
                                <button class="table__accion table__accion--eliminar" type="submit">
                                    <i class="fa-solid fa-circle-xmark"></i>

                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php  } ?>
            </tbody>
        </table>

    <?php  } else {   ?>
        <p class="text-center">No hay cantantes</p>
    <?php  } ?>
</div>

<?php 
    echo $paginacion;
?>