SELECT * FROM usuarios;

use dbsistema;

UPDATE usuarios SET senha = 'teste123' WHERE email = 'zeteste@teste';

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `email` varchar(80) NOT NULL,
  `senha` varchar(80) NOT NULL,
  PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  `descricao` text NOT NULL,
  `marca` varchar(80) NOT NULL,
  `modelo` varchar(80) NOT NULL,
  `valorunitario` decimal(10,0) NOT NULL,
  `categoria` varchar(80) NOT NULL,
  `url_img` varchar(250) NOT NULL,
  `ativo` tinyint(1) DEFAULT 1,
  PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE compras (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    nropedido VARCHAR(50) NOT NULL,  
    usuario INT NOT NULL,          
    idproduto INT NOT NULL,         
    quantidade INT NOT NULL,      
    valorUnitario DECIMAL(10, 2) NOT NULL, 
    dataCompra DATETIME NOT NULL,      
    datapagamento DATETIME NULL,       
    
    FOREIGN KEY (usuario) REFERENCES usuarios(id), 
    FOREIGN KEY (idproduto) REFERENCES produtos(id)
);



