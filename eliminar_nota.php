<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['archivo'])) {
        $archivo = $_GET['archivo'];

        // Verificar si el archivo existe
        if (file_exists($archivo)) {
            // Eliminar el archivo
            unlink($archivo);
            echo 'La nota ha sido eliminada exitosamente.';
        } else {
            echo 'La nota no existe.';
        }
    } else {
        echo 'No se proporcionó el nombre del archivo.';
    }
} else {
    echo 'Error al procesar la solicitud.';
}
?>
<link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <div class="container"><button class="btn btn-primary" onclick="window.location.href = 'index.php';">Regresar</button></div>