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

$directorio = './';

// Obtener las carpetas existentes
$carpetas = array_filter(glob($directorio . '*', GLOB_ONLYDIR));
?>

<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<head>
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
    
    <div class="card">

    <form method="POST" action="guardado.php">
        <input type="hidden" name="archivo" value="<?php echo $archivo; ?>">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required value="<?php echo $titulo; ?>">
        <br>
        <label for="contenido">Contenido:</label>
        <textarea id="contenido" name="contenido" required><?php echo $contenido; ?></textarea>
        <br>
        <label for="carpeta">Carpeta:</label>
        <select id="carpeta" name="carpeta">
            <option value="">Seleccionar carpeta</option>
            <?php
            // Mostrar las carpetas existentes como opciones
            foreach ($carpetas as $carpeta) {
                $nombreCarpeta = basename($carpeta);
                echo '<option value="' . $nombreCarpeta . '">' . $nombreCarpeta . '</option>';
            }
            ?>
            <option value="">Mover a la raíz</option>
        </select>
        <br>
        <input type="submit" value="Guardar">
    </form>
    </div>
    </section>
</body>
</html>
