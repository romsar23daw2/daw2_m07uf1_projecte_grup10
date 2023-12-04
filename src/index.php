<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="utf-8">
    <title>Botiga de rellotges</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./Assets/Stylesheets/agenda.css">
    <style>
        body {
            background-image: url('./Assets/Images/background.jpg');
            background-size: 100%;
            background-repeat: no-repeat;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .content {
            text-align: center;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(5px);
        }
    </style>
</head>

<body class="bg-light">
    <div class="content">
        <h3><b>Pàgina d'inici de la botiga de rellotges</b></h3><br>
        <a href="login.php" class="btn btn-primary">Login</a><br><br>
        <a href="info.php" class="btn btn-secondary">Informació</a><br><br>

        <label class="diahora mt-3">
            <?php
            date_default_timezone_set('Europe/Andorra');
            echo "<p>Data i hora: " . date('d/m/Y h:i:s') . "</p>";
            ?>
        </label>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>