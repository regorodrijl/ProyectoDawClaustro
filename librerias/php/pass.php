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


$opciones = [
    'cost' => 12,
];


$password="usuario"."password".getdate()["hours"];
var_dump( password_hash($password, PASSWORD_BCRYPT, $opciones)."\n");


class Password {
    public static function hash($password) {
        return password_hash($password, PASSWORD_DEFAULT, ['cost' => 15]);
    }
    public static function verify($password, $hash) {
        return password_verify($password, $hash);
    }
}

//login hacemos pass guardando hash
$p=new Password();
echo "\n\n\n\n";
$p->hash($password);
var_dump($p);
//luego token guardamos hash con hora y fecha para token y devolvemos token, 
var_dump($f->verify($password,$p));

echo(getdate()["hours"]);
echo(getdate()["mday"]);
echo(getdate()["mon"]);
echo(getdate()["year"]);
$f=new Password();
echo "coincide";


//en cada peticion incluir token y primero comprobar si esta ok! si no redirigir a relogin


//$stmt = $pdo->prepare("insert into claustro(titulo,dia,horaInicio,horaFin,curso,orden,observacion,activo,borrado) values(:titulo,:dia,:horaInicio,:horaFin,:curso,:orden,:observacion,true,false)");
// $stmt->bindParam(':titulo', $res['titulo']);
// $stmt->bindParam(':dia', $res['dia']);
// $stmt->bindParam(':horaInicio', $res['horaInicio']);
// $stmt->bindParam(':horaFin', $res['horaFin']);
// $stmt->bindParam(':curso', $res['curso']);
// $stmt->bindParam(':orden', $res['orden']);
// $stmt->bindParam(':observacion', $res['observacion']);
// $stmt->execute();



// //Obtenemos contraseña desde un form.
// $contrasena = $_POST['contra'] ?: '';

// //Encriptamos de manera segura la contraseña
// $contrasena = password_hash(
//                     base64_encode(
//                         hash('sha256', $contrasena, true)
//                     ),
//                 PASSWORD_DEFAULT
//             );


// //Sentencia SQL.
// $stmt = $conexion->prepare("INSERT INTO tabla (password) VALUES (?)");

// //Ligamos parametros marcadores.
// $stmt->bind_param("s",$contrasena);

// //Ejecutamos sentencia.
// $stmt->execute();

// //Cerramos sentencia.
// $stmt->close();