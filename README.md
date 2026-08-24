# Madeira & Cia — Promoção de Aniversário

Projeto desenvolvido em PHP, HTML e CSS para calcular descontos conforme a forma de pagamento.

## Regras

| Forma de pagamento | Desconto |
|---|---:|
| Depósito | 10% |
| Boleto | 8% |
| Cartão de crédito | 0% |

## Arquivos

- `index.php` — formulário, processamento PHP e comentário reflexivo.
- `style.css` — layout e estilização.

## Como executar

1. Instale um servidor local com PHP, como XAMPP, WAMP ou Laragon.
2. Coloque a pasta do projeto no diretório público do servidor.
3. Inicie o Apache.
4. Abra `http://localhost/madeira_e_cia_promocao/`.

## Testes sugeridos

Com uma compra de R$ 1.000,00:

- Depósito → desconto de R$ 100,00 → valor final R$ 900,00.
- Boleto → desconto de R$ 80,00 → valor final R$ 920,00.
- Cartão de crédito → desconto de R$ 0,00 → valor final R$ 1.000,00.
