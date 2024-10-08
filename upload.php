<?php
header('Content-Type: application/json');

// Inicializa a resposta
$response = array('success' => false, 'message' => '');

// Verifica se o aviso foi enviado
if (isset($_POST['aviso'])) {
    $aviso = trim($_POST['aviso']);

    // Validação simples
    if (!empty($aviso)) {
        // Atualiza o arquivo config.json
        $config = array('aviso' => $aviso);
        if (file_put_contents('config.json', json_encode($config, JSON_PRETTY_PRINT))) {
            $response['success'] = true;
            $response['message'] = 'Aviso atualizado com sucesso.';
        } else {
            $response['message'] = 'Falha ao atualizar o aviso.';
        }
    } else {
        $response['message'] = 'O aviso não pode estar vazio.';
    }
} else {
    $response['message'] = 'Aviso não fornecido.';
}

// Lida com upload de imagens, se houver
if (!empty($_FILES['images']['name'][0])) {
    $uploadDir = 'imagens/'; // Certifique-se de que este diretório exista e tenha permissões de escrita
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
        $nomeArquivo = basename($_FILES['images']['name'][$key]);
        $caminhoDestino = $uploadDir . $nomeArquivo;

        // Verifica se o arquivo é uma imagem
        $check = getimagesize($tmpName);
        if ($check !== false) {
            // Move o arquivo para o diretório de destino
            if (move_uploaded_file($tmpName, $caminhoDestino)) {
                $response['success'] = true;
            } else {
                $response['success'] = false;
                $response['message'] .= 'Falha ao fazer upload da imagem: ' . $nomeArquivo . '. ';
            }
        } else {
            $response['success'] = false;
            $response['message'] .= 'Arquivo não é uma imagem válida: ' . $nomeArquivo . '. ';
        }
    }
} else {
    if ($response['success'] === false) {
        $response['message'] .= 'Nenhuma imagem foi enviada.';
    }
}

echo json_encode($response);
?>