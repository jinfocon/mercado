<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Conexão com o banco de dados
        include 'conexao.php';
        
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Inserção do imposto no banco de dados
            $tipo_id = $_POST['tipo_id'];
            $imposto = $_POST['imposto'];

            $sql = "INSERT INTO impostos_tipos_produto (tipo_id, imposto) VALUES (:tipo_id, :imposto)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':tipo_id', $tipo_id);
            $stmt->bindParam(':imposto', $imposto);
            $stmt->execute();

            echo "Imposto cadastrado com sucesso!";
            header("Location: cadastro_impostos.php");
        exit();
        } catch(PDOException $e) {
            echo "Erro na conexão com o banco de dados: " . $e->getMessage();
        }
    }
