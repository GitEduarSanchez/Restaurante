<?php
require_once("class/class.php");
  if (isset($_SESSION['acceso'])) {
    if ($_SESSION['acceso'] == "administrador" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero" || $_SESSION["acceso"]=="mesero" || $_SESSION["acceso"]=="cocinero" || $_SESSION["acceso"]=="repartidor") {

$imp = new Login();
$imp = $imp->ImpuestosPorId();
$impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
$valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

$con = new Login();
$con = $con->ConfiguracionPorId();
$simbolo = ($con == "" ? "" : "<strong>".$con[0]['simbolo']."</strong>");

$tipo = decrypt($_GET['tipo']);
$documento = decrypt($_GET['documento']);
$extension = $documento == 'EXCEL' ? '.xls' : '.doc';

switch($tipo)
  {

############################### MODULO DE CONFIGURACIONES ###############################

case 'PROVINCIAS': 

$archivo = str_replace(" ", "_","LISTADO DE PROVINCIAS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE PROVINCIA</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarProvincias();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $reg[$i]['id_provincia']; ?></td>
           <td><?php echo $reg[$i]['provincia']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'DEPARTAMENTOS': 

$archivo = str_replace(" ", "_","LISTADO DE DEPARTAMENTOS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE PROVINCIA</th>
           <th>NOMBRE DE DEPARTAMENTO</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarDepartamentos();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['provincia']; ?></td>
           <td><?php echo $reg[$i]['departamento']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'DOCUMENTOS': 

$archivo = str_replace(" ", "_","LISTADO DE DOCUMENTOS TRIBUTARIOS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE DOCUMENTO</th>
           <th>DESCRIPCIÓN DE DOCUMENTO</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarDocumentos();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['documento']; ?></td>
           <td><?php echo $reg[$i]['descripcion']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'TIPOMONEDA': 

$archivo = str_replace(" ", "_","LISTADO DE TIPOS DE MONEDA");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE MONEDA</th>
           <th>SIGLAS</th>
           <th>SIMBOLO</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarTipoMoneda();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['moneda']; ?></td>
           <td><?php echo $reg[$i]['siglas']; ?></td>
           <td><?php echo $reg[$i]['simbolo']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'TIPOCAMBIO': 

$archivo = str_replace(" ", "_","LISTADO DE TIPO DE CAMBIO");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>DESCRIPCIÓN DE CAMBIO</th>
           <th>MONTO DE CAMBIO</th>
           <th>TIPO DE MONEDA</th>
           <th>FECHA DE INGRESO</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarTipoCambio();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['descripcioncambio']; ?></td>
           <td><?php echo $reg[$i]['montocambio']; ?></td>
           <td><?php echo $reg[$i]['moneda']."/".$reg[$i]['siglas']; ?></td>
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechacambio'])); ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'IMPUESTOS': 

$archivo = str_replace(" ", "_","LISTADO DE IMPUESTOS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE IMPUESTO</th>
           <th>VALOR(%)</th>
           <th>STATUS</th>
           <th>REGISTRO</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarImpuestos();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nomimpuesto']; ?></td>
           <td><?php echo $reg[$i]['valorimpuesto']; ?></td>
           <td><?php echo $reg[$i]['statusimpuesto']; ?></td>
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaimpuesto'])); ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'SALAS': 

$archivo = str_replace(" ", "_","LISTADO DE SALAS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE SALA</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarSalas();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nomsala']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'MESAS': 

$archivo = str_replace(" ", "_","LISTADO DE MESAS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE SALA</th>
           <th>NOMBRE DE MESA</th>
           <th>Nº DE PERSONAS</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarMesas();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nomsala']; ?></td>
           <td><?php echo $reg[$i]['nommesa']; ?></td>
           <td><?php echo $reg[$i]['puestos']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'CATEGORIAS': 

$archivo = str_replace(" ", "_","LISTADO DE CATEGORIAS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE CATEGORIA</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarCategorias();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nomcategoria']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'MEDIDAS': 

$archivo = str_replace(" ", "_","LISTADO DE MEDIDAS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE MEDIDA</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarMedidas();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nommedida']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;
############################### MODULO DE CONFIGURACIONES ##############################



################################## MODULO DE USUARIOS ##################################

case 'USUARIOS': 

$tra = new Login();
$reg = $tra->ListarUsuarios();

$archivo = str_replace(" ", "_","LISTADO DE USUARIOS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE DOCUMENTO</th>
           <th>NOMBRES Y APELLIDOS</th>
<?php if ($documento == "EXCEL") { ?>
           <th>SEXO</th>
           <th>CORREO ELECTRONICO</th>
<?php } ?>
           <th>USUARIO</th>
           <th>NIVEL</th>
           <th>STATUS</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['dni']; ?></td>
           <td><?php echo $reg[$i]['nombres']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['sexo']; ?></td>
           <td><?php echo $reg[$i]['email']; ?></td>
<?php } ?>
           <td><?php echo $reg[$i]['usuario']; ?></td>
           <td><?php echo $reg[$i]['nivel']; ?></td>
           <td><?php echo $status = ( $reg[$i]['status'] == 1 ? "ACTIVO" : "INACTIVO"); ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'LOGS': 

$archivo = str_replace(" ", "_","LISTADO LOGS DE ACCESO");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>IP EQUIPO</th>
           <th>TIEMPO DE ENTRADA</th>
           <th>NAVEGADOR DE ACCESO</th>
           <th>PÁGINAS DE ACCESO</th>
           <th>USUARIOS</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarLogs();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['ip']; ?></td>
           <td><?php echo $reg[$i]['tiempo']; ?></td>
           <td><?php echo $reg[$i]['detalles']; ?></td>
           <td><?php echo $reg[$i]['paginas']; ?></td>
           <td><?php echo $reg[$i]['usuario']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

################################ MODULO DE USUARIOS ##############################














############################### MODULO DE CLIENTES ###################################

case 'CLIENTES': 

$archivo = str_replace(" ", "_","LISTADO DE CLIENTES");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>TIPO CLIENTE</th>
           <th>TIPO DE DOCUMENTO</th>
           <th>Nº DE DOCUMENTO</th>
           <th>NOMBRES/RAZÓN SOCIAL</th>
           <th>GIRO DE CLIENTE</th>
           <th>Nº DE TELÉFONO</th>
<?php if ($documento == "EXCEL") { ?>
           <th>PROVINCIA</th>
           <th>DEPARTAMENTO</th>
           <th>DIRECCIÓN DOMICILIARIA</th>
           <th>CORREO ELECTRONICO</th>
<?php } ?>
           <th>LIMITE DE CRÉDITO</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarClientes();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['tipocliente']; ?></td>
           <td><?php echo $reg[$i]['documcliente'] == '0' ? "*********" : $reg[$i]['documento']; ?></td>
           <td><?php echo $reg[$i]['dnicliente']; ?></td>
           <td><?php echo $reg[$i]['nomcliente']; ?></td>
           <td><?php echo $reg[$i]['girocliente'] == '' ? "*********" : $reg[$i]['girocliente']; ?></td>
           <td><?php echo $reg[$i]['tlfcliente'] == '' ? "*********" : $reg[$i]['tlfcliente']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['id_provincia'] == '0' ? "*********" : $reg[$i]['provincia']; ?></td>
           <td><?php echo $reg[$i]['id_departamento'] == '0' ? "*********" : $reg[$i]['departamento']; ?></td>
           <td><?php echo $reg[$i]['direccliente']; ?></td>
           <td><?php echo $reg[$i]['emailcliente'] == '' ? "*********" : $reg[$i]['emailcliente']; ?></td>
<?php } ?>
           <td><?php echo $reg[$i]['limitecredito']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

############################### MODULO DE CLIENTES ###################################










################################ MODULO DE PROVEEDORES #################################

case 'PROVEEDORES': 

$archivo = str_replace(" ", "_","LISTADO DE PROVEEDORES");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>TIPO DE DOCUMENTO</th>
           <th>Nº DE DOCUMENTO</th>
           <th>NOMBRE DE PROVEEDOR</th>
           <th>Nº DE TELÉFONO</th>
<?php if ($documento == "EXCEL") { ?>
           <th>PROVINCIA</th>
           <th>DEPARTAMENTO</th>
           <th>DIRECCIÓN DOMICILIARIA</th>
           <th>CORREO ELECTRONICO</th>
<?php } ?>
           <th>VENDEDOR</th>
           <th>Nº DE TELÉFONO</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarProveedores();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['documproveedor'] == '0' ? "*********" : $reg[$i]['documento']; ?></td>
           <td><?php echo $reg[$i]['cuitproveedor']; ?></td>
           <td><?php echo $reg[$i]['nomproveedor']; ?></td>
           <td><?php echo $reg[$i]['tlfproveedor'] == '' ? "*********" : $reg[$i]['tlfproveedor']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['id_provincia'] == '0' ? "*********" : $reg[$i]['provincia']; ?></td>
           <td><?php echo $reg[$i]['id_departamento'] == '0' ? "*********" : $reg[$i]['departamento']; ?></td>
           <td><?php echo $reg[$i]['direcproveedor']; ?></td>
           <td><?php echo $reg[$i]['emailproveedor'] == '' ? "*********" : $reg[$i]['emailproveedor']; ?></td>
<?php } ?>
           <td><?php echo $reg[$i]['vendedor']; ?></td>
           <td><?php echo $reg[$i]['tlfvendedor']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

################################# MODULO DE PROVEEDORES ################################






























################################ MODULO DE INGREDIENTES ################################

case 'INGREDIENTES':

$tra = new Login();
$reg = $tra->ListarIngredientes();

$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 

$archivo = str_replace(" ", "_","LISTADO DE INGREDIENTES");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE INGREDIENTE</th>
           <th>MEDIDA</th>
           <th>PRECIO COMPRA</th>
           <th>PRECIO VENTA</th>
           <th><?php echo $cambio == '' ? "CAMBIO" : "PRECIO ".$cambio[0]['siglas']; ?></th>
           <th>EXISTENCIA</th>
<?php if ($documento == "EXCEL") { ?>
           <th>STOCK MINIMO</th>
           <th>STOCK MÁXIMO</th>
<?php } ?>
           <th><?php echo $impuesto; ?></th>
           <th>DESC</th>
<?php if ($documento == "EXCEL") { ?>
           <th>LOTE</th>
           <th>FECHA DE EXPIRACIÓN</th>
           <th>PROVEEDOR</th>
<?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalCompra=0;
$TotalVenta=0;
$TotalMoneda=0;
$TotalArticulos=0;
for($i=0;$i<sizeof($reg);$i++){ 
$TotalCompra+=$reg[$i]['preciocompra'];
$TotalVenta+=$reg[$i]['precioventa']-$reg[$i]['descingrediente']/100;
$TotalMoneda += ($cambio == 0 ? "0" : $reg[$i]['precioventa']/$cambio[0]['montocambio']);
$TotalArticulos+=$reg[$i]['cantingrediente'];
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codingrediente']; ?></td>
           <td><?php echo $reg[$i]['nomingrediente']; ?></td>
           <td><?php echo $reg[$i]['nommedida']; ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
<td><?php echo $cambio == '' ? "*****" : $cambio[0]['simbolo'].number_format($reg[$i]['precioventa']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
           <td><?php echo number_format($reg[$i]['cantingrediente'], 2, '.', ','); ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['stockminimo'] == '0.00' ? "*********" : number_format($reg[$i]['stockminimo'], 2, '.', ','); ?></td>
           <td><?php echo $reg[$i]['stockmaximo'] == '0.00' ? "*********" : number_format($reg[$i]['stockmaximo'], 2, '.', ','); ?></td>
<?php } ?>
          <td><?php echo $reg[$i]['ivaingrediente'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
          <td><?php echo number_format($reg[$i]['descingrediente'], 2, '.', ','); ?></td>
<?php if ($documento == "EXCEL") { ?>
          <td><?php echo $reg[$i]['lote']; ?></td>
          <td><?php echo $reg[$i]['fechaexpiracion'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechaexpiracion'])); ?></td>
          <td><?php echo $reg[$i]['codproveedor'] == '0' ? "*********" : $reg[$i]['nomproveedor']; ?></td>
<?php } ?>
         </tr>
        <?php } ?>
         <tr class="text-center">
  <?php if ($documento == "EXCEL") { ?>
           <td colspan="4"></td>
  <?php } else { ?>
           <td colspan="4"></td>
  <?php } ?>
<td><?php echo $simbolo.number_format($TotalCompra, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalVenta, 2, '.', ','); ?></td>
<td><?php echo $cambio[0]['simbolo'].number_format($TotalMoneda, 2, '.', ','); ?></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
<?php if ($documento == "EXCEL") { ?>
<td></td>
<td></td>
<td></td>
<td></td>
<?php } else { ?>
<td></td>
<td></td>
<?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'INGREDIENTESCSV':

$tra = new Login();
$reg = $tra->ListarIngredientes();

$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 

$archivo = str_replace(" ", "_","LISTADO DE INGREDIENTES");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $reg[$i]['codingrediente']; ?></td>
           <td><?php echo $reg[$i]['nomingrediente']; ?></td>
           <td><?php echo $reg[$i]['codmedida']; ?></td>
           <td><?php echo number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
           <td><?php echo number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
           <td><?php echo number_format($reg[$i]['cantingrediente'], 2, '.', ','); ?></td>
           <td><?php echo $reg[$i]['stockminimo'] == '0.00' ? "0" : $reg[$i]['stockminimo']; ?></td>
           <td><?php echo $reg[$i]['stockmaximo'] == '0.00' ? "0" : $reg[$i]['stockmaximo']; ?></td>
           <td><?php echo $reg[$i]['ivaingrediente']; ?></td>
           <td><?php echo number_format($reg[$i]['descingrediente'], 2, '.', ','); ?></td>
           <td><?php echo $reg[$i]['lote']; ?></td>
           <td><?php echo $reg[$i]['fechaexpiracion'] == '0000-00-00' ? "0000-00-00" : date("d-m-Y",strtotime($reg[$i]['fechaexpiracion'])); ?></td>
           <td><?php echo $reg[$i]['codproveedor']; ?></td>
         </tr>
        <?php }  } ?>
</table>
<?php
break;

case 'INGREDIENTESVENDIDOS':

$tra = new Login();
$reg = $tra->BuscarIngredientesVendidos(); 

$archivo = str_replace(" ", "_","INGREDIENTES VENDIDOS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"])).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE INGREDIENTE</th>
           <th>MEDIDA</th>
           <th>DESC.</th>
           <th>PRECIO VENTA</th>
           <th>EXISTENCIA</th>
           <th>VENDIDO</th>
           <th>MONTO TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {

$precioTotal=0;
$existeTotal=0;
$vendidosTotal=0;
$pagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$precioTotal+=$reg[$i]['precioventa'];
$existeTotal+=$reg[$i]['cantingrediente'];
$vendidosTotal+=$reg[$i]['cantidad']; 
$pagoTotal+=$reg[$i]['precioventa']*$reg[$i]['cantidad']-$reg[$i]['descingrediente']/100; 
?>
         <tr class="text-center" class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['codingrediente']; ?></td>
          <td><?php echo $reg[$i]['nomingrediente']; ?></td>
          <td><?php echo $reg[$i]['nommedida']; ?></td>
          <td><?php echo number_format($reg[$i]['descingrediente'], 2, '.', ','); ?>%</td>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><?php echo number_format($reg[$i]['cantingrediente'], 2, '.', ','); ?></td>
          <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['precioventa']*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr class="text-center">
           <td colspan="5"></td>
<td><?php echo $simbolo.number_format($precioTotal, 2, '.', ','); ?></td>
<td><?php echo number_format($existeTotal, 2, '.', ','); ?></td>
<td><?php echo number_format($vendidosTotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($pagoTotal, 2, '.', ','); ?></td>
         </tr>
</table>
<?php
break;

case 'KARDEXINGREDIENTES':

$kardex = new Login();
$kardex = $kardex->BuscarKardexIngrediente(); 

$archivo = str_replace(" ", "_","KARDEX DEL INGREDIENTE (".portales($kardex[0]['nomingrediente']).")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>MOVIMIENTO</th>
           <th>ENTRADAS</th>
           <th>SALIDAS</th>
           <th>DEVOLUCIÓN</th>
           <th>EXISTENCIA</th>
<?php if ($documento == "EXCEL") { ?>
           <th><?php echo $impuesto; ?></th>
           <th>DESCUENTO</th>
           <th>PRECIO</th>
<?php } ?>
           <th>DOCUMENTO</th>
           <th>FECHA KARDEX</th>
         </tr>
      <?php 

if($kardex==""){
echo "";      
} else {

$TotalEntradas=0;
$TotalSalidas=0;
$TotalDevolucion=0;
$a=1;
for($i=0;$i<sizeof($kardex);$i++){ 
$TotalEntradas+=$kardex[$i]['entradas'];
$TotalSalidas+=$kardex[$i]['salidas'];
$TotalDevolucion+=$kardex[$i]['devolucion'];
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $kardex[$i]['movimiento']; ?></td>
          <td><?php echo number_format($kardex[$i]['entradas'], 2, '.', ','); ?></td>
          <td><?php echo number_format($kardex[$i]['salidas'], 2, '.', ','); ?></td>
          <td><?php echo number_format($kardex[$i]['devolucion'], 2, '.', ','); ?></td>
          <td><?php echo number_format($kardex[$i]['stockactual'], 2, '.', ','); ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $kardex[$i]['ivaingrediente'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
           <td><?php echo number_format($kardex[$i]['descingrediente'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($kardex[$i]["precio"], 2, '.', ','); ?></td>
<?php } ?>
          <td><?php echo $kardex[$i]['documento']." ".$num = ($kardex[$i]['documento'] == 'VENTA' || $kardex[$i]['documento'] == 'DEVOLUCION' ? $kardex[$i]['codproceso'] : ""); ?></td>
          <td><?php echo date("d-m-Y",strtotime($kardex[$i]['fechakardex'])); ?></td>
         </tr>
        <?php } } ?>
</table>
<strong>DETALLE DE INGREDIENTE<br>
<strong>CÓDIGO: <?php echo $kardex[0]['codingrediente']; ?><br>
<strong>DESCRIPCIÓN: <?php echo $kardex[0]['nomingrediente']; ?><br>
<strong>MEDIDA: <?php echo $kardex[0]['nommedida']; ?><br>
<strong>TOTAL ENTRADAS: <?php echo number_format($TotalEntradas, 2, '.', ','); ?><br>
<strong>TOTAL SALIDAS: <?php echo number_format($TotalSalidas, 2, '.', ','); ?><br>
<strong>TOTAL DEVOLUCIÓN: <?php echo number_format($TotalDevolucion, 2, '.', ','); ?><br>
<strong>EXISTENCIA: <?php echo number_format($kardex[0]['cantingrediente'], 2, '.', ','); ?><br>
<strong>PRECIO COMPRA: <?php echo $simbolo." ".number_format($kardex[0]['preciocompra'], 2, '.', ','); ?><br>
<strong>PPRECIO VENTA: <?php echo $simbolo." ".number_format($kardex[0]['precioventa'], 2, '.', ','); ?>
<?php
break;

case 'KARDEXVALORIZADOINGREDIENTES':

$tra = new Login();
$reg = $tra->ListarIngredientes(); 

$archivo = str_replace(" ", "_","KARDEX VALORIZADO DE INGREDIENTES");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE PRODUCTO</th>
           <th>MEDIDA</th>
           <th>PRECIO VENTA</th>
           <th><?php echo $impuesto; ?></th>
           <th>DESC.</th>
           <th>EXISTENCIA</th>
           <th>TOTAL VENTA</th>
           <th>TOTAL COMPRA</th>
           <th>GANANCIAS</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {

$existeTotal=0;
$pagoTotal=0;
$compraTotal=0;
$TotalGanancia=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$existeTotal+=$reg[$i]['cantingrediente'];
$pagoTotal+=$reg[$i]['precioventa']*$reg[$i]['cantingrediente']-$reg[$i]['descingrediente']/100;
$compraTotal+=$reg[$i]['preciocompra']*$reg[$i]['cantingrediente'];

$sumventa = $reg[$i]['precioventa']*$reg[$i]['cantingrediente']-$reg[$i]['descingrediente']/100; 
$sumcompra = $reg[$i]['preciocompra']*$reg[$i]['cantingrediente'];
 
$TotalGanancia+=$sumventa-$sumcompra;
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['codingrediente']; ?></td>
          <td><?php echo $reg[$i]['nomingrediente']; ?></td>
          <td><?php echo $reg[$i]['nommedida']; ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><?php echo $reg[$i]['ivaingrediente'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
          <td><?php echo number_format($reg[$i]['descingrediente'], 2, '.', ','); ?>%</td>
          <td><?php echo number_format($reg[$i]['cantingrediente'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['precioventa']*$reg[$i]['cantingrediente'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['cantingrediente'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($sumventa-$sumcompra, 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr>
           <td colspan="7"></td>
<td><?php echo number_format($existeTotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($pagoTotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($compraTotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalGanancia, 2, '.', ','); ?></td>
         </tr>
</table>
<?php
break;

################################# MODULO DE INGREDIENTES ##################################

























################################ MODULO DE PRODUCTOS ################################
case 'PRODUCTOS':

$tra = new Login();
$reg = $tra->ListarProductos();

$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 

$archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE PRODUCTO</th>
           <th>CATEGORIA</th>
           <th>PRECIO COMPRA</th>
           <th>PRECIO VENTA</th>
           <th><?php echo $cambio == '' ? "CAMBIO" : "PRECIO ".$cambio[0]['siglas']; ?></th>
           <th>EXISTENCIA</th>
<?php if ($documento == "EXCEL") { ?>
           <th>STOCK MINIMO</th>
           <th>STOCK MÁXIMO</th>
<?php } ?>
           <th><?php echo $impuesto; ?></th>
           <th>DESC</th>
<?php if ($documento == "EXCEL") { ?>
           <th>CÓDIGO DE BARRA</th>
           <th>LOTE</th>
           <th>FECHA DE ELABORACIÓN</th>
           <th>FECHA DE EXPIRACIÓN</th>
           <th>PROVEEDOR</th>
<?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalCompra=0;
$TotalVenta=0;
$TotalMoneda=0;
$TotalArticulos=0;
for($i=0;$i<sizeof($reg);$i++){ 
$TotalCompra+=$reg[$i]['preciocompra'];
$TotalVenta+=$reg[$i]['precioventa']-$reg[$i]['descproducto']/100;
$TotalMoneda += ($cambio == 0 ? "0" : $reg[$i]['precioventa']/$cambio[0]['montocambio']);
$TotalArticulos+=$reg[$i]['existencia'];
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codproducto']; ?></td>
           <td><?php echo $reg[$i]['producto']; ?></td>
           <td><?php echo $reg[$i]['nomcategoria']; ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
<td><?php echo $cambio == '' ? "*****" : $cambio[0]['simbolo'].number_format($reg[$i]['precioventa']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
           <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['stockminimo'] == '0.00' ? "*********" : $reg[$i]['stockminimo']; ?></td>
           <td><?php echo $reg[$i]['stockmaximo'] == '0.00' ? "*********" : $reg[$i]['stockmaximo']; ?></td>
<?php } ?>
          <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
          <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['codigobarra'] == '' ? "*********" : $reg[$i]['codigobarra']; ?></td>
           <td><?php echo $reg[$i]['lote'] == '' || $reg[$i]['lote'] == '0' ? "*********" : $reg[$i]['lote']; ?></td>
  <td><?php echo $reg[$i]['fechaelaboracion'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechaelaboracion'])); ?></td>
  <td><?php echo $reg[$i]['fechaexpiracion'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechaexpiracion'])); ?></td>
           <td><?php echo $reg[$i]['codproveedor'] == '0' ? "*********" : $reg[$i]['nomproveedor']; ?></td>
<?php } ?>
         </tr>
        <?php } ?>
         <tr class="text-center">
  <?php if ($documento == "EXCEL") { ?>
           <td colspan="4"></td>
  <?php } else { ?>
           <td colspan="4"></td>
  <?php } ?>
<td><?php echo $simbolo.number_format($TotalCompra, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalVenta, 2, '.', ','); ?></td>
<td><?php echo $cambio[0]['simbolo'].number_format($TotalMoneda, 2, '.', ','); ?></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
<?php if ($documento == "EXCEL") { ?>
<td></td>
<td></td>
<td></td>
<td></td>
<?php } else { ?>
<td></td>
<td></td>
<?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'PRODUCTOSCSV':

$tra = new Login();
$reg = $tra->ListarProductos();

$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 

$archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $reg[$i]['codproducto']; ?></td>
           <td><?php echo $reg[$i]['producto']; ?></td>
           <td><?php echo $reg[$i]['codcategoria']; ?></td>
           <td><?php echo number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
           <td><?php echo number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
           <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
           <td><?php echo $reg[$i]['stockminimo'] == '0.00' ? "0" : number_format($reg[$i]['stockminimo'], 2, '.', ','); ?></td>
           <td><?php echo $reg[$i]['stockmaximo'] == '0.00' ? "0" : number_format($reg[$i]['stockmaximo'], 2, '.', ','); ?></td>
          <td><?php echo $reg[$i]['ivaproducto']; ?></td>
          <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
           <td><?php echo $reg[$i]['codigobarra']; ?></td>
           <td><?php echo $reg[$i]['lote']; ?></td>
  <td><?php echo $reg[$i]['fechaelaboracion'] == '0000-00-00' ? "0000-00-00" : date("d-m-Y",strtotime($reg[$i]['fechaelaboracion'])); ?></td>
  <td><?php echo $reg[$i]['fechaexpiracion'] == '0000-00-00' ? "0000-00-00" : date("d-m-Y",strtotime($reg[$i]['fechaexpiracion'])); ?></td>
           <td><?php echo $reg[$i]['codproveedor']; ?></td>
           <td><?php echo $reg[$i]['stockteorico']; ?></td>
           <td><?php echo $reg[$i]['motivoajuste']; ?></td>
         </tr>
        <?php }  } ?>
</table>
<?php
break;

case 'PRODUCTOSVENDIDOS':

$tra = new Login();
$reg = $tra->BuscarProductosVendidos(); 

$archivo = str_replace(" ", "_","PRODUCTOS VENDIDOS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"])).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE PRODUCTO</th>
           <th>CATEGORIA</th>
           <th>DESC.</th>
           <th>PRECIO VENTA</th>
           <th>EXISTENCIA</th>
           <th>VENDIDO</th>
           <th>MONTO TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {

$precioTotal=0;
$existeTotal=0;
$vendidosTotal=0;
$pagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$precioTotal+=$reg[$i]['precioventa'];
$existeTotal+=$reg[$i]['existencia'];
$vendidosTotal+=$reg[$i]['cantidad']; 
$pagoTotal+=$reg[$i]['precioventa']*$reg[$i]['cantidad']-$reg[$i]['descproducto']/100; 
?>
         <tr class="text-center" class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['codproducto']; ?></td>
          <td><?php echo $reg[$i]['producto']; ?></td>
          <td><?php echo $reg[$i]['nomcategoria']; ?></td>
          <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
          <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['precioventa']*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr class="text-center">
           <td colspan="5"></td>
<td><?php echo $simbolo.number_format($precioTotal, 2, '.', ','); ?></td>
<td><?php echo number_format($existeTotal, 2, '.', ','); ?></td>
<td><?php echo number_format($vendidosTotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($pagoTotal, 2, '.', ','); ?></td>
         </tr>
</table>
<?php
break;

case 'PRODUCTOSXMONEDA':

$cambio = new Login();
$cambio = $cambio->BuscarTiposCambios();

$tra = new Login();
$reg = $tra->ListarProductos(); 

$archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS DE MONEDA ".$cambio[0]['moneda'].")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE PRODUCTO</th>
           <th>CATEGORIA</th>
           <th>PRECIO VENTA</th>
           <th>PRECIO <?php echo $cambio[0]['siglas']; ?></th>
           <th>EXISTENCIA</th>
<?php if ($documento == "EXCEL") { ?>
           <th>STOCK MINIMO</th>
           <th>STOCK MÁXIMO</th>
<?php } ?>
           <th><?php echo $impuesto; ?></th>
           <th>DESCUENTO</th>
<?php if ($documento == "EXCEL") { ?>
           <th>CÓDIGO DE BARRA</th>
           <th>LOTE</th>
           <th>FECHA DE ELABORACIÓN</th>
           <th>FECHA DE EXPIRACIÓN</th>
           <th>PROVEEDOR</th>
<?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codproducto']; ?></td>
           <td><?php echo $reg[$i]['producto']; ?></td>
           <td><?php echo $reg[$i]['nomcategoria']; ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
           <td><?php echo $cambio[0]['simbolo'].number_format($reg[$i]['precioventa']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
           <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['stockminimo'] == '0.00' ? "*********" : number_format($reg[$i]['stockminimo'], 2, '.', ','); ?></td>
           <td><?php echo $reg[$i]['stockmaximo'] == '0.00' ? "*********" : number_format($reg[$i]['stockmaximo'], 2, '.', ','); ?></td>
<?php } ?>
          <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
          <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['codigobarra'] == '' ? "*********" : $reg[$i]['codigobarra']; ?></td>
           <td><?php echo $reg[$i]['lote'] == '' ? "*********" : $reg[$i]['lote']; ?></td>
  <td><?php echo $reg[$i]['fechaelaboracion'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechaelaboracion'])); ?></td>
  <td><?php echo $reg[$i]['fechaexpiracion'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechaexpiracion'])); ?></td>
           <td><?php echo $reg[$i]['codproveedor'] == '0' ? "*********" : $reg[$i]['nomproveedor']; ?></td>
<?php } ?>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'KARDEXPRODUCTOS':

$kardex = new Login();
$kardex = $kardex->BuscarKardexProducto(); 

$archivo = str_replace(" ", "_","KARDEX DEL PRODUCTO (".portales($kardex[0]['producto']).")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>MOVIMIENTO</th>
           <th>ENTRADAS</th>
           <th>SALIDAS</th>
           <th>DEVOLUCIÓN</th>
           <th>EXISTENCIA</th>
<?php if ($documento == "EXCEL") { ?>
           <th><?php echo $impuesto; ?></th>
           <th>DESCUENTO</th>
           <th>PRECIO</th>
<?php } ?>
           <th>DOCUMENTO</th>
           <th>FECHA KARDEX</th>
         </tr>
      <?php 

if($kardex==""){
echo "";      
} else {

$TotalEntradas=0;
$TotalSalidas=0;
$TotalDevolucion=0;
$a=1;
for($i=0;$i<sizeof($kardex);$i++){ 
$TotalEntradas+=$kardex[$i]['entradas'];
$TotalSalidas+=$kardex[$i]['salidas'];
$TotalDevolucion+=$kardex[$i]['devolucion'];
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $kardex[$i]['movimiento']; ?></td>
          <td><?php echo number_format($kardex[$i]['entradas'], 2, '.', ','); ?></td>
          <td><?php echo number_format($kardex[$i]['salidas'], 2, '.', ','); ?></td>
          <td><?php echo number_format($kardex[$i]['devolucion'], 2, '.', ','); ?></td>
          <td><?php echo number_format($kardex[$i]['stockactual'], 2, '.', ','); ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $kardex[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
           <td><?php echo number_format($kardex[$i]['descproducto'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($kardex[$i]["precio"], 2, '.', ','); ?></td>
<?php } ?>
          <td><?php echo $kardex[$i]['documento']." ".$num = ($kardex[$i]['documento'] == 'VENTA' || $kardex[$i]['documento'] == 'DEVOLUCION' ? $kardex[$i]['codproceso'] : ""); ?></td>
          <td><?php echo date("d-m-Y",strtotime($kardex[$i]['fechakardex'])); ?></td>
         </tr>
        <?php } } ?>
</table>
<strong>DETALLE DE PRODUCTO<br>
<strong>CÓDIGO: <?php echo $kardex[0]['codproducto']; ?><br>
<strong>DESCRIPCIÓN: <?php echo $kardex[0]['producto']; ?><br>
<strong>CATEGORIA: <?php echo $kardex[0]['nomcategoria']; ?><br>
<strong>TOTAL ENTRADAS: <?php echo number_format($TotalEntradas, 2, '.', ','); ?><br>
<strong>TOTAL SALIDAS: <?php echo number_format($TotalSalidas, 2, '.', ','); ?><br>
<strong>TOTAL DEVOLUCIÓN: <?php echo number_format($TotalDevolucion, 2, '.', ','); ?><br>
<strong>EXISTENCIA: <?php echo number_format($kardex[0]['existencia'], 2, '.', ','); ?><br>
<strong>PRECIO COMPRA: <?php echo $simbolo." ".number_format($kardex[0]['preciocompra'], 2, '.', ','); ?><br>
<strong>PPRECIO VENTA: <?php echo $simbolo." ".number_format($kardex[0]['precioventa'], 2, '.', ','); ?>
<?php
break;

case 'KARDEXVALORIZADOPRODUCTOS':

$tra = new Login();
$reg = $tra->ListarProductos(); 

$archivo = str_replace(" ", "_","KARDEX VALORIZADO DE PRODUCTOS");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE PRODUCTO</th>
           <th>CATEGORIA</th>
           <th>PRECIO VENTA</th>
           <th><?php echo $impuesto; ?></th>
           <th>DESC.</th>
           <th>EXISTENCIA</th>
           <th>TOTAL VENTA</th>
           <th>TOTAL COMPRA</th>
           <th>GANANCIAS</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {

$existeTotal=0;
$pagoTotal=0;
$compraTotal=0;
$TotalGanancia=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$existeTotal+=$reg[$i]['existencia'];
$pagoTotal+=$reg[$i]['precioventa']*$reg[$i]['existencia']-$reg[$i]['descproducto']/100;
$compraTotal+=$reg[$i]['preciocompra']*$reg[$i]['existencia'];

$sumventa = $reg[$i]['precioventa']*$reg[$i]['existencia']-$reg[$i]['descproducto']/100; 
$sumcompra = $reg[$i]['preciocompra']*$reg[$i]['existencia'];
 
$TotalGanancia+=$sumventa-$sumcompra;
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['codproducto']; ?></td>
          <td><?php echo $reg[$i]['producto']; ?></td>
          <td><?php echo $reg[$i]['nomcategoria']; ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
          <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
          <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['precioventa']*$reg[$i]['existencia'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['existencia'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($sumventa-$sumcompra, 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr>
           <td colspan="7"></td>
<td><?php echo number_format($existeTotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($pagoTotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($compraTotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalGanancia, 2, '.', ','); ?></td>
         </tr>
</table>
<?php
break;

case 'KARDEXPRODUCTOSVALORIZADOXFECHAS':

$tra = new Login();
$reg = $tra->BuscarKardexProductosValorizadoxFechas(); 

$archivo = str_replace(" ", "_","KARDEX VALORIZADO POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"])).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE PRODUCTO</th>
           <th>CATEGORIA</th>
           <th>DESC.</th>
           <th>PRECIO VENTA</th>
           <th>EXISTENCIA</th>
           <th>VENDIDO</th>
           <th>TOTAL VENTA</th>
           <th>TOTAL COMPRA</th>
           <th>GANANCIAS</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {

$precioTotal=0;
$existeTotal=0;
$vendidosTotal=0;
$pagoTotal=0;
$compraTotal=0;
$TotalGanancia=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$precioTotal+=$reg[$i]['precioventa'];
$existeTotal+=$reg[$i]['existencia'];
$vendidosTotal+=$reg[$i]['cantidad']; 
$pagoTotal+=$reg[$i]['precioventa']*$reg[$i]['cantidad']-$reg[$i]['descproducto']/100;
$compraTotal+=$reg[$i]['preciocompra']*$reg[$i]['cantidad'];

$sumventa = $reg[$i]['precioventa']*$reg[$i]['cantidad']-$reg[$i]['descproducto']/100; 
$sumcompra = $reg[$i]['preciocompra']*$reg[$i]['cantidad'];
 
$TotalGanancia+=$sumventa-$sumcompra;
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['codproducto']; ?></td>
          <td><?php echo $reg[$i]['producto']; ?></td>
          <td><?php echo $reg[$i]['codcategoria'] == '' ? "*****" : $reg[$i]['nomcategoria']; ?></td>
          <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
          <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['precioventa']*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($sumventa-$sumcompra, 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr>
           <td colspan="5"></td>
<td><?php echo $simbolo.number_format($precioTotal, 2, '.', ','); ?></td>
<td><?php echo number_format($existeTotal, 2, '.', ','); ?></strong></td>
<td><?php echo number_format($vendidosTotal, 2, '.', ','); ?></strong></td>
<td><?php echo $simbolo.number_format($pagoTotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($compraTotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalGanancia, 2, '.', ','); ?></td>
         </tr>
</table>
<?php
break;
################################# MODULO DE PRODUCTOS ##################################
























################################ MODULO DE COMBOS ################################
case 'COMBOS':

$tra = new Login();
$reg = $tra->ListarCombos();

$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 

$archivo = str_replace(" ", "_","LISTADO DE COMBOS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE COMBO</th>
           <th>PRECIO COMPRA</th>
           <th>PRECIO VENTA</th>
           <th><?php echo $cambio == '' ? "CAMBIO" : "PRECIO ".$cambio[0]['siglas']; ?></th>
           <th>EXISTENCIA</th>
<?php if ($documento == "EXCEL") { ?>
           <th>STOCK MINIMO</th>
           <th>STOCK MÁXIMO</th>
<?php } ?>
           <th><?php echo $impuesto; ?></th>
           <th>DESC</th>
<?php if ($documento == "EXCEL") { ?>
           <th>DETALLES DE PRODUCTOS</th>
<?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalCompra=0;
$TotalVenta=0;
$TotalMoneda=0;
$TotalArticulos=0;
for($i=0;$i<sizeof($reg);$i++){ 
$TotalCompra+=$reg[$i]['preciocompra'];
$TotalVenta+=$reg[$i]['precioventa']-$reg[$i]['desccombo']/100;
$TotalMoneda += ($cambio == "" ? "0" : $reg[$i]['precioventa']/$cambio[0]['montocambio']);
$TotalArticulos+=$reg[$i]['existencia'];
?>
         <tr align="center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codcombo']; ?></td>
           <td><?php echo $reg[$i]['nomcombo']; ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
<td><?php echo $cambio == '' ? "*****" : $cambio[0]['simbolo'].number_format($reg[$i]['precioventa']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
           <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['stockminimo'] == '0.00' ? "*********" : number_format($reg[$i]['stockminimo'], 2, '.', ','); ?></td>
           <td><?php echo $reg[$i]['stockmaximo'] == '0.00' ? "*********" : number_format($reg[$i]['stockmaximo'], 2, '.', ','); ?></td>
<?php } ?>
          <td><?php echo $reg[$i]['ivacombo'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
          <td><?php echo number_format($reg[$i]['desccombo'], 2, '.', ','); ?></td>
<?php if ($documento == "EXCEL") { ?>
  <td style="text-align:left;font-weight:bold;font-size:10px;"><?php echo $reg[$i]['detalles_productos']; ?></td>      
<?php } ?>
         </tr>
        <?php } ?>
         <tr align="center">
  <?php if ($documento == "EXCEL") { ?>
           <td colspan="3"></td>
  <?php } else { ?>
           <td colspan="3"></td>
  <?php } ?>
<td><?php echo $simbolo.number_format($TotalCompra, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalVenta, 2, '.', ','); ?></td>
<td><?php echo $cambio == '' ? "" : $cambio[0]['simbolo'].number_format($TotalMoneda, 2, '.', ','); ?></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
<?php if ($documento == "EXCEL") { ?>
<td></td>
<td></td>
<td></td>
<td></td>
<?php } else { ?>
<td></td>
<td></td>
<?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'COMBOSVENDIDOS':

$tra = new Login();
$reg = $tra->BuscarProductosVendidos(); 

$archivo = str_replace(" ", "_","COMBOS VENDIDOS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"])).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE COMBO</th>
           <th>DESC.</th>
           <th>PRECIO VENTA</th>
           <th>EXISTENCIA</th>
           <th>VENDIDO</th>
           <th>MONTO TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {

$precioTotal=0;
$existeTotal=0;
$vendidosTotal=0;
$pagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$precioTotal+=$reg[$i]['precioventa'];
$existeTotal+=$reg[$i]['existencia'];
$vendidosTotal+=$reg[$i]['cantidad']; 
$pagoTotal+=$reg[$i]['precioventa']*$reg[$i]['cantidad']-$reg[$i]['descproducto']/100; 
?>
         <tr align="center" class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['codproducto']; ?></td>
          <td><?php echo $reg[$i]['producto']; ?></td>
          <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
          <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['precioventa']*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr align="center">
           <td colspan="4"></td>
<td><?php echo $simbolo.number_format($precioTotal, 2, '.', ','); ?></td>
<td><?php echo number_format($existeTotal, 2, '.', ','); ?></strong></td>
<td><?php echo number_format($vendidosTotal, 2, '.', ','); ?></strong></td>
<td><?php echo $simbolo.number_format($pagoTotal, 2, '.', ','); ?></td>
         </tr>
</table>
<?php
break;

case 'COMBOSXMONEDA':

$cambio = new Login();
$cambio = $cambio->BuscarTiposCambios();

$tra = new Login();
$reg = $tra->ListarCombos(); 

$archivo = str_replace(" ", "_","LISTADO DE COMBOS DE MONEDA ".$cambio[0]['moneda'].")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE COMBO</th>
           <th>PRECIO VENTA</th>
           <th>PRECIO <?php echo $cambio[0]['siglas']; ?></th>
           <th>EXISTENCIA</th>
<?php if ($documento == "EXCEL") { ?>
           <th>STOCK MINIMO</th>
           <th>STOCK MÁXIMO</th>
<?php } ?>
           <th><?php echo $impuesto; ?></th>
           <th>DESCUENTO</th>
           <th>DETALLES DE PRODUCTOS</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr align="center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codcombo']; ?></td>
           <td><?php echo $reg[$i]['nomcombo']; ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
           <td><?php echo $cambio[0]['simbolo'].number_format($reg[$i]['precioventa']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
           <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['stockminimo'] == '0.00' ? "*********" : number_format($reg[$i]['stockminimo'], 2, '.', ','); ?></td>
           <td><?php echo $reg[$i]['stockmaximo'] == '0.00' ? "*********" : number_format($reg[$i]['stockmaximo'], 2, '.', ','); ?></td>
<?php } ?>
          <td><?php echo $reg[$i]['ivacombo'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
          <td><?php echo number_format($reg[$i]['desccombo'], 2, '.', ','); ?></td>
          <td style="text-align:left;font-weight:bold;font-size:10px;"><?php echo $reg[$i]['detalles_productos']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'KARDEXCOMBOS':

$kardex = new Login();
$kardex = $kardex->BuscarKardexCombo(); 

$archivo = str_replace(" ", "_","KARDEX DEL COMBO (".portales($kardex[0]['nomcombo']).")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>MOVIMIENTO</th>
           <th>ENTRADAS</th>
           <th>SALIDAS</th>
           <th>DEVOLUCIÓN</th>
           <th>EXISTENCIA</th>
<?php if ($documento == "EXCEL") { ?>
           <th><?php echo $impuesto; ?></th>
           <th>DESCUENTO</th>
           <th>PRECIO</th>
<?php } ?>
           <th>DOCUMENTO</th>
           <th>FECHA KARDEX</th>
         </tr>
      <?php 

if($kardex==""){
echo "";      
} else {

$TotalEntradas=0;
$TotalSalidas=0;
$TotalDevolucion=0;
$a=1;
for($i=0;$i<sizeof($kardex);$i++){ 
$TotalEntradas+=$kardex[$i]['entradas'];
$TotalSalidas+=$kardex[$i]['salidas'];
$TotalDevolucion+=$kardex[$i]['devolucion'];
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $kardex[$i]['movimiento']; ?></td>
          <td><?php echo number_format($kardex[$i]['entradas'], 2, '.', ','); ?></td>
          <td><?php echo number_format($kardex[$i]['salidas'], 2, '.', ','); ?></td>
          <td><?php echo number_format($kardex[$i]['devolucion'], 2, '.', ','); ?></td>
          <td><?php echo number_format($kardex[$i]['stockactual'], 2, '.', ','); ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $kardex[$i]['ivacombo'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
          <td><?php echo number_format($kardex[$i]['desccombo'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($kardex[$i]["precio"], 2, '.', ','); ?></td>
<?php } ?>
          <td><?php echo $kardex[$i]['documento']." ".$num = ($kardex[$i]['documento'] == 'VENTA' || $kardex[$i]['documento'] == 'DEVOLUCION' ? $kardex[$i]['codproceso'] : ""); ?></td>
          <td><?php echo date("d-m-Y",strtotime($kardex[$i]['fechakardex'])); ?></td>
         </tr>
        <?php } } ?>
</table>
<strong>DETALLE DE COMBO</strong><br>
<strong>CÓDIGO:</strong> <?php echo $kardex[0]['codcombo']; ?><br>
<strong>DESCRIPCIÓN:</strong> <?php echo $kardex[0]['nomcombo']; ?><br>
<strong>TOTAL ENTRADAS:</strong> <?php echo number_format($TotalEntradas, 2, '.', ','); ?><br>
<strong>TOTAL SALIDAS:</strong> <?php echo number_format($TotalSalidas, 2, '.', ','); ?><br>
<strong>TOTAL DEVOLUCIÓN:</strong> <?php echo number_format($TotalDevolucion, 2, '.', ','); ?><br>
<strong>EXISTENCIA:</strong> <?php echo number_format($kardex[0]['existencia'], 2, '.', ','); ?><br>
<strong>PRECIO COMPRA:</strong> <?php echo $simbolo." ".number_format($kardex[0]['preciocompra'], 2, '.', ','); ?><br>
<strong>PPRECIO VENTA:</strong> <?php echo $simbolo." ".number_format($kardex[0]['precioventa'], 2, '.', ','); ?>
<?php
break;

case 'KARDEXVALORIZADOCOMBOS':

$tra = new Login();
$reg = $tra->ListarCombos(); 

$archivo = str_replace(" ", "_","KARDEX VALORIZADO DE COMBOS");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE COMBO</th>
           <th>PRECIO VENTA</th>
           <th><?php echo $impuesto; ?></th>
           <th>DESC.</th>
           <th>EXISTENCIA</th>
           <th>TOTAL VENTA</th>
           <th>TOTAL COMPRA</th>
           <th>GANANCIAS</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {

$existeTotal=0;
$pagoTotal=0;
$compraTotal=0;
$TotalGanancia=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$existeTotal+=$reg[$i]['existencia'];
$pagoTotal+=$reg[$i]['precioventa']*$reg[$i]['existencia']-$reg[$i]['desccombo']/100;
$compraTotal+=$reg[$i]['preciocompra']*$reg[$i]['existencia'];

$sumventa = $reg[$i]['precioventa']*$reg[$i]['existencia']-$reg[$i]['desccombo']/100; 
$sumcompra = $reg[$i]['preciocompra']*$reg[$i]['existencia'];
 
$TotalGanancia+=$sumventa-$sumcompra;
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['codcombo']; ?></td>
          <td><?php echo $reg[$i]['nomcombo']; ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><?php echo $reg[$i]['ivacombo'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
          <td><?php echo number_format($reg[$i]['desccombo'], 2, '.', ','); ?>%</td>
          <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['precioventa']*$reg[$i]['existencia'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['existencia'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($sumventa-$sumcompra, 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr>
           <td colspan="6"></td>
<td><?php echo number_format($existeTotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($pagoTotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($compraTotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalGanancia, 2, '.', ','); ?></td>
         </tr>
</table>
<?php
break;

case 'KARDEXCOMBOSVALORIZADOXFECHAS':

$tra = new Login();
$reg = $tra->BuscarKardexCombosValorizadoxFechas(); 

$archivo = str_replace(" ", "_","KARDEX COMBOS VALORIZADO POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"])).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE COMBO</th>
           <th>DESC.</th>
           <th>PRECIO VENTA</th>
           <th>EXISTENCIA</th>
           <th>VENDIDO</th>
           <th>TOTAL VENTA</th>
           <th>TOTAL COMPRA</th>
           <th>GANANCIAS</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {

$precioTotal=0;
$existeTotal=0;
$vendidosTotal=0;
$pagoTotal=0;
$compraTotal=0;
$TotalGanancia=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$precioTotal+=$reg[$i]['precioventa'];
$existeTotal+=$reg[$i]['existencia'];
$vendidosTotal+=$reg[$i]['cantidad']; 
$pagoTotal+=$reg[$i]['precioventa']*$reg[$i]['cantidad']-$reg[$i]['descproducto']/100;
$compraTotal+=$reg[$i]['preciocompra']*$reg[$i]['cantidad'];

$sumventa = $reg[$i]['precioventa']*$reg[$i]['cantidad']-$reg[$i]['descproducto']/100; 
$sumcompra = $reg[$i]['preciocompra']*$reg[$i]['cantidad'];
 
$TotalGanancia+=$sumventa-$sumcompra;
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['codproducto']; ?></td>
          <td><?php echo $reg[$i]['producto']; ?></td>
          <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
          <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['precioventa']*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($sumventa-$sumcompra, 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr>
           <td colspan="4"></td>
<td><?php echo $simbolo.number_format($precioTotal, 2, '.', ','); ?></td>
<td><?php echo number_format($existeTotal, 2, '.', ','); ?></strong></td>
<td><?php echo number_format($vendidosTotal, 2, '.', ','); ?></strong></td>
<td><?php echo $simbolo.number_format($pagoTotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($compraTotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalGanancia, 2, '.', ','); ?></td>
         </tr>
</table>
<?php
break;
################################# MODULO DE COMBOS ##################################

























################################### MODULO DE COMPRAS ###################################

case 'COMPRAS':

$tra = new Login();
$reg = $tra->ListarCompras(); 

$archivo = str_replace(" ", "_","LISTADO DE COMPRAS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE COMPRA</th>
           <th>DESCRIPCIÓN DE PROVEEDOR</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>FECHA EMISIÓN</th>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'];
$TotalImpuesto+=$reg[$i]['totalivac'];
$TotalDescuento+=$reg[$i]['totaldescuentoc'];
$TotalImporte+=$reg[$i]['totalpagoc'];
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codcompra']; ?></td>
           <td><?php echo $reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]["statuscompra"]; ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
      
      <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>

      <?php } ?>
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
           <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
           <?php if ($documento == "EXCEL") { ?>
          <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalivac'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['ivac'], 2, '.', ','); ?>%</sup></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuentoc'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr class="text-center">
           <td colspan="8"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'CUENTASXPAGAR':

$tra = new Login();
$reg = $tra->ListarCuentasxPagar(); 

$archivo = str_replace(" ", "_","LISTADO DE COMPRAS POR PAGAR");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE COMPRA</th>
           <th>DESCRIPCIÓN DE PROVEEDOR</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>FECHA EMISIÓN</th>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'];
$TotalImpuesto+=$reg[$i]['totalivac'];
$TotalDescuento+=$reg[$i]['totaldescuentoc'];
$TotalImporte+=$reg[$i]['totalpagoc'];
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codcompra']; ?></td>
           <td><?php echo $reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]["statuscompra"]; ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
      
      <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>

      <?php } ?>
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
           <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
           <?php if ($documento == "EXCEL") { ?>
          <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalivac'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['ivac'], 2, '.', ','); ?>%</sup></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuentoc'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr class="text-center">
           <td colspan="8"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'COMPRASXPROVEEDOR':

$tra = new Login();
$reg = $tra->BuscarComprasxProveedor(); 

$archivo = str_replace(" ", "_","LISTADO DE COMPRAS DEL PROVEEDOR (".$reg[0]['cuitproveedor'].": ".$reg[0]['nomproveedor'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE COMPRA</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>FECHA EMISIÓN</th>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'];
$TotalImpuesto+=$reg[$i]['totalivac'];
$TotalDescuento+=$reg[$i]['totaldescuentoc'];
$TotalImporte+=$reg[$i]['totalpagoc'];
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codcompra']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]["statuscompra"]; ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
      
      <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>

      <?php } ?>
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
           <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
           <?php if ($documento == "EXCEL") { ?>
          <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalivac'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['ivac'], 2, '.', ','); ?>%</sup></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuentoc'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr class="text-center">
           <td colspan="7"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
</table>
<?php
break;


case 'COMPRASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarComprasxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE COMPRAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"])).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE COMPRA</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>FECHA EMISIÓN</th>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'];
$TotalImpuesto+=$reg[$i]['totalivac'];
$TotalDescuento+=$reg[$i]['totaldescuentoc'];
$TotalImporte+=$reg[$i]['totalpagoc'];
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codcompra']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]["statuscompra"]; ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
      
      <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>

      <?php } ?>
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
           <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
           <?php if ($documento == "EXCEL") { ?>
          <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalivac'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['ivac'], 2, '.', ','); ?>%</sup></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuentoc'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr class="text-center">
           <td colspan="7"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
</table>
<?php
break;
################################## MODULO DE COMPRAS ###################################
















############################### MODULO DE COTIZACIONES ###############################
case 'COTIZACIONES':

$tra = new Login();
$reg = $tra->ListarCotizaciones(); 

$archivo = str_replace(" ", "_","LISTADO DE COTIZACIONES");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE COTIZACIÓN</th>
           <th>DESCRIPCIÓN DE CLIENTE</th>
           <th>OBSERVACIONES</th>
           <th>FECHA DE EMISIÓN</th>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
   
$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codcotizacion']; ?></td>
           <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
           <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechacotizacion'])); ?></td>
           <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr>
           <?php echo $documento == "EXCEL" ? '<td colspan="5"></td>' : '<td colspan="5"></td>'; ?>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></strong></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'COTIZACIONESXFECHAS':

$tra = new Login();
$reg = $tra->BuscarCotizacionesxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE COTIZACIONES (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"])));

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE COTIZACIÓN</th>
           <th>DESCRIPCIÓN DE CLIENTE</th>
           <th>OBSERVACIONES</th>
           <th>FECHA DE EMISIÓN</th>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
   
$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codcotizacion']; ?></td>
           <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
           <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechacotizacion'])); ?></td>
           <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr>
           <?php echo $documento == "EXCEL" ? '<td colspan="5"></td>' : '<td colspan="5"></td>'; ?>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></strong></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
</table>
<?php
break;


case 'PRODUCTOSCOTIZADOS':

$tra = new Login();
$reg = $tra->BuscarProductosCotizados(); 

$archivo = str_replace(" ", "_","PRODUCTOS COTIZADOS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"])));

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE PRODUCTO</th>
           <th>CATEGORIA</th>
           <th>DESC.</th>
           <th><?php echo $impuesto; ?></th>
           <th>PRECIO VENTA</th>
           <th>EXISTENCIA</th>
           <th>COTIZADO</th>
           <th>MONTO TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {

$precioTotal=0;
$existeTotal=0;
$vendidosTotal=0;
$pagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$precioTotal+=$reg[$i]['precioventa'];
$existeTotal+=$reg[$i]['existencia'];
$vendidosTotal+=$reg[$i]['cantidad']; 
$pagoTotal+=$reg[$i]['precioventa']*$reg[$i]['cantidad']-$reg[$i]['descproducto']/100; 
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['codproducto']; ?></td>
          <td><?php echo $reg[$i]['producto']; ?></td>
          <td><?php echo $reg[$i]['nomcategoria']; ?></td>
          <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
          <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
          <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['precioventa']*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr>
           <td colspan="6"></td>
<td><?php echo $simbolo.number_format($precioTotal, 2, '.', ','); ?></td>
<td><?php echo number_format($existeTotal, 2, '.', ','); ?></strong></td>
<td><?php echo number_format($vendidosTotal, 2, '.', ','); ?></strong></td>
<td><?php echo $simbolo.number_format($pagoTotal, 2, '.', ','); ?></td>
         </tr>
</table>
<?php
break;


case 'COTIZACIONESXVENDEDOR':

$tra = new Login();
$reg = $tra->BuscarCotizacionesxVendedor(); 

$archivo = str_replace(" ", "_","PRODUCTOS COTIZADOS DEL VENDEDOR (".$reg[0]['dni'].": ".$reg[0]['nombres']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"])));

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE PRODUCTO</th>
           <th>CATEGORIA</th>
           <th>DESC.</th>
           <th><?php echo $impuesto; ?></th>
           <th>PRECIO VENTA</th>
           <th>EXISTENCIA</th>
           <th>COTIZADO</th>
           <th>MONTO TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {

$precioTotal=0;
$existeTotal=0;
$vendidosTotal=0;
$pagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$precioTotal+=$reg[$i]['precioventa'];
$existeTotal+=$reg[$i]['existencia'];
$vendidosTotal+=$reg[$i]['cantidad']; 
$pagoTotal+=$reg[$i]['precioventa']*$reg[$i]['cantidad']-$reg[$i]['descproducto']/100; 
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['codproducto']; ?></td>
          <td><?php echo $reg[$i]['producto']; ?></td>
          <td><?php echo $reg[$i]['nomcategoria']; ?></td>
          <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
          <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
          <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['precioventa']*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr>
           <td colspan="6"></td>
<td><?php echo $simbolo.number_format($precioTotal, 2, '.', ','); ?></td>
<td><?php echo number_format($existeTotal, 2, '.', ','); ?></strong></td>
<td><?php echo number_format($vendidosTotal, 2, '.', ','); ?></strong></td>
<td><?php echo $simbolo.number_format($pagoTotal, 2, '.', ','); ?></td>
         </tr>
</table>
<?php
break;

############################### MODULO DE COTIZACIONES ###############################
























##################################### MODULO DE CAJAS ###################################

case 'CAJAS':

$tra = new Login();
$reg = $tra->ListarCajas(); 

$archivo = str_replace(" ", "_","LISTADO DE CAJAS ASIGNADAS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE CAJA</th>
           <th>NOMBRE DE CAJA</th>
           <th>RESPONSABLE</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nrocaja']; ?></td>
           <td><?php echo $reg[$i]['nomcaja']; ?></td>
           <td><?php echo $reg[$i]['dni'].": ".$reg[$i]['nombres']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'ARQUEOS':

$tra = new Login();
$reg = $tra->ListarArqueoCaja(); 

$archivo = str_replace(" ", "_","LISTADO DE ARQUEOS DE CAJAS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE CAJA</th>
<?php if ($documento == "EXCEL") { ?>
           <th>RESPONSABLE</th>
           <th>APERTURA</th>
           <th>CIERRE</th>
           <th>OBSERVACIONES</th>
<?php } ?>
           <th>INICIAL</th>
           <th>TOTAL EN VENTAS</th>
<?php if ($documento == "EXCEL") { ?>
           <th>VENTAS EN EFECTIVO</th>
           <th>VENTAS EN OTROS</th>
           <th>VENTAS A CREDITOS</th>
           <th>ABONOS EN EFECTIVO</th>
           <th>ABONOS EN OTROS</th>
           <th>INGRESOS EN EFECTIVO</th>
           <th>INGRESOS EN OTROS</th>
           <th>EGRESOS</th>
           <th>PROPINAS EN EFECTIVO</th>
           <th>PROPINAS EN OTROS</th>
<?php } ?>
           <th>TOTAL EFECTIVO</th>
           <th>EFECTIVO EN CAJA</th>
           <th>DIFERENCIA</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {


$TotalVentas = 0;
$VentasEfectivo = 0;
$VentasOtros = 0;
$TotalCreditos = 0;
$AbonosEfectivo = 0;
$AbonosOtros = 0;
$IngresosEfectivo = 0;
$IngresosOtros = 0;
$TotalEgresos = 0;
$PropinasEfectivo = 0;
$PropinasOtros = 0;
$TotalEfectivo = 0;
$TotalCaja = 0;
$TotalDiferencia = 0;

$a=1; 
for($i=0;$i<sizeof($reg);$i++){

$TotalVentas += $reg[$i]['efectivo']+$reg[$i]['cheque']+$reg[$i]['tcredito']+$reg[$i]['tdebito']+$reg[$i]['tprepago']+$reg[$i]['transferencia']+$reg[$i]['electronico']+$reg[$i]['cupon']+$reg[$i]['otros'];

$VentasEfectivo += $reg[$i]['efectivo'];

$VentasOtros += $reg[$i]['cheque']+$reg[$i]['tcredito']+$reg[$i]['tdebito']+$reg[$i]['tprepago']+$reg[$i]['transferencia']+$reg[$i]['electronico']+$reg[$i]['cupon']+$reg[$i]['otros'];

$TotalEfectivo += $reg[$i]['montoinicial']+$reg[$i]['efectivo']+$reg[$i]['ingresosefectivo']+$reg[$i]['abonosefectivo']+$reg[$i]['propinasefectivo']-$reg[$i]['egresos'];

$TotalOtros = $reg[$i]['cheque']+$reg[$i]['tcredito']+$reg[$i]['tdebito']+$reg[$i]['tprepago']+$reg[$i]['transferencia']+$reg[$i]['electronico']+$reg[$i]['cupon']+$reg[$i]['otros']+$reg[$i]['abonosotros']+$reg[$i]['propinasotros']+$reg[$i]['ingresosotros'];

$TotalCreditos += $reg[$i]['creditos'];
$AbonosEfectivo += $reg[$i]['abonosefectivo'];
$AbonosOtros += $reg[$i]['abonosotros'];
$IngresosEfectivo += $reg[$i]['ingresosefectivo'];
$IngresosOtros += $reg[$i]['ingresosotros'];
$TotalEgresos += $reg[$i]['egresos'];
$PropinasEfectivo += $reg[$i]['propinasefectivo'];
$PropinasOtros += $reg[$i]['propinasotros'];
$TotalCaja += $reg[$i]['dineroefectivo'];
$TotalDiferencia += $reg[$i]['diferencia'];
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['dni'].": ".$reg[$i]['nombres']; ?></td>
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaapertura'])); ?></td>
           <td><?php echo $reg[$i]['fechacierre'] == '0000-00-00 00:00:00' ? "*********" : date("d-m-Y H:i:s",strtotime($reg[$i]['fechacierre'])); ?></td>
           <td><?php echo $reg[$i]['comentarios'] == '' ? "*********" : $reg[$i]['comentarios']; ?></td>
<?php } ?>
            <td><?php echo $simbolo.number_format($reg[$i]['montoinicial'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['efectivo']+$reg[$i]['cheque']+$reg[$i]['tcredito']+$reg[$i]['tdebito']+$reg[$i]['tprepago']+$reg[$i]['transferencia']+$reg[$i]['electronico']+$reg[$i]['cupon']+$reg[$i]['otros'], 2, '.', ','); ?></td>
<?php if ($documento == "EXCEL") { ?>
            <td><?php echo $simbolo.number_format($reg[$i]['efectivo'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['cheque']+$reg[$i]['tcredito']+$reg[$i]['tdebito']+$reg[$i]['tprepago']+$reg[$i]['transferencia']+$reg[$i]['electronico']+$reg[$i]['cupon']+$reg[$i]['otros'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['creditos'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['abonosefectivo'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['abonosotros'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['ingresosefectivo'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['ingresosotros'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['egresos'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['propinasefectivo'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['propinasotros'], 2, '.', ','); ?></td>
<?php } ?>
            <td><?php echo $simbolo.number_format($reg[$i]['montoinicial']+$reg[$i]['efectivo']+$reg[$i]['ingresosefectivo']+$reg[$i]['abonosefectivo']+$reg[$i]['propinasefectivo']-$reg[$i]['egresos'], 2, '.', ','); ?></td>

            <td><?php echo $simbolo.number_format($reg[$i]['dineroefectivo'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['diferencia'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr class="text-center">
<?php if ($documento == "EXCEL") { ?>    
          <td colspan="7"></td>
<?php } else { ?>   
          <td colspan="3"></td>
<?php } ?>
<td><?php echo $simbolo.number_format($TotalVentas, 2, '.', ','); ?></td>
<?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($VentasEfectivo, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($VentasOtros, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalCreditos, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($AbonosEfectivo, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($AbonosOtros, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($IngresosEfectivo, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($IngresosOtros, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalEgresos, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($PropinasEfectivo, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($PropinasOtros, 2, '.', ','); ?></td>
<?php } ?>
<td><?php echo $simbolo.number_format($TotalEfectivo, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalCaja, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDiferencia, 2, '.', ','); ?></td>
         </tr>
<?php } ?>
</table>
<?php
break;

case 'ARQUEOSXFECHAS':

$tra = new Login();
$reg = $tra->BuscarArqueosxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE ARQUEOS EN (CAJA ".$reg[0]['nrocaja'].": ".$reg[0]['nomcaja']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"])).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>RESPONSABLE</th>
<?php if ($documento == "EXCEL") { ?>
           <th>APERTURA</th>
           <th>CIERRE</th>
           <th>OBSERVACIONES</th>
<?php } ?>
           <th>INICIAL</th>
           <th>TOTAL EN VENTAS</th>
<?php if ($documento == "EXCEL") { ?>
           <th>VENTAS EN EFECTIVO</th>
           <th>VENTAS EN OTROS</th>
           <th>VENTAS A CREDITOS</th>
           <th>ABONOS EN EFECTIVO</th>
           <th>ABONOS EN OTROS</th>
           <th>INGRESOS EN EFECTIVO</th>
           <th>INGRESOS EN OTROS</th>
           <th>EGRESOS</th>
           <th>PROPINAS EN EFECTIVO</th>
           <th>PROPINAS EN OTROS</th>
<?php } ?>
           <th>TOTAL EFECTIVO</th>
           <th>EFECTIVO EN CAJA</th>
           <th>DIFERENCIA</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {


$TotalVentas = 0;
$VentasEfectivo = 0;
$VentasOtros = 0;
$TotalCreditos = 0;
$AbonosEfectivo = 0;
$AbonosOtros = 0;
$IngresosEfectivo = 0;
$IngresosOtros = 0;
$TotalEgresos = 0;
$PropinasEfectivo = 0;
$PropinasOtros = 0;
$TotalEfectivo = 0;
$TotalCaja = 0;
$TotalDiferencia = 0;

$a=1; 
for($i=0;$i<sizeof($reg);$i++){

$TotalVentas += $reg[$i]['efectivo']+$reg[$i]['cheque']+$reg[$i]['tcredito']+$reg[$i]['tdebito']+$reg[$i]['tprepago']+$reg[$i]['transferencia']+$reg[$i]['electronico']+$reg[$i]['cupon']+$reg[$i]['otros'];

$VentasEfectivo += $reg[$i]['efectivo'];

$VentasOtros += $reg[$i]['cheque']+$reg[$i]['tcredito']+$reg[$i]['tdebito']+$reg[$i]['tprepago']+$reg[$i]['transferencia']+$reg[$i]['electronico']+$reg[$i]['cupon']+$reg[$i]['otros'];

$TotalEfectivo += $reg[$i]['montoinicial']+$reg[$i]['efectivo']+$reg[$i]['ingresosefectivo']+$reg[$i]['abonosefectivo']+$reg[$i]['propinasefectivo']-$reg[$i]['egresos'];

$TotalOtros = $reg[$i]['cheque']+$reg[$i]['tcredito']+$reg[$i]['tdebito']+$reg[$i]['tprepago']+$reg[$i]['transferencia']+$reg[$i]['electronico']+$reg[$i]['cupon']+$reg[$i]['otros']+$reg[$i]['abonosotros']+$reg[$i]['propinasotros']+$reg[$i]['ingresosotros'];


$TotalCreditos += $reg[$i]['creditos'];
$AbonosEfectivo += $reg[$i]['abonosefectivo'];
$AbonosOtros += $reg[$i]['abonosotros'];
$IngresosEfectivo += $reg[$i]['ingresosefectivo'];
$IngresosOtros += $reg[$i]['ingresosotros'];
$TotalEgresos += $reg[$i]['egresos'];
$PropinasEfectivo += $reg[$i]['propinasefectivo'];
$PropinasOtros += $reg[$i]['propinasotros'];
$TotalCaja += $reg[$i]['dineroefectivo'];
$TotalDiferencia += $reg[$i]['diferencia'];
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['dni'].": ".$reg[$i]['nombres']; ?></td>
 <?php if ($documento == "EXCEL") { ?>
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaapertura'])); ?></td>
           <td><?php echo $reg[$i]['fechacierre'] == '0000-00-00 00:00:00' ? "*********" : date("d-m-Y H:i:s",strtotime($reg[$i]['fechacierre'])); ?></td>
           <td><?php echo $reg[$i]['comentarios'] == '' ? "*********" : $reg[$i]['comentarios']; ?></td>
<?php } ?>
            <td><?php echo $simbolo.number_format($reg[$i]['montoinicial'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['efectivo']+$reg[$i]['cheque']+$reg[$i]['tcredito']+$reg[$i]['tdebito']+$reg[$i]['tprepago']+$reg[$i]['transferencia']+$reg[$i]['electronico']+$reg[$i]['cupon']+$reg[$i]['otros'], 2, '.', ','); ?></td>
<?php if ($documento == "EXCEL") { ?>
            <td><?php echo $simbolo.number_format($reg[$i]['efectivo'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['cheque']+$reg[$i]['tcredito']+$reg[$i]['tdebito']+$reg[$i]['tprepago']+$reg[$i]['transferencia']+$reg[$i]['electronico']+$reg[$i]['cupon']+$reg[$i]['otros'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['creditos'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['abonosefectivo'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['abonosotros'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['ingresosefectivo'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['ingresosotros'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['egresos'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['propinasefectivo'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['propinasotros'], 2, '.', ','); ?></td>
<?php } ?>
            <td><?php echo $simbolo.number_format($reg[$i]['montoinicial']+$reg[$i]['efectivo']+$reg[$i]['ingresosefectivo']+$reg[$i]['abonosefectivo']+$reg[$i]['propinasefectivo']-$reg[$i]['egresos'], 2, '.', ','); ?></td>

            <td><?php echo $simbolo.number_format($reg[$i]['dineroefectivo'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['diferencia'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr class="text-center">
<?php if ($documento == "EXCEL") { ?>    
          <td colspan="6"></td>
<?php } else { ?>   
          <td colspan="3"></td>
<?php } ?>
<td><?php echo $simbolo.number_format($TotalVentas, 2, '.', ','); ?></td>
<?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($VentasEfectivo, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($VentasOtros, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalCreditos, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($AbonosEfectivo, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($AbonosOtros, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($IngresosEfectivo, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($IngresosOtros, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalEgresos, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($PropinasEfectivo, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($PropinasOtros, 2, '.', ','); ?></td>
<?php } ?>
<td><?php echo $simbolo.number_format($TotalEfectivo, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalCaja, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDiferencia, 2, '.', ','); ?></td>
         </tr>
<?php } ?>
</table>
<?php
break;

case 'MOVIMIENTOS':

$tra = new Login();
$reg = $tra->ListarMovimientos(); 

$archivo = str_replace(" ", "_","LISTADO DE MOVIMIENTOS DE CAJAS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE CAJA</th>
           <th>RESPONSABLE</th>
           <th>DESCRIPCIÓN</th>
           <th>TIPO</th>
           <th>MONTO</th>
           <th>MEDIO</th>
           <th>FECHA MOVIMIENTO</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalImporte=0;
for($i=0;$i<sizeof($reg);$i++){ 
$TotalImporte+=$reg[$i]['montomovimiento'];
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></td>
           <td><?php echo $reg[$i]['dni'].": ".$reg[$i]['nombres']; ?></td>
           <td><?php echo $reg[$i]['descripcionmovimiento']; ?></td>
           <td><?php echo $reg[$i]['tipomovimiento']; ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['montomovimiento'], 2, '.', ','); ?></td>
           <td><?php echo $reg[$i]['mediomovimiento']; ?></td>
           <td><?php echo $reg[$i]['fechamovimiento']; ?></td>
         </tr>
        <?php } ?>
         <tr class="text-center">
           <td colspan="5"></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td></td>
<td></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'MOVIMIENTOSXFECHAS':

$tra = new Login();
$reg = $tra->BuscarMovimientosxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE MOVIMIENTOS EN (CAJA ".$reg[0]['nrocaja'].": ".$reg[0]['nomcaja']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"])).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>RESPONSABLE</th>
           <th>DESCRIPCIÓN</th>
           <th>TIPO</th>
           <th>MONTO</th>
           <th>MEDIO</th>
           <th>FECHA MOVIMIENTO</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalImporte=0;
for($i=0;$i<sizeof($reg);$i++){ 
$TotalImporte+=$reg[$i]['montomovimiento'];
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['dni'].": ".$reg[$i]['nombres']; ?></td>
           <td><?php echo $reg[$i]['descripcionmovimiento']; ?></td>
           <td><?php echo $reg[$i]['tipomovimiento']; ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['montomovimiento'], 2, '.', ','); ?></td>
           <td><?php echo $reg[$i]['mediomovimiento']; ?></td>
           <td><?php echo $reg[$i]['fechamovimiento']; ?></td>
         </tr>
        <?php } } ?>
         <tr class="text-center">
           <td colspan="4"></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td></td>
<td></td>
         </tr>
</table>
<?php
break;

#################################### MODULO DE CAJAS ####################################




















################################## MODULO DE VENTAS ###################################
case 'VENTAS':

$tra = new Login();
$reg = $tra->ListarVentas(); 

$archivo = str_replace(" ", "_","LISTADO DE VENTAS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE VENTA</th>
           <th>DESCRIPCIÓN DE CLIENTE</th>
           <th>TIPO DE PAGO</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>FECHA EMISIÓN</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>FORMA DE PAGO #1</th>
           <th>FORMA DE PAGO #2</th>
           <?php } ?>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
   
$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo substr($reg[$i]["tipodocumento"], 0, 1)."".$reg[$i]["codfactura"]; ?></td>
           <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
           <td><?php echo $reg[$i]['tipopago']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE" ? "VENCIDA" : $reg[$i]["statusventa"]; ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
      
      <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>

      <?php } ?>
           
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
           <?php if ($documento == "EXCEL") { ?>
          <td><?php echo $reg[$i]['formapago'] == "0" ? "**********" : $reg[$i]['formapago']; ?></td>
          <td><?php echo $reg[$i]['formapago2'] == "0" ? "**********" : $reg[$i]['formapago2']; ?></td>
           <?php } ?>
           <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr class="text-center">
           <td colspan="11"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'VENTASXCAJAS':

$tra = new Login();
$reg = $tra->BuscarVentasxCajas(); 

$archivo = str_replace(" ", "_","LISTADO DE VENTAS EN (CAJA Nº: ".$reg[0]["nrocaja"].": ".$reg[0]["nomcaja"]." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"])).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE VENTA</th>
           <th>DESCRIPCIÓN DE CLIENTE</th>
           <th>TIPO DE PAGO</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>FECHA EMISIÓN</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>FORMA DE PAGO #1</th>
           <th>FORMA DE PAGO #2</th>
           <?php } ?>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
   
$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo substr($reg[$i]["tipodocumento"], 0, 1)."".$reg[$i]["codfactura"]; ?></td>
           <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
           <td><?php echo $reg[$i]['tipopago']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE" ? "VENCIDA" : $reg[$i]["statusventa"]; ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
      
      <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>

      <?php } ?>
           
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
           <?php if ($documento == "EXCEL") { ?>
          <td><?php echo $reg[$i]['formapago'] == "0" ? "**********" : $reg[$i]['formapago']; ?></td>
          <td><?php echo $reg[$i]['formapago2'] == "0" ? "**********" : $reg[$i]['formapago2']; ?></td>
           <?php } ?>
           <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr class="text-center">
           <td colspan="11"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'VENTASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarVentasxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE VENTAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"])).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE VENTA</th>
           <th>DESCRIPCIÓN DE CLIENTE</th>
           <th>TIPO DE PAGO</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>FECHA EMISIÓN</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>FORMA DE PAGO #1</th>
           <th>FORMA DE PAGO #2</th>
           <?php } ?>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
   
$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo substr($reg[$i]["tipodocumento"], 0, 1)."".$reg[$i]["codfactura"]; ?></td>
           <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
           <td><?php echo $reg[$i]['tipopago']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE" ? "VENCIDA" : $reg[$i]["statusventa"]; ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
      
      <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>

      <?php } ?>
           
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
           <?php if ($documento == "EXCEL") { ?>
          <td><?php echo $reg[$i]['formapago'] == "0" ? "**********" : $reg[$i]['formapago']; ?></td>
          <td><?php echo $reg[$i]['formapago2'] == "0" ? "**********" : $reg[$i]['formapago2']; ?></td>
           <?php } ?>
           <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr class="text-center">
           <td colspan="11"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'VENTASXCONDICIONES':

$tra = new Login();
$reg = $tra->BuscarVentasxCondiciones();
$formapago = limpiar($_GET["formapago"]); 

$archivo = str_replace(" ", "_","LISTADO DE VENTAS POR (CONDICIÓN DE PAGO: ".$formapago." Y FECHAS DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"])).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE VENTA</th>
           <th>DESCRIPCIÓN DE CLIENTE</th>
           <th>TIPO DE PAGO</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>FECHA EMISIÓN</th>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
           <th>TOTAL PAGO</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;
$TotalPagado=0;

for($i=0;$i<sizeof($reg);$i++){ 
   
$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
$TotalPagado+=$reg[$i]['formapago'] == $formapago ? $reg[$i]['montopagado'] : $reg[$i]['montopagado2'];
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo substr($reg[$i]["tipodocumento"], 0, 1)."".$reg[$i]["codfactura"]; ?></td>
           <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
           <td><?php echo $reg[$i]['tipopago']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE" ? "VENCIDA" : $reg[$i]["statusventa"]; ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
      
      <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>

      <?php } ?>
           
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
           <?php if ($documento == "EXCEL") { ?>
          <td><?php echo $reg[$i]['formapago'] == "0" ? "**********" : $reg[$i]['formapago']; ?></td>
          <td><?php echo $reg[$i]['formapago2'] == "0" ? "**********" : $reg[$i]['formapago2']; ?></td>
           <?php } ?>
           <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  <td><?php echo $reg[$i]['formapago'] == $formapago ? $simbolo.number_format($reg[$i]['montopagado'], 2, '.', ',') : $simbolo.number_format($reg[$i]['montopagado2'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr class="text-center">
           <td colspan="11"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalPagado, 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'VENTASXTIPOS':

$tra = new Login();
$reg = $tra->BuscarVentasxTipos(); 

$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CLIENTES (".$tipo = ($_GET["tipocliente"] == 'NATURAL' ? "NATURALES" : "JURIDICOS")." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"])).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE DOCUMENTO</th>
           <th>DESCRIPCIÓN DE CLIENTE</th>
           <th>Nº DE TELÉFONO</th>
           <th>CANTIDAD COMPRAS</th>
           <th>TOTAL COMPRAS</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalGeneral=0;

for($i=0;$i<sizeof($reg);$i++){ 
   
$TotalArticulos+=$reg[$i]['cantidad'];
$TotalGeneral+=$reg[$i]['totalcompras'];
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]["dnicliente"]; ?></td>
           <td><?php echo $reg[$i]['nomcliente']; ?></td>
           <td><?php echo $reg[$i]['tlfcliente'] == '' ? "*********" : $reg[$i]['tlfcliente']; ?></td>
           <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalcompras'], 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr class="text-center">
           <td colspan="4"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalGeneral, 2, '.', ','); ?></td>
         </tr>
</table>
<?php
break;

case 'VENTASXCLIENTES':

$tra = new Login();
$reg = $tra->BuscarVentasxClientes(); 

$archivo = str_replace(" ", "_","LISTADO DE DETALLE DE VENTAS DEL CLIENTE (".$reg[0]["dnicliente"].": ".$reg[0]["nomcliente"]." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"])).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE VENTA</th>
           <th>TIPO DE PAGO</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>FECHA EMISIÓN</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>FORMA DE PAGO #1</th>
           <th>FORMA DE PAGO #2</th>
           <?php } ?>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
   
$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo substr($reg[$i]["tipodocumento"], 0, 1)."".$reg[$i]["codfactura"]; ?></td>
           <td><?php echo $reg[$i]['tipopago']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE" ? "VENCIDA" : $reg[$i]["statusventa"]; ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
      
      <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>

      <?php } ?>
           
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
           <?php if ($documento == "EXCEL") { ?>
          <td><?php echo $reg[$i]['formapago'] == "0" ? "**********" : $reg[$i]['formapago']; ?></td>
          <td><?php echo $reg[$i]['formapago2'] == "0" ? "**********" : $reg[$i]['formapago2']; ?></td>
           <?php } ?>
           <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr class="text-center">
           <td colspan="10"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
</table>
<?php
break;


case 'DELIVERYXFECHAS':

$tra = new Login();
$reg = $tra->BuscarDeliveryxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE DELIVERY POR REPARTIDOR (".$reg[0]["dni2"].": ".$reg[0]["nombres2"]." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"])).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE VENTA</th>
           <th>DESCRIPCIÓN DE CLIENTE</th>
           <th>FECHA EMISIÓN</th>
           <th>Nº DE ARTICULOS</th>
           <th>TOTAL IMPORTE</th>
           <th>TOTAL DELIVERY</th>
           <th>TOTAL COMISIÓN</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalImporte=0;
$TotalDelivery=0;
$TotalComision=0;

for($i=0;$i<sizeof($reg);$i++){ 
   
$TotalArticulos+=$reg[$i]['articulos'];
$TotalImporte+=$reg[$i]['totalpago'];
$TotalDelivery+=$reg[$i]['montodelivery'];
$TotalComision+=$reg[$i]['montodelivery']*$reg[$i]['comision2']/100;
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo substr($reg[$i]["tipodocumento"], 0, 1)."".$reg[$i]["codfactura"]; ?></td>
           <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
            <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
            <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['montodelivery'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['montodelivery']*$reg[$i]['comision2']/100, 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr class="text-center">
           <td colspan="4"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDelivery, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalComision, 2, '.', ','); ?></td>
         </tr>
</table>
<?php
break;

case 'COMISIONXVENTAS':

$tra = new Login();
$reg = $tra->BuscarComisionxVentas(); 

$archivo = str_replace(" ", "_","LISTADO DE COMISIÓN POR VENDEDOR (".$reg[0]["dni"].": ".$reg[0]["nombres"]." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"])).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE VENTA</th>
           <th>DESCRIPCIÓN DE CLIENTE</th>
           <th>TIPO DE PAGO</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>FECHA EMISIÓN</th>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
           <th>TOTAL COMISIÓN</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;
$TotalComision=0;

for($i=0;$i<sizeof($reg);$i++){ 
   
$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
$TotalComision+=$reg[$i]['totalpago']*$reg[$i]['comision']/100;
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo substr($reg[$i]["tipodocumento"], 0, 1)."".$reg[$i]["codfactura"]; ?></td>
           <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
           <td><?php echo $reg[$i]['tipopago']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE" ? "VENCIDA" : $reg[$i]["statusventa"]; ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
      
      <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>

      <?php } ?>
           
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
           <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totalpago']*$reg[$i]['comision']/100, 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr class="text-center">
           <td colspan="9"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalComision, 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
</table>
<?php
break;
################################# MODULO DE VENTAS ################################






















################################## MODULO DE CREDITOS #################################
case 'CREDITOS':

$tra = new Login();
$reg = $tra->ListarCreditos(); 

$archivo = str_replace(" ", "_","LISTADO DE CREDITOS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE VENTA</th>
           <th>DESCRIPCIÓN DE CLIENTE</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>FECHA EMISIÓN</th>
           <th>IMPORTE TOTAL</th>
           <th>TOTAL ABONO</th>
           <th>TOTAL DEBE</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalImporte+=$reg[$i]['totalpago'];
$TotalAbono+=$reg[$i]['creditopagado'];
$TotalDebe+=$reg[$i]['totalpago']-$reg[$i]['creditopagado'];
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo substr($reg[$i]["tipodocumento"], 0, 1)."".$reg[$i]["codfactura"]; ?></td>
           <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE" ? "VENCIDA" : $reg[$i]["statusventa"]; ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
      
      <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>

      <?php } ?>
           
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr class="text-center">
           <td colspan="8"></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'CREDITOSXCLIENTES':

$tra = new Login();
$reg = $tra->BuscarCreditosxClientes(); 

$archivo = str_replace(" ", "_","LISTADO DE CREDITOS DEL (CLIENTE: ".$reg[0]["dnicliente"].": ".$reg[0]["nomcliente"].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE VENTA</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>FECHA EMISIÓN</th>
           <th>IMPORTE TOTAL</th>
           <th>TOTAL ABONO</th>
           <th>TOTAL DEBE</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalImporte+=$reg[$i]['totalpago'];
$TotalAbono+=$reg[$i]['creditopagado'];
$TotalDebe+=$reg[$i]['totalpago']-$reg[$i]['creditopagado'];
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo substr($reg[$i]["tipodocumento"], 0, 1)."".$reg[$i]["codfactura"]; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE" ? "VENCIDA" : $reg[$i]["statusventa"]; ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
      
      <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>

      <?php } ?>
           
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr class="text-center">
           <td colspan="7"></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'CREDITOSXFECHAS':

$tra = new Login();
$reg = $tra->BuscarCreditosxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE CREDITOS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"])).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE VENTA</th>
           <th>DESCRIPCIÓN DE CLIENTE</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>FECHA EMISIÓN</th>
           <th>IMPORTE TOTAL</th>
           <th>TOTAL ABONO</th>
           <th>TOTAL DEBE</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalImporte+=$reg[$i]['totalpago'];
$TotalAbono+=$reg[$i]['creditopagado'];
$TotalDebe+=$reg[$i]['totalpago']-$reg[$i]['creditopagado'];
?>
         <tr class="text-center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo substr($reg[$i]["tipodocumento"], 0, 1)."".$reg[$i]["codfactura"]; ?></td>
           <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE" ? "VENCIDA" : $reg[$i]["statusventa"]; ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
      
      <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>

      <?php } ?>
           
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr class="text-center">
           <td colspan="8"></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
</table>
<?php
break;
################################# MODULO DE CREDITOS ###################################
















################################# MODULO DE NOTAS DE CREDITOS ###################################
case 'NOTAS':

$tra = new Login();
$reg = $tra->ListarNotasCreditos(); 

$archivo = str_replace(" ", "_","LISTADO DE NOTAS DE CREDITOS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE CAJA</th>
           <th>Nº DE NOTA</th>
           <th>Nº DE DOCUMENTO</th>
           <th>DESCRIPCIÓN DE CLIENTE</th>
           <th>FECHA DE EMISIÓN</th>
           <th>MOTIVO DE NOTA</th>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $caja = ($reg[$i]['codcaja'] == '0' ? "**********" : $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']); ?></td>
           <td><?php echo $reg[$i]['codfactura']; ?></td>
           <td><?php echo $reg[$i]['tipodocumento']." Nº: ".$reg[$i]['facturaventa']; ?></td>
           <td><?php echo $reg[$i]['codcliente'] == '' || $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechanota'])); ?></td>
           <td><?php echo $reg[$i]['observaciones']; ?></td>
           <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr>
           <?php echo $documento == "EXCEL" ? '<td colspan="7"></td>' : '<td colspan="7"></td>'; ?>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'NOTASXCAJAS':

$tra = new Login();
$reg = $tra->BuscarNotasxCajas(); 

$archivo = str_replace(" ", "_","LISTADO DE NOTAS DE CREDITOS EN (CAJA Nº: ".$reg[0]["nrocaja"].": ".$reg[0]["nomcaja"]." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"])).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE NOTA</th>
           <th>Nº DE DOCUMENTO</th>
           <th>DESCRIPCIÓN DE CLIENTE</th>
           <th>FECHA DE EMISIÓN</th>
           <th>MOTIVO DE NOTA</th>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codfactura']; ?></td>
           <td><?php echo $reg[$i]['tipodocumento']." Nº: ".$reg[$i]['facturaventa']; ?></td>
           <td><?php echo $reg[$i]['codcliente'] == '' || $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechanota'])); ?></td>
           <td><?php echo $reg[$i]['observaciones']; ?></td>
           <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr>
           <?php echo $documento == "EXCEL" ? '<td colspan="6"></td>' : '<td colspan="6"></td>'; ?>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'NOTASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarNotasxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE NOTAS DE CREDITOS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"])).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE CAJA</th>
           <th>Nº DE NOTA</th>
           <th>Nº DE DOCUMENTO</th>
           <th>DESCRIPCIÓN DE CLIENTE</th>
           <th>FECHA DE EMISIÓN</th>
           <th>MOTIVO DE NOTA</th>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $caja = ($reg[$i]['codcaja'] == '0' ? "**********" : $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']); ?></td>
           <td><?php echo $reg[$i]['codfactura']; ?></td>
           <td><?php echo $reg[$i]['tipodocumento']." Nº: ".$reg[$i]['facturaventa']; ?></td>
           <td><?php echo $reg[$i]['codcliente'] == '' || $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechanota'])); ?></td>
           <td><?php echo $reg[$i]['observaciones']; ?></td>
           <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr>
           <?php echo $documento == "EXCEL" ? '<td colspan="7"></td>' : '<td colspan="7"></td>'; ?>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'NOTASXCLIENTE':

$tra = new Login();
$reg = $tra->BuscarNotasxClientes(); 

$archivo = str_replace(" ", "_","LISTADO DE NOTAS DE CREDITOS DEL (CLIENTE: ".$reg[0]["dnicliente"].": ".$reg[0]["nomcliente"].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE CAJA</th>
           <th>Nº DE NOTA</th>
           <th>Nº DE DOCUMENTO</th>
           <th>FECHA DE EMISIÓN</th>
           <th>MOTIVO DE NOTA</th>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>SUBTOTAL</th>
           <th><?php echo $impuesto; ?></th>
           <th>DCTO %</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $caja = ($reg[$i]['codcaja'] == '0' ? "**********" : $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']); ?></td>
           <td><?php echo $reg[$i]['codfactura']; ?></td>
           <td><?php echo $reg[$i]['tipodocumento']." Nº: ".$reg[$i]['facturaventa']; ?></td>
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechanota'])); ?></td>
           <td><?php echo $reg[$i]['observaciones']; ?></td>
           <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr>
           <?php echo $documento == "EXCEL" ? '<td colspan="6"></td>' : '<td colspan="6"></td>'; ?>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

################################# MODULO DE NOTAS DE CREDITOS ###################################

}
 
?>


<?php } else { ?> 
    <script type='text/javascript' language='javascript'>
      alert('NO TIENES PERMISO PARA ACCEDER A ESTA PAGINA.\nCONSULTA CON EL ADMINISTRADOR PARA QUE TE DE ACCESO')  
    document.location.href='panel'   
        </script> 
<?php } } else { ?>
    <script type='text/javascript' language='javascript'>
      alert('NO TIENES PERMISO PARA ACCEDER AL SISTEMA.\nDEBERA DE INICIAR SESION')  
    document.location.href='logout'  
        </script> 
<?php } ?>  