<?php

include 'conexao.php';

try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Criar banco de dados
    // $sql = "CREATE DATABASE ". $database;
    // $conn->exec($sql);
    // echo "Banco de dados 'mercado' criado com sucesso!\n";

    // Conectar ao banco de dados
    $conn->exec("USE jinfocon_mercado");

    // Criar tabela "tipos_produto"
    $sql = "CREATE TABLE tipos_produto (
        id INT AUTO_INCREMENT PRIMARY KEY,
        tipo VARCHAR(50) NOT NULL
    )";
    $conn->exec($sql);
    echo "Tabela 'tipos_produto' criada com sucesso!\n";

    // Criar tabela "produtos"
    $sql = "CREATE TABLE produtos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(50) NOT NULL,
        tipo_id INT,
        valor DECIMAL(10, 2) NOT NULL,
        FOREIGN KEY (tipo_id) REFERENCES tipos_produto(id)
    )";
    $conn->exec($sql);
    echo "Tabela 'produtos' criada com sucesso!\n";

    // Criar tabela "impostos_tipos_produto"
    $sql = "CREATE TABLE impostos_tipos_produto (
        tipo_id INT,
        imposto DECIMAL(5, 2) NOT NULL,
        FOREIGN KEY (tipo_id) REFERENCES tipos_produto(id)
    )";
    $conn->exec($sql);
    echo "Tabela 'impostos_tipos_produto' criada com sucesso!\n";

    header("Location: index.php");
        exit();
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>