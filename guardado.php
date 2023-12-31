<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['archivo']) && isset($_POST['titulo']) && isset($_POST['contenido']) && isset($_POST['carpeta'])) {
        $archivo = $_POST['archivo'];
        $titulo = $_POST['titulo'];
        $contenido = $_POST['contenido'];
        $carpeta = $_POST['carpeta'];

        if (file_exists($archivo)) {
            if (!empty($carpeta)) {
                // Verificar si la carpeta seleccionada es válida
                if (is_dir($carpeta)) {
                    $nuevaCarpeta = rtrim($carpeta, '/') . '/';
                    $nuevoArchivo = $nuevaCarpeta . $titulo . '.txt';

                    rename($archivo, $nuevoArchivo);
                    $archivo = fopen($nuevoArchivo, 'w');
                    fwrite($archivo, $contenido);
                    fclose($archivo);

                    echo 'Nota modificada y movida correctamente a la carpeta.';
                } else {
                    echo 'La carpeta seleccionada no es válida.';
                }
            } else {
                $nuevoArchivo = './' . $titulo . '.txt';
                rename($archivo, $nuevoArchivo);
                $archivo = fopen($nuevoArchivo, 'w');
                fwrite($archivo, $contenido);
                fclose($archivo);

                echo 'Nota movida a la raíz y modificada correctamente.';
            }
        } else {
            echo 'La nota no existe.';
        }
    } else {
        echo 'No se proporcionaron los datos necesarios.';
    }
} else {
    echo 'Error al procesar la solicitud.';
}
?>
<link rel="stylesheet" href="style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<div class="container"><button class="btn btn-primary" onclick="window.location.href = 'index.php';">Regresar</button></div>
