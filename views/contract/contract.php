<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/png" href="../../src/img/favicon.png">
        <title>ALImóveis</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="../../lib/personal/css/contract.css">
    </head>
    <body>
        <div class="header-top">
            <div class="row">
                <div class="item-left">Contrato nº <?=$contract['desCode']?></div>
                <div class="item-right">© 2017 | ALImóveis - Versão 1.0.0</div>
            </div>
            <hr>
        </div>
        <div class="header-title">
            <h3>CONTRATO DE LOCAÇÃO DE IMÓVEL RESIDENCIAL</h3>
        </div>
        <div class="header-content">
            <p>
                Pelo presente instrumento, de um lado <b><?=$locator['desName']?></b>, <?=$locator['desNationality']?>,
                <?=$locator['desMaritalStatus']?>, <?=$locator['desProfession']?>, domiciliado(a) à <?=$locator['desAddress']?>,
                nº <?=$locator['desNumber']?>, bairro <?=$locator['desDistrict']?>, CEP nº <?=$locator['desZipCode']?>,
                nesta cidade de <?=$locator['desCity']?>-<?=$locator['desState']?>, portador(a) da Cédula de Identidade - RG
                nº <?=$locator['desRG']?>, inscrito(a) no Cadastro Nacional de Pessao Física - CPF sob o nº <?=$locator['desCPF']?>,
                a seguir simplesmente denominado(a) <b>Locador</b>, e, de outro lado <b><?=$renter['desName']?></b>,
                <?=$renter['desNationality']?>, <?=$renter['desMaritalStatus']?>, <?=$renter['desProfession']?>,
                domiciliado(a) nesta cidade de <?=$locator['desCity']?>-<?=$locator['desState']?>, portador(a) da Cédula
                de Identidade - RG nº <?=$renter['desRG']?>, inscrito(a) no Cadastro Nacional de Pessoa Física - CPF sob
                o nº <?=$renter['desCPF']?>, a seguir simplesmente denominado(a) <b>Locatário</b>, resolvem de comum acordo
                celebrar o presente contrato de locação, que se regerá pelas seguintes cláusulas.
            </p>
            <p>
                <ol>
                <li>
                    O <b>Locador</b> aluga ao <b>Locatário</b> o imóvel de sua propriedade localizado
                    à <?=$immobile['desAddress']?>, nº <?=$immobile['desNumber']?>, bairro <?=$immobile['desDistrict']?>,
                    CEP nº <?=$immobile['desZipCode']?>, nesta cidade de <?=$immobile['desCity']?>-<?=$immobile['desState']?>.
                </li>
                <li>
                    A locação é para fins exclusivamente residenciais.
                </li>
                <li>
                    O prazo de locação é de <?=$contract['desDeadline']?> (<?=trim($mesFull)?>) mês(es) a contar desta data.
                </li>
                <li>
                    O aluguel mensal é de R$ <?=number_format($contract['desValue'], 2, ",", ".")?> (<?=trim($valueFull)?>) durante o prazo de locação descrito
                    na cláusula 3.
                    <div class="item-content">
                        <b>Parágrafo Único</b> - O reajuste será anual e com base na variação do IGPM/FGV divulgado pela
                        Fundação Getúlio Vargas ou, em caso da sua extinção, pela variação de outro índice que venha
                        a substituí-lo ou, na falta deste, de outro índice oficial que reflita a inflação.
                    </div>
                </li>
                <li>
                    O aluguel será pago no dia <?=date('d', strtotime($contract['dtInitial']))?> (<?=trim($dateFull)?>)
                    do mês seguinte ao mês vencido.
                    <div class="item-content">
                        <b>Parágrafo 1º</b> - O pagamento do aluguel será feito através de depósito/transferência,
                        em conta bancária de preferência da <b>Locatário</b>, ou em sua residência, sito à <?=$locator['desAddress']?>,
                        nº <?=$locator['desNumber']?>, bairro <?=$locator['desDistrict']?>, CEP nº <?=$locator['desZipCode']?>,
                        nesta cidade de <?=$locator['desCity']?>-<?=$locator['desState']?>.
                    </div>
                    <div class="item-content">
                        <b>Parágrafo 2º</b> - O pagamento do primeiro aluguel será proporcional aos dias corridos do mês,
                        a partir da assinatura deste, ou do início da moradia no imóvel locado, o que vier primeiro.
                    </div>
                    <div class="item-content">
                        <b>Parágrafo 3º</b> - O atraso no pagamento implicará na incidência de multa de 2% (dois por cento)
                        calculado sobre o total dos valores em atraso, além de juros de mora mensal de 1% (um por cento).
                    </div>
                </li>
                <li>
                    Correrão por conta do <b>Locatário</b>, a partir da assinatura deste, ou do início da moradia no imóvel
                    locado, o que vier primeiro, as despesas incidentes ou que venham a incidir sobre o imóvel, tais como
                    água, luz e esgoto. Ficará isento o <b>Locatário</b> do pagamento de impostos territorias e urbanos,
                    as taxas de conservação e limpeza e todos os demais impostos, e obras a serem realizadas no imóvel.
                    <div class="item-content">
                        <b>Parágrafo 1º</b> - Todos os valores devidos serão pagos juntamente com o aluguel, nos montantes
                        indicados pelo <b>Locatário</b>, ou, a critério deste, diretamente aos respectivos órgãos, entidades
                        e pessoas credoras, entregando mensalmente os comprovantes.
                    </div>
                    <div class="item-content">
                        <b>Parágrafo 2º</b> - Na hipótese de pagamento direto ao credor, o <b>Locatário</b> entregará
                        mensalmente à <b>Locador</b>, juntamente com o pagamento do aluguel, os comprovantes respectivos
                        devidamente quitados.
                    </div>
                    <div class="item-content">
                        <b>Parágrafo 3º</b> - <b style="text-transform: none">Todos os pagamentos deverão ser feitos até
                        o dia do vencimento</b> indicado em cada conta/fatura. Os acréscimos devidos e todas as consequências
                        pelo atraso em tais pagamentos serão de exclusiva responsabilidade do <b>Locatário</b>.
                    </div>
                </li>
                <li>
                    Não pode o <b>Locatário</b> ceder ou sub-rogar a terceiros, sem o consentimento prévio, expresso e
                    escrito da <b>Locador</b>.
                </li>
                <li>
                    Não pode, também, o <b>Locatário</b> efetuar qualquer reforma ou reparo no imóvel locado, sem o
                    consentimento prévio, expresso e escrito da <b>Locador</b>.
                </li>
                <li>
                    O <b>Locatário</b> declara expressamente que vistoriou o imóvel locado e que recebe em bom estado de
                    conservação e condições de habitabilidade, com todos os materiais, utensílios, aparelhos e acessórios
                    em pleno funcionamento, e compromete-se a devolvê-los ao termino da locação.
                </li>
                <li>
                    Todas as benfeitorias necessárias que eventualmente o <b>Locatário</b> fizer no imóvel locado, assim
                    como as benfeitorias úteis autorizadas pela <b>Locatário</b>, ficarão incorparadas ao imóvel, e serão
                    abatidas no aluguel mensal, de forma parcelada, no valor máximo de até R$ 100,00 (cem reais), ou
                    conforme acordado entre as partes, não dando direito ao <b>Locatário</b> o exercício de direito de
                    rentenção.
                    <div class="item-content">
                        <b>Parágrafo Único</b> - O <b>Locatário</b> se obriga a comunicar imediatamente à <b>Locatário</b>
                        o recebimento de qualquer aviso ao notificação dos poderes públicos que visem modificar o imóvel
                        ou que impliquem qualquer tipo de alteração no mesmo, ficando responsável por qualquer exigência
                        a que tenha dado causa, antes da tomada de qualquer providência, avisar por escrito à <b>Locatário</b>
                    </div>
                </li>
                <li>
                    Qualquer pedido ou reclamação a ser feito entre as partes tendo como base o presente contato, somente
                    terá validade se feito por escrito por uma parte à outra. Não será válido nenhum tipo de pedido ou
                    reclamação verbal.
                </li>
                <li>
                    Constituem causas para a rescisão do presente contrato:
                    <div class="item-content">
                        <ol type="a" class="sub">
                            <li>O descumprimento pelas partes de qualquer obrigação aqui instituída;</li>
                            <li>O atraso do pagamento do aluguel ou de qualquer outra despesa ordinária ou extraordinária que
                                seja de responsabilidade do <b>Locatário</b>.</li>
                        </ol>
                    </div>
                    <div class="item-content">
                        <b>Parágrafo 1º</b> - Durante o prazo estipulado para a duração do contrato, não poderá a <b>Locador</b>
                        reaver o imóvel locado. O <b>Locatário</b>, todavia, poderá devolvê-lo, pagando a multa de 10%
                        (dez por cento), proporcionalmente ao período de cumprimento do contrato, ou, na falta, a quê for
                        judicialmente estipulado.
                    </div>
                    <div class="item-content">
                        <b>Parágrafo 2º</b> - O <b>Locatário</b> ficará dispensado da multa se a devolução do imóvel decorrer
                        de transferência, pelo empregador, privado ou público, para prestar serviços em localidades diversas
                        daquele do início do contrato, e se notificar, por escrito, a <b>Locador</b> com prazo de, no
                        mínimo 30 (trinta) dias de antecedência.
                    </div>
                    <div class="item-content">
                        <b>Parágrafo 3º</b> - Todos os prazos e datas previstas neste contrato vencer-se-ão de pleno direito,
                        sem necessidade de tomada de qualquer medida, tais como notificações e/ou avisos e interpelações
                        judiciais.
                    </div>
                </li>
                <li>
                    O contrato terá vigência até a data final, bem como, respeitado por eventual comprador do imóvel.
                </li>
                <li>
                    <b style="text-transform: none">Fica eleito o foro desta cidade</b> para dirimir quaisquer dúvidas
                    oriundas do presente.
                </li>
                </ol>
            </p>
            <p>
                E assim, por estarem justos e contatados, assinam o presente em 02 (duas) vias de igual teor e forma.
            </p>
            <p class="locateDate">
                Manaus-AM, <?=strftime('%d de %B de %Y', strtotime($contract['dtInitial']))?>.
            </p>
            <table>
                <tbody>
                <tr>
                    <td style="border-top: solid; width: 45%"><b><?=$locator['desName']?><br>Locador</b></td>
                    <td style="width: 10%">&nbsp;</td>
                    <td style="border-top: solid; width: 45%"><b><?=$renter['desName']?><br>Locatário</b></td>
                </tr>
                </tbody>
            </table>
            <p class="witnesses">
                Testemunhas:
            </p>
            <table>
                <tbody>
                <tr>
                    <td style="border-bottom: solid; width: 45%;">&nbsp;</td>
                    <td style="width: 10%;">&nbsp;</td>
                    <td style="border-bottom: solid; width: 45%;">&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align: left"><b style="text-transform: none">Nome:</b></td>
                    <td>&nbsp;</td>
                    <td style="text-align: left"><b style="text-transform: none">Nome:</b></td>
                </tr>
                <tr>
                    <td style="text-align: left"><b style="text-transform: none">CPF nº</b></td>
                    <td>&nbsp;</td>
                    <td style="text-align: left"><b style="text-transform: none">CPF nº</b></td>
                </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>