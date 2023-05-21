<?php
require_once 'vendor/autoload.php';

use Dompdf\Dompdf;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se o campo conteudoCupomFiscal está presente no POST
    if (isset($_POST['conteudoCupomFiscal'])) {
        $conteudoCupomFiscal = $_POST['conteudoCupomFiscal'];

        $dompdf = new Dompdf();
        $dompdf->loadHtml($conteudoCupomFiscal);

        // (Opcional) Definir opções de visualização do PDF, como tamanho da página, orientação, etc.
        $dompdf->setPaper('letter', 'portrait');

        // Aplicar estilos CSS para centralizar a grid
        $style = '
            <style>
                .cupom-fiscal {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    text-align: center;
                }
            </style>
        ';
        $dompdf->getOptions()->setIsRemoteEnabled(true); // Permitir carregar estilos externos

        // Renderizar o PDF
        $dompdf->render();

        // Enviar o PDF para o navegador para download
        $dompdf->stream("cupom_fiscal.pdf", array("Attachment" => false));
    }
}