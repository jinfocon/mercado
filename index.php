<?php

include 'conexao.php';
header('Content-Type: text/html; charset=utf-8');

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar se o banco de dados "mercado" existe
    $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$database'";
    $stmt = $conn->query($query);
    $databaseExists = $stmt->fetch();

    if (!$databaseExists) {
        // Redirecionar para o script de criação do banco de dados
        header("Location: script_banco.php");
        exit();
    }

    // Verificar se os scripts de criação das tabelas foram executados
    $query = "SHOW TABLES LIKE 'produtos'";
    $stmt = $conn->query($query);
    $produtosTableExists = $stmt->rowCount() > 0;

    $query = "SHOW TABLES LIKE 'tipos_produto'";
    $stmt = $conn->query($query);
    $tiposProdutoTableExists = $stmt->rowCount() > 0;

    $query = "SHOW TABLES LIKE 'impostos_tipos_produto'";
    $stmt = $conn->query($query);
    $impostosTiposProdutoTableExists = $stmt->rowCount() > 0;

    if (!$produtosTableExists || !$tiposProdutoTableExists || !$impostosTiposProdutoTableExists) {
        // Redirecionar para o script de criação das tabelas
        header("Location: script_banco.php");
        exit();
    }

    // Consulta para obter os produtos cadastrados
    $query = "SELECT id, nome, valor FROM produtos";
    $stmt = $conn->query($query);
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Erro: " . $e->getMessage();
}

$conn = null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vendas</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.3/jspdf.umd.min.js"></script>
</head>
<body>

    <center><label>Escolhe um Produto</label><br><select name="produto">
                <!-- Loop para exibir as opções do select -->
                <?php foreach ($produtos as $produto) { ?>
                    <option value="<?php echo $produto['id']; ?>"><?php echo $produto['nome']; ?></option>
                <?php } ?>
            </select><br>
            <br><label>Informe a Quantidade</label>
            <br><input type="number" name="quantidade" value="1" min="1"><br>
            <br><button type="button" onclick="adicionarProduto()">Adicionar</button><br><br></center>
    <div class="cupom-fiscal">
        <h1>Mercado Teste</h1>
        <p>Rua dos Mercados, 1000</p>
        <p>Cidade do Mercado - SP, Brasil</p>
        <table>
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dados da venda serão adicionados dinamicamente aqui -->
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"><right>Total:</right></td>
                    <td><span id="total">R$0,00</span></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <form action="cupom_fiscal.php" method="POST" target="_blank">
        <input type="hidden" name="conteudoCupomFiscal" value="" id="cupomFiscalHidden">
        <input type="submit" value="Emitir Cupom">
    </form>
    <br>
    <br>
    <center>
        <button type="submit"><a href="cadastro_tipos.php" class="btn">Cadastrar Tipos de Produtos</a></button><br><br>
        <button type="submit"><a href="cadastro_impostos.php" class="btn">Cadastrar Impostos</a></button><br><br>
        <button type="submit"><a href="cadastro_produtos.php" class="btn">Cadastrar Produtos</a></button><br><br>
    </center>
    <script>
        function adicionarProduto() {
            var selectProduto = document.querySelector('select[name="produto"]');
            var quantidadeInput = document.querySelector('input[name="quantidade"]');
            var tabelaVendas = document.querySelector('.cupom-fiscal table tbody');
            var totalElement = document.getElementById('total');

            var produtoId = selectProduto.value;
            var produtoNome = selectProduto.options[selectProduto.selectedIndex].text;
            var quantidade = quantidadeInput.value;

            // Obter o valor do produto do PHP
            var valorProduto = <?php echo $produtos[0]["valor"]; ?>;

            // Calcular o valor total
            var valorTotal = valorProduto * quantidade;

            // Formatar o valor total para o formato "R$00,00"
            var valorFormatado = valorTotal.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

            // Criar nova linha na tabela de vendas
            var novaLinha = document.createElement('tr');
            novaLinha.innerHTML = '<td>' + produtoNome + '</td>' +
                '<td><center>' + quantidade + '</center></td>' +
                '<td>' + valorFormatado + '</td>';
                tabelaVendas.appendChild(novaLinha);

            // Atualizar o valor total da compra
            var valorTotalCompra = calcularValorTotalCompra();
            totalElement.innerText = formatarValorMonetario(valorTotalCompra);

            // Limpar o campo de quantidade
            quantidadeInput.value = 1;
            }

            function calcularValorTotalCompra() {
            var linhas = document.querySelectorAll('.cupom-fiscal table tbody tr');
            var total = 0;

            for (var i = 0; i < linhas.length; i++) {
                var valorCelula = linhas[i].querySelector('td:last-child').innerText;
                var valorNumerico = parseFloat(valorCelula.replace(/[^\d,.-]/g, '').replace(',', '.')); // Remover símbolos e substituir vírgula por ponto
                total += valorNumerico;
            }

            return total;
            }

            function formatarValorMonetario(valor) {
            return 'R$' + valor.toFixed(2).replace('.', ',');
            }

            // Captura o evento de submit do formulário
            document.querySelector('form').addEventListener('submit', function() {
                // Obtém o conteúdo da div cupom-fiscal
                var cupomFiscal = document.querySelector('.cupom-fiscal').innerHTML;

                // Define o valor do campo hidden com o conteúdo da div
                document.getElementById('cupomFiscalHidden').value = cupomFiscal;
            });
    </script>
    <script>
        // Função para gerar o PDF
        function gerarPDF() {
            const doc = new jsPDF({
                orientation: 'portrait',
                unit: 'in',
                format: 'letter'
            });

            const cupomElement = document.querySelector('.cupom-fiscal');
            const { width, height } = cupomElement.getBoundingClientRect();
            const cupomHTML = cupomElement.innerHTML;

            doc.html(cupomHTML, {
                callback: function () {
                    doc.save('cupom_fiscal.pdf');
                },
                x: 0,
                y: 0,
                width: width,
                height: height
            });
        }
    </script>
</body>
</html>
