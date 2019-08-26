<!DOCTYPE HTML>
<html>

<head>
    <?php include 'head.php'; ?>
</head>

<body class="cbp-spmenu-push">
    <div class="main-content">
        <div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
            <!--left-fixed -navigation-->
            <?php include 'menu.php'; ?>
            <!--left-fixed -navigation-->
            <!-- main content start-->
            <div id="page-wrapper" style="min-height: 347px;padding-top: 1px;">
                <div class="main-page">
                    <?php
                    $sql = "SELECT `paciente_nome`, `paciente_plano`, `paciente_peso`, `paciente_altura`, `paciente_nascimento_data`, `paciente_alergia`, `paciente_medicamentos`, `paciente_obs` FROM `paciente_tb` WHERE `paciente_id`='" . $paciente_numero_id . "'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    ?>
                    <div class="col-md-12 chart-layer1-right">
                        <div class="user-marorm">
                            <div class="malorm-bottom">
                                <h2><?php echo $row['paciente_nome']; ?></h2>
                                <p>Data de Nascimento: <?php echo corrigirData($row['paciente_nascimento_data']); ?> - <?php echo (date('Y-m-d') - $row['paciente_nascimento_data']); ?> anos </p>
                                <p>Peso: <?php echo $row['paciente_peso']; ?> Kg - Altura: <?php echo $row['paciente_altura']; ?> metros </p>
                                <p>Plano de saúde: <?php echo $row['paciente_plano']; ?> </p>
                                <p>Alergia: <?php echo $row['paciente_alergia']; ?> </p>
                                <p>Medicamentos: <?php echo $row['paciente_medicamentos']; ?> </p>
                                <p>Observações: <?php echo $row['paciente_obs']; ?> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--footer-->
            <div class="footer">
                <p>&copy; 2019 All Rights Reserved | Design by Allan de Miranda</p>
            </div>
            <!--//footer-->
        </div>
        <?php include 'footer.php'; ?>
</body>

</html>