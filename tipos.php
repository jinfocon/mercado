<?php
// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se o campo 'tipo' foi preenchido
    if (isset($_POST['tipo']) && !empty($_POST['tipo'])) {
        // Obtém o valor do campo 'tipo' do formulário
        $tipo = $_POST['tipo'];

        // Conexão com o banco de dados
        include 'conexao.php';

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepara a consulta SQL para inserir o tipo de produto
            $sql = "INSERT INTO tipos_produto (tipo) VALUES (:tipo)";
            $stmt = $conn->prepare($sql);

            // Executa a consulta SQL com os valores informados
            $stmt->execute(array(':tipo' => $tipo));

            // Redireciona para a página index.php
            header("Location: cadastro_tipos.php");
            exit();
        } catch(PDOException $e) {
            echo "Erro na conexão com o banco de dados: " . $e->getMessage();
        }
    } else {
        echo "O campo 'Tipo de Produto' é obrigatório.";
    }
}
?>
