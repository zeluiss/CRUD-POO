<?php
//Prepara pa gerenciar a sessão
session_start();

include 'db.php'; // Conectar ao banco de dados

// Verifica se o usuário está registrado na sessão (logado)
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Armazena informações do usuário
$nome = $_SESSION['nome'];
$email = $_SESSION['email'];

// Função para lidar com o logout
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

// Função para obter todos os produtos
function getProducts() {
    global $conn;
    $result = $conn->query("SELECT * FROM produtos");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Obter todos os produtos para exibição na página principal
$products = getProducts();

// Variável de nome, se houver (pode ser parte de um sistema de login)
$nome = "Usuário"; // Você pode substituir por uma variável de sessão ou banco de dados
?>