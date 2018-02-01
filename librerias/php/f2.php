<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once("./conexion.php");
if(!empty($_POST['claustro'])){
	//se crea claustro, con ese id vamos crear la firma de cada profe, insert en firma (un insert por cada profesor y claustro.)
	//print_r(json_decode($_POST['datos']));
	try{	
		$result = $_POST['claustro'];
		$result = json_decode($result);
		var_dump($result);

		//creamos el claustro
		foreach ($result as  $key) {
			$stmt = $pdo->prepare("insert into claustro(titulo,dia,horaInicio,horaFin,curso,orden,observacion) values(:titulo,:dia,:horaInicio,:horaFin,:curso,:orden,:observacion)");
			$stmt->bindParam(':titulo', $key['titulo']);
			$stmt->bindParam(':dia', $key['dia']);
			$stmt->bindParam(':horaInicio', $key['horaInicio']);
			$stmt->bindParam(':horaFin', $key['horaFin']);
			$stmt->bindParam(':curso', $key['curso']);
			$stmt->bindParam(':orden', $key['orden']);
			$stmt->bindParam(':observacion', $key['observacion']);
			$stmt->execute();
		} 
		echo "ok";
			/*
			// ahora insertamos en firmas para tener la integridad referencial de BD, previa busqueda de id usuario de a tabla profesor.   
			//ultimo id insertado.
			$lastId = $pdo->lastInsertId(); 
			$profesores = $_POST['claustro']["profesores"];
			$arrayIdProfes=[];
			foreach ($profesores as $key) {
				$stmt = $pdo->prepare("select * from profesor where nombre=:nome");
				$stmt->bindParam(':nome', $key);
				$filas=$stmt->fetch();
				// recorremos lo obtenido y los guardamos en array para meterlos en firma
				foreach ($filas as $row) {
					array_push($arrayIdProfes,array("id"=>$row['id']);	
				}*/
			}
			catch(PDOException $e) {
				echo "error: ".$e->getMessage();
			}
		}