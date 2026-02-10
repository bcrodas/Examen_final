<?php
include "conexion.php";

function obtenerResultado($prom) {
    if ($prom === null) return ["-", "Sin notas"];
    if ($prom < 5) return [number_format($prom,2), "Suspenso"];
    if ($prom < 7) return [number_format($prom,2), "Bien"];
    if ($prom < 9) return [number_format($prom,2), "Notable"];
    return [number_format($prom,2), "Sobresaliente"];
}

$consulta = $conexion->query("
    SELECT a.nombre, a.apellido, AVG(n.nota) AS promedio
    FROM alumno a
    LEFT JOIN nota n ON a.id = n.alumno_id
    GROUP BY a.id
");

if (isset($_GET['excel'])) {
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=reporte_notas.xls");
    echo "<table border='1'><tr><th>Alumno</th><th>Promedio</th><th>Resultado</th></tr>";
    while ($row = $consulta->fetch_assoc()) {
        list($promedio, $res) = obtenerResultado($row['promedio']);
        echo "<tr><td>{$row['nombre']} {$row['apellido']}</td><td>$promedio</td><td>$res</td></tr>";
    }
    echo "</table>";
    exit;
}
?>

<h2>Reporte de Notas</h2>
<a href="reportes.php?excel=1" class="btn btn-success mb-3"> 📊 Exportar a Excel </a>
<table class="table table-bordered table-striped">
<tr>
    <th>Alumno</th>
    <th>Promedio</th>
    <th>Resultado</th>
</tr>
<?php
while ($row = $consulta->fetch_assoc()) {
    list($promedio, $resultado) = obtenerResultado($row['promedio']);
    echo "<tr><td>{$row['nombre']} {$row['apellido']}</td><td>$promedio</td><td>$resultado</td></tr>";
}
?>
</table>
