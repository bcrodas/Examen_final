<?php
include __DIR__ . "/conexion.php";

/* CREAR */
if (isset($_POST['guardar'])) {
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $apellido = $conexion->real_escape_string($_POST['apellido']);
    $correo = $conexion->real_escape_string($_POST['correo']);

    $sql = "INSERT INTO alumno(nombre, apellido, correo) VALUES('$nombre', '$apellido', '$correo')";
    if ($conexion->query($sql) === false) {
        echo "Error al guardar: " . $conexion->error;
    } else {
        header("Location: dashboard.php?pagina=alumnos");
        exit;
    }
}

/* ACTUALIZAR */
if (isset($_POST['actualizar'])) {
    $id = intval($_POST['id']); // seguridad
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $apellido = $conexion->real_escape_string($_POST['apellido']);
    $correo = $conexion->real_escape_string($_POST['correo']);

    $sql = "UPDATE alumno SET nombre='$nombre', apellido='$apellido', correo='$correo' WHERE id=$id";
    if ($conexion->query($sql) === false) {
        echo "Error al actualizar: " . $conexion->error;
    } else {
        header("Location: dashboard.php?pagina=alumnos");
        exit;
    }
}

/* ELIMINAR */
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']); // seguridad
    $conexion->query("DELETE FROM nota WHERE alumno_id=$id");
    $conexion->query("DELETE FROM alumno WHERE id=$id");
    header("Location: dashboard.php?pagina=alumnos");
    exit;
}

/* EDITAR */
$editar = false;
$alumno = null;
if (isset($_GET['editar'])) {
    $editar = true;
    $id = intval($_GET['editar']);
    $alumno = $conexion->query("SELECT * FROM alumno WHERE id=$id")->fetch_assoc();
}
?>

<h3><?= $editar ? "Editar Alumno" : "Registrar Alumno" ?></h3>

<form method="POST">
    <?php if ($editar): ?>
        <input type="hidden" name="id" value="<?= $alumno['id'] ?>">
    <?php endif; ?>

    <input class="form-control mb-2" name="nombre" placeholder="Nombre" value="<?= $editar ? $alumno['nombre'] : '' ?>" required>
    <input class="form-control mb-2" name="apellido" placeholder="Apellido" value="<?= $editar ? $alumno['apellido'] : '' ?>" required>
    <input class="form-control mb-2" name="correo" type="email" placeholder="Correo" value="<?= $editar ? $alumno['correo'] : '' ?>" required>

    <button type="submit" 
            class="btn btn-<?= $editar ? 'warning' : 'primary' ?>" 
            name="<?= $editar ? 'actualizar' : 'guardar' ?>">
        <?= $editar ? 'Actualizar' : 'Guardar' ?>
    </button>
</form>

<hr>

<table class="table table-bordered">
    <tr>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Correo</th>
        <th>Acciones</th>
    </tr>

    <?php
    $res = $conexion->query("SELECT * FROM alumno");
    while ($r = $res->fetch_assoc()) {
        echo "<tr>
            <td>{$r['nombre']}</td>
            <td>{$r['apellido']}</td>
            <td>{$r['correo']}</td>
            <td>
                <a class='btn btn-warning btn-sm' href='dashboard.php?pagina=alumnos&editar={$r['id']}'>Editar</a>
                <a class='btn btn-danger btn-sm' href='dashboard.php?pagina=alumnos&eliminar={$r['id']}'>Eliminar</a>
            </td>
        </tr>";
    }
    ?>
</table>
