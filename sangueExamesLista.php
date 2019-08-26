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
                    $sql = "SELECT * FROM `exames_sangue_tb` WHERE `sangue_paciente_id`='" . $paciente_numero_id . "' ORDER BY `sangue_coleta_data` ASC";
                    $result = mysqli_query($conn, $sql);
                    $exames = array();
                    while ($row = mysqli_fetch_assoc($result)) {
                        $flag = "naoTem";
                        for ($i = 0; $i < count($exames); $i++) {
                            if ($exames[$i]['sangue_nome'] == $row['sangue_nome']) {
                                $flag = "tem";
                                $exames[$i]['sangue_valor_total'] = $row['sangue_valor_total'];
                                $exames[$i]['sangue_coleta_data'] = $row['sangue_coleta_data'];
                                $exames[$i]['sangue_valor_maximo'] = $row['sangue_valor_maximo'];
                                $exames[$i]['sangue_valor_minimo'] = $row['sangue_valor_minimo'];
                                $a++;
                                if ($row['sangue_valor_maximo'] != "") {
                                    if ($row['sangue_valor_total'] >= $row['sangue_valor_maximo']) {
                                        $exames[$i]['cor'] = "RED";
                                        if ($row['sangue_valor_total'] == $row['sangue_valor_maximo']) {
                                            $exames[$i]['cor'] = "YELLOW";
                                        }
                                        break;
                                    } else {
                                        $exames[$i]['cor'] = "";
                                    }
                                }
                                if ($row['sangue_valor_minimo'] != "") {
                                    if ($row['sangue_valor_total'] <= $row['sangue_valor_minimo']) {
                                        $exames[$i]['cor'] = "RED";
                                        if ($row['sangue_valor_total'] == $row['sangue_valor_minimo']) {
                                            $exames[$i]['cor'] = "YELLOW";
                                        }
                                        break;
                                    } else {
                                        $exames[$i]['cor'] = "";
                                    }
                                }
                                if (($row['sangue_valor_minimo'] == $row['sangue_valor_minimo']) and ($row['sangue_valor_minimo'] == $row['sangue_valor_total']) and ($row['sangue_valor_maximo'] == $row['sangue_valor_total'])) {
                                    $exames[$i]['cor'] = "";
                                }
                                break;
                            }
                        }
                        if ($flag == "naoTem") {
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
                                } else {
                                    $cor = "";
                                }
                            }
                            if (($row['sangue_valor_minimo'] == $row['sangue_valor_minimo']) and ($row['sangue_valor_minimo'] == $row['sangue_valor_total'])) {
                                $cor = "";
                            }
                            array_push($exames, ["sangue_nome" => $row['sangue_nome'], "sangue_valor_total" => $row['sangue_valor_total'], "sangue_coleta_data" => $row['sangue_coleta_data'], "sangue_valor_maximo" => $row['sangue_valor_maximo'], "sangue_valor_minimo" => $row['sangue_valor_minimo'], "sangue_valor_escala" => $row['sangue_valor_escala'], "cor" => $cor, "sangue_id" => $row['sangue_id']]);
                        }
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
                                        <th>Última coleta</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    sort($exames);
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
                                        echo '<td><a href="grafico.php?sangue_nome=' . $exames[$i]['sangue_nome'] . '" class="fa fa-check-square"></td>';
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