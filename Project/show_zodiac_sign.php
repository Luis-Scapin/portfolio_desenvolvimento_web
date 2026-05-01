<?php include('layouts/header.php'); ?>

<?php
$data_nascimento = $_POST['data_nascimento'] ?? '';
$signo_encontrado = null;

function criarDataValida($diaMes, $ano)
{
    $partes = explode('/', $diaMes);
    if (count($partes) !== 2) {
        return null;
    }
    $dia = intval($partes[0]);
    $mes = intval($partes[1]);
    return DateTime::createFromFormat('Y-m-d', sprintf('%04d-%02d-%02d', $ano, $mes, $dia));
}

function estaNoPeriodo($dataNascimento, $inicio, $fim)
{
    $ano = intval($dataNascimento->format('Y'));
    $dataInicio = criarDataValida($inicio, $ano);
    $dataFim = criarDataValida($fim, $ano);

    if (!$dataInicio || !$dataFim) {
        return false;
    }

    if ($dataInicio <= $dataFim) {
        return $dataNascimento >= $dataInicio && $dataNascimento <= $dataFim;
    }

    $dataInicio = criarDataValida($inicio, $ano - 1);
    $dataFim = criarDataValida($fim, $ano);
    return $dataNascimento >= $dataInicio && $dataNascimento <= $dataFim;
}

if ($data_nascimento) {
    if (strpos($data_nascimento, '/') !== false) {
        $data = DateTime::createFromFormat('d/m/Y', $data_nascimento);
    } else {
        $data = DateTime::createFromFormat('Y-m-d', $data_nascimento);
    }

    if ($data) {
        $signos = simplexml_load_file('signos.xml');

        foreach ($signos->signo as $signo) {
            if (estaNoPeriodo($data, (string)$signo->dataInicio, (string)$signo->dataFim)) {
                $signo_encontrado = $signo;
                break;
            }
        }
    }
}
?>

<body class="bg-light">
    <main class="page">
        <header class="page-header">
            <h1>Resultado do Signo</h1>
        </header>

        <?php if ($signo_encontrado): ?>
            <section class="result-card">
                <h2><?php echo $signo_encontrado->signoNome; ?></h2>
                <p><?php echo $signo_encontrado->descricao; ?></p>
                <p><strong>Período:</strong> <?php echo $signo_encontrado->dataInicio; ?> a <?php echo $signo_encontrado->dataFim; ?></p>
            </section>
        <?php else: ?>
            <p class="alert alert-warning">Não foi possível identificar seu signo.</p>
        <?php endif; ?>

        <p class="text-center">
            <a href="index.php" class="btn btn-primary">Voltar para a página inicial</a>
        </p>
    </main>
</body>

</html>