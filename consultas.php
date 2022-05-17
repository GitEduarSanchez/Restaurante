<?php
require_once("class/class.php");
if (isset($_SESSION['acceso'])) {
  if ($_SESSION['acceso'] == "administrador" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero" || $_SESSION["acceso"]=="mesero" || $_SESSION["acceso"]=="cocinero" || $_SESSION["acceso"]=="repartidor") {

$imp = new Login();
$imp = $imp->ImpuestosPorId();
$impuesto = ($imp == "" ? "Impuesto" : $imp[0]['nomimpuesto']);
$valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

$con = new Login();
$con = $con->ConfiguracionPorId();
$simbolo = ($con == "" ? "" : "<strong>".$con[0]['simbolo']."</strong>");
    
$tra = new Login();
?>


<?php
############################# CARGAR USUARIOS ############################
if (isset($_GET['CargaUsuarios'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>N° de Documento</th>
                                                    <th>Nombres y Apellidos</th>
                                                    <th>Nº de Teléfono</th>
                                                    <th>Usuario</th>
                                                    <th>Nivel</th>
                                                    <th>Status</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarUsuarios();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON USUARIOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['dni']; ?></td>
                                               <td><?php echo $reg[$i]['nombres']; ?></td>
                                               <td><?php echo $reg[$i]['telefono']; ?></td>
                                               <td><?php echo $reg[$i]['usuario']; ?></td>
                                               <td><?php echo $reg[$i]['nivel']; ?></td>
<td><?php echo $status = ( $reg[$i]['status'] == 1 ? "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='badge badge-pill badge-dark'><i class='fa fa-times'></i> INACTIVO</span>"); ?></td>
                                               <td>

<button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerUsuario('<?php echo encrypt($reg[$i]["codigo"]); ?>')"><i class="fa fa-eye"></i></button>

<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalUser" data-backdrop="static" data-keyboard="false" onClick="UpdateUsuario('<?php echo $reg[$i]["codigo"]; ?>','<?php echo $reg[$i]["dni"]; ?>','<?php echo $reg[$i]["nombres"]; ?>','<?php echo $reg[$i]["sexo"]; ?>','<?php echo $reg[$i]["direccion"]; ?>','<?php echo $reg[$i]["telefono"]; ?>','<?php echo $reg[$i]["email"]; ?>','<?php echo $reg[$i]["usuario"]; ?>','<?php echo $reg[$i]["nivel"]; ?>','<?php echo $reg[$i]["status"]; ?>','<?php echo number_format($reg[$i]['comision'], 0, '.', ''); ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarUsuario('<?php echo encrypt($reg[$i]["codigo"]); ?>','<?php echo encrypt($reg[$i]["dni"]); ?>','<?php echo encrypt("USUARIOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR USUARIOS ############################
?>




<?php
############################# CARGAR PROVINCIAS ############################
if (isset($_GET['CargaProvincias'])) { 
?>

<div class="table-responsive"><table id="datatable" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Provincias</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarProvincias();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PROVINCIAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['provincia']; ?></td>
                                               <td>

<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateProvincia('<?php echo ($reg[$i]['id_provincia'] == '0' ? "" : $reg[$i]['id_provincia']); ?>','<?php echo $reg[$i]["provincia"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarProvincia('<?php echo encrypt($reg[$i]["id_provincia"]); ?>','<?php echo encrypt("PROVINCIAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR PROVINCIAS ############################
?>


<?php
############################# CARGAR DEPARTAMENTOS ############################
if (isset($_GET['CargaDepartamentos'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Provincia</th>
                                                    <th>Departamento</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarDepartamentos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON DEPARTAMENTOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['provincia']; ?></td>
                                               <td><?php echo $reg[$i]['departamento']; ?></td>
                                               <td>

<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateDepartamento('<?php echo $reg[$i]["id_departamento"]; ?>','<?php echo $reg[$i]["departamento"]; ?>','<?php echo ($reg[$i]['id_provincia'] == '0' ? "" : $reg[$i]['id_provincia']); ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarDepartamento('<?php echo encrypt($reg[$i]["id_departamento"]); ?>','<?php echo encrypt("DEPARTAMENTOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR DEPARTAMENTOS ############################
?>


<?php
############################# CARGAR TIPOS DE DOCUMENTOS ############################
if (isset($_GET['CargaDocumentos'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nombre</th>
                                                    <th>Descripción de Documento</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarDocumentos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON TIPOS DE DOCUMENTOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['documento']; ?></td>
                                               <td><?php echo $reg[$i]['descripcion']; ?></td>
                                               <td>

<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateDocumento('<?php echo $reg[$i]["coddocumento"]; ?>','<?php echo $reg[$i]["documento"]; ?>','<?php echo $reg[$i]["descripcion"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarDocumento('<?php echo encrypt($reg[$i]["coddocumento"]); ?>','<?php echo encrypt("DOCUMENTOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR TIPOS DE DOCUMENTOS ############################
?>


<?php
############################# CARGAR TIPOS DE MONEDA ############################
if (isset($_GET['CargaMonedas'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nombre de Moneda</th>
                                                    <th>Siglas</th>
                                                    <th>Simbolo</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarTipoMoneda();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON TIPOS DE MONEDAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['moneda']; ?></td>
                                               <td><?php echo $reg[$i]['siglas']; ?></td>
                                               <td><?php echo $reg[$i]['simbolo']; ?></td>
                                               <td>

<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateTipoMoneda('<?php echo $reg[$i]["codmoneda"]; ?>','<?php echo $reg[$i]["moneda"]; ?>','<?php echo $reg[$i]["siglas"]; ?>','<?php echo $reg[$i]["simbolo"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarTipoMoneda('<?php echo encrypt($reg[$i]["codmoneda"]); ?>','<?php echo encrypt("TIPOMONEDA") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR TIPOS DE MONEDA ############################
?>


<?php
############################# CARGAR TIPOS DE CAMBIO ############################
if (isset($_GET['CargaCambios'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Descripción de Cambio</th>
                                                    <th>Monto de Cambio</th>
                                                    <th>Tipo Moneda</th>
                                                    <th>Fecha Ingreso</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarTipoCambio();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON TIPOS DE CAMBIO DE MONEDA ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['descripcioncambio']; ?></td>
                                               <td><?php echo $reg[$i]['montocambio']; ?></td>
  <td><abbr title="<?php echo "Siglas: ".$reg[$i]['siglas']; ?>"><?php echo $reg[$i]['moneda']; ?></abbr></td>
                    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechacambio'])); ?></td>
                    <td>
<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateTipoCambio('<?php echo $reg[$i]["codcambio"]; ?>','<?php echo $reg[$i]["descripcioncambio"]; ?>','<?php echo $reg[$i]["montocambio"]; ?>','<?php echo $reg[$i]["codmoneda"]; ?>','<?php echo date("Y-m-d",strtotime($reg[$i]['fechacambio'])); ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarTipoCambio('<?php echo encrypt($reg[$i]["codcambio"]); ?>','<?php echo encrypt("TIPOCAMBIO") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR TIPOS DE CAMBIO ############################
?>



<?php
############################# CARGAR IMPUESTOS ############################
if (isset($_GET['CargaImpuestos'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nombre de Impuesto</th>
                                                    <th>Valor (%)</th>
                                                    <th>Status</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarImpuestos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON IMPUESTOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['nomimpuesto']; ?></td>
                                               <td><?php echo $reg[$i]['valorimpuesto']; ?></td>
<td><?php echo $status = ( $reg[$i]['statusimpuesto'] == 'ACTIVO' ? "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[$i]['statusimpuesto']."</span>" : "<span class='badge badge-pill badge-dark'><i class='fa fa-times'></i> ".$reg[$i]['statusimpuesto']."</span>"); ?></td>
                                               <td>

<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateImpuesto('<?php echo $reg[$i]["codimpuesto"]; ?>','<?php echo $reg[$i]["nomimpuesto"]; ?>','<?php echo $reg[$i]["valorimpuesto"]; ?>','<?php echo $reg[$i]["statusimpuesto"]; ?>','<?php echo date("d-m-Y",strtotime($reg[$i]['fechaimpuesto'])); ?>','update')"><i class="fa fa-edit"></i></button> 
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarImpuesto('<?php echo encrypt($reg[$i]["codimpuesto"]); ?>','<?php echo encrypt("IMPUESTOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>

       
 <?php 
   } 
############################# CARGAR IMPUESTOS ############################
?>


<?php
############################# CARGAR SALAS ############################
if (isset($_GET['CargaSalas'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nombre de Sala</th>
                                                    <th>Creada</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarSalas();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON SALAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['nomsala']; ?></td>
                                               <td><?php echo date("d-m-Y",strtotime($reg[$i]['fecha'])); ?></td>
                                               <td>
<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateSala('<?php echo $reg[$i]["codsala"]; ?>','<?php echo $reg[$i]["nomsala"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarSala('<?php echo encrypt($reg[$i]["codsala"]); ?>','<?php echo encrypt("SALAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR SALAS ############################
?>


<?php
############################# CARGAR MESAS ############################
if (isset($_GET['CargaMesas'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nombre de Sala</th>
                                                    <th>Nombre de Mesa</th>
                                                    <th>Status</th>
                                                    <th>Creada</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarMesas();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON MESAS EN SALAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['nomsala']; ?></td>
                                               <td><abbr title="<?php echo $reg[$i]['puestos']." PERSONAS"; ?>"><?php echo $reg[$i]['nommesa']; ?></abbr></td>
                                               <td><?php echo $status = ( $reg[$i]['statusmesa'] == 0 ? "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> DISPONIBLE</span>" : "<span class='badge badge-pill badge-dark'><i class='fa fa-times'></i> RESERVADA</span>"); ?></td>
                                               <td><?php echo date("d-m-Y",strtotime($reg[$i]['fecha'])); ?></td>
                                               <td>
<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateMesa('<?php echo $reg[$i]["codmesa"]; ?>','<?php echo $reg[$i]["codsala"]; ?>','<?php echo $reg[$i]["nommesa"]; ?>','<?php echo $reg[$i]["puestos"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarMesa('<?php echo encrypt($reg[$i]["codmesa"]); ?>','<?php echo encrypt("MESAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR MESAS ############################
?>


<?php
############################# CARGAR CATEGORIAS ############################
if (isset($_GET['CargaCategorias'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nombre de Categoria</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarCategorias();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON CATEGORIAS DE PRODUCTOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $reg[$i]['codcategoria']; ?></td>
                                               <td><?php echo $reg[$i]['nomcategoria']; ?></td>
                                               <td>
<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateCategoria('<?php echo $reg[$i]["codcategoria"]; ?>','<?php echo $reg[$i]["nomcategoria"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarCategoria('<?php echo encrypt($reg[$i]["codcategoria"]); ?>','<?php echo encrypt("CATEGORIAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR CATEGORIAS ############################
?>



<?php
############################# CARGAR MEDIDAS ############################
if (isset($_GET['CargaMedidas'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nombre de Medida</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarMedidas();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON MEDIDAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $reg[$i]['codmedida']; ?></td>
                                               <td><?php echo $reg[$i]['nommedida']; ?></td>
                                               <td>
<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateMedida('<?php echo $reg[$i]["codmedida"]; ?>','<?php echo $reg[$i]["nommedida"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarMedida('<?php echo encrypt($reg[$i]["codmedida"]); ?>','<?php echo encrypt("MEDIDAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR UNIDADES ############################
?>






<?php
############################# CARGAR PROVEEDORES ############################
if (isset($_GET['CargaProveedores'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nombres de Proveedor</th>
                                                    <th>Correo Electrónico</th>
                                                    <th>Nº de Teléfono</th>
                                                    <th>Vendedor</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarProveedores();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PROVEEDORES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
<td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento'])." ".$reg[$i]['cuitproveedor']; ?>"><?php echo $reg[$i]['nomproveedor']; ?></abbr></td>
           <td><?php echo $reg[$i]['emailproveedor'] == '' ? "*********" : $reg[$i]['emailproveedor']; ?></td>
           <td><?php echo $reg[$i]['tlfproveedor'] == '' ? "*********" : $reg[$i]['tlfproveedor']; ?></td>
           <td><?php echo $reg[$i]['vendedor'] == '' ? "*********" : $reg[$i]['vendedor']; ?></td>
                                               <td>
<button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerProveedor('<?php echo encrypt($reg[$i]["codproveedor"]); ?>')"><i class="fa fa-eye"></i></button>

<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalProveedor" data-backdrop="static" data-keyboard="false" onClick="UpdateProveedor('<?php echo $reg[$i]["codproveedor"]; ?>','<?php echo $reg[$i]["documproveedor"]; ?>','<?php echo $reg[$i]["cuitproveedor"]; ?>','<?php echo $reg[$i]["nomproveedor"]; ?>','<?php echo $reg[$i]["tlfproveedor"]; ?>','<?php echo ($reg[$i]['id_provincia'] == '0' ? "" : $reg[$i]['id_provincia']); ?>','<?php echo $reg[$i]["direcproveedor"]; ?>','<?php echo $reg[$i]["emailproveedor"]; ?>','<?php echo $reg[$i]["vendedor"]; ?>','<?php echo $reg[$i]["tlfvendedor"]; ?>','update'); SelectDepartamento('<?php echo ($reg[$i]['id_provincia'] == '0' ? "" : $reg[$i]['id_provincia']); ?>','<?php echo $reg[$i]["id_departamento"]; ?>')"><i class="fa fa-edit"></i></button>

<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarProveedor('<?php echo encrypt($reg[$i]["codproveedor"]); ?>','<?php echo encrypt("PROVEEDORES") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR PROVEEDORES ############################
?>






<?php
############################# CARGAR INGREDIENTES ############################
if (isset($_GET['CargaIngredientes'])) { 

$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nombre de Ingrediente</th>
                                                    <th>Unidad Medida</th>
                                                    <th>Precio Compra</th>
                                                    <th>P.V.P</th>
                               <th><?php echo $cambio == '' ? "*****" : "P.V. ".$cambio[0]['siglas']; ?></th>
                                                    <th>Stock</th>
                                                    <th><?php echo $impuesto; ?> </th>
                                                    <th>Desc %</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarIngredientes();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON INGREDIENTES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
  <td><abbr title="CÓDIGO: <?php echo $reg[$i]['codingrediente']; ?>"><?php echo $reg[$i]['nomingrediente']; ?></abbr></td>
                                               <td><?php echo $reg[$i]['nommedida']; ?></td>
                                            <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
                                              <td><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
<td><?php echo $cambio == '' ? "*****" : "<strong>".$cambio[0]['simbolo']."</strong> ".number_format($reg[$i]['precioventa']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
                                               <td><?php echo number_format($reg[$i]['cantingrediente'], 2, '.', ','); ?></td>
                                               <td><?php echo $reg[$i]['ivaingrediente'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
                                               <td><?php echo number_format($reg[$i]['descingrediente'], 2, '.', ','); ?></td>
                                               <td>
<button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerIngrediente('<?php echo encrypt($reg[$i]["codingrediente"]); ?>')"><i class="fa fa-eye"></i></button>

<button type="button" class="btn btn-info btn-rounded" onClick="UpdateIngrediente('<?php echo encrypt($reg[$i]["codingrediente"]); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarIngrediente('<?php echo encrypt($reg[$i]["codingrediente"]); ?>','<?php echo encrypt("INGREDIENTES") ?>')" title="Eliminar"><i class="fa fa-trash-o"></i></button>

 </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR INGREDIENTES ############################
?>





<?php
############################# CARGAR KARDEX VALORIZADO DE INGREDIENTES ############################
if (isset($_GET['CargaKardexValorizadoIngredientes'])) { 

$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nombre de Ingrediente</th>
                                                    <th>Unidad Medida</th>
                                                    <th>Precio Compra</th>
                                                    <th>P.V.P</th>
                                                    <th>Stock</th>
                                                    <th><?php echo $impuesto; ?> </th>
                                                    <th>Desc %</th>
                                                    <th>Total Venta</th>
                                                    <th>Total Compra</th>
                                                    <th>Ganancias</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarIngredientes();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON INGREDIENTES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
$TotalGanancia=0;

for($i=0;$i<sizeof($reg);$i++){

$sumventa = $reg[$i]['precioventa']*$reg[$i]['cantingrediente']-$reg[$i]['descingrediente']/100; 
$sumcompra = $reg[$i]['preciocompra']*$reg[$i]['cantingrediente'];

$TotalGanancia+=$sumventa-$sumcompra;  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
  <td><abbr title="CÓDIGO: <?php echo $reg[$i]['codingrediente']; ?>"><?php echo $reg[$i]['nomingrediente']; ?></abbr></td>
                                               <td><?php echo $reg[$i]['nommedida']; ?></td>
                                            <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
                                              <td><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
                                               <td><?php echo number_format($reg[$i]['cantingrediente'], 2, '.', ','); ?></td>
                                               <td><?php echo $reg[$i]['ivaingrediente'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
                                               <td><?php echo number_format($reg[$i]['descingrediente'], 2, '.', ','); ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['precioventa']*$reg[$i]['cantingrediente']-$reg[$i]['descingrediente']/100, 2, '.', ','); ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['cantingrediente'], 2, '.', ','); ?></td>
                    <td><?php echo $simbolo.number_format($sumventa-$sumcompra, 2, '.', ','); ?></td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR KARDEX VALORIZADO DE INGREDIENTES ############################
?>



<?php
############################# CARGAR PRODUCTOS ############################
if (isset($_GET['CargaProductos'])) { 

$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Img</th>
                                                    <th>Nombre de Producto</th>
                                                    <th>Categoria</th>
                                                    <th>Precio Compra</th>
                                                    <th>P.V.P</th>
                                                    <th>Stock</th>
                                                    <th><?php echo $impuesto; ?> </th>
                                                    <th>Desc %</th>
<?php echo $perfil = ($_SESSION['acceso'] == "administrador" || $_SESSION["acceso"]=="secretaria" ? "<th>Acciones</th>" : "<th><i class='mdi mdi-drag-horizontal'></i></th>"); ?>                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarProductos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PRODUCTOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
<td><?php if (file_exists("fotos/productos/".$reg[$i]["codproducto"].".jpg")){
    echo "<img src='fotos/productos/".$reg[$i]["codproducto"].".jpg?' class='rounded-circle' style='margin:0px;' width='50' height='40'>";
       }else{
    echo "<img src='fotos/img.png' class='rounded-circle' style='margin:0px;' width='50' height='40'>";  
    } ?>
  </a></td>
  <td><abbr title="CÓDIGO: <?php echo $reg[$i]['codproducto']; ?>"><?php echo $reg[$i]['producto']; ?></abbr></td>
                                            <td><?php echo $reg[$i]['nomcategoria']; ?></td>
                                            <td><?php echo $preciocompra = ($_SESSION['acceso'] == "cajero" || $_SESSION["acceso"]=="cocinero" ? "**********" : $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',')); ?></td>
<td><abbr title="<?php echo $cambio == '' ? "*****" : "P.V.P ".$cambio[0]['siglas']." ".number_format($reg[$i]['precioventa']/$cambio[0]['montocambio'], 2, '.', ','); ?>"><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></abbr></td>
                                               <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
                                               <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
                                               <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
                                               <td>
<button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerProducto('<?php echo encrypt($reg[$i]["codproducto"]); ?>')"><i class="fa fa-eye"></i></button>

<?php if ($_SESSION['acceso'] == "cocinero") {?>
<button type="button" class="btn btn-danger btn-rounded" data-placement="left" title="Sumar stock" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalStock" data-backdrop="static" data-keyboard="false" onClick="SumarProducto('<?php echo $reg[$i]["idproducto"]; ?>','<?php echo $reg[$i]["codproducto"]; ?>','<?php echo $reg[$i]["producto"]; ?>')"><i class="fa fa-refresh"></i></button>
<?php } ?>

<?php if ($_SESSION['acceso'] == "administrador" || $_SESSION["acceso"]=="secretaria") { ?>
<button type="button" class="btn btn-info btn-rounded" onClick="UpdateProducto('<?php echo encrypt($reg[$i]["codproducto"]); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

<button type="button" class="btn btn-danger btn-rounded" onClick="AgregaIngrediente('<?php echo encrypt($reg[$i]["codproducto"]); ?>')" title="Agregar" ><i class="fa fa-cart-arrow-down"></i></button>

<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarProducto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt("PRODUCTOS") ?>')" title="Eliminar"><i class="fa fa-trash-o"></i></button>
<?php } ?>

 </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR PRODUCTOS ############################
?>


<?php
############################# CARGAR KARDEX VALORIZADO DE PRODUCTOS ############################
if (isset($_GET['CargaKardexValorizadoProductos'])) { 

$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nombre de Producto</th>
                                                    <th>Categoria</th>
                                                    <th>Precio Compra</th>
                                                    <th>P.V.P</th>
                                                    <th>Stock</th>
                                                    <th><?php echo $impuesto; ?> </th>
                                                    <th>Desc %</th>
                                                    <th>Total Venta</th>
                                                    <th>Total Compra</th>
                                                    <th>Ganancias</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarProductos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PRODUCTOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
$TotalGanancia=0;

for($i=0;$i<sizeof($reg);$i++){

$sumventa = $reg[$i]['precioventa']*$reg[$i]['existencia']-$reg[$i]['descproducto']/100; 
$sumcompra = $reg[$i]['preciocompra']*$reg[$i]['existencia'];

$TotalGanancia+=$sumventa-$sumcompra;  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
  <td><abbr title="CÓDIGO: <?php echo $reg[$i]['codproducto']; ?>"><?php echo $reg[$i]['producto']; ?></abbr></td>
                                            <td><?php echo $reg[$i]['nomcategoria']; ?></td>
                                            <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
<td><abbr title="<?php echo $cambio == '' ? "*****" : "P.V.P ".$cambio[0]['siglas']." ".number_format($reg[$i]['precioventa']/$cambio[0]['montocambio'], 2, '.', ','); ?>"><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></abbr></td>
                                               <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
                                               <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
                                               <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['precioventa']*$reg[$i]['existencia']-$reg[$i]['descproducto']/100, 2, '.', ','); ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['existencia'], 2, '.', ','); ?></td>
                    <td><?php echo $simbolo.number_format($sumventa-$sumcompra, 2, '.', ','); ?></td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR KARDEX VALORIZADO DE PRODUCTOS ############################
?>



<?php
############################# CARGAR COMBOS ############################
if (isset($_GET['CargaCombos'])) { 

$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                         <thead>
                                         <tr role="row">
                                            <th>N°</th>
                                            <th>Img</th>
                                            <th>Nombre de Combo</th>
                                            <th>Precio Compra</th>
                                            <th>Precio Venta</th>
                        <th><?php echo $cambio == '' ? "*****" : "P.V. ".$cambio[0]['siglas']; ?></th>
                                            <th>Stock</th>
                                            <th><?php echo $impuesto; ?> </th>
                                            <th>Descto</th>
                                            <th>Detalles de Productos</th>
<?php echo $perfil = ($_SESSION['acceso'] == "administrador" || $_SESSION["acceso"]=="secretaria" ? "<th>Acciones</th>" : "<th><i class='mdi mdi-drag-horizontal'></i></th>"); ?> 
                                         </tr>
                                         </thead>
                                         <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarCombos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COMBOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                            <tr role="row" class="odd">
                            <td><?php echo $a++; ?></td>
<td><?php if (file_exists("fotos/combos/".$reg[$i]["codcombo"].".jpg")){
    echo "<img src='fotos/combos/".$reg[$i]["codcombo"].".jpg?' class='rounded-circle' style='margin:0px;' width='50' height='40'>";
       }else{
    echo "<img src='fotos/img.png' class='rounded-circle' style='margin:0px;' width='50' height='40'>";  
    } ?>
  </a></td>
  <td><abbr title="CÓDIGO: <?php echo $reg[$i]['codcombo']; ?>"><?php echo $reg[$i]['nomcombo']; ?></abbr></td>

                            <td><?php echo $preciocompra = ($_SESSION['acceso'] == "cajero" || $_SESSION["acceso"]=="cocinero" ? "**********" : $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',')); ?></td>
                            <td><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
<td><?php echo $cambio == '' ? "*****" : "<strong>".$cambio[0]['simbolo']."</strong> ".number_format($reg[$i]['precioventa']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
                            <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
                            <td><?php echo $reg[$i]['ivacombo'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
                            <td><?php echo number_format($reg[$i]['desccombo'], 2, '.', ','); ?></td>
                            <td class="font-10 bold"><?php echo $reg[$i]['detalles_productos']; ?></td>
                                               <td>
<button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="VerCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>')"><i class="fa fa-eye"></i></button>

<?php if ($_SESSION['acceso'] == "cocinero") {?>
<button type="button" class="btn btn-danger btn-rounded" data-placement="left" title="Sumar Stock" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalStock" data-backdrop="static" data-keyboard="false" onClick="SumarCombo('<?php echo $reg[$i]["idcombo"]; ?>','<?php echo $reg[$i]["codcombo"]; ?>','<?php echo $reg[$i]["nomcombo"]; ?>')"><i class="fa fa-refresh"></i></button>
<?php } ?>

<?php if ($_SESSION['acceso'] == "administrador" || $_SESSION["acceso"]=="secretaria") {?>
<button type="button" class="btn btn-info btn-rounded" onClick="UpdateCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

<button type="button" class="btn btn-danger btn-rounded" onClick="AgregaProducto('<?php echo encrypt($reg[$i]["codcombo"]); ?>')" title="Agregar" ><i class="fa fa-cart-arrow-down"></i></button>

<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt("COMBOS") ?>')" title="Eliminar"><i class="fa fa-trash-o"></i></button>
<?php } ?>
 </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR COMBOS ############################
?>



<?php
############################# CARGAR KARDEX VALORIZADO DE COMBOS ############################
if (isset($_GET['CargaKardexValorizadoCombos'])) { 

$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nombre de Combo</th>
                                                    <th>Precio Compra</th>
                                                    <th>P.V.P</th>
                                                    <th>Stock</th>
                                                    <th><?php echo $impuesto; ?> </th>
                                                    <th>Desc %</th>
                                                    <th>Total Venta</th>
                                                    <th>Total Compra</th>
                                                    <th>Ganancias</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarCombos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COMBOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
$TotalGanancia=0;

for($i=0;$i<sizeof($reg);$i++){

$sumventa = $reg[$i]['precioventa']*$reg[$i]['existencia']-$reg[$i]['desccombo']/100; 
$sumcompra = $reg[$i]['preciocompra']*$reg[$i]['existencia'];

$TotalGanancia+=$sumventa-$sumcompra;  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
  <td><abbr title="CÓDIGO: <?php echo $reg[$i]['codcombo']; ?>"><?php echo $reg[$i]['nomcombo']; ?></abbr></td>
                                            <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
<td><abbr title="<?php echo $cambio == '' ? "*****" : "P.V.P ".$cambio[0]['siglas']." ".number_format($reg[$i]['precioventa']/$cambio[0]['montocambio'], 2, '.', ','); ?>"><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></abbr></td>
                                               <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
                                               <td><?php echo $reg[$i]['ivacombo'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
                                               <td><?php echo number_format($reg[$i]['desccombo'], 2, '.', ','); ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['precioventa']*$reg[$i]['existencia']-$reg[$i]['desccombo']/100, 2, '.', ','); ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['existencia'], 2, '.', ','); ?></td>
                    <td><?php echo $simbolo.number_format($sumventa-$sumcompra, 2, '.', ','); ?></td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR KARDEX VALORIZADO DE COMBOS ############################
?>



<?php
############################# CARGAR CAJAS PARA VENTAS ############################
if (isset($_GET['CargaCajas'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nombre de Caja</th>
                                                    <th>Nº Documento</th>
                                                    <th>Responsable</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarCajas();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON CAJAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></td>
                                               <td><?php echo $reg[$i]['dni']; ?></td>
                                               <td><?php echo $reg[$i]['nombres']; ?></td>
                                               <td>
<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCajas" data-backdrop="static" data-keyboard="false" onClick="UpdateCaja('<?php echo $reg[$i]["codcaja"]; ?>','<?php echo $reg[$i]["nrocaja"]; ?>','<?php echo $reg[$i]["nomcaja"]; ?>','<?php echo $reg[$i]["codigo"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarCaja('<?php echo encrypt($reg[$i]["codcaja"]); ?>','<?php echo encrypt("CAJAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>

       
 <?php 
   } 
############################# CARGAR CAJAS PARA VENTAS ############################
?>


<?php
########################### CARGAR ARQUEOS DE CAJAS PARA VENTAS ##########################
if (isset($_GET['CargaArqueos'])) { 

?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                <thead>
                                                <tr role="row">
                                                <th>N°</th>
                                                <th>Caja</th>
                                                <th>Responsable</th>
                                                <th>Hora de Apertura</th>
                                                <th>Hora de Cierre</th>
                                                <th>Monto Inicial</th>
                                                <th>Efectivo en Caja</th>
                                                <th>Diferencia en Caja</th>
                                                <th>Acciones</th>
                                                </tr>
                                                </thead>
                                                <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarArqueoCaja();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON ARQUEOS DE CAJAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
           	<td><?php echo $a++; ?></td>
            <td><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></td>
            <td><?php echo $reg[$i]['dni'].": ".$reg[$i]['nombres']; ?></td>
            <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaapertura'])); ?></td>
            <td><?php echo $reg[$i]['statusarqueo'] == 1 ? "**********" : date("d-m-Y H:i:s",strtotime($reg[$i]['fechacierre'])); ?></td>
            <td><?php echo number_format($reg[$i]['montoinicial'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[0]['dineroefectivo'], 2, '.', ','); ?></td>
           	<td><?php echo $simbolo.number_format($reg[$i]['diferencia'], 2, '.', ','); ?></td>
                                               <td>

<button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerArqueo('<?php echo encrypt($reg[$i]["codarqueo"]); ?>')"><i class="fa fa-eye"></i></button>

<?php if($reg[$i]["statusarqueo"]=='1'){ ?>

<button type="button" class="btn btn-dark btn-rounded" onClick="CerrarCaja('<?php echo encrypt($reg[$i]["codarqueo"]); ?>')" title="Cerrar Caja" ><i class="fa fa-archive"></i></button>

<?php } else { ?>

<a href="reportepdf?codarqueo=<?php echo encrypt($reg[$i]['codarqueo']); ?>&tipo=<?php echo encrypt("TICKETCIERRE") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>

<?php } ?>

</td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>

 <?php
   } 
######################### CARGAR ARQUEOS DE CAJAS PARA VENTAS ############################
?>


<?php
######################## CARGAR MOVIMIENTOS EN CAJAS PARA VENTAS ########################
if (isset($_GET['CargaMovimientos'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                  <th>N°</th>
                                                  <th>Caja</th>
                                                  <th>Responsable</th>
                                                  <th>Tipo</th>
                                                  <th>Descripción</th>
                                                  <th>Monto</th>
                                                  <th>Fecha</th>
                                                  <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarMovimientos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON MOVIMIENTOS EN CAJAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                  <td><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></td>
                                  <td><?php echo $reg[$i]['nombres']; ?></td>
                                  <td><?php echo $reg[$i]['tipomovimiento']; ?></td>
                                  <td><?php echo $reg[$i]['descripcionmovimiento']; ?></td>
                                  <td><?php echo $simbolo.number_format($reg[$i]['montomovimiento'], 2, '.', ','); ?></td>
                                  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechamovimiento'])); ?></td>
                                               <td>
<button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerMovimiento('<?php echo encrypt($reg[$i]["codmovimiento"]); ?>')"><i class="fa fa-eye"></i></button>

<?php if ($reg[$i]['statusarqueo']=="1") { ?>

<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalMovimiento" data-backdrop="static" data-keyboard="false" onClick="UpdateMovimiento('<?php echo $reg[$i]["codmovimiento"]; ?>','<?php echo $reg[$i]["codcaja"]; ?>','<?php echo $reg[$i]["tipomovimiento"]; ?>','<?php echo $reg[$i]["descripcionmovimiento"]; ?>','<?php echo number_format($reg[$i]["montomovimiento"], 2, '.', ','); ?>','<?php echo $reg[$i]["mediomovimiento"]; ?>','<?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechamovimiento'])); ?>','<?php echo $reg[$i]["codarqueo"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarMovimiento('<?php echo encrypt($reg[$i]["codmovimiento"]); ?>','<?php echo encrypt("MOVIMIENTOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> 

<?php } ?>

</td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
######################## CARGAR MOVIMIENTOS EN CAJAS PARA VENTAS #######################
?>







<?php
############################# CARGAR CREDITOS ############################
if (isset($_GET['CargaCreditos'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>N° de Venta</th>
                                                    <th>Nº de Documento</th>
                                                    <th>Nombre de Cliente</th>
                                                    <th>Imp. Total</th>
                                                    <th>Abono</th>
                                                    <th>Debe</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarCreditos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON CREDITOS DE VENTAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                    <td><?php echo substr($reg[$i]["tipodocumento"], 0, 1)."".$reg[$i]["codfactura"]; ?></td>

<td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]['dnicliente']; ?></td> 

<td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></td>

  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
                          <td>
<button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerCredito('<?php echo encrypt($reg[$i]["codventa"]); ?>')"><i class="fa fa-eye"></i></button>

<?php if($reg[$i]['totalpago'] != $reg[$i]['creditopagado']) { ?>
<button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Nuevo Abono" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCredito" data-backdrop="static" data-keyboard="false" onClick="AbonoCredito('<?php echo encrypt($reg[$i]["codcliente"]); ?>',
'<?php echo encrypt($reg[$i]["codventa"]); ?>',
'<?php echo number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ''); ?>',
'<?php echo $reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento'].": ".$reg[$i]["dnicliente"]; ?>',
'<?php echo $reg[$i]["nomcliente"]; ?>',
'<?php echo substr($reg[$i]["tipodocumento"], 0, 1)."".$reg[$i]["codfactura"]; ?>',
'<?php echo number_format($reg[$i]["totalpago"], 2, '.', ''); ?>',
'<?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?>',
'<?php echo number_format($total = ( $reg[$i]['creditopagado'] == '' ? "0.00" : $reg[$i]['creditopagado']), 2, '.', ''); ?>',
'<?php echo number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ''); ?>')"><i class="fa fa-credit-card"></i></button>
<?php } ?>

<a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&tipo=<?php echo encrypt("TICKETCREDITO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
                                              </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR CREDITOS ############################
?>





<?php
############################# CARGAR NOTAS DE CREDITO ############################
if (isset($_GET['CargaNotas'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>N° de Caja</th>
                                                    <th>N° de Nota</th>
                                                    <th>Nº de Documento</th>
                                                    <th>Descripción de Cliente</th>
                                                    <th>Motivo de Nota</th>
                                                    <th>Nº Artic</th>
                                                    <th>Imp. Total</th>
                                                    <th>Fecha Emisión</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarNotasCreditos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON NOTAS DE CREDITOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                    <td><?php echo $caja = ($reg[$i]['codcaja'] == '0' ? "**********" : $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']); ?></td>
                    <td><?php echo $reg[$i]['codfactura']; ?></td>
                    <td><?php echo $reg[$i]['tipodocumento']." Nº: ".$reg[$i]['facturaventa']; ?></td>
                    <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></td>
      <td class="text-center"><?php echo $reg[$i]["observaciones"]; ?></td>
                    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td> 
      <td class="text-center"><?php echo $simbolo.number_format($reg[$i]['totalpago'], 0, '.', '.'); ?></td>
                    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechanota'])); ?></td>
                                               <td>
<button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target=".bs-example-modal-lg" data-backdrop="static" data-keyboard="false" onClick="VerNota('<?php echo encrypt($reg[$i]["codnota"]); ?>')"><i class="fa fa-eye"></i></button>

<a href="reportepdf?codnota=<?php echo encrypt($reg[$i]['codnota']); ?>&tipo=<?php echo encrypt("NOTACREDITO"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
                                              </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR NOTAS DE CREDITO ############################
?>





<?php
############################# CARGAR PEDIDOS ############################
if (isset($_GET['CargaDetallesPedidos']) && isset($_GET['proceso'])) { 

  if(limpiar(decrypt($_GET["proceso"]))=="MESAS"){

?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Descripción de Cliente</th>
                                                    <th>Nº Pedido</th>
                                                    <th>Platillos</th>
                                                    <th>Tiempo</th>
                                                    <th>Status</th>
                                                    <th></th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarDetallesPedidos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PEDIDOS DE PRODUCTOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){

$fecha1 = new DateTime($reg[$i]['fechapedido']);
$fecha2 = ($reg[$i]['fechaentrega'] == '0000-00-00 00:00:00' ? new DateTime() : new DateTime($reg[$i]['fechaentrega']));
$fecha = $fecha1->diff($fecha2);  
?>

                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
<td><?php echo $cliente = ( $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente'])."<br><small class='text-danger alert-link'><i class='fa fa-clock-o'></i> ".$reg[$i]['nomsala']."<br>".$reg[$i]['nommesa']."</small>"; ?></td>

<td><?php echo "<strong>".$reg[$i]['codpedido']."-".$reg[$i]['pedido']."</strong><br><small><i class='fa fa-clock-o'></i> ".date("H:i:s",strtotime($reg[$i]['fechapedido']))."</small>"; ?></td>

<td><?php echo "<span class='font-10 bold'><strong>".$reg[$i]['detalles']."</strong></span>"; ?></td>

<td><?php printf('Hace %d horas, %d minutos, %d segundos ', $fecha->h, $fecha->i, $fecha->s); ?></td>

<td><?php echo $status = ( $reg[$i]['cocinero'] == 1 ? "<span class='badge badge-pill badge-danger'><i class='fa fa-exclamation-triangle'></i> PENDIENTE</span>" : "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ENTREGADO</span>"); ?></td>
                                            <td>
<a href="reportepdf?codpedido=<?php echo encrypt($reg[$i]['codpedido']); ?>&codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&pedido=<?php echo encrypt($reg[$i]['pedido']); ?>&tipo=<?php echo encrypt("COMANDA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Comanda"><i class="fa fa-print"></i></button></a>

                                              </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>

 <?php } else { ?>

<div class="table-responsive"><table id="default_order" class="table2 table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Descripción de Cliente</th>
                                                    <th>Nº Pedido</th>
                                                    <th>Platillos</th>
                                                    <th>Tiempo Pedido</th>
                                                    <th>Status</th>
                                                    <th><span class="mdi mdi-drag-horizontal"></span></th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarDetallesPedidos();

if($reg==""){
    
    echo "";   

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){

$explode = explode("<br>",$reg[0]['detalles']); 

$fecha1 = new DateTime($reg[$i]['fechapedido']);
$fecha2 = ($reg[$i]['fechaentrega'] == '0000-00-00 00:00:00' ? new DateTime() : new DateTime($reg[$i]['fechaentrega']));
$fecha = $fecha1->diff($fecha2);
?>

                                               <tr>
                                               <td><?php echo $a++; ?></td>
<td><?php echo $cliente = ( $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente'])."<br><small>".$tipo = ($reg[$i]['repartidor'] == 0 ? "<i class='fa fa-home'></i> EN ESTABLECIMIENTO" : "<i class='fa fa-motorcycle'></i> DELIVERY")."</small>"; ?></td>

<td><?php echo "<strong>".substr($reg[$i]['codpedido']."-".$reg[$i]['pedido'], 1)."</strong><br><small><i class='fa fa-clock-o'></i> ".date("H:i:s",strtotime($reg[$i]['fechapedido']))."</small>"; ?></td>

<td><?php echo "<span class='font-10 bold'><strong>".$reg[$i]['detalles']."</strong></span>"; ?></td>

<td><?php printf('Hace %d horas, %d minutos, %d segundos ', $fecha->h, $fecha->i, $fecha->s); ?></td>

<td><?php echo $status = ( $reg[$i]['cocinero'] == 1 ? "<span class='badge badge-pill badge-danger'><i class='fa fa-exclamation-triangle'></i> PENDIENTE</span>" : "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ENTREGADO</span>"); ?></td>
                                            <td>
<a href="reportepdf?codpedido=<?php echo encrypt($reg[$i]['codpedido']); ?>&codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&pedido=<?php echo encrypt($reg[$i]['pedido']); ?>&tipo=<?php echo encrypt("COMANDA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Comanda"><i class="fa fa-print"></i></button></a>

                                              </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>

 <?php
}
   } 
############################# CARGAR PEDIDOS ############################
?>


<?php
############################# CARGAR MOSTRADOR ############################
if (isset($_GET['CargaMostrador']) && isset($_GET['proceso'])) { 

 $proceso = limpiar($_GET['proceso']);

 $reg = $tra->ListarMostrador();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PEDIDOS DE PRODUCTOS A COCINA ACTUALMENTE </center>";
    echo "</div>";    

} else { 
?>

<!-- Row--> 
<div class="row">

<?php 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 

$fecha1 = new DateTime($reg[$i]['fechapedido']);
$fecha2 = ($reg[$i]['fechaentrega'] == '0000-00-00 00:00:00' ? new DateTime() : new DateTime($reg[$i]['fechaentrega']));
$fecha = $fecha1->diff($fecha2);
//printf('%d años, %d meses, %d días, %d horas, %d minutos', $fecha->y, $fecha->m, $fecha->d, $fecha->h, $fecha->i);
?>
            <!-- Column -->
            <div class="col-lg-4">
              <div class="card">
                <div class="bg-warning p-2">
                  <div class="text-center text-white">
                    <i class="mdi mdi-reorder-horizontal"></i> DETALLE DE PEDIDO
                  </div>
                </div>

                <div class="card-body">
                  <h4 class="font-normal text-danger alert-link"><?php echo $sala = ( $reg[$i]['codmesa'] == '0' ? "DELIVERY" : $reg[$i]['nomsala']." : ".$reg[$i]['nommesa']); ?></h4>

                  <h4 class="font-normal"><?php echo $cliente = ( $reg[$i]['codcliente'] == '' || $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']); ?></h4>

                  <p class="mb-0 text-danger font-12 alert-link">Recibido: <?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechapedido'])); ?><br>

                  <?php if($reg[$i]['fechaentrega'] == '0000-00-00 00:00:00' && $reg[$i]['tipodocumento'] == '0'){

                  printf('Hace: %d horas, %d minutos, %d segundos ', $fecha->h, $fecha->i, $fecha->s); 

                  } else { ?>

                  <?php 
                  
                  echo "Entregado: ".$proceso = ($reg[$i]['fechaentrega'] == '0000-00-00 00:00:00' ? "**********" : date("d-m-Y H:i:s",strtotime($reg[$i]['fechaentrega'])));

                  printf('<br>Esperado: %d horas, %d minutos, %d segundos ', $fecha->h, $fecha->i, $fecha->s);
                  } ?>
                </p>

                  <p class="mb-0 mt-2 font-12"><?php echo "<strong>Pedido: ".substr($reg[$i]['codpedido']."-".$reg[$i]['pedido'], 1)."<br>".$reg[$i]['detalles']."</strong>"; ?></p>

                <?php if($reg[$i]['cocinero'] == '1'){?>
                  <div class="d-flex no-block align-items-center mb-3">
                    <div class="ml-auto">
                      <button type="button" class="btn btn-info btn-rounded" onClick="EntregarPedidos('<?php echo encrypt($reg[$i]["codpedido"]) ?>','<?php echo encrypt($reg[$i]["pedido"]) ?>','<?php echo encrypt($reg[$i]["codventa"]) ?>','<?php echo encrypt($reg[$i]["delivery"]) ?>','<?php echo $proceso ?>','<?php echo encrypt("ENTREGARPEDIDOCOCINERO") ?>')" title="Entregar Pedido" ><i class="fa fa-refresh"></i></button>

                        <a href="reportepdf?codpedido=<?php echo encrypt($reg[$i]['codpedido']); ?>&codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&pedido=<?php echo encrypt($reg[$i]['pedido']); ?>&tipo=<?php echo encrypt("COMANDA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Comanda"><i class="fa fa-print"></i></button></a>
                    </div>
                  </div>
                <?php } ?>

                </div>
              </div>
            </div>
            <!-- Column -->

                                   
            <?php } } ?>
                                 
      </div>
    <!-- Row -->
 <?php
   } 
############################# CARGAR MOSTRADOR ############################
?>

<?php
############################# CARGAR MOSTRADOR DELIVERY ############################
if (isset($_GET['CargaDelivery']) && isset($_GET['proceso'])) { 

$proceso = limpiar($_GET['proceso']);

$reg = $tra->ListarDelivery();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PEDIDOS DE PRODUCTOS PARA ENTREGAS ACTUALMENTE </center>";
    echo "</div>";    

} else { ?>

<!-- Row--> 
<div class="row">


<?php 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>

         <!-- Column -->
            <div class="col-lg-4">
              <div class="card">
                <div class="bg-warning p-2">
                  <div class="text-center text-white">
                    <i class="mdi mdi-reorder-horizontal"></i> DETALLE DE DELIVERY
                  </div>
                </div>

                <div class="card-body">
                  <h5 class="font-normal text-danger"><?php echo $nombre = ( $reg[$i]['codcliente'] == '0' ? "<strong>CLIENTE: *************</strong>" : $reg[$i]['nomcliente']).
"<br>".$direccion = ( $reg[$i]['codcliente'] == '0' ? "DIRECC: *************" : $reg[$i]['direccliente']).
"<br> ".$tlf = ( $reg[$i]['tlfcliente'] == '' ? "Nº TLF: *************" : $reg[$i]['tlfcliente']); ?></h5>

                  <p class="mb-0 mt-2 font-12"><?php echo "<span style='font-size:12px;'><strong>Pedido #".$reg[$i]['pedido']."<br>".$reg[$i]['detalles']."</strong></span>"; ?></p>

                <?php if($reg[$i]['tipodocumento'] != '0' && $reg[$i]['cocinero'] == '0' && $reg[$i]['entregado'] == '1'){ ?>
                  
                  <div class="d-flex no-block align-items-center mb-3">
                    <div class="ml-auto">
                      <button type="button" class="btn btn-info btn-rounded" onClick="EntregarDelivery('<?php echo encrypt($reg[$i]["codpedido"]) ?>','<?php echo encrypt($reg[$i]["pedido"]) ?>','<?php echo encrypt($reg[$i]["codventa"]) ?>','<?php echo encrypt($reg[$i]["delivery"]) ?>','<?php echo $proceso ?>','<?php echo encrypt("ENTREGARPEDIDODELIVERY") ?>')" title="Entregar Pedido" ><i class="fa fa-refresh"></i></button>

                      <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
                    </div>
                  </div>

                <?php } ?>

                </div>
              </div>
            </div>
            <!-- Column -->

            <?php } } ?>
                                 
      </div>
    <!-- Row -->
 <?php
   } 
############################# CARGAR MOSTRADOR DELIVERY ############################
?>

<!-- Datatables-->
  <script src="assets/plugins/datatables/dataTables.min.js"></script>
  <script src="assets/plugins/datatables/datatable-basic.init.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#datatable').dataTable();
      $('#default_order').dataTable();
    } );
  </script>


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