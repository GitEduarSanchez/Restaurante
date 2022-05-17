<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
     if ($_SESSION['acceso'] == "administrador" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero") {

$tra = new Login();
$ses = $tra->ExpiraSession();  

$imp = new Login();
$imp = $imp->ImpuestosPorId();
$impuesto = ($imp == "" ? "Impuesto" : $imp[0]['nomimpuesto']);
$valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

$con = new Login();
$con = $con->ConfiguracionPorId();
$simbolo = ($con == "" ? "" : "<strong>".$con[0]['simbolo']."</strong>");

$arqueo = new Login();
$arqueo = $arqueo->ArqueoCajaPorUsuario();

if(isset($_POST["proceso"]) and $_POST["proceso"]=="nuevopedido")
{
$reg = $tra->NuevoPedidoDelivery();
exit;
}
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="agregarpedido")
{
$reg = $tra->AgregaPedidoDelivery();
exit;
}
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="cerrardelivery")
{
$reg = $tra->CerrarDelivery();
exit;
}
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="nuevocliente")
{
$reg = $tra->RegistrarClientes();
exit;
}        
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Ing. Ruben Chirinos">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title></title>

    <!-- Menu CSS -->
    <link href="assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- toast CSS -->
    <link href="assets/plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- Datatables CSS -->
    <link href="assets/plugins/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- Sweet-Alert -->
    <link rel="stylesheet" href="assets/css/sweetalert.css">
    <!-- animation CSS -->
    <link href="assets/css/animate.css" rel="stylesheet">
    <!-- needed css -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="assets/css/default.css" id="theme" rel="stylesheet">
    <!--Bootstrap Horizontal CSS -->
    <link href="assets/css/bootstrap-horizon.css" rel="stylesheet">
    <!--<link href="assets/css/style-light.css" rel="stylesheet">
    Scrolling-tabs CSS
    <link rel="stylesheet" href="assets/css/jquery.scrolling-tabs.css">
    <link rel="stylesheet" href="assets/css/st-demo.css"> -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</head>

<body onLoad="muestraReloj()" class="fix-header">
    
   <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>

    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-boxed-layout="full" data-header-position="fixed" data-sidebar-position="fixed" class="mini-sidebar"> 


<!--############################## MODAL PARA AGREGAR OBSERVACIONES EN DETALLE ######################################-->
<!-- sample modal content -->
<div id="myModalObservacion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-align-justify"></i> Detalle de Producto/Combo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
                </div>

        <form class="form form-material" method="post" action="#" name="agregaobservaciones" id="agregaobservaciones">
                
            <div class="modal-body">

            <div id="agrega_detalle_observacion"></div><!-- detalle observacion -->

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
            </div>

        </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!--############################## MODAL PARA AGREGAR OBSERVACIONES EN DETALLE ######################################-->


<!--############################## MODAL PARA MOSTRAR MENU ######################################-->
<!-- sample modal content -->
<div id="myModalMenu" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-tasks"></i> Menú</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
            </div>
                            
            <div class="modal-body">

            <div id="muestra_menu"></div>
            
            </div>

            <div class="modal-footer">
<a href="reportepdf?&tipo=<?php echo encrypt("MENU"); ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn btn-warning waves-light" type="button"><span><i class="fa fa-print"></i> Imprimir</span></button></a>
<button class="btn btn-dark" type="reset" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-trash-o"></span> Cerrar</button>
            </div>

    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal --> 
<!--############################## MODAL PARA MOSTRAR MENU ######################################-->


<!--############################## MODAL PARA MOSTRAR PEDIDOS EN COCINA ######################################-->
<!-- sample modal content -->
<div id="myModalPedidos" class="modal bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-tasks"></i> Detalles de Pedidos</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
            </div>
            
        <form class="form form-material" name="detalledelivery" id="detalledelivery" action="#">
                
               <div class="modal-body">

                    <div id="detallescocina"></div>

               </div>

            <div class="modal-footer">
<button class="btn btn-dark" type="reset" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-trash-o"></span> Cerrar</button>
            </div>
        </form>

    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal --> 
<!--############################## MODAL PARA MOSTRAR PEDIDOS EN COCINA ######################################-->


<!--############################## MODAL PARA REGISTRO DE NUEVO CLIENTE ######################################-->
<!-- sample modal content -->
<div id="myModalCliente" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-save"></i> Nuevo Cliente</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
            </div>
            
        <form class="form form-material" method="post" action="#" name="clientedelivery" id="clientedelivery"> 

            <div id="save">
                <!-- error will be shown here ! -->
            </div>
                
        <div class="modal-body">

        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Tipo de Cliente: <span class="symbol required"></span></label>
                    <i class="fa fa-bars form-control-feedback"></i>
                    <select name="tipocliente" id="tipocliente" class="form-control" onChange="CargaTipoCliente(this.form.tipocliente.value);" required="" aria-required="true">
                        <option value=""> -- SELECCIONE -- </option>
                        <option value="NATURAL">NATURAL</option>
                        <option value="JURIDICO">JURIDICO</option>
                    </select> 
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Tipo de Documento: </label>
                    <i class="fa fa-bars form-control-feedback"></i> 
                    <select name="documcliente" id="documcliente" class='form-control' required="" aria-required="true">
                        <option value="0"> -- SELECCIONE -- </option>
                        <?php
                        $doc = new Login();
                        $doc = $doc->ListarDocumentos();
                        if($doc==""){ 
                         echo "";
                     } else {
                        for($i=0;$i<sizeof($doc);$i++){ ?>
                            <option value="<?php echo $doc[$i]['coddocumento'] ?>"><?php echo $doc[$i]['documento']; ?></option>
                        <?php } } ?>
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Nº de Documento: <span class="symbol required"></span></label>
                    <input type="hidden" name="proceso" id="proceso" value="nuevocliente"/>
                    <input type="text" class="form-control" name="dnicliente" id="dnicliente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nº de Documento" autocomplete="off" required="" aria-required="true"/> 
                    <i class="fa fa-bolt form-control-feedback"></i> 
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Nombre de Cliente: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="nomcliente" id="nomcliente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nombre de Cliente" disabled="" autocomplete="off" required="" aria-required="true"/>  
                    <i class="fa fa-pencil form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Razón Social: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="razoncliente" id="razoncliente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Razón Social" disabled="" autocomplete="off" required="" aria-required="true"/>  
                    <i class="fa fa-pencil form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Giro de Cliente: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="girocliente" id="girocliente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Giro de Cliente" disabled="" autocomplete="off" required="" aria-required="true"/>  
                    <i class="fa fa-pencil form-control-feedback"></i> 
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Nº de Teléfono: </label>
                    <input type="text" class="form-control phone-inputmask" name="tlfcliente" id="tlfcliente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nº de Teléfono" autocomplete="off" required="" aria-required="true"/>  
                    <i class="fa fa-phone form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Correo de Cliente: </label>
                    <input type="text" class="form-control" name="emailcliente" id="emailcliente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Correo Electronico" autocomplete="off" required="" aria-required="true"/> 
                    <i class="fa fa-envelope-o form-control-feedback"></i>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Provincia: </label>
                    <i class="fa fa-bars form-control-feedback"></i>
                    <select name="id_provincia" id="id_provincia" onChange="CargaDepartamentos(this.form.id_provincia.value);" class='form-control' required="" aria-required="true">
                    <option value="0"> -- SELECCIONE -- </option>
                    <?php
                    $pro = new Login();
                    $pro = $pro->ListarProvincias();
                    if($pro==""){ 
                        echo "";
                    } else {
                    for($i=0;$i<sizeof($pro);$i++){ ?>
                    <option value="<?php echo $pro[$i]['id_provincia'] ?>"><?php echo $pro[$i]['provincia'] ?></option>        
                    <?php } } ?>
                    </select> 
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Departamentos: </label>
                    <i class="fa fa-bars form-control-feedback"></i>
                    <select class="form-control" id="id_departamento" name="id_departamento" required="" aria-required="true">
                    <option value=""> -- SIN RESULTADOS -- </option>
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Dirección Domiciliaria: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="direccliente" id="direccliente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Dirección Domiciliaria" autocomplete="off" required="" aria-required="true"/> 
                    <i class="fa fa-map-marker form-control-feedback"></i>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Limite de Crédito: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="limitecredito" id="limitecredito" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="Ingrese Limite de Crédito" autocomplete="off" required="" aria-required="true"/>  
                    <i class="fa fa-usd form-control-feedback"></i>
                </div>
            </div>
        </div>
    </div>

        <div class="modal-footer">
            <div class="col-md-6">
                <button type="submit" name="btn-cliente" id="btn-cliente" class="btn btn-warning btn-lg btn-block waves-effect waves-light"><span class="fa fa-save"></span> Guardar</button>
            </div>
            <div class="col-md-6">
                <button type="button" onclick="
                document.getElementById('proceso').value = 'save',
                document.getElementById('codcliente').value = '',
                document.getElementById('tipocliente').value = '',
                document.getElementById('documcliente').value = '',
                document.getElementById('dnicliente').value = '',
                document.getElementById('nomcliente').value = '',
                document.getElementById('razoncliente').value = '',
                document.getElementById('girocliente').value = '',
                document.getElementById('tlfcliente').value = '',
                document.getElementById('emailcliente').value = '',
                document.getElementById('id_provincia').value = '',
                document.getElementById('id_departamento').value = '',
                document.getElementById('direccliente').value = '',
                document.getElementById('limitecredito').value = ''" class="btn btn-dark btn-lg btn-block waves-effect waves-light" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-trash-o"></span> Cancelar</button>
            </div>
        </div>

        </form>

    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal --> 
<!--############################## MODAL PARA REGISTRO DE NUEVO CLIENTE ######################################-->


<!--############################## MODAL PARA CIERRE DE DELIVERY ######################################-->
<!-- sample modal content -->
<div id="myModalPago" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-tasks"></i> Cierre de Venta</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
            </div>
            
        <form class="form form-material" name="cerrardelivery" id="cerrardelivery" action="#">

            <div class="modal-body">

            <div id="cierredelivery"></div>


            <div class="row">
                <div class="col-md-6">
                   <span id="submit_cerrar"><button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><span class="fa fa-print"></span> Facturar e Imprimir</button></span>
                </div>
                <div class="col-md-6">
                   <button type="reset" class="btn btn-dark btn-lg btn-block waves-effect waves-light" class="close" data-dismiss="modal" aria-hidden="true" onclick="document.getElementById('cierredelivery').innerHTML = ''"><span class="fa fa-trash-o"></span> Cancelar</button>
                </div>
            </div>
    
            </div>
        </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!--############################## MODAL PARA CIERRE DE DELIVERY ######################################-->
    
        <!-- INICIO DE MENU -->
        <?php include('menu.php'); ?>
        <!-- FIN DE MENU -->
   

        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb border-bottom">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-xs-12 align-self-center">
                <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Gestión de Delivery</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item">Mostrador</li>
                                <li class="breadcrumb-item active" aria-current="page">Delivery</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="page-content container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->

<form class="form form-material" method="post" action="#" name="savedelivery" id="savedelivery">   

<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Gestión de Delivery</h4>
            </div>

            <div id="save">
            <!-- error will be shown here ! -->
            </div>
            
            <div class="form-body">

              <div class="card-body">

    <div class="row">

        <!-- .col -->
        <div class="col-md-6">
        
        <h3 class="card-subtitle m-0 text-dark"><i class="font-20 mdi mdi-cart-plus"></i> Detalle de Ventas</h3><hr>

        <?php if($arqueo==""){ ?>

        <div class='alert alert-danger'>
            <center><span class='fa fa-info-circle'></span> POR FAVOR DEBE DE REALIZAR EL ARQUEO DE CAJA ASIGNADA PARA PROCESAR VENTAS <a href="arqueos"><label> REALIZAR ARQUEO</a></label></div></center>

        <?php } else { ?>

    <div id="pedidos">
        <?php
        $pedido = new Login();
        $reg = $pedido->ListarPedidosDelivery();
        ?>
        <div class="row-horizon">
        <span style="font-size: 16px;" class="categorias selectedGat" onClick="RecibeDelivery('0','0');"><i class="fa fa-plus-circle"></i></span>
        <?php 
        if($reg==""){ echo ""; } else {
        $a=1;
        for ($i = 0; $i < sizeof($reg); $i++) { ?>
        <span class="categorias" onClick="RecibeDelivery('<?php echo encrypt($reg[$i]['codpedido']);?>','<?php echo encrypt($reg[$i]['codventa']);?>');"><span class="font-16"><?php echo $a++;?></span> <abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?>">  <span style="font-size: 12px;"><i class="fa fa-clock-o"></i>  <?php echo date("H:i:s",strtotime($reg[$i]['fechapedido']));?></span></abbr></span>
        <?php } } ?>
        </div><br>
    </div>

    <div id="muestradetalledelivery"><!-- detalle delivery -->

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
                <div class="input-group mb-3">
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
                   <input type="radio" class="custom-control-input" id="evento1" name="tipopedido" value="INTERNO" checked="checked" onclick="TipoPedido('this.form.tipopedido.value')">
                   <label class="custom-control-label" for="evento1">EN ESTABLECIMIENTO</label>
                   </div>
                   <div class="custom-control custom-radio">
                   <input type="radio" class="custom-control-input" id="evento2" name="tipopedido" value="EXTERNO" onclick="TipoPedido('this.form.tipopedido.value')">
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
                    if($usuario==""){ 
                            echo "";
                    } else {
                    for($i=0;$i<sizeof($usuario);$i++){ ?>
                    <option value="<?php echo encrypt($usuario[$i]['codigo']); ?>"><?php echo $usuario[$i]['nombres'] ?></option> <?php } } ?>
                    </select>
                </div> 
            </div>
        </div>

    
    <div id="favoritos" style="display:none !important;"></div>

        <div class="table-responsive m-t-10 scroll">
            <table id="carrito" class="table2">
                <thead>
                    <tr class="text-center">
                        <th width="18%">Cantidad</th>
                        <th width="42%">Descripción</th>
                        <th width="12%">Precio</th>
                        <th width="14%">Importe</th>
                        <th width="14%">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center" colspan=5><h4>NO HAY DETALLES AGREGADOS</h4></td>
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
                    <input type="hidden" name="iva" id="iva" value="<?php echo number_format($valor, 2, '.', ''); ?>">
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
                <button type="button" onclick="MuestraFavoritos();" class="btn btn-success btn-lg btn-block waves-effect waves-light"><span class="fa fa-star"></span> Favoritos</button>
            </div>
            <div class="col-md-6">
                
                <button type="button" class="btn btn-info btn-lg btn-block waves-effect waves-light" onClick="RecargaPedidos('<?php echo encrypt("DELIVERY"); ?>');" data-placement="left" title="Ver Pedidos" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalPedidos" data-backdrop="static" data-keyboard="false"><i class="fa fa-cutlery"></i> Pedidos</button>
            </div>
        </div>

    </div><!-- detalle delivery -->   

        <?php } ?>


        </div>
        <!-- /.col -->
        
        <!-- .col -->  
        <div class="col-md-6">

        <h3 class="card-subtitle m-0 text-dark"><i class="font-20 fa fa-cubes"></i> Productos<span class="pull-right" data-placement="left" title="Menu" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalMenu" style="cursor: pointer;" onclick="CargarMenu();"><i class="fa fa-clipboard"></i> Menú</span></h3><hr>
            
            <div class="row">
                <div class="col-md-6">
                   <button type="button" class="btn btn-success btn-lg btn-block waves-effect waves-light" style="cursor: pointer;" onClick="MostrarProductos();"><span class="fa fa-cubes"></span> Productos</button>
                </div>
                <div class="col-md-6">
                   <button type="button" class="btn btn-info btn-lg btn-block waves-effect waves-light" style="cursor: pointer;" onClick="MostrarCombos();"><span class="fa  fa-archive"></span> Combos</button>
                </div>
            </div><hr>

            <div id="loading"></div>

        </div>
       <!-- /.col -->
                                   
    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Row -->

        </form> 
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                <i class="fa fa-copyright"></i> <span class="current-year"></span>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
   

    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="assets/script/jquery.min.js"></script> 
    <script src="assets/js/bootstrap.js"></script>
    <!-- apps -->
    <script src="assets/js/app.min.js"></script>
    <script src="assets/js/app.init.horizontal-fullwidth.js"></script>
    <script src="assets/js/app-style-switcher.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="assets/js/perfect-scrollbar.js"></script>
    <script src="assets/js/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="assets/js/waves.js"></script>
    <!-- Sweet-Alert -->
    <script src="assets/js/sweetalert-dev.js"></script>
    <!--Menu sidebar -->
    <script src="assets/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="assets/js/custom.js"></script>

    <!-- script jquery -->
    <script type="text/javascript" src="assets/script/titulos.js"></script>
    <script type="text/javascript" src="assets/script/jquery.mask.js"></script>
    <script type="text/javascript" src="assets/script/mask.js"></script>
    <script type="text/javascript" src="assets/script/script2.js"></script>
    <script type="text/javascript" src="assets/script/jsdelivery.js"></script>
    <script type="text/javascript" src="assets/script/validation.min.js"></script>
    <script type="text/javascript" src="assets/script/script.js"></script>
    <!-- script jquery -->

    <!-- Calendario -->
    <link rel="stylesheet" href="assets/calendario/jquery-ui.css" />
    <script src="assets/calendario/jquery-ui.js"></script>
    <script src="assets/script/jscalendario.js"></script>
    <script src="assets/script/autocompleto.js"></script>
    <!-- Calendario -->


    <!-- jQuery -->
    <script src="assets/plugins/noty/packaged/jquery.noty.packaged.min.js"></script>
    <script type="text/jscript">
    $('#loading').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
    setTimeout(function() {
    $('#loading').load("salas_mesas?CargaProductos=si");
     }, 100);
    </script>
    <!-- jQuery -->


</body>
</html>

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