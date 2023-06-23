<?php

//FUNCION POST PARA GUARDADO DE LOS ARCHIVOS TXT
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $carpeta = $_POST['carpeta'];

    $nombreArchivo = str_replace(' ', '_', $titulo) . '.txt';
    $carpeta = str_replace(' ', '_', $carpeta); 
    $rutaCarpeta = './' . $carpeta . '/';
    $rutaArchivo = $rutaCarpeta . $nombreArchivo;

    if (!is_dir($rutaCarpeta)) {
        mkdir($rutaCarpeta, 0777, true);
    }

    $archivo = fopen($rutaArchivo, 'w');
    fwrite($archivo, $contenido);
    fclose($archivo);

    header('Location: index.php?success=true');
    exit();
}

//FUNCION PARA LLENAR LA TABLA DE NOTAS EXISTENTES 
function obtenerNotas($directorio, $carpetaActual = '', $nivel = 0) {
    $notas = array();

    $archivos = scandir($directorio);
    foreach ($archivos as $archivo) {
        if ($archivo === '.' || $archivo === '..') {
            continue;
        }

        $rutaArchivo = $directorio . '/' . $archivo;

        if (is_dir($rutaArchivo)) {
            $nuevaCarpeta = $carpetaActual . '/' . $archivo;
            $notas[] = [
                'titulo' => $archivo,
                'archivo' => '',
                'carpeta' => $carpetaActual !== '' ? $carpetaActual : 'Sin carpeta',
                'profundidad' => $nivel
            ];
            $notas = array_merge($notas, obtenerNotas($rutaArchivo, $nuevaCarpeta, $nivel + 1));
        } elseif (pathinfo($archivo, PATHINFO_EXTENSION) === 'txt') {
            $titulo = pathinfo($archivo, PATHINFO_FILENAME);
            $notas[] = [
                'titulo' => $titulo,
                'archivo' => $rutaArchivo,
                'carpeta' => $carpetaActual !== '' ? $carpetaActual : 'Sin carpeta',
                'profundidad' => $nivel
            ];
        }
    }

    return $notas;
}

$notas = obtenerNotas('.', '');

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/your-kit-id.js" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>BlackNotes</title>
</head>
<header id="header">

<div class="Entradaspr">
    <div class="container d-flex align-items-center justify-content-between">
        <div class="logo">
            <h1 class="logo"><a href="index.php">Black Notes<span>.</span></a></h1>
        </div>
        <nav class="navbar navbar-expand-lg" fixed-top>

            <div class="container-fluid">
                <button id="navtoggle" class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                        </li>
                      <li><a class="getstarted scrollto" href="/php15/index.php"><img src="mas.png" alt="">  INICIO</a></li>
                       <li><a class="getstarted scrollto" href="/php15/directorio.php"> <img src="tarea-completada.png" alt=""> DIRECTORIO</a></li>
                        <li><a class="getstarted scrollto" href="/php15/index.php#card"><img src="texto.png" alt="">   NOTAS </a></li>
                    </ul>
                </div>
            </div>
        </nav>

    </div>
</header>
<body>

<section class="hero">

    <div class="card1">
        <form method="POST" action="index.php" class="form">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" required placeholder="Colocale un Titulo al texto">
            </div>
            <div class="form-group">
                <label for="carpeta">Carpeta: (Puedes dejarla vacia si quieres que se guarde en la raiz)</label>
                <input type="text" id="carpeta" name="carpeta" placeholder="Nombre de la Carpeta (Si ya existe Se combina)">
            </div>
            <div class="form-group">
                <label for="contenido">Contenido:</label>
                <textarea id="contenido" name="contenido" required placeholder="Escribe el contenido"></textarea>
            </div>
            <input type="submit" value="Guardar" class="btn btn-success">
        </form>
        
        <div class="container">
            <?php if (isset($_GET['success']) && $_GET['success'] === 'true'): ?>
                <div class="alert alert-success" role="alert">
                    ¡La nota se ha guardado exitosamente!
                </div>
            <?php endif; ?>
           <a class="btn btn-warning" href="directorio.php">Ver directorio</a>

        </div>
    </div>

    <br>
    <div class="card" id="card">
        <h2>Notas:</h2>

        <?php
        $carpetas = array();
        $archivosTxt = array();

        foreach ($notas as $nota) {
            if ($nota['carpeta'] !== '') {
                $carpetas[$nota['carpeta']] = $nota['profundidad'];
            }

            if (!empty($nota['archivo'])) {
                $ext = pathinfo($nota['archivo'], PATHINFO_EXTENSION);
                if ($ext === 'txt') {
                    $archivosTxt[] = $nota;
                }
            }
        }
        ?>

        <form method="GET" action="index.php">
            <label for="filtro-carpeta">Filtrar por carpeta:</label>
            <select id="filtro-carpeta" name="filtro-carpeta">
                <option value="">Todas las carpetas</option>
                <?php foreach ($carpetas as $carpeta => $profundidad): ?>
                    <option value="<?php echo htmlspecialchars($carpeta); ?>"><?php echo str_repeat('&nbsp;&nbsp;&nbsp;', $profundidad) . htmlspecialchars($carpeta); ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" value="Filtrar" class="btn btn-primary">Filtrar</button>
        </form>

        <?php
        $filtroCarpeta = isset($_GET['filtro-carpeta']) ? $_GET['filtro-carpeta'] : '';
        $notasFiltradas = array_filter($archivosTxt, function ($nota) use ($filtroCarpeta) {
            return $filtroCarpeta === '' || $nota['carpeta'] === $filtroCarpeta;
        });
        ?>

        <?php if (count($notasFiltradas) > 0): ?>
            <table class="mtable">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Carpeta</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($notasFiltradas as $nota): ?>
                        <tr>
                            <td><img src="texto.png" alt=""><?php echo str_repeat('&nbsp;&nbsp;&nbsp;', $nota['profundidad']) . htmlspecialchars($nota['titulo']); ?></td>
                            <td><img src="carpeta.png" alt=""><?php echo htmlspecialchars($nota['carpeta']); ?></td>
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
</section>

</body>
</html>
