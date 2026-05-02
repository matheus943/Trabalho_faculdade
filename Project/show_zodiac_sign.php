<?php include('layouts/header.php'); ?>

<?php
$data_nascimento = $_POST['data_nascimento'];
$data_obj = new DateTime($data_nascimento);
$dia_mes = $data_obj->format('d/m'); // Ex: 25/03

$signos = simplexml_load_file("signos.xml");

function converterData($data_xml) {
    // Transforma "21/03" em um objeto comparável (usando ano fixo)
    return DateTime::createFromFormat('d/m', $data_xml);
}

$meu_signo = null;

foreach ($signos->signo as $signo) {
    $inicio = converterData($signo->dataInicio);
    $fim = converterData($signo->dataFim);
    $atual = converterData($dia_mes);

    // Lógica especial para Capricórnio (que vira o ano)
    if ($inicio > $fim) {
        if ($atual >= $inicio || $atual <= $fim) {
            $meu_signo = $signo;
            break;
        }
    } else {
        if ($atual >= $inicio && $atual <= $fim) {
            $meu_signo = $signo;
            break;
        }
    }
}
?>

<div class="container mt-5 text-center">
    <?php if ($meu_signo): ?>
        <h1 class="display-4"><?= $meu_signo->signoNome ?></h1>
        <p class="lead"><?= $meu_signo->descricao ?></p>
    <?php endif; ?>
    <a href="index.php" class="btn btn-secondary mt-3">Voltar</a>
</div>

</body>
</html>