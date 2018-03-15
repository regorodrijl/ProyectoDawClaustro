//getdate()
<?php
$opciones = [
    'cost' => 12,
];
echo(getdate()["hours"]);
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


//Obtenemos contraseña desde un form.
$contrasena = $_POST['contra'] ?: '';

//Encriptamos de manera segura la contraseña
$contrasena = password_hash(
                    base64_encode(
                        hash('sha256', $contrasena, true)
                    ),
                PASSWORD_DEFAULT
            );


//Sentencia SQL.
$stmt = $conexion->prepare("INSERT INTO tabla (password) VALUES (?)");

//Ligamos parametros marcadores.
$stmt->bind_param("s",$contrasena);

//Ejecutamos sentencia.
$stmt->execute();

//Cerramos sentencia.
$stmt->close();













// // // // // // // Te voy a dejar un ejemplo como guardar de metodo segura la contraseña con password_hash(), no aplicaria un md5 solo, ya que existen páginas donde podemos descrifrar facilmente las contraseñas  md5, por ejemplo.

// // // // // // // http://md5cracker.org/

// // // // // // // Veamos el funcionamiento password_hash(), crea un nuevo hash de contraseña usando un algoritmo de hash fuerte de único sentido. password_hash() es compatible con crypt(). Por lo tanto, los hash de contraseñas creados con crypt() se pueden usar con password_hash().

//Obtenemos contraseña desde un form.
$contrasena = $_POST['contra'] ?: '';

//Encriptamos de manera segura la contraseña
$contrasena = password_hash(
                    base64_encode(
                        hash('sha256', $contrasena, true)
                    ),
                PASSWORD_DEFAULT
            );


//Sentencia SQL.
$stmt = $conexion->prepare("INSERT INTO tabla (password) VALUES (?)");

//Ligamos parametros marcadores.
$stmt->bind_param("s",$contrasena);

//Ejecutamos sentencia.
$stmt->execute();

//Cerramos sentencia.
$stmt->close();
// // // // // Ahora vemos como podemos verificar la contraseña insertada con hash_equals.

// // // // // hash_equals — Comparación de strings segura contra ataques de temporización

$contrasena = $_POST['contra'] ?: '';    

//Encriptamos de manera segura la contraseña
$contrasena = password_hash(
                    base64_encode(
                        hash('sha256', $contrasena, true)
                    ),
                PASSWORD_DEFAULT
            );

//Sentencia SQL
$stmt = $conexion->prepare("SELECT password FROM tabla WHERE password = ?");

//Ligamos parametros marcadores.
$stmt->bind_param("s",$contrasena);

//Ejecutamos sentencia.
$stmt->execute();  

$stmt->store_result();
if($stmt->num_rows===1) {

    $stmt->bind_result($contrasenaBD);
    $stmt->fetch();
    $stmt->close();

   if (hash_equals($contrasena,$contrasenaDB)) {
      //Hacemos algo.

   }        

} else { $stmt->close(); }

if(isset($_REQUEST["login_pass"])){$login_pass = $_REQUEST["login_pass"];}else{$login_pass = "";}
require 'conexion.php';

$login_pass = "2000000";

$contrasena = password_hash(
    base64_encode(
        hash('sha256',$login_pass, true)
    ),
    PASSWORD_DEFAULT
);

//password_verify — Comprueba que la contraseña coincida con un hash, asique no debes volver a hashearla con password_hash.

$sql_in="SELECT LIDER_EXPLOIT FROM LIDERES WHERE LIDER_EXPLOIT ='".$contrasena."'";

$result = mysqli_query($conn,$sql_in);
$row=mysqli_fetch_array($result);

//Comprobación -> Contraseña -> OK
if (password_verify(
        base64_encode(
            hash('sha256', $login_pass, true)
        ),
        $row["LIDER_EXPLOIT"]
)) {

  echo 'es igual';
}
else
{
  echo 'no es igual';
}