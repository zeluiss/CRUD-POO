<?php
session_start(); // Inicia a sessão

include 'db.php'; // Conecta ao banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Prepara a consulta para verificar se o usuário existe no banco de dados
    $stmt = $conn->prepare("SELECT nome, senha FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email); // Bind da variável email
    $stmt->execute(); // Executa a consulta
    $stmt->store_result(); // Armazena o resultado

    // Se o usuário for encontrado
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($nome, $senha_db); // Recupera o nome e a senha do banco
        $stmt->fetch(); // Preenche as variáveis com o resultado da consulta

        // Verifica se a senha fornecida é a mesma que está no banco de dados
        if ($senha == $senha_db) {
            // Se a senha estiver correta, registra os dados do usuário na sessão
            $_SESSION['email'] = $email;
            $_SESSION['nome'] = $nome;

            // Redireciona para a página principal
            header("Location: principal.php");
            exit(); // Interrompe a execução após o redirecionamento
        } else {
            // Se a senha estiver incorreta
            echo "Login ou senha inválidos. Tente novamente.";
        }
    } else {
        // Se o email não for encontrado
        echo "Login ou senha inválidos. Tente novamente.";
    }

    // Fecha a consulta
    $stmt->close();
}

// Fecha a conexão com o banco de dados
$conn->close();
?>