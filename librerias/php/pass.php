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
        $stmt->bindParam(1, $datalogin['usuario'],PDO::PARAM_STR);
        $stmt->execute(); 
        $filas=$stmt->fetch(PDO::FETCH_ASSOC);
        if($filas){
            //existe usuario
            //buscamos hash para comprobar contrseña
        
            $stmtLogin = $pdo->prepare("select * from loginpass where idUsuario=?");
            $stmtLogin->bindParam(1,  $filas(['id']),PDO::PARAM_STR);
            $stmtLogin->execute(); 
            $returnLogin=$stmtLogin->fetch(PDO::FETCH_ASSOC);
            $comprobante = password_verify($datalogin['password'], $returnLogin(['hashPass']));

            if($comprobante){

            }
            //generamos token.
            $insertado=true;
            $jsondata['status'] = "ok";
            $jsondata['result'] = $comprobante;
            echo json_encode($jsondata);
        }else{
            $jsondata['status'] = "ko";
            $jsondata['result'] = "No existe el usuario";
            echo json_encode($jsondata);
        }
	}catch(PDOException $e)	{
		echo  json_encode("error: ".$e->getMessage());
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
				$jsondata['result'] = $tokenSesion;
				echo json_encode($jsondata);
            }else{
                $jsondata['status'] = "ko";
				$jsondata['result'] = "Se ha producido un error";
				echo json_encode($jsondata);
            }
        }
	}
	catch(PDOException $e) {
		echo  json_encode("error: ".$e->getMessage());
	}
}

//en cada peticion incluir token y primero comprobar si esta ok! si no redirigir a relogin

