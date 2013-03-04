<?php

$DBHOST = '192.168.77.201';
$DBUSER = 'arthur';
$DBPASS	= 'minhasenhalegal';
$DBNAME = 'asterisk';

#--------------------------------
#não alterar daqui para baixo
#--------------------------------

$email = "";
$sAntiga = "";
$sNova = "";
$conf = "";

//preenchendo variaveis via post
if(isset($_POST['email']))
	$email = $_POST['email'];

if(isset($_POST['senha_antiga']))
	$sAntiga = $_POST['senha_antiga'];

if(isset($_POST['senha_nova']))
	$sNova = $_POST['senha_nova'];

if(isset($_POST['confirmacao']))
	$conf = $_POST['confirmacao'];


//conexão com o servidor
$conect = mysql_connect($DBHOST, $DBUSER, $DBPASS);

// Caso a conexão seja reprovada, exibe na tela uma mensagem de erro
if (!$conect) die ("<h1>Falha na conexão com o Banco de Dados!</h1>");

// Caso a conexão seja aprovada, então conecta o Banco de Dados.	
$db = mysql_select_db($DBNAME);

//pega senha atual
$qry = "SELECT secret FROM sip_buddies WHERE email = '$email'";
$result = mysql_query($qry, $conect);

$resultado = mysql_fetch_array($result);

//compara senha atual com senha do banco :p
if($sAntiga == $resultado[0]){
	if($sNova != $conf){
		header('Location: ' . ABSPATH . '/change-password/?msg=senha_diferente');
		//echo "senha_diferente == " . $email . "|" . $sAntiga . "|" . $sNova . "|" . $conf;
		exit;
	}
	//atualiza senha no banco :p
	$qry = "UPDATE sip_buddies SET secret='$sNova' WHERE email='$email'";
	mysql_query($qry,$conect);
	//echo "senha_alterada == " . $email . "|" . $sAntiga . "|" . $sNova . "|" . $conf;
	header('Location: ' . ABSPATH . '/change-password/?msg=senha_alterada');

}
else
	//echo "senha_invalida == " . $email . "|" . $sAntiga . "|" . $sNova . "|" . $conf;
	header('Location: ' . ABSPATH . '/change-password/?msg=senha_invalida');

mysql_close();

?>


