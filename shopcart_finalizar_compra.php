<?php
session_start();

// Verifica se o usuÃƒÂ¡rio estÃƒÂ¡ logado
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Incluir funÃƒÂ§ÃƒÂµes de gerenciamento do carrinho
include 'shopcart_controller.php';

?>

<?php include 'header.php'; ?>

<div class="container p-2">
    <h4>FinalizaÃ§Ã£o da Compra - Resumo do Pedido</h4>
    <?php if (isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0): ?>
        <table class="table table-bordered table-warning table-striped table-hover table-sm">
            <thead class="table-dark">
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>PreÃƒÂ§o</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['carrinho'] as $id_produto => $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['nome_produto']); ?></td>
                        <td><?php echo $item['quantidade']; ?></td>
                        <td>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                        <td>R$ <?php echo number_format($item['subtotal'], 2, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h4>Total da Compra: R$ <?php echo number_format(calcularTotalCarrinho(), 2, ',', '.'); ?></h4>

        <form method="POST" action="shopcart_processar_compra.php">
            <input type="hidden" name="acao" value="finalizar">
            <button type="submit" class="btn btn-success"><i class="bi bi-check-lg"></i> FINALIZAR COMPRA</button>
            <a href="shopcart.php" class="btn btn-warning"><i class="bi bi-chevron-left"></i> VOLTAR AO CARRINHO</a>
        </form>

    <?php else: ?>
        <p>Seu carrinho estÃ¡ vazio.</p>
        <a href="principal.php" class="btn btn-primary">Voltar para os Produtos</a>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
