<?php include 'principal_controller.php'; ?>
<?php include 'header.php'; ?>

<div class="container mt-4">
    <h2> <?php echo "Bem-vindo " . $_SESSION['nome']; ?>!</h2>

    <form method="POST" action="">
        <input type="submit" name="logout" value="Logout" class="btn btn-danger">
    </form>

    <h3 class="mt-4">Produtos Cadastrados</h3>
    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <?php if (!empty($product['url_img'])): ?>
                        <img src="<?php echo $product['url_img']; ?>" class="card-img-top" alt="Imagem do Produto" style="max-height: 200px; object-fit: cover;">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/200" class="card-img-top" alt="Imagem do Produto">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($product['nome']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($product['descricao']); ?></p>
                        <p><strong>Marca:</strong> <?php echo htmlspecialchars($product['marca']); ?></p>
                        <p><strong>Modelo:</strong> <?php echo htmlspecialchars($product['modelo']); ?></p>
                        <p><strong>Valor:</strong> R$ <?php echo number_format($product['valorunitario'], 2, ',', '.'); ?></p>
                        <a href="produto_detalhes.php?id=<?php echo $product['id']; ?>" class="btn btn-primary">Adicionar ao Carrinho</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'footer.php'; ?>