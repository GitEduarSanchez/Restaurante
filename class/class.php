<?php
session_start();
require_once("classconexion.php");
include_once('funciones_basicas.php');
include "class.phpmailer.php";
include "class.smtp.php";

// Motrar todos los errores de PHP
error_reporting(E_ALL);
// Motrar todos los errores de PHP
ini_set('display_errors', '1');

//evita el error Fatal error: Allowed memory size of X bytes exhausted (tried to allocate Y bytes)...
ini_set('memory_limit', '-1'); 
// es lo mismo que set_time_limit(300) ;
ini_set('max_execution_time', 3800); 

################################## CLASE LOGIN ###################################
class Login extends Db
{

public function __construct()
{
	parent::__construct();
} 	

###################### FUNCION PARA EXPIRAR SESSION POR INACTIVIDAD ####################
public function ExpiraSession()
{
	if(!isset($_SESSION['usuario'])){// Esta logeado?.
		header("Location: logout.php"); 
	}

	//Verifico el tiempo si esta seteado, caso contrario lo seteo.
	if(isset($_SESSION['time'])){
		$tiempo = limpiar($_SESSION['time']);
	} else {
		$tiempo = strtotime(date("Y-m-d H:i:s"));
	}

	$inactividad =7200; //(1 hora de cierre sesion )600 equivale a 10 minutos

	$actual =  strtotime(date("Y-m-d H:i:s"));

	if(($actual-$tiempo) >= $inactividad){
		?>					
		<script type='text/javascript' language='javascript'>
			alert('SU SESSION A EXPIRADO \nPOR FAVOR LOGUEESE DE NUEVO PARA ACCEDER AL SISTEMA') 
			document.location.href='logout'	 
		</script> 
		<?php
	} else {
		$_SESSION['time'] = $actual;
	} 
}
###################### FUNCION PARA EXPIRAR SESSION POR INACTIVIDAD ####################


#################### FUNCION PARA ACCEDER AL SISTEMA ####################
public function Logueo()
{
	self::SetNames();
	if(empty($_POST["usuario"]) or empty($_POST["password"]))
	{
		echo "1";
		exit;
	}

	$sql = "SELECT * FROM usuarios WHERE usuario = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar($_POST["usuario"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		echo "2";
		exit;

	} else {
			
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[]=$row;
		}

		if (limpiar($row['status'])==0)
		{  
			echo "3";
			exit;
		} 
		elseif (password_verify($_POST["password"], $row['password'])) {

		######### DATOS DEL USUARIO ###########
		$_SESSION["codigo"] = $p[0]["codigo"];
		$_SESSION["dni"] = $p[0]["dni"];
		$_SESSION["nombres"] = $p[0]["nombres"];
		$_SESSION["sexo"] = $p[0]["sexo"];
		$_SESSION["direccion"] = $p[0]["direccion"];
		$_SESSION["telefono"] = $p[0]["telefono"];
		$_SESSION["email"] = $p[0]["email"];
		$_SESSION["usuario"] = $p[0]["usuario"];
		$_SESSION["password"] = $p[0]["password"];
		$_SESSION["nivel"] = $p[0]["nivel"];
		$_SESSION["status"] = $p[0]["status"];
		$_SESSION["ingreso"] = limpiar(date("Y-m-d H:i:s"));

		$query = "INSERT INTO log VALUES (null, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1,$a);
		$stmt->bindParam(2,$b);
		$stmt->bindParam(3,$c);
		$stmt->bindParam(4,$d);
		$stmt->bindParam(5,$e);

		$a = limpiar($_SERVER['REMOTE_ADDR']);
		$b = limpiar(date("Y-m-d H:i:s"));
		$c = limpiar($_SERVER['HTTP_USER_AGENT']);
		$d = limpiar($_SERVER['PHP_SELF']);
		$e = limpiar($_POST["usuario"]);
		$stmt->execute();

		switch($_SESSION["nivel"])
		{
			case 'ADMINISTRADOR(A)':
			$_SESSION["acceso"]="administrador";
			?>

			<script type="text/javascript">
				window.location="panel";
			</script>

			<?php
			break;
			case 'SECRETARIA':
			$_SESSION["acceso"]="secretaria";
			?>

			<script type="text/javascript">
				window.location="panel";
			</script>

			<?php
			break;
			case 'CAJERO(A)':
			$_SESSION["acceso"]="cajero";
			?>

			<script type="text/javascript">
				window.location="panel";
			</script>

			<?php
			break;
			case 'MESERO(A)':
			$_SESSION["acceso"]="mesero";
			?>

			<script type="text/javascript">
				window.location="panel";
			</script>

			<?php
			break;
			case 'COCINERO(A)':
			$_SESSION["acceso"]="cocinero";
			?>

			<script type="text/javascript">
				window.location="panel";
			</script>

			<?php
			break;
			case 'REPARTIDOR':
			$_SESSION["acceso"]="repartidor";
			?>

			<script type="text/javascript">
				window.location="panel";
			</script>
			
			<?php
			break;
		}//end switch	

	} else {

  	echo "4";
  
	}
  } 
}
#################### FUNCION PARA ACCEDER AL SISTEMA ####################



















######################## FUNCION RECUPERAR Y ACTUALIZAR PASSWORD #######################

########################### FUNCION PARA RECUPERAR CLAVE #############################
public function RecuperarPassword()
{
	self::SetNames();
	if(empty($_POST["email"]))
	{
		echo "1";
		exit;
	}

	$sql = "SELECT * FROM usuarios WHERE email = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar($_POST["email"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "2";
		exit;
	}
	else
	{
			
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$pa[] = $row;
		}
		$id = $pa[0]["codigo"];
		$nombres = $pa[0]["nombres"];
		$email = $pa[0]["email"];
		$pass = strtoupper(generar_clave(10));
	}

	################## DATOS DE CONFIGURACION #####################
	$sql = "SELECT * FROM configuracion";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
    $rucemisor = $row['cuit'];
    $nomsucursal = $row['nomsucursal'];
    $correo = $row['correosucursal'];
    ################## DATOS DE CONFIGURACION #####################

	#################### VALIDACION DE ENVIO DE CORREO CON PHPMAILER ####################
	$smtp=new PHPMailer();
	$smtp->SMTPOptions = array(
		'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
		)
	);

	# Indicamos que vamos a utilizar un servidor SMTP
	$smtp->IsSMTP();

    # Definimos el formato del correo con UTF-8
	$smtp->CharSet="UTF-8";

    # autenticación contra nuestro servidor smtp
	$smtp->Port = 465;
	$smtp->IsSMTP(); // use SMTP
	$smtp->SMTPAuth   = true;
	$smtp->SMTPSecure = 'ssl';						// enable SMTP authentication
	$smtp->Host       = "smtp.gmail.com";			// sets MAIL as the SMTP server
	//$smtp->Username   = "empresa@gmail.com";	// MAIL username
	//$smtp->Password   = "passworemailempresa";			// MAIL password
	$smtp->Username   = $correo;	// MAIL username
	$smtp->Password   = "gino186$";			// MAIL password

	# datos de quien realiza el envio
	//$smtp->From       = "elsaiya@gmail.com"; // from mail
	$smtp->From       = $correo; // from mail
	$smtp->FromName   = $nomsucursal; // from mail name

	# Indicamos las direcciones donde enviar el mensaje con el formato
	#   "correo"=>"nombre usuario"
	# Se pueden poner tantos correos como se deseen

	# establecemos un limite de caracteres de anchura
	$smtp->WordWrap   = 50; // set word wrap

	# NOTA: Los correos es conveniente enviarlos en formato HTML y Texto para que
	# cualquier programa de correo pueda leerlo.

	# Definimos el contenido HTML del correo
	$contenidoHTML="<head>";
	$contenidoHTML.="<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
	$contenidoHTML.="</head><body>";
	$contenidoHTML.="<b>Recuperación de Contraseña</b>";
	$contenidoHTML.="<p>Nueva Contraseña de Acceso: $pass</p>";
	$contenidoHTML.="</body>\n";

	# Definimos el contenido en formato Texto del correo
	$contenidoTexto= " Recuperación de Contraseña";
	$contenidoTexto.="\n\n";

	# Definimos el subject
	$smtp->Subject= " Recuperación de Contraseña";

	# Adjuntamos el archivo al correo.
    $smtp->AddAttachment("fotos/logo_principal.png", "logo.png");
	//$smtp->AddAttachment("");

	# Indicamos el contenido
	$smtp->AltBody=$contenidoTexto; //Text Body
	$smtp->MsgHTML($contenidoHTML); //Text body HTML

	$smtp->ClearAllRecipients();
	$smtp->AddAddress($email,str_replace(" ", "_",$nombres));

	//$smtp->Send();
	//Enviamos email
	if(!$smtp->Send()) {

	    //Mensaje no pudo ser enviado
	    echo "3";
		exit;

	} else {

	$sql = " UPDATE usuarios set "
	." password = ? "
	." WHERE "
	." codigo = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $password);
	$stmt->bindParam(2, $codigo);

	$codigo = $id;
	$password = password_hash($pass, PASSWORD_DEFAULT);
	$stmt->execute();

	echo "<span class='fa fa-check-square-o'></span> SU NUEVA CLAVE DE ACCESO LE FUE ENVIADA A SU CORREO ELECTRONICO EXITOSAMENTE";
	exit;

   }
	#################### VALIDACION DE ENVIO DE CORREO CON PHPMAILER ####################
}	
############################# FUNCION PARA RECUPERAR CLAVE ############################

########################## FUNCION PARA ACTUALIZAR PASSWORD ############################
public function ActualizarPassword()
{
	self::SetNames();
	if(empty($_POST["dni"]))
	{
		echo "1";
		exit;
	}

	if(password_hash($_POST["password"], PASSWORD_DEFAULT) == limpiar($_POST["clave"])){
		echo "2";
		exit;

	} else {
		
		$sql = " UPDATE usuarios set "
		." usuario = ?, "
		." password = ? "
		." WHERE "
		." codigo = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $usuario);
		$stmt->bindParam(2, $password);
		$stmt->bindParam(3, $codigo);	

		$usuario = limpiar($_POST["usuario"]);
		$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
		$codigo = limpiar($_POST["codigo"]);
		$stmt->execute();
		
		echo "<span class='fa fa-check-square-o'></span> SU CLAVE DE ACCESO FUE ACTUALIZADA EXITOSAMENTE, SER&Aacute; EXPULSADO DE SU SESI&Oacute;N Y DEBER&Aacute; DE ACCEDER NUEVAMENTE CON SU NUEVA CLAVE";
		?>
		<script>
			function redireccionar(){location.href="logout";}
			setTimeout ("redireccionar()", 3000);
		</script>
		<?php
		exit;
	}
}
########################## FUNCION PARA ACTUALIZAR PASSWORD  ############################

####################### FUNCION RECUPERAR Y ACTUALIZAR PASSWORD ########################


























###################### FUNCION CONFIGURACION GENERAL DEL SISTEMA #######################

######################## FUNCION ID CONFIGURACION DEL SISTEMA #########################
public function ConfiguracionPorId()
{
	self::SetNames();
	$sql = "SELECT 
	configuracion.id,
	configuracion.documsucursal,
	configuracion.cuit,
	configuracion.nomsucursal,
	configuracion.codgiro,
	configuracion.girosucursal,
	configuracion.tlfsucursal,
	configuracion.correosucursal,
	configuracion.id_provincia,
	configuracion.id_departamento,
	configuracion.direcsucursal,
	configuracion.documencargado,
	configuracion.dniencargado,
	configuracion.nomencargado,
	configuracion.tlfencargado,
	configuracion.codmoneda,
	configuracion.codmoneda2,
	configuracion.nroactividadsucursal,
	configuracion.inicioticket,
	configuracion.inicioboleta,
	configuracion.iniciofactura,
	configuracion.inicionota,
	configuracion.fechaautorizacion,
	configuracion.llevacontabilidad,
	configuracion.descuentoglobal,
	configuracion.propinasugerida,
	configuracion.infoapi,
	documentos.documento,
	documentos2.documento AS documento2,
	tiposmoneda.moneda,
	tiposmoneda2.moneda AS moneda2,
	tiposmoneda.simbolo,
	tiposmoneda2.simbolo AS simbolo2,
	provincias.provincia,
	departamentos.departamento
	FROM configuracion 
	LEFT JOIN documentos ON configuracion.documsucursal = documentos.coddocumento
	LEFT JOIN documentos AS documentos2 ON configuracion.documencargado = documentos2.coddocumento 
	LEFT JOIN provincias ON configuracion.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON configuracion.id_departamento = departamentos.id_departamento 
	LEFT JOIN tiposmoneda ON configuracion.codmoneda = tiposmoneda.codmoneda
	LEFT JOIN tiposmoneda AS tiposmoneda2 ON configuracion.codmoneda2 = tiposmoneda2.codmoneda WHERE configuracion.id = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array('1'));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################## FUNCION ID CONFIGURACION DEL SISTEMA #########################

######################## FUNCION  ACTUALIZAR CONFIGURACION ##########################
public function ActualizarConfiguracion()
{

	self::SetNames();
	if(empty($_POST["cuit"]) or empty($_POST["nomsucursal"]) or empty($_POST["codgiro"]) or empty($_POST["girosucursal"]) or empty($_POST["tlfsucursal"]) or empty($_POST["correosucursal"]) or empty($_POST["direcsucursal"]) or empty($_POST["codmoneda"]) or empty($_POST["codmoneda2"]) or empty($_POST["dniencargado"]) or empty($_POST["nomencargado"]) or empty($_POST["tlfencargado"]) or empty($_POST["nroactividadsucursal"]) or empty($_POST["inicioticket"]) or empty($_POST["inicioboleta"]) or empty($_POST["iniciofactura"]) or empty($_POST["inicionota"]) or empty($_POST["fechaautorizacion"]) or empty($_POST["llevacontabilidad"]) or empty($_POST["descuentoglobal"]))
	{
		echo "1";
		exit;
	}

	$sql = " UPDATE configuracion set "
	." documsucursal = ?, "
	." cuit = ?, "
	." nomsucursal = ?, "
	." codgiro = ?, "
	." girosucursal = ?, "
	." tlfsucursal = ?, "
	." correosucursal = ?, "
	." id_provincia = ?, "
	." id_departamento = ?, "
	." direcsucursal = ?, "
	." codmoneda = ?, "
	." codmoneda2 = ?, "
	." documencargado = ?, "
	." dniencargado = ?, "
	." nomencargado = ?, "
	." tlfencargado = ?, "
	." nroactividadsucursal = ?, "
	." inicioticket = ?, "
	." inicioboleta = ?, "
	." iniciofactura = ?, "
	." inicionota = ?, "
	." fechaautorizacion = ?, "
	." llevacontabilidad = ?, "
	." descuentoglobal = ?, "
	." propinasugerida = ?, "
	." infoapi = ? "
	." WHERE "
	." id = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $documsucursal);
	$stmt->bindParam(2, $cuit);
	$stmt->bindParam(3, $nomsucursal);
	$stmt->bindParam(4, $codgiro);
	$stmt->bindParam(5, $girosucursal);
	$stmt->bindParam(6, $tlfsucursal);
	$stmt->bindParam(7, $correosucursal);
	$stmt->bindParam(8, $id_provincia);
	$stmt->bindParam(9, $id_departamento);
	$stmt->bindParam(10, $direcsucursal);
	$stmt->bindParam(11, $codmoneda);
	$stmt->bindParam(12, $codmoneda2);
	$stmt->bindParam(13, $documencargado);
	$stmt->bindParam(14, $dniencargado);
	$stmt->bindParam(15, $nomencargado);
	$stmt->bindParam(16, $tlfencargado);
	$stmt->bindParam(17, $nroactividadsucursal);
	$stmt->bindParam(18, $inicioticket);
	$stmt->bindParam(19, $inicioboleta);
	$stmt->bindParam(20, $iniciofactura);
	$stmt->bindParam(21, $inicionota);
	$stmt->bindParam(22, $fechaautorizacion);
	$stmt->bindParam(23, $llevacontabilidad);
	$stmt->bindParam(24, $descuentoglobal);
	$stmt->bindParam(25, $propinasugerida);
	$stmt->bindParam(26, $infoapi);
	$stmt->bindParam(27, $id);

	$documsucursal = limpiar($_POST['documsucursal'] == '' ? "0" : $_POST['documsucursal']);
	$cuit = limpiar($_POST["cuit"]);
	$nomsucursal = limpiar($_POST["nomsucursal"]);
	$codgiro = limpiar($_POST["codgiro"]);
	$girosucursal = limpiar($_POST["girosucursal"]);
	$tlfsucursal = limpiar($_POST["tlfsucursal"]);
	$correosucursal = limpiar($_POST["correosucursal"]);
	$id_provincia = limpiar($_POST['id_provincia'] == '' ? "0" : $_POST['id_provincia']);
	$id_departamento = limpiar($_POST['id_departamento'] == '' ? "0" : $_POST['id_departamento']);
	$direcsucursal = limpiar($_POST["direcsucursal"]);
	$codmoneda = limpiar($_POST["codmoneda"]);
	$codmoneda2 = limpiar($_POST["codmoneda2"]);
	$documencargado = limpiar($_POST['documencargado'] == '' ? "0" : $_POST['documencargado']);
	$dniencargado = limpiar($_POST["dniencargado"]);
	$nomencargado = limpiar($_POST["nomencargado"]);
	$tlfencargado = limpiar($_POST["tlfencargado"]);
	$nroactividadsucursal = limpiar($_POST["nroactividadsucursal"]);
	$inicioticket = limpiar($_POST["inicioticket"]);
	$inicioboleta = limpiar($_POST["inicioboleta"]);
	$iniciofactura = limpiar($_POST["iniciofactura"]);
	$inicionota = limpiar($_POST["inicionota"]);
if (limpiar($_POST['fechaautorizacion']!="") && limpiar($_POST['fechaautorizacion']!="0000-00-00")) { $fechaautorizacion = limpiar(date("Y-m-d",strtotime($_POST['fechaautorizacion']))); } else { $fechaautorizacion = limpiar('0000-00-00'); };
	$llevacontabilidad = limpiar($_POST["llevacontabilidad"]);
	$descuentoglobal = limpiar($_POST["descuentoglobal"]);
	$propinasugerida = limpiar($_POST["propinasugerida"]);
	$infoapi = limpiar("NO");
	$id = limpiar($_POST["id"]);
	$stmt->execute();

	################## SUBIR LOGO PRINCIPAL #1 ######################################
         //datos del arhivo  
if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo =''; }
if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo =''; }
if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo =''; }  
         //compruebo si las características del archivo son las que deseo  
	if ((strpos($tipo_archivo,'image/png')!==false)&&$tamano_archivo<200000) {  
			if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/".$nombre_archivo) && rename("fotos/".$nombre_archivo,"fotos/logo-principal.png"))
			
					{ 
		 ## se puede dar un aviso
					} 
		 ## se puede dar otro aviso 
				}
	################## FINALIZA SUBIR LOGO PRINCIPAL #1 ##################

	################## SUBIR LOGO PDF #1 ######################################
         //datos del arhivo  
if (isset($_FILES['imagen2']['name'])) { $nombre_archivo = $_FILES['imagen2']['name']; } else { $nombre_archivo =''; }
if (isset($_FILES['imagen2']['type'])) { $tipo_archivo = $_FILES['imagen2']['type']; } else { $tipo_archivo =''; }
if (isset($_FILES['imagen2']['size'])) { $tamano_archivo = $_FILES['imagen2']['size']; } else { $tamano_archivo =''; }  
         //compruebo si las características del archivo son las que deseo  
	if ((strpos($tipo_archivo,'image/png')!==false)&&$tamano_archivo<200000) {  
			if (move_uploaded_file($_FILES['imagen2']['tmp_name'], "fotos/".$nombre_archivo) && rename("fotos/".$nombre_archivo,"fotos/logo-pdf.png"))
			
					{ 
		 ## se puede dar un aviso
					} 
		 ## se puede dar otro aviso 
				}
	################## FINALIZA SUBIR LOGO PDF #1 ######################################

	echo "<span class='fa fa-check-square-o'></span> LOS DATOS DE CONFIGURACI&Oacute;N FUERON ACTUALIZADOS EXITOSAMENTE";
	exit;
}
######################## FUNCION  ACTUALIZAR CONFIGURACION #######################

#################### FIN DE FUNCION CONFIGURACION GENERAL DEL SISTEMA ##################


























################################## CLASE USUARIOS #####################################

############################## FUNCION REGISTRAR USUARIOS ##############################
public function RegistrarUsuarios()
{
	self::SetNames();
	if(empty($_POST["nombres"]) or empty($_POST["usuario"]) or empty($_POST["password"]))
	{
		echo "1";
		exit;
	}

	$sql = "SELECT dni FROM usuarios WHERE dni = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["dni"]));
	$num = $stmt->rowCount();
	if($num > 0)
	{
		
		echo "2";
		exit;
	}
	else
	{
		$sql = "SELECT email FROM usuarios WHERE email = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["email"]));
		$num = $stmt->rowCount();
		if($num > 0)
		{

			echo "3";
			exit;
		}
		else
		{
			$sql = "SELECT usuario FROM usuarios WHERE usuario = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["usuario"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$query = "INSERT INTO usuarios values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
				$stmt = $this->dbh->prepare($query);
				$stmt->bindParam(1, $dni);
				$stmt->bindParam(2, $nombres);
				$stmt->bindParam(3, $sexo);
				$stmt->bindParam(4, $direccion);
				$stmt->bindParam(5, $telefono);
				$stmt->bindParam(6, $email);
				$stmt->bindParam(7, $usuario);
				$stmt->bindParam(8, $password);
				$stmt->bindParam(9, $nivel);
				$stmt->bindParam(10, $status);
				$stmt->bindParam(11, $comision);

				$dni = limpiar($_POST["dni"]);
				$nombres = limpiar($_POST["nombres"]);
				$sexo = limpiar($_POST["sexo"]);
				$direccion = limpiar($_POST["direccion"]);
				$telefono = limpiar($_POST["telefono"]);
				$email = limpiar($_POST["email"]);
				$usuario = limpiar($_POST["usuario"]);
				//$password = hash("sha512", $password);	
				//$hashed_password = password_hash($password, PASSWORD_DEFAULT);
				$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
				$nivel = limpiar($_POST["nivel"]);
				$status = limpiar($_POST["status"]);
				$comision = limpiar($_POST["comision"]);
				$stmt->execute();

		################## SUBIR FOTO DE USUARIOS ######################################
         //datos del arhivo  
				if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo =''; }
				if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo =''; }
				if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo =''; }  
         //compruebo si las características del archivo son las que deseo  
				if ((strpos($tipo_archivo,'image/jpeg')!==false)&&$tamano_archivo<50000) 
				{  
					if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/".$nombre_archivo) && rename("fotos/".$nombre_archivo,"fotos/".$_POST["dni"].".jpg"))
					{ 
		 ## se puede dar un aviso
					} 
		 ## se puede dar otro aviso 
				}
		################## FINALIZA SUBIR FOTO DE USUARIOS ##################

				echo "<span class='fa fa-check-square-o'></span> EL USUARIO HA SIDO REGISTRADO EXITOSAMENTE";
				exit;
			}
			else
			{
				echo "4";
				exit;
			}
		}
	}
}
############################# FUNCION REGISTRAR USUARIOS ###############################

############################# FUNCION LISTAR USUARIOS ################################
public function ListarUsuarios()
{
	self::SetNames();

	$sql = "SELECT * FROM usuarios";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
############################## FUNCION LISTAR USUARIOS ################################

###################### FUNCION LISTAR USUARIOS RESPONSABLES ######################
public function ListarResponsables()
{
	self::SetNames();
	$sql = "SELECT * FROM usuarios WHERE nivel = 'ADMINISTRADOR(A)' OR nivel = 'SECRETARIA' OR nivel = 'CAJERO(A)'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
##################### FUNCION LISTAR USUARIOS RESPONSABLES #########################

###################### FUNCION LISTAR USUARIOS REPARTIDORES ######################
public function ListarRepartidores()
{
	self::SetNames();
	$sql = "SELECT * FROM usuarios WHERE nivel = 'REPARTIDOR'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
##################### FUNCION LISTAR USUARIOS REPARTIDORES #########################

########################## FUNCION BUSQUEDA DE LOGS DE USUARIOS ###############################
public function BusquedaLogs()
	{
	self::SetNames();
	
	$buscar = limpiar($_POST['b']);

	if(empty($buscar)) {
            echo "";
            exit;
    }

    $sql = "SELECT * FROM log WHERE CONCAT(ip, ' ',tiempo, ' ',detalles, ' ',usuario) LIKE '%".$buscar."%' LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0) {

	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON REGISTROS PARA TU BUSQUEDA</div></center>";
	exit;
		
	} else {
			
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################## FUNCION BUSQUEDA DE LOGS DE USUARIOS ###############################

########################### FUNCION LISTAR LOGS DE USUARIOS ###########################
public function ListarLogs()
{
	self::SetNames();
	$sql = "SELECT * FROM log";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

   }
########################### FUNCION LISTAR LOGS DE USUARIOS ###########################

############################ FUNCION ID USUARIOS #################################
public function UsuariosPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM usuarios WHERE codigo = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codigo"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID USUARIOS #################################

############################ FUNCION ACTUALIZAR USUARIOS ############################
public function ActualizarUsuarios()
{

	self::SetNames();
	if(empty($_POST["dni"]) or empty($_POST["nombres"]) or empty($_POST["usuario"]) or empty($_POST["password"]))
	{
		echo "1";
		exit;
	}

	$sql = "SELECT * FROM usuarios WHERE codigo != ? AND dni = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codigo"],$_POST["dni"]));
	$num = $stmt->rowCount();
	if($num > 0)
	{
		echo "2";
		exit;
	}
	else
	{
		$sql = "SELECT email FROM usuarios WHERE codigo != ? AND email = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codigo"],$_POST["email"]));
		$num = $stmt->rowCount();
		if($num > 0)
		{
			echo "3";
			exit;
		}
		else
		{
			$sql = "SELECT usuario FROM usuarios WHERE codigo != ? AND usuario = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["codigo"],$_POST["usuario"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$sql = " UPDATE usuarios set "
				." dni = ?, "
				." nombres = ?, "
				." sexo = ?, "
				." direccion = ?, "
				." telefono = ?, "
				." email = ?, "
				." usuario = ?, "
				." password = ?, "
				." nivel = ?, "
				." status = ?, "
				." comision = ? "
				." WHERE "
				." codigo = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $dni);
				$stmt->bindParam(2, $nombres);
				$stmt->bindParam(3, $sexo);
				$stmt->bindParam(4, $direccion);
				$stmt->bindParam(5, $telefono);
				$stmt->bindParam(6, $email);
				$stmt->bindParam(7, $usuario);
				$stmt->bindParam(8, $password);
				$stmt->bindParam(9, $nivel);
				$stmt->bindParam(10, $status);
				$stmt->bindParam(11, $comision);
				$stmt->bindParam(12, $codigo);

				$dni = limpiar($_POST["dni"]);
				$nombres = limpiar($_POST["nombres"]);
				$sexo = limpiar($_POST["sexo"]);
				$direccion = limpiar($_POST["direccion"]);
				$telefono = limpiar($_POST["telefono"]);
				$email = limpiar($_POST["email"]);
				$usuario = limpiar($_POST["usuario"]);
				$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
				$nivel = limpiar($_POST["nivel"]);
				$status = limpiar($_POST["status"]);
				$comision = limpiar($_POST["comision"]);
				$codigo = limpiar($_POST["codigo"]);
				$stmt->execute();

		################## SUBIR FOTO DE USUARIOS ######################################
         //datos del arhivo  
				if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo =''; }
				if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo =''; }
				if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo =''; }  
         //compruebo si las características del archivo son las que deseo  
				if ((strpos($tipo_archivo,'image/jpeg')!==false)&&$tamano_archivo<50000) 
				{  
					if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/".$nombre_archivo) && rename("fotos/".$nombre_archivo,"fotos/".$_POST["dni"].".jpg"))
					{ 
		 ## se puede dar un aviso
					} 
		 ## se puede dar otro aviso 
				}
		################## FINALIZA SUBIR FOTO DE USUARIOS ######################################

				echo "<span class='fa fa-check-square-o'></span> EL USUARIO HA SIDO ACTUALIZADO EXITOSAMENTE";
				exit;

			}
			else
			{
				echo "4";
				exit;
			}
		}
	}
}
############################ FUNCION ACTUALIZAR USUARIOS ############################

############################# FUNCION ELIMINAR USUARIOS ################################
public function EliminarUsuarios()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administrador") {

		$sql = "SELECT codigo FROM cajas WHERE codigo = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codigo"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM usuarios WHERE codigo = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codigo);
			$codigo = decrypt($_GET["codigo"]);
			$stmt->execute();

			$dni = decrypt($_GET["dni"]);
			if (file_exists("fotos/".$dni.".jpg")){
		    //funcion para eliminar una carpeta con contenido
			$archivos = "fotos/".$dni.".jpg";		
			unlink($archivos);
			}

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
############################## FUNCION ELIMINAR USUARIOS ##############################

############################ FIN DE CLASE USUARIOS ################################


























################################ CLASE PROVINCIAS ##################################

########################## FUNCION REGISTRAR PROVINCIAS ###############################
public function RegistrarProvincias()
{
	self::SetNames();
	if(empty($_POST["provincia"]))
	{
		echo "1";
		exit;
	}

			$sql = "SELECT provincia FROM provincias WHERE provincia = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["provincia"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$query = "INSERT INTO provincias values (null, ?);";
				$stmt = $this->dbh->prepare($query);
				$stmt->bindParam(1, $provincia);

				$provincia = limpiar($_POST["provincia"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> LA PROVINCIA HA SIDO REGISTRADA EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
	    }
}
############################ FUNCION REGISTRAR PROVINCIAS ############################

############################ FUNCION LISTAR PROVINCIAS ################################
public function ListarProvincias()
{
	self::SetNames();
	$sql = "SELECT * FROM provincias";

	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
########################### FUNCION LISTAR PROVINCIAS ################################

########################### FUNCION ID PROVINCIAS #################################
public function ProvinciasPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM provincias WHERE id_provincia = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["id_provincia"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID PROVINCIAS #################################

############################ FUNCION ACTUALIZAR PROVINCIAS ############################
public function ActualizarProvincias()
{

	self::SetNames();
	if(empty($_POST["id_provincia"]) or empty($_POST["provincia"]))
	{
		echo "1";
		exit;
	}

			$sql = "SELECT provincia FROM provincias WHERE id_provincia != ? AND provincia = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["id_provincia"],$_POST["provincia"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$sql = " UPDATE provincias set "
				." provincia = ? "
				." WHERE "
				." id_provincia = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $provincia);
				$stmt->bindParam(2, $id_provincia);

				$provincia = limpiar($_POST["provincia"]);
	            $id_provincia = limpiar($_POST['id_provincia']);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> LA PROVINCIA HA SIDO ACTUALIZADA EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
		}
}
############################ FUNCION ACTUALIZAR PROVINCIAS ############################

############################ FUNCION ELIMINAR PROVINCIAS ############################
public function EliminarProvincias()
{
	self::SetNames();
	if($_SESSION['acceso'] == "administrador") {

		$sql = "SELECT id_provincia FROM departamentos WHERE id_provincia = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["id_provincia"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM provincias WHERE id_provincia = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$id_provincia);
			$id_provincia = decrypt($_GET["id_provincia"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
############################ FUNCION ELIMINAR PROVINCIAS ##############################

############################## FIN DE CLASE PROVINCIAS ################################


























############################### CLASE DEPARTAMENTOS ################################

############################# FUNCION REGISTRAR DEPARTAMENTOS ###########################
public function RegistrarDepartamentos()
{
	self::SetNames();
	if(empty($_POST["departamento"]) or empty($_POST["id_provincia"]))
	{
		echo "1";
		exit;
	}

			$sql = "SELECT departamento FROM departamentos WHERE departamento = ? AND id_provincia = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["departamento"],$_POST["id_provincia"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$query = "INSERT INTO departamentos values (null, ?, ?);";
				$stmt = $this->dbh->prepare($query);
				$stmt->bindParam(1, $departamento);
				$stmt->bindParam(2, $id_provincia);

				$departamento = limpiar($_POST["departamento"]);
				$id_provincia = limpiar($_POST['id_provincia']);
				$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> EL DEPARTAMENTO HA SIDO REGISTRADO EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
	    }
}
########################### FUNCION REGISTRAR DEPARTAMENTOS ########################

########################## FUNCION PARA LISTAR DEPARTAMENTOS ##########################
	public function ListarDepartamentos()
	{
		self::SetNames();
		$sql = "SELECT * FROM departamentos LEFT JOIN provincias ON departamentos.id_provincia = provincias.id_provincia";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
######################### FUNCION PARA LISTAR DEPARTAMENTOS ##########################

###################### FUNCION LISTAR DEPARTAMENTOS POR PROVINCIAS #####################
	public function ListarDepartamentoXProvincias() 
	       {
		self::SetNames();
		$sql = "SELECT * FROM departamentos WHERE id_provincia = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_GET["id_provincia"]));
		$num = $stmt->rowCount();
		    if($num==0)
		{
			echo "<option value='0' selected> -- SIN RESULTADOS -- </option>";
			exit;
		}
		else
		{
		while($row = $stmt->fetch())
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
##################### FUNCION LISTAR DEPARTAMENTOS POR PROVINCIAS ######################

################# FUNCION PARA SELECCIONAR DEPARTAMENTOS POR PROVINCIA #################
	public function SeleccionaDepartamento()
	{
		self::SetNames();
		$sql = "SELECT * FROM departamentos WHERE id_provincia = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_GET["id_provincia"]));
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "<option value=''> -- SIN RESULTADOS -- </option>";
			exit;
		}
		else
		{
			while($row = $stmt->fetch())
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
################# FUNCION PARA SELECCIONAR DEPARTAMENTOS POR PROVINCIA ################

############################ FUNCION ID DEPARTAMENTOS #################################
public function DepartamentosPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM departamentos LEFT JOIN provincias ON departamentos.id_provincia = provincias.id_provincia WHERE departamentos.id_provincia = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["id_provincia"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID DEPARTAMENTOS #################################

######################## FUNCION ACTUALIZAR DEPARTAMENTOS ############################
public function ActualizarDepartamentos()
{
	self::SetNames();
	if(empty($_POST["id_departamento"]) or empty($_POST["departamento"]) or empty($_POST["id_provincia"]))
	{
		echo "1";
		exit;
	}

			$sql = "SELECT departamento FROM departamentos WHERE id_departamento != ? AND departamento = ? AND id_provincia = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["id_departamento"],$_POST["departamento"],$_POST["id_provincia"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$sql = " UPDATE departamentos set "
				." departamento = ?, "
				." id_provincia = ? "
				." WHERE "
				." id_departamento = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $departamento);
				$stmt->bindParam(2, $id_provincia);
				$stmt->bindParam(3, $id_departamento);

				$departamento = limpiar($_POST["departamento"]);
	            $id_provincia = limpiar($_POST['id_provincia']);
	            $id_departamento = limpiar($_POST['id_departamento']);
				$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> EL DEPARTAMENTO HA SIDO ACTUALIZADO EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
		}
}
############################ FUNCION ACTUALIZAR DEPARTAMENTOS #######################

############################ FUNCION ELIMINAR DEPARTAMENTOS ###########################
public function EliminarDepartamentos()
{
	self::SetNames();
	if($_SESSION['acceso'] == "administrador") {

		$sql = "SELECT id_departamento FROM configuracion WHERE id_departamento = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["id_departamento"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM departamentos WHERE id_departamento = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$id_departamento);
			$id_departamento = decrypt($_GET["id_departamento"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
########################### FUNCION ELIMINAR DEPARTAMENTOS ############################

############################## FIN DE CLASE DEPARTAMENTOS ##############################


























################################ CLASE TIPOS DE DOCUMENTOS ##############################

########################### FUNCION REGISTRAR TIPO DE DOCUMENTOS ########################
public function RegistrarDocumentos()
{
	self::SetNames();
	if(empty($_POST["documento"]) or empty($_POST["descripcion"]))
	{
		echo "1";
		exit;
	}

			$sql = "SELECT * FROM documentos WHERE documento = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["documento"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$query = "INSERT INTO documentos values (null, ?, ?);";
				$stmt = $this->dbh->prepare($query);
				$stmt->bindParam(1, $documento);
				$stmt->bindParam(2, $descripcion);

				$documento = limpiar($_POST["documento"]);
				$descripcion = limpiar($_POST["descripcion"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> EL TIPO DE DOCUMENTO HA SIDO REGISTRADO EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
	    }
}
############################ FUNCION REGISTRAR TIPO DE MONEDA ########################

########################## FUNCION LISTAR TIPO DE MONEDA ################################
public function ListarDocumentos()
{
	self::SetNames();
	$sql = "SELECT * FROM documentos ORDER BY documento ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
######################### FUNCION LISTAR TIPO DE DOCUMENTOS ##########################

######################### FUNCION ID TIPO DE DOCUMENTOS ###############################
public function DocumentoPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM documentos WHERE coddocumento = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["coddocumento"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################## FUNCION ID TIPO DE DOCUMENTOS #########################

######################### FUNCION ACTUALIZAR TIPO DE DOCUMENTOS ########################
public function ActualizarDocumentos()
{

	self::SetNames();
	if(empty($_POST["coddocumento"]) or empty($_POST["documento"]) or empty($_POST["descripcion"]))
	{
		echo "1";
		exit;
	}

			$sql = "SELECT documento FROM documentos WHERE coddocumento != ? AND documento = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["coddocumento"],$_POST["documento"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$sql = " UPDATE documentos set "
				." documento = ?, "
				." descripcion = ? "
				." WHERE "
				." coddocumento = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $documento);
				$stmt->bindParam(2, $descripcion);
				$stmt->bindParam(3, $coddocumento);

				$documento = limpiar($_POST["documento"]);
				$descripcion = limpiar($_POST["descripcion"]);
				$coddocumento = limpiar($_POST["coddocumento"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> EL TIPO DE DOCUMENTO HA SIDO ACTUALIZADO EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
		}
}
####################### FUNCION ACTUALIZAR TIPO DE DOCUMENTOS #######################

######################### FUNCION ELIMINAR TIPO DE DOCUMENTOS #########################
public function EliminarDocumentos()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administrador") {

		$sql = "SELECT documsucursal FROM configuracion WHERE documsucursal = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["coddocumento"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM documentos WHERE coddocumento = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$coddocumento);
			$coddocumento = decrypt($_GET["coddocumento"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
######################## FUNCION ELIMINAR TIPOS DE DOCUMENTOS ###########################

########################### FIN DE CLASE TIPOS DE DOCUMENTOS ###########################



























############################### CLASE TIPOS DE MONEDAS ##############################

############################ FUNCION REGISTRAR TIPO DE MONEDA ##########################
public function RegistrarTipoMoneda()
{
	self::SetNames();
	if(empty($_POST["moneda"]) or empty($_POST["moneda"]) or empty($_POST["simbolo"]))
	{
		echo "1";
		exit;
	}

			$sql = "SELECT * FROM tiposmoneda WHERE moneda = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["moneda"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$query = "INSERT INTO tiposmoneda values (null, ?, ?, ?);";
				$stmt = $this->dbh->prepare($query);
				$stmt->bindParam(1, $moneda);
				$stmt->bindParam(2, $siglas);
				$stmt->bindParam(3, $simbolo);

				$moneda = limpiar($_POST["moneda"]);
				$siglas = limpiar($_POST["siglas"]);
				$simbolo = limpiar($_POST["simbolo"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> EL TIPO DE MONEDA HA SIDO REGISTRADO EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
	    }
}
######################### FUNCION REGISTRAR TIPO DE MONEDA #######################

########################## FUNCION LISTAR TIPO DE MONEDA ################################
public function ListarTipoMoneda()
{
	self::SetNames();
	$sql = "SELECT * FROM tiposmoneda";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
########################### FUNCION LISTAR TIPO DE MONEDA #########################

############################ FUNCION ID TIPO DE MONEDA #################################
public function TipoMonedaPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM tiposmoneda WHERE codmoneda = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codmoneda"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID TIPO DE MONEDA #################################

####################### FUNCION ACTUALIZAR TIPO DE MONEDA ###########################
public function ActualizarTipoMoneda()
{

	self::SetNames();
	if(empty($_POST["codmoneda"]) or empty($_POST["moneda"]) or empty($_POST["siglas"]) or empty($_POST["simbolo"]))
	{
		echo "1";
		exit;
	}

			$sql = "SELECT moneda FROM tiposmoneda WHERE codmoneda != ? AND moneda = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["codmoneda"],$_POST["moneda"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$sql = " UPDATE tiposmoneda set "
				." moneda = ?, "
				." siglas = ?, "
				." simbolo = ? "
				." WHERE "
				." codmoneda = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $moneda);
				$stmt->bindParam(2, $siglas);
				$stmt->bindParam(3, $simbolo);
				$stmt->bindParam(4, $codmoneda);

				$moneda = limpiar($_POST["moneda"]);
				$siglas = limpiar($_POST["siglas"]);
				$simbolo = limpiar($_POST["simbolo"]);
				$codmoneda = limpiar($_POST["codmoneda"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> EL TIPO DE MONEDA HA SIDO ACTUALIZADO EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
		}
}
######################## FUNCION ACTUALIZAR TIPO DE MONEDA ############################

######################### FUNCION ELIMINAR TIPO DE MONEDA ###########################
public function EliminarTipoMoneda()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administrador") {

		$sql = "SELECT codmoneda FROM tiposcambio WHERE codmoneda = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codmoneda"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM tiposmoneda WHERE codmoneda = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codmoneda);
			$codmoneda = decrypt($_GET["codmoneda"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
########################### FUNCION ELIMINAR TIPOS DE MONEDAS ########################

##################### FUNCION BUSCAR TIPOS DE CAMBIOS POR MONEDA #######################
public function BuscarTiposCambios()
{
	self::SetNames();
	$sql = "SELECT * FROM tiposmoneda INNER JOIN tiposcambio ON tiposmoneda.codmoneda = tiposcambio.codmoneda WHERE tiposcambio.codmoneda = ? ORDER BY tiposcambio.codcambio DESC LIMIT 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codmoneda"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<center><div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON TIPOS DE CAMBIO PARA LA MONEDA SELECCIONADA</div></center>";
		exit;
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
##################### FUNCION BUSCAR TIPOS DE CAMBIOS POR MONEDA #####################

############################# FIN DE CLASE TIPOS DE MONEDAS #############################
























############################## CLASE TIPOS DE CAMBIOS ################################

########################## FUNCION REGISTRAR TIPO DE CAMBIO #########################
public function RegistrarTipoCambio()
{
	self::SetNames();
	if(empty($_POST["descripcioncambio"]) or empty($_POST["montocambio"]) or empty($_POST["codmoneda"]) or empty($_POST["fechacambio"]))
	{
		echo "1";
		exit;
	}
			
		$sql = "SELECT codmoneda, fechacambio FROM tiposcambio WHERE codmoneda = ? AND fechacambio = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codmoneda"],date("Y-m-d",strtotime($_POST['fechacambio']))));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = "INSERT INTO tiposcambio values (null, ?, ?, ?, ?); ";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $descripcioncambio);
			$stmt->bindParam(2, $montocambio);
			$stmt->bindParam(3, $codmoneda);
			$stmt->bindParam(4, $fechacambio);

			$descripcioncambio = limpiar($_POST["descripcioncambio"]);
			$montocambio = number_format($_POST["montocambio"], 3, '.', '');
			$codmoneda = limpiar($_POST["codmoneda"]);
			$fechacambio = limpiar(date("Y-m-d",strtotime($_POST['fechacambio'])));
			$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> EL TIPO DE CAMBIO HA SIDO REGISTRADO EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
	    }
}
######################### FUNCION REGISTRAR TIPO DE CAMBIO ########################

########################### FUNCION LISTAR TIPO DE CAMBIO ########################
public function ListarTipoCambio()
{
	self::SetNames();
	$sql = "SELECT * FROM tiposcambio INNER JOIN tiposmoneda ON tiposcambio.codmoneda = tiposmoneda.codmoneda";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
######################### FUNCION LISTAR TIPO DE CAMBIO ################################

######################## FUNCION ID TIPO DE CAMBIO #################################
public function TipoCambioPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM tiposcambio INNER JOIN tiposmoneda ON tiposcambio.codmoneda = tiposmoneda.codmoneda WHERE tiposcambio.codcambio = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcambio"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID TIPO DE CAMBIO #################################

####################### FUNCION ACTUALIZAR TIPO DE CAMBIO ############################
public function ActualizarTipoCambio()
{
	self::SetNames();
	if(empty($_POST["codcambio"])or empty($_POST["descripcioncambio"]) or empty($_POST["montocambio"]) or empty($_POST["codmoneda"]) or empty($_POST["fechacambio"]))
	{
		echo "1";
		exit;
	}
			
		$sql = "SELECT codmoneda, fechacambio FROM tiposcambio WHERE codcambio != ? AND codmoneda = ? AND fechacambio = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codcambio"],$_POST["codmoneda"],date("Y-m-d",strtotime($_POST['fechacambio']))));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$sql = "UPDATE tiposcambio set "
			." descripcioncambio = ?, "
			." montocambio = ?, "
			." codmoneda = ?, "
			." fechacambio = ? "
			." WHERE "
			." codcambio = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $descripcioncambio);
			$stmt->bindParam(2, $montocambio);
			$stmt->bindParam(3, $codmoneda);
			$stmt->bindParam(4, $fechacambio);
			$stmt->bindParam(5, $codcambio);

			$descripcioncambio = limpiar($_POST["descripcioncambio"]);
			$montocambio = number_format($_POST["montocambio"], 3, '.', '');
			$codmoneda = limpiar($_POST["codmoneda"]);
			$fechacambio = limpiar(date("Y-m-d",strtotime($_POST['fechacambio'])));
			$codcambio = limpiar($_POST["codcambio"]);
			$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> EL TIPO DE CAMBIO HA SIDO ACTUALIZADO EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
	    }
}
###################### FUNCION ACTUALIZAR TIPO DE CAMBIO ############################

########################## FUNCION ELIMINAR TIPO DE CAMBIO ###########################
public function EliminarTipoCambio()
{
	self::SetNames();
		if ($_SESSION['acceso'] == "administrador") {

		    $sql = "DELETE FROM tiposcambio WHERE codcambio = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codcambio);
			$codcambio = decrypt($_GET["codcambio"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		} 
}
########################### FUNCION ELIMINAR TIPO DE CAMBIO ###########################

######################## FUNCION BUSCAR PRODUCTOS POR MONEDA ###########################
public function MonedaProductoId()
{
	self::SetNames();
	$sql = "SELECT configuracion.codmoneda2, tiposmoneda.moneda, tiposmoneda.siglas, tiposmoneda.simbolo, tiposcambio.montocambio 
	FROM configuracion 
	INNER JOIN tiposmoneda ON configuracion.codmoneda2 = tiposmoneda.codmoneda
	INNER JOIN tiposcambio ON tiposmoneda.codmoneda = tiposcambio.codmoneda WHERE configuracion.id = ? ORDER BY tiposcambio.codcambio DESC LIMIT 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array('1'));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	   }
}
###################### FUNCION BUSCAR PRODUCTOS POR MONEDA ##########################

############################ FIN DE CLASE TIPOS DE CAMBIOS #############################


























############################### CLASE IMPUESTOS ####################################

############################ FUNCION REGISTRAR IMPUESTOS ###############################
public function RegistrarImpuestos()
{
	self::SetNames();
	if(empty($_POST["nomimpuesto"]) or empty($_POST["valorimpuesto"]) or empty($_POST["statusimpuesto"]))
	{
		echo "1";
		exit;
	}

			$sql = "SELECT statusimpuesto FROM impuestos WHERE nomimpuesto != ? AND statusimpuesto = ? AND statusimpuesto = 'ACTIVO'";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["nomimpuesto"],$_POST["statusimpuesto"]));
			$num = $stmt->rowCount();
			if($num>0)
			{
				echo "2";
				exit;
			}
			else
			{

			$sql = "SELECT nomimpuesto FROM impuestos WHERE nomimpuesto = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["nomimpuesto"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$query = "INSERT INTO impuestos values (null, ?, ?, ?, ?);";
				$stmt = $this->dbh->prepare($query);
				$stmt->bindParam(1, $nomimpuesto);
				$stmt->bindParam(2, $valorimpuesto);
				$stmt->bindParam(3, $statusimpuesto);
				$stmt->bindParam(4, $fechaimpuesto);

				$nomimpuesto = limpiar($_POST["nomimpuesto"]);
				$valorimpuesto = limpiar($_POST["valorimpuesto"]);
				$statusimpuesto = limpiar($_POST["statusimpuesto"]);
				$fechaimpuesto = limpiar(date("Y-m-d",strtotime($_POST['fechaimpuesto'])));
				$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> EL IMPUESTO HA SIDO REGISTRADO  EXITOSAMENTE";
			exit;

			} else {

			echo "3";
			exit;
	    }
	}
}
############################ FUNCION REGISTRAR IMPUESTOS ###############################

############################# FUNCION LISTAR IMPUESTOS ################################
public function ListarImpuestos()
{
	self::SetNames();
	$sql = "SELECT * FROM impuestos";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
############################# FUNCION LISTAR IMPUESTOS ################################

############################ FUNCION ID IMPUESTOS #################################
public function ImpuestosPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM impuestos WHERE statusimpuesto = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array("ACTIVO"));
	$num = $stmt->rowCount();
	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
}
############################ FUNCION ID IMPUESTOS #################################

############################ FUNCION ACTUALIZAR IMPUESTOS ############################
public function ActualizarImpuestos()
{

	self::SetNames();
	if(empty($_POST["codimpuesto"]) or empty($_POST["nomimpuesto"]) or empty($_POST["valorimpuesto"]) or empty($_POST["statusimpuesto"]))
	{
		echo "1";
		exit;
	}

			$sql = "SELECT statusimpuesto FROM impuestos WHERE codimpuesto != ? AND statusimpuesto = ? AND statusimpuesto = 'ACTIVO'";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["codimpuesto"],$_POST["statusimpuesto"]));
			$num = $stmt->rowCount();
			if($num>0)
			{
				echo "2";
				exit;
			}
			else
			{

			$sql = "SELECT nomimpuesto FROM impuestos WHERE codimpuesto != ? AND nomimpuesto = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["codimpuesto"],$_POST["nomimpuesto"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$sql = " UPDATE impuestos set "
				." nomimpuesto = ?, "
				." valorimpuesto = ?, "
				." statusimpuesto = ? "
				." WHERE "
				." codimpuesto = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $nomimpuesto);
				$stmt->bindParam(2, $valorimpuesto);
				$stmt->bindParam(3, $statusimpuesto);
				$stmt->bindParam(4, $codimpuesto);

				$nomimpuesto = limpiar($_POST["nomimpuesto"]);
				$valorimpuesto = limpiar($_POST["valorimpuesto"]);
				$statusimpuesto = limpiar($_POST["statusimpuesto"]);
				$codimpuesto = limpiar($_POST["codimpuesto"]);
				$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> EL IMPUESTO HA SIDO ACTUALIZADO EXITOSAMENTE";
			exit;

			} else {

			echo "3";
			exit;
		}
	}
}
############################ FUNCION ACTUALIZAR IMPUESTOS ############################

######################### FUNCION ELIMINAR IMPUESTOS #########################
public function EliminarImpuestos()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administrador") {

		$sql = "SELECT * FROM impuestos WHERE codimpuesto = ? AND statusimpuesto = 'ACTIVO'";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codimpuesto"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM impuestos WHERE codimpuesto = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codimpuesto);
			$codimpuesto = decrypt($_GET["codimpuesto"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
######################## FUNCION ELIMINAR IMPUESTOS ###########################

############################ FIN DE CLASE IMPUESTOS ################################





















#################################### CLASE SALAS ##################################

############################# FUNCION REGISTRAR SALAS ############################
public function RegistrarSalas()
{
	self::SetNames();
	if(empty($_POST["nomsala"]))
	{
		echo "1";
		exit;
	}

			$sql = "SELECT nomsala FROM salas WHERE nomsala = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["nomsala"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$query = "INSERT INTO salas values (null, ?, ?);";
				$stmt = $this->dbh->prepare($query);
				$stmt->bindParam(1, $nomsala);
				$stmt->bindParam(2, $fecha);

				$nomsala = limpiar($_POST["nomsala"]);
		        $fecha = limpiar(date("Y-m-d"));
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> LA SALA HA SIDO REGISTRADA EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
	    }
}
############################# FUNCION REGISTRAR SALAS ##############################

############################# FUNCION LISTAR SALAS #############################
public function ListarSalas()
{
	self::SetNames();
	$sql = "SELECT * FROM salas";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
############################## FUNCION LISTAR SALAS #############################

############################ FUNCION ID SALAS #################################
public function SalasPorId()
{
	self::SetNames();
	$sql = "SELECT salas.codsala, salas.nomsala, salas.fecha, mesas.codmesa, mesas.nommesa, mesas.fecha, mesas.statusmesa FROM salas LEFT JOIN mesas ON salas.codsala = mesas.codsala WHERE salas.codsala = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codsala"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID SALAS #################################

############################ FUNCION ACTUALIZAR SALAS ############################
public function ActualizarSalas()
{

	self::SetNames();
	if(empty($_POST["codsala"]) or empty($_POST["nomsala"]))
	{
		echo "1";
		exit;
	}

			$sql = "SELECT nomsala FROM salas WHERE codsala != ? AND nomsala = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["codsala"],$_POST["nomsala"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$sql = " UPDATE salas set "
				." nomsala = ? "
				." WHERE "
				." codsala = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $nomsala);
				$stmt->bindParam(2, $codsala);

				$nomsala = limpiar($_POST["nomsala"]);
				$codsala = limpiar($_POST["codsala"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> LA SALA HA SIDO ACTUALIZADA EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
		}
}
############################ FUNCION ACTUALIZAR SALAS ############################

############################ FUNCION ELIMINAR SALAS ############################
public function EliminarSalas()
{
	self::SetNames();

	if($_SESSION['acceso'] == "administrador") {

		$sql = "SELECT codsala FROM mesas WHERE codsala = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codsala"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM salas WHERE codsala = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codsala);
			$codsala = decrypt($_GET["codsala"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
############################# FUNCION ELIMINAR SALAS #############################

################################ FIN DE CLASE SALAS ###############################






















#################################### CLASE MESAS ##################################

############################# FUNCION REGISTRAR MESAS ############################
public function RegistrarMesas()
{
	self::SetNames();
	if(empty($_POST["codsala"]) or empty($_POST["nommesa"]))
	{
		echo "1";
		exit;
	}

	$sql = "SELECT codsala, nommesa FROM mesas WHERE codsala = ? and nommesa = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codsala"], $_POST["nommesa"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$query = "INSERT INTO mesas values (null, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codsala);
		$stmt->bindParam(2, $nommesa);
		$stmt->bindParam(3, $puestos);
		$stmt->bindParam(4, $fecha);
        $stmt->bindParam(5, $statusmesa);

		$codsala = limpiar($_POST["codsala"]);
		$nommesa = limpiar($_POST["nommesa"]);
		$puestos = limpiar($_POST["puestos"]);
        $fecha = limpiar(date("Y-m-d"));
        $statusmesa = limpiar("0");
		$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> LA MESA HA SIDO REGISTRADA EXITOSAMENTE";
		exit;

		} else {

		echo "2";
		exit;
    }
}
############################# FUNCION REGISTRAR MESAS ##############################

############################# FUNCION LISTAR MESAS #############################
public function ListarMesas()
{
	self::SetNames();
	$sql = "SELECT 
	salas.codsala, 
	salas.nomsala, 
	salas.fecha, 
	mesas.codmesa, 
	mesas.nommesa, 
	mesas.puestos, 
	mesas.fecha, 
	mesas.statusmesa,
	SUM(pag.totalpago) as total_deudas
	
	FROM mesas LEFT JOIN salas ON mesas.codsala = salas.codsala

	LEFT JOIN
        (SELECT
        codmesa, totalpago     
        FROM ventas WHERE statuspago != 0) pag ON pag.codmesa = mesas.codmesa

	GROUP BY mesas.codmesa
	ORDER BY mesas.nommesa ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
############################## FUNCION LISTAR MESAS #############################

############################ FUNCION ID MESAS #################################
public function MesasPorId()
{
	self::SetNames();
	$sql = "SELECT salas.codsala, salas.nomsala, salas.fecha, mesas.codmesa, mesas.nommesa, mesas.puestos, mesas.fecha, mesas.statusmesa FROM mesas LEFT JOIN salas ON mesas.codsala = salas.codsala WHERE mesas.codmesa = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codmesa"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID MESAS #################################

############################ FUNCION ACTUALIZAR MESAS ############################
public function ActualizarMesas()
{

	self::SetNames();
	if(empty($_POST["codmesa"]) or empty($_POST["codsala"]) or empty($_POST["nommesa"]))
	{
		echo "1";
		exit;
	}

	$sql = "SELECT codsala, nommesa FROM mesas WHERE codmesa != ? AND codsala = ? AND nommesa = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codmesa"],$_POST["codsala"],$_POST["nommesa"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$sql = " UPDATE mesas set "
		." codsala = ?, "
		." nommesa = ?, "
		." puestos = ? "
		." WHERE "
		." codmesa = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $codsala);
		$stmt->bindParam(2, $nommesa);
		$stmt->bindParam(3, $puestos);
		$stmt->bindParam(4, $codmesa);

		$codsala = limpiar($_POST["codsala"]);
		$nommesa = limpiar($_POST["nommesa"]);
		$puestos = limpiar($_POST["puestos"]);
		$codmesa = limpiar($_POST["codmesa"]);
		$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> LA MESA HA SIDO ACTUALIZADA EXITOSAMENTE";
		exit;

		} else {

		echo "2";
		exit;
	}
}
############################ FUNCION ACTUALIZAR MESAS ############################

############################ FUNCION ELIMINAR MESAS ############################
public function EliminarMesas()
{
	self::SetNames();

	if($_SESSION['acceso'] == "administrador") {

	$sql = "SELECT codmesa FROM ventas WHERE codmesa = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codmesa"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{

		$sql = "DELETE FROM mesas WHERE codmesa = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codmesa);
		$codmesa = decrypt($_GET["codmesa"]);
		$stmt->execute();

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
	} 
			
	} else {
		
		echo "3";
		exit;
	}	
}
############################# FUNCION ELIMINAR MESAS #############################

####################### FUNCION BUSCAR MESAS POR SALAS ######################
public function BuscarMesas() 
{
	self::SetNames();
	$sql = "SELECT * FROM mesas WHERE codsala = ? AND statusmesa != 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codsala"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<option value=''> -- SIN RESULTADOS -- </option>";
		exit;
	}
	else
	{
	while($row = $stmt->fetch())
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
####################### FUNCION BUSCAR MESAS POR SALAS #########################

############################ FUNCION CAMBIAR MESAS ############################
public function CambiarMesas()
{
	self::SetNames();
	if(empty($_POST["codventa"]) or empty($_POST["viejamesa"]) or empty($_POST["nuevasala"]) or empty($_POST["nuevamesa"]))
	{
		echo "1";
		exit;
	}

	$sql = "SELECT * FROM mesas WHERE codmesa = ? AND statusmesa = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_POST["nuevamesa"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		
        $sql = "SELECT * FROM ventas WHERE codmesa = ? AND statusventa = 0 AND bandera = 0";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_POST["viejamesa"])));
		$num = $stmt->rowCount();
        if($num > 1) {

		    ############### ACTUALIZO MESA EN VENTA ###############
        	$sql = " UPDATE ventas set "
        	." codmesa = ? "
        	." WHERE "
        	." codventa = ?;
        	";
        	$stmt = $this->dbh->prepare($sql);
        	$stmt->bindParam(1, $nuevamesa);
        	$stmt->bindParam(2, $codventa);

        	$nuevamesa = limpiar(decrypt($_POST["nuevamesa"]));
        	$codventa = limpiar(decrypt($_POST["codventa"]));
        	$stmt->execute();
		    ############### ACTUALIZO MESA EN VENTA ###############

		    ############### ACTUALIZO STATUS A RESERVADA DE MESA ###############
        	$sql = " UPDATE mesas set "
        	." statusmesa = ? "
        	." WHERE "
        	." codmesa = ?;
        	";
        	$stmt = $this->dbh->prepare($sql);
        	$stmt->bindParam(1, $statusmesa);
        	$stmt->bindParam(2, $nuevamesa);

        	$statusmesa = limpiar("1");
        	$nuevamesa = limpiar(decrypt($_POST["nuevamesa"]));
        	$stmt->execute();
		    ############### ACTUALIZO STATUS A RESERVADA DE MESA ###############

        } else {

        	############### ACTUALIZO STATUS A DISPONIBLE DE MESA ###############
        	$sql = " UPDATE mesas set "
        	." statusmesa = ? "
        	." WHERE "
        	." codmesa = ?;
        	";
        	$stmt = $this->dbh->prepare($sql);
        	$stmt->bindParam(1, $statusmesa);
        	$stmt->bindParam(2, $mesaentra);

        	$statusmesa = limpiar("0");
        	$mesaentra = limpiar(decrypt($_POST["viejamesa"]));
        	$stmt->execute();
		    ############### ACTUALIZO STATUS A DISPONIBLE DE MESA ###############

		    ############### ACTUALIZO MESA EN VENTA ###############
        	$sql = " UPDATE ventas set "
        	." codmesa = ? "
        	." WHERE "
        	." codventa = ?;
        	";
        	$stmt = $this->dbh->prepare($sql);
        	$stmt->bindParam(1, $nuevamesa);
        	$stmt->bindParam(2, $codventa);

        	$nuevamesa = limpiar(decrypt($_POST["nuevamesa"]));
        	$codventa = limpiar(decrypt($_POST["codventa"]));
        	$stmt->execute();
		    ############### ACTUALIZO MESA EN VENTA ###############

		    ############### ACTUALIZO STATUS A RESERVADA DE MESA ###############
        	$sql = " UPDATE mesas set "
        	." statusmesa = ? "
        	." WHERE "
        	." codmesa = ?;
        	";
        	$stmt = $this->dbh->prepare($sql);
        	$stmt->bindParam(1, $statusmesa);
        	$stmt->bindParam(2, $nuevamesa);

        	$statusmesa = limpiar("1");
        	$nuevamesa = limpiar(decrypt($_POST["nuevamesa"]));
        	$stmt->execute();
		    ############### ACTUALIZO STATUS A RESERVADA DE MESA ###############

        }

		echo "<span class='fa fa-check-square-o'></span> LA MESA HA SIDO CAMBIADA EXITOSAMENTE";
		exit;

	} else {

		echo "2";
		exit;
	}
}
############################ FUNCION CAMBIAR MESAS ############################

################################ FIN DE CLASE MESAS ###############################























#################################### CLASE CATEGORIAS ##################################

############################# FUNCION REGISTRAR CATEGORIAS ############################
public function RegistrarCategorias()
{
	self::SetNames();
	if(empty($_POST["nomcategoria"]))
	{
		echo "1";
		exit;
	}

			$sql = "SELECT nomcategoria FROM categorias WHERE nomcategoria = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["nomcategoria"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$query = "INSERT INTO categorias values (null, ?);";
				$stmt = $this->dbh->prepare($query);
				$stmt->bindParam(1, $nomcategoria);

				$nomcategoria = limpiar($_POST["nomcategoria"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> LA CATEGORIA HA SIDO REGISTRADA EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
	    }
}
############################# FUNCION REGISTRAR CATEGORIAS ##############################

############################# FUNCION LISTAR CATEGORIAS #############################
public function ListarCategorias()
{
	self::SetNames();
	$sql = "SELECT * FROM categorias ORDER BY nomcategoria ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
############################## FUNCION LISTAR NOTICIAS #############################

############################ FUNCION ID CATEGORIAS #################################
public function CategoriasPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM categorias WHERE codcategoria = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcategoria"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID CATEGORIAS #################################

############################ FUNCION ACTUALIZAR CATEGORIAS ############################
public function ActualizarCategorias()
{

	self::SetNames();
	if(empty($_POST["codcategoria"]) or empty($_POST["nomcategoria"]))
	{
		echo "1";
		exit;
	}

			$sql = "SELECT nomcategoria FROM categorias WHERE codcategoria != ? AND nomcategoria = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["codcategoria"],$_POST["nomcategoria"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$sql = " UPDATE categorias set "
				." nomcategoria = ? "
				." WHERE "
				." codcategoria = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $nomcategoria);
				$stmt->bindParam(2, $codcategoria);

				$nomcategoria = limpiar($_POST["nomcategoria"]);
				$codcategoria = limpiar($_POST["codcategoria"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> LA CATEGORIA HA SIDO ACTUALIZADA EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
		}
}
############################ FUNCION ACTUALIZAR CATEGORIAS ############################

############################ FUNCION ELIMINAR CATEGORIAS ############################
public function EliminarCategorias()
{
	self::SetNames();

	if($_SESSION['acceso'] == "administrador") {

		$sql = "SELECT codcategoria FROM productos WHERE codcategoria = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codcategoria"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM categorias WHERE codcategoria = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codcategoria);
			$codcategoria = decrypt($_GET["codcategoria"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
############################# FUNCION ELIMINAR CATEGORIAS #############################

################################ FIN DE CLASE CATEGORIAS ###############################


























#################################### CLASE MEDIDAS ##################################

############################# FUNCION REGISTRAR MEDIDAS ############################
public function RegistrarMedidas()
{
	self::SetNames();
	if(empty($_POST["nommedida"]))
	{
		echo "1";
		exit;
	}

		$sql = "SELECT nommedida FROM medidas WHERE nommedida = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["nommedida"]));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = "INSERT INTO medidas values (null, ?);";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $nommedida);

			$nommedida = limpiar($_POST["nommedida"]);
			$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> LA MEDIDA HA SIDO REGISTRADA EXITOSAMENTE";
		exit;

	} else {

		echo "2";
		exit;
	}
}
############################# FUNCION REGISTRAR MEDIDAS ##############################

############################# FUNCION LISTAR MEDIDAS #############################
public function ListarMedidas()
{
	self::SetNames();
	$sql = "SELECT * FROM medidas";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 }
############################## FUNCION LISTAR MEDIDAS #############################

############################ FUNCION ID MEDIDAS #################################
public function MedidasPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM medidas WHERE codmedida = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codmedida"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID MEDIDAS #################################

############################ FUNCION ACTUALIZAR MEDIDAS ############################
public function ActualizarMedidas()
{

	self::SetNames();
	if(empty($_POST["codmedida"]) or empty($_POST["nommedida"]))
	{
		echo "1";
		exit;
	}

			$sql = "SELECT nommedida FROM medidas WHERE codmedida != ? AND nommedida = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->execute(array($_POST["codmedida"],$_POST["nommedida"]));
			$num = $stmt->rowCount();
			if($num == 0)
			{
				$sql = " UPDATE medidas set "
				." nommedida = ? "
				." WHERE "
				." codmedida = ?;
				";
				$stmt = $this->dbh->prepare($sql);
				$stmt->bindParam(1, $nommedida);
				$stmt->bindParam(2, $codmedida);

				$nommedida = limpiar($_POST["nommedida"]);
				$codmedida = limpiar($_POST["codmedida"]);
				$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> LA MEDIDA HA SIDO ACTUALIZADA EXITOSAMENTE";
			exit;

			} else {

			echo "2";
			exit;
		}
}
############################ FUNCION ACTUALIZAR MEDIDAS ############################

############################ FUNCION ELIMINAR MEDIDAS ############################
public function EliminarMedidas()
{
	self::SetNames();

	if($_SESSION['acceso'] == "administrador") {

		$sql = "SELECT codmedida FROM ingredientes WHERE codmedida = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codmedida"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM medidas WHERE codmedida = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codmedida);
			$codmedida = decrypt($_GET["codmedida"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
############################# FUNCION ELIMINAR MEDIDAS #############################

################################ FIN DE CLASE MEDIDAS ###############################
























################################## CLASE CLIENTES ##################################

############################### FUNCION CARGAR CLIENTES ##############################
	public function CargarClientes()
	{
		self::SetNames();
		if(empty($_FILES["sel_file"]))
		{
			echo "1";
			exit;
		}
        //Aquí es donde seleccionamos nuestro csv
         $fname = $_FILES['sel_file']['name'];
         //echo 'Cargando nombre del archivo: '.$fname.' ';
         $chk_ext = explode(".",$fname);
         
        if(strtolower(end($chk_ext)) == "csv")
        {
        //si es correcto, entonces damos permisos de lectura para subir
        $filename = $_FILES['sel_file']['tmp_name'];
        $handle = fopen($filename, "r");
        $this->dbh->beginTransaction();
        
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

               //Insertamos los datos con los valores...
			   
		$query = "INSERT INTO clientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcliente);
		$stmt->bindParam(2, $tipocliente);
		$stmt->bindParam(3, $documcliente);
		$stmt->bindParam(4, $dnicliente);
		$stmt->bindParam(5, $nomcliente);
		$stmt->bindParam(6, $razoncliente);
		$stmt->bindParam(7, $girocliente);
		$stmt->bindParam(8, $tlfcliente);
		$stmt->bindParam(9, $id_provincia);
		$stmt->bindParam(10, $id_departamento);
		$stmt->bindParam(11, $direccliente);
		$stmt->bindParam(12, $emailcliente);
		$stmt->bindParam(13, $limitecredito);
		$stmt->bindParam(14, $fechaingreso);
		
		$codcliente = limpiar($data[0]);
		$tipocliente = limpiar($data[1]);
		$documcliente = limpiar($data[2]);
		$dnicliente = limpiar($data[3]);
		$nomcliente = limpiar($data[4]);
		$razoncliente = limpiar($data[5]);
		$girocliente = limpiar($data[6]);
		$tlfcliente = limpiar($data[7]);
		$id_provincia = limpiar($data[8]);
		$id_departamento = limpiar($data[9]);
		$direccliente = limpiar($data[10]);
		$emailcliente = limpiar($data[11]);
		$limitecredito = limpiar($data[12]);
		$fechaingreso = limpiar(date("Y-m-d"));
		$stmt->execute();
				
        }
           $this->dbh->commit();
           //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
           fclose($handle);
	        
	echo "<span class='fa fa-check-square-o'></span> LA CARGA MASIVA DE CLIENTES FUE REALIZADA EXITOSAMENTE";
	exit;
             
         }
         else
         {
    //si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para ver si esta separado por " , "
         echo "2";
		 exit;
      }  
}
################################# FUNCION CARGAR CLIENTES ###############################

############################ FUNCION REGISTRAR CLIENTES ###############################
	public function RegistrarClientes()
	{
		self::SetNames();
		if(empty($_POST["tipocliente"]) or empty($_POST["dnicliente"]) or empty($_POST["direccliente"]))
		{
			echo "1";
			exit;
		}

		$sql = "SELECT codcliente FROM clientes ORDER BY idcliente DESC LIMIT 1";
		foreach ($this->dbh->query($sql) as $row){

			$id=$row["codcliente"];

		}
		if(empty($id))
		{
			$codcliente = "C1";

		} else {

			$resto = substr($id, 0, 1);
			$coun = strlen($resto);
			$num     = substr($id, $coun);
			$codigo     = $num + 1;
			$codcliente = "C".$codigo;
		}

		$sql = "SELECT dnicliente FROM clientes WHERE dnicliente = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["dnicliente"]));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = "INSERT INTO clientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $codcliente);
			$stmt->bindParam(2, $tipocliente);
		    $stmt->bindParam(3, $documcliente);
			$stmt->bindParam(4, $dnicliente);
			$stmt->bindParam(5, $nomcliente);
			$stmt->bindParam(6, $razoncliente);
			$stmt->bindParam(7, $girocliente);
			$stmt->bindParam(8, $tlfcliente);
			$stmt->bindParam(9, $id_provincia);
			$stmt->bindParam(10, $id_departamento);
			$stmt->bindParam(11, $direccliente);
			$stmt->bindParam(12, $emailcliente);
		    $stmt->bindParam(13, $limitecredito);
			$stmt->bindParam(14, $fechaingreso);
			
			$tipocliente = limpiar($_POST["tipocliente"]);
			$documcliente = limpiar($_POST["documcliente"]);
			$dnicliente = limpiar($_POST["dnicliente"]);
			$nomcliente = limpiar($_POST['tipocliente'] == 'JURIDICO' ? "" : $_POST["nomcliente"]);
			$razoncliente = limpiar($_POST['tipocliente'] == 'NATURAL' ? "" : $_POST["razoncliente"]);
			$girocliente = limpiar($_POST['tipocliente'] == 'NATURAL' ? "" : $_POST["girocliente"]);
			$tlfcliente = limpiar($_POST["tlfcliente"]);
if (limpiar($_POST['id_provincia']=="")) { $id_provincia = limpiar('0'); } else { $id_provincia = limpiar($_POST['id_provincia']); }
if (limpiar($_POST['id_departamento']=="")) { $id_departamento = limpiar('0'); } else { $id_departamento = limpiar($_POST['id_departamento']); }
			$direccliente = limpiar($_POST["direccliente"]);
			$emailcliente = limpiar($_POST["emailcliente"]);
			$limitecredito = limpiar($_POST["limitecredito"]);
		    $fechaingreso = limpiar(date("Y-m-d"));
			$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> EL CLIENTE HA SIDO REGISTRADO EXITOSAMENTE";
			exit;

		} else {

			echo "2";
			exit;
		}
	}
######################## FUNCION REGISTRAR CLIENTES ###############################

########################## FUNCION BUSQUEDA DE CLIENTES ###############################
public function BusquedaClientes()
	{
	self::SetNames();
	 $sql = "SELECT
	clientes.codcliente,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	clientes.nomcliente,
	clientes.razoncliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	clientes.fechaingreso,
    documentos.documento,
	provincias.provincia,
	departamentos.departamento
	FROM clientes 
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento WHERE CONCAT(dnicliente, ' ',nomcliente, ' ',razoncliente, ' ',direccliente, ' ',emailcliente) LIKE '%".limpiar($_GET['bclientes'])."%' LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0) {

	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON REGISTROS PARA TU BUSQUEDA</div></center>";
	exit;
		
	} else {
			
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################## FUNCION BUSQUEDA DE CLIENTES ###############################

############################ FUNCION LISTAR CLIENTES ################################
	public function ListarClientes()
	{
		self::SetNames();
	$sql = "SELECT
		clientes.codcliente,
		clientes.tipocliente,
		clientes.documcliente,
		clientes.dnicliente,
		CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
		clientes.girocliente,
		clientes.tlfcliente,
		clientes.id_provincia,
		clientes.id_departamento,
		clientes.direccliente,
		clientes.emailcliente,
		clientes.limitecredito,
		clientes.fechaingreso,
	    documentos.documento,
		provincias.provincia,
		departamentos.departamento
		FROM clientes 
		LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
		LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
		LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
######################### FUNCION LISTAR CLIENTES ################################

######################### FUNCION ID CLIENTES #################################
	public function ClientesPorId()
	{
		self::SetNames();
		$sql = "SELECT
		clientes.codcliente,
		clientes.tipocliente,
		clientes.documcliente,
		clientes.dnicliente,
		CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
		clientes.girocliente,
		clientes.tlfcliente,
		clientes.id_provincia,
		clientes.id_departamento,
		clientes.direccliente,
		clientes.emailcliente,
		clientes.limitecredito,
		clientes.fechaingreso,
	    documentos.documento,
		provincias.provincia,
		departamentos.departamento,
		COUNT(ventas.codcliente) as cantidad,
		SUM(ventas.totalpago) as totalcompras
		FROM clientes
		LEFT JOIN ventas ON clientes.codcliente = ventas.codcliente 
		LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
		LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
		LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento WHERE clientes.codcliente = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codcliente"])));
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
############################ FUNCION ID CLIENTES #################################
	
############################ FUNCION ACTUALIZAR CLIENTES ############################
	public function ActualizarClientes()
	{
		
	    self::SetNames();
		if(empty($_POST["codcliente"]) or empty($_POST["tipocliente"]) or empty($_POST["dnicliente"]) or empty($_POST["direccliente"]))
		{
			echo "1";
			exit;
		}
		$sql = "SELECT dnicliente FROM clientes WHERE codcliente != ? AND dnicliente = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codcliente"],$_POST["dnicliente"]));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$sql = "UPDATE clientes set "
			." tipocliente = ?, "
			." documcliente = ?, "
			." dnicliente = ?, "
			." nomcliente = ?, "
			." razoncliente = ?, "
			." girocliente = ?, "
			." tlfcliente = ?, "
			." id_provincia = ?, "
			." id_departamento = ?, "
			." direccliente = ?, "
			." emailcliente = ?, "
			." limitecredito = ? "
			." WHERE "
			." codcliente = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $tipocliente);
		    $stmt->bindParam(2, $documcliente);
			$stmt->bindParam(3, $dnicliente);
			$stmt->bindParam(4, $nomcliente);
			$stmt->bindParam(5, $razoncliente);
			$stmt->bindParam(6, $girocliente);
			$stmt->bindParam(7, $tlfcliente);
			$stmt->bindParam(8, $id_provincia);
			$stmt->bindParam(9, $id_departamento);
			$stmt->bindParam(10, $direccliente);
			$stmt->bindParam(11, $emailcliente);
			$stmt->bindParam(12, $limitecredito);
			$stmt->bindParam(13, $codcliente);
			
			$tipocliente = limpiar($_POST["tipocliente"]);
			$documcliente = limpiar($_POST["documcliente"]);
			$dnicliente = limpiar($_POST["dnicliente"]);
			$nomcliente = limpiar($_POST['tipocliente'] == 'JURIDICO' ? "" : $_POST["nomcliente"]);
			$razoncliente = limpiar($_POST['tipocliente'] == 'NATURAL' ? "" : $_POST["razoncliente"]);
			$girocliente = limpiar($_POST['tipocliente'] == 'NATURAL' ? "" : $_POST["girocliente"]);
			$tlfcliente = limpiar($_POST["tlfcliente"]);
if (limpiar($_POST['id_provincia']=="")) { $id_provincia = limpiar('0'); } else { $id_provincia = limpiar($_POST['id_provincia']); }
if (limpiar($_POST['id_departamento']=="")) { $id_departamento = limpiar('0'); } else { $id_departamento = limpiar($_POST['id_departamento']); }
			$direccliente = limpiar($_POST["direccliente"]);
			$emailcliente = limpiar($_POST["emailcliente"]);
			$limitecredito = limpiar($_POST["limitecredito"]);
			$codcliente = limpiar($_POST["codcliente"]);
			$stmt->execute();
        
		echo "<span class='fa fa-check-square-o'></span> EL CLIENTE HA SIDO ACTUALIZADO EXITOSAMENTE";
		exit;

		} else {

			echo "2";
			exit;
		}
	}
############################ FUNCION ACTUALIZAR CLIENTES ############################

########################### FUNCION ELIMINAR CLIENTES #################################
	public function EliminarClientes()
	{
	self::SetNames();
		if ($_SESSION['acceso'] == "administrador") {

		$sql = "SELECT codcliente FROM ventas WHERE codcliente = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codcliente"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM clientes where codcliente = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codcliente);
			$codcliente = decrypt($_GET["codcliente"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
########################## FUNCION ELIMINAR CLIENTES #################################

############################## FIN DE CLASE CLIENTES #################################


























################################## CLASE PROVEEDORES ###################################

########################## FUNCION CARGAR PROVEEDORES ###############################
	public function CargarProveedores()
	{
		self::SetNames();
		if(empty($_FILES["sel_file"]))
		{
			echo "1";
			exit;
		}
        //Aquí es donde seleccionamos nuestro csv
         $fname = $_FILES['sel_file']['name'];
         //echo 'Cargando nombre del archivo: '.$fname.' ';
         $chk_ext = explode(".",$fname);
         
        if(strtolower(end($chk_ext)) == "csv")
        {
        //si es correcto, entonces damos permisos de lectura para subir
        $filename = $_FILES['sel_file']['tmp_name'];
        $handle = fopen($filename, "r");
        $this->dbh->beginTransaction();
        
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

               //Insertamos los datos con los valores...
			   
		$query = "INSERT INTO proveedores values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codproveedor);
		$stmt->bindParam(2, $documproveedor);
		$stmt->bindParam(3, $dniproveedor);
		$stmt->bindParam(4, $nomproveedor);
		$stmt->bindParam(5, $tlfproveedor);
		$stmt->bindParam(6, $id_provincia);
		$stmt->bindParam(7, $id_departamento);
		$stmt->bindParam(8, $direcproveedor);
		$stmt->bindParam(9, $emailproveedor);
		$stmt->bindParam(10, $vendedor);
		$stmt->bindParam(11, $tlfvendedor);
		$stmt->bindParam(12, $fechaingreso);

		$codproveedor = limpiar($data[0]);
		$documproveedor = limpiar($data[1]);
		$dniproveedor = limpiar($data[2]);
		$nomproveedor = limpiar($data[3]);
		$tlfproveedor = limpiar($data[4]);
		$id_provincia = limpiar($data[5]);
		$id_departamento = limpiar($data[6]);
		$direcproveedor = limpiar($data[7]);
		$emailproveedor = limpiar($data[8]);
		$vendedor = limpiar($data[9]);
		$tlfvendedor = limpiar($data[10]);
		$fechaingreso = limpiar(date("Y-m-d"));
		$stmt->execute();
				
        }
           $this->dbh->commit();
           //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
           fclose($handle);
	        
	echo "<span class='fa fa-check-square-o'></span> LA CARGA MASIVA DE PROVEEDORES FUE REALIZADA EXITOSAMENTE";
	exit;
             
         }
         else
         {
    //si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para ver si esta separado por " , "
         echo "2";
		 exit;
      }  
}
############################# FUNCION CARGAR PROVEEDORES ##############################

############################ FUNCION REGISTRAR PROVEEDORES ##########################
	public function RegistrarProveedores()
	{
		self::SetNames();
		if(empty($_POST["cuitproveedor"]) or empty($_POST["nomproveedor"]) or empty($_POST["direcproveedor"]))
		{
			echo "1";
			exit;
		}

		$sql = "SELECT codproveedor FROM proveedores ORDER BY idproveedor DESC LIMIT 1";
		foreach ($this->dbh->query($sql) as $row){

			$id=$row["codproveedor"];

		}
		if(empty($id))
		{
			$codproveedor = "P1";

		} else {

			$resto = substr($id, 0, 1);
			$coun = strlen($resto);
			$num     = substr($id, $coun);
			$codigo     = $num + 1;
			$codproveedor = "P".$codigo;
		}

		$sql = "SELECT cuitproveedor FROM proveedores WHERE cuitproveedor = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["cuitproveedor"]));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = "INSERT INTO proveedores values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $codproveedor);
		    $stmt->bindParam(2, $documproveedor);
			$stmt->bindParam(3, $cuitproveedor);
			$stmt->bindParam(4, $nomproveedor);
			$stmt->bindParam(5, $tlfproveedor);
			$stmt->bindParam(6, $id_provincia);
			$stmt->bindParam(7, $id_departamento);
			$stmt->bindParam(8, $direcproveedor);
			$stmt->bindParam(9, $emailproveedor);
			$stmt->bindParam(10, $vendedor);
			$stmt->bindParam(11, $tlfvendedor);
			$stmt->bindParam(12, $fechaingreso);
			
			$documproveedor = limpiar($_POST['documproveedor'] == '' ? "0" : $_POST['documproveedor']);
			$cuitproveedor = limpiar($_POST["cuitproveedor"]);
			$nomproveedor = limpiar($_POST["nomproveedor"]);
			$tlfproveedor = limpiar($_POST["tlfproveedor"]);
			$id_provincia = limpiar($_POST['id_provincia'] == '' ? "0" : $_POST['id_provincia']);
			$id_departamento = limpiar($_POST['id_departamento'] == '' ? "0" : $_POST['id_departamento']);
			$direcproveedor = limpiar($_POST["direcproveedor"]);
			$emailproveedor = limpiar($_POST["emailproveedor"]);
			$vendedor = limpiar($_POST["vendedor"]);
			$tlfvendedor = limpiar($_POST["tlfvendedor"]);
		    $fechaingreso = limpiar(date("Y-m-d"));
			$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> EL PROVEEDOR HA SIDO REGISTRADO EXITOSAMENTE";
			exit;

		} else {

			echo "2";
			exit;
		}
	}
########################### FUNCION REGISTRAR PROVEEDORES ########################

########################### FUNCION LISTAR PROVEEDORES ################################
	public function ListarProveedores()
	{
		self::SetNames();
	    $sql = "SELECT
		proveedores.codproveedor,
		proveedores.documproveedor,
		proveedores.cuitproveedor,
		proveedores.nomproveedor,
		proveedores.tlfproveedor,
		proveedores.id_provincia,
		proveedores.id_departamento,
		proveedores.direcproveedor,
		proveedores.emailproveedor,
		proveedores.vendedor,
		proveedores.tlfvendedor,
		proveedores.fechaingreso,
	    documentos.documento,
		provincias.provincia,
		departamentos.departamento
		FROM proveedores 
		LEFT JOIN documentos ON proveedores.documproveedor = documentos.coddocumento
		LEFT JOIN provincias ON proveedores.id_provincia = provincias.id_provincia 
		LEFT JOIN departamentos ON proveedores.id_departamento = departamentos.id_departamento";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################### FUNCION LISTAR PROVEEDORES ################################

########################### FUNCION ID PROVEEDORES #################################
	public function ProveedoresPorId()
	{
		self::SetNames();
		$sql = "SELECT
		proveedores.codproveedor,
		proveedores.documproveedor,
		proveedores.cuitproveedor,
		proveedores.nomproveedor,
		proveedores.tlfproveedor,
		proveedores.id_provincia,
		proveedores.id_departamento,
		proveedores.direcproveedor,
		proveedores.emailproveedor,
		proveedores.vendedor,
		proveedores.tlfvendedor,
		proveedores.fechaingreso,
	    documentos.documento,
		provincias.provincia,
		departamentos.departamento
		FROM proveedores 
		LEFT JOIN documentos ON proveedores.documproveedor = documentos.coddocumento
		LEFT JOIN provincias ON proveedores.id_provincia = provincias.id_provincia 
		LEFT JOIN departamentos ON proveedores.id_departamento = departamentos.id_departamento WHERE proveedores.codproveedor = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codproveedor"])));
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "";
		}
		else
		{
			if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
############################ FUNCION ID PROVEEDORES #################################
	
############################ FUNCION ACTUALIZAR PROVEEDORES ############################
	public function ActualizarProveedores()
	{
	self::SetNames();
		if(empty($_POST["codproveedor"]) or empty($_POST["cuitproveedor"]) or empty($_POST["nomproveedor"]) or empty($_POST["direcproveedor"]))
		{
			echo "1";
			exit;
		}
		$sql = "SELECT cuitproveedor FROM proveedores WHERE codproveedor != ? AND cuitproveedor = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codproveedor"],$_POST["cuitproveedor"]));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$sql = "UPDATE proveedores set "
			." documproveedor = ?, "
			." cuitproveedor = ?, "
			." nomproveedor = ?, "
			." tlfproveedor = ?, "
			." id_provincia = ?, "
			." id_departamento = ?, "
			." direcproveedor = ?, "
			." emailproveedor = ?, "
			." vendedor = ?, "
			." tlfvendedor = ? "
			." WHERE "
			." codproveedor = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $documproveedor);
			$stmt->bindParam(2, $cuitproveedor);
			$stmt->bindParam(3, $nomproveedor);
			$stmt->bindParam(4, $tlfproveedor);
			$stmt->bindParam(5, $id_provincia);
			$stmt->bindParam(6, $id_departamento);
			$stmt->bindParam(7, $direcproveedor);
			$stmt->bindParam(8, $emailproveedor);
			$stmt->bindParam(9, $vendedor);
			$stmt->bindParam(10, $tlfvendedor);
			$stmt->bindParam(11, $codproveedor);
			
			$documproveedor = limpiar($_POST['documproveedor'] == '' ? "0" : $_POST['documproveedor']);
			$cuitproveedor = limpiar($_POST["cuitproveedor"]);
			$nomproveedor = limpiar($_POST["nomproveedor"]);
			$tlfproveedor = limpiar($_POST["tlfproveedor"]);
			$id_provincia = limpiar($_POST['id_provincia'] == '' ? "0" : $_POST['id_provincia']);
			$id_departamento = limpiar($_POST['id_departamento'] == '' ? "0" : $_POST['id_departamento']);
			$direcproveedor = limpiar($_POST["direcproveedor"]);
			$emailproveedor = limpiar($_POST["emailproveedor"]);
			$vendedor = limpiar($_POST["vendedor"]);
			$tlfvendedor = limpiar($_POST["tlfvendedor"]);
			$codproveedor = limpiar($_POST["codproveedor"]);
			$stmt->execute();
        
		echo "<span class='fa fa-check-square-o'></span> EL PROVEEDOR HA SIDO ACTUALIZADO EXITOSAMENTE";
		exit;

		} else {

			echo "2";
			exit;
		}
	}
############################ FUNCION ACTUALIZAR PROVEEDORES ############################

########################## FUNCION ELIMINAR PROVEEDORES #################################
	public function EliminarProveedores()
	{
	self::SetNames();
		if ($_SESSION['acceso'] == "administrador") {

		$sql = "SELECT codproveedor FROM productos WHERE codproveedor = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codproveedor"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM proveedores where codproveedor = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codproveedor);
			$codproveedor = decrypt($_GET["codproveedor"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
########################### FUNCION ELIMINAR PROVEEDORES #########################

############################## FIN DE CLASE PROVEEDORES #################################




























################################# CLASE INGREDIENTES ######################################

############################### FUNCION CARGAR INGREDIENTES ##############################
	public function CargarIngredientes()
	{
		self::SetNames();
		if(empty($_FILES["sel_file"]))
		{
			echo "1";
			exit;
		}

        //Aquí es donde seleccionamos nuestro csv
         $fname = $_FILES['sel_file']['name'];
         //echo 'Cargando nombre del archivo: '.$fname.' ';
         $chk_ext = explode(".",$fname);
         
        if(strtolower(end($chk_ext)) == "csv")
        {
        //si es correcto, entonces damos permisos de lectura para subir
        $filename = $_FILES['sel_file']['tmp_name'];
        $handle = fopen($filename, "r");
        $this->dbh->beginTransaction();
        
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

               //Insertamos los datos con los valores...
        $query = "INSERT INTO ingredientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    	$stmt = $this->dbh->prepare($query);
    	$stmt->bindParam(1, $codingrediente);
    	$stmt->bindParam(2, $nomingrediente);
    	$stmt->bindParam(3, $codmedida);
    	$stmt->bindParam(4, $preciocompra);
    	$stmt->bindParam(5, $precioventa);
    	$stmt->bindParam(6, $cantingrediente);
    	$stmt->bindParam(7, $stockminimo);
    	$stmt->bindParam(8, $stockmaximo);
    	$stmt->bindParam(9, $ivaingrediente);
    	$stmt->bindParam(10, $descingrediente);
		$stmt->bindParam(11, $lote);
    	$stmt->bindParam(12, $fechaexpiracion);
    	$stmt->bindParam(13, $codproveedor);
    	$stmt->bindParam(14, $controlstocki);

    	$codingrediente = limpiar($data[0]);
    	$nomingrediente = limpiar($data[1]);
    	$codmedida = limpiar($data[2]);
    	$preciocompra = limpiar($data[3]);
    	$precioventa = limpiar($data[4]);
    	$cantingrediente = limpiar($data[5]);
    	$stockminimo = limpiar($data[6]);
    	$stockmaximo = limpiar($data[7]);
    	$ivaingrediente = limpiar($data[8]);
    	$descingrediente = limpiar($data[9]);
    	$lote = limpiar($data[10]);
    	$fechaexpiracion = limpiar($data[11]);
    	$codproveedor = limpiar($data[12]);
    	$controlstocki = limpiar($data[13]);
    	$stmt->execute();

        ##################### REGISTRAMOS LOS DATOS DE INGREDIENTES EN KARDEX #####################
		$query = "INSERT INTO kardex_ingredientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codproceso);
		$stmt->bindParam(2, $codresponsable);
		$stmt->bindParam(3, $codingrediente);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaingrediente);
		$stmt->bindParam(10, $descingrediente);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);
		
		$codproceso = limpiar($data[0]);
		$codresponsable = limpiar("0");
		$codproducto = limpiar($data[0]);
		$movimiento = limpiar("ENTRADAS");
		$entradas = limpiar($data[5]);
		$salidas = limpiar("0");
		$devolucion = limpiar("0");
		$stockactual = limpiar($data[5]);
		$ivaingrediente = limpiar($data[8]);
		$descingrediente = limpiar($data[9]);
    	$precio = limpiar($data[4]);
		$documento = limpiar("INVENTARIO INICIAL");
		$fechakardex = limpiar(date("Y-m-d"));
		$stmt->execute();
		##################### REGISTRAMOS LOS DATOS DE INGREDIENTES EN KARDEX #####################
	
        }
           
           $this->dbh->commit();
           //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
           fclose($handle);
	        
	echo "<span class='fa fa-check-square-o'></span> LA CARGA MASIVA DE INGREDIENTES FUE REALIZADA EXITOSAMENTE";
	exit;
             
         }
         else
         {
    //si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para ver si esta separado por " , "
         echo "2";
		 exit;
      }  
}
############################## FUNCION CARGAR INGREDIENTES ##############################

########################### FUNCION REGISTRAR INGREDIENTES ###############################
public function RegistrarIngredientes()
{
	self::SetNames();
	if(empty($_POST["codingrediente"]) or empty($_POST["nomingrediente"]) or empty($_POST["codmedida"]))
	{
		echo "1";
		exit;
	}


	$sql = "SELECT codingrediente FROM ingredientes WHERE codingrediente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codingrediente"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
$query = "INSERT INTO ingredientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codingrediente);
		$stmt->bindParam(2, $nomingrediente);
		$stmt->bindParam(3, $codmedida);
		$stmt->bindParam(4, $preciocompra);
		$stmt->bindParam(5, $precioventa);
		$stmt->bindParam(6, $cantingrediente);
		$stmt->bindParam(7, $stockminimo);
		$stmt->bindParam(8, $stockmaximo);
		$stmt->bindParam(9, $ivaingrediente);
		$stmt->bindParam(10, $descingrediente);
		$stmt->bindParam(11, $lote);
		$stmt->bindParam(12, $fechaexpiracion);
		$stmt->bindParam(13, $codproveedor);
		$stmt->bindParam(14, $controlstocki);

		$codingrediente = limpiar($_POST["codingrediente"]);
		$nomingrediente = limpiar($_POST["nomingrediente"]);
		$codmedida = limpiar($_POST["codmedida"]);
		$preciocompra = limpiar($_POST["preciocompra"]);
		$precioventa = limpiar($_POST["precioventa"]);
		$cantingrediente = limpiar($_POST["cantingrediente"]);
		$stockminimo = limpiar($_POST["stockminimo"]);
		$stockmaximo = limpiar($_POST["stockmaximo"]);
		$ivaingrediente = limpiar($_POST["ivaingrediente"]);
		$descingrediente = limpiar($_POST["descingrediente"]);
		$lote = limpiar($_POST['lote'] == '' ? "0" : $_POST['lote']);
		$fechaexpiracion = limpiar($_POST['fechaexpiracion'] == '' ? "0000-00-00" : date("Y-m-d",strtotime($_POST['fechaexpiracion'])));
		$codproveedor = limpiar($_POST['codproveedor'] == '' ? "0" : $_POST['codproveedor']);
		$controlstocki = limpiar($_POST["controlstocki"]);
		$stmt->execute();

##################### REGISTRAMOS LOS DATOS DE INGREDIENTE EN KARDEX #####################
		$query = "INSERT INTO kardex_ingredientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codproceso);
		$stmt->bindParam(2, $codresponsable);
		$stmt->bindParam(3, $codingrediente);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaingrediente);
		$stmt->bindParam(10, $descingrediente);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);

		$codproceso = limpiar($_POST['codingrediente']);
		$codresponsable = limpiar("0");
		$codingrediente = limpiar($_POST['codingrediente']);
		$movimiento = limpiar("ENTRADAS");
		$entradas = limpiar($_POST['cantingrediente']);
		$salidas = limpiar("0");
		$devolucion = limpiar("0");
		$stockactual = limpiar($_POST['cantingrediente']);
		$ivaingrediente = limpiar($_POST["ivaingrediente"]);
		$descingrediente = limpiar($_POST["descingrediente"]);
		$precio = limpiar($_POST['precioventa']);
		$documento = limpiar("INVENTARIO INICIAL");
		$fechakardex = limpiar(date("Y-m-d"));
		$stmt->execute();
##################### REGISTRAMOS LOS DATOS DE INGREDIENTE EN KARDEX #####################


		echo "<span class='fa fa-check-square-o'></span> EL INGREDIENTE HA SIDO REGISTRADO EXITOSAMENTE";
		exit;

	} else {

		echo "2";
		exit;
	}
}
########################## FUNCION REGISTRAR INGREDIENTES ###############################

########################## FUNCION BUSQUEDA DE INGREDIENTES ###############################
public function BusquedaIngredientes()
	{
	self::SetNames();
	
	$buscar = limpiar($_POST['b']);

	if(empty($buscar)) {
            echo "";
            exit;
    }

    $sql = "SELECT
		ingredientes.idingrediente,
		ingredientes.codingrediente,
		ingredientes.nomingrediente,
		ingredientes.codmedida,
		ingredientes.preciocompra,
		ingredientes.precioventa,
		ingredientes.cantingrediente,
		ingredientes.stockminimo,
		ingredientes.stockmaximo,
		ingredientes.ivaingrediente,
		ingredientes.descingrediente,
		ingredientes.lote,
		ingredientes.fechaexpiracion,
		ingredientes.codproveedor,
		ingredientes.controlstocki,
		medidas.nommedida,
		proveedores.cuitproveedor,
		proveedores.nomproveedor
	FROM (ingredientes INNER JOIN medidas ON ingredientes.codmedida=medidas.codmedida)
	LEFT JOIN proveedores ON ingredientes.codproveedor=proveedores.codproveedor WHERE CONCAT(codingrediente, ' ',nomingrediente, ' ',nommedida) LIKE '%".$buscar."%' LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0) {

	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</div></center>";
	exit;
		
	} else {
			
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################## FUNCION BUSQUEDA DE INGREDIENTES ###############################

########################### FUNCION LISTAR INGREDIENTES ################################
public function ListarIngredientes()
	{
	self::SetNames();
    $sql = "SELECT
	ingredientes.idingrediente,
	ingredientes.codingrediente,
	ingredientes.nomingrediente,
	ingredientes.codmedida,
	ingredientes.preciocompra,
	ingredientes.precioventa,
	ingredientes.cantingrediente,
	ingredientes.stockminimo,
	ingredientes.stockmaximo,
	ingredientes.ivaingrediente,
	ingredientes.descingrediente,
	ingredientes.lote,
	ingredientes.fechaexpiracion,
	ingredientes.codproveedor,
	ingredientes.controlstocki,
	medidas.nommedida,
	proveedores.cuitproveedor,
	proveedores.nomproveedor
	FROM (ingredientes INNER JOIN medidas ON ingredientes.codmedida=medidas.codmedida)
	LEFT JOIN proveedores ON ingredientes.codproveedor=proveedores.codproveedor";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################## FUNCION LISTAR INGREDIENTES ################################

########################### FUNCION LISTAR INGREDIENTES EN STOCK MINIMO ################################
public function ListarIngredientesMinimo()
{
	self::SetNames();
    $sql = "SELECT
	ingredientes.idingrediente,
	ingredientes.codingrediente,
	ingredientes.nomingrediente,
	ingredientes.codmedida,
	ingredientes.preciocompra,
	ingredientes.precioventa,
	ingredientes.cantingrediente,
	ingredientes.stockminimo,
	ingredientes.stockmaximo,
	ingredientes.ivaingrediente,
	ingredientes.descingrediente,
	ingredientes.lote,
	ingredientes.fechaexpiracion,
	ingredientes.codproveedor,
	ingredientes.controlstocki,
	medidas.nommedida,
	proveedores.cuitproveedor,
	proveedores.nomproveedor
	FROM (ingredientes INNER JOIN medidas ON ingredientes.codmedida=medidas.codmedida)
	LEFT JOIN proveedores ON ingredientes.codproveedor=proveedores.codproveedor
	WHERE CAST(ingredientes.cantingrediente AS DECIMAL(10,5)) <= CAST(ingredientes.stockminimo AS DECIMAL(10,5))";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################## FUNCION LISTAR INGREDIENTES EN STOCK MINIMO ################################

########################### FUNCION LISTAR INGREDIENTES EN STOCK MAXIMO ################################
public function ListarIngredientesMaximo()
{
	self::SetNames();
    $sql = "SELECT
	ingredientes.idingrediente,
	ingredientes.codingrediente,
	ingredientes.nomingrediente,
	ingredientes.codmedida,
	ingredientes.preciocompra,
	ingredientes.precioventa,
	ingredientes.cantingrediente,
	ingredientes.stockminimo,
	ingredientes.stockmaximo,
	ingredientes.ivaingrediente,
	ingredientes.descingrediente,
	ingredientes.lote,
	ingredientes.fechaexpiracion,
	ingredientes.codproveedor,
	ingredientes.controlstocki,
	medidas.nommedida,
	proveedores.cuitproveedor,
	proveedores.nomproveedor
	FROM (ingredientes INNER JOIN medidas ON ingredientes.codmedida=medidas.codmedida)
	LEFT JOIN proveedores ON ingredientes.codproveedor=proveedores.codproveedor
	WHERE CAST(ingredientes.cantingrediente AS DECIMAL(10,5)) >= CAST(ingredientes.stockmaximo AS DECIMAL(10,5))";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################## FUNCION LISTAR INGREDIENTES EN STOCK MAXIMO ################################

############################# FUNCION LISTAR INGREDIENTES EN EXTRAS ################################
public function ListarIngredientesModal()
{
	self::SetNames();
    $sql = "SELECT * FROM ingredientes 
    INNER JOIN medidas ON ingredientes.codmedida = medidas.codmedida 
    WHERE ingredientes.cantingrediente != '0.00'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################## FUNCION LISTAR INGREDIENTES EN EXTRAS ################################

############################ FUNCION ID INGREDIENTES #################################
public function IngredientesPorId()
{
	self::SetNames();
	$sql = "SELECT
	ingredientes.idingrediente,
	ingredientes.codingrediente,
	ingredientes.nomingrediente,
	ingredientes.codmedida,
	ingredientes.preciocompra,
	ingredientes.precioventa,
	ingredientes.cantingrediente,
	ingredientes.stockminimo,
	ingredientes.stockmaximo,
	ingredientes.ivaingrediente,
	ingredientes.descingrediente,
	ingredientes.lote,
	ingredientes.fechaexpiracion,
	ingredientes.codproveedor,
	ingredientes.controlstocki,
	medidas.nommedida,
	proveedores.cuitproveedor,
	proveedores.nomproveedor
	FROM (ingredientes INNER JOIN medidas ON ingredientes.codmedida=medidas.codmedida)
	LEFT JOIN proveedores ON ingredientes.codproveedor=proveedores.codproveedor WHERE ingredientes.codingrediente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codingrediente"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID INGREDIENTES #################################

############################ FUNCION VER INGREDIENTES EN PRODUCTOS ############################
public function VerDetallesIngredientes()
{
	self::SetNames();
	$sql ="SELECT 
	productosxingredientes.codproducto, 
	productosxingredientes.cantracion, 
	ingredientes.codingrediente, 
	ingredientes.nomingrediente,
	ingredientes.preciocompra,   
	ingredientes.precioventa, 
	ingredientes.cantingrediente,
	ingredientes.descingrediente, 
	ingredientes.codmedida, 
	medidas.nommedida 
	FROM (productos LEFT JOIN productosxingredientes ON productos.codproducto=productosxingredientes.codproducto) 
	LEFT JOIN ingredientes ON ingredientes.codingrediente=productosxingredientes.codingrediente
	INNER JOIN medidas ON ingredientes.codmedida=medidas.codmedida WHERE productosxingredientes.codproducto = ?";
    $stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codproducto"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "";		
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION VER INGREDIENTES EN PRODUCTOS ############################

############################ FUNCION VER MODAL INGREDIENTES EN PRODUCTOS ############################
public function VerDetallesIngredientesModal()
{
	self::SetNames();
	$sql ="SELECT 
	productosxingredientes.codproducto, 
	productosxingredientes.cantracion, 
	ingredientes.codingrediente, 
	ingredientes.nomingrediente,
	ingredientes.preciocompra,   
	ingredientes.precioventa, 
	ingredientes.cantingrediente,
	ingredientes.descingrediente, 
	ingredientes.codmedida, 
	medidas.nommedida 
	FROM (productos LEFT JOIN productosxingredientes ON productos.codproducto=productosxingredientes.codproducto) 
	LEFT JOIN ingredientes ON ingredientes.codingrediente=productosxingredientes.codingrediente
	INNER JOIN medidas ON ingredientes.codmedida=medidas.codmedida WHERE productosxingredientes.codproducto = ?";
    $stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar($_GET["d_codigo"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "";		
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION VER MODAL INGREDIENTES EN PRODUCTOS ############################

############################ FUNCION ACTUALIZAR INGREDIENTES ############################
public function ActualizarIngredientes()
{
self::SetNames();
	if(empty($_POST["codingrediente"]) or empty($_POST["nomingrediente"]) or empty($_POST["codmedida"]))
	{
		echo "1";
		exit;
	}
	$sql = "SELECT codingrediente FROM ingredientes WHERE idingrediente != ? AND codingrediente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["idingrediente"],$_POST["codingrediente"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$sql = "UPDATE ingredientes set"
		." nomingrediente = ?, "
		." codmedida = ?, "
		." preciocompra = ?, "
		." precioventa = ?, "
		." cantingrediente = ?, "
		." stockminimo = ?, "
		." stockmaximo = ?, "
		." ivaingrediente = ?, "
		." descingrediente = ?, "
		." lote = ?, "
		." fechaexpiracion = ?, "
		." codproveedor = ?, "
		." controlstocki = ? "
		." WHERE "
		." idingrediente = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $nomingrediente);
		$stmt->bindParam(2, $codmedida);
		$stmt->bindParam(3, $preciocompra);
		$stmt->bindParam(4, $precioventa);
		$stmt->bindParam(5, $cantingrediente);
		$stmt->bindParam(6, $stockminimo);
		$stmt->bindParam(7, $stockmaximo);
		$stmt->bindParam(8, $ivaingrediente);
		$stmt->bindParam(9, $descingrediente);
		$stmt->bindParam(10, $lote);
		$stmt->bindParam(11, $fechaexpiracion);
		$stmt->bindParam(12, $codproveedor);
		$stmt->bindParam(13, $controlstocki);
		$stmt->bindParam(14, $idingrediente);

		$nomingrediente = limpiar($_POST["nomingrediente"]);
		$codmedida = limpiar($_POST["codmedida"]);
		$preciocompra = limpiar($_POST["preciocompra"]);
		$precioventa = limpiar($_POST["precioventa"]);
		$cantingrediente = limpiar($_POST["cantingrediente"]);
		$stockminimo = limpiar($_POST["stockminimo"]);
		$stockmaximo = limpiar($_POST["stockmaximo"]);
		$ivaingrediente = limpiar($_POST["ivaingrediente"]);
		$descingrediente = limpiar($_POST["descingrediente"]);
		$lote = limpiar($_POST['lote'] == '' ? "0" : $_POST['lote']);
		$fechaexpiracion = limpiar($_POST['fechaexpiracion'] == '' ? "0000-00-00" : date("Y-m-d",strtotime($_POST['fechaexpiracion'])));
		$codproveedor = limpiar($_POST['codproveedor'] == '' ? "0" : $_POST['codproveedor']);
		$controlstocki = limpiar($_POST["controlstocki"]);
		$codingrediente = limpiar($_POST["codingrediente"]);
		$idingrediente = limpiar($_POST["idingrediente"]);
		$stmt->execute();
    
	echo "<span class='fa fa-check-square-o'></span> EL INGREDIENTE HA SIDO ACTUALIZADO EXITOSAMENTE";
	exit;

	} else {

		echo "2";
		exit;
	}
}
############################ FUNCION ACTUALIZAR INGREDIENTES ############################

########################## FUNCION ELIMINAR DETALLES INGREDIENTES ###########################
public function EliminarDetalleIngrediente()
	{
	self::SetNames();
	if ($_SESSION["acceso"]=="administrador") {

	$sql = "SELECT 
	cantingrediente,
	preciocompra,
	precioventa FROM ingredientes WHERE codingrediente = '".limpiar(decrypt($_GET["codingrediente"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
	$this->p[] = $row;
	}
	$racionbd = decrypt($_GET["cantracion"]);
	$totalracioncompra = $racionbd * $row["preciocompra"];
	$totalracionventa = $racionbd * $row["precioventa"];
    
    $sql = "DELETE FROM productosxingredientes WHERE codproducto = ? and codingrediente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1,$codproducto);
	$stmt->bindParam(2,$codingrediente);
	$codproducto = decrypt($_GET["codproducto"]);
	$codingrediente = decrypt($_GET["codingrediente"]);
	$stmt->execute();

	$sql3 = "SELECT 
	preciocompra,
	precioventa FROM productos WHERE codproducto = '".limpiar(decrypt($_GET["codproducto"]))."'";
	foreach ($this->dbh->query($sql3) as $row3)
	{
	$this->p[] = $row3;
	}
	$preciocomprabd = $row3["preciocompra"];
	$precioventabd = $row3["precioventa"];

	############ ACTUALIZAMOS PRECIO DEL PRODUCTO ################
    $sql2 = " UPDATE productos set "
    ." preciocompra = ?, "
    ." precioventa = ? "
    ." WHERE "
    ." codproducto = ?;
    ";
    $stmt = $this->dbh->prepare($sql2);
    $stmt->bindParam(1, $preciocompra);
    $stmt->bindParam(2, $precioventa);
    $stmt->bindParam(3, $codproducto);

    $preciocompra = number_format($preciocomprabd-$totalracioncompra, 2, '.', '');
    $precioventa = number_format($precioventabd-$totalracionventa, 2, '.', '');
	$codproducto = decrypt($_GET["codproducto"]);
    $stmt->execute();
    ############ ACTUALIZAMOS PRECIO DEL PRODUCTO ################

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
	} 
}
########################## FUNCION ELIMINAR DETALLES INGREDIENTES #################################

########################## FUNCION ELIMINAR INGREDIENTES ###########################
public function EliminarIngredientes()
{
self::SetNames();
	if ($_SESSION["acceso"]=="administrador") {

	$sql = "SELECT codingrediente FROM productosxingredientes WHERE codingrediente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codingrediente"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{

		$sql = "DELETE FROM ingredientes WHERE codingrediente = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codingrediente);
		$codingrediente = decrypt($_GET["codingrediente"]);
		$stmt->execute();

		$sql = "DELETE FROM kardex_ingredientes where codingrediente = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codingrediente);
		$codingrediente = decrypt($_GET["codingrediente"]);
		$stmt->execute();

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
	} 
			
	} else {
		
		echo "3";
		exit;
	}	
}
########################## FUNCION ELIMINAR INGREDIENTES #################################

###################### FUNCION BUSCAR INGREDIENTES FACTURADOS #########################
public function BuscarIngredientesVendidos() 
	{
	self::SetNames();
   $sql = "SELECT 
   productos.idproducto,
   productos.codproducto, 
   productos.producto, 
   productos.codcategoria, 
   ingredientes.precioventa, 
   ingredientes.codingrediente, 
   ingredientes.nomingrediente, 
   ingredientes.cantingrediente, 
   ingredientes.descingrediente, 
   productosxingredientes.cantracion, 
   medidas.nommedida, 
   detalleventas.cantventa, 
   SUM(productosxingredientes.cantracion*detalleventas.cantventa) as cantidad
   FROM (ventas LEFT JOIN detalleventas ON ventas.codventa = detalleventas.codventa)
   LEFT JOIN productos ON detalleventas.idproducto = productos.idproducto
   INNER JOIN productosxingredientes ON productos.codproducto = productosxingredientes.codproducto 
   LEFT JOIN ingredientes ON productosxingredientes.codingrediente = ingredientes.codingrediente 
   LEFT JOIN medidas ON ingredientes.codmedida = medidas.codmedida 
   WHERE DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') BETWEEN ? AND ? 
   GROUP BY ingredientes.codingrediente";

   /*$sql = "SELECT productos.codproducto, productos.producto, productos.codcategoria, productos.precioventa, productos.existencia, ingredientes.costoingrediente, ingredientes.codingrediente, ingredientes.nomingrediente, ingredientes.cantingrediente, productosvsingredientes.cantracion, detalleventas.cantventa, SUM(productosvsingredientes.cantracion*detalleventas.cantventa) as cantidades FROM productos INNER JOIN detalleventas ON productos.codproducto=detalleventas.codproducto INNER JOIN productosvsingredientes ON productos.codproducto=productosvsingredientes.codproducto LEFT JOIN ingredientes ON productosvsingredientes.codingrediente = ingredientes.codingrediente WHERE DATE_FORMAT(detalleventas.fechadetalleventa,'%Y-%m-%d') >= ? AND DATE_FORMAT(detalleventas.fechadetalleventa,'%Y-%m-%d') <= ? GROUP BY ingredientes.codingrediente";

   $sql ="SELECT ingredientes.codingrediente, ingredientes.nomingrediente, ingredientes.codmedida, detalleventas.descproducto, detalleventas.precioventa, productos.existencia, categorias.nomcategoria, ventas.fechaventa, SUM(detalleventas.cantventa) as cantidad 
   FROM (ventas LEFT JOIN detalleventas ON ventas.codventa=detalleventas.codventa) LEFT JOIN productos ON detalleventas.codproducto=productos.codproducto LEFT JOIN categorias ON productos.codcategoria=categorias.codcategoria WHERE DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') >= ? AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') <= ? GROUP BY detalleventas.codproducto, detalleventas.precioventa, detalleventas.descproducto ORDER BY productos.codproducto ASC";*/

	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################### FUNCION INGREDIENTES FACTURADOS ###############################

######################## FUNCION BUSCA KARDEX INGREDIENTES ##########################
public function BuscarKardexIngrediente() 
    {
	self::SetNames();
	$sql ="SELECT * FROM (ingredientes LEFT JOIN kardex_ingredientes ON ingredientes.codingrediente=kardex_ingredientes.codingrediente) 
	LEFT JOIN medidas ON ingredientes.codmedida=medidas.codmedida 
	WHERE kardex_ingredientes.codingrediente = ?";
    $stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_GET["codingrediente"]));
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################## FUNCION BUSCA KARDEX INGREDIENTES #########################

############################### FIN DE CLASE INGREDIENTES ###############################


































################################# CLASE PRODUCTOS ######################################

############################### FUNCION CARGAR PRODUCTOS ##############################
public function CargarProductos()
	{
	self::SetNames();
	if(empty($_FILES["sel_file"]))
	{
		echo "1";
		exit;
	}

    //Aquí es donde seleccionamos nuestro csv
     $fname = $_FILES['sel_file']['name'];
     //echo 'Cargando nombre del archivo: '.$fname.' ';
     $chk_ext = explode(".",$fname);
     
    if(strtolower(end($chk_ext)) == "csv")
    {
    //si es correcto, entonces damos permisos de lectura para subir
    $filename = $_FILES['sel_file']['tmp_name'];
    $handle = fopen($filename, "r");
    $this->dbh->beginTransaction();
    
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

    //Insertamos los datos con los valores...
    $query = "INSERT INTO productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codproducto);
	$stmt->bindParam(2, $producto);
	$stmt->bindParam(3, $codcategoria);
	$stmt->bindParam(4, $preciocompra);
	$stmt->bindParam(5, $precioventa);
	$stmt->bindParam(6, $existencia);
	$stmt->bindParam(7, $stockminimo);
	$stmt->bindParam(8, $stockmaximo);
	$stmt->bindParam(9, $ivaproducto);
	$stmt->bindParam(10, $descproducto);
	$stmt->bindParam(11, $codigobarra);
	$stmt->bindParam(12, $lote);
	$stmt->bindParam(13, $fechaelaboracion);
	$stmt->bindParam(14, $fechaexpiracion);
	$stmt->bindParam(15, $codproveedor);
	$stmt->bindParam(16, $stockteorico);
	$stmt->bindParam(17, $motivoajuste);
	$stmt->bindParam(18, $favorito);
	$stmt->bindParam(19, $controlstockp);

	$codproducto = limpiar($data[0]);
	$producto = limpiar($data[1]);
	$codcategoria = limpiar($data[2]);
	$preciocompra = limpiar($data[3]);
	$precioventa = limpiar($data[4]);
	$existencia = limpiar($data[5]);
	$stockminimo = limpiar($data[6]);
	$stockmaximo = limpiar($data[7]);
	$ivaproducto = limpiar($data[8]);
	$descproducto = limpiar($data[9]);
	$codigobarra = limpiar($data[10]);
	$lote = limpiar($data[11]);
	$fechaelaboracion = limpiar($data[12]);
	$fechaexpiracion = limpiar($data[13]);
	$codproveedor = limpiar($data[14]);
	$stockteorico = limpiar("0");
	$motivoajuste = limpiar("NINGUNO");
	$favorito = limpiar($data[15]);
	$controlstockp = limpiar($data[16]);
	$stmt->execute();

    ##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX #####################
	$query = "INSERT INTO kardex_productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codproceso);
	$stmt->bindParam(2, $codresponsable);
	$stmt->bindParam(3, $codproducto);
	$stmt->bindParam(4, $movimiento);
	$stmt->bindParam(5, $entradas);
	$stmt->bindParam(6, $salidas);
	$stmt->bindParam(7, $devolucion);
	$stmt->bindParam(8, $stockactual);
	$stmt->bindParam(9, $ivaproducto);
	$stmt->bindParam(10, $descproducto);
	$stmt->bindParam(11, $precio);
	$stmt->bindParam(12, $documento);
	$stmt->bindParam(13, $fechakardex);
	
	$codproceso = limpiar($data[0]);
	$codresponsable = limpiar("0");
	$codproducto = limpiar($data[0]);
	$movimiento = limpiar("ENTRADAS");
	$entradas = limpiar($data[5]);
	$salidas = limpiar("0");
	$devolucion = limpiar("0");
	$stockactual = limpiar($data[5]);
	$ivaproducto = limpiar($data[8]);
	$descproducto = limpiar($data[9]);
	$precio = limpiar($data[4]);
	$documento = limpiar("INVENTARIO INICIAL");
	$fechakardex = limpiar(date("Y-m-d"));
	$stmt->execute();
	##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX #####################
	
    }
           
    $this->dbh->commit();
    //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
    fclose($handle);
	        
	echo "<span class='fa fa-check-square-o'></span> LA CARGA MASIVA DE PRODUCTOS FUE REALIZADA EXITOSAMENTE";
	exit;
             
    } else {
    //si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para ver si esta separado por " , "
        echo "2";
		exit;
    }  
}
############################## FUNCION CARGAR PRODUCTOS ##############################

########################### FUNCION REGISTRAR PRODUCTOS ###############################
public function RegistrarProductos()
{
	self::SetNames();
	if(empty($_POST["codproducto"]) or empty($_POST["producto"]) or empty($_POST["codcategoria"]))
	{
		echo "1";
		exit;
	}

	if(!empty($_SESSION["CarritoIngrediente"])){

	############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA #############
	$v = $_SESSION["CarritoIngrediente"];
	for($i=0;$i<count($v);$i++){

		$sql = "SELECT cantingrediente
		FROM ingredientes 
		WHERE codingrediente = '".$v[$i]['txtCodigo']."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		
		$cantingredientebd = $row['cantingrediente'];
		$cantidad = $v[$i]['cantidad'];

        if($cantidad == "" || $cantidad == 0 || $cantidad == 0.00){

		    echo "2";
		    exit();
	    }
	    elseif ($cantidad > $cantingredientebd) 
        { 
		    echo "3";
		    exit;
	    } 
	}
	############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA #############

    }

	$sql = "SELECT codproducto FROM productos WHERE codproducto = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codproducto"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
	$query = "INSERT INTO productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codproducto);
	$stmt->bindParam(2, $producto);
	$stmt->bindParam(3, $codcategoria);
	$stmt->bindParam(4, $preciocompra);
	$stmt->bindParam(5, $precioventa);
	$stmt->bindParam(6, $existencia);
	$stmt->bindParam(7, $stockminimo);
	$stmt->bindParam(8, $stockmaximo);
	$stmt->bindParam(9, $ivaproducto);
	$stmt->bindParam(10, $descproducto);
	$stmt->bindParam(11, $codigobarra);
	$stmt->bindParam(12, $lote);
	$stmt->bindParam(13, $fechaelaboracion);
	$stmt->bindParam(14, $fechaexpiracion);
	$stmt->bindParam(15, $codproveedor);
	$stmt->bindParam(16, $stockteorico);
	$stmt->bindParam(17, $motivoajuste);
	$stmt->bindParam(18, $favorito);
	$stmt->bindParam(19, $controlstockp);

	$codproducto = limpiar($_POST["codproducto"]);
	$producto = limpiar($_POST["producto"]);
	$codcategoria = limpiar($_POST["codcategoria"]);
	$preciocompra = limpiar($_POST["preciocompra"]);
	$precioventa = limpiar($_POST["precioventa"]);
	$existencia = limpiar($_POST["existencia"]);
	$stockminimo = limpiar($_POST["stockminimo"]);
	$stockmaximo = limpiar($_POST["stockmaximo"]);
	$ivaproducto = limpiar($_POST["ivaproducto"]);
	$descproducto = limpiar($_POST["descproducto"]);
	$codigobarra = limpiar($_POST['codigobarra'] == '' ? "0" : $_POST['codigobarra']);
	$lote = limpiar($_POST['lote'] == '' ? "0" : $_POST['lote']);			
	$fechaelaboracion = limpiar($_POST['fechaelaboracion'] == '' ? "0000-00-00" : date("Y-m-d",strtotime($_POST['fechaelaboracion'])));
	$fechaexpiracion = limpiar($_POST['fechaexpiracion'] == '' ? "0000-00-00" : date("Y-m-d",strtotime($_POST['fechaexpiracion'])));
	$codproveedor = limpiar($_POST['codproveedor'] == '' ? "0" : $_POST['codproveedor']);
	$stockteorico = limpiar("0");
	$motivoajuste = limpiar("NINGUNO");
	$favorito = limpiar($_POST["favorito"]);
	$controlstockp = limpiar($_POST["controlstockp"]);
	$stmt->execute();

	##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX #####################
	$query = "INSERT INTO kardex_productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codproceso);
	$stmt->bindParam(2, $codresponsable);
	$stmt->bindParam(3, $codproducto);
	$stmt->bindParam(4, $movimiento);
	$stmt->bindParam(5, $entradas);
	$stmt->bindParam(6, $salidas);
	$stmt->bindParam(7, $devolucion);
	$stmt->bindParam(8, $stockactual);
	$stmt->bindParam(9, $ivaproducto);
	$stmt->bindParam(10, $descproducto);
	$stmt->bindParam(11, $precio);
	$stmt->bindParam(12, $documento);
	$stmt->bindParam(13, $fechakardex);

	$codproceso = limpiar($_POST['codproducto']);
	$codresponsable = limpiar("0");
	$codproducto = limpiar($_POST['codproducto']);
	$movimiento = limpiar("ENTRADAS");
	$entradas = limpiar($_POST['existencia']);
	$salidas = limpiar("0");
	$devolucion = limpiar("0");
	$stockactual = limpiar($_POST['existencia']);
	$ivaproducto = limpiar($_POST["ivaproducto"]);
	$descproducto = limpiar($_POST["descproducto"]);
	$precio = limpiar($_POST['precioventa']);
	$documento = limpiar("INVENTARIO INICIAL");
	$fechakardex = limpiar(date("Y-m-d"));
	$stmt->execute();
	##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX #####################

	##################  SUBIR FOTO DE PRODUCTO ######################################
    //datos del arhivo  
    if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo =''; }
    if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo =''; }
    if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo =''; } 
    //compruebo si las características del archivo son las que deseo  
    if ((strpos($tipo_archivo,'image/jpeg')!==false)&&$tamano_archivo<200000) 
    {  
    if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/productos/".$nombre_archivo) && rename("fotos/productos/".$nombre_archivo,"fotos/productos/".$codproducto.".jpg"))
	{ 
	## se puede dar un aviso
	} 
	## se puede dar otro aviso 
	}
	##################  FINALIZA SUBIR FOTO DE PRODUCTO ######################################

	if(!empty($_SESSION["CarritoIngrediente"])){

	################## PROCESO DE REGISTRO DE INSCREDIENTES A PRODUCTOS ####################
	$this->dbh->beginTransaction();

	$detalle = $_SESSION["CarritoIngrediente"];
	for($i=0;$i<count($detalle);$i++){

		$query = " INSERT INTO productosxingredientes values (null, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codproducto);
		$stmt->bindParam(2, $codingrediente);
		$stmt->bindParam(3, $cantidad);
		
		$codproducto = limpiar($_POST["codproducto"]);
		$codingrediente = limpiar($detalle[$i]['txtCodigo']);
		$cantidad = number_format($detalle[$i]['cantidad'], 2, '.', '');
		$stmt->execute();
	}
	unset($_SESSION["CarritoIngrediente"]);
    $this->dbh->commit();
	################### PROCESO DE REGISTRO DE INSCREDIENTES A PRODUCTOS ##################

    }
		echo "<span class='fa fa-check-square-o'></span> EL PRODUCTO HA SIDO REGISTRADO EXITOSAMENTE";
		exit;

	} else {

		echo "4";
		exit;
	}
}
########################## FUNCION REGISTRAR PRODUCTOS ###############################

########################## FUNCION BUSQUEDA DE PRODUCTOS ###############################
public function BusquedaProductos()
	{
	self::SetNames();
	
	$buscar = limpiar($_POST['b']);

	if(empty($buscar)) {
            echo "";
            exit;
    }

    $sql = "SELECT
	productos.idproducto,
	productos.codproducto,
	productos.producto,
	productos.codcategoria,
	productos.preciocompra,
	productos.precioventa,
	productos.existencia,
	productos.stockminimo,
	productos.stockmaximo,
	productos.ivaproducto,
	productos.descproducto,
	productos.codigobarra,
	productos.lote,
	productos.fechaelaboracion,
	productos.fechaexpiracion,
	productos.codproveedor,
	productos.stockteorico,
	productos.motivoajuste,
	productos.favorito,
	productos.controlstockp,
	categorias.nomcategoria,
	proveedores.cuitproveedor,
	proveedores.nomproveedor
	FROM (productos LEFT JOIN categorias ON productos.codcategoria=categorias.codcategoria)
	LEFT JOIN proveedores ON productos.codproveedor=proveedores.codproveedor 
	WHERE CONCAT(codproducto, ' ',producto, ' ',nomcategoria) LIKE '%".$buscar."%' LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0) {

	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</div></center>";
	exit;
		
	} else {
			
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################## FUNCION BUSQUEDA DE PRODUCTOS ###############################

########################### FUNCION LISTAR PRODUCTOS ################################
	public function ListarProductos()
	{
		self::SetNames();
        $sql = "SELECT
		productos.idproducto,
		productos.codproducto,
		productos.producto,
		productos.codcategoria,
		productos.preciocompra,
		productos.precioventa,
		productos.existencia,
		productos.stockminimo,
		productos.stockmaximo,
		productos.ivaproducto,
		productos.descproducto,
		productos.codigobarra,
		productos.lote,
		productos.fechaelaboracion,
		productos.fechaexpiracion,
		productos.codproveedor,
		productos.stockteorico,
		productos.motivoajuste,
		productos.favorito,
		productos.controlstockp,
		categorias.nomcategoria,
		proveedores.cuitproveedor,
		proveedores.nomproveedor
	FROM (productos INNER JOIN categorias ON productos.codcategoria=categorias.codcategoria)
	LEFT JOIN proveedores ON productos.codproveedor=proveedores.codproveedor";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################## FUNCION LISTAR PRODUCTOS ################################

########################### FUNCION LISTAR PRODUCTOS FAVORITOS ################################
public function ListarProductosFavoritos()
{
	self::SetNames();
    $sql = "SELECT
	productos.idproducto,
	productos.codproducto,
	productos.producto,
	productos.codcategoria,
	productos.preciocompra,
	productos.precioventa,
	productos.existencia,
	productos.ivaproducto,
	productos.descproducto,
	categorias.nomcategoria
	FROM productos INNER JOIN categorias ON productos.codcategoria=categorias.codcategoria WHERE productos.favorito = 1";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################## FUNCION LISTAR PRODUCTOS FAVORITOS ################################

########################### FUNCION LISTAR PRODUCTOS EN STOCK MINIMO ################################
public function ListarProductosMinimo()
{
	self::SetNames();
    $sql = "SELECT
	productos.idproducto,
	productos.codproducto,
	productos.producto,
	productos.codcategoria,
	productos.preciocompra,
	productos.precioventa,
	productos.existencia,
	productos.stockminimo,
	productos.stockmaximo,
	productos.ivaproducto,
	productos.descproducto,
	productos.codigobarra,
	productos.lote,
	productos.fechaelaboracion,
	productos.fechaexpiracion,
	productos.codproveedor,
	productos.stockteorico,
	productos.motivoajuste,
	productos.favorito,
	productos.controlstockp,
	categorias.nomcategoria,
	proveedores.cuitproveedor,
	proveedores.nomproveedor
	FROM (productos INNER JOIN categorias ON productos.codcategoria=categorias.codcategoria)
	LEFT JOIN proveedores ON productos.codproveedor=proveedores.codproveedor
	WHERE CAST(productos.existencia AS DECIMAL(10,5)) <= CAST(productos.stockminimo AS DECIMAL(10,5))";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################## FUNCION LISTAR PRODUCTOS EN STOCK MINIMO ################################

########################### FUNCION LISTAR PRODUCTOS EN STOCK MAXIMO ################################
public function ListarProductosMaximo()
{
	self::SetNames();
    $sql = "SELECT
	productos.idproducto,
	productos.codproducto,
	productos.producto,
	productos.codcategoria,
	productos.preciocompra,
	productos.precioventa,
	productos.existencia,
	productos.stockminimo,
	productos.stockmaximo,
	productos.ivaproducto,
	productos.descproducto,
	productos.codigobarra,
	productos.lote,
	productos.fechaelaboracion,
	productos.fechaexpiracion,
	productos.codproveedor,
	productos.stockteorico,
	productos.motivoajuste,
	productos.favorito,
	categorias.nomcategoria,
	proveedores.cuitproveedor,
	proveedores.nomproveedor
	FROM (productos INNER JOIN categorias ON productos.codcategoria=categorias.codcategoria)
	LEFT JOIN proveedores ON productos.codproveedor=proveedores.codproveedor
	WHERE CAST(productos.existencia AS DECIMAL(10,5)) >= CAST(productos.stockmaximo AS DECIMAL(10,5))";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################## FUNCION LISTAR PRODUCTOS EN STOCK MAXIMO ################################

############################# FUNCION LISTAR PRODUCTOS ################################
public function ListarProductosModal()
{
	self::SetNames();
    $sql = "SELECT * FROM productos 
    INNER JOIN categorias ON productos.codcategoria=categorias.codcategoria WHERE productos.existencia != '0.00'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################## FUNCION LISTAR PRODUCTOS ################################

############################# FUNCION LISTAR PRODUCTOS PARA MENU ################################
public function ListarProductosMenu()
	{
	self::SetNames();
    $sql = "SELECT
	categorias.nomcategoria, 
	GROUP_CONCAT(codproducto, '|', producto, '|', preciocompra, '|', precioventa, '|', existencia SEPARATOR '<br>') AS menu
	FROM productos 
    INNER JOIN categorias ON productos.codcategoria=categorias.codcategoria
    GROUP BY productos.codcategoria";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################## FUNCION LISTAR PRODUCTOS PARA MENU ################################

############################ FUNCION ID PRODUCTOS #################################
public function ProductosPorId()
{
	self::SetNames();
	$sql = "SELECT
	productos.idproducto,
	productos.codproducto,
	productos.producto,
	productos.codcategoria,
	productos.preciocompra,
	productos.precioventa,
	productos.existencia,
	productos.stockminimo,
	productos.stockmaximo,
	productos.ivaproducto,
	productos.descproducto,
	productos.codigobarra,
	productos.lote,
	productos.fechaelaboracion,
	productos.fechaexpiracion,
	productos.codproveedor,
	productos.stockteorico,
	productos.motivoajuste,
	productos.favorito,
	productos.controlstockp,
	categorias.nomcategoria,
	proveedores.cuitproveedor,
	proveedores.nomproveedor
	FROM (productos LEFT JOIN categorias ON productos.codcategoria=categorias.codcategoria)
	LEFT JOIN proveedores ON productos.codproveedor=proveedores.codproveedor 
	WHERE productos.codproducto = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codproducto"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID PRODUCTOS #################################

############################ FUNCION VER PRODUCTOS EN COMBOS ############################
public function VerDetallesProductos()
{
	self::SetNames();
	$sql ="SELECT 
	combosxproductos.codcombo, 
	combosxproductos.cantidad, 
	productos.codproducto, 
	productos.producto, 
	productos.preciocompra,  
	productos.precioventa, 
	productos.existencia,
	productos.descproducto, 
	productos.codcategoria, 
	categorias.nomcategoria 
	FROM (combos LEFT JOIN combosxproductos ON combos.codcombo = combosxproductos.codcombo) 
	LEFT JOIN productos ON combosxproductos.codproducto = productos.codproducto
	INNER JOIN categorias ON productos.codcategoria = categorias.codcategoria 
	WHERE combosxproductos.codcombo = ?";
    $stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcombo"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "";		
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION VER PRODUCTOS EN COMBOS ############################

############################ FUNCION VER MODAL PRODUCTOS EN COMBOS ############################
public function VerDetallesProductosModal()
{
	self::SetNames();
	$sql ="SELECT 
	combosxproductos.codcombo, 
	combosxproductos.cantidad, 
	productos.codproducto, 
	productos.producto, 
	productos.preciocompra,  
	productos.precioventa, 
	productos.existencia,
	productos.descproducto, 
	productos.codcategoria, 
	categorias.nomcategoria 
	FROM (combos LEFT JOIN combosxproductos ON combos.codcombo = combosxproductos.codcombo) 
	LEFT JOIN productos ON combosxproductos.codproducto = productos.codproducto
	INNER JOIN categorias ON productos.codcategoria = categorias.codcategoria 
	WHERE combosxproductos.codcombo = ?";
    $stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar($_GET["d_codigo"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "";		
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION VER MODAL PRODUCTOS EN COMBOS ############################

############################ FUNCION ID PRODUCTOS #################################
public function DetallesProductoPorId()
{
	self::SetNames();
	$sql = "SELECT
	productos.idproducto,
	productos.codproducto,
	productos.producto,
	productos.codcategoria,
	productos.preciocompra,
	productos.precioventa,
	productos.existencia,
	productos.stockminimo,
	productos.stockmaximo,
	productos.ivaproducto,
	productos.descproducto,
	productos.codigobarra,
	productos.lote,
	productos.fechaelaboracion,
	productos.fechaexpiracion,
	productos.codproveedor,
	productos.stockteorico,
	productos.motivoajuste,
	productos.favorito,
	productos.controlstockp,
	categorias.nomcategoria,
	proveedores.cuitproveedor,
	proveedores.nomproveedor
	FROM (productos LEFT JOIN categorias ON productos.codcategoria=categorias.codcategoria)
	LEFT JOIN proveedores ON productos.codproveedor=proveedores.codproveedor 
	WHERE productos.codproducto = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar($_GET["d_codigo"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID PRODUCTOS #################################

############################ FUNCION ACTUALIZAR PRODUCTOS ############################
public function ActualizarProductos()
	{
	self::SetNames();
	if(empty($_POST["codproducto"]) or empty($_POST["producto"]) or empty($_POST["codcategoria"]))
	{
		echo "1";
		exit;
	}

	################## PROCESO DE REGISTRO DE INSCREDIENTES A PRODUCTOS ####################
	$this->dbh->beginTransaction();
	if (isset($_POST["codingrediente"])) {
	    for($i=0;$i<count($_POST['codingrediente']);$i++){  //recorro el array
		   if (!empty($_POST['codingrediente'][$i])) {

		        if($_POST['cantidad'][$i] == "" || $_POST['cantidad'][$i] == 0 || $_POST['cantidad'][$i] == 0.00){

		            echo "2";
		            exit();
	            }
		   }
       }
	}
	$this->dbh->commit();
	################### PROCESO DE REGISTRO DE INSCREDIENTES A PRODUCTOS ##################

	$sql = "SELECT codproducto FROM productos WHERE idproducto != ? AND codproducto = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["idproducto"],$_POST["codproducto"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$sql = "UPDATE productos set"
		." producto = ?, "
		." codcategoria = ?, "
		." preciocompra = ?, "
		." precioventa = ?, "
		." existencia = ?, "
		." stockminimo = ?, "
		." stockmaximo = ?, "
		." ivaproducto = ?, "
		." descproducto = ?, "
		." codigobarra = ?, "
		." lote = ?, "
		." fechaelaboracion = ?, "
		." fechaexpiracion = ?, "
		." codproveedor = ?, "
		." favorito = ?, "
		." controlstockp = ? "
		." WHERE "
		." idproducto = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $producto);
		$stmt->bindParam(2, $codcategoria);
		$stmt->bindParam(3, $preciocompra);
		$stmt->bindParam(4, $precioventa);
		$stmt->bindParam(5, $existencia);
		$stmt->bindParam(6, $stockminimo);
		$stmt->bindParam(7, $stockmaximo);
		$stmt->bindParam(8, $ivaproducto);
		$stmt->bindParam(9, $descproducto);
		$stmt->bindParam(10, $codigobarra);
		$stmt->bindParam(11, $lote);
		$stmt->bindParam(12, $fechaelaboracion);
		$stmt->bindParam(13, $fechaexpiracion);
		$stmt->bindParam(14, $codproveedor);
		$stmt->bindParam(15, $favorito);
		$stmt->bindParam(16, $controlstockp);
		$stmt->bindParam(17, $idproducto);

		$producto = limpiar($_POST["producto"]);
		$codcategoria = limpiar($_POST["codcategoria"]);
		$preciocompra = limpiar($_POST["preciocompra"]);
		$precioventa = limpiar($_POST["precioventa"]);
		$existencia = limpiar($_POST["existencia"]);
		$stockminimo = limpiar($_POST["stockminimo"]);
		$stockmaximo = limpiar($_POST["stockmaximo"]);
		$ivaproducto = limpiar($_POST["ivaproducto"]);
		$descproducto = limpiar($_POST["descproducto"]);
		$codigobarra = limpiar($_POST['codigobarra'] == '' ? "0" : $_POST['codigobarra']);
		$lote = limpiar($_POST['lote'] == '' ? "0" : $_POST['lote']);			
		$fechaelaboracion = limpiar($_POST['fechaelaboracion'] == '' ? "0000-00-00" : date("Y-m-d",strtotime($_POST['fechaelaboracion'])));
		$fechaexpiracion = limpiar($_POST['fechaexpiracion'] == '' ? "0000-00-00" : date("Y-m-d",strtotime($_POST['fechaexpiracion'])));
		$codproveedor = limpiar($_POST['codproveedor'] == '' ? "0" : $_POST['codproveedor']);
		$favorito = limpiar($_POST["favorito"]);
		$controlstockp = limpiar($_POST["controlstockp"]);
		$codproducto = limpiar($_POST["codproducto"]);
		$idproducto = limpiar($_POST["idproducto"]);
		$stmt->execute();

		$sql = "DELETE FROM productosxingredientes WHERE codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codproducto);
		$codproducto = limpiar($_POST["codproducto"]);
		$stmt->execute();

	##################  SUBIR FOTO DE PRODUCTO ######################################
         //datos del arhivo  
if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo =''; }
if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo =''; }
if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo =''; } 
         //compruebo si las características del archivo son las que deseo  
if ((strpos($tipo_archivo,'image/jpeg')!==false)&&$tamano_archivo<200000) 
		 {  
if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/productos/".$nombre_archivo) && rename("fotos/productos/".$nombre_archivo,"fotos/productos/".$codproducto.".jpg"))
		 { 
		 ## se puede dar un aviso
		 } 
		 ## se puede dar otro aviso 
		 }
	################## FINALIZA SUBIR FOTO DE PRODUCTO ##########################

	################## PROCESO DE REGISTRO DE INSCREDIENTES A PRODUCTOS ####################
	if (isset($_POST["codingrediente"])) {
	    for($i=0;$i<count($_POST['codingrediente']);$i++){  //recorro el array
		   if (!empty($_POST['codingrediente'][$i])) {

			$query = "INSERT INTO productosxingredientes values (null, ?, ?, ?); ";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $codproducto);
			$stmt->bindParam(2, $codingrediente);
			$stmt->bindParam(3, $cantidad);

			$codproducto = limpiar($_POST["codproducto"]);
			$codingrediente = limpiar($_POST['codingrediente'][$i]);
			$cantidad = limpiar($_POST['cantidad'][$i]);
			$stmt->execute();
		   }
       }
	}
	################### PROCESO DE REGISTRO DE INSCREDIENTES A PRODUCTOS ##################
        
	echo "<span class='fa fa-check-square-o'></span> EL PRODUCTO HA SIDO ACTUALIZADO EXITOSAMENTE";
	exit;

	} else {

		echo "3";
		exit;
	}
}
############################ FUNCION ACTUALIZAR PRODUCTOS ############################

############################ FUNCION AGREGAR INGREDIENTES A PRODUCTOS ############################
public function AgregarIngredientes()
	{
	self::SetNames();
	if(empty($_POST["codproducto"]) or empty($_SESSION["CarritoIngrediente"]))
	{
		echo "1";
		exit;
	}

	############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA #############
	$v = $_SESSION["CarritoIngrediente"];
	for($i=0;$i<count($v);$i++){

		$sql = "SELECT cantingrediente
		FROM ingredientes 
		WHERE codingrediente = '".$v[$i]['txtCodigo']."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		
		$cantingredientebd = $row['cantingrediente'];
		$cantidad = $v[$i]['cantidad'];

        if($cantidad == "" || $cantidad == 0 || $cantidad == 0.00){

		    echo "2";
		    exit();
	    }
	    elseif ($cantidad > $cantingredientebd) 
        { 
		    echo "3";
		    exit;
	    }
	}
	############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA #############

	################## PROCESO DE REGISTRO DE INSCREDIENTES A PRODUCTOS ####################
	$this->dbh->beginTransaction();

	$detalle = $_SESSION["CarritoIngrediente"];
	for($i=0;$i<count($detalle);$i++){

		$sql = "SELECT 
		codproducto, 
		codingrediente 
		FROM productosxingredientes 
		WHERE codproducto = '".limpiar($_POST['codproducto'])."' 
		AND codingrediente = '".limpiar($detalle[$i]['txtCodigo'])."'";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num == 0)
		{

		$query = " INSERT INTO productosxingredientes values (null, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codproducto);
		$stmt->bindParam(2, $codingrediente);
		$stmt->bindParam(3, $cantidad);
		
		$codproducto = limpiar($_POST["codproducto"]);
		$codingrediente = limpiar($detalle[$i]['txtCodigo']);
		$cantidad = number_format($detalle[$i]['cantidad'], 2, '.', '');
		$stmt->execute();

		} else {

		$sql = "SELECT 
		cantracion 
		FROM productosxingredientes 
		WHERE codproducto = '".limpiar($_POST['codproducto'])."' 
		AND codingrediente = '".limpiar($detalle[$i]['txtCodigo'])."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$racionbd = $row['cantracion'];

		$query = "UPDATE productosxingredientes set"
		." cantracion = ? "
		." WHERE "
		." codproducto = ? AND codingrediente = ?;
		";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $cantracion);
		$stmt->bindParam(2, $codproducto);
		$stmt->bindParam(3, $codingrediente);

		$cantracion = limpiar($racionbd+$detalle[$i]['cantidad']);
		$codproducto = limpiar($_POST["codproducto"]);
		$codingrediente = limpiar($detalle[$i]['txtCodigo']);
		$stmt->execute();

		}
	}
	unset($_SESSION["CarritoIngrediente"]);
    $this->dbh->commit();
	################### PROCESO DE REGISTRO DE INSCREDIENTES A PRODUCTOS ##################

	############## ACTUALIZAMOS LOS PRECIO DEL PRODUCTO ###################
    $sql2 = " UPDATE productos set "
    ." preciocompra = ?, "
    ." precioventa = ? "
    ." WHERE "
    ." codproducto = ?;
    ";
    $stmt = $this->dbh->prepare($sql2);
    $stmt->bindParam(1, $preciocompra);
    $stmt->bindParam(2, $precioventa);
    $stmt->bindParam(3, $codproducto);

    $preciocompra = number_format($_POST["preciocomprabd"]+$_POST["preciocompra"], 2, '.', '');
    $precioventa = number_format($_POST["precioventabd"]+$_POST["precioventa"], 2, '.', '');
	$codproducto = limpiar($_POST["codproducto"]);
    $stmt->execute();
    ############## ACTUALIZAMOS LOS PRECIO DEL PRODUCTO ###################
        
	echo "<span class='fa fa-check-square-o'></span> LOS INGREDIENTES FUERON AGREGADOS AL PRODUCTO EXITOSAMENTE";
	exit;
}
############################ FUNCION AGREGAR INGREDIENTES A PRODUCTOS ############################

########################## FUNCION AJUSTAR STOCK DE PRODUCTOS ###########################
public function SumarStockProducto()
{
	self::SetNames();
	if(empty($_POST["idproducto"]) or empty($_POST["cantidad"]))
	{
		echo "1";
	    exit;
	}
	elseif($_POST["cantidad"] == 0 || $_POST["cantidad"] == 0.00){

		echo "2";
		exit();
	}

	################ OBTENGO EXISTENCIA DE PRODUCTO ################
	$sql = "SELECT
	codproducto,
	producto,
	existencia,
	precioventa,
	ivaproducto, 
	descproducto 
	FROM productos 
	WHERE idproducto = '".limpiar($_POST['idproducto'])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$codproductobd = $row['codproducto'];
	$productobd = $row['producto'];
	$existenciabd = $row['existencia'];
	$precioventabd = $row['precioventa'];
	$ivaproductobd = $row['ivaproducto'];
	$descproductobd = $row['descproducto'];
    ################ OBTENGO EXISTENCIA DE PRODUCTO ################
	
	################ ACTUALIZO EXISTENCIA DE PRODUCTO ################
	$sql = "UPDATE productos set"
		  ." existencia = ? "
		  ." where "
		  ." idproducto = ?;
		   ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $existencia);
	$stmt->bindParam(2, $idproducto);
	
	$existencia = number_format($_POST["cantidad"] + $existenciabd, 2, '.', '');
	$idproducto = limpiar($_POST["idproducto"]);
	$stmt->execute();
	################ ACTUALIZO EXISTENCIA DE PRODUCTO ################

	##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX #####################
	$query = "INSERT INTO kardex_productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codproceso);
	$stmt->bindParam(2, $codresponsable);
	$stmt->bindParam(3, $codproducto);
	$stmt->bindParam(4, $movimiento);
	$stmt->bindParam(5, $entradas);
	$stmt->bindParam(6, $salidas);
	$stmt->bindParam(7, $devolucion);
	$stmt->bindParam(8, $stockactual);
	$stmt->bindParam(9, $ivaproducto);
	$stmt->bindParam(10, $descproducto);
	$stmt->bindParam(11, $precio);
	$stmt->bindParam(12, $documento);
	$stmt->bindParam(13, $fechakardex);

	$codproceso = limpiar($codproductobd);
	$codresponsable = limpiar("0");
	$codproducto = limpiar($codproductobd);
	$movimiento = limpiar("ENTRADAS");
	$entradas = limpiar($_POST['cantidad']);
	$salidas = limpiar("0");
	$devolucion = limpiar("0");
	$stockactual = number_format($_POST["cantidad"] + $existenciabd, 2, '.', '');
	$ivaproducto = limpiar($ivaproductobd);
	$descproducto = limpiar($descproductobd);
	$precio = limpiar($precioventabd);
	$documento = limpiar("SUMA DE STOCK");
	$fechakardex = limpiar(date("Y-m-d"));
	$stmt->execute();
    ##################### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX #####################

	echo "<span class='fa fa-check-square-o'></span> LA CANTIDAD FUE SUMADA AL STOCK DEL PRODUCTO EXITOSAMENTE";
	exit;
}
###################### FUNCION AJUSTAR STOCK DE PRODUCTOS #########################

########################## FUNCION AJUSTAR STOCK DE PRODUCTOS ###########################
public function ActualizarAjuste()
{
self::SetNames();
	if(empty($_POST["codproducto"]) or empty($_POST["stockteorico"]) or empty($_POST["motivoajuste"]))
	{
		echo "1";
	    exit;
	}
	
	$sql = "UPDATE productos set"
		  ." stockteorico = ?, "
		  ." motivoajuste = ? "
		  ." WHERE "
		  ." idproducto = ?;
		   ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $stockteorico);
	$stmt->bindParam(2, $motivoajuste);
    $stmt->bindParam(3, $idproducto);
	
	$stockteorico = limpiar($_POST["stockteorico"]);
	$motivoajuste = limpiar($_POST["motivoajuste"]);
	$idproducto = limpiar($_POST["idproducto"]);
	$stmt->execute();

	echo "<span class='fa fa-check-square-o'></span> EL AJUSTE DE STOCK DEL PRODUCTO SE HA REALIZADO EXITOSAMENTE";
	exit;
}
###################### FUNCION AJUSTAR STOCK DE PRODUCTOS #########################

########################## FUNCION ELIMINAR PRODUCTOS ###########################
public function EliminarProductos()
{
self::SetNames();
	if ($_SESSION["acceso"]=="administrador") {

	$sql = "SELECT codproducto FROM detalleventas WHERE codproducto = ? AND tipo = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codproducto"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{

		$sql = "DELETE FROM productos WHERE codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codproducto);
		$codproducto = decrypt($_GET["codproducto"]);
		$stmt->execute();

		$sql = "DELETE FROM kardex_productos where codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codproducto);
		$codproducto = decrypt($_GET["codproducto"]);
		$stmt->execute();

		$codproducto = decrypt($_GET["codproducto"]);
		if (file_exists("fotos/productos/".$codproducto.".jpg")){
	    //funcion para eliminar una carpeta con contenido
		$archivos = "fotos/productos/".$codproducto.".jpg";		
		unlink($archivos);
		}

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
	} 
			
	} else {
		
		echo "3";
		exit;
	}	
}
########################## FUNCION ELIMINAR PRODUCTOS #################################

###################### FUNCION BUSCAR PRODUCTOS FACTURADOS #########################
public function BuscarProductosVendidos() 
    {
	self::SetNames();
	$sql ="SELECT
	detalleventas.idproducto, 
	detalleventas.codproducto,
	detalleventas.producto,
	detalleventas.descproducto,
	detalleventas.ivaproducto,
	detalleventas.preciocompra, 
	detalleventas.precioventa, 
	productos.codcategoria,
	productos.existencia,
	categorias.nomcategoria, 
	ventas.fechaventa,
	SUM(detalleventas.cantventa) as cantidad
	FROM (ventas INNER JOIN detalleventas ON ventas.codventa = detalleventas.codventa) 
	LEFT JOIN productos ON detalleventas.idproducto = productos.idproducto  
	LEFT JOIN categorias ON productos.codcategoria=categorias.codcategoria 
	WHERE DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') BETWEEN ? AND ?
	AND detalleventas.tipo = 1
	GROUP BY detalleventas.codproducto, detalleventas.precioventa, detalleventas.descproducto 
	ORDER BY detalleventas.codproducto ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################### FUNCION PRODUCTOS FACTURADOS ###############################

######################## FUNCION BUSCA KARDEX PRODUCTOS ##########################
public function BuscarKardexProducto() 
    {
	self::SetNames();
	$sql ="SELECT * FROM (productos LEFT JOIN kardex_productos ON productos.codproducto=kardex_productos.codproducto) 
	LEFT JOIN categorias ON productos.codcategoria=categorias.codcategoria 
	LEFT JOIN proveedores ON productos.codproveedor=proveedores.codproveedor 
	WHERE kardex_productos.codproducto = ?";
    $stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_GET["codproducto"]));
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################## FUNCION BUSCA KARDEX PRODUCTOS #########################

###################### FUNCION KARDEX PRODUCTOS POR FECHAS #########################
public function BuscarKardexProductosValorizadoxFechas() 
{
	self::SetNames();
	$sql ="SELECT
	detalleventas.idproducto, 
	detalleventas.codproducto,
	detalleventas.producto,
	detalleventas.descproducto,
	detalleventas.ivaproducto,
	detalleventas.preciocompra, 
	detalleventas.precioventa,
	productos.codcategoria,
	productos.existencia,
	categorias.nomcategoria, 
	ventas.fechaventa,
	SUM(detalleventas.cantventa) as cantidad 
	FROM (ventas INNER JOIN detalleventas ON ventas.codventa = detalleventas.codventa) 
	LEFT JOIN productos ON detalleventas.idproducto = productos.idproducto
	LEFT JOIN categorias ON productos.codcategoria = categorias.codcategoria
	WHERE DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') >= ? 
	AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') <= ? 
	AND detalleventas.tipo = 1
	GROUP BY detalleventas.codproducto, detalleventas.precioventa, detalleventas.descproducto 
	ORDER BY detalleventas.codproducto ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################### FUNCION KARDEX PRODUCTOS POR FECHAS ###############################

############################### FIN DE CLASE PRODUCTOS ###############################


































################################# CLASE COMBOS ######################################

########################### FUNCION REGISTRAR PRODUCTOS ###############################
public function RegistrarCombos()
	{
	self::SetNames();
	if(empty($_POST["codcombo"]) or empty($_POST["nomcombo"]) or empty($_POST["existencia"]))
	{
		echo "1";
		exit;
	}

	if(!empty($_SESSION["CarritoProducto"])){

	############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA #############
	$v = $_SESSION["CarritoProducto"];
	for($i=0;$i<count($v);$i++){

		$sql = "SELECT existencia
		FROM productos 
		WHERE codproducto = '".$v[$i]['txtCodigo']."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		
		$cantproductobd = $row['existencia'];
		$cantidad = $v[$i]['cantidad'];

        if($cantidad == "" || $cantidad == 0 || $cantidad == 0.00){

		    echo "2";
		    exit();
	    }
	    elseif ($cantidad > $cantproductobd) 
        { 
		    echo "3";
		    exit;
	    } 
	}
	############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA #############

    }

	$sql = " SELECT codcombo FROM combos WHERE codcombo = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codcombo"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
    $query = "INSERT INTO combos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codcombo);
	$stmt->bindParam(2, $nomcombo);
	$stmt->bindParam(3, $preciocompra);
	$stmt->bindParam(4, $precioventa);
	$stmt->bindParam(5, $existencia);
	$stmt->bindParam(6, $stockminimo);
	$stmt->bindParam(7, $stockmaximo);
	$stmt->bindParam(8, $ivacombo);
	$stmt->bindParam(9, $desccombo);

	$codcombo = limpiar($_POST["codcombo"]);
	$nomcombo = limpiar($_POST["nomcombo"]);
	$preciocompra = limpiar($_POST["preciocompra"]);
	$precioventa = limpiar($_POST["precioventa"]);
	$existencia = limpiar($_POST["existencia"]);
	$stockminimo = limpiar($_POST["stockminimo"]);
	$stockmaximo = limpiar($_POST["stockmaximo"]);
	$ivacombo = limpiar($_POST["ivacombo"]);
	$desccombo = limpiar($_POST["desccombo"]);
	$stmt->execute();

    ##################### REGISTRAMOS LOS DATOS DE COMBOS EN KARDEX #####################
	$query = "INSERT INTO kardex_combos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codproceso);
	$stmt->bindParam(2, $codresponsable);
	$stmt->bindParam(3, $codcombo);
	$stmt->bindParam(4, $movimiento);
	$stmt->bindParam(5, $entradas);
	$stmt->bindParam(6, $salidas);
	$stmt->bindParam(7, $devolucion);
	$stmt->bindParam(8, $stockactual);
	$stmt->bindParam(9, $ivacombo);
	$stmt->bindParam(10, $desccombo);
	$stmt->bindParam(11, $precio);
	$stmt->bindParam(12, $documento);
	$stmt->bindParam(13, $fechakardex);

	$codproceso = limpiar($_POST['codcombo']);
	$codresponsable = limpiar("0");
	$codcombo = limpiar($_POST['codcombo']);
	$movimiento = limpiar("ENTRADAS");
	$entradas = limpiar($_POST['existencia']);
	$salidas = limpiar("0");
	$devolucion = limpiar("0");
	$stockactual = limpiar($_POST['existencia']);
	$ivacombo = limpiar($_POST["ivacombo"]);
	$desccombo = limpiar($_POST["desccombo"]);
	$precio = limpiar($_POST['precioventa']);
	$documento = limpiar("INVENTARIO INICIAL");
	$fechakardex = limpiar(date("Y-m-d"));
	$stmt->execute();
    ##################### REGISTRAMOS LOS DATOS DE COMBOS EN KARDEX #####################

    ##################  SUBIR FOTO DE COMBO ######################################
     //datos del arhivo  
    if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo =''; }
    if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo =''; }
    if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo =''; } 
     //compruebo si las características del archivo son las que deseo  
    if ((strpos($tipo_archivo,'image/jpeg')!==false)&&$tamano_archivo<200000) 
	 {  
	 	if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/combos/".$nombre_archivo) && rename("fotos/combos/".$nombre_archivo,"fotos/combos/".$codcombo.".jpg"))
	 { 
	 ## se puede dar un aviso
	 } 
	 ## se puede dar otro aviso 
	 }
    ##################  FINALIZA SUBIR FOTO DE COMBO ######################################

	if(!empty($_SESSION["CarritoProducto"])){

	################## PROCESO DE REGISTRO DE PRODUCTOS A COMBOS ####################
	$this->dbh->beginTransaction();

	$detalle = $_SESSION["CarritoProducto"];
	for($i=0;$i<count($detalle);$i++){

		$query = " INSERT INTO combosxproductos values (null, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcombo);
		$stmt->bindParam(2, $codproducto);
		$stmt->bindParam(3, $cantidad);
		
		$codcombo = limpiar($_POST["codcombo"]);
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$cantidad = number_format($detalle[$i]['cantidad'], 2, '.', '');
		$stmt->execute();
	}
	unset($_SESSION["CarritoProducto"]);
    $this->dbh->commit();
	################### PROCESO DE REGISTRO DE PRODUCTOS A COMBOS ##################

    }
		echo "<span class='fa fa-check-square-o'></span> EL COMBO HA SIDO REGISTRADO EXITOSAMENTE";
		exit;

	} else {

		echo "4";
		exit;
	}
}
########################## FUNCION REGISTRAR COMBOS ###############################

########################### FUNCION LISTAR COMBOS ################################
public function ListarCombos()
{
	self::SetNames();
    $sql = "SELECT
	combos.idcombo,
	combos.codcombo,
	combos.nomcombo,
	combos.preciocompra,
	combos.precioventa,
	combos.existencia,
	combos.stockminimo,
	combos.stockmaximo,
	combos.ivacombo,
	combos.desccombo,
	GROUP_CONCAT(cantidad, ' | ', producto, ' | ', nomcategoria SEPARATOR '<br>') AS detalles_productos,
	productos.codproducto,
	productos.producto,
	productos.codcategoria,
	categorias.nomcategoria
	FROM (combos INNER JOIN combosxproductos ON combos.codcombo = combosxproductos.codcombo)
	LEFT JOIN productos ON combosxproductos.codproducto = productos.codproducto
	LEFT JOIN categorias ON productos.codcategoria = categorias.codcategoria
	GROUP BY combos.codcombo";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################## FUNCION LISTAR COMBOS ################################

########################### FUNCION LISTAR COMBOS EN STOCK MINIMO ################################
public function ListarCombosMinimo()
{
	self::SetNames();
    $sql = "SELECT
	combos.idcombo,
	combos.codcombo,
	combos.nomcombo,
	combos.preciocompra,
	combos.precioventa,
	combos.existencia,
	combos.stockminimo,
	combos.stockmaximo,
	combos.ivacombo,
	combos.desccombo,
	GROUP_CONCAT(cantidad, ' | ', producto, ' | ', nomcategoria SEPARATOR '<br>') AS detalles_productos,
	productos.codproducto,
	productos.producto,
	productos.codcategoria,
	categorias.nomcategoria
	FROM (combos INNER JOIN combosxproductos ON combos.codcombo = combosxproductos.codcombo)
	LEFT JOIN productos ON combosxproductos.codproducto = productos.codproducto
	LEFT JOIN categorias ON productos.codcategoria = categorias.codcategoria
	WHERE CAST(combos.existencia AS DECIMAL(10,5)) <= CAST(combos.stockminimo AS DECIMAL(10,5))
	GROUP BY combos.codcombo";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################## FUNCION LISTAR COMBOS EN STOCK MINIMO ################################

########################### FUNCION LISTAR COMBOS EN STOCK MAXIMO ################################
public function ListarCombosMaximo()
	{
	self::SetNames();
    $sql = "SELECT
	combos.idcombo,
	combos.codcombo,
	combos.nomcombo,
	combos.preciocompra,
	combos.precioventa,
	combos.existencia,
	combos.stockminimo,
	combos.stockmaximo,
	combos.ivacombo,
	combos.desccombo,
	GROUP_CONCAT(cantidad, ' | ', producto, ' | ', nomcategoria SEPARATOR '<br>') AS detalles_productos,
	productos.codproducto,
	productos.producto,
	productos.codcategoria,
	categorias.nomcategoria
	FROM (combos INNER JOIN combosxproductos ON combos.codcombo = combosxproductos.codcombo)
	LEFT JOIN productos ON combosxproductos.codproducto = productos.codproducto
	LEFT JOIN categorias ON productos.codcategoria = categorias.codcategoria
	WHERE CAST(combos.existencia AS DECIMAL(10,2)) >= CAST(combos.stockmaximo AS DECIMAL(10,2))
	GROUP BY combos.codcombo";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################## FUNCION LISTAR COMBOS EN STOCK MAXIMO ################################

############################# FUNCION LISTAR COMBOS EN MODAL ################################
public function ListarCombosModal()
	{
	self::SetNames();
    $sql = "SELECT * FROM combos";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################## FUNCION LISTAR COMBOS EN MODAL ################################

############################# FUNCION LISTAR COMBOS PARA MENU ################################
public function ListarCombosMenu()
	{
	self::SetNames();
    $sql = "SELECT
	combos.idcombo,
	combos.codcombo,
	combos.nomcombo,
	combos.preciocompra,
	combos.precioventa,
	combos.existencia,
	combos.stockminimo,
	combos.stockmaximo,
	combos.ivacombo,
	combos.desccombo,
	GROUP_CONCAT(cantidad, ' | ', producto SEPARATOR '<br>') AS detalles_productos,
	productos.codproducto,
	productos.producto,
	productos.codcategoria,
	categorias.nomcategoria
	FROM (combos INNER JOIN combosxproductos ON combos.codcombo = combosxproductos.codcombo)
	LEFT JOIN productos ON combosxproductos.codproducto = productos.codproducto
	LEFT JOIN categorias ON productos.codcategoria = categorias.codcategoria
	GROUP BY combos.codcombo";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################## FUNCION LISTAR COMBOS PARA MENU ################################

############################ FUNCION ID COMBOS #################################
public function CombosPorId()
{
	self::SetNames();
	$sql = "SELECT
	combos.idcombo,
	combos.codcombo,
	combos.nomcombo,
	combos.preciocompra,
	combos.precioventa,
	combos.existencia,
	combos.stockminimo,
	combos.stockmaximo,
	combos.ivacombo,
	combos.desccombo
	FROM combos WHERE codcombo = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcombo"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID COMBOS #################################

############################ FUNCION ID PRODUCTOS #################################
public function DetallesComboPorId()
{
	self::SetNames();
	$sql = "SELECT
	combos.idcombo,
	combos.codcombo,
	combos.nomcombo,
	combos.preciocompra,
	combos.precioventa,
	combos.existencia,
	combos.stockminimo,
	combos.stockmaximo,
	combos.ivacombo,
	combos.desccombo
	FROM combos WHERE codcombo = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar($_GET["d_codigo"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID PRODUCTOS #################################

############################ FUNCION ACTUALIZAR COMBOS ############################
public function ActualizarCombos()
	{
	self::SetNames();
	if(empty($_POST["codcombo"]) or empty($_POST["nomcombo"]) or empty($_POST["existencia"]))
	{
	    echo "1";
		exit;
	}

	################## PROCESO DE REGISTRO DE PRODUCTOS A COMBOS ####################
	$this->dbh->beginTransaction();
	if (isset($_POST["codproducto"])) {
	    for($i=0;$i<count($_POST['codproducto']);$i++){  //recorro el array
		   if (!empty($_POST['codproducto'][$i])) {

		        if($_POST['cantidad'][$i] == "" || $_POST['cantidad'][$i] == 0 || $_POST['cantidad'][$i] == 0.00){

		            echo "2";
		            exit();
	            }
		   }
       }
	}
	$this->dbh->commit();
	################### PROCESO DE REGISTRO DE PRODUCTOS A COMBOS ##################

	$sql = "SELECT codcombo FROM combos WHERE idcombo != ? AND codcombo = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["idcombo"],$_POST["codcombo"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$sql = "UPDATE combos set"
		." nomcombo = ?, "
		." preciocompra = ?, "
		." precioventa = ?, "
		." existencia = ?, "
		." stockminimo = ?, "
		." stockmaximo = ?, "
		." ivacombo = ?, "
		." desccombo = ? "
		." where "
		." idcombo = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $nomcombo);
		$stmt->bindParam(2, $preciocompra);
		$stmt->bindParam(3, $precioventa);
		$stmt->bindParam(4, $existencia);
		$stmt->bindParam(5, $stockminimo);
		$stmt->bindParam(6, $stockmaximo);
		$stmt->bindParam(7, $ivacombo);
		$stmt->bindParam(8, $desccombo);
		$stmt->bindParam(9, $idcombo);

		$nomcombo = limpiar($_POST["nomcombo"]);
		$preciocompra = limpiar($_POST["preciocompra"]);
		$precioventa = limpiar($_POST["precioventa"]);
		$existencia = limpiar($_POST["existencia"]);
		$stockminimo = limpiar($_POST["stockminimo"]);
		$stockmaximo = limpiar($_POST["stockmaximo"]);
		$ivacombo = limpiar($_POST["ivacombo"]);
		$desccombo = limpiar($_POST["desccombo"]);
		$codcombo = limpiar($_POST["codcombo"]);
		$idcombo = limpiar($_POST["idcombo"]);
		$stmt->execute();

	##################  SUBIR FOTO DE COMBO ######################################
     //datos del arhivo  
    if (isset($_FILES['imagen']['name'])) { $nombre_archivo = $_FILES['imagen']['name']; } else { $nombre_archivo =''; }
    if (isset($_FILES['imagen']['type'])) { $tipo_archivo = $_FILES['imagen']['type']; } else { $tipo_archivo =''; }
    if (isset($_FILES['imagen']['size'])) { $tamano_archivo = $_FILES['imagen']['size']; } else { $tamano_archivo =''; } 
     //compruebo si las características del archivo son las que deseo  
    if ((strpos($tipo_archivo,'image/jpeg')!==false)&&$tamano_archivo<200000) 
	 {  
	 	if (move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/combos/".$nombre_archivo) && rename("fotos/combos/".$nombre_archivo,"fotos/combos/".$codcombo.".jpg"))
	 { 
	 ## se puede dar un aviso
	 } 
	 ## se puede dar otro aviso 
	 }
    ##################  FINALIZA SUBIR FOTO DE COMBO ######################################

	################## PROCESO DE REGISTRO DE PRODUCTOS A COMBOS ####################
	$this->dbh->beginTransaction();
	if (isset($_POST["codproducto"])) {
	    for($i=0;$i<count($_POST['codproducto']);$i++){  //recorro el array
		   if (!empty($_POST['codproducto'][$i])) {

		   	$query = "UPDATE combosxproductos set"
		   	." cantidad = ? "
		   	." WHERE "
		   	." codcombo = ? AND codproducto = ?;
		   	";
		   	$stmt = $this->dbh->prepare($query);
		   	$stmt->bindParam(1, $cantidad);
		   	$stmt->bindParam(2, $codcombo);
		   	$stmt->bindParam(3, $codproducto);

		   	$cantidad = limpiar($_POST['cantidad'][$i]);
		   	$codcombo = limpiar($_POST["codcombo"]);
		   	$codproducto = limpiar($_POST['codproducto'][$i]);
		   	$stmt->execute();

		   }
       }
	}
	$this->dbh->commit();
	################### PROCESO DE REGISTRO DE PRODUCTOS A COMBOS ##################
        
	echo "<span class='fa fa-check-square-o'></span> EL COMBO HA SIDO ACTUALIZADO EXITOSAMENTE";
	exit;

	} else {

		echo "3";
		exit;
	}
}
############################ FUNCION ACTUALIZAR COMBOS ############################

############################ FUNCION AGREGAR PRODUCTOS A COMBOS ############################
public function AgregarProductos()
{
self::SetNames();
	if(empty($_POST["codcombo"]) or empty($_SESSION["CarritoProducto"]))
	{
		echo "1";
		exit;
	}

	############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA #############
	$v = $_SESSION["CarritoProducto"];
	for($i=0;$i<count($v);$i++){

		$sql = "SELECT existencia
		FROM productos 
		WHERE codproducto = '".$v[$i]['txtCodigo']."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		
		$cantproductobd = $row['existencia'];
		$cantidad = $v[$i]['cantidad'];

        if($cantidad == "" || $cantidad == 0 || $cantidad == 0.00){

		    echo "2";
		    exit();
	    }
	    elseif ($cantidad > $cantproductobd) 
        { 
		    echo "2";
		    exit;
	    }
	}
	############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA #############

	################## PROCESO DE REGISTRO DE PRODUCTOS A COMBOS ####################
	$this->dbh->beginTransaction();

	$detalle = $_SESSION["CarritoProducto"];
	for($i=0;$i<count($detalle);$i++){

		$sql = "SELECT 
		codcombo, 
		codproducto 
		FROM combosxproductos 
		WHERE codcombo = '".limpiar($_POST['codcombo'])."' 
		AND codproducto = '".limpiar($detalle[$i]['txtCodigo'])."'";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num == 0)
		{

		$query = " INSERT INTO combosxproductos values (null, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcombo);
		$stmt->bindParam(2, $codproducto);
		$stmt->bindParam(3, $cantidad);
		
		$codcombo = limpiar($_POST["codcombo"]);
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$cantidad = number_format($detalle[$i]['cantidad'], 2, '.', '');
		$stmt->execute();

		} else {

		$sql = "SELECT 
		cantidad
		FROM combosxproductos 
		WHERE codcombo = '".limpiar($_POST['codcombo'])."' 
		AND codproducto = '".limpiar($detalle[$i]['txtCodigo'])."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$cantidadbd = $row['cantidad'];

		$query = "UPDATE combosxproductos set"
		." cantidad = ? "
		." WHERE "
		." codcombo = ? AND codproducto = ?;
		";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $cantidad);
		$stmt->bindParam(2, $codcombo);
		$stmt->bindParam(3, $codproducto);

		$cantidad = limpiar($cantidadbd+$detalle[$i]['cantidad']);
		$codcombo = limpiar($_POST["codcombo"]);
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$stmt->execute();

		}
	}
	unset($_SESSION["CarritoProducto"]);
    $this->dbh->commit();
	################### PROCESO DE REGISTRO DE PRODUCTOS A COMBOS ##################

	############## ACTUALIZAMOS LOS PRECIO DEL COMBO ###################
    $sql2 = " UPDATE combos set "
    ." preciocompra = ?, "
    ." precioventa = ? "
    ." WHERE "
    ." codcombo = ?;
    ";
    $stmt = $this->dbh->prepare($sql2);
    $stmt->bindParam(1, $preciocompra);
    $stmt->bindParam(2, $precioventa);
    $stmt->bindParam(3, $codcombo);

    $preciocompra = number_format($_POST["preciocomprabd"]+$_POST["preciocompra"], 2, '.', '');
    $precioventa = number_format($_POST["precioventabd"]+$_POST["precioventa"], 2, '.', '');
	$codcombo = limpiar($_POST["codcombo"]);
    $stmt->execute();
    ############## ACTUALIZAMOS LOS PRECIO DEL COMBO ###################
        
	echo "<span class='fa fa-check-square-o'></span> LOS PRODUCTOS FUERON AGREGADOS AL COMBO EXITOSAMENTE";
	exit;
}
############################ FUNCION AGREGAR PRODUCTOS A COMBOS ############################

########################## FUNCION AJUSTAR STOCK DE COMBOS ###########################
public function SumarStockCombo()
{
	self::SetNames();
	if(empty($_POST["idcombo"]) or empty($_POST["cantidad"]))
	{
		echo "1";
	    exit;
	}
	elseif($_POST["cantidad"] == 0 || $_POST["cantidad"] == 0.00){

		echo "2";
		exit();
	}

	################ OBTENGO EXISTENCIA DE COMBO ################
	$sql = "SELECT
	codcombo,
	existencia,
	precioventa,
	ivacombo, 
	desccombo 
	FROM combos 
	WHERE idcombo = '".limpiar($_POST['idcombo'])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$codcombobd = $row['codcombo'];
	$existenciabd = $row['existencia'];
	$precioventabd = $row['precioventa'];
	$ivacombobd = $row['ivacombo'];
	$desccombobd = $row['desccombo'];
    ################ OBTENGO EXISTENCIA DE COMBO ################
	
	################ ACTUALIZO EXISTENCIA DE COMBO ################
	$sql = "UPDATE combos set"
		  ." existencia = ? "
		  ." where "
		  ." idcombo = ?;
		   ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $existencia);
	$stmt->bindParam(2, $idcombo);
	
	$existencia = number_format($_POST["cantidad"] + $existenciabd, 2, '.', '');
	$idcombo = limpiar($_POST["idcombo"]);
	$stmt->execute();
	################ ACTUALIZO EXISTENCIA DE COMBO ################

	##################### REGISTRAMOS LOS DATOS DE COMBOS EN KARDEX #####################
	$query = "INSERT INTO kardex_combos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codproceso);
	$stmt->bindParam(2, $codresponsable);
	$stmt->bindParam(3, $codcombo);
	$stmt->bindParam(4, $movimiento);
	$stmt->bindParam(5, $entradas);
	$stmt->bindParam(6, $salidas);
	$stmt->bindParam(7, $devolucion);
	$stmt->bindParam(8, $stockactual);
	$stmt->bindParam(9, $ivacombo);
	$stmt->bindParam(10, $desccombo);
	$stmt->bindParam(11, $precio);
	$stmt->bindParam(12, $documento);
	$stmt->bindParam(13, $fechakardex);

	$codproceso = limpiar($codcombobd);
	$codresponsable = limpiar("0");
	$codcombo = limpiar($codcombobd);
	$movimiento = limpiar("ENTRADAS");
	$entradas = limpiar($_POST['cantidad']);
	$salidas = limpiar("0");
	$devolucion = limpiar("0");
	$stockactual = number_format($_POST["cantidad"] + $existenciabd, 2, '.', '');
	$ivacombo = limpiar($ivacombobd);
	$desccombo = limpiar($desccombobd);
	$precio = limpiar($precioventabd);
	$documento = limpiar("SUMA DE STOCK");
	$fechakardex = limpiar(date("Y-m-d"));
	$stmt->execute();
    ##################### REGISTRAMOS LOS DATOS DE COMBOS EN KARDEX #####################

	echo "<span class='fa fa-check-square-o'></span> LA CANTIDAD FUE SUMADA AL STOCK DEL COMBO EXITOSAMENTE";
	exit;
}
###################### FUNCION AJUSTAR STOCK DE COMBOS #########################

########################## FUNCION ELIMINAR COMBOS ###########################
public function EliminarCombos()
	{
	self::SetNames();
	if ($_SESSION["acceso"]=="administrador") {

	$sql = "SELECT codproducto FROM detalleventas WHERE codproducto = ? AND tipo = 2";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcombo"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{

		$sql = "DELETE FROM combos WHERE codcombo = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codcombo);
		$codcombo = decrypt($_GET["codcombo"]);
		$stmt->execute();

		$sql = "DELETE FROM kardex_combos where codcombo = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codcombo);
		$codcombo = decrypt($_GET["codcombo"]);
		$stmt->execute();

		$sql = "DELETE FROM combosxproductos where codcombo = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codcombo);
		$codcombo = decrypt($_GET["codcombo"]);
		$stmt->execute();

		$codcombo = decrypt($_GET["codcombo"]);
		if (file_exists("fotos/combos/".$codcombo.".jpg")){
	    //funcion para eliminar una carpeta con contenido
		$archivos = "fotos/combos/".$codcombo.".jpg";		
		unlink($archivos);
		}

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
	} 
			
	} else {
		
		echo "3";
		exit;
	}	
}
########################## FUNCION ELIMINAR COMBOS #################################

###################### FUNCION BUSCAR COMBOS FACTURADOS #########################
public function BuscarCombosVendidos() 
	{
	self::SetNames();
    $sql ="SELECT 
    detalleventas.idproducto,
    detalleventas.codproducto,
    detalleventas.producto,
    detalleventas.descproducto,  
    detalleventas.ivaproducto,
    detalleventas.precioventa, 
    combos.existencia, 
    ventas.fechaventa, 
    SUM(detalleventas.cantventa) as cantidad 
    FROM (ventas LEFT JOIN detalleventas ON ventas.codventa = detalleventas.codventa) 
    LEFT JOIN combos ON detalleventas.idproducto = combos.idcombo 
    WHERE DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') >= ? 
    AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') <= ?
    AND detalleventas.tipo = 2 
    GROUP BY detalleventas.codproducto, detalleventas.precioventa, detalleventas.descproducto 
    ORDER BY combos.codcombo ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN COMBOS FACTURADOS PARA EL RANGO DE FECHA INGRESADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################### FUNCION COMBOS FACTURADOS ###############################

######################## FUNCION BUSCA KARDEX COMBOS ##########################
public function BuscarKardexCombo() 
	{
	self::SetNames();
	$sql ="SELECT * FROM (combos LEFT JOIN kardex_combos ON combos.codcombo = kardex_combos.codcombo) 
	WHERE kardex_combos.codcombo = ?";
    $stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_GET["codcombo"]));
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN MOVIMIENTOS EN KARDEX PARA EL COMBO INGRESADO</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################## FUNCION BUSCA KARDEX COMBOS #########################

###################### FUNCION KARDEX COMBOS POR FECHAS #########################
public function BuscarKardexCombosValorizadoxFechas() 
{
	self::SetNames();
	$sql ="SELECT 
	detalleventas.codproducto,
	detalleventas.producto,
	detalleventas.descproducto,
	detalleventas.ivaproducto,
	detalleventas.preciocompra, 
	detalleventas.precioventa,
	combos.existencia,
	ventas.fechaventa,
	SUM(detalleventas.cantventa) as cantidad 
	FROM (ventas INNER JOIN detalleventas ON ventas.codventa = detalleventas.codventa) 
	LEFT JOIN combos ON detalleventas.idproducto = combos.idcombo
	WHERE DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') >= ? 
	AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') <= ? 
	AND detalleventas.tipo = 2
	GROUP BY detalleventas.codproducto, detalleventas.precioventa, detalleventas.descproducto 
	ORDER BY detalleventas.codproducto ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################### FUNCION KARDEX COMBOS POR FECHAS ###############################

############################### FIN DE CLASE COMBOS ###############################































###################################### CLASE COMPRAS ###################################

############################# FUNCION REGISTRAR COMPRAS #############################
public function RegistrarCompras()
{
	self::SetNames();
if(empty($_POST["codcompra"]) or empty($_POST["fechaemision"]) or empty($_POST["fecharecepcion"]) or empty($_POST["codproveedor"]))
	{
		echo "1";
		exit;
	}

	if (limpiar(isset($_POST['fechavencecredito']))) {  

		$fechaactual = date("Y-m-d");
		$fechavence = date("Y-m-d",strtotime($_POST['fechavencecredito']));
		
	    if (strtotime($fechavence) < strtotime($fechaactual)) {
	  
	        echo "2";
		    exit;
	    }
    }

	if(empty($_SESSION["CarritoCompra"]))
	{
		echo "3";
		exit;
		
	} else {

    $sql = "SELECT codcompra FROM compras WHERE codcompra = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST['codcompra']));
	$num = $stmt->rowCount();
	if($num == 0)
	{

    $query = "INSERT INTO compras values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codcompra);
	$stmt->bindParam(2, $codproveedor);
	$stmt->bindParam(3, $subtotalivasic);
	$stmt->bindParam(4, $subtotalivanoc);
	$stmt->bindParam(5, $ivac);
	$stmt->bindParam(6, $totalivac);
	$stmt->bindParam(7, $descontadoc);
	$stmt->bindParam(8, $descuentoc);
	$stmt->bindParam(9, $totaldescuentoc);
	$stmt->bindParam(10, $totalpagoc);
	$stmt->bindParam(11, $tipocompra);
	$stmt->bindParam(12, $formacompra);
	$stmt->bindParam(13, $fechavencecredito);
	$stmt->bindParam(14, $fechapagado);
	$stmt->bindParam(15, $observaciones);
	$stmt->bindParam(16, $statuscompra);
	$stmt->bindParam(17, $fechaemision);
	$stmt->bindParam(18, $fecharecepcion);
	$stmt->bindParam(19, $codigo);
    
	$codcompra = limpiar($_POST["codcompra"]);
	$codproveedor = limpiar($_POST["codproveedor"]);
	$subtotalivasic = limpiar($_POST["txtsubtotal"]);
	$subtotalivanoc = limpiar($_POST["txtsubtotal2"]);
	$ivac = limpiar($_POST["iva"]);
	$totalivac = limpiar($_POST["txtIva"]);
	$descontadoc = limpiar($_POST["txtdescontado"]);
	$descuentoc = limpiar($_POST["descuento"]);
	$totaldescuentoc = limpiar($_POST["txtDescuento"]);
	$totalpagoc = limpiar($_POST["txtTotal"]);
	$tipocompra = limpiar($_POST["tipocompra"]);
	$formacompra = limpiar($_POST["tipocompra"]=="CONTADO" ? $_POST["formacompra"] : "CREDITO");
	$fechavencecredito = limpiar($_POST["tipocompra"]=="CREDITO" ? date("Y-m-d",strtotime($_POST['fechavencecredito'])) : "0000-00-00");
    $fechapagado = limpiar("0000-00-00");
    $observaciones = limpiar($_POST["observaciones"]);
	$statuscompra = limpiar($_POST["tipocompra"]=="CONTADO" ? "PAGADA" : "PENDIENTE");
    $fechaemision = limpiar(date("Y-m-d",strtotime($_POST['fechaemision'])));
    $fecharecepcion = limpiar(date("Y-m-d",strtotime($_POST['fecharecepcion'])));
	$codigo = limpiar($_SESSION["codigo"]);
	$stmt->execute();
	
	$this->dbh->beginTransaction();

	$detalle = $_SESSION["CarritoCompra"];
	for($i=0;$i<count($detalle);$i++){

	$query = "INSERT INTO detallecompras values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codcompra);
    $stmt->bindParam(2, $tipoentrada);
    $stmt->bindParam(3, $codproducto);
    $stmt->bindParam(4, $producto);
    $stmt->bindParam(5, $codcategoria);
	$stmt->bindParam(6, $preciocomprac);
	$stmt->bindParam(7, $precioventac);
	$stmt->bindParam(8, $cantcompra);
	$stmt->bindParam(9, $ivaproductoc);
	$stmt->bindParam(10, $descproductoc);
	$stmt->bindParam(11, $descfactura);
	$stmt->bindParam(12, $valortotal);
	$stmt->bindParam(13, $totaldescuentoc);
	$stmt->bindParam(14, $valorneto);
	$stmt->bindParam(15, $lotec);
	$stmt->bindParam(16, $fechaelaboracionc);
	$stmt->bindParam(17, $fechaexpiracionc);
		
	$codcompra = limpiar($_POST['codcompra']);
	$tipoentrada = limpiar($detalle[$i]['tipoentrada']);
	$codproducto = limpiar($detalle[$i]['txtCodigo']);
	$producto = limpiar($detalle[$i]['producto']);
	$codcategoria = limpiar($detalle[$i]['codcategoria']);
	$preciocomprac = limpiar($detalle[$i]['precio']);
	$precioventac = limpiar($detalle[$i]['precio2']);
	$cantcompra = limpiar(number_format($detalle[$i]['cantidad'], 2, '.', ''));
	$ivaproductoc = limpiar($detalle[$i]['ivaproducto']);
	$descproductoc = limpiar($detalle[$i]['descproducto']);
	$descfactura = limpiar($detalle[$i]['descproductofact']);
	$descuento = $detalle[$i]["descproductofact"]/100;
	$valortotal = number_format($detalle[$i]['precio']*$detalle[$i]['cantidad'], 2, '.', '');
	$totaldescuentoc = number_format($valortotal*$descuento, 2, '.', '');
    $valorneto = number_format($valortotal-$totaldescuentoc, 2, '.', '');
	$lotec = limpiar($detalle[$i]['lote']);
	$fechaelaboracionc = limpiar($detalle[$i]['fechaelaboracion']=="" ? "0000-00-00" : date("Y-m-d",strtotime($detalle[$i]['fechaelaboracion'])));
	$fechaexpiracionc = limpiar($detalle[$i]['fechaexpiracion']=="" ? "0000-00-00" : date("Y-m-d",strtotime($detalle[$i]['fechaexpiracion'])));
	$stmt->execute();


	if(limpiar($detalle[$i]['tipoentrada'])=="PRODUCTO"){

    ############### VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ################
	$sql = "SELECT existencia FROM productos WHERE codproducto = '".limpiar($detalle[$i]['txtCodigo'])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$existenciaproductobd = $row['existencia'];

	############# ACTUALIZAMOS LA EXISTENCIA DE PRODUCTOS COMPRADOS ###############
	$sql = "UPDATE productos set "
	      ." preciocompra = ?, "
		  ." precioventa = ?, "
		  ." existencia = ?, "
		  ." ivaproducto = ?, "
		  ." descproducto = ?, "
		  ." fechaelaboracion = ?, "
		  ." fechaexpiracion = ?, "
		  ." codproveedor = ?, "
		  ." lote = ? "
		  ." WHERE "
		  ." codproducto = ?;
		   ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $preciocompra);
	$stmt->bindParam(2, $precioventa);
	$stmt->bindParam(3, $existencia);
	$stmt->bindParam(4, $ivaproducto);
	$stmt->bindParam(5, $descproducto);
	$stmt->bindParam(6, $fechaelaboracion);
	$stmt->bindParam(7, $fechaexpiracion);
	$stmt->bindParam(8, $codproveedor);
	$stmt->bindParam(9, $lote);
	$stmt->bindParam(10, $codproducto);
	
	$preciocompra = limpiar($detalle[$i]['precio']);
	$precioventa = limpiar($detalle[$i]['precio2']);
	$existencia = limpiar(number_format($detalle[$i]['cantidad']+$existenciaproductobd, 2, '.', ''));
	$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
	$descproducto = limpiar($detalle[$i]['descproducto']);
	$fechaelaboracion = limpiar($detalle[$i]['fechaelaboracion']=="" ? "0000-00-00" : date("Y-m-d",strtotime($detalle[$i]['fechaelaboracion'])));
	$fechaexpiracion = limpiar($detalle[$i]['fechaexpiracion']=="" ? "0000-00-00" : date("Y-m-d",strtotime($detalle[$i]['fechaexpiracion'])));
	$codproveedor = limpiar($_POST['codproveedor']);
	$lote = limpiar($detalle[$i]['lote']);
	$codproducto = limpiar($detalle[$i]['txtCodigo']);
	$stmt->execute();

	############### REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
    $query = "INSERT INTO kardex_productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codcompra);
	$stmt->bindParam(2, $codproveedor);
	$stmt->bindParam(3, $codproducto);
	$stmt->bindParam(4, $movimiento);
	$stmt->bindParam(5, $entradas);
	$stmt->bindParam(6, $salidas);
	$stmt->bindParam(7, $devolucion);
	$stmt->bindParam(8, $stockactual);
	$stmt->bindParam(9, $ivaproducto);
	$stmt->bindParam(10, $descproducto);
	$stmt->bindParam(11, $precio);
	$stmt->bindParam(12, $documento);
	$stmt->bindParam(13, $fechakardex);		

	$codcompra = limpiar($_POST['codcompra']);
	$codproveedor = limpiar($_POST["codproveedor"]);
	$codproducto = limpiar($detalle[$i]['txtCodigo']);
	$movimiento = limpiar("ENTRADAS");
	$entradas= limpiar(number_format($detalle[$i]['cantidad'], 2, '.', ''));
	$salidas = limpiar("0");
	$devolucion = limpiar("0");
	$stockactual = limpiar(number_format($detalle[$i]['cantidad']+$existenciaproductobd, 2, '.', ''));
	$precio = limpiar($detalle[$i]["precio"]);
	$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
	$descproducto = limpiar($detalle[$i]['descproducto']);
	$documento = limpiar("COMPRA");
	$fechakardex = limpiar(date("Y-m-d"));
	$stmt->execute();


	} else {

	############### VERIFICO LA EXISTENCIA DEL INSUMO EN ALMACEN ################
	$sql = "SELECT 
	cantingrediente 
	FROM ingredientes 
	WHERE codingrediente = '".limpiar($detalle[$i]['txtCodigo'])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$existenciaingredientebd = $row['cantingrediente'];
	############### VERIFICO LA EXISTENCIA DEL INSUMO EN ALMACEN ################

	############# ACTUALIZAMOS LA EXISTENCIA DE INGREDIENTES COMPRADOS ###############
	$sql = "UPDATE ingredientes set "
	      ." preciocompra = ?, "
		  ." precioventa = ?, "
		  ." cantingrediente = ?, "
		  ." ivaingrediente = ?, "
		  ." descingrediente = ?, "
		  ." fechaexpiracion = ?, "
		  ." codproveedor = ?, "
		  ." lote = ? "
		  ." WHERE "
		  ." codingrediente = ?;
		   ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $preciocompra);
	$stmt->bindParam(2, $precioventa);
	$stmt->bindParam(3, $cantingrediente);
	$stmt->bindParam(4, $ivaingrediente);
	$stmt->bindParam(5, $descingrediente);
	$stmt->bindParam(6, $fechaexpiracion);
	$stmt->bindParam(7, $codproveedor);
	$stmt->bindParam(8, $lote);
	$stmt->bindParam(9, $codingrediente);
	
	$preciocompra = limpiar($detalle[$i]['precio']);
	$precioventa = limpiar($detalle[$i]['precio2']);
	$cantingrediente = limpiar(number_format($detalle[$i]['cantidad']+$existenciaingredientebd, 2, '.', ''));
	$ivaingrediente = limpiar($detalle[$i]['ivaproducto']);
	$descingrediente = limpiar($detalle[$i]['descproducto']);
	$fechaexpiracion = limpiar($detalle[$i]['fechaexpiracion']=="" ? "0000-00-00" : date("Y-m-d",strtotime($detalle[$i]['fechaexpiracion'])));
	$codproveedor = limpiar($_POST['codproveedor']);
	$lote = limpiar($detalle[$i]['lote']);
	$codingrediente = limpiar($detalle[$i]['txtCodigo']);
	$stmt->execute();

	############### REGISTRAMOS LOS DATOS DE INSUMOS EN KARDEX ###################
    $query = "INSERT INTO kardex_ingredientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codcompra);
	$stmt->bindParam(2, $codproveedor);
	$stmt->bindParam(3, $codingrediente);
	$stmt->bindParam(4, $movimiento);
	$stmt->bindParam(5, $entradas);
	$stmt->bindParam(6, $salidas);
	$stmt->bindParam(7, $devolucion);
	$stmt->bindParam(8, $stockactual);
	$stmt->bindParam(9, $ivaingrediente);
	$stmt->bindParam(10, $descingrediente);
	$stmt->bindParam(11, $precio);
	$stmt->bindParam(12, $documento);
	$stmt->bindParam(13, $fechakardex);		

	$codcompra = limpiar($_POST['codcompra']);
	$codproveedor = limpiar($_POST["codproveedor"]);
	$codingrediente = limpiar($detalle[$i]['txtCodigo']);
	$movimiento = limpiar("ENTRADAS");
	$entradas= limpiar(number_format($detalle[$i]['cantidad'], 2, '.', ''));
	$salidas = limpiar("0");
	$devolucion = limpiar("0");
	$stockactual = limpiar(number_format($detalle[$i]['cantidad']+$existenciaingredientebd, 2, '.', ''));
	$precio = limpiar($detalle[$i]["precio"]);
	$ivaingrediente = limpiar($detalle[$i]['ivaproducto']);
	$descingrediente = limpiar($detalle[$i]['descproducto']);
	$documento = limpiar("COMPRA");
	$fechakardex = limpiar(date("Y-m-d"));
	$stmt->execute();

	     }

    }
	####################### DESTRUYO LA VARIABLE DE SESSION #####################
	unset($_SESSION["CarritoCompra"]);
    $this->dbh->commit();

		
    echo "<span class='fa fa-check-square-o'></span> LA COMPRA DE PRODUCTOS E INGREDIENTES HA SIDO REGISTRADA EXITOSAMENTE <a href='reportepdf?codcompra=".encrypt($codcompra)."&tipo=".encrypt("FACTURACOMPRA")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR DOCUMENTO</strong></font color></a></div>";
	exit;

	    } else {
			echo "4";
			exit;
		}
	}
}
############################ FUNCION REGISTRAR COMPRAS ##########################

########################## FUNCION BUSQUEDA DE COMPRAS ###############################
public function BusquedaCompras()
	{
	self::SetNames();
	$sql = "SELECT 
	compras.codcompra, 
	compras.codproveedor, 
	compras.subtotalivasic, 
	compras.subtotalivanoc, 
	compras.ivac, 
	compras.totalivac,
	compras.descontadoc, 
	compras.descuentoc, 
	compras.totaldescuentoc, 
	compras.totalpagoc, 
	compras.statuscompra, 
	compras.fechavencecredito, 
	compras.fechapagado,
	compras.observaciones,
	compras.fecharecepcion, 
	compras.fechaemision,
	proveedores.documproveedor, 
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	documentos.documento,
	SUM(detallecompras.cantcompra) AS articulos 
	FROM (compras LEFT JOIN detallecompras ON detallecompras.codcompra = compras.codcompra) 
	LEFT JOIN proveedores ON compras.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos ON proveedores.documproveedor = documentos.coddocumento
	LEFT JOIN usuarios ON compras.codigo = usuarios.codigo 
	WHERE CONCAT(compras.codcompra, ' ',proveedores.cuitproveedor, ' ',proveedores.nomproveedor, ' ',compras.formacompra) LIKE '%".limpiar($_GET['bcompras'])."%' 
	AND compras.statuscompra = 'PAGADA' 
	GROUP BY detallecompras.codcompra 
	ORDER BY compras.idcompra DESC LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0) {

	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</div></center>";
	exit;
		
	} else {
			
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################## FUNCION BUSQUEDA DE COMPRAS ###############################

######################### FUNCION LISTAR COMPRAS ################################
public function ListarCompras()
{
	self::SetNames();
	$sql = "SELECT 
	compras.codcompra, 
	compras.codproveedor, 
	compras.subtotalivasic, 
	compras.subtotalivanoc, 
	compras.ivac, 
	compras.totalivac,
	compras.descontadoc, 
	compras.descuentoc, 
	compras.totaldescuentoc, 
	compras.totalpagoc, 
	compras.statuscompra, 
	compras.fechavencecredito, 
	compras.fechapagado,
	compras.observaciones,
	compras.fecharecepcion, 
	compras.fechaemision,
	proveedores.documproveedor, 
	proveedores.documproveedor, 
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	documentos.documento,
	SUM(detallecompras.cantcompra) AS articulos 
	FROM (compras LEFT JOIN detallecompras ON detallecompras.codcompra = compras.codcompra) 
	LEFT JOIN proveedores ON compras.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos ON proveedores.documproveedor = documentos.coddocumento
	LEFT JOIN usuarios ON compras.codigo = usuarios.codigo 
	WHERE compras.statuscompra = 'PAGADA' 
	GROUP BY detallecompras.codcompra 
	ORDER BY compras.idcompra DESC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
################################## FUNCION LISTAR COMPRAS ############################

########################## FUNCION BUSQUEDA DE CUENTAS POR PAGAR ###############################
public function BusquedaCuentasxPagar()
	{
	self::SetNames();
	$sql = "SELECT 
	compras.codcompra, 
	compras.codproveedor, 
	compras.subtotalivasic, 
	compras.subtotalivanoc, 
	compras.ivac, 
	compras.totalivac,
	compras.descontadoc, 
	compras.descuentoc, 
	compras.totaldescuentoc, 
	compras.totalpagoc, 
	compras.statuscompra, 
	compras.fechavencecredito, 
	compras.fechapagado,
	compras.observaciones,
	compras.fecharecepcion, 
	compras.fechaemision,
	proveedores.documproveedor, 
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	documentos.documento,
	SUM(detallecompras.cantcompra) AS articulos 
	FROM (compras LEFT JOIN detallecompras ON detallecompras.codcompra = compras.codcompra) 
	LEFT JOIN proveedores ON compras.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos ON proveedores.documproveedor = documentos.coddocumento
	LEFT JOIN usuarios ON compras.codigo = usuarios.codigo 
	WHERE CONCAT(compras.codcompra, ' ',proveedores.cuitproveedor, ' ',proveedores.nomproveedor, ' ',compras.formacompra) LIKE '%".limpiar($_GET['bcompras'])."%' 
	AND compras.statuscompra = 'PENDIENTE' 
	GROUP BY detallecompras.codcompra 
	ORDER BY compras.idcompra DESC LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0) {

	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</div></center>";
	exit;
		
	} else {
			
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################## FUNCION BUSQUEDA DE CUENTAS POR PAGAR ###############################

########################### FUNCION LISTAR CUENTAS POR PAGAR #######################
public function ListarCuentasxPagar()
{
	self::SetNames();
	$sql = "SELECT 
	compras.codcompra, 
	compras.codproveedor, 
	compras.subtotalivasic, 
	compras.subtotalivanoc, 
	compras.ivac, 
	compras.totalivac,
	compras.descontadoc, 
	compras.descuentoc, 
	compras.totaldescuentoc, 
	compras.totalpagoc, 
	compras.statuscompra, 
	compras.fechavencecredito, 
	compras.fechapagado,
	compras.observaciones,
	compras.fecharecepcion, 
	compras.fechaemision,
	proveedores.documproveedor, 
	proveedores.documproveedor, 
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	documentos.documento,
	SUM(detallecompras.cantcompra) AS articulos 
	FROM (compras LEFT JOIN detallecompras ON detallecompras.codcompra = compras.codcompra) 
	LEFT JOIN proveedores ON compras.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos ON proveedores.documproveedor = documentos.coddocumento
	LEFT JOIN usuarios ON compras.codigo = usuarios.codigo 
	WHERE compras.statuscompra = 'PENDIENTE' 
	GROUP BY detallecompras.codcompra 
	ORDER BY compras.idcompra DESC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
######################### FUNCION LISTAR CUENTAS POR PAGAR ############################

############################ FUNCION PARA PAGAR COMPRAS ############################
public function PagarCompras()
	{
	if ($_SESSION['acceso'] == "administrador" || $_SESSION["acceso"]=="secretaria") {
	
	self::SetNames();
	$sql = " UPDATE compras SET"
		  ." statuscompra = ?, "
		  ." fechapagado = ? "
		  ." WHERE "
		  ." codcompra = ?;
		   ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $statuscompra);
	$stmt->bindParam(2, $fechapagado);
	$stmt->bindParam(3, $codcompra);

	$statuscompra = limpiar("PAGADA");
	$fechapagado = limpiar(date("Y-m-d"));
	$codcompra = limpiar(decrypt($_GET["codcompra"]));
	$stmt->execute();

	   echo "1";
	   exit;
	   
	} else {
	   
		echo "2";
		exit;
	}
}
########################## FUNCION PARA PAGAR COMPRAS ###############################

############################ FUNCION ID COMPRAS #################################
public function ComprasPorId()
{
	self::SetNames();
	$sql = "SELECT 
	compras.idcompra, 
	compras.codcompra,
	compras.codproveedor, 
	compras.subtotalivasic,
	compras.subtotalivanoc, 
	compras.ivac,
	compras.totalivac,
	compras.descontadoc, 
	compras.descuentoc,
	compras.totaldescuentoc, 
	compras.totalpagoc, 
	compras.tipocompra,
	compras.formacompra,
	compras.fechavencecredito,
    compras.fechapagado,
    compras.observaciones,
	compras.statuscompra,
	compras.fechaemision,
	compras.fecharecepcion,
	compras.codigo,
	proveedores.documproveedor,
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	proveedores.tlfproveedor, 
	proveedores.id_provincia, 
	proveedores.id_departamento, 
	proveedores.direcproveedor, 
	proveedores.emailproveedor,
	proveedores.vendedor,
	proveedores.tlfvendedor,
    documentos.documento, 
	usuarios.dni, 
	usuarios.nombres,
	provincias.provincia,
	departamentos.departamento
	FROM (compras INNER JOIN proveedores ON compras.codproveedor = proveedores.codproveedor) 
	LEFT JOIN documentos ON proveedores.documproveedor = documentos.coddocumento
	LEFT JOIN provincias ON proveedores.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON proveedores.id_departamento = departamentos.id_departamento
	LEFT JOIN usuarios ON compras.codigo = usuarios.codigo
	WHERE compras.codcompra = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcompra"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID COMPRAS #################################
	
############################ FUNCION VER DETALLES COMPRAS ############################
public function VerDetallesCompras()
	{
	self::SetNames();
	$sql = "SELECT
	detallecompras.coddetallecompra,
	detallecompras.codcompra,
	detallecompras.tipoentrada,
	detallecompras.codproducto,
	detallecompras.producto,
	detallecompras.codcategoria,
	detallecompras.preciocomprac,
	detallecompras.precioventac,
	detallecompras.cantcompra,
	detallecompras.ivaproductoc,
	detallecompras.descproductoc,
	detallecompras.descfactura,
	detallecompras.valortotal, 
	detallecompras.totaldescuentoc,
	detallecompras.valorneto,
	detallecompras.lotec,
	detallecompras.fechaelaboracionc,
	detallecompras.fechaexpiracionc,
	categorias.nomcategoria,
	medidas.nommedida
	FROM detallecompras 
	LEFT JOIN categorias ON detallecompras.codcategoria = categorias.codcategoria 
	LEFT JOIN medidas ON detallecompras.codcategoria = medidas.codmedida 
	WHERE detallecompras.codcompra = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcompra"])));
	$num = $stmt->rowCount();
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$this->p[]=$row;
	}
	return $this->p;
	$this->dbh=null;
}
############################ FUNCION VER DETALLES COMPRAS ##############################

############################## FUNCION ACTUALIZAR COMPRAS #############################
public function ActualizarCompras()
{
	self::SetNames();
	if(empty($_POST["codcompra"]) or empty($_POST["fechaemision"]) or empty($_POST["fecharecepcion"]) or empty($_POST["codproveedor"]))
	{
		echo "1";
		exit;
	}

	if (limpiar(isset($_POST['fechavencecredito']))) {  

		$fechaactual = date("Y-m-d");
		$fechavence = date("Y-m-d",strtotime($_POST['fechavencecredito']));
		
	    if (strtotime($fechavence) < strtotime($fechaactual)) {
	  
	        echo "2";
		    exit;
	    }
    }

	for($i=0;$i<count($_POST['coddetallecompra']);$i++){  //recorro el array
        if (!empty($_POST['coddetallecompra'][$i])) {

	        if($_POST['cantcompra'][$i]==0){

		      echo "3";
		      exit();

	        }
        }
    }

    $this->dbh->beginTransaction();

    for($i=0;$i<count($_POST['coddetallecompra']);$i++){  //recorro el array
         if (!empty($_POST['coddetallecompra'][$i])) {

	$sql = "SELECT 
	cantcompra 
	FROM detallecompras 
	WHERE coddetallecompra = '".limpiar($_POST['coddetallecompra'][$i])."' 
	AND codcompra = '".limpiar($_POST["codcompra"])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
		
	$cantidadbd = $row['cantcompra'];

	if($cantidadbd != $_POST['cantcompra'][$i]){

		$query = "UPDATE detallecompras set"
		." cantcompra = ?, "
		." valortotal = ?, "
		." totaldescuentoc = ?, "
		." valorneto = ? "
		." WHERE "
		." coddetallecompra = ? AND codcompra = ?;
		";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $cantcompra);
		$stmt->bindParam(2, $valortotal);
		$stmt->bindParam(3, $totaldescuento);
		$stmt->bindParam(4, $valorneto);
		$stmt->bindParam(5, $coddetallecompra);
		$stmt->bindParam(6, $codcompra);

		$cantcompra = number_format($_POST['cantcompra'][$i], 2, '.', '');
		$preciocompra = limpiar($_POST['preciocompra'][$i]);
		$precioventa = limpiar($_POST['precioventa'][$i]);
		$ivaproducto = limpiar($_POST['ivaproducto'][$i]);
		$descuento = $_POST['descfactura'][$i]/100;
		$valortotal = number_format($_POST['valortotal'][$i], 2, '.', '');
		$totaldescuento = number_format($_POST['totaldescuentoc'][$i], 2, '.', '');
		$valorneto = number_format($_POST['valorneto'][$i], 2, '.', '');
		$coddetallecompra = limpiar($_POST['coddetallecompra'][$i]);
		$codcompra = limpiar($_POST["codcompra"]);
		$stmt->execute();


	if(limpiar($_POST['tipoentrada'][$i])=="PRODUCTO"){

		$sql = "SELECT existencia FROM productos WHERE codproducto = '".limpiar($_POST['codproducto'][$i])."'";
	    foreach ($this->dbh->query($sql) as $row)
	    {
		$this->p[] = $row;
	    }
	    $existenciaproductobd = $row['existencia'];
	    $cantcompra = $_POST["cantcompra"][$i];
	    $cantidadcomprabd = $_POST["cantidadcomprabd"][$i];
	    $totalcompra = $cantcompra-$cantidadcomprabd;

	    ############ ACTUALIZAMOS EXISTENCIA DEL PRODUCTO EN ALMACEN ################
	    $sql2 = " UPDATE productos set "
	    ." existencia = ? "
	    ." WHERE "
	    ." codproducto = '".limpiar($_POST["codproducto"][$i])."';
	    ";
	    $stmt = $this->dbh->prepare($sql2);
	    $stmt->bindParam(1, $existencia);
	    $existencia = limpiar(number_format($existenciaproductobd+$totalcompra, 2, '.', ''));
	    $stmt->execute();
	    ############ ACTUALIZAMOS EXISTENCIA DEL PRODUCTO EN ALMACEN ################

	    ############## ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX ###################
	    $sql3 = " UPDATE kardex_productos set "
	    ." entradas = ?, "
	    ." stockactual = ? "
	    ." WHERE "
	    ." codproceso = '".limpiar($_POST["codcompra"])."' and codproducto = '".limpiar($_POST["codproducto"][$i])."';
	    ";
	    $stmt = $this->dbh->prepare($sql3);
	    $stmt->bindParam(1, $entradas);
	    $stmt->bindParam(2, $existencia);

	    $entradas = limpiar(number_format($_POST["cantcompra"][$i], 2, '.', ''));
	    $existencia = limpiar(number_format($existenciaproductobd+$totalcompra, 2, '.', ''));
	    $stmt->execute();
	    ############## ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX ###################

		} else {

	    ############### VERIFICO LA EXISTENCIA DEL INGREDIENTE EN ALMACEN ################	
		$sql = "SELECT cantingrediente FROM ingredientes WHERE codingrediente = '".limpiar($_POST['codproducto'][$i])."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$existenciaingredientebd = $row['cantingrediente'];
		$cantcompra = $_POST["cantcompra"][$i];
		$cantidadcomprabd = $_POST["cantidadcomprabd"][$i];
		$totalcompra = $cantcompra-$cantidadcomprabd;
		############### VERIFICO LA EXISTENCIA DEL INGREDIENTE EN ALMACEN ################

	    ############ ACTUALIZAMOS EXISTENCIA DEL INGREDIENTE EN ALMACEN ################
		$sql2 = " UPDATE ingredientes set "
		." cantingrediente = ? "
		." WHERE "
		." codingrediente = '".limpiar($_POST["codproducto"][$i])."';
		";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->bindParam(1, $cantingrediente);
		$cantingrediente = limpiar(number_format($existenciaingredientebd+$totalcompra, 2, '.', ''));
		$stmt->execute();
		############ ACTUALIZAMOS EXISTENCIA DEL INGREDIENTE EN ALMACEN ################

	    ############## ACTUALIZAMOS LOS DATOS DEL INGREDIENTE EN KARDEX ###################
		$sql3 = " UPDATE kardex_ingredientes set "
		." entradas = ?, "
		." stockactual = ? "
		." WHERE "
		." codproceso = '".limpiar($_POST["codcompra"])."' and codingrediente = '".limpiar($_POST["codproducto"][$i])."';
		";
		$stmt = $this->dbh->prepare($sql3);
		$stmt->bindParam(1, $entradas);
		$stmt->bindParam(2, $cantingrediente);

		$entradas = limpiar(number_format($_POST["cantcompra"][$i], 2, '.', ''));
		$cantingrediente = limpiar(number_format($existenciaingredientebd+$totalcompra, 2, '.', ''));
		$stmt->execute();
		############## ACTUALIZAMOS LOS DATOS DEL INGREDIENTE EN KARDEX ###################

		}


		} else {

           echo "";

	       }
        }
    }

    $this->dbh->commit();

    ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############
	$sql3 = "SELECT SUM(totaldescuentoc) AS totaldescuentosi, SUM(valorneto) AS valorneto FROM detallecompras WHERE codcompra = '".limpiar($_POST["codcompra"])."' AND ivaproductoc = 'SI'";
	foreach ($this->dbh->query($sql3) as $row3)
	{
		$this->p[] = $row3;
	}
	$subtotaldescuentosi = ($row3['totaldescuentosi']== "" ? "0.00" : $row3['totaldescuentosi']);
	$subtotalivasic = ($row3['valorneto']== "" ? "0.00" : $row3['valorneto']);
	############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############

    ############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############
	$sql4 = "SELECT SUM(totaldescuentoc) AS totaldescuentono, SUM(valorneto) AS valorneto FROM detallecompras WHERE codcompra = '".limpiar($_POST["codcompra"])."' AND ivaproductoc = 'NO'";
	foreach ($this->dbh->query($sql4) as $row4)
	{
		$this->p[] = $row4;
	}
	$subtotaldescuentono = ($row4['totaldescuentono']== "" ? "0.00" : $row4['totaldescuentono']);
	$subtotalivanoc = ($row4['valorneto']== "" ? "0.00" : $row4['valorneto']);
	############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############

   ############ ACTUALIZO LOS TOTALES EN LA COMPRA ##############
	$sql = " UPDATE compras SET "
	." codproveedor = ?, "
	." subtotalivasic = ?, "
	." subtotalivanoc = ?, "
	." totalivac = ?, "
	." descontadoc = ?, "
	." descuentoc = ?, "
	." totaldescuentoc = ?, "
	." totalpagoc = ?, "
	." tipocompra = ?, "
	." formacompra = ?, "
	." fechavencecredito = ?, "
	." observaciones = ?, "
	." fechaemision = ?, "
	." fecharecepcion = ? "
	." WHERE "
	." codcompra = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $codproveedor);
	$stmt->bindParam(2, $subtotalivasic);
	$stmt->bindParam(3, $subtotalivanoc);
	$stmt->bindParam(4, $totalivac);
	$stmt->bindParam(5, $descontadoc);
	$stmt->bindParam(6, $descuentoc);
	$stmt->bindParam(7, $totaldescuentoc);
	$stmt->bindParam(8, $totalpagoc);
	$stmt->bindParam(9, $tipocompra);
	$stmt->bindParam(10, $formacompra);
	$stmt->bindParam(11, $fechavencecredito);
	$stmt->bindParam(12, $observaciones);
	$stmt->bindParam(13, $fechaemision);
	$stmt->bindParam(14, $fecharecepcion);
	$stmt->bindParam(15, $codcompra);

	$codproveedor = limpiar($_POST["codproveedor"]);
	$ivac = $_POST["iva"]/100;
	$totalivac = number_format($subtotalivasic*$ivac, 2, '.', '');
	$descontadoc = number_format($subtotaldescuentosi+$subtotaldescuentono, 2, '.', '');
	$descuentoc = limpiar($_POST["descuento"]);
    $txtDescuento = $_POST["descuento"]/100;

    $total = number_format($subtotalivasic+$subtotalivanoc+$totalivac, 2, '.', '');
    $totaldescuentoc = number_format($total*$txtDescuento, 2, '.', '');
    $totalpagoc = number_format($total-$totaldescuentoc, 2, '.', '');

	$tipocompra = limpiar($_POST["tipocompra"]);
	$formacompra = limpiar($_POST["tipocompra"]=="CONTADO" ? $_POST["formacompra"] : "CREDITO");
	$fechavencecredito = limpiar($_POST["tipocompra"]=="CREDITO" ? date("Y-m-d",strtotime($_POST['fechavencecredito'])) : "0000-00-00");
	$observaciones = limpiar($_POST["observaciones"]);
	$statuscompra = limpiar($_POST["tipocompra"]=="CONTADO" ? "PAGADA" : "PENDIENTE");			
	$fechaemision = limpiar(date("Y-m-d",strtotime($_POST['fechaemision'])));
	$fecharecepcion = limpiar(date("Y-m-d",strtotime($_POST['fecharecepcion'])));
	$codcompra = limpiar($_POST["codcompra"]);
	$stmt->execute();


    echo "<span class='fa fa-check-square-o'></span> LA COMPRA DE PRODUCTOS E INGREDIENTES HA SIDO ACTUALIZADA EXITOSAMENTE <a href='reportepdf?codcompra=".encrypt($codcompra)."&tipo=".encrypt("FACTURACOMPRA")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR REPORTE</strong></font color></a></div>";
	exit;
}
############################# FUNCION ACTUALIZAR COMPRAS #########################

########################## FUNCION ELIMINAR DETALLES COMPRAS ########################
public function EliminarDetallesCompras()
{
    self::SetNames();
	if ($_SESSION["acceso"]=="administrador") {

	$sql = "SELECT * FROM detallecompras WHERE codcompra = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcompra"])));
	$num = $stmt->rowCount();
	if($num > 1)
	{

		$sql = "SELECT 
		tipoentrada, 
		codproducto, 
		cantcompra, 
		preciocomprac, 
		ivaproductoc, 
		descproductoc 
		FROM detallecompras 
		WHERE coddetallecompra = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["coddetallecompra"])));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$tipoentrada = $row['tipoentrada'];
		$codproducto = $row['codproducto'];
		$cantidadbd = $row['cantcompra'];
		$preciocomprabd = $row['preciocomprac'];
		$ivaproductobd = $row['ivaproductoc'];
		$descproductobd = $row['descproductoc'];

 	if(limpiar($tipoentrada)=="PRODUCTO"){

		$sql2 = "SELECT existencia FROM productos WHERE codproducto = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute(array($codproducto));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$existenciaproductobd = $row['existencia'];

		############# ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############
		$sql = "UPDATE productos SET "
		." existencia = ? "
		." WHERE "
		." codproducto = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$stmt->bindParam(2, $codproducto);

		$existencia = limpiar(number_format($existenciaproductobd-$cantidadbd, 2, '.', ''));
		$stmt->execute();
		############# ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############


	    ########## REGISTRAMOS LOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ##########
		$query = "INSERT INTO kardex_productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcompra);
		$stmt->bindParam(2, $codproveedor);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);		

		$codcompra = limpiar(decrypt($_GET["codcompra"]));
	    $codproveedor = limpiar(decrypt($_GET["codproveedor"]));
		$movimiento = limpiar("DEVOLUCION");
		$entradas= limpiar("0");
		$salidas = limpiar("0");
		$devolucion = limpiar(number_format($cantidadbd, 2, '.', ''));
		$stockactual = limpiar(number_format($existenciaproductobd-$cantidadbd, 2, '.', ''));
		$precio = limpiar($preciocomprabd);
		$ivaproducto = limpiar($ivaproductobd);
		$descproducto = limpiar($descproductobd);
		$documento = limpiar("DEVOLUCION COMPRA");
		$fechakardex = limpiar(date("Y-m-d"));
		$stmt->execute();
		########## REGISTRAMOS LOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ##########

	} else {

		############### VERIFICO LA EXISTENCIA DEL INGREDIENTE EN ALMACEN ################
		$sql2 = "SELECT cantingrediente FROM ingredientes WHERE codingrediente = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute(array($codproducto));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$existenciaingredientebd = $row['cantingrediente'];
		############### VERIFICO LA EXISTENCIA DEL INGREDIENTE EN ALMACEN ################

		############# ACTUALIZAMOS LA EXISTENCIA DE INGREDIENTE EN ALMACEN #############
		$sql = "UPDATE ingredientes SET "
		." cantingrediente = ? "
		." WHERE "
		." codingrediente = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $cantingrediente);
		$stmt->bindParam(2, $codproducto);

		$cantingrediente = limpiar(number_format($existenciaingredientebd-$cantidadbd, 2, '.', ''));
		$stmt->execute();
		############# ACTUALIZAMOS LA EXISTENCIA DE INGREDIENTE EN ALMACEN #############

	    ########## REGISTRAMOS LOS DATOS DEL INGREDIENTE ELIMINADO EN KARDEX ##########
		$query = "INSERT INTO kardex_ingredientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcompra);
		$stmt->bindParam(2, $codproveedor);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaingrediente);
		$stmt->bindParam(10, $descingrediente);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);		

		$codcompra = limpiar(decrypt($_GET["codcompra"]));
	    $codproveedor = limpiar(decrypt($_GET["codproveedor"]));
		$movimiento = limpiar("DEVOLUCION");
		$entradas= limpiar("0");
		$salidas = limpiar("0");
		$devolucion = limpiar(number_format($cantidadbd, 2, '.', ''));
		$stockactual = limpiar(number_format($existenciaingredientebd-$cantidadbd, 2, '.', ''));
		$ivaingrediente = limpiar($ivaproductobd);
		$descingrediente = limpiar($descproductobd);
		$precio = limpiar($preciocomprabd);
		$documento = limpiar("DEVOLUCION COMPRA");
		$fechakardex = limpiar(date("Y-m-d"));
		$stmt->execute();
		########## REGISTRAMOS LOS DATOS DEL INGREDIENTE ELIMINADO EN KARDEX ##########

	}


	########## ELIMINAMOS EL PRODUCTO EN DETALLES DE COMPRAS ###########
	$sql = "DELETE FROM detallecompras WHERE coddetallecompra = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1,$coddetallecompra);
	$coddetallecompra = decrypt($_GET["coddetallecompra"]);
	$stmt->execute();
	########## ELIMINAMOS EL PRODUCTO EN DETALLES DE COMPRAS ###########

    ############ CONSULTO LOS TOTALES DE COMPRAS ##############
    $sql2 = "SELECT ivac, descuentoc FROM compras WHERE codcompra = ?";
    $stmt = $this->dbh->prepare($sql2);
    $stmt->execute(array(decrypt($_GET["codcompra"])));
    $num = $stmt->rowCount();

	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$paea[] = $row;
	}
	$iva = $paea[0]["ivac"]/100;
    $descuento = $paea[0]["descuentoc"]/100;
    ############ CONSULTO LOS TOTALES DE COMPRAS ##############

    ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############
	$sql3 = "SELECT SUM(totaldescuentoc) AS totaldescuentosi, SUM(valorneto) AS valorneto FROM detallecompras WHERE codcompra = '".limpiar(decrypt($_GET["codcompra"]))."' AND ivaproductoc = 'SI'";
	foreach ($this->dbh->query($sql3) as $row3)
	{
		$this->p[] = $row3;
	}
	$subtotaldescuentosi = ($row3['totaldescuentosi']== "" ? "0.00" : $row3['totaldescuentosi']);
	$subtotalivasic = ($row3['valorneto']== "" ? "0.00" : $row3['valorneto']);
	############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############

    ############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############
	$sql4 = "SELECT SUM(totaldescuentoc) AS totaldescuentono, SUM(valorneto) AS valorneto FROM detallecompras WHERE codcompra = '".limpiar(decrypt($_GET["codcompra"]))."' AND ivaproductoc = 'NO'";
	foreach ($this->dbh->query($sql4) as $row4)
	{
		$this->p[] = $row4;
	}
	$subtotaldescuentono = ($row4['totaldescuentono']== "" ? "0.00" : $row4['totaldescuentono']);
	$subtotalivanoc = ($row4['valorneto']== "" ? "0.00" : $row4['valorneto']);
	############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############

    ############ ACTUALIZO LOS TOTALES EN LA COMPRAS ##############
	$sql = " UPDATE compras SET "
	." subtotalivasic = ?, "
	." subtotalivanoc = ?, "
	." totalivac = ?, "
	." descontadoc = ?, "
	." totaldescuentoc = ?, "
	." totalpagoc = ? "
	." WHERE "
	." codcompra = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $subtotalivasic);
	$stmt->bindParam(2, $subtotalivanoc);
	$stmt->bindParam(3, $totalivac);
	$stmt->bindParam(4, $descontadoc);
	$stmt->bindParam(5, $totaldescuentoc);
	$stmt->bindParam(6, $totalpagoc);
	$stmt->bindParam(7, $codcompra);

	$totalivac= number_format($subtotalivasic*$iva, 2, '.', '');
	$descontadoc = number_format($subtotaldescuentosi+$subtotaldescuentono, 2, '.', '');
    $total= number_format($subtotalivasic+$subtotalivanoc+$totalivac, 2, '.', '');
    $totaldescuentoc = number_format($total*$descuento, 2, '.', '');
    $totalpagoc = number_format($total-$totaldescuentoc, 2, '.', '');
	$codcompra = limpiar(decrypt($_GET["codcompra"]));
	$stmt->execute();

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
	} 
			
	} else {
		
		echo "3";
		exit;
	}	
}
###################### FUNCION ELIMINAR DETALLES COMPRAS #######################

####################### FUNCION ELIMINAR COMPRAS #################################
public function EliminarCompras()
	{
	self::SetNames();
	if ($_SESSION["acceso"]=="administrador") {

	$sql = "SELECT tipoentrada, codproducto, cantcompra, preciocomprac, ivaproductoc, descproductoc FROM detallecompras WHERE codcompra = '".limpiar(decrypt($_GET["codcompra"]))."'";

	$array=array();

	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;

		$tipoentrada = $row['tipoentrada'];
		$codproducto = $row['codproducto'];
		$cantidadbd = $row['cantcompra'];
		$preciocomprabd = $row['preciocomprac'];
		$ivaproductobd = $row['ivaproductoc'];
		$descproductobd = $row['descproductoc'];

	if(limpiar($tipoentrada)=="PRODUCTO"){

		$sql2 = "SELECT existencia FROM productos WHERE codproducto = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute( array($codproducto));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$existenciaproductobd = $row['existencia'];

		########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############
		$sql = "UPDATE productos SET "
		." existencia = ? "
		." WHERE "
		." codproducto = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$stmt->bindParam(2, $codproducto);

		$existencia = limpiar(number_format($existenciaproductobd-$cantidadbd, 2, '.', ''));
		$stmt->execute();

	    ########## REGISTRAMOS LOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ##########
		$query = "INSERT INTO kardex_productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcompra);
		$stmt->bindParam(2, $codproveedor);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);		

		$codcompra = limpiar(decrypt($_GET["codcompra"]));
	    $codproveedor = limpiar(decrypt($_GET["codproveedor"]));
		$movimiento = limpiar("DEVOLUCION");
		$entradas= limpiar("0");
		$salidas = limpiar("0");
		$devolucion = limpiar($cantidadbd);
		$stockactual = limpiar($existenciaproductobd-$cantidadbd);
		$precio = limpiar($preciocomprabd);
		$ivaproducto = limpiar($ivaproductobd);
		$descproducto = limpiar($descproductobd);
		$documento = limpiar("DEVOLUCION COMPRA");
		$fechakardex = limpiar(date("Y-m-d"));
		$stmt->execute();

	} else {

		############### VERIFICO LA EXISTENCIA DEL INGREDIENTE EN ALMACEN ################
		$sql2 = "SELECT cantingrediente FROM ingredientes WHERE codingrediente = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute(array($codproducto));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$existenciaingredientebd = $row['cantingrediente'];

		############# ACTUALIZAMOS LA EXISTENCIA DE INGREDIENTE EN ALMACEN #############
		$sql = "UPDATE ingredientes SET "
		." cantingrediente = ? "
		." WHERE "
		." codingrediente = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$stmt->bindParam(2, $codproducto);

		$existencia = limpiar(number_format($existenciaingredientebd-$cantidadbd, 2, '.', ''));
		$stmt->execute();

	    ########## REGISTRAMOS LOS DATOS DEL INGREDIENTE ELIMINADO EN KARDEX ##########
		$query = "INSERT INTO kardex_ingredientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcompra);
		$stmt->bindParam(2, $codproveedor);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaingrediente);
		$stmt->bindParam(10, $descingrediente);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);		

		$codcompra = limpiar(decrypt($_GET["codcompra"]));
	    $codproveedor = limpiar(decrypt($_GET["codproveedor"]));
		$movimiento = limpiar("DEVOLUCION");
		$entradas= limpiar("0");
		$salidas = limpiar("0");
		$devolucion = limpiar($cantidadbd);
		$stockactual = limpiar(number_format($existenciaingredientebd-$cantidadbd, 2, '.', ''));
		$ivaingrediente = limpiar($ivaproductobd);
		$descingrediente = limpiar($descproductobd);
		$precio = limpiar($preciocomprabd);
		$documento = limpiar("DEVOLUCION COMPRA");
		$fechakardex = limpiar(date("Y-m-d"));
		$stmt->execute();

		}

	}

		$sql = "DELETE FROM compras WHERE codcompra = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codcompra);
		$codcompra = decrypt($_GET["codcompra"]);
		$stmt->execute();

		$sql = "DELETE FROM detallecompras WHERE codcompra = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codcompra);
		$codcompra = decrypt($_GET["codcompra"]);
		$stmt->execute();

		echo "1";
		exit;

	} else {

		echo "2";
		exit;
	}
}
######################### FUNCION ELIMINAR COMPRAS #################################

##################### FUNCION BUSQUEDA COMPRAS POR PROVEEDORES ###################
public function BuscarComprasxProveedor() 
{
	self::SetNames();
	$sql = "SELECT 
	compras.codcompra,
	compras.codproveedor, 
	compras.subtotalivasic,
	compras.subtotalivanoc, 
	compras.ivac,
	compras.totalivac,
	compras.descontadoc, 
	compras.descuentoc,
	compras.totaldescuentoc, 
	compras.totalpagoc, 
	compras.tipocompra,
	compras.formacompra,
	compras.fechavencecredito,
    compras.fechapagado,
    compras.observaciones,
	compras.statuscompra,
	compras.fechaemision,
	compras.fecharecepcion,
	proveedores.documproveedor,
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	proveedores.tlfproveedor, 
	proveedores.id_provincia, 
	proveedores.id_departamento, 
	proveedores.direcproveedor, 
	proveedores.emailproveedor,
	proveedores.vendedor,
	proveedores.tlfvendedor,
    documentos.documento,
	provincias.provincia,
	departamentos.departamento, 
	SUM(detallecompras.cantcompra) as articulos 
	FROM (compras LEFT JOIN detallecompras ON compras.codcompra=detallecompras.codcompra) 
	INNER JOIN proveedores ON compras.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos ON proveedores.documproveedor = documentos.coddocumento
	LEFT JOIN provincias ON proveedores.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON proveedores.id_departamento = departamentos.id_departamento 
	WHERE compras.codproveedor = ? GROUP BY detallecompras.codcompra";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codproveedor"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
################### FUNCION BUSQUEDA COMPRAS POR PROVEEDORES ###################

###################### FUNCION BUSQUEDA COMPRAS POR FECHAS ###########################
public function BuscarComprasxFechas() 
{
	self::SetNames();
	$sql ="SELECT 
	compras.codcompra,
	compras.codproveedor, 
	compras.subtotalivasic,
	compras.subtotalivanoc, 
	compras.ivac,
	compras.totalivac,
	compras.descontadoc, 
	compras.descuentoc,
	compras.totaldescuentoc, 
	compras.totalpagoc, 
	compras.tipocompra,
	compras.formacompra,
	compras.fechavencecredito,
    compras.fechapagado,
    compras.observaciones,
	compras.statuscompra,
	compras.fechaemision,
	compras.fecharecepcion,
	proveedores.documproveedor,
	proveedores.cuitproveedor, 
	proveedores.nomproveedor, 
	proveedores.tlfproveedor, 
	proveedores.id_provincia, 
	proveedores.id_departamento, 
	proveedores.direcproveedor, 
	proveedores.emailproveedor,
	proveedores.vendedor,
	proveedores.tlfvendedor,
    documentos.documento,
	provincias.provincia,
	departamentos.departamento, 
	SUM(detallecompras.cantcompra) as articulos 
	FROM (compras LEFT JOIN detallecompras ON compras.codcompra=detallecompras.codcompra) 
	INNER JOIN proveedores ON compras.codproveedor = proveedores.codproveedor 
	LEFT JOIN documentos ON proveedores.documproveedor = documentos.coddocumento
	LEFT JOIN provincias ON proveedores.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON proveedores.id_departamento = departamentos.id_departamento
	 WHERE DATE_FORMAT(compras.fecharecepcion,'%Y-%m-%d') >= ? AND DATE_FORMAT(compras.fecharecepcion,'%Y-%m-%d') <= ? GROUP BY detallecompras.codcompra";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA COMPRAS POR FECHAS ###########################

############################# FIN DE CLASE COMPRAS ###################################





























############################## CLASE COTIZACIONES ###################################

########################### FUNCION REGISTRAR COTIZACIONES ##########################
public function RegistrarCotizaciones()
	{
	self::SetNames();
	if(empty($_POST["txtTotal"]))
	{
		echo "1";
		exit;
	}

	if(empty($_SESSION["CarritoCotizacion"]))
	{
		echo "2";
		exit;
	}

    ################### CREO CODIGO DE FACTURA ####################
	$sql4 = "SELECT codcotizacion FROM cotizaciones 
	ORDER BY idcotizacion DESC LIMIT 1";
	foreach ($this->dbh->query($sql4) as $row4){

		$cotizacion=$row4["codcotizacion"];

	}
	if(empty($cotizacion))
	{
		$codcotizacion = "0000000001";

	} else {

        $var1 = substr($cotizacion , 0);
        $var2 = strlen($var1);
        $var3 = $var1 + 1;
        $var4 = str_pad($var3, $var2, "0", STR_PAD_LEFT);
        $codcotizacion = $var4;
	}
	################### CREO CODIGO DE FACTURA ####################

    $query = "INSERT INTO cotizaciones values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codcotizacion);
	$stmt->bindParam(2, $codcliente);
	$stmt->bindParam(3, $subtotalivasi);
	$stmt->bindParam(4, $subtotalivano);
	$stmt->bindParam(5, $iva);
	$stmt->bindParam(6, $totaliva);
	$stmt->bindParam(7, $descontado);
	$stmt->bindParam(8, $descuento);
	$stmt->bindParam(9, $totaldescuento);
	$stmt->bindParam(10, $totalpago);
	$stmt->bindParam(11, $totalpago2);
	$stmt->bindParam(12, $observaciones);
	$stmt->bindParam(13, $fechacotizacion);
	$stmt->bindParam(14, $codigo);
    
	$codcliente = limpiar($_POST["codcliente"]);
	$subtotalivasi = limpiar($_POST["txtsubtotal"]);
	$subtotalivano = limpiar($_POST["txtsubtotal2"]);
	$iva = limpiar($_POST["iva"]);
	$totaliva = limpiar($_POST["txtIva"]);
	$descontado = limpiar($_POST["txtdescontado"]);
	$descuento = limpiar($_POST["descuento"]);
	$totaldescuento = limpiar($_POST["txtDescuento"]);
	$totalpago = limpiar($_POST["txtTotal"]);
	$totalpago2 = limpiar($_POST["txtTotalCompra"]);
	$observaciones = limpiar($_POST["observaciones"]);
    $fechacotizacion = limpiar(date("Y-m-d H:i:s"));
	$codigo = limpiar($_SESSION["codigo"]);
	$stmt->execute();
	
	$this->dbh->beginTransaction();
	$detalle = $_SESSION["CarritoCotizacion"];
	for($i=0;$i<count($detalle);$i++){

	$query = "INSERT INTO detallecotizaciones values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codcotizacion);
    $stmt->bindParam(2, $idproducto);
    $stmt->bindParam(3, $codproducto);
    $stmt->bindParam(4, $producto);
    $stmt->bindParam(5, $codcategoria);
	$stmt->bindParam(6, $cantidad);
	$stmt->bindParam(7, $preciocompra);
	$stmt->bindParam(8, $precioventa);
	$stmt->bindParam(9, $ivaproducto);
	$stmt->bindParam(10, $descproducto);
	$stmt->bindParam(11, $valortotal);
	$stmt->bindParam(12, $totaldescuentov);
	$stmt->bindParam(13, $valorneto);
	$stmt->bindParam(14, $valorneto2);
	$stmt->bindParam(15, $detallesobservaciones);
	$stmt->bindParam(16, $tipo);
		
	$idproducto = limpiar($detalle[$i]['id']);
	$codproducto = limpiar($detalle[$i]['txtCodigo']);
	$producto = limpiar($detalle[$i]['producto']);
	$codcategoria = limpiar($detalle[$i]['codcategoria']);
	$cantidad = number_format($detalle[$i]['cantidad'], 2, '.', '');
	$preciocompra = limpiar($detalle[$i]['precio']);
	$precioventa = limpiar($detalle[$i]['precio2']);
	$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
	$descproducto = limpiar($detalle[$i]['descproducto']);
	$descuento = $detalle[$i]['descproducto']/100;
	$valortotal = number_format($detalle[$i]['precio2']*$detalle[$i]['cantidad'], 2, '.', '');
	$totaldescuentov = number_format($valortotal*$descuento, 2, '.', '');
    $valorneto = number_format($valortotal-$totaldescuentov, 2, '.', '');
	$valorneto2 = number_format($detalle[$i]['precio']*$detalle[$i]['cantidad'], 2, '.', '');
	$detallesobservaciones = limpiar($detalle[$i]['observacion'] == ", " ? "" : $detalle[$i]['observacion']);
	$tipo = limpiar($detalle[$i]['tipo']);
	$stmt->execute();
    }
        
    ####################### DESTRUYO LA VARIABLE DE SESSION #####################
	unset($_SESSION["CarritoCotizacion"]);
    $this->dbh->commit();
		
echo "<span class='fa fa-check-square-o'></span> LA COTIZACI&Oacute;N DE PRODUCTOS HA SIDO REGISTRADA EXITOSAMENTE <a href='reportepdf?codcotizacion=".encrypt($codcotizacion)."&tipo=".encrypt("FACTURACOTIZACION")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR REPORTE</strong></font color></a></div>";

echo "<script>window.open('reportepdf?codcotizacion=".encrypt($codcotizacion)."&tipo=".encrypt("FACTURACOTIZACION")."', '_blank');</script>";
	exit;
}
########################## FUNCION REGISTRAR COTIZACIONES ############################

########################## FUNCION BUSQUEDA DE COTIZACIONES ###############################
public function BusquedaCotizaciones() 
{
	self::SetNames();
  	$sql ="SELECT 
	cotizaciones.idcotizacion, 
	cotizaciones.codcotizacion,  
	cotizaciones.codcliente, 
	cotizaciones.subtotalivasi, 
	cotizaciones.subtotalivano, 
	cotizaciones.iva, 
	cotizaciones.totaliva, 
	cotizaciones.descontado,
	cotizaciones.descuento, 
	cotizaciones.totaldescuento,
	cotizaciones.totalpago, 
	cotizaciones.totalpago2, 
	cotizaciones.observaciones,
	cotizaciones.fechacotizacion, 
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,  
	SUM(detallecotizaciones.cantcotizacion) AS articulos 
	FROM (cotizaciones LEFT JOIN detallecotizaciones ON detallecotizaciones.codcotizacion = cotizaciones.codcotizacion) 
	LEFT JOIN clientes ON cotizaciones.codcliente = clientes.codcliente
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	LEFT JOIN usuarios ON cotizaciones.codigo = usuarios.codigo
	WHERE CONCAT(cotizaciones.codcotizacion, ' ',if(cotizaciones.codcliente='0','0',clientes.dnicliente), ' ',if(cotizaciones.codcliente='0','0',clientes.nomcliente), ' ',if(cotizaciones.codcliente='0','0',clientes.girocliente)) LIKE '%".limpiar($_GET['bcotizaciones'])."%'
	GROUP BY detallecotizaciones.codcotizacion 
	ORDER BY cotizaciones.idcotizacion ASC LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS PARA TU BUSQUEDA REALIZADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
    }
}
########################## FUNCION BUSQUEDA DE COTIZACIONES ###############################

####################### FUNCION LISTAR COTIZACIONES ################################
public function ListarCotizaciones()
{
	self::SetNames();

	if($_SESSION["acceso"] == "cajero" || $_SESSION["acceso"] == "anfitrion") {

    $sql = "SELECT 
	cotizaciones.idcotizacion, 
	cotizaciones.codcotizacion, 
	cotizaciones.codcliente, 
	cotizaciones.subtotalivasi, 
	cotizaciones.subtotalivano, 
	cotizaciones.iva, 
	cotizaciones.totaliva,
	cotizaciones.descontado, 
	cotizaciones.descuento, 
	cotizaciones.totaldescuento,
	cotizaciones.totalpago, 
	cotizaciones.totalpago2, 
	cotizaciones.observaciones,
	cotizaciones.fechacotizacion,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,  
	SUM(detallecotizaciones.cantcotizacion) AS articulos 
	FROM (cotizaciones LEFT JOIN detallecotizaciones ON detallecotizaciones.codcotizacion = cotizaciones.codcotizacion) 
	LEFT JOIN clientes ON cotizaciones.codcliente = clientes.codcliente
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	LEFT JOIN usuarios ON cotizaciones.codigo = usuarios.codigo 
	WHERE cotizaciones.codigo = '".limpiar($_SESSION["codigo"])."' 
	GROUP BY detallecotizaciones.codcotizacion 
	ORDER BY cotizaciones.idcotizacion ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
		return $this->p;
		$this->dbh=null;

	} else {

	$sql = "SELECT 
	cotizaciones.idcotizacion, 
	cotizaciones.codcotizacion, 
	cotizaciones.codcliente, 
	cotizaciones.subtotalivasi, 
	cotizaciones.subtotalivano, 
	cotizaciones.iva, 
	cotizaciones.totaliva,
	cotizaciones.descontado, 
	cotizaciones.descuento, 
	cotizaciones.totaldescuento,
	cotizaciones.totalpago, 
	cotizaciones.totalpago2,
	cotizaciones.observaciones, 
	cotizaciones.fechacotizacion, 
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,  
	SUM(detallecotizaciones.cantcotizacion) AS articulos 
	FROM (cotizaciones LEFT JOIN detallecotizaciones ON detallecotizaciones.codcotizacion = cotizaciones.codcotizacion) 
	LEFT JOIN clientes ON cotizaciones.codcliente = clientes.codcliente
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	LEFT JOIN usuarios ON cotizaciones.codigo = usuarios.codigo 
	GROUP BY detallecotizaciones.codcotizacion
	ORDER BY cotizaciones.idcotizacion ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

    }
}
######################### FUNCION LISTAR COTIZACIONES ############################

############################ FUNCION ID COTIZACIONES #################################
public function CotizacionesPorId()
	{
	self::SetNames();
	$sql = " SELECT 
	cotizaciones.idcotizacion, 
	cotizaciones.codcotizacion, 
	cotizaciones.codcliente, 
	cotizaciones.subtotalivasi,
	cotizaciones.subtotalivano, 
	cotizaciones.iva,
	cotizaciones.totaliva,
    cotizaciones.descontado, 
	cotizaciones.descuento,
	cotizaciones.totaldescuento, 
	cotizaciones.totalpago, 
	cotizaciones.totalpago2,
    cotizaciones.observaciones,
	cotizaciones.fechacotizacion,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	usuarios.dni, 
	usuarios.nombres,
	provincias.provincia,
	departamentos.departamento
	FROM (cotizaciones LEFT JOIN clientes ON cotizaciones.codcliente = clientes.codcliente)  
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento
	LEFT JOIN usuarios ON cotizaciones.codigo = usuarios.codigo
	WHERE cotizaciones.codcotizacion = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcotizacion"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID COTIZACIONES #################################
	
######################## FUNCION VER DETALLES COTIZACIONES ############################
public function VerDetallesCotizaciones()
	{
	self::SetNames();
	$sql = "SELECT
	detallecotizaciones.coddetallecotizacion,
	detallecotizaciones.codcotizacion,
	detallecotizaciones.coddetallecotizacion,
	detallecotizaciones.idproducto,
	detallecotizaciones.codproducto,
	detallecotizaciones.codcategoria,
	detallecotizaciones.producto,
	detallecotizaciones.cantcotizacion,
	detallecotizaciones.preciocompra,
	detallecotizaciones.precioventa,
	detallecotizaciones.ivaproducto,
	detallecotizaciones.descproducto,
	detallecotizaciones.valortotal, 
	detallecotizaciones.totaldescuentov,
	detallecotizaciones.valorneto,
	detallecotizaciones.valorneto2,
	detallecotizaciones.detallesobservaciones,
	detallecotizaciones.tipo,
	categorias.nomcategoria
	FROM detallecotizaciones 
	LEFT JOIN categorias ON detallecotizaciones.codcategoria = categorias.codcategoria
	WHERE detallecotizaciones.codcotizacion = ? ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcotizacion"])));
	$num = $stmt->rowCount();
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$this->p[]=$row;
	}
	return $this->p;
	$this->dbh=null;
}
##################### FUNCION VER DETALLES COTIZACIONES #########################

######################## FUNCION ACTUALIZAR COTIZACIONES #######################
public function ActualizarCotizaciones()
	{
	self::SetNames();
	if(empty($_POST["codcotizacion"]))
	{
		echo "1";
		exit;
	}

	for($i=0;$i<count($_POST['coddetallecotizacion']);$i++){  //recorro el array
        if (!empty($_POST['coddetallecotizacion'][$i])) {

	       if($_POST['cantcotizacion'][$i]==0){

		      echo "2";
		      exit();

	       }
        }
    }

	$this->dbh->beginTransaction();
	for($i=0;$i<count($_POST['coddetallecotizacion']);$i++){  //recorro el array
	if (!empty($_POST['coddetallecotizacion'][$i])) {

	$sql = "SELECT cantcotizacion 
	FROM detallecotizaciones 
	WHERE coddetallecotizacion = '".limpiar($_POST['coddetallecotizacion'][$i])."' 
	AND codcotizacion = '".limpiar($_POST["codcotizacion"])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
		
	$cantidadbd = $row['cantcotizacion'];

	if($cantidadbd != $_POST['cantcotizacion'][$i]){

		$query = "UPDATE detallecotizaciones set"
		." cantcotizacion = ?, "
		." valortotal = ?, "
		." totaldescuentov = ?, "
		." valorneto = ?, "
		." valorneto2 = ? "
		." WHERE "
		." coddetallecotizacion = ? AND codcotizacion = ?;
		";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $cantcotizacion);
		$stmt->bindParam(2, $valortotal);
		$stmt->bindParam(3, $totaldescuentov);
		$stmt->bindParam(4, $valorneto);
		$stmt->bindParam(5, $valorneto2);
		$stmt->bindParam(6, $coddetallecotizacion);
		$stmt->bindParam(7, $codcotizacion);

		$cantcotizacion = limpiar($_POST['cantcotizacion'][$i]);
		$preciocompra = limpiar($_POST['preciocompra'][$i]);
		$precioventa = limpiar($_POST['precioventa'][$i]);
		$ivaproducto = limpiar($_POST['ivaproducto'][$i]);
		$descuento = $_POST['descproducto'][$i]/100;
		$valortotal = number_format($_POST['valortotal'][$i], 2, '.', '');
		$totaldescuento = number_format($_POST['totaldescuentov'][$i], 2, '.', '');
		$valorneto = number_format($_POST['valorneto'][$i], 2, '.', '');
		$valorneto2 = number_format($_POST['valorneto2'][$i], 2, '.', '');
		$coddetallecotizacion = limpiar($_POST['coddetallecotizacion'][$i]);
		$codcotizacion = limpiar($_POST["codcotizacion"]);
		$stmt->execute();

		} else {

           echo "";

	       }
        }
    }
    $this->dbh->commit();

    ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############
	$sql3 = "SELECT SUM(totaldescuentov) AS totaldescuentosi, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detallecotizaciones WHERE codcotizacion = '".limpiar($_POST["codcotizacion"])."' AND ivaproducto = 'SI'";
	foreach ($this->dbh->query($sql3) as $row3)
	{
		$this->p[] = $row3;
	}
	$subtotaldescuentosi = ($row3['totaldescuentosi']== "" ? "0.00" : $row3['totaldescuentosi']);
	$subtotalivasi = ($row3['valorneto']== "" ? "0.00" : $row3['valorneto']);
	$subtotalivasi2 = ($row3['valorneto2']== "" ? "0.00" : $row3['valorneto2']);

    ############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############
	$sql4 = "SELECT SUM(totaldescuentov) AS totaldescuentono, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detallecotizaciones WHERE codcotizacion = '".limpiar($_POST["codcotizacion"])."' AND ivaproducto = 'NO'";
	foreach ($this->dbh->query($sql4) as $row4)
	{
		$this->p[] = $row4;
	}
	$subtotaldescuentono = ($row4['totaldescuentono']== "" ? "0.00" : $row4['totaldescuentono']);
	$subtotalivano = ($row4['valorneto']== "" ? "0.00" : $row4['valorneto']);
	$subtotalivano2 = ($row4['valorneto2']== "" ? "0.00" : $row4['valorneto2']);

    ############ ACTUALIZO LOS TOTALES EN LA COTIZACION ##############
	$sql = " UPDATE cotizaciones SET "
	." codcliente = ?, "
	." observaciones = ?, "
	." subtotalivasi = ?, "
	." subtotalivano = ?, "
	." totaliva = ?, "
	." descontado = ?, "
	." descuento = ?, "
	." totaldescuento = ?, "
	." totalpago = ?, "
	." totalpago2= ? "
	." WHERE "
	." codcotizacion = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $codcliente);
	$stmt->bindParam(2, $observaciones);
	$stmt->bindParam(3, $subtotalivasi);
	$stmt->bindParam(4, $subtotalivano);
	$stmt->bindParam(5, $totaliva);
	$stmt->bindParam(6, $descontado);
	$stmt->bindParam(7, $descuento);
	$stmt->bindParam(8, $totaldescuento);
	$stmt->bindParam(9, $totalpago);
	$stmt->bindParam(10, $totalpago2);
	$stmt->bindParam(11, $codcotizacion);

	$codcliente = limpiar($_POST["codcliente"]);
	$observaciones = limpiar($_POST["observaciones"]);
	$iva = $_POST["iva"]/100;
	$totaliva = number_format($subtotalivasi*$iva, 2, '.', '');
	$descontado = number_format($subtotaldescuentosi+$subtotaldescuentono, 2, '.', '');
	$descuento = limpiar($_POST["descuento"]);
    $txtDescuento = $_POST["descuento"]/100;
    $total = number_format($subtotalivasi+$subtotalivano+$totaliva, 2, '.', '');
    $totaldescuento = number_format($total*$txtDescuento, 2, '.', '');
    $totalpago = number_format($total-$totaldescuento, 2, '.', '');
	$totalpago2 = number_format($subtotalivasi2+$subtotalivano2, 2, '.', '');
	$codcotizacion = limpiar($_POST["codcotizacion"]);
	$stmt->execute();

echo "<span class='fa fa-check-square-o'></span> LA COTIZACI&Oacute;N DE PRODUCTOS HA SIDO ACTUALIZADA EXITOSAMENTE <a href='reportepdf?codcotizacion=".encrypt($codcotizacion)."&tipo=".encrypt("FACTURACOTIZACION")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR REPORTE</strong></font color></a></div>";

echo "<script>window.open('reportepdf?codcotizacion=".encrypt($codcotizacion)."&tipo=".encrypt("FACTURACOTIZACION")."', '_blank');</script>";
	exit;
}
####################### FUNCION ACTUALIZAR COTIZACIONES ############################

####################### FUNCION AGREGAR DETALLES COTIZACIONES ########################
public function AgregarDetallesCotizaciones()
	{
	self::SetNames();
	if(empty($_POST["codcotizacion"]))
	{
		echo "1";
		exit;
	}

    if(empty($_SESSION["CarritoCotizacion"]))
	{
		echo "2";
		exit;
		
	}

    $this->dbh->beginTransaction();
    $detalle = $_SESSION["CarritoCotizacion"];
	for($i=0;$i<count($detalle);$i++){

	$sql = "SELECT codcotizacion, codproducto FROM detallecotizaciones WHERE codcotizacion = '".limpiar($_POST['codcotizacion'])."' AND codproducto = '".limpiar($detalle[$i]['txtCodigo'])."'";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num == 0)
		{

        $query = "INSERT INTO detallecotizaciones values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcotizacion);
	    $stmt->bindParam(2, $idproducto);
	    $stmt->bindParam(3, $codproducto);
	    $stmt->bindParam(4, $producto);
	    $stmt->bindParam(5, $codcategoria);
		$stmt->bindParam(6, $cantidad);
		$stmt->bindParam(7, $preciocompra);
		$stmt->bindParam(8, $precioventa);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $valortotal);
		$stmt->bindParam(12, $totaldescuentov);
		$stmt->bindParam(13, $valorneto);
		$stmt->bindParam(14, $valorneto2);
		$stmt->bindParam(15, $detallesobservaciones);
		$stmt->bindParam(16, $tipo);
			
		$codcotizacion = limpiar($_POST["codcotizacion"]);
		$idproducto = limpiar($detalle[$i]['id']);
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$producto = limpiar($detalle[$i]['producto']);
		$codcategoria = limpiar($detalle[$i]['codcategoria']);
		$cantidad = number_format($detalle[$i]['cantidad'], 2, '.', '');
		$preciocompra = limpiar($detalle[$i]['precio']);
		$precioventa = limpiar($detalle[$i]['precio2']);
		$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
		$descproducto = limpiar($detalle[$i]['descproducto']);
		$descuento = $detalle[$i]['descproducto']/100;
		$valortotal = number_format($detalle[$i]['precio2']*$detalle[$i]['cantidad'], 2, '.', '');
		$totaldescuentov = number_format($valortotal*$descuento, 2, '.', '');
	    $valorneto = number_format($valortotal-$totaldescuentov, 2, '.', '');
		$valorneto2 = number_format($detalle[$i]['precio']*$detalle[$i]['cantidad'], 2, '.', '');
	    $detallesobservaciones = limpiar($detalle[$i]['observacion'] == ", " ? "" : $detalle[$i]['observacion']);
	    $tipo = limpiar($detalle[$i]['tipo']);
		$stmt->execute();

	  } else {

	  	$sql = "SELECT cantcotizacion FROM detallecotizaciones WHERE codcotizacion = '".limpiar($_POST['codcotizacion'])."' AND codproducto = '".limpiar($detalle[$i]['txtCodigo'])."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$cantidad = $row['cantcotizacion'];

	  	$query = "UPDATE detallecotizaciones set"
		." cantcotizacion = ?, "
		." descproducto = ?, "
		." valortotal = ?, "
		." totaldescuentov = ?, "
		." valorneto = ?, "
		." valorneto2 = ? "
		." WHERE "
		." codcotizacion = ? AND codproducto = ?;
		";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $cantcotizacion);
		$stmt->bindParam(2, $descproducto);
		$stmt->bindParam(3, $valortotal);
		$stmt->bindParam(4, $totaldescuentov);
		$stmt->bindParam(5, $valorneto);
		$stmt->bindParam(6, $valorneto2);
		$stmt->bindParam(7, $codcotizacion);
		$stmt->bindParam(8, $codproducto);

		$cantcotizacion = limpiar($detalle[$i]['cantidad']+$cantidad);
		$preciocompra = limpiar($detalle[$i]['precio']);
		$precioventa = limpiar($detalle[$i]['precio2']);
		$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
		$descproducto = limpiar($detalle[$i]['descproducto']);
		$descuento = $detalle[$i]['descproducto']/100;
		$valortotal = number_format($detalle[$i]['precio2'] * $cantcotizacion, 2, '.', '');
		$totaldescuentov = number_format($valortotal * $descuento, 2, '.', '');
		$valorneto = number_format($valortotal - $totaldescuentov, 2, '.', '');
		$valorneto2 = number_format($detalle[$i]['precio'] * $cantcotizacion, 2, '.', '');
		$codcotizacion = limpiar($_POST["codcotizacion"]);
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$stmt->execute();
	 }
   }    
        ####################### DESTRUYO LA VARIABLE DE SESSION #####################
	    unset($_SESSION["CarritoCotizacion"]);
        $this->dbh->commit();

        ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############
        $sql3 = "SELECT SUM(totaldescuentov) AS totaldescuentosi, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detallecotizaciones WHERE codcotizacion = '".limpiar($_POST["codcotizacion"])."' AND ivaproducto = 'SI'";
        foreach ($this->dbh->query($sql3) as $row3)
        {
        	$this->p[] = $row3;
        }
        $subtotaldescuentosi = ($row3['totaldescuentosi']== "" ? "0.00" : $row3['totaldescuentosi']);
        $subtotalivasi = ($row3['valorneto']== "" ? "0.00" : $row3['valorneto']);
        $subtotalivasi2 = ($row3['valorneto2']== "" ? "0.00" : $row3['valorneto2']);

		############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############
        $sql4 = "SELECT SUM(totaldescuentov) AS totaldescuentono, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detallecotizaciones WHERE codcotizacion = '".limpiar($_POST["codcotizacion"])."' AND ivaproducto = 'NO'";
        foreach ($this->dbh->query($sql4) as $row4)
        {
        	$this->p[] = $row4;
        }
        $subtotaldescuentono = ($row4['totaldescuentono']== "" ? "0.00" : $row4['totaldescuentono']);
        $subtotalivano = ($row4['valorneto']== "" ? "0.00" : $row4['valorneto']);
        $subtotalivano2 = ($row4['valorneto2']== "" ? "0.00" : $row4['valorneto2']);


        ############ ACTUALIZO LOS TOTALES EN LA COTIZACION ##############
        $sql = " UPDATE cotizaciones SET "
        ." codcliente = ?, "
        ." observaciones = ?, "
        ." subtotalivasi = ?, "
        ." subtotalivano = ?, "
        ." totaliva = ?, "
        ." descontado = ?, "
        ." descuento = ?, "
        ." totaldescuento = ?, "
        ." totalpago = ?, "
        ." totalpago2= ? "
        ." WHERE "
        ." codcotizacion = ?;
        ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(1, $codcliente);
        $stmt->bindParam(2, $observaciones);
        $stmt->bindParam(3, $subtotalivasi);
        $stmt->bindParam(4, $subtotalivano);
        $stmt->bindParam(5, $totaliva);
        $stmt->bindParam(6, $descontado);
        $stmt->bindParam(7, $descuento);
        $stmt->bindParam(8, $totaldescuento);
        $stmt->bindParam(9, $totalpago);
        $stmt->bindParam(10, $totalpago2);
        $stmt->bindParam(11, $codcotizacion);

        $codcliente = limpiar($_POST["codcliente"]);
        $observaciones = limpiar($_POST["observaciones"]);
        $iva = $_POST["iva"]/100;
        $totaliva = number_format($subtotalivasi*$iva, 2, '.', '');
        $descontado = number_format($subtotaldescuentosi+$subtotaldescuentono, 2, '.', '');
        $descuento = limpiar($_POST["descuento"]);
        $txtDescuento = $_POST["descuento"]/100;
        $total = number_format($subtotalivasi+$subtotalivano+$totaliva, 2, '.', '');
        $totaldescuento = number_format($total*$txtDescuento, 2, '.', '');
        $totalpago = number_format($total-$totaldescuento, 2, '.', '');
        $totalpago2 = number_format($subtotalivasi2+$subtotalivano2, 2, '.', '');
        $codcotizacion = limpiar($_POST["codcotizacion"]);
        $stmt->execute();
		

echo "<span class='fa fa-check-square-o'></span> LOS DETALLES DE PRODUCTOS FUERON AGREGADOS A LA COTIZACI&Oacute;N EXITOSAMENTE <a href='reportepdf?codcotizacion=".encrypt($codcotizacion)."&tipo=".encrypt("FACTURACOTIZACION")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR REPORTE</strong></font color></a></div>";

echo "<script>window.open('reportepdf?codcotizacion=".encrypt($codcotizacion)."&tipo=".encrypt("FACTURACOTIZACION")."', '_blank');</script>";
	exit;
}
######################### FUNCION AGREGAR DETALLES COTIZACIONES #######################

######################## FUNCION ELIMINAR DETALLES COTIZACIONES #######################
public function EliminarDetallesCotizaciones()
	{
	self::SetNames();
	if ($_SESSION["acceso"]=="administrador") {

	$sql = "SELECT * FROM detallecotizaciones WHERE codcotizacion = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcotizacion"])));
	$num = $stmt->rowCount();
	if($num > 1)
	{

		$sql = "DELETE FROM detallecotizaciones WHERE coddetallecotizacion = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$coddetallecotizacion);
		$coddetallecotizacion = decrypt($_GET["coddetallecotizacion"]);
		$stmt->execute();

	    ############ CONSULTO LOS TOTALES DE COTIZACIONES ##############
	    $sql2 = "SELECT iva, descuento FROM cotizaciones WHERE codcotizacion = ?";
	    $stmt = $this->dbh->prepare($sql2);
	    $stmt->execute(array(decrypt($_GET["codcotizacion"])));
	    $num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$paea[] = $row;
		}
		$iva = $paea[0]["iva"]/100;
	    $descuento = $paea[0]["descuento"]/100;

        ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############
		$sql3 = "SELECT SUM(totaldescuentov) AS totaldescuentosi, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detallecotizaciones WHERE codcotizacion = '".limpiar(decrypt($_GET["codcotizacion"]))."' AND ivaproducto = 'SI'";
		foreach ($this->dbh->query($sql3) as $row3)
		{
			$this->p[] = $row3;
		}
		$subtotaldescuentosi = ($row3['totaldescuentosi']== "" ? "0.00" : $row3['totaldescuentosi']);
		$subtotalivasi = ($row3['valorneto']== "" ? "0.00" : $row3['valorneto']);
		$subtotalivasi2 = ($row3['valorneto2']== "" ? "0.00" : $row3['valorneto2']);

	    ############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############
		$sql4 = "SELECT SUM(totaldescuentov) AS totaldescuentono, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detallecotizaciones WHERE codcotizacion = '".limpiar(decrypt($_GET["codcotizacion"]))."' AND ivaproducto = 'NO'";
		foreach ($this->dbh->query($sql4) as $row4)
		{
			$this->p[] = $row4;
		}
		$subtotaldescuentono = ($row4['totaldescuentono']== "" ? "0.00" : $row4['totaldescuentono']);
		$subtotalivano = ($row4['valorneto']== "" ? "0.00" : $row4['valorneto']);
		$subtotalivano2 = ($row4['valorneto2']== "" ? "0.00" : $row4['valorneto2']);

        ############ ACTUALIZO LOS TOTALES EN LA COTIZACION ##############
		$sql = " UPDATE cotizaciones SET "
		." subtotalivasi = ?, "
		." subtotalivano = ?, "
		." totaliva = ?, "
		." descontado = ?, "
		." totaldescuento = ?, "
		." totalpago = ?, "
		." totalpago2= ? "
		." WHERE "
		." codcotizacion = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $subtotalivasi);
		$stmt->bindParam(2, $subtotalivano);
		$stmt->bindParam(3, $totaliva);
		$stmt->bindParam(4, $descontado);
		$stmt->bindParam(5, $totaldescuento);
		$stmt->bindParam(6, $totalpago);
		$stmt->bindParam(7, $totalpago2);
		$stmt->bindParam(8, $codcotizacion);

		$totaliva= number_format($subtotalivasi*$iva, 2, '.', '');
		$descontado = number_format($subtotaldescuentosi+$subtotaldescuentono, 2, '.', '');
	    $total= number_format($subtotalivasi+$subtotalivano+$totaliva, 2, '.', '');
	    $totaldescuento= number_format($total*$descuento, 2, '.', '');
	    $totalpago= number_format($total-$totaldescuento, 2, '.', '');
		$totalpago2 = number_format($subtotalivasi2+$subtotalivano2, 2, '.', '');
		$codcotizacion = limpiar(decrypt($_GET["codcotizacion"]));
		$stmt->execute();
		############ ACTUALIZO LOS TOTALES EN LA COTIZACION ##############

		echo "1";
		exit;

	} else {
		   
		echo "2";
		exit;
	} 
			
	} else {
		
		echo "3";
		exit;
	}	
}
################### FUNCION ELIMINAR DETALLES COTIZACIONES #####################

####################### FUNCION ELIMINAR COTIZACIONES #################################
public function EliminarCotizaciones()
	{
	self::SetNames();
	if ($_SESSION["acceso"]=="administrador") {

		$sql = "DELETE FROM cotizaciones WHERE codcotizacion = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codcotizacion);
		$codcotizacion = decrypt($_GET["codcotizacion"]);
		$stmt->execute();

		$sql = "DELETE FROM detallecotizaciones WHERE codcotizacion = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codcotizacion);
		$codcotizacion = decrypt($_GET["codcotizacion"]);
		$stmt->execute();

		echo "1";
		exit;

	} else {

		echo "2";
		exit;
	}
}
###################### FUNCION ELIMINAR COTIZACIONES #################################

####################### FUNCION PROCESAR COTIZACIONES A VENTA #################################
public function ProcesarCotizaciones()
	{
	self::SetNames();
	####################### VERIFICO ARQUEO DE CAJA #######################
	$sql = "SELECT * FROM arqueocaja 
	INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	INNER JOIN usuarios ON cajas.codigo = usuarios.codigo 
	WHERE usuarios.codigo = ? AND arqueocaja.statusarqueo = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_SESSION["codigo"]));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "1";
		exit;

	} else {
		
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		$codarqueo = $row['codarqueo'];
		$codcaja = $row['codcaja'];
	}
    ####################### VERIFICO ARQUEO DE CAJA #######################
    
    if(empty($_POST["tipodocumento"]) or empty($_POST["tipopago"]))
	{
		echo "2";
		exit;
	}
	elseif(limpiar($_POST["txtImporte"]=="") && limpiar($_POST["txtImporte"]==0) && limpiar($_POST["txtImporte"]==0.00))
	{
		echo "3";
		exit;
		
	}
	elseif(isset($_POST['formapago2']) && $_POST["formapago2"] != ""){

		/*if($_POST["txtTotal"] > $_POST["txtAgregado"])
	    {
		   echo "4";
		   exit;
	    }***/
	}
	else if(limpiar($_POST["tipodocumento"]) == "FACTURA" && limpiar($_POST["codcliente"]) == "0"){

    	echo "5";
	    exit;
	}

    ############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA #############
	$sql = "SELECT * FROM detallecotizaciones WHERE codcotizacion = '".decrypt($_POST['codcotizacion'])."'";
    	foreach ($this->dbh->query($sql) as $row2) {

	    $cantidad = $row2['cantcotizacion'];
	    $tipo = $row2['tipo'];

		if(limpiar($tipo) == 1){

	    	$sql = "SELECT 
	    	existencia 
	    	FROM productos 
	    	WHERE codproducto = '".limpiar($row2['codproducto'])."'";
	    	foreach ($this->dbh->query($sql) as $row)
	    	{
	    		$this->p[] = $row;
	    	}

	    	$existenciadb = $row['existencia'];

	    	if ($cantidad > $existenciadb) 
	    	{ 
	    		echo "6";
	    		exit;
	    	}

		} else {

	    	$sql = "SELECT 
	    	existencia 
	    	FROM combos 
	    	WHERE codcombo = '".limpiar($row2['codproducto'])."'";
	    	foreach ($this->dbh->query($sql) as $row)
	    	{
	    		$this->p[] = $row;
	    	}

	    	$existenciadb = $row['existencia'];

	    	if ($cantidad > $existenciadb) 
	    	{ 
	    		echo "6";
	    		exit;
	    	}

		}
	}
	############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA #############

	################### SELECCIONE LOS DATOS DEL CLIENTE ######################
    $sql = "SELECT
    clientes.dnicliente,
    CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
    clientes.girocliente,
    clientes.emailcliente, 
    clientes.tipocliente,
    clientes.limitecredito,
    clientes.id_provincia,
    clientes.id_departamento,
    clientes.direccliente,
    provincias.provincia,
    departamentos.departamento,
    ROUND(SUM(if(pag.montocredito!='0',pag.montocredito,'0.00')), 2) montoactual,
    ROUND(SUM(if(pag.montocredito!='0',clientes.limitecredito-pag.montocredito,clientes.limitecredito)), 2) creditodisponible
    FROM clientes 
    LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento
    LEFT JOIN
       (SELECT
       codcliente, montocredito       
       FROM creditosxclientes) pag ON pag.codcliente = clientes.codcliente
       WHERE clientes.codcliente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar($_POST['codcliente'])));
	$num = $stmt->rowCount();
	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$p[] = $row;
	}
    $tipocliente = ($row['tipocliente'] == "" ? "0" : $row['tipocliente']);
    $dnicliente = ($row['dnicliente'] == "" ? "0" : $row['dnicliente']);
    $nomcliente = ($row['nomcliente'] == "" ? "0" : $row['nomcliente']);
    $girocliente = ($row['girocliente'] == "" ? "0" : $row['girocliente']);
    $emailcliente = $row['emailcliente'];
    $provincia = ($row['id_provincia'] == "" || $row['id_provincia'] == "0" ? "0" : $row['provincia']);
    $departamento = ($row['id_departamento'] == "" || $row['id_provincia'] == "0" ? "0" : $row['departamento']);
    $direccliente = ($row['direccliente'] == "" ? "0" : $row['direccliente']);
    $limitecredito = $row['limitecredito'];
    $montoactual = $row['montoactual'];
    $creditodisponible = $row['creditodisponible'];
    $medioabono = (empty($_POST["medioabono"]) ? "" : $_POST["medioabono"]);
    $montoabono = (empty($_POST["montoabono"]) ? "0.00" : $_POST["montoabono"]);
    $total = number_format($_POST["txtImporte"]-$montoabono, 2, '.', '');
    ################### SELECCIONE LOS DATOS DEL CLIENTE ######################

    ################### VERIFICO CONDICIONES DEL CLIENTE ######################
    if(limpiar($_POST["tipodocumento"] == "FACTURA" && $tipocliente == "NATURAL")){ 

    	    echo "7";
	        exit;

    } else if ($_POST["tipopago"] == "CREDITO") {

		$fechaactual = date("Y-m-d");
		$fechavence = date("Y-m-d",strtotime($_POST['fechavencecredito']));

		if ($_POST["codcliente"] == '0') { 

	        echo "8";
	        exit;

        } else if (strtotime($fechavence) < strtotime($fechaactual)) {

			echo "9";
			exit;

		} else if ($montoabono != "0.00" && $medioabono == "") {
  
           echo "10";
	       exit;

		} else if ($limitecredito != "0.00" && $total > $creditodisponible) {
  
           echo "11";
	       exit;

		} else if($_POST["montoabono"] >= $_POST["txtImporte"]) { 
	
		   echo "12";
		   exit;

	    }
	}
	################### VERIFICO CONDICIONES DEL CLIENTE ######################

	##################### AGREGAMOS EL NUMERO DE PEDIDO A LA VENTA #######################
	$sql = "SELECT 
	codpedido,
	codventa 
	FROM ventas 
	ORDER BY idventa 
	DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$pedido=$row["codpedido"];
		$venta=$row["codventa"];

	}
	if(empty($pedido) or empty($venta))
	{
		$codpedido = "P1";
		$codventa = "1";

	} else {
		
		$resto = substr($pedido, 0, 1);
		$coun = strlen($resto);
		$num = substr($pedido, $coun);
		$codigop = $num + 1;
		$codigov = $venta + 1;
		$codpedido = "P".$codigop;
		$codventa = $codigov;
	}
	##################### AGREGAMOS EL NUMERO DE PEDIDO A LA VENTA #######################

	################ CREO EL CODIGO DE BANDERA PARA NUMERO DE VENTA ################
	$sql = "SELECT bandera from ventas WHERE statuspago = 0 ORDER BY bandera DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

    $idbandera=$row["bandera"];

    }
	if(empty($idbandera)){

		$bandera = '1';

	} else {
		$num     = $idbandera + 1;
		$bandera = $num;
	}
	################ CREO EL CODIGO DE BANDERA PARA NUMERO DE VENTA ################

	################ OBTENGO DATOS DE CONFIGURACION ################
	$sql = "SELECT * 
	FROM configuracion 
    LEFT JOIN documentos ON configuracion.documsucursal = documentos.coddocumento
    LEFT JOIN provincias ON configuracion.id_provincia = provincias.id_provincia 
    LEFT JOIN departamentos ON configuracion.id_departamento = departamentos.id_departamento 
    LEFT JOIN tiposmoneda ON configuracion.codmoneda = tiposmoneda.codmoneda";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
    $rucemisor = $row['cuit'];
    $razonsocial = $row['nomsucursal'];
    $actecoemisor = $row['codgiro'];
    $giroemisor = $row['girosucursal'];
    $provincia = ($row['id_provincia'] == "" || $row['id_provincia'] == "0" ? $row['direcsucursal'] : $row['provincia']);
    $departamento = ($row['id_departamento'] == "" || $row['id_departamento'] == "0" ? $row['direcsucursal'] : $row['departamento']);
    $direcemisor = $row['direcsucursal'];
    $inicioticket = $row['inicioticket'];
    $inicioboleta = $row['inicioboleta'];
	$iniciofactura = $row['iniciofactura'];		
	$infoapi = $row['infoapi']; 
	$simbolo = $row['simbolo'];
	################ OBTENGO DATOS DE CONFIGURACION ################

	################ CREO LOS CODIGO VENTA-SERIE-AUTORIZACION ################
	$sql = "SELECT 
	codfactura 
	FROM ventas 
	WHERE tipodocumento = '".limpiar($_POST['tipodocumento'])."' 
	AND statuspago = 0 ORDER BY bandera DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$factura=$row["codfactura"];

	}
	
	if($_POST['tipodocumento']=="TICKET") {

        $codfactura = (empty($factura) ? $inicioticket : $factura + 1);
		$codserie = limpiar(GenerateRandomStringg());
		$codautorizacion = limpiar(GenerateRandomStringg());

	} elseif($_POST['tipodocumento']=="BOLETA") {

        $codfactura = (empty($factura) ? $inicioboleta : $factura + 1);
		$codserie = limpiar(GenerateRandomStringg());
		$codautorizacion = limpiar(GenerateRandomStringg());

	} elseif($_POST['tipodocumento']=="FACTURA") {

		$codfactura = (empty($factura) ? $iniciofactura : $factura + 1);
		$codserie = limpiar(GenerateRandomStringg());
		$codautorizacion = limpiar(GenerateRandomStringg());
	}
    ################# CREO LOS CODIGO VENTA-SERIE-AUTORIZACION ###############

	################### SELECCIONE LOS DATOS DE LA COTIZACION ######################
    $sql = "SELECT * FROM cotizaciones WHERE codcotizacion = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_POST['codcotizacion'])));
	$num = $stmt->rowCount();
	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$p[] = $row;
	}
    ################### SELECCIONE LOS DATOS DE LA COTIZACION ######################

    $fecha = date("Y-m-d H:i:s");

    $query = "INSERT INTO ventas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codpedido);
	$stmt->bindParam(2, $codventa);
	$stmt->bindParam(3, $codmesa);
	$stmt->bindParam(4, $tipodocumento);
	$stmt->bindParam(5, $codcaja);
	$stmt->bindParam(6, $codfactura);
	$stmt->bindParam(7, $codserie);
	$stmt->bindParam(8, $codautorizacion);
	$stmt->bindParam(9, $codcliente);
	$stmt->bindParam(10, $subtotalivasi);
	$stmt->bindParam(11, $subtotalivano);
	$stmt->bindParam(12, $iva);
	$stmt->bindParam(13, $totaliva);
	$stmt->bindParam(14, $descontado);
	$stmt->bindParam(15, $descuento);
	$stmt->bindParam(16, $totaldescuento);
	$stmt->bindParam(17, $totalpago);
	$stmt->bindParam(18, $totalpago2);
	$stmt->bindParam(19, $creditopagado);
	$stmt->bindParam(20, $montodelivery);
	$stmt->bindParam(21, $tipopago);
	$stmt->bindParam(22, $formapago);
	$stmt->bindParam(23, $montopagado);
	$stmt->bindParam(24, $formapago2);
	$stmt->bindParam(25, $montopagado2);
	$stmt->bindParam(26, $formapropina);
	$stmt->bindParam(27, $montopropina);
	$stmt->bindParam(28, $montodevuelto);
	$stmt->bindParam(29, $fechavencecredito);
	$stmt->bindParam(30, $fechapagado);
	$stmt->bindParam(31, $statusventa);
	$stmt->bindParam(32, $statuspago);
	$stmt->bindParam(33, $fecha);
	$stmt->bindParam(34, $delivery);
	$stmt->bindParam(35, $repartidor);
	$stmt->bindParam(36, $entregado);
	$stmt->bindParam(37, $observaciones);
	$stmt->bindParam(38, $codigo);
	$stmt->bindParam(39, $bandera);
	$stmt->bindParam(40, $docelectronico);
    
	$codmesa = limpiar("0");
	$tipodocumento = limpiar($_POST["tipodocumento"]);
	//$codcaja = limpiar($_POST["codcaja"]);
	$codcliente = limpiar($_POST['codcliente']);
	$subtotalivasi = limpiar($row["subtotalivasi"]);
	$subtotalivano = limpiar($row["subtotalivano"]);
	$iva = limpiar($row["iva"]);
	$totaliva = limpiar($row["totaliva"]);
	$descontado = limpiar($row["descontado"]);
	$descuento = limpiar($row["descuento"]);
	$totaldescuento = limpiar($row["totaldescuento"]);
	$totalpago = limpiar($row["totalpago"]);
	$totalpago2 = limpiar($row["totalpago2"]);
	$creditopagado = limpiar(isset($_POST['montoabono']) ? $_POST["montoabono"] : "0.00");
	$montodelivery = limpiar(isset($_POST['montodelivery']) ? $_POST["montodelivery"] : "0.00");
	$tipopago = limpiar($_POST["tipopago"]);
	$formapago = limpiar($_POST["tipopago"]=="CONTADO" ? $_POST["formapago"] : "CREDITO");
	$montopagado = limpiar($_POST['montopagado']);
	$formapago2 = limpiar(isset($_POST['montopagado2']) ? $_POST["formapago2"] : "0");
	$montopagado2 = limpiar(isset($_POST['montopagado2']) ? $_POST["montopagado2"] : "0");
    $formapropina = limpiar("0");
	$montopropina = limpiar("0.00");
	$montodevuelto = limpiar($_POST['montodevuelto']);
    $fechavencecredito = limpiar($_POST["tipopago"]=="CREDITO" ? date("Y-m-d",strtotime($_POST['fechavencecredito'])) : "0000-00-00");
    $fechapagado = limpiar("0000-00-00");
    $statusventa = limpiar($_POST["tipopago"]=="CONTADO" ? "PAGADA" : "PENDIENTE");
	$statuspago = limpiar("0");
	$delivery = limpiar($_POST["repartidores"]!="" ? "1" : "0");
	$repartidor = limpiar($_POST["repartidores"]!="" ? decrypt($_POST['repartidores']) : "0");
	$entregado = limpiar($_POST["repartidores"]!="" ? "1" : "0");
	$observaciones = limpiar($_POST['observaciones']=="" ? "NINGUNA" : $_POST['observaciones']);
	$codigo = limpiar($_SESSION["codigo"]);
	$docelectronico = limpiar($infoapi=="SI" ? "1" : "0");
	$stmt->execute();

	$this->dbh->beginTransaction();
	################### SELECCIONO DETALLES DE LA COTIZACION ######################
	$sql = "SELECT * FROM detallecotizaciones 
	WHERE codcotizacion = '".decrypt($_POST['codcotizacion'])."'";
    foreach ($this->dbh->query($sql) as $row2)
	   {

    	############### VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ##################
	    $sql = "SELECT existencia FROM productos WHERE codproducto = '".limpiar($row2['codproducto'])."'";
	    foreach ($this->dbh->query($sql) as $row3)
	    {
		$this->p[] = $row3;
	    }
	    $existenciabd = $row3['existencia'];
	    ############### VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN ##################

	    $query = "INSERT INTO detalleventas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	    $stmt = $this->dbh->prepare($query);
	    $stmt->bindParam(1, $codpedido);
	    $stmt->bindParam(2, $codventa);
    	$stmt->bindParam(3, $idproducto);
	    $stmt->bindParam(4, $codproducto);
	    $stmt->bindParam(5, $producto);
	    $stmt->bindParam(6, $codcategoria);
	    $stmt->bindParam(7, $cantidad);
	    $stmt->bindParam(8, $preciocompra);
	    $stmt->bindParam(9, $precioventa);
	    $stmt->bindParam(10, $ivaproducto);
	    $stmt->bindParam(11, $descproducto);
	    $stmt->bindParam(12, $valortotal);
	    $stmt->bindParam(13, $totaldescuentov);
	    $stmt->bindParam(14, $valorneto);
	    $stmt->bindParam(15, $valorneto2);
	    $stmt->bindParam(16, $detallesobservaciones);
	    $stmt->bindParam(17, $tipo);

    	$idproducto = limpiar($row2['idproducto']);
    	$codproducto = limpiar($row2['codproducto']);
    	$producto = limpiar($row2['producto']);
    	$codcategoria = limpiar($row2['codcategoria']);
    	$cantidad = limpiar($row2['cantcotizacion']);
    	$preciocompra = limpiar($row2['preciocompra']);
    	$precioventa = limpiar($row2['precioventa']);
    	$ivaproducto = limpiar($row2['ivaproducto']);
    	$descproducto = limpiar($row2['descproducto']);
    	$descuento = $row2['descproducto']/100;
    	$valortotal = number_format($row2['valortotal'], 2, '.', '');
    	$totaldescuentov = number_format($row2['totaldescuentov'], 2, '.', '');
    	$valorneto = number_format($row2['valorneto'], 2, '.', '');
    	$valorneto2 = number_format($row2['valorneto2'], 2, '.', '');
    	$detallesobservaciones = limpiar($row2['detallesobservaciones']);
    	$tipo = limpiar($row2['tipo']);
    	$stmt->execute();

    if(limpiar($row2['tipo']) == 1){

    ############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################

    ############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################
	$sql = "SELECT existencia, controlstockp FROM productos WHERE codproducto = '".limpiar($row2['codproducto'])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$existenciaproductobd = $row['existencia'];
	$controlproductobd = $row['controlstockp'];
	############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################

	if($controlproductobd == 1){

	    ##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
		$sql = " UPDATE productos set "
			  ." existencia = ? "
			  ." WHERE "
			  ." codproducto = '".limpiar($row2['codproducto'])."';
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$cantventa = number_format($row2['cantcotizacion'], 2, '.', '');
		$existencia = number_format($existenciaproductobd-$cantventa, 2, '.', '');
		$stmt->execute();
		##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################

		############## REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
        $query = "INSERT INTO kardex_productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codventa);
		$stmt->bindParam(2, $codcliente);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);		

		$codcliente = limpiar($_POST["codcliente"]);
		$codproducto = limpiar($row2['codproducto']);
		$movimiento = limpiar("SALIDAS");
		$entradas = limpiar("0");
		$salidas= number_format($row2['cantcotizacion'], 2, '.', '');
		$devolucion = limpiar("0");
		$stockactual = number_format($existenciaproductobd-$row2['cantcotizacion'], 2, '.', '');
		$precio = limpiar($row2['precioventa']);
		$ivaproducto = limpiar($row2['ivaproducto']);
		$descproducto = limpiar($row2['descproducto']);
		$documento = limpiar("PROCESO EN COTIZACION");
		$fechakardex = limpiar($fecha);
		$stmt->execute();
		############## REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
	}

    ############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################	

    } else {

	############################### PROCESO PARA VERIFICAR LOS COMBOS ######################################

    ############## VERIFICO LA EXISTENCIA DEL COMBO EN ALMACEN #################
	$sql = "SELECT existencia FROM combos WHERE codcombo = '".limpiar($row2['codproducto'])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$existenciacombobd = $row['existencia'];
	############## VERIFICO LA EXISTENCIA DEL COMBO EN ALMACEN #################

	    ##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
		$sql = " UPDATE combos set "
			  ." existencia = ? "
			  ." WHERE "
			  ." codcombo = '".limpiar($row2['codproducto'])."';
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$cantventa = number_format($row2['cantcotizacion'], 2, '.', '');
		$existencia = number_format($existenciacombobd-$cantventa, 2, '.', '');
		$stmt->execute();
		##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################

		############## REGISTRAMOS LOS DATOS DE COMBOS EN KARDEX ###################
        $query = "INSERT INTO kardex_combos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codventa);
		$stmt->bindParam(2, $codcliente);
		$stmt->bindParam(3, $codcombo);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivacombo);
		$stmt->bindParam(10, $desccombo);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);		

		$codcliente = limpiar($_POST["codcliente"]);
		$codcombo = limpiar($row2['codproducto']);
		$movimiento = limpiar("SALIDAS");
		$entradas = limpiar("0");
		$salidas= number_format($row2['cantcotizacion'], 2, '.', '');
		$devolucion = limpiar("0");
		$stockactual = number_format($existenciacombobd-$row2['cantcotizacion'], 2, '.', '');
		$precio = limpiar($row2['precioventa']);
		$ivacombo = limpiar($row2['ivaproducto']);
		$desccombo = limpiar($row2['descproducto']);
		$documento = limpiar("PROCESO EN COTIZACION");
		$fechakardex = limpiar($fecha);
		$stmt->execute();
		############## REGISTRAMOS LOS DATOS DE COMBOS EN KARDEX ###################

    ############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################	
    }


    ############################### PROCESO PARA VERIFICAR LOS INGREDIENTES ######################################	

	    ############## VERIFICO SSI EL PRODUCTO TIENE INGREDIENTES RELACIONADOS #################
	    $sql = "SELECT * FROM productosxingredientes WHERE codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(limpiar($row2['codproducto'])));
		$num = $stmt->rowCount();
        if($num>0) {  

        	$sql = "SELECT * FROM productosxingredientes LEFT JOIN ingredientes ON productosxingredientes.codingrediente = ingredientes.codingrediente WHERE productosxingredientes.codproducto IN ('".$row2['codproducto']."')";
        	foreach ($this->dbh->query($sql) as $row)
		    { 
			   $this->p[] = $row;

			   //$codproducto = $row['codproducto'];
			   $cantracionbd = ($row['cantracion'] == "" ? "0" : $row['cantracion']);
			   $codingredientebd = $row['codingrediente'];
			   $cantingredientebd = $row['cantingrediente'];
			   $precioventaingredientebd = $row['precioventa'];
			   $ivaingredientebd = $row['ivaingrediente'];
			   $descingredientebd = $row['descingrediente'];
		       $controlingredientebd = $row['controlstocki'];

		    if($controlingredientebd == 1){

			   ############## ACTUALIZO LOS DATOS DEL INGREDIENTE #################
			   $update = "UPDATE ingredientes set "
			   ." cantingrediente = ? "
			   ." WHERE "
			   ." codingrediente = ?;
			   ";
			   $stmt = $this->dbh->prepare($update);
			   $stmt->bindParam(1, $cantidadracion);
			   $stmt->bindParam(2, $codingredientebd);

			   $racion = number_format($cantracionbd*$row2['cantcotizacion'], 2, '.', '');
			   $cantidadracion = number_format($cantingredientebd-$racion, 2, '.', '');
			   $stmt->execute();
			   ############## ACTUALIZO LOS DATOS DEL INGREDIENTE #################

			   ############## REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
			   $query = "INSERT INTO kardex_ingredientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
			   $stmt = $this->dbh->prepare($query);
			   $stmt->bindParam(1, $codventa);
			   $stmt->bindParam(2, $codcliente);
			   $stmt->bindParam(3, $codingrediente);
			   $stmt->bindParam(4, $movimiento);
			   $stmt->bindParam(5, $entradas);
			   $stmt->bindParam(6, $salidas);
			   $stmt->bindParam(7, $devolucion);
			   $stmt->bindParam(8, $stockactual);
			   $stmt->bindParam(9, $ivaingrediente);
			   $stmt->bindParam(10, $descingrediente);
			   $stmt->bindParam(11, $precio);
			   $stmt->bindParam(12, $documento);
			   $stmt->bindParam(13, $fechakardex);		

			   $codcliente = limpiar($_POST["codcliente"]);
			   $codingrediente = limpiar($codingredientebd);
			   $movimiento = limpiar("SALIDAS");
			   $entradas = limpiar("0");
			   $salidas= limpiar($racion);
			   $devolucion = limpiar("0");
			   $stockactual = number_format($cantingredientebd-$racion, 2, '.', '');
			   $precio = limpiar($precioventaingredientebd);
			   $ivaingrediente = limpiar($ivaingredientebd);
			   $descingrediente = limpiar($descingredientebd);
			   $documento = limpiar("PROCESO EN COTIZACION");
			   $fechakardex = limpiar($fecha);
			   $stmt->execute();
			}
		}
	}//fin de consulta de ingredientes de productos	

############################### PROCESO PARA VERIFICAR LOS INGREDIENTES ######################################	

	}
    $this->dbh->commit();

	$sql = "DELETE FROM cotizaciones WHERE codcotizacion = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1,$codcotizacion);
	$codcotizacion = decrypt($_POST["codcotizacion"]);
	$stmt->execute();

	$sql = "DELETE FROM detallecotizaciones WHERE codcotizacion = ?";
	$stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(1,$codcotizacion);
	$codcotizacion = decrypt($_POST["codcotizacion"]);
	$stmt->execute();

	############## AGREGAMOS EL INGRESO DE VENTAS PAGADAS A CAJA ###############
	if (limpiar($_POST["tipopago"]=="CONTADO")){

	################## OBTENGO LOS DATOS EN CAJA ##################
	$sql = "SELECT 
	efectivo, 
	cheque, 
	tcredito, 
	tdebito, 
	tprepago, 
	transferencia, 
	electronico,
	cupon, 
	otros,
	propinasefectivo,
	propinasotros,
	nroticket,
	nroboleta,
	nrofactura
	FROM arqueocaja WHERE codcaja = '".limpiar($codcaja)."' AND statusarqueo = 1";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$efectivo = ($row['efectivo']== "" ? "0.00" : $row['efectivo']);
	$cheque = ($row['cheque']== "" ? "0.00" : $row['cheque']);
	$tcredito = ($row['tcredito']== "" ? "0.00" : $row['tcredito']);
	$tdebito = ($row['tdebito']== "" ? "0.00" : $row['tdebito']);
	$tprepago = ($row['tprepago']== "" ? "0.00" : $row['tprepago']);
	$transferencia = ($row['transferencia']== "" ? "0.00" : $row['transferencia']);
	$electronico = ($row['electronico']== "" ? "0.00" : $row['electronico']);
	$cupon = ($row['cupon']== "" ? "0.00" : $row['cupon']);
	$otros = ($row['otros']== "" ? "0.00" : $row['otros']);
	$propinasefectivo = ($row['propinasefectivo']== "" ? "0.00" : $row['propinasefectivo']);
	$propinasotros = ($row['propinasotros']== "" ? "0.00" : $row['propinasotros']);
	$nroticket = $row['nroticket'];
	$nroboleta = $row['nroboleta'];
	$nrofactura = $row['nrofactura'];
	################## OBTENGO LOS DATOS EN CAJA ##################

	if(isset($_POST['formapago2']) && $_POST['formapago2']!=""){

	########################## PROCESO LA 1ERA FORMA DE PAGO #################################
	$sql = "UPDATE arqueocaja set "
	." efectivo = ?, "
	." cheque = ?, "
	." tcredito = ?, "
	." tdebito = ?, "
	." tprepago = ?, "
	." transferencia = ?, "
	." electronico = ?, "
	." cupon = ?, "
	." otros = ?, "
	." propinasefectivo = ?, "
	." propinasotros = ?, "
	." nroticket = ?, "
	." nroboleta = ?, "
	." nrofactura = ? "
	." WHERE "
	." codcaja = ? AND statusarqueo = 1;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $txtEfectivo);
	$stmt->bindParam(2, $txtCheque);
	$stmt->bindParam(3, $txtTcredito);
	$stmt->bindParam(4, $txtTdebito);
	$stmt->bindParam(5, $txtTprepago);
	$stmt->bindParam(6, $txtTransferencia);
	$stmt->bindParam(7, $txtElectronico);
	$stmt->bindParam(8, $txtCupon);
	$stmt->bindParam(9, $txtOtros);
	$stmt->bindParam(10, $txtPropinaEfectivo);
	$stmt->bindParam(11, $txtPropinaOtros);
	$stmt->bindParam(12, $NumTicket);
	$stmt->bindParam(13, $NumBoleta);
	$stmt->bindParam(14, $NumFactura);
	$stmt->bindParam(15, $codcaja);

	$txtEfectivo = limpiar($_POST["formapago"] == "EFECTIVO" ? number_format($efectivo+$_POST["montopagado"], 2, '.', '') : $efectivo);
	$txtCheque = limpiar($_POST["formapago"] == "CHEQUE" ? number_format($cheque+$_POST["montopagado"], 2, '.', '') : $cheque);
	$txtTcredito = limpiar($_POST["formapago"] == "TARJETA DE CREDITO" ? number_format($tcredito+$_POST["montopagado"], 2, '.', '') : $tcredito);
	$txtTdebito = limpiar($_POST["formapago"] == "TARJETA DE DEBITO" ? number_format($tdebito+$_POST["montopagado"], 2, '.', '') : $tdebito);
	$txtTprepago = limpiar($_POST["formapago"] == "TARJETA PREPAGO" ? number_format($tprepago+$_POST["montopagado"], 2, '.', '') : $tprepago);
	$txtTransferencia = limpiar($_POST["formapago"] == "TRANSFERENCIA" ? number_format($transferencia+$_POST["montopagado"], 2, '.', '') : $transferencia);
	$txtElectronico = limpiar($_POST["formapago"] == "DINERO ELECTRONICO" ? number_format($electronico+$_POST["montopagado"], 2, '.', '') : $electronico);
	$txtCupon = limpiar($_POST["formapago"] == "CUPON" ? number_format($cupon+$_POST["montopagado"], 2, '.', '') : $cupon);
	$txtOtros = limpiar($_POST["formapago"] == "OTROS" ? number_format($otros+$_POST["montopagado"], 2, '.', '') : $otros);
	
	$txtPropinaEfectivo = limpiar(isset($_POST['montopropina']) && $_POST["formapropina"] == "EFECTIVO" ? number_format($propinasefectivo+$_POST["montopropina"], 2, '.', '') : $propinasefectivo);
	$txtPropinaOtros = limpiar(isset($_POST['montopropina']) && $_POST["formapropina"] != "EFECTIVO" ? number_format($propinasotros+$_POST["montopropina"], 2, '.', '') : $propinasotros);

	$NumTicket = limpiar($_POST["tipodocumento"] == "TICKET" ? $nroticket+1 : $nroticket);
	$NumBoleta = limpiar($_POST["tipodocumento"] == "BOLETA" ? $nroboleta+1 : $nroboleta);
	$NumFactura = limpiar($_POST["tipodocumento"] == "FACTURA" ? $nrofactura+1 : $nrofactura);
	$stmt->execute();
	########################## PROCESO LA 1ERA FORMA DE PAGO #################################


	########################## PROCESO LA 2DA FORMA DE PAGO #################################
	$sql2 = "UPDATE arqueocaja set "
	." efectivo = ?, "
	." cheque = ?, "
	." tcredito = ?, "
	." tdebito = ?, "
	." tprepago = ?, "
	." transferencia = ?, "
	." electronico = ?, "
	." cupon = ?, "
	." otros = ? "
	." WHERE "
	." codcaja = ? AND statusarqueo = 1;
	";
	$stmt = $this->dbh->prepare($sql2);
	$stmt->bindParam(1, $txtEfectivo2);
	$stmt->bindParam(2, $txtCheque2);
	$stmt->bindParam(3, $txtTcredito2);
	$stmt->bindParam(4, $txtTdebito2);
	$stmt->bindParam(5, $txtTprepago2);
	$stmt->bindParam(6, $txtTransferencia2);
	$stmt->bindParam(7, $txtElectronico2);
	$stmt->bindParam(8, $txtCupon2);
	$stmt->bindParam(9, $txtOtros2);
	$stmt->bindParam(10, $codcaja);

	$txtEfectivo2 = limpiar($_POST["formapago2"] == "EFECTIVO" ? number_format($efectivo+$_POST["montopagado2"], 2, '.', '') : $txtEfectivo);
	$txtCheque2 = limpiar($_POST["formapago2"] == "CHEQUE" ? number_format($cheque+$_POST["montopagado2"], 2, '.', '') : $cheque);
	$txtTcredito2 = limpiar($_POST["formapago2"] == "TARJETA DE CREDITO" ? number_format($tcredito+$_POST["montopagado2"], 2, '.', '') : $txtTcredito);
	$txtTdebito2 = limpiar($_POST["formapago2"] == "TARJETA DE DEBITO" ? number_format($tdebito+$_POST["montopagado2"], 2, '.', '') : $txtTdebito);
	$txtTprepago2 = limpiar($_POST["formapago2"] == "TARJETA PREPAGO" ? number_format($tprepago+$_POST["montopagado2"], 2, '.', '') : $txtTprepago);
	$txtTransferencia2 = limpiar($_POST["formapago2"] == "TRANSFERENCIA" ? number_format($transferencia+$_POST["montopagado2"], 2, '.', '') : $txtTransferencia);
	$txtElectronico2 = limpiar($_POST["formapago2"] == "DINERO ELECTRONICO" ? number_format($electronico+$_POST["montopagado2"], 2, '.', '') : $txtElectronico);
	$txtCupon2 = limpiar($_POST["formapago2"] == "CUPON" ? number_format($cupon+$_POST["montopagado2"], 2, '.', '') : $txtCupon);
	$txtOtros2 = limpiar($_POST["formapago2"] == "OTROS" ? number_format($otros+$_POST["montopagado2"], 2, '.', '') : $txtOtros);
	$stmt->execute();
	########################## PROCESO LA 2DA FORMA DE PAGO #################################

	} else { 

	########################## PROCESO LA 1ERA FORMA DE PAGO #################################
	$sql = "UPDATE arqueocaja set "
	." efectivo = ?, "
	." cheque = ?, "
	." tcredito = ?, "
	." tdebito = ?, "
	." tprepago = ?, "
	." transferencia = ?, "
	." electronico = ?, "
	." cupon = ?, "
	." otros = ?, "
	." propinasefectivo = ?, "
	." propinasotros = ?, "
	." nroticket = ?, "
	." nroboleta = ?, "
	." nrofactura = ? "
	." WHERE "
	." codcaja = ? AND statusarqueo = 1;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $txtEfectivo);
	$stmt->bindParam(2, $txtCheque);
	$stmt->bindParam(3, $txtTcredito);
	$stmt->bindParam(4, $txtTdebito);
	$stmt->bindParam(5, $txtTprepago);
	$stmt->bindParam(6, $txtTransferencia);
	$stmt->bindParam(7, $txtElectronico);
	$stmt->bindParam(8, $txtCupon);
	$stmt->bindParam(9, $txtOtros);
	$stmt->bindParam(10, $txtPropinaEfectivo);
	$stmt->bindParam(11, $txtPropinaOtros);
	$stmt->bindParam(12, $NumTicket);
	$stmt->bindParam(13, $NumBoleta);
	$stmt->bindParam(14, $NumFactura);
	$stmt->bindParam(15, $codcaja);
	
	$textdelivery = limpiar(isset($_POST['montodelivery']) ? $_POST["montodelivery"] : "0.00");
	$TotalPagar =  number_format($_POST["txtTotal"]+$textdelivery, 2, '.', '');
	$txtEfectivo = limpiar($_POST["formapago"] == "EFECTIVO" ? number_format($efectivo+$TotalPagar, 2, '.', '') : $efectivo);
	$txtCheque = limpiar($_POST["formapago"] == "CHEQUE" ? number_format($cheque+$TotalPagar, 2, '.', '') : $cheque);
	$txtTcredito = limpiar($_POST["formapago"] == "TARJETA DE CREDITO" ? number_format($tcredito+$TotalPagar, 2, '.', '') : $tcredito);
	$txtTdebito = limpiar($_POST["formapago"] == "TARJETA DE DEBITO" ? number_format($tdebito+$TotalPagar, 2, '.', '') : $tdebito);
	$txtTprepago = limpiar($_POST["formapago"] == "TARJETA PREPAGO" ? number_format($tprepago+$TotalPagar, 2, '.', '') : $tprepago);
	$txtTransferencia = limpiar($_POST["formapago"] == "TRANSFERENCIA" ? number_format($transferencia+$TotalPagar, 2, '.', '') : $transferencia);
	$txtElectronico = limpiar($_POST["formapago"] == "DINERO ELECTRONICO" ? number_format($electronico+$TotalPagar, 2, '.', '') : $electronico);
	$txtCupon = limpiar($_POST["formapago"] == "CUPON" ? number_format($cupon+$TotalPagar, 2, '.', '') : $cupon);
	$txtOtros = limpiar($_POST["formapago"] == "OTROS" ? number_format($otros+$TotalPagar, 2, '.', '') : $otros);
	
	$txtPropinaEfectivo = limpiar(isset($_POST['montopropina']) && $_POST["formapropina"] == "EFECTIVO" ? number_format($propinasefectivo+$_POST["montopropina"], 2, '.', '') : $propinasefectivo);
	$txtPropinaOtros = limpiar(isset($_POST['montopropina']) && $_POST["formapropina"] != "EFECTIVO" ? number_format($propinasotros+$_POST["montopropina"], 2, '.', '') : $propinasotros);

	$NumTicket = limpiar($_POST["tipodocumento"] == "TICKET" ? $nroticket+1 : $nroticket);
	$NumBoleta = limpiar($_POST["tipodocumento"] == "BOLETA" ? $nroboleta+1 : $nroboleta);
	$NumFactura = limpiar($_POST["tipodocumento"] == "FACTURA" ? $nrofactura+1 : $nrofactura);
	$stmt->execute();
	########################## PROCESO LA 1ERA FORMA DE PAGO #################################
		}
	}
    ################ AGREGAMOS EL INGRESO DE VENTAS PAGADAS A CAJA ##############


    ######### AGREGAMOS EL INGRESO Y ABONOS DE VENTAS A CREDITOS A CAJA ############
	if (limpiar($_POST["tipopago"]=="CREDITO")) {

	################## OBTENGO LOS DATOS EN CAJA ##################
	$sql = "SELECT 
	efectivo, 
	cheque, 
	tcredito, 
	tdebito, 
	tprepago, 
	transferencia, 
	electronico, 
	cupon,
	otros,
	creditos,
	nroticket,
	nroboleta,
	nrofactura
	FROM arqueocaja WHERE codcaja = '".limpiar($codcaja)."' AND statusarqueo = 1";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$efectivo = ($row['efectivo']== "" ? "0.00" : $row['efectivo']);
	$cheque = ($row['cheque']== "" ? "0.00" : $row['cheque']);
	$tcredito = ($row['tcredito']== "" ? "0.00" : $row['tcredito']);
	$tdebito = ($row['tdebito']== "" ? "0.00" : $row['tdebito']);
	$tprepago = ($row['tprepago']== "" ? "0.00" : $row['tprepago']);
	$transferencia = ($row['transferencia']== "" ? "0.00" : $row['transferencia']);
	$electronico = ($row['electronico']== "" ? "0.00" : $row['electronico']);
	$cupon = ($row['cupon']== "" ? "0.00" : $row['cupon']);
	$otros = ($row['otros']== "" ? "0.00" : $row['otros']);
	$credito = ($row['creditos']== "" ? "0.00" : $row['creditos']);
	$nroticket = $row['nroticket'];
	$nroboleta = $row['nroboleta'];
	$nrofactura = $row['nrofactura'];
	################## OBTENGO LOS DATOS EN CAJA ##################

	$sql = "UPDATE arqueocaja set "
	." efectivo = ?, "
	." cheque = ?, "
	." tcredito = ?, "
	." tdebito = ?, "
	." tprepago = ?, "
	." transferencia = ?, "
	." electronico = ?, "
	." cupon = ?, "
	." otros = ?, "
	." creditos = ?, "
	." nroticket = ?, "
	." nroboleta = ?, "
	." nrofactura = ? "
	." WHERE "
	." codcaja = ? AND statusarqueo = 1;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $txtEfectivo);
	$stmt->bindParam(2, $txtCheque);
	$stmt->bindParam(3, $txtTcredito);
	$stmt->bindParam(4, $txtTdebito);
	$stmt->bindParam(5, $txtTprepago);
	$stmt->bindParam(6, $txtTransferencia);
	$stmt->bindParam(7, $txtElectronico);
	$stmt->bindParam(8, $txtCupon);
	$stmt->bindParam(9, $txtOtros);
	$stmt->bindParam(10, $txtCredito);
	$stmt->bindParam(11, $NumTicket);
	$stmt->bindParam(12, $NumBoleta);
	$stmt->bindParam(13, $NumFactura);
	$stmt->bindParam(14, $codcaja);

	$textdelivery = limpiar(isset($_POST['montodelivery']) ? $_POST["montodelivery"] : "0.00");
	$TotalPagar =  number_format($_POST["txtTotal"]+$textdelivery, 2, '.', '');
	$txtEfectivo = limpiar($_POST["medioabono"] == "EFECTIVO" ? number_format($efectivo+$_POST["montoabono"], 2, '.', '') : $efectivo);
	$txtCheque = limpiar($_POST["medioabono"] == "CHEQUE" ? number_format($cheque+$_POST["montoabono"], 2, '.', '') : $cheque);
	$txtTcredito = limpiar($_POST["medioabono"] == "TARJETA DE CREDITO" ? number_format($tcredito+$_POST["montoabono"], 2, '.', '') : $tcredito);
	$txtTdebito = limpiar($_POST["medioabono"] == "TARJETA DE DEBITO" ? number_format($tdebito+$_POST["montoabono"], 2, '.', '') : $tdebito);
	$txtTprepago = limpiar($_POST["medioabono"] == "TARJETA PREPAGO" ? number_format($tprepago+$_POST["montoabono"], 2, '.', '') : $tprepago);
	$txtTransferencia = limpiar($_POST["medioabono"] == "TRANSFERENCIA" ? number_format($transferencia+$_POST["montoabono"], 2, '.', '') : $transferencia);
	$txtElectronico = limpiar($_POST["medioabono"] == "DINERO ELECTRONICO" ? number_format($electronico+$_POST["montoabono"], 2, '.', '') : $electronico);
	$txtCupon = limpiar($_POST["medioabono"] == "CUPON" ? number_format($cupon+$_POST["montoabono"], 2, '.', '') : $cupon);
	$txtOtros = limpiar($_POST["medioabono"] == "OTROS" ? number_format($otros+$_POST["montoabono"], 2, '.', '') : $otros);
	$txtCredito = number_format($credito+($TotalPagar-$_POST["montoabono"]), 2, '.', '');

	$NumTicket = limpiar($_POST["tipodocumento"] == "TICKET" ? $nroticket+1 : $nroticket);
	$NumBoleta = limpiar($_POST["tipodocumento"] == "BOLETA" ? $nroboleta+1 : $nroboleta);
	$NumFactura = limpiar($_POST["tipodocumento"] == "FACTURA" ? $nrofactura+1 : $nrofactura);
	$stmt->execute();


	$sql = "SELECT codcliente FROM creditosxclientes WHERE codcliente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codcliente"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$query = "INSERT INTO creditosxclientes values (null, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcliente);
		$stmt->bindParam(2, $montocredito);

		$codcliente = limpiar($_POST["codcliente"]);
		$TotalPagar =  number_format($_POST["txtTotal"]+$textdelivery, 2, '.', '');
		$montocredito = number_format($TotalPagar-$_POST["montoabono"], 2, '.', '');
		$stmt->execute();

	} else { 

		$sql = "UPDATE creditosxclientes set"
		." montocredito = ? "
		." WHERE "
		." codcliente = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $montocredito);
		$stmt->bindParam(2, $codcliente);

		$TotalPagar =  number_format($_POST["txtTotal"]+$textdelivery, 2, '.', '');
		$montocredito = number_format($montoactual+($TotalPagar-$_POST["montoabono"]), 2, '.', '');
		$codcliente = limpiar($_POST["codcliente"]);
		$stmt->execute();
	}

   if (limpiar($_POST["montoabono"]!="0.00" && $_POST["montoabono"]!="0" && $_POST["montoabono"]!="")) {

	$query = "INSERT INTO abonoscreditos values (null, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codcaja);
	$stmt->bindParam(2, $codventa);
	$stmt->bindParam(3, $codcliente);
	$stmt->bindParam(4, $montoabono);
	$stmt->bindParam(5, $formaabono);
	$stmt->bindParam(6, $fechaabono);

	$codcaja = limpiar($_POST["codcaja"]);
	$codcliente = limpiar($_POST["codcliente"]);
	$montoabono = limpiar($_POST["montoabono"]);
	$formaabono = limpiar($_POST["medioabono"]);
	$fechaabono = limpiar(date("Y-m-d H:i:s"));
	$stmt->execute();

   }

	} 
   ########## AGREGAMOS EL INGRESO Y ABONOS DE VENTAS A CREDITOS A CAJA ########

echo "<span class='fa fa-check-square-o'></span> LA COTIZACION HA SIDO PROCESADA COMO VENTA EXITOSAMENTE <a href='reportepdf?codventa=".encrypt($codventa)."&tipo=".encrypt($tipodocumento)."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR REPORTE</strong></font color></a></div>";

echo "<script>window.open('reportepdf?codventa=".encrypt($codventa)."&tipo=".encrypt($tipodocumento)."', '_blank');</script>";
	exit;
}
###################### FUNCION PROCESAR COTIZACIONES A VENTAS #################################

###################### FUNCION BUSQUEDA COTIZACIONES POR FECHAS ####################
public function BuscarCotizacionesxFechas() 
{
	self::SetNames();
	$sql ="SELECT 
	cotizaciones.idcotizacion, 
	cotizaciones.codcotizacion,
	cotizaciones.codcliente, 
	cotizaciones.subtotalivasi,
	cotizaciones.subtotalivano, 
	cotizaciones.iva,
	cotizaciones.totaliva, 
	cotizaciones.descontado,
	cotizaciones.descuento,
	cotizaciones.totaldescuento, 
	cotizaciones.totalpago, 
	cotizaciones.totalpago2,
	cotizaciones.observaciones,
	cotizaciones.fechacotizacion,
	clientes.tipocliente,
	clientes.documcliente,
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	provincias.provincia,
	departamentos.departamento,
	SUM(detallecotizaciones.cantcotizacion) as articulos 
	FROM (cotizaciones LEFT JOIN detallecotizaciones ON detallecotizaciones.codcotizacion = cotizaciones.codcotizacion)
	LEFT JOIN clientes ON cotizaciones.codcliente = clientes.codcliente
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia
	LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento
	WHERE DATE_FORMAT(cotizaciones.fechacotizacion,'%Y-%m-%d') BETWEEN ? AND ? 
	GROUP BY detallecotizaciones.codcotizacion";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COTIZACIONES PARA EL RANGO DE FECHA INGRESADO</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
################### FUNCION BUSQUEDA COTIZACIONES POR FECHAS ###################

###################### FUNCION BUSCAR PRODUCTOS COTIZADOS #########################
public function BuscarProductosCotizados() 
{
	self::SetNames();
   $sql ="SELECT 
   detallecotizaciones.idproducto,
   detallecotizaciones.codproducto,
   detallecotizaciones.producto,
   detallecotizaciones.descproducto,
   detallecotizaciones.ivaproducto,
   detallecotizaciones.preciocompra, 
   detallecotizaciones.precioventa, 
   productos.codcategoria,
   productos.existencia,
   categorias.nomcategoria, 
   cotizaciones.fechacotizacion,
   SUM(detallecotizaciones.cantcotizacion) as cantidad 
   FROM (cotizaciones INNER JOIN detallecotizaciones ON cotizaciones.codcotizacion = detallecotizaciones.codcotizacion) 
   LEFT JOIN productos ON detallecotizaciones.idproducto = productos.idproducto
   LEFT JOIN categorias ON productos.codcategoria=categorias.codcategoria 
   WHERE DATE_FORMAT(cotizaciones.fechacotizacion,'%Y-%m-%d') BETWEEN ? AND ? 
   GROUP BY detallecotizaciones.codproducto, detallecotizaciones.precioventa, detallecotizaciones.descproducto
   ORDER BY detallecotizaciones.codproducto ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN PRODUCTOS COTIZADOS PARA EL RANGO DE FECHA INGRESADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################### FUNCION PRODUCTOS COTIZADOS ###############################

###################### FUNCION BUSCAR PRODUCTOS COTIZADOS POR VENDEDOR #########################
public function BuscarCotizacionesxVendedor() 
{
   self::SetNames();
   $sql ="SELECT
   detallecotizaciones.idproducto, 
   detallecotizaciones.codproducto,
   detallecotizaciones.producto,
   detallecotizaciones.descproducto,
   detallecotizaciones.ivaproducto, 
   detallecotizaciones.precioventa, 
   productos.codcategoria,
   productos.existencia,
   categorias.nomcategoria, 
   cotizaciones.fechacotizacion,
   usuarios.dni,
   usuarios.nombres, 
   SUM(detallecotizaciones.cantcotizacion) as cantidad 
   FROM (cotizaciones INNER JOIN detallecotizaciones ON cotizaciones.codcotizacion = detallecotizaciones.codcotizacion) 
   INNER JOIN usuarios ON cotizaciones.codigo = usuarios.codigo 
   LEFT JOIN productos ON detallecotizaciones.idproducto = productos.idproducto  
   LEFT JOIN categorias ON productos.codcategoria=categorias.codcategoria
   WHERE cotizaciones.codigo = ? 
   AND DATE_FORMAT(cotizaciones.fechacotizacion,'%Y-%m-%d') BETWEEN ? AND ? 
   GROUP BY detallecotizaciones.codproducto
   ORDER BY detallecotizaciones.codproducto ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_GET['codigo']));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN PRODUCTOS FACTURADOS PARA EL VENDEDOR Y RANGO DE FECHA INGRESADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################### FUNCION PRODUCTOS COTIZADOS POR VENDEDOR ###############################

########################### FIN DE CLASE COTIZACIONES ############################































################################ CLASE CAJAS DE VENTAS ################################

######################### FUNCION REGISTRAR CAJAS DE VENTAS #######################
public function RegistrarCajas()
{
	self::SetNames();
	if(empty($_POST["nrocaja"]) or empty($_POST["nomcaja"]) or empty($_POST["codigo"]))
	{
		echo "1";
		exit;
	}
		
		$sql = "SELECT nrocaja FROM cajas WHERE nrocaja = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["nrocaja"]));
		$num = $stmt->rowCount();
		if($num > 0)
		{
		    echo "2";
		    exit;

		} else {
			
		$sql = "SELECT nomcaja FROM cajas WHERE nomcaja = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["nomcaja"]));
		$num = $stmt->rowCount();
		if($num > 0)
		{
			echo "3";
			exit;

		} else {
			
		$sql = "SELECT codigo FROM cajas WHERE codigo = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codigo"]));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$query = "INSERT INTO cajas values (null, ?, ?, ?); ";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $nrocaja);
			$stmt->bindParam(2, $nomcaja);
			$stmt->bindParam(3, $codigo);

			$nrocaja = limpiar($_POST["nrocaja"]);
			$nomcaja = limpiar($_POST["nomcaja"]);
			$codigo = limpiar($_POST["codigo"]);
			$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> LA CAJA PARA VENTA HA SIDO REGISTRADA EXITOSAMENTE";
			exit;

			} else {

			echo "4";
			exit;
		    }
		}
	}
}
######################### FUNCION REGISTRAR CAJAS DE VENTAS #########################

######################### FUNCION LISTAR CAJAS DE VENTAS ################################
public function ListarCajas()
{
	self::SetNames();
	
	if($_SESSION['acceso'] == "administrador") {

        $sql = "SELECT * FROM cajas INNER JOIN usuarios ON cajas.codigo = usuarios.codigo";
			foreach ($this->dbh->query($sql) as $row)
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;

	} else {

        $sql = "SELECT * FROM cajas INNER JOIN usuarios ON cajas.codigo = usuarios.codigo WHERE cajas.codigo = '".limpiar($_SESSION["codigo"])."'";
			foreach ($this->dbh->query($sql) as $row)
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
	}
}
######################### FUNCION LISTAR CAJAS DE VENTAS ################################

############################ FUNCION ID CAJAS DE VENTAS #################################
public function CajasPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM cajas INNER JOIN usuarios ON usuarios.codigo = cajas.codigo WHERE cajas.codcaja = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codcaja"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID CAJAS DE VENTAS #################################

#################### FUNCION ACTUALIZAR CAJAS DE VENTAS ############################
public function ActualizarCajas()
{
	self::SetNames();
	if(empty($_POST["codcaja"]) or empty($_POST["nrocaja"]) or empty($_POST["nomcaja"]) or empty($_POST["codigo"]))
	{
		echo "1";
		exit;
	}
		$sql = "SELECT nrocaja FROM cajas WHERE codcaja != ? AND nrocaja = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codcaja"],$_POST["nrocaja"]));
		$num = $stmt->rowCount();
		if($num > 0)
		{
		    echo "2";
		    exit;

		} else {
			
		$sql = "SELECT nomcaja FROM cajas WHERE codcaja != ? AND nomcaja = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codcaja"],$_POST["nomcaja"]));
		$num = $stmt->rowCount();
		if($num > 0)
		{
			echo "3";
			exit;

		} else {
			
		$sql = "SELECT codigo FROM cajas WHERE codcaja != ? AND codigo = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_POST["codcaja"],$_POST["codigo"]));
		$num = $stmt->rowCount();
		if($num == 0)
		{
			$sql = "UPDATE cajas set "
			." nrocaja = ?, "
			." nomcaja = ?, "
			." codigo = ? "
			." WHERE "
			." codcaja = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $nrocaja);
			$stmt->bindParam(2, $nomcaja);
			$stmt->bindParam(3, $codigo);
			$stmt->bindParam(4, $codcaja);

			$nrocaja = limpiar($_POST["nrocaja"]);
			$nomcaja = limpiar($_POST["nomcaja"]);
			$codigo = limpiar($_POST["codigo"]);
			$codcaja = limpiar($_POST["codcaja"]);
			$stmt->execute();

			echo "<span class='fa fa-check-square-o'></span> LA CAJA PARA VENTA HA SIDO ACTUALIZADA EXITOSAMENTE";
			exit;

			} else {

			echo "4";
			exit;
		    }
		}
	}
}
#################### FUNCION ACTUALIZAR CAJAS DE VENTAS ###########################

####################### FUNCION ELIMINAR CAJAS DE VENTAS ########################
public function EliminarCajas()
{
	self::SetNames();
		if ($_SESSION['acceso'] == "administrador") {

		$sql = "SELECT codcaja FROM ventas WHERE codcaja = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codcaja"])));
		$num = $stmt->rowCount();
		if($num == 0)
		{

			$sql = "DELETE FROM cajas WHERE codcaja = ?";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1,$codcaja);
			$codcaja = decrypt($_GET["codcaja"]);
			$stmt->execute();

			echo "1";
			exit;

		} else {
		   
			echo "2";
			exit;
		  } 
			
		} else {
		
		echo "3";
		exit;
	 }	
}
####################### FUNCION ELIMINAR CAJAS DE VENTAS #######################

######################### FUNCION LISTAR CAJAS ABIERTAS ##########################
public function ListarCajasAbiertas()
{
	self::SetNames();
	if ($_SESSION['acceso'] == "administrador") {

	$sql = "SELECT * FROM arqueocaja INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja INNER JOIN usuarios ON cajas.codigo = usuarios.codigo WHERE arqueocaja.statusarqueo = 1";
		foreach ($this->dbh->query($sql) as $row)
	    {
		$this->p[] = $row;
	    }
	    return $this->p;
	    $this->dbh=null;

	} else {

        $sql = "SELECT * FROM arqueocaja INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja INNER JOIN usuarios ON cajas.codigo = usuarios.codigo WHERE cajas.codigo = '".limpiar($_SESSION["codigo"])."' AND arqueocaja.statusarqueo = 1";
			foreach ($this->dbh->query($sql) as $row)
	    {
		$this->p[] = $row;
	    }
	    return $this->p;
	    $this->dbh=null;
    }
}
######################### FUNCION LISTAR CAJAS ABIERTAS ##########################

############################ FIN DE CLASE CAJAS DE VENTAS ##############################


























########################## CLASE ARQUEOS DE CAJA ###################################

########################## FUNCION PARA REGISTRAR ARQUEO DE CAJA ####################
public function RegistrarArqueoCaja()
{
	self::SetNames();
	if(empty($_POST["codcaja"]) or empty($_POST["montoinicial"]) or empty($_POST["fecharegistro"]))
	{
		echo "1";
		exit;
	}

	$sql = "SELECT codcaja FROM arqueocaja WHERE codcaja = ? AND statusarqueo = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codcaja"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$query = "INSERT INTO arqueocaja values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcaja);
		$stmt->bindParam(2, $montoinicial);
		$stmt->bindParam(3, $efectivo);
		$stmt->bindParam(4, $cheque);
		$stmt->bindParam(5, $tcredito);
		$stmt->bindParam(6, $tdebito);
		$stmt->bindParam(7, $tprepago);
		$stmt->bindParam(8, $transferencia);
		$stmt->bindParam(9, $electronico);
		$stmt->bindParam(10, $cupon);
		$stmt->bindParam(11, $otros);
		$stmt->bindParam(12, $creditos);
		$stmt->bindParam(13, $abonosefectivo);
		$stmt->bindParam(14, $abonosotros);
		$stmt->bindParam(15, $propinasefectivo);
		$stmt->bindParam(16, $propinasotros);
		$stmt->bindParam(17, $ingresosefectivo);
		$stmt->bindParam(18, $ingresosotros);
		$stmt->bindParam(19, $egresos);
		$stmt->bindParam(20, $egresonotas);
		$stmt->bindParam(21, $nroticket);
		$stmt->bindParam(22, $nroboleta);
		$stmt->bindParam(23, $nrofactura);
		$stmt->bindParam(24, $nronota);
		$stmt->bindParam(25, $dineroefectivo);
		$stmt->bindParam(26, $diferencia);
		$stmt->bindParam(27, $comentarios);
		$stmt->bindParam(28, $fechaapertura);
		$stmt->bindParam(29, $fechacierre);
		$stmt->bindParam(30, $statusarqueo);

		$codcaja = limpiar($_POST["codcaja"]);
		$montoinicial = limpiar($_POST["montoinicial"]);
		$efectivo = limpiar("0.00");
		$cheque = limpiar("0.00");
		$tcredito = limpiar("0.00");
		$tdebito = limpiar("0.00");
		$tprepago = limpiar("0.00");
		$transferencia = limpiar("0.00");
		$electronico = limpiar("0.00");
		$cupon = limpiar("0.00");
		$otros = limpiar("0.00");
		$creditos = limpiar("0.00");
		$abonosefectivo = limpiar("0.00");
		$abonosotros = limpiar("0.00");
		$propinasefectivo = limpiar("0.00");
		$propinasotros = limpiar("0.00");
		$ingresosefectivo = limpiar("0.00");
		$ingresosotros = limpiar("0.00");
		$egresos = limpiar("0.00");
		$egresonotas = limpiar("0.00");
		$nroticket = limpiar("0");
		$nroboleta = limpiar("0");
		$nrofactura = limpiar("0");
		$nronota = limpiar("0");
		$dineroefectivo = limpiar("0.00");
		$diferencia = limpiar("0.00");
		$comentarios = limpiar('NINGUNO');
		$fechaapertura = limpiar(date("Y-m-d H:i:s",strtotime($_POST['fecharegistro'])));
		$fechacierre = limpiar("0000-00-00 00:00:00");
		$statusarqueo = limpiar("1");
		$stmt->execute();

		echo "<span class='fa fa-check-square-o'></span> EL ARQUEO DE CAJA HA SIDO REALIZADO EXITOSAMENTE";
		exit;

			} else {

			echo "2";
			exit;
	    }
}
######################## FUNCION PARA REGISTRAR ARQUEO DE CAJA #######################

######################## FUNCION PARA LISTAR ARQUEO DE CAJA ########################
public function ListarArqueoCaja()
{
	self::SetNames();
	
	if($_SESSION['acceso'] == "administrador") {

        $sql = "SELECT * FROM arqueocaja INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja INNER JOIN usuarios ON cajas.codigo = usuarios.codigo";
			foreach ($this->dbh->query($sql) as $row)
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;

	} else {

        $sql = "SELECT * FROM arqueocaja INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja INNER JOIN usuarios ON cajas.codigo = usuarios.codigo WHERE cajas.codigo = '".limpiar($_SESSION["codigo"])."'";
			foreach ($this->dbh->query($sql) as $row)
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
	}
}
######################## FUNCION PARA LISTAR ARQUEO DE CAJA #########################

########################## FUNCION ID ARQUEO DE CAJA #############################
public function ArqueoCajaPorId()
{
	self::SetNames();
	$sql = "SELECT * FROM arqueocaja 
	INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo WHERE arqueocaja.codarqueo = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codarqueo"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################## FUNCION ID ARQUEO DE CAJA #############################

##################### FUNCION VERIFICA ARQUEO DE CAJA POR USUARIO #######################
public function ArqueoCajaPorUsuario()
{
	self::SetNames();
	$sql = "SELECT * FROM arqueocaja 
	INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	INNER JOIN usuarios ON cajas.codigo = usuarios.codigo 
	WHERE usuarios.codigo = ? 
	AND arqueocaja.statusarqueo = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar($_SESSION["codigo"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
###################### FUNCION VERIFICA ARQUEO DE CAJA POR USUARIO ###################

######################### FUNCION PARA CERRAR ARQUEO DE CAJA #########################
public function CerrarArqueoCaja()
{
	self::SetNames();
	if(empty($_POST["codarqueo"]) or empty($_POST["dineroefectivo"]))
	{
		echo "1";
		exit;
	}

	if($_POST["dineroefectivo"] != 0.00 || $_POST["dineroefectivo"] != 0){

		$sql = "UPDATE arqueocaja SET "
		." dineroefectivo = ?, "
		." diferencia = ?, "
		." comentarios = ?, "
		." fechacierre = ?, "
		." statusarqueo = ? "
		." WHERE "
		." codarqueo = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $dineroefectivo);
		$stmt->bindParam(2, $diferencia);
		$stmt->bindParam(5, $statusarqueo);
		$stmt->bindParam(3, $comentarios);
		$stmt->bindParam(4, $fechacierre);
		$stmt->bindParam(6, $codarqueo);

		$dineroefectivo = limpiar($_POST["dineroefectivo"]);
		$diferencia = limpiar($_POST["diferencia"]);
		$comentarios = limpiar($_POST['comentarios']);
		$fechacierre = limpiar(date("Y-m-d H:i:s",strtotime($_POST['fecharegistro'])));
		$statusarqueo = limpiar("0");
		$codarqueo = limpiar($_POST["codarqueo"]);
		$stmt->execute();

	echo "<span class='fa fa-check-square-o'></span> EL CIERRE DE CAJA FUE REALIZADO EXITOSAMENTE <a href='reportepdf?codarqueo=".encrypt($codarqueo)."&tipo=".encrypt("TICKETCIERRE")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR TICKET</strong></font color></a></div>";

	echo "<script>window.open('reportepdf?codarqueo=".encrypt($codarqueo)."&tipo=".encrypt("TICKETCIERRE")."', '_blank');</script>";
	exit;
			} else {

			echo "2";
			exit;
	    }
}
######################### FUNCION PARA CERRAR ARQUEO DE CAJA ######################

###################### FUNCION BUSCAR ARQUEOS DE CAJA POR FECHAS ######################
public function BuscarArqueosxFechas() 
	       {
		self::SetNames();		
$sql = "SELECT * FROM arqueocaja INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo WHERE arqueocaja.codcaja = ? AND DATE_FORMAT(arqueocaja.fechaapertura,'%Y-%m-%d') >= ? AND DATE_FORMAT(arqueocaja.fechaapertura,'%Y-%m-%d') <= ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(1, trim(decrypt($_GET['codcaja'])));
		$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
		$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)
		{
		echo "<center><div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</div></center>";
		exit;
		}
		else
		{
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
	    }
	
}
######################## FUNCION BUSCAR ARQUEOS DE CAJA POR FECHAS ####################

############################# FIN DE CLASE ARQUEOS DE CAJA ###########################


























############################ CLASE MOVIMIENTOS EN CAJAS ##############################

###################### FUNCION PARA REGISTRAR MOVIMIENTO EN CAJA #######################
public function RegistrarMovimientos()
{
	self::SetNames();
	if(empty($_POST["tipomovimiento"]) or empty($_POST["montomovimiento"]) or empty($_POST["mediomovimiento"]) or empty($_POST["codcaja"]))
	{
		echo "1";
		exit;
	}
	elseif($_POST["montomovimiento"] == "" || $_POST["montomovimiento"] == 0 || $_POST["montomovimiento"] == 0.00)
	{
		echo "2";
		exit;

	}

	$sql = "SELECT * FROM arqueocaja WHERE codcaja = '".limpiar($_POST["codcaja"])."' AND statusarqueo = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "4";
		exit;
	}  
	
	#################### SELECCIONAMOS LOS DATOS DE CAJA ####################
	$sql = "SELECT 
	codarqueo,
	montoinicial, 
	efectivo, 
	abonosefectivo, 
	propinasefectivo,
	ingresosefectivo,
	ingresosotros, 
	egresos FROM arqueocaja WHERE codcaja = '".limpiar($_POST["codcaja"])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$arqueo = $row['codarqueo'];
	$inicial = $row['montoinicial'];
	$efectivo = $row['efectivo'];
	$abono = $row['abonosefectivo'];
	$propina = $row['propinasefectivo'];
	$ingreso = $row['ingresosefectivo'];
	$ingreso2 = $row['ingresosotros'];
	$egresos = $row['egresos'];
	$total = $inicial+$efectivo+$abono+$propina+$ingreso-$egresos;
	#################### SELECCIONAMOS LOS DATOS DE CAJA ####################

	//REALIZO LA CONDICION SI EL MOVIMIENTO ES UN INGRESO
	if($_POST["tipomovimiento"]=="INGRESO"){ 

		######################## ACTUALIZO DATOS EN ARQUEO ########################
		$sql = " UPDATE arqueocaja SET "
		." ingresosefectivo = ?, "
		." ingresosotros = ? "
		." WHERE "
		." codcaja = ? AND statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtEfectivo);
		$stmt->bindParam(2, $txtOtros);
		$stmt->bindParam(3, $codcaja);

		$txtEfectivo = limpiar($_POST["mediomovimiento"] == "EFECTIVO" ? number_format($ingreso+$_POST["montomovimiento"], 2, '.', '') : $ingreso);
	    $txtOtros = limpiar($_POST["mediomovimiento"] != "EFECTIVO" ? number_format($ingreso2+$_POST["montomovimiento"], 2, '.', '') : $ingreso2);
		$codcaja = limpiar($_POST["codcaja"]);
		$stmt->execute();
		######################## ACTUALIZO DATOS EN ARQUEO ########################

		######################## REGISTRO EL MOVIMIENTOS EN CAJA ########################
		$query = "INSERT INTO movimientoscajas values (null, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcaja);
		$stmt->bindParam(2, $tipomovimiento);
		$stmt->bindParam(3, $descripcionmovimiento);
		$stmt->bindParam(4, $montomovimiento);
		$stmt->bindParam(5, $mediomovimiento);
		$stmt->bindParam(6, $fechamovimiento);
		$stmt->bindParam(7, $arqueo);

		$codcaja = limpiar($_POST["codcaja"]);
		$tipomovimiento = limpiar($_POST["tipomovimiento"]);
		$descripcionmovimiento = limpiar($_POST["descripcionmovimiento"]);
		$montomovimiento = limpiar($_POST["montomovimiento"]);
		$mediomovimiento = limpiar($_POST["mediomovimiento"]);
		$fechamovimiento = limpiar(date("Y-m-d H:i:s",strtotime($_POST['fecharegistro'])));
		$stmt->execute();
		######################## REGISTRO EL MOVIMIENTOS EN CAJA ########################

    //REALIZO LA CONDICION SI EL MOVIMIENTO ES UN EGRESO
	} else {

	    if($_POST["mediomovimiento"]!="EFECTIVO"){

			echo "5";
			exit;

        } else if($_POST["montomovimiento"]>$total){

			echo "6";
			exit;

        } else {

		######################## ACTUALIZO DATOS EN ARQUEO ########################
        $sql = "UPDATE arqueocaja SET "
		." egresos = ? "
		." WHERE "
		." codcaja = ? AND statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $egresos);
		$stmt->bindParam(2, $codcaja);

		$egresos = number_format($egresos+$_POST["montomovimiento"], 2, '.', '');
		$codcaja = limpiar($_POST["codcaja"]);
		$stmt->execute();
		######################## ACTUALIZO DATOS EN ARQUEO ########################

		######################## REGISTRO EL MOVIMIENTOS EN CAJA ########################
		$query = "INSERT INTO movimientoscajas values (null, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcaja);
		$stmt->bindParam(2, $tipomovimiento);
		$stmt->bindParam(3, $descripcionmovimiento);
		$stmt->bindParam(4, $montomovimiento);
		$stmt->bindParam(5, $mediomovimiento);
		$stmt->bindParam(6, $fechamovimiento);
		$stmt->bindParam(7, $arqueo);

		$codcaja = limpiar($_POST["codcaja"]);
		$tipomovimiento = limpiar($_POST["tipomovimiento"]);
		$descripcionmovimiento = limpiar($_POST["descripcionmovimiento"]);
		$montomovimiento = limpiar($_POST["montomovimiento"]);
		$mediomovimiento = limpiar($_POST["mediomovimiento"]);
		$fechamovimiento = limpiar(date("Y-m-d H:i:s",strtotime($_POST['fecharegistro'])));
		$stmt->execute();
		######################## REGISTRO EL MOVIMIENTOS EN CAJA ########################

	     }
	}

	echo "<span class='fa fa-check-square-o'></span> EL MOVIMIENTO EN CAJA HA SIDO REGISTRADO EXITOSAMENTE";
	exit;	
}
##################### FUNCION PARA REGISTRAR MOVIMIENTO EN CAJA #######################

###################### FUNCION PARA LISTAR MOVIMIENTO EN CAJA #######################
public function ListarMovimientos()
{
	self::SetNames();
	
	if($_SESSION['acceso'] == "administrador") {

        $sql = "SELECT * FROM movimientoscajas 
        INNER JOIN cajas ON movimientoscajas.codcaja = cajas.codcaja
        LEFT JOIN arqueocaja ON movimientoscajas.codarqueo = arqueocaja.codarqueo 
        LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo 
        ORDER BY codmovimiento DESC";
			foreach ($this->dbh->query($sql) as $row)
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;

	} else {

        $sql = "SELECT * FROM movimientoscajas 
        INNER JOIN cajas ON movimientoscajas.codcaja = cajas.codcaja
        LEFT JOIN arqueocaja ON movimientoscajas.codarqueo = arqueocaja.codarqueo 
        LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo 
        WHERE usuarios.codigo = '".limpiar($_SESSION["codigo"])."' ORDER BY codmovimiento DESC";
			foreach ($this->dbh->query($sql) as $row)
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
	}
}
###################### FUNCION PARA LISTAR MOVIMIENTO EN CAJA ######################

########################## FUNCION ID MOVIMIENTO EN CAJA #############################
public function MovimientosPorId()
{
	self::SetNames();
	$sql = "SELECT * from movimientoscajas INNER JOIN cajas ON movimientoscajas.codcaja = cajas.codcaja INNER JOIN usuarios ON cajas.codigo = usuarios.codigo WHERE movimientoscajas.codmovimiento = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codmovimiento"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[] = $row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
########################## FUNCION ID MOVIMIENTO EN CAJA #############################

##################### FUNCION PARA ACTUALIZAR MOVIMIENTOS EN CAJA ##################
public function ActualizarMovimientos()
{
	self::SetNames();
if(empty($_POST["codmovimiento"]) or empty($_POST["tipomovimiento"]) or empty($_POST["montomovimiento"]) or empty($_POST["mediomovimiento"]) or empty($_POST["codcaja"]))
	{
		echo "1";
		exit;
	}
	elseif($_POST["montomovimiento"] == "" || $_POST["montomovimiento"] == 0 || $_POST["montomovimiento"] == 0.00)
	{
		echo "2";
		exit;

	}
	elseif($_POST["tipomovimiento"] != $_POST["tipomovimientobd"] || $_POST["mediomovimiento"] != $_POST["mediomovimientobd"])
	{
		echo "3";
		exit;

	}

	$sql = "SELECT * FROM arqueocaja WHERE codcaja = '".limpiar($_POST["codcaja"])."' AND statusarqueo = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "4";
		exit;
	}  

	#################### SELECCIONAMOS LOS DATOS DE CAJA ####################
	$sql = "SELECT
	montoinicial, 
	efectivo, 
	abonosefectivo, 
	propinasefectivo,
	ingresosefectivo,
	ingresosotros,  
	egresos,
	statusarqueo  
	FROM arqueocaja INNER JOIN movimientoscajas ON arqueocaja.codarqueo = movimientoscajas.codarqueo WHERE arqueocaja.codarqueo = '".limpiar($_POST["codarqueo"])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$inicial = $row['montoinicial'];
	$efectivo = $row['efectivo'];
	$abono = $row['abonosefectivo'];
	$propina = $row['propinasefectivo'];
	$ingreso = $row['ingresosefectivo'];
	$ingreso2 = $row['ingresosotros'];
	$egreso = $row['egresos'];
	$status = $row['statusarqueo'];
	$total = $inicial+$efectivo+$abono+$propina+$ingreso-$egreso;
	#################### SELECCIONAMOS LOS DATOS DE CAJA ####################
	
	//REALIZAMOS CALCULO DE CAMPOS
	$montomovimiento = limpiar($_POST["montomovimiento"]);
	$montomovimientobd = limpiar($_POST["montomovimientobd"]);
	$ingresobd = number_format($ingreso-$montomovimientobd, 2, '.', '');
	$ingresobd2 = number_format($ingreso2-$montomovimientobd, 2, '.', '');
	$totalmovimiento = number_format($montomovimiento-$montomovimientobd, 2, '.', '');

	if($status == 1) {

	if($_POST["tipomovimiento"]=="INGRESO"){ //REALIZO LA CONDICION SI EL MOVIMIENTO ES UN INGRESO

	$sql = "UPDATE arqueocaja SET "
		." ingresosefectivo = ?, "
		." ingresosotros = ? "
		." WHERE "
		." codcaja = ? AND statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtEfectivo);
		$stmt->bindParam(2, $txtOtros);
		$stmt->bindParam(3, $codcaja);
		
		$txtEfectivo = limpiar($_POST["mediomovimiento"] == "EFECTIVO" ? number_format($ingresobd+$montomovimiento, 2, '.', '') : $ingreso);
	    $txtOtros = limpiar($_POST["mediomovimiento"] != "EFECTIVO" ? number_format($ingresobd2+$montomovimiento, 2, '.', '') : $ingreso2);
		$codcaja = limpiar($_POST["codcaja"]);
		$stmt->execute();

	    $sql = "UPDATE movimientoscajas SET"
		." codcaja = ?, "
		." tipomovimiento = ?, "
		." descripcionmovimiento = ?, "
		." montomovimiento = ?, "
		." mediomovimiento = ? "
		." WHERE "
		." codmovimiento = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $codcaja);
		$stmt->bindParam(2, $tipomovimiento);
		$stmt->bindParam(3, $descripcionmovimiento);
		$stmt->bindParam(4, $montomovimiento);
		$stmt->bindParam(5, $mediomovimiento);
		$stmt->bindParam(6, $codmovimiento);

		$codcaja = limpiar($_POST["codcaja"]);
		$tipomovimiento = limpiar($_POST["tipomovimiento"]);
		$descripcionmovimiento = limpiar($_POST["descripcionmovimiento"]);
		$montomovimiento = limpiar($_POST["montomovimiento"]);
		$mediomovimiento = limpiar($_POST["mediomovimiento"]);
		$codmovimiento = limpiar($_POST["codmovimiento"]);
		$stmt->execute();

	} else { //REALIZO LA CONDICION SI EL MOVIMIENTO ES UN EGRESO

	    if($_POST["mediomovimiento"]!="EFECTIVO"){

			echo "5";
			exit;

        } else if($totalmovimiento>$total){

			echo "6";
			exit;

        } else {

	$sql = "UPDATE arqueocaja SET"
		." egresos = ? "
		." WHERE "
		." codcaja = ? AND statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $egresos);
		$stmt->bindParam(2, $codcaja);

		$egresos = number_format($egreso+$totalmovimiento, 2, '.', '');
		$codcaja = limpiar($_POST["codcaja"]);
		$stmt->execute();

		$sql = "UPDATE movimientoscajas SET"
		." codcaja = ?, "
		." tipomovimiento = ?, "
		." descripcionmovimiento = ?, "
		." montomovimiento = ?, "
		." mediomovimiento = ? "
		." WHERE "
		." codmovimiento = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $codcaja);
		$stmt->bindParam(2, $tipomovimiento);
		$stmt->bindParam(3, $descripcionmovimiento);
		$stmt->bindParam(4, $montomovimiento);
		$stmt->bindParam(5, $mediomovimiento);
		$stmt->bindParam(6, $codmovimiento);

		$codcaja = limpiar($_POST["codcaja"]);
		$tipomovimiento = limpiar($_POST["tipomovimiento"]);
		$descripcionmovimiento = limpiar($_POST["descripcionmovimiento"]);
		$montomovimiento = limpiar($_POST["montomovimiento"]);
		$mediomovimiento = limpiar($_POST["mediomovimiento"]);
		$codmovimiento = limpiar($_POST["codmovimiento"]);
		$stmt->execute();

	    }
	}	

	echo "<span class='fa fa-check-square-o'></span> EL MOVIMIENTO EN CAJA HA SIDO ACTUALIZADO EXITOSAMENTE";
    exit;

	} else {
		   
		echo "7";
		exit;
    }
} 
##################### FUNCION PARA ACTUALIZAR MOVIMIENTOS EN CAJA ####################	

###################### FUNCION PARA ELIMINAR MOVIMIENTOS EN CAJA ######################
public function EliminarMovimiento()
{
	if($_SESSION['acceso'] == "administrador" || $_SESSION['acceso'] == "secretaria" || $_SESSION['acceso'] == "cajero") {

    #################### AGREGAMOS EL INGRESO A ARQUEO EN CAJA ####################
	$sql = "SELECT * FROM movimientoscajas INNER JOIN arqueocaja ON movimientoscajas.codarqueo = arqueocaja.codarqueo WHERE movimientoscajas.codmovimiento = '".limpiar(decrypt($_GET["codmovimiento"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	//OBTENEMOS CAMPOS DE MOVIMIENTOS
	$codcaja = $row['codcaja'];
	$tipomovimiento = $row['tipomovimiento'];
	$descripcionmovimiento = $row['descripcionmovimiento'];
	$montomovimiento = $row['montomovimiento'];
	$mediomovimiento = $row['mediomovimiento'];
	$fechamovimiento = $row['fechamovimiento'];

	//OBTENEMOS CAMPOS DE ARQUEO
	$inicial = $row['montoinicial'];
	$efectivo = $row['efectivo'];
	$ingreso = $row['ingresosefectivo'];
	$ingreso2 = $row['ingresosotros'];
	$egreso = $row['egresos'];
	$status = $row['statusarqueo'];

    if($status == 1) {

        if($tipomovimiento=="INGRESO"){

		$sql = "UPDATE arqueocaja SET"
		." ingresosefectivo = ?, "
		." ingresosotros = ? "
		." WHERE "
		." codcaja = ? AND statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtEfectivo);
		$stmt->bindParam(2, $txtOtros);
		$stmt->bindParam(3, $codcaja);

	   $txtEfectivo = limpiar($mediomovimiento == "EFECTIVO" ? number_format($ingreso-$montomovimiento, 2, '.', '') : $ingreso);
	    $txtOtros = limpiar($mediomovimiento != "EFECTIVO" ? number_format($ingreso2-$montomovimiento, 2, '.', '') : $ingreso2);
		$stmt->execute();

       } else {

		$sql = "UPDATE arqueocaja SET "
		." egresos = ? "
		." WHERE "
		." codcaja = ? AND statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $egresos);
		$stmt->bindParam(2, $codcaja);

		$egresos = number_format($egreso-$montomovimiento, 2, '.', '');
		$stmt->execute();

      }

		$sql = "DELETE FROM movimientoscajas WHERE codmovimiento = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codmovimiento);
		$codmovimiento = decrypt($_GET["codmovimiento"]);
		$stmt->execute();

		echo "1";
		exit;
		   
		 } else {
		   
			echo "2";
			exit;
		  }
			
	} else {
		
		echo "3";
		exit;
	 }	
}
###################### FUNCION PARA ELIMINAR MOVIMIENTOS EN CAJAS  ####################

################## FUNCION BUSCAR MOVIMIENTOS DE CAJA POR FECHAS #######################
public function BuscarMovimientosxFechas() 
	       {
		self::SetNames();		
$sql = "SELECT * FROM movimientoscajas INNER JOIN cajas ON movimientoscajas.codcaja = cajas.codcaja INNER JOIN usuarios ON cajas.codigo = usuarios.codigo WHERE movimientoscajas.codcaja = ? AND DATE_FORMAT(movimientoscajas.fechamovimiento,'%Y-%m-%d') >= ? AND DATE_FORMAT(movimientoscajas.fechamovimiento,'%Y-%m-%d') <= ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(1, trim(decrypt($_GET['codcaja'])));
		$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
		$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num==0)
		{
		echo "<center><div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</div></center>";
		exit;
		}
		else
		{
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
	    }
	
}
###################### FUNCION BUSCAR MOVIMIENTOS DE CAJA POR FECHAS ###################

######################### FIN DE CLASE MOVIMIENTOS EN CAJAS #############################


























































###################################### CLASE VENTAS ###################################

##################################################################################################################
#                                                                                                                #
#                                   FUNCIONES PARA PEDIDOS DE PRODUCTOS EN MESA                                  #
#                                                                                                                #
##################################################################################################################

####################### FUNCION VERIFICAR PEDIDOS EN MESAS #######################
public function VerificaMesa()
{ 
	self::SetNames();
	$imp = new Login();
	$imp = $imp->ImpuestosPorId();
	$impuesto = ($imp == '' ? "Impuesto" : $imp[0]['nomimpuesto']);
	$valor = ($imp == '' ? "0.00" : $imp[0]['valorimpuesto']);

	$con = new Login();
	$con = $con->ConfiguracionPorId();
	$simbolo = ($con == '' ? "" : "<strong>".$con[0]['simbolo']."</strong>");

	if ($_SESSION["acceso"]!="mesero") {

	 	$sql = "SELECT * FROM arqueocaja 
	 	INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	 	INNER JOIN usuarios ON cajas.codigo = usuarios.codigo 
	 	WHERE usuarios.codigo = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_SESSION["codigo"]));
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "<div class='alert alert-danger'>";
            echo "<center><span class='fa fa-info-circle'></span> POR FAVOR DEBE DE REALIZAR EL ARQUEO DE CAJA ASIGNADA PARA PROCESAR VENTAS <a href='arqueos'><label> REALIZAR ARQuuyuyyuyyyUEO</a></label></div></center>";
			exit;
	    }
	}

	$sql = "SELECT
	clientes.documcliente,
	clientes.dnicliente, 
    CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente, 
    ventas.codpedido, 
    ventas.codventa,
    ventas.codcaja, 
    ventas.codcliente, 
    documentos.documento, 
    ventas.subtotalivasi, 
    ventas.subtotalivano, 
    ventas.iva, 
    ventas.totaliva, 
	ventas.descontado,
    ventas.descuento, 
    ventas.totaldescuento, 
    ventas.totalpago, 
    ventas.totalpago2,
	ventas.creditopagado,
    ventas.montodelivery, 
    ventas.codigo, 
    ventas.observaciones, 
    detallepedidos.coddetallepedido, 
    detallepedidos.codpedido, 
    detallepedidos.pedido, 
    detallepedidos.codproducto, 
    detallepedidos.producto, 
    detallepedidos.ivaproducto, 
    detallepedidos.cantventa, 
    detallepedidos.descproducto, 
    detallepedidos.valortotal, 
    detallepedidos.totaldescuentov, 
    detallepedidos.valorneto,  
    detallepedidos.observacionespedido,
    detallepedidos.tipo,
    salas.nomsala, 
    mesas.codmesa, 
    mesas.nommesa,
    mesas.statusmesa, 
    usuarios.nombres 
    FROM mesas INNER JOIN ventas ON mesas.codmesa = ventas.codmesa 
    INNER JOIN detallepedidos ON detallepedidos.codpedido = ventas.codpedido
    INNER JOIN salas ON salas.codsala = mesas.codsala  
    LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente 
    LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento 
    LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo 
    WHERE ventas.codmesa = ?
    AND  ventas.codpedido = ? 
    AND ventas.codventa = ? 
    AND mesas.statusmesa = 1 
    AND ventas.statuspago = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codmesa"]),decrypt($_GET["codpedido"]),decrypt($_GET["codventa"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
	?>

	<?php
    $mesa = new Login();
    $mesa = $mesa->MesasPorId();
    ?> 

    <input type="hidden" name="proceso" id="proceso" value="nuevopedido"/>
    <input type="hidden" name="mesa" id="mesa" value="<?php echo encrypt($mesa[0]['codmesa']); ?>">
    <input type="hidden" name="pedido" id="pedido" value="<?php echo encrypt("0"); ?>">
    <input type="hidden" name="venta" id="venta" value="<?php echo encrypt("0"); ?>">
    <input type="hidden" name="codpedido" id="codpedido" value="<?php echo encrypt("0"); ?>">
    <input type="hidden" name="codventa" id="codventa" value="<?php echo encrypt("0"); ?>">
    <input type="hidden" name="codmesa" id="codmesa" value="<?php echo $mesa[0]['codmesa']; ?>">
    <input type="hidden" name="nombremesa" id="nombremesa" value="<?php echo $mesa[0]['nommesa']; ?>">
    <input type="hidden" name="idproducto" id="idproducto">
    <input type="hidden" name="codproducto" id="codproducto">
    <input type="hidden" name="producto" id="producto">
    <input type="hidden" name="codcategoria" id="codcategoria">
    <input type="hidden" name="categorias" id="categorias">
    <input type="hidden" name="precioventa" id="precioventa">
    <input type="hidden" name="preciocompra" id="preciocompra"> 
    <input type="hidden" name="precioconiva" id="precioconiva">
    <input type="hidden" name="observacion" id="observacion">
    <input type="hidden" name="ivaproducto" id="ivaproducto">
    <input type="hidden" name="descproducto" id="descproducto">
    <input type="hidden" name="tipo" id="tipo">
    <input type="hidden" name="cantidad" id="cantidad" value="1">
    <input type="hidden" name="existencia" id="existencia">

    <div class="row">
        <div class="col-md-12">
            <label class="control-label">Búsqueda de Cliente: </label>
            <div class="input-group mb-3 has-feedback">
                <div class="input-group-append">
                <button type="button" class="btn btn-success waves-effect waves-light" data-placement="left" title="Nuevo Cliente" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCliente" data-backdrop="static" data-keyboard="false"><i class="fa fa-user-plus"></i></button>
                </div>
                <input type="hidden" name="codcliente" id="codcliente" value="0">
                <input type="text" class="form-control" name="busqueda" id="busqueda" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Criterio para la Búsqueda del Cliente" value="CONSUMIDOR FINAL" autocomplete="off"/>
            </div>
        </div>
    </div>
      
    <div id="favoritos" style="display:none !important;"></div>

    <div class="table-responsive m-t-10 scroll">
    	<table id="carrito" class="table2">
    		<thead>
    			<tr class="text-center">
    				<th width="16%">Cantidad</th>
    				<th width="42%">Descripción</th>
    				<th width="14%">Precio</th>
    				<th width="14%">Importe</th>
    				<th width="14%">Acción</th>
    			</tr>
    		</thead>
    		<tbody>
    			<tr>
    				<td class="text-center" colspan=5><h4>NO HAY DETALLES AGREGADOS<h4></td>
    				</tr>
    			</tbody>
    		</table> 
    	</div>

    	<hr>

    	<div class="table-responsive">
    		<table id="carritototal" width="100%">
    			<tr>
                   <td><h5 class="text-left"><label>TOTAL DE ITEMS:</label></h5></td>
                   <td><h5 class="text-right"><label id="lblitems" name="lblitems">0.00</label></h5></td>
                </tr>
                <tr>
    				<td><h5 class="text-left"><label>TOTAL A CONFIRMAR:</label></h5></td>
    				<td><h5 class="text-right"><?php echo $simbolo; ?><label id="lbltotal" name="lbltotal">0.00</label></h5></td>
    				<input type="hidden" name="txtsubtotal" id="txtsubtotal" value="0.00"/>
    				<input type="hidden" name="txtsubtotal2" id="txtsubtotal2" value="0.00"/>
    				<input type="hidden" name="iva" id="iva" value="<?php echo $valor == '' ? "0.00" : number_format($valor, 2, '.', ''); ?>">
    				<input type="hidden" name="txtIva" id="txtIva" value="0.00"/>
                    <input type="hidden" name="txtdescontado" id="txtdescontado" value="0.00"/>
    				<input type="hidden" name="descuento" id="descuento" value="<?php echo number_format($con[0]['descuentoglobal'], 2, '.', ''); ?>">
    				<input type="hidden" name="txtDescuento" id="txtDescuento" value="0.00"/>
    				<input type="hidden" name="txtTotal" id="txtTotal" value="0.00"/>
    				<input type="hidden" name="txtTotalCompra" id="txtTotalCompra" value="0.00"/>
    			</tr>
    		</table>
    	</div>

    	<div class="row">
    		<div class="col-md-6">
    			<span id="submit_guardar"><button type="submit" name="btn-submit" id="btn-submit" class="btn btn-warning btn-lg btn-block waves-effect waves-light" ><span class="fa fa-save"></span> Confirmar</button></span>
    		</div>
    		<div class="col-md-6">
    			<button type="button" class="btn btn-dark btn-lg btn-block" id="vaciar"><span class="fa fa-trash-o"></span> Limpiar</button>
    		</div>
    	</div>

    	<div class="row">
    		<div class="col-md-6">
    			<button type="button" onClick="MuestraFavoritos()" class="btn btn-success btn-lg btn-block waves-effect waves-light"><span class="fa fa-star"></span> Favoritos</button>
    		</div>
    		<div class="col-md-6">
    			<button type="button" class="btn btn-info btn-lg btn-block waves-effect waves-light" onClick="RecargaPedidos('<?php echo encrypt("MESAS"); ?>');" data-placement="left" title="Ver Pedidos" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalPedidos" data-backdrop="static" data-keyboard="false"><i class="fa fa-cutlery"></i> Pedidos</button>
    		</div>
    	</div>

		<?php  
		exit;
		} else {
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
####################### FUNCION VERIFICAR PEDIDOS EN MESA #######################

######################### FUNCION LISTAR NUMERO DE PEDIDOS EN MESA ########################
public function ListarPedidosMesas()
{
	self::SetNames();

	if(empty($_GET['codpedido']) || decrypt($_GET['codpedido']) == 0){

	$sql = "SELECT 
	ventas.idventa, 
	ventas.codpedido,
	ventas.codventa,
	ventas.codmesa, 
	ventas.codcliente,
	salas.nomsala, 
    mesas.codmesa, 
    mesas.nommesa,
    mesas.statusmesa, 
	detallepedidos.fechapedido, 
	clientes.documcliente,
	clientes.dnicliente, 
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	documentos.documento
	FROM mesas INNER JOIN ventas ON mesas.codmesa = ventas.codmesa 
    INNER JOIN detallepedidos ON detallepedidos.codpedido = ventas.codpedido
    INNER JOIN salas ON salas.codsala = mesas.codsala
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento 
	WHERE ventas.codmesa = ?
	AND ventas.statuspago = 1 
	GROUP BY ventas.codpedido 
	ORDER BY ventas.idventa ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codmesa"])));
	$num = $stmt->rowCount();

	} else {

	$sql = "SELECT 
	ventas.idventa, 
	ventas.codpedido,
	ventas.codventa,
	ventas.codmesa, 
	ventas.codcliente,
	salas.nomsala, 
    mesas.codmesa, 
    mesas.nommesa,
    mesas.statusmesa, 
	detallepedidos.fechapedido, 
	clientes.documcliente,
	clientes.dnicliente, 
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	documentos.documento
	FROM mesas INNER JOIN ventas ON mesas.codmesa = ventas.codmesa 
    INNER JOIN detallepedidos ON detallepedidos.codpedido = ventas.codpedido
    INNER JOIN salas ON salas.codsala = mesas.codsala
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento 
	WHERE ventas.codmesa = '".limpiar(decrypt($_GET["codmesa"]))."'
	AND ventas.codpedido = '".limpiar(decrypt($_GET["codpedido"]))."'
	AND ventas.statuspago = 1 
	GROUP BY ventas.codpedido 
	ORDER BY ventas.idventa ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();

	}

	if($num==0)
	{

    $mesa = new Login();
    $mesa = $mesa->MesasPorId();
    ?>

    <div class="row">
        <div class="col-md-10">
        <h4 class="text-danger"><strong><?php echo $mesa[0]['nomsala']; ?></strong></h4> 
        <h4 class="text-danger"><strong><?php echo $mesa[0]['nommesa']; ?></strong></h4>
        </div>
    </div>

	<?php  
	exit;
	} else {
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################### FUNCION LISTAR NUMERO DE PEDIDOS EN MESA ########################

############################ FUNCION REGISTRAR VENTAS ##############################
public function NuevoPedido()
	{
	self::SetNames();
	if(empty($_SESSION["CarritoVenta"]))
	{
		echo "1";
		exit;
	}

	############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA ############
	$v = $_SESSION["CarritoVenta"];
	for($i=0;$i<count($v);$i++){

		if(limpiar($v[$i]['tipo']) == 1){

		    $sql = "SELECT existencia FROM productos WHERE codproducto = '".$v[$i]['txtCodigo']."'";
		    foreach ($this->dbh->query($sql) as $row)
		    {
			$this->p[] = $row;
		    }
		
		    $existenciadb = $row['existencia'];
		    $cantidad = $v[$i]['cantidad'];

	        if ($cantidad > $existenciadb) 
	        { 
		       echo "2";
		       exit;
	        }

	    } else { 

		    $sql = "SELECT existencia FROM combos WHERE codcombo = '".$v[$i]['txtCodigo']."'";
		    foreach ($this->dbh->query($sql) as $row)
		    {
			$this->p[] = $row;
		    }
		
		    $existenciadb = $row['existencia'];
		    $cantidad = $v[$i]['cantidad'];

	        if ($cantidad > $existenciadb) 
	        { 
		       echo "2";
		       exit;
	        }
	    }
	}
	############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA ############

	##################### AGREGAMOS EL NUMERO DE PEDIDO A LA VENTA #######################
	$sql = "SELECT 
	codpedido,
	codventa 
	FROM ventas 
	ORDER BY idventa 
	DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$pedido=$row["codpedido"];
		$venta=$row["codventa"];

	}
	if(empty($pedido) or empty($venta))
	{
		$codpedido = "P1";
		$codventa = "1";

	} else {
		
		$resto = substr($pedido, 0, 1);
		$coun = strlen($resto);
		$num = substr($pedido, $coun);
		$codigop = $num + 1;
		$codigov = $venta + 1;
		$codpedido = "P".$codigop;
		$codventa = $codigov;
	}
	##################### AGREGAMOS EL NUMERO DE PEDIDO A LA VENTA #######################

    $fecha = date("Y-m-d H:i:s");

	$query = "INSERT INTO ventas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codpedido);
	$stmt->bindParam(2, $codventa);
	$stmt->bindParam(3, $codmesa);
	$stmt->bindParam(4, $tipodocumento);
	$stmt->bindParam(5, $codcaja);
	$stmt->bindParam(6, $codfactura);
	$stmt->bindParam(7, $codserie);
	$stmt->bindParam(8, $codautorizacion);
	$stmt->bindParam(9, $codcliente);
	$stmt->bindParam(10, $subtotalivasi);
	$stmt->bindParam(11, $subtotalivano);
	$stmt->bindParam(12, $iva);
	$stmt->bindParam(13, $totaliva);
	$stmt->bindParam(14, $descontado);
	$stmt->bindParam(15, $descuento);
	$stmt->bindParam(16, $totaldescuento);
	$stmt->bindParam(17, $totalpago);
	$stmt->bindParam(18, $totalpago2);
	$stmt->bindParam(19, $creditopagado);
	$stmt->bindParam(20, $montodelivery);
	$stmt->bindParam(21, $tipopago);
	$stmt->bindParam(22, $formapago);
	$stmt->bindParam(23, $montopagado);
	$stmt->bindParam(24, $formapago2);
	$stmt->bindParam(25, $montopagado2);
	$stmt->bindParam(26, $formapropina);
	$stmt->bindParam(27, $montopropina);
	$stmt->bindParam(28, $montodevuelto);
	$stmt->bindParam(29, $fechavencecredito);
	$stmt->bindParam(30, $fechapagado);
	$stmt->bindParam(31, $statusventa);
	$stmt->bindParam(32, $statuspago);
	$stmt->bindParam(33, $fechaventa);
	$stmt->bindParam(34, $delivery);
	$stmt->bindParam(35, $repartidor);
	$stmt->bindParam(36, $entregado);
	$stmt->bindParam(37, $observaciones);
	$stmt->bindParam(38, $codigo);
	$stmt->bindParam(39, $bandera);
	$stmt->bindParam(40, $docelectronico);
    
	$codmesa = limpiar($_POST["codmesa"]);
	$tipodocumento = limpiar("0");
	$codcaja = limpiar("0");
	$codfactura = limpiar("0");
	$codserie = limpiar("0");
	$codautorizacion = limpiar("0");
	$codcliente = limpiar($_POST["codcliente"]);
	$subtotalivasi = limpiar($_POST["txtsubtotal"]);
	$subtotalivano = limpiar($_POST["txtsubtotal2"]);
	$iva = limpiar($_POST["iva"]);
	$totaliva = limpiar($_POST["txtIva"]);
	$descontado = limpiar($_POST["txtdescontado"]);
	$descuento = limpiar($_POST["descuento"]);
	$totaldescuento = limpiar($_POST["txtDescuento"]);
	$totalpago = limpiar($_POST["txtTotal"]);
	$totalpago2 = limpiar($_POST["txtTotalCompra"]);
    $creditopagado = limpiar("0.00");
    $montodelivery = limpiar("0.00");
    $tipopago = limpiar("0");
    $formapago = limpiar("0");
    $montopagado = limpiar("0.00");
    $formapago2 = limpiar("0");
    $montopagado2 = limpiar("0.00");
    $formapropina = limpiar("0");
	$montopropina = limpiar("0.00");
    $montodevuelto = limpiar("0.00");
    $fechavencecredito = limpiar("0000-00-00");
    $fechapagado = limpiar("0000-00-00");
    $statusventa = limpiar("0");
    $statuspago = limpiar("1");
    $fechaventa = limpiar($fecha);
	$delivery = limpiar("0");
	$repartidor = limpiar("0");
	$entregado = limpiar("0");
	$observaciones = limpiar("0");
	$codigo = limpiar($_SESSION["codigo"]);
	$bandera = limpiar("0");
	$docelectronico = limpiar("0");
	$stmt->execute();

	#################### ACTUALIZAMOS EL STATUS DE MESA ####################
	$sql = "UPDATE mesas set "
	." statusmesa = ? "
	." WHERE "
	." codmesa = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $statusmesa);
	$stmt->bindParam(2, $codmesa);

	$statusmesa = limpiar('1');
	$codmesa = limpiar($_POST["codmesa"]);
	$stmt->execute();
   #################### ACTUALIZAMOS EL STATUS DE MESA ####################

	$this->dbh->beginTransaction();
	$detalle = $_SESSION["CarritoVenta"];
	for($i=0;$i<count($detalle);$i++){

	$query = "INSERT INTO detalleventas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codpedido);
	$stmt->bindParam(2, $codventa);
	$stmt->bindParam(3, $idproducto);
    $stmt->bindParam(4, $codproducto);
    $stmt->bindParam(5, $producto);
    $stmt->bindParam(6, $codcategoria);
	$stmt->bindParam(7, $cantidad);
	$stmt->bindParam(8, $preciocompra);
	$stmt->bindParam(9, $precioventa);
	$stmt->bindParam(10, $ivaproducto);
	$stmt->bindParam(11, $descproducto);
	$stmt->bindParam(12, $valortotal);
	$stmt->bindParam(13, $totaldescuentov);
	$stmt->bindParam(14, $valorneto);
	$stmt->bindParam(15, $valorneto2);
	$stmt->bindParam(16, $detallesobservaciones);
	$stmt->bindParam(17, $tipo);
	
	$idproducto = limpiar($detalle[$i]['id']);
	$codproducto = limpiar($detalle[$i]['txtCodigo']);
	$producto = limpiar($detalle[$i]['producto']);
	$codcategoria = limpiar($detalle[$i]['codcategoria']);
	$cantidad = number_format($detalle[$i]['cantidad'], 2, '.', '');
	$preciocompra = limpiar($detalle[$i]['precio']);
	$precioventa = limpiar($detalle[$i]['precio2']);
	$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
	$descproducto = limpiar($detalle[$i]['descproducto']);
	$descuento = $detalle[$i]['descproducto']/100;
	$valortotal = number_format($detalle[$i]['precio2']*$detalle[$i]['cantidad'], 2, '.', '');
	$totaldescuentov = number_format($valortotal*$descuento, 2, '.', '');
    $valorneto = number_format($valortotal-$totaldescuentov, 2, '.', '');
	$valorneto2 = number_format($detalle[$i]['precio']*$detalle[$i]['cantidad'], 2, '.', '');
    $detallesobservaciones = limpiar("");
	$tipo = limpiar($detalle[$i]['tipo']);
	$stmt->execute();


	$query = "INSERT INTO detallepedidos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codpedido);
	$stmt->bindParam(2, $pedido);
	$stmt->bindParam(3, $codventa);
	$stmt->bindParam(4, $idproducto);
	$stmt->bindParam(5, $codproducto);
	$stmt->bindParam(6, $producto);
	$stmt->bindParam(7, $codcategoria);
	$stmt->bindParam(8, $cantidad);
	$stmt->bindParam(9, $precioventa);
	$stmt->bindParam(10, $ivaproducto);
	$stmt->bindParam(11, $descproducto);
	$stmt->bindParam(12, $valortotal);
	$stmt->bindParam(13, $totaldescuentov);
	$stmt->bindParam(14, $valorneto);
	$stmt->bindParam(15, $observacionespedido);
	$stmt->bindParam(16, $cocinero);
	$stmt->bindParam(17, $fechapedido);
	$stmt->bindParam(18, $fechaentrega);
	$stmt->bindParam(19, $tipo);

	$pedido = limpiar("1");
	$idproducto = limpiar($detalle[$i]['id']);
	$codproducto = limpiar($detalle[$i]['txtCodigo']);
	$producto = limpiar($detalle[$i]['producto']);
	$codcategoria = limpiar($detalle[$i]['codcategoria']);
	$cantidad = number_format($detalle[$i]['cantidad'], 2, '.', '');
	$precioventa = limpiar($detalle[$i]['precio2']);
	$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
	$descproducto = limpiar($detalle[$i]['descproducto']);
	$descuento = $detalle[$i]['descproducto']/100;
	$valortotal = number_format($detalle[$i]['precio2']*$detalle[$i]['cantidad'], 2, '.', '');
	$totaldescuentov = number_format($valortotal*$descuento, 2, '.', '');
    $valorneto = number_format($valortotal-$totaldescuentov, 2, '.', '');
    $observacionespedido = limpiar($detalle[$i]['observacion'] == ", " ? "" : $detalle[$i]['observacion']);
	$cocinero = limpiar('1');
	$fechapedido = limpiar($fecha);
	$fechaentrega = limpiar("0000-00-00");
	$tipo = limpiar($detalle[$i]['tipo']);
	$stmt->execute();

    if(limpiar($detalle[$i]['tipo']) == 1){

    ############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################		

	############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################
	$sql = "SELECT 
	existencia, 
	controlstockp 
	FROM productos 
	WHERE codproducto = '".limpiar($detalle[$i]['txtCodigo'])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$existenciaproductobd = $row['existencia'];
	$controlproductobd = $row['controlstockp'];
	############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################

	if($controlproductobd == 1){

	    ##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
		$sql = " UPDATE productos set "
			  ." existencia = ? "
			  ." WHERE "
			  ." codproducto = '".limpiar($detalle[$i]['txtCodigo'])."';
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$cantventa = number_format($detalle[$i]['cantidad'], 2, '.', '');
		$existencia = number_format($existenciaproductobd-$cantventa, 2, '.', '');
		$stmt->execute();
	    ##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################

		############## REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
        $query = "INSERT INTO kardex_productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codventa);
		$stmt->bindParam(2, $codcliente);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);		

		$codcliente = limpiar($_POST["codcliente"]);
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$movimiento = limpiar("SALIDAS");
		$entradas = limpiar("0");
		$salidas= number_format($detalle[$i]['cantidad'], 2, '.', '');
		$devolucion = limpiar("0");
		$stockactual = number_format($existenciaproductobd-$detalle[$i]['cantidad'], 2, '.', '');
		$precio = limpiar($detalle[$i]['precio2']);
		$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
		$descproducto = limpiar($detalle[$i]['descproducto']);
		$documento = limpiar("PEDIDO EN MESA");
		$fechakardex = limpiar(date("Y-m-d"));
		$stmt->execute();
		############## REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
	}

    ############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################		

   } else {

   	############################### PROCESO PARA VERIFICAR LOS COMBOS ######################################		

		############## VERIFICO LA EXISTENCIA DEL COMBO EN ALMACEN #################
		$sql = "SELECT existencia FROM combos WHERE codcombo = '".limpiar($detalle[$i]['txtCodigo'])."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$existenciacombobd = $row['existencia'];
		############## VERIFICO LA EXISTENCIA DEL COMBO EN ALMACEN #################

	    ##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
		$sql = " UPDATE combos set "
			  ." existencia = ? "
			  ." where "
			  ." codcombo = '".limpiar($detalle[$i]['txtCodigo'])."';
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$cantventa = number_format($detalle[$i]['cantidad'], 2, '.', '');
		$existencia = number_format($existenciacombobd-$cantventa, 2, '.', '');
		$stmt->execute();
		##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################

		############## REGISTRAMOS LOS DATOS DE COMBOS EN KARDEX ###################
	    $query = "INSERT INTO kardex_combos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codventa);
		$stmt->bindParam(2, $codcliente);
		$stmt->bindParam(3, $codcombo);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivacombo);
		$stmt->bindParam(10, $desccombo);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);		

		$codcliente = limpiar($_POST["codcliente"]);
		$codcombo = limpiar($detalle[$i]['txtCodigo']);
		$movimiento = limpiar("SALIDAS");
		$entradas = limpiar("0");
		$salidas= number_format($detalle[$i]['cantidad'], 2, '.', '');
		$devolucion = limpiar("0");
		$stockactual = number_format($existenciacombobd-$detalle[$i]['cantidad'], 2, '.', '');
		$precio = limpiar($detalle[$i]['precio2']);
		$ivacombo = limpiar($detalle[$i]['ivaproducto']);
		$desccombo = limpiar($detalle[$i]['descproducto']);
		$documento = limpiar("PEDIDO EN MESA");
		$fechakardex = limpiar(date("Y-m-d"));
		$stmt->execute();
		############## REGISTRAMOS LOS DATOS DE COMBOS EN KARDEX ###################

   ############################### PROCESO PARA VERIFICAR LOS COMBOS ######################################

   }



    ############################### PROCESO PARA VERIFICAR LOS INGREDIENTES ######################################	

	    ############## VERIFICO SSI EL PRODUCTO TIENE INGREDIENTES RELACIONADOS #################
	    $sql = "SELECT * FROM productosxingredientes WHERE codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(limpiar($detalle[$i]['txtCodigo'])));
		$num = $stmt->rowCount();
        if($num>0) {  

        	$sql = "SELECT * FROM productosxingredientes LEFT JOIN ingredientes ON productosxingredientes.codingrediente = ingredientes.codingrediente WHERE productosxingredientes.codproducto IN ('".$detalle[$i]['txtCodigo']."')";
        	foreach ($this->dbh->query($sql) as $row)
		    { 
			   $this->p[] = $row;

			   //$codproducto = $row['codproducto'];
			   $cantracionbd = $row['cantracion'];
			   $codingredientebd = $row['codingrediente'];
			   $cantingredientebd = $row['cantingrediente'];
			   $precioventaingredientebd = $row['precioventa'];
			   $ivaingredientebd = $row['ivaingrediente'];
			   $descingredientebd = $row['descingrediente'];
		       $controlingredientebd = $row['controlstocki'];

		    if($controlingredientebd == 1){

			   ############## ACTUALIZO LOS DATOS DEL INGREDIENTE #################
			   $update = "UPDATE ingredientes set "
			   ." cantingrediente = ? "
			   ." WHERE "
			   ." codingrediente = ?;
			   ";
			   $stmt = $this->dbh->prepare($update);
			   $stmt->bindParam(1, $cantidadracion);
			   $stmt->bindParam(2, $codingredientebd);

			   $racion = number_format($cantracionbd*$detalle[$i]['cantidad'], 2, '.', '');
			   $cantidadracion = number_format($cantingredientebd-$racion, 2, '.', '');
			   $stmt->execute();
			   ############## ACTUALIZO LOS DATOS DEL INGREDIENTE #################

			   ############## REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
			   $query = "INSERT INTO kardex_ingredientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
			   $stmt = $this->dbh->prepare($query);
			   $stmt->bindParam(1, $codventa);
			   $stmt->bindParam(2, $codcliente);
			   $stmt->bindParam(3, $codingrediente);
			   $stmt->bindParam(4, $movimiento);
			   $stmt->bindParam(5, $entradas);
			   $stmt->bindParam(6, $salidas);
			   $stmt->bindParam(7, $devolucion);
			   $stmt->bindParam(8, $stockactual);
			   $stmt->bindParam(9, $ivaingrediente);
			   $stmt->bindParam(10, $descingrediente);
			   $stmt->bindParam(11, $precio);
			   $stmt->bindParam(12, $documento);
			   $stmt->bindParam(13, $fechakardex);		

			   $codcliente = limpiar($_POST["codcliente"]);
			   $codingrediente = limpiar($codingredientebd);
			   $movimiento = limpiar("SALIDAS");
			   $entradas = limpiar("0");
			   $salidas= limpiar($racion);
			   $devolucion = limpiar("0");
			   $stockactual = number_format($cantingredientebd-$racion, 2, '.', '');
			   $precio = limpiar($precioventaingredientebd);
			   $ivaingrediente = limpiar($ivaingredientebd);
			   $descingrediente = limpiar($descingredientebd);
			   $documento = limpiar("PEDIDO EN MESA");
			   $fechakardex = limpiar(date("Y-m-d"));
			   $stmt->execute();
			}
		}
	}//fin de consulta de ingredientes de productos	

############################### PROCESO PARA VERIFICAR LOS INGREDIENTES ######################################	

      }
		
	####################### DESTRUYO LA VARIABLE DE SESSION #####################
	unset($_SESSION["CarritoVenta"]);
    $this->dbh->commit();

    echo "<span class='fa fa-check-square-o'></span> EL PEDIDO DE LA ".limpiar($_POST["nombremesa"]).", FUE REGISTRADO EXITOSAMENTE <a href='reportepdf?codpedido=".encrypt($codpedido)."&pedido=".encrypt($pedido)."&codventa=".encrypt($codventa)."&tipo=".encrypt("COMANDA")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR COMANDA</strong></font color></a></div>";

    echo "<script>window.open('reportepdf?codpedido=".encrypt($codpedido)."&pedido=".encrypt($pedido)."&codventa=".encrypt($codventa)."&tipo=".encrypt("COMANDA")."', '_blank');</script>";
	exit; 
}
######################### FUNCION REGISTRAR VENTAS ############################

############################ FUNCION AGREGAR PEDIDOS A VENTAS ##############################
public function AgregaPedido()
	{
	self::SetNames();
	if(empty($_SESSION["CarritoVenta"]))
	{
		echo "1";
		exit;
	}

	############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA ############
	$v = $_SESSION["CarritoVenta"];
	for($i=0;$i<count($v);$i++){

		if(limpiar($v[$i]['tipo']) == 1){

		    $sql = "SELECT existencia FROM productos WHERE codproducto = '".$v[$i]['txtCodigo']."'";
		    foreach ($this->dbh->query($sql) as $row)
		    {
			$this->p[] = $row;
		    }
		
		    $existenciadb = $row['existencia'];
		    $cantidad = $v[$i]['cantidad'];

	        if ($cantidad > $existenciadb) 
	        { 
		       echo "2";
		       exit;
	        }

	    } else { 

		    $sql = "SELECT existencia FROM combos WHERE codcombo = '".$v[$i]['txtCodigo']."'";
		    foreach ($this->dbh->query($sql) as $row)
		    {
			$this->p[] = $row;
		    }
		
		    $existenciadb = $row['existencia'];
		    $cantidad = $v[$i]['cantidad'];

	        if ($cantidad > $existenciadb) 
	        { 
		       echo "2";
		       exit;
	        }
	    }
	}
	############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA ############

	##################### AGREGAMOS EL NUMERO DE PEDIDO A LA VENTA #######################
	$sql = "SELECT 
	pedido 
	FROM detallepedidos 
	WHERE codpedido = '".limpiar(decrypt($_POST['codpedido']))."' 
	AND codventa = '".limpiar(decrypt($_POST['codventa']))."' 
	ORDER BY coddetallepedido DESC LIMIT 1";
    foreach ($this->dbh->query($sql) as $row){

    $nuevopedido=$row["pedido"];

    }
	
    $dig = $nuevopedido + 1;
    $pedido = $dig;
	##################### AGREGAMOS EL NUMERO DE PEDIDO A LA VENTA #######################

	$this->dbh->beginTransaction();
	$detalle = $_SESSION["CarritoVenta"];
	for($i=0;$i<count($detalle);$i++){

	############ REVISAMOS QUE EL PRODUCTO NO ESTE EN LA BD ###################
    $sql = "SELECT 
    codpedido, 
    codventa, 
    codproducto 
    FROM detalleventas 
    WHERE codpedido = '".limpiar(decrypt($_POST['codpedido']))."' 
    AND codventa = '".limpiar(decrypt($_POST['codventa']))."' 
    AND codproducto = '".limpiar($detalle[$i]['txtCodigo'])."'";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num == 0)
	{

	$query = "INSERT INTO detalleventas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codpedido);
	$stmt->bindParam(2, $codventa);
	$stmt->bindParam(3, $idproducto);
    $stmt->bindParam(4, $codproducto);
    $stmt->bindParam(5, $producto);
    $stmt->bindParam(6, $codcategoria);
	$stmt->bindParam(7, $cantidad);
	$stmt->bindParam(8, $preciocompra);
	$stmt->bindParam(9, $precioventa);
	$stmt->bindParam(10, $ivaproducto);
	$stmt->bindParam(11, $descproducto);
	$stmt->bindParam(12, $valortotal);
	$stmt->bindParam(13, $totaldescuentov);
	$stmt->bindParam(14, $valorneto);
	$stmt->bindParam(15, $valorneto2);
	$stmt->bindParam(16, $detallesobservaciones);
	$stmt->bindParam(17, $tipo);
	
	$codpedido = limpiar(decrypt($_POST["codpedido"]));
	$codventa = limpiar(decrypt($_POST["codventa"]));
	$idproducto = limpiar($detalle[$i]['id']);
	$codproducto = limpiar($detalle[$i]['txtCodigo']);
	$producto = limpiar($detalle[$i]['producto']);
	$codcategoria = limpiar($detalle[$i]['codcategoria']);
	$cantidad = number_format($detalle[$i]['cantidad'], 2, '.', '');
	$preciocompra = limpiar($detalle[$i]['precio']);
	$precioventa = limpiar($detalle[$i]['precio2']);
	$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
	$descproducto = limpiar($detalle[$i]['descproducto']);
	$descuento = $detalle[$i]['descproducto']/100;
	$valortotal = number_format($detalle[$i]['precio2']*$detalle[$i]['cantidad'], 2, '.', '');
	$totaldescuentov = number_format($valortotal*$descuento, 2, '.', '');
    $valorneto = number_format($valortotal-$totaldescuentov, 2, '.', '');
	$valorneto2 = number_format($detalle[$i]['precio']*$detalle[$i]['cantidad'], 2, '.', '');
    $detallesobservaciones = limpiar("");
	$tipo = limpiar($detalle[$i]['tipo']);
	$stmt->execute();

	$query = "INSERT INTO detallepedidos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codpedido);
	$stmt->bindParam(2, $pedido);
	$stmt->bindParam(3, $codventa);
	$stmt->bindParam(4, $idproducto);
	$stmt->bindParam(5, $codproducto);
	$stmt->bindParam(6, $producto);
	$stmt->bindParam(7, $codcategoria);
	$stmt->bindParam(8, $cantidad);
	$stmt->bindParam(9, $precioventa);
	$stmt->bindParam(10, $ivaproducto);
	$stmt->bindParam(11, $descproducto);
	$stmt->bindParam(12, $valortotal);
	$stmt->bindParam(13, $totaldescuentov);
	$stmt->bindParam(14, $valorneto);
	$stmt->bindParam(15, $observacionespedido);
	$stmt->bindParam(16, $cocinero);
	$stmt->bindParam(17, $fechapedido);
	$stmt->bindParam(18, $fechaentrega);
	$stmt->bindParam(19, $tipo);

	$codpedido = limpiar(decrypt($_POST["codpedido"]));
	$codventa = limpiar(decrypt($_POST["codventa"]));
	$idproducto = limpiar($detalle[$i]['id']);
	$codproducto = limpiar($detalle[$i]['txtCodigo']);
	$producto = limpiar($detalle[$i]['producto']);
	$codcategoria = limpiar($detalle[$i]['codcategoria']);
	$cantidad = number_format($detalle[$i]['cantidad'], 2, '.', '');
	$precioventa = limpiar($detalle[$i]['precio2']);
	$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
	$descproducto = limpiar($detalle[$i]['descproducto']);
	$descuento = $detalle[$i]['descproducto']/100;
	$valortotal = number_format($detalle[$i]['precio2']*$detalle[$i]['cantidad'], 2, '.', '');
	$totaldescuentov = number_format($valortotal*$descuento, 2, '.', '');
    $valorneto = number_format($valortotal-$totaldescuentov, 2, '.', '');
    $observacionespedido = limpiar($detalle[$i]['observacion'] == ", " ? "" : $detalle[$i]['observacion']);
	$cocinero = limpiar('1');
	$fechapedido = limpiar(date("Y-m-d H:i:s"));
	$fechaentrega = limpiar("0000-00-00");
	$tipo = limpiar($detalle[$i]['tipo']);
	$stmt->execute();

	if(limpiar($detalle[$i]['tipo']) == 1){

    ############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################		

	############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################
	$sql = "SELECT 
	existencia, 
	controlstockp 
	FROM productos 
	WHERE codproducto = '".limpiar($detalle[$i]['txtCodigo'])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$existenciaproductobd = $row['existencia'];
	$controlproductobd = $row['controlstockp'];
	############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################

	if($controlproductobd == 1){

		##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
		$sql = " UPDATE productos set "
			  ." existencia = ? "
			  ." WHERE "
			  ." codproducto = '".limpiar($detalle[$i]['txtCodigo'])."';
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$cantventa = number_format($detalle[$i]['cantidad'], 2, '.', '');
		$existencia = number_format($existenciaproductobd-$cantventa, 2, '.', '');
		$stmt->execute();
		##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################

		############## REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
        $query = "INSERT INTO kardex_productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codventa);
		$stmt->bindParam(2, $codcliente);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);		

		$codventa = limpiar(decrypt($_POST["codventa"]));
		$codcliente = limpiar($_POST["codcliente"]);
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$movimiento = limpiar("SALIDAS");
		$entradas = limpiar("0");
		$salidas= number_format($detalle[$i]['cantidad'], 2, '.', '');
		$devolucion = limpiar("0");
		$stockactual = number_format($existenciaproductobd-$detalle[$i]['cantidad'], 2, '.', '');
		$precio = limpiar($detalle[$i]['precio2']);
		$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
		$descproducto = limpiar($detalle[$i]['descproducto']);
		$documento = limpiar("PEDIDO EN MESA");
		$fechakardex = limpiar(date("Y-m-d"));
		$stmt->execute();
		############## REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
	}
    ############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################	

    } else {

    ############################### PROCESO PARA VERIFICAR LOS COMBOS ######################################		

		############## VERIFICO LA EXISTENCIA DEL COMBOS EN ALMACEN #################
		$sql = "SELECT existencia FROM combos WHERE codcombo = '".limpiar($detalle[$i]['txtCodigo'])."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$existenciacombobd = ($row['existencia']== "" ? "0" : $row['existencia']);
		############## VERIFICO LA EXISTENCIA DEL COMBOS EN ALMACEN #################

		##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
		$sql = " UPDATE combos set "
			  ." existencia = ? "
			  ." where "
			  ." codcombo = '".limpiar($detalle[$i]['txtCodigo'])."';
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$cantventa = number_format($detalle[$i]['cantidad'], 2, '.', '');
		$existencia = number_format($existenciacombobd-$cantventa, 2, '.', '');
		$stmt->execute();
		##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################

		############## REGISTRAMOS LOS DATOS DE COMBOS EN KARDEX ###################
	    $query = "INSERT INTO kardex_combos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codventa);
		$stmt->bindParam(2, $codcliente);
		$stmt->bindParam(3, $codcombo);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivacombo);
		$stmt->bindParam(10, $desccombo);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);		

		$codventa = limpiar($_POST["codventa"]);
		$codcliente = limpiar($_POST["codcliente"]);
		$codcombo = limpiar($detalle[$i]['txtCodigo']);
		$movimiento = limpiar("SALIDAS");
		$entradas = limpiar("0");
		$salidas= number_format($detalle[$i]['cantidad'], 2, '.', '');
		$devolucion = limpiar("0");
		$stockactual = number_format($existenciaproductobd-$detalle[$i]['cantidad'], 2, '.', '');
		$precio = limpiar($detalle[$i]['precio2']);
		$ivacombo = limpiar($detalle[$i]['ivaproducto']);
		$desccombo = limpiar($detalle[$i]['descproducto']);
		$documento = limpiar("PEDIDO EN MESA");
		$fechakardex = limpiar(date("Y-m-d"));
		$stmt->execute();
		############## REGISTRAMOS LOS DATOS DE COMBOS EN KARDEX ###################

    ############################### PROCESO PARA VERIFICAR LOS COMBOS ######################################

    }	



    ############################### PROCESO PARA VERIFICAR LOS INGREDIENTES ######################################	

	    ############## VERIFICO SI EL PRODUCTO TIENE INGREDIENTES RELACIONADOS #################
	    $sql = "SELECT * FROM productosxingredientes WHERE codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(limpiar($detalle[$i]['txtCodigo'])));
		$num = $stmt->rowCount();
        if($num>0) {  

        	$sql = "SELECT * FROM productosxingredientes LEFT JOIN ingredientes ON productosxingredientes.codingrediente = ingredientes.codingrediente WHERE productosxingredientes.codproducto IN ('".$detalle[$i]['txtCodigo']."')";
        	foreach ($this->dbh->query($sql) as $row)
		    { 
			   $this->p[] = $row;

			   $cantracionbd = $row['cantracion'];
			   $codingredientebd = $row['codingrediente'];
			   $cantingredientebd = $row['cantingrediente'];
			   $precioventaingredientebd = $row['precioventa'];
			   $ivaingredientebd = $row['ivaingrediente'];
			   $descingredientebd = $row['descingrediente'];
		       $controlingredientebd = $row['controlstocki'];

		    if($controlingredientebd == 1){

			   ############## ACTUALIZO LOS DATOS DEL INGREDIENTE #################
			   $update = "UPDATE ingredientes set "
			   ." cantingrediente = ? "
			   ." WHERE "
			   ." codingrediente = ?;
			   ";
			   $stmt = $this->dbh->prepare($update);
			   $stmt->bindParam(1, $cantidadracion);
			   $stmt->bindParam(2, $codingredientebd);

			   $racion = number_format($cantracionbd*$detalle[$i]['cantidad'], 2, '.', '');
			   $cantidadracion = number_format($cantingredientebd-$racion, 2, '.', '');
			   $stmt->execute();
			   ############## ACTUALIZO LOS DATOS DEL INGREDIENTE #################

			   ############## REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
			   $query = "INSERT INTO kardex_ingredientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
			   $stmt = $this->dbh->prepare($query);
			   $stmt->bindParam(1, $codventa);
			   $stmt->bindParam(2, $codcliente);
			   $stmt->bindParam(3, $codingrediente);
			   $stmt->bindParam(4, $movimiento);
			   $stmt->bindParam(5, $entradas);
			   $stmt->bindParam(6, $salidas);
			   $stmt->bindParam(7, $devolucion);
			   $stmt->bindParam(8, $stockactual);
			   $stmt->bindParam(9, $ivaingrediente);
			   $stmt->bindParam(10, $descingrediente);
			   $stmt->bindParam(11, $precio);
			   $stmt->bindParam(12, $documento);
			   $stmt->bindParam(13, $fechakardex);		

			   $codventa = limpiar(decrypt($_POST["codventa"]));
			   $codcliente = limpiar($_POST["codcliente"]);
			   $codingrediente = limpiar($codingredientebd);
			   $movimiento = limpiar("SALIDAS");
			   $entradas = limpiar("0");
			   $salidas= limpiar($racion);
			   $devolucion = limpiar("0");
			   $stockactual = number_format($cantingredientebd-$racion, 2, '.', '');
			   $precio = limpiar($precioventaingredientebd);
			   $ivaingrediente = limpiar($ivaingredientebd);
			   $descingrediente = limpiar($descingredientebd);
			   $documento = limpiar("PEDIDO EN MESA");
			   $fechakardex = limpiar(date("Y-m-d"));
			   $stmt->execute();
			}
		}
	}//fin de consulta de ingredientes de productos		

    ############################### PROCESO PARA VERIFICAR LOS INGREDIENTES ######################################	

		} else {

		##################### VERIFICO LA CANTIDAD YA REGISTRADA DEL PRODUCTO VENDIDO ####################
		$sql = "SELECT cantventa 
		FROM detalleventas 
		WHERE codpedido = '".limpiar(decrypt($_POST['codpedido']))."'
		AND codproducto = '".limpiar($detalle[$i]['txtCodigo'])."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$cantidad = $row['cantventa'];
		##################### VERIFICO LA CANTIDAD YA REGISTRADA DEL PRODUCTO VENDIDO ####################

	  	$query = "UPDATE detalleventas set"
		." cantventa = ?, "
		." descproducto = ?, "
		." valortotal = ?, "
		." totaldescuentov = ?, "
		." valorneto = ?, "
		." valorneto2 = ? "
		." WHERE "
		." codpedido = ? AND codventa = ? AND codproducto = ?;
		";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $cantventa);
		$stmt->bindParam(2, $descproducto);
		$stmt->bindParam(3, $valortotal);
		$stmt->bindParam(4, $totaldescuentov);
		$stmt->bindParam(5, $valorneto);
		$stmt->bindParam(6, $valorneto2);
		$stmt->bindParam(7, $codpedido);
		$stmt->bindParam(8, $codventa);
		$stmt->bindParam(9, $codproducto);

		$cantventa = number_format($detalle[$i]['cantidad']+$cantidad, 2, '.', '');
		$preciocompra = limpiar($detalle[$i]['precio']);
		$precioventa = limpiar($detalle[$i]['precio2']);
		$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
		$descproducto = limpiar($detalle[$i]['descproducto']);
		$descuento = $detalle[$i]['descproducto']/100;
		$valortotal = number_format($detalle[$i]['precio2'] * $cantventa, 2, '.', '');
		$totaldescuentov = number_format($valortotal * $descuento, 2, '.', '');
		$valorneto = number_format($valortotal - $totaldescuentov, 2, '.', '');
		$valorneto2 = number_format($detalle[$i]['precio'] * $cantventa, 2, '.', '');
		$codpedido = limpiar(decrypt($_POST["codpedido"]));
		$codventa = limpiar(decrypt($_POST["codventa"]));
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$stmt->execute();

		$query = "INSERT INTO detallepedidos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codpedido);
		$stmt->bindParam(2, $pedido);
		$stmt->bindParam(3, $codventa);
	    $stmt->bindParam(4, $idproducto);
		$stmt->bindParam(5, $codproducto);
		$stmt->bindParam(6, $producto);
		$stmt->bindParam(7, $codcategoria);
		$stmt->bindParam(8, $cantidad);
		$stmt->bindParam(9, $precioventa);
		$stmt->bindParam(10, $ivaproducto);
		$stmt->bindParam(11, $descproducto);
		$stmt->bindParam(12, $valortotal);
		$stmt->bindParam(13, $totaldescuentov);
		$stmt->bindParam(14, $valorneto);
		$stmt->bindParam(15, $observacionespedido);
		$stmt->bindParam(16, $cocinero);
		$stmt->bindParam(17, $fechapedido);
		$stmt->bindParam(18, $fechaentrega);
	    $stmt->bindParam(19, $tipo);

		$codpedido = limpiar(decrypt($_POST["codpedido"]));
		$codventa = limpiar(decrypt($_POST["codventa"]));
		$idproducto = limpiar($detalle[$i]['id']);
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$producto = limpiar($detalle[$i]['producto']);
		$codcategoria = limpiar($detalle[$i]['codcategoria']);
		$cantidad = number_format($detalle[$i]['cantidad'], 2, '.', '');
		$precioventa = limpiar($detalle[$i]['precio2']);
		$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
		$descproducto = limpiar($detalle[$i]['descproducto']);
		$descuento = $detalle[$i]['descproducto']/100;
		$valortotal = number_format($detalle[$i]['precio2']*$detalle[$i]['cantidad'], 2, '.', '');
		$totaldescuentov = number_format($valortotal*$descuento, 2, '.', '');
	    $valorneto = number_format($valortotal-$totaldescuentov, 2, '.', '');
	    $observacionespedido = limpiar($detalle[$i]['observacion'] == ", " ? "" : $detalle[$i]['observacion']);
		$cocinero = limpiar('1');
		$fechapedido = limpiar(date("Y-m-d H:i:s"));
		$fechaentrega = limpiar("0000-00-00");
	    $tipo = limpiar($detalle[$i]['tipo']);
		$stmt->execute();

	if(limpiar($detalle[$i]['tipo']) == 1){

     ############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################

		############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################
		$sql = "SELECT 
		existencia, 
		controlstockp 
		FROM productos 
		WHERE codproducto = '".limpiar($detalle[$i]['txtCodigo'])."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$existenciaproductobd = $row['existencia'];
		$controlproductobd = $row['controlstockp'];
		############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################		

    if($controlproductobd == 1){

		##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
		$sql = " UPDATE productos set "
			  ." existencia = ? "
			  ." WHERE "
			  ." codproducto = '".limpiar($detalle[$i]['txtCodigo'])."';
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$cantventa = number_format($detalle[$i]['cantidad'], 2, '.', '');
		$existencia = number_format($existenciaproductobd-$cantventa, 2, '.', '');
		$stmt->execute();
		##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################

		########## ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX ###################
		$sql3 = " UPDATE kardex_productos set "
		      ." salidas = ?, "
		      ." stockactual = ? "
			  ." WHERE "
			  ." codproceso = '".limpiar(decrypt($_POST["codventa"]))."' AND codproducto = '".limpiar($detalle[$i]['txtCodigo'])."';
			   ";
		$stmt = $this->dbh->prepare($sql3);
		$stmt->bindParam(1, $salidas);
		$stmt->bindParam(2, $stockactual);
		
		$salidas = number_format($detalle[$i]['cantidad']+$cantidad, 2, '.', '');
		$stockactual = number_format($existenciaproductobd-$cantventa, 2, '.', '');
		$stmt->execute();
	}

    ############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################	

    } else {

    ############################### PROCESO PARA VERIFICAR LOS COMBOS ######################################

	############## VERIFICO LA EXISTENCIA DEL COMBOS EN ALMACEN #################
	$sql = "SELECT 
	existencia 
	FROM combos 
	WHERE codcombo = '".limpiar($detalle[$i]['txtCodigo'])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$existenciacombobd = ($row['existencia']== "" ? "0" : $row['existencia']);
	############## VERIFICO LA EXISTENCIA DEL COMBOS EN ALMACEN #################		

	##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
	$sql = " UPDATE combos set "
		  ." existencia = ? "
		  ." where "
		  ." codcombo = '".limpiar($detalle[$i]['txtCodigo'])."';
		   ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $existencia);
	$cantventa = number_format($detalle[$i]['cantidad'], 2, '.', '');
	$existencia = number_format($existenciacombobd-$cantventa, 2, '.', '');
	$stmt->execute();
	##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################

	########## ACTUALIZAMOS LOS DATOS DEL COMBOS EN KARDEX ###################
	$sql3 = " UPDATE kardex_combos set "
	      ." salidas = ?, "
	      ." stockactual = ? "
		  ." WHERE "
		  ." codproceso = '".limpiar(decrypt($_POST["codventa"]))."' and codcombo = '".limpiar($detalle[$i]['txtCodigo'])."';
		   ";
	$stmt = $this->dbh->prepare($sql3);
	$stmt->bindParam(1, $salidas);
	$stmt->bindParam(2, $stockactual);
	
	$salidas = number_format($detalle[$i]['cantidad']+$cantidad, 2, '.', '');
	$stockactual = number_format($existenciacombobd-$cantventa, 2, '.', '');
	$stmt->execute();
	########## ACTUALIZAMOS LOS DATOS DEL COMBOS EN KARDEX ###################

    ############################### PROCESO PARA VERIFICAR LOS COMBOS ######################################	

    }		


    ############################### PROCESO PARA VERIFICAR LOS INGREDIENTES ######################################	

		############## VERIFICO SI EL PRODUCTO TIENE INGREDIENTES RELACIONADOS #################
	    $sql = "SELECT * FROM productosxingredientes WHERE codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(limpiar($detalle[$i]['txtCodigo'])));
		$num = $stmt->rowCount();
        if($num>0) {  

        	$sql = "SELECT * FROM productosxingredientes LEFT JOIN ingredientes ON productosxingredientes.codingrediente = ingredientes.codingrediente WHERE productosxingredientes.codproducto IN ('".$detalle[$i]['txtCodigo']."')";
        	foreach ($this->dbh->query($sql) as $row)
		    { 
			   $this->p[] = $row;

			   $cantracionbd = $row['cantracion'];
			   $codingredientebd = $row['codingrediente'];
			   $cantingredientebd = $row['cantingrediente'];
			   $precioventaingredientebd = $row['precioventa'];
			   $ivaingredientebd = $row['ivaingrediente'];
			   $descingredientebd = $row['descingrediente'];

		    if($controlingredientebd == 1){

			   ############## ACTUALIZO LOS DATOS DEL INGREDIENTE #################
			   $update = "UPDATE ingredientes set "
			   ." cantingrediente = ? "
			   ." WHERE "
			   ." codingrediente = ?;
			   ";
			   $stmt = $this->dbh->prepare($update);
			   $stmt->bindParam(1, $cantidadracion);
			   $stmt->bindParam(2, $codingredientebd);

			   $racion = number_format($cantracionbd*$detalle[$i]['cantidad'], 2, '.', '');
			   $cantidadracion = number_format($cantingredientebd-$racion, 2, '.', '');
			   $stmt->execute();
			   ############## ACTUALIZO LOS DATOS DEL INGREDIENTE #################

			   ############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################
			   $sql = "SELECT 
			   salidas 
			   FROM kardex_ingredientes 
			   WHERE codproceso = '".limpiar(decrypt($_POST['codventa']))."' 
			   AND codingrediente = '".limpiar($codingredientebd)."'";
			   foreach ($this->dbh->query($sql) as $row)
			   {
			   	$this->p[] = $row;
			   }
			   $salidakardex = $row['salidas'];
		############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################	

			   ########## ACTUALIZAMOS LOS DATOS DEL INGREDIENTE EN KARDEX ###################
			   $sql3 = " UPDATE kardex_ingredientes set "
			   ." salidas = ?, "
			   ." stockactual = ? "
			   ." WHERE "
			   ." codproceso = '".limpiar(decrypt($_POST["codventa"]))."' AND codingrediente = '".limpiar($codingredientebd)."';
			   ";
			   $stmt = $this->dbh->prepare($sql3);
			   $stmt->bindParam(1, $salidas);
			   $stmt->bindParam(2, $stockactual);

			   $racion = number_format($cantracionbd*$detalle[$i]['cantidad'], 2, '.', '');
			   $salidas = number_format($salidakardex+$racion, 2, '.', '');
			   
			   $substock = number_format($cantracionbd*$detalle[$i]['cantidad'], 2, '.', '');
			   $stockactual = number_format($cantingredientebd-$substock, 2, '.', '');
			   $stmt->execute();
			}
		}
	}//fin de consulta de ingredientes de productos	

    ############################### PROCESO PARA VERIFICAR LOS INGREDIENTES ######################################	

        }
    }
		
	####################### DESTRUYO LA VARIABLE DE SESSION #####################
	unset($_SESSION["CarritoVenta"]);
    $this->dbh->commit();

    ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############
    $sql3 = "SELECT SUM(totaldescuentov) AS totaldescuentosi, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detalleventas WHERE codpedido = '".limpiar(decrypt($_POST["codpedido"]))."' AND codventa = '".limpiar(decrypt($_POST["codventa"]))."' AND ivaproducto = 'SI'";
    foreach ($this->dbh->query($sql3) as $row3)
    {
    	$this->p[] = $row3;
    }
	$subtotaldescuentosi = ($row3['totaldescuentosi']== "" ? "0.00" : $row3['totaldescuentosi']);
    $subtotalivasi = ($row3['valorneto']== "" ? "0.00" : $row3['valorneto']);
    $subtotalivasi2 = ($row3['valorneto2']== "" ? "0.00" : $row3['valorneto2']);
    ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############

    ############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############
    $sql4 = "SELECT SUM(totaldescuentov) AS totaldescuentono, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detalleventas WHERE codpedido = '".limpiar(decrypt($_POST["codpedido"]))."' AND codventa = '".limpiar(decrypt($_POST["codventa"]))."' AND ivaproducto = 'NO'";
    foreach ($this->dbh->query($sql4) as $row4)
    {
    	$this->p[] = $row4;
    }
	$subtotaldescuentono = ($row4['totaldescuentono']== "" ? "0.00" : $row4['totaldescuentono']);
    $subtotalivano = ($row4['valorneto']== "" ? "0.00" : $row4['valorneto']);
    $subtotalivano2 = ($row4['valorneto2']== "" ? "0.00" : $row4['valorneto2']);
    ############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############

    ############ ACTUALIZO LOS TOTALES EN LA VENTA ##############
    $sql = " UPDATE ventas SET "
    ." codcliente = ?, "
    ." subtotalivasi = ?, "
    ." subtotalivano = ?, "
    ." totaliva = ?, "
	." descontado = ?, "
    ." descuento = ?, "
    ." totaldescuento = ?, "
    ." totalpago = ?, "
    ." totalpago2 = ? "
    ." WHERE "
    ." codpedido = ? AND codventa = ?;
    ";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(1, $codcliente);
    $stmt->bindParam(2, $subtotalivasi);
    $stmt->bindParam(3, $subtotalivano);
    $stmt->bindParam(4, $totaliva);
	$stmt->bindParam(5, $descontado);
    $stmt->bindParam(6, $descuento);
    $stmt->bindParam(7, $totaldescuento);
    $stmt->bindParam(8, $totalpago);
    $stmt->bindParam(9, $totalpago2);
    $stmt->bindParam(10, $codpedido);
    $stmt->bindParam(11, $codventa);

    $codcliente = limpiar("0");
    $iva = $_POST["iva"]/100;
    $totaliva = number_format($subtotalivasi*$iva, 2, '.', '');
	$descontado = number_format($subtotaldescuentosi+$subtotaldescuentono, 2, '.', '');
    $descuento = limpiar($_POST["descuento"]);
    $txtDescuento = $_POST["descuento"]/100;
    $total = number_format($subtotalivasi+$subtotalivano+$totaliva, 2, '.', '');
    $totaldescuento = number_format($total*$txtDescuento, 2, '.', '');
    $totalpago = number_format($total-$totaldescuento, 2, '.', '');
    $totalpago2 = number_format($subtotalivasi2+$subtotalivano2, 2, '.', '');
    $codpedido = limpiar(decrypt($_POST["codpedido"]));
    $codventa = limpiar(decrypt($_POST["codventa"]));
    $stmt->execute();
    ############ ACTUALIZO LOS TOTALES EN LA VENTA ##############

    echo "<span class='fa fa-check-square-o'></span> EL PEDIDO FUE AGREGADO A LA ".limpiar($_POST["nombremesa"])." EXITOSAMENTE <a href='reportepdf?codpedido=".encrypt($codpedido)."&pedido=".encrypt($pedido)."&codventa=".encrypt($codventa)."&tipo=".encrypt("COMANDA")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR COMANDA</strong></font color></a></div>";

    echo "<script>window.open('reportepdf?codpedido=".encrypt($codpedido)."&pedido=".encrypt($pedido)."&codventa=".encrypt($codventa)."&tipo=".encrypt("COMANDA")."', '_blank');</script>";
	exit;
}
######################### FUNCION AGREGAR PEDIDOS A VENTAS ############################

############################ FUNCION CERRAR MESA #############################
public function CerrarMesa()
	{
	self::SetNames();
	$sql = "UPDATE ventas set "
	." statuspago = ? "
	." WHERE "
	." codpedido = ? AND codventa = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $statuspago);
	$stmt->bindParam(2, $codpedido);
	$stmt->bindParam(3, $codventa);
    
	$statuspago = limpiar("2");
	$codpedido = limpiar(decrypt($_GET["codpedido"]));
	$codventa = limpiar(decrypt($_GET["codventa"]));
	$stmt->execute();

	#################### ACTUALIZAMOS EL STATUS DE COCINA EN PEDIDOS ####################
	/*$sql = "UPDATE detallepedidos set "
		  ." cocinero = ? "
		  ." WHERE "
		  ." codpedido = ? AND codventa = ?;
		   ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $cocinero);
	$stmt->bindParam(2, $codpedido);
	$stmt->bindParam(3, $codventa);
	
	$cocinero = limpiar("0");
	$codpedido = limpiar(decrypt($_GET["codpedido"]));
	$codventa = limpiar(decrypt($_GET["codventa"]));
	$stmt->execute();*/
	#################### ACTUALIZAMOS EL STATUS DE COCINA EN PEDIDOS ####################

	#################### ACTUALIZAMOS LA FECHA DE ENTREGA EN PEDIDOS ####################
	/*$sql = "UPDATE detallepedidos set "
		  ." fechaentrega = ? "
		  ." WHERE "
		  ." codpedido = ? AND codventa = ? AND fechaentrega = '0000-00-00 00:00:00';
		   ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $fechaentrega);
	$stmt->bindParam(2, $codpedido);
	$stmt->bindParam(3, $codventa);
	
	$fechaentrega = date("Y-m-d H:i:s");
	$codpedido = limpiar(decrypt($_GET["codpedido"]));
	$codventa = limpiar(decrypt($_GET["codventa"]));
	$stmt->execute();*/
	#################### ACTUALIZAMOS LA FECHA DE ENTREGA EN PEDIDOS ####################

	#################### ACTUALIZAMOS EL STATUS DE MESA ####################
	$sql = "SELECT codmesa FROM ventas WHERE codmesa = ? AND statuspago = 1";
    $stmt = $this->dbh->prepare($sql);
    $stmt->execute(array(limpiar(decrypt($_GET["codmesa"]))));
    $num = $stmt->rowCount();
    if($num == 0)
    {
    	$sql = "UPDATE mesas set "
    	." statusmesa = ? "
    	." WHERE "
    	." codmesa = ?;
    	";
    	$stmt = $this->dbh->prepare($sql);
    	$stmt->bindParam(1, $statusmesa);
    	$stmt->bindParam(2, $codmesa);

    	$statusmesa = limpiar('2');
    	$codmesa = limpiar(decrypt($_GET["codmesa"]));
    	$stmt->execute();
    }	
    #################### ACTUALIZAMOS EL STATUS DE MESA ####################
}
########################### FUNCION CERRAR MESA ###########################

####################### FUNCION VERIFICAR PEDIDOS EN MESA PARA COBRO #######################
public function BusquedaPedidosMesa()
{ 
	self::SetNames();
	$sql = "SELECT * FROM arqueocaja 
	INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	INNER JOIN usuarios ON cajas.codigo = usuarios.codigo 
	WHERE usuarios.codigo = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_SESSION["codigo"]));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<center><span class='fa fa-info-circle'></span> POR FAVOR DEBE DE REALIZAR EL ARQUEO DE CAJA ASIGNADA PARA PROCESAR VENTAS <a href='arqueos'><label> REALIZAR ARQUEO</a></label></div></center>";
		exit;

	} else {
	
	$sql = "SELECT
	clientes.documcliente,
	clientes.dnicliente, 
    CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente, 
    ventas.codpedido, 
    ventas.codventa,
    ventas.codcaja, 
    ventas.codcliente, 
    documentos.documento, 
    ventas.subtotalivasi, 
    ventas.subtotalivano, 
    ventas.iva, 
    ventas.totaliva,
	ventas.descontado, 
    ventas.descuento, 
    ventas.totaldescuento, 
    ventas.totalpago, 
    ventas.totalpago2, 
    ventas.creditopagado, 
    ventas.codigo, 
    ventas.observaciones,  
    salas.nomsala, 
    mesas.codmesa, 
    mesas.nommesa,
    mesas.statusmesa, 
    usuarios.nombres,
	SUM(detalleventas.cantventa) AS articulos, 
	GROUP_CONCAT(cantventa, ' | ', substr(producto, 1,21) , ' | ', ROUND(valorneto, 2) SEPARATOR '<br>') AS detalles  
    FROM mesas INNER JOIN ventas ON mesas.codmesa = ventas.codmesa
	LEFT JOIN detalleventas ON detalleventas.codpedido = ventas.codpedido
    LEFT JOIN salas ON salas.codsala = mesas.codsala  
    LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente 
    LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento 
    LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo 
    WHERE mesas.codmesa = ? AND ventas.statuspago = 2 
    GROUP BY detalleventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codmesa"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		  
	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> ESTA MESA SE ENCUENTRA ABIERTA AL CLIENTE ACTUALMENTE</div></center>";
	exit;

	} 
	else 
	{
	    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	   }
	}
}
####################### FUNCION VERIFICAR PEDIDOS EN MESA PARA COBRO #######################

############################ FUNCION COBRAR MESA ##############################
public function CobrarMesa()
{
	self::SetNames();
	####################### VERIFICO ARQUEO DE CAJA #######################
	$sql = "SELECT * FROM arqueocaja 
	INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	INNER JOIN usuarios ON cajas.codigo = usuarios.codigo 
	WHERE usuarios.codigo = ? AND arqueocaja.statusarqueo = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_SESSION["codigo"]));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "1";
		exit;

	} else {
		
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		$codarqueo = $row['codarqueo'];
		$codcaja = $row['codcaja'];
	}
    ####################### VERIFICO ARQUEO DE CAJA #######################

    if(empty($_POST["tipodocumento"]) or empty($_POST["tipopago"]))
	{
		echo "2";
		exit;
	}
	elseif(limpiar($_POST["txtImporte"]=="") && limpiar($_POST["txtImporte"]==0) && limpiar($_POST["txtImporte"]==0.00))
	{
		echo "3";
		exit;
			
	}
	elseif(isset($_POST['formapago2']) && $_POST["formapago2"] != ""){

		/*if($_POST["txtTotal"] > $_POST["txtAgregado"])
		{
			echo "4";
			exit;
		}*/
	}
	else if(limpiar($_POST["tipodocumento"]) == "FACTURA" && limpiar($_POST["codcliente"]) == "0"){ 

        echo "5";
		exit;
	}

	################### SELECCIONE LOS DATOS DEL CLIENTE ######################
    $sql = "SELECT
    clientes.dnicliente,
    CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
    clientes.girocliente,
    clientes.emailcliente, 
    clientes.tipocliente,
    clientes.limitecredito,
    clientes.id_provincia,
    clientes.id_departamento,
    clientes.direccliente,
    provincias.provincia,
    departamentos.departamento,
    ROUND(SUM(if(pag.montocredito!='0',pag.montocredito,'0.00')), 2) montoactual,
    ROUND(SUM(if(pag.montocredito!='0',clientes.limitecredito-pag.montocredito,clientes.limitecredito)), 2) creditodisponible
    FROM clientes 
    LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento
    LEFT JOIN
       (SELECT
       codcliente, montocredito       
       FROM creditosxclientes) pag ON pag.codcliente = clientes.codcliente
       WHERE clientes.codcliente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar($_POST['codcliente'])));
	$num = $stmt->rowCount();
	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$p[] = $row;
	}
    $tipocliente = ($row['tipocliente'] == "" ? "0" : $row['tipocliente']);
    $dnicliente = ($row['dnicliente'] == "" ? "0" : $row['dnicliente']);
    $nomcliente = ($row['nomcliente'] == "" ? "0" : $row['nomcliente']);
    $girocliente = ($row['girocliente'] == "" ? "0" : $row['girocliente']);
    $emailcliente = $row['emailcliente'];
    $provincia = ($row['id_provincia'] == "" || $row['id_provincia'] == "0" ? "0" : $row['provincia']);
    $departamento = ($row['id_departamento'] == "" || $row['id_provincia'] == "0" ? "0" : $row['departamento']);
    $direccliente = ($row['direccliente'] == "" ? "0" : $row['direccliente']);
    $limitecredito = $row['limitecredito'];
    $montoactual = $row['montoactual'];
    $creditodisponible = $row['creditodisponible'];
    $medioabono = (empty($_POST["medioabono"]) ? "" : $_POST["medioabono"]);
    $montoabono = (empty($_POST["montoabono"]) ? "0.00" : $_POST["montoabono"]);
    $total = number_format($_POST["txtImporte"]-$montoabono, 2, '.', '');
    ################### SELECCIONE LOS DATOS DEL CLIENTE ######################
	
	if(limpiar($_POST["tipodocumento"] == "FACTURA" && $tipocliente == "NATURAL")){ 

    	    echo "6";
	        exit;

    } else if ($_POST["tipopago"] == "CREDITO") {

		$fechaactual = date("Y-m-d");
		$fechavence = date("Y-m-d",strtotime($_POST['fechavencecredito']));

		if ($_POST["codcliente"] == '0') { 

	        echo "7";
	        exit;

        } else if (strtotime($fechavence) < strtotime($fechaactual)) {

			echo "8";
			exit;

		} else if ($montoabono != "0.00" && $medioabono == "") {
  
           echo "9";
	       exit;

		} else if ($limitecredito != "0.00" && $total > $creditodisponible) {
  
           echo "10";
	       exit;

		} else if($_POST["montoabono"] >= $_POST["txtTotalPago"]) { 
	
		   echo "11";
		   exit;

	    }
	}
	################### SELECCIONE LOS DATOS DEL CLIENTE ######################

	################ CREO EL CODIGO DE BANDERA PARA NUMERO DE VENTA ################
	$sql = "SELECT bandera from ventas WHERE statuspago = 0 ORDER BY bandera DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

    $idbandera=$row["bandera"];

    }
	if(empty($idbandera)){

		$bandera = '1';

	} else {
		$num     = $idbandera + 1;
		$bandera = $num;
	}
	################ CREO EL CODIGO DE BANDERA PARA NUMERO DE VENTA ################
	
    ################ OBTENGO DATOS DE CONFIGURACION ################
	$sql = "SELECT * 
	FROM configuracion 
    LEFT JOIN documentos ON configuracion.documsucursal = documentos.coddocumento
    LEFT JOIN provincias ON configuracion.id_provincia = provincias.id_provincia 
    LEFT JOIN departamentos ON configuracion.id_departamento = departamentos.id_departamento 
    LEFT JOIN tiposmoneda ON configuracion.codmoneda = tiposmoneda.codmoneda";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
    $rucemisor = $row['cuit'];
    $razonsocial = $row['nomsucursal'];
    $actecoemisor = $row['codgiro'];
    $giroemisor = $row['girosucursal'];
    $provincia = ($row['id_provincia'] == "" || $row['id_provincia'] == "0" ? $row['direcsucursal'] : $row['provincia']);
    $departamento = ($row['id_departamento'] == "" || $row['id_departamento'] == "0" ? $row['direcsucursal'] : $row['departamento']);
    $direcemisor = $row['direcsucursal'];
    $inicioticket = $row['inicioticket'];
    $inicioboleta = $row['inicioboleta'];
	$iniciofactura = $row['iniciofactura'];		
	$infoapi = $row['infoapi']; 
	$simbolo = $row['simbolo'];
	################ OBTENGO DATOS DE CONFIGURACION ################

	################ CREO LOS CODIGO VENTA-SERIE-AUTORIZACION ################
	$sql = "SELECT 
	codfactura 
	FROM ventas 
	WHERE tipodocumento = '".limpiar($_POST['tipodocumento'])."' 
	AND statuspago = 0 ORDER BY bandera DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$factura=$row["codfactura"];

	}
	
	if($_POST['tipodocumento']=="TICKET") {

        $codfactura = (empty($factura) ? $inicioticket : $factura + 1);
		$codserie = limpiar(GenerateRandomStringg());
		$codautorizacion = limpiar(GenerateRandomStringg());

	} elseif($_POST['tipodocumento']=="BOLETA") {

        $codfactura = (empty($factura) ? $inicioboleta : $factura + 1);
		$codserie = limpiar(GenerateRandomStringg());
		$codautorizacion = limpiar(GenerateRandomStringg());

	} elseif($_POST['tipodocumento']=="FACTURA") {

		$codfactura = (empty($factura) ? $iniciofactura : $factura + 1);
		$codserie = limpiar(GenerateRandomStringg());
		$codautorizacion = limpiar(GenerateRandomStringg());
	}
    ################# CREO LOS CODIGO VENTA-SERIE-AUTORIZACION ###############


if ($infoapi == "SI"){

############################# PROCESO PARA ENVIAR INFORMACION PARA FACTURACION ELECTRONICA #############################

############################# PROCESO PARA ENVIAR INFORMACION PARA FACTURACION ELECTRONICA #############################

}//FIN DE INFO API


	$sql = "UPDATE ventas set "
	." tipodocumento = ?, "
	." codcaja = ?, "
	." codfactura = ?, "
	." codserie = ?, "
	." codautorizacion = ?, "
	." codcliente = ?, "
	." descuento = ?, "
	." totaldescuento = ?, "
	." totalpago = ?, "
	." creditopagado = ?, "
	." tipopago = ?, "
	." formapago = ?, "
	." montopagado = ?, "
	." formapago2 = ?, "
	." montopagado2 = ?, "
	." formapropina = ?, "
	." montopropina = ?, "
	." montodevuelto = ?, "
	." fechavencecredito = ?, "
	." statusventa = ?, "
	." statuspago = ?, "
	." observaciones = ?, "
	." bandera = ?, "
	." docelectronico = ? "
	." WHERE "
	." codpedido = ? AND codventa = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $tipodocumento);
	$stmt->bindParam(2, $codcaja);
	$stmt->bindParam(3, $codfactura);
	$stmt->bindParam(4, $codserie);
	$stmt->bindParam(5, $codautorizacion);
	$stmt->bindParam(6, $codcliente);
	$stmt->bindParam(7, $descuento);
	$stmt->bindParam(8, $totaldescuento);
	$stmt->bindParam(9, $totalpago);
	$stmt->bindParam(10, $creditopagado);
	$stmt->bindParam(11, $tipopago);
	$stmt->bindParam(12, $formapago);
	$stmt->bindParam(13, $montopagado);
	$stmt->bindParam(14, $formapago2);
	$stmt->bindParam(15, $montopagado2);
	$stmt->bindParam(16, $formapropina);
	$stmt->bindParam(17, $montopropina);
	$stmt->bindParam(18, $montodevuelto);
	$stmt->bindParam(19, $fechavencecredito);
	$stmt->bindParam(20, $statusventa);
	$stmt->bindParam(21, $statuspago);
	$stmt->bindParam(22, $observaciones);
	$stmt->bindParam(23, $bandera);
	$stmt->bindParam(24, $docelectronico);
	$stmt->bindParam(25, $codpedido);
	$stmt->bindParam(26, $codventa);
    
	$tipodocumento = limpiar($_POST["tipodocumento"]);
	$codcaja = limpiar($_POST["codcaja"]);
	$codcliente = limpiar($_POST["codcliente"]);
	$descuento = limpiar($_POST["descuento"]);
	$totaldescuento = limpiar($_POST["txtDescuento2"]);
	$totalpago = limpiar($_POST["txtTotalPago"]);
	$creditopagado = limpiar(isset($_POST['montoabono']) ? $_POST["montoabono"] : "0.00");
	$tipopago = limpiar($_POST["tipopago"]);
	$formapago = limpiar($_POST["tipopago"]=="CONTADO" ? $_POST["formapago"] : "CREDITO");
	$montopagado = limpiar($_POST['montopagado']);
	$formapago2 = limpiar(isset($_POST['montopagado2']) ? $_POST["formapago2"] : "0");
	$montopagado2 = limpiar(isset($_POST['montopagado2']) ? $_POST["montopagado2"] : "0");
	$formapropina = limpiar($_POST['formapropina']=="" ? "0" : $_POST["formapropina"]);
	$montopropina = limpiar(isset($_POST['montopropina']) ? $_POST["montopropina"] : "0");
	$montodevuelto = limpiar($_POST['montodevuelto']);
    $fechavencecredito = limpiar($_POST["tipopago"]=="CREDITO" ? date("Y-m-d",strtotime($_POST['fechavencecredito'])) : "0000-00-00");
    $statusventa = limpiar($_POST["tipopago"]=="CONTADO" ? "PAGADA" : "PENDIENTE");
	$statuspago = limpiar("0");
	$observaciones = limpiar($_POST['observaciones']=="" ? "NINGUNA" : $_POST['observaciones']);
	$docelectronico = limpiar($infoapi=="SI" ? "1" : "0");
	$codpedido = limpiar($_POST["codpedido"]);
	$codventa = limpiar($_POST["codventa"]);
	$stmt->execute();

	#################### ACTUALIZAMOS EL STATUS DE MESA ####################
	$sql = "SELECT codmesa FROM ventas WHERE codmesa = ? AND statuspago != 0";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar($_POST["codmesa"])));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$sql = "UPDATE mesas set "
		." statusmesa = ? "
		." WHERE "
		." codmesa = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $statusmesa);
		$stmt->bindParam(2, $codmesa);

		$statusmesa = limpiar('0');
		$codmesa = limpiar($_POST["codmesa"]);
		$stmt->execute();
	}	
    #################### ACTUALIZAMOS EL STATUS DE MESA ####################

    ############## AGREGAMOS EL INGRESO DE VENTAS PAGADAS A CAJA ###############
	if (limpiar($_POST["tipopago"]=="CONTADO")){

	################## OBTENGO LOS DATOS EN CAJA ##################
	$sql = "SELECT 
	efectivo, 
	cheque, 
	tcredito, 
	tdebito, 
	tprepago, 
	transferencia, 
	electronico,
	cupon, 
	otros,
	propinasefectivo,
	propinasotros,
	nroticket,
	nroboleta,
	nrofactura
	FROM arqueocaja WHERE codcaja = '".limpiar($_POST["codcaja"])."' AND statusarqueo = 1";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$efectivo = ($row['efectivo']== "" ? "0.00" : $row['efectivo']);
	$cheque = ($row['cheque']== "" ? "0.00" : $row['cheque']);
	$tcredito = ($row['tcredito']== "" ? "0.00" : $row['tcredito']);
	$tdebito = ($row['tdebito']== "" ? "0.00" : $row['tdebito']);
	$tprepago = ($row['tprepago']== "" ? "0.00" : $row['tprepago']);
	$transferencia = ($row['transferencia']== "" ? "0.00" : $row['transferencia']);
	$electronico = ($row['electronico']== "" ? "0.00" : $row['electronico']);
	$cupon = ($row['cupon']== "" ? "0.00" : $row['cupon']);
	$otros = ($row['otros']== "" ? "0.00" : $row['otros']);
	$propinasefectivo = ($row['propinasefectivo']== "" ? "0.00" : $row['propinasefectivo']);
	$propinasotros = ($row['propinasotros']== "" ? "0.00" : $row['propinasotros']);
	$nroticket = $row['nroticket'];
	$nroboleta = $row['nroboleta'];
	$nrofactura = $row['nrofactura'];
	################## OBTENGO LOS DATOS EN CAJA ##################

	if(isset($_POST['formapago2']) && $_POST['formapago2']!=""){

    ################ AGREGO EL MONTO #1 EN CAJA ################
	$sql = "UPDATE arqueocaja set "
	." efectivo = ?, "
	." cheque = ?, "
	." tcredito = ?, "
	." tdebito = ?, "
	." tprepago = ?, "
	." transferencia = ?, "
	." electronico = ?, "
	." cupon = ?, "
	." otros = ?, "
	." propinasefectivo = ?, "
	." propinasotros = ?, "
	." nroticket = ?, "
	." nroboleta = ?, "
	." nrofactura = ? "
	." WHERE "
	." codcaja = ? AND statusarqueo = 1;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $txtEfectivo);
	$stmt->bindParam(2, $txtCheque);
	$stmt->bindParam(3, $txtTcredito);
	$stmt->bindParam(4, $txtTdebito);
	$stmt->bindParam(5, $txtTprepago);
	$stmt->bindParam(6, $txtTransferencia);
	$stmt->bindParam(7, $txtElectronico);
	$stmt->bindParam(8, $txtCupon);
	$stmt->bindParam(9, $txtOtros);
	$stmt->bindParam(10, $txtPropinaEfectivo);
	$stmt->bindParam(11, $txtPropinaOtros);
	$stmt->bindParam(12, $NumTicket);
	$stmt->bindParam(13, $NumBoleta);
	$stmt->bindParam(14, $NumFactura);
	$stmt->bindParam(15, $codcaja);

	$txtEfectivo = limpiar($_POST["formapago"] == "EFECTIVO" ? number_format($efectivo+$_POST["montopagado"], 2, '.', '') : $efectivo);
	$txtCheque = limpiar($_POST["formapago"] == "CHEQUE" ? number_format($cheque+$_POST["montopagado"], 2, '.', '') : $cheque);
	$txtTcredito = limpiar($_POST["formapago"] == "TARJETA DE CREDITO" ? number_format($tcredito+$_POST["montopagado"], 2, '.', '') : $tcredito);
	$txtTdebito = limpiar($_POST["formapago"] == "TARJETA DE DEBITO" ? number_format($tdebito+$_POST["montopagado"], 2, '.', '') : $tdebito);
	$txtTprepago = limpiar($_POST["formapago"] == "TARJETA PREPAGO" ? number_format($tprepago+$_POST["montopagado"], 2, '.', '') : $tprepago);
	$txtTransferencia = limpiar($_POST["formapago"] == "TRANSFERENCIA" ? number_format($transferencia+$_POST["montopagado"], 2, '.', '') : $transferencia);
	$txtElectronico = limpiar($_POST["formapago"] == "DINERO ELECTRONICO" ? number_format($electronico+$_POST["montopagado"], 2, '.', '') : $electronico);
	$txtCupon = limpiar($_POST["formapago"] == "CUPON" ? number_format($cupon+$_POST["montopagado"], 2, '.', '') : $cupon);
	$txtOtros = limpiar($_POST["formapago"] == "OTROS" ? number_format($otros+$_POST["montopagado"], 2, '.', '') : $otros);
	
	$txtPropinaEfectivo = limpiar(isset($_POST['montopropina']) && $_POST["formapropina"] == "EFECTIVO" ? number_format($propinasefectivo+$_POST["montopropina"], 2, '.', '') : $propinasefectivo);
	$txtPropinaOtros = limpiar(isset($_POST['montopropina']) && $_POST["formapropina"] != "EFECTIVO" ? number_format($propinasotros+$_POST["montopropina"], 2, '.', '') : $propinasotros);

	$NumTicket = limpiar($_POST["tipodocumento"] == "TICKET" ? $nroticket+1 : $nroticket);
	$NumBoleta = limpiar($_POST["tipodocumento"] == "BOLETA" ? $nroboleta+1 : $nroboleta);
	$NumFactura = limpiar($_POST["tipodocumento"] == "FACTURA" ? $nrofactura+1 : $nrofactura);

	$codcaja = limpiar($_POST["codcaja"]);
	$stmt->execute();
	################ AGREGO EL MONTO #1 EN CAJA ################

	################ AGREGO EL MONTO #2 EN CAJA ################
	$sql2 = "UPDATE arqueocaja set "
	." efectivo = ?, "
	." cheque = ?, "
	." tcredito = ?, "
	." tdebito = ?, "
	." tprepago = ?, "
	." transferencia = ?, "
	." electronico = ?, "
	." cupon = ?, "
	." otros = ? "
	." WHERE "
	." codcaja = ? AND statusarqueo = 1;
	";
	$stmt = $this->dbh->prepare($sql2);
	$stmt->bindParam(1, $txtEfectivo2);
	$stmt->bindParam(2, $txtCheque2);
	$stmt->bindParam(3, $txtTcredito2);
	$stmt->bindParam(4, $txtTdebito2);
	$stmt->bindParam(5, $txtTprepago2);
	$stmt->bindParam(6, $txtTransferencia2);
	$stmt->bindParam(7, $txtElectronico2);
	$stmt->bindParam(8, $txtCupon2);
	$stmt->bindParam(9, $txtOtros2);
	$stmt->bindParam(10, $codcaja);

	$txtEfectivo2 = limpiar($_POST["formapago2"] == "EFECTIVO" ? number_format($efectivo+$_POST["montopagado2"], 2, '.', '') : $txtEfectivo);
	$txtCheque2 = limpiar($_POST["formapago2"] == "CHEQUE" ? number_format($cheque+$_POST["montopagado2"], 2, '.', '') : $cheque);
	$txtTcredito2 = limpiar($_POST["formapago2"] == "TARJETA DE CREDITO" ? number_format($tcredito+$_POST["montopagado2"], 2, '.', '') : $txtTcredito);
	$txtTdebito2 = limpiar($_POST["formapago2"] == "TARJETA DE DEBITO" ? number_format($tdebito+$_POST["montopagado2"], 2, '.', '') : $txtTdebito);
	$txtTprepago2 = limpiar($_POST["formapago2"] == "TARJETA PREPAGO" ? number_format($tprepago+$_POST["montopagado2"], 2, '.', '') : $txtTprepago);
	$txtTransferencia2 = limpiar($_POST["formapago2"] == "TRANSFERENCIA" ? number_format($transferencia+$_POST["montopagado2"], 2, '.', '') : $txtTransferencia);
	$txtElectronico2 = limpiar($_POST["formapago2"] == "DINERO ELECTRONICO" ? number_format($electronico+$_POST["montopagado2"], 2, '.', '') : $txtElectronico);
	$txtCupon2 = limpiar($_POST["formapago2"] == "CUPON" ? number_format($cupon+$_POST["montopagado2"], 2, '.', '') : $txtCupon);
	$txtOtros2 = limpiar($_POST["formapago2"] == "OTROS" ? number_format($otros+$_POST["montopagado2"], 2, '.', '') : $txtOtros);
	$codcaja = limpiar($_POST["codcaja"]);
	$stmt->execute();
	################ AGREGO EL MONTO #2 EN CAJA ################

	} else { 

	################ AGREGO EL MONTO #1 EN CAJA ################
	$sql = "UPDATE arqueocaja set "
	." efectivo = ?, "
	." cheque = ?, "
	." tcredito = ?, "
	." tdebito = ?, "
	." tprepago = ?, "
	." transferencia = ?, "
	." electronico = ?, "
	." cupon = ?, "
	." otros = ?, "
	." propinasefectivo = ?, "
	." propinasotros = ?, "
	." nroticket = ?, "
	." nroboleta = ?, "
	." nrofactura = ? "
	." WHERE "
	." codcaja = ? AND statusarqueo = 1;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $txtEfectivo);
	$stmt->bindParam(2, $txtCheque);
	$stmt->bindParam(3, $txtTcredito);
	$stmt->bindParam(4, $txtTdebito);
	$stmt->bindParam(5, $txtTprepago);
	$stmt->bindParam(6, $txtTransferencia);
	$stmt->bindParam(7, $txtElectronico);
	$stmt->bindParam(8, $txtCupon);
	$stmt->bindParam(9, $txtOtros);
	$stmt->bindParam(10, $txtPropinaEfectivo);
	$stmt->bindParam(11, $txtPropinaOtros);
	$stmt->bindParam(12, $NumTicket);
	$stmt->bindParam(13, $NumBoleta);
	$stmt->bindParam(14, $NumFactura);
	$stmt->bindParam(15, $codcaja);

	$txtEfectivo = limpiar($_POST["formapago"] == "EFECTIVO" ? number_format($efectivo+$_POST["txtTotalPago"], 2, '.', '') : $efectivo);
	$txtCheque = limpiar($_POST["formapago"] == "CHEQUE" ? number_format($cheque+$_POST["txtTotalPago"], 2, '.', '') : $cheque);
	$txtTcredito = limpiar($_POST["formapago"] == "TARJETA DE CREDITO" ? number_format($tcredito+$_POST["txtTotalPago"], 2, '.', '') : $tcredito);
	$txtTdebito = limpiar($_POST["formapago"] == "TARJETA DE DEBITO" ? number_format($tdebito+$_POST["txtTotalPago"], 2, '.', '') : $tdebito);
	$txtTprepago = limpiar($_POST["formapago"] == "TARJETA PREPAGO" ? number_format($tprepago+$_POST["txtTotalPago"], 2, '.', '') : $tprepago);
	$txtTransferencia = limpiar($_POST["formapago"] == "TRANSFERENCIA" ? number_format($transferencia+$_POST["txtTotalPago"], 2, '.', '') : $transferencia);
	$txtElectronico = limpiar($_POST["formapago"] == "DINERO ELECTRONICO" ? number_format($electronico+$_POST["txtTotalPago"], 2, '.', '') : $electronico);
	$txtCupon = limpiar($_POST["formapago"] == "CUPON" ? number_format($cupon+$_POST["txtTotalPago"], 2, '.', '') : $cupon);
	$txtOtros = limpiar($_POST["formapago"] == "OTROS" ? number_format($otros+$_POST["txtTotalPago"], 2, '.', '') : $otros);
	
	$txtPropinaEfectivo = limpiar(isset($_POST['montopropina']) && $_POST["formapropina"] == "EFECTIVO" ? number_format($propinasefectivo+$_POST["montopropina"], 2, '.', '') : $propinasefectivo);
	$txtPropinaOtros = limpiar(isset($_POST['montopropina']) && $_POST["formapropina"] != "EFECTIVO" ? number_format($propinasotros+$_POST["montopropina"], 2, '.', '') : $propinasotros);

	$NumTicket = limpiar($_POST["tipodocumento"] == "TICKET" ? $nroticket+1 : $nroticket);
	$NumBoleta = limpiar($_POST["tipodocumento"] == "BOLETA" ? $nroboleta+1 : $nroboleta);
	$NumFactura = limpiar($_POST["tipodocumento"] == "FACTURA" ? $nrofactura+1 : $nrofactura);

	$codcaja = limpiar($_POST["codcaja"]);
	$stmt->execute();
	################ AGREGO EL MONTO #1 EN CAJA ################
		}
	}
    ################ AGREGAMOS EL INGRESO DE VENTAS PAGADAS A CAJA ##############


    ######### AGREGAMOS EL INGRESO Y ABONOS DE VENTAS A CREDITOS A CAJA ############
	if (limpiar($_POST["tipopago"]=="CREDITO")) {

	################## OBTENGO LOS DATOS EN CAJA ##################
	$sql = "SELECT 
	efectivo, 
	cheque, 
	tcredito, 
	tdebito, 
	tprepago, 
	transferencia, 
	electronico, 
	cupon,
	otros,
	creditos,
	nroticket,
	nroboleta,
	nrofactura
	FROM arqueocaja WHERE codcaja = '".limpiar($_POST["codcaja"])."' AND statusarqueo = 1";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$efectivo = ($row['efectivo']== "" ? "0.00" : $row['efectivo']);
	$cheque = ($row['cheque']== "" ? "0.00" : $row['cheque']);
	$tcredito = ($row['tcredito']== "" ? "0.00" : $row['tcredito']);
	$tdebito = ($row['tdebito']== "" ? "0.00" : $row['tdebito']);
	$tprepago = ($row['tprepago']== "" ? "0.00" : $row['tprepago']);
	$transferencia = ($row['transferencia']== "" ? "0.00" : $row['transferencia']);
	$electronico = ($row['electronico']== "" ? "0.00" : $row['electronico']);
	$cupon = ($row['cupon']== "" ? "0.00" : $row['cupon']);
	$otros = ($row['otros']== "" ? "0.00" : $row['otros']);
	$credito = ($row['creditos']== "" ? "0.00" : $row['creditos']);
	$nroticket = $row['nroticket'];
	$nroboleta = $row['nroboleta'];
	$nrofactura = $row['nrofactura'];
	################## OBTENGO LOS DATOS EN CAJA ##################

	$sql = "UPDATE arqueocaja set "
	." efectivo = ?, "
	." cheque = ?, "
	." tcredito = ?, "
	." tdebito = ?, "
	." tprepago = ?, "
	." transferencia = ?, "
	." electronico = ?, "
	." cupon = ?, "
	." otros = ?, "
	." creditos = ?, "
	." nroticket = ?, "
	." nroboleta = ?, "
	." nrofactura = ? "
	." WHERE "
	." codcaja = ? AND statusarqueo = 1;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $txtEfectivo);
	$stmt->bindParam(2, $txtCheque);
	$stmt->bindParam(3, $txtTcredito);
	$stmt->bindParam(4, $txtTdebito);
	$stmt->bindParam(5, $txtTprepago);
	$stmt->bindParam(6, $txtTransferencia);
	$stmt->bindParam(7, $txtElectronico);
	$stmt->bindParam(8, $txtCupon);
	$stmt->bindParam(9, $txtOtros);
	$stmt->bindParam(10, $txtCredito);
	$stmt->bindParam(11, $NumTicket);
	$stmt->bindParam(12, $NumBoleta);
	$stmt->bindParam(13, $NumFactura);
	$stmt->bindParam(14, $codcaja);

	$txtEfectivo = limpiar($_POST["medioabono"] == "EFECTIVO" ? number_format($efectivo+$_POST["montoabono"], 2, '.', '') : $efectivo);
	$txtCheque = limpiar($_POST["medioabono"] == "CHEQUE" ? number_format($cheque+$_POST["montoabono"], 2, '.', '') : $cheque);
	$txtTcredito = limpiar($_POST["medioabono"] == "TARJETA DE CREDITO" ? number_format($tcredito+$_POST["montoabono"], 2, '.', '') : $tcredito);
	$txtTdebito = limpiar($_POST["medioabono"] == "TARJETA DE DEBITO" ? number_format($tdebito+$_POST["montoabono"], 2, '.', '') : $tdebito);
	$txtTprepago = limpiar($_POST["medioabono"] == "TARJETA PREPAGO" ? number_format($tprepago+$_POST["montoabono"], 2, '.', '') : $tprepago);
	$txtTransferencia = limpiar($_POST["medioabono"] == "TRANSFERENCIA" ? number_format($transferencia+$_POST["montoabono"], 2, '.', '') : $transferencia);
	$txtElectronico = limpiar($_POST["medioabono"] == "DINERO ELECTRONICO" ? number_format($electronico+$_POST["montoabono"], 2, '.', '') : $electronico);
	$txtCupon = limpiar($_POST["medioabono"] == "CUPON" ? number_format($cupon+$_POST["montoabono"], 2, '.', '') : $cupon);
	$txtOtros = limpiar($_POST["medioabono"] == "OTROS" ? number_format($otros+$_POST["montoabono"], 2, '.', '') : $otros);
	$txtCredito = number_format($credito+($_POST["txtTotalPago"]-$_POST["montoabono"]), 2, '.', '');

	$NumTicket = limpiar($_POST["tipodocumento"] == "TICKET" ? $nroticket+1 : $nroticket);
	$NumBoleta = limpiar($_POST["tipodocumento"] == "BOLETA" ? $nroboleta+1 : $nroboleta);
	$NumFactura = limpiar($_POST["tipodocumento"] == "FACTURA" ? $nrofactura+1 : $nrofactura);

	$codcaja = limpiar($_POST["codcaja"]);
	$stmt->execute();
	################ AGREGO EL MONTO #1 EN CAJA ################

	$sql = "SELECT codcliente FROM creditosxclientes WHERE codcliente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codcliente"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$query = "INSERT INTO creditosxclientes values (null, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcliente);
		$stmt->bindParam(2, $montocredito);

		$codcliente = limpiar($_POST["codcliente"]);
		$montocredito = number_format($_POST["txtTotalPago"]-$_POST["montoabono"], 2, '.', '');
		$stmt->execute();

	} else { 

		$sql = "UPDATE creditosxclientes set"
		." montocredito = ? "
		." WHERE "
		." codcliente = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $montocredito);
		$stmt->bindParam(2, $codcliente);

		$montocredito = number_format($montoactual+($_POST["txtTotalPago"]-$_POST["montoabono"]), 2, '.', '');
		$codcliente = limpiar($_POST["codcliente"]);
		$stmt->execute();
	}

	   if (limpiar($_POST["montoabono"]!="0.00" && $_POST["montoabono"]!="0" && $_POST["montoabono"]!="")) {

		$query = "INSERT INTO abonoscreditos values (null, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcaja);
		$stmt->bindParam(2, $codventa);
		$stmt->bindParam(3, $codcliente);
		$stmt->bindParam(4, $montoabono);
		$stmt->bindParam(5, $formaabono);
		$stmt->bindParam(6, $fechaabono);

		$codcaja = limpiar($_POST["codcaja"]);
		$codcliente = limpiar($_POST["codcliente"]);
		$montoabono = limpiar($_POST["montoabono"]);
		$formaabono = limpiar($_POST["medioabono"]);
		$fechaabono = limpiar(date("Y-m-d H:i:s"));
		$stmt->execute();
	
	   }

	} 
   ########## AGREGAMOS EL INGRESO Y ABONOS DE VENTAS A CREDITOS A CAJA ########

echo "<span class='fa fa-check-square-o'></span> LA MESA HA SIDO COBRADA EN CAJA EXITOSAMENTE <a href='reportepdf?codventa=".encrypt($codventa)."&tipo=".encrypt($tipodocumento)."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR ".$tipodocumento."</strong></font color></a></div>";

echo "<script>window.open('reportepdf?codventa=".encrypt($codventa)."&tipo=".encrypt($tipodocumento)."', '_blank');</script>";
	exit;
}
############################ FUNCION COBRAR MESA ############################

##################################################################################################################
#                                                                                                                #
#                                   FUNCIONES PARA PEDIDOS DE PRODUCTOS EN MESA                                  #
#                                                                                                                #
##################################################################################################################






















##################################################################################################################
#                                                                                                                #
#                                  FUNCIONES PARA PEDIDOS DE PRODUCTOS EN DELIVERY                               #
#                                                                                                                #
##################################################################################################################

####################### FUNCION VERIFICAR PEDIDOS EN DELIVERY #######################
public function VerificaDelivery()
{
	self::SetNames();
	$imp = new Login();
	$imp = $imp->ImpuestosPorId();
	$impuesto = ($imp == '' ? "Impuesto" : $imp[0]['nomimpuesto']);
	$valor = ($imp == '' ? "0" : $imp[0]['valorimpuesto']);

	$con = new Login();
	$con = $con->ConfiguracionPorId();
	$simbolo = "<strong>".$con[0]['simbolo']."</strong>";

	if ($_SESSION["acceso"]!="mesero") {

	 	$sql = "SELECT * FROM arqueocaja INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja INNER JOIN usuarios ON cajas.codigo = usuarios.codigo WHERE usuarios.codigo = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array($_SESSION["codigo"]));
		$num = $stmt->rowCount();
		if($num==0)
		{
			echo "<div class='alert alert-danger'>";
            echo "<center><span class='fa fa-info-circle'></span> POR FAVOR DEBE DE REALIZAR EL ARQUEO DE CAJA ASIGNADA PARA PROCESAR VENTAS <a href='arqueos'><label> REALIZAR ARQUEO</a></label></div></center>";
			exit;
	    }
	}

	$sql = "SELECT 
	clientes.documcliente,
	clientes.dnicliente, 
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente, 
	ventas.codpedido, 
	ventas.codventa,
	ventas.codcaja, 
	ventas.codcliente, 
	documentos.documento, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva,
	ventas.descontado, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2,
	ventas.creditopagado,
	ventas.montodelivery, 
	ventas.codigo, 
	ventas.delivery,
	ventas.repartidor,
	ventas.entregado,
	ventas.observaciones, 
	detallepedidos.coddetallepedido, 
	detallepedidos.codpedido, 
	detallepedidos.pedido,
	detallepedidos.idproducto, 
	detallepedidos.codproducto, 
	detallepedidos.producto, 
	detallepedidos.cantventa, 
	detallepedidos.ivaproducto, 
	detallepedidos.descproducto, 
	detallepedidos.valortotal, 
	detallepedidos.totaldescuentov, 
	detallepedidos.valorneto, 
	detallepedidos.observacionespedido,
    detallepedidos.tipo,
	usuarios.nombres 
    FROM ventas INNER JOIN detallepedidos ON ventas.codpedido = detallepedidos.codpedido 
    LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente 
    LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento 
    LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo 
    WHERE ventas.codpedido = ? AND ventas.codventa = ? AND ventas.statuspago = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codpedido"]),decrypt($_GET["codventa"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
	?>

    <input type="hidden" name="idproducto" id="idproducto">
    <input type="hidden" name="codproducto" id="codproducto">
    <input type="hidden" name="producto" id="producto">
    <input type="hidden" name="codcategoria" id="codcategoria">
    <input type="hidden" name="categorias" id="categorias">
    <input type="hidden" name="precioventa" id="precioventa">
    <input type="hidden" name="preciocompra" id="preciocompra"> 
    <input type="hidden" name="precioconiva" id="precioconiva">
    <input type="hidden" name="observacion" id="observacion">
    <input type="hidden" name="ivaproducto" id="ivaproducto">
    <input type="hidden" name="descproducto" id="descproducto">
    <input type="hidden" name="tipo" id="tipo">
    <input type="hidden" name="cantidad" id="cantidad" value="1">
    <input type="hidden" name="existencia" id="existencia">
    <input type="hidden" name="proceso" id="proceso" value="nuevopedido"/>
    <input type="hidden" name="codpedido" id="codpedido" value="<?php echo encrypt("0"); ?>">
    <input type="hidden" name="codventa" id="codventa" value="<?php echo encrypt("0"); ?>">

    <div class="row">
        <div class="col-md-12">
            <label class="control-label">Búsqueda de Cliente: </label>
            <div class="input-group mb-3 has-feedback">
                <div class="input-group-append">
                <button type="button" class="btn btn-success waves-effect waves-light" data-placement="left" title="Nuevo Cliente" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCliente" data-backdrop="static" data-keyboard="false"><i class="fa fa-user-plus"></i></button>
                </div>
                <input type="hidden" name="codcliente" id="codcliente" value="0">
                <input type="text" class="form-control" name="busqueda" id="busqueda" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Criterio para la Búsqueda del Cliente" value="CONSUMIDOR FINAL" autocomplete="off"/>
            </div>
        </div>
    </div>
  
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
              <label class="control-label">Tipo de Pedido: <span class="symbol required"></span></label><br>
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="evento1" name="tipopedido" value="INTERNO"  checked="checked"onClick="TipoPedido('this.form.tipopedido.value')">
                <label class="custom-control-label" for="evento1">EN ESTABLECIMIENTO</label>
              </div>

              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="evento2" name="tipopedido" value="EXTERNO"onClick="TipoPedido('this.form.tipopedido.value')">
                <label class="custom-control-label" for="evento2">PARA DOMICILIO</label>
              </div>
            </div>
        </div>

        <div class="col-md-7"> 
            <div class="form-group has-feedback"> 
                <label class="control-label">Nombre de Repartidor: <span class="symbol required"></span></label>
                <i class="fa fa-bars form-control-feedback"></i>
                <select name="repartidor" id="repartidor" class="form-control" disabled="" required="" aria-required="true">
                <option value=""> -- SELECCIONE -- </option>
                <?php
                $usuario = new Login();
                $usuario = $usuario->ListarRepartidores();
                for($i=0;$i<sizeof($usuario);$i++){ ?>
                <option value="<?php echo encrypt($usuario[$i]['codigo']); ?>"><?php echo $usuario[$i]['nombres'] ?></option>   <?php } ?>
                </select>
            </div> 
        </div>
    </div>

    <div id="favoritos" style="display:none !important;"></div>

    <div class="table-responsive m-t-10 scroll">
    	<table id="carrito" class="table2">
    		<thead>
    			<tr class="text-center">
    				<th width="16%">Cantidad</th>
    				<th width="42%">Descripción</th>
    				<th width="14%">Precio</th>
    				<th width="14%">Importe</th>
    				<th width="14%">Acción</th>
    			</tr>
    		</thead>
    		<tbody>
    			<tr>
    				<td class="text-center" colspan=5><h4>NO HAY DETALLES AGREGADOS<h4></td>
    				</tr>
    			</tbody>
    		</table> 
    	</div>

    	<hr>

    	<div class="table-responsive">
    		<table id="carritototal" width="100%">
    			<tr>
    				<td><h5 class="text-left"><label>TOTAL DE ITEMS:</label></h5></td>
    				<td><h5 class="text-right"><label id="lblitems" name="lblitems">0.00</label></h5></td>
    			</tr>
    			<tr>
    				<td><h5 class="text-left"><label>TOTAL A CONFIRMAR:</label></h5></td>
    				<td><h5 class="text-right"><?php echo $simbolo; ?><label id="lbltotal" name="lbltotal">0.00</label></h5></td>
    				<input type="hidden" name="txtsubtotal" id="txtsubtotal" value="0.00"/>
    				<input type="hidden" name="txtsubtotal2" id="txtsubtotal2" value="0.00"/>
    				<input type="hidden" name="iva" id="iva" value="<?php echo $valor == '' ? "0.00" : number_format($valor, 2, '.', ''); ?>">
    				<input type="hidden" name="txtIva" id="txtIva" value="0.00"/>
    				<input type="hidden" name="txtdescontado" id="txtdescontado" value="0.00"/>
    				<input type="hidden" name="descuento" id="descuento" value="<?php echo number_format($con[0]['descuentoglobal'], 2, '.', ''); ?>">
    				<input type="hidden" name="txtDescuento" id="txtDescuento" value="0.00"/>
    				<input type="hidden" name="txtTotal" id="txtTotal" value="0.00"/>
    				<input type="hidden" name="txtTotalCompra" id="txtTotalCompra" value="0.00"/>
    			</tr>
    		</table>
    	</div>

    	<div class="row">
            <div class="col-md-6">
                <span id="submit_guardar"><button type="submit" name="btn-submit" id="btn-submit" class="btn btn-warning btn-lg btn-block waves-effect waves-light" ><span class="fa fa-save"></span> Confirmar</button></span>
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-dark btn-lg btn-block" id="limpiar"><span class="fa fa-trash-o"></span> Limpiar</button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <button type="button" onClick="MuestraFavoritos()" class="btn btn-success btn-lg btn-block waves-effect waves-light"><span class="fa fa-star"></span> Favoritos</button>
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-info btn-lg btn-block waves-effect waves-light" onClick="RecargaPedidos('<?php echo encrypt("DELIVERY"); ?>');" data-placement="left" title="Ver Pedidos" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalPedidos" data-backdrop="static" data-keyboard="false"><i class="fa fa-cutlery"></i> Pedidos</button>
            </div>
        </div>

		<?php  
		exit;
		} else {
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
####################### FUNCION VERIFICAR PEDIDOS EN DELIVERY #######################

######################### FUNCION LISTAR NUMERO DE PEDIDOS EN DELIVERY ########################
public function ListarPedidosDelivery()
	{
	self::SetNames();

	if(empty($_GET['codpedido']) || decrypt($_GET['codpedido']) == 0){

	$sql = "SELECT 
	ventas.idventa, 
	ventas.codpedido,
	ventas.codventa, 
	ventas.codcliente, 
	ventas.delivery, 
	ventas.repartidor,
	detallepedidos.fechapedido, 
	clientes.documcliente,
	clientes.dnicliente, 
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	documentos.documento
	FROM ventas INNER JOIN detallepedidos ON detallepedidos.codpedido = ventas.codpedido 
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento 
	WHERE ventas.statuspago = 1 AND ventas.delivery = 1 GROUP BY ventas.codpedido ORDER BY ventas.idventa ASC";
    foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

	} else {

	$sql = "SELECT 
	ventas.idventa, 
	ventas.codpedido,
	ventas.codventa, 
	ventas.codcliente, 
	ventas.delivery, 
	ventas.repartidor,
	detallepedidos.fechapedido, 
	clientes.documcliente,
	clientes.dnicliente, 
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	documentos.documento
	FROM ventas INNER JOIN detallepedidos ON detallepedidos.codpedido = ventas.codpedido 
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento 
	WHERE ventas.codpedido = '".decrypt($_GET["codpedido"])."' AND ventas.statuspago = 1 AND ventas.delivery = 1 GROUP BY ventas.codpedido ORDER BY ventas.idventa ASC";
    foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
	}
}
######################### FUNCION LISTAR NUMERO DE PEDIDOS EN DELIVERY ########################

############################ FUNCION NUEVO PEDIDO DELIVERY ##############################
public function NuevoPedidoDelivery()
{
	self::SetNames();
	if(empty($_SESSION["CarritoVenta"]))
	{
		echo "1";
		exit;
	}

	############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA ############
	$v = $_SESSION["CarritoVenta"];
	for($i=0;$i<count($v);$i++){

		if(limpiar($v[$i]['tipo']) == 1){

		    $sql = "SELECT existencia FROM productos WHERE codproducto = '".$v[$i]['txtCodigo']."'";
		    foreach ($this->dbh->query($sql) as $row)
		    {
			$this->p[] = $row;
		    }
		
		    $existenciadb = $row['existencia'];
		    $cantidad = $v[$i]['cantidad'];

	        if ($cantidad > $existenciadb) 
	        { 
		       echo "2";
		       exit;
	        }

	    } else { 

		    $sql = "SELECT existencia FROM combos WHERE codcombo = '".$v[$i]['txtCodigo']."'";
		    foreach ($this->dbh->query($sql) as $row)
		    {
			$this->p[] = $row;
		    }
		
		    $existenciadb = $row['existencia'];
		    $cantidad = $v[$i]['cantidad'];

	        if ($cantidad > $existenciadb) 
	        { 
		       echo "2";
		       exit;
	        }
	    }
	}
	############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA ############

    if(limpiar($_POST["tipopedido"]=="EXTERNO") && limpiar($_POST["repartidor"] == ""))
	{
		echo "3";
		exit;
	}
    else if(limpiar($_POST["tipopedido"]=="EXTERNO") && limpiar($_POST["codcliente"] == "0"))
	{
		echo "4";
		exit;
	}

	##################### AGREGAMOS EL NUMERO DE PEDIDO A LA VENTA #######################
	$sql = "SELECT codpedido, codventa FROM ventas ORDER BY idventa DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$pedido=$row["codpedido"];
		$venta=$row["codventa"];

	}
	if(empty($pedido) or empty($venta))
	{
		$codpedido = "P1";
		$codventa = "1";

	} else {
		
		$resto = substr($pedido, 0, 1);
		$coun = strlen($resto);
		$num = substr($pedido, $coun);
		$codigop = $num + 1;
		$codigov = $venta + 1;
		$codpedido = "P".$codigop;
		$codventa = $codigov;
	}
	##################### AGREGAMOS EL NUMERO DE PEDIDO A LA VENTA #######################

    $fecha = date("Y-m-d H:i:s");

	$query = "INSERT INTO ventas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codpedido);
	$stmt->bindParam(2, $codventa);
	$stmt->bindParam(3, $codmesa);
	$stmt->bindParam(4, $tipodocumento);
	$stmt->bindParam(5, $codcaja);
	$stmt->bindParam(6, $codfactura);
	$stmt->bindParam(7, $codserie);
	$stmt->bindParam(8, $codautorizacion);
	$stmt->bindParam(9, $codcliente);
	$stmt->bindParam(10, $subtotalivasi);
	$stmt->bindParam(11, $subtotalivano);
	$stmt->bindParam(12, $iva);
	$stmt->bindParam(13, $totaliva);
	$stmt->bindParam(14, $descontado);
	$stmt->bindParam(15, $descuento);
	$stmt->bindParam(16, $totaldescuento);
	$stmt->bindParam(17, $totalpago);
	$stmt->bindParam(18, $totalpago2);
	$stmt->bindParam(19, $creditopagado);
	$stmt->bindParam(20, $montodelivery);
	$stmt->bindParam(21, $tipopago);
	$stmt->bindParam(22, $formapago);
	$stmt->bindParam(23, $montopagado);
	$stmt->bindParam(24, $formapago2);
	$stmt->bindParam(25, $montopagado2);
	$stmt->bindParam(26, $formapropina);
	$stmt->bindParam(27, $montopropina);
	$stmt->bindParam(28, $montodevuelto);
	$stmt->bindParam(29, $fechavencecredito);
	$stmt->bindParam(30, $fechapagado);
	$stmt->bindParam(31, $statusventa);
	$stmt->bindParam(32, $statuspago);
	$stmt->bindParam(33, $fechaventa);
	$stmt->bindParam(34, $delivery);
	$stmt->bindParam(35, $repartidor);
	$stmt->bindParam(36, $entregado);
	$stmt->bindParam(37, $observaciones);
	$stmt->bindParam(38, $codigo);
	$stmt->bindParam(39, $bandera);
	$stmt->bindParam(40, $docelectronico);
    
	$codmesa = limpiar("0");
	$tipodocumento = limpiar("0");
	$codcaja = limpiar("0");
	$codfactura = limpiar("0");
	$codserie = limpiar("0");
	$codautorizacion = limpiar("0");
	$codcliente = limpiar($_POST["codcliente"]);
	$subtotalivasi = limpiar($_POST["txtsubtotal"]);
	$subtotalivano = limpiar($_POST["txtsubtotal2"]);
	$iva = limpiar($_POST["iva"]);
	$totaliva = limpiar($_POST["txtIva"]);
	$descontado = limpiar($_POST["txtdescontado"]);
	$descuento = limpiar($_POST["descuento"]);
	$totaldescuento = limpiar($_POST["txtDescuento"]);
	$totalpago = limpiar($_POST["txtTotal"]);
	$totalpago2 = limpiar($_POST["txtTotalCompra"]);
    $creditopagado = limpiar("0.00");
    $montodelivery = limpiar("0.00");
    $tipopago = limpiar("0");
    $formapago = limpiar("0");
    $montopagado = limpiar("0.00");
    $formapago2 = limpiar("0");
    $montopagado2 = limpiar("0.00");
    $formapropina = limpiar("0");
	$montopropina = limpiar("0.00");
    $montodevuelto = limpiar("0.00");
    $fechavencecredito = limpiar("0000-00-00");
    $fechapagado = limpiar("0000-00-00");
    $statusventa = limpiar("0");
    $statuspago = limpiar("1");
    $fechaventa = limpiar($fecha);
	$delivery = limpiar("1");
	$repartidor = limpiar($_POST["tipopedido"]=="EXTERNO" ? decrypt($_POST['repartidor']) : "0");
	$entregado = limpiar($_POST["tipopedido"]=="EXTERNO" ? "1" : "0");
	$observaciones = limpiar("0");
	$codigo = limpiar($_SESSION["codigo"]);
	$bandera = limpiar("0");
	$docelectronico = limpiar("0");
	$stmt->execute();

	$this->dbh->beginTransaction();
	$detalle = $_SESSION["CarritoVenta"];
	for($i=0;$i<count($detalle);$i++){

	$query = "INSERT INTO detalleventas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codpedido);
	$stmt->bindParam(2, $codventa);
    $stmt->bindParam(3, $idproducto);
    $stmt->bindParam(4, $codproducto);
    $stmt->bindParam(5, $producto);
    $stmt->bindParam(6, $codcategoria);
	$stmt->bindParam(7, $cantidad);
	$stmt->bindParam(8, $preciocompra);
	$stmt->bindParam(9, $precioventa);
	$stmt->bindParam(10, $ivaproducto);
	$stmt->bindParam(11, $descproducto);
	$stmt->bindParam(12, $valortotal);
	$stmt->bindParam(13, $totaldescuentov);
	$stmt->bindParam(14, $valorneto);
	$stmt->bindParam(15, $valorneto2);
	$stmt->bindParam(16, $detallesobservaciones);
	$stmt->bindParam(17, $tipo);
	
	$idproducto = limpiar($detalle[$i]['id']);
	$codproducto = limpiar($detalle[$i]['txtCodigo']);
	$producto = limpiar($detalle[$i]['producto']);
	$codcategoria = limpiar($detalle[$i]['codcategoria']);
	$cantidad = number_format($detalle[$i]['cantidad'], 2, '.', '');
	$preciocompra = limpiar($detalle[$i]['precio']);
	$precioventa = limpiar($detalle[$i]['precio2']);
	$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
	$descproducto = limpiar($detalle[$i]['descproducto']);
	$descuento = $detalle[$i]['descproducto']/100;
	$valortotal = number_format($detalle[$i]['precio2']*$detalle[$i]['cantidad'], 2, '.', '');
	$totaldescuentov = number_format($valortotal*$descuento, 2, '.', '');
    $valorneto = number_format($valortotal-$totaldescuentov, 2, '.', '');
	$valorneto2 = number_format($detalle[$i]['precio']*$detalle[$i]['cantidad'], 2, '.', '');
    $detallesobservaciones = limpiar("");
	$tipo = limpiar($detalle[$i]['tipo']);
	$stmt->execute();


	$query = "INSERT INTO detallepedidos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codpedido);
	$stmt->bindParam(2, $pedido);
	$stmt->bindParam(3, $codventa);
    $stmt->bindParam(4, $idproducto);
	$stmt->bindParam(5, $codproducto);
	$stmt->bindParam(6, $producto);
	$stmt->bindParam(7, $codcategoria);
	$stmt->bindParam(8, $cantidad);
	$stmt->bindParam(9, $precioventa);
	$stmt->bindParam(10, $ivaproducto);
	$stmt->bindParam(11, $descproducto);
	$stmt->bindParam(12, $valortotal);
	$stmt->bindParam(13, $totaldescuentov);
	$stmt->bindParam(14, $valorneto);
	$stmt->bindParam(15, $observacionespedido);
	$stmt->bindParam(16, $cocinero);
	$stmt->bindParam(17, $fechapedido);
	$stmt->bindParam(18, $fechaentrega);
	$stmt->bindParam(19, $tipo);

	$pedido = limpiar("1");
	$idproducto = limpiar($detalle[$i]['id']);
	$codproducto = limpiar($detalle[$i]['txtCodigo']);
	$producto = limpiar($detalle[$i]['producto']);
	$codcategoria = limpiar($detalle[$i]['codcategoria']);
	$cantidad = number_format($detalle[$i]['cantidad'], 2, '.', '');
	$precioventa = limpiar($detalle[$i]['precio2']);
	$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
	$descproducto = limpiar($detalle[$i]['descproducto']);
	$descuento = $detalle[$i]['descproducto']/100;
	$valortotal = number_format($detalle[$i]['precio2']*$detalle[$i]['cantidad'], 2, '.', '');
	$totaldescuentov = number_format($valortotal*$descuento, 2, '.', '');
    $valorneto = number_format($valortotal-$totaldescuentov, 2, '.', '');
    $observacionespedido = limpiar($detalle[$i]['observacion'] == ", " ? "" : $detalle[$i]['observacion']);
	$cocinero = limpiar('1');
	$fechapedido = limpiar($fecha);
	$fechaentrega = limpiar("0000-00-00");
	$tipo = limpiar($detalle[$i]['tipo']);
	$stmt->execute();

	if(limpiar($detalle[$i]['tipo']) == 1){

    ############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################		

		############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################
		$sql = "SELECT existencia, controlstockp FROM productos WHERE codproducto = '".limpiar($detalle[$i]['txtCodigo'])."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$existenciaproductobd = $row['existencia'];
		$controlproductobd = $row['controlstockp'];
		############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################

		if($controlproductobd == 1){

		    ##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
			$sql = " UPDATE productos set "
				  ." existencia = ? "
				  ." WHERE "
				  ." codproducto = '".limpiar($detalle[$i]['txtCodigo'])."';
				   ";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $existencia);
			$cantventa = number_format($detalle[$i]['cantidad'], 2, '.', '');
			$existencia = number_format($existenciaproductobd-$cantventa, 2, '.', '');
			$stmt->execute();
			##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################

			############## REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
	        $query = "INSERT INTO kardex_productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $codventa);
			$stmt->bindParam(2, $codcliente);
			$stmt->bindParam(3, $codproducto);
			$stmt->bindParam(4, $movimiento);
			$stmt->bindParam(5, $entradas);
			$stmt->bindParam(6, $salidas);
			$stmt->bindParam(7, $devolucion);
			$stmt->bindParam(8, $stockactual);
			$stmt->bindParam(9, $ivaproducto);
			$stmt->bindParam(10, $descproducto);
			$stmt->bindParam(11, $precio);
			$stmt->bindParam(12, $documento);
			$stmt->bindParam(13, $fechakardex);		

			$codcliente = limpiar($_POST["codcliente"]);
			$codproducto = limpiar($detalle[$i]['txtCodigo']);
			$movimiento = limpiar("SALIDAS");
			$entradas = limpiar("0");
			$salidas= number_format($detalle[$i]['cantidad'], 2, '.', '');
			$devolucion = limpiar("0");
			$stockactual = number_format($existenciaproductobd-$detalle[$i]['cantidad'], 2, '.', '');
			$precio = limpiar($detalle[$i]['precio2']);
			$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
			$descproducto = limpiar($detalle[$i]['descproducto']);
			$documento = limpiar("PEDIDO EN DELIVERY");
			$fechakardex = limpiar(date("Y-m-d"));
			$stmt->execute();
		}
	############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################		

    } else {

   	############################### PROCESO PARA VERIFICAR LOS COMBOS ######################################		

		############## VERIFICO LA EXISTENCIA DEL COMBO EN ALMACEN #################
		$sql = "SELECT existencia FROM combos WHERE codcombo = '".limpiar($detalle[$i]['txtCodigo'])."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$existenciacombobd = $row['existencia'];
		############## VERIFICO LA EXISTENCIA DEL COMBO EN ALMACEN #################

	    ##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
		$sql = " UPDATE combos set "
			  ." existencia = ? "
			  ." where "
			  ." codcombo = '".limpiar($detalle[$i]['txtCodigo'])."';
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$cantventa = number_format($detalle[$i]['cantidad'], 2, '.', '');
		$existencia = number_format($existenciacombobd-$cantventa, 2, '.', '');
		$stmt->execute();
		##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################

		############## REGISTRAMOS LOS DATOS DE COMBOS EN KARDEX ###################
	    $query = "INSERT INTO kardex_combos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codventa);
		$stmt->bindParam(2, $codcliente);
		$stmt->bindParam(3, $codcombo);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivacombo);
		$stmt->bindParam(10, $desccombo);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);		

		$codcliente = limpiar($_POST["codcliente"]);
		$codcombo = limpiar($detalle[$i]['txtCodigo']);
		$movimiento = limpiar("SALIDAS");
		$entradas = limpiar("0");
		$salidas= limpiar($detalle[$i]['cantidad']);
		$devolucion = limpiar("0");
		$stockactual = number_format($existenciacombobd-$detalle[$i]['cantidad'], 2, '.', '');
		$precio = limpiar($detalle[$i]['precio2']);
		$ivacombo = limpiar($detalle[$i]['ivaproducto']);
		$desccombo = limpiar($detalle[$i]['descproducto']);
		$documento = limpiar("PEDIDO EN MESA");
		$fechakardex = limpiar(date("Y-m-d"));
		$stmt->execute();
		############## REGISTRAMOS LOS DATOS DE COMBOS EN KARDEX ###################

   ############################### PROCESO PARA VERIFICAR LOS COMBOS ######################################
   }


   ############################### PROCESO PARA VERIFICAR LOS INGREDIENTES ######################################	

	    ############## VERIFICO SSI EL PRODUCTO TIENE INGREDIENTES RELACIONADOS #################
	    $sql = "SELECT * FROM productosxingredientes WHERE codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(limpiar($detalle[$i]['txtCodigo'])));
		$num = $stmt->rowCount();
        if($num>0) {  

        	$sql = "SELECT * FROM productosxingredientes LEFT JOIN ingredientes ON productosxingredientes.codingrediente = ingredientes.codingrediente WHERE productosxingredientes.codproducto IN ('".$detalle[$i]['txtCodigo']."')";
        	foreach ($this->dbh->query($sql) as $row)
		    { 
			   $this->p[] = $row;

			   //$codproducto = $row['codproducto'];
			   $cantracionbd = ($row['cantracion'] == "" ? "0" : $row['cantracion']);
			   $codingredientebd = $row['codingrediente'];
			   $cantingredientebd = $row['cantingrediente'];
			   $precioventaingredientebd = $row['precioventa'];
			   $ivaingredientebd = $row['ivaingrediente'];
			   $descingredientebd = $row['descingrediente'];
		       $controlingredientebd = $row['controlstocki'];

		    if($controlingredientebd == 1){

			   ############## ACTUALIZO LOS DATOS DEL INGREDIENTE #################
			   $update = "UPDATE ingredientes set "
			   ." cantingrediente = ? "
			   ." WHERE "
			   ." codingrediente = ?;
			   ";
			   $stmt = $this->dbh->prepare($update);
			   $stmt->bindParam(1, $cantidadracion);
			   $stmt->bindParam(2, $codingredientebd);

			   $racion = number_format($cantracionbd*$detalle[$i]['cantidad'], 2, '.', '');
			   $cantidadracion = number_format($cantingredientebd-$racion, 2, '.', '');
			   $stmt->execute();
			   ############## ACTUALIZO LOS DATOS DEL INGREDIENTE #################

			   ############## REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
			   $query = "INSERT INTO kardex_ingredientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
			   $stmt = $this->dbh->prepare($query);
			   $stmt->bindParam(1, $codventa);
			   $stmt->bindParam(2, $codcliente);
			   $stmt->bindParam(3, $codingrediente);
			   $stmt->bindParam(4, $movimiento);
			   $stmt->bindParam(5, $entradas);
			   $stmt->bindParam(6, $salidas);
			   $stmt->bindParam(7, $devolucion);
			   $stmt->bindParam(8, $stockactual);
			   $stmt->bindParam(9, $ivaingrediente);
			   $stmt->bindParam(10, $descingrediente);
			   $stmt->bindParam(11, $precio);
			   $stmt->bindParam(12, $documento);
			   $stmt->bindParam(13, $fechakardex);		

			   $codcliente = limpiar($_POST["codcliente"]);
			   $codingrediente = limpiar($codingredientebd);
			   $movimiento = limpiar("SALIDAS");
			   $entradas = limpiar("0");
			   $salidas= limpiar($racion);
			   $devolucion = limpiar("0");
			   $stockactual = number_format($cantingredientebd-$racion, 2, '.', '');
			   $precio = limpiar($precioventaingredientebd);
			   $ivaingrediente = limpiar($ivaingredientebd);
			   $descingrediente = limpiar($descingredientebd);
			   $documento = limpiar("PEDIDO EN DELIVERY");
			   $fechakardex = limpiar(date("Y-m-d"));
			   $stmt->execute();
			}
		}
	}//fin de consulta de ingredientes de productos	

    ############################### PROCESO PARA VERIFICAR LOS INGREDIENTES ######################################	

      }
		
	####################### DESTRUYO LA VARIABLE DE SESSION #####################
	unset($_SESSION["CarritoVenta"]);
    $this->dbh->commit();

echo "<span class='fa fa-check-square-o'></span> EL PEDIDO EN DELIVERY, FUE REGISTRADO EXITOSAMENTE <a href='reportepdf?codpedido=".encrypt($codpedido)."&pedido=".encrypt($pedido)."&codventa=".encrypt($codventa)."&tipo=".encrypt("COMANDA")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR COMANDA</strong></font color></a></div>";

echo "<script>window.open('reportepdf?codpedido=".encrypt($codpedido)."&pedido=".encrypt($pedido)."&codventa=".encrypt($codventa)."&tipo=".encrypt("COMANDA")."', '_blank');</script>";
	exit;
}
######################### FUNCION REGISTRAR NUEVO PEDIDO EN DELIVERY ############################

############################ FUNCION AGREGAR PEDIDOS EN DELIVERY ##############################
public function AgregaPedidoDelivery()
{
	self::SetNames();
	if(empty($_SESSION["CarritoVenta"]))
	{
		echo "1";
		exit;
	}

	############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA ############
	$v = $_SESSION["CarritoVenta"];
	for($i=0;$i<count($v);$i++){

		if(limpiar($v[$i]['tipo']) == 1){

		    $sql = "SELECT existencia FROM productos WHERE codproducto = '".$v[$i]['txtCodigo']."'";
		    foreach ($this->dbh->query($sql) as $row)
		    {
			$this->p[] = $row;
		    }
		
		    $existenciadb = $row['existencia'];
		    $cantidad = $v[$i]['cantidad'];

	        if ($cantidad > $existenciadb) 
	        { 
		       echo "2";
		       exit;
	        }

	    } else { 

		    $sql = "SELECT existencia FROM combos WHERE codcombo = '".$v[$i]['txtCodigo']."'";
		    foreach ($this->dbh->query($sql) as $row)
		    {
			$this->p[] = $row;
		    }
		
		    $existenciadb = $row['existencia'];
		    $cantidad = $v[$i]['cantidad'];

	        if ($cantidad > $existenciadb) 
	        { 
		       echo "2";
		       exit;
	        }
	    }
	}
	############ VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA ############

    if(limpiar($_POST["tipopedido"]=="EXTERNO") && limpiar($_POST["repartidor"] == ""))
	{
		echo "3";
		exit;
	}
    else if(limpiar($_POST["tipopedido"]=="EXTERNO") && limpiar($_POST["codcliente"] == "0"))
	{
		echo "4";
		exit;
	}

	##################### AGREGAMOS EL NUMERO DE PEDIDO A LA VENTA #######################
	$sql = "SELECT pedido FROM detallepedidos WHERE codpedido = '".limpiar(decrypt($_POST['codpedido']))."' AND codventa = '".limpiar(decrypt($_POST['codventa']))."' ORDER BY coddetallepedido DESC LIMIT 1";
    foreach ($this->dbh->query($sql) as $row){

    $nuevopedido=$row["pedido"];

    }
	
    $dig = $nuevopedido + 1;
    $pedido = $dig;
	##################### AGREGAMOS EL NUMERO DE PEDIDO A LA VENTA #######################

	$this->dbh->beginTransaction();
	$detalle = $_SESSION["CarritoVenta"];
	for($i=0;$i<count($detalle);$i++){

	############ REVISAMOS QUE EL PRODUCTO NO ESTE EN LA BD ###################
    $sql = "SELECT 
    codpedido, 
    codproducto 
    FROM detalleventas 
    WHERE codpedido = '".limpiar(decrypt($_POST['codpedido']))."' 
    AND codventa = '".limpiar(decrypt($_POST['codventa']))."' 
    AND codproducto = '".limpiar($detalle[$i]['txtCodigo'])."'";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num == 0)
	{

	$query = "INSERT INTO detalleventas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codpedido);
	$stmt->bindParam(2, $codventa);
    $stmt->bindParam(3, $idproducto);
    $stmt->bindParam(4, $codproducto);
    $stmt->bindParam(5, $producto);
    $stmt->bindParam(6, $codcategoria);
	$stmt->bindParam(7, $cantidad);
	$stmt->bindParam(8, $preciocompra);
	$stmt->bindParam(9, $precioventa);
	$stmt->bindParam(10, $ivaproducto);
	$stmt->bindParam(11, $descproducto);
	$stmt->bindParam(12, $valortotal);
	$stmt->bindParam(13, $totaldescuentov);
	$stmt->bindParam(14, $valorneto);
	$stmt->bindParam(15, $valorneto2);
	$stmt->bindParam(16, $detallesobservaciones);
	$stmt->bindParam(17, $tipo);
	
	$codpedido = limpiar(decrypt($_POST["codpedido"]));
	$codventa = limpiar(decrypt($_POST["codventa"]));
	$idproducto = limpiar($detalle[$i]['id']);
	$codproducto = limpiar($detalle[$i]['txtCodigo']);
	$producto = limpiar($detalle[$i]['producto']);
	$codcategoria = limpiar($detalle[$i]['codcategoria']);
	$cantidad = number_format($detalle[$i]['cantidad'], 2, '.', '');
	$preciocompra = limpiar($detalle[$i]['precio']);
	$precioventa = limpiar($detalle[$i]['precio2']);
	$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
	$descproducto = limpiar($detalle[$i]['descproducto']);
	$descuento = $detalle[$i]['descproducto']/100;
	$valortotal = number_format($detalle[$i]['precio2']*$detalle[$i]['cantidad'], 2, '.', '');
	$totaldescuentov = number_format($valortotal*$descuento, 2, '.', '');
    $valorneto = number_format($valortotal-$totaldescuentov, 2, '.', '');
	$valorneto2 = number_format($detalle[$i]['precio']*$detalle[$i]['cantidad'], 2, '.', '');
	$detallesobservaciones = limpiar("");
	$tipo = limpiar($detalle[$i]['tipo']);
	$stmt->execute();

	$query = "INSERT INTO detallepedidos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codpedido);
	$stmt->bindParam(2, $pedido);
	$stmt->bindParam(3, $codventa);
    $stmt->bindParam(4, $idproducto);
	$stmt->bindParam(5, $codproducto);
	$stmt->bindParam(6, $producto);
	$stmt->bindParam(7, $codcategoria);
	$stmt->bindParam(8, $cantidad);
	$stmt->bindParam(9, $precioventa);
	$stmt->bindParam(10, $ivaproducto);
	$stmt->bindParam(11, $descproducto);
	$stmt->bindParam(12, $valortotal);
	$stmt->bindParam(13, $totaldescuentov);
	$stmt->bindParam(14, $valorneto);
	$stmt->bindParam(15, $observacionespedido);
	$stmt->bindParam(16, $cocinero);
	$stmt->bindParam(17, $fechapedido);
	$stmt->bindParam(18, $fechaentrega);
	$stmt->bindParam(19, $tipo);

	$codpedido = limpiar(decrypt($_POST["codpedido"]));
	$codventa = limpiar(decrypt($_POST["codventa"]));
	$idproducto = limpiar($detalle[$i]['id']);
	$codproducto = limpiar($detalle[$i]['txtCodigo']);
	$producto = limpiar($detalle[$i]['producto']);
	$codcategoria = limpiar($detalle[$i]['codcategoria']);
	$cantidad = number_format($detalle[$i]['cantidad'], 2, '.', '');
	$precioventa = limpiar($detalle[$i]['precio2']);
	$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
	$descproducto = limpiar($detalle[$i]['descproducto']);
	$descuento = $detalle[$i]['descproducto']/100;
	$valortotal = number_format($detalle[$i]['precio2']*$detalle[$i]['cantidad'], 2, '.', '');
	$totaldescuentov = number_format($valortotal*$descuento, 2, '.', '');
    $valorneto = number_format($valortotal-$totaldescuentov, 2, '.', '');
    $observacionespedido = limpiar($detalle[$i]['observacion'] == ", " ? "" : $detalle[$i]['observacion']);
	$cocinero = limpiar('1');
	$fechapedido = limpiar(date("Y-m-d H:i:s"));
	$fechaentrega = limpiar("0000-00-00");
	$tipo = limpiar($detalle[$i]['tipo']);
	$stmt->execute();

    if(limpiar($detalle[$i]['tipo']) == 1){

    ############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################		

		############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################
		$sql = "SELECT 
		existencia, 
		controlstockp 
		FROM productos 
		WHERE codproducto = '".limpiar($detalle[$i]['txtCodigo'])."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$existenciaproductobd = $row['existencia'];
		$controlproductobd = $row['controlstockp'];
		############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################

		if($controlproductobd == 1){

			##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
			$sql = " UPDATE productos set "
				  ." existencia = ? "
				  ." WHERE "
				  ." codproducto = '".limpiar($detalle[$i]['txtCodigo'])."';
				   ";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $existencia);
			$cantventa = number_format($detalle[$i]['cantidad'], 2, '.', '');
			$existencia = number_format($existenciaproductobd-$cantventa, 2, '.', '');
			$stmt->execute();
			##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################

			############## REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
	        $query = "INSERT INTO kardex_productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $codventa);
			$stmt->bindParam(2, $codcliente);
			$stmt->bindParam(3, $codproducto);
			$stmt->bindParam(4, $movimiento);
			$stmt->bindParam(5, $entradas);
			$stmt->bindParam(6, $salidas);
			$stmt->bindParam(7, $devolucion);
			$stmt->bindParam(8, $stockactual);
			$stmt->bindParam(9, $ivaproducto);
			$stmt->bindParam(10, $descproducto);
			$stmt->bindParam(11, $precio);
			$stmt->bindParam(12, $documento);
			$stmt->bindParam(13, $fechakardex);		

			$codventa = limpiar(decrypt($_POST["codventa"]));
			$codcliente = limpiar($_POST["codcliente"]);
			$codproducto = limpiar($detalle[$i]['txtCodigo']);
			$movimiento = limpiar("SALIDAS");
			$entradas = limpiar("0");
			$salidas= number_format($detalle[$i]['cantidad'], 2, '.', '');
			$devolucion = limpiar("0");
			$stockactual = number_format($existenciaproductobd-$detalle[$i]['cantidad'], 2, '.', '');
			$precio = limpiar($detalle[$i]['precio2']);
			$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
			$descproducto = limpiar($detalle[$i]['descproducto']);
			$documento = limpiar("PEDIDO EN DELIVERY");
			$fechakardex = limpiar(date("Y-m-d"));
			$stmt->execute();
			############## REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
		}
    ############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################	

    } else {

    ############################### PROCESO PARA VERIFICAR LOS COMBOS ######################################		

		############## VERIFICO LA EXISTENCIA DEL COMBOS EN ALMACEN #################
		$sql = "SELECT existencia FROM combos WHERE codcombo = '".limpiar($detalle[$i]['txtCodigo'])."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$existenciacombobd = ($row['existencia']== "" ? "0" : $row['existencia']);
		############## VERIFICO LA EXISTENCIA DEL COMBOS EN ALMACEN #################

		##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
		$sql = " UPDATE combos set "
			  ." existencia = ? "
			  ." where "
			  ." codcombo = '".limpiar($detalle[$i]['txtCodigo'])."';
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$cantventa = number_format($detalle[$i]['cantidad'], 2, '.', '');
		$existencia = number_format($existenciacombobd-$cantventa, 2, '.', '');
		$stmt->execute();
		##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################

		############## REGISTRAMOS LOS DATOS DE COMBOS EN KARDEX ###################
	    $query = "INSERT INTO kardex_combos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codventa);
		$stmt->bindParam(2, $codcliente);
		$stmt->bindParam(3, $codcombo);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivacombo);
		$stmt->bindParam(10, $desccombo);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);		

		$codventa = limpiar($_POST["codventa"]);
		$codcliente = limpiar($_POST["codcliente"]);
		$codcombo = limpiar($detalle[$i]['txtCodigo']);
		$movimiento = limpiar("SALIDAS");
		$entradas = limpiar("0");
		$salidas= limpiar($detalle[$i]['cantidad']);
		$devolucion = limpiar("0");
		$stockactual = number_format($existenciacombobd-$detalle[$i]['cantidad'], 2, '.', '');
		$precio = limpiar($detalle[$i]['precio2']);
		$ivacombo = limpiar($detalle[$i]['ivaproducto']);
		$desccombo = limpiar($detalle[$i]['descproducto']);
		$documento = limpiar("PEDIDO EN MESA");
		$fechakardex = limpiar(date("Y-m-d"));
		$stmt->execute();
		############## REGISTRAMOS LOS DATOS DE COMBOS EN KARDEX ###################

    ############################### PROCESO PARA VERIFICAR LOS COMBOS ######################################

    }	


    ############################### PROCESO PARA VERIFICAR LOS INGREDIENTES ######################################	

	    ############## VERIFICO SI EL PRODUCTO TIENE INGREDIENTES RELACIONADOS #################
	    $sql = "SELECT * FROM productosxingredientes WHERE codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(limpiar($detalle[$i]['txtCodigo'])));
		$num = $stmt->rowCount();
        if($num>0) {  

        	$sql = "SELECT * FROM productosxingredientes LEFT JOIN ingredientes ON productosxingredientes.codingrediente = ingredientes.codingrediente WHERE productosxingredientes.codproducto IN ('".$detalle[$i]['txtCodigo']."')";
        	foreach ($this->dbh->query($sql) as $row)
		    { 
			   $this->p[] = $row;

			   $cantracionbd = $row['cantracion'];
			   $codingredientebd = $row['codingrediente'];
			   $cantingredientebd = $row['cantingrediente'];
			   $precioventaingredientebd = $row['precioventa'];
			   $ivaingredientebd = $row['ivaingrediente'];
			   $descingredientebd = $row['descingrediente'];
		       $controlingredientebd = $row['controlstocki'];

		    if($controlingredientebd == 1){

			   ############## ACTUALIZO LOS DATOS DEL INGREDIENTE #################
			   $update = "UPDATE ingredientes set "
			   ." cantingrediente = ? "
			   ." WHERE "
			   ." codingrediente = ?;
			   ";
			   $stmt = $this->dbh->prepare($update);
			   $stmt->bindParam(1, $cantidadracion);
			   $stmt->bindParam(2, $codingredientebd);

			   $racion = number_format($cantracionbd*$detalle[$i]['cantidad'], 2, '.', '');
			   $cantidadracion = number_format($cantingredientebd-$racion, 2, '.', '');
			   $stmt->execute();
			   ############## ACTUALIZO LOS DATOS DEL INGREDIENTE #################

			   ############## REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
			   $query = "INSERT INTO kardex_ingredientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
			   $stmt = $this->dbh->prepare($query);
			   $stmt->bindParam(1, $codventa);
			   $stmt->bindParam(2, $codcliente);
			   $stmt->bindParam(3, $codingrediente);
			   $stmt->bindParam(4, $movimiento);
			   $stmt->bindParam(5, $entradas);
			   $stmt->bindParam(6, $salidas);
			   $stmt->bindParam(7, $devolucion);
			   $stmt->bindParam(8, $stockactual);
			   $stmt->bindParam(9, $ivaingrediente);
			   $stmt->bindParam(10, $descingrediente);
			   $stmt->bindParam(11, $precio);
			   $stmt->bindParam(12, $documento);
			   $stmt->bindParam(13, $fechakardex);		

			   $codventa = limpiar(decrypt($_POST["codventa"]));
			   $codcliente = limpiar($_POST["codcliente"]);
			   $codingrediente = limpiar($codingredientebd);
			   $movimiento = limpiar("SALIDAS");
			   $entradas = limpiar("0");
			   $salidas= limpiar($racion);
			   $devolucion = limpiar("0");
			   $stockactual = number_format($cantingredientebd-$racion, 2, '.', '');
			   $precio = limpiar($precioventaingredientebd);
			   $ivaingrediente = limpiar($ivaingredientebd);
			   $descingrediente = limpiar($descingredientebd);
			   $documento = limpiar("PEDIDO EN DELIVERY");
			   $fechakardex = limpiar(date("Y-m-d"));
			   $stmt->execute();
			}
		}
	}//fin de consulta de ingredientes de productos		

############################### PROCESO PARA VERIFICAR LOS INGREDIENTES ######################################	

		} else {

		##################### VERIFICO LA CANTIDAD YA REGISTRADA DEL PRODUCTO VENDIDO ####################
		$sql = "SELECT cantventa 
		FROM detalleventas 
		WHERE codpedido = '".limpiar(decrypt($_POST['codpedido']))."' 
		AND codventa = '".limpiar(decrypt($_POST['codventa']))."' 
		AND codproducto = '".limpiar($detalle[$i]['txtCodigo'])."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$cantidad = $row['cantventa'];
		##################### VERIFICO LA CANTIDAD YA REGISTRADA DEL PRODUCTO VENDIDO ####################

	  	$query = "UPDATE detalleventas set"
		." cantventa = ?, "
		." descproducto = ?, "
		." valortotal = ?, "
		." totaldescuentov = ?, "
		." valorneto = ?, "
		." valorneto2 = ? "
		." WHERE "
		." codpedido = ? AND codventa = ? AND codproducto = ?;
		";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $cantventa);
		$stmt->bindParam(2, $descproducto);
		$stmt->bindParam(3, $valortotal);
		$stmt->bindParam(4, $totaldescuentov);
		$stmt->bindParam(5, $valorneto);
		$stmt->bindParam(6, $valorneto2);
		$stmt->bindParam(7, $codpedido);
		$stmt->bindParam(8, $codventa);
		$stmt->bindParam(9, $codproducto);

		$cantventa = number_format($detalle[$i]['cantidad']+$cantidad, 2, '.', '');
		$preciocompra = limpiar($detalle[$i]['precio']);
		$precioventa = limpiar($detalle[$i]['precio2']);
		$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
		$descproducto = limpiar($detalle[$i]['descproducto']);
		$descuento = $detalle[$i]['descproducto']/100;
		$valortotal = number_format($detalle[$i]['precio2'] * $cantventa, 2, '.', '');//aqui
		$totaldescuentov = number_format($valortotal * $descuento, 2, '.', '');
		$valorneto = number_format($valortotal - $totaldescuentov, 2, '.', '');
		$valorneto2 = number_format($detalle[$i]['precio'] * $cantventa, 2, '.', '');//aqui
		$codpedido = limpiar(decrypt($_POST["codpedido"]));
		$codventa = limpiar(decrypt($_POST["codventa"]));
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$stmt->execute();

		$query = "INSERT INTO detallepedidos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codpedido);
		$stmt->bindParam(2, $pedido);
		$stmt->bindParam(3, $codventa);
        $stmt->bindParam(4, $idproducto);
		$stmt->bindParam(5, $codproducto);
		$stmt->bindParam(6, $producto);
		$stmt->bindParam(7, $codcategoria);
		$stmt->bindParam(8, $cantidad);
		$stmt->bindParam(9, $precioventa);
		$stmt->bindParam(10, $ivaproducto);
		$stmt->bindParam(11, $descproducto);
		$stmt->bindParam(12, $valortotal);
		$stmt->bindParam(13, $totaldescuentov);
		$stmt->bindParam(14, $valorneto);
		$stmt->bindParam(15, $observacionespedido);
		$stmt->bindParam(16, $cocinero);
		$stmt->bindParam(17, $fechapedido);
		$stmt->bindParam(18, $fechaentrega);
	    $stmt->bindParam(19, $tipo);

		$codpedido = limpiar(decrypt($_POST["codpedido"]));
		$codventa = limpiar(decrypt($_POST["codventa"]));
		$idproducto = limpiar($detalle[$i]['id']);
		$codproducto = limpiar($detalle[$i]['txtCodigo']);
		$producto = limpiar($detalle[$i]['producto']);
		$codcategoria = limpiar($detalle[$i]['codcategoria']);
		$cantidad = number_format($detalle[$i]['cantidad'], 2, '.', '');
		$precioventa = limpiar($detalle[$i]['precio2']);
		$ivaproducto = limpiar($detalle[$i]['ivaproducto']);
		$descproducto = limpiar($detalle[$i]['descproducto']);
		$descuento = $detalle[$i]['descproducto']/100;
		$valortotal = number_format($detalle[$i]['precio2']*$detalle[$i]['cantidad'], 2, '.', '');
		$totaldescuentov = number_format($valortotal*$descuento, 2, '.', '');
	    $valorneto = number_format($valortotal-$totaldescuentov, 2, '.', '');
	    $observacionespedido = limpiar($detalle[$i]['observacion'] == ", " ? "" : $detalle[$i]['observacion']);
		$cocinero = limpiar('1');
		$fechapedido = limpiar(date("Y-m-d H:i:s"));
		$fechaentrega = limpiar("0000-00-00");
	    $tipo = limpiar($detalle[$i]['tipo']);
		$stmt->execute();

	if(limpiar($detalle[$i]['tipo']) == 1){

    ############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################

		############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################
		$sql = "SELECT 
		existencia, 
		controlstockp 
		FROM productos 
		WHERE codproducto = '".limpiar($detalle[$i]['txtCodigo'])."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$existenciaproductobd = $row['existencia'];
		$controlproductobd = $row['controlstockp'];
		############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################	

		if($controlproductobd == 1){	

			##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
			$sql = " UPDATE productos set "
				  ." existencia = ? "
				  ." WHERE "
				  ." codproducto = '".limpiar($detalle[$i]['txtCodigo'])."';
				   ";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $existencia);
			$cantventa = number_format($detalle[$i]['cantidad'], 2, '.', '');
			$existencia = number_format($existenciaproductobd-$cantventa, 2, '.', '');
			$stmt->execute();
			##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################

			########## ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX ###################
			$sql3 = " UPDATE kardex_productos set "
			      ." salidas = ?, "
			      ." stockactual = ? "
				  ." WHERE "
				  ." codproceso = '".limpiar(decrypt($_POST["codventa"]))."' and codproducto = '".limpiar($detalle[$i]['txtCodigo'])."';
				   ";
			$stmt = $this->dbh->prepare($sql3);
			$stmt->bindParam(1, $salidas);
			$stmt->bindParam(2, $stockactual);
			
			$salidas = number_format($detalle[$i]['cantidad']+$cantidad, 2, '.', '');
			$stockactual = number_format($existenciaproductobd-$cantventa, 2, '.', '');
			$stmt->execute();
			########## ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX ###################
		}
	############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################	

    } else {

    ############################### PROCESO PARA VERIFICAR LOS COMBOS ######################################

		############## VERIFICO LA EXISTENCIA DEL COMBOS EN ALMACEN #################
		$sql = "SELECT 
		existencia 
		FROM combos 
		WHERE codcombo = '".limpiar($detalle[$i]['txtCodigo'])."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$existenciacombobd = ($row['existencia']== "" ? "0" : $row['existencia']);
		############## VERIFICO LA EXISTENCIA DEL COMBOS EN ALMACEN #################		

		##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
		$sql = " UPDATE combos set "
			  ." existencia = ? "
			  ." where "
			  ." codcombo = '".limpiar($detalle[$i]['txtCodigo'])."';
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$cantventa = number_format($detalle[$i]['cantidad'], 2, '.', '');
		$existencia = number_format($existenciacombobd-$cantventa, 2, '.', '');
		$stmt->execute();
		##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################

		########## ACTUALIZAMOS LOS DATOS DEL COMBOS EN KARDEX ###################
		$sql3 = " UPDATE kardex_combos set "
		      ." salidas = ?, "
		      ." stockactual = ? "
			  ." WHERE "
			  ." codproceso = '".limpiar(decrypt($_POST["codventa"]))."' and codcombo = '".limpiar($detalle[$i]['txtCodigo'])."';
			   ";
		$stmt = $this->dbh->prepare($sql3);
		$stmt->bindParam(1, $salidas);
		$stmt->bindParam(2, $stockactual);
		
		$salidas = number_format($detalle[$i]['cantidad']+$cantidad, 2, '.', '');
		$stockactual = number_format($existenciacombobd-$cantventa, 2, '.', '');
		$stmt->execute();
		########## ACTUALIZAMOS LOS DATOS DEL COMBOS EN KARDEX ###################

    ############################### PROCESO PARA VERIFICAR LOS COMBOS ######################################	

    }	


    ############################### PROCESO PARA VERIFICAR LOS INGREDIENTES ######################################	

		############## VERIFICO SSI EL PRODUCTO TIENE INGREDIENTES RELACIONADOS #################
	    $sql = "SELECT * FROM productosxingredientes WHERE codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(limpiar($detalle[$i]['txtCodigo'])));
		$num = $stmt->rowCount();
        if($num>0) {  

        	$sql = "SELECT * FROM productosxingredientes LEFT JOIN ingredientes ON productosxingredientes.codingrediente = ingredientes.codingrediente WHERE productosxingredientes.codproducto IN ('".$detalle[$i]['txtCodigo']."')";
        	foreach ($this->dbh->query($sql) as $row)
		    { 
			   $this->p[] = $row;

			   $cantracionbd = $row['cantracion'];
			   $codingredientebd = $row['codingrediente'];
			   $cantingredientebd = $row['cantingrediente'];
			   $precioventaingredientebd = $row['precioventa'];
			   $ivaingredientebd = $row['ivaingrediente'];
			   $descingredientebd = $row['descingrediente'];
		       $controlingredientebd = $row['controlstocki'];

		    if($controlingredientebd == 1){

			   ############## ACTUALIZO LOS DATOS DEL INGREDIENTE #################
			   $update = "UPDATE ingredientes set "
			   ." cantingrediente = ? "
			   ." WHERE "
			   ." codingrediente = ?;
			   ";
			   $stmt = $this->dbh->prepare($update);
			   $stmt->bindParam(1, $cantidadracion);
			   $stmt->bindParam(2, $codingredientebd);

			   $racion = number_format($cantracionbd*$detalle[$i]['cantidad'], 2, '.', '');
			   $cantidadracion = number_format($cantingredientebd-$racion, 2, '.', '');
			   $stmt->execute();
			   ############## ACTUALIZO LOS DATOS DEL INGREDIENTE #################

			   ############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################
			   $sql = "SELECT salidas FROM kardex_ingredientes WHERE codproceso = '".limpiar(decrypt($_POST["codventa"]))."' AND codingrediente = '".limpiar($codingredientebd)."'";
			   foreach ($this->dbh->query($sql) as $row)
			   {
			   	$this->p[] = $row;
			   }
			   $salidakardex = $row['salidas'];
		       ############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################	

			   ########## ACTUALIZAMOS LOS DATOS DEL INGREDIENTE EN KARDEX ###################
			   $sql3 = " UPDATE kardex_ingredientes set "
			   ." salidas = ?, "
			   ." stockactual = ? "
			   ." WHERE "
			   ." codproceso = '".limpiar(decrypt($_POST["codventa"]))."' and codingrediente = '".limpiar($codingredientebd)."';
			   ";
			   $stmt = $this->dbh->prepare($sql3);
			   $stmt->bindParam(1, $salidas);
			   $stmt->bindParam(2, $stockactual);

			   $racion = number_format($cantracionbd*$detalle[$i]['cantidad'], 2, '.', '');
			   $salidas = number_format($salidakardex+$racion, 2, '.', '');
			   
			   $substock = number_format($cantracionbd*$detalle[$i]['cantidad'], 2, '.', '');
			   $stockactual = number_format($cantingredientebd-$substock, 2, '.', '');
			   $stmt->execute();
			}
		}
	}//fin de consulta de ingredientes de productos	

############################### PROCESO PARA VERIFICAR LOS INGREDIENTES ######################################	


        }
    }
		
	####################### DESTRUYO LA VARIABLE DE SESSION #####################
	unset($_SESSION["CarritoVenta"]);
    $this->dbh->commit();

    ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############
    $sql3 = "SELECT SUM(totaldescuentov) AS totaldescuentosi, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detalleventas WHERE codpedido = '".limpiar(decrypt($_POST["codpedido"]))."' AND codventa = '".limpiar(decrypt($_POST["codventa"]))."' AND ivaproducto = 'SI'";
    foreach ($this->dbh->query($sql3) as $row3)
    {
    	$this->p[] = $row3;
    }
	$subtotaldescuentosi = ($row3['totaldescuentosi']== "" ? "0.00" : $row3['totaldescuentosi']);
    $subtotalivasi = ($row3['valorneto']== "" ? "0.00" : $row3['valorneto']);
    $subtotalivasi2 = ($row3['valorneto2']== "" ? "0.00" : $row3['valorneto2']);
    ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############

    ############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############
    $sql4 = "SELECT SUM(totaldescuentov) AS totaldescuentono, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detalleventas WHERE codpedido = '".limpiar(decrypt($_POST["codpedido"]))."' AND codventa = '".limpiar(decrypt($_POST["codventa"]))."' AND ivaproducto = 'NO'";
    foreach ($this->dbh->query($sql4) as $row4)
    {
    	$this->p[] = $row4;
    }
	$subtotaldescuentono = ($row4['totaldescuentono']== "" ? "0.00" : $row4['totaldescuentono']);
    $subtotalivano = ($row4['valorneto']== "" ? "0.00" : $row4['valorneto']);
    $subtotalivano2 = ($row4['valorneto2']== "" ? "0.00" : $row4['valorneto2']);
    ############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############

    ############ ACTUALIZO LOS TOTALES EN LA VENTA ##############
    $sql = " UPDATE ventas SET "
    ." codcliente = ?, "
    ." subtotalivasi = ?, "
    ." subtotalivano = ?, "
    ." totaliva = ?, "
	." descontado = ?, "
    ." descuento = ?, "
    ." totaldescuento = ?, "
    ." totalpago = ?, "
    ." totalpago2 = ?, "
    ." repartidor = ?, "
    ." entregado = ? "
    ." WHERE "
    ." codpedido = ? AND codventa = ?;
    ";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(1, $codcliente);
    $stmt->bindParam(2, $subtotalivasi);
    $stmt->bindParam(3, $subtotalivano);
    $stmt->bindParam(4, $totaliva);
	$stmt->bindParam(5, $descontado);
    $stmt->bindParam(6, $descuento);
    $stmt->bindParam(7, $totaldescuento);
    $stmt->bindParam(8, $totalpago);
    $stmt->bindParam(9, $totalpago2);
    $stmt->bindParam(10, $repartidor);
    $stmt->bindParam(11, $entregado);
    $stmt->bindParam(12, $codpedido);
    $stmt->bindParam(13, $codventa);

    $codcliente = limpiar($_POST["codcliente"]);
    $iva = $_POST["iva"]/100;
    $totaliva = number_format($subtotalivasi*$iva, 2, '.', '');
	$descontado = number_format($subtotaldescuentosi+$subtotaldescuentono, 2, '.', '');
    $descuento = limpiar($_POST["descuento"]);
    $txtDescuento = $_POST["descuento"]/100;
    $total = number_format($subtotalivasi+$subtotalivano+$totaliva, 2, '.', '');
    $totaldescuento = number_format($total*$txtDescuento, 2, '.', '');
    $totalpago = number_format($total-$totaldescuento, 2, '.', '');
    $totalpago2 = number_format($subtotalivasi2+$subtotalivano2, 2, '.', '');
	$repartidor = limpiar($_POST["tipopedido"]=="EXTERNO" ? decrypt($_POST['repartidor']) : "0");
	$entregado = limpiar($_POST["tipopedido"]=="EXTERNO" ? "1" : "0");
    $codpedido = limpiar(decrypt($_POST["codpedido"]));
    $codventa = limpiar(decrypt($_POST["codventa"]));
    $stmt->execute();
    ############ ACTUALIZO LOS TOTALES EN LA VENTA ##############

    echo "<span class='fa fa-check-square-o'></span> EL PEDIDO EN DELIVERY FUE AGREGADO EXITOSAMENTE <a href='reportepdf?codpedido=".encrypt($codpedido)."&pedido=".encrypt($pedido)."&codventa=".encrypt($codventa)."&tipo=".encrypt("COMANDA")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR COMANDA</strong></font color></a></div>";

    echo "<script>window.open('reportepdf?codpedido=".encrypt($codpedido)."&pedido=".encrypt($pedido)."&codventa=".encrypt($codventa)."&tipo=".encrypt("COMANDA")."', '_blank');</script>";
	exit;
}
######################### FUNCION AGREGAR PEDIDOS A VENTAS ############################

############################ FUNCION CERRAR PEDIDO EN DELIVERY ##############################
public function CerrarDelivery()
{
	self::SetNames();
	####################### VERIFICO ARQUEO DE CAJA #######################
	$sql = "SELECT * FROM arqueocaja 
	INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	INNER JOIN usuarios ON cajas.codigo = usuarios.codigo 
	WHERE usuarios.codigo = ? AND arqueocaja.statusarqueo = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_SESSION["codigo"]));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "1";
		exit;

	} else {
		
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		$codarqueo = $row['codarqueo'];
		$codcaja = $row['codcaja'];
	}
    ####################### VERIFICO ARQUEO DE CAJA #######################

    if(empty($_POST["tipodocumento"]) or empty($_POST["tipopago"]))
	{
		echo "2";
		exit;
	}
	elseif(limpiar($_POST["txtImporte"]=="") && limpiar($_POST["txtImporte"]==0) && limpiar($_POST["txtImporte"]==0.00))
	{
		echo "3";
		exit;
		
	}

	elseif(isset($_POST['formapago2']) && $_POST["formapago2"] != ""){

		/*if($_POST["txtTotal"] > $_POST["txtAgregado"])
	    {
		   echo "4";
		   exit;
	    }*/
	}

    elseif(limpiar($_POST["tipopedido"]=="EXTERNO") && limpiar($_POST["repartidor"] == ""))
	{
		echo "5";
		exit;
	}
    else if(limpiar($_POST["tipopedido"]=="EXTERNO") && limpiar($_POST["codcliente"] == "0"))
	{
		echo "6";
		exit;
	}
	else if(limpiar($_POST["tipodocumento"]) == "FACTURA" && limpiar($_POST["codcliente"]) == "0"){ 

    	echo "7";
	    exit;
	}

	################### SELECCIONE LOS DATOS DEL CLIENTE ######################
    $sql = "SELECT
    clientes.dnicliente,
    CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
    clientes.girocliente,
    clientes.emailcliente, 
    clientes.tipocliente,
    clientes.limitecredito,
    clientes.id_provincia,
    clientes.id_departamento,
    clientes.direccliente,
    provincias.provincia,
    departamentos.departamento,
    ROUND(SUM(if(pag.montocredito!='0',pag.montocredito,'0.00')), 2) montoactual,
    ROUND(SUM(if(pag.montocredito!='0',clientes.limitecredito-pag.montocredito,clientes.limitecredito)), 2) creditodisponible
    FROM clientes 
    LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento
    LEFT JOIN
       (SELECT
       codcliente, montocredito       
       FROM creditosxclientes) pag ON pag.codcliente = clientes.codcliente
       WHERE clientes.codcliente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar($_POST['codcliente'])));
	$num = $stmt->rowCount();
	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$p[] = $row;
	}
    $tipocliente = ($row['tipocliente'] == "" ? "0" : $row['tipocliente']);
    $dnicliente = ($row['dnicliente'] == "" ? "0" : $row['dnicliente']);
    $nomcliente = ($row['nomcliente'] == "" ? "0" : $row['nomcliente']);
    $girocliente = ($row['girocliente'] == "" ? "0" : $row['girocliente']);
    $emailcliente = $row['emailcliente'];
    $provincia = ($row['id_provincia'] == "" || $row['id_provincia'] == "0" ? "0" : $row['provincia']);
    $departamento = ($row['id_departamento'] == "" || $row['id_provincia'] == "0" ? "0" : $row['departamento']);
    $direccliente = ($row['direccliente'] == "" ? "0" : $row['direccliente']);
    $limitecredito = $row['limitecredito'];
    $montoactual = $row['montoactual'];
    $creditodisponible = $row['creditodisponible'];
    $medioabono = (empty($_POST["medioabono"]) ? "" : $_POST["medioabono"]);
    $montoabono = (empty($_POST["montoabono"]) ? "0.00" : $_POST["montoabono"]);
    $total = number_format($_POST["txtImporte"]-$montoabono, 2, '.', '');
    ################### SELECCIONE LOS DATOS DEL CLIENTE ######################
	
	if(limpiar($_POST["tipodocumento"] == "FACTURA" && $tipocliente == "NATURAL")){ 

    	    echo "8";
	        exit;

    } else if ($_POST["tipopago"] == "CREDITO") {

		$fechaactual = date("Y-m-d");
		$fechavence = date("Y-m-d",strtotime($_POST['fechavencecredito']));

		if ($_POST["codcliente"] == '0') { 

	        echo "9";
	        exit;

        } else if (strtotime($fechavence) < strtotime($fechaactual)) {

			echo "10";
			exit;

		} else if ($montoabono != "0.00" && $medioabono == "") {
  
           echo "11";
	       exit;

		} else if ($limitecredito != "0.00" && $total > $creditodisponible) {
  
           echo "12";
	       exit;

		} else if($_POST["montoabono"] >= $_POST["txtTotal"]) { 
	
		   echo "13";
		   exit;

	    }

	}

	################ CREO EL CODIGO DE BANDERA PARA NUMERO DE VENTA ################
	$sql = "SELECT bandera from ventas WHERE statuspago = 0 ORDER BY bandera DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

    $idbandera=$row["bandera"];

    }
	if(empty($idbandera)){

		$bandera = '1';

	} else {
		$num     = $idbandera + 1;
		$bandera = $num;
	}
	################ CREO EL CODIGO DE BANDERA PARA NUMERO DE VENTA ################
	
    ################ OBTENGO DATOS DE CONFIGURACION ################
	$sql = "SELECT * 
	FROM configuracion 
    LEFT JOIN documentos ON configuracion.documsucursal = documentos.coddocumento
    LEFT JOIN provincias ON configuracion.id_provincia = provincias.id_provincia 
    LEFT JOIN departamentos ON configuracion.id_departamento = departamentos.id_departamento 
    LEFT JOIN tiposmoneda ON configuracion.codmoneda = tiposmoneda.codmoneda";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
    $rucemisor = $row['cuit'];
    $razonsocial = $row['nomsucursal'];
    $actecoemisor = $row['codgiro'];
    $giroemisor = $row['girosucursal'];
    $provincia = ($row['id_provincia'] == "" || $row['id_provincia'] == "0" ? $row['direcsucursal'] : $row['provincia']);
    $departamento = ($row['id_departamento'] == "" || $row['id_departamento'] == "0" ? $row['direcsucursal'] : $row['departamento']);
    $direcemisor = $row['direcsucursal'];
    $inicioticket = $row['inicioticket'];
    $inicioboleta = $row['inicioboleta'];
	$iniciofactura = $row['iniciofactura'];		
	$infoapi = $row['infoapi']; 
	$simbolo = $row['simbolo'];
	################ OBTENGO DATOS DE CONFIGURACION ################

	################ CREO LOS CODIGO VENTA-SERIE-AUTORIZACION ################
	$sql = "SELECT 
	codfactura 
	FROM ventas 
	WHERE tipodocumento = '".limpiar($_POST['tipodocumento'])."' 
	AND statuspago = 0 ORDER BY bandera DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$factura=$row["codfactura"];

	}
	
	if($_POST['tipodocumento']=="TICKET") {

        $codfactura = (empty($factura) ? $inicioticket : $factura + 1);
		$codserie = limpiar(GenerateRandomStringg());
		$codautorizacion = limpiar(GenerateRandomStringg());

	} elseif($_POST['tipodocumento']=="BOLETA") {

        $codfactura = (empty($factura) ? $inicioboleta : $factura + 1);
		$codserie = limpiar(GenerateRandomStringg());
		$codautorizacion = limpiar(GenerateRandomStringg());

	} elseif($_POST['tipodocumento']=="FACTURA") {

		$codfactura = (empty($factura) ? $iniciofactura : $factura + 1);
		$codserie = limpiar(GenerateRandomStringg());
		$codautorizacion = limpiar(GenerateRandomStringg());
	}
    ################# CREO LOS CODIGO VENTA-SERIE-AUTORIZACION ###############

if ($infoapi == "SI"){

############################# PROCESO PARA ENVIAR INFORMACION PARA FACTURACION ELECTRONICA #############################

############################# PROCESO PARA ENVIAR INFORMACION PARA FACTURACION ELECTRONICA #############################

}//FIN DE INFO API

	$sql = "UPDATE ventas set "
	." tipodocumento = ?, "
	." codcaja = ?, "
	." codfactura = ?, "
	." codserie = ?, "
	." codautorizacion = ?, "
	." codcliente = ?, "
	." descuento = ?, "
	." totaldescuento = ?, "
	." totalpago = ?, "
	." creditopagado = ?, "
	." montodelivery = ?, "
	." tipopago = ?, "
	." formapago = ?, "
	." montopagado = ?, "
	." formapago2 = ?, "
	." montopagado2 = ?, "
	." formapropina = ?, "
	." montopropina = ?, "
	." montodevuelto = ?, "
	." fechavencecredito = ?, "
	." statusventa = ?, "
	." statuspago = ?, "
	." repartidor = ?, "
	." entregado = ?, "
	." observaciones = ?, "
	." bandera = ?, "
	." docelectronico = ? "
	." WHERE "
	." codpedido = ? AND codventa = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $tipodocumento);
	$stmt->bindParam(2, $codcaja);
	$stmt->bindParam(3, $codfactura);
	$stmt->bindParam(4, $codserie);
	$stmt->bindParam(5, $codautorizacion);
	$stmt->bindParam(6, $codcliente);
	$stmt->bindParam(7, $descuento);
	$stmt->bindParam(8, $totaldescuento);
	$stmt->bindParam(9, $totalpago);
	$stmt->bindParam(10, $creditopagado);
	$stmt->bindParam(11, $montodelivery);
	$stmt->bindParam(12, $tipopago);
	$stmt->bindParam(13, $formapago);
	$stmt->bindParam(14, $montopagado);
	$stmt->bindParam(15, $formapago2);
	$stmt->bindParam(16, $montopagado2);
	$stmt->bindParam(17, $formapropina);
	$stmt->bindParam(18, $montopropina);
	$stmt->bindParam(19, $montodevuelto);
	$stmt->bindParam(20, $fechavencecredito);
	$stmt->bindParam(21, $statusventa);
	$stmt->bindParam(22, $statuspago);
	$stmt->bindParam(23, $repartidor);
	$stmt->bindParam(24, $entregado);
	$stmt->bindParam(25, $observaciones);
	$stmt->bindParam(26, $bandera);
	$stmt->bindParam(27, $docelectronico);
	$stmt->bindParam(28, $codpedido);
	$stmt->bindParam(29, $codventa);
    
	$tipodocumento = limpiar($_POST["tipodocumento"]);
	$codcaja = limpiar($_POST["codcaja"]);
	$codcliente = limpiar($_POST["codcliente"]);
	$descuento = limpiar($_POST["descuento"]);
	$totaldescuento = limpiar($_POST["txtDescuento"]);
	$totalpago = limpiar($_POST["txtTotal"]);
	$creditopagado = limpiar(isset($_POST['montoabono']) ? $_POST["montoabono"] : "0.00");
	$montodelivery = limpiar(isset($_POST['montodelivery']) ? $_POST["montodelivery"] : "0.00");
	$tipopago = limpiar($_POST["tipopago"]);
	$formapago = limpiar($_POST["tipopago"]=="CONTADO" ? $_POST["formapago"] : "CREDITO");
	$montopagado = limpiar($_POST['montopagado']);
	$formapago2 = limpiar(isset($_POST['montopagado2']) ? $_POST["formapago2"] : "0");
	$montopagado2 = limpiar(isset($_POST['montopagado2']) ? $_POST["montopagado2"] : "0");
	$formapropina = limpiar($_POST['formapropina']=="" ? "0" : $_POST["formapropina"]);
	$montopropina = limpiar(isset($_POST['montopropina']) ? $_POST["montopropina"] : "0");
	$montodevuelto = limpiar($_POST['montodevuelto']);
    $fechavencecredito = limpiar($_POST["tipopago"]=="CREDITO" ? date("Y-m-d",strtotime($_POST['fechavencecredito'])) : "0000-00-00");
    $statusventa = limpiar($_POST["tipopago"]=="CONTADO" ? "PAGADA" : "PENDIENTE");
	$statuspago = limpiar("0");
	$repartidor = limpiar($_POST["tipopedido"]=="EXTERNO" ? decrypt($_POST['repartidor']) : "0");
	$entregado = limpiar($_POST["tipopedido"]=="EXTERNO" ? "1" : "0");
	$observaciones = limpiar($_POST['observaciones']=="" ? "NINGUNA" : $_POST['observaciones']);
	$docelectronico = limpiar($infoapi=="SI" ? "1" : "0");
	$codpedido = limpiar($_POST["codpedido"]);
	$codventa = limpiar($_POST["codventa"]);
	$stmt->execute();

    #################### ACTUALIZAMOS EL STATUS DE COCINA EN PEDIDOS ####################
	$sql = "UPDATE detallepedidos set "
		  ." cocinero = ? "
		  ." WHERE "
		  ." codpedido = ? AND codventa = ?;
		   ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $cocinero);
	$stmt->bindParam(2, $codpedido);
	$stmt->bindParam(3, $codventa);
	
	$cocinero = limpiar("0");
	$codpedido = limpiar($_POST["codpedido"]);
	$codventa = limpiar($_POST["codventa"]);
	$stmt->execute();
	#################### ACTUALIZAMOS EL STATUS DE COCINA EN PEDIDOS ####################

	#################### ACTUALIZAMOS LA FECHA DE ENTREGA EN PEDIDOS ####################
	$sql = "UPDATE detallepedidos set "
		  ." fechaentrega = ? "
		  ." WHERE "
		  ." codpedido = ? AND codventa = ? AND fechaentrega = '0000-00-00 00:00:00';
		   ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $fechaentrega);
	$stmt->bindParam(2, $codpedido);
	$stmt->bindParam(3, $codventa);
	
	$fechaentrega = date("Y-m-d H:i:s");
	$codpedido = limpiar($_POST["codpedido"]);
	$codventa = limpiar($_POST["codventa"]);
	$stmt->execute();
	#################### ACTUALIZAMOS LA FECHA DE ENTREGA EN PEDIDOS ####################

   ############## AGREGAMOS EL INGRESO DE VENTAS PAGADAS A CAJA ###############
	if (limpiar($_POST["tipopago"]=="CONTADO")){

	################## OBTENGO LOS DATOS EN CAJA ##################
	$sql = "SELECT 
	efectivo, 
	cheque, 
	tcredito, 
	tdebito, 
	tprepago, 
	transferencia, 
	electronico,
	cupon, 
	otros,
	propinasefectivo,
	propinasotros,
	nroticket,
	nroboleta,
	nrofactura
	FROM arqueocaja WHERE codcaja = '".limpiar($_POST["codcaja"])."' AND statusarqueo = 1";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$efectivo = ($row['efectivo']== "" ? "0.00" : $row['efectivo']);
	$cheque = ($row['cheque']== "" ? "0.00" : $row['cheque']);
	$tcredito = ($row['tcredito']== "" ? "0.00" : $row['tcredito']);
	$tdebito = ($row['tdebito']== "" ? "0.00" : $row['tdebito']);
	$tprepago = ($row['tprepago']== "" ? "0.00" : $row['tprepago']);
	$transferencia = ($row['transferencia']== "" ? "0.00" : $row['transferencia']);
	$electronico = ($row['electronico']== "" ? "0.00" : $row['electronico']);
	$cupon = ($row['cupon']== "" ? "0.00" : $row['cupon']);
	$otros = ($row['otros']== "" ? "0.00" : $row['otros']);
	$propinasefectivo = ($row['propinasefectivo']== "" ? "0.00" : $row['propinasefectivo']);
	$propinasotros = ($row['propinasotros']== "" ? "0.00" : $row['propinasotros']);
	$nroticket = $row['nroticket'];
	$nroboleta = $row['nroboleta'];
	$nrofactura = $row['nrofactura'];
	################## OBTENGO LOS DATOS EN CAJA ##################

	
	if(isset($_POST['formapago2']) && $_POST['formapago2']!=""){

	########################## PROCESO LA 1ERA FORMA DE PAGO #################################
	$sql = "UPDATE arqueocaja set "
	." efectivo = ?, "
	." cheque = ?, "
	." tcredito = ?, "
	." tdebito = ?, "
	." tprepago = ?, "
	." transferencia = ?, "
	." electronico = ?, "
	." cupon = ?, "
	." otros = ?, "
	." propinasefectivo = ?, "
	." propinasotros = ?, "
	." nroticket = ?, "
	." nroboleta = ?, "
	." nrofactura = ? "
	." WHERE "
	." codcaja = ? AND statusarqueo = 1;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $txtEfectivo);
	$stmt->bindParam(2, $txtCheque);
	$stmt->bindParam(3, $txtTcredito);
	$stmt->bindParam(4, $txtTdebito);
	$stmt->bindParam(5, $txtTprepago);
	$stmt->bindParam(6, $txtTransferencia);
	$stmt->bindParam(7, $txtElectronico);
	$stmt->bindParam(8, $txtCupon);
	$stmt->bindParam(9, $txtOtros);
	$stmt->bindParam(10, $txtPropinaEfectivo);
	$stmt->bindParam(11, $txtPropinaOtros);
	$stmt->bindParam(12, $NumTicket);
	$stmt->bindParam(13, $NumBoleta);
	$stmt->bindParam(14, $NumFactura);
	$stmt->bindParam(15, $codcaja);

	$txtEfectivo = limpiar($_POST["formapago"] == "EFECTIVO" ? number_format($efectivo+$_POST["montopagado"], 2, '.', '') : $efectivo);
	$txtCheque = limpiar($_POST["formapago"] == "CHEQUE" ? number_format($cheque+$_POST["montopagado"], 2, '.', '') : $cheque);
	$txtTcredito = limpiar($_POST["formapago"] == "TARJETA DE CREDITO" ? number_format($tcredito+$_POST["montopagado"], 2, '.', '') : $tcredito);
	$txtTdebito = limpiar($_POST["formapago"] == "TARJETA DE DEBITO" ? number_format($tdebito+$_POST["montopagado"], 2, '.', '') : $tdebito);
	$txtTprepago = limpiar($_POST["formapago"] == "TARJETA PREPAGO" ? number_format($tprepago+$_POST["montopagado"], 2, '.', '') : $tprepago);
	$txtTransferencia = limpiar($_POST["formapago"] == "TRANSFERENCIA" ? number_format($transferencia+$_POST["montopagado"], 2, '.', '') : $transferencia);
	$txtElectronico = limpiar($_POST["formapago"] == "DINERO ELECTRONICO" ? number_format($electronico+$_POST["montopagado"], 2, '.', '') : $electronico);
	$txtCupon = limpiar($_POST["formapago"] == "CUPON" ? number_format($cupon+$_POST["montopagado"], 2, '.', '') : $cupon);
	$txtOtros = limpiar($_POST["formapago"] == "OTROS" ? number_format($otros+$_POST["montopagado"], 2, '.', '') : $otros);
	
	$txtPropinaEfectivo = limpiar(isset($_POST['montopropina']) && $_POST["formapropina"] == "EFECTIVO" ? number_format($propinasefectivo+$_POST["montopropina"], 2, '.', '') : $propinasefectivo);
	$txtPropinaOtros = limpiar(isset($_POST['montopropina']) && $_POST["formapropina"] != "EFECTIVO" ? number_format($propinasotros+$_POST["montopropina"], 2, '.', '') : $propinasotros);

	$NumTicket = limpiar($_POST["tipodocumento"] == "TICKET" ? $nroticket+1 : $nroticket);
	$NumBoleta = limpiar($_POST["tipodocumento"] == "BOLETA" ? $nroboleta+1 : $nroboleta);
	$NumFactura = limpiar($_POST["tipodocumento"] == "FACTURA" ? $nrofactura+1 : $nrofactura);

	$codcaja = limpiar($_POST["codcaja"]);
	$stmt->execute();
	########################## PROCESO LA 1ERA FORMA DE PAGO #################################

	########################## PROCESO LA 2DA FORMA DE PAGO #################################
	$sql2 = "UPDATE arqueocaja set "
	." efectivo = ?, "
	." cheque = ?, "
	." tcredito = ?, "
	." tdebito = ?, "
	." tprepago = ?, "
	." transferencia = ?, "
	." electronico = ?, "
	." cupon = ?, "
	." otros = ? "
	." WHERE "
	." codcaja = ? AND statusarqueo = 1;
	";
	$stmt = $this->dbh->prepare($sql2);
	$stmt->bindParam(1, $txtEfectivo2);
	$stmt->bindParam(2, $txtCheque2);
	$stmt->bindParam(3, $txtTcredito2);
	$stmt->bindParam(4, $txtTdebito2);
	$stmt->bindParam(5, $txtTprepago2);
	$stmt->bindParam(6, $txtTransferencia2);
	$stmt->bindParam(7, $txtElectronico2);
	$stmt->bindParam(8, $txtCupon2);
	$stmt->bindParam(9, $txtOtros2);
	$stmt->bindParam(10, $codcaja);

	$txtEfectivo2 = limpiar($_POST["formapago2"] == "EFECTIVO" ? number_format($efectivo+$_POST["montopagado2"], 2, '.', '') : $txtEfectivo);
	$txtCheque2 = limpiar($_POST["formapago2"] == "CHEQUE" ? number_format($cheque+$_POST["montopagado2"], 2, '.', '') : $cheque);
	$txtTcredito2 = limpiar($_POST["formapago2"] == "TARJETA DE CREDITO" ? number_format($tcredito+$_POST["montopagado2"], 2, '.', '') : $txtTcredito);
	$txtTdebito2 = limpiar($_POST["formapago2"] == "TARJETA DE DEBITO" ? number_format($tdebito+$_POST["montopagado2"], 2, '.', '') : $txtTdebito);
	$txtTprepago2 = limpiar($_POST["formapago2"] == "TARJETA PREPAGO" ? number_format($tprepago+$_POST["montopagado2"], 2, '.', '') : $txtTprepago);
	$txtTransferencia2 = limpiar($_POST["formapago2"] == "TRANSFERENCIA" ? number_format($transferencia+$_POST["montopagado2"], 2, '.', '') : $txtTransferencia);
	$txtElectronico2 = limpiar($_POST["formapago2"] == "DINERO ELECTRONICO" ? number_format($electronico+$_POST["montopagado2"], 2, '.', '') : $txtElectronico);
	$txtCupon2 = limpiar($_POST["formapago2"] == "CUPON" ? number_format($cupon+$_POST["montopagado2"], 2, '.', '') : $txtCupon);
	$txtOtros2 = limpiar($_POST["formapago2"] == "OTROS" ? number_format($otros+$_POST["montopagado2"], 2, '.', '') : $txtOtros);
	$codcaja = limpiar($_POST["codcaja"]);
	$stmt->execute();
	########################## PROCESO LA 2DA FORMA DE PAGO #################################

	} else { 

	########################## PROCESO LA 1ERA FORMA DE PAGO #################################
	$sql = "UPDATE arqueocaja set "
	." efectivo = ?, "
	." cheque = ?, "
	." tcredito = ?, "
	." tdebito = ?, "
	." tprepago = ?, "
	." transferencia = ?, "
	." electronico = ?, "
	." cupon = ?, "
	." otros = ?, "
	." propinasefectivo = ?, "
	." propinasotros = ?, "
	." nroticket = ?, "
	." nroboleta = ?, "
	." nrofactura = ? "
	." WHERE "
	." codcaja = ? AND statusarqueo = 1;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $txtEfectivo);
	$stmt->bindParam(2, $txtCheque);
	$stmt->bindParam(3, $txtTcredito);
	$stmt->bindParam(4, $txtTdebito);
	$stmt->bindParam(5, $txtTprepago);
	$stmt->bindParam(6, $txtTransferencia);
	$stmt->bindParam(7, $txtElectronico);
	$stmt->bindParam(8, $txtCupon);
	$stmt->bindParam(9, $txtOtros);
	$stmt->bindParam(10, $txtPropinaEfectivo);
	$stmt->bindParam(11, $txtPropinaOtros);
	$stmt->bindParam(12, $NumTicket);
	$stmt->bindParam(13, $NumBoleta);
	$stmt->bindParam(14, $NumFactura);
	$stmt->bindParam(15, $codcaja);
	
	$textdelivery = limpiar(isset($_POST['montodelivery']) ? $_POST["montodelivery"] : "0.00");
	$TotalPagar =  number_format($_POST["txtTotal"]+$textdelivery, 2, '.', '');
	$txtEfectivo = limpiar($_POST["formapago"] == "EFECTIVO" ? number_format($efectivo+$TotalPagar, 2, '.', '') : $efectivo);
	$txtCheque = limpiar($_POST["formapago"] == "CHEQUE" ? number_format($cheque+$TotalPagar, 2, '.', '') : $cheque);
	$txtTcredito = limpiar($_POST["formapago"] == "TARJETA DE CREDITO" ? number_format($tcredito+$TotalPagar, 2, '.', '') : $tcredito);
	$txtTdebito = limpiar($_POST["formapago"] == "TARJETA DE DEBITO" ? number_format($tdebito+$TotalPagar, 2, '.', '') : $tdebito);
	$txtTprepago = limpiar($_POST["formapago"] == "TARJETA PREPAGO" ? number_format($tprepago+$TotalPagar, 2, '.', '') : $tprepago);
	$txtTransferencia = limpiar($_POST["formapago"] == "TRANSFERENCIA" ? number_format($transferencia+$TotalPagar, 2, '.', '') : $transferencia);
	$txtElectronico = limpiar($_POST["formapago"] == "DINERO ELECTRONICO" ? number_format($electronico+$TotalPagar, 2, '.', '') : $electronico);
	$txtCupon = limpiar($_POST["formapago"] == "CUPON" ? number_format($cupon+$TotalPagar, 2, '.', '') : $cupon);
	$txtOtros = limpiar($_POST["formapago"] == "OTROS" ? number_format($otros+$TotalPagar, 2, '.', '') : $otros);
	
	$txtPropinaEfectivo = limpiar(isset($_POST['montopropina']) && $_POST["formapropina"] == "EFECTIVO" ? number_format($propinasefectivo+$_POST["montopropina"], 2, '.', '') : $propinasefectivo);
	$txtPropinaOtros = limpiar(isset($_POST['montopropina']) && $_POST["formapropina"] != "EFECTIVO" ? number_format($propinasotros+$_POST["montopropina"], 2, '.', '') : $propinasotros);

	$NumTicket = limpiar($_POST["tipodocumento"] == "TICKET" ? $nroticket+1 : $nroticket);
	$NumBoleta = limpiar($_POST["tipodocumento"] == "BOLETA" ? $nroboleta+1 : $nroboleta);
	$NumFactura = limpiar($_POST["tipodocumento"] == "FACTURA" ? $nrofactura+1 : $nrofactura);

	$codcaja = limpiar($_POST["codcaja"]);
	$stmt->execute();
	########################## PROCESO LA 1ERA FORMA DE PAGO #################################
		}
	}
    ################ AGREGAMOS EL INGRESO DE VENTAS PAGADAS A CAJA ##############


    ######### AGREGAMOS EL INGRESO Y ABONOS DE VENTAS A CREDITOS A CAJA ############
	if (limpiar($_POST["tipopago"]=="CREDITO")) {

	################## OBTENGO LOS DATOS EN CAJA ##################
	$sql = "SELECT 
	efectivo, 
	cheque, 
	tcredito, 
	tdebito, 
	tprepago, 
	transferencia, 
	electronico, 
	cupon,
	otros,
	creditos,
	nroticket,
	nroboleta,
	nrofactura
	FROM arqueocaja WHERE codcaja = '".limpiar($_POST["codcaja"])."' AND statusarqueo = 1";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$efectivo = ($row['efectivo']== "" ? "0.00" : $row['efectivo']);
	$cheque = ($row['cheque']== "" ? "0.00" : $row['cheque']);
	$tcredito = ($row['tcredito']== "" ? "0.00" : $row['tcredito']);
	$tdebito = ($row['tdebito']== "" ? "0.00" : $row['tdebito']);
	$tprepago = ($row['tprepago']== "" ? "0.00" : $row['tprepago']);
	$transferencia = ($row['transferencia']== "" ? "0.00" : $row['transferencia']);
	$electronico = ($row['electronico']== "" ? "0.00" : $row['electronico']);
	$cupon = ($row['cupon']== "" ? "0.00" : $row['cupon']);
	$otros = ($row['otros']== "" ? "0.00" : $row['otros']);
	$credito = ($row['creditos']== "" ? "0.00" : $row['creditos']);
	$nroticket = $row['nroticket'];
	$nroboleta = $row['nroboleta'];
	$nrofactura = $row['nrofactura'];
	################## OBTENGO LOS DATOS EN CAJA ##################

	$sql = "UPDATE arqueocaja set "
	." efectivo = ?, "
	." cheque = ?, "
	." tcredito = ?, "
	." tdebito = ?, "
	." tprepago = ?, "
	." transferencia = ?, "
	." electronico = ?, "
	." cupon = ?, "
	." otros = ?, "
	." creditos = ?, "
	." nroticket = ?, "
	." nroboleta = ?, "
	." nrofactura = ? "
	." WHERE "
	." codcaja = ? AND statusarqueo = 1;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $txtEfectivo);
	$stmt->bindParam(2, $txtCheque);
	$stmt->bindParam(3, $txtTcredito);
	$stmt->bindParam(4, $txtTdebito);
	$stmt->bindParam(5, $txtTprepago);
	$stmt->bindParam(6, $txtTransferencia);
	$stmt->bindParam(7, $txtElectronico);
	$stmt->bindParam(8, $txtCupon);
	$stmt->bindParam(9, $txtOtros);
	$stmt->bindParam(10, $txtCredito);
	$stmt->bindParam(11, $NumTicket);
	$stmt->bindParam(12, $NumBoleta);
	$stmt->bindParam(13, $NumFactura);
	$stmt->bindParam(14, $codcaja);

	$textdelivery = limpiar(isset($_POST['montodelivery']) ? $_POST["montodelivery"] : "0.00");
	$TotalPagar =  number_format($_POST["txtTotal"]+$textdelivery, 2, '.', '');
	$txtEfectivo = limpiar($_POST["medioabono"] == "EFECTIVO" ? number_format($efectivo+$_POST["montoabono"], 2, '.', '') : $efectivo);
	$txtCheque = limpiar($_POST["medioabono"] == "CHEQUE" ? number_format($cheque+$_POST["montoabono"], 2, '.', '') : $cheque);
	$txtTcredito = limpiar($_POST["medioabono"] == "TARJETA DE CREDITO" ? number_format($tcredito+$_POST["montoabono"], 2, '.', '') : $tcredito);
	$txtTdebito = limpiar($_POST["medioabono"] == "TARJETA DE DEBITO" ? number_format($tdebito+$_POST["montoabono"], 2, '.', '') : $tdebito);
	$txtTprepago = limpiar($_POST["medioabono"] == "TARJETA PREPAGO" ? number_format($tprepago+$_POST["montoabono"], 2, '.', '') : $tprepago);
	$txtTransferencia = limpiar($_POST["medioabono"] == "TRANSFERENCIA" ? number_format($transferencia+$_POST["montoabono"], 2, '.', '') : $transferencia);
	$txtElectronico = limpiar($_POST["medioabono"] == "DINERO ELECTRONICO" ? number_format($electronico+$_POST["montoabono"], 2, '.', '') : $electronico);
	$txtCupon = limpiar($_POST["medioabono"] == "CUPON" ? number_format($cupon+$_POST["montoabono"], 2, '.', '') : $cupon);
	$txtOtros = limpiar($_POST["medioabono"] == "OTROS" ? number_format($otros+$_POST["montoabono"], 2, '.', '') : $otros);
	$txtCredito = number_format($credito+($TotalPagar-$_POST["montoabono"]), 2, '.', '');

	$NumTicket = limpiar($_POST["tipodocumento"] == "TICKET" ? $nroticket+1 : $nroticket);
	$NumBoleta = limpiar($_POST["tipodocumento"] == "BOLETA" ? $nroboleta+1 : $nroboleta);
	$NumFactura = limpiar($_POST["tipodocumento"] == "FACTURA" ? $nrofactura+1 : $nrofactura);

	$codcaja = limpiar($_POST["codcaja"]);
	$stmt->execute();

	$sql = "SELECT codcliente FROM creditosxclientes WHERE codcliente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_POST["codcliente"]));
	$num = $stmt->rowCount();
	if($num == 0)
	{
		$query = "INSERT INTO creditosxclientes values (null, ?, ?);";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codcliente);
		$stmt->bindParam(2, $montocredito);

		$codcliente = limpiar($_POST["codcliente"]);
		$TotalPagar =  number_format($_POST["txtTotal"]+$textdelivery, 2, '.', '');
		$montocredito = number_format($TotalPagar-$_POST["montoabono"], 2, '.', '');
		$stmt->execute();

	} else { 

		$sql = "UPDATE creditosxclientes set"
		." montocredito = ? "
		." WHERE "
		." codcliente = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $montocredito);
		$stmt->bindParam(2, $codcliente);

		$TotalPagar =  number_format($_POST["txtTotal"]+$textdelivery, 2, '.', '');
		$montocredito = number_format($montoactual+($TotalPagar-$_POST["montoabono"]), 2, '.', '');
		$codcliente = limpiar($_POST["codcliente"]);
		$stmt->execute();
	}

   if (limpiar($_POST["montoabono"]!="0.00" && $_POST["montoabono"]!="0" && $_POST["montoabono"]!="")) {

	$query = "INSERT INTO abonoscreditos values (null, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codcaja);
	$stmt->bindParam(2, $codventa);
	$stmt->bindParam(3, $codcliente);
	$stmt->bindParam(4, $montoabono);
	$stmt->bindParam(5, $formaabono);
	$stmt->bindParam(6, $fechaabono);

	$codcaja = limpiar($_POST["codcaja"]);
	$codcliente = limpiar($_POST["codcliente"]);
	$montoabono = limpiar($_POST["montoabono"]);
	$formaabono = limpiar($_POST["medioabono"]);
	$fechaabono = limpiar(date("Y-m-d H:i:s"));
	$stmt->execute();

   }

	} 
   ########## AGREGAMOS EL INGRESO Y ABONOS DE VENTAS A CREDITOS A CAJA ########

echo "<span class='fa fa-check-square-o'></span> EL PEDIDO EN DELIVERY HA SIDO COBRADO EN CAJA EXITOSAMENTE <a href='reportepdf?codventa=".encrypt($codventa)."&tipo=".encrypt($tipodocumento)."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR ".$tipodocumento."</strong></font color></a></div>";

echo "<script>window.open('reportepdf?codventa=".encrypt($codventa)."&tipo=".encrypt($tipodocumento)."', '_blank');</script>";
	exit;
}
############################ FUNCION CERRAR DELIVERY ############################


##################################################################################################################
#                                                                                                                #
#                                  FUNCIONES PARA PEDIDOS DE PRODUCTOS EN DELIVERY                               #
#                                                                                                                #
##################################################################################################################





############################ FUNCION VER DETALLES PEDIDOS #############################
public function DetallesPedido()
	{
	self::SetNames();

	if (isset($_GET["tipo"]) && decrypt($_GET["tipo"])=="COMANDA") {

    $sql = "SELECT * 
	FROM ventas INNER JOIN detallepedidos ON detallepedidos.codpedido = ventas.codpedido 
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento 
	LEFT JOIN mesas ON mesas.codmesa = ventas.codmesa 
	LEFT JOIN salas ON mesas.codsala = salas.codsala 
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
	WHERE detallepedidos.codpedido = ? AND detallepedidos.pedido = ? AND detallepedidos.codventa = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codpedido"]),decrypt($_GET["pedido"]),decrypt($_GET["codventa"])));
	$num = $stmt->rowCount();
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$this->p[]=$row;
	}
		return $this->p;
		$this->dbh=null;

	} else if (isset($_GET["tipo"]) && decrypt($_GET["tipo"])=="PRECUENTA") {

	$sql = "SELECT 
	ventas.idventa, 
	ventas.codpedido, 
	ventas.codcliente, 
	ventas.codmesa, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva, 
	ventas.descontado,
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.creditopagado,
	ventas.montodelivery, 
	ventas.delivery, 
	ventas.repartidor, 
	usuarios.nombres, 
	clientes.documcliente, 
	clientes.dnicliente, 
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente, 
	clientes.girocliente, 
	clientes.direccliente, 
	documentos.documento, 
	salas.nomsala, 
	mesas.nommesa, 
	detallepedidos.pedido, 
	detallepedidos.observacionespedido, 
	detallepedidos.cocinero, 
	GROUP_CONCAT(cantventa, '|', substr(producto, 1,21) , '|', ROUND(valorneto, 2) SEPARATOR '<br>') AS detalles, SUM(valorneto) AS suma 
	FROM ventas 
	INNER JOIN detallepedidos ON detallepedidos.codpedido = ventas.codpedido 
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento 
	LEFT JOIN mesas ON mesas.codmesa = ventas.codmesa 
	LEFT JOIN salas ON mesas.codsala = salas.codsala 
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo 
	WHERE detallepedidos.codpedido = ? AND detallepedidos.codventa = ? GROUP BY detallepedidos.codpedido, detallepedidos.pedido";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codpedido"]),decrypt($_GET["codventa"])));
	$num = $stmt->rowCount();
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$this->p[]=$row;
	}
		return $this->p;
		$this->dbh=null;
	}
	 else if (isset($_GET["tipo"]) && decrypt($_GET["tipo"])=="DELIVERY") {

	$sql = "SELECT 
	clientes.documcliente,
	clientes.dnicliente, 
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente, 
	ventas.codpedido, 
	ventas.codventa,
	ventas.codcaja, 
	ventas.codcliente, 
	documentos.documento, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva,
	ventas.descontado, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.creditopagado,
	ventas.montodelivery,	
	ventas.codigo, 
	ventas.fechaventa,
	ventas.delivery,
	ventas.repartidor,
	ventas.entregado,
	ventas.observaciones, 
	detallepedidos.coddetallepedido, 
	detallepedidos.codpedido, 
	detallepedidos.pedido
	FROM ventas INNER JOIN detallepedidos ON ventas.codpedido = detallepedidos.codpedido 
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente 
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento 
	WHERE ventas.codpedido = ? AND ventas.codventa = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codpedido"]),decrypt($_GET["codventa"])));
		$num = $stmt->rowCount();
	    if($num==0)
	    {
		echo "";
	    }
	   else
	   {
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}

	 } else {

	$sql = "SELECT * FROM ventas 
	INNER JOIN detallepedidos ON ventas.codpedido = detallepedidos.codpedido 
	INNER JOIN mesas ON ventas.codmesa = mesas.codmesa
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente 
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento 
	WHERE ventas.codpedido = ? AND ventas.codventa = ? AND ventas.codmesa = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codpedido"]),decrypt($_GET["codventa"]),decrypt($_GET["codmesa"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "";
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$this->p[]=$row;
			}
			return $this->p;
			$this->dbh=null;
		}
	}
}
############################ FUNCION VER DETALLES PEDIDOS #############################

######################## FUNCION ELIMINAR DETALLES DE PEDIDOS #######################
public function EliminarDetallePedido()
{
    self::SetNames();
	$sql = "SELECT * FROM detallepedidos WHERE codpedido = ? AND codventa = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codpedido"]),decrypt($_GET["codventa"])));
	$num = $stmt->rowCount();
	if($num > 1)
	{

		############## OBTENGO LOS DATOS DEL PEDIDO A ELIMINAR #################
		$sql = "SELECT 
		cantventa, 
		preciocompra, 
		precioventa, 
		ivaproducto, 
		descproducto,
		tipo  
		FROM detalleventas 
		WHERE codpedido = ? 
		AND codventa = ? 
		AND codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codpedido"]),decrypt($_GET["codventa"]),decrypt($_GET["codproducto"])));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$cantidadbd = $row['cantventa'];
		$preciocomprabd = $row['preciocompra'];
		$precioventabd = $row['precioventa'];
		$ivaproductobd = $row['ivaproducto'];
		$descproductobd = $row['descproducto'];
		$tipobd = $row['tipo'];
		############## OBTENGO LOS DATOS DEL PEDIDO A ELIMINAR #################


    if(limpiar($tipobd) == 1){

    ############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################		

		############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################
		$sql2 = "SELECT existencia, controlstockp FROM productos WHERE codproducto = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute(array(decrypt($_GET["codproducto"])));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$existenciaproductobd = $row['existencia'];
	    $controlproductobd = $row['controlstockp'];
		############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################

		if($controlproductobd == 1){

			########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############
			$sql = "UPDATE productos SET "
			." existencia = ? "
			." WHERE "
			." codproducto = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $existencia);
			$stmt->bindParam(2, $codproducto);

			$existencia = number_format($existenciaproductobd+$cantidadbd, 2, '.', '');
			$codproducto = limpiar(decrypt($_GET["codproducto"]));
			$stmt->execute();
			########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############

		    ######## REGISTRAMOS LOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ###########
			$query = "INSERT INTO kardex_productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $codventa);
			$stmt->bindParam(2, $codcliente);
			$stmt->bindParam(3, $codproducto);
			$stmt->bindParam(4, $movimiento);
			$stmt->bindParam(5, $entradas);
			$stmt->bindParam(6, $salidas);
			$stmt->bindParam(7, $devolucion);
			$stmt->bindParam(8, $stockactual);
			$stmt->bindParam(9, $ivaproducto);
			$stmt->bindParam(10, $descproducto);
			$stmt->bindParam(11, $precio);
			$stmt->bindParam(12, $documento);
			$stmt->bindParam(13, $fechakardex);		

			$codventa = limpiar(decrypt($_GET["codventa"]));
			$codcliente = limpiar(decrypt($_GET["codcliente"]));
			$movimiento = limpiar("DEVOLUCION");
			$entradas= limpiar("0");
			$salidas = limpiar("0");
			$devolucion = limpiar($cantidadbd);
			$stockactual = limpiar($existenciaproductobd+$cantidadbd);
			$precio = limpiar($precioventabd);
			$ivaproducto = limpiar($ivaproductobd);
			$descproducto = limpiar($descproductobd);
			$documento = limpiar("DEVOLUCION DE PEDIDO");
			$fechakardex = limpiar(date("Y-m-d"));
			$stmt->execute();
			######## REGISTRAMOS LOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ###########
		}
    ############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################

	} else {

    ############################### PROCESO PARA VERIFICAR LOS COMBOS ######################################		

		############## VERIFICO LA EXISTENCIA DEL COMBO EN ALMACEN #################
		$sql2 = "SELECT existencia FROM combos WHERE codcombo = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute(array(decrypt($_GET["codproducto"])));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$existenciacombobd = $row['existencia'];
		############## VERIFICO LA EXISTENCIA DEL COMBO EN ALMACEN #################

		########### ACTUALIZAMOS LA EXISTENCIA DE COMBO EN ALMACEN #############
		$sql = "UPDATE combos SET "
		." existencia = ? "
		." WHERE "
		." codcombo = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$stmt->bindParam(2, $codcombo);

		$existencia = number_format($existenciacombobd+$cantidadbd, 2, '.', '');
		$codcombo = limpiar(decrypt($_GET["codproducto"]));
		$stmt->execute();
		########### ACTUALIZAMOS LA EXISTENCIA DE COMBO EN ALMACEN #############

	    ######## REGISTRAMOS LOS DATOS DEL COMBO ELIMINADO EN KARDEX ###########
		$query = "INSERT INTO kardex_combos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codventa);
		$stmt->bindParam(2, $codcliente);
		$stmt->bindParam(3, $codcombo);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivacombo);
		$stmt->bindParam(10, $desccombo);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);		

		$codventa = limpiar(decrypt($_GET["codventa"]));
		$codcliente = limpiar(decrypt($_GET["codcliente"]));
		$movimiento = limpiar("DEVOLUCION");
		$entradas= limpiar("0");
		$salidas = limpiar("0");
		$devolucion = limpiar($cantidadbd);
		$stockactual = limpiar($existenciacombobd+$cantidadbd);
		$precio = limpiar($precioventabd);
		$ivacombo = limpiar($ivaproductobd);
		$desccombo = limpiar($descproductobd);
		$documento = limpiar("DEVOLUCION DE PEDIDO");
		$fechakardex = limpiar(date("Y-m-d"));
		$stmt->execute();
		######## REGISTRAMOS LOS DATOS DEL COMBO ELIMINADO EN KARDEX ###########

    ############################### PROCESO PARA VERIFICAR LOS COMBOS ######################################

	}	


    ############################### PROCESO PARA VERIFICAR LOS INGREDIENTES ###################################	

		############## VERIFICO SI EL PRODUCTO TIENE INGREDIENTES RELACIONADOS #################
		$sql = "SELECT * FROM productosxingredientes WHERE codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(limpiar(decrypt($_GET["codproducto"]))));
		$num = $stmt->rowCount();
		if($num>0) {  

			$sql = "SELECT * FROM productosxingredientes LEFT JOIN ingredientes ON productosxingredientes.codingrediente = ingredientes.codingrediente WHERE productosxingredientes.codproducto IN ('".decrypt($_GET["codproducto"])."')";
			foreach ($this->dbh->query($sql) as $row)
			{ 
				$this->p[] = $row;

				$cantracionbd = $row['cantracion'];
				$codingredientebd = $row['codingrediente'];
				$cantingredientebd = $row['cantingrediente'];
				$precioventaingredientebd = $row['precioventa'];
				$ivaingredientebd = $row['ivaingrediente'];
				$descingredientebd = $row['descingrediente'];
	            $controlingredientebd = $row['controlstocki'];

		    if($controlingredientebd == 1){

			   ############## ACTUALIZO LOS DATOS DEL INGREDIENTE #################
			   $update = "UPDATE ingredientes set "
			   ." cantingrediente = ? "
			   ." WHERE "
			   ." codingrediente = ?;
			   ";
			   $stmt = $this->dbh->prepare($update);
			   $stmt->bindParam(1, $cantidadracion);
			   $stmt->bindParam(2, $codingredientebd);

			   $racion = number_format($cantracionbd*$cantidadbd, 2, '.', '');
			   $cantidadracion = number_format($cantingredientebd+$racion, 2, '.', '');
			   $stmt->execute();
			   ############## ACTUALIZO LOS DATOS DEL INGREDIENTE #################

			   ############## REGISTRAMOS LOS DATOS DE INGREDIENTES EN KARDEX ###################
			   $query = "INSERT INTO kardex_ingredientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
			   $stmt = $this->dbh->prepare($query);
			   $stmt->bindParam(1, $codventa);
			   $stmt->bindParam(2, $codcliente);
			   $stmt->bindParam(3, $codingrediente);
			   $stmt->bindParam(4, $movimiento);
			   $stmt->bindParam(5, $entradas);
			   $stmt->bindParam(6, $salidas);
			   $stmt->bindParam(7, $devolucion);
			   $stmt->bindParam(8, $stockactual);
			   $stmt->bindParam(9, $ivaingrediente);
			   $stmt->bindParam(10, $descingrediente);
			   $stmt->bindParam(11, $precio);
			   $stmt->bindParam(12, $documento);
			   $stmt->bindParam(13, $fechakardex);		

			   $codventa = limpiar(decrypt($_GET["codventa"]));
			   $codcliente = limpiar(decrypt($_GET["codcliente"]));
			   $codingrediente = limpiar($codingredientebd);
			   $movimiento = limpiar("DEVOLUCION");
			   $entradas = limpiar("0");
			   $salidas= limpiar("0");
			   $devolucion = limpiar($racion);
			   $stockactual = number_format($cantingredientebd+$racion, 2, '.', '');
			   $precio = limpiar($precioventaingredientebd);
			   $ivaingrediente = limpiar($ivaingredientebd);
			   $descingrediente = limpiar($descingredientebd);
			   $documento = limpiar("DEVOLUCION DE PEDIDO");
			   $fechakardex = limpiar(date("Y-m-d"));
			   $stmt->execute();
			}
		}
	}//fin de consulta de ingredientes de productos		

############################### PROCESO PARA VERIFICAR LOS INGREDIENTES ###################################	

		$sql = "DELETE FROM detallepedidos WHERE codpedido = ? AND pedido = ? AND codventa = ? AND codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codpedido);
		$stmt->bindParam(2,$pedido);
		$stmt->bindParam(3,$codventa);
		$stmt->bindParam(4,$codproducto);
		$codpedido = decrypt($_GET["codpedido"]);
		$pedido = decrypt($_GET["pedido"]);
		$codventa = decrypt($_GET["codventa"]);
		$codproducto = decrypt($_GET["codproducto"]);
		$stmt->execute();

		if($cantidadbd > decrypt($_GET["cantventa"])){

		$sql = "UPDATE detalleventas set "
		." cantventa = ?, "
		." valortotal = ?, "
		." totaldescuentov = ?, "
		." valorneto = ?, "
		." valorneto2 = ? "
		." WHERE "
		." codpedido = ? AND codventa = ? AND codproducto = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $cantidad);
		$stmt->bindParam(2, $valortotal);
		$stmt->bindParam(3, $totaldescuentov);
		$stmt->bindParam(4, $valorneto);
		$stmt->bindParam(5, $valorneto2);
		$stmt->bindParam(6, $codpedido);
		$stmt->bindParam(7, $codventa);
		$stmt->bindParam(8, $codproducto);

		$cantidad = number_format($cantidadbd-decrypt($_GET["cantventa"]), 2, '.', '');
	    $valortotal = number_format($precioventabd * $cantidad, 2, '.', '');
	    $totaldescuentov = number_format($valortotal * $descuentobd, 2, '.', '');
	    $valorneto = number_format($valortotal - $totaldescuentov, 2, '.', '');
	    $valorneto2 = number_format($preciocomprabd * $cantidad, 2, '.', '');
		$codpedido = decrypt($_GET["codpedido"]);
		$codventa = decrypt($_GET["codventa"]);
		$codproducto = decrypt($_GET["codproducto"]);
		$stmt->execute();

		} else {

		$sql = "DELETE FROM detalleventas WHERE codpedido = ? AND codventa = ? AND codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codpedido);
		$stmt->bindParam(2,$codventa);
		$stmt->bindParam(3,$codproducto);
		$codpedido = decrypt($_GET["codpedido"]);
		$codventa = decrypt($_GET["codventa"]);
		$codproducto = decrypt($_GET["codproducto"]);
		$stmt->execute();

		}

	    ############ CONSULTO LOS TOTALES DE VENTAS ##############
		$sql2 = "SELECT iva, descuento FROM ventas WHERE codventa = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute(array(decrypt($_GET["codventa"])));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$paea[] = $row;
		}
		$iva = $paea[0]["iva"]/100;
		$descuento = $paea[0]["descuento"]/100;

        ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############
		$sql3 = "SELECT SUM(totaldescuentov) AS totaldescuentosi, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detalleventas WHERE codpedido = '".limpiar(decrypt($_GET["codpedido"]))."' AND codventa = '".limpiar(decrypt($_GET["codventa"]))."' AND ivaproducto = 'SI'";
		foreach ($this->dbh->query($sql3) as $row3)
		{
			$this->p[] = $row3;
		}
	    $subtotaldescuentosi = ($row3['totaldescuentosi']== "" ? "0.00" : $row3['totaldescuentosi']);
		$subtotalivasi = ($row3['valorneto']== "" ? "0.00" : $row3['valorneto']);
		$subtotalivasi2 = ($row3['valorneto2']== "" ? "0.00" : $row3['valorneto2']);
		############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############

	    ############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############
		$sql4 = "SELECT SUM(totaldescuentov) AS totaldescuentono, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detalleventas WHERE codpedido = '".limpiar(decrypt($_GET["codpedido"]))."' AND codventa = '".limpiar(decrypt($_GET["codventa"]))."' AND ivaproducto = 'NO'";
		foreach ($this->dbh->query($sql4) as $row4)
		{
			$this->p[] = $row4;
		}
	    $subtotaldescuentono = ($row4['totaldescuentono']== "" ? "0.00" : $row4['totaldescuentono']);
		$subtotalivano = ($row4['valorneto']== "" ? "0.00" : $row4['valorneto']);
		$subtotalivano2 = ($row4['valorneto2']== "" ? "0.00" : $row4['valorneto2']);
		############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############

        ############ ACTUALIZO LOS TOTALES EN LA VENTA ##############
        $sql = " UPDATE ventas SET "
		." subtotalivasi = ?, "
		." subtotalivano = ?, "
		." totaliva = ?, "
	    ." descontado = ?, "
		." totaldescuento = ?, "
		." totalpago = ?, "
		." totalpago2= ? "
		." WHERE "
		." codpedido = ? AND codventa = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $subtotalivasi);
		$stmt->bindParam(2, $subtotalivano);
		$stmt->bindParam(3, $totaliva);
	    $stmt->bindParam(4, $descontado);
		$stmt->bindParam(5, $totaldescuento);
		$stmt->bindParam(6, $totalpago);
		$stmt->bindParam(7, $totalpago2);
		$stmt->bindParam(8, $codpedido);
		$stmt->bindParam(9, $codventa);

		$totaliva= number_format($subtotalivasi*$iva, 2, '.', '');
	    $descontado = number_format($subtotaldescuentosi+$subtotaldescuentono, 2, '.', '');
		$total= number_format($subtotalivasi+$subtotalivano+$totaliva, 2, '.', '');
		$totaldescuento= number_format($total*$descuento, 2, '.', '');
		$totalpago= number_format($total-$totaldescuento, 2, '.', '');
		$totalpago2 = number_format($subtotalivasi2+$subtotalivano2, 2, '.', '');
		$codpedido = limpiar(decrypt($_GET["codpedido"]));
		$codventa = limpiar(decrypt($_GET["codventa"]));
		$stmt->execute();
		
		echo "1";
		exit;

		} else {

		############## OBTENGO LOS DATOS DEL PEDIDO A ELIMINAR #################
		$sql = "SELECT 
		cantventa, 
		preciocompra, 
		precioventa, 
		ivaproducto, 
		descproducto,
		tipo  
		FROM detalleventas 
		WHERE codpedido = ? 
		AND codventa = ?
		AND codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["codpedido"]),decrypt($_GET["codventa"]),decrypt($_GET["codproducto"])));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$cantidadbd = $row['cantventa'];
		$preciocomprabd = $row['preciocompra'];
		$precioventabd = $row['precioventa'];
		$ivaproductobd = $row['ivaproducto']/100;
		$descproductobd = $row['descproducto']/100;
		$tipobd = $row['tipo'];
		############## OBTENGO LOS DATOS DEL PEDIDO A ELIMINAR #################

    if(limpiar($tipobd) == 1){

    ############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################		

		############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################
		$sql2 = "SELECT 
		existencia, 
		controlstockp 
		FROM productos 
		WHERE codproducto = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute(array(decrypt($_GET["codproducto"])));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$existenciaproductobd = $row['existencia'];
	    $controlproductobd = $row['controlstockp'];
		############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################

		if($controlproductobd == 1){

			########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############
			$sql = "UPDATE productos SET "
			." existencia = ? "
			." WHERE "
			." codproducto = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $existencia);
			$stmt->bindParam(2, $codproducto);

			$existencia = number_format($existenciaproductobd+$cantidadbd, 2, '.', '');
			$codproducto = limpiar(decrypt($_GET["codproducto"]));
			$stmt->execute();
			########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############

		    ######## REGISTRAMOS LOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ###########
			$query = "INSERT INTO kardex_productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $codventa);
			$stmt->bindParam(2, $codcliente);
			$stmt->bindParam(3, $codproducto);
			$stmt->bindParam(4, $movimiento);
			$stmt->bindParam(5, $entradas);
			$stmt->bindParam(6, $salidas);
			$stmt->bindParam(7, $devolucion);
			$stmt->bindParam(8, $stockactual);
			$stmt->bindParam(9, $ivaproducto);
			$stmt->bindParam(10, $descproducto);
			$stmt->bindParam(11, $precio);
			$stmt->bindParam(12, $documento);
			$stmt->bindParam(13, $fechakardex);		

			$codventa = limpiar(decrypt($_GET["codventa"]));
			$codcliente = limpiar(decrypt($_GET["codcliente"]));
			$movimiento = limpiar("DEVOLUCION");
			$entradas= limpiar("0");
			$salidas = limpiar("0");
			$devolucion = limpiar($cantidadbd);
			$stockactual = limpiar($existenciaproductobd+$cantidadbd);
			$precio = limpiar($precioventabd);
			$ivaproducto = limpiar($ivaproductobd);
			$descproducto = limpiar($descproductobd);
			$documento = limpiar("DEVOLUCION DE PEDIDO");
			$fechakardex = limpiar(date("Y-m-d"));
			$stmt->execute();
			######## REGISTRAMOS LOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ###########
		}
    ############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################

	} else {

    ############################### PROCESO PARA VERIFICAR LOS COMBOS ######################################		

		############## VERIFICO LA EXISTENCIA DEL COMBO EN ALMACEN #################
		$sql2 = "SELECT existencia FROM combos WHERE codcombo = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute(array(decrypt($_GET["codproducto"])));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$existenciacombobd = $row['existencia'];
		############## VERIFICO LA EXISTENCIA DEL COMBO EN ALMACEN #################

		########### ACTUALIZAMOS LA EXISTENCIA DE COMBO EN ALMACEN #############
		$sql = "UPDATE combos SET "
		." existencia = ? "
		." WHERE "
		." codcombo = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$stmt->bindParam(2, $codcombo);

		$existencia = number_format($existenciacombobd+$cantidadbd, 2, '.', '');
		$codcombo = limpiar(decrypt($_GET["codproducto"]));
		$stmt->execute();
		########### ACTUALIZAMOS LA EXISTENCIA DE COMBO EN ALMACEN #############

	    ######## REGISTRAMOS LOS DATOS DEL COMBO ELIMINADO EN KARDEX ###########
		$query = "INSERT INTO kardex_combos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codventa);
		$stmt->bindParam(2, $codcliente);
		$stmt->bindParam(3, $codcombo);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivacombo);
		$stmt->bindParam(10, $desccombo);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);		

		$codventa = limpiar(decrypt($_GET["codventa"]));
		$codcliente = limpiar(decrypt($_GET["codcliente"]));
		$movimiento = limpiar("DEVOLUCION");
		$entradas= limpiar("0");
		$salidas = limpiar("0");
		$devolucion = limpiar($cantidadbd);
		$stockactual = limpiar($existenciacombobd+$cantidadbd);
		$precio = limpiar($precioventabd);
		$ivacombo = limpiar($ivaproductobd);
		$desccombo = limpiar($descproductobd);
		$documento = limpiar("DEVOLUCION DE PEDIDO");
		$fechakardex = limpiar(date("Y-m-d"));
		$stmt->execute();
		######## REGISTRAMOS LOS DATOS DEL COMBO ELIMINADO EN KARDEX ###########

    ############################### PROCESO PARA VERIFICAR LOS COMBOS ######################################	

	}	



############################### PROCESO PARA VERIFICAR LOS INGREDIENTES ###################################	

	############## VERIFICO SI EL PRODUCTO TIENE INGREDIENTES RELACIONADOS #################
	$sql = "SELECT * FROM productosxingredientes WHERE codproducto = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar(decrypt($_GET["codproducto"]))));
	$num = $stmt->rowCount();
	if($num>0) {  

		$sql = "SELECT * FROM productosxingredientes LEFT JOIN ingredientes ON productosxingredientes.codingrediente = ingredientes.codingrediente WHERE productosxingredientes.codproducto IN ('".decrypt($_GET["codproducto"])."')";
		foreach ($this->dbh->query($sql) as $row)
		{ 
			$this->p[] = $row;

			$cantracionbd = $row['cantracion'];
			$codingredientebd = $row['codingrediente'];
			$cantingredientebd = $row['cantingrediente'];
			$precioventaingredientebd = $row['precioventa'];
			$ivaingredientebd = $row['ivaingrediente'];
			$descingredientebd = $row['descingrediente'];
            $controlingredientebd = $row['controlstocki'];

		    if($controlingredientebd == 1){

			   ############## ACTUALIZO LOS DATOS DEL INGREDIENTE #################
			   $update = "UPDATE ingredientes set "
			   ." cantingrediente = ? "
			   ." WHERE "
			   ." codingrediente = ?;
			   ";
			   $stmt = $this->dbh->prepare($update);
			   $stmt->bindParam(1, $cantidadracion);
			   $stmt->bindParam(2, $codingredientebd);

			   $racion = number_format($cantracionbd*$cantidadbd, 2, '.', '');
			   $cantidadracion = number_format($cantingredientebd+$racion, 2, '.', '');
			   $stmt->execute();
			   ############## ACTUALIZO LOS DATOS DEL INGREDIENTE #################

			   ############## REGISTRAMOS LOS DATOS DE INGREDIENTES EN KARDEX ###################
			   $query = "INSERT INTO kardex_ingredientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
			   $stmt = $this->dbh->prepare($query);
			   $stmt->bindParam(1, $codventa);
			   $stmt->bindParam(2, $codcliente);
			   $stmt->bindParam(3, $codingrediente);
			   $stmt->bindParam(4, $movimiento);
			   $stmt->bindParam(5, $entradas);
			   $stmt->bindParam(6, $salidas);
			   $stmt->bindParam(7, $devolucion);
			   $stmt->bindParam(8, $stockactual);
			   $stmt->bindParam(9, $ivaingrediente);
			   $stmt->bindParam(10, $descingrediente);
			   $stmt->bindParam(11, $precio);
			   $stmt->bindParam(12, $documento);
			   $stmt->bindParam(13, $fechakardex);		

			   $codventa = limpiar(decrypt($_GET["codventa"]));
			   $codcliente = limpiar(decrypt($_GET["codcliente"]));
			   $codingrediente = limpiar($codingredientebd);
			   $movimiento = limpiar("DEVOLUCION");
			   $entradas = limpiar("0");
			   $salidas= limpiar("0");
			   $devolucion = limpiar($racion);
			   $stockactual = number_format($cantingredientebd+$racion, 2, '.', '');
			   $precio = limpiar($precioventaingredientebd);
			   $ivaingrediente = limpiar($ivaingredientebd);
			   $descingrediente = limpiar($descingredientebd);
			   $documento = limpiar("DEVOLUCION DE PEDIDO");
			   $fechakardex = limpiar(date("Y-m-d"));
			   $stmt->execute();
			}
		}
	}//fin de consulta de ingredientes de productos		

############################### PROCESO PARA VERIFICAR LOS INGREDIENTES ###################################	

		#################### ELIMINAMOS EL PEDIDO EN VENTAS ####################
		$sql = "DELETE FROM ventas WHERE codpedido = ? AND codventa = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codpedido);
		$stmt->bindParam(2,$codventa);
		$codpedido = decrypt($_GET["codpedido"]);
		$codventa = decrypt($_GET["codventa"]);
		$stmt->execute();
		#################### ELIMINAMOS EL PEDIDO EN VENTAS ####################

		#################### ELIMINAMOS EL PEDIDO EN DETALLES VENTAS ####################
		$sql = "DELETE FROM detalleventas WHERE codpedido = ? AND codventa = ? AND codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codpedido);
		$stmt->bindParam(2,$codventa);
		$stmt->bindParam(3,$codproducto);
		$codpedido = decrypt($_GET["codpedido"]);
		$codventa = decrypt($_GET["codventa"]);
		$codproducto = decrypt($_GET["codproducto"]);
		$stmt->execute();
		#################### ELIMINAMOS EL PEDIDO EN DETALLES VENTAS ####################

		#################### ELIMINAMOS EL PEDIDO EN DETALLES PEDIDOS ####################
		$sql = "DELETE FROM detallepedidos WHERE codpedido = ? AND pedido = ? AND codventa = ? AND codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codpedido);
		$stmt->bindParam(2,$pedido);
		$stmt->bindParam(3,$codventa);
		$stmt->bindParam(4,$codproducto);
		$codpedido = decrypt($_GET["codpedido"]);
		$pedido = decrypt($_GET["pedido"]);
		$codventa = decrypt($_GET["codventa"]);
		$codproducto = decrypt($_GET["codproducto"]);
		$stmt->execute();
		#################### ELIMINAMOS EL PEDIDO EN DETALLES PEDIDOS ####################


		if (limpiar(isset($_GET['codmesa']))) { 

        	#################### VERIFICAMOS SI EXISTEN MAS PEDIDOS EN MESA ####################
        	$sql = "SELECT codmesa FROM ventas WHERE codmesa = ?";
		    $stmt = $this->dbh->prepare($sql);
		    $stmt->execute(array(decrypt($_GET["codmesa"])));
		    $num = $stmt->rowCount();
		    if($num == 0)
		    {
		    	
		    #################### ACTUALIZAMOS EL STATUS DE MESA ####################
			$sql = "UPDATE mesas set "
			." statusmesa = ? "
			." WHERE "
			." codmesa = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $statusmesa);
			$stmt->bindParam(2, $codmesa);

			$statusmesa = limpiar('0');
			$codmesa = decrypt($_GET["codmesa"]);
			$stmt->execute();
            #################### ACTUALIZAMOS EL STATUS DE MESA ####################
            }
        }	

		echo "1";
		exit;
	}	
}
##################### FUNCION ELIMINAR DETALLES DE PEDIDOS #################################

############################ FUNCION CANCELAR PEDIDOS #############################
public function CancelarPedido()
	{
	self::SetNames();

	#################### SELECCIONO LOS PRODUCTOS EN DETALLES VENTAS ####################
	$sql = "SELECT * FROM detalleventas 
	WHERE codpedido = '".limpiar(decrypt($_GET["codpedido"]))."' 
	AND codventa = '".limpiar(decrypt($_GET["codventa"]))."'";

    foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;

		$codproductobd = $row['codproducto'];
		$cantidadbd = $row['cantventa'];
		$precioventabd = $row['precioventa'];
		$ivaproductobd = $row['ivaproducto'];
		$descproductobd = $row['descproducto'];
		$tipobd = $row['tipo'];

    if(limpiar($tipobd) == 1){

    ############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################		

		############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################
		$sql2 = "SELECT existencia, controlstockp FROM productos WHERE codproducto = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute(array($codproductobd));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$existenciaproductobd = $row['existencia'];
	    $controlproductobd = $row['controlstockp'];
		############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################

		if($controlproductobd == 1){	

			########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN ###############
			$sql = "UPDATE productos SET "
			." existencia = ? "
			." WHERE "
			." codproducto = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $existencia);
			$stmt->bindParam(2, $codproductobd);

			$existencia = limpiar($existenciaproductobd+$cantidadbd);
			$stmt->execute();
			########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############

		    ########## REGISTRAMOS LOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ########
			$query = "INSERT INTO kardex_productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $codventa);
			$stmt->bindParam(2, $codcliente);
			$stmt->bindParam(3, $codproductobd);
			$stmt->bindParam(4, $movimiento);
			$stmt->bindParam(5, $entradas);
			$stmt->bindParam(6, $salidas);
			$stmt->bindParam(7, $devolucion);
			$stmt->bindParam(8, $stockactual);
			$stmt->bindParam(9, $ivaproducto);
			$stmt->bindParam(10, $descproducto);
			$stmt->bindParam(11, $precio);
			$stmt->bindParam(12, $documento);
			$stmt->bindParam(13, $fechakardex);		

		    $codventa = limpiar(decrypt($_GET["codventa"]));
			$codcliente = limpiar("0");
			$movimiento = limpiar("DEVOLUCION");
			$entradas= limpiar("0");
			$salidas = limpiar("0");
			$devolucion = limpiar($cantidadbd);
			$stockactual = limpiar($existenciaproductobd+$cantidadbd);
			$precio = limpiar($precioventabd);
			$ivaproducto = limpiar($ivaproductobd);
			$descproducto = limpiar($descproductobd);
			$documento = limpiar("DEVOLUCION DE PEDIDO");
			$fechakardex = limpiar(date("Y-m-d"));
			$stmt->execute();
			########## REGISTRAMOS LOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ########
		}
    ############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################

	} else {

    ############################### PROCESO PARA VERIFICAR LOS COMBOS ######################################		

		############## VERIFICO LA EXISTENCIA DEL COMBO EN ALMACEN #################
		$sql2 = "SELECT existencia FROM combos WHERE codcombo = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute(array($codproductobd));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$existenciacombobd = $row['existencia'];
		############## VERIFICO LA EXISTENCIA DEL COMBO EN ALMACEN #################	

		########### ACTUALIZAMOS LA EXISTENCIA DE COMBO EN ALMACEN ###############
		$sql = "UPDATE combos SET "
		." existencia = ? "
		." WHERE "
		." codcombo = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$stmt->bindParam(2, $codproductobd);

		$existencia = limpiar($existenciacombobd+$cantidadbd);
		$stmt->execute();
		########### ACTUALIZAMOS LA EXISTENCIA DE COMBO EN ALMACEN #############

	    ########## REGISTRAMOS LOS DATOS DEL COMBO ELIMINADO EN KARDEX ########
		$query = "INSERT INTO kardex_combos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codventa);
		$stmt->bindParam(2, $codcliente);
		$stmt->bindParam(3, $codproductobd);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivacombo);
		$stmt->bindParam(10, $desccombo);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);		

	    $codventa = limpiar(decrypt($_GET["codventa"]));
		$codcliente = limpiar("0");
		$movimiento = limpiar("DEVOLUCION");
		$entradas= limpiar("0");
		$salidas = limpiar("0");
		$devolucion = limpiar($cantidadbd);
		$stockactual = limpiar($existenciacombobd+$cantidadbd);
		$precio = limpiar($precioventabd);
		$ivacombo = limpiar($ivaproductobd);
		$desccombo = limpiar($descproductobd);
		$documento = limpiar("DEVOLUCION DE PEDIDO");
		$fechakardex = limpiar(date("Y-m-d"));
		$stmt->execute();
		########## REGISTRAMOS LOS DATOS DEL COMBO ELIMINADO EN KARDEX ########

    ############################### PROCESO PARA VERIFICAR LOS COMBOS ######################################

	}


    ############################### PROCESO PARA VERIFICAR LOS INGREDIENTES ###################################	

	############## VERIFICO SI EL PRODUCTO TIENE INGREDIENTES RELACIONADOS #################
	$sql = "SELECT * FROM productosxingredientes WHERE codproducto = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar($codproductobd)));
	$num = $stmt->rowCount();
	if($num>0) {  

		$sql = "SELECT * FROM productosxingredientes LEFT JOIN ingredientes ON productosxingredientes.codingrediente = ingredientes.codingrediente WHERE productosxingredientes.codproducto IN ('".$codproductobd."')";
		foreach ($this->dbh->query($sql) as $row)
		{ 
			$this->p[] = $row;

			$cantracionbd = $row['cantracion'];
			$codingredientebd = $row['codingrediente'];
			$cantingredientebd = $row['cantingrediente'];
			$precioventaingredientebd = $row['precioventa'];
			$ivaingredientebd = $row['ivaingrediente'];
			$descingredientebd = $row['descingrediente'];
            $controlingredientebd = $row['controlstocki'];

	    if($controlingredientebd == 1){

		   ############## ACTUALIZO LOS DATOS DEL INGREDIENTE #################
		   $update = "UPDATE ingredientes set "
		   ." cantingrediente = ? "
		   ." WHERE "
		   ." codingrediente = ?;
		   ";
		   $stmt = $this->dbh->prepare($update);
		   $stmt->bindParam(1, $cantidadracion);
		   $stmt->bindParam(2, $codingredientebd);

		   $racion = number_format($cantracionbd*$cantidadbd, 2, '.', '');
		   $cantidadracion = number_format($cantingredientebd+$racion, 2, '.', '');
		   $stmt->execute();
		   ############## ACTUALIZO LOS DATOS DEL INGREDIENTE #################

		   ############## REGISTRAMOS LOS DATOS DE INGREDIENTES EN KARDEX ###################
		   $query = "INSERT INTO kardex_ingredientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		   $stmt = $this->dbh->prepare($query);
		   $stmt->bindParam(1, $codventa);
		   $stmt->bindParam(2, $codcliente);
		   $stmt->bindParam(3, $codingrediente);
		   $stmt->bindParam(4, $movimiento);
		   $stmt->bindParam(5, $entradas);
		   $stmt->bindParam(6, $salidas);
		   $stmt->bindParam(7, $devolucion);
		   $stmt->bindParam(8, $stockactual);
		   $stmt->bindParam(9, $ivaingrediente);
		   $stmt->bindParam(10, $descingrediente);
		   $stmt->bindParam(11, $precio);
		   $stmt->bindParam(12, $documento);
		   $stmt->bindParam(13, $fechakardex);		

		   $codventa = limpiar(decrypt($_GET["codventa"]));
		   $codcliente = limpiar("0");
		   $codingrediente = limpiar($codingredientebd);
		   $movimiento = limpiar("DEVOLUCION");
		   $entradas = limpiar("0");
		   $salidas= limpiar("0");
		   $devolucion = limpiar($racion);
		   $stockactual = number_format($cantidadracion, 2, '.', '');
		   $precio = limpiar($precioventaingredientebd);
		   $ivaingrediente = limpiar($ivaingredientebd);
		   $descingrediente = limpiar($descingredientebd);
		   $documento = limpiar("DEVOLUCION DE PEDIDO");
		   $fechakardex = limpiar(date("Y-m-d"));
		   $stmt->execute();
			}
		}
	}//fin de consulta de ingredientes de productos	

############################### PROCESO PARA VERIFICAR LOS INGREDIENTES ###################################	

		}//fin de detalles ventas	

		
	#################### ELIMINAMOS EL PEDIDO EN VENTAS ####################
	$sql = "DELETE FROM ventas WHERE codpedido = ? AND codventa = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1,$codpedido);
	$stmt->bindParam(2,$codventa);
	$codpedido = decrypt($_GET["codpedido"]);
	$codventa = decrypt($_GET["codventa"]);
	$stmt->execute();
	#################### ELIMINAMOS EL PEDIDO EN VENTAS ####################

	#################### ELIMINAMOS EL PEDIDO EN DETALLES VENTAS ####################
	$sql = "DELETE FROM detalleventas WHERE codpedido = ? AND codventa = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1,$codpedido);
	$stmt->bindParam(2,$codventa);
	$codpedido = decrypt($_GET["codpedido"]);
	$codventa = decrypt($_GET["codventa"]);
	$stmt->execute();
	#################### ELIMINAMOS EL PEDIDO EN DETALLES VENTAS ####################

	#################### ELIMINAMOS EL PEDIDO EN DETALLES PEDIDOS ####################
	$sql = "DELETE FROM detallepedidos WHERE codpedido = ? AND codventa = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1,$codpedido);
	$stmt->bindParam(2,$codventa);
	$codpedido = decrypt($_GET["codpedido"]);
	$codventa = decrypt($_GET["codventa"]);
	$stmt->execute();
	#################### ELIMINAMOS EL PEDIDO EN DETALLES PEDIDOS ####################

    if (limpiar(isset($_GET['codmesa']))) { 

    	#################### VERIFICAMOS SI EXISTEN MAS PEDIDOS EN MESA ####################
    	$sql = "SELECT codmesa FROM ventas WHERE codmesa = ?";
	    $stmt = $this->dbh->prepare($sql);
	    $stmt->execute(array(decrypt($_GET["codmesa"])));
	    $num = $stmt->rowCount();
	    if($num == 0)
	    {
	    	
	    #################### ACTUALIZAMOS EL STATUS DE MESA ####################
		$sql = "UPDATE mesas set "
		." statusmesa = ? "
		." WHERE "
		." codmesa = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $statusmesa);
		$stmt->bindParam(2, $codmesa);

		$statusmesa = limpiar('0');
		$codmesa = decrypt($_GET["codmesa"]);
		$stmt->execute();
        #################### ACTUALIZAMOS EL STATUS DE MESA ####################
            }
        }	
		
    echo "1";
    exit;
}
########################### FUNCION CANCELAR PEDIDOS ###########################

######################### FUNCION LISTAR DETALLES DE PEDIDOS ########################
public function ListarDetallesPedidos()
{	
	self::SetNames();

	if(limpiar(decrypt($_GET["proceso"]))=="MESAS"){

	$sql = "SELECT 
	ventas.idventa, 
	ventas.codpedido, 
	ventas.codventa,
	ventas.codcliente, 
	ventas.codmesa, 
	ventas.totalpago,
	ventas.creditopagado, 
	ventas.montodelivery, 
	ventas.delivery, 
	ventas.repartidor, 
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,  
	salas.nomsala, 
	mesas.nommesa, 
	detallepedidos.pedido, 
	detallepedidos.observacionespedido, 
	detallepedidos.cocinero,
	detallepedidos.fechapedido,
	detallepedidos.fechaentrega, 
	detallepedidos.tipo,
	GROUP_CONCAT(cantventa, ' | ', producto, ' | ', observacionespedido SEPARATOR '<br>') AS detalles 
	FROM ventas INNER JOIN detallepedidos ON detallepedidos.codpedido = ventas.codpedido 
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente 
	LEFT JOIN mesas ON mesas.codmesa = ventas.codmesa 
	LEFT JOIN salas ON mesas.codsala = salas.codsala  
	WHERE ventas.codmesa != 0 
	GROUP BY detallepedidos.codpedido, detallepedidos.pedido 
	ORDER BY detallepedidos.cocinero DESC";
        foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;

	} else {

	$sql = "SELECT 
	ventas.idventa, 
	ventas.codpedido, 
	ventas.codventa,
	ventas.codcliente, 
	ventas.codmesa, 
	ventas.totalpago,
	ventas.creditopagado,
	ventas.montodelivery, 
	ventas.delivery, 
	ventas.repartidor, 
	clientes.dnicliente, 
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,  
	detallepedidos.pedido, 
	detallepedidos.observacionespedido,
	detallepedidos.cocinero,
	detallepedidos.fechapedido,
	detallepedidos.fechaentrega,
	detallepedidos.tipo,  
	GROUP_CONCAT(cantventa, ' | ', producto, ' | ', observacionespedido SEPARATOR '<br>') AS detalles 
	FROM ventas INNER JOIN detallepedidos ON detallepedidos.codpedido = ventas.codpedido 
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente 
	WHERE ventas.delivery = 1 
	GROUP BY detallepedidos.codpedido, detallepedidos.pedido 
	ORDER BY detallepedidos.cocinero DESC";
        foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################### FUNCION LISTAR DETALLES DE PEDIDOS ########################

######################### FUNCION LISTAR PEDIDOS EN MOSTRADOR ########################
	public function ListarMostrador()
	{
	
	self::SetNames();

	if(limpiar(decrypt($_GET["proceso"]))=="TODOS"){	

	$sql = "SELECT 
	ventas.idventa, 
	ventas.codpedido, 
	ventas.codventa, 
	ventas.codcliente, 
	ventas.codmesa, 
	ventas.tipodocumento, 
	ventas.totalpago,
	ventas.creditopagado,
	ventas.montodelivery, 
	ventas.delivery, 
	ventas.repartidor, 
	clientes.dnicliente, 
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente, 
	salas.nomsala, 
	mesas.nommesa, 
	detallepedidos.pedido, 
	detallepedidos.observacionespedido, 
	detallepedidos.cocinero, 
	detallepedidos.fechapedido, 
	detallepedidos.fechaentrega,
	detallepedidos.tipo, 
	GROUP_CONCAT(cantventa, ' | ', producto, ' | ', observacionespedido SEPARATOR '<br>') AS detalles 
	FROM ventas 
	INNER JOIN detallepedidos ON detallepedidos.codpedido = ventas.codpedido 
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente 
	LEFT JOIN mesas ON mesas.codmesa = ventas.codmesa 
	LEFT JOIN salas ON mesas.codsala = salas.codsala 
	WHERE detallepedidos.cocinero = '1' AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') = '".date("Y-m-d")."' GROUP BY detallepedidos.codpedido, detallepedidos.pedido, detallepedidos.codventa";
        foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	
    } elseif(limpiar(decrypt($_GET["proceso"]))=="MESAS"){

	$sql = "SELECT 
	ventas.idventa, 
	ventas.codpedido, 
	ventas.codventa, 
	ventas.codcliente, 
	ventas.codmesa, 
	ventas.tipodocumento, 
	ventas.totalpago,
	ventas.creditopagado,
	ventas.montodelivery, 
	ventas.delivery, 
	ventas.repartidor, 
	clientes.dnicliente, 
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente, 
	salas.nomsala, 
	mesas.nommesa, 
	detallepedidos.pedido, 
	detallepedidos.observacionespedido, 
	detallepedidos.cocinero, 
	detallepedidos.fechapedido, 
	detallepedidos.fechaentrega, 
	detallepedidos.tipo,
	GROUP_CONCAT(cantventa, ' | ', producto, ' | ', observacionespedido SEPARATOR '<br>') AS detalles 
	FROM ventas 
	INNER JOIN detallepedidos ON detallepedidos.codpedido = ventas.codpedido 
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente 
	LEFT JOIN mesas ON mesas.codmesa = ventas.codmesa 
	LEFT JOIN salas ON mesas.codsala = salas.codsala 
	WHERE ventas.codmesa != '0' AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') = '".date("Y-m-d")."' AND detallepedidos.cocinero = '1' GROUP BY detallepedidos.codpedido, detallepedidos.pedido, detallepedidos.codventa";
        foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;

    } elseif(limpiar(decrypt($_GET["proceso"]))=="DELIVERY"){

	$sql = "SELECT 
	ventas.idventa, 
	ventas.codpedido, 
	ventas.codventa, 
	ventas.codcliente, 
	ventas.codmesa, 
	ventas.tipodocumento, 
	ventas.totalpago, 
	ventas.creditopagado,
	ventas.montodelivery,
	ventas.delivery, 
	ventas.repartidor, 
	clientes.dnicliente, 
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente, 
	salas.nomsala, 
	mesas.nommesa, 
	detallepedidos.pedido, 
	detallepedidos.observacionespedido, 
	detallepedidos.cocinero, 
	detallepedidos.fechapedido, 
	detallepedidos.fechaentrega,
	detallepedidos.tipo, 
	GROUP_CONCAT(cantventa, ' | ', producto, ' | ', observacionespedido SEPARATOR '<br>') AS detalles 
	FROM ventas 
	INNER JOIN detallepedidos ON detallepedidos.codpedido = ventas.codpedido 
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente 
	LEFT JOIN mesas ON mesas.codmesa = ventas.codmesa 
	LEFT JOIN salas ON mesas.codsala = salas.codsala 
	WHERE ventas.delivery = '1' AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') = '".date("Y-m-d")."' AND detallepedidos.cocinero = '1' GROUP BY detallepedidos.codpedido, detallepedidos.pedido, detallepedidos.codventa";
        foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;

    } elseif(limpiar(decrypt($_GET["proceso"]))=="ENTREGADOS"){	

	$sql = "SELECT 
	ventas.idventa, 
	ventas.codpedido, 
	ventas.codventa, 
	ventas.codcliente, 
	ventas.codmesa, 
	ventas.tipodocumento, 
	ventas.totalpago,
	ventas.creditopagado,
	ventas.montodelivery, 
	ventas.delivery, 
	ventas.repartidor, 
	clientes.dnicliente, 
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente, 
	salas.nomsala, 
	mesas.nommesa, 
	detallepedidos.pedido, 
	detallepedidos.observacionespedido, 
	detallepedidos.cocinero, 
	detallepedidos.fechapedido, 
	detallepedidos.fechaentrega,
	detallepedidos.tipo, 
	GROUP_CONCAT(cantventa, ' | ', producto, ' | ', observacionespedido SEPARATOR '<br>') AS detalles 
	FROM ventas 
	INNER JOIN detallepedidos ON detallepedidos.codpedido = ventas.codpedido 
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente 
	LEFT JOIN mesas ON mesas.codmesa = ventas.codmesa 
	LEFT JOIN salas ON mesas.codsala = salas.codsala 
	WHERE detallepedidos.cocinero = '0' AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') = '".date("Y-m-d")."' GROUP BY detallepedidos.codpedido, detallepedidos.pedido, detallepedidos.codventa ORDER BY detallepedidos.fechapedido DESC";
        foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################### FUNCION LISTAR PEDIDOS EN MOSTRADOR ########################

################## FUNCION PARA ENTREGA DE PEDIDOS POR COCINERO #####################
public function EntregarPedidoMesa()
	{
	self::SetNames();

	if(limpiar(decrypt($_GET["delivery"]))=="0"){
		
	$sql = "UPDATE detallepedidos set "
		  ." cocinero = ?, "
		  ." fechaentrega = ? "
		  ." WHERE "
		  ." codpedido = ? AND pedido = ? AND codventa = ?;
		   ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $cocinero);
	$stmt->bindParam(2, $fechaentrega);
	$stmt->bindParam(3, $codpedido);
	$stmt->bindParam(4, $pedido);
  	$stmt->bindParam(5, $codventa);
	
	$cocinero = limpiar("0");
	$fechaentrega = limpiar(date("Y-m-d H:i:s"));
	$codpedido = limpiar(decrypt($_GET["codpedido"]));
	$pedido = limpiar(decrypt($_GET["pedido"]));
  	$codventa = limpiar(decrypt($_GET["codventa"]));
	$stmt->execute();
	
    echo "1";
    exit;

	} else {
		
  	$sql = "UPDATE detallepedidos set "
  	." cocinero = ?, "
	." fechaentrega = ? "
  	." WHERE "
  	." codpedido = ? AND pedido = ? AND codventa = ?;
  	";
  	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $cocinero);
	$stmt->bindParam(2, $fechaentrega);
	$stmt->bindParam(3, $codpedido);
	$stmt->bindParam(4, $pedido);
  	$stmt->bindParam(5, $codventa);

  	$cocinero = limpiar("0");
	$fechaentrega = limpiar(date("Y-m-d H:i:s"));
  	$codpedido = limpiar(decrypt($_GET["codpedido"]));
  	$pedido = limpiar(decrypt($_GET["pedido"]));
  	$codventa = limpiar(decrypt($_GET["codventa"]));
  	$stmt->execute();
	
    echo "2";
	exit;

	}
}
##################### FUNCION PARA ENTREGA DE PEDIDOS POR COCINERO ###################

######################### FUNCION LISTAR DELIVERY EN MOSTRADOR ########################
public function ListarDelivery()
	{
	self::SetNames();

	if(limpiar(decrypt($_GET["proceso"]))=="TODOS"){

	$sql = "SELECT 
	ventas.idventa, 
	ventas.codventa, 
	ventas.codpedido, 
	ventas.codcliente, 
	ventas.codmesa, 
	ventas.tipodocumento, 
	ventas.totalpago,
	ventas.creditopagado,
	ventas.montodelivery, 
	ventas.delivery, 
	ventas.repartidor, 
	ventas.entregado, 
	clientes.dnicliente, 
	clientes.nomcliente, 
	clientes.direccliente, 
	clientes.tlfcliente, 
	detallepedidos.pedido, 
	detallepedidos.observacionespedido, 
	detallepedidos.cocinero,
	detallepedidos.tipo, 
	GROUP_CONCAT(cantventa, ' | ', producto, ' | ', observacionespedido SEPARATOR '<br>') AS detalles 
	FROM ventas 
	INNER JOIN detallepedidos ON detallepedidos.codpedido = ventas.codpedido 
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente 
	LEFT JOIN usuarios ON ventas.repartidor = usuarios.codigo
	WHERE ventas.repartidor = '".$_SESSION["codigo"]."' 
	AND ventas.entregado = 1 
	GROUP BY detallepedidos.codpedido, detallepedidos.pedido, detallepedidos.codventa";
	    foreach ($this->dbh->query($sql) as $row)
	    {
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	
	} else {

	$sql = "SELECT 
	ventas.idventa, 
	ventas.codventa, 
	ventas.codpedido, 
	ventas.codcliente, 
	ventas.codmesa, 
	ventas.tipodocumento, 
	ventas.totalpago,
	ventas.creditopagado,
	ventas.montodelivery, 
	ventas.delivery, 
	ventas.repartidor, 
	ventas.entregado, 
	clientes.dnicliente, 
	clientes.nomcliente, 
	clientes.direccliente, 
	clientes.tlfcliente, 
	detallepedidos.pedido, 
	detallepedidos.observacionespedido, 
	detallepedidos.cocinero,
	detallepedidos.tipo, 
	GROUP_CONCAT(cantventa, ' | ', producto, ' | ', observacionespedido SEPARATOR '<br>') AS detalles 
	FROM ventas 
	INNER JOIN detallepedidos ON detallepedidos.codpedido = ventas.codpedido 
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente 
	LEFT JOIN usuarios ON ventas.repartidor = usuarios.codigo 
	WHERE ventas.repartidor = '".$_SESSION["codigo"]."' 
	AND ventas.entregado = 0 
	GROUP BY detallepedidos.codpedido, detallepedidos.pedido, detallepedidos.codventa";
        foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
######################### FUNCION LISTAR DELIVERY EN MOSTRADOR ########################

################## FUNCION PARA ENTREGA DE PEDIDOS POR DELIVERY #####################
public function EntregarPedidoDelivery()
{
	self::SetNames();
	
	$sql = "UPDATE ventas set "
		  ." entregado = ? "
		  ." WHERE "
		  ." codpedido = ? AND codventa = ?;
		   ";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $entregado);
	$stmt->bindParam(2, $codpedido);
	$stmt->bindParam(3, $codventa);
	
	$entregado = strip_tags("0");
	$codpedido = limpiar(decrypt($_GET["codpedido"]));
  	$codventa = limpiar(decrypt($_GET["codventa"]));
	$stmt->execute();
	
    echo "1";
    exit;
}
##################### FUNCION PARA ENTREGA DE PEDIDOS POR DELIVERY ###################

########################## FUNCION BUSQUEDA DE VENTAS ###############################
public function BusquedaVentas()
	{
	self::SetNames();
	$sql = "SELECT 
	ventas.idventa, 
	ventas.codventa, 
	ventas.codmesa,
	ventas.tipodocumento, 
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codcliente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva,
	ventas.descontado, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2,
	ventas.creditopagado, 
	ventas.montodelivery,
	ventas.tipopago, 
	ventas.formapago, 
	ventas.formapago2,
	ventas.montopagado, 
	ventas.montopagado2,
	ventas.montopropina,
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.delivery,
	ventas.repartidor,
	ventas.observaciones,
	ventas.docelectronico, 
	cajas.nrocaja,
	cajas.nomcaja,
	clientes.documcliente, 
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente, 
	documentos.documento,
	SUM(detalleventas.cantventa) AS articulos 
	FROM (ventas LEFT JOIN detalleventas ON detalleventas.codventa = ventas.codventa)
	LEFT JOIN mesas ON ventas.codmesa = mesas.codmesa 
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja 
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo WHERE CONCAT(ventas.tipodocumento, '',ventas.codfactura, '',ventas.tipopago, '',ventas.formapago, if(ventas.codcliente='0','0',clientes.dnicliente)) LIKE '%".limpiar($_GET['bventas'])."%' AND ventas.statuspago = '0' GROUP BY detalleventas.codventa ORDER BY ventas.idventa DESC LIMIT 0,60";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0) {

	echo "<center><div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</div></center>";
	exit;
		
	} else {
			
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################## FUNCION BUSQUEDA DE VENTAS ###############################

################################## FUNCION LISTAR VENTAS ################################
public function ListarVentas()
{
	self::SetNames();

if ($_SESSION['acceso'] == "administrador") {

	$sql = "SELECT 
	ventas.idventa, 
	ventas.codventa, 
	ventas.codmesa,
	ventas.tipodocumento, 
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codcliente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva,
	ventas.descontado, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2,
	ventas.creditopagado, 
	ventas.montodelivery,
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado,
	ventas.formapago2, 
	ventas.montopagado2,
	ventas.formapropina,
	ventas.montopropina,
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.delivery,
	ventas.repartidor,
	ventas.observaciones,
	ventas.docelectronico, 
	cajas.nrocaja,
	cajas.nomcaja,
	clientes.documcliente, 
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente, 
	documentos.documento,
	SUM(detalleventas.cantventa) AS articulos 
	FROM (ventas LEFT JOIN detalleventas ON detalleventas.codventa = ventas.codventa)
	LEFT JOIN mesas ON ventas.codmesa = mesas.codmesa 
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja 
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo WHERE ventas.statuspago = '0' GROUP BY detalleventas.codventa";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;

 } else {

    $sql = "SELECT 
	ventas.idventa, 
	ventas.codventa, 
	ventas.codmesa,
	ventas.tipodocumento, 
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codcliente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva,
	ventas.descontado, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2,
	ventas.creditopagado,
	ventas.montodelivery, 
	ventas.tipopago, 
	ventas.formapago,
	ventas.montopagado, 
	ventas.formapago2, 
	ventas.montopagado2,
	ventas.formapropina,
	ventas.montopropina,
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
	ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.delivery,
	ventas.repartidor,
	ventas.observaciones,
	ventas.docelectronico,
	cajas.nrocaja,
	cajas.nomcaja,
	clientes.documcliente, 
	clientes.dnicliente,
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,  
	documentos.documento,
	SUM(detalleventas.cantventa) AS articulos 
	FROM (ventas LEFT JOIN detalleventas ON detalleventas.codventa = ventas.codventa)
	LEFT JOIN mesas ON ventas.codmesa = mesas.codmesa 
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja 
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo WHERE ventas.codigo = '".limpiar($_SESSION["codigo"])."' AND ventas.statuspago = '0' GROUP BY detalleventas.codventa";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
    }
}
################################## FUNCION LISTAR VENTAS ############################

############################ FUNCION ID VENTAS #################################
public function VentasPorId()
	{
	self::SetNames();
	$sql = "SELECT 
	ventas.idventa, 
	ventas.codpedido,
	ventas.codventa,
	ventas.codmesa,
	ventas.tipodocumento, 
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codcliente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva,
	ventas.descontado, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2,
	ventas.creditopagado,
	ventas.montodelivery, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado,
	ventas.formapago2,
	ventas.montopagado2,
	ventas.formapropina,
	ventas.montopropina,
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
    ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.delivery,
	ventas.repartidor,
    ventas.observaciones,
    ventas.docelectronico, 
    salas.nomsala,
    mesas.nommesa,
    clientes.tipocliente,
	clientes.codcliente,
	clientes.documcliente,
	clientes.dnicliente,
    CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,  
	clientes.girocliente,
	clientes.tlfcliente, 
	clientes.id_provincia, 
	clientes.id_departamento, 
	clientes.direccliente, 
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
    cajas.nrocaja,
    cajas.nomcaja,
    usuarios.dni, 
    usuarios.nombres,
    provincias.provincia,
    departamentos.departamento,
	ROUND(SUM(if(pag.montocredito!='0',pag.montocredito,'0')), 2) montoactual,
    ROUND(SUM(if(pag.montocredito!='0',clientes.limitecredito-pag.montocredito,clientes.limitecredito)), 2) creditodisponible,
    pag2.abonototal
    FROM (ventas LEFT JOIN mesas ON ventas.codmesa = mesas.codmesa)
    LEFT JOIN salas ON mesas.codsala = salas.codsala
    LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento 
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
    
    LEFT JOIN
        (SELECT
        codcliente, montocredito       
        FROM creditosxclientes) pag ON pag.codcliente = clientes.codcliente
    
    LEFT JOIN
        (SELECT
        codventa, codcliente, SUM(if(montoabono!='0',montoabono,'0')) AS abonototal
        FROM abonoscreditos 
        WHERE codventa = '".limpiar(decrypt($_GET["codventa"]))."') pag2 ON pag2.codcliente = clientes.codcliente
        WHERE ventas.codventa = ? AND ventas.statuspago = '0'";
    $stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codventa"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID VENTAS #################################
	
############################ FUNCION VER DETALLES VENTAS #############################
public function VerDetallesVentas()
	{
	self::SetNames();
	$sql = "SELECT
	detalleventas.coddetalleventa,
	detalleventas.codventa,
	detalleventas.idproducto,
	detalleventas.codproducto,
	detalleventas.producto,
	detalleventas.codcategoria,
	detalleventas.cantventa,
	detalleventas.preciocompra,
	detalleventas.precioventa,
	detalleventas.ivaproducto,
	detalleventas.descproducto,
	detalleventas.valortotal, 
	detalleventas.totaldescuentov,
	detalleventas.valorneto,
	detalleventas.valorneto2,
	detalleventas.detallesobservaciones,
	detalleventas.tipo,
	categorias.nomcategoria
	FROM detalleventas LEFT JOIN categorias ON detalleventas.codcategoria = categorias.codcategoria
	WHERE detalleventas.codventa = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codventa"])));
	$num = $stmt->rowCount();
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$this->p[]=$row;
	}
		return $this->p;
		$this->dbh=null;
}
########################### FUNCION VER DETALLES VENTAS ###########################

############################# FUNCION ACTUALIZAR VENTAS #############################
public function ActualizarVentas()
	{
	self::SetNames();
	if(empty($_POST["codpedido"]) or empty($_POST["codventa"]))
	{
		echo "1";
		exit;
	}

    ############ CONSULTO TOTAL EN FACTURA ##############
	$sql = "SELECT 
	totalpago,
	totalpago2,
	montodelivery 
	FROM ventas 
	WHERE codventa = '".limpiar($_POST["codventa"])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$totalpagobd = $row['totalpago'];
	$totalpago2bd = $row['totalpago2'];
	$montodeliverybd = $row['montodelivery'];
	############ CONSULTO TOTAL EN FACTURA ##############

    ################### SELECCIONE LOS DATOS DEL CLIENTE ######################
    $sql = "SELECT
    CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente, 
    clientes.emailcliente, 
    clientes.limitecredito,
    ROUND(SUM(if(pag.montocredito!='0',pag.montocredito,'0.00')), 2) montoactual,
    ROUND(SUM(if(pag.montocredito!='0',clientes.limitecredito-pag.montocredito,clientes.limitecredito)), 2) creditodisponible
    FROM clientes 
    LEFT JOIN
       (SELECT
       codcliente, montocredito       
       FROM creditosxclientes) pag ON pag.codcliente = clientes.codcliente
       WHERE clientes.codcliente = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar($_POST['codcliente'])));
	$num = $stmt->rowCount();
	if($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$p[] = $row;
	}
    $nomcliente = $row['nomcliente'];
    $emailcliente = $row['emailcliente'];
    $limitecredito = $row['limitecredito'];
    $montoactual = $row['montoactual'];
    $creditodisponible = $row['creditodisponible'];
    $montoabono = (empty($_POST["abonototal"]) ? "0.00" : $_POST["abonototal"]);
    $total = number_format($_POST["txtTotal"], 2, '.', '');

	for($i=0;$i<count($_POST['coddetalleventa']);$i++){  //recorro el array
		if (!empty($_POST['coddetalleventa'][$i])) {

			if($_POST['cantventa'][$i]==0){

				echo "2";
				exit();

			}
		}
	}
	################### SELECCIONE LOS DATOS DEL CLIENTE ######################

	$this->dbh->beginTransaction();
	for($i=0;$i<count($_POST['coddetalleventa']);$i++){  //recorro el array
	if (!empty($_POST['coddetalleventa'][$i])) {

	    $sql = "SELECT 
	    cantventa 
	    FROM detalleventas 
	    WHERE coddetalleventa = '".limpiar($_POST['coddetalleventa'][$i])."' 
	    AND codventa = '".limpiar($_POST["codventa"])."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$cantidadbd = $row['cantventa'];

	if($cantidadbd != $_POST['cantventa'][$i]){

	if(limpiar($_POST['tipo'][$i]) == 1){

	    ############### VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA ############
	    $sql = "SELECT 
	    existencia, 
	    controlstockp 
	    FROM productos 
	    WHERE codproducto = '".limpiar($_POST['codproducto'][$i])."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$existenciaproductobd = $row['existencia'];
		$controlproductobd = $row['controlstockp'];
		$cantventa = number_format($_POST['cantventa'][$i], 2, '.', '');
		$cantidadventabd = number_format($_POST['cantidadventabd'][$i], 2, '.', '');
		$totalventa = $cantventa-$cantidadventabd;
		############### VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA ############

        if ($totalventa > $existenciaproductobd) 
        { 
		    echo "4";
		    exit;
	    }

	} else {

		############### VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA EN COMBO ############
	    $sql = "SELECT existencia FROM combos WHERE codcombo = '".limpiar($_POST['codproducto'][$i])."'";
		    foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$existenciacombobd = $row['existencia'];
		$cantventa = $_POST["cantventa"][$i];
		$cantidadventabd = $_POST["cantidadventabd"][$i];
		$totalventa = $cantventa-$cantidadventabd;

        if ($totalventa > $existenciacombobd) 
        { 
		    echo "4";
		    exit;
	    }
	    ############### VALIDO SI LA CANTIDAD ES MAYOR QUE LA EXISTENCIA EN COMBO ############

	}

	    $query = "UPDATE detalleventas set"
		." cantventa = ?, "
		." valortotal = ?, "
		." totaldescuentov = ?, "
		." valorneto = ?, "
		." valorneto2 = ? "
		." WHERE "
		." coddetalleventa = ? AND codventa = ?;
		";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $cantventa);
		$stmt->bindParam(2, $valortotal);
		$stmt->bindParam(3, $totaldescuentov);
		$stmt->bindParam(4, $valorneto);
		$stmt->bindParam(5, $valorneto2);
		$stmt->bindParam(6, $coddetalleventa);
		$stmt->bindParam(7, $codventa);

		$cantventa = number_format($_POST['cantventa'][$i], 2, '.', '');
		$preciocompra = limpiar($_POST['preciocompra'][$i]);
		$precioventa = limpiar($_POST['precioventa'][$i]);
		$ivaproducto = limpiar($_POST['ivaproducto'][$i]);
		$descuento = $_POST['descproducto'][$i]/100;
		$valortotal = number_format($_POST['valortotal'][$i], 2, '.', '');
		$totaldescuento = number_format($_POST['totaldescuentov'][$i], 2, '.', '');
		$valorneto = number_format($_POST['valorneto'][$i], 2, '.', '');
		$valorneto2 = number_format($_POST['valorneto2'][$i], 2, '.', '');
		$coddetalleventa = limpiar($_POST['coddetalleventa'][$i]);
		$codventa = limpiar($_POST["codventa"]);
		$stmt->execute();

	if(limpiar($_POST['tipo'][$i]) == 1){

   ############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################

	if($controlproductobd == 1){
	
		##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
		$sql = " UPDATE productos set "
			  ." existencia = ? "
			  ." WHERE "
			  ." codproducto = '".limpiar($_POST["codproducto"][$i])."';
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$existencia = number_format($existenciaproductobd-$totalventa, 2, '.', '');
		$stmt->execute();
		##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################

		############# ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX ###################
		$sql3 = " UPDATE kardex_productos set "
		      ." salidas = ?, "
		      ." stockactual = ? "
			  ." WHERE "
			  ." codproceso = '".limpiar($_POST["codventa"])."' AND codproducto = '".limpiar($_POST["codproducto"][$i])."';
			   ";
		$stmt = $this->dbh->prepare($sql3);
		$stmt->bindParam(1, $salidas);
		$stmt->bindParam(2, $existencia);
		
		$salidas = number_format($_POST['cantventa'][$i], 2, '.', '');
		$existencia = number_format($existenciaproductobd-$totalventa, 2, '.', '');
		$stmt->execute();
		############# ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX ###################
	}

    ############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################		

	} else {

	############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################
	
		##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
		$sql = " UPDATE combos set "
			  ." existencia = ? "
			  ." where "
			  ." codcombo = '".limpiar($_POST["codproducto"][$i])."';
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$existencia = number_format($existenciacombobd-$totalventa, 2, '.', '');
		$stmt->execute();
		##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################

		############# ACTUALIZAMOS LOS DATOS DEL PRODUCTO EN KARDEX ###################
		$sql3 = " UPDATE kardex_combos set "
		      ." salidas = ?, "
		      ." stockactual = ? "
			  ." WHERE "
			  ." codproceso = '".limpiar($_POST["codventa"])."' AND codcombo = '".limpiar($_POST["codproducto"][$i])."';
			   ";
		$stmt = $this->dbh->prepare($sql3);
		$stmt->bindParam(1, $salidas);
		$stmt->bindParam(2, $existencia);
		
		$salidas = number_format($_POST['cantventa'][$i], 2, '.', '');
		$existencia = number_format($existenciacombobd-$totalventa, 2, '.', '');
		$stmt->execute();

    ############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################

	}	


    ############################### PROCESO PARA VERIFICAR LOS INGREDIENTES ######################################	

		############## VERIFICO SSI EL PRODUCTO TIENE INGREDIENTES RELACIONADOS #################
	    $sql = "SELECT * FROM productosxingredientes WHERE codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(limpiar($_POST["codproducto"][$i])));
		$num = $stmt->rowCount();
        if($num>0) {  

        	$sql = "SELECT * FROM productosxingredientes LEFT JOIN ingredientes ON productosxingredientes.codingrediente = ingredientes.codingrediente WHERE productosxingredientes.codproducto IN ('".$_POST["codproducto"][$i]."')";
        	foreach ($this->dbh->query($sql) as $row)
		    { 
			   $this->p[] = $row;

			   $cantracionbd = $row['cantracion'];
			   $codingredientebd = $row['codingrediente'];
			   $cantingredientebd = $row['cantingrediente'];
			   $precioventaingredientebd = $row['precioventa'];
			   $ivaingredientebd = $row['ivaingrediente'];
			   $descingredientebd = $row['descingrediente'];
		       $controlingredientebd = $row['controlstocki'];

		    if($controlingredientebd == 1){

			   ############## ACTUALIZO LOS DATOS DEL INGREDIENTE #################
			   $update = "UPDATE ingredientes set "
			   ." cantingrediente = ? "
			   ." WHERE "
			   ." codingrediente = ?;
			   ";
			   $stmt = $this->dbh->prepare($update);
			   $stmt->bindParam(1, $cantidadracion);
			   $stmt->bindParam(2, $codingredientebd);

			   $racion = number_format($cantracionbd*$totalventa, 2, '.', '');
			   $cantidadracion = number_format($cantingredientebd-$racion, 2, '.', '');
			   $stmt->execute();
			   ############## ACTUALIZO LOS DATOS DEL INGREDIENTE #################

			   ############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################
			   $sql = "SELECT 
			   salidas 
			   FROM kardex_ingredientes 
			   WHERE codproceso = '".limpiar($_POST['codventa'])."' 
			   AND codingrediente = '".limpiar($codingredientebd)."'";
			   foreach ($this->dbh->query($sql) as $row)
			   {
			   	$this->p[] = $row;
			   }
			   $salidakardex = $row['salidas'];
		       ############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################

			   ########## ACTUALIZAMOS LOS DATOS DEL INGREDIENTE EN KARDEX ###################
			   $sql3 = " UPDATE kardex_ingredientes set "
			   ." salidas = ?, "
			   ." stockactual = ? "
			   ." WHERE "
			   ." codproceso = '".limpiar($_POST["codventa"])."' AND codingrediente = '".limpiar($codingredientebd)."';
			   ";
			   $stmt = $this->dbh->prepare($sql3);
			   $stmt->bindParam(1, $salidas);
			   $stmt->bindParam(2, $stockactual);

			   $racion = number_format($cantracionbd*$totalventa, 2, '.', '');
			   $salidas = number_format($salidakardex+$racion, 2, '.', '');
			   
			   $substock = number_format($cantracionbd*$totalventa, 2, '.', '');
			   $stockactual = number_format($cantingredientebd-$substock, 2, '.', '');
			   $stmt->execute();	
			}
		}
	}//fin de consulta de ingredientes de productos	

############################### PROCESO PARA VERIFICAR LOS INGREDIENTES ######################################		


		} else {

           echo "";

	       }
        } 
    }    
    $this->dbh->commit();

    ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############
    $sql3 = "SELECT SUM(totaldescuentov) AS totaldescuentosi, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detalleventas WHERE codventa = '".limpiar($_POST["codventa"])."' AND ivaproducto = 'SI'";
    foreach ($this->dbh->query($sql3) as $row3)
    {
    	$this->p[] = $row3;
    }
    $subtotaldescuentosi = ($row3['totaldescuentosi']== "" ? "0.00" : $row3['totaldescuentosi']);
    $subtotalivasi = ($row3['valorneto']== "" ? "0.00" : $row3['valorneto']);
    $subtotalivasi2 = ($row3['valorneto2']== "" ? "0.00" : $row3['valorneto2']);
    ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############

    ############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############
    $sql4 = "SELECT SUM(totaldescuentov) AS totaldescuentono, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detalleventas WHERE codventa = '".limpiar($_POST["codventa"])."' AND ivaproducto = 'NO'";
    foreach ($this->dbh->query($sql4) as $row4)
    {
    	$this->p[] = $row4;
    }
    $subtotaldescuentono = ($row4['totaldescuentono']== "" ? "0.00" : $row4['totaldescuentono']);
    $subtotalivano = ($row4['valorneto']== "" ? "0.00" : $row4['valorneto']);
    $subtotalivano2 = ($row4['valorneto2']== "" ? "0.00" : $row4['valorneto2']);
    ############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############

    ############ ACTUALIZO LOS TOTALES EN LA COTIZACION ##############
    $sql = " UPDATE ventas SET "
    ." codcliente = ?, "
    ." subtotalivasi = ?, "
    ." subtotalivano = ?, "
    ." totaliva = ?, "
	." descontado = ?, "
    ." descuento = ?, "
    ." totaldescuento = ?, "
    ." totalpago = ?, "
	." totalpago2 = ?, "
	." montodevuelto = ? "
    ." WHERE "
    ." codventa = ?;
    ";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(1, $codcliente);
    $stmt->bindParam(2, $subtotalivasi);
    $stmt->bindParam(3, $subtotalivano);
    $stmt->bindParam(4, $totaliva);
	$stmt->bindParam(5, $descontado);
    $stmt->bindParam(6, $descuento);
    $stmt->bindParam(7, $totaldescuento);
    $stmt->bindParam(8, $totalpago);
    $stmt->bindParam(9, $totalpago2);
	$stmt->bindParam(10, $montodevuelto);
    $stmt->bindParam(11, $codventa);

    $codcliente = limpiar($_POST["codcliente"]);
    $iva = $_POST["iva"]/100;
    $totaliva = number_format($subtotalivasi*$iva, 2, '.', '');
	$descontado = number_format($subtotaldescuentosi+$subtotaldescuentono, 2, '.', '');
    $descuento = limpiar($_POST["descuento"]);
    $txtDescuento = $_POST["descuento"]/100;
    $total = number_format($_POST["txtsubtotal"]+$_POST["txtsubtotal2"]+$_POST["txtIva"], 2, '.', '');
    $totaldescuento = number_format($_POST["txtDescuento"], 2, '.', '');
    $totalpago = number_format($_POST["txtTotal"], 2, '.', '');
    $totalpago2 = number_format($_POST["txtTotalCompra"], 2, '.', '');
    $txttotal = number_format($_POST["txtTotal"]+$montodeliverybd, 2, '.', '');
	$montodevuelto = number_format($totalpago > $_POST["pagado"] ? "0.00" : $_POST["pagado"]-$txttotal, 2, '.', '');
    $codventa = limpiar($_POST["codventa"]);
    $tipodocumento = limpiar($_POST["tipodocumento"]);
    $tipopago = limpiar($_POST["tipopago"]);
    $stmt->execute();

    ################ AGREGAMOS O QUITAMOS LA DIFERENCIA EN CAJA ####################
	if (limpiar($_POST["tipopago"]=="CONTADO") && $totalpagobd != $totalpago){

		$sql = "SELECT 
		efectivo, 
		cheque, 
		tcredito, 
		tdebito, 
		tprepago, 
		transferencia, 
		electronico,
		cupon, 
		otros
		FROM arqueocaja 
		WHERE codcaja = '".limpiar($_POST["codcaja"])."' 
		AND statusarqueo = 1";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$efectivo = ($row['efectivo']== "" ? "0.00" : $row['efectivo']);
		$cheque = ($row['cheque']== "" ? "0.00" : $row['cheque']);
		$tcredito = ($row['tcredito']== "" ? "0.00" : $row['tcredito']);
		$tdebito = ($row['tdebito']== "" ? "0.00" : $row['tdebito']);
		$tprepago = ($row['tprepago']== "" ? "0.00" : $row['tprepago']);
		$transferencia = ($row['transferencia']== "" ? "0.00" : $row['transferencia']);
		$electronico = ($row['electronico']== "" ? "0.00" : $row['electronico']);
		$cupon = ($row['cupon']== "" ? "0.00" : $row['cupon']);
		$otros = ($row['otros']== "" ? "0.00" : $row['otros']);

		if ($totalpagobd > $totalpago){
	
	    ########################## PROCESO LA 1ERA FORMA DE PAGO #################################
		$sql = "UPDATE arqueocaja set "
		." efectivo = ?, "
		." cheque = ?, "
		." tcredito = ?, "
		." tdebito = ?, "
		." tprepago = ?, "
		." transferencia = ?, "
		." electronico = ?, "
		." cupon = ?, "
		." otros = ? "
		." WHERE "
		." codcaja = ? AND statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtEfectivo);
		$stmt->bindParam(2, $txtCheque);
		$stmt->bindParam(3, $txtTcredito);
		$stmt->bindParam(4, $txtTdebito);
		$stmt->bindParam(5, $txtTprepago);
		$stmt->bindParam(6, $txtTransferencia);
		$stmt->bindParam(7, $txtElectronico);
		$stmt->bindParam(8, $txtCupon);
		$stmt->bindParam(9, $txtOtros);
		$stmt->bindParam(10, $caja);

$txtEfectivo = limpiar($_POST["formapago"] == "EFECTIVO" ? number_format($efectivo-($totalpagobd-$totalpago), 2, '.', '') : $efectivo);
$txtCheque = limpiar($_POST["formapago"] == "CHEQUE" ? number_format($cheque-($totalpagobd-$totalpago), 2, '.', '') : $cheque);
$txtTcredito = limpiar($_POST["formapago"] == "TARJETA DE CREDITO" ? number_format($tcredito-($totalpagobd-$totalpago), 2, '.', '') : $tcredito);
$txtTdebito = limpiar($_POST["formapago"] == "TARJETA DE DEBITO" ? number_format($tdebito-($totalpagobd-$totalpago), 2, '.', '') : $tdebito);
$txtTprepago = limpiar($_POST["formapago"] == "TARJETA PREPAGO" ? number_format($tprepago-($totalpagobd-$totalpago), 2, '.', '') : $tprepago);
$txtTransferencia = limpiar($_POST["formapago"] == "TRANSFERENCIA" ? number_format($transferencia-($totalpagobd-$totalpago), 2, '.', '') : $transferencia);
$txtElectronico = limpiar($_POST["formapago"] == "DINERO ELECTRONICO" ? number_format($electronico-($totalpagobd-$totalpago), 2, '.', '') : $electronico);
$txtCupon = limpiar($_POST["formapago"] == "CUPON" ? number_format($cupon-($totalpagobd-$totalpago), 2, '.', '') : $cupon);
$txtOtros = limpiar($_POST["formapago"] == "OTROS" ? number_format($otros-($totalpagobd-$totalpago), 2, '.', '') : $otros);
		$codcaja = limpiar($_POST["codcaja"]);
		$stmt->execute();
	########################## PROCESO LA 1ERA FORMA DE PAGO #################################


	if($_POST['formapago2'] != "0"){
	########################## PROCESO LA 2DA FORMA DE PAGO #################################
		
	########################## PROCESO LA 2DA FORMA DE PAGO #################################
	}

		} else {

	########################## PROCESO LA 1ERA FORMA DE PAGO #################################
		$sql = "UPDATE arqueocaja set "
		." efectivo = ?, "
		." cheque = ?, "
		." tcredito = ?, "
		." tdebito = ?, "
		." tprepago = ?, "
		." transferencia = ?, "
		." electronico = ?, "
		." cupon = ?, "
		." otros = ? "
		." WHERE "
		." codcaja = ? AND statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtEfectivo);
		$stmt->bindParam(2, $txtCheque);
		$stmt->bindParam(3, $txtTcredito);
		$stmt->bindParam(4, $txtTdebito);
		$stmt->bindParam(5, $txtTprepago);
		$stmt->bindParam(6, $txtTransferencia);
		$stmt->bindParam(7, $txtElectronico);
		$stmt->bindParam(8, $txtCupon);
		$stmt->bindParam(9, $txtOtros);
		$stmt->bindParam(10, $caja);

$txtEfectivo = limpiar($_POST["formapago"] == "EFECTIVO" ? number_format($efectivo+($totalpago-$totalpagobd), 2, '.', '') : $efectivo);
$txtCheque = limpiar($_POST["formapago"] == "CHEQUE" ? number_format($cheque+($totalpago-$totalpagobd), 2, '.', '') : $cheque);
$txtTcredito = limpiar($_POST["formapago"] == "TARJETA DE CREDITO" ? number_format($tcredito+($totalpago-$totalpagobd), 2, '.', '') : $tcredito);
$txtTdebito = limpiar($_POST["formapago"] == "TARJETA DE DEBITO" ? number_format($tdebito+($totalpago-$totalpagobd), 2, '.', '') : $tdebito);
$txtTprepago = limpiar($_POST["formapago"] == "TARJETA PREPAGO" ? number_format($tprepago+($totalpago-$totalpagobd), 2, '.', '') : $tprepago);
$txtTransferencia = limpiar($_POST["formapago"] == "TRANSFERENCIA" ? number_format($transferencia+($totalpago-$totalpagobd), 2, '.', '') : $transferencia);
$txtElectronico = limpiar($_POST["formapago"] == "DINERO ELECTRONICO" ? number_format($electronico+($totalpago-$totalpagobd), 2, '.', '') : $electronico);
$txtCupon = limpiar($_POST["formapago"] == "CUPON" ? number_format($cupon+($totalpago-$totalpagobd), 2, '.', '') : $cupon);
$txtOtros = limpiar($_POST["formapago"] == "OTROS" ? number_format($otros+($totalpago-$totalpagobd), 2, '.', '') : $otros);
		$codcaja = limpiar($_POST["codcaja"]);
		$stmt->execute();	
	########################## PROCESO LA 1ERA FORMA DE PAGO #################################

	if($_POST['formapago2'] != "0"){
	########################## PROCESO LA 2DA FORMA DE PAGO #################################
		
	########################## PROCESO LA 2DA FORMA DE PAGO #################################
	}


	    }
	}
    ############### AGREGAMOS O QUITAMOS LA DIFERENCIA EN CAJA ####################

    ############## AGREGAMOS O QUITAMOS LA DIFERENCIA EN CAJA ##################
	if (limpiar($_POST["tipopago"]=="CREDITO") && $totalpagobd != $totalpago) {

		$sql = "SELECT 
		efectivo, 
		cheque, 
		tcredito, 
		tdebito, 
		tprepago, 
		transferencia, 
		electronico,
		cupon, 
		otros,
		creditos,
		abonosefectivo,
		abonosotros
		FROM arqueocaja WHERE codcaja = '".limpiar($_POST["codcaja"])."' AND statusarqueo = 1";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$efectivo = ($row['efectivo']== "" ? "0.00" : $row['efectivo']);
		$cheque = ($row['cheque']== "" ? "0.00" : $row['cheque']);
		$tcredito = ($row['tcredito']== "" ? "0.00" : $row['tcredito']);
		$tdebito = ($row['tdebito']== "" ? "0.00" : $row['tdebito']);
		$tprepago = ($row['tprepago']== "" ? "0.00" : $row['tprepago']);
		$transferencia = ($row['transferencia']== "" ? "0.00" : $row['transferencia']);
		$electronico = ($row['electronico']== "" ? "0.00" : $row['electronico']);
		$cupon = ($row['cupon']== "" ? "0.00" : $row['cupon']);
		$otros = ($row['otros']== "" ? "0.00" : $row['otros']);

		$sql = " UPDATE arqueocaja SET "
		   ." creditos = ? "
		   ." WHERE "
		   ." codcaja = ? and statusarqueo = 1;
		    ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $TxtTotal);
		$stmt->bindParam(2, $caja);

		$TxtTotal = number_format(($totalpagobd>$totalpago ? $credito-($totalpagobd-$totalpago) : $credito+($totalpago-$totalpagobd)), 2, '.', '');
		$codcaja = limpiar($_POST["codcaja"]);
		$stmt->execute();	

		$sql = "UPDATE creditosxclientes set"
		." montocredito = ? "
		." WHERE "
		." codcliente = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $montocredito);
		$stmt->bindParam(2, $codcliente);

        $montocredito = number_format(($totalpagobd>$totalpago ? $montoactual-($totalpagobd-$totalpago) : $montoactual+($totalpago-$totalpagobd)), 2, '.', '');
		$codcliente = limpiar($_POST["codcliente"]);
		$stmt->execute(); 
	}
    ############## AGREGAMOS O QUITAMOS LA DIFERENCIA EN CAJA ##################

echo "<span class='fa fa-check-square-o'></span> LA VENTA DE PRODUCTOS HA SIDO ACTUALIZADA EXITOSAMENTE <a href='reportepdf?codventa=".encrypt($codventa)."&tipo=".encrypt($tipodocumento)."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR REPORTE</strong></font color></a></div>";

echo "<script>window.open('reportepdf?codventa=".encrypt($codventa)."&tipo=".encrypt($tipodocumento)."', '_blank');</script>";
	exit;
}
############################ FUNCION ACTUALIZAR VENTAS ###########################

########################### FUNCION AGREGAR DETALLES VENTAS ##########################
public function AgregarDetallesVentas()
{
	self::SetNames();
}
########################## FUNCION AGREGAR DETALLES VENTAS ##########################

######################## FUNCION ELIMINAR DETALLES VENTAS #######################
public function EliminarDetallesVentas()
{
	self::SetNames();
	if ($_SESSION["acceso"]=="administrador") {

    ############ CONSULTO TOTAL EN FACTURA ##############
	$sql = "SELECT 
	codpedido, 
	codventa, 
	codcaja, 
	codcliente, 
	tipopago,
	formapago,
	formapago2, 
	totalpago 
	FROM ventas 
	WHERE codventa = '".limpiar(decrypt($_GET["codventa"]))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$codpedidobd = $row['codpedido'];
	$codventabd = $row['codventa'];
	$cajabd = $row['codcaja'];
	$clientebd = $row['codcliente'];
	$tipopagobd = $row['tipopago'];
	$formapagobd = $row['formapago'];
	$formapago2bd = $row['formapago2'];
	$totalpagobd = $row['totalpago'];
	############ CONSULTO TOTAL EN FACTURA ##############

	################### VERIFICO MONTO DE CREDITO DEL CLIENTE ######################
	$sql = "SELECT 
	montocredito 
	FROM creditosxclientes 
	WHERE codcliente = '".$clientebd."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
    $monto = (empty($row['montocredito']) ? "0.00" : $row['montocredito']);
    ################### VERIFICO MONTO DE CREDITO DEL CLIENTE ######################

	################### CUENTO LOS DETALLES DE PRODUCTOS DE ESTA FACTURA ######################
	$sql = "SELECT * FROM detalleventas WHERE codventa = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codventa"])));
	$num = $stmt->rowCount();
	if($num > 1)
	{

		################### VERIFICO EL DETALLE DE PRODUCTO DE ESTA FACTURA ######################
		$sql = "SELECT
		idproducto,  
		codproducto, 
		cantventa, 
		precioventa, 
		ivaproducto, 
		descproducto,
		tipo  
		FROM detalleventas 
		WHERE coddetalleventa = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(decrypt($_GET["coddetalleventa"])));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$idproductobd = $row['idproducto'];
		$codproductobd = $row['codproducto'];
		$cantidadbd = $row['cantventa'];
		$precioventabd = $row['precioventa'];
		$ivaproductobd = $row['ivaproducto'];
		$descproductobd = $row['descproducto'];
		################### VERIFICO EL DETALLE DE PRODUCTO DE ESTA FACTURA ######################

    if(limpiar($tipobd) == 1){

    ############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################		

		############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################
		$sql2 = "SELECT 
		existencia, 
		controlstockp 
		FROM productos 
		WHERE codproducto = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute(array($codproductobd));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$existenciaproductobd = $row['existencia'];
	    $controlproductobd = $row['controlstockp'];
		############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################	

		if($controlproductobd == 1){

			########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############
			$sql = "UPDATE productos SET "
			." existencia = ? "
			." WHERE "
			." codproducto = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $existencia);
			$stmt->bindParam(2, $codproductobd);

			$existencia = limpiar($existenciaproductobd+$cantidadbd);
			$stmt->execute();
			########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############

		    ######## REGISTRAMOS LOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ###########
			$query = "INSERT INTO kardex_productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $codventabd);
			$stmt->bindParam(2, $codcliente);
			$stmt->bindParam(3, $codproductobd);
			$stmt->bindParam(4, $movimiento);
			$stmt->bindParam(5, $entradas);
			$stmt->bindParam(6, $salidas);
			$stmt->bindParam(7, $devolucion);
			$stmt->bindParam(8, $stockactual);
			$stmt->bindParam(9, $ivaproducto);
			$stmt->bindParam(10, $descproducto);
			$stmt->bindParam(11, $precio);
			$stmt->bindParam(12, $documento);
			$stmt->bindParam(13, $fechakardex);		

			$codcliente = limpiar(decrypt($_GET["codcliente"]) == '' ? "0" : decrypt($_GET["codcliente"]));
			$movimiento = limpiar("DEVOLUCION");
			$entradas= limpiar("0");
			$salidas = limpiar("0");
			$devolucion = limpiar($cantidadbd);
			$stockactual = limpiar($existenciaproductobd+$cantidadbd);
			$precio = limpiar($precioventabd);
			$ivaproducto = limpiar($ivaproductobd);
			$descproducto = limpiar($descproductobd);
			$documento = limpiar("DEVOLUCION DETALLE VENTA");
			$fechakardex = limpiar(date("Y-m-d"));
			$stmt->execute();
			######## REGISTRAMOS LOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ###########
		}
    ############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################		

	} else {

    ############################### PROCESO PARA VERIFICAR LOS COMBOS ######################################		

		############## VERIFICO LA EXISTENCIA DEL COMBO EN ALMACEN #################
		$sql2 = "SELECT existencia FROM combos WHERE codcombo = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute(array($codproductobd));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$existenciacombobd = $row['existencia'];
		############## VERIFICO LA EXISTENCIA DEL COMBO EN ALMACEN #################	

		########### ACTUALIZAMOS LA EXISTENCIA DE COMBO EN ALMACEN #############
		$sql = "UPDATE combos SET "
		." existencia = ? "
		." WHERE "
		." codcombo = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$stmt->bindParam(2, $codproductobd);

		$existencia = limpiar($existenciacombobd+$cantidadbd);
		$stmt->execute();
		########### ACTUALIZAMOS LA EXISTENCIA DE COMBO EN ALMACEN #############

	    ######## REGISTRAMOS LOS DATOS DEL COMBO ELIMINADO EN KARDEX ###########
		$query = "INSERT INTO kardex_combos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codventabd);
		$stmt->bindParam(2, $codcliente);
		$stmt->bindParam(3, $codproductobd);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivacombo);
		$stmt->bindParam(10, $desccombo);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);		

		$codcliente = limpiar(decrypt($_GET["codcliente"]) == '' ? "0" : decrypt($_GET["codcliente"]));
		$movimiento = limpiar("DEVOLUCION");
		$entradas= limpiar("0");
		$salidas = limpiar("0");
		$devolucion = limpiar($cantidadbd);
		$stockactual = limpiar($existenciacombobd+$cantidadbd);
		$precio = limpiar($precioventabd);
		$ivacombo = limpiar($ivaproductobd);
		$desccombo = limpiar($descproductobd);
		$documento = limpiar("DEVOLUCION DETALLE VENTA");
		$fechakardex = limpiar(date("Y-m-d"));
		$stmt->execute();
		######## REGISTRAMOS LOS DATOS DEL COMBO ELIMINADO EN KARDEX ###########
			
    ############################### PROCESO PARA VERIFICAR LOS COMBOS ######################################	

	}

    ############################### PROCESO PARA VERIFICAR LOS INGREDIENTES ###################################	

	############## VERIFICO SI EL PRODUCTO TIENE INGREDIENTES RELACIONADOS #################
	$sql = "SELECT * FROM productosxingredientes WHERE codproducto = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar($codproductobd)));
	$num = $stmt->rowCount();
	if($num>0) {  

		$sql = "SELECT * FROM productosxingredientes LEFT JOIN ingredientes ON productosxingredientes.codingrediente = ingredientes.codingrediente WHERE productosxingredientes.codproducto IN ('".$codproductobd."')";
		foreach ($this->dbh->query($sql) as $row)
		{ 
			$this->p[] = $row;

			$cantracionbd = $row['cantracion'];
			$codingredientebd = $row['codingrediente'];
			$cantingredientebd = $row['cantingrediente'];
			$precioventaingredientebd = $row['precioventa'];
			$ivaingredientebd = $row['ivaingrediente'];
			$descingredientebd = $row['descingrediente'];
            $controlingredientebd = $row['controlstocki'];

		    if($controlingredientebd == 1){

			   ############## ACTUALIZO LOS DATOS DEL INGREDIENTE #################
			   $update = "UPDATE ingredientes set "
			   ." cantingrediente = ? "
			   ." WHERE "
			   ." codingrediente = ?;
			   ";
			   $stmt = $this->dbh->prepare($update);
			   $stmt->bindParam(1, $cantidadracion);
			   $stmt->bindParam(2, $codingredientebd);

			   $racion = number_format($cantracionbd*$cantidadbd, 2, '.', '');
			   $cantidadracion = number_format($cantingredientebd+$racion, 2, '.', '');
			   $stmt->execute();
			   ############## ACTUALIZO LOS DATOS DEL INGREDIENTE #################

			   ############## REGISTRAMOS LOS DATOS DE INGREDIENTES EN KARDEX ###################
			   $query = "INSERT INTO kardex_ingredientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
			   $stmt = $this->dbh->prepare($query);
			   $stmt->bindParam(1, $codventabd);
			   $stmt->bindParam(2, $codcliente);
			   $stmt->bindParam(3, $codingrediente);
			   $stmt->bindParam(4, $movimiento);
			   $stmt->bindParam(5, $entradas);
			   $stmt->bindParam(6, $salidas);
			   $stmt->bindParam(7, $devolucion);
			   $stmt->bindParam(8, $stockactual);
			   $stmt->bindParam(9, $ivaingrediente);
			   $stmt->bindParam(10, $descingrediente);
			   $stmt->bindParam(11, $precio);
			   $stmt->bindParam(12, $documento);
			   $stmt->bindParam(13, $fechakardex);		

			   $codcliente = limpiar(decrypt($_GET["codcliente"]) == '' ? "0" : decrypt($_GET["codcliente"]));
			   $codingrediente = limpiar($codingredientebd);
			   $movimiento = limpiar("DEVOLUCION");
			   $entradas = limpiar("0");
			   $salidas= limpiar("0");
			   $devolucion = limpiar($racion);
			   $stockactual = number_format($cantidadracion, 2, '.', '');
			   $precio = limpiar($precioventaingredientebd);
			   $ivaingrediente = limpiar($ivaingredientebd);
			   $descingrediente = limpiar($descingredientebd);
			   $documento = limpiar("DEVOLUCION DETALLE VENTA");
			   $fechakardex = limpiar(date("Y-m-d"));
			   $stmt->execute();
			}
		}
	}//fin de consulta de ingredientes de productos	

    ############################### PROCESO PARA VERIFICAR LOS INGREDIENTES ###################################	


		############ ELIMINO EL DETALLE EN FACTURA ##############
		$sql = "DELETE FROM detalleventas WHERE coddetalleventa = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$coddetalleventa);
		$coddetalleventa = decrypt($_GET["coddetalleventa"]);
		$stmt->execute();
		############ ELIMINO EL DETALLE EN FACTURA ##############

	    ############ CONSULTO LOS TOTALES DE VENTAS ##############
		$sql2 = "SELECT iva, descuento FROM ventas WHERE codventa = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute(array(decrypt($_GET["codventa"])));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$paea[] = $row;
		}
		$iva = $paea[0]["iva"]/100;
		$descuento = $paea[0]["descuento"]/100;
		############ CONSULTO LOS TOTALES DE VENTAS ##############

        ############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############
		$sql3 = "SELECT SUM(totaldescuentov) AS totaldescuentosi, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detalleventas WHERE codventa = '".limpiar(decrypt($_GET["codventa"]))."' AND ivaproducto = 'SI'";
		foreach ($this->dbh->query($sql3) as $row3)
		{
			$this->p[] = $row3;
		}
		$subtotaldescuentosi = ($row3['totaldescuentosi']== "" ? "0.00" : $row3['totaldescuentosi']);
		$subtotalivasi = ($row3['valorneto']== "" ? "0.00" : $row3['valorneto']);
		$subtotalivasi2 = ($row3['valorneto2']== "" ? "0.00" : $row3['valorneto2']);
		############ SUMO LOS IMPORTE DE PRODUCTOS CON IVA ##############

	    ############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############
		$sql4 = "SELECT SUM(totaldescuentov) AS totaldescuentono, SUM(valorneto) AS valorneto, SUM(valorneto2) AS valorneto2 FROM detalleventas WHERE codventa = '".limpiar(decrypt($_GET["codventa"]))."' AND ivaproducto = 'NO'";
		foreach ($this->dbh->query($sql4) as $row4)
		{
			$this->p[] = $row4;
		}
		$subtotaldescuentono = ($row4['totaldescuentono']== "" ? "0.00" : $row4['totaldescuentono']);
		$subtotalivano = ($row4['valorneto']== "" ? "0.00" : $row4['valorneto']);
		$subtotalivano2 = ($row4['valorneto2']== "" ? "0.00" : $row4['valorneto2']);
		############ SUMO LOS IMPORTE DE PRODUCTOS SIN IVA ##############

        ############ ACTUALIZO LOS TOTALES EN LA COTIZACION ##############
		$sql = " UPDATE ventas SET "
		." subtotalivasi = ?, "
		." subtotalivano = ?, "
		." totaliva = ?, "
		." descontado = ?, "
		." totaldescuento = ?, "
		." totalpago = ?, "
		." totalpago2= ? "
		." WHERE "
		." codventa = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $subtotalivasi);
		$stmt->bindParam(2, $subtotalivano);
		$stmt->bindParam(3, $totaliva);
		$stmt->bindParam(4, $descontado);
		$stmt->bindParam(5, $totaldescuento);
		$stmt->bindParam(6, $totalpago);
		$stmt->bindParam(7, $totalpago2);
		$stmt->bindParam(8, $codventa);

		$totaliva= number_format($subtotalivasi*$iva, 2, '.', '');
		$descontado = number_format($subtotaldescuentosi+$subtotaldescuentono, 2, '.', '');
		$total= number_format($subtotalivasi+$subtotalivano+$totaliva, 2, '.', '');
		$totaldescuento= number_format($total*$descuento, 2, '.', '');
		$totalpago= number_format($total-$totaldescuento, 2, '.', '');
		$totalpago2 = number_format($subtotalivasi2+$subtotalivano2, 2, '.', '');
		$codventa = limpiar(decrypt($_GET["codventa"]));
		$stmt->execute();
		############ ACTUALIZO LOS TOTALES EN LA COTIZACION ##############

	#################### QUITAMOS LA DIFERENCIA EN CAJA DE CONTADO ####################
	if (limpiar($tipopagobd=="CONTADO")){	

		$sql = "SELECT 
		efectivo, 
		cheque, 
		tcredito, 
		tdebito, 
		tprepago, 
		transferencia, 
		electronico,
		cupon, 
		otros
		FROM arqueocaja WHERE codcaja = '".limpiar($cajabd)."' AND statusarqueo = 1";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$efectivo = ($row['efectivo']== "" ? "0.00" : $row['efectivo']);
		$cheque = ($row['cheque']== "" ? "0.00" : $row['cheque']);
		$tcredito = ($row['tcredito']== "" ? "0.00" : $row['tcredito']);
		$tdebito = ($row['tdebito']== "" ? "0.00" : $row['tdebito']);
		$tprepago = ($row['tprepago']== "" ? "0.00" : $row['tprepago']);
		$transferencia = ($row['transferencia']== "" ? "0.00" : $row['transferencia']);
		$electronico = ($row['electronico']== "" ? "0.00" : $row['electronico']);
		$cupon = ($row['cupon']== "" ? "0.00" : $row['cupon']);
		$otros = ($row['otros']== "" ? "0.00" : $row['otros']);

		$sql = "UPDATE arqueocaja set "
		." efectivo = ?, "
		." cheque = ?, "
		." tcredito = ?, "
		." tdebito = ?, "
		." tprepago = ?, "
		." transferencia = ?, "
		." electronico = ?, "
		." cupon = ?, "
		." otros = ? "
		." WHERE "
		." codcaja = ? AND statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtEfectivo);
		$stmt->bindParam(2, $txtCheque);
		$stmt->bindParam(3, $txtTcredito);
		$stmt->bindParam(4, $txtTdebito);
		$stmt->bindParam(5, $txtTprepago);
		$stmt->bindParam(6, $txtTransferencia);
		$stmt->bindParam(7, $txtElectronico);
		$stmt->bindParam(8, $txtCupon);
		$stmt->bindParam(9, $txtOtros);
		$stmt->bindParam(10, $cajabd);

$MontoCalculo = number_format($totalpagobd-$totalpago, 2, '.', '');
$txtEfectivo = limpiar($formapagobd == "EFECTIVO" ? number_format($efectivo-$MontoCalculo, 2, '.', '') : $efectivo);
$txtCheque = limpiar($formapagobd == "CHEQUE" ? number_format($cheque-$MontoCalculo, 2, '.', '') : $cheque);
$txtTcredito = limpiar($formapagobd == "TARJETA DE CREDITO" ? number_format($tcredito-$MontoCalculo, 2, '.', '') : $tcredito);
$txtTdebito = limpiar($formapagobd == "TARJETA DE DEBITO" ? number_format($tdebito-$MontoCalculo, 2, '.', '') : $tdebito);
$txtTprepago = limpiar($formapagobd == "TARJETA PREPAGO" ? number_format($tprepago-$MontoCalculo, 2, '.', '') : $tprepago);
$txtTransferencia = limpiar($formapagobd == "TRANSFERENCIA" ? number_format($transferencia-$MontoCalculo, 2, '.', '') : $transferencia);
$txtElectronico = limpiar($formapagobd == "DINERO ELECTRONICO" ? number_format($electronico-$MontoCalculo, 2, '.', '') : $electronico);
$txtCupon = limpiar($formapagobd == "CUPON" ? number_format($cupon-$MontoCalculo, 2, '.', '') : $cupon);
$txtOtros = limpiar($formapagobd == "OTROS" ? number_format($otros-$MontoCalculo, 2, '.', '') : $otros);
		$stmt->execute();
	}
    #################### QUITAMOS LA DIFERENCIA EN CAJA DE CONTADO ####################

    #################### QUITAMOS LA DIFERENCIA EN CAJA DE CREDITO ####################
	if (limpiar($tipopagobd=="CREDITO")){

		$sql = "SELECT 
		efectivo, 
		cheque, 
		tcredito, 
		tdebito, 
		tprepago, 
		transferencia, 
		electronico,
		cupon, 
		otros,
		creditos,
		abonosefectivo,
		abonosotros
		FROM arqueocaja WHERE codcaja = '".limpiar($cajabd)."' AND statusarqueo = 1";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$efectivo = ($row['efectivo']== "" ? "0.00" : $row['efectivo']);
		$cheque = ($row['cheque']== "" ? "0.00" : $row['cheque']);
		$tcredito = ($row['tcredito']== "" ? "0.00" : $row['tcredito']);
		$tdebito = ($row['tdebito']== "" ? "0.00" : $row['tdebito']);
		$tprepago = ($row['tprepago']== "" ? "0.00" : $row['tprepago']);
		$transferencia = ($row['transferencia']== "" ? "0.00" : $row['transferencia']);
		$electronico = ($row['electronico']== "" ? "0.00" : $row['electronico']);
		$cupon = ($row['cupon']== "" ? "0.00" : $row['cupon']);
		$otros = ($row['otros']== "" ? "0.00" : $row['otros']);

		$sql = " UPDATE arqueocaja SET "
		    ." creditos = ? "
		    ." WHERE "
		    ." codcaja = ? and statusarqueo = 1;
		    ";
		    $stmt = $this->dbh->prepare($sql);
		    $stmt->bindParam(1, $TxtTotal);
		    $stmt->bindParam(2, $cajabd);

		    $Calculo = number_format($totalpagobd-$totalpago, 2, '.', '');
		    $TxtTotal = number_format($credito-$Calculo, 2, '.', '');
		    $stmt->execute();

		$sql = "UPDATE creditosxclientes set"
		    ." montocredito = ? "
			." WHERE "
			." codcliente = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $montocredito);
			$stmt->bindParam(2, $clientebd);

			$montocredito = number_format($monto-$Calculo, 2, '.', '');
			$stmt->execute(); 	
	}
    #################### QUITAMOS LA DIFERENCIA EN CAJA DE CREDITO ####################

		echo "1";
		exit;

	} else {

		echo "2";
		exit;
	} 

	} else {
		
		echo "3";
		exit;
	}	
}
##################### FUNCION ELIMINAR DETALLES VENTAS #################################

########################## FUNCION ELIMINAR VENTAS #################################
public function EliminarVentas()
{
	self::SetNames();
	if ($_SESSION["acceso"]=="administrador") {

        ############ CONSULTO TOTAL EN FACTURA ##############
		$sql = "SELECT 
		codpedido, 
		codventa, 
		codcaja, 
		codcliente, 
		tipopago,
		formapago,
		formapago2, 
		totalpago 
		FROM ventas 
		WHERE codventa = '".limpiar(decrypt($_GET["codventa"]))."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$codpedidobd = $row['codpedido'];
		$codventabd = $row['codventa'];
		$cajabd = $row['codcaja'];
		$clientebd = $row['codcliente'];
		$tipopagobd = $row['tipopago'];
		$formapagobd = $row['formapago'];
		$formapago2bd = $row['formapago2'];
		$totalpagobd = $row['totalpago'];
		############ CONSULTO TOTAL EN FACTURA ##############

	    ################### CONSULTO DETALLES DE PRODUCTOS EN FACTURA ######################
	    $sql = "SELECT * FROM detalleventas WHERE codventa = '".limpiar(decrypt($_GET["codventa"]))."'";
	    foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;

		$idproductobd = $row['idproducto'];
		$codproductobd = $row['codproducto'];
		$cantidadbd = $row['cantventa'];
		$precioventabd = $row['precioventa'];
		$ivaproductobd = $row['ivaproducto'];
		$descproductobd = $row['descproducto'];
		$tipobd = $row['tipo'];
		################### CONSULTO DETALLES DE PRODUCTOS EN FACTURA ######################

		################### VERIFICO MONTO DE CREDITO DEL CLIENTE ######################
		$sql = "SELECT montocredito FROM creditosxclientes WHERE codcliente = '".$clientebd."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
        $monto = (empty($row['montocredito']) ? "0.00" : $row['montocredito']);
        ################### VERIFICO MONTO DE CREDITO DEL CLIENTE ######################	

    if(limpiar($tipobd) == 1){

    ############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################		

		############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################
		$sql2 = "SELECT existencia, controlstockp FROM productos WHERE codproducto = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute(array($codproductobd));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$existenciaproductobd = $row['existencia'];
	    $controlproductobd = $row['controlstockp'];
		############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################	 

        if($controlproductobd == 1){

			########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN ###############
			$sql = "UPDATE productos SET "
			." existencia = ? "
			." WHERE "
			." codproducto = ?;
			";
			$stmt = $this->dbh->prepare($sql);
			$stmt->bindParam(1, $existencia);
			$stmt->bindParam(2, $codproductobd);

			$existencia = limpiar($existenciaproductobd+$cantidadbd);
			$stmt->execute();
			########### ACTUALIZAMOS LA EXISTENCIA DE PRODUCTO EN ALMACEN #############

		    ########## REGISTRAMOS LOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ########
			$query = "INSERT INTO kardex_productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
			$stmt = $this->dbh->prepare($query);
			$stmt->bindParam(1, $codventabd);
			$stmt->bindParam(2, $codcliente);
			$stmt->bindParam(3, $codproductobd);
			$stmt->bindParam(4, $movimiento);
			$stmt->bindParam(5, $entradas);
			$stmt->bindParam(6, $salidas);
			$stmt->bindParam(7, $devolucion);
			$stmt->bindParam(8, $stockactual);
			$stmt->bindParam(9, $ivaproducto);
			$stmt->bindParam(10, $descproducto);
			$stmt->bindParam(11, $precio);
			$stmt->bindParam(12, $documento);
			$stmt->bindParam(13, $fechakardex);		

			$codcliente = limpiar(decrypt($_GET["codcliente"]) == '' ? "0" : decrypt($_GET["codcliente"]));
			$movimiento = limpiar("DEVOLUCION");
			$entradas= limpiar("0");
			$salidas = limpiar("0");
			$devolucion = limpiar($cantidadbd);
			$stockactual = limpiar($existenciaproductobd+$cantidadbd);
			$precio = limpiar($precioventabd);
			$ivaproducto = limpiar($ivaproductobd);
			$descproducto = limpiar($descproductobd);
			$documento = limpiar("DEVOLUCION VENTA GENERAL");
			$fechakardex = limpiar(date("Y-m-d"));
			$stmt->execute();
			########## REGISTRAMOS LOS DATOS DEL PRODUCTO ELIMINADO EN KARDEX ########
		}
    ############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################	

	} else {

    ############################### PROCESO PARA VERIFICAR LOS COMBOS ######################################		

		############## VERIFICO LA EXISTENCIA DEL COMBO EN ALMACEN #################
		$sql2 = "SELECT existencia FROM combos WHERE codcombo = ?";
		$stmt = $this->dbh->prepare($sql2);
		$stmt->execute(array($codproductobd));
		$num = $stmt->rowCount();

		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$p[] = $row;
		}
		$existenciacombobd = $row['existencia'];
		############## VERIFICO LA EXISTENCIA DEL COMBO EN ALMACEN #################	

		########### ACTUALIZAMOS LA EXISTENCIA DE COMBO EN ALMACEN ###############
		$sql = "UPDATE combos SET "
		." existencia = ? "
		." WHERE "
		." codcombo = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$stmt->bindParam(2, $codproductobd);

		$existencia = limpiar($existenciacombobd+$cantidadbd);
		$stmt->execute();
		########### ACTUALIZAMOS LA EXISTENCIA DE COMBO EN ALMACEN #############

	    ########## REGISTRAMOS LOS DATOS DEL COMBO ELIMINADO EN KARDEX ########
		$query = "INSERT INTO kardex_combos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codventabd);
		$stmt->bindParam(2, $codcliente);
		$stmt->bindParam(3, $codproductobd);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivacombo);
		$stmt->bindParam(10, $desccombo);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);		

		$codcliente = limpiar(decrypt($_GET["codcliente"]) == '' ? "0" : decrypt($_GET["codcliente"]));
		$movimiento = limpiar("DEVOLUCION");
		$entradas= limpiar("0");
		$salidas = limpiar("0");
		$devolucion = limpiar($cantidadbd);
		$stockactual = limpiar($existenciacombobd+$cantidadbd);
		$precio = limpiar($precioventabd);
		$ivacombo = limpiar($ivaproductobd);
		$desccombo = limpiar($descproductobd);
		$documento = limpiar("DEVOLUCION VENTA GENERAL");
		$fechakardex = limpiar(date("Y-m-d"));
		$stmt->execute();
		########## REGISTRAMOS LOS DATOS DEL COMBO ELIMINADO EN KARDEX ########

    ############################### PROCESO PARA VERIFICAR LOS COMBOS ######################################	

	}


    ############################### PROCESO PARA VERIFICAR LOS INGREDIENTES ###################################	

		############## VERIFICO SI EL PRODUCTO TIENE INGREDIENTES RELACIONADOS #################
		$sql = "SELECT * FROM productosxingredientes WHERE codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(limpiar($codproductobd)));
		$num = $stmt->rowCount();
		if($num>0) {  

			############## CONSULTO LOS DATOS DE INGREDIENTES #################
			$sql = "SELECT * FROM productosxingredientes LEFT JOIN ingredientes ON productosxingredientes.codingrediente = ingredientes.codingrediente WHERE productosxingredientes.codproducto IN ('".$codproductobd."')";
			foreach ($this->dbh->query($sql) as $row)
			{ 
				$this->p[] = $row;

			$cantracionbd = $row['cantracion'];
			$codingredientebd = $row['codingrediente'];
			$cantingredientebd = $row['cantingrediente'];
			$precioventaingredientebd = $row['precioventa'];
			$ivaingredientebd = $row['ivaingrediente'];
			$descingredientebd = $row['descingrediente'];
	        $controlingredientebd = $row['controlstocki'];
		    ############## CONSULTO LOS DATOS DE INGREDIENTES #################	

		    if($controlingredientebd == 1){	

			    ############## ACTUALIZO LOS DATOS DEL INGREDIENTE #################
			   $update = "UPDATE ingredientes set "
			   ." cantingrediente = ? "
			   ." WHERE "
			   ." codingrediente = ?;
			   ";
			   $stmt = $this->dbh->prepare($update);
			   $stmt->bindParam(1, $cantidadracion);
			   $stmt->bindParam(2, $codingredientebd);

			   $racion = number_format($cantracionbd*$cantidadbd, 2, '.', '');
			   $cantidadracion = number_format($cantingredientebd+$racion, 2, '.', '');
			   $stmt->execute();
			   ############## ACTUALIZO LOS DATOS DEL INGREDIENTE #################

			   ############## REGISTRAMOS LOS DATOS DE INGREDIENTES EN KARDEX ###################
			   $query = "INSERT INTO kardex_ingredientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
			   $stmt = $this->dbh->prepare($query);
			   $stmt->bindParam(1, $codventabd);
			   $stmt->bindParam(2, $codcliente);
			   $stmt->bindParam(3, $codingrediente);
			   $stmt->bindParam(4, $movimiento);
			   $stmt->bindParam(5, $entradas);
			   $stmt->bindParam(6, $salidas);
			   $stmt->bindParam(7, $devolucion);
			   $stmt->bindParam(8, $stockactual);
			   $stmt->bindParam(9, $ivaingrediente);
			   $stmt->bindParam(10, $descingrediente);
			   $stmt->bindParam(11, $precio);
			   $stmt->bindParam(12, $documento);
			   $stmt->bindParam(13, $fechakardex);		

			   $codcliente = limpiar(decrypt($_GET["codcliente"]) == '' ? "0" : decrypt($_GET["codcliente"]));
			   $codingrediente = limpiar($codingredientebd);
			   $movimiento = limpiar("DEVOLUCION");
			   $entradas = limpiar("0");
			   $salidas= limpiar("0");
			   $devolucion = limpiar($racion);
			   $stockactual = number_format($cantidadracion, 2, '.', '');
			   $precio = limpiar($precioventaingredientebd);
			   $ivaingrediente = limpiar($ivaingredientebd);
			   $descingrediente = limpiar($descingredientebd);
			   $documento = limpiar("DEVOLUCION VENTA GENERAL");
			   $fechakardex = limpiar(date("Y-m-d"));
			   $stmt->execute();
            }
        }
    }//fin de consulta de ingredientes de productos 

############################### PROCESO PARA VERIFICAR LOS INGREDIENTES ###################################	

		}//fin de detalles ventas

	#################### QUITAMOS LA DIFERENCIA EN CAJA DE CONTADO ####################
	if (limpiar($tipopagobd=="CONTADO")){	

		$sql = "SELECT 
		efectivo, 
		cheque, 
		tcredito, 
		tdebito, 
		tprepago, 
		transferencia, 
		electronico,
		cupon, 
		otros
		FROM arqueocaja WHERE codcaja = '".limpiar($cajabd)."' AND statusarqueo = 1";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$efectivo = ($row['efectivo']== "" ? "0.00" : $row['efectivo']);
		$cheque = ($row['cheque']== "" ? "0.00" : $row['cheque']);
		$tcredito = ($row['tcredito']== "" ? "0.00" : $row['tcredito']);
		$tdebito = ($row['tdebito']== "" ? "0.00" : $row['tdebito']);
		$tprepago = ($row['tprepago']== "" ? "0.00" : $row['tprepago']);
		$transferencia = ($row['transferencia']== "" ? "0.00" : $row['transferencia']);
		$electronico = ($row['electronico']== "" ? "0.00" : $row['electronico']);
		$cupon = ($row['cupon']== "" ? "0.00" : $row['cupon']);
		$otros = ($row['otros']== "" ? "0.00" : $row['otros']);

		$sql = "UPDATE arqueocaja set "
		." efectivo = ?, "
		." cheque = ?, "
		." tcredito = ?, "
		." tdebito = ?, "
		." tprepago = ?, "
		." transferencia = ?, "
		." electronico = ?, "
		." cupon = ?, "
		." otros = ? "
		." WHERE "
		." codcaja = ? AND statusarqueo = 1;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtEfectivo);
		$stmt->bindParam(2, $txtCheque);
		$stmt->bindParam(3, $txtTcredito);
		$stmt->bindParam(4, $txtTdebito);
		$stmt->bindParam(5, $txtTprepago);
		$stmt->bindParam(6, $txtTransferencia);
		$stmt->bindParam(7, $txtElectronico);
		$stmt->bindParam(8, $txtCupon);
		$stmt->bindParam(9, $txtOtros);
		$stmt->bindParam(10, $cajabd);

$txtEfectivo = limpiar($formapagobd == "EFECTIVO" ? number_format($efectivo-$totalpagobd, 2, '.', '') : $efectivo);
$txtCheque = limpiar($formapagobd == "CHEQUE" ? number_format($cheque-$totalpagobd, 2, '.', '') : $cheque);
$txtTcredito = limpiar($formapagobd == "TARJETA DE CREDITO" ? number_format($tcredito-$totalpagobd, 2, '.', '') : $tcredito);
$txtTdebito = limpiar($formapagobd == "TARJETA DE DEBITO" ? number_format($tdebito-$totalpagobd, 2, '.', '') : $tdebito);
$txtTprepago = limpiar($formapagobd == "TARJETA PREPAGO" ? number_format($tprepago-$totalpagobd, 2, '.', '') : $tprepago);
$txtTransferencia = limpiar($formapagobd == "TRANSFERENCIA" ? number_format($transferencia-$totalpagobd, 2, '.', '') : $transferencia);
$txtElectronico = limpiar($formapagobd == "DINERO ELECTRONICO" ? number_format($electronico-$totalpagobd, 2, '.', '') : $electronico);
$txtCupon = limpiar($formapagobd == "CUPON" ? number_format($cupon-$totalpagobd, 2, '.', '') : $cupon);
$txtOtros = limpiar($formapagobd == "OTROS" ? number_format($otros-$totalpagobd, 2, '.', '') : $otros);
		$stmt->execute();
}
    #################### QUITAMOS LA DIFERENCIA EN CAJA DE CONTADO ####################

    #################### QUITAMOS LA DIFERENCIA EN CAJA DE CREDITO ####################
	if (limpiar($tipopagobd=="CREDITO")){

		$sql = "SELECT 
		efectivo, 
		cheque, 
		tcredito, 
		tdebito, 
		tprepago, 
		transferencia, 
		electronico,
		cupon, 
		otros,
		creditos,
		abonosefectivo,
		abonosotros
		FROM arqueocaja WHERE codcaja = '".limpiar($cajabd)."' AND statusarqueo = 1";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$efectivo = ($row['efectivo']== "" ? "0.00" : $row['efectivo']);
		$cheque = ($row['cheque']== "" ? "0.00" : $row['cheque']);
		$tcredito = ($row['tcredito']== "" ? "0.00" : $row['tcredito']);
		$tdebito = ($row['tdebito']== "" ? "0.00" : $row['tdebito']);
		$tprepago = ($row['tprepago']== "" ? "0.00" : $row['tprepago']);
		$transferencia = ($row['transferencia']== "" ? "0.00" : $row['transferencia']);
		$electronico = ($row['electronico']== "" ? "0.00" : $row['electronico']);
		$cupon = ($row['cupon']== "" ? "0.00" : $row['cupon']);
		$otros = ($row['otros']== "" ? "0.00" : $row['otros']);

		$sql = " UPDATE arqueocaja SET "
	    ." creditos = ? "
	    ." WHERE "
	    ." codcaja = ? and statusarqueo = 1;
	    ";
	    $stmt = $this->dbh->prepare($sql);
	    $stmt->bindParam(1, $TxtTotal);
	    $stmt->bindParam(2, $cajabd);

	    $TxtTotal = number_format($credito-$totalpagobd, 2, '.', '');
	    $stmt->execute();

		$sql = "UPDATE creditosxclientes set"
	    ." montocredito = ? "
		." WHERE "
		." codcliente = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $montocredito);
		$stmt->bindParam(2, $clientebd);

		$montocredito = number_format($monto-$totalpagobd, 2, '.', '');
		$stmt->execute(); 	
	}
    #################### QUITAMOS LA DIFERENCIA EN CAJA DE CREDITO ####################

		################## ELIMINO LA VENTA ##################
        $sql = "DELETE FROM ventas WHERE codventa = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codventa);
		$codventa = decrypt($_GET["codventa"]);
		$stmt->execute();
		################## ELIMINO LA VENTA ##################

		################## ELIMINO EL DETALLE DE VENTA ##################
		$sql = "DELETE FROM detalleventas WHERE codventa = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codventa);
		$codventa = decrypt($_GET["codventa"]);
		$stmt->execute();
		################## ELIMINO EL DETALLE DE VENTA ##################

		################## ELIMINO EL DETALLE DE PEDIDOS ##################
		$sql = "DELETE FROM detallepedidos WHERE codventa = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1,$codventa);
		$codventa = decrypt($_GET["codventa"]);
		$stmt->execute();
		################## ELIMINO EL DETALLE DE PEDIDOS ##################

		echo "1";
		exit;

	} else {

		echo "2";
		exit;
	}
}
####################### FUNCION ELIMINAR VENTAS #################################

########################## FUNCION LISTAR VENTAS DIARIAS ################################
public function BuscarVentasDiarias()
{
	self::SetNames();
    $sql = "SELECT 
	ventas.idventa, 
	ventas.codventa,
	ventas.codmesa,
	ventas.tipodocumento, 
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codcliente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva,
	ventas.descontado, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2,
	ventas.creditopagado,
	ventas.montodelivery, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado,
	ventas.formapago2, 
	ventas.montopagado2,
	ventas.formapropina,
	ventas.montopropina, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
    ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa, 
	ventas.delivery,
	ventas.repartidor,
    ventas.observaciones, 
	cajas.nrocaja,
	cajas.nomcaja,
	clientes.documcliente,
	clientes.dnicliente, 
    CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente, 
	clientes.tlfcliente, 
	clientes.id_provincia, 
	clientes.id_departamento, 
	clientes.direccliente, 
	clientes.emailcliente,
	documentos.documento,
	provincias.provincia,
	departamentos.departamento,
	SUM(detalleventas.cantventa) as articulos 
	FROM (ventas LEFT JOIN detalleventas ON detalleventas.codventa=ventas.codventa)
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja 
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento 
	WHERE ventas.codigo = '".limpiar($_SESSION["codigo"])."' 
	AND DATE_FORMAT(ventas.fechaventa,'%d-%m-%Y') = '".date("d-m-Y")."' 
	AND ventas.statuspago = '0' 
	GROUP BY detalleventas.codventa";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	    return $this->p;
		$this->dbh=null;
}
########################### FUNCION LISTAR VENTAS DIARIAS ############################

###################### FUNCION BUSQUEDA VENTAS POR CAJAS ###########################
public function BuscarVentasxCajas() 
{
	self::SetNames();
	$sql ="SELECT 
	ventas.idventa, 
	ventas.codventa,
	ventas.codmesa,
	ventas.tipodocumento, 
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codcliente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva,
	ventas.descontado, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2,
	ventas.creditopagado,
	ventas.montodelivery,
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado,
	ventas.formapago2, 
	ventas.montopagado2,
	ventas.formapropina,
	ventas.montopropina, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
    ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa, 
	ventas.delivery,
	ventas.repartidor,
    ventas.observaciones, 
	cajas.nrocaja,
	cajas.nomcaja,
	clientes.documcliente,
	clientes.dnicliente,
    CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,  
	clientes.tlfcliente, 
	clientes.id_provincia, 
	clientes.id_departamento, 
	clientes.direccliente, 
	clientes.emailcliente,
	documentos.documento,
	provincias.provincia,
	departamentos.departamento,
	usuarios.nombres,
	SUM(detalleventas.cantventa) as articulos 
	FROM (ventas LEFT JOIN detalleventas ON detalleventas.codventa=ventas.codventa)
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja 
	LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento
	 WHERE ventas.codcaja = ? 
	 AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') >= ? 
	 AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') <= ? 
	 AND ventas.statuspago = '0' 
	 GROUP BY detalleventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codcaja'])));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA VENTAS POR CAJAS ###########################

###################### FUNCION BUSQUEDA VENTAS POR FECHAS ###########################
public function BuscarVentasxFechas() 
{
	self::SetNames();
	$sql ="SELECT 
	ventas.idventa, 
	ventas.codventa,
	ventas.codmesa,
	ventas.tipodocumento, 
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codcliente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva,
	ventas.descontado, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.creditopagado,
	ventas.montodelivery,
	ventas.tipopago, 
	ventas.formapago,
	ventas.montopagado, 
	ventas.formapago2, 
	ventas.montopagado2,
	ventas.formapropina,
	ventas.montopropina, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
    ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa, 
	ventas.delivery,
	ventas.repartidor,
    ventas.observaciones,
	clientes.documcliente,
	clientes.dnicliente, 
    CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente, 
	clientes.tlfcliente, 
	clientes.id_provincia, 
	clientes.id_departamento, 
	clientes.direccliente, 
	clientes.emailcliente,
	documentos.documento,
	provincias.provincia,
	departamentos.departamento,
	SUM(detalleventas.cantventa) as articulos 
	FROM (ventas LEFT JOIN detalleventas ON detalleventas.codventa=ventas.codventa)
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento
	WHERE DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') >= ? 
	AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') <= ? 
	AND ventas.statuspago = '0' 
	GROUP BY detalleventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA VENTAS POR FECHAS ###########################

###################### FUNCION BUSQUEDA VENTAS POR CONDICION DE PAGO Y FECHAS ###########################
public function BuscarVentasxCondiciones() 
{
	self::SetNames();
	$sql ="SELECT 
	ventas.idventa, 
	ventas.codventa,
	ventas.codmesa,
	ventas.tipodocumento, 
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codcliente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva,
	ventas.descontado, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2, 
	ventas.creditopagado,
	ventas.montodelivery,
	ventas.tipopago, 
	ventas.formapago,
	ventas.montopagado, 
	ventas.formapago2, 
	ventas.montopagado2,
	ventas.formapropina,
	ventas.montopropina, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
    ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa, 
	ventas.delivery,
	ventas.repartidor,
    ventas.observaciones,
	clientes.documcliente,
	clientes.dnicliente, 
    CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente, 
	clientes.tlfcliente, 
	clientes.id_provincia, 
	clientes.id_departamento, 
	clientes.direccliente, 
	clientes.emailcliente,
	documentos.documento,
	provincias.provincia,
	departamentos.departamento,
	SUM(detalleventas.cantventa) as articulos 
	FROM (ventas LEFT JOIN detalleventas ON detalleventas.codventa=ventas.codventa)
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento
	WHERE ventas.formapago = '".limpiar($_GET['formapago'])."' OR ventas.formapago2 = '".limpiar($_GET['formapago'])."'
	AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') >= ? 
	AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') <= ? 
	AND ventas.statuspago = '0' 
	GROUP BY detalleventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	//$stmt->bindValue(1, trim(decrypt($_GET['formapago'])));
	$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA VENTAS POR CONDICION DE PAGO Y FECHAS ###########################


###################### FUNCION BUSQUEDA DELIVERY POR FECHAS ###########################
public function BuscarDeliveryxFechas() 
{
	self::SetNames();
	$sql ="SELECT 
	ventas.idventa, 
	ventas.codventa,
	ventas.codmesa,
	ventas.tipodocumento, 
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codcliente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva,
	ventas.descontado, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2,
	ventas.creditopagado,
	ventas.montodelivery, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado,
	ventas.formapago2, 
	ventas.montopagado2,
	ventas.formapropina,
	ventas.montopropina, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
    ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa, 
	ventas.delivery,
	ventas.repartidor,
    ventas.observaciones, 
	cajas.nrocaja,
	cajas.nomcaja,
	clientes.documcliente,
	clientes.dnicliente,
    CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,  
	clientes.tlfcliente, 
	clientes.id_provincia, 
	clientes.id_departamento, 
	clientes.direccliente, 
	clientes.emailcliente,
	usuarios.dni,
	usuarios.nombres,
	usuarios.comision,
	usuarios2.dni AS dni2,
	usuarios2.nombres AS nombres2,
	usuarios2.comision AS comision2,
	documentos.documento,
	provincias.provincia,
	departamentos.departamento, 
	SUM(detalleventas.cantventa) as articulos 
	FROM (ventas INNER JOIN detalleventas ON ventas.codventa = detalleventas.codventa)
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja 
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
	LEFT JOIN usuarios AS usuarios2 ON ventas.repartidor = usuarios2.codigo
	WHERE ventas.repartidor = ? 
	AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') >= ? 
	AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') <= ? 
	AND ventas.statusventa = 'PAGADA'
	GROUP BY detalleventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_GET['codigo']));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA DELIVERY POR FECHAS ###########################

###################### FUNCION BUSQUEDA VENTAS POR TIPOS DE CLIENTES ###########################
public function BuscarVentasxTipos() 
{
	self::SetNames();
	$sql ="SELECT 
	ventas.idventa, 
	ventas.codventa,
	ventas.codmesa,
	ventas.tipodocumento, 
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codcliente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva,
	ventas.descontado, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2,
	ventas.creditopagado,
	ventas.montodelivery, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado,
	ventas.formapago2, 
	ventas.montopagado2,
	ventas.formapropina,
	ventas.montopropina, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
    ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa, 
	ventas.delivery,
	ventas.repartidor,
    ventas.observaciones, 
	cajas.nrocaja,
	cajas.nomcaja,
	clientes.documcliente,
	clientes.dnicliente,
    CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,  
	clientes.tlfcliente, 
	clientes.id_provincia, 
	clientes.id_departamento, 
	clientes.direccliente, 
	clientes.emailcliente,
	documentos.documento,
	provincias.provincia,
	departamentos.departamento,
	COUNT(ventas.codcliente) as cantidad,
	SUM(ventas.totalpago) as totalcompras 
	FROM (ventas INNER JOIN clientes ON ventas.codcliente = clientes.codcliente)
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja 
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento
	 WHERE clientes.tipocliente = ? 
	 AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') >= ? 
	 AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') <= ? 
	 AND ventas.statuspago = '0' 
	 GROUP BY ventas.codcliente";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_GET['tipocliente']));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA VENTAS POR TIPOS DE CLIENTES ###########################

###################### FUNCION BUSQUEDA VENTAS POR CLIENTES ###########################
public function BuscarVentasxClientes() 
{
	self::SetNames();
	$sql ="SELECT 
	ventas.idventa, 
	ventas.codventa,
	ventas.codmesa,
	ventas.tipodocumento, 
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codcliente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva,
	ventas.descontado, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2,
	ventas.creditopagado,
	ventas.montodelivery, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado,
	ventas.formapago2, 
	ventas.montopagado2,
	ventas.formapropina,
	ventas.montopropina, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
    ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa, 
	ventas.delivery,
	ventas.repartidor,
    ventas.observaciones, 
	cajas.nrocaja,
	cajas.nomcaja,
	clientes.documcliente,
	clientes.dnicliente,
    CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,  
	clientes.tlfcliente, 
	clientes.id_provincia, 
	clientes.id_departamento, 
	clientes.direccliente, 
	clientes.emailcliente,
	documentos.documento,
	provincias.provincia,
	departamentos.departamento, 
	SUM(detalleventas.cantventa) as articulos 
	FROM (ventas INNER JOIN detalleventas ON ventas.codventa = detalleventas.codventa)
	INNER JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja 
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento
	 WHERE ventas.codcliente = ? 
	 AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') >= ? 
	 AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') <= ? 
	 AND ventas.statuspago = '0' 
	 GROUP BY detalleventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_GET['codcliente']));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA VENTAS POR CLIENTES ###########################

###################### FUNCION BUSQUEDA COMISION POR VENTAS ###########################
public function BuscarComisionxVentas() 
{
	self::SetNames();
	$sql ="SELECT 
	ventas.idventa, 
	ventas.codventa,
	ventas.codmesa,
	ventas.tipodocumento, 
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codcliente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva, 
	ventas.descontado,
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2,
	ventas.creditopagado,
	ventas.montodelivery, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado,
	ventas.formapago2, 
	ventas.montopagado2,
	ventas.formapropina,
	ventas.montopropina, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
    ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa, 
	ventas.delivery,
	ventas.repartidor,
    ventas.observaciones, 
	cajas.nrocaja,
	cajas.nomcaja,
	clientes.documcliente,
	clientes.dnicliente,
    CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,  
	clientes.tlfcliente, 
	clientes.id_provincia, 
	clientes.id_departamento, 
	clientes.direccliente, 
	clientes.emailcliente,
	usuarios.dni,
	usuarios.nombres,
	usuarios.comision,
	documentos.documento,
	provincias.provincia,
	departamentos.departamento, 
	SUM(detalleventas.cantventa) as articulos 
	FROM (ventas INNER JOIN detalleventas ON ventas.codventa = detalleventas.codventa)
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja 
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
	WHERE ventas.codigo = ? 
	AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') >= ? 
	AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') <= ? 
	AND ventas.statusventa = 'PAGADA' 
	AND ventas.statuspago = '0' 
	GROUP BY detalleventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_GET['codigo']));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA COMISION POR VENTAS ###########################

############################## FIN DE CLASE VENTAS ###################################















































###################################### CLASE CREDITOS ###################################

####################### FUNCION REGISTRAR PAGOS A CREDITOS #############################
public function RegistrarPago()
{
	self::SetNames();
	####################### VERIFICO ARQUEO DE CAJA #######################
	$sql = "SELECT * FROM arqueocaja 
	INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	INNER JOIN usuarios ON cajas.codigo = usuarios.codigo 
	WHERE usuarios.codigo = ? AND arqueocaja.statusarqueo = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_SESSION["codigo"]));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "1";
		exit;
		
	} else {
			
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
        $codarqueo = $row['codarqueo'];
        $codcaja = $row['codcaja'];
        $abonoefectivo = ($row['abonosefectivo']== "" ? "0.00" : $row['abonosefectivo']);
        $abonootros = ($row['abonosotros']== "" ? "0.00" : $row['abonosotros']);
	}
	####################### VERIFICO ARQUEO DE CAJA #######################

    if(empty($_POST["codcliente"]) or empty($_POST["codventa"]) or empty($_POST["montoabono"]))
	{
		echo "2";
		exit;
	} 
	else if($_POST["montoabono"] > $_POST["totaldebe"])
	{
		echo "3";
		exit;

	} else {

	################### VERIFICO MONTO DE CREDITO DEL CLIENTE ######################
	$sql = "SELECT montocredito 
	FROM creditosxclientes 
	WHERE codcliente = '".limpiar(decrypt($_POST['codcliente']))."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
    $monto = (empty($row['montocredito']) ? "0.00" : $row['montocredito']);
    ################### VERIFICO MONTO DE CREDITO DEL CLIENTE ######################

	################### INGRESOS EL ABONO DEL CREDITO ######################
	$query = "INSERT INTO abonoscreditos values (null, ?, ?, ?, ?, ?, ?); ";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $codcaja);
	$stmt->bindParam(2, $codventa);
	$stmt->bindParam(3, $codcliente);
	$stmt->bindParam(4, $montoabono);
	$stmt->bindParam(5, $formaabono);
	$stmt->bindParam(6, $fechaabono);

	$codventa = limpiar(decrypt($_POST["codventa"]));
	$codcliente = limpiar(decrypt($_POST["codcliente"]));
	$montoabono = limpiar($_POST["montoabono"]);
	$formaabono = limpiar($_POST["formaabono"]);
	$fechaabono = limpiar(date("Y-m-d H:i:s"));
	$stmt->execute();
	################### INGRESOS EL ABONO DEL CREDITO ######################

	############# ACTUALIZAMNOS DATOS DE CAJA ##############
	$sql = "UPDATE arqueocaja set "
	." abonosefectivo = ?, "
	." abonosotros = ? "
	." WHERE "
	." codcaja = ? AND statusarqueo = 1;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $txtEfectivo);
	$stmt->bindParam(2, $txtOtros);
	$stmt->bindParam(3, $codarqueo);

    $txtEfectivo = limpiar($_POST["formaabono"] == "EFECTIVO" ? number_format($abonoefectivo+$_POST["montoabono"], 2, '.', '') : $abonoefectivo);
    $txtOtros = limpiar($_POST["formaabono"] != "EFECTIVO" ? number_format($abonootros+$_POST["montoabono"], 2, '.', '') : $abonootros);
	$stmt->execute(); 
	############# ACTUALIZAMNOS DATOS DE CAJA ##############

    ############## ACTUALIZAMOS EL MONTO DE CREDITO ##################
	$sql = "UPDATE creditosxclientes set"
	." montocredito = ? "
	." WHERE "
	." codcliente = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $montocredito);
	$stmt->bindParam(2, $codcliente);

    $montocredito = number_format($monto - $_POST["montoabono"], 2, '.', '');
	$codcliente = limpiar(decrypt($_POST["codcliente"]));
	$stmt->execute(); 
	############## ACTUALIZAMOS EL MONTO DE CREDITO ##################

	############## ACTUALIZAMOS EL STATUS DE LA FACTURA ##################
	if($_POST["montoabono"] == $_POST["totaldebe"]) {

		$sql = "UPDATE ventas set "
		." creditopagado = ?, "
		." statusventa = ?, "
		." fechapagado = ? "
		." WHERE "
		." codventa = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $creditopagado);
		$stmt->bindParam(2, $statusventa);
		$stmt->bindParam(3, $fechapagado);
		$stmt->bindParam(4, $codventa);

		$creditopagado = number_format($_POST["totalabono"] + $_POST["montoabono"], 2, '.', '');
		$statusventa = limpiar("PAGADA");
		$fechapagado = limpiar(date("Y-m-d"));
		$codventa = limpiar(decrypt($_POST["codventa"]));
		$stmt->execute();
	
	} else {

		$sql = "UPDATE ventas set "
		." creditopagado = ? "
		." WHERE "
		." codventa = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $creditopagado);
		$stmt->bindParam(2, $codventa);

		$creditopagado = number_format($_POST["totalabono"] + $_POST["montoabono"], 2, '.', '');
		$codventa = limpiar(decrypt($_POST["codventa"]));
		$stmt->execute();
	}
    ############## ACTUALIZAMOS EL STATUS DE LA FACTURA ##################

		
echo "<span class='fa fa-check-square-o'></span> EL ABONO AL CR&Eacute;DITO DE VENTA HA SIDO REGISTRADO EXITOSAMENTE <a href='reportepdf?codventa=".encrypt($codventa)."&tipo=".encrypt("TICKETCREDITO")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR DOCUMENTO</strong></font color></a></div>";

echo "<script>window.open('reportepdf?codventa=".encrypt($codventa)."&tipo=".encrypt("TICKETCREDITO")."', '_blank');</script>";
	exit;
   }
}
##################### FUNCION REGISTRAR PAGOS A CREDITOS ###########################

###################### FUNCION LISTAR CREDITOS ####################### 
public function ListarCreditos()
{
	self::SetNames();
	$sql = "SELECT 
	ventas.idventa,
	ventas.codpedido,
	ventas.codventa,
	ventas.tipodocumento,
	ventas.codfactura, 
	ventas.totalpago,
	ventas.creditopagado,
	ventas.montodelivery, 
	ventas.tipopago,
	ventas.statusventa,
	ventas.fechaventa, 
	ventas.fechavencecredito,
	ventas.fechapagado,
	clientes.codcliente,
	clientes.documcliente, 
	clientes.dnicliente, 
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,  
	clientes.girocliente, 
	clientes.tlfcliente, 
	abonoscreditos.codventa as codigo, 
	abonoscreditos.formaabono,
	abonoscreditos.fechaabono, 
	documentos.documento,
	SUM(abonoscreditos.montoabono) AS abonototal 
	FROM (ventas INNER JOIN clientes ON ventas.codcliente = clientes.codcliente)
	LEFT JOIN abonoscreditos ON ventas.codventa = abonoscreditos.codventa
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	WHERE ventas.tipopago ='CREDITO' 
	AND ventas.statusventa != 'ANULADA' 
	GROUP BY ventas.codventa 
	ORDER BY ventas.idventa DESC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
###################### FUNCION LISTAR CREDITOS ####################### 

############################ FUNCION ID CREDITOS #################################
public function CreditosPorId()
{
	self::SetNames();
	$sql = "SELECT 
	ventas.idventa,
	ventas.codpedido,  
	ventas.codventa,
	ventas.tipodocumento, 
    ventas.codfactura,
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codcliente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva,
	ventas.descontado, 
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2,
	ventas.creditopagado, 
	ventas.montodelivery,
	ventas.tipopago, 
	ventas.formapago, 
	ventas.montopagado,
	ventas.formapago2, 
	ventas.montopagado2,
	ventas.montopropina,
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
    ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
    ventas.observaciones,
	cajas.nrocaja,
	cajas.nomcaja,
	clientes.documcliente,
	clientes.dnicliente, 
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,  
	clientes.girocliente, 
	clientes.tlfcliente, 
	clientes.id_provincia, 
	clientes.id_departamento, 
	clientes.direccliente, 
	clientes.emailcliente,
	documentos.documento,
	usuarios.dni, 
	usuarios.nombres,
	provincias.provincia,
	departamentos.departamento,
	abonoscreditos.formaabono,
	SUM(montoabono) AS abonototal
	FROM (ventas LEFT JOIN abonoscreditos ON ventas.codventa = abonoscreditos.codventa)
	LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento 
	LEFT JOIN cajas ON abonoscreditos.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON cajas.codigo = usuarios.codigo
	WHERE ventas.codventa = ? GROUP BY abonoscreditos.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codventa"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID CREDITOS #################################
	
######################### FUNCION VER DETALLES VENTAS ############################
public function VerDetallesAbonos()
{
	self::SetNames();
	$sql = "SELECT * FROM abonoscreditos 
	INNER JOIN ventas ON abonoscreditos.codventa = ventas.codventa 
	LEFT JOIN cajas ON abonoscreditos.codcaja = cajas.codcaja 
	WHERE abonoscreditos.codventa = ?";	
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET["codventa"])));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
########################## FUNCION VER DETALLES VENTAS ###########################

###################### FUNCION BUSQUEDA CREDITOS POR CLIENTES ###########################
public function BuscarCreditosxClientes() 
{
	self::SetNames();
	$sql = "SELECT 
	ventas.codpedido,
	ventas.codventa, 
	ventas.tipodocumento,
    ventas.codfactura,
	ventas.totalpago, 
	ventas.creditopagado,
	ventas.montodelivery,
	ventas.tipopago,
	ventas.statusventa,
	ventas.fechaventa, 
	ventas.fechavencecredito,
	ventas.fechapagado,
	clientes.codcliente,
	clientes.documcliente, 
	clientes.dnicliente, 
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,  
	clientes.girocliente, 
	clientes.tlfcliente, 
	abonoscreditos.codventa as codigo,
	abonoscreditos.formaabono, 
	abonoscreditos.fechaabono, 
	documentos.documento,
	SUM(abonoscreditos.montoabono) AS abonototal  
	FROM (ventas INNER JOIN clientes ON ventas.codcliente = clientes.codcliente)
	LEFT JOIN abonoscreditos ON ventas.codventa = abonoscreditos.codventa 
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	WHERE ventas.codcliente = ? 
	AND ventas.tipopago ='CREDITO' 
	GROUP BY ventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim($_GET['codcliente']));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA CREDITOS POR CLIENTES ###########################

###################### FUNCION BUSQUEDA CREDITOS POR FECHAS ###########################
public function BuscarCreditosxFechas() 
{
	self::SetNames();
	$sql = "SELECT 
	ventas.codpedido,
	ventas.codventa,
	ventas.tipodocumento,
    ventas.codfactura, 
	ventas.totalpago, 
	ventas.creditopagado,
	ventas.montodelivery,
	ventas.tipopago,
	ventas.statusventa,
	ventas.fechaventa, 
	ventas.fechavencecredito,
	ventas.fechapagado,
	clientes.codcliente,
	clientes.documcliente, 
	clientes.dnicliente, 
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,  
	clientes.girocliente, 
	clientes.tlfcliente, 
	abonoscreditos.codventa as codigo, 
	abonoscreditos.formaabono, 
	abonoscreditos.fechaabono, 
	documentos.documento,
	SUM(abonoscreditos.montoabono) AS abonototal  
	FROM (ventas INNER JOIN clientes ON ventas.codcliente = clientes.codcliente)
	LEFT JOIN abonoscreditos ON ventas.codventa = abonoscreditos.codventa
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	WHERE DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') >= ? 
	AND DATE_FORMAT(ventas.fechaventa,'%Y-%m-%d') <= ?
	AND ventas.tipopago ='CREDITO' GROUP BY ventas.codventa";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "<div class='alert alert-danger'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
		echo "</div>";		
		exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA CREDITOS POR FECHAS ###########################

###################################### CLASE CREDITOS ###################################













































###################################### CLASE NOTA DE CREDITO ###################################

############################ FUNCION ID VENTAS #################################
public function BuscarVentasPorId()
	{
	self::SetNames();
	$sql = "SELECT 
	ventas.idventa, 
	ventas.codpedido,
	ventas.codventa,
	ventas.codmesa,
	ventas.tipodocumento, 
	ventas.codfactura, 
	ventas.codserie, 
	ventas.codautorizacion, 
	ventas.codcaja, 
	ventas.codcliente, 
	ventas.subtotalivasi, 
	ventas.subtotalivano, 
	ventas.iva, 
	ventas.totaliva, 
	ventas.descontado,
	ventas.descuento, 
	ventas.totaldescuento, 
	ventas.totalpago, 
	ventas.totalpago2,
	ventas.creditopagado,
	ventas.montodelivery, 
	ventas.tipopago, 
	ventas.formapago, 
	ventas.formapago2,
	ventas.montopagado,
	ventas.montopropina, 
	ventas.montodevuelto, 
	ventas.fechavencecredito, 
    ventas.fechapagado,
	ventas.statusventa, 
	ventas.fechaventa,
	ventas.delivery,
	ventas.repartidor,
    ventas.observaciones,
    ventas.docelectronico, 
    salas.nomsala,
    mesas.nommesa,
    clientes.tipocliente,
	clientes.codcliente,
	clientes.documcliente,
	clientes.dnicliente,
    CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,  
	clientes.girocliente,
	clientes.tlfcliente, 
	clientes.id_provincia, 
	clientes.id_departamento, 
	clientes.direccliente, 
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
    cajas.nrocaja,
    cajas.nomcaja,
    usuarios.dni, 
    usuarios.nombres,
    provincias.provincia,
    departamentos.departamento,
	ROUND(SUM(if(pag.montocredito!='0',pag.montocredito,'0')), 2) montoactual,
    ROUND(SUM(if(pag.montocredito!='0',clientes.limitecredito-pag.montocredito,clientes.limitecredito)), 2) creditodisponible,
    pag2.abonototal
    FROM (ventas LEFT JOIN mesas ON ventas.codmesa = mesas.codmesa)
    LEFT JOIN salas ON mesas.codsala = salas.codsala
    LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento 
	LEFT JOIN cajas ON ventas.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON ventas.codigo = usuarios.codigo
    
    LEFT JOIN
        (SELECT
        codcliente, montocredito       
        FROM creditosxclientes) pag ON pag.codcliente = clientes.codcliente
    
    LEFT JOIN
        (SELECT
        codventa, codcliente, SUM(if(montoabono!='0',montoabono,'0')) AS abonototal
        FROM abonoscreditos 
        WHERE codventa = '".limpiar($_GET["numeroventa"])."') pag2 ON pag2.codcliente = clientes.codcliente
        WHERE ventas.codventa = ? AND ventas.statuspago = '0'";
    $stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar($_GET["numeroventa"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID VENTAS #################################
	
############################ FUNCION VER DETALLES VENTAS #############################
public function BuscarDetallesVentas()
	{
	self::SetNames();
	$sql = "SELECT
	detalleventas.coddetalleventa,
	detalleventas.codventa,
	detalleventas.idproducto,
	detalleventas.codproducto,
	detalleventas.producto,
	detalleventas.codcategoria,
	detalleventas.cantventa,
	detalleventas.preciocompra,
	detalleventas.precioventa,
	detalleventas.ivaproducto,
	detalleventas.descproducto,
	detalleventas.valortotal, 
	detalleventas.totaldescuentov,
	detalleventas.valorneto,
	detalleventas.valorneto2,
	detalleventas.detallesobservaciones,
	detalleventas.tipo,
	categorias.nomcategoria
	FROM detalleventas LEFT JOIN categorias ON detalleventas.codcategoria = categorias.codcategoria
	WHERE detalleventas.codventa = ?";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar($_GET["numeroventa"])));
	$num = $stmt->rowCount();
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$this->p[]=$row;
	}
	return $this->p;
	$this->dbh=null;
}
########################### FUNCION VER DETALLES VENTAS ###########################

####################### FUNCION REGISTRAR NOTA DE CREDITO #############################
public function RegistrarNotaCredito()
{
	self::SetNames();

	if($_POST["descontar"] == 1){//VERIFICO SI SE DESCONTARA DE CAJA

	####################### VERIFICO ARQUEO DE CAJA #######################
	$sql = "SELECT * FROM arqueocaja 
	INNER JOIN cajas ON arqueocaja.codcaja = cajas.codcaja 
	INNER JOIN usuarios ON cajas.codigo = usuarios.codigo 
	WHERE arqueocaja.codarqueo = ? AND arqueocaja.statusarqueo = 1";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_POST["codarqueo"])));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "1";
		exit;

	} else {
		
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		$codarqueo = $row['codarqueo'];
		$codcaja = $row['codcaja'];
		$SaldoCaja = number_format($row['efectivo']-$row['egresos'], 2, '.', '');
	}
    ####################### VERIFICO ARQUEO DE CAJA #######################

    }//FIN DE VERIFICO SI SE DESCONTARA DE CAJA

    if(empty($_POST["codventa"]) or empty($_POST["codfactura"]) or empty($_POST["observaciones"]))
	{
		echo "2";
		exit;
	}
	elseif(!array_filter($_POST['devuelto']) || $_POST["txtTotal"] == "" || $_POST["txtTotal"] == "0" || $_POST["txtTotal"] == "0.00")
	{
		echo "3";
		exit;
	}  
	else if($_POST["descontar"] == 1 && $_POST["txtTotal"] > $SaldoCaja){

		echo "4";
		exit;

	}

	################ VERIFICO QUE CANTIDAD DEVUELTA NO SEA MAYOR QUE VENDIDA ################
	$this->dbh->beginTransaction();
	for($i=0;$i<count($_POST['devuelto']);$i++){
        if (!empty($_POST['devuelto'][$i])) {

        	if($_POST['devuelto'][$i] > $_POST['cantidad'][$i]){

        		echo "5";
        		exit;
        	}

        }//fin de if
	}//fin de for
    $this->dbh->commit();
    ################ VERIFICO QUE CANTIDAD DEVUELTA NO SEA MAYOR QUE VENDIDA ################

	################ OBTENGO DATOS DE CONFIGURACION ################
	$sql = "SELECT * 
	FROM configuracion 
    LEFT JOIN documentos ON configuracion.documsucursal = documentos.coddocumento
    LEFT JOIN provincias ON configuracion.id_provincia = provincias.id_provincia 
    LEFT JOIN departamentos ON configuracion.id_departamento = departamentos.id_departamento 
    LEFT JOIN tiposmoneda ON configuracion.codmoneda = tiposmoneda.codmoneda";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
    $rucemisor = $row['cuit'];
    $razonsocial = $row['nomsucursal'];
    $actecoemisor = $row['codgiro'];
    $giroemisor = $row['girosucursal'];
    $provincia = ($row['id_provincia'] == "" || $row['id_provincia'] == "0" ? $row['direcsucursal'] : $row['provincia']);
    $departamento = ($row['id_departamento'] == "" || $row['id_departamento'] == "0" ? $row['direcsucursal'] : $row['departamento']);
    $direcemisor = $row['direcsucursal'];
	$nroactividad = $row['nroactividadsucursal'];
    $inicionota = $row['inicionota'];		
	$infoapi = $row['infoapi']; 
	$simbolo = $row['simbolo'];
	################ OBTENGO DATOS DE CONFIGURACION ################

	################ CREO CODIGO DE NOTA ###############
	$sql = "SELECT codnota FROM notascredito 
	ORDER BY idnota DESC LIMIT 1";
	foreach ($this->dbh->query($sql) as $row){

		$nota=$row["codnota"];
	}
	if(empty($nota))
	{
		$codnota = "01";

	} else {

        $num = substr($nota, 0);
        $dig = $num + 1;
        $codigofinal = str_pad($dig, 2, "0", STR_PAD_LEFT);
        $codnota = $codigofinal;
	}
    ################ CREO CODIGO DE NOTA ###############

    ################### CREO CODIGO DE FACTURA ####################
	$sql4 = "SELECT codfactura
	FROM notascredito ORDER BY idnota DESC LIMIT 1";
	foreach ($this->dbh->query($sql4) as $row4){

	    $factura=$row4["codfactura"];

	}
	if(empty($nota))
	{
		$codfactura = $nroactividad.'-'.$inicionota;

	} else {

        $var = strlen($nroactividad."-");
        $var1 = substr($factura , $var);
        $var2 = strlen($var1);
        $var3 = $var1 + 1;
        $var4 = str_pad($var3, $var2, "0", STR_PAD_LEFT);
        $codfactura = $nroactividad.'-'.$var4;
	}
    ################ CREO LOS CODIGO VENTA-SERIE-AUTORIZACION ###############

	################ REGISTRO LA NOTA DE CREDITO ################
	$query = "INSERT INTO notascredito values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = $this->dbh->prepare($query);
	$stmt->bindParam(1, $numerocaja);
	$stmt->bindParam(2, $codnota);
	$stmt->bindParam(3, $codfactura);
	$stmt->bindParam(4, $tipodocumento);
	$stmt->bindParam(5, $facturaventa);
	$stmt->bindParam(6, $codcliente);
	$stmt->bindParam(7, $subtotalivasi);
	$stmt->bindParam(8, $subtotalivano);
	$stmt->bindParam(9, $iva);
	$stmt->bindParam(10, $totaliva);
	$stmt->bindParam(11, $descontado);
	$stmt->bindParam(12, $descuento);
	$stmt->bindParam(13, $totaldescuento);
	$stmt->bindParam(14, $totalpago);
	$stmt->bindParam(15, $fechanota);
	$stmt->bindParam(16, $observaciones);
	$stmt->bindParam(17, $codigo);

	$numerocaja = limpiar($_POST['descontar'] == 1 ? $codcaja : "0");
	$tipodocumento = limpiar($_POST["tipodocumento"]);
	$facturaventa = limpiar(decrypt($_POST["codfactura"]));
	$codcliente = limpiar($_POST["codcliente"]);
	$subtotalivasi = limpiar($_POST["txtsubtotal"]);
	$subtotalivano = limpiar($_POST["txtsubtotal2"]);
	$iva = limpiar($_POST["iva"]);
	$totaliva = limpiar($_POST["txtIva"]);
	$descontado = limpiar($_POST["txtdescontado"]);
	$descuento = limpiar($_POST["descuento"]);
	$totaldescuento = limpiar($_POST["txtDescuento"]);
	$totalpago = limpiar($_POST["txtTotal"]);
	$fechanota = limpiar(date("Y-m-d H:i:s"));
	$observaciones = limpiar($_POST["observaciones"]);
	$codigo = limpiar($_SESSION["codigo"]);
	$stmt->execute();
	################ REGISTRO LA NOTA DE CREDITO ################

	$this->dbh->beginTransaction();
	for($i=0;$i<count($_POST['devuelto']);$i++){
        if (!empty($_POST['devuelto'][$i])) {

        	################ REGISTRO LOS DETALLES DE NOTA DE CREDITO ################
        	$query = "INSERT INTO detallenotas values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
        	$stmt = $this->dbh->prepare($query);
        	$stmt->bindParam(1, $codnota);
        	$stmt->bindParam(2, $idproducto);
        	$stmt->bindParam(3, $codproducto);
        	$stmt->bindParam(4, $producto);
        	$stmt->bindParam(5, $codcategoria);
        	$stmt->bindParam(6, $cantidad);
        	$stmt->bindParam(7, $preciocompra);
        	$stmt->bindParam(8, $precioventa);
        	$stmt->bindParam(9, $ivaproducto);
        	$stmt->bindParam(10, $descproducto);
        	$stmt->bindParam(11, $valortotal);
        	$stmt->bindParam(12, $totaldescuentov);
        	$stmt->bindParam(13, $valorneto);
        	$stmt->bindParam(14, $tipo);

        	$idproducto = limpiar($_POST['idproducto'][$i]);
        	$codproducto = limpiar($_POST['codproducto'][$i]);
        	$producto = limpiar($_POST['producto'][$i]);
        	$codcategoria = limpiar($_POST['codcategoria'][$i]);
        	$cantidad = limpiar($_POST['devuelto'][$i]);
        	$preciocompra = limpiar($_POST['preciocompra'][$i]);
        	$precioventa = limpiar($_POST['precioventa'][$i]);
        	$ivaproducto = limpiar($_POST['ivaproducto'][$i]);
        	$descproducto = limpiar($_POST['descproducto'][$i]);
        	$descuento = $_POST['descproducto'][$i]/100;
        	$valortotal = number_format($_POST['precioventa'][$i]*$_POST['devuelto'][$i], 2, '.', '');
        	$totaldescuentov = number_format($valortotal*$descuento, 2, '.', '');
        	$valorneto = number_format($valortotal-$totaldescuentov, 2, '.', '');
        	$tipo = limpiar($_POST["tipo"][$i]);
        	$stmt->execute();
        	################ REGISTRO LOS DETALLES DE NOTA DE CREDITO ################

    if(limpiar($_POST['tipo'][$i]) == 1){

    ############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################	

	############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################
	$sql = "SELECT 
	existencia, 
	controlstockp 
	FROM productos 
	WHERE codproducto = '".limpiar($_POST['codproducto'][$i])."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$existenciaproductobd = $row['existencia'];
	$controlproductobd = $row['controlstockp'];
	############## VERIFICO LA EXISTENCIA DEL PRODUCTO EN ALMACEN #################

	if($controlproductobd == 1){

	    ##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
		$sql = " UPDATE productos set "
			  ." existencia = ? "
			  ." WHERE "
			  ." codproducto = '".limpiar($_POST['codproducto'][$i])."';
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$cantdevuelta = number_format($_POST['devuelto'][$i], 2, '.', '');
		$existencia = number_format($existenciaproductobd+$cantdevuelta, 2, '.', '');
		$stmt->execute();
	    ##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################

		############## REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
        $query = "INSERT INTO kardex_productos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codnota);
		$stmt->bindParam(2, $codcliente);
		$stmt->bindParam(3, $codproducto);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivaproducto);
		$stmt->bindParam(10, $descproducto);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);		

		$codcliente = limpiar($_POST["codcliente"]);
		$codproducto = limpiar($_POST['codproducto'][$i]);
		$movimiento = limpiar("DEVOLUCION");
		$entradas = limpiar("0");
		$salidas = limpiar("0");
		$devolucion= number_format($_POST['devuelto'][$i], 2, '.', '');
		$stockactual = number_format($existenciaproductobd+$_POST['devuelto'][$i], 2, '.', '');
		$ivaproducto = limpiar($_POST['ivaproducto'][$i]);
		$descproducto = limpiar($_POST['descproducto'][$i]);
		$precio = limpiar($_POST['precioventa'][$i]);
		$documento = limpiar("DEVOLUCION NOTA DE CREDITO");
		$fechakardex = limpiar(date("Y-m-d"));
		$stmt->execute();
		############## REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
	}

    ############################### PROCESO PARA VERIFICAR LOS PRODUCTOS ######################################		

    } else {

   	############################### PROCESO PARA VERIFICAR LOS COMBOS ######################################		

		############## VERIFICO LA EXISTENCIA DEL COMBO EN ALMACEN #################
		$sql = "SELECT 
		existencia 
		FROM combos 
		WHERE codcombo = '".limpiar($_POST['codproducto'][$i])."'";
		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		$existenciacombobd = $row['existencia'];
		############## VERIFICO LA EXISTENCIA DEL COMBO EN ALMACEN #################

	    ##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################
		$sql = " UPDATE combos set "
			  ." existencia = ? "
			  ." where "
			  ." codcombo = '".limpiar($_POST['codproducto'][$i])."';
			   ";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $existencia);
		$cantdevuelta = number_format($_POST['codproducto'][$i], 2, '.', '');
		$existencia = number_format($existenciacombobd+$cantdevuelta, 2, '.', '');
		$stmt->execute();
		##################### ACTUALIZO LA EXISTENCIA DEL ALMACEN ####################

		############## REGISTRAMOS LOS DATOS DE COMBOS EN KARDEX ###################
	    $query = "INSERT INTO kardex_combos values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(1, $codnota);
		$stmt->bindParam(2, $codcliente);
		$stmt->bindParam(3, $codcombo);
		$stmt->bindParam(4, $movimiento);
		$stmt->bindParam(5, $entradas);
		$stmt->bindParam(6, $salidas);
		$stmt->bindParam(7, $devolucion);
		$stmt->bindParam(8, $stockactual);
		$stmt->bindParam(9, $ivacombo);
		$stmt->bindParam(10, $desccombo);
		$stmt->bindParam(11, $precio);
		$stmt->bindParam(12, $documento);
		$stmt->bindParam(13, $fechakardex);		

		$codcliente = limpiar($_POST["codcliente"]);
		$codproducto = limpiar($_POST['codproducto'][$i]);
		$movimiento = limpiar("DEVOLUCION");
		$entradas = limpiar("0");
		$salidas = limpiar("0");
		$devolucion= number_format($_POST['devuelto'][$i], 2, '.', '');
		$stockactual = number_format($existenciacombobd+$_POST['devuelto'][$i], 2, '.', '');
		$ivacombo = limpiar($_POST['ivaproducto'][$i]);
		$desccombo = limpiar($_POST['descproducto'][$i]);
		$precio = limpiar($_POST['precioventa'][$i]);
		$documento = limpiar("DEVOLUCION NOTA DE CREDITO");
		$fechakardex = limpiar(date("Y-m-d"));
		$stmt->execute();
		############## REGISTRAMOS LOS DATOS DE COMBOS EN KARDEX ###################

    ############################### PROCESO PARA VERIFICAR LOS COMBOS ######################################

    }

    ############################### PROCESO PARA VERIFICAR LOS INGREDIENTES ######################################	

	    ############## VERIFICO SSI EL PRODUCTO TIENE INGREDIENTES RELACIONADOS #################
	    $sql = "SELECT * FROM productosxingredientes WHERE codproducto = ?";
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute(array(limpiar($_POST['codproducto'][$i])));
		$num = $stmt->rowCount();
        if($num>0) {  

        	$sql = "SELECT * FROM productosxingredientes LEFT JOIN ingredientes ON productosxingredientes.codingrediente = ingredientes.codingrediente WHERE productosxingredientes.codproducto IN ('".$_POST['codproducto'][$i]."')";
        	foreach ($this->dbh->query($sql) as $row)
		    { 
			   $this->p[] = $row;

			   $cantracionbd = $row['cantracion'];
			   $codingredientebd = $row['codingrediente'];
			   $cantingredientebd = $row['cantingrediente'];
			   $precioventaingredientebd = $row['precioventa'];
			   $ivaingredientebd = $row['ivaingrediente'];
			   $descingredientebd = $row['descingrediente'];
		       $controlingredientebd = $row['controlstocki'];

		    if($controlingredientebd == 1){

			   ############## ACTUALIZO LOS DATOS DEL INGREDIENTE #################
			   $update = "UPDATE ingredientes set "
			   ." cantingrediente = ? "
			   ." WHERE "
			   ." codingrediente = ?;
			   ";
			   $stmt = $this->dbh->prepare($update);
			   $stmt->bindParam(1, $cantidadracion);
			   $stmt->bindParam(2, $codingredientebd);

			   $racion = number_format($cantracionbd*$_POST['devuelto'][$i], 2, '.', '');
			   $cantidadracion = number_format($cantingredientebd+$racion, 2, '.', '');
			   $stmt->execute();
			   ############## ACTUALIZO LOS DATOS DEL INGREDIENTE #################

			   ############## REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
			   $query = "INSERT INTO kardex_ingredientes values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
			   $stmt = $this->dbh->prepare($query);
			   $stmt->bindParam(1, $codnota);
			   $stmt->bindParam(2, $codcliente);
			   $stmt->bindParam(3, $codingrediente);
			   $stmt->bindParam(4, $movimiento);
			   $stmt->bindParam(5, $entradas);
			   $stmt->bindParam(6, $salidas);
			   $stmt->bindParam(7, $devolucion);
			   $stmt->bindParam(8, $stockactual);
			   $stmt->bindParam(9, $ivaingrediente);
			   $stmt->bindParam(10, $descingrediente);
			   $stmt->bindParam(11, $precio);
			   $stmt->bindParam(12, $documento);
			   $stmt->bindParam(13, $fechakardex);		

			   $codcliente = limpiar($_POST["codcliente"]);
			   $codingrediente = limpiar($codingredientebd);
			   $movimiento = limpiar("DEVOLUCION");
			   $entradas = limpiar("0");
			   $salidas= limpiar("0");
			   $devolucion = limpiar($racion);
			   $stockactual = number_format($cantingredientebd+$racion, 2, '.', '');
			   $ivaingrediente = limpiar($ivaingredientebd);
			   $descingrediente = limpiar($descingredientebd);
			   $precio = limpiar($precioventaingredientebd);
			   $documento = limpiar("DEVOLUCION NOTA DE CREDITO");
			   $fechakardex = limpiar(date("Y-m-d"));
			   $stmt->execute();
			}
		}
	}//fin de consulta de ingredientes de productos	

############################### PROCESO PARA VERIFICAR LOS INGREDIENTES ######################################	




        	

        	############## REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################
        	/*$query = "INSERT INTO kardex values (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
        	$stmt = $this->dbh->prepare($query);
        	$stmt->bindParam(1, $codnota);
        	$stmt->bindParam(2, $codcliente);
        	$stmt->bindParam(3, $codproducto);
        	$stmt->bindParam(4, $movimiento);
        	$stmt->bindParam(5, $entradas);
        	$stmt->bindParam(6, $salidas);
        	$stmt->bindParam(7, $devolucion);
        	$stmt->bindParam(8, $stockactual);
        	$stmt->bindParam(9, $ivaproducto);
        	$stmt->bindParam(10, $descproducto);
        	$stmt->bindParam(11, $precio);
        	$stmt->bindParam(12, $documento);
        	$stmt->bindParam(13, $fechakardex);		
        	$stmt->bindParam(14, $codsucursal);

        	$codcliente = limpiar($_POST["codcliente"]);
        	$codproducto = limpiar($_POST['codproducto'][$i]);
        	$movimiento = limpiar("DEVOLUCION");
        	$entradas = limpiar("0");
        	$salidas= limpiar("0");
        	$devolucion = limpiar($_POST['devuelto'][$i]);
        	$stockactual = limpiar($existenciabd+$_POST['devuelto'][$i]);
        	$precio = limpiar($_POST["precioventa"][$i]);
        	$ivaproducto = limpiar($_POST['ivaproducto'][$i]);
        	$descproducto = limpiar($_POST['descproducto'][$i]);
        	$documento = limpiar("NOTA DE CRÉDITO: ".$codnota);
        	$fechakardex = limpiar(date("Y-m-d"));
        	$codsucursal = limpiar($_POST["codsucursal"]);
        	$stmt->execute();*/
        	############## REGISTRAMOS LOS DATOS DE PRODUCTOS EN KARDEX ###################

        }//fin de if
	}//fin de for
    $this->dbh->commit();

	############## ACTUALIZAMOS STATUS DE FACTURA ###############
	$sql = "UPDATE ventas set "
	." statusventa = ? "
	." WHERE "
	." codventa = ?;
	";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindParam(1, $status);
	$stmt->bindParam(2, $codventa);

	$status = limpiar("ANULADA");
	$codventa = limpiar(decrypt($_POST["codventa"]));
	$stmt->execute();
    ################ ACTUALIZAMOS STATUS DE FACTURA ##############

	############## DESCONTAMOS EL TOTAL DE DOCUMENTO EN CAJA ###############
	if (limpiar($_POST["descontar"] == 1 && $_POST["tipopago"]=="CONTADO")){

	################## OBTENGO LOS DATOS EN CAJA ##################
	$sql = "SELECT 
	efectivo, 
	abonosefectivo, 
	propinasefectivo, 
	egresos,
	egresonotas,
	nroticket,
	nroboleta,
	nrofactura,
	nronota FROM arqueocaja 
	WHERE codarqueo = '".limpiar($codarqueo)."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$efectivo = ($row['efectivo']== "" ? "0.00" : $row['efectivo']);
	$abonosefectivo = ($row['abonosefectivo']== "" ? "0.00" : $row['abonosefectivo']);
	$propinasefectivo = ($row['propinasefectivo']== "" ? "0.00" : $row['propinasefectivo']);
	$egreso = ($row['egresos']== "" ? "0.00" : $row['egresos']);
	$egresonota = ($row['egresonotas']== "" ? "0.00" : $row['egresonotas']);
	$nroticket = $row['nroticket'];
	$nroboleta = $row['nroboleta'];
	$nrofactura = $row['nrofactura'];
	$nronota = $row['nronota'];
	$disponible = $efectivo+$abonosefectivo+$propinasefectivo-$egreso;
	################## OBTENGO LOS DATOS EN CAJA ##################

		########################## DESCUENTO EL MONTO EN CAJA ##########################
	    $sql = "UPDATE arqueocaja set "
		." efectivo = ?, "
		." egresonotas = ?, "
		." nroticket = ?, "
		." nroboleta = ?, "
		." nrofactura = ?, "
		." nronota = ? "
		." WHERE "
		." codarqueo = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtTotal);
		$stmt->bindParam(2, $txtEgresoNota);
		$stmt->bindParam(3, $NumTicket);
		$stmt->bindParam(4, $NumBoleta);
		$stmt->bindParam(5, $NumFactura);
		$stmt->bindParam(6, $NumNota);
		$stmt->bindParam(7, $codarqueo);

		$txtTotal = number_format($disponible-$_POST["txtTotal"], 2, '.', '');
		$txtEgresoNota = number_format($egresonota+$_POST["txtTotal"], 2, '.', '');
		$NumTicket = limpiar($_POST["tipodocumento"] == "TICKET" ? $nroticket-1 : $nroticket);
		$NumBoleta = limpiar($_POST["tipodocumento"] == "BOLETA" ? $nroboleta-1 : $nroboleta);
		$NumFactura = limpiar($_POST["tipodocumento"] == "FACTURA" ? $nrofactura-1 : $nrofactura);
		$NumNota = limpiar($nronota+1);
		$stmt->execute();
		########################## DESCUENTO EL MONTO EN CAJA ##########################
	}
    ################ DESCONTAMOS EL TOTAL DE DOCUMENTO EN CAJA ##############

    ############## DESCONTAMOS EL TOTAL DE DOCUMENTO EN CAJA ###############
	if (limpiar($_POST["descontar"] == 1 && $_POST["tipopago"]=="CREDITO")){

	################## OBTENGO LOS DATOS EN CAJA ##################
	$sql = "SELECT 
	efectivo, 
	creditos,
	egresonotas,
	nroticket,
	nroboleta,
	nrofactura,
	nronota
	FROM arqueocaja WHERE codarqueo = '".limpiar($codarqueo)."'";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	$efectivo = ($row['efectivo']== "" ? "0.00" : $row['efectivo']);
	$credito = ($row['creditos']== "" ? "0.00" : $row['creditos']);
	$egresonota = ($row['egresonotas']== "" ? "0.00" : $row['egresonotas']);
	$nroticket = $row['nroticket'];
	$nroboleta = $row['nroboleta'];
	$nrofactura = $row['nrofactura'];
	$nronota = $row['nronota'];
	################## OBTENGO LOS DATOS EN CAJA ##################

		########################## DESCUENTO EL MONTO EN CAJA ##########################
	    $sql = "UPDATE arqueocaja set "
		." efectivo = ?, "
		." creditos = ?, "
		." egresonotas = ?, "
		." nroticket = ?, "
		." nroboleta = ?, "
		." nrofactura = ?, "
		." nronota = ? "
		." WHERE "
		." codarqueo = ?;
		";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(1, $txtEfectivo);
		$stmt->bindParam(2, $txtCredito);
		$stmt->bindParam(3, $txtEgresoNota);
		$stmt->bindParam(4, $NumTicket);
		$stmt->bindParam(5, $NumBoleta);
		$stmt->bindParam(6, $NumFactura);
		$stmt->bindParam(7, $NumNota);
		$stmt->bindParam(8, $codarqueo);

		$txtEfectivo = ($_POST["abonototal"]!= "0.00" ? number_format($efectivo-$_POST["abonototal"], 2, '.', '') : $efectivo);
		$txtCredito = number_format($credito-$_POST["txtTotal"], 2, '.', '');
		$txtEgresoNota = number_format($egresonota+$_POST["txtTotal"], 2, '.', '');
		$NumTicket = limpiar($_POST["tipodocumento"] == "TICKET" ? $nroticket-1 : $nroticket);
		$NumBoleta = limpiar($_POST["tipodocumento"] == "BOLETA" ? $nroboleta-1 : $nroboleta);
		$NumFactura = limpiar($_POST["tipodocumento"] == "FACTURA" ? $nrofactura-1 : $nrofactura);
		$NumNota = limpiar($nronota+1);
		$stmt->execute();
		########################## DESCUENTO EL MONTO EN CAJA ##########################

	}
    ################ DESCONTAMOS EL TOTAL DE DOCUMENTO CAJA ##############

    
echo "<span class='fa fa-check-square-o'></span> EL NOTA DE CR&Eacute;DITO HA SIDO REGISTRADA EXITOSAMENTE <a href='reportepdf?codnota=".encrypt($codnota)."&tipo=".encrypt("NOTACREDITO")."' class='on-default' data-placement='left' data-toggle='tooltip' data-original-title='Imprimir Documento' target='_black' rel='noopener noreferrer'><font color='black'><strong>IMPRIMIR DOCUMENTO</strong></font color></a></div>";

echo "<script>window.open('reportepdf?codnota=".encrypt($codnota)."&tipo=".encrypt("NOTACREDITO")."', '_blank');</script>";
	exit;

}
##################### FUNCION REGISTRAR NOTA DE CREDITO ###########################

############################ FUNCION ID NOTA CREDITO #################################
public function NotasCreditoPorId()
	{
	self::SetNames();
	$sql = "SELECT
    notascredito.idnota,
	notascredito.codcaja, 
    notascredito.codnota,
    notascredito.codfactura,
    notascredito.tipodocumento,
    notascredito.facturaventa,
	notascredito.codcliente, 
	notascredito.subtotalivasi, 
	notascredito.subtotalivano, 
	notascredito.iva, 
	notascredito.totaliva,
	notascredito.descontado, 
	notascredito.descuento, 
	notascredito.totaldescuento, 
	notascredito.totalpago, 
	notascredito.fechanota,
    notascredito.observaciones,  
    clientes.tipocliente,
	clientes.codcliente,
	clientes.documcliente,
	clientes.dnicliente,
    CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,  
	clientes.girocliente,
	clientes.tlfcliente, 
	clientes.id_provincia, 
	clientes.id_departamento, 
	clientes.direccliente, 
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
    provincias.provincia,
    departamentos.departamento,
    cajas.nrocaja,
    cajas.nomcaja,
    usuarios.dni, 
    usuarios.nombres
    FROM (notascredito LEFT JOIN clientes ON notascredito.codcliente = clientes.codcliente)
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento 
	LEFT JOIN cajas ON notascredito.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON notascredito.codigo = usuarios.codigo
	WHERE notascredito.codnota = ?";
    $stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(limpiar(decrypt($_GET["codnota"]))));
	$num = $stmt->rowCount();
	if($num==0)
	{
		echo "";
	}
	else
	{
		if($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
############################ FUNCION ID NOTA CREDITO #################################

########################### FUNCION VER DETALLES NOTA DE CREDITO ##########################
public function VerDetallesNotasCredito()
	{
	self::SetNames();
	$sql = "SELECT
	detallenotas.coddetallenota,
	detallenotas.codnota,
	detallenotas.idproducto,
	detallenotas.codproducto,
	detallenotas.producto,
	detallenotas.codcategoria,
	detallenotas.cantventa,
	detallenotas.preciocompra,
	detallenotas.precioventa,
	detallenotas.ivaproducto,
	detallenotas.descproducto,
	detallenotas.valortotal, 
	detallenotas.totaldescuentov,
	detallenotas.valorneto,
	detallenotas.tipo,
	categorias.nomcategoria
	FROM detallenotas INNER JOIN productos ON detallenotas.codproducto = productos.codproducto 
	LEFT JOIN categorias ON detallenotas.codcategoria = categorias.codcategoria 
	WHERE detallenotas.codnota = ? GROUP BY productos.codproducto";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array(decrypt($_GET["codnota"])));
	$num = $stmt->rowCount();
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$this->p[]=$row;
	}
		return $this->p;
		$this->dbh=null;
}
############################ FUNCION VER DETALLES NOTA DE CREDITO #######################

###################### FUNCION LISTAR NOTA DE CREDITO ####################### 
public function ListarNotasCreditos()
{
	self::SetNames();
	$sql = "SELECT
	notascredito.idnota,
	notascredito.codcaja, 
    notascredito.codnota,
    notascredito.codfactura,
    notascredito.tipodocumento,
    notascredito.facturaventa,
	notascredito.codcliente, 
	notascredito.subtotalivasi, 
	notascredito.subtotalivano, 
	notascredito.iva, 
	notascredito.totaliva,
	notascredito.descontado, 
	notascredito.descuento, 
	notascredito.totaldescuento, 
	notascredito.totalpago, 
	notascredito.fechanota,
    notascredito.observaciones, 
	notascredito.codigo,
	clientes.documcliente,
	clientes.dnicliente, 
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	provincias.provincia,
    departamentos.departamento,
	cajas.nrocaja,
	cajas.nomcaja,
	usuarios.dni, 
    usuarios.nombres,
	SUM(detallenotas.cantventa) AS articulos
	FROM (notascredito LEFT JOIN detallenotas ON detallenotas.codnota = notascredito.codnota)
	LEFT JOIN clientes ON notascredito.codcliente = clientes.codcliente
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento
	LEFT JOIN cajas ON notascredito.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON notascredito.codigo = usuarios.codigo
	GROUP BY notascredito.codnota 
	ORDER BY notascredito.idnota ASC";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
###################### FUNCION LISTAR NOTA DE CREDITO ####################### 

###################### FUNCION BUSQUEDA NOTAS POR CAJAS ###########################
public function BuscarNotasxCajas() 
	{
	self::SetNames();
	$sql ="SELECT
	notascredito.idnota,
	notascredito.codcaja, 
    notascredito.codnota,
    notascredito.codfactura,
    notascredito.tipodocumento,
    notascredito.facturaventa,
	notascredito.codcliente, 
	notascredito.subtotalivasi, 
	notascredito.subtotalivano, 
	notascredito.iva, 
	notascredito.totaliva,
	notascredito.descontado, 
	notascredito.descuento, 
	notascredito.totaldescuento, 
	notascredito.totalpago, 
	notascredito.fechanota,
    notascredito.observaciones, 
	notascredito.codigo,
	clientes.documcliente,
	clientes.dnicliente, 
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	provincias.provincia,
    departamentos.departamento,
	cajas.nrocaja,
	cajas.nomcaja,
	usuarios.dni, 
    usuarios.nombres,
	SUM(detallenotas.cantventa) AS articulos
	FROM (notascredito LEFT JOIN detallenotas ON detallenotas.codnota = notascredito.codnota)
	LEFT JOIN clientes ON notascredito.codcliente = clientes.codcliente
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento
	LEFT JOIN cajas ON notascredito.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON notascredito.codigo = usuarios.codigo
	WHERE notascredito.codcaja = ? 
	AND DATE_FORMAT(notascredito.fechanota,'%Y-%m-%d') BETWEEN ? AND ? 
	GROUP BY notascredito.codnota 
	ORDER BY notascredito.idnota ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(decrypt($_GET['codcaja'])));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(3, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA NOTAS POR CAJAS ###########################

###################### FUNCION BUSQUEDA NOTAS POR FECHAS ###########################
public function BuscarNotasxFechas() 
	{
	self::SetNames();
	$sql ="SELECT
	notascredito.idnota,
	notascredito.codcaja, 
    notascredito.codnota,
    notascredito.codfactura,
    notascredito.tipodocumento,
    notascredito.facturaventa,
	notascredito.codcliente, 
	notascredito.subtotalivasi, 
	notascredito.subtotalivano, 
	notascredito.iva, 
	notascredito.totaliva,
	notascredito.descontado, 
	notascredito.descuento, 
	notascredito.totaldescuento, 
	notascredito.totalpago, 
	notascredito.fechanota,
    notascredito.observaciones, 
	notascredito.codigo,
	clientes.documcliente,
	clientes.dnicliente, 
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	provincias.provincia,
    departamentos.departamento,
	cajas.nrocaja,
	cajas.nomcaja,
	usuarios.dni, 
    usuarios.nombres,
	SUM(detallenotas.cantventa) AS articulos
	FROM (notascredito LEFT JOIN detallenotas ON detallenotas.codnota = notascredito.codnota)
	LEFT JOIN clientes ON notascredito.codcliente = clientes.codcliente
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento
	LEFT JOIN cajas ON notascredito.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON notascredito.codigo = usuarios.codigo
	WHERE DATE_FORMAT(notascredito.fechanota,'%Y-%m-%d') BETWEEN ? AND ? 
	GROUP BY notascredito.codnota 
	ORDER BY notascredito.idnota ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->bindValue(1, trim(date("Y-m-d",strtotime($_GET['desde']))));
	$stmt->bindValue(2, trim(date("Y-m-d",strtotime($_GET['hasta']))));
	$stmt->execute();
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA NOTAS POR FECHAS ###########################

###################### FUNCION BUSQUEDA NOTAS POR CLIENTE ###########################
public function BuscarNotasxClientes() 
	{
	self::SetNames();
	$sql ="SELECT
	notascredito.idnota,
	notascredito.codcaja, 
    notascredito.codnota,
    notascredito.codfactura,
    notascredito.tipodocumento,
    notascredito.facturaventa,
	notascredito.codcliente, 
	notascredito.subtotalivasi, 
	notascredito.subtotalivano, 
	notascredito.iva, 
	notascredito.totaliva,
	notascredito.descontado, 
	notascredito.descuento, 
	notascredito.totaldescuento, 
	notascredito.totalpago, 
	notascredito.fechanota,
    notascredito.observaciones, 
	notascredito.codigo,
	clientes.documcliente,
	clientes.dnicliente, 
	CONCAT(if(clientes.tipocliente='JURIDICO',clientes.razoncliente,clientes.nomcliente)) as nomcliente,
	clientes.girocliente,
	clientes.tlfcliente,
	clientes.id_provincia,
	clientes.id_departamento,
	clientes.direccliente,
	clientes.emailcliente,
	clientes.limitecredito,
	documentos.documento,
	provincias.provincia,
    departamentos.departamento,
	cajas.nrocaja,
	cajas.nomcaja,
	usuarios.dni, 
    usuarios.nombres,
	SUM(detallenotas.cantventa) AS articulos
	FROM (notascredito LEFT JOIN detallenotas ON detallenotas.codnota = notascredito.codnota)
	LEFT JOIN clientes ON notascredito.codcliente = clientes.codcliente
	LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
	LEFT JOIN provincias ON clientes.id_provincia = provincias.id_provincia 
	LEFT JOIN departamentos ON clientes.id_departamento = departamentos.id_departamento
	LEFT JOIN cajas ON notascredito.codcaja = cajas.codcaja
	LEFT JOIN usuarios ON notascredito.codigo = usuarios.codigo
	WHERE notascredito.codcliente = ?
	GROUP BY notascredito.codnota 
	ORDER BY notascredito.idnota ASC";
	$stmt = $this->dbh->prepare($sql);
	$stmt->execute(array($_GET["codcliente"]));
	$num = $stmt->rowCount();
	if($num==0)
	{
	echo "<div class='alert alert-danger'>";
	echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
	echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON RESULTADOS EN TU BÚSQUEDA REALIZADA</center>";
	echo "</div>";		
	exit;
	}
	else
	{
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$this->p[]=$row;
		}
		return $this->p;
		$this->dbh=null;
	}
}
###################### FUNCION BUSQUEDA NOTAS POR CLIENTES ###########################

###################################### CLASE NOTA DE CREDITO ###################################


































####################################### FUNCION PARA GRAFICOS #######################################

########################### FUNCION SUMA DE COMPRAS #################################
 public function SumaCompras()
{
	self::SetNames();

	$sql ="SELECT  
	MONTH(fecharecepcion) mes, 
	SUM(totalpagoc) totalmes
	FROM compras 
	WHERE YEAR(fecharecepcion) = '".date('Y')."' AND MONTH(fecharecepcion) GROUP BY MONTH(fecharecepcion) ORDER BY 1";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 
 } 
########################### FUNCION SUMA DE COMPRAS #################################


########################### FUNCION SUMA DE VENTAS #################################
 public function SumaVentas()
{
	self::SetNames();

	$sql ="SELECT  
	MONTH(fechaventa) mes, 
	SUM(totalpago) totalmes
	FROM ventas 
	WHERE YEAR(fechaventa) = '".date('Y')."' AND MONTH(fechaventa) GROUP BY MONTH(fechaventa) ORDER BY 1";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
 
 }
########################### FUNCION SUMA DE VENTAS #################################

########################### FUNCION PRODUCTOS 5 MAS VENDIDOS ############################
	public function ProductosMasVendidos()
	{
		self::SetNames();

	$sql = "SELECT productos.codproducto, productos.producto, productos.codcategoria, detalleventas.descproducto, detalleventas.precioventa, productos.existencia, categorias.nomcategoria, ventas.fechaventa, SUM(detalleventas.cantventa) as cantidad FROM (ventas LEFT JOIN detalleventas ON ventas.codventa=detalleventas.codventa) LEFT JOIN productos ON detalleventas.codproducto=productos.codproducto LEFT JOIN categorias ON categorias.codcategoria=productos.codcategoria GROUP BY detalleventas.codproducto, detalleventas.precioventa, detalleventas.descproducto ORDER BY productos.codproducto ASC LIMIT 8";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################## FUNCION 5 PRODUCTOS MAS VENDIDOS ###########################

########################## FUNCION SUMAR VENTAS POR USUARIOS ##########################
	public function VentasxUsuarios()
	{
		self::SetNames();
     $sql = "SELECT usuarios.codigo, usuarios.nombres, SUM(ventas.totalpago) as total FROM (usuarios INNER JOIN ventas ON usuarios.codigo=ventas.codigo) GROUP BY usuarios.codigo";
	foreach ($this->dbh->query($sql) as $row)
	{
		$this->p[] = $row;
	}
	return $this->p;
	$this->dbh=null;
}
########################## FUNCION SUMAR VENTAS POR USUARIOS #########################

#################### FUNCION PARA CONTAR REGISTROS ###################################
public function ContarRegistros()
	{
      self::SetNames();

$sql = "SELECT
(SELECT COUNT(codigo) FROM usuarios) AS usuarios,
(SELECT COUNT(codproducto) FROM productos) AS productos,
(SELECT COUNT(codingrediente) FROM ingredientes) AS ingredientes,
(SELECT COUNT(codcliente) FROM clientes) AS clientes,
(SELECT COUNT(codproveedor) FROM proveedores) AS proveedores,
(SELECT COUNT(codproducto) FROM productos WHERE existencia <= stockminimo) AS minimo,
(SELECT COUNT(codproducto) FROM productos WHERE fechaexpiracion != '0000-00-00' AND fechaexpiracion <= '".date("Y-m-d")."') AS vencidos,
(SELECT COUNT(idcompra) FROM compras) AS compras,
(SELECT COUNT(idventa) FROM ventas) AS ventas,
(SELECT COUNT(idcompra) FROM compras WHERE tipocompra = 'CREDITO' AND statuscompra = 'PENDIENTE' AND fechavencecredito <= '".date("Y-m-d")."') AS creditoscomprasvencidos,
(SELECT COUNT(idventa) FROM ventas WHERE tipopago = 'CREDITO' AND statusventa = 'PENDIENTE' AND fechavencecredito <= '".date("Y-m-d")."') AS creditosventasvencidos";

		foreach ($this->dbh->query($sql) as $row)
		{
			$this->p[] = $row;
		}
		return $this->p;
		$this->dbh=null;
}
##################### FUNCION PARA CONTAR REGISTROS ##################

####################################### FUNCION PARA GRAFICOS #######################################


}
############## TERMINA LA CLASE LOGIN ######################
?>