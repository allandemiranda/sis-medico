<!DOCTYPE HTML>
<html>

<head>
    <?php include 'head.php'; ?>
    <div class="main-page">
        <?php
        $sql = "SELECT * FROM `exames_sangue_tb` WHERE `sangue_nome`='" . $_GET['sangue_nome'] . "' AND `sangue_paciente_id`='" . $paciente_numero_id . "' ORDER BY `sangue_coleta_data` DESC";
        $result = mysqli_query($conn, $sql);
        $exames = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $cor = "";
            if ($row['sangue_valor_maximo'] != "") {
                if ($row['sangue_valor_total'] >= $row['sangue_valor_maximo']) {
                    $cor = "RED";
                    if ($row['sangue_valor_total'] == $row['sangue_valor_maximo']) {
                        $cor = "YELLOW";
                    }
                } else {
                    $cor = "";
                }
            }
            if ($row['sangue_valor_minimo'] != "") {
                if ($row['sangue_valor_total'] <= $row['sangue_valor_minimo']) {
                    $cor = "RED";
                    if ($row['sangue_valor_total'] == $row['sangue_valor_minimo']) {
                        $cor = "YELLOW";
                    }
                }
            }
            if (($row['sangue_valor_minimo'] == $row['sangue_valor_minimo']) and ($row['sangue_valor_minimo'] == $row['sangue_valor_total']) and ($row['sangue_valor_maximo'] == $row['sangue_valor_total'])) {
                $cor = "";
            }
            array_push($exames, ["sangue_nome" => $row['sangue_nome'], "sangue_valor_total" => $row['sangue_valor_total'], "sangue_coleta_data" => $row['sangue_coleta_data'], "sangue_valor_maximo" => $row['sangue_valor_maximo'], "sangue_valor_minimo" => $row['sangue_valor_minimo'], "sangue_valor_escala" => $row['sangue_valor_escala'], "cor" => $cor, "sangue_analise_metodo" => $row['sangue_analise_metodo']]);
        }
        ?>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {
                'packages': ['corechart']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Coleta', 'Resultado', 'Máximo', 'Mínimo'],
                    <?php
                    $graficoAqui = "SIM";
                    for ($i = count($exames) - 1; $i >= 0; $i--) {
                        if ($exames[$i]['sangue_valor_total'] == "POSITIVO") {
                            $graficoAqui = "NAO";
                        }
                        if ($exames[$i]['sangue_valor_total'] == "NEGATIVO") {
                            $graficoAqui = "NAO";
                        }
                        $sangue_valor_minimo_g = $exames[$i]['sangue_valor_minimo'];
                        $sangue_valor_maximo_g = $exames[$i]['sangue_valor_maximo'];
                        if ($sangue_valor_minimo_g == "") {
                            $sangue_valor_minimo_g = "0";
                        }
                        if ($sangue_valor_maximo_g == "") {
                            $sangue_valor_maximo_g = "0";
                        }
                        echo "['" . corrigirData($exames[$i]['sangue_coleta_data']) . "', " . $exames[$i]['sangue_valor_total'] . ", " . $sangue_valor_maximo_g . ", " . $sangue_valor_minimo_g . "],";
                    }
                    ?>
                ]);

                var options = {
                    title: '<?php echo $exames[0]['sangue_nome']; ?>',
                    curveType: 'function',
                    legend: {
                        position: 'bottom'
                    }
                };

                var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

                chart.draw(data, options);
            }
        </script>

</head>

<body class="cbp-spmenu-push">
    <div class="main-content">
        <div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
            <!--left-fixed -navigation-->
            <?php include 'menu.php'; ?>
            <!--left-fixed -navigation-->
            <!-- main content start-->
            <div id="page-wrapper" style="min-height: 347px;padding-top: 1px;">
                <?php
                if ($graficoAqui == "SIM") {
                    echo '<div class="tables"><div class="bs-example widget-shadow" data-example-id="hoverable-table"><div id="curve_chart" style="max-width:100%; height:500px;"></div></div></div>';
                }
                ?>
                <div class="tables">
                    <div class="bs-example widget-shadow" data-example-id="hoverable-table">
                        <h4>Exames de sangue:</h4>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Exame</th>
                                    <th>Resultado</th>
                                    <th>Mínimo</th>
                                    <th>Máximo</th>
                                    <th>Coleta</th>
                                    <th>Método</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $fake_id = 0;
                                for ($i = 0; $i < count($exames); $i++) {
                                    if ($exames[$i]['cor'] == "RED") {
                                        echo '<tr style="background-color: #f09999;">';
                                    }
                                    if ($exames[$i]['cor'] == "YELLOW") {
                                        echo '<tr style="background-color: #cce341;">';
                                    }
                                    if ($exames[$i]['cor'] == "") {
                                        echo '<tr>';
                                    }
                                    echo '<th scope="row"> ' . ++$fake_id . ' </th>';
                                    echo '<td> ' . $exames[$i]['sangue_nome'] . ' </td>';
                                    if (($exames[$i]['sangue_valor_total'] == "NEGATIVO") or ($exames[$i]['sangue_valor_total'] == "POSITIVO")) {
                                        echo '<td> ' . $exames[$i]['sangue_valor_total'] . ' </td>';
                                        echo '<td> - </td>';
                                        echo '<td> - </td>';
                                    } else {
                                        echo '<td> ' . $exames[$i]['sangue_valor_total'] . ' <x style="font-size: 12px;">(' . $exames[$i]['sangue_valor_escala'] . ')</x></td>';
                                        if ($exames[$i]['sangue_valor_minimo'] != "") {
                                            echo '<td> ' . $exames[$i]['sangue_valor_minimo'] . ' <x style="font-size: 12px;">(' . $exames[$i]['sangue_valor_escala'] . ')</x></td>';
                                        } else {
                                            echo '<td> - </td>';
                                        }
                                        if ($exames[$i]['sangue_valor_maximo'] != "") {
                                            echo '<td> ' . $exames[$i]['sangue_valor_maximo'] . ' <x style="font-size: 12px;">(' . $exames[$i]['sangue_valor_escala'] . ')</x></td>';
                                        } else {
                                            echo '<td> - </td>';
                                        }
                                    }
                                    if ((date('Y-m-d') - $exames[$i]['sangue_coleta_data']) == 0) {
                                        echo '<td> ' . corrigirData($exames[$i]['sangue_coleta_data']) . ' </td>';
                                    }
                                    if ((date('Y-m-d') - $exames[$i]['sangue_coleta_data']) == 1) {
                                        echo '<td> ' . corrigirData($exames[$i]['sangue_coleta_data']) . ' (à ' . (date('Y-m-d') - $exames[$i]['sangue_coleta_data']) . ' ano)</td>';
                                    }
                                    if ((date('Y-m-d') - $exames[$i]['sangue_coleta_data']) > 1) {
                                        echo '<td> ' . corrigirData($exames[$i]['sangue_coleta_data']) . ' (à ' . (date('Y-m-d') - $exames[$i]['sangue_coleta_data']) . ' anos)</td>';
                                    }
                                    echo '<td> ' . $exames[$i]['sangue_analise_metodo'] . ' </td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
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