<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Produtos</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
        <center>
        <h2>Cadastro de Produtos</h2>
        <br><br>
        <!-- Formulário de Cadastro de Produtos -->
        <form action="cadastro_produtos.php" method="POST">
            <label for="nome">Nome:</label>
            <br><input type="text" name="nome" required>
            <br>
            <br><label for="tipo_id">Tipo de Produto:</label>
            <br><select name="tipo_id" required><br>
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
                        echo "<option value='".$tipoProduto['id']."'>".$tipoProduto['tipo']."</option>";
                    }
                } catch(PDOException $e) {
                    echo "Erro na conexão com o banco de dados: " . $e->getMessage();
                }
                ?>
            </select><br>

            <br><label for="valor">Valor:</label><br>
            <input type="number" name="valor" required>
            <br>
            <br><button type="submit">Cadastrar</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Conexão com o banco de dados
            include 'conexao.php';

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Inserção do produto no banco de dados
                $nome = $_POST['nome'];
                $tipo_id = $_POST['tipo_id'];
                $valor = $_POST['valor'];

                $sql = "INSERT INTO produtos (nome, tipo_id, valor) VALUES (:nome, :tipo_id, :valor)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':tipo_id', $tipo_id);
                $stmt->bindParam(':valor', $valor);
                $stmt->execute();
            } catch(PDOException $e) {
                echo "Erro na conexão com o banco de dados: " . $e->getMessage();
            }
        }
        ?>

         <!-- Grid de Produtos -->
         <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Tipo de Produto</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
            <?php
                // Conexão com o banco de dados
               include 'conexao.php';

                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Consulta dos produtos cadastrados
                    $sql = "SELECT p.nome, t.tipo, p.valor FROM produtos p
                            INNER JOIN tipos_produto t ON p.tipo_id = t.id";
                    $stmt = $conn->query($sql);
                    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($produtos as $produto) {
                        echo "<tr>";
                        echo "<td>".$produto['nome']."</td>";
                        echo "<td>".$produto['tipo']."</td>";
                        echo "<td>R$ ".$produto['valor']."</td>";
                        echo "</tr>";
                    }
                } catch(PDOException $e) {
                    echo "Erro na conexão com o banco de dados: " . $e->getMessage();
                }
                ?>
            </tbody>
        </table>

        <button type="submit"><a href="index.php" class="btn">Voltar</a></center></button>

</body>
</html>