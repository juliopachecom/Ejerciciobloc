<?php
if(isset($_GET['archivo'])) {
    $archivoSeleccionado = $_GET['archivo'];
    $contenidoSeleccionado = file_get_contents($archivoSeleccionado);
    $tituloSeleccionado = pathinfo($archivoSeleccionado, PATHINFO_FILENAME);
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Visualizar Nota</title>
</head>
<body>
    <h1><p>Visualizar Nota</p></h1>

    <?php if (isset($contenidoSeleccionado)): ?>
        <div class="card">
            <h2>Título: <?php echo $tituloSeleccionado; ?></h2>
            <h5>Contenido de la nota:</h5>
            <p><?php echo $contenidoSeleccionado; ?></p>
        </div>
    <?php else: ?>
        <p>No se ha seleccionado ninguna nota.</p>
    <?php endif; ?>
    <div class="container"><button class="btn btn-primary" onclick="window.location.href = 'index.php';">Regresar</button></div></body>
</html>
