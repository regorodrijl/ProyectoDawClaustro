<? 
/*$hoy=date('Y-m-d');

		//file_put_contents('nombre.txt', file_get_contents($nombre));

//@file_put_contents('img.txt', file_get_contents($img));
echo "Vamos probar expresiones reg ";
$patron="/[P|p]rofe\s-(\s[0-9]*)?/";
echo preg_match($patron,"Profe -");
echo preg_match($patron,"profe - 12");
echo preg_match($patron,"Profe - 03");
echo preg_match($patron,"profe -");
*/

define('UPLOAD_DIR', './Firmas/');

//$img = $_POST['campofoto'];
// Sacamos data:image/png;base64,

require_once('./conexion.php');
//$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );


$stmtFirma = $pdo->prepare("select * from firma where idClaustro=1;");
$stmtFirma->execute();
$result=$stmtFirma->fetchAll(PDO::FETCH_ASSOC);
if($result){
	//var_dump($result);
	foreach ($result as $key) {
		$img=$key["firma"];
		//var_dump($img);
		if($img>=0){
			echo "CON imagen ";
		}else{


			echo " imagennnn ".gettype($img);
			$img = str_replace('data:image/png;base64,', '', $img);
			$img = str_replace(' ', '+', $img);
			$data = base64_decode($img);
			$src = 'data: image/png;base64,'.$img;

			echo '<table border="1px"><tr><td>NOMBRE</td><td><img src="'.$src.'" width="100" height="auto"></td></tr></table>';
		}
		// Sustituimos el ' ' por el símbolo +.

		//Pasamos el formato ASCII recibido a binario.
		//$file = UPLOAD_DIR . uniqid() . '.png';


		//$success = @file_put_contents($file, $data);
		//echo $success ? "Imagen almacenada en servidor: ".$file : "<br/>Error: Imposible guardar el fichero. Compruebe permisos en carpeta: ".UPLOAD_DIR;


			//Pasamos el formato ASCII recibido a binario.
				/*$file = UPLOAD_DIR . uniqid() . '.png';
		$success = @file_put_contents($file, $data);
		echo $success ? "Imagen almacenada en servidor: ".$file : "<br/>Error: Imposible guardar el fichero. Compruebe permisos en carpeta: ".UPLOAD_DIR;
*/		
		//$imageData = base64_encode(file_get_contents($file));
		
		//echo '<img src="data:image/png;base64,'.$data.'"/>';
		//echo $img;
		//echo strlen($img);

		//echo $img;
		//$cadena=str_replace(PHP_EOL,"",$img);
		//header('Content-Type: image/png');
		//echo '<img src="'.$img.'"/>';
		//echo base64_decode($img);
		//echo strlen($img);


		//echo '<img ng-src="data:image/png;base64,'.$cadena.'"/>';
		//data:image/gif;base64,echo $key["firma"];
		//echo '<img src="data:image/png;base64,'.base64_decode($img).'"/>';
		//break;
		//
		/*
		echo "ESTO ES IMG<br><br><br>";
		$img=trim($key["firma"]);
		$img=str_replace(" ","",$img);
		$img=trim($img);

		

		echo $cadena;
		echo "<br><br><br>";
		echo '<img src="'.$cadena.'"/>';*/
		//echo base64_decode($img);
		//$img = preg_replace("/[\n|\r|\n\r|\t|\0|\x0B]/", "",$img);
		//echo '<img src="data:image/png;base64,'.base64_decode($img).'"/>';
		
	}
}
?>