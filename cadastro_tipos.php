<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Tipos de Produtos</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <center>
        <h2>Cadastro de Tipos de Produtos</h2>

        <!-- Formulário de Cadastro de Tipos de Produtos -->
        <form action="tipos.php" method="POST">
            <label for="tipo">Tipo de Produto:</label><br>
            <input type="text" name="tipo" required><br>
            <br><button type="submit">Cadastrar</button>
            <button type="submit"><a href="index.php" class="btn">Voltar</a></button>

        </form><br>

        <!-- Grid de Tipos de Produtos -->
        <table>
            <thead>
                <tr>
                    <th>Tipo de Produto</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Conexão com o banco de dados
                include 'conexao.php';
                
                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    // Consulta dos tipos de produtos cadastrados
                    $sql = "SELECT * FROM tipos_produto";
                    $stmt = $conn->query($sql);
                    $tiposProdutos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach ($tiposProdutos as $tipoProduto) {
                        echo "<tr><td>".$tipoProduto['tipo']."</td></tr>";
                    }
                } catch(PDOException $e) {
                    echo "Erro na conexão com o banco de dados: " . $e->getMessage();
                }
                ?>
            </tbody>
        </table>
    </center>
</body>
</html>
