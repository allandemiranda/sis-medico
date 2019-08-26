<!DOCTYPE HTML>
<html>

<head>
    <?php include 'head.php'; ?>
</head>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $imagem = $_FILES['vacina_img']['tmp_name'];
    $tamanho = $_FILES['vacina_img']['size'];
    $fp = fopen($imagem, "rb");
    $vacina_img = fread($fp, $tamanho);
    $vacina_img = addslashes($vacina_img);
    fclose($fp);    

    $sql = "INSERT INTO `cartao_vacina_tb`(`id_vacina_paciente`, `vacina_img`) VALUES ('" . $paciente_numero_id . "','" . $vacina_img . "')";
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

    if($tamanho == 0){
        $_SG['status-alert'] = "";
        $_SG['status-alert'] = $_SG['status-alert'] . '<div class="alert alert-danger alert-dismissablee">';
        $_SG['status-alert'] = $_SG['status-alert'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button"> × </button>';
        $_SG['status-alert'] = $_SG['status-alert'] . " Error: Tipo de imgem não suportada.";
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
                                <h4>Adicionar nova imagem de vacina </h4>
                            </div>
                            <div class="form-body">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="form-group col-md-12">
                                        <label class="col-md-12">Imagem do cartão:</label>
                                        <input id="vacina_img" type="file" name="vacina_img" class="col-md-6">
                                        <br>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-success">Adicionar</button>
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