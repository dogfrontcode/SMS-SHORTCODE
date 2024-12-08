<?php
session_start();

// Inicializa os contadores caso não estejam definidos
if (!isset($_SESSION['sent'])) $_SESSION['sent'] = 0;
if (!isset($_SESSION['errors'])) $_SESSION['errors'] = 0;
if (!isset($_SESSION['custom'])) $_SESSION['custom'] = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Lista</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 350px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .counters {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
            width: 100%;
        }

        .counter {
            text-align: center;
            width: 30%;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px 5px;
        }

        .counter h2 {
            margin: 0;
            font-size: 18px;
            color: #007bff;
        }

        .counter p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #555;
        }

        textarea {
            width: 100%;
            height: 150px;
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 10px;
            font-size: 14px;
            resize: none;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Enviar Lista</h1>
        
        <div class="counters">
            <div class="counter">
                <h2><?php echo $_SESSION['sent']; ?></h2>
                <p>Enviados</p>
            </div>
            <div class="counter">
                <h2><?php echo $_SESSION['errors']; ?></h2>
                <p>Erros</p>
            </div>
        </div>
        
        <form action="api.php" method="POST">
            <textarea name="userInput" placeholder="01234567890:5521969503030" required></textarea>
            <button type="submit">Enviar</button>
        </form>
    </div>
</body>
</html>
