<?php
$host= 'localhost';
$dbname='claustro';
$user='root';
$pass='';

try {
	$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
	$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch(PDOException $e) {
	echo 'Falló la conexión: ' .$e->getMessage();
}


// $opciones = [
//     'cost' => 12,
// ];


// $password="usuario"."password".getdate()["hours"];
// var_dump( password_hash($password, PASSWORD_BCRYPT, $opciones)."\n");


// class Password {
//     public static function hash($password) {
//         return password_hash($password, PASSWORD_BCRYPT, ['cost' => 15]);
//     }
//     public static function verify($password, $hash) {
//         return password_verify($password, $hash);
//     }
// }

// //login hacemos pass guardando hash
// $p=new Password();
// echo "\n\n\n\n";
// $p->hash($password);
// echo "passsssss";
// var_dump($p);
// //luego token guardamos hash con hora y fecha para token y devolvemos token, 
// $f=new Password();
// var_dump($f->verify($password,$p));

// echo(getdate()["hours"].getdate()["mday"].getdate()["mon"].getdate()["year"]);
// $f=new Password();
// echo "coincide";

if(!empty($_POST['login'])){
    $datalogin = $_POST['login'];
	try{
        $stmt = $pdo->prepare("select * from usuario where usuario=?");
        $stmt->bindParam(1,  $_POST['login']['usuario']);
        $stmt->execute(); 
        $filas=$stmt->fetch(PDO::FETCH_ASSOC);
        if($filas){
            //existe usuario
            $idUsuario=$filas["id"];
            $stmtLogin = $pdo->prepare("select * from loginpass where idUsuario=:id");
            $stmtLogin->bindParam(":id", $idUsuario);
            $stmtLogin->execute(); 
            $returnLogin=$stmtLogin->fetch(PDO::FETCH_ASSOC);
            $comprobante = password_verify($datalogin['password'], $returnLogin['hashPass']);
            if($comprobante){
                //generamos token y lo devolvemos x hora 
                $token=$returnLogin['hashPass'].getdate()["hours"].getdate()["mday"].getdate()["mon"].getdate()["year"];
                $stmtToken=$pdo->prepare("update loginpass set token=:token where id=:id");
				$stmtToken->bindParam(":token", $token);
                $stmtToken->bindParam(":id", $desactivar);
				if($stmtToken->execute()){                    
                    $jsondata['status'] = "ok";
                    $jsondata['dato']="token";
                    $jsondata['responseText'] = $token;
                    echo json_encode($jsondata);
				}else {
                    $jsondata['status'] = "ko";
                    $jsondata['responseText'] = mysql_error($pdo);
                    echo json_encode($jsondata);
                }
            }else{
                $jsondata['status'] = "ko";
                $jsondata['responseText'] = "La contraseña o el usuario son erroneos";
                echo json_encode($jsondata);
            }
        }else{
            $jsondata['status'] = "ko";
            $jsondata['responseText'] = $filas;
            echo json_encode($jsondata);
        }
	}catch(PDOException $e)	{
        $jsondata['status'] = "ko: Error";
        $jsondata['responseText'] = $e->getMessage();
		echo  json_encode($jsondata);
	}
}
if(!empty($_POST['token'])){
    $dataToken = $_POST['token'];
	try{
        $stmtComprobarToken = $pdo->prepare("select * from usuario where usuario=?");
        $stmtComprobarToken->bindParam(1,  $dataToken['token']);
        $stmtComprobarToken->execute(); 
        $resToken=$stmtComprobarToken->fetch(PDO::FETCH_ASSOC);
        if($resToken){
            $jsondata['status'] = "ok";
            $jsondata['responseText'] = "Sesion correcta";
            echo json_encode($jsondata);
        }else {
            $jsondata['status'] = "ko";
            $jsondata['responseText'] = mysql_error($pdo);
            echo json_encode($jsondata);
        }
        }catch(PDOException $e)	{
            $jsondata['status'] = "ko: Error";
            $jsondata['responseText'] = $e->getMessage();
            echo  json_encode($jsondata);
        }
}
if(!empty($_POST['registrarse'])){
    $res = $_POST['registrarse'];
	try{
        $stmt = $pdo->prepare("insert into usuario(usuario,email) values(:usuario,:email)");
        $stmt->bindParam(':usuario', $res['usuario'] );
        $stmt->bindParam(':email',  $res['email']);
        $stmt->execute();

        if($stmt ==false){
            echo json_encode("ko,".$pdo->errorinfo());
        }else {
            $lastId = $pdo->lastInsertId(); 
            //creamos hash
            $hashPassword = password_hash($res['password'], PASSWORD_BCRYPT, ['cost' => 15]);
            //genermos primer token
            $tokenSesion = $hashPassword.getdate()["hours"].getdate()["mday"].getdate()["mon"].getdate()["year"];
            // insertamos en firma
            $stmt = $pdo->prepare("insert into loginpass(idUsuario,hashPass,token) values(:idUsuario,:hashPass,:token)");
            $stmt->bindParam(':idUsuario', $lastId);
            $stmt->bindParam(':hashPass', $hashPassword);
            $stmt->bindParam(':token', $tokenSesion);

            if($stmt->execute()){
                $insertado=true;
                $jsondata['status'] = "ok";
				$jsondata['responseText'] = $tokenSesion;
				echo json_encode($jsondata);
            }else{
                $jsondata['status'] = "ko";
				$jsondata['responseText'] = "Se ha producido un error";
				echo json_encode($jsondata);
            }
        }
	}
	catch(PDOException $e) {
		echo  json_encode("error: ".$e->getMessage());
	}
}

//en cada peticion incluir token y primero comprobar si esta ok! si no redirigir a relogin

