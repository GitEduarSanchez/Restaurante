<?php
require_once("class/class.php");
?>
<!--<script type="text/javascript" src="assets/script/jsventas.js"></script>
<script type="text/javascript" src="assets/script/jsdelivery.js"></script>-->
<script src="assets/script/jscalendario.js"></script>
<script src="assets/script/autocompleto.js"></script> 

<?php
$imp = new Login();
$imp = $imp->ImpuestosPorId();
$impuesto = ($imp == "" ? "Impuesto" : $imp[0]['nomimpuesto']);
$valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

$con = new Login();
$con = $con->ConfiguracionPorId();
$simbolo = ($con == "" ? "" : "<label>".$con[0]['simbolo']."</label>");

$new = new Login();
?>


<?php 
######################## BUSCA DEPARTAMENTOS POR PROVINCIAS ########################
if (isset($_GET['BuscaDepartamentos']) && isset($_GET['id_provincia'])) {
  
   $dep = $new->ListarDepartamentoXProvincias();

$id_provincia = limpiar($_GET['id_provincia']);

 if($id_provincia=="") { ?>

  <option value="">-- SIN RESULTADOS --</option>
  <?php } else { ?>

    <option value=""> -- SELECCIONE -- </option>
  <?php
   for($i=0;$i<sizeof($dep);$i++){
    ?>
<option value="<?php echo $dep[$i]['id_departamento']; ?>" ><?php echo $dep[$i]['departamento']; ?></option>
    <?php 
    }
  }
}
######################## BUSCA DEPARTAMENTOS POR PROVINCIAS ########################
?>

<?php 
######################## SELECCIONE DEPARTAMENTOS POR PROVINCIAS ########################
if (isset($_GET['SeleccionaDepartamento']) && isset($_GET['id_provincia']) && isset($_GET['id_departamento'])) {
  
   $dep = $new->SeleccionaDepartamento();
  ?>
    </div>
  </div>
       <option value="">SELECCIONE</option>
  <?php for($i=0;$i<sizeof($dep);$i++){ ?>
<option value="<?php echo $dep[$i]['id_departamento']; ?>"<?php if (!(strcmp($_GET['id_departamento'], htmlentities($dep[$i]['id_departamento'])))) {echo "selected=\"selected\"";} ?>><?php echo $dep[$i]['departamento']; ?></option>
<?php
   } 
}
######################## SELECCIONE DEPARTAMENTOS POR PRIVINCIAS ########################
?>

<?php 
######################## BUSCA MESAS POR SALAS ########################
if (isset($_GET['BuscaMesasxSalas']) && isset($_GET['codsala'])) {
  
$mesa = new Login();
$mesa = $mesa->BuscarMesas();

$codsala = limpiar($_GET['codsala']);

 if($codsala=="") { ?>

  <option value="">-- SIN RESULTADOS --</option>
  <?php } else { ?>
  <option value=""> -- SELECCIONE -- </option>
  <?php
  for($i=0;$i<sizeof($mesa);$i++){
  ?>
  <option value="<?php echo encrypt($mesa[$i]['codmesa']); ?>" ><?php echo $mesa[$i]['nommesa']; ?></option>
    <?php 
    } 
  }
}
######################## BUSCA MESAS POR SALAS ########################
?>


<?php
######################## MOSTRAR USUARIO EN VENTANA MODAL ############################
if (isset($_GET['BuscaUsuarioModal']) && isset($_GET['codigo'])) { 
$reg = $new->UsuariosPorId();
?>

  <table class="table-responsive" border="0" class="text-center">
  <tr>
    <td><strong>Nº de Documento:</strong> <?php echo $reg[0]['dni']; ?></td>
  </tr>
  <tr>
    <td><strong>Nombres y Apellidos:</strong> <?php echo $reg[0]['nombres']; ?></td>
  </tr>
  <tr>
    <td><strong>Sexo:</strong> <?php echo $reg[0]['sexo']; ?></td>
  </tr>
  <tr>
    <td><strong>Dirección Domiciliaria: </strong> <?php echo $reg[0]['direccion']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de Teléfono: </strong> <?php echo $reg[0]['telefono']; ?></td>
  </tr>
  <tr>
    <td><strong>Correo Electrónico: </strong> <?php echo $reg[0]['email']; ?></td>
  </tr>
  <tr>
    <td><strong>Usuario de Acceso: </strong> <?php echo $reg[0]['usuario']; ?></td>
  </tr>
  <tr>
    <td><strong>Nivel de Acceso: </strong> <?php echo $reg[0]['nivel']; ?></td>
  </tr>
  <tr>
    <td><strong>Comisión por Ventas: </strong> <?php echo number_format($reg[0]['comision'], 2, '.', ''); ?>%</td>
  </tr>
  <tr>
  <td><strong>Status de Acceso: </strong> <?php echo $status = ( $reg[0]['status'] == 1 ? "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='badge badge-pill badge-warning'><i class='fa fa-times'></i> INACTIVO</span>"); ?></td>
  </tr>
</table>  

  <?php
   } 
######################## MOSTRAR USUARIO EN VENTANA MODAL ############################
?>




<?php 
######################## MUESTRA DIV CLIENTE ########################
if (isset($_GET['BuscaDivCliente'])) {
  
  ?>
<div class="row">
      <div class="col-md-12">
<font color="red"><label> Para poder realizar la Carga Masiva de Clientes, el archivo Excel, debe estar estructurado de 13 columnas, la cuales tendrán las siguientes especificaciones:</label></font><br>

  1. Código de Cliente. (Ejemplo: C1, C2, C3, C4, C5......)<br>
  2. Tipo de Cliente (Opciones: NATURAL/JURIDICO).<br>
  3. Tipo de Documento. (Debera de Ingresar el Codigo de Documento a la que corresponde)<br>
  4. Nº de Documento.<br>
  5. Nombre de Cliente.<br>
  6. Razón Social (Ingresar en caso de ser Cliente Juridico de lo contrario dejarlo vacio).<br>
  7. Giro de Cliente (Ingresar en caso de ser Cliente Juridico de lo contrario dejarlo vacio).<br>
  8. Nº de Teléfono. (Formato: (9999) 9999999).<br>
  9. Provincia. (Debera de Ingresar el Codigo de Provincia a la que corresponde)<br>
  10. Departamento. (Debera de Ingresar el Codigo de Departamento a la que corresponde)<br>
  11. Dirección Domiciliaria.<br>
  12. Correo Electronico.<br>
  13. Monto de Crédito en Ventas.<br><br>

  <font color="red"><label> NOTA:</label></font><br>
  a) El Archivo no debe de tener cabecera, solo deben estar los registros a grabar.<br>
  b) Se debe de guardar como archivo .CSV  (delimitado por comas)(*.csv).<br>
  c) Todos los datos deberán escribirse en mayúscula para mejor orden y visibilidad en los reportes.<br>
  d) Deben de tener en cuenta que la carga masiva de Clientes, deben de ser cargados como se explica, para evitar problemas de datos del cliente dentro del Sistema.<br><br>
   </div>
</div>                               
<?php 
  }
######################## MUESTRA DIV CLIENTE ########################
?>

<?php
######################## MOSTRAR CLIENTE EN VENTANA MODAL ########################
if (isset($_GET['BuscaClienteModal']) && isset($_GET['codcliente'])) { 

$reg = $new->ClientesPorId();
?>
 <table class="table-responsive" border="0" class="text-center">
  <tr>
    <td><strong>Código:</strong> <?php echo $reg[0]['codcliente']; ?></td>
  </tr>
  <tr>
    <td><strong>Tipo de Cliente: </strong> <?php echo $reg[0]['tipocliente']; ?></td>
  </tr> 
  <tr>
    <td><strong>Nº de <?php echo $reg[0]['documcliente'] == '0' ? "Documento" : $reg[0]['documento'] ?>:</strong> <?php echo $reg[0]['dnicliente']; ?></td>
  </tr>
  <tr>
    <td><strong>Nombre/Razón Social:</strong> <?php echo $reg[0]['nomcliente']; ?></td>
  </tr>
  <tr>
    <td><strong>Giro de Cliente:</strong> <?php echo $reg[0]['tipocliente'] == 'NATURAL' ? "*********" : $reg[0]['girocliente']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de Teléfono: </strong> <?php echo $reg[0]['tlfcliente'] == '' ? "*********" : $reg[0]['tlfcliente'] ?></td>
  </tr>
  <tr>
    <td><strong>Provincia: </strong> <?php echo $reg[0]['provincia'] == '' ? "*********" : $reg[0]['provincia'] ?></td>
  </tr>
  <tr>
    <td><strong>Departamento: </strong> <?php echo $reg[0]['departamento'] == '' ? "*********" : $reg[0]['departamento'] ?></td>
  </tr>
  <tr>
    <td><strong>Dirección Domiciliaria: </strong> <?php echo $reg[0]['direccliente']; ?></td>
  </tr>
  <tr>
    <td><strong>Correo Electrónico: </strong> <?php echo $reg[0]['emailcliente'] == '' ? "*********" : $reg[0]['emailcliente'] ?></td>
  </tr> 
  <tr>
    <td><strong>Limite de Crédito: </strong> <?php echo number_format($reg[0]['limitecredito'], 2, '.', ','); ?></td>
  </tr> 
  <tr>
    <td><strong>Cantidad de Compras: </strong> <?php echo number_format($reg[0]['cantidad'], 2, '.', ','); ?></td>
  </tr>  
  <tr>
    <td><strong>Total en Compras: </strong> <?php echo $simbolo.number_format($reg[0]['totalcompras'], 2, '.', ','); ?></td>
  </tr>  
  <tr>
    <td><strong>Fecha de Ingreso: </strong> <?php echo date("d-m-Y",strtotime($reg[0]['fechaingreso'])); ?></td>
  </tr>
</table>
<?php 
} 
######################## MOSTRAR CLIENTE EN VENTANA MODAL ########################
?>












<?php 
######################## MUESTRA DIV PROVEEDOR ########################
if (isset($_GET['BuscaDivProveedor'])) {
  
  ?>
<div class="row">
      <div class="col-md-12">
<font color="red"><label> Para poder realizar la Carga Masiva de Proveedores, el archivo Excel, debe estar estructurado de 11 columnas, la cuales tendrán las siguientes especificaciones:</label></font><br>

  1. Código de Proveedor. (Ejemplo: P1, P2, P3, P4, P5......)<br>
  2. Tipo de Documento. (Debera de Ingresar el Codigo de Documento a la que corresponde)<br>
  3. Nº de Documento.<br>
  4. Nombre de Proveedor (Ingresar Nombre de Proveedor).<br>
  5. Nº de Teléfono. (Formato: (9999) 9999999).<br>
  6. Provincia. (Debera de Ingresar el Codigo de Provincia a la que corresponde)<br>
  7. Departamento. (Debera de Ingresar el Codigo de Departamento a la que corresponde)<br>
  8. Dirección de Proveedor.<br>
  9. Correo Electronico.<br>
  10. Nombre de Vendedor.<br>
  11. Nº de Teléfono de Vendedor. (Formato: (9999) 9999999).<br><br>

  <font color="red"><label> NOTA:</label></font><br>
  a) El Archivo no debe de tener cabecera, solo deben estar los registros a grabar.<br>
  b) Se debe de guardar como archivo .CSV  (delimitado por comas)(*.csv).<br>
  c) Todos los datos deberán escribirse en mayúscula para mejor orden y visibilidad en los reportes.<br>
  d) Deben de tener en cuenta que la carga masiva de Proveedores, deben de ser cargados como se explica, para evitar problemas de datos del proveedor dentro del Sistema.<br><br>
   </div>
</div>
<?php 
  }
######################## MUESTRA DIV PROVEEDOR ########################
?>

<?php
######################## MOSTRAR PROVEEDOR EN VENTANA MODAL ########################
if (isset($_GET['BuscaProveedorModal']) && isset($_GET['codproveedor'])) { 

$reg = $new->ProveedoresPorId();
?>
  
  <table class="table-responsive" border="0" class="text-center">
  <tr>
    <td><strong>Código:</strong> <?php echo $reg[0]['codproveedor']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de <?php echo $reg[0]['documproveedor'] == '0' ? "Documento" : $reg[0]['documento']; ?>:</strong> <?php echo $reg[0]['cuitproveedor']; ?>:</td>
  </tr>
  <tr>
    <td><strong>Nombres de Proveedor:</strong> <?php echo $reg[0]['nomproveedor']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de Teléfono: </strong> <?php echo $reg[0]['tlfproveedor']; ?></td>
  </tr>
  <tr>
    <td><strong>Provincia: </strong> <?php echo $reg[0]['provincia'] == '' ? "*********" : $reg[0]['provincia']; ?></td>
  </tr>
  <tr>
    <td><strong>Departamento: </strong> <?php echo $reg[0]['departamento'] == '' ? "*********" : $reg[0]['departamento']; ?></td>
  </tr>
  <tr>
    <td><strong>Dirección de Proveedor: </strong> <?php echo $reg[0]['direcproveedor']; ?></td>
  </tr>
  <tr>
    <td><strong>Correo Electrónico: </strong> <?php echo $reg[0]['emailproveedor']; ?></td>
  </tr> 
  <tr>
    <td><strong>Vendedor: </strong> <?php echo $reg[0]['vendedor']; ?></td>
  </tr> 
  <tr>
    <td><strong>Nº de Teléfono: </strong> <?php echo $reg[0]['tlfvendedor']; ?></td>
  </tr>
  <tr>
    <td><strong>Fecha de Ingreso: </strong> <?php echo date("d-m-Y",strtotime($reg[0]['fechaingreso'])); ?></td>
  </tr>
</table>
<?php 
} 
######################## MOSTRAR PROVEEDOR EN VENTANA MODAL ########################
?>





























<?php 
######################## MUESTRA DIV INGREDIENTE ########################
if (isset($_GET['BuscaDivIngrediente'])) {
  
  ?>
<div class="row">
      <div class="col-md-12">
<font color="red"><label> Para poder realizar la Carga Masiva de Ingredientes, el archivo Excel, debe estar estructurado de 14 columnas, la cuales tendrán las siguientes especificaciones:</label></font><br><br>

  1. Código de Ingrediente (Ejem. 0001).<br>
  2. Nombre de Ingrediente.<br>
  3. Código de Medida. (Deberá ingresar el Nº de Unidad de Medida a la que corresponde).<br>
  4. Precio Compra. (Numeros con 2 decimales).<br>
  5. Precio Venta. (Numeros con 2 decimales).<br>
  6. Cantidad. (Debe de ser con 2 decimales).<br>
  7. Stock Minimo. (Debe de ser con 2 decimales).<br>
  8. Stock Máximo. (Debe de ser con 2 decimales).<br>
  9. <?php echo $impuesto; ?> de Producto. (Ejem. SI o NO).<br>
  10. Descuento de Producto. (Numeros con 2 decimales).<br>
  11. Lote de Producto (En caso de no tener colocar Cero (0)).<br>
  12. Fecha de Expiración. (Formato: 0000-00-00).<br>
  13. Proveedor. (Debe de verificar a que codigo pertenece el Proveedor existente).<br>
  14. Control de Stock. (Se debe de colocar 0 o 1. Ejem. SI = 1, NO = 0).<br><br>

  <font color="red"><label> NOTA:</label></font><br>
  a) El Archivo no debe de tener cabecera, solo deben estar los registros a grabar.<br>
  b) Se debe de guardar como archivo .CSV  (delimitado por comas)(*.csv).<br>
  c) Todos los datos deberán escribirse en mayúscula para mejor orden y visibilidad en los reportes.<br>
  d) Deben de tener en cuenta que la carga masiva de Ingredientes, deben de ser cargados como se explica, para evitar problemas de datos del ingrediente dentro del Sistema.<br><br>
    </div>
</div>                                 
<?php 
  }
######################## MUESTRA DIV INGREDIENTE ########################
?>

<?php
######################## MOSTRAR INGREDIENTES EN VENTANA MODAL ########################
if (isset($_GET['BuscaIngredienteModal']) && isset($_GET['codingrediente'])) { 

$reg = $new->IngredientesPorId(); 

$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 
?>
  
  <table class="table-responsive" border="0" class="text-center">
  <tr>
    <td><strong>Código:</strong> <?php echo $reg[0]['codingrediente']; ?></td>
  </tr>
  <tr>
    <td><strong>Ingrediente:</strong> <?php echo $reg[0]['nomingrediente']; ?></td>
  </tr> 
  <tr>
  <td><strong>Proveedor: </strong><?php echo $reg[0]['codproveedor'] == '0' ? "*********" : $reg[0]['cuitproveedor'].": ".$reg[0]['nomproveedor']; ?></td>
  </tr> 
  <tr>
    <td><strong>Unidad Medida:</strong> <?php echo $reg[0]['nommedida']; ?></td>
  </tr>
  <tr>
    <td><strong>Precio de Compra: </strong> <?php echo $simbolo.number_format($reg[0]['preciocompra'], 2, '.', ','); ?></td>
  </tr> 
  <tr>
    <td><strong>Precio de Venta: </strong> <?php echo $simbolo.number_format($reg[0]['precioventa'], 2, '.', ','); ?></td>
  </tr>
<?php if($cambio!=""){ ?>
  <tr>
    <td><strong><?php echo $cambio == '' ? "**********" : "Precio ".$cambio[0]['siglas']; ?>: </strong> 
      <?php echo $cambio == '' ? "**********" : "<label>".$cambio[0]['simbolo']."</label> ".number_format($reg[0]['precioventa']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
  </tr> 
<?php } ?>
  <tr>
    <td><strong>Existencia: </strong> <?php echo $reg[0]['cantingrediente']; ?></td>
  </tr> 
  <tr>
    <td><strong>Stock Minimo: </strong> <?php echo $reg[0]['stockminimo'] == '0' ? "*********" : $reg[0]['stockminimo']; ?></td>
  </tr> 
  <tr>
    <td><strong>Stock Máximo: </strong> <?php echo $reg[0]['stockmaximo'] == '0' ? "*********" : $reg[0]['stockmaximo']; ?></td>
  </tr> 
  <tr>
    <td><strong><?php echo $impuesto; ?>: </strong> <?php echo $reg[0]['ivaingrediente'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
  </tr> 
  <tr>
    <td><strong>Descuento: </strong> <?php echo number_format($reg[0]['descingrediente'], 2, '.', ',')."%"; ?></td>
  </tr>  
  <tr>
    <td><strong>Nº de Lote: </strong> <?php echo $reg[0]['lote'] == '0' ? "*********" : $reg[0]['lote']; ?></td>
  </tr>
  <tr>
    <td><strong>Fecha de Expiración: </strong> <?php echo $reg[0]['fechaexpiracion'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[0]['fechaexpiracion'])); ?></td>
  </tr>
  <tr>
    <td><strong>Status: </strong> <?php echo $status = ( $reg[0]['cantingrediente'] != 0.00 ? "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='badge badge-pill badge-warning'><i class='fa fa-times'></i> INACTIVO</span>"); ?></td>
  </tr>
    <tr>
    <td><strong>Control de Stock: </strong> <?php echo $control = ( $reg[0]['controlstocki'] == 1 ? "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> SI</span>" : "<span class='badge badge-pill badge-warning'><i class='fa fa-times'></i> NO</span>"); ?></td>  
    </tr>
</table>
<?php 
} 
######################## MOSTRAR INGREDIENTES EN VENTANA MODAL ########################
?>

<?php 
######################## BUSQUEDA DE INGREDIENTES VENDIDOS ########################
if (isset($_GET['BuscaIngredientesVendidos']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarIngredientesVendidos();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Ingredientes Vendidos por Fecha Desde <?php echo date("d-m-Y", strtotime($desde)); ?> Hasta <?php echo date("d-m-Y", strtotime($hasta)); ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("INGREDIENTESVENDIDOS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("INGREDIENTESVENDIDOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("INGREDIENTESVENDIDOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>Código</th>
                                  <th>Descripción de Ingrediente</th>
                                  <th>Unidad Medida</th>
                                  <th>Desc</th>
                                  <th>Precio de Venta</th>
                                  <th>Existencia</th>
                                  <th>Vendido</th>
                                  <th>Monto Total</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$precioTotal=0;
$existeTotal=0;
$vendidosTotal=0;
$pagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$precioTotal+=$reg[$i]['precioventa'];
$existeTotal+=$reg[$i]['cantingrediente'];
$vendidosTotal+=$reg[$i]['cantidad']; 
$pagoTotal+=$reg[$i]['precioventa']*$reg[$i]['cantingrediente']-$reg[$i]['descingrediente']/100; 
?>
                                <tr>
                      <td><?php echo $a++; ?></div></td>
                      <td><?php echo $reg[$i]['codingrediente']; ?></td>
                      <td><?php echo $reg[$i]['nomingrediente']; ?></td>
                      <td><?php echo $reg[$i]['nommedida']; ?></td>
                      <td><?php echo $reg[$i]['descingrediente']; ?>%</td>
                      <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
                      <td><?php echo number_format($reg[$i]['cantingrediente'], 2, '.', ','); ?></td>
                      <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
                      <td><?php echo $simbolo.number_format($reg[$i]['precioventa']*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
                                </tr>
                        <?php  }  ?>
                      <tr>
                        <td colspan="5"></td>
                        <td><label><?php echo $simbolo.number_format($precioTotal, 2, '.', ','); ?></label></td>
                        <td><label><?php echo number_format($existeTotal, 2, '.', ','); ?></label></td>
                        <td><label><?php echo number_format($vendidosTotal, 2, '.', ','); ?></label></td>
                        <td><label><?php echo $simbolo.number_format($pagoTotal, 2, '.', ','); ?></label></td>
                      </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
######################## BUSQUEDA DE INGREDIENTES VENDIDOS ########################
?>

<?php 
######################## MUESTRA INGREDIENTES AGREGADOS A PRODUCTOS ########################
if (isset($_GET['BuscaIngredienteAgregados']) && isset($_GET['codproducto'])) { 
$new = new Login();
$reg = $new->ProductosPorId();   
?>
<div class="row">
            <div class="col-md-3">
                <div class="form-group has-feedback">
                <label class="control-label">Código de Producto: <span class="symbol required"></span></label>
                <input type="hidden" name="proceso" id="proceso" value="save"/>
                <input type="hidden" name="codproducto" id="codproducto" value="<?php echo $reg[0]['codproducto']; ?>"/>
                <input type="hidden" name="preciocompra" id="preciocompra" value="0.00"/>
                <input type="hidden" name="precioventa" id="precioventa" value="0.00"/>
                <input type="hidden" name="producto" id="producto" value="<?php echo encrypt($reg[0]['codproducto']); ?>">
                    <br /><abbr title="Código de Producto"><?php echo $reg[0]['codproducto']; ?></abbr>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Nombre de Producto: <span class="symbol required"></span></label>
                    <br /><abbr title="Nombre de Producto"><?php echo $reg[0]['producto']; ?></abbr>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Existencia: <span class="symbol required"></span></label>
                    <br /><abbr title="Existencia de Producto"><?php echo $reg[0]['existencia']; ?></abbr>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Categoria de Producto: <span class="symbol required"></span></label>
                    <br /><abbr title="Categoria de Producto"><?php echo $reg[0]['nomcategoria']; ?></abbr>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Precio de Compra: <span class="symbol required"></span></label>
                    <input type="hidden" name="preciocomprabd" id="preciocomprabd" value="<?php echo $reg[0]['preciocompra']; ?>"/>
                    <br /><abbr title="Precio de Compra"><?php echo number_format($reg[0]['preciocompra'], 2, '.', ','); ?></abbr>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Precio de Venta: <span class="symbol required"></span></label>
                    <input type="hidden" name="precioventabd" id="precioventabd" value="<?php echo $reg[0]['precioventa']; ?>"/>
                    <br /><abbr title="Precio de Venta"><?php echo number_format($reg[0]['precioventa'], 2, '.', ','); ?></abbr>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label"><?php echo $impuesto; ?> de Producto: <span class="symbol required"></span></label>
                    <br /><abbr title="Impuesto de Producto"><?php echo $reg[0]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></abbr>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Descuento de Producto: <span class="symbol required"></span></label>
                    <br /><abbr title="Descuento de Producto"><?php echo number_format($reg[0]['descproducto'], 2, '.', ','); ?></abbr>
                </div>
            </div>
        </div>

<h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cart-plus"></i> Ingredientes Agregados</h2><br>

<table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
              <thead>
              <tr role="row">
              </tr>
                                <tr>
                                <th>Nº</th>
                                <th>Cant. Ración</th>
                                <th>Ingrediente</th>
                                <th>Existencia</th>
                                <th>Precio Compra</th>
                                <th>Precio Venta</th>
                                <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                            </thead>
                                <tbody>
<?php 
$tru = new Login();
$a=1;
$busq = $tru->VerDetallesIngredientes();

if($busq==""){

echo "";      

} else {

for($i=0;$i<sizeof($busq);$i++){
?>
                <tr>
<td><?php echo $a++; ?></td>
<td><?php echo $busq[$i]["cantracion"]; ?></td>
<td><?php echo $busq[$i]["nomingrediente"]; ?></td>
<td><?php echo $busq[$i]["cantingrediente"]." ".$busq[$i]["nommedida"]; ?></td>
<td><?php echo number_format($busq[$i]["cantracion"]*$busq[$i]["preciocompra"], 2, '.', ','); ?></td>
<td><?php echo number_format($busq[$i]["cantracion"]*$busq[$i]["precioventa"], 2, '.', ','); ?></td>
<td><button type="button" class="btn btn-dark btn-rounded" onClick="EliminaDetalleIngredienteAgregado('<?php echo encrypt($busq[$i]['codproducto']) ?>','<?php echo encrypt($busq[$i]['codingrediente']) ?>','<?php echo encrypt($busq[$i]['cantracion']) ?>','<?php echo encrypt("ELIMINADETALLEINGREDIENTE") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td>
                </tr><?php } } ?>
              </tbody>
        </table>

<?php 
}
######################## MUESTRA INGREDIENTES AGREGADOS A PRODUCTOS ########################
?>

<?php 
######################## BUSQUEDA DE KARDEX POR INGREDIENTES ########################
if (isset($_GET['BuscaKardexIngrediente']) && isset($_GET['codingrediente'])) { 

$codingrediente = limpiar($_GET['codingrediente']); 

  if($codingrediente=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL INGREDIENTE CORRECTAMENTE</center>";
  echo "</div>";
  exit;
   
   } else {
  
$kardex = new Login();
$kardex = $kardex->BuscarKardexIngrediente();  
?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Movimientos del Ingrediente <?php echo $kardex[0]['codingrediente'].": ".$kardex[0]['nomingrediente']; ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codingrediente=<?php echo $codingrediente; ?>&tipo=<?php echo encrypt("KARDEXINGREDIENTES") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codingrediente=<?php echo $codingrediente; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("KARDEXINGREDIENTES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codingrediente=<?php echo $codingrediente; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("KARDEXINGREDIENTES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

              </div>
            </div>
          </div>

          <div id="div3"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                                  <th>Nº</th>
                                  <th>Movimiento</th>
                                  <th>Entradas</th>
                                  <th>Salidas</th>
                                  <th>Devolución</th>
                                  <th>Precio Costo</th>
                                  <th>Costo Movimiento</th>
                                  <th>Stock Actual</th>
                                  <th>Documento</th>
                                  <th>Fecha de Kardex</th>
                              </tr>
                              </thead>
                              <tbody>
<?php
$TotalEntradas=0;
$TotalSalidas=0;
$TotalDevolucion=0;
$a=1;
for($i=0;$i<sizeof($kardex);$i++){ 
$TotalEntradas+=$kardex[$i]['entradas'];
$TotalSalidas+=$kardex[$i]['salidas'];
$TotalDevolucion+=$kardex[$i]['devolucion'];
?>
                              <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $kardex[$i]['movimiento']; ?></td>
                                  <td><?php echo number_format($kardex[$i]['entradas'], 2, '.', ','); ?></td>
                                  <td><?php echo number_format($kardex[$i]['salidas'], 2, '.', ','); ?></td>
                                  <td><?php echo number_format($kardex[$i]['devolucion'], 2, '.', ','); ?></td>
                                  <td><?php echo $simbolo.number_format($kardex[$i]['precio'], 2, '.', ','); ?></td>
                          <?php if($kardex[$i]["movimiento"]=="ENTRADAS"){ ?>
        <td><?php echo number_format($kardex[$i]['precio']*$kardex[$i]['entradas'], 2, '.', ','); ?></td>
                          <?php } elseif($kardex[$i]["movimiento"]=="SALIDAS"){ ?>
        <td><?php echo number_format($kardex[$i]['precio']*$kardex[$i]['salidas'], 2, '.', ','); ?></td>
                          <?php } else { ?>
        <td><?php echo number_format($kardex[$i]['precio']*$kardex[$i]['devolucion'], 2, '.', ','); ?></td>
                          <?php } ?>
                                  <td><?php echo number_format($kardex[$i]['stockactual'], 2, '.', ','); ?></td>
                                  <td><?php echo $kardex[$i]['documento']." ".$num = ($kardex[$i]['documento'] == 'VENTA' || $kardex[$i]['documento'] == 'DEVOLUCION' ? $kardex[$i]['codproceso'] : ""); ?></td>
                                  <td><?php echo date("d-m-Y",strtotime($kardex[$i]['fechakardex'])); ?></td>
                              </tr>
                        <?php  }  ?>
                              </tbody>
                          </table>
                        
          <label>Detalles de Ingrediente</label><br>
          <label>Código:</label> <?php echo $kardex[0]['codingrediente']; ?><br>
          <label>Descripción:</label> <?php echo $kardex[0]['nomingrediente']; ?><br>
          <label>Categoria:</label> <?php echo $kardex[0]['nommedida']; ?><br>
          <label>Total Entradas:</label> <?php echo number_format($TotalEntradas, 2, '.', ','); ?><br>
          <label>Total Salidas:</label> <?php echo number_format($TotalSalidas, 2, '.', ','); ?><br>
          <label>Total Devolución:</label> <?php echo number_format($TotalDevolucion, 2, '.', ','); ?><br>
          <label>Existencia:</label> <?php echo number_format($kardex[0]['cantingrediente'], 2, '.', ','); ?><br>
          <label>Precio Compra:</label> <?php echo $simbolo." ".number_format($kardex[0]['preciocompra'], 2, '.', ','); ?><br>
          <label>Precio Venta:</label> <?php echo $simbolo." ".number_format($kardex[0]['precioventa'], 2, '.', ','); ?>
            </div>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
######################## BUSQUEDA DE KARDEX POR INGREDIENTES ########################
?>


























<?php 
######################## MUESTRA DIV PRODUCTO ########################
if (isset($_GET['BuscaDivProducto'])) {
  
  ?>
<div class="row">
      <div class="col-md-12">
<font color="red"><label> Para poder realizar la Carga Masiva de Productos, el archivo Excel, debe estar estructurado de 17 columnas, la cuales tendrán las siguientes especificaciones:</label></font><br><br>

  1. Código de Producto (Ejem. 0001).<br>
  2. Nombre de Producto.<br>
  3. Código de Categoria. (Deberá ingresar el Nº de Categoria a la que corresponde o colocar Cero (0)).<br>
  4. Precio Compra. (Numeros con 2 decimales).<br>
  5. Precio Venta. (Numeros con 2 decimales).<br>
  6. Existencia. (Debe de ser solo enteros).<br>
  7. Stock Minimo. (Debe de ser solo enteros).<br>
  8. Stock Máximo. (Debe de ser solo enteros).<br>
  9. <?php echo $impuesto; ?> de Producto. (Ejem. SI o NO).<br>
  10. Descuento de Producto. (Numeros con 2 decimales).<br>
  11. Código de Barra. (En caso de no tener colocar Cero (0)).<br>
  12. Lote de Producto (En caso de no tener colocar Cero (0)).<br>
  13. Fecha de Elaboración. (Formato: 0000-00-00).<br>
  14. Fecha de Expiración. (Formato: 0000-00-00).<br>
  15. Proveedor. (Debe de verificar a que codigo pertenece el Proveedor existente).<br>
  16. Favorito.<br>
  17. Control de Stock. (Se debe de colocar 0 o 1. Ejem. SI = 1, NO = 0).<br><br>

  <font color="red"><label> NOTA:</label></font><br>
  a) El Archivo no debe de tener cabecera, solo deben estar los registros a grabar.<br>
  b) Se debe de guardar como archivo .CSV  (delimitado por comas)(*.csv).<br>
  c) Todos los datos deberán escribirse en mayúscula para mejor orden y visibilidad en los reportes.<br>
  d) Deben de tener en cuenta que la carga masiva de Productos, deben de ser cargados como se explica, para evitar problemas de datos del productos dentro del Sistema.<br><br>
    </div>
</div>                                 
<?php 
  }
######################## MUESTRA DIV PRODUCTO ########################
?>

<?php
######################## MOSTRAR PRODUCTOS EN VENTANA MODAL ########################
if (isset($_GET['BuscaProductoModal']) && isset($_GET['codproducto'])) { 

$reg = $new->ProductosPorId(); 

$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 
?>
  
  <table class="table-responsive" border="0" class="text-center">
  <tr>
    <td><strong>Código:</strong> <?php echo $reg[0]['codproducto']; ?></td>
  </tr>
  <tr>
    <td><strong>Producto:</strong> <?php echo $reg[0]['producto']; ?></td>
  </tr> 
  <tr>
  <td><strong>Proveedor: </strong><?php echo $reg[0]['codproveedor'] == '0' ? "*********" : $reg[0]['cuitproveedor'].": ".$reg[0]['nomproveedor']; ?></td>
  </tr> 
  <tr>
    <td><strong>Categoria:</strong> <?php echo $reg[0]['nomcategoria']; ?></td>
  </tr>
  <tr>
    <td><strong>Precio de Compra: </strong> <?php echo $preciocompra = ($_SESSION['acceso'] == "cajero" || $_SESSION["acceso"]=="cocinero" ? "**********" : $simbolo.number_format($reg[0]['preciocompra'], 2, '.', ',')); ?></td>
  </tr> 
  <tr>
    <td><strong>Precio de Venta: </strong> <?php echo $simbolo.number_format($reg[0]['precioventa'], 2, '.', ','); ?></td>
  </tr>
<?php if($cambio!=""){ ?>
  <tr>
    <td><strong><?php echo $cambio == '' ? "**********" : "Precio ".$cambio[0]['siglas']; ?>: </strong> 
      <?php echo $cambio == '' ? "**********" : "<label>".$cambio[0]['simbolo']."</label> ".number_format($reg[0]['precioventa']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
  </tr> 
<?php } ?>
  <tr>
    <td><strong>Existencia: </strong> <?php echo number_format($reg[0]['existencia'], 2, '.', ','); ?></td>
  </tr> 
  <tr>
    <td><strong>Stock Minimo: </strong> <?php echo $reg[0]['stockminimo'] == '0.00' ? "*********" : number_format($reg[0]['stockminimo'], 2, '.', ','); ?></td>
  </tr> 
  <tr>
    <td><strong>Stock Máximo: </strong> <?php echo $reg[0]['stockmaximo'] == '0.00' ? "*********" : number_format($reg[0]['stockmaximo'], 2, '.', ','); ?></td>
  </tr> 
  <tr>
    <td><strong><?php echo $impuesto; ?>: </strong> <?php echo $reg[0]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
  </tr> 
  <tr>
    <td><strong>Descuento: </strong> <?php echo number_format($reg[0]['descproducto'], 2, '.', ',')."%"; ?></td>
  </tr> 
  <tr>
  <td><strong>Código de Barra: </strong> <?php echo $reg[0]['codigobarra'] == '0' ? "*********" : $reg[0]['codigobarra']; ?></td>
  </tr> 
  <tr>
    <td><strong>Nº de Lote: </strong> <?php echo $reg[0]['lote'] == '0' ? "*********" : $reg[0]['lote']; ?></td>
  </tr> 
  <tr>
    <td><strong>Fecha de Elaboración: </strong> <?php echo $reg[0]['fechaelaboracion'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[0]['fechaelaboracion'])); ?></td>
  </tr> 
  <tr>
    <td><strong>Fecha de Expiración: </strong> <?php echo $reg[0]['fechaexpiracion'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[0]['fechaexpiracion'])); ?></td>
  </tr>
  <tr>
    <td><strong>Status: </strong> <?php echo $status = ( $reg[0]['existencia'] != 0 ? "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='badge badge-pill badge-warning'><i class='fa fa-times'></i> INACTIVO</span>"); ?></td>
  </tr>
    <tr>
    <td><strong>Favorito: </strong> <?php echo $status = ( $reg[0]['favorito'] == 1 ? "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> SI</span>" : "<span class='badge badge-pill badge-warning'><i class='fa fa-times'></i> NO</span>"); ?></td>  
    </tr>
    <tr>
    <td><strong>Control de Stock: </strong> <?php echo $control = ( $reg[0]['controlstockp'] == 1 ? "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> SI</span>" : "<span class='badge badge-pill badge-warning'><i class='fa fa-times'></i> NO</span>"); ?></td>  
    </tr>
</table>

<?php 
$tru = new Login();
$a=1;
$busq = $tru->VerDetallesIngredientes(); 

if($busq==""){

    echo "";      
    
} else {

?>
<div id="div1">
  <table id="default_order" class="table2 table-striped table-bordered border display m-t-10">
          <thead>
          <tr>
        <th colspan="6" data-priority="1"><center>Ingredientes Agregados</center></th>
          </tr>
          <tr>
            <th>Nº</th>
            <th>Ingrediente</th>
            <th>Medida</th>
            <th>Existencia</th>
            <th>Cant. Ración</th>
            <th>P.V.P</th>
          </tr>
          </thead>
            <tbody>
<?php 
$TotalCosto=0;
for($i=0;$i<sizeof($busq);$i++){
$TotalCosto+=($busq[$i]['precioventa']-$busq[$i]['descingrediente']/100)*$busq[$i]["cantracion"];
?>
          <tr>
            <th><?php echo $a++; ?></th>
<td><?php echo $busq[$i]["nomingrediente"]; ?></td>
<td><?php echo $busq[$i]["nommedida"]; ?></td>
<td><?php echo number_format($busq[$i]["cantingrediente"], 2, '.', ','); ?></td>
<td><?php echo number_format($busq[$i]["cantracion"], 2, '.', ','); ?></td>
<td><?php echo number_format($busq[$i]["precioventa"], 2, '.', ','); ?></td>
          </tr> 
            <?php } ?> 
          <tr>
          <td colspan="4"></td>
          <td><label>Total Gasto</label></td>
          <td><label><?php echo $simbolo.number_format($TotalCosto, 2, '.', ','); ?></label></td>
          </tr>
         </tbody>
        </table>
        </div>
<?php  
    }
} 
######################## MOSTRAR PRODUCTOS EN VENTANA MODAL ########################
?>

<?php 
######################## BUSQUEDA DE PRODUCTOS VENDIDOS ########################
if (isset($_GET['BuscaProductosVendidos']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarProductosVendidos();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Productos Vendidos por Fecha Desde <?php echo date("d-m-Y", strtotime($desde)); ?> Hasta <?php echo date("d-m-Y", strtotime($hasta)); ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("PRODUCTOSVENDIDOS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOSVENDIDOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRODUCTOSVENDIDOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>Código</th>
                                  <th>Descripción de Producto</th>
                                  <th>Categoria</th>
                                  <th>Desc</th>
                                  <th>Precio de Venta</th>
                                  <th>Existencia</th>
                                  <th>Vendido</th>
                                  <th>Monto Total</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                      <td><?php echo $a++; ?></div></td>
                      <td><?php echo $reg[$i]['codproducto']; ?></td>
                      <td><?php echo $reg[$i]['producto']; ?></td>
                      <td><?php echo $reg[$i]['nomcategoria']; ?></td>
                      <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
                      <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
                      <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
                      <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
                      <td><?php echo $simbolo.number_format($reg[$i]['precioventa']*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
                                </tr>
                        <?php  }  ?>
                      <tr>
                        <td colspan="5"></td>
                        <td><label><?php echo $simbolo.number_format($precioTotal, 2, '.', ','); ?></label></td>
                        <td><label><?php echo number_format($existeTotal, 2, '.', ','); ?></label></td>
                        <td><label><?php echo number_format($vendidosTotal, 2, '.', ','); ?></label></td>
                        <td><label><?php echo $simbolo.number_format($pagoTotal, 2, '.', ','); ?></label></td>
                      </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
######################## BUSQUEDA DE PRODUCTOS VENDIDOS ########################
?>

<?php 
######################## BUSQUEDA DE PRODUCTOS POR MONEDA ########################
if (isset($_GET['BuscaProductosxMoneda']) && isset($_GET['codmoneda'])) { 

  $codmoneda = limpiar($_GET['codmoneda']);

  if($codmoneda=="") { 

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE TIPO DE MONEDA PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
   } else {

$cambio = new Login();
$cambio = $cambio->BuscarTiposCambios();
  
$reg = $new->ListarProductos();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Productos al Cambio de <?php echo $cambio[0]['moneda']." (".$cambio[0]['siglas'].")"; ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codmoneda=<?php echo $codmoneda; ?>&tipo=<?php echo encrypt("PRODUCTOSXMONEDA") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codmoneda=<?php echo $codmoneda; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOSXMONEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codmoneda=<?php echo $codmoneda; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRODUCTOSXMONEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

              </div>
            </div>
          </div>

          <div id="div3"><table id="datatable-responsive" class="table2 table-hover table-nomargin table-bordered dataTable table-striped" cellspacing="0" width="100%">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Img</th>
                                                    <th>Código</th>
                                                    <th>Nombre de Producto</th>
                                                    <th>Categoria</th>
                                                    <th>Precio Venta</th>
                                                    <th><?php echo $cambio[0]['siglas']; ?></th>
                                                    <th>Existencia</th>
                                                    <th><?php echo $impuesto; ?></th>
                                                    <th>Descuento</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 

if($reg==""){ 

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
<td><a href="#" data-placement="left" title="Ver Imagen" data-original-title="" data-href="#" data-toggle="modal" data-target=".bs-example-modal-sm" data-backdrop="static" data-keyboard="false" onClick="VerImagen('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]['codsucursal']) ?>')"><?php if (file_exists("fotos/productos/".$reg[$i]["codproducto"].".jpg")){
    echo "<img src='fotos/productos/".$reg[$i]["codproducto"].".jpg?' class='img-rounded' style='margin:0px;' width='50' height='45'>"; 
}else{
   echo "<img src='fotos/producto.png' class='img-rounded' style='margin:0px;' width='50' height='45'>";  
} 
     ?></a></td>
                                               <td><?php echo $reg[$i]['codproducto']; ?></td>
                                               <td><?php echo $reg[$i]['producto']; ?></td>
                                               <td><?php echo $reg[$i]['nomcategoria']; ?></td>
                                              <td><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
                                              <td><?php echo "<label>".$cambio[0]['simbolo']."</label> ".number_format($reg[$i]['precioventa']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
                                               <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
                                               <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
                                               <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table>
                         </div>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
######################## BUSQUEDA DE PRODUCTOS POR MONEDA ##########################
?>


<?php 
######################## BUSQUEDA DE KARDEX POR PRODUCTOS ########################
if (isset($_GET['BuscaKardexProducto']) && isset($_GET['codproducto'])) { 

$codproducto = limpiar($_GET['codproducto']); 

  if($codproducto=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL PRODUCTO CORRECTAMENTE</center>";
  echo "</div>";
  exit;
   
   } else {
  
$kardex = new Login();
$kardex = $kardex->BuscarKardexProducto();  
?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Movimientos del Producto <?php echo $kardex[0]['codproducto'].": ".$kardex[0]['producto']; ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codproducto=<?php echo $codproducto; ?>&tipo=<?php echo encrypt("KARDEXPRODUCTOS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codproducto=<?php echo $codproducto; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("KARDEXPRODUCTOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codproducto=<?php echo $codproducto; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("KARDEXPRODUCTOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

              </div>
            </div>
          </div>

          <div id="div3"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                                  <th>Nº</th>
                                  <th>Movimiento</th>
                                  <th>Entradas</th>
                                  <th>Salidas</th>
                                  <th>Devolución</th>
                                  <th>Precio Costo</th>
                                  <th>Costo Movimiento</th>
                                  <th>Stock Actual</th>
                                  <th>Documento</th>
                                  <th>Fecha de Kardex</th>
                              </tr>
                              </thead>
                              <tbody>
<?php
$TotalEntradas=0;
$TotalSalidas=0;
$TotalDevolucion=0;
$a=1;
for($i=0;$i<sizeof($kardex);$i++){ 
$TotalEntradas+=$kardex[$i]['entradas'];
$TotalSalidas+=$kardex[$i]['salidas'];
$TotalDevolucion+=$kardex[$i]['devolucion'];
?>
                              <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $kardex[$i]['movimiento']; ?></td>
                                  <td><?php echo number_format($kardex[$i]['entradas'], 2, '.', ','); ?></td>
                                  <td><?php echo number_format($kardex[$i]['salidas'], 2, '.', ','); ?></td>
                                  <td><?php echo number_format($kardex[$i]['devolucion'], 2, '.', ','); ?></td>
                                  <td><?php echo $simbolo.number_format($kardex[$i]['precio'], 2, '.', ','); ?></td>
                          <?php if($kardex[$i]["movimiento"]=="ENTRADAS"){ ?>
        <td><?php echo number_format($kardex[$i]['precio']*$kardex[$i]['entradas'], 2, '.', ','); ?></td>
                          <?php } elseif($kardex[$i]["movimiento"]=="SALIDAS"){ ?>
        <td><?php echo number_format($kardex[$i]['precio']*$kardex[$i]['salidas'], 2, '.', ','); ?></td>
                          <?php } else { ?>
        <td><?php echo number_format($kardex[$i]['precio']*$kardex[$i]['devolucion'], 2, '.', ','); ?></td>
                          <?php } ?>
                                  <td><?php echo number_format($kardex[$i]['stockactual'], 2, '.', ','); ?></td>
                                  <td><?php echo $kardex[$i]['documento']." ".$num = ($kardex[$i]['documento'] == 'VENTA' || $kardex[$i]['documento'] == 'DEVOLUCION' ? $kardex[$i]['codproceso'] : ""); ?></td>
                                  <td><?php echo date("d-m-Y",strtotime($kardex[$i]['fechakardex'])); ?></td>
                              </tr>
                        <?php  }  ?>
                              </tbody>
                          </table>
                        
          <label>Detalles de Producto</label><br>
          <label>Código:</label> <?php echo $kardex[0]['codproducto']; ?><br>
          <label>Descripción:</label> <?php echo $kardex[0]['producto']; ?><br>
          <label>Categoria:</label> <?php echo $kardex[0]['nomcategoria']; ?><br>
          <label>Total Entradas:</label> <?php echo number_format($TotalEntradas, 2, '.', ','); ?><br>
          <label>Total Salidas:</label> <?php echo number_format($TotalSalidas, 2, '.', ','); ?><br>
          <label>Total Devolución:</label> <?php echo number_format($TotalDevolucion, 2, '.', ','); ?><br>
          <label>Existencia:</label> <?php echo number_format($kardex[0]['existencia'], 2, '.', ','); ?><br>
          <label>Precio Compra:</label> <?php echo $simbolo." ".number_format($kardex[0]['preciocompra'], 2, '.', ','); ?><br>
          <label>Precio Venta:</label> <?php echo $simbolo." ".number_format($kardex[0]['precioventa'], 2, '.', ','); ?>
            </div>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
######################## BUSQUEDA DE KARDEX POR PRODUCTOS ########################
?>

<?php 
########################### BUSQUEDA KARDEX PRODUCTOS VALORIZADO POR FECHAS ##########################
if (isset($_GET['BuscaKardexProductosxFechas']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
  if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarKardexProductosValorizadoxFechas();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Kardex Valorizado por Fecha Desde <?php echo date("d-m-Y", strtotime($desde)); ?> Hasta <?php echo date("d-m-Y", strtotime($hasta)); ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("KARDEXPRODUCTOSVALORIZADOXFECHAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("KARDEXPRODUCTOSVALORIZADOXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("KARDEXPRODUCTOSVALORIZADOXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr role="row">
                                  <th>Nº</th>
                                  <th>Código</th>
                                  <th>Descripción de Producto</th>
                                  <th>Categoria</th>
                                  <th>Desc</th>
                                  <th>Precio de Venta</th>
                                  <th>Existencia</th>
                                  <th>Vendido</th>
                                  <th>Total Venta</th>
                                  <th>Total Compra</th>
                                  <th>Ganancias</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr role="row" class="odd">
                      <td><?php echo $a++; ?></div></td>
                      <td><?php echo $reg[$i]['codproducto']; ?></td>
                      <td><?php echo $reg[$i]['producto']; ?></td>
                      <td><?php echo $reg[$i]['codcategoria'] == '' ? "*****" : $reg[$i]['nomcategoria']; ?></td>
                      <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
                      <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
                      <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
                      <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
                      <td><?php echo $simbolo.number_format($reg[$i]['precioventa']*$reg[$i]['cantidad']-$reg[$i]['descproducto']/100, 2, '.', ','); ?></td>
                      <td><?php echo $simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
                      <td><?php echo $simbolo.number_format($sumventa-$sumcompra, 2, '.', ','); ?></td>
                                </tr>
                        <?php  }  ?>
                      <tr>
                        <td colspan="5"></td>
                        <td><label><?php echo $simbolo.number_format($precioTotal, 2, '.', ','); ?></label></td>
                        <td><label><?php echo number_format($existeTotal, 2, '.', ','); ?></label></td>
                        <td><label><?php echo number_format($vendidosTotal, 2, '.', ','); ?></label></td>
                        <td><label><?php echo $simbolo.number_format($pagoTotal, 2, '.', ','); ?></label></td>
                        <td><label><?php echo $simbolo.number_format($compraTotal, 2, '.', ','); ?></label></td>
                        <td><label><?php echo $simbolo.number_format($TotalGanancia, 2, '.', ','); ?></label></td>
                      </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
########################### BUSQUEDA KARDEX PRODUCTOS VALORIZADO POR FECHAS ##########################
?>

<?php 
######################## BUSQUEDA DE PRODUCTOS PARA MENU ########################
if (isset($_GET['Buscar_Menu'])) { 

$reg = $new->ListarProductosMenu(); 
?>
<div id="div2">

<?php
$a=1;
for($cont = 0, $s = sizeof($reg); $cont < $s; $cont++):
?>

<div class="table-responsive">
  <table class="table">
    <thead class="bg-danger text-white">
      <tr>
        <th colspan="2"><i class="fa fa-tasks"></i> <?php echo $reg[$cont]["nomcategoria"]; ?></th>
      </tr>

<?php
$a=1;
$explode = explode("<br>",$reg[$cont]['menu']);

for($aum = 0, $r = sizeof($explode); $aum < $r; $aum++):
list($codproducto,$producto,$preciocompra,$precioventa,$existencia) = explode("|",$explode[$aum]);
?>      
    </thead>
    <tbody>
      <tr class="table2">
        <td width="80%"><?php echo $producto; ?></td>
        <td width="20%"><?php echo $simbolo.$precioventa; ?></td>
      </tr>

<?php 
endfor; ##fin de for 
?>
    </tbody>
  </table>
</div>

<?php
  endfor; ##fin de for
?>

<div class="table-responsive">
  <table class="table">
    <thead class="bg-danger text-white">
      <tr>
        <th colspan="3"><i class="fa fa-tasks"></i> COMBOS</th>
      </tr>

<?php
$tra2 = new Login();
$combo = $tra2->ListarCombosMenu();

$a=1;
for($contt = 0, $ss = sizeof($combo); $contt < $ss; $contt++):
?>      
    </thead>
    <tbody>
      <tr class="table2">
        <td width="30%"><?php echo $combo[$contt]["nomcombo"]; ?></td>
        <td class="font-12" width="50%"><?php echo $combo[$contt]["detalles_productos"]; ?></td>
        <td width="20%"><?php echo $simbolo.$combo[$contt]["precioventa"]; ?></td>
      </tr>

<?php 
endfor; ##fin de for 
?>
    </tbody>
  </table>
</div>

</div>

<?php
}
######################## BUSQUEDA DE PRODUCTOS PARA MENU ##########################
?>



























<?php
######################## MOSTRAR COMBOS EN VENTANA MODAL ########################
if (isset($_GET['BuscaComboModal']) && isset($_GET['codcombo'])) { 

$reg = $new->CombosPorId(); 

$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 
?>
  
  <table class="table-responsive" border="0" align="center">
  <tr>
    <td><strong>Código:</strong> <?php echo $reg[0]['codcombo']; ?></td>
  </tr>
  <tr>
    <td><strong>Nombre de Combo:</strong> <?php echo $reg[0]['nomcombo']; ?></td>
  </tr> 
  <tr>
    <td><strong>Precio de Compra: </strong> <?php echo $preciocompra = ($_SESSION['acceso'] == "cajero" || $_SESSION["acceso"]=="cocinero" ? "**********" : $simbolo.number_format($reg[0]['preciocompra'], 2, '.', ',')); ?></td>
  </tr> 
  <tr>
    <td><strong>Precio de Venta: </strong> <?php echo $simbolo.number_format($reg[0]['precioventa'], 2, '.', ','); ?></td>
  </tr>
<?php if($cambio){ ?>
  <tr>
    <td><strong><?php echo $cambio == '' ? "**********" : "Precio ".$cambio[0]['siglas']; ?>: </strong> 
      <?php echo $cambio == '' ? "**********" : "<label>".$cambio[0]['simbolo']."</label> ".number_format($reg[0]['precioventa']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
  </tr> 
<?php } ?>
  <tr>
    <td><strong>Existencia: </strong> <?php echo number_format($reg[0]['existencia'], 2, '.', ','); ?></td>
  </tr> 
  <tr>
    <td><strong>Stock Minimo: </strong> <?php echo $reg[0]['stockminimo'] == '0.00' ? "*********" : number_format($reg[0]['stockminimo'], 2, '.', ','); ?></td>
  </tr> 
  <tr>
    <td><strong>Stock Máximo: </strong> <?php echo $reg[0]['stockmaximo'] == '0.00' ? "*********" : number_format($reg[0]['stockmaximo'], 2, '.', ','); ?></td>
  </tr> 
  <tr>
    <td><strong><?php echo $impuesto; ?>: </strong> <?php echo $reg[0]['ivacombo'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
  </tr> 
  <tr>
    <td><strong>Descuento: </strong> <?php echo number_format($reg[0]['desccombo'], 2, '.', ',')."%"; ?></td>
  </tr> 
  <tr>
    <td><strong>Status: </strong> <?php echo $status = ( $reg[0]['existencia'] != 0 ? "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='badge badge-pill badge-warning'><i class='fa fa-times'></i> INACTIVO</span>"); ?></td>
  </tr>
</table>


<?php 
$tru = new Login();
$a=1;
$busq = $tru->VerDetallesProductos(); 

if($busq==""){

    echo "";      
    
} else {

?>
<div id="div1">
  <table id="default_order" class="table2 table-striped table-bordered border display m-t-10">
          <thead>
          <tr>
        <th colspan="6" data-priority="1"><center>Productos Agregados</center></th>
          </tr>
          <tr>
            <th>Nº</th>
            <th>Producto</th>
            <th>Categoria</th>
            <th>Existencia</th>
            <th>Cantidad</th>
            <th>P.V.P</th>
          </tr>
          </thead>
            <tbody>
<?php 
$TotalCosto=0;
for($i=0;$i<sizeof($busq);$i++){
$TotalCosto+=($busq[$i]['precioventa']-$busq[$i]['descproducto']/100)*$busq[$i]["cantidad"];
?>
          <tr>
            <th><?php echo $a++; ?></th>
<td><?php echo $busq[$i]["producto"]; ?></td>
<td><?php echo $busq[$i]["nomcategoria"]; ?></td>
<td><?php echo number_format($busq[$i]["existencia"], 2, '.', ','); ?></td>
<td><?php echo number_format($busq[$i]["cantidad"], 2, '.', ','); ?></td>
<td><?php echo number_format($busq[$i]["precioventa"], 2, '.', ','); ?></td>
          </tr> 
            <?php } ?> 
          <tr>
          <td colspan="4"></td>
          <td><label>Total Gasto</label></td>
          <td><label><?php echo $simbolo.number_format($TotalCosto, 2, '.', ','); ?></label></td>
          </tr>
         </tbody>
        </table>
        </div>
<?php  
    }
} 
######################## MOSTRAR COMBOS EN VENTANA MODAL ########################
?>


<?php 
######################## MUESTRA PRODUCTOS AGREGADOS A COMBOS ########################
if (isset($_GET['BuscaProductosNuevo']) && isset($_GET['codcombo'])) { 

$new = new Login();
$reg = $new->CombosPorId();   
?>
<div class="row">
            <div class="col-md-3">
                <div class="form-group has-feedback">
                <label class="control-label">Código de Combo: <span class="symbol required"></span></label>
                <input type="hidden" name="proceso" id="proceso" value="save"/>
                <input type="hidden" name="codcombo" id="codcombo" value="<?php echo $reg[0]['codcombo']; ?>"/>
                <input type="hidden" name="preciocompra" id="preciocompra" value="<?php echo $reg[0]['preciocompra']; ?>"/>
                <input type="hidden" name="precioventa" id="precioventa" value="<?php echo $reg[0]['precioventa']; ?>"/>
                <input type="hidden" name="combo" id="combo" value="<?php echo encrypt($reg[0]['codcombo']); ?>">
                    <br /><abbr title="Código de Producto"><?php echo $reg[0]['codproducto']; ?></abbr>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Nombre de Combo: <span class="symbol required"></span></label>
                    <br /><abbr title="Nombre de Combo"><?php echo $reg[0]['nomcombo']; ?></abbr>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Existencia: <span class="symbol required"></span></label>
                    <br /><abbr title="Existencia de Combo"><?php echo number_format($reg[0]['existencia'], 2, '.', ','); ?></abbr>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Precio de Compra: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="preciocomprabd" id="preciocomprabd" value="<?php echo $reg[0]['preciocompra']; ?>"/>
                    <br /><abbr title="Precio de Compra"><label id="lblcompra" name="lblcompra"><?php echo number_format($reg[0]['preciocompra'], 2, '.', ','); ?></label></abbr>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Precio de Venta: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="precioventabd" id="precioventabd" value="<?php echo $reg[0]['precioventa']; ?>"/>
                    <br /><abbr title="Precio de Venta"><label id="lblventa" name="lblventa"><?php echo number_format($reg[0]['precioventa'], 2, '.', ','); ?></label></abbr>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label"><?php echo $impuesto; ?> de Combo: <span class="symbol required"></span></label>
                    <br /><abbr title="Impuesto de Producto"><?php echo $reg[0]['ivacombo'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></abbr>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Descuento de Combo: <span class="symbol required"></span></label>
                    <br /><abbr title="Descuento de Combo"><?php echo number_format($reg[0]['desccombo'], 0, '.', ','); ?></abbr>
                </div>
            </div>
        </div>

<h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cart-plus"></i> Productos Agregados</h2><br>

<table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
              <thead>
              <tr role="row">
              </tr>
                                <tr>
                                <th>Nº</th>
                                <th>Cantidad</th>
                                <th>Producto</th>
                                <th>Existencia</th>
                                <th>Precio Compra</th>
                                <th>Precio Venta</th>
                                <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                            </thead>
                                <tbody>
<?php 
$tru = new Login();
$a=1;
$busq = $tru->VerDetallesProductos();

if($busq==""){

echo "";      

} else {

$count = 0;
for($i=0;$i<sizeof($busq);$i++){
$count++; 
?>
                <tr>
<td><?php echo $a++; ?></td>
<td><input type="text" class="form-control" name="cantidad[]" id="cantidad_<?php echo $count; ?>" style="width: 80px;background:#e4e7ea;border-radius:5px 5px 5px 5px;" onfocus="this.style.background=('#B7F0FF')" onfocus="this.style.background=('#B7F0FF')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e4e7ea');" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoProducto(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" value="<?php echo $busq[$i]["cantidad"]; ?>" title="Ingrese Cantidad" required="" aria-required="true">
</td>
<td>
<input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $busq[$i]["codproducto"]; ?>">
<input type="hidden" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" value="<?php echo $busq[$i]["preciocompra"]; ?>">
<input type="hidden" name="precioventa[]" id="precioventa_<?php echo $count; ?>" value="<?php echo $busq[$i]["precioventa"]; ?>">
<input type="hidden" class="preciocompra" name="montocompra[]" id="montocompra_<?php echo $count; ?>" value="<?php echo number_format($busq[$i]["cantidad"]*$busq[$i]["preciocompra"], 2, '.', ''); ?>">
<input type="hidden" class="precioventa" name="montoventa[]" id="montoventa_<?php echo $count; ?>" value="<?php echo number_format($busq[$i]["cantidad"]*$busq[$i]["precioventa"], 2, '.', ''); ?>">
<?php echo $busq[$i]["producto"]; ?>
</td>
<td><?php echo $busq[$i]["existencia"]." ".$busq[$i]["nomcategoria"]; ?></td>
<td><?php echo number_format($busq[$i]["cantidad"]*$busq[$i]["preciocompra"], 2, '.', ','); ?></td>
<td><?php echo number_format($busq[$i]["cantidad"]*$busq[$i]["precioventa"], 2, '.', ','); ?></td>
<td><button type="button" class="btn btn-dark btn-rounded" onClick="EliminaDetalleProductoNuevo('<?php echo encrypt($busq[$i]['codcombo']) ?>','<?php echo encrypt($busq[$i]['codproducto']) ?>','<?php echo encrypt($busq[$i]['cantidad']) ?>','<?php echo encrypt("ELIMINADETALLEPRODUCTO") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td>
                </tr><?php } } ?>
              </tbody>
        </table>

<?php 
}
######################## MUESTRA PRODUCTOS AGREGADOS A COMBOS ########################
?>


<?php 
######################## MUESTRA PRODUCTOS AGREGADOS A COMBOS ########################
if (isset($_GET['BuscaProductosAgregados']) && isset($_GET['codcombo'])) { 
$new = new Login();
$reg = $new->CombosPorId();   
?>
<div class="row">
            <div class="col-md-3">
                <div class="form-group has-feedback">
                <label class="control-label">Código de Combo: <span class="symbol required"></span></label>
                <input type="hidden" name="proceso" id="proceso" value="save"/>
                <input type="hidden" name="codcombo" id="codcombo" value="<?php echo $reg[0]['codcombo']; ?>"/>
                <input type="hidden" name="preciocompra" id="preciocompra" value="0.00"/>
                <input type="hidden" name="precioventa" id="precioventa" value="0.00"/>
                <input type="hidden" name="combo" id="combo" value="<?php echo encrypt($reg[0]['codcombo']); ?>">
                    <br /><abbr title="Código de Combo"><?php echo $reg[0]['codcombo']; ?></abbr>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Nombre de Combo: <span class="symbol required"></span></label>
                    <br /><abbr title="Nombre de Combo"><?php echo $reg[0]['nomcombo']; ?></abbr>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Existencia: <span class="symbol required"></span></label>
                    <br /><abbr title="Existencia de Combo"><?php echo number_format($reg[0]['existencia'], 2, '.', ','); ?></abbr>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Precio de Compra: <span class="symbol required"></span></label>
                    <input type="hidden" name="preciocomprabd" id="preciocomprabd" value="<?php echo $reg[0]['preciocompra']; ?>"/>
                    <br /><abbr title="Precio de Compra"><?php echo number_format($reg[0]['preciocompra'], 2, '.', ','); ?></abbr>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Precio de Venta: <span class="symbol required"></span></label>
                    <input type="hidden" name="precioventabd" id="precioventabd" value="<?php echo $reg[0]['precioventa']; ?>"/>
                    <br /><abbr title="Precio de Venta"><?php echo number_format($reg[0]['precioventa'], 2, '.', ','); ?></abbr>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label"><?php echo $impuesto; ?> de codcombo: <span class="symbol required"></span></label>
                    <br /><abbr title="Impuesto de Combo"><?php echo $reg[0]['ivacombo'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></abbr>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Descuento de Combo: <span class="symbol required"></span></label>
                    <br /><abbr title="Descuento de Combo"><?php echo number_format($reg[0]['desccombo'], 2, '.', ','); ?></abbr>
                </div>
            </div>
        </div>

<h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cart-plus"></i> Productos Agregados</h2><br>

<table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
              <thead>
              <tr role="row">
              </tr>
                                <tr>
                                <th>Nº</th>
                                <th>Cantidad</th>
                                <th>Producto</th>
                                <th>Existencia</th>
                                <th>Precio Compra</th>
                                <th>Precio Venta</th>
                                <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                            </thead>
                                <tbody>
<?php 
$tru = new Login();
$a=1;
$busq = $tru->VerDetallesProductos();

if($busq==""){

echo "";      

} else {

for($i=0;$i<sizeof($busq);$i++){
?>
                <tr>
<td><?php echo $a++; ?></td>
<td><?php echo $busq[$i]["cantidad"]; ?></td>
<td><?php echo $busq[$i]["producto"]; ?></td>
<td><?php echo number_format($busq[$i]["existencia"], 2, '.', ','); ?></td>
<td><?php echo number_format($busq[$i]["preciocompra"], 2, '.', ','); ?></td>
<td><?php echo number_format($busq[$i]["precioventa"], 2, '.', ','); ?></td>
<td><button type="button" class="btn btn-dark btn-rounded" onClick="EliminaDetalleProductoAgregado('<?php echo encrypt($busq[$i]['codcombo']) ?>','<?php echo encrypt($busq[$i]['codproducto']) ?>','<?php echo encrypt($busq[$i]['cantidad']) ?>','<?php echo encrypt("ELIMINADETALLEPRODUCTO") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td>
                </tr><?php } } ?>
              </tbody>
        </table>

<?php 
}
######################## MUESTRA PRODUCTOS AGREGADOS A COMBOS ########################
?>

<?php 
######################## BUSQUEDA DE COMBOS VENDIDOS ########################
if (isset($_GET['BuscaCombosVendidos']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarCombosVendidos();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Combos Vendidos por Fecha Desde <?php echo date("d-m-Y", strtotime($desde)); ?> Hasta <?php echo date("d-m-Y", strtotime($hasta)); ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("COMBOSVENDIDOS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COMBOSVENDIDOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COMBOSVENDIDOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

          <div id="div2"><table id="datatable-scroller" class="table table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>Código</th>
                                  <th>Descripción de Combo</th>
                                  <th>Desc</th>
                                  <th>Precio de Venta</th>
                                  <th>Existencia</th>
                                  <th>Vendido</th>
                                  <th>Monto Total</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                      <td><?php echo $a++; ?></div></td>
                      <td><?php echo $reg[$i]['codproducto']; ?></td>
                      <td><?php echo $reg[$i]['producto']; ?></td>
                      <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
                      <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
                      <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
                      <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
                      <td><?php echo $simbolo.number_format($reg[$i]['precioventa']*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
                                </tr>
                        <?php  }  ?>
                      <tr>
                        <td colspan="4"></td>
                        <td><label><?php echo $simbolo.number_format($precioTotal, 2, '.', ','); ?></label></td>
                        <td><label><?php echo number_format($existeTotal, 2, '.', ','); ?></label></td>
                        <td><label><?php echo number_format($vendidosTotal, 2, '.', ','); ?></label></td>
                        <td><label><?php echo $simbolo.number_format($pagoTotal, 2, '.', ','); ?></label></td>
                      </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
######################## BUSQUEDA DE COMBOS VENDIDOS ########################
?>

<?php 
######################## BUSQUEDA DE COMBOS POR MONEDA ########################
if (isset($_GET['BuscaCombosxMoneda']) && isset($_GET['codmoneda'])) { 

  $codmoneda = limpiar($_GET['codmoneda']);

  if($codmoneda=="") { 

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE TIPO DE MONEDA PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
   } else {

$cambio = new Login();
$cambio = $cambio->BuscarTiposCambios();
  
$reg = $new->ListarCombos();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Combos al Cambio de <?php echo $cambio[0]['moneda']." (".$cambio[0]['siglas'].")"; ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codmoneda=<?php echo $codmoneda; ?>&tipo=<?php echo encrypt("COMBOSXMONEDA") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codmoneda=<?php echo $codmoneda; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COMBOSXMONEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codmoneda=<?php echo $codmoneda; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COMBOSXMONEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

              </div>
            </div>
          </div>

          <div id="div3"><table id="datatable-responsive" class="table table-hover table-nomargin table-bordered dataTable table-striped" cellspacing="0" width="100%">
                                          <thead>
                                          <tr role="row">
                                            <th>N°</th>
                                            <th>Img</th>
                                            <th>Código</th>
                                            <th>Nombre de Combo</th>
                                            <th>Precio Venta</th>
                                            <th><?php echo $cambio[0]['siglas']; ?></th>
                                            <th>Existencia</th>
                                            <th><?php echo $impuesto; ?></th>
                                            <th>Descuento</th>
                                            <th>Detalles de Productos</th>
                                            </tr>
                                            </thead>
                                            <tbody class="BusquedaRapida">

<?php 

if($reg==""){ 

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                            <tr role="row" class="odd">
                            <td><?php echo $a++; ?></td>
<td><?php if (file_exists("fotos/combos/".$reg[$i]["codcombo"].".jpg")){
    echo "<img src='fotos/combos/".$reg[$i]["codcombo"].".jpg?' class='img-rounded' style='margin:0px;' width='50' height='45'>"; 
}else{
   echo "<img src='fotos/producto.png' class='img-rounded' style='margin:0px;' width='50' height='45'>";  
} 
     ?></a></td>
                        <td><?php echo $reg[$i]['codcombo']; ?></td>
                        <td><?php echo $reg[$i]['nomcombo']; ?></td>
                        <td><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
                        <td><?php echo "<label>".$cambio[0]['simbolo']."</label> ".number_format($reg[$i]['precioventa']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
                        <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
                        <td><?php echo $reg[$i]['ivacombo'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
                        <td><?php echo number_format($reg[$i]['desccombo'],2, '.', ','); ?></td>
                        <td class="font-10 bold"><?php echo $reg[$i]['detalles_productos']; ?></td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table>
                         </div>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
######################## BUSQUEDA DE COMBOS POR MONEDA ##########################
?>


<?php 
######################## BUSQUEDA DE KARDEX POR COMBOS ########################
if (isset($_GET['BuscaKardexCombo']) && isset($_GET['codcombo'])) { 

$codcombo = limpiar($_GET['codcombo']); 

  if($codcombo=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL COMBO CORRECTAMENTE</center>";
  echo "</div>";
  exit;
   
   } else {
  
$kardex = new Login();
$kardex = $kardex->BuscarKardexCombo();  
?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Movimientos del Combo <?php echo $kardex[0]['codcombo'].": ".$kardex[0]['nomcombo']; ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codcombo=<?php echo $codcombo; ?>&tipo=<?php echo encrypt("KARDEXCOMBOS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codcombo=<?php echo $codcombo; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("KARDEXCOMBOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codcombo=<?php echo $codcombo; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("KARDEXCOMBOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

              </div>
            </div>
          </div>

          <div id="div3"><table id="datatable-scroller" class="table table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                                  <th>Nº</th>
                                  <th>Movimiento</th>
                                  <th>Entradas</th>
                                  <th>Salidas</th>
                                  <th>Devolución</th>
                                  <th>Precio Costo</th>
                                  <th>Costo Movimiento</th>
                                  <th>Stock Actual</th>
                                  <th>Documento</th>
                                  <th>Fecha de Kardex</th>
                              </tr>
                              </thead>
                              <tbody>
<?php
$TotalEntradas=0;
$TotalSalidas=0;
$TotalDevolucion=0;
$a=1;
for($i=0;$i<sizeof($kardex);$i++){ 
$TotalEntradas+=$kardex[$i]['entradas'];
$TotalSalidas+=$kardex[$i]['salidas'];
$TotalDevolucion+=$kardex[$i]['devolucion'];
?>
                              <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $kardex[$i]['movimiento']; ?></td>
                                  <td><?php echo number_format($kardex[$i]['entradas'], 2, '.', ','); ?></td>
                                  <td><?php echo number_format($kardex[$i]['salidas'], 2, '.', ','); ?></td>
                                  <td><?php echo number_format($kardex[$i]['devolucion'], 2, '.', ','); ?></td>
                                  <td><?php echo $simbolo.number_format($kardex[$i]['precio'], 2, '.', ','); ?></td>
                          <?php if($kardex[$i]["movimiento"]=="ENTRADAS"){ ?>
        <td><?php echo number_format($kardex[$i]['precio']*$kardex[$i]['entradas'], 2, '.', ','); ?></td>
                          <?php } elseif($kardex[$i]["movimiento"]=="SALIDAS"){ ?>
        <td><?php echo number_format($kardex[$i]['precio']*$kardex[$i]['salidas'], 2, '.', ','); ?></td>
                          <?php } else { ?>
        <td><?php echo number_format($kardex[$i]['precio']*$kardex[$i]['devolucion'], 2, '.', ','); ?></td>
                          <?php } ?>
                                  <td><?php echo number_format($kardex[$i]['stockactual'], 2, '.', ','); ?></td>
                                  <td><?php echo $kardex[$i]['documento']." ".$num = ($kardex[$i]['documento'] == 'VENTA' || $kardex[$i]['documento'] == 'DEVOLUCION' ? $kardex[$i]['codproceso'] : ""); ?></td>
                                  <td><?php echo date("d-m-Y",strtotime($kardex[$i]['fechakardex'])); ?></td>
                              </tr>
                        <?php  }  ?>
                              </tbody>
                          </table>
                        
          <label>Detalles de Combo</label><br>
          <label>Código:</label> <?php echo $kardex[0]['codcombo']; ?><br>
          <label>Descripción:</label> <?php echo $kardex[0]['nomcombo']; ?><br>
          <label>Total Entradas:</label> <?php echo number_format($TotalEntradas, 2, '.', ','); ?><br>
          <label>Total Salidas:</label> <?php echo number_format($TotalSalidas, 2, '.', ','); ?><br>
          <label>Total Devolución:</label> <?php echo number_format($TotalDevolucion, 2, '.', ','); ?><br>
          <label>Existencia:</label> <?php echo number_format($kardex[0]['existencia'], 2, '.', ','); ?><br>
          <label>Precio Compra:</label> <?php echo $simbolo." ".number_format($kardex[0]['preciocompra'], 2, '.', ','); ?><br>
          <label>Precio Venta:</label> <?php echo $simbolo." ".number_format($kardex[0]['precioventa'], 2, '.', ','); ?>
            </div>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
######################## BUSQUEDA DE KARDEX POR COMBOS ########################
?>


<?php 
########################### BUSQUEDA KARDEX COMBOS VALORIZADO POR FECHAS ##########################
if (isset($_GET['BuscaKardexCombosxFechas']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
  if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarKardexCombosValorizadoxFechas();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Kardex de Combos Valorizado por Fecha Desde <?php echo date("d-m-Y", strtotime($desde)); ?> Hasta <?php echo date("d-m-Y", strtotime($hasta)); ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("KARDEXCOMBOSVALORIZADOXFECHAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("KARDEXCOMBOSVALORIZADOXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("KARDEXCOMBOSVALORIZADOXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr role="row">
                                  <th>Nº</th>
                                  <th>Código</th>
                                  <th>Descripción de Combo</th>
                                  <th>Desc</th>
                                  <th>Precio de Venta</th>
                                  <th>Existencia</th>
                                  <th>Vendido</th>
                                  <th>Total Venta</th>
                                  <th>Total Compra</th>
                                  <th>Ganancias</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr role="row" class="odd">
                      <td><?php echo $a++; ?></div></td>
                      <td><?php echo $reg[$i]['codproducto']; ?></td>
                      <td><?php echo $reg[$i]['producto']; ?></td>
                      <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
                      <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
                      <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
                      <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
                      <td><?php echo $simbolo.number_format($reg[$i]['precioventa']*$reg[$i]['cantidad']-$reg[$i]['descproducto']/100, 2, '.', ','); ?></td>
                      <td><?php echo $simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
                      <td><?php echo $simbolo.number_format($sumventa-$sumcompra, 2, '.', ','); ?></td>
                                </tr>
                        <?php  }  ?>
                      <tr>
                        <td colspan="4"></td>
                        <td><label><?php echo $simbolo.number_format($precioTotal, 2, '.', ','); ?></label></td>
                        <td><label><?php echo number_format($existeTotal, 2, '.', ','); ?></label></td>
                        <td><label><?php echo number_format($vendidosTotal, 2, '.', ','); ?></label></td>
                        <td><label><?php echo $simbolo.number_format($pagoTotal, 2, '.', ','); ?></label></td>
                        <td><label><?php echo $simbolo.number_format($compraTotal, 2, '.', ','); ?></label></td>
                        <td><label><?php echo $simbolo.number_format($TotalGanancia, 2, '.', ','); ?></label></td>
                      </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
########################### BUSQUEDA KARDEX PRODUCTOS VALORIZADO POR FECHAS ##########################
?>




















<?php
######################### MOSTRAR COMPRA PAGADA EN VENTANA MODAL ########################
if (isset($_GET['BuscaCompraPagadaModal']) && isset($_GET['codcompra'])) { 
 
$reg = $new->ComprasPorId();

  if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COMPRAS Y DETALLES ACTUALMENTE </center>";
    echo "</div>";    

} else {
?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-danger">RAZÓN SOCIAL</b></h4>
  <p class="text-muted m-l-5"><?php echo $con[0]['nomsucursal']; ?>,
  <br/> Nº <?php echo $con[0]['documsucursal'] == '0' ? "DOCUMENTO" : $con[0]['documento']; ?>: <?php echo $con[0]['cuit']; ?> - TLF: <?php echo $con[0]['tlfsucursal']; ?></p>

  <h4><b class="text-danger">Nº COMPRA <?php echo $reg[0]['codcompra']; ?></b></h4>
  <p class="text-muted m-l-5">STATUS: 
  <?php if($reg[0]["statuscompra"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[0]["statuscompra"]."</span>"; } 
      elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00" && $reg[0]['statuscompra'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[0]["statuscompra"]."</span>"; } ?>

  <?php if($reg[0]['fechavencecredito']!= "0000-00-00") { ?>
  <br>DIAS VENCIDOS: 
  <?php if($reg[0]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[0]['fechavencecredito'] >= date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito']); }
        elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[0]['fechapagado'],$reg[0]['fechavencecredito']); } ?>
  <?php } ?>
  
  <?php if($reg[0]['fechapagado']!= "0000-00-00") { ?>
  <br>FECHA PAGADA: <?php echo date("d-m-Y",strtotime($reg[0]['fechapagado'])); ?>
  <?php } ?>

  <br>FECHA DE EMISIÓN: <?php echo date("d-m-Y",strtotime($reg[0]['fechaemision'])); ?>
  <br/> FECHA DE RECEPCIÓN: <?php echo date("d-m-Y",strtotime($reg[0]['fecharecepcion'])); ?></p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
  <h4><b class="text-danger">PROVEEDOR</b></h4>
  <p class="text-muted m-l-30"><?php echo $reg[0]['nomproveedor'] == '' ? "**********************" : $reg[0]['nomproveedor']; ?>,
  <br/>DIREC: <?php echo $reg[0]['direcproveedor'] == '' ? "*********" : $reg[0]['direcproveedor']; ?> <?php echo $reg[0]['provincia'] == '' ? "*********" : strtoupper($reg[0]['provincia']); ?> <?php echo $reg[0]['departamento'] == '' ? "*********" : strtoupper($reg[0]['departamento']); ?>
  <br/> EMAIL: <?php echo $reg[0]['emailproveedor'] == '' ? "**********************" : $reg[0]['emailproveedor']; ?>
  <br/> Nº <?php echo $reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento']; ?>: <?php echo $reg[0]['cuitproveedor'] == '' ? "**********************" : $reg[0]['cuitproveedor']; ?> - TLF: <?php echo $reg[0]['tlfproveedor'] == '' ? "**********************" : $reg[0]['tlfproveedor']; ?>
  <br/> VENDEDOR: <?php echo $reg[0]['vendedor']; ?> - TLF: <?php echo $reg[0]['tlfvendedor'] == '' ? "**********************" : $reg[0]['tlfvendedor']; ?></p>
                                            
                                        </address>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-10" style="clear: both;">
                                        <table class="table2 table-hover">
                                            <thead>
                                                <tr>
                        <th>#</th>
                        <th class="text-left">Descripción de Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
<?php if ($_SESSION['acceso'] == "administrador") { ?><th><span class="mdi mdi-drag-horizontal"></span></th><?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesCompras();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto']; 
?>
                                                <tr>
      <td><label><?php echo $a++; ?></label></td>
      <td class="text-left"><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5>
      <small class="text-danger alert-link"><?php echo $detalle[$i]['tipoentrada'] == 'PRODUCTO' ? $detalle[$i]['nomcategoria'] : $detalle[$i]['nommedida']; ?></small></td>
      <td><?php echo $detalle[$i]['cantcompra']; ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['preciocomprac'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.$detalle[$i]['totaldescuentoc']; ?><sup><strong><?php echo $detalle[$i]['descfactura']; ?>%</strong></sup></td>
      <td><?php echo $detalle[$i]['ivaproductoc'] == 'SI' ? number_format($reg[0]['ivac'], 2, '.', '')."%" : "(E)"; ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
 <?php if ($_SESSION['acceso'] == "administrador") { ?><td>
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarDetallesComprasPagadasModal('<?php echo encrypt($detalle[$i]["coddetallecompra"]); ?>','<?php echo encrypt($detalle[$i]["codcompra"]); ?>','<?php echo encrypt($reg[0]["codproveedor"]); ?>','<?php echo encrypt("DETALLESCOMPRAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                                </tr>
                                      <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="col-md-12">

                                    <div class="pull-right text-right">
<p><b>Subtotal:</b> <?php echo $simbolo.number_format($SubTotal, 2, '.', ','); ?></p>
<p><b>Total Grabado <?php echo number_format($reg[0]['ivac'], 2, '.', ''); ?>%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivasic'], 2, '.', ','); ?></p>
<p><b>Total Exento 0%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivanoc'], 2, '.', ','); ?></p>
<p><b>Total <?php echo $impuesto; ?> (<?php echo number_format($reg[0]['ivac'], 2, '.', ''); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totalivac'], 2, '.', ','); ?> </p>
<p><b>Desc. Global (<?php echo $reg[0]['descuentoc']; ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaldescuentoc'], 2, '.', ','); ?> </p>
                                        <hr>
<h4><b>Importe Total :</b> <?php echo $simbolo.number_format($reg[0]['totalpagoc'], 2, '.', ','); ?></h4></div>
                                    <div class="clearfix"></div>
                                    <hr>
                                <div class="col-md-12">
                                    <div class="text-right">
 <a href="reportepdf?codcompra=<?php echo encrypt($reg[0]['codcompra']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA") ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn waves-light btn-light" type="button"><span><i class="fa fa-print"></i> Imprimir</span> </button></a>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                                    </div>
                                </div>
                            </div>
                <!-- .row -->

  <?php
       }
   } 
######################### MOSTRAR COMPRA PAGADA EN VENTANA MODAL ########################
?>

<?php
####################### MOSTRAR COMPRA PENDIENTE EN VENTANA MODAL #######################
if (isset($_GET['BuscaCompraPendienteModal']) && isset($_GET['codcompra'])) { 
 
$reg = $new->ComprasPorId();

  if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COMPRAS Y DETALLES ACTUALMENTE </center>";
    echo "</div>";    

} else {
?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-warning">RAZÓN SOCIAL</b></h4>
  <p class="text-muted m-l-5"><?php echo $con[0]['nomsucursal']; ?>,
  <br/> Nº <?php echo $con[0]['documsucursal'] == '0' ? "DOCUMENTO" : $con[0]['documento']; ?>: <?php echo $con[0]['cuit']; ?> - TLF: <?php echo $con[0]['tlfsucursal']; ?></p>

  <h4><b class="text-warning">Nº COMPRA <?php echo $reg[0]['codcompra']; ?></b></h4>
  <p class="text-muted m-l-5">STATUS: 
  <?php if($reg[0]["statuscompra"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[0]["statuscompra"]."</span>"; } 
      elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00" && $reg[0]['statuscompra'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[0]["statuscompra"]."</span>"; } ?>

  <?php if($reg[0]['fechavencecredito']!= "0000-00-00") { ?>
  <br>DIAS VENCIDOS: 
  <?php if($reg[0]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[0]['fechavencecredito'] >= date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito']); }
        elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[0]['fechapagado'],$reg[0]['fechavencecredito']); } ?>
  <?php } ?>
  
  <?php if($reg[0]['fechapagado']!= "0000-00-00") { ?>
  <br>FECHA PAGADA: <?php echo date("d-m-Y",strtotime($reg[0]['fechapagado'])); ?>
  <?php } ?>

  <br>FECHA DE EMISIÓN: <?php echo date("d-m-Y",strtotime($reg[0]['fechaemision'])); ?>
  <br/> FECHA DE RECEPCIÓN: <?php echo date("d-m-Y",strtotime($reg[0]['fecharecepcion'])); ?></p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
  <h4><b class="text-warning">PROVEEDOR</b></h4>
  <p class="text-muted m-l-30"><?php echo $reg[0]['nomproveedor'] == '' ? "**********************" : $reg[0]['nomproveedor']; ?>,
  <br/>DIREC: <?php echo $reg[0]['direcproveedor'] == '' ? "*********" : $reg[0]['direcproveedor']; ?> <?php echo $reg[0]['provincia'] == '' ? "*********" : strtoupper($reg[0]['provincia']); ?> <?php echo $reg[0]['departamento'] == '' ? "*********" : strtoupper($reg[0]['departamento']); ?>
  <br/> EMAIL: <?php echo $reg[0]['emailproveedor'] == '' ? "**********************" : $reg[0]['emailproveedor']; ?>
  <br/> Nº <?php echo $reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento']; ?>: <?php echo $reg[0]['cuitproveedor'] == '' ? "**********************" : $reg[0]['cuitproveedor']; ?> - TLF: <?php echo $reg[0]['tlfproveedor'] == '' ? "**********************" : $reg[0]['tlfproveedor']; ?>
  <br/> VENDEDOR: <?php echo $reg[0]['vendedor']; ?> - TLF: <?php echo $reg[0]['tlfvendedor'] == '' ? "**********************" : $reg[0]['tlfvendedor']; ?></p>
                                            
                                        </address>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-10" style="clear: both;">
                                        <table class="table2 table-hover">
                                            <thead>
                                              <tr>
                        <th>#</th>
                        <th class="text-left">Descripción de Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
<?php if ($_SESSION['acceso'] == "administrador") { ?><th><span class="mdi mdi-drag-horizontal"></span></th><?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesCompras();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto'];
?>
                                                <tr>
      <td><label><?php echo $a++; ?></label></td>
      <td class="text-left"><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5>
      <small class="text-danger alert-link"><?php echo $detalle[$i]['tipoentrada'] == 'PRODUCTO' ? $detalle[$i]['nomcategoria'] : $detalle[$i]['nommedida']; ?></small></td>
      <td><?php echo $detalle[$i]['cantcompra']; ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['preciocomprac'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.$detalle[$i]['totaldescuentoc']; ?><sup><strong><?php echo $detalle[$i]['descfactura']; ?>%</strong></sup></td>
      <td><?php echo $detalle[$i]['ivaproductoc'] == 'SI' ? number_format($reg[0]['ivac'], 2, '.', '')."%" : "(E)"; ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
 <?php if ($_SESSION['acceso'] == "administrador") { ?><td>
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarDetallesComprasPendientesModal('<?php echo encrypt($detalle[$i]["coddetallecompra"]); ?>','<?php echo encrypt($detalle[$i]["codcompra"]); ?>','<?php echo encrypt($reg[0]["codproveedor"]); ?>','<?php echo encrypt("DETALLESCOMPRAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                                </tr>
                                      <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="col-md-12">

                                    <div class="pull-right text-right">
<p><b>Subtotal:</b> <?php echo $simbolo.number_format($SubTotal, 2, '.', ','); ?></p>
<p><b>Total Grabado <?php echo number_format($reg[0]['ivac'], 2, '.', ''); ?>%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivasic'], 2, '.', ','); ?></p>
<p><b>Total Exento 0%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivanoc'], 2, '.', ','); ?></p>
<p><b>Total <?php echo $impuesto; ?> (<?php echo number_format($reg[0]['ivac'], 2, '.', ''); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totalivac'], 2, '.', ','); ?> </p>
<p><b>Descontado %:</b> <?php echo $simbolo.number_format($reg[0]['descontadoc'], 2, '.', ','); ?> </p>
<p><b>Desc. Global (<?php echo $reg[0]['descuentoc']; ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaldescuentoc'], 2, '.', ','); ?> </p>
                                        <hr>
<h4><b>Importe Total :</b> <?php echo $simbolo.number_format($reg[0]['totalpagoc'], 2, '.', ','); ?></h4></div>
                                    <div class="clearfix"></div>
                                    <hr>

                                <div class="col-md-12">
                                    <div class="text-right">
 <a href="reportepdf?codcompra=<?php echo encrypt($reg[0]['codcompra']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA") ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn waves-light btn-light" type="button"><span><i class="fa fa-print"></i> Imprimir</span></button></a>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                                    </div>
                                </div>
                            </div>
                <!-- .row -->

  <?php
       }
   } 
###################### MOSTRAR COMPRA PENDIENTE EN VENTANA MODAL #######################
?>


<?php
######################## MOSTRAR DETALLES DE COMPRAS UPDATE ############################
if (isset($_GET['MuestraDetallesComprasUpdate']) && isset($_GET['codcompra'])) { 
 
$reg = $new->ComprasPorId();

?>

<div class="table-responsive m-t-20">
            <table class="table2 table-hover">
                <thead>
                    <tr class="text-center">
                        <th>Cantidad</th>
                        <th>Código</th>
                        <th class="text-left">Descripción de Producto</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
<?php if ($_SESSION['acceso'] == "administrador") { ?><th>Acción</th><?php } ?>
                    </tr>
                </thead>
                <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesCompras();
$a=1;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){ 
$count++; 
?>
                                 <tr class="text-center">
      <td>
      <input type="text" step="0.01" min="0.50" class="form-control cantidad bold" name="cantcompra[]" id="cantcompra_<?php echo $count; ?>" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoCompra(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" value="<?php echo $detalle[$i]["cantcompra"]; ?>" style="width: 80px;background:#e4e7ea;border-radius:5px 5px 5px 5px;" onfocus="this.style.background=('#B7F0FF')" onfocus="this.style.background=('#B7F0FF')" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', ''); this.style.background=('#e4e7ea');" title="Ingrese Cantidad" required="" aria-required="true">
      <input type="hidden" name="cantidadcomprabd[]" id="cantidadcomprabd" value="<?php echo $detalle[$i]["cantcompra"]; ?>">
      <input type="hidden" name="coddetallecompra[]" id="coddetallecompra" value="<?php echo $detalle[$i]["coddetallecompra"]; ?>">
      <input type="hidden" name="tipoentrada[]" id="tipoentrada" value="<?php echo $detalle[$i]["tipoentrada"]; ?>">
      <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $detalle[$i]["codproducto"]; ?>">
      <input type="hidden" name="precioventa[]" id="precioventa" value="<?php echo number_format($detalle[$i]["precioventac"], 2, '.', ''); ?>">
      </td>

      <td><label><?php echo $detalle[$i]['codproducto']; ?></label></td>

      <td class="text-left"><label><h5><?php echo $detalle[$i]['producto']; ?></h5>
      <small class="text-danger alert-link"><?php echo $detalle[$i]['tipoentrada'] == 'PRODUCTO' ? $detalle[$i]['nomcategoria'] : $detalle[$i]['nommedida']; ?></small></label></td>
            
      <td><input type="hidden" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" value="<?php echo $detalle[$i]["preciocomprac"]; ?>"><?php echo number_format($detalle[$i]['preciocomprac'], 2, '.', ','); ?></td>

      <td><input type="hidden" name="valortotal[]" id="valortotal_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["valortotal"], 2, '.', ''); ?>"><label id="txtvalortotal_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></label></td>

      <td>
    <input type="hidden" name="descfactura[]" id="descfactura_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["descfactura"], 2, '.', ''); ?>">
    <input type="hidden" class="totaldescuentoc" name="totaldescuentoc[]" id="totaldescuentoc_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["totaldescuentoc"], 2, '.', ''); ?>">
    <label id="txtdescproducto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['totaldescuentoc'], 2, '.', ','); ?></label><sup><label><?php echo number_format($detalle[$i]['descfactura'], 2, '.', ','); ?>%</label></sup></td>

    <td><input type="hidden" name="ivaproducto[]" id="ivaproducto_<?php echo $count; ?>" value="<?php echo $detalle[$i]["ivaproductoc"]; ?>"><?php echo $detalle[$i]['ivaproductoc'] == 'SI' ? number_format($reg[0]['ivac'], 2, '.', '')."%" : "(E)"; ?></td>

    <td><input type="hidden" class="subtotalivasi" name="subtotalivasi[]" id="subtotalivasi_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproductoc'] == 'SI' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

    <input type="hidden" class="subtotalivano" name="subtotalivano[]" id="subtotalivano_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproductoc'] == 'NO' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

    <input type="hidden" class="valorneto" name="valorneto[]" id="valorneto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?>" ><label id="txtvalorneto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></label></td>

 <?php if ($_SESSION['acceso'] == "administrador") { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesComprasUpdate('<?php echo encrypt($detalle[$i]["coddetallecompra"]); ?>','<?php echo encrypt($detalle[$i]["codcompra"]); ?>','<?php echo encrypt($reg[0]["codproveedor"]); ?>','<?php echo encrypt("DETALLESCOMPRAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                 </tr>
                     <?php } ?>
                </tbody>
            </table><hr>

             <table id="carritototal" class="table-responsive">
            <tr>
    <td width="250"><h5><label>Gravado <?php echo number_format($reg[0]['ivac'], 2, '.', '') ?>%:</label></h5></td>
    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal" name="lblsubtotal"><?php echo number_format($reg[0]['subtotalivasic'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtsubtotal" id="txtsubtotal" value="<?php echo number_format($reg[0]['subtotalivasic'], 2, '.', ''); ?>"/>    </td>
                  
    <td width="250">
    <h5><label>Exento 0%:</label></h5>    
    </td>

    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal2" name="lblsubtotal2"><?php echo number_format($reg[0]['subtotalivanoc'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtsubtotal2" id="txtsubtotal2" value="<?php echo number_format($reg[0]['subtotalivanoc'], 2, '.', ''); ?>"/>    </td>
    
    <td width="250"><h5><label><?php echo $impuesto; ?> <?php echo number_format($reg[0]['ivac'], 2, '.', ''); ?>%:<input type="hidden" name="iva" id="iva" autocomplete="off" value="<?php echo number_format($reg[0]['ivac'], 2, '.', ''); ?>"></label></h5>
    </td>

    <td class="text-center" width="250">
    <h5><?php echo $simbolo; ?><label id="lbliva" name="lbliva"><?php echo number_format($reg[0]['totalivac'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtIva" id="txtIva" value="<?php echo number_format($reg[0]['totalivac'], 2, '.', ''); ?>"/>
    </td>
    </tr>
    <tr>
    <td>
    <h5><label>Descontado %:</label></h5> </td>
    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescontado" name="lbldescontado"><?php echo number_format($reg[0]['descontadoc'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtdescontado" id="txtdescontado" value="<?php echo number_format($reg[0]['descontadoc'], 2, '.', ''); ?>"/>
        </td>
    
    <td>
    <h5><label>Desc. Global <input class="number" type="text" name="descuento" id="descuento" onKeyPress="EvaluateText('%f', this);" style="border-radius:4px;height:30px;width:60px;" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($reg[0]['descuentoc'], 2, '.', ''); ?>">%:</label></h5>    </td>

    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescuento" name="lbldescuento"><?php echo number_format($reg[0]['totaldescuentoc'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtDescuento" id="txtDescuento" value="<?php echo number_format($reg[0]['totaldescuentoc'], 2, '.', ''); ?>"/>    </td>

    <td><h4><b>Importe Total</b></h4>
    </td>

    <td class="text-center">
    <h4><b><?php echo $simbolo; ?><label id="lbltotal" name="lbltotal"><?php echo number_format($reg[0]['totalpagoc'], 2, '.', ''); ?></label></b></h4>
    <input type="hidden" name="txtTotal" id="txtTotal" value="<?php echo number_format($reg[0]['totalpagoc'], 2, '.', ''); ?>"/>
    <input type="hidden" name="txtTotal2" id="txtTotal2" value="<?php echo number_format($reg[0]['totalpagoc'], 2, '.', ''); ?>"/>
    </td>
                    </tr>
    </table>

  </div>
<?php
  } 
######################## MOSTRAR DETALLES DE COMPRAS UPDATE ########################
?>


<?php
######################## BUSQUEDA COMPRAS POR PROVEEDORES ########################
if (isset($_GET['BuscaComprasxProvedores']) && isset($_GET['codproveedor'])) {
  
  $codproveedor = limpiar($_GET['codproveedor']);

 if($codproveedor=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE PROVEEDOR PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else {

$pre = new Login();
$reg = $pre->BuscarComprasxProveedor();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Compras al Proveedor <?php echo $reg[0]['cuitproveedor'].": ".$reg[0]['nomproveedor']; ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codproveedor=<?php echo $codproveedor; ?>&tipo=<?php echo encrypt("COMPRASXPROVEEDOR") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codproveedor=<?php echo $codproveedor; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COMPRASXPROVEEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codproveedor=<?php echo $codproveedor; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COMPRASXPROVEEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                              <th>Nº</th>
                              <th>N° de Compra</th>
                              <th>Descripción de Proveedor</th>
                              <th>Status</th>
                              <th>Dias Venc.</th>
                              <th>Fecha de Emisión</th>
                              <th>Fecha de Recepción</th>
                              <th>Nº de Articulos</th>
                              <th>Subtotal</th>
                              <th><?php echo $impuesto; ?></th>
                              <th>Desc %</th>
                              <th>Imp. Total</th>
                              <th><i class="mdi mdi-drag-horizontal"></i></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'];
$TotalIva+=$reg[$i]['totalivac'];
$TotalDescuento+=$reg[$i]['totaldescuentoc'];
$TotalImporte+=$reg[$i]['totalpagoc'];
?>
                                <tr>
                    <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]['codcompra']; ?></td>
 <td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]['cuitproveedor']; ?>"><?php echo $reg[$i]['nomproveedor']; ?></abbr></td>
                    <td><?php if($reg[$i]["statuscompra"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statuscompra"]."</span>"; } ?>
        

      </td>
<td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
                    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
                    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fecharecepcion'])); ?></td>
                    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalivac'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['ivac'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuentoc'], 2, '.', ','); ?>%</sup></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
                    <td>
<a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                </tr>
                        <?php  }  ?>
         <tr>
           <td colspan="7"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA COMPRAS POR PROVEEDORES ##########################
?>


<?php
########################## BUSQUEDA COMPRAS POR FECHAS ##########################
if (isset($_GET['BuscaComprasxFechas']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarComprasxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Compras de Productos por Fechas Desde <?php echo date("d-m-Y", strtotime($desde)); ?> Hasta <?php echo date("d-m-Y", strtotime($hasta)); ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("COMPRASXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COMPRASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COMPRASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                              <th>Nº</th>
                              <th>N° de Compra</th>
                              <th>Descripción de Proveedor</th>
                              <th>Status</th>
                              <th>Dias Venc.</th>
                              <th>Fecha de Emisión</th>
                              <th>Fecha de Recepción</th>
                              <th>Nº de Articulos</th>
                              <th>Subtotal</th>
                              <th><?php echo $impuesto; ?></th>
                              <th>Desc %</th>
                              <th>Imp. Total</th>
                              <th><i class="mdi mdi-drag-horizontal"></i></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'];
$TotalIva+=$reg[$i]['totalivac'];
$TotalDescuento+=$reg[$i]['totaldescuentoc'];
$TotalImporte+=$reg[$i]['totalpagoc'];
?>
                                <tr>
                    <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]['codcompra']; ?></td>
 <td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]['cuitproveedor']; ?>"><?php echo $reg[$i]['nomproveedor']; ?></abbr></td>
                    <td><?php if($reg[$i]["statuscompra"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statuscompra"]."</span>"; } ?>
        

      </td>
<td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
                    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
                    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fecharecepcion'])); ?></td>
                    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalivac'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['ivac'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuentoc'], 2, '.', ','); ?>%</sup></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
                    <td>
<a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                </tr>
                        <?php  }  ?>
         <tr>
           <td colspan="7"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA COMPRAS POR FECHAS ########################
?>























<?php
######################## BUSQUEDA DETALLE DE PRODUCTO EN COTIZACION #######################
if (isset($_GET['BuscaDetallesProductoCotizacion']) && isset($_GET['d_codigo']) && isset($_GET['d_tipo']) && isset($_GET['d_cantidad']) && isset($_GET['d_observacion'])) { 

if(limpiar($_GET['d_tipo'] == 1)){ 

$reg = $new->DetallesProductoPorId();

?>

      <div class="row">
        <div class="col-md-2">
          <div class="form-group has-feedback">
            <label class="control-label">Cantidad: <span class="symbol required"></span></label>
            <br /><abbr title="Cantidad de Producto"><label id="d_cantidad"><?php echo $_GET['d_cantidad']; ?></label></abbr>
          </div>
        </div>

        <div class="col-md-8">
          <div class="form-group has-feedback">
            <label class="control-label">Descripción de Producto: <span class="symbol required"></span></label>
            <br /><abbr title="Descripción de Producto"><label id="d_producto"><?php echo $reg[0]['producto']; ?></label></abbr>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group has-feedback">
            <label class="control-label">Precio: <span class="symbol required"></span></label>
            <br /><abbr title="Precio de Producto"><label id="d_precioventa"><?php echo number_format($reg[0]['precioventa'], 2, '.', ','); ?></label></abbr>
          </div>
        </div>
      </div>

      <?php 
$tru = new Login();
$a=1;
$busq = $tru->VerDetallesIngredientesModal(); 

if($busq==""){

    echo "";      
    
} else {

?>
<div id="div1">
  <table id="default_order" class="table2 table-striped table-bordered border display m-t-10">
          <thead>
          <tr>
        <th colspan="6" data-priority="1"><center>Ingredientes Agregados</center></th>
          </tr>
          <tr>
            <th>Nº</th>
            <th>Ingrediente</th>
            <th>Medida</th>
            <th>Cant. Ración</th>
          </tr>
          </thead>
            <tbody>
<?php 
$TotalCosto=0;
for($i=0;$i<sizeof($busq);$i++){
$TotalCosto+=($busq[$i]['precioventa']-$busq[$i]['descingrediente']/100)*$busq[$i]["cantracion"];
?>
          <tr>
            <th><?php echo $a++; ?></th>
<td><?php echo $busq[$i]["nomingrediente"]; ?></td>
<td><?php echo $busq[$i]["nommedida"]; ?></td>
<td><?php echo $busq[$i]["cantracion"]; ?></td>
          </tr> 
            <?php } ?> 
         </tbody>
        </table>
        </div>

  <?php } ?>

      <div class="row m-t-5">
        <div class="col-md-12"> 
          <div class="form-group has-feedback2"> 
            <label class="control-label">Observaciones: <span class="symbol required"></span></label> 
            <textarea class="form-control" type="text" name="observacion" id="observacion" onKeyUp="this.value=this.value.toUpperCase();" onfocus="this.style.background=('#FDF0DF')" onBlur="DoActionObservacion(
            '<?php echo $reg[0]['idproducto']; ?>',
            '<?php echo $reg[0]['codproducto']; ?>',
            '<?php echo $reg[0]['producto']; ?>',
            '<?php echo $reg[0]['codcategoria']; ?>',
            '<?php echo $reg[0]['nomcategoria']; ?>',
            '<?php echo number_format($reg[0]['preciocompra'], 2, '.', ''); ?>',
            '<?php echo number_format($reg[0]['precioventa'], 2, '.', ''); ?>',
            '<?php echo number_format($reg[0]['descproducto'], 2, '.', ''); ?>',
            '<?php echo $reg[0]['ivaproducto']; ?>',
            '<?php echo $reg[0]['existencia']; ?>',
            '<?php echo $precioconiva = ( $reg[0]['ivaproducto'] == 'SI' ? number_format($reg[0]['precioventa'], 2, '.', '') : "0.00"); ?>',
            '<?php echo "1"; ?>',
            document.getElementById('observacion').value);" autocomplete="off" placeholder="Agrega un comentario aqui...." rows="2" required="" aria-required="true"><?php echo str_replace("_"," ", $_GET['d_observacion']); ?></textarea>
            <i class="fa fa-comment-o form-control-feedback2"></i> 
          </div> 
        </div>
      </div> 
<?php } else {

$reg = $new->DetallesComboPorId();

?>
      <div class="row">
        <div class="col-md-2">
          <div class="form-group has-feedback">
            <label class="control-label">Cantidad: <span class="symbol required"></span></label>
            <br /><abbr title="Cantidad de Combo"><label id="d_cantidad"><?php echo $_GET['d_cantidad']; ?></label></abbr>
          </div>
        </div>

        <div class="col-md-8">
          <div class="form-group has-feedback">
            <label class="control-label">Descripción de Combo: <span class="symbol required"></span></label>
            <br /><abbr title="Descripción de Combo"><label id="d_producto"><?php echo $reg[0]['nomcombo']; ?></label></abbr>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group has-feedback">
            <label class="control-label">Precio: <span class="symbol required"></span></label>
            <br /><abbr title="Precio de Combo"><label id="d_precioventa"><?php echo number_format($reg[0]['precioventa'], 2, '.', ','); ?></label></abbr>
          </div>
        </div>
      </div>

      <?php 
$tru = new Login();
$a=1;
$busq = $tru->VerDetallesProductosModal(); 

if($busq==""){

    echo "";      
    
} else {

?>
<div id="div">
  <table id="default_order" class="table2 table-striped table-bordered border display m-t-10">
          <thead>
          <tr>
        <th colspan="6" data-priority="1"><center>Productos Agregados</center></th>
          </tr>
          <tr>
            <th>Nº</th>
            <th>Producto</th>
            <th>Categoria</th>
            <th>Cantidad</th>
          </tr>
          </thead>
            <tbody>
<?php 
$TotalCosto=0;
for($i=0;$i<sizeof($busq);$i++){
$TotalCosto+=($busq[$i]['precioventa']-$busq[$i]['descproducto']/100)*$busq[$i]["cantidad"];
?>
          <tr>
            <th><?php echo $a++; ?></th>
<td><?php echo $busq[$i]["producto"]; ?></td>
<td><?php echo $busq[$i]["nomcategoria"]; ?></td>
<td><?php echo $busq[$i]["cantidad"]; ?></td>
          </tr> 
            <?php } ?>
         </tbody>
        </table>
        </div>
<?php } ?>

      <div class="row m-t-5">
        <div class="col-md-12"> 
          <div class="form-group has-feedback2"> 
            <label class="control-label">Observaciones: <span class="symbol required"></span></label> 
            <textarea class="form-control" type="text" name="observacion" id="observacion" onKeyUp="this.value=this.value.toUpperCase();" onfocus="this.style.background=('#FDF0DF')" onBlur="DoActionObservacion(
            '<?php echo $reg[0]['idcombo']; ?>',
            '<?php echo $reg[0]['codcombo']; ?>',
            '<?php echo $reg[0]['nomcombo']; ?>',
            '<?php echo "********"; ?>',
            '<?php echo "********"; ?>',
            '<?php echo number_format($reg[0]['preciocompra'], 2, '.', ''); ?>',
            '<?php echo number_format($reg[0]['precioventa'], 2, '.', ''); ?>',
            '<?php echo number_format($reg[0]['desccombo'], 2, '.', ''); ?>',
            '<?php echo $reg[0]['ivacombo']; ?>',
            '<?php echo $reg[0]['existencia']; ?>',
            '<?php echo $precioconiva = ( $reg[0]['ivacombo'] == 'SI' ? number_format($reg[0]['precioventa'], 2, '.', '') : "0.00"); ?>',
            '<?php echo "2"; ?>',
            document.getElementById('observacion').value);" autocomplete="off" placeholder="Agrega un comentario aqui...." rows="2" required="" aria-required="true"><?php echo str_replace("_"," ", $_GET['d_observacion']); ?></textarea>
            <i class="fa fa-comment-o form-control-feedback2"></i> 
          </div> 
        </div>
      </div> 
<?php
  }
} 
######################## BUSQUEDA DETALLE DE PRODUCTO EN COTIZACION ########################
?>

<?php 
######################## MUESTRA CONDICIONES DE PAGO PARA COTIZACIONES ########################
if (isset($_GET['BuscaCondicionesPagosCotizacion']) && isset($_GET['tipopago']) && isset($_GET['txtTotal'])) { 
  
 if(limpiar($_GET['tipopago'])==""){ echo ""; 

 } elseif(limpiar($_GET['tipopago'])=="CONTADO"){  ?>

    <div class="row">

        <!-- .col -->
        <div class="col-md-6">

        <h4 class="card-subtitle m-0 text-dark"><i class="font-18 mdi mdi-cash-multiple"></i> Métodos de Pago Nº 1</h4><hr>
            
        <div class="row">
          <div class="col-md-12"> 
            <div class="form-group has-feedback"> 
              <label class="control-label">Forma de Pago Nº 1: <span class="symbol required"></span></label>
              <i class="fa fa-bars form-control-feedback"></i>
              <select name="formapago" id="formapago" class="form-control" required="" aria-required="true">
                <option value=""> -- SELECCIONE -- </option>
                <option value="EFECTIVO" selected="">EFECTIVO</option>
                <option value="CHEQUE">CHEQUE</option>
                <option value="TARJETA DE CREDITO">TARJETA DE CRÉDITO</option>
                <option value="TARJETA DE DEBITO">TARJETA DE DÉBITO</option>
                <option value="TARJETA PREPAGO">TARJETA PREPAGO</option>
                <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                <option value="DINERO ELECTRONICO">DINERO ELECTRÓNICO</option>
                <option value="CUPON">CUPÓN</option>
                <option value="OTROS">OTROS</option>
              </select>
            </div> 
          </div>
        </div>

        <div class="row">
          <div class="col-md-12"> 
            <div class="form-group has-feedback"> 
              <label class="control-label">Monto de Pago Nº 1: <span class="symbol required"></span></label>
              <input type="hidden" name="montodevuelto" id="montodevuelto" value="0.00">
              <input class="form-control" type="text" name="montopagado" id="montopagado" onKeyUp="DevolucionCotizacion();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" autocomplete="off" placeholder="Monto de Pago Nº 1" value="<?php echo number_format($_GET['txtTotal'], 2, '.', ''); ?>" required="" aria-required="true"> 
              <i class="fa fa-dollar form-control-feedback"></i>
            </div> 
          </div>
        </div>

        </div>
        <!-- /.col -->

        <!-- .col -->
        <div class="col-md-6">

        <h4 class="card-subtitle m-0 text-dark"><i class="font-18 mdi mdi-cash-multiple"></i> Métodos de Pago Nº 2</h4><hr>
            
        <div class="row">
          <div class="col-md-12"> 
            <div class="form-group has-feedback"> 
              <label class="control-label">Forma de Pago Nº 2: </label>
              <i class="fa fa-bars form-control-feedback"></i>
              <select name="formapago2" id="formapago2" class="form-control" required="" aria-required="true">
                <option value=""> -- SELECCIONE -- </option>
                <option value="EFECTIVO">EFECTIVO</option>
                <option value="CHEQUE">CHEQUE</option>
                <option value="TARJETA DE CREDITO">TARJETA DE CRÉDITO</option>
                <option value="TARJETA DE DEBITO">TARJETA DE DÉBITO</option>
                <option value="TARJETA PREPAGO">TARJETA PREPAGO</option>
                <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                <option value="DINERO ELECTRONICO">DINERO ELECTRÓNICO</option>
                <option value="CUPON">CUPÓN</option>
                <option value="OTROS">OTROS</option>
              </select>
            </div> 
          </div>
        </div>

        <div class="row">
          <div class="col-md-12"> 
            <div class="form-group has-feedback"> 
              <label class="control-label">Monto de Pago Nº 2: </label>
              <input class="form-control" type="text" name="montopagado2" id="montopagado2" onKeyUp="DevolucionCotizacion();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" autocomplete="off" placeholder="Monto de Pago Nº 2" value="0.00" disabled="" required="" aria-required="true"> 
              <i class="fa fa-dollar form-control-feedback"></i>
            </div>  
          </div>
        </div>

        </div>
        <!-- /.col -->

      </div><!-- END CONDICION PAGO -->

      <div class="row">
        <div class="col-md-12"> 
          <div class="form-group has-feedback2"> 
            <label class="control-label">Observaciones: </label> 
            <textarea class="form-control" type="text" name="observaciones" id="observaciones" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Observaciones" rows="1"></textarea>
            <i class="fa fa-comment-o form-control-feedback2"></i> 
          </div> 
        </div>
      </div>
          
 <?php   } else if(limpiar($_GET['tipopago'])=="CREDITO"){  ?>

      <div class="row">
        <div class="col-md-6"> 
             <div class="form-group has-feedback"> 
                <label class="control-label">Fecha Vence Crédito: <span class="symbol required"></span></label> 
                <input type="text" class="form-control vencecredito" name="fechavencecredito" id="fechavencecredito" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo date("d-m-Y"); ?>" placeholder="Ingrese Fecha Vence Crédito" aria-required="true">
                <i class="fa fa-calendar form-control-feedback"></i>  
           </div> 
        </div>

        <div class="col-md-6"> 
            <div class="form-group has-feedback"> 
              <label class="control-label">Forma de Abono: </label>
                <i class="fa fa-bars form-control-feedback"></i>
                <select name="medioabono" id="medioabono" class="form-control" required="" aria-required="true">
                <option value=""> -- SELECCIONE -- </option>
                <option value="EFECTIVO">EFECTIVO</option>
                <option value="CHEQUE">CHEQUE</option>
                <option value="TARJETA DE CREDITO">TARJETA DE CRÉDITO</option>
                <option value="TARJETA DE DEBITO">TARJETA DE DÉBITO</option>
                <option value="TARJETA PREPAGO">TARJETA PREPAGO</option>
                <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                <option value="DINERO ELECTRONICO">DINERO ELECTRÓNICO</option>
                <option value="CUPON">CUPÓN</option>
                <option value="OTROS">OTROS</option>
              </select>
            </div> 
        </div>
      </div>

      <div class="row">
        <div class="col-md-6"> 
          <div class="form-group has-feedback"> 
            <label class="control-label">Abono Crédito: <span class="symbol required"></span></label>
            <input type="hidden" name="formapago" id="formapago" value="">
            <input type="hidden" name="montopagado" id="montopagado" value="0.00">
            <input type="hidden" name="formapago2" id="formapago2" value="">
            <input type="hidden" name="montopagado2" id="montopagado2" value="0.00">
            <input type="hidden" name="montodevuelto" id="montodevuelto" value="0.00">
            <input class="form-control number" type="text" name="montoabono" id="montoabono" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" autocomplete="off" placeholder="Ingrese Monto de Abono" value="0.00" required="" aria-required="true"> 
            <i class="fa fa-dollar form-control-feedback"></i>
          </div> 
        </div>

        <div class="col-md-6"> 
          <div class="form-group has-feedback2"> 
            <label class="control-label">Observaciones: </label> 
            <textarea class="form-control" type="text" name="observaciones" id="observaciones" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Observaciones" rows="1"></textarea>
            <i class="fa fa-comment-o form-control-feedback2"></i> 
          </div> 
        </div>
      </div>
 
<?php  }
  }
######################## MUESTRA CONDICIONES DE PAGO PARA COTIZACIONES ########################
?>

<?php
######################## MOSTRAR COTIZACIONES EN VENTANA MODAL #########################
if (isset($_GET['BuscaCotizacionModal']) && isset($_GET['codcotizacion'])) { 
 
$reg = $new->CotizacionesPorId();

  if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COTIZACIONES Y DETALLES ACTUALMENTE </center>";
    echo "</div>";    

} else {
?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-dark">SUCURSAL</b></h4>
  <p class="text-muted m-l-5"><?php echo $con[0]['nomsucursal']; ?>,
  <br/> Nº <?php echo $con[0]['documsucursal'] == '0' ? "DOCUMENTO" : $con[0]['documento']; ?>: <?php echo $con[0]['cuit']; ?> - TLF: <?php echo $con[0]['tlfsucursal']; ?></p>

  <h4><b class="text-dark">Nº COTIZACIÓN <?php echo $reg[0]['codcotizacion']; ?></b></h4>
  <p class="text-muted m-l-5">FECHA DE EMISIÓN: <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechacotizacion'])); ?></p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
  <h4><b class="text-dark">CLIENTE</b></h4>
  <p class="text-muted m-l-30"><?php echo $reg[0]['nomcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente']; ?>,
  <?php echo $reg[0]['direccliente'] == '' ? "" : "<br/>".$reg[0]['direccliente']; ?>
  <?php echo $reg[0]['provincia'] == '' ? "" : "<br/>".$reg[0]['provincia']; ?> <?php echo $reg[0]['departamento'] == '' ? "" : strtoupper($reg[0]['departamento']); ?>
  <br/> EMAIL: <?php echo $reg[0]['emailcliente'] == '' ? "*******" : $reg[0]['emailcliente']; ?>
  <br/> Nº <?php echo $reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento'] ?>: <?php echo $reg[0]['dnicliente'] == '' ? "*******" : $reg[0]['dnicliente']; ?> - TLF: <?php echo $reg[0]['tlfcliente'] == '' ? "*******" : $reg[0]['tlfcliente']; ?></p>
                                            
                                        </address>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-10" style="clear: both;">
                                        <table class="table table-hover">
                               <thead>
                        <tr>
                        <th>#</th>
                        <th class="text-left">Descripción de Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
<?php if ($_SESSION['acceso'] == "administrador") { ?><th>Acción</th><?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesCotizaciones();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto'];
?>
                                                <tr>
      <td><label><?php echo $a++; ?></label></td>
      <td class="text-left"><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5>
      <small class="text-danger alert-link"><?php echo $detalle[$i]['codcategoria'] == '0' ? "**********" : $detalle[$i]['nomcategoria'] ?></small></td>
      <td><?php echo $detalle[$i]['cantcotizacion']; ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><strong><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</strong></sup></td>
      <td><?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($reg[0]['iva'], 2, '.', ',')."%" : "(E)"; ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
 <?php if ($_SESSION['acceso'] == "administrador") { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesCotizacionModal('<?php echo encrypt($detalle[$i]["coddetallecotizacion"]); ?>','<?php echo encrypt($detalle[$i]["codcotizacion"]); ?>','<?php echo encrypt("DETALLESCOTIZACIONES") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                                </tr>
                                      <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="col-md-12">

                                    <div class="pull-right text-right">
<p><b>Subtotal:</b> <?php echo $simbolo.number_format($SubTotal, 2, '.', ','); ?></p>
<p><b>Gravado  <?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivasi'], 2, '.', ','); ?><p>
<p><b>Exento 0%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivano'], 2, '.', ','); ?></p>
<p><b>Total <?php echo $impuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaliva'], 2, '.', ','); ?> </p>
<p><b>Descontado %:</b> <?php echo $simbolo.number_format($reg[0]['descontado'], 2, '.', ','); ?> </p>
<p><b>Desc. Global (<?php echo number_format($reg[0]['descuento'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaldescuento'], 2, '.', ','); ?> </p>
                                        <hr>
<h4><b>Importe Total:</b> <?php echo $simbolo.number_format($reg[0]['totalpago'], 2, '.', ','); ?></h4></div>
                                    <div class="clearfix"></div>
                                    <hr>

                                <div class="col-md-12">
                                    <div class="text-right">
 <a href="reportepdf?codcotizacion=<?php echo encrypt($reg[0]['codcotizacion']); ?>&tipo=<?php echo encrypt("FACTURACOTIZACION") ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn waves-light btn-light" type="button"> <span><i class="fa fa-print"></i> Imprimir</span></button></a>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                                    </div>
                                </div>
                            </div>
                <!-- .row -->
  <?php
       }
   } 
######################### MOSTRAR COTIZACIONES EN VENTANA MODAL #########################
?>


<?php
####################### MOSTRAR DETALLES DE COTIZACIONES UPDATE #########################
if (isset($_GET['MuestraDetallesCotizacionesUpdate']) && isset($_GET['codcotizacion'])) { 
 
$reg = $new->CotizacionesPorId();

?>

<div class="table-responsive m-t-20">
            <table class="table2 table-hover">
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Código</th>
                        <th class="text-left">Descripción de Producto</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
<?php if ($_SESSION['acceso'] == "administrador") { ?><th>Acción</th><?php } ?>
                    </tr>
                </thead>
                <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesCotizaciones();
$a=1;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){ 
$count++;  
?>
                                 <tr>
      <td>
      <input type="text" step="1" min="1" class="form-control cantidad bold" name="cantcotizacion[]" id="cantcotizacion_<?php echo $count; ?>" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoCotizacion(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" style="width: 80px;background:#e4e7ea;border-radius:5px 5px 5px 5px;" onfocus="this.style.background=('#B7F0FF')" onfocus="this.style.background=('#B7F0FF')" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', ''); this.style.background=('#e4e7ea');" title="Ingrese Cantidad" value="<?php echo $detalle[$i]["cantcotizacion"]; ?>" required="" aria-required="true">
      <input type="hidden" name="cantcotizacionbd[]" id="cantcotizacionbd" value="<?php echo $detalle[$i]["cantcotizacion"]; ?>">
      <input type="hidden" name="coddetallecotizacion[]" id="coddetallecotizacion" value="<?php echo $detalle[$i]["coddetallecotizacion"]; ?>">
      <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $detalle[$i]["codproducto"]; ?>">
      <input type="hidden" name="tipo[]" id="tipo" value="<?php echo $detalle[$i]["tipo"]; ?>">
      <input type="hidden" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>"></td>
      
      <td><label><?php echo $detalle[$i]['codproducto']; ?></label></td>
      
      <td class="text-left"><label><h5><?php echo $detalle[$i]['producto']; ?></h5>
      <small class="text-danger alert-link"><?php echo $detalle[$i]['detallesobservaciones'] == '' ? "**********" : $detalle[$i]['detallesobservaciones'] ?></small></label></td>
      
      <td><input type="hidden" name="precioventa[]" id="precioventa_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>"><?php echo number_format($detalle[$i]['precioventa'], 2, '.', ''); ?></td>

       <td><input type="hidden" name="valortotal[]" id="valortotal_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["valortotal"], 2, '.', ''); ?>"><label><label id="txtvalortotal_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valortotal'], 2, '.', ''); ?></label></label></td>

       <td><input type="hidden" name="descproducto[]" id="descproducto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["descproducto"], 2, '.', ''); ?>">
        <input type="hidden" class="totaldescuentov" name="totaldescuentov[]" id="totaldescuentov_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["totaldescuentov"], 2, '.', ''); ?>">
        <label><label id="txtdescproducto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['totaldescuentov'], 2, '.', ''); ?></label><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ''); ?>%</sup></label></td>

      <td><input type="hidden" name="ivaproducto[]" id="ivaproducto_<?php echo $count; ?>" value="<?php echo $detalle[$i]["ivaproducto"]; ?>"><label><?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($reg[0]['iva'], 2, '.', '')."%" : "(E)"; ?></label></td>

       <td><input type="hidden" class="subtotalivasi" name="subtotalivasi[]" id="subtotalivasi_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

        <input type="hidden" class="subtotalivano" name="subtotalivano[]" id="subtotalivano_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == 'NO' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

        <input type="hidden" class="valorneto" name="valorneto[]" id="valorneto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?>" >

        <input type="hidden" class="valorneto2" name="valorneto2[]" id="valorneto2_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto2'], 2, '.', ''); ?>" >

        <label> <label id="txtvalorneto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?></label></label></td>

 <?php if ($_SESSION['acceso'] == "administrador") { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesCotizacionesUpdate('<?php echo encrypt($detalle[$i]["coddetallecotizacion"]); ?>','<?php echo encrypt($detalle[$i]["codcotizacion"]); ?>','<?php echo encrypt("DETALLESCOTIZACIONES") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                 </tr>
                     <?php } ?>
                </tbody>
            </table><hr>

            <table id="carritototal" class="table-responsive">
                <tr>
    <td width="250"><h5><label>Gravado <?php echo number_format($reg[0]['iva'], 2, '.', '') ?>%:</label></h5></td>
    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal" name="lblsubtotal"><?php echo number_format($reg[0]['subtotalivasi'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtsubtotal" id="txtsubtotal" value="<?php echo number_format($reg[0]['subtotalivasi'], 2, '.', ''); ?>"/>    </td>
                  
    <td width="250">
    <h5><label>Exento 0%:</label></h5>    </td>

    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal2" name="lblsubtotal2"><?php echo number_format($reg[0]['subtotalivano'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtsubtotal2" id="txtsubtotal2" value="<?php echo number_format($reg[0]['subtotalivano'], 2, '.', ''); ?>"/>    </td>
    
    <td width="250"><h5><label><?php echo $impuesto; ?> <?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>%:<input type="hidden" name="iva" id="iva" autocomplete="off" value="<?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>"></label></h5>
    </td>

    <td class="text-center" width="250">
    <h5><?php echo $simbolo; ?><label id="lbliva" name="lbliva"><?php echo number_format($reg[0]['totaliva'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtIva" id="txtIva" value="<?php echo number_format($reg[0]['totaliva'], 2, '.', ''); ?>"/>
    </td>
                </tr>
                <tr>
    <td>
    <h5><label>Descontado %:</label></h5> </td>
    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescontado" name="lbldescontado"><?php echo number_format($reg[0]['descontado'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtdescontado" id="txtdescontado" value="<?php echo number_format($reg[0]['descontado'], 2, '.', ''); ?>"/>
        </td>
    
    <td>
    <h5><label>Desc. Global <input class="number" type="text" name="descuento" id="descuento" onKeyPress="EvaluateText('%f', this);" style="border-radius:4px;height:30px;width:60px;"  onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($reg[0]['descuento'], 2, '.', ''); ?>">%:</label></h5>    </td>

    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescuento" name="lbldescuento"><?php echo number_format($reg[0]['totaldescuento'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtDescuento" id="txtDescuento" value="<?php echo number_format($reg[0]['totaldescuento'], 2, '.', ''); ?>"/>    </td>

    <td><h4><b>Importe Total</b></h4>
    </td>

    <td class="text-center">
    <h4><b><?php echo $simbolo; ?><label id="lbltotal" name="lbltotal"><?php echo number_format($reg[0]['totalpago'], 2, '.', ''); ?></label></b></h4>
    <input type="hidden" name="txtTotal" id="txtTotal" value="<?php echo number_format($reg[0]['totalpago'], 2, '.', ''); ?>"/>
    <input type="hidden" name="txtTotalCompra" id="txtTotalCompra" value="<?php echo number_format($reg[0]['totalpago2'], 2, '.', ''); ?>"/>    </td>
                    </tr>
                  </table>

        </div>
<?php
  } 
####################### MOSTRAR DETALLES DE COTIZACIONES UPDATE #########################
?>

<?php
####################### MOSTRAR DETALLES DE COTIZACIONES AGREGAR #######################
if (isset($_GET['MuestraDetallesCotizacionesAgregar']) && isset($_GET['codcotizacion'])) { 
 
$reg = $new->CotizacionesPorId();

?>

<div class="table-responsive m-t-20">
            <table class="table2 table-hover">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Código</th>
                        <th class="text-left">Descripción de Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
<?php if ($_SESSION['acceso'] == "administrador") { ?><th>Acción</th><?php } ?>
                    </tr>
                </thead>
                <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesCotizaciones();
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
    ?>
                                 <tr>
      <td><label><?php echo $a++; ?></label></td>
      
      <td><label><?php echo $detalle[$i]['codproducto']; ?></label></td>
      
      <td class="text-left"><label><h5><?php echo $detalle[$i]['producto']; ?></h5>
      <small class="text-danger alert-link"><?php echo $detalle[$i]['detallesobservaciones'] == '' ? "**********" : $detalle[$i]['detallesobservaciones'] ?></small></label></td>

      <td><?php echo $detalle[$i]['cantcotizacion']; ?></td>
      
      <td><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ''); ?></td>

       <td><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ''); ?></td>
      
      <td><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ''); ?><sup><label><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ''); ?>%</label></sup></td>

      <td><?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($reg[0]['iva'], 2, '.', '')."%" : "(E)"; ?></td>

      <td><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ''); ?></td>

 <?php if ($_SESSION['acceso'] == "administrador") { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesCotizacionesAgregar('<?php echo encrypt($detalle[$i]["coddetallecotizacion"]); ?>','<?php echo encrypt($detalle[$i]["codcotizacion"]); ?>','<?php echo encrypt("DETALLESCOTIZACIONES") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                 </tr>
                     <?php } ?>
                </tbody>
            </table>

            <table id="carritototal" class="table-responsive">
                <tr>
    <td width="250"><h5><label>Gravado <?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>%:</label></h5></td>
    <td width="250">
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['subtotalivasi'], 2, '.', ''); ?></label></h5>
    </td>
                  
    <td width="250">
    <h5><label>Exento 0%:</label></h5>    </td>

    <td width="250">
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['subtotalivano'], 2, '.', ''); ?></label></h5>
    </td>
    
    <td width="250"><h5><label><?php echo $impuesto; ?> <?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>%:</label></h5>
    </td>

    <td class="text-center" width="250">
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['totaliva'], 2, '.', ''); ?></label></h5>
    </td>
                </tr>
                <tr>
    <td>
    <h5><label>Descontado %:</label></h5> </td>
    <td>
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['descontado'], 2, '.', ''); ?></label></h5>
        </td>
    
    <td>
    <h5><label>Desc. Global <?php echo number_format($reg[0]['descuento'], 2, '.', ''); ?>%:</label></h5>    </td>

    <td>
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['totaldescuento'], 2, '.', ''); ?></label></h5>
    </td>

    <td><h4><b>Importe Total</b></h4>
    </td>

    <td class="text-center">
    <h4><b><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['totalpago'], 2, '.', ''); ?></label></b></h4>
    </td>
                    </tr>
                  </table>

            </div>
<?php
  } 
######################## MOSTRAR DETALLES DE COTIZACIONES AGREGRA #######################
?>


<?php
########################## BUSQUEDA COTIZACIONES POR FECHAS ##########################
if (isset($_GET['BuscaCotizacionesxFechas']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarCotizacionesxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Cotizaciones por Fechas Desde <?php echo date("d-m-Y", strtotime($desde)); ?> Hasta <?php echo date("d-m-Y", strtotime($hasta)); ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("COTIZACIONESXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COTIZACIONESXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COTIZACIONESXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Cotización</th>
                                  <th>Descripción de Cliente</th>
                                  <th>Fecha Emisión</th>
                                  <th>Nº de Articulos</th>
                                  <th>Subtotal</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc %</th>
                                  <th>Imp. Total</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $reg[$i]['codcotizacion']; ?></td>
<td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td> 
  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechacotizacion'])); ?></td> 
                                  <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  <td> <a href="reportepdf?codcotizacion=<?php echo encrypt($reg[$i]['codcotizacion']); ?>&tipo=<?php echo encrypt("FACTURACOTIZACION") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                  </tr>
                        <?php  }  ?>
         <tr>
           <td colspan="4"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA COTIZACIONES POR FECHAS ##########################
?>

<?php 
########################### BUSQUEDA DE PRODUCTOS COTIZADOS ##########################
if (isset($_GET['BuscaProductoCotizados']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$cotizado = new Login();
$reg = $cotizado->BuscarProductosCotizados();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i>  Productos Cotizados por Fecha Desde <?php echo date("d-m-Y", strtotime($desde)); ?> Hasta <?php echo date("d-m-Y", strtotime($hasta)); ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("PRODUCTOSCOTIZADOS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOSCOTIZADOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRODUCTOSCOTIZADOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>Código</th>
                                  <th>Descripción de Producto</th>
                                  <th>Categoria</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc %</th>
                                  <th>Precio de Venta</th>
                                  <th>Existencia</th>
                                  <th>Cotizado</th>
                                  <th>Monto Total</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                      <td><?php echo $a++; ?></td>
                      <td><?php echo $reg[$i]['codproducto']; ?></td>
                      <td><?php echo $reg[$i]['producto']; ?></td>
                      <td><?php echo $reg[$i]['nomcategoria']; ?></td>
                      <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
                      <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
                      <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
                      <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
                      <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
                      <td><?php echo $simbolo.number_format($reg[$i]['precioventa']*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
                                </tr>
                        <?php  }  ?>
                      <tr>
                        <td colspan="6"></td>
                        <td><label><?php echo $simbolo.number_format($precioTotal, 2, '.', ','); ?></label></td>
                        <td><label><?php echo number_format($existeTotal, 2, '.', ','); ?></label></td>
                        <td><label><?php echo number_format($vendidosTotal, 2, '.', ','); ?></label></td>
                        <td><label><?php echo $simbolo.number_format($pagoTotal, 2, '.', ','); ?></label></td>
                      </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
########################### BUSQUEDA DE PRODUCTOS COTIZADOS ##########################
?>


<?php 
########################### BUSQUEDA DE COTIZADOS VENDIDOS POR VENDEDOR ##########################
if (isset($_GET['BuscaCotizacionesxVendedor']) && isset($_GET['codigo']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codigo = limpiar($_GET['codigo']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codigo=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE VENDEDOR PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarCotizacionesxVendedor();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Cotizaciones del Vendedor <?php echo $reg[0]['nombres']; ?>  y Fecha Desde <?php echo date("d-m-Y", strtotime($desde)); ?> Hasta <?php echo date("d-m-Y", strtotime($hasta)); ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("COTIZACIONESXVENDEDOR") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COTIZACIONESXVENDEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COTIZACIONESXVENDEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>Código</th>
                                  <th>Descripción de Producto</th>
                                  <th>Categoria</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc %</th>
                                  <th>Precio de Venta</th>
                                  <th>Existencia</th>
                                  <th>Cotizado</th>
                                  <th>Monto Total</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                      <td><?php echo $a++; ?></div></td>
                      <td><?php echo $reg[$i]['codproducto']; ?></td>
                      <td><?php echo $reg[$i]['producto']; ?></td>
                      <td><?php echo $reg[$i]['nomcategoria']; ?></td>
                      <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
                      <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
                      <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
                      <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
                      <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
                      <td><?php echo $simbolo.number_format($reg[$i]['precioventa']*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
                                </tr>
                        <?php  }  ?>
                      <tr>
                        <td colspan="6"></td>
                        <td><label><?php echo $simbolo.number_format($precioTotal, 2, '.', ','); ?></label></td>
                        <td><label><?php echo number_format($existeTotal, 2, '.', ','); ?></label></td>
                        <td><label><?php echo number_format($vendidosTotal, 2, '.', ','); ?></label></td>
                        <td><label><?php echo $simbolo.number_format($pagoTotal, 2, '.', ','); ?></label></td>
                      </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
########################### BUSQUEDA DE PRODUCTOS COTIZADOS POR VENDEDOR ##########################
?>






















<?php
######################## MOSTRAR CAJA DE VENTA EN VENTANA MODAL ########################
if (isset($_GET['BuscaCajaModal']) && isset($_GET['codcaja'])) { 

$reg = $new->CajasPorId();
?>
  
  <table class="table-responsive" border="0" class="text-center"> 
  <tr>
    <td><strong>Nº de Caja:</strong> <?php echo $reg[0]['nrocaja']; ?></td>
  </tr>
  <tr>
    <td><strong>Nombre de Caja:</strong> <?php echo $reg[0]['nomcaja']; ?></td>
  </tr>
  <tr>
    <td><strong>Responsable de Caja: </strong> <?php echo $reg[0]['nombres']; ?></td>
  </tr>
</table>
<?php 
} 
######################## MOSTRAR CAJA DE VENTA EN VENTANA MODAL ########################
?>

<?php
######################## MOSTRAR ARQUEO EN CAJA EN VENTANA MODAL ########################
if (isset($_GET['BuscaArqueoModal']) && isset($_GET['codarqueo'])) { 

$reg = $new->ArqueoCajaPorId();

$TotalVentas = $reg[0]['efectivo']+$reg[0]['cheque']+$reg[0]['tcredito']+$reg[0]['tdebito']+$reg[0]['tprepago']+$reg[0]['transferencia']+$reg[0]['electronico']+$reg[0]['cupon']+$reg[0]['otros'];

$VentaOtros = $reg[0]['cheque']+$reg[0]['tcredito']+$reg[0]['tdebito']+$reg[0]['tprepago']+$reg[0]['transferencia']+$reg[0]['electronico']+$reg[0]['cupon']+$reg[0]['otros'];

$TotalEfectivo = $reg[0]['montoinicial']+$reg[0]['efectivo']+$reg[0]['ingresosefectivo']+$reg[0]['abonosefectivo']+$reg[0]['propinasefectivo']-$reg[0]['egresos'];

$TotalOtros = $reg[0]['cheque']+$reg[0]['tcredito']+$reg[0]['tdebito']+$reg[0]['tprepago']+$reg[0]['transferencia']+$reg[0]['electronico']+$reg[0]['cupon']+$reg[0]['otros']+$reg[0]['abonosotros']+$reg[0]['propinasotros']+$reg[0]['ingresosotros'];

?>
  
  <table class="table-responsive" border="0" class="text-center">
  <tr>
    <td><h4 class="card-subtitle m-0 text-dark"><i class="mdi mdi-account-outline"></i> Cajero</h4><hr></td>
  </tr>

  <tr>
    <td><strong>Nombre de Caja:</strong> <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?></td>
  </tr>
  <tr>
    <td><strong>Responsable:</strong> <?php echo $reg[0]['dni'].": ".$reg[0]['nombres']; ?></td>
  </tr>
  <tr>
    <td><strong>Hora Apertura:</strong> <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechaapertura'])); ?></td>
  </tr>
  <tr>
    <td><strong>Hora Cierre:</strong> <?php echo $cierre = ( $reg[0]['statusarqueo'] == '1' ? $reg[0]['fechacierre'] : date("d-m-Y H:i:s",strtotime($reg[0]['fechacierre']))); ?></td>
  </tr>
  <tr>
    <td><strong>Monto Inicial:</strong> <?php echo $simbolo.number_format($reg[0]['montoinicial'], 2, '.', ','); ?></td>
  </tr>

  <tr>
    <td><hr><h4 class="card-subtitle m-0 text-dark"><i class="mdi mdi-cart-plus"></i> Ventas a Contado</h4><hr></td>
  </tr>

  <tr>
    <td><strong>Efectivo:</strong> <?php echo $simbolo.number_format($reg[0]['efectivo'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Cheque:</strong> <?php echo $simbolo.number_format($reg[0]['cheque'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Tarjeta Crédito:</strong> <?php echo $simbolo.number_format($reg[0]['tcredito'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Tarjeta Débito:</strong> <?php echo $simbolo.number_format($reg[0]['tdebito'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Tarjeta Prepago:</strong> <?php echo $simbolo.number_format($reg[0]['tprepago'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Transferencia:</strong> <?php echo $simbolo.number_format($reg[0]['transferencia'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Dinero Electrónico:</strong> <?php echo $simbolo.number_format($reg[0]['electronico'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Cupón:</strong> <?php echo $simbolo.number_format($reg[0]['cupon'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Otros:</strong> <?php echo $simbolo.number_format($reg[0]['otros'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Crédito:</strong> <?php echo $simbolo.number_format($reg[0]['creditos'], 2, '.', ','); ?></td>
  </tr>

  <tr>
    <td><hr><h4 class="card-subtitle m-0 text-dark"><i class="mdi mdi-cart-plus"></i> Abonos de Créditos</h4><hr></td>
  </tr>

  <tr>
    <td><strong>Abonos Efectivo:</strong> <?php echo $simbolo.number_format($reg[0]['abonosefectivo'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Abonos Otros:</strong> <?php echo $simbolo.number_format($reg[0]['abonosotros'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Propinas Efectivo:</strong> <?php echo $simbolo.number_format($reg[0]['propinasefectivo'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Propinas Otros:</strong> <?php echo $simbolo.number_format($reg[0]['propinasotros'], 2, '.', ','); ?></td>
  </tr>


  <tr>
    <td><hr><h4 class="card-subtitle m-0 text-dark"><i class="mdi mdi-cash-usd"></i> Movimientos</h4><hr></td>
  </tr>

  <tr>
    <td><strong>Ingresos Efectivo:</strong> <?php echo $simbolo.number_format($reg[0]['ingresosefectivo'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Ingresos Otros:</strong> <?php echo $simbolo.number_format($reg[0]['ingresosotros'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Egresos:</strong> <?php echo $simbolo.number_format($reg[0]['egresos'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Notas de Crédito:</strong> <?php echo $simbolo.number_format($reg[0]['egresonotas'], 2, '.', ','); ?></td>
  </tr>

  <tr>
    <td><hr><h4 class="card-subtitle m-0 text-dark"><i class="mdi mdi-scale-balance"></i> Balance en Caja</h4><hr></td>
  </tr>

  <tr>
    <td><strong>Total en Ventas:</strong> <?php echo $simbolo.number_format($TotalVentas, 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Ventas en Efectivo:</strong> <?php echo $simbolo.number_format($reg[0]['efectivo'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Ventas en Otros:</strong> <?php echo $simbolo.number_format($VentaOtros, 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Total en Efectivo:</strong> <?php echo $simbolo.number_format($TotalEfectivo, 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Total en Otros:</strong> <?php echo $simbolo.number_format($TotalOtros, 2, '.', ','); ?></td>
  </tr>

  <tr>
    <td><strong>Efectivo en Caja:</strong> <?php echo $simbolo.number_format($reg[0]['dineroefectivo'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Diferencia:</strong> <?php echo $simbolo.number_format($reg[0]['diferencia'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Observaciones:</strong> <?php echo $reg[0]['comentarios'] == '' ? "**********" : $reg[0]['comentarios']; ?></td>
  </tr>
</table>
  
  <?php
   } 
######################## MOSTRAR ARQUEO EN CAJA EN VENTANA MODAL ########################
?>


<?php
######################## BUSQUEDA ARQUEOS DE CAJA POR FECHAS ########################
if (isset($_GET['BuscaArqueosxFechas']) && isset($_GET['codcaja']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codcaja = limpiar($_GET['codcaja']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codcaja=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarArqueosxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Arqueos de Cajas por Fechas Desde <?php echo date("d-m-Y", strtotime($desde)); ?> Hasta <?php echo date("d-m-Y", strtotime($hasta)); ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("ARQUEOSXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("ARQUEOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("ARQUEOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>Caja</th>
                                  <th>Hora de Apertura</th>
                                  <th>Hora de Cierre</th>
                                  <th>Inicial</th>
                                  <th>Total Ventas</th>
                                  <th>Ventas Efectivo</th>
                                  <th>Ventas Otros</th>
                                  <th>Otros Efectivo</th>
                                  <th>Total Efectivo</th>
                                  <th>Dinero en Caja</th>
                                  <th>Diferencia</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$TotalVentas = 0;
$VentasEfectivo = 0;
$VentasOtros = 0;
$OtrosEfectivo = 0;
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

$OtrosEfectivo += $reg[$i]['ingresosefectivo']+$reg[$i]['abonosefectivo']+$reg[$i]['propinasefectivo'];

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
                                <tr>
                    <td><?php echo $a++; ?></td>
<td><abbr title="<?php echo "Responsable: ".$reg[$i]['nombres']; ?>"><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></abbr></td>
              <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaapertura'])); ?></td>
<td><?php echo $reg[$i]['fechacierre'] == '0000-00-00 00:00:00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechacierre'])); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['montoinicial'], 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['efectivo']+$reg[$i]['cheque']+$reg[$i]['tcredito']+$reg[$i]['tdebito']+$reg[$i]['tprepago']+$reg[$i]['transferencia']+$reg[$i]['electronico']+$reg[$i]['cupon']+$reg[$i]['otros'], 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['efectivo'], 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['cheque']+$reg[$i]['tcredito']+$reg[$i]['tdebito']+$reg[$i]['tprepago']+$reg[$i]['transferencia']+$reg[$i]['electronico']+$reg[$i]['cupon']+$reg[$i]['otros'], 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['ingresosefectivo']+$reg[$i]['abonosefectivo']+$reg[$i]['propinasefectivo'], 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['montoinicial']+$reg[$i]['efectivo']+$reg[$i]['ingresosefectivo']+$reg[$i]['abonosefectivo']+$reg[$i]['propinasefectivo']-$reg[$i]['egresos'], 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['dineroefectivo'], 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['diferencia'], 2, '.', ','); ?></td>
                                </tr>
         <tr>
           <td colspan="5"></td>
<td><?php echo $simbolo.number_format($TotalVentas, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($VentasEfectivo, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($VentasOtros, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($OtrosEfectivo, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalEfectivo, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalCaja, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDiferencia, 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
######################## BUSQUEDA ARQUEOS DE CAJAS POR FECHAS ########################
?>
















<?php
###################### MOSTRAR MOVIMIENTO EN CAJA EN VENTANA MODAL #######################
if (isset($_GET['BuscaMovimientoModal']) && isset($_GET['codmovimiento'])) { 

$reg = $new->MovimientosPorId();

  ?>
  
  <table class="table-responsive" border="0" class="text-center">
  <tr>
    <td><strong>Nombre de Caja:</strong> <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?></td>
  </tr>
  <tr>
    <td><strong>Tipo de Movimiento:</strong> <?php echo $tipo = ( $reg[0]['tipomovimiento'] == "INGRESO" ? "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> INGRESO</span>" : "<span class='badge badge-pill badge-dark'><i class='fa fa-times'></i> EGRESO</span>"); ?></td>
  </tr>
  <tr>
    <td><strong>Descripción de Movimiento:</strong> <?php echo $reg[0]['descripcionmovimiento']; ?></td>
  </tr>
  <tr>
    <td><strong>Monto de Movimiento:</strong> <?php echo $simbolo.number_format($reg[0]['montomovimiento'], 2, '.', ','); ?></td>
    </tr>
  <tr>
    <td><strong>Medio de Movimiento:</strong> <?php echo $reg[0]['mediomovimiento']; ?></td>
  </tr>
  <tr>
    <td><strong>Fecha Movimiento:</strong> <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechamovimiento'])); ?></td>
  </tr>
  <tr>
    <td><strong>Responsable:</strong> <?php echo $reg[0]['dni'].": ".$reg[0]['nombres']; ?></td>
  </tr>
</table>
  
  <?php
   } 
###################### MOSTRAR MOVIMIENTO EN CAJA EN VENTANA MODAL ######################
?>




<?php
######################## BUSQUEDA MOVIMIENTOS DE CAJA POR FECHAS ########################
if (isset($_GET['BuscaMovimientosxFechas']) && isset($_GET['codcaja']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codcaja = limpiar($_GET['codcaja']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codcaja=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarMovimientosxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Movimientos en Cajas por Fechas Desde <?php echo date("d-m-Y", strtotime($desde)); ?> Hasta <?php echo date("d-m-Y", strtotime($hasta)); ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("MOVIMIENTOSXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("MOVIMIENTOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("MOVIMIENTOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>Nº de Caja</th>
                                  <th>Responsable</th>
                                  <th>Tipo Movimiento</th>
                                  <th>Descripción</th>
                                  <th>Monto</th>
                                  <th>Medio de Movimiento</th>
                                  <th>Fecha Movimiento</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
                                <tr>
                    <td><?php echo $a++; ?></td>
              <td><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></td>
              <td><?php echo $reg[$i]['nombres']; ?></td>
<td><?php echo $tipo = ( $reg[$i]['tipomovimiento'] == 'INGRESO' ? "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]['tipomovimiento']."</span>" : "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> ".$reg[$i]['tipomovimiento']."</span>"); ?></td>
<td><?php echo $reg[$i]['descripcionmovimiento']; ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['montomovimiento'], 2, '.', ','); ?></td>
              <td><?php echo $reg[$i]['mediomovimiento']; ?></td>
              <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechamovimiento'])); ?></td>
                                </tr>
                        <?php  }  ?>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
######################## BUSQUEDA MOVIMIENTOS DE CAJAS POR FECHAS ########################
?>

























<?php
##################################################################################################################
#                                                                                                                #
#                                         FUNCIONES PARA ACTUALIZAR VENTAS                                       #
#                                                                                                                #
##################################################################################################################
?>

<?php
################### MUESTRA MODAL CIERRE VENTA UPDATE ########################
if (isset($_GET['CargaModalCierreVentaUpdate']) && isset($_GET['codpedido']) && isset($_GET['codventa']) && isset($_GET['descuento']) && isset($_GET['totaldescuento']) && isset($_GET['totalpago'])) {

$new = new Login();
$reg = $new->VentasPorId(); 

$codpedido = limpiar(decrypt($_GET['codpedido']));
$codventa = limpiar(decrypt($_GET['codventa']));
$totalpago = limpiar($_GET['totalpago']);
  
?>
    
      <div class="row">
        <div class="col-md-12">
          <div class="form-group has-feedback">
            <label class="control-label"><h4 class="mb-0 font-light">Búsqueda de Cliente: </h4></label>
            <input type="hidden" name="codcliente" id="codcliente" value="<?php echo $reg[0]['codcliente'] == '' ? "0" : $reg[0]['codcliente']; ?>">
            <input type="text" class="form-control" name="busqueda" id="busqueda" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Criterio para la Búsqueda del Cliente" value="<?php echo $reg[0]['codcliente'] == '' ? "CONSUMIDOR FINAL" : $documento = ($reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento']).": ".$reg[0]['dnicliente'].": ".$reg[0]['nomcliente']; ?>" autocomplete="off"/>
            <i class="fa fa-search form-control-feedback"></i>
          </div>
        </div> 
      </div>

      <div class="row">
        <div class="col-md-4">
          <h4 class="mb-0 font-light">Total a Pagar</h4>
          <h4 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TotalImporte" name="TotalImporte"><?php echo number_format($totalpago, 2, '.', ',') ?></label></h4>
        </div>

        <div class="col-md-4">
          <h4 class="mb-0 font-light">Total Recibido</h4>
          <h4 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TotalPagado" name="TotalPagado"><?php echo number_format($totalpago, 2, '.', ',') ?></label></h4>
        </div>

        <div class="col-md-4">
          <h4 class="mb-0 font-light">Total Cambio</h4>
          <h4 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TextCambio" name="TextCambio">0.00</label></h4>
        </div>
      </div>
             
      <div class="row">
        <div class="col-md-8">
          <h4 class="mb-0 font-light">Nombre del Cliente</h4>
          <h4 class="mb-0 font-medium"> <label id="TextCliente" name="TextCliente"><?php echo $reg[0]['codcliente'] == '0' || $reg[0]['codcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente']; ?></label></h4>
        </div>

        <div class="col-md-4">
          <h4 class="mb-0 font-light">Limite de Crédito</h4>
          <h4 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TextCredito" name="TextCredito">0.00</label></h4>
        </div>
      </div>
      <hr>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label class="control-label">Tipo de Documento: <span class="symbol required"></span></label><br>

            <div class="form-check form-check-inline">
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="ticket" name="tipodocumento" value="TICKET" <?php if (isset($reg[0]['tipodocumento']) && $reg[0]['tipodocumento'] == "TICKET") { ?> checked="checked" <?php } ?>>
                <label class="custom-control-label" for="ticket">TICKET</label>
              </div>
            </div>

            <div class="form-check form-check-inline">
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="boleta" name="tipodocumento" value="BOLETA" <?php if (isset($reg[0]['tipodocumento'])) { ?> <?php if($reg[0]['tipodocumento'] == "BOLETA") { ?> value="BOLETA" checked="checked" <?php } } else { ?> checked="checked" <?php } ?>>
                <label class="custom-control-label" for="boleta">BOLETA</label>
              </div>
            </div>

            <div class="form-check form-check-inline">
              <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" id="factura" name="tipodocumento" value="FACTURA" <?php if (isset($reg[0]['tipodocumento']) && $reg[0]['tipodocumento'] == "FACTURA") { ?> checked="checked" <?php } ?>>
                <label class="custom-control-label" for="factura">FACTURA</label>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
            <label class="control-label">Condición de Pago: <span class="symbol required"></span></label>
            <input type="hidden" name="iva" id="iva" value="<?php echo $detalle[0]['iva']; ?>"/>
            <input type="hidden" name="totaliva" id="totaliva" value="<?php echo $reg[0]['totaliva']; ?>"/>
            <input type="hidden" name="txtImporte" id="txtImporte" value="<?php echo $totalpago; ?>"/>
            <input type="hidden" name="txtTotal" id="txtTotal" value="<?php echo $totalpago; ?>"/>
            <input type="hidden" name="fechaventa" id="fechaventa" value="<?php echo date("Y-m-d",strtotime($detalle[0]['fechaventa'])); ?>"/>

 
            <input type="hidden" name="subtotalivasi" id="subtotalivasi" value="<?php echo $detalle[0]['subtotalivasi']; ?>"/>
            <input type="hidden" name="subtotalivano" id="subtotalivano" value="<?php echo $detalle[0]['subtotalivano']; ?>"/>
            <input type="hidden" name="iva" id="iva" value="<?php echo $detalle[0]['iva']; ?>"/>
            <input type="hidden" name="totaliva" id="totaliva" value="<?php echo $detalle[0]['totaliva']; ?>"/>
            <input type="hidden" name="txtImporte" id="txtImporte" value="<?php echo $totalpago; ?>"/>
            <input type="hidden" name="txtTotalPago" id="txtTotalPago" value="<?php echo $totalpago; ?>"/>

            <input type="hidden" name="fechaventa" id="fechaventa" value="<?php echo date("Y-m-d",strtotime($detalle[0]['fechaventa'])); ?>"/>
            <div class="custom-control custom-radio">
              <input type="radio" class="custom-control-input" id="contado" name="tipopago" value="CONTADO" onClick="CargaCondicionesPagos()" 
              <?php if (isset($reg[0]['tipopago'])) { ?> <?php if($reg[0]['tipopago'] == "CONTADO") { ?> value="CONTADO" checked="checked" <?php } } else { ?> checked="checked"  <?php } ?>>
              <label class="custom-control-label" for="contado">CONTADO</label>
            </div>

            <div class="custom-control custom-radio">
              <input type="radio" class="custom-control-input" id="credito" name="tipopago" value="CREDITO" onClick="CargaCondicionesPagos()" <?php if (isset($reg[0]['tipopago']) && $reg[0]['tipopago'] == "CREDITO") { ?> checked="checked" <?php } ?>>
              <label class="custom-control-label" for="credito">CRÉDITO</label>
            </div>
          </div>
        </div>
      </div>

  <div id="condiciones"><!-- IF CONDICION PAGO -->

      <div class="row">
        <div class="col-md-6"> 
          <div class="form-group has-feedback"> 
              <label class="control-label">Forma de Pago Nº 1: <span class="symbol required"></span></label>
              <i class="fa fa-bars form-control-feedback"></i>
              <select name="formapago" id="formapago" class="form-control" required="" aria-required="true">
              <option value=""> -- SELECCIONE -- </option>
              <option value="EFECTIVO"<?php if (!(strcmp('EFECTIVO', $reg[0]['formapago']))) {echo "selected=\"selected\"";} ?>>EFECTIVO</option>
              <option value="CHEQUE"<?php if (!(strcmp('CHEQUE', $reg[0]['formapago']))) {echo "selected=\"selected\"";} ?>>CHEQUE</option>
              <option value="TARJETA DE CREDITO"<?php if (!(strcmp('TARJETA DE CREDITO', $reg[0]['formapago']))) {echo "selected=\"selected\"";} ?>>TARJETA DE CRÉDITO</option>
              <option value="TARJETA DE DEBITO"<?php if (!(strcmp('TARJETA DE DEBITO', $reg[0]['formapago']))) {echo "selected=\"selected\"";} ?>>TARJETA DE DÉBITO</option>
              <option value="TARJETA PREPAGO"<?php if (!(strcmp('TARJETA PREPAGO', $reg[0]['formapago']))) {echo "selected=\"selected\"";} ?>>TARJETA PREPAGO</option>
              <option value="TRANSFERENCIA"<?php if (!(strcmp('TRANSFERENCIA', $reg[0]['formapago']))) {echo "selected=\"selected\"";} ?>>TRANSFERENCIA</option>
              <option value="DINERO ELECTRONICO"<?php if (!(strcmp('DINERO ELECTRONICO', $reg[0]['formapago']))) {echo "selected=\"selected\"";} ?>>DINERO ELECTRÓNICO</option>
              <option value="CUPON"<?php if (!(strcmp('CUPON', $reg[0]['formapago']))) {echo "selected=\"selected\"";} ?>>CUPÓN</option>
              <option value="OTROS"<?php if (!(strcmp('OTROS', $reg[0]['formapago']))) {echo "selected=\"selected\"";} ?>>OTROS</option>
              </select>
            </div> 
        </div>

        <div class="col-md-6"> 
          <div class="form-group has-feedback"> 
            <label class="control-label">Monto de Pago Nº 1: <span class="symbol required"></span></label>
            <input type="hidden" name="montodevuelto" id="montodevuelto" value="0.00">
            <input class="form-control" type="text" name="totalpagado" id="totalpagado" onKeyUp="DevolucionVenta();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" autocomplete="off" placeholder="Monto de Pago Nº 1" value="<?php echo $totalpago; ?>" required="" aria-required="true"> 
            <i class="fa fa-dollar form-control-feedback"></i>
          </div> 
        </div>
      </div>

      <div class="row">
        <div class="col-md-6"> 
            <div class="form-group has-feedback"> 
              <label class="control-label">Forma de Pago Nº 2: </label>
              <i class="fa fa-bars form-control-feedback"></i>
              <select name="formapago2" id="formapago2" class="form-control" onchange="ActivaMontoPago();" required="" aria-required="true">
              <option value=""> -- SELECCIONE -- </option>
              <option value="EFECTIVO">EFECTIVO</option>
              <option value="CHEQUE">CHEQUE</option>
              <option value="TARJETA DE CREDITO">TARJETA DE CRÉDITO</option>
              <option value="TARJETA DE DEBITO">TARJETA DE DÉBITO</option>
              <option value="TARJETA PREPAGO">TARJETA PREPAGO</option>
              <option value="TRANSFERENCIA">TRANSFERENCIA</option>
              <option value="DINERO ELECTRONICO">DINERO ELECTRÓNICO</option>
              <option value="CUPON">CUPÓN</option>
              <option value="OTROS">OTROS</option>
              </select>
            </div> 
        </div>

        <div class="col-md-6"> 
          <div class="form-group has-feedback"> 
            <label class="control-label">Monto de Pago Nº 2: </label>
            <input class="form-control" type="text" name="totalpagado2" id="totalpagado2" onKeyUp="DevolucionVenta();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" autocomplete="off" placeholder="Monto de Pago Nº 2" value="0.00" disabled="" required="" aria-required="true"> 
            <i class="fa fa-dollar form-control-feedback"></i>
          </div>  
      </div>
        </div>

      <div class="row">
        <div class="col-md-6"> 
          <div class="form-group has-feedback"> 
              <label class="control-label">Pago de Propina: </label>
              <i class="fa fa-bars form-control-feedback"></i>
              <select name="formapropina" id="formapropina" class="form-control" onchange="ActivaPropina();" required="" aria-required="true">
              <option value=""> -- SELECCIONE -- </option>
              <option value="EFECTIVO">EFECTIVO</option>
              <option value="CHEQUE">CHEQUE</option>
              <option value="TARJETA DE CREDITO">TARJETA DE CRÉDITO</option>
              <option value="TARJETA DE DEBITO">TARJETA DE DÉBITO</option>
              <option value="TARJETA PREPAGO">TARJETA PREPAGO</option>
              <option value="TRANSFERENCIA">TRANSFERENCIA</option>
              <option value="DINERO ELECTRONICO">DINERO ELECTRÓNICO</option>
              <option value="CUPON">CUPÓN</option>
              <option value="OTROS">OTROS</option>
              </select>
            </div> 
        </div>

        <div class="col-md-6"> 
          <div class="form-group has-feedback"> 
            <label class="control-label">Propina Recibida: </label>
            <input class="form-control number" type="text" name="montopropina" id="montopropina" onKeyUp="DevolucionVenta();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" autocomplete="off" placeholder="Propina Recibida" value="0.00" disabled="" required="" aria-required="true"> 
            <i class="fa fa-dollar form-control-feedback"></i>
          </div> 
        </div>
      </div>

      <div class="row">
        <div class="col-md-12"> 
          <div class="form-group has-feedback2"> 
            <label class="control-label">Observaciones: </label> 
            <textarea class="form-control" type="text" name="observaciones" id="observaciones" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Observaciones" rows="1"></textarea>
            <i class="fa fa-comment-o form-control-feedback2"></i> 
          </div> 
        </div>
      </div> 

    </div><!-- END CONDICION PAGO -->

<?php
}
######################## MUESTRA MODAL CIERRE VENTA UPDATE ########################
?>


<?php
##################################################################################################################
#                                                                                                                #
#                                         FUNCIONES PARA ACTUALIZAR VENTAS                                       #
#                                                                                                                #
##################################################################################################################
?>


<?php
######################## MOSTRAR VENTAS EN VENTANA MODAL ########################
if (isset($_GET['BuscaVentaModal']) && isset($_GET['codventa'])) { 
 
$reg = $new->VentasPorId();

  if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON VENTAS Y DETALLES ACTUALMENTE </center>";
    echo "</div>";    

} else {
?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-danger">RAZÓN SOCIAL</b></h4>
  <p class="text-muted m-l-5"><?php echo $con[0]['nomsucursal']; ?>,
  <br/> Nº <?php echo $con[0]['documsucursal'] == '0' ? "DOCUMENTO" : $con[0]['documento']; ?>: <?php echo $con[0]['cuit']; ?> - TLF: <?php echo $con[0]['tlfsucursal']; ?></p>

  <h4><b class="text-danger">Nº <?php echo $reg[0]['tipodocumento'].": ".$reg[0]['codfactura']; ?></b></h4>
  <p class="text-muted m-l-5">Nº SERIE: <?php echo $reg[0]['codserie']; ?>

  <?php if($reg[0]['codmesa']!= '0') { ?>
  <br><?php echo $reg[0]['nomsala'].": ".$reg[0]['nommesa']; ?>
  <?php } ?>

  <br>Nº DE CAJA: <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?>
  
  <?php if($reg[0]['fechavencecredito']!= "0000-00-00") { ?>
  <br>DIAS VENCIDOS: 
  <?php if($reg[0]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[0]['fechavencecredito'] >= date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito']); }
        elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[0]['fechapagado'],$reg[0]['fechavencecredito']); } ?>
  <?php } ?>

  <br>STATUS: 
  <?php if($reg[0]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[0]["statusventa"]."</span>"; } 
      elseif($reg[0]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[0]["statusventa"]."</span>"; }
      elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00" && $reg[0]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[0]["statusventa"]."</span>"; } ?>
  
  <?php if($reg[0]['fechapagado']!= "0000-00-00") { ?>
  <br>FECHA PAGADA: <?php echo date("d-m-Y",strtotime($reg[0]['fechapagado'])); ?>
  <?php } ?>

  <br>FECHA DE EMISIÓN: <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechaventa'])); ?></p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
  <h4><b class="text-danger">CLIENTE</b></h4>
  <p class="text-muted m-l-30"><?php echo $reg[0]['nomcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente']; ?>,
  <br/>DIREC: <?php echo $reg[0]['direccliente'] == '' ? "*********" : $reg[0]['direccliente']; ?> <?php echo $reg[0]['provincia'] == '' ? "*********" : strtoupper($reg[0]['provincia']); ?> <?php echo $reg[0]['departamento'] == '' ? "*********" : strtoupper($reg[0]['departamento']); ?>
  <br/> EMAIL: <?php echo $reg[0]['emailcliente'] == '' ? "**********************" : $reg[0]['emailcliente']; ?>
  <br/> Nº <?php echo $reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento']; ?>: <?php echo $reg[0]['dnicliente'] == '' ? "**********************" : $reg[0]['dnicliente']; ?> - TLF: <?php echo $reg[0]['tlfcliente'] == '' ? "**********************" : $reg[0]['tlfcliente']; ?></p>
                                            
                                        </address>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-10" style="clear: both;">
                                        <table class="table2 table-hover">
                               <thead>
                        <tr>
                        <th>#</th>
                        <th class="text-left">Descripción de Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
<?php if ($_SESSION['acceso'] == "administrador") { ?><th><span class="mdi mdi-drag-horizontal"></span></th><?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesVentas();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto'];
?>
                                                <tr>
      <td><label><?php echo $a++; ?></label></td>
      <td class="text-left"><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5>
      <small class="text-danger alert-link"><?php echo $detalle[$i]['codcategoria'] == '0' ? "**********" : $detalle[$i]['nomcategoria'] ?></small></td>
      <td><?php echo $detalle[$i]['cantventa']; ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><strong><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</strong></sup></td>
      <td><?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($reg[0]['iva'], 2, '.', ',')."%" : "(E)"; ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
 <?php if ($_SESSION['acceso'] == "administrador") { ?><td>
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarDetallesVentaModal('<?php echo encrypt($detalle[$i]["coddetalleventa"]); ?>','<?php echo encrypt($detalle[$i]["codventa"]); ?>','<?php echo encrypt($reg[0]["codcliente"]); ?>','<?php echo encrypt("DETALLESVENTAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                                </tr>
                                      <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="col-md-12">

                                    <div class="pull-right text-right">
<p><b>Subtotal:</b> <?php echo $simbolo.number_format($SubTotal, 2, '.', ','); ?></p>
<p><b>Total Grabado <?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivasi'], 2, '.', ','); ?><p>
<p><b>Total Exento 0%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivano'], 2, '.', ','); ?></p>
<p><b>Total <?php echo $impuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaliva'], 2, '.', ','); ?> </p>
<p><b>Descontado %:</b> <?php echo $simbolo.number_format($reg[0]['descontado'], 2, '.', ','); ?> </p>
<p><b>Desc. Global (<?php echo $reg[0]['descuento']; ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaldescuento'], 2, '.', ','); ?> </p>
<p><b>Costo Delivery:</b> <?php echo $simbolo.number_format($reg[0]['montodelivery'], 2, '.', ','); ?> </p>
<p><b>Total Propina:</b> <?php echo $simbolo.number_format($reg[0]['montopropina'], 2, '.', ','); ?> </p>
                                        <hr>
<h4><b>Importe Total:</b> <?php echo $simbolo.number_format($reg[0]['totalpago'], 2, '.', ','); ?></h4></div>
                                    <div class="clearfix"></div>
                                    <hr>

                                <div class="col-md-12">
                                    <div class="text-right">
 <?php if($reg[0]['statusventa'] != "ANULADA"){ ?><a href="reportepdf?codventa=<?php echo encrypt($reg[0]['codventa']); ?>&tipo=<?php echo encrypt($reg[0]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn waves-light btn-light" type="button"><span><i class="fa fa-print"></i> Imprimir</span></button></a><?php } ?>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                                    </div>
                                </div>
                            </div>
                <!-- .row -->
  <?php
       }
   } 
######################## MOSTRAR VENTAS EN VENTANA MODAL ########################
?>


<?php
######################## MOSTRAR DETALLES DE VENTAS UPDATE ########################
if (isset($_GET['MuestraDetallesVentasUpdate']) && isset($_GET['codventa'])) { 
 
$reg = $new->VentasPorId();

?>

<div class="table-responsive m-t-20">
            <table class="table2 table-hover">
                <thead>
                    <tr class="text-center">
                        <th>Cantidad</th>
                        <th>Código</th>
                        <th class="text-left">Descripción de Producto</th>
                        <th>Precio Unit.</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
<?php if ($_SESSION['acceso'] == "administrador") { ?><th><span class="mdi mdi-drag-horizontal"></span></th><?php } ?>
                    </tr>
                </thead>
                <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesVentas();
$a=1;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){ 
$count++;
?>
            <tr class="text-center">
      
      <td><input type="text" step="0.01" min="0.50" class="form-control cantidad bold" name="cantventa[]" id="cantventa_<?php echo $count; ?>" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoVenta(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" value="<?php echo $detalle[$i]["cantventa"]; ?>" style="width: 80px;background:#e4e7ea;border-radius:5px 5px 5px 5px;" onfocus="this.style.background=('#B7F0FF')" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', ''); this.style.background=('#e4e7ea');" title="Ingrese Cantidad" required="" aria-required="true">
    <input type="hidden" name="cantidadventabd[]" id="cantidadventabd" value="<?php echo $detalle[$i]["cantventa"]; ?>">
    <input type="hidden" name="coddetalleventa[]" id="coddetalleventa" value="<?php echo $detalle[$i]["coddetalleventa"]; ?>">
    <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $detalle[$i]["codproducto"]; ?>">
    <input type="hidden" name="tipo[]" id="tipo" value="<?php echo $detalle[$i]["tipo"]; ?>">
    <input type="hidden" class="preciocompra" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>"></td>
      
    <td><label><?php echo $detalle[$i]['codproducto']; ?></label></td>
      
    <td class="text-left"><label><h5><?php echo $detalle[$i]['producto']; ?></h5>
      <small class="text-danger alert-link"><?php echo $detalle[$i]['detallesobservaciones'] == '' ? "**********" : $detalle[$i]['detallesobservaciones'] ?></small></label></td>
      
    <td><input type="hidden" class="precioventa" name="precioventa[]" id="precioventa_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>"><?php echo number_format($detalle[$i]["precioventa"], 2, '.', ','); ?></td>

    <td><input type="hidden" name="valortotal[]" id="valortotal_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["valortotal"], 2, '.', ''); ?>"><label id="txtvalortotal_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></label></td>
      
    <td><input type="hidden" name="descproducto[]" id="descproducto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["descproducto"], 2, '.', ''); ?>">
        <input type="hidden" class="totaldescuentov" name="totaldescuentov[]" id="totaldescuentov_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["totaldescuentov"], 2, '.', ''); ?>">
        <label id="txtdescproducto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?></label><sup><label><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</label></sup></td>

    <td><input type="hidden" name="ivaproducto[]" id="ivaproducto_<?php echo $count; ?>" value="<?php echo $detalle[$i]["ivaproducto"]; ?>"><?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($reg[0]['iva'], 2, '.', '')."%" : "(E)"; ?></td>

      <td><input type="hidden" class="subtotalivasi" name="subtotalivasi[]" id="subtotalivasi_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

        <input type="hidden" class="subtotalivano" name="subtotalivano[]" id="subtotalivano_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == 'NO' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

        <input type="hidden" class="valorneto" name="valorneto[]" id="valorneto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?>" >

        <input type="hidden" class="valorneto2" name="valorneto2[]" id="valorneto2_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto2'], 2, '.', ''); ?>" >

        <label id="txtvalorneto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></label></td>

 <?php if ($_SESSION['acceso'] == "administrador") { ?><td>
<button type="button" class="btn btn-dark btn-rounded" onClick="EliminarDetallesVentaUpdate('<?php echo encrypt($detalle[$i]["coddetalleventa"]); ?>','<?php echo encrypt($detalle[$i]["codventa"]); ?>','<?php echo encrypt($reg[0]["codcliente"]); ?>','<?php echo encrypt("DETALLESVENTAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>

                                 </tr>
                     <?php } ?>
                </tbody>
            </table><hr>

             <table id="carritototal" class="table-responsive">
            <tr>
    <td width="250"><h5><label>Gravado <?php echo $reg[0]['iva'] ?>%:</label></h5></td>
    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal" name="lblsubtotal"><?php echo number_format($reg[0]['subtotalivasi'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtsubtotal" id="txtsubtotal" value="<?php echo number_format($reg[0]['subtotalivasi'], 2, '.', ''); ?>"/>    </td>
                  
    <td width="250">
    <h5><label>Exento 0%:</label></h5>    
    </td>

    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal2" name="lblsubtotal2"><?php echo number_format($reg[0]['subtotalivano'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtsubtotal2" id="txtsubtotal2" value="<?php echo number_format($reg[0]['subtotalivano'], 2, '.', ''); ?>"/>    </td>
    
    <td width="250"><h5><label><?php echo $impuesto; ?> <?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>%:<input type="hidden" name="iva" id="iva" autocomplete="off" value="<?php echo $reg[0]['iva'] ?>"></label></h5>
    </td>

    <td class="text-center" width="250">
    <h5><?php echo $simbolo; ?><label id="lbliva" name="lbliva"><?php echo number_format($reg[0]['totaliva'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtIva" id="txtIva" value="<?php echo number_format($reg[0]['totaliva'], 2, '.', ''); ?>"/>
    </td>
    </tr>
    <tr>
    <td>
    <h5><label>Descontado %:</label></h5> </td>
    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescontado" name="lbldescontado"><?php echo number_format($reg[0]['descontado'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtdescontado" id="txtdescontado" value="<?php echo number_format($reg[0]['descontado'], 2, '.', ''); ?>"/>
        </td>
    
    <td>
    <h5><label>Desc. Global <input class="number" type="text" name="descuento" id="descuento" onKeyPress="EvaluateText('%f', this);" style="border-radius:4px;height:30px;width:60px;" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($reg[0]['descuento'], 2, '.', ''); ?>">%:</label></h5>    </td>

    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescuento" name="lbldescuento"><?php echo number_format($reg[0]['totaldescuento'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtDescuento" id="txtDescuento" value="<?php echo number_format($reg[0]['totaldescuento'], 2, '.', ''); ?>"/>    </td>

    <td><h4><b>Importe Total</b></h4>
    </td>

    <td class="text-center">
    <h4><b><?php echo $simbolo; ?><label id="lbltotal" name="lbltotal"><?php echo number_format($reg[0]['totalpago'], 2, '.', ''); ?></label></b></h4>
    <input type="hidden" name="txtTotal" id="txtTotal" value="<?php echo number_format($reg[0]['totalpago'], 2, '.', ''); ?>"/>
    <input type="hidden" name="txtTotal2" id="txtTotal2" value="<?php echo number_format($reg[0]['totalpago'], 2, '.', ''); ?>"/>
    <input type="hidden" name="txtTotalCompra" id="txtTotalCompra" value="<?php echo number_format($reg[0]['totalpago2'], 2, '.', ''); ?>"/>    </td>
                    </tr>
    </table>
        </div>
<?php
  } 
######################## MOSTRAR DETALLES DE VENTAS UPDATE ########################
?>

<?php
######################## MOSTRAR DETALLES DE VENTAS AGREGAR ########################
if (isset($_GET['MuestraDetallesVentasAgregar']) && isset($_GET['codventa'])) { 
 
$reg = $new->VentasPorId();
?>

<div class="table-responsive m-t-20">
            <table class="table2 table-hover">
                <thead>
                    <tr class="text-center">
                        <th>Nº</th>
                        <th>Código</th>
                        <th class="text-left">Descripción de Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unit.</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
<?php if ($_SESSION['acceso'] == "administrador") { ?><th>Acción</th><?php } ?>
                    </tr>
                </thead>
                <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesVentas();
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
    ?>
                                 <tr class="text-center">
      <td><label><?php echo $a++; ?></label></td>
      
      <td><label><?php echo $detalle[$i]['codproducto']; ?></label></td>

      <td class="text-left"><h5><label><?php echo $detalle[$i]['producto']; ?></label></h5>
      <small class="text-danger alert-link"><?php echo $detalle[$i]['detallesobservaciones'] == '' ? "**********" : $detalle[$i]['detallesobservaciones'] ?></small></td>

      <td><?php echo $detalle[$i]['cantventa']; ?></td>
      
      <td><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>

       <td><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
      
      <td><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><label><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</label></sup></td>

      <td><?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($reg[0]['iva'], 2, '.', ',')."%" : "(E)"; ?></td>

      <td><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>

 <?php if ($_SESSION['acceso'] == "administrador") { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesVentaAgregar('<?php echo encrypt($detalle[$i]["coddetalleventa"]); ?>','<?php echo encrypt($detalle[$i]["codventa"]); ?>','<?php echo encrypt($reg[0]["codcliente"]); ?>','<?php echo encrypt("DETALLESVENTAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                 </tr>
                     <?php } ?>
                </tbody>
            </table><hr>

            <table id="carritototal" class="table-responsive">
                <tr>
    <td width="250"><h5><label>Gravado <?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%:</label></h5></td>
    <td width="250">
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['subtotalivasi'], 2, '.', ','); ?></label></h5>
    </td>
                  
    <td width="250">
    <h5><label>Exento 0%:</label></h5>    </td>

    <td width="250">
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['subtotalivano'], 2, '.', ','); ?></label></h5>
    </td>
    
    <td width="250"><h5><label><?php echo $impuesto; ?> <?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%:</label></h5>
    </td>

    <td class="text-center" width="250">
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['totaliva'], 2, '.', ','); ?></label></h5>
    </td>
                </tr>
                <tr>
    <td>
    <h5><label>Descontado %:</label></h5> </td>
    <td>
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['descontado'], 2, '.', ','); ?></label></h5>
    </td>
    
    <td>
    <h5><label>Desc. Global <?php echo number_format($reg[0]['descuento'], 2, '.', ','); ?>%:</label></h5>
    </td>

    <td>
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['totaldescuento'], 2, '.', ','); ?></label></h5>
    </td>

    <td><h4><b>Importe Total</b></h4>
    </td>

    <td class="text-center">
    <h4><b><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['totalpago'], 2, '.', ','); ?></label></b></h4>
    </td>
                    </tr>
                  </table>

        </div>
<?php
  } 
######################## MOSTRAR DETALLES DE VENTAS AGREGRAR ########################
?>


<?php
######################## BUSQUEDA VENTAS POR CAJAS ########################
if (isset($_GET['BuscaVentasxCajas']) && isset($_GET['codcaja']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codcaja = limpiar($_GET['codcaja']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codcaja=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarVentasxCajas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Ventas en Caja <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("VENTASXCAJAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("VENTASXCAJAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("VENTASXCAJAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Venta</th>
                                  <th>Descripción de Cliente</th>
                                  <th>Status</th>
                                  <th>Fecha Emisión</th>
                                  <th>Nº de Articulos</th>
                                  <th>Subtotal</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc %</th>
                                  <th>Imp. Total</th>
                                  <th><i class="mdi mdi-drag-horizontal"></i></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo substr($reg[$i]["tipodocumento"], 0, 1)."".$reg[$i]["codfactura"]; ?></td>
  <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td>
  <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
  <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
 <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  <td><?php if($reg[$i]['statusventa'] != "ANULADA"){ ?><a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a><?php } else { ?><span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ANULADA</span><?php } ?></td>
                                  </tr>
                        <?php  }  ?>
         <tr>
           <td colspan="5"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
######################## BUSQUEDA VENTAS POR CAJAS ########################
?>


<?php
######################## BUSQUEDA VENTAS POR FECHAS ########################
if (isset($_GET['BuscaVentasxFechas']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarVentasxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Ventas por Fechas Desde <?php echo date("d-m-Y", strtotime($desde)); ?> Hasta <?php echo date("d-m-Y", strtotime($hasta)); ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("VENTASXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("VENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("VENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Venta</th>
                                  <th>Descripción de Cliente</th>
                                  <th>Status</th>
                                  <th>Fecha Emisión</th>
                                  <th>Forma de Pago #1</th>
                                  <th>Forma de Pago #2</th>
                                  <th>Nº de Articulos</th>
                                  <th>Subtotal</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc %</th>
                                  <th>Imp. Total</th>
                                  <th><i class="mdi mdi-drag-horizontal"></i></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo substr($reg[$i]["tipodocumento"], 0, 1)."".$reg[$i]["codfactura"]; ?></td>
  <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td>
  <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
  <td><?php echo $reg[$i]['formapago'] == "0" ? "**********" : $reg[$i]['formapago']; ?></td>
  <td><?php echo $reg[$i]['formapago2'] == "0" ? "**********" : $reg[$i]['formapago2']; ?></td>
  <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
 <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  <td><?php if($reg[$i]['statusventa'] != "ANULADA"){ ?><a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a><?php } else { ?><span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ANULADA</span><?php } ?></td>
                                  </tr>
                        <?php  }  ?>
         <tr>
           <td colspan="7"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
######################## BUSQUEDA VENTAS POR FECHAS ########################
?>

<?php
######################## BUSQUEDA VENTAS CONDICION DE PAGO Y FECHAS ########################
if (isset($_GET['BuscaVentasxCondiciones']) && isset($_GET['formapago']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $formapago = limpiar($_GET['formapago']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($formapago=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE FORMA DE PAGO PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarVentasxCondiciones();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Ventas de Método de Pago <?php echo $formapago; ?> y  Fechas Desde <?php echo date("d-m-Y", strtotime($desde)); ?> Hasta <?php echo date("d-m-Y", strtotime($hasta)); ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?formapago=<?php echo $formapago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("VENTASXCONDICIONES") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?formapago=<?php echo $formapago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("VENTASXCONDICIONES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?formapago=<?php echo $formapago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("VENTASXCONDICIONES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Venta</th>
                                  <th>Descripción de Cliente</th>
                                  <th>Status</th>
                                  <th>Fecha Emisión</th>
                                  <th>Forma de Pago #1</th>
                                  <th>Forma de Pago #2</th>
                                  <th>Nº de Articulos</th>
                                  <th>Subtotal</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc %</th>
                                  <th>Imp. Total</th>
                                  <th>Total Pago </th>
                                  <th><i class="mdi mdi-drag-horizontal"></i></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo substr($reg[$i]["tipodocumento"], 0, 1)."".$reg[$i]["codfactura"]; ?></td>
  <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td>
  <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
  <td><?php echo $reg[$i]['formapago'] == "0" ? "**********" : $reg[$i]['formapago']; ?></td>
  <td><?php echo $reg[$i]['formapago2'] == "0" ? "**********" : $reg[$i]['formapago2']; ?></td>
  <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
 <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  <td><?php echo $reg[$i]['formapago'] == $formapago ? $simbolo.number_format($reg[$i]['montopagado'], 2, '.', ',') : $simbolo.number_format($reg[$i]['montopagado2'], 2, '.', ','); ?></td>
  <td><?php if($reg[$i]['statusventa'] != "ANULADA"){ ?><a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a><?php } else { ?><span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ANULADA</span><?php } ?></td>
                                  </tr>
                        <?php  }  ?>
         <tr>
           <td colspan="7"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalPagado, 2, '.', ','); ?></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
######################## BUSQUEDA VENTAS POR CONDICION DE PAGO Y FECHAS ########################
?>

<?php
######################## BUSQUEDA VENTAS POR TIPOS DE CLIENTES ########################
if (isset($_GET['BuscaVentasxTipos']) && isset($_GET['tipocliente']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $tipocliente = limpiar($_GET['tipocliente']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);
  $tipo = ($tipocliente == 'NATURAL' ? "NATURALES" : "JURIDICOS");

 if($tipocliente=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE TIPO DE CLIENTE PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarVentasxTipos();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Ventas de Clientes <?php echo $tipo; ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?tipocliente=<?php echo $tipocliente; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("VENTASXTIPOS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?tipocliente=<?php echo $tipocliente; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("VENTASXTIPOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?tipocliente=<?php echo $tipocliente; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("VENTASXTIPOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Documento</th>
                                  <th>Descripción de Cliente</th>
                                  <th>Nº de Teléfono</th>
                                  <th>Cantidad Compras</th>
                                  <th>Total Compras</th>
                                  <th><i class="mdi mdi-drag-horizontal"></i></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
                                <tr>
                                  <td><?php echo $a++; ?></td>
  <td><?php echo $documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]["dnicliente"]; ?></td>
  <td><?php echo $reg[$i]['nomcliente']; ?></td>
  <td><?php echo $reg[$i]['tlfcliente'] == '' ? "*********" : $reg[$i]['tlfcliente']; ?></td>
  <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalcompras'], 2, '.', ','); ?></td>
                    <td>
<a href="reportepdf?codcliente=<?php echo $reg[$i]['codcliente']; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("VENTASXCLIENTES") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                  </tr>
                        <?php  }  ?>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
######################## BUSQUEDA VENTAS POR TIPOS DE CLIENTES ########################
?>


<?php
######################## BUSQUEDA VENTAS POR CLIENTES ########################
if (isset($_GET['BuscaVentasxClientes']) && isset($_GET['codcliente']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codcliente = limpiar($_GET['codcliente']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codcliente=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL CLIENTE CORRECTAMENTE</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarVentasxClientes();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Ventas del Clientes <?php echo $reg[0]['nomcliente']; ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codcliente=<?php echo $codcliente; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("VENTASXCLIENTES") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codcliente=<?php echo $codcliente; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("VENTASXCLIENTES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codcliente=<?php echo $codcliente; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("VENTASXCLIENTES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Venta</th>
                                  <th>Status</th>
                                  <th>Fecha Emisión</th>
                                  <th>Forma de Pago #1</th>
                                  <th>Forma de Pago #2</th>
                                  <th>Nº de Articulos</th>
                                  <th>Subtotal</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc %</th>
                                  <th>Imp. Total</th>
                                  <th><i class="mdi mdi-drag-horizontal"></i></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                <td><?php echo $a++; ?></td>
                <td><?php echo substr($reg[$i]["tipodocumento"], 0, 1)."".$reg[$i]["codfactura"]; ?></td>
                <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
                <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
  <td><?php echo $reg[$i]['formapago'] == "0" ? "**********" : $reg[$i]['formapago']; ?></td>
  <td><?php echo $reg[$i]['formapago2'] == "0" ? "**********" : $reg[$i]['formapago2']; ?></td>
               <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
 <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php if($reg[$i]['statusventa'] != "ANULADA"){ ?><a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a><?php } else { ?><span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ANULADA</span><?php } ?></td>
                                  </tr>
                        <?php  }  ?>
         <tr>
           <td colspan="6"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
######################## BUSQUEDA VENTAS POR CLIENTES ########################
?>

<?php 
########################### BUSQUEDA DELIVERY POR FECHAS ##########################
if (isset($_GET['BuscaDeliveryxFechas']) && isset($_GET['codigo']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codigo = limpiar($_GET['codigo']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codigo=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE VENDEDOR PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$delivery = new Login();
$reg = $delivery->BuscarDeliveryxFechas();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Delivery del Repartidor <?php echo $reg[0]['nombres2']; ?>  y Fecha Desde <?php echo date("d-m-Y", strtotime($desde)); ?> Hasta <?php echo date("d-m-Y", strtotime($hasta)); ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("DELIVERYXFECHAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DELIVERYXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DELIVERYXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Venta</th>
                                  <th>Descripción de Cliente</th>
                                  <th>Fecha Emisión</th>
                                  <th>Nº de Articulos</th>
                                  <th>Imp. Total</th>
                                  <th>Total Delivery</th>
                                  <th>Total Comisión</th>
                                  <th><i class="mdi mdi-drag-horizontal"></i></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo substr($reg[$i]["tipodocumento"], 0, 1)."".$reg[$i]["codfactura"]; ?></td>
  <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td>
  <td><?php echo date("d-m-Y h:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
  <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['montodelivery'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['montodelivery']*$reg[$i]['comision2']/100, 2, '.', ','); ?></td>

  <td><?php if($reg[$i]['statusventa'] != "ANULADA"){ ?><a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a><?php } else { ?><span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ANULADA</span><?php } ?></td>
                                  </tr>
                        <?php  }  ?>
         <tr>
           <td colspan="4"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDelivery, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalComision, 2, '.', ','); ?></td>
         </tr>
                            </tbody>
                        </table>
                    </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
########################### BUSQUEDA DE DELIVERY POR FECHAS ##########################
?>


<?php 
########################### BUSQUEDA COMISION POR VENDEDOR ##########################
if (isset($_GET['BuscaComisionxVentas']) && isset($_GET['codigo']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codigo = limpiar($_GET['codigo']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codigo=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE VENDEDOR PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarComisionxVentas();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Comisión del Vendedor <?php echo $reg[0]['nombres']; ?>  y Fecha Desde <?php echo date("d-m-Y", strtotime($desde)); ?> Hasta <?php echo date("d-m-Y", strtotime($hasta)); ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("COMISIONXVENTAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COMISIONXVENTAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COMISIONXVENTAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Venta</th>
                                  <th>Descripción de Cliente</th>
                                  <th>Status</th>
                                  <th>Fecha Emisión</th>
                                  <th>Nº de Articulos</th>
                                  <th>Subtotal</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc %</th>
                                  <th>Imp. Total</th>
                                  <th>Total Comisión</th>
                                  <th><i class="mdi mdi-drag-horizontal"></i></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
$TotalArticulos=0;
$TotalGravado=0;
$TotalExento=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;
$TotalComision=0;

for($i=0;$i<sizeof($reg);$i++){
   
$TotalArticulos+=$reg[$i]['articulos'];
$TotalGravado+=$reg[$i]['subtotalivasi'];
$TotalExento+=$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
$TotalComision+=$reg[$i]['totalpago']*$reg[$i]['comision']/100;
?>
                                <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo substr($reg[$i]["tipodocumento"], 0, 1)."".$reg[$i]["codfactura"]; ?></td>
  <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td>

  
  <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>

  <td><?php echo date("d-m-Y h:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
  <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
 <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago']*$reg[$i]['comision']/100, 2, '.', ','); ?></td>
  <td><?php if($reg[$i]['statusventa'] != "ANULADA"){ ?><a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a><?php } else { ?><span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ANULADA</span><?php } ?></td>
                                  </tr>
                        <?php  }  ?>
         <tr>
           <td colspan="5"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalGravado, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalExento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalComision, 2, '.', ','); ?></td>
         </tr>
                            </tbody>
                        </table>
                    </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
########################### BUSQUEDA DE COMISION POR VENDEDOR ##########################
?>












































<?php
######################## MOSTRAR VENTA DE CREDITO EN VENTANA MODAL #######################
if (isset($_GET['BuscaCreditoModal']) && isset($_GET['codventa'])) { 
 
$reg = $new->CreditosPorId();

?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-danger">RAZÓN SOCIAL</b></h4>
  <p class="text-muted m-l-5"><?php echo $con[0]['nomsucursal']; ?>,
  <br/> Nº <?php echo $con[0]['documsucursal'] == '0' ? "DOCUMENTO" : $con[0]['documento']; ?>: <?php echo $con[0]['cuit']; ?> - TLF: <?php echo $con[0]['tlfsucursal']; ?></p>

  <h4><b class="text-danger">Nº <?php echo $reg[0]['tipodocumento'].": ".$reg[0]['codfactura']; ?></b></h4>
  <p class="text-muted m-l-5">Nº DE CAJA: <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?>
  <br>TOTAL FACTURA: <?php echo $simbolo.number_format($reg[0]['totalpago'], 2, '.', ','); ?>
  <br>TOTAL ABONO: <?php echo $simbolo.number_format($reg[0]['abonototal'], 2, '.', ','); ?>
  <br>TOTAL DEBE: <?php echo $simbolo.number_format($reg[0]['totalpago']-$reg[0]['abonototal'], 2, '.', ','); ?>
  <br>DIAS VENCIDOS: 
  <?php if($reg[0]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[0]['fechavencecredito'] >= date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito']); }
        elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[0]['fechapagado'],$reg[0]['fechavencecredito']); } ?>
  <br>STATUS: 
  <?php if($reg[0]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[0]["statusventa"]."</span>"; } 
      elseif($reg[0]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[0]["statusventa"]."</span>"; }
      elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00" && $reg[0]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[0]["statusventa"]."</span>"; } ?>
  <?php if($reg[0]['fechapagado']!= "0000-00-00") { ?>
  <br>FECHA PAGADA: <?php echo date("d-m-Y",strtotime($reg[0]['fechapagado'])); ?>
  <?php } ?>
  <br>FECHA DE EMISIÓN: <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechaventa'])); ?></p>

  <h4><b class="text-danger">CLIENTE </b></h4>
  <p class="text-muted m-l-5"><?php echo $reg[0]['nomcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente']; ?>,
  <br/>DIREC: <?php echo $reg[0]['direccliente'] == '' ? "*********" : $reg[0]['direccliente']; ?> <?php echo $reg[0]['provincia'] == '' ? "*********" : strtoupper($reg[0]['provincia']); ?> <?php echo $reg[0]['departamento'] == '' ? "*********" : strtoupper($reg[0]['departamento']); ?>
  <br/> EMAIL: <?php echo $reg[0]['emailcliente'] == '' ? "**********************" : $reg[0]['emailcliente']; ?>
  <br/> Nº <?php echo $reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento']; ?>: <?php echo $reg[0]['dnicliente'] == '' ? "**********************" : $reg[0]['dnicliente']; ?> - TLF: <?php echo $reg[0]['tlfcliente'] == '' ? "**********************" : $reg[0]['tlfcliente']; ?></p>


                                        </address>
                                    </div>
                                </div>
                                
            <div class="col-md-12">
                  <div class="table-responsive m-t-10" style="clear: both;">
                      <table class="table2 table-hover">
                               <thead>
                        <tr><th colspan="5">Detalles de Abonos</th></tr>
                        <tr>
                        <th>#</th>
                        <th>Nº de Caja</th>
                        <th>Monto de Abono</th>
                        <th>Forma de Pago</th>
                        <th>Fecha de Abono</th>
                        </tr>
                                            </thead>
                                            <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesAbonos();

if($detalle==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON ABONOS ACTUALMENTE </center>";
    echo "</div>";    

} else {

$a=1;
for($i=0;$i<sizeof($detalle);$i++){  

?>
                          <tr>
                            <td><?php echo $a++; ?></td>
                            <td><?php echo $detalle[$i]['nrocaja'].": ".$detalle[$i]['nomcaja']; ?></td>
                            <td><?php echo $simbolo.number_format($detalle[$i]['montoabono'], 2, '.', ','); ?></td>
                            <td><?php echo $detalle[$i]['formaabono']; ?></td>
                            <td><?php echo date("d-m-Y H:i:s",strtotime($detalle[$i]['fechaabono'])); ?></td>
                          </tr>
                        <?php } } ?>
                              </tbody>
                          </table>
                              </div>
                                <hr>

                                <div class="col-md-12">
                                    <div class="text-right">
 <a href="reportepdf?codventa=<?php echo encrypt($reg[0]['codventa']); ?>&tipo=<?php echo encrypt("TICKETCREDITO") ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn waves-light btn-light" type="button"><span><i class="fa fa-print"></i> Imprimir</span></button></a>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                                    </div>
                                </div>
                              </div>
                <!-- .row -->
  <?php
   } 
######################## MOSTRAR VENTA DE CREDITO EN VENTANA MODAL #######################?>


<?php
######################## BUSQUEDA CREDITOS POR CLIENTES ########################
if (isset($_GET['BuscaCreditosxClientes']) && isset($_GET['codcliente'])) {
  
  $codcliente = limpiar($_GET['codcliente']);

 if($codcliente=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL CLIENTE CORRECTAMENTE</center>";
   echo "</div>";   
   exit;

} else {

$pre = new Login();
$reg = $pre->BuscarCreditosxClientes();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Créditos del Cliente <?php echo $reg[0]['dnicliente'].": ".$reg[0]['nomcliente']; ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codcliente=<?php echo $codcliente; ?>&tipo=<?php echo encrypt("CREDITOSXCLIENTES") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codcliente=<?php echo $codcliente; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CREDITOSXCLIENTES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codcliente=<?php echo $codcliente; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CREDITOSXCLIENTES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Venta</th>
                                  <th>Descripción de Cliente</th>
                                  <th>Status</th>
                                  <th>Dias Venc</th>
                                  <th>Fecha Emisión</th>
                                  <th>Imp. Total</th>
                                  <th>Total Abono</th>
                                  <th>Total Debe</th>
                                  <th><i class="mdi mdi-drag-horizontal"></i></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;

for($i=0;$i<sizeof($reg);$i++){
   
$TotalImporte+=$reg[$i]['totalpago'];
$TotalAbono+=$reg[$i]['abonototal'];
$TotalDebe+=$reg[$i]['totalpago']-$reg[$i]['abonototal'];
?>
                                <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $reg[$i]['codfactura']; ?></td>
  <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td>
      <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>

<td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['abonototal'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['abonototal'], 2, '.', ','); ?></td>
  <td> <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&tipo=<?php echo encrypt("TICKETCREDITO"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                  </tr>
                        <?php  }  ?>
         <tr>
           <td colspan="6"></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
######################## BUSQUEDA CREDITOS POR CLIENTES ########################
?>


<?php
######################## BUSQUEDA CREDITOS POR FECHAS ########################
if (isset($_GET['BuscaCreditosxFechas']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarCreditosxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Créditos por Fechas Desde <?php echo date("d-m-Y", strtotime($desde)); ?> Hasta <?php echo date("d-m-Y", strtotime($hasta)); ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("CREDITOSXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CREDITOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CREDITOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Venta</th>
                                  <th>Descripción de Cliente</th>
                                  <th>Status</th>
                                  <th>Dias Venc</th>
                                  <th>Fecha Emisión</th>
                                  <th>Imp. Total</th>
                                  <th>Total Abono</th>
                                  <th>Total Debe</th>
                                  <th><i class="mdi mdi-drag-horizontal"></i></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;

for($i=0;$i<sizeof($reg);$i++){
   
$TotalImporte+=$reg[$i]['totalpago'];
$TotalAbono+=$reg[$i]['abonototal'];
$TotalDebe+=$reg[$i]['totalpago']-$reg[$i]['abonototal'];
?>
                                <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $reg[$i]['codfactura']; ?></td>
  <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td>
      <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>

<td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['abonototal'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['abonototal'], 2, '.', ','); ?></td>
  <td> <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&tipo=<?php echo encrypt("TICKETCREDITO"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                  </tr>
                        <?php  }  ?>
         <tr>
           <td colspan="6"></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
   }
 } 
######################## BUSQUEDA CREDITOS POR FECHAS ########################
?>












































<?php
######################## MOSTRAR FACTURA PARA NOTA DE CREDITO ########################
if (isset($_GET['ProcesaNotaCredito']) && isset($_GET['numeroventa']) && isset($_GET['descontar'])) { 
 
  $numeroventa = limpiar($_GET['numeroventa']);
  $descontar = limpiar($_GET['descontar']);
  $codarqueo = limpiar(isset($_GET['codarqueo']) ? $_GET["codarqueo"] : "");
  //$codarqueo = limpiar($_GET["codarqueo"]);

  $reg = $new->BuscarVentasPorId();

 if($numeroventa=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL Nº DE DOCUMENTO CORRECTAMENTE</center>";
   echo "</div>";   
   exit;

    //} else if($descontar == 1 && $codarqueo=="") {
 	} else if(isset($_GET['codarqueo']) && $codarqueo=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

 } elseif($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> EL Nº DE DOCUMENTO INGRESADO NO SE ENCUENTRA REGISTRADO </center>";
    echo "</div>";    

} else {

?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalle de <?php echo $reg[0]['tipodocumento']." Nº: ".$reg[0]['codfactura']; ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">


          <div class="row">
            <div class="col-md-12">
              <div class="pull-left">
                <address>
  <h4><b class="text-danger">RAZÓN SOCIAL</b></h4>
  <p class="text-muted m-l-5"><?php echo $con[0]['nomsucursal']; ?>,
  <br/> Nº <?php echo $con[0]['documsucursal'] == '0' ? "DOCUMENTO" : $con[0]['documento'] ?>: <?php echo $con[0]['cuit']; ?> - TLF: <?php echo $con[0]['tlfsucursal']; ?>

  <?php 
  if(isset($_GET['codarqueo'])){ 
  $arqueo = new Login();
  $arqueo = $arqueo->ArqueoCajaPorId();
  ?>
  <br><strong>CAJA PARA NOTA CRÉDITO:</strong> <span class="text-danger alert-link"><?php echo $arqueo[0]['nrocaja'].": ".$arqueo[0]['nomcaja']; ?></span>
  <br><strong>SALDO EN CAJA:</strong> <span class="text-danger alert-link"><?php echo number_format($arqueo[0]['efectivo']-$arqueo[0]['egresos'], 2, '.', ','); ?></span>
  <?php } ?></p>

  <h4><b class="text-danger">Nº <?php echo $reg[0]['tipodocumento']." ". $reg[0]['codfactura']; ?></b></h4>
  <p class="text-muted m-l-5">Nº SERIE: <?php echo $reg[0]['codserie']; ?>

  <?php if($reg[0]['codmesa']!= '0') { ?>
  <br><?php echo $reg[0]['nomsala'].": ".$reg[0]['nommesa']; ?>
  <?php } ?>

  <br>Nº DE CAJA: <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?>
  
  <?php if($reg[0]['fechavencecredito']!= "0000-00-00") { ?>
  <br>DIAS VENCIDOS: 
  <?php if($reg[0]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[0]['fechavencecredito'] >= date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito']); }
        elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[0]['fechapagado'],$reg[0]['fechavencecredito']); } ?>
  <?php } ?>

  <br>STATUS: 
  <?php if($reg[0]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[0]["statusventa"]."</span>"; } 
      elseif($reg[0]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[0]["statusventa"]."</span>"; }
      elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00" && $reg[0]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[0]["statusventa"]."</span>"; } ?>
  
  <?php if($reg[0]['fechapagado']!= "0000-00-00") { ?>
  <br>FECHA PAGADA: <?php echo date("d-m-Y",strtotime($reg[0]['fechapagado'])); ?>
  <?php } ?>

  <br>FECHA DE EMISIÓN: <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechaventa'])); ?></p>
              </address>
            </div>
                                    
   <div class="pull-right text-right">
              <address>
  <h4><b class="text-danger">CLIENTE</b></h4>
  <p class="text-muted m-l-30"><?php echo $reg[0]['nomcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente']; ?>,
  <br/>DIREC: <?php echo $reg[0]['direccliente'] == '' ? "*********" : $reg[0]['direccliente']; ?> <?php echo $reg[0]['provincia'] == '' ? "*********" : strtoupper($reg[0]['provincia']); ?> <?php echo $reg[0]['departamento'] == '' ? "*********" : strtoupper($reg[0]['departamento']); ?>
  <br/> EMAIL: <?php echo $reg[0]['emailcliente'] == '' ? "**********************" : $reg[0]['emailcliente']; ?>
  <br/> Nº <?php echo $reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento'] ?>: <?php echo $reg[0]['dnicliente'] == '' ? "**********************" : $reg[0]['dnicliente']; ?> - TLF: <?php echo $reg[0]['tlfcliente'] == '' ? "**********************" : $reg[0]['tlfcliente']; ?></p>
              </address>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <h4><b class="text-danger">PROCEDIMIENTO</b></h4>
            
            <div class="custom-control custom-radio">
              <input type="radio" class="custom-control-input" id="evento1" name="observaciones" value="DOCUMENTO ANULADO" checked="checked">
              <label class="custom-control-label" for="evento1">DOCUMENTO ANULADO</label>
            </div>

            <div class="custom-control custom-radio">
              <input type="radio" class="custom-control-input" id="evento2" name="observaciones" value="TEXTO CORREJIDO">
              <label class="custom-control-label" for="evento2">TEXTO CORREJIDO</label>
            </div>

            <div class="custom-control custom-radio">
              <input type="radio" class="custom-control-input" id="evento3" name="observaciones" value="MONTO CORREJIDO">
              <label class="custom-control-label" for="evento3">MONTO CORREJIDO</label>
            </div>

          </div>
        </div>
      </div>
        
    </div>

        </div>
    </div>

          <div class="table-responsive m-t-20">
            <table class="table2 table-hover">
                <thead>
                    <tr>
                        <th>Devolución</th>
                        <th>Vendido</th>
                        <th class="text-left">Descripción de Producto</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
                    </tr>
                </thead>
                <tbody>
<?php 
$tra = new Login();
$detalle = $tra->BuscarDetallesVentas();

$SubTotal = 0;
$a=1;
$b=0;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto'];
$c = $b++; 
$count++; 
?>
                                 <tr>
      <td>
      <input type="text" step="1" min="0" class="form-control cantidad bold" name="devuelto[]" id="devuelto_<?php echo $count; ?>" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoDevolucion(<?php echo $count; ?>);" autocomplete="off" placeholder="Devolución" style="width: 80px;background:#e4e7ea;border-radius:5px 5px 5px 5px;" onfocus="this.style.background=('#B7F0FF')" onfocus="this.style.background=('#B7F0FF')" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', ''); this.style.background=('#e4e7ea');" title="" value="0">
      </td>

      <td><h5><strong><?php echo $detalle[$i]['cantventa']; ?></strong></h5></td>

      <td class="text-left">
      <input type="hidden" name="idproducto[]" id="idproducto" value="<?php echo $detalle[$i]["idproducto"]; ?>">
      <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $detalle[$i]["codproducto"]; ?>">
      <input type="hidden" name="producto[]" id="producto" value="<?php echo $detalle[$i]["producto"]; ?>">
      <input type="hidden" name="cantidad[]" id="cantidad_<?php echo $count; ?>" value="<?php echo $detalle[$i]["cantventa"]; ?>">
      <input type="hidden" name="coddetalleventa[]" id="coddetalleventa" value="<?php echo encrypt($detalle[$i]["coddetalleventa"]); ?>">
      <input type="hidden" name="codcategoria[]" id="codcategoria" value="<?php echo $detalle[$i]["codcategoria"]; ?>">
      <input type="hidden" name="tipo[]" id="tipo" value="<?php echo $detalle[$i]["tipo"]; ?>">
      <strong><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5>
      <small class="text-danger alert-link"><?php echo $detalle[$i]['codcategoria'] == '0' ? "**********" : $detalle[$i]['nomcategoria'] ?></small></strong></td>
      <td>
      <input type="hidden" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>">
      <input type="hidden" name="precioventa[]" id="precioventa_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>"><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ''); ?></td>
      <td>
      <input type="hidden" name="valortotal[]" id="valortotal_<?php echo $count; ?>" value="0.00">
      <strong><label id="txtvalortotal_<?php echo $count; ?>">0.00</label></strong></td>
      
      <td>
      <input type="hidden" name="descproducto[]" id="descproducto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["descproducto"], 2, '.', ''); ?>">
      <input type="hidden" class="totaldescuentov" name="totaldescuentov[]" id="totaldescuentov_<?php echo $count; ?>" value="0.00">
      <?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup>0.00%</sup></td>

      <td>
      <input type="hidden" name="ivaproducto[]" id="ivaproducto_<?php echo $count; ?>" value="<?php echo $detalle[$i]["ivaproducto"]; ?>"><?php echo $detalle[$i]['ivaproducto'] == 'SI' ? $reg[0]['iva']."%" : "(E)"; ?></td>

      <td><input type="hidden" class="subtotalivasi" name="subtotalivasi[]" id="subtotalivasi_<?php echo $count; ?>" value="0.00">

        <input type="hidden" class="subtotalivano" name="subtotalivano[]" id="subtotalivano_<?php echo $count; ?>" value="0.00">

        <input type="hidden" class="valorneto" name="valorneto[]" id="valorneto_<?php echo $count; ?>" value="0.00" >

        <strong> <label id="txtvalorneto_<?php echo $count; ?>">0.00</label></strong></td>
                                 </tr>
                     <?php } ?>
                </tbody>
            </table><hr>

    <input type="hidden" name="idventa" id="idventa" value="<?php echo encrypt($reg[0]['idventa']); ?>">
    <input type="hidden" name="codventa" id="codventa" value="<?php echo encrypt($reg[0]['codventa']); ?>">
    <input type="hidden" name="codfactura" id="codfactura" value="<?php echo encrypt($reg[0]['codfactura']); ?>">
    <input type="hidden" name="tipodocumento" id="tipodocumento" value="<?php echo $reg[0]['tipodocumento']; ?>"/>
    <input type="hidden" name="tipopago" id="tipopago" value="<?php echo $reg[0]['tipopago']; ?>"/>
    <input type="hidden" name="codcliente" id="codcliente" value="<?php echo $codigo = ($reg[0]['codcliente'] == "" ? "0" : $reg[0]['codcliente']); ?>"/>
    <input type="hidden" name="tipocliente" id="tipocliente" value="<?php echo $tipo = ($reg[0]['tipocliente'] == "" ? "0" : $reg[0]['tipocliente']); ?>"/>
    <input type="hidden" name="dnicliente" id="dnicliente" value="<?php echo $dni = ($reg[0]['dnicliente'] == "" ? "0" : $reg[0]['dnicliente']); ?>"/>
    <input type="hidden" name="nomcliente" id="nomcliente" value="<?php echo $nombre = ($reg[0]['nomcliente'] == "" ? "0" : $reg[0]['nomcliente']); ?>"/>
    <input type="hidden" name="girocliente" id="girocliente" value="<?php echo $giro = ($reg[0]['girocliente'] == "" ? "0" : $reg[0]['girocliente']); ?>"/>
    <input type="hidden" name="provincia" id="provincia" value="<?php echo $provincia = ($reg[0]['id_provincia'] == "" || $reg[0]['id_provincia'] == "0" ? "0" : $reg[0]['provincia']); ?>"/>
    <input type="hidden" name="departamento" id="departamento" value="<?php echo $departamento = ($reg[0]['id_departamento'] == "" || $reg[0]['id_departamento'] == "0"  ? "0" : $reg[0]['departamento']); ?>"/>
    <input type="hidden" name="direccliente" id="girocliente" value="<?php echo $direccion = ($reg[0]['direccliente'] == "" ? "0" : $reg[0]['direccliente']); ?>"/>

             <table id="carritototal" class="table-responsive">
                <tr>
    <td width="250"><h5><label>Gravado <?php echo number_format($reg[0]['iva'], 2, '.', '') ?>%:</label></h5></td>
    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal" name="lblsubtotal">0.00</label></h5>
    <input type="hidden" name="txtsubtotal" id="txtsubtotal" value="0.00"/>    
    </td>
                  
    <td width="250">
    <h5><label>Exento 0%:</label></h5>    
    </td>

    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal2" name="lblsubtotal2">0.00</label></h5>
    <input type="hidden" name="txtsubtotal2" id="txtsubtotal2" value="0.00"/>    
    </td>
    
    <td width="250"><h5><label><?php echo $impuesto; ?> <?php echo number_format($reg[0]['iva'], 2, '.', '') ?>%:<input type="hidden" name="iva" id="iva" autocomplete="off" value="<?php echo number_format($reg[0]['iva'], 2, '.', '') ?>"></label></h5>
    </td>

    <td class="text-center" width="250">
    <h5><?php echo $simbolo; ?><label id="lbliva" name="lbliva">0.00</label></h5>
    <input type="hidden" name="txtIva" id="txtIva" value="0.00"/>
    </td>
    </tr>
    <tr>
    <td>
    <h5><label>Descontado %:</label></h5> 
    </td>
    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescontado" name="lbldescontado">0.00</label></h5>
    <input type="hidden" name="txtdescontado" id="txtdescontado" value="0.00"/>
    </td>
    <td>
    <h5><label>Desc. Global <?php echo number_format($reg[0]['descuento'], 2, '.', '') ?>%:</label></h5>    
    </td>
    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescuento" name="lbldescuento">0.00</label></h5>
    <input type="hidden" name="descuento" id="descuento" value="<?php echo number_format($reg[0]['descuento'], 2, '.', '') ?>">
    <input type="hidden" name="txtDescuento" id="txtDescuento" value="0.00"/></td>

    <td><h4><b>Importe Total</b></h4></td>

    <td class="text-center">
    <h4><b><?php echo $simbolo; ?><label id="lbltotal" name="lbltotal">0.00</label></b></h4>
    <input type="hidden" name="txtTotal" id="txtTotal" value="0.00"/></td>
                    </tr>
                  </table>
        </div><hr>

      <div class="text-right">
<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-primary"><span class="fa fa-save"></span> Guardar Nota</button>
      </div>
          
        </div>
      </div>

    </div>
  </div>
</div>
<!-- End Row -->

<?php  
    }
}
######################## MOSTRAR FACTURA PARA NOTA DE CREDITO ########################
?>



<?php
######################## MOSTRAR NOTA DE CREDITO EN VENTANA MODAL ########################
if (isset($_GET['BuscaNotaCreditoModal']) && isset($_GET['codnota'])) { 
 
$reg = $new->NotasCreditoPorId();

  if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON VENTAS Y DETALLES ACTUALMENTE </center>";
    echo "</div>";    

} else {
?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-danger">RAZÓN SOCIAL</b></h4>
  <p class="text-muted m-l-5"><?php echo $con[0]['nomsucursal']; ?>,
  <br/> Nº <?php echo $con[0]['documsucursal'] == '0' ? "DOCUMENTO" : $con[0]['documento'] ?>: <?php echo $con[0]['cuit']; ?> - TLF: <?php echo $con[0]['tlfsucursal']; ?></p>

  <h4><b class="text-danger">Nº NOTA CRÉDITO <?php echo $reg[0]['codfactura']; ?></b></h4>
  <p class="text-muted m-l-5">Nº <?php echo $reg[0]['tipodocumento']; ?>: <?php echo $reg[0]['facturaventa']; ?>

  <br>OBSERVACIÓN: <?php echo $reg[0]["observaciones"]; ?>
  <br>Nº DE CAJA: <?php echo $caja = ($reg[0]['codcaja'] == 0 ? "**********": $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']); ?>
  <br>FECHA DE EMISIÓN: <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechanota'])); ?></p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
  <h4><b class="text-danger">CLIENTE</b></h4>
  <p class="text-muted m-l-30"><?php echo $reg[0]['nomcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente']; ?>,
  <br/>DIREC: <?php echo $reg[0]['direccliente'] == '' ? "*********" : $reg[0]['direccliente']; ?> <?php echo $reg[0]['provincia'] == '' ? "*********" : strtoupper($reg[0]['provincia']); ?> <?php echo $reg[0]['departamento'] == '' ? "*********" : strtoupper($reg[0]['departamento']); ?>
  <br/> EMAIL: <?php echo $reg[0]['emailcliente'] == '' ? "**********************" : $reg[0]['emailcliente']; ?>
  <br/> Nº <?php echo $reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento'] ?>: <?php echo $reg[0]['dnicliente'] == '' ? "**********************" : $reg[0]['dnicliente']; ?> - TLF: <?php echo $reg[0]['tlfcliente'] == '' ? "**********************" : $reg[0]['tlfcliente']; ?></p>
                                            
                                        </address>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-10" style="clear: both;">
                                        <table class="table2 table-hover">
                               <thead>
                        <tr>
                        <th>#</th>
                        <th class="text-left">Descripción de Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesNotasCredito();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto'];
?>
                                                <tr>
      <td><?php echo $a++; ?></td>
      <td class="text-left"><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5>
      <small class="text-danger alert-link"><?php echo $detalle[$i]['codcategoria'] == '' ? "**********" : $detalle[$i]['nomcategoria'] ?></small></td>
      <td><?php echo $detalle[$i]['cantventa']; ?></strong></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><strong><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</strong></sup></label></td>
      <td><?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($reg[0]['iva'], 2, '.', ',')."%" : "(E)"; ?></label></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
                                                </tr>
                                      <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="col-md-12">

                                    <div class="pull-right text-right">
<p><b>Subtotal:</b> <?php echo $simbolo.number_format($SubTotal, 2, '.', ','); ?></p>
<p><b>Total Grabado <?php echo number_format($reg[0]['iva'], 2, '.', ',') ?>%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivasi'], 2, '.', ','); ?><p>
<p><b>Total Exento 0%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivano'], 2, '.', ','); ?></p>
<p><b>Total <?php echo $impuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaliva'], 2, '.', ','); ?> </p>
<p><b>Desc. Global (<?php echo number_format($reg[0]['descuento'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaldescuento'], 2, '.', ','); ?> </p>
                                        <hr>
<h4><b>Importe Total:</b> <?php echo $simbolo.number_format($reg[0]['totalpago'], 2, '.', ','); ?></h4></div>
                                    <div class="clearfix"></div>
                                    <hr>

                                <div class="col-md-12">
                                    <div class="text-right">
 <a href="reportepdf?codnota=<?php echo encrypt($reg[0]['codnota']); ?>&tipo=<?php echo encrypt("NOTACREDITO") ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn waves-light btn-light" type="button"><span><i class="fa fa-print"></i> Imprimir</span></button></a>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                                    </div>
                                </div>
                            </div>
                <!-- .row -->
  <?php
       }
   } 
######################## MOSTRAR NOTA DE CREDITO EN VENTANA MODAL ########################
?>


<?php
########################## BUSQUEDA NOTAS DE CREDITOS POR CAJAS ##########################
if (isset($_GET['BuscaNotasxCajas']) && isset($_GET['codcaja']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codcaja = limpiar($_GET['codcaja']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codcaja=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


  } else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

  } elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarNotasxCajas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Notas de Créditos de Caja <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?> </h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("NOTASXCAJAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("NOTASXCAJAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("NOTASXCAJAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                                <th>N°</th>
                                <th>N° de Nota</th>
                                <th>Nº de Documento</th>
                                <th>Descripción de Cliente</th>
                                <th>Motivo de Nota</th>
                                <th>Fecha Emisión</th>
                                <th>Nº Artic</th>
                                <th>SubTotal</th>
                                <th><?php echo $impuesto; ?></th>
                                <th>Dcto %</th>
                                <th>Imp. Total</th>
                                <th><i class="mdi mdi-drag-horizontal"></i></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalIva=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalIva+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
                                <tr>
                    <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]['codfactura']; ?></td>
                    <td><?php echo $reg[$i]['tipodocumento']." Nº: ".$reg[$i]['facturaventa']; ?></td>
                    <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></td>
                    <td><?php echo $reg[$i]['observaciones']; ?></td>

                    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechanota'])); ?></td>
                    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
                                               <td>
<a href="reportepdf?codnota=<?php echo encrypt($reg[$i]['codnota']); ?>&tipo=<?php echo encrypt("NOTACREDITO"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
                                              </td>

                                </tr>
                        <?php  }  ?>
         <tr>
           <td colspan="6"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA NOTAS DE CREDITOS POR CAJAS ########################
?>

<?php
########################## BUSQUEDA NOTAS DE CREDITOS POR FECHAS ##########################
if (isset($_GET['BuscaNotasxFechas']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarNotasxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Notas de Créditos por Fechas Desde <?php echo date("d-m-Y", strtotime($desde)); ?> Hasta <?php echo date("d-m-Y", strtotime($hasta)); ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("NOTASXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("NOTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("NOTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                                <th>N°</th>
                                <th>N° de Caja</th>
                                <th>N° de Nota</th>
                                <th>Nº de Documento</th>
                                <th>Descripción de Cliente</th>
                                <th>Motivo de Nota</th>
                                <th>Fecha Emisión</th>
                                <th>Nº Artic</th>
                                <th>SubTotal</th>
                                <th><?php echo $impuesto; ?></th>
                                <th>Dcto %</th>
                                <th>Imp. Total</th>
                                <th><i class="mdi mdi-drag-horizontal"></i></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalIva=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalIva+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
                                <tr>
                    <td><?php echo $a++; ?></td>
                    <td><?php echo $caja = ($reg[$i]['codcaja'] == '0' ? "**********" : $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']); ?></td>
                    <td><?php echo $reg[$i]['codfactura']; ?></td>
                    <td><?php echo $reg[$i]['tipodocumento']." Nº: ".$reg[$i]['facturaventa']; ?></td>
                    <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></td>
                    <td><?php echo $reg[$i]['observaciones']; ?></td>

                    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechanota'])); ?></td>
                    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
                                               <td>
<a href="reportepdf?codnota=<?php echo encrypt($reg[$i]['codnota']); ?>&tipo=<?php echo encrypt("NOTACREDITO"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
                                              </td>

                                </tr>
                        <?php  }  ?>
         <tr>
           <td colspan="7"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA NOTAS DE CREDITOS POR FECHAS ########################
?>


<?php
######################## BUSQUEDA NOTAS DE CREDITOS POR CLIENTES ########################
if (isset($_GET['BuscaNotasxClientes']) && isset($_GET['codcliente'])) {
  
  $codcliente = limpiar($_GET['codcliente']);

 if($codcliente=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL CLIENTE CORRECTAMENTE</center>";
   echo "</div>";   
   exit;

} else {

$pre = new Login();
$reg = $pre->BuscarNotasxClientes();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-warning">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Notas de Créditos del Cliente <?php echo $reg[0]['dnicliente'].": ".$reg[0]['nomcliente']; ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codcliente=<?php echo $codcliente; ?>&tipo=<?php echo encrypt("NOTASXCLIENTE") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codcliente=<?php echo $codcliente; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("NOTASXCLIENTE") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codcliente=<?php echo $codcliente; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("NOTASXCLIENTE") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                                <th>N°</th>
                                <th>N° de Caja</th>
                                <th>N° de Nota</th>
                                <th>Nº de Documento</th>
                                <th>Motivo de Nota</th>
                                <th>Fecha Emisión</th>
                                <th>Nº Artic</th>
                                <th>SubTotal</th>
                                <th><?php echo $impuesto; ?></th>
                                <th>Dcto %</th>
                                <th>Imp. Total</th>
                                <th><i class="mdi mdi-drag-horizontal"></i></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalIva=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalIva+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
                                <tr>
                    <td><?php echo $a++; ?></td>
                    <td><?php echo $caja = ($reg[$i]['codcaja'] == '0' ? "**********" : $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']); ?></td>
                    <td><?php echo $reg[$i]['codfactura']; ?></td>
                    <td><?php echo $reg[$i]['tipodocumento']." Nº: ".$reg[$i]['facturaventa']; ?></td>
                    <td><?php echo $reg[$i]['observaciones']; ?></td>

                    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechanota'])); ?></td>
                    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
                                               <td>
<a href="reportepdf?codnota=<?php echo encrypt($reg[$i]['codnota']); ?>&tipo=<?php echo encrypt("NOTACREDITO"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
                                              </td>

                                </tr>
                        <?php  }  ?>
         <tr>
           <td colspan="6"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA NOTAS DE CREDITOS POR CLIENTES ##########################
?>


