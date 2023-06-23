<!DOCTYPE html>
<html>
<head>
    <title>Directorio</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        

        .list-group-item img {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }
    </style>
</head>

<header>
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
</header>
<body>

<section class="hero">
    <div class="container">
        <?php
        $directorio = './';

        if (isset($_POST['editar'])) {
            $carpetaAnterior = $_POST['carpetaAnterior'];
            $carpetaNueva = $_POST['carpetaNueva'];
            $carpetaNueva = str_replace(' ', '_', $_POST['carpetaNueva']);

            if ($carpetaAnterior !== '' && $carpetaNueva !== '') {
                if (is_dir($directorio . $carpetaAnterior)) {
                    rename($directorio . $carpetaAnterior, $directorio . $carpetaNueva);
                }
            }
        }

        if (isset($_POST['eliminar'])) {
            $carpetaEliminar = $_POST['carpetaEliminar'];

            if ($carpetaEliminar !== '') {
                if (is_dir($directorio . $carpetaEliminar)) {
                    $archivos = glob($directorio . $carpetaEliminar . '/*.txt');
                    foreach ($archivos as $archivo) {
                        unlink($archivo);
                    }

                    rmdir($directorio . $carpetaEliminar);
                }
            }
        }

        $carpetas = array_filter(glob($directorio . '*'), 'is_dir');
        $archivosFueraCarpetas = glob($directorio . '*.txt');
        ?>

        <ul class="list-group">
            <?php foreach ($carpetas as $carpeta) {
                $nombreCarpeta = basename($carpeta);
                echo '<li class="list-group-item">';
                echo '<img src="carpeta.png" alt="Carpeta">';
                echo $nombreCarpeta;

                // Botón Editar
                echo '<button type="button" class="btn btn-primary btn-sm ml-2" data-toggle="modal" data-target="#editarModal' . $nombreCarpeta . '">Editar</button>';

                // Ventana emergente para Editar
                echo '<div class="modal fade" id="editarModal' . $nombreCarpeta . '" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel' . $nombreCarpeta . '" aria-hidden="true">';
                echo '<div class="modal-dialog" role="document">';
                echo '<div class="modal-content">';
                echo '<div class="modal-header">';
                echo '<h5 class="modal-title" id="editarModalLabel' . $nombreCarpeta . '">Editar carpeta: ' . $nombreCarpeta . '</h5>';
                echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                echo '<span aria-hidden="true">&times;</span>';
                echo '</button>';
                echo '</div>';
                echo '<div class="modal-body">';
                echo '<form action="" method="post">';
                echo '<input type="hidden" name="carpetaAnterior" value="' . $nombreCarpeta . '">';
                echo '<input type="text" name="carpetaNueva" class="form-control" placeholder="Nuevo nombre" required>';
                echo '</div>';
                echo '<div class="modal-footer">';
                echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>';
                echo '<button type="submit" name="editar" class="btn btn-primary">Guardar cambios</button>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';

                // Botón Eliminar
                echo '<button type="button" class="btn btn-danger btn-sm ml-2" data-toggle="modal" data-target="#eliminarModal' . $nombreCarpeta . '">Eliminar</button>';

                // Ventana emergente para Eliminar
                echo '<div class="modal fade" id="eliminarModal' . $nombreCarpeta . '" tabindex="-1" role="dialog" aria-labelledby="eliminarModalLabel' . $nombreCarpeta . '" aria-hidden="true">';
                echo '<div class="modal-dialog" role="document">';
                echo '<div class="modal-content">';
                echo '<div class="modal-header">';
                echo '<h5 class="modal-title" id="eliminarModalLabel' . $nombreCarpeta . '">Eliminar carpeta: ' . $nombreCarpeta . '</h5>';
                echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                echo '<span aria-hidden="true">&times;</span>';
                echo '</button>';
                echo '</div>';
                echo '<div class="modal-body">';
                echo '<p>¿Estás seguro de que deseas eliminar la carpeta ' . $nombreCarpeta . '?</p>';
                echo '</div>';
                echo '<div class="modal-footer">';
                echo '<form action="" method="post">';
                echo '<input type="hidden" name="carpetaEliminar" value="' . $nombreCarpeta . '">';
                echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>';
                echo '<button type="submit" name="eliminar" class="btn btn-danger">Eliminar</button>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';

                echo '</li>';

                // Mostrar archivos de texto dentro de la carpeta
                $archivosTxt = glob($carpeta . '/*.txt');
                if (!empty($archivosTxt)) {
                    foreach ($archivosTxt as $archivo) {
                        $nombreArchivo = basename($archivo);
                        echo '<li class="list-group-item pl-5">';
                        echo '<img src="texto.png" alt="Archivo de texto">';
                        echo $nombreArchivo;
                        echo '<a class="btn btn-primary btn-sm ml-2" href="visualizar.php?archivo=' . urlencode($archivo) . '">Visualizar</a>';
                        echo '</li>';
                    }
                }
            } ?>

            <?php foreach ($archivosFueraCarpetas as $archivo) {
                $nombreArchivo = basename($archivo);
                echo '<li class="list-group-item">';
                echo '<img src="texto.png" alt="Archivo de texto">';
                echo $nombreArchivo;
                echo '<a class="btn btn-primary btn-sm ml-2" href="visualizar.php?archivo=' . urlencode($archivo) . '">Visualizar</a>';
                echo '</li>';
            } ?>
        </ul>
    </div>
    </section>  
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>