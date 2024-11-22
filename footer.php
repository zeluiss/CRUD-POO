<footer class="bg-dark text-white d-flex align-items-center" style="height: 1cm;">
    <div class="container text-center">
        <!-- Exibe o nome do usuário logado, se existir -->
        <p class="mb-0">
            &copy; <?php echo date("Y"); ?> Z Enterprise. Todos os direitos reservados. 
            <?php 
            if (isset($_SESSION['nome'])) { 
                echo "Bem-vindo, " . $_SESSION['nome']; // Exibe o nome do usuário logado
            }
            ?>
        </p>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>