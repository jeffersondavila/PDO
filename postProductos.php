<?php
//C:\xampp\php\ext
//https://learn.microsoft.com/es-es/sql/connect/php/download-drivers-php-sql-server?view=sql-server-ver15
//php.ini
//extension=php_pdo_sqlsrv_81_ts_x64
//C:\xampp\htdocs
//Proyectos
$valorSeleccionado = $_POST["posicionCombo"];

$usuario = "sa";
$password = "loc@del@rea";
$rutaServidor = "localhost";
// la ruta del servidor tambien puede ser 127.0.0.0, nombre de tu equipo o la ip del servidor remoto

$nombreBaseDeDatos = "factura";

try {
    $baseDeDatos = new PDO("sqlsrv:server=$rutaServidor;database=$nombreBaseDeDatos", $usuario, $password);
    $baseDeDatos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exeption $e) {
    echo $e;
}

$consulta = "
SELECT TOP(10) producto.idproducto, producto.nombre FROM producto
INNER JOIN categoria ON categoria.id=producto.categoriaP
INNER JOIN venta ON venta.productoid=producto.idproducto
WHERE YEAR(venta.fecha)=2022 AND categoria.id=" . $valorSeleccionado;

$sentencia = $baseDeDatos->query($consulta);
$resultado = $sentencia->fetchAll(PDO::FETCH_OBJ);

$i = 0;
$idArreglo = [];
$nombreArreglo = [];

foreach ($resultado as $resul) {
    $idArreglo[$i] = $resul->idproducto;
    $nombreArreglo[$i] = $resul->nombre;
    $i++;
}

$longitudArreglo = sizeof($idArreglo);

$json[] = array(
    'idproducto' => $idArreglo,
    'nombre' => $nombreArreglo,
    'cantidad' => $longitudArreglo
);
$json_string = json_encode($json);
echo $json_string;
?>