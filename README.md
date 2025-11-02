# Simple-Web-Site
A demostration on a school project
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bienvenida</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background-image: url('https://images.unsplash.com/photo-1505506874110-6a7a69069a08?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .contenedor {
      width: 60%;
      max-width: 1200px;
      background-color: rgba(255, 255, 255, 0.95);
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
      overflow: hidden;
    }

    header {
      background-color: #2c3e50;
      padding: 20px;
      display: flex;
      align-items: center;
      border-bottom: 3px solid #3498db;
    }

    .logo {
      height: 60px;
      width: auto;
    }

    main {
      padding: 40px 20px;
      text-align: center;
    }

    .video-link {
      display: inline-block;
      background-color: #e74c3c;
      color: white;
      padding: 15px 30px;
      text-decoration: none;
      border-radius: 5px;
      font-size: 18px;
      font-weight: bold;
      transition: background-color 0.3s ease;
      margin: 20px 0;
    }

    .video-link:hover {
      background-color: #c0392b;
    }

    .contador {
      background-color: #3498db;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      margin-bottom: 20px;
      display: inline-block;
      font-size: 16px;
    }

    footer {
      background-color: #34495e;
      color: white;
      padding: 30px 20px;
      text-align: center;
    }

    .info-footer {
      line-height: 1.8;
    }

    .info-footer p {
      margin: 5px 0;
    }

    .email {
      color: #3498db;
      text-decoration: none;
    }

    .email:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <?php
  // Funcionalidad 1: Variables Dinámicas
  $nombre_curso = "Desarrollo de Sistemas Web";
  $nombre_alumno = "Miguel Angel García Carloz";
  $codigo = "223984318";
  $email = "ghverdes@gmail.com";
  $logo_url = "https://i.postimg.cc/Bn4hmWJt/netflix-logo.jpg";
  
  // Funcionalidad 3: Contador de Visitas
  $archivo_contador = "contador.txt";
  $visitas = 1;
  
  if(file_exists($archivo_contador)) {
      $visitas = file_get_contents($archivo_contador) + 1;
  }
  file_put_contents($archivo_contador, $visitas);
  ?>
  
  <div class="contenedor">
    <header>
      <img src="<?php echo $logo_url; ?>" alt="Logo del sitio" class="logo">
    </header>

    <main>
      <div class="contador">
        <strong>Visitas:</strong> <?php echo $visitas; ?>
      </div>
      <br>
      <a href="https://www.netflix.com/watch/70143836" class="video-link" target="_blank">
         Netflix
      </a>
    </main>

    <footer>
      <div class="info-footer">
        <p><strong>Curso:</strong> <?php echo $nombre_curso; ?></p>
        <p><strong>Nombre:</strong> <?php echo $nombre_alumno; ?></p>
        <p><strong>Código:</strong> <?php echo $codigo; ?></p>
        <p><strong>Contacto:</strong> 
          <a href="mailto:<?php echo $email; ?>" class="email"><?php echo $email; ?></a>
        </p>
      </div>
    </footer>
  </div>
</body>
</html>
