<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $nombreArchivo = str_replace(' ', '_', $titulo) . '.txt';
    $archivo = fopen($nombreArchivo, 'w');
    
    fwrite($archivo, $contenido);
    fclose($archivo);
    header('Location: index.php?success=true');
    exit();
}

$notas = [];
$archivos = glob("*.txt");
foreach ($archivos as $archivo) {
    $titulo = pathinfo($archivo, PATHINFO_FILENAME);
    $notas[] = [
        'titulo' => $titulo,
        'archivo' => $archivo
    ];
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Aplicación de Notas</title>
</head>
<body>
    <h1><p>Aplicación de Notas</p></h1>
    


    <form method="POST" action="index.php">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required>
        <br>
        <label for="contenido">Contenido:</label>
        <textarea id="contenido" name="contenido" required></textarea>
        <br>
        <input type="submit" value="Guardar" class="btn btn-success">
    </form>
    <div class="container">
    <?php if (isset($_GET['success']) && $_GET['success'] === 'true'): ?>
        <div class="alert alert-success" role="alert">
            ¡La nota se ha guardado exitosamente!
        </div>
    <?php endif; ?>
    </div>
    <div class="card">
        <h2>Notas:</h2>

        <?php if (count($notas) > 0): ?>
            <table class="mtable">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($notas as $nota): ?>
                        <tr>
                            <td><?php echo $nota['titulo']; ?></td>
                            <td>
                            <a class="btn btn-primary" href="visualizar.php?archivo=<?php echo urlencode($nota['archivo']); ?>">Visualizar</a>
                                <a class="btn btn-warning" href="editar.php?archivo=<?php echo urlencode($nota['archivo']); ?>&titulo=<?php echo urlencode($nota['titulo']); ?>">Editar</a>
                                <a class="btn btn-danger" href="eliminado.php?archivo=<?php echo urlencode($nota['archivo']); ?>">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay notas.</p>
        <?php endif; ?>
    </div>
</body>
</html>
