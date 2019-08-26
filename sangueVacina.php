
<?php
$servername = "localhost";
$username = "allandemiranda";
$password = "senha1234";
$dbname = "medicos_bd";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$paciente_numero_id = 1;
$sql = "SELECT `vacina_img` FROM `cartao_vacina_tb` WHERE `id_vacina_paciente`=2 ORDER BY `id_vacina` DESC LIMIT 1";
$result = mysqli_query($conn, $sql) or die("Impossível executar a query ");
$row = mysqli_fetch_object($result);
header( "Content-type: image/gif");  
echo $row->vacina_img;
?>