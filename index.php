<?php
$mensagem = "";
$classeMensagem = "";
$nome = "";
$valorCompra = "";
$formaPagamento = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["txtNome"] ?? "");
    $valorCompra = str_replace(",", ".", trim($_POST["txtValorCompra"] ?? ""));
    $formaPagamento = $_POST["cmbPag"] ?? "";

    if ($nome === "" || !is_numeric($valorCompra) || (float)$valorCompra <= 0) {
        $mensagem = "Preencha o nome e informe um valor de compra válido.";
        $classeMensagem = "erro";
    } else {
        $valorCompra = (float)$valorCompra;
        $desconto = 0;
        $percentual = 0;
        $descricaoPagamento = "";

        switch ($formaPagamento) {
            case "deposito":
                $percentual = 10;
                $desconto = $valorCompra * 0.10;
                $descricaoPagamento = "depósito";
                break;

            case "boleto":
                $percentual = 8;
                $desconto = $valorCompra * 0.08;
                $descricaoPagamento = "boleto";
                break;

            case "cartaoCredito":
                $percentual = 0;
                $desconto = 0;
                $descricaoPagamento = "cartão de crédito";
                break;

            default:
                $mensagem = "Selecione uma forma de pagamento válida.";
                $classeMensagem = "erro";
        }

        if ($descricaoPagamento !== "") {
            $valorFinal = $valorCompra - $desconto;

            $mensagem = "Olá, " . htmlspecialchars($nome, ENT_QUOTES, "UTF-8") .
                "! Sua compra de R$ " . number_format($valorCompra, 2, ",", ".") .
                " foi realizada com " . $descricaoPagamento .
                ". Desconto: " . $percentual . "% (R$ " .
                number_format($desconto, 2, ",", ".") .
                "). Valor final: R$ " .
                number_format($valorFinal, 2, ",", ".") . ".";

            $classeMensagem = "sucesso";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Madeira & Cia | Promoção de Aniversário</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="container">
        <section class="card">
            <div class="brand">
                <span class="brand-icon">M</span>
                <div>
                    <p class="eyebrow">MADEIRA & CIA LTDA.</p>
                    <h1>Promoção de aniversário</h1>
                </div>
            </div>

            <p class="subtitle">
                Informe os dados da compra e escolha a forma de pagamento para calcular seu desconto.
            </p>

            <form method="POST" action="">
                <label for="txtNome">Nome do cliente</label>
                <input
                    type="text"
                    id="txtNome"
                    name="txtNome"
                    placeholder="Digite seu nome"
                    value="<?= htmlspecialchars($nome, ENT_QUOTES, "UTF-8") ?>"
                    required
                >

                <label for="txtValorCompra">Valor da compra</label>
                <div class="input-money">
                    <span>R$</span>
                    <input
                        type="number"
                        id="txtValorCompra"
                        name="txtValorCompra"
                        placeholder="0,00"
                        min="0.01"
                        step="0.01"
                        value="<?= htmlspecialchars($valorCompra, ENT_QUOTES, "UTF-8") ?>"
                        required
                    >
                </div>

                <label for="cmbPag">Forma de pagamento</label>
                <select id="cmbPag" name="cmbPag" required>
                    <option value="">Selecione uma opção</option>
                    <option value="deposito" <?= $formaPagamento === "deposito" ? "selected" : "" ?>>
                        Depósito — 10% de desconto
                    </option>
                    <option value="boleto" <?= $formaPagamento === "boleto" ? "selected" : "" ?>>
                        Boleto — 8% de desconto
                    </option>
                    <option value="cartaoCredito" <?= $formaPagamento === "cartaoCredito" ? "selected" : "" ?>>
                        Cartão de crédito — sem desconto
                    </option>
                </select>

                <button type="submit">Calcular desconto</button>
            </form>

            <?php if ($mensagem !== ""): ?>
                <div class="mensagem <?= $classeMensagem ?>" role="alert">
                    <?= $mensagem ?>
                </div>
            <?php endif; ?>

            <div class="descontos">
                <div><strong>10%</strong><span>Depósito</span></div>
                <div><strong>8%</strong><span>Boleto</span></div>
                <div><strong>0%</strong><span>Cartão</span></div>
            </div>
        </section>
    </main>
</body>
</html>

<!--
COMENTÁRIO REFLEXIVO — RACIOCÍNIO LÓGICO

Para corrigir o código recebido, primeiro analisei as três possibilidades de pagamento
e comparei as taxas informadas pela empresa com os percentuais utilizados no código.
Identifiquei que os percentuais de depósito e boleto estavam invertidos: depósito deve
receber 10% e boleto deve receber 8%. O cartão de crédito permanece com desconto zero.

Depois, organizei a decisão usando switch, deixando cada regra de negócio separada e
facilitando a leitura e a manutenção do código. Para cada opção, o programa calcula o
valor do desconto multiplicando o valor da compra pelo percentual correspondente.
Em seguida, subtraio o desconto do valor original para obter o valor final.

Também acrescentei validações para impedir o processamento de nome vazio, valor inválido
ou valor menor/igual a zero. Os valores monetários são formatados com duas casas decimais
e padrão brasileiro, usando number_format.

Para o formulário, utilizei HTML semântico com campos para nome, valor e forma de
pagamento. O CSS foi criado separadamente para produzir um layout personalizado,
responsivo e visualmente organizado. O formulário utiliza POST e envia os dados para
o próprio arquivo PHP, integrando a interface com a lógica de processamento.

Por fim, mantive os dados preenchidos após o envio e apresentei uma mensagem específica
com o desconto e o valor final. Os cenários que devem ser testados são depósito,
boleto e cartão de crédito, verificando respectivamente descontos de 10%, 8% e 0%.
-->
