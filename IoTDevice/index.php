<?php
//Obtener los valores de las variables
$temperatura = $_GET['temp'];
$humedad = $_GET['hum'];
$humedadTierra = $_GET['hum_tierra'];
$ppmGas = $_GET['gas'];
$lat = isset($_GET['lat']) ? $_GET['lat'] : '';
$longi = isset($_GET['longi']) ? $_GET['longi'] : '';
$estado = $_GET['estado'];

//Imprimir los valores de las variables
echo "Temperatura: " . $temperatura . "<br>";
echo "Humedad: " . $humedad . "<br>";
echo "Humedad de Tierra: " . $humedadTierra . "<br>";
echo "Concentración de Gas: " . $ppmGas . "<br>";
echo "Latitud: " . $lat . "<br>";
echo "Longitud: " . $longi . "<br>";
echo "Estado: " . $estado . "<brb>";

//Modify the values of the variables below to match your database
$usuario = "root";
$contrasena = "";
$servidor = "localhost";
$basededatos = "ecoguardian";

// Create connection
$conexion = mysqli_connect($servidor, $usuario, "") or die("No se ha podido conectar al servidor de Base de datos");
// Check connection
$db = mysqli_select_db($conexion, $basededatos) or die("No se ha podido seleccionar la base de datos");


//Insertar datos en la base de datos
$consulta = "INSERT INTO datos (temperatura, humedad, humedad_tierra, ppm_gas) VALUES ('$temperatura', '$humedad', '$humedadTierra', '$ppmGas')";
$id_a_actualizar = 35;
$nueva_latitud = $lat;
$nueva_longitud = $longi;

$estado_color = estadoToString($estado);

//Función para convertir el estado a un string
function estadoToString($estado) {
    switch ($estado) {
        case 0:
            return "verde_fuerte";
        case 1:
            return "verde_claro";
        case 2:
            return "rojo";
        case 3:
            return "amarillo";
        case 4:
            return "naranja";
        case 5:
            return "azul";
        case 6:
            return "morado";
        case 7:
            return "celeste";
        default:
            return "negro";
    }
}

$sql = "UPDATE dispositivos_ecoguardianes SET latitud = '$nueva_latitud', longitud = '$nueva_longitud', estado = '$estado_color' WHERE id = $id_a_actualizar";
$resultado = mysqli_query($conexion, $consulta);

if ($resultado) {
    echo "Datos insertados correctamente.";
} else {
    echo "Error al insertar datos: " . mysqli_error($conexion);
}

if (mysqli_query($conexion, $sql)) {
    echo "Registro actualizado correctamente.";
} else {
    echo "Error al actualizar el registro: " . mysqli_error($conexion);
}

mysqli_close($conexion);

?>
