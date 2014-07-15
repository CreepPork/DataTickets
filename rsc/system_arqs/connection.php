<?php

	function conecta($conexao){
	
	switch ($conexao) {
		case 1:
			$conecta = mysql_connect("localhost", "", "") or print (mysql_error());
			mysql_select_db("dataticket", $conecta) or print(mysql_error());  // DATATICKET DATABASE
		break;

		case 2:
			$conecta = mysql_connect("localhost", "", "") or print (mysql_error());
			mysql_select_db("artbackup", $conecta); // ARTBACKUP DATABASE
		break;

		case 3:
			$conecta = mysql_connect("localhost", "", "") or print (mysql_error());
			mysql_select_db("datasafer", $conecta); // DATASAFER DATABASE
		break;
		
		default:
			ECHO "FUNCTION conecta EXCEPTION: NO PARAMETER OR WRONG PARAMETER";
			break;
	}
	


	
	}



?>