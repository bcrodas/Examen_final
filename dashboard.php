

<!DOCTYPE html>

<html lang="es">
<head>
<meta charset="UTF-8">
<title>Sistema de Gestión Académica</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-dark bg-dark">
<div class="container-fluid">
    <a class="navbar-brand">Gestión Académica</a>
    <div>
        <a href="dashboard.php?pagina=alumnos" class="btn btn-light btn-sm">Alumnos</a>
        <a href="dashboard.php?pagina=notas" class="btn btn-light btn-sm">Notas</a>
        <a href="dashboard.php?pagina=promedios" class="btn btn-light btn-sm">Promedios</a>
        <a href="dashboard.php?pagina=reportes" class="btn btn-light btn-sm">Reportes</a>
    </div>
</div>
</nav>

<div class="container mt-4">

<?php
if (isset($_GET['pagina'])) {
    switch ($_GET['pagina']) {
        case "alumnos":
            include "alumnos.php";
            break;
        case "notas":
            include "notas.php";
            break;
        case "promedios":
            include "promedios.php";
            break;
        case "reportes":
            include "reportes.php";
            break;
        default:
            echo "<h4>Seleccione una opción</h4>";
    }
} else {
    echo "<h4>Bienvenido al sistema académico</h4>";
}
?>

</div>

</body>
</html>
