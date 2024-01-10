<?php

	if (! function_exists('conecta')) { // FIXME: Fixed duplicate times this would be added, it would crash
		function conecta($conexao){
		
		switch ($conexao) {
			case 1:
				$conecta = mysql_connect("host.docker.internal", "root", "") or print (mysql_error());
				mysql_select_db("dataticket", $conecta) or print(mysql_error());  // DATATICKET DATABASE
			break;

			case 2:
				$conecta = mysql_connect("host.docker.internal", "root", "") or print (mysql_error());
				mysql_select_db("dataticket", $conecta); // ARTBACKUP DATABASE
			break;

			case 3:
				$conecta = mysql_connect("host.docker.internal", "root", "") or print (mysql_error());
				mysql_select_db("dataticket", $conecta); // DATASAFER DATABASE
			break;
			
			default:
				ECHO "FUNCTION conecta EXCEPTION: NO PARAMETER OR WRONG PARAMETER";
				break;
		}
	}


	
	}



?>
