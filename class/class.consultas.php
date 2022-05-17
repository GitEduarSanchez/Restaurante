<?php
session_start();
require_once("classconexion.php");

class conectorDB extends Db
{
	public function __construct()
    {
        parent::__construct();
    } 	
	
	public function EjecutarSentencia($consulta, $valores = array()){  //funcion principal, ejecuta todas las consultas
		$resultado = false;
		
		if($statement = $this->dbh->prepare($consulta)){  //prepara la consulta
			if(preg_match_all("/(:\w+)/", $consulta, $campo, PREG_PATTERN_ORDER)){ //tomo los nombres de los campos iniciados con :xxxxx
				$campo = array_pop($campo); //inserto en un arreglo
				foreach($campo as $parametro){
					$statement->bindValue($parametro, $valores[substr($parametro,1)]);
				}
			}
			try {
				if (!$statement->execute()) { //si no se ejecuta la consulta...
					print_r($statement->errorInfo()); //imprimir errores
					return false;
				}
				$resultado = $statement->fetchAll(PDO::FETCH_ASSOC); //si es una consulta que devuelve valores los guarda en un arreglo.
				$statement->closeCursor();
			}
			catch(PDOException $e){
				echo "Error de ejecución: \n";
				print_r($e->getMessage());
			}	
		}
		return $resultado;
		$this->dbh = null; //cerramos la conexión
	} /// Termina funcion consultarBD
}/// Termina clase conectorDB

class Json
{
	private $json;

	public function BuscaCategoria($filtro){
    $consulta = "SELECT CONCAT(nomcategoria) as label, codcategoria FROM categorias WHERE CONCAT(nomcategoria) LIKE '%".$filtro."%' ORDER BY codcategoria ASC LIMIT 0,10";
			$conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;
	}
	
	public function BuscaMedidas($filtro){
    $consulta = "SELECT CONCAT(nommedida) as label, codmedida FROM medidas WHERE CONCAT(nommedida) LIKE '%".$filtro."%' GROUP BY nommedida ORDER BY codmedida ASC LIMIT 0,10";
			$conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;
	}

	public function BuscaIngrediente($filtro){

    $consulta = "SELECT CONCAT(ingredientes.nomingrediente) as label, ingredientes.idingrediente, ingredientes.codingrediente, ingredientes.nomingrediente, ingredientes.codmedida, ROUND(ingredientes.preciocompra, 2) preciocompra, ROUND(ingredientes.precioventa, 2) precioventa, ROUND(ingredientes.cantingrediente, 2) cantingrediente, ingredientes.ivaingrediente, ROUND(ingredientes.descingrediente, 2) descingrediente, ingredientes.fechaexpiracion, medidas.nommedida FROM ingredientes INNER JOIN medidas ON ingredientes.codmedida=medidas.codmedida WHERE CONCAT(codingrediente, '',nomingrediente, '',nommedida) LIKE '%".$filtro."%' GROUP BY codingrediente ASC LIMIT 0,15";
        $conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;
	}


	public function BuscaProducto($filtro){

    $consulta = "SELECT CONCAT(productos.producto) as label, productos.idproducto, productos.codproducto, productos.producto, productos.codcategoria, ROUND(productos.preciocompra, 2) preciocompra, ROUND(productos.precioventa, 2) precioventa, ROUND(productos.existencia, 2) existencia, productos.ivaproducto, ROUND(productos.descproducto, 2) descproducto, productos.fechaelaboracion, productos.fechaexpiracion, categorias.nomcategoria FROM productos INNER JOIN categorias ON productos.codcategoria=categorias.codcategoria WHERE CONCAT(codproducto, '',producto, '',nomcategoria, '',codigobarra) LIKE '%".$filtro."%' GROUP BY codproducto ASC LIMIT 0,15";
        $conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;
	}

	public function BuscaCombo($filtro){

    $consulta = "SELECT CONCAT(combos.nomcombo) as label, combos.idcombo, combos.codcombo, combos.nomcombo, ROUND(combos.preciocompra, 2) preciocompra, ROUND(combos.precioventa, 2) precioventa, ROUND(combos.existencia, 2) existencia, combos.ivacombo, ROUND(combos.desccombo, 2) desccombo FROM combos WHERE CONCAT(codcombo, '',nomcombo) LIKE '%".$filtro."%' GROUP BY codcombo ASC LIMIT 0,15";
        $conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;
	}

	public function BuscaClientes($filtro){
		$consulta = "SELECT
	CONCAT(if(clientes.documcliente='0','DOC.',documentos.documento), ': ',clientes.dnicliente, ': ',if(clientes.nomcliente='',clientes.razoncliente,clientes.nomcliente)) as label,  
	clientes.codcliente, 
	clientes.tipocliente,
	clientes.nomcliente,
	clientes.razoncliente, 
	clientes.limitecredito,
	ROUND(SUM(if(pag.montocredito!='0',clientes.limitecredito-pag.montocredito,clientes.limitecredito)), 2) creditodisponible
    FROM
       clientes 
     LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
     LEFT JOIN
       (SELECT
           codcliente, montocredito       
           FROM creditosxclientes) pag ON pag.codcliente = clientes.codcliente
           WHERE CONCAT(clientes.dnicliente, '',clientes.nomcliente, '',clientes.razoncliente, '',clientes.girocliente) LIKE '%".$filtro."%' 
           GROUP BY clientes.codcliente ASC LIMIT 0,10";
		$conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;
	}


	public function BuscaFactura($filtro){
		$consulta = "SELECT CONCAT(tipodocumento, ' Nº ',codfactura, ': ',if(ventas.codcliente='0','CONSUMIDOR FINAL',if(clientes.nomcliente='',clientes.razoncliente,clientes.nomcliente))) as label, idventa, codventa, codfactura FROM ventas LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente WHERE CONCAT(ventas.tipodocumento, ventas.codfactura) LIKE '%".$filtro."%' AND ventas.statusventa != 'ANULADA' ORDER BY ventas.codfactura ASC LIMIT 0,10";
		$conexion = new conectorDB();
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;
		
	}

}/// TERMINA CLASE  ///
?>