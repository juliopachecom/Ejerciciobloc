<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['archivo']) && isset($_GET['titulo'])) {
        $archivo = $_GET['archivo'];
        $titulo = $_GET['titulo'];

        // Verificar si el archivo existe
        if (file_exists($archivo)) {
            // Leer el contenido actual de la nota
            $contenido = file_get_contents($archivo);
        } else {
            echo 'La nota no existe.';
            exit;
        }
    } else {
        echo 'No se proporcionaron los datos necesarios.';
        exit;
    }
} else {
    echo 'Error al procesar la solicitud.';
    exit;
}
?>

<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="style.css">
<head>
    <title>Editar Nota</title>
</head>
<body>
    <h1>Editar Nota</h1>

    <form method="POST" action="guardar_modificacion.php">
        <input type="hidden" name="archivo" value="<?php echo $archivo; ?>">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required value="<?php echo $titulo; ?>">
        <br>
        <label for="contenido">Contenido:</label>
        <textarea id="contenido" name="contenido" required><?php echo $contenido; ?></textarea>
        <br>
        <input type="submit" value="Guardar">
    </form>
</body>
</html>
