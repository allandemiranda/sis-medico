<!DOCTYPE HTML>
<html>

<head>
    <?php include 'head.php'; ?>
</head>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (test_input($_POST['sangue_nome_select']) != "naoselecionado") {
        $explode = explode("(", test_input($_POST['sangue_nome_select']));
        $sangue_nome = $explode[0];
        $sangue_valor_escala = $explode[1];
        $sangue_valor_tipo = $explode[2];
    } else {
        $sangue_nome = test_input($_POST['sangue_nome']);
        $sangue_valor_escala = test_input($_POST['sangue_valor_escala']);
        $sangue_valor_tipo = test_input($_POST['sangue_valor_tipo']);
    }
    $sql = "INSERT INTO `exames_sangue_tb`(`sangue_paciente_id`, `sangue_nome`, `sangue_coleta_data`, `sangue_analise_metodo`, `sangue_valor_maximo`, `sangue_valor_minimo`, `sangue_valor_tipo`, `sangue_valor_total`, `sangue_valor_escala`, `sangue_obs`) VALUES ('" . $paciente_numero_id . "','" . $sangue_nome . "','" . test_input($_POST['sangue_coleta_data']) . "','" . test_input($_POST['sangue_analise_metodo']) . "','" . test_input($_POST['sangue_valor_maximo']) . "','" . test_input($_POST['sangue_valor_minimo']) . "','" . $sangue_valor_tipo . "','" . test_input($_POST['sangue_valor_total']) . "','" . $sangue_valor_escala . "','" . test_input($_POST['sangue_obs']) . "')";
    if (mysqli_query($conn, $sql)) {
        $_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-success alert-dismissable">';
        $_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
        $_SG['status-alert'] = $_SG['status-alert'] . ' Sucesso!';
        $_SG['status-alert'] = $_SG['status-alert'] . '</div>';
    } else {
        $_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-danger alert-dismissablee">';
        $_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
        $_SG['status-alert'] = $_SG['status-alert'] . " Error: " . $sql . "<br>" . mysqli_error($_SG['link']);
        $_SG['status-alert'] = $_SG['status-alert'] . '</div>';
    }
}
?>

<body class="cbp-spmenu-push">
    <div class="main-content">
        <div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
            <!--left-fixed -navigation-->
            <?php include 'menu.php'; ?>
            <!--left-fixed -navigation-->
            <!-- main content start-->
            <div id="page-wrapper" style="min-height: 347px;padding-top: 1px;">
                <?php
                echo $_SG['status-alert'];
                ?>
                <div class="main-page">
                    <div class="forms">
                        <div class="form-grids row widget-shadow" data-example-id="basic-forms">
                            <div class="form-title">
                                <h4>Adicionar novo exame </h4>
                            </div>
                            <div class="form-body">
                                <form action="" method="POST">
                                    <div class="form-group col-md-12">
                                        <label class="col-md-12">Nome do Exame</label>
                                        <select name="sangue_nome_select" class="col-md-12 form-control" type="text">
                                            <option value="naoselecionado"> - </option>
                                            <?php
                                            $sql_exames = "SELECT `sangue_nome` FROM `exames_sangue_tb` WHERE `sangue_paciente_id`='" . $paciente_numero_id . "' GROUP BY `sangue_nome` ORDER BY `sangue_nome` ASC";
                                            $result_exames = mysqli_query($conn, $sql_exames);
                                            while ($row_exames = mysqli_fetch_assoc($result_exames)) {
                                                $sql_exames_extra = "SELECT `sangue_valor_escala`, `sangue_valor_tipo` FROM `exames_sangue_tb`   WHERE `sangue_nome`='" . $row_exames['sangue_nome'] . "' LIMIT 1 ";
                                                $result_exames_extra = mysqli_query($conn, $sql_exames_extra);
                                                $row_exames_extra = mysqli_fetch_assoc($result_exames_extra);
                                                echo '<option value="' . $row_exames["sangue_nome"] . '(' . $row_exames_extra["sangue_valor_escala"] . '(' . $row_exames_extra["sangue_valor_tipo"] . '"> ' . $row_exames["sangue_nome"] . ' (' . $row_exames_extra["sangue_valor_escala"] . ')</option>';
                                            }
                                            ?>
                                        </select>
                                        <p>Ou</p>
                                        <input name="sangue_nome" type="text" class="col-md-7 form-control" placeholder="Nome do Exame" onChange="javascript:this.value=this.value.toUpperCase();" value="">
                                        <input name="sangue_valor_escala" type="text" class="col-md-2 form-control" placeholder="Escala do Exame" onChange="javascript:this.value=this.value.toUpperCase();" value="">
                                        <select name="sangue_valor_tipo" class="col-md-3 form-control">
                                            <option value="0"> Numérico </option>
                                            <option value="1"> Binário </option>
                                        </select>
                                        <br><br>
                                        <label class="col-md-12">Método</label>
                                        <input name="sangue_analise_metodo" type="text" class="col-md-12 form-control" placeholder="Descreva o método de análise" onChange="javascript:this.value=this.value.toUpperCase();" value="" require="">
                                        <br><br><br><br>
                                        <label class="col-md-2">Resultado</label>
                                        <input name="sangue_valor_total" type="text" class="col-md-3 form-control" placeholder="0.00 ou POSITIVO ou NEGATIVO" value="" require="" onChange="javascript:this.value=this.value.toUpperCase();">
                                        <label class="col-md-1">Valor Mínimo</label>
                                        <input name="sangue_valor_minimo" type="text" class="col-md-2 form-control" placeholder="0.00" value="" require="">
                                        <label class="col-md-1">Valor Máximo</label>
                                        <input name="sangue_valor_maximo" type="text" class="col-md-2 form-control" placeholder="0.00" value="" require="">
                                        <br><br><br><br>
                                        <label class="col-md-2">Data do Exame</label>
                                        <input name="sangue_coleta_data" type="date" class="col-md-2 form-control" require="">
                                        <label class="col-md-2">Observações</label>
                                        <input name="sangue_obs" type="text" class="col-md-6 form-control" placeholder="" onChange="javascript:this.value=this.value.toUpperCase();" value="">
                                        <br>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-success">Criar</button>
                                        <br><br>
                                    </div>
                                </form>
                            </div>
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
