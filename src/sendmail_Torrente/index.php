<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Email</title>
    <style>
        button {
            padding: 10px;
            background-color: #4CAF50; 
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <form action="send.php" method="post"><br>
        <label for="subject">Assumpte</label>
        <select name="subject" id="subject">
            <option value="Petició de modificació/esborrament del compte de client">Petició de modificació/esborrament del compte de client</option>
            <option value="Petició de justificació de comanda rebutjada">Petició de justificació de comanda rebutjada</option>
        </select><br><br>

        <label for="message">Missatge</label>
        <input type="text" name="message" id="message"><br><br>
        <button type="submit" name="send">Enviar</button> 
        
        <input type="hidden" name="gestor_email" value="<?php echo obtenerGestorAsignado($_SESSION['nombre_de_usuario_cliente']); ?>">

    </form>
</body>
</html>
