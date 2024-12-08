<?php
session_start();

// Inicializa os contadores na sessão, caso não existam
if (!isset($_SESSION['sent'])) $_SESSION['sent'] = 0;
if (!isset($_SESSION['errors'])) $_SESSION['errors'] = 0;

// Verifica se os dados foram enviados pelo método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userInput = trim($_POST['userInput'] ?? '');

    if (!empty($userInput)) {
        // Divide o conteúdo do textarea por linhas
        $lines = explode("\n", $userInput);

        foreach ($lines as $line) {
            // Remove espaços em branco extras
            $line = trim($line);

            // Separa o conteúdo por ":"
            $parts = explode(':', $line);

            if (count($parts) === 2) {
                $cpf = trim($parts[0]);
                $numero = trim($parts[1]);

                // Consulta os dados do cliente pela API usando o CPF
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://x-search.xyz/3nd-p01n75/xsiayer0-0t/lunder231224/r0070x/05/cpf.php?cpf=$cpf");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'accept: application/json',
                    'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                ]);

                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                if ($httpCode === 200) {
                    // Decodifica o JSON recebido
                    $data = json_decode($response, true);

                    if ($data['status'] === 1 && isset($data['dados'][0]['Nome'])) {
                        $nome = $data['dados'][0]['Nome'];
                        $msg = "ola $nome";

                        // Envia o SMS para o número usando a API
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, "http://sms.pswin.com/http4sms/send.asp?USER=thonh&PW=T02YoSzrH&RCV=$numero&TXT=" . urlencode($msg));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                            'accept: text/html',
                            'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
                        ]);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                        $smsResponse = curl_exec($ch);
                        $smsHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                        curl_close($ch);

                        if ($smsHttpCode === 200) {
                            $_SESSION['sent']++;
                        } else {
                            $_SESSION['errors']++;
                        }
                    } else {
                        $_SESSION['errors']++; // Erro na consulta do CPF
                    }
                } else {
                    $_SESSION['errors']++; // Erro na requisição para a API do CPF
                }
            } else {
                $_SESSION['errors']++; // Linha inválida
            }
        }
    } else {
        $_SESSION['errors']++; // Entrada vazia
    }
}

// Redireciona de volta para o formulário
header('Location: index.php');
exit;
?>
