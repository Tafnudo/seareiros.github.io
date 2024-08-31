<?php
$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica e salva o aviso
    if (isset($_POST['aviso'])) {
        $aviso = $_POST['aviso'];
        file_put_contents('config.json', json_encode(['aviso' => $aviso]));
    }

    // Verifica e salva as imagens
    if (isset($_FILES['images'])) {
        $uploadDir = 'uploads/';
        foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
            $fileName = basename($_FILES['images']['name'][$key]);
            $targetFile = $uploadDir . $fileName;

            if (move_uploaded_file($tmpName, $targetFile)) {
                $response['success'] = true;
            } else {
                $response['success'] = false;
                break;
            }
        }
    }

    echo json_encode($response);
    exit;
}
?>
