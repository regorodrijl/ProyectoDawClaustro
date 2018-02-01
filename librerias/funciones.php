<?php
if (isset($_POST['actualizar'])) {
	$conn = mysql_connect('regorodri.noip.me', 'regorodri', 'Nahyr17.7') or die("No puedo conectarse!!".mysql_error());

	//$db   = mysql_select_db('profesor') or die(&quot;Opps some thing went wrong&quot;);//

	return "dentro";
}else{
	return "Imposible conectar";
}


/*
      $result;

      $name = $_POST['name'];
      $age = $_POST['age'];
      if(mysql_query("INSERT INTO user VALUES('$name', '$age')"))
       echo "Successfully Inserted";
     else
     echo "Insertion Failed";*/
     ?>