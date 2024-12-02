<?php
session_start();
include 'header.php';
?>

<div class="container p-2">
    <h2>Compra Finalizada com Sucesso!</h2>
    <p>Obrigado pela sua compra. Em breve, entraremos em contato com mais informaÃƒÂ§ÃƒÂµes.</p>
    <a href="principal.php" class="btn btn-primary">Voltar para a Loja</a>
</div>

<?php include 'footer.php'; ?>

shopcart_processar_compra.php

<?php
include 'db.php';
include 'shopcart_controller.php';
//session_start();

// Armazena informaÃƒÂ§ÃƒÂµes do usuÃƒÂ¡rio
$nome = $_SESSION['nome'];
$email = $_SESSION['email'];

// Verifica se o usuÃƒÂ¡rio estÃƒÂ¡ logado
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// FunÃƒÂ§ÃƒÂ£o para salvar o pedido no banco de dados (exemplo simples)
function salvarPedido($carrinho, $total) {
    global $conn;
    
    // Pega o ID do usuÃƒÂ¡rio que estÃƒÂ¡ na sessÃƒÂ£o
    $id_usuario = $_SESSION['id'];  // Pegando o ID do usuÃƒÂ¡rio que estÃƒÂ¡ na sessÃƒÂ£o
    $data_pedido = date('Y-m-d H:i:s');

    // Tenta inserir o pedido no banco
    try {
        $sql = "INSERT INTO pedidos (id_usuario, total, data_pedido) VALUES ('$id_usuario', '$total', '$data_pedido')";
        
        if ($conn->query($sql) === TRUE) {
            $pedido_id = $conn->insert_id;  // ObtÃƒÂ©m o ID do pedido recÃƒÂ©m-criado
            
            // Inserir itens do pedido no banco
            foreach ($carrinho as $id_produto => $item) {
                $produto_id = $item['id_produto'];
                $quantidade = $item['quantidade'];
                $subtotal = $item['subtotal'];

                $sql_item = "INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, subtotal) 
                             VALUES ('$pedido_id', '$produto_id', '$quantidade', '$subtotal')";
                if ($conn->query($sql_item) === FALSE) {
                    throw new Exception("Erro ao inserir item do pedido: " . $conn->error);
                }
            }

            return true;  // Pedido e itens foram inseridos com sucesso
        } else {
            throw new Exception("Erro ao inserir pedido: " . $conn->error);
        }
    } catch (Exception $e) {
        // Retorna o erro para ser tratado na pÃƒÂ¡gina de erro
        return $e->getMessage();
    }
}

// Verifica se o botÃƒÂ£o de finalizar compra foi acionado
if (isset($_POST['acao']) && $_POST['acao'] == 'finalizar') {
    $total = calcularTotalCarrinho();  // Calcula o total da compra

    // Salva o pedido no banco de dados
    $erro = salvarPedido($_SESSION['carrinho'], $total);

    if ($erro === true) {
        // Limpa o carrinho da sessÃƒÂ£o
        unset($_SESSION['carrinho']);

        // Redireciona para a pÃƒÂ¡gina de confirmaÃƒÂ§ÃƒÂ£o de compra ou pagamento
        header("Location: shopcart_sucesso_compra.php");
        exit();
    } else {
        // Se algo falhou ao salvar o pedido, redireciona para a pÃƒÂ¡gina de erro com a mensagem de erro
        $_SESSION['erro_compra'] = $erro;  // Armazena o erro na sessÃƒÂ£o
        header("Location: shopcart_erro_compra.php");
        exit();
    }
} else {
    // Se a aÃƒÂ§ÃƒÂ£o nÃƒÂ£o for vÃƒÂ¡lida, redireciona para a pÃƒÂ¡gina inicial ou carrinho
    header("Location: index.php");
    exit();
}
?>
