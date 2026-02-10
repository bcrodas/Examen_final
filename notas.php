<?php
include __DIR__ . "/conexion.php";

/* ====== GUARDAR NOTA ====== */
if (isset($_POST['guardar'])) {
    $alumno_id = intval($_POST['alumno_id']);
    $nota = floatval($_POST['nota']);

    if ($nota >= 0 && $nota <= 10) {
        $sql = "INSERT INTO nota (alumno_id, nota) VALUES ($alumno_id, $nota)";
        if ($conexion->query($sql) === false) {
            echo "<div class='alert alert-danger'>Error al guardar: " . $conexion->error . "</div>";
        } else {
            header("Location: dashboard.php?pagina=notas");
            exit;
        }
    } else {
        echo "<div class='alert alert-warning'>La nota debe estar entre 0 y 10.</div>";
    }
}

/* ====== ACTUALIZAR NOTA ====== */
if (isset($_POST['actualizar'])) {
    $id = intval($_POST['id']);
    $nota = floatval($_POST['nota']);

    if ($nota >= 0 && $nota <= 10) {
        $sql = "UPDATE nota SET nota=$nota WHERE id=$id";
        if ($conexion->query($sql) === false) {
            echo "<div class='alert alert-danger'>Error al actualizar: " . $conexion->error . "</div>";
        } else {
            header("Location: dashboard.php?pagina=notas");
            exit;
        }
    } else {
        echo "<div class='alert alert-warning'>La nota debe estar entre 0 y 10.</div>";
    }
}

/* ====== ELIMINAR NOTA ====== */
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $conexion->query("DELETE FROM nota WHERE id=$id");
    header("Location: dashboard.php?pagina=notas");
    exit;
}

/* ====== OBTENER NOTA PARA EDITAR ====== */
$editar = false;
$notaEditar = null;
if (isset($_GET['editar'])) {
    $editar = true;
    $id = intval($_GET['editar']);
    $notaEditar = $conexion->query("SELECT * FROM nota WHERE id=$id")->fetch_assoc();
}
?>

<h2><?= $editar ? "Editar Nota" : "Registrar Nota" ?></h2>

<form method="POST" class="mb-4">
    <?php if ($editar): ?>
        <input type="hidden" name="id" value="<?= $notaEditar['id'] ?>">
    <?php endif; ?>

    <?php if (!$editar): ?>
        <select name="alumno_id" class="form-control mb-2" required>
            <option value="">Seleccione Alumno</option>
            <?php
            $alumnos = $conexion->query("SELECT * FROM alumno");
            while ($a = $alumnos->fetch_assoc()) {
                echo "<option value='{$a['id']}'>{$a['nombre']} {$a['apellido']}</option>";
            }
            ?>
        </select>
    <?php endif; ?>

    <input type="number" step="0.01" name="nota" class="form-control mb-2"
           placeholder="Nota (0 a 10)"
           value="<?= $editar ? $notaEditar['nota'] : '' ?>" required>

    <button type="submit" class="btn btn-<?= $editar ? 'warning' : 'primary' ?>" 
            name="<?= $editar ? 'actualizar' : 'guardar' ?>">
        <?= $editar ? 'Actualizar' : 'Guardar' ?>
    </button>

    <?php if ($editar): ?>
        <a href="dashboard.php?pagina=notas" class="btn btn-secondary">Cancelar</a>
    <?php endif; ?>
</form>

<hr>

<h2>Listado de Notas</h2>

<table class="table table-bordered table-striped">
    <tr>
        <th>Alumno</th>
        <th>Nota</th>
        <th>Acciones</th>
    </tr>
    <?php
    $resultado = $conexion->query("
        SELECT n.id, n.nota, a.nombre, a.apellido
        FROM nota n
        JOIN alumno a ON n.alumno_id = a.id
        ORDER BY n.id DESC
    ");

    while ($row = $resultado->fetch_assoc()) {
        echo "<tr>
            <td>{$row['nombre']} {$row['apellido']}</td>
            <td>{$row['nota']}</td>
            <td>
                <a href='dashboard.php?pagina=notas&editar={$row['id']}' class='btn btn-warning btn-sm'>Editar</a>
                <a href='dashboard.php?pagina=notas&eliminar={$row['id']}' class='btn btn-danger btn-sm' 
                   onclick=\"return confirm('¿Eliminar nota?')\">Eliminar</a>
            </td>
        </tr>";
    }
    ?>
</table>
