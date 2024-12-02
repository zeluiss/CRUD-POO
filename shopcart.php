<?php
session_start();

// Verifica se o usuÃ¡rio estÃ¡ logado
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

include 'shopcart_controller.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Carrinho de Compras</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Garantir que o body ocupe a altura total da tela */
        body {
            display: flex;
            flex-direction: column;
            height: 100vh; /* 100% da altura da tela */
        }

        /* O conteÃºdo principal ocuparÃ¡ todo o espaÃ§o disponÃ­vel */
        .container {
            flex-grow: 1;
        }

        /* Limitar o tamanho das imagens no carrinho */
        .img-carrinho {
            max-width: 50px;
            max-height: 50px;
            object-fit: cover;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Header -->
    <?php include 'header.php'; ?>

    <!-- ConteÃºdo principal -->
    <div class="container p-2 flex-grow-1">
        <h3>Carrinho de Compras</h3>

        <?php if (isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0): ?>
            <table border="1" class="table table-bordered table-light table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>Imagem</th>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>PreÃ§o</th>
                        <th>Subtotal</th>
                        <th>AÃ§Ãµes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['carrinho'] as $id_produto => $item): ?>
                        <tr>
                            <!-- Exibir a imagem do produto -->
                            <td>
                                <?php 
                                    // Verifica se o caminho da imagem estÃ¡ correto
                                    if (!empty($item['url_img']) && file_exists($item['url_img'])): 
                                ?>
                                    <img src="<?php echo $item['url_img']; ?>" alt="Imagem do Produto" class="img-carrinho">
                                <?php else: ?>
                                    <!-- Caso nÃ£o tenha imagem, exibe um placeholder -->
                                    <img src="https://via.placeholder.com/150" alt="Imagem do Produto" class="img-carrinho">
                                <?php endif; ?>
                            </td>
                            <!-- Exibir o nome do produto -->
                            <td><?php echo htmlspecialchars($item['nome_produto']); ?></td>
                            <!-- FormulÃ¡rio para alterar a quantidade -->
                            <td>
                                <form method="POST" action="shopcart_controller.php">
                                    <input type="hidden" name="id_produto" value="<?php echo $id_produto; ?>">
                                    <input type="number" name="quantidade" value="<?php echo $item['quantidade']; ?>" min="1" max="10">
                                    <button type="submit" name="action" value="alterar" class="btn btn-sm btn-warning"><i class="bi bi-pencil-fill"></i> ALTERAR</button>
                                </form>
                            </td>
                            <!-- Exibir o preÃ§o do produto -->
                            <td>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                            <!-- Exibir o subtotal -->
                            <td>R$ <?php echo number_format($item['subtotal'], 2, ',', '.'); ?></td>
                            <!-- BotÃ£o para excluir o produto -->
                            <td><a href="shopcart_controller.php?action=remover&id_produto=<?php echo $id_produto; ?>" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i> EXCLUIR</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h3>Total: R$ <?php echo number_format(calcularTotalCarrinho(), 2, ',', '.'); ?></h3>

            <a href="shopcart_finalizar_compra.php" class="btn btn-success"><i class="bi bi-check-lg"></i> FINALIZAR COMPRA</a>
            <a href="principal.php" class="btn btn-primary"><i class="bi bi-chevron-left"></i> CONTINUAR COMPRA</a>
        <?php else: ?>
            <p>Seu carrinho estÃ¡ vazio.</p>
            <a href="principal.php" class="btn btn-primary"><i class="bi bi-arrow-return-left"></i> VOLTAR</a>
        <?php endif; ?>
    </div>

</body>
</html>
<?php include 'footer.php'; ?>
