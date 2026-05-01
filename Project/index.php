<?php include('layouts/header.php'); ?>

<body>
    <main class="page">
        <header class="page-header">
            <h1>Descubra Seu Signo do Zodíaco</h1>
            <p>Informe sua data de nascimento e descubra seu signo.</p>
        </header>

        <form id="signo-form" method="POST" action="show_zodiac_sign.php" class="form-card">
            <label for="data_nascimento" class="form-label">Data de Nascimento</label>
            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
            <small class="form-text">Selecione sua data de nascimento</small>
            <button type="submit" class="btn btn-primary btn-block">Descobrir Meu Signo</button>
        </form>
    </main>
</body>

</html>