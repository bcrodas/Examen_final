<?php
include "conexion.php";

/* ====== CONSULTA PROMEDIOS ====== */
$consulta = $conexion->query("
    SELECT 
        a.id,
        a.nombre,
        a.apellido,
        AVG(n.nota) AS promedio
    FROM alumno a
    LEFT JOIN nota n ON a.id = n.alumno_id
    GROUP BY a.id
");

/* ====== FUNCIÓN RESULTADO ====== */
function resultado($promedio) {
    if ($promedio === null) return "Sin notas";
    if ($promedio < 5) return "Suspenso";
    if ($promedio < 7) return "Bien";
    if ($promedio < 9) return "Notable";
    return "Sobresaliente";
}
?>

<meta charset="UTF-8">
<title>Promedios de Alumnos</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

<h2>Promedio y Resultado</h2>

<table class="table table-bordered table-striped">
<tr>
<th>Alumno</th>
<th>Promedio</th>
<th>Resultado</th>
</tr>

<?php while ($row = $consulta->fetch_assoc()): ?>
<tr>
<td><?= $row['nombre']." ".$row['apellido'] ?></td>
<td>
    <?= $row['promedio'] !== null ? number_format($row['promedio'], 2) : "—" ?>
</td>
<td><?= resultado($row['promedio']) ?></td>
</tr>
<?php endwhile; ?>

</table>
