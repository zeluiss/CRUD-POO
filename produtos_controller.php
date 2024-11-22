<?php
include 'db.php';

// Função para salvar produto
function saveProduct($nome, $descricao, $marca, $modelo, $valorunitario, $categoria, $url_img, $ativo) {
    global $conn;
    // Verificar se a imagem foi enviada
    $stmt = $conn->prepare("INSERT INTO produtos (nome, descricao, marca, modelo, valorunitario, categoria, url_img, ativo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssi", $nome, $descricao, $marca, $modelo, $valorunitario, $categoria, $url_img, $ativo);
    return $stmt->execute();
}


// Função para obter todos os produtos
function getProducts() {
    global $conn;
    $result = $conn->query("SELECT * FROM produtos");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Função para obter um produto específico
function getProduct($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Função para atualizar um produto
function updateProduct($id, $nome, $descricao, $marca, $modelo, $valorunitario, $categoria, $url_img, $ativo) {
    global $conn;
    $stmt = $conn->prepare("UPDATE produtos SET nome = ?, descricao = ?, marca = ?, modelo = ?, valorunitario = ?, categoria = ?, url_img = ?, ativo = ? WHERE id = ?");
    $stmt->bind_param("ssssssssi", $nome, $descricao, $marca, $modelo, $valorunitario, $categoria, $url_img, $ativo, $id);
    return $stmt->execute();
}

// Função para excluir um produto
function deleteProduct($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM produtos WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// Processamento do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar se o campo de imagem foi enviado
    $url_img = ''; // Valor padrão caso não haja imagem
    if (isset($_FILES['url_img']) && $_FILES['url_img']['error'] == 0) {
        // Processar o upload da imagem
        $url_img = 'uploads/' . $_FILES['url_img']['name']; // Caminho do arquivo para salvar na pasta 'uploads'
        move_uploaded_file($_FILES['url_img']['tmp_name'], $url_img);
    } elseif (isset($_POST['url_img'])) {
        // Se o campo de imagem foi enviado como texto (no caso de edição)
        $url_img = $_POST['url_img'];
    }

    if (isset($_POST['save'])) {
        saveProduct($_POST['nome'], $_POST['descricao'], $_POST['marca'], $_POST['modelo'], $_POST['valorunitario'], $_POST['categoria'], $url_img, isset($_POST['ativo']) ? 1 : 0);
    } elseif (isset($_POST['update'])) {
        updateProduct($_POST['id'], $_POST['nome'], $_POST['descricao'], $_POST['marca'], $_POST['modelo'], $_POST['valorunitario'], $_POST['categoria'], $url_img, isset($_POST['ativo']) ? 1 : 0);
    }
}

// Processamento da exclusão
if (isset($_GET['delete'])) {
    deleteProduct($_GET['delete']);
}
?>