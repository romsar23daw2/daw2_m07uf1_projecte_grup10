<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Email</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <form class="bg-white p-4 rounded shadow-sm" action="send.php" method="post">
            <div class="form-group">
                <label for="subject">Asumpte</label>
                <select class="form-control" id="subject" name="subject">
                    <option value="petició de modificacio/esborrament del compte de client">Petició de modificació/esborrament del compte de client</option>
                    <option value="petició de justificació de comanda rebutjada">Petició de justificació de comanda rebutjada</option>
                </select>
            </div>
            <div class="form-group">
                <label for="message">Missatge</label>
                <input type="text" class="form-control" id="message" name="message" value="">
            </div>
            <div class="form-group">
                <a href="../menu.php" class="btn btn-secondary">Tornar</a>
                
                <button type="submit" class="btn btn-success" name="send">Enviar</button>
            </div>
        </form>
    </div>
</body>
</html>
