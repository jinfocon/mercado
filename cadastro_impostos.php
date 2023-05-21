<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Impostos</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <center>
        <h2>Cadastro de Impostos</h2>

        <!-- Formulário de Cadastro de Impostos -->
        <form action="impostos.php" method="POST">
            <label for="tipo_id">Tipo de Produto:</label>
            <select name="tipo_id" required>
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
            </select>
                <br><br>
            <label for="imposto">Imposto:</label>
            <input type="number" name="imposto" required>
                <br><br>
            <button type="submit">Cadastrar</button>
            <button type="submit"><a href="index.php" class="btn">Voltar</a></button>

        </form>
        <br>
        <h3>Tipos de Impostos Cadastrados</h3>
        <table>
            <thead>
                <tr>
                    <th>Tipo de Produto</th>
                    <th>Imposto</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Conexão com o banco de dados
               include 'conexao.php';

                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Consulta dos impostos cadastrados
                    $sql = "SELECT t.tipo, i.imposto FROM impostos_tipos_produto i INNER JOIN tipos_produto t ON i.tipo_id = t.id";
                    $stmt = $conn->query($sql);
                    $impostos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($impostos as $imposto) {
                        echo "<tr><td>".$imposto['tipo']."</td><td>".$imposto['imposto']."</td></tr>";
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
