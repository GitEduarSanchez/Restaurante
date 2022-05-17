<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
     if ($_SESSION['acceso'] == "administrador" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero" || $_SESSION["acceso"]=="mesero" || $_SESSION["acceso"]=="cocinero" || $_SESSION["acceso"]=="repartidor") {

$tra = new Login();
$ses = $tra->ExpiraSession();

$grafico = new Login();
$grafico = $grafico->ContarRegistros();  

$imp = new Login();
$imp = $imp->ImpuestosPorId();
$impuesto = ($imp == "" ? "Impuesto" : $imp[0]['nomimpuesto']);
$valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

$con = new Login();
$con = $con->ConfiguracionPorId();
$simbolo = ($con == "" ? "" : "<strong>".$con[0]['simbolo']."</strong>");

if(isset($_POST["proceso"]) and $_POST["proceso"]=="nuevopedido")
{
$reg = $tra->NuevoPedido();
exit;
}
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="agregarpedido")
{
$reg = $tra->AgregaPedido();
exit;
}
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="cobrarmesa")
{
$reg = $tra->CobrarMesa();
exit;
}
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="nuevocliente")
{
$reg = $tra->RegistrarClientes();
exit;
}
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="cambiomesa")
{
$reg = $tra->CambiarMesas();
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
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/quill.snow.css">
    <!-- needed css -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="assets/css/default.css" id="theme" rel="stylesheet">
   <!--Bootstrap Horizontal CSS -->
    <link href="assets/css/bootstrap-horizon.css" rel="stylesheet">

    <!-- script jquery -->
    <script src="assets/script/jquery.min.js"></script> 
    <script type="text/javascript" src="assets/plugins/chart.js/chart.min.js"></script>
    <script type="text/javascript" src="assets/script/graficos.js"></script>
    <!--  script jquery -->

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
            
        <form class="form form-material" method="post" action="#" name="clienteventa" id="clienteventa"> 

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


<!--############################## MODAL CAMBIO DE MESA ######################################-->
<!-- sample modal content -->
<div id="myModalCambioMesa" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-tasks"></i> Cambio de Mesa</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
            </div>
            
        <form class="form form-material" name="cambiarmesa" id="cambiarmesa" action="#">

            <div class="modal-body">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group has-feedback">
                        <label class="control-label">Nombre de Sala: <span class="symbol required"></span></label>
                        <input type="hidden" name="proceso" id="proceso" value="cambiomesa"/>
                        <input type="hidden" name="codpedido" id="codpedido">
                        <input type="hidden" name="codventa" id="codventa">
                        <input type="hidden" name="viejamesa" id="viejamesa">
                        <br/><abbr title="Nombre de Sala"><label class="text-danger" id="salaentra"></label></abbr>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group has-feedback">
                        <label class="control-label">Nombre de Mesa: <span class="symbol required"></span></label>
                        <br/><abbr title="Nombre de Mesa"><label class="text-danger" id="mesaentra"></label></abbr>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group has-feedback">
                        <label class="control-label">Seleccione Sala: <span class="symbol required"></span></label>
                        <i class="fa fa-bars form-control-feedback"></i>
                        <select name="nuevasala" id="nuevasala" class='form-control' onChange="CargaMesas(this.form.nuevasala.value);" required="" aria-required="true">
                        <option value=""> -- SELECCIONE -- </option>
                        <?php
                        $sala = new Login();
                        $sala = $sala->ListarSalas();
                        if($sala==""){
                            echo "";    
                         } else {
                        for($i=0;$i<sizeof($sala);$i++){
                        ?>
                        <option value="<?php echo encrypt($sala[$i]['codsala']); ?>"><?php echo $sala[$i]['nomsala'] ?></option>
                        <?php } } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group has-feedback">
                        <label class="control-label">Seleccione Mesa: <span class="symbol required"></span></label>
                        <i class="fa fa-bars form-control-feedback"></i>
                        <select name="nuevamesa" id="nuevamesa" class='form-control' required="" aria-required="true">
                        <option value="">-- SIN RESULTADOS --</option>
                        </select>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                   <button type="submit" name="btn-cambiar" id="btn-cambiar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><span class="fa fa-save"></span> Cambiar Mesa</button>
                </div>
                <div class="col-md-6">
                   <button type="reset" class="btn btn-dark btn-lg btn-block waves-effect waves-light" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-trash-o"></span> Cancelar</button>
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
<!--############################## MODAL CAMBIO DE MESA ######################################-->


<!--############################## MODAL PARA CIERRE DE VENTA ######################################-->
<!-- sample modal content -->
<div id="myModalPago" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-tasks"></i> Cierre de Venta</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
            </div>
            
        <form class="form form-material" name="cerrarventa" id="cerrarventa" action="#">

            <div class="modal-body">

            <div id="cierremesa"></div>


            <div class="row">
                <div class="col-md-6">
                   <span id="submit_cerrar"><button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><span class="fa fa-print"></span> Facturar e Imprimir</button></span>
                </div>
                <div class="col-md-6">
                   <button type="reset" class="btn btn-dark btn-lg btn-block waves-effect waves-light" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-trash-o"></span> Cancelar</button>
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
<!--############################## MODAL PARA CIERRE DE VENTA ######################################-->
    
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
                <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> <?php echo $var = ($_SESSION['acceso'] == "mesero" || $_SESSION['acceso'] == "cocinero" || $_SESSION['acceso'] == "repartidor" ? "Mostrador de Pedidos" : "Gestión de Ventas"); ?></h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item"><a href="panel" class="text-info"> Mostrador</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo $var = ($_SESSION['acceso'] == "mesero" || $_SESSION['acceso'] == "cocinero" || $_SESSION['acceso'] == "repartidor" ? "<a href='logout' class='text-info'> Cerrar Sesión</a>" : "Ventas"); ?></li>
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

<?php if ($_SESSION['acceso'] == "administrador" || $_SESSION["acceso"]=="cajero" || $_SESSION["acceso"]=="mesero") { ?>
            
<form class="form form-material" method="post" action="#" name="saveventas" id="saveventas">   

<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Gestión de Ventas</h4>
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

    <div id="pedidos"></div>

    <div id="muestradetallemesa"><center>SELECCIONE MESA PARA CONTINUAR <i class="font-20 fa fa-arrow-right"></i></center></div>

        </div>
        <!-- /.col -->
        
        <!-- .col -->  
        <div class="col-md-6">

        <h3 class="card-subtitle m-0 text-dark"><?php echo $var = ($_SESSION['acceso'] == "mesero" ? "<i class='font-20 fa fa-tasks'></i> Mesas/Productos" : "<span onClick='MostrarMesas();' style='cursor:pointer;'><i class='font-20 mdi mdi-black-mesa'></i> Recargar Mesas</span>"); ?>

        <span class="pull-right" data-placement="left" title="Menu" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalMenu" style="cursor: pointer;" onclick="CargarMenu();"><i class="fa fa-clipboard"></i> Menú</span></h3><hr>
            
            <?php
            if ($_SESSION['acceso'] == "mesero") {
            ?>          
            <div class="row">
                <div class="col-md-4">
                   <button type="button" id="boton" class="btn btn-dark btn-lg btn-block waves-effect waves-light" style="cursor: pointer;" onClick="MostrarMesas();"><span class="mdi mdi-black-mesa"></span> Mesas</button>
                </div>
                <div class="col-md-4">
                   <button type="button" class="btn btn-success btn-lg btn-block waves-effect waves-light" style="cursor: pointer;" onClick="MostrarProductos();"><span class="fa fa-cubes"></span> Productos</button>
                </div>
                <div class="col-md-4">
                   <button type="button" class="btn btn-info btn-lg btn-block waves-effect waves-light" style="cursor: pointer;" onClick="MostrarCombos();"><span class="fa  fa-archive"></span> Combos</button>
                </div>
            </div><hr>
            <?php } ?>

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


<?php } else if ($_SESSION['acceso'] == "cocinero") { ?>

    <!-- Row -->
    <div class="page-content container-fluid note-has-grid">
        <ul class="nav nav-pills p-3 bg-white mb-3 rounded-pill align-items-center">
            
            <li class="nav-item"> <a href="javascript:void(0)" onClick="MuestraComanda('<?php echo encrypt("TODOS"); ?>');" class="nav-link rounded-pill note-link d-flex align-items-center active px-2 px-md-3 mr-0 mr-md-2" id="all-todo">
               <i class="mdi mdi-account-search"></i><span class="d-none d-md-block"> Todos</span></a> 
            </li>

            <li class="nav-item"> <a href="javascript:void(0)" onClick="MuestraComanda('<?php echo encrypt("MESAS"); ?>');" class="nav-link rounded-pill note-link d-flex align-items-center px-2 px-md-3 mr-0 mr-md-2" id="all-category">
               <i class="mdi mdi-black-mesa"></i><span class="d-none d-md-block"> Mesas</span></a> 
            </li>
            
            <li class="nav-item"> <a href="javascript:void(0)" onClick="MuestraComanda('<?php echo encrypt("DELIVERY"); ?>');" class="nav-link rounded-pill note-link d-flex align-items-center px-2 px-md-3 mr-0 mr-md-2" id="note-business">
                <i class="mdi mdi-motorbike"></i><span class="d-none d-md-block"> Delivery</span></a> 
            </li>
            
            <li class="nav-item"> <a href="javascript:void(0)" onClick="MuestraComanda('<?php echo encrypt("ENTREGADOS"); ?>');" class="nav-link rounded-pill note-link d-flex align-items-center px-2 px-md-3 mr-0 mr-md-2" id="note-social">
                <i class="mdi mdi-view-parallel"></i><span class="d-none d-md-block"> Entregados</span></a> 
            </li>

            <li class="nav-item ml-auto"> <a href="javascript:void(0)" onClick="RecargaComanda('<?php echo encrypt("TODOS"); ?>');" class="nav-link btn-primary rounded-pill d-flex align-items-center px-3" id="add-notes">
                <i class="mdi mdi-refresh"></i><span class="d-none d-md-block font-14"> Recargar Mostrador</span></a> 
            </li>
        </ul>
    </div>
    <!-- End Row -->
            
    <div id="mostrador"></div>

    <script type="text/javascript">
    $('#mostrador').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
    setTimeout(function() {
    
    $('#mostrador').load("consultas?CargaMostrador=si&proceso="+'<?php echo encrypt("TODOS"); ?>');
     }, 200);
    </script>

<?php } else if ($_SESSION['acceso'] == "repartidor") { ?>

    <!-- Row -->
    <div class="page-content container-fluid note-has-grid">
        <ul class="nav nav-pills p-3 bg-white mb-3 rounded-pill align-items-center">
            
            <li class="nav-item"> <a href="javascript:void(0)" onClick="MuestraDelivery('<?php echo encrypt("TODOS"); ?>');" class="nav-link rounded-pill note-link d-flex align-items-center active px-2 px-md-3 mr-0 mr-md-2" id="all-todo">
               <i class="mdi mdi-account-search"></i><span class="d-none d-md-block"> Pendientes</span></a> 
            </li>

            <li class="nav-item"> <a href="javascript:void(0)" onClick="MuestraDelivery('<?php echo encrypt("ENTREGADOS"); ?>');" class="nav-link rounded-pill note-link d-flex align-items-center px-2 px-md-3 mr-0 mr-md-2" id="note-social">
                <i class="mdi mdi-view-parallel"></i><span class="d-none d-md-block"> Entregados</span></a> 
            </li>

            <li class="nav-item ml-auto"> <a href="javascript:void(0)" onClick="RecargaDelivery('<?php echo encrypt("TODOS"); ?>');" class="nav-link btn-primary rounded-pill d-flex align-items-center px-3" id="add-notes">
                <i class="mdi mdi-refresh"></i><span class="d-none d-md-block font-14"> Recargar Mostrador</span></a> 
            </li>
        </ul>
    </div>
    <!-- End Row -->
            
    <div id="delivery"></div>

    <script type="text/javascript">
    $('#delivery').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
    setTimeout(function() {
    $('#delivery').load("consultas?CargaDelivery=si&proceso="+'<?php echo encrypt("TODOS"); ?>');
     }, 200);
    </script>
    
<?php } else { ?>

    <div class="row">
    <div class="col-md-12 col-lg-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-uppercase mb-0">
                Gráfico de Registros
            </h5>
            <div id="chart-container">
                <canvas id="bar-chart" width="800" height="400"></canvas>
            </div>
            <script>
                    // Bar chart
                    new Chart(document.getElementById("bar-chart"), {
                        type: 'bar',
                        data: {
                            labels: ["Clientes", "Proveedores", "Ingredientes", "Productos", "Compras", "Ventas"],
                            datasets: [
                            {
                                label: "Cantidad Nº",
                                backgroundColor: ["#ff7676", "#3e95cd","#3cba9f","#003399","#f0ad4e","#969788"],
                                data: [<?php echo $grafico[0]['clientes'] ?>,<?php echo $grafico[0]['proveedores'] ?>,<?php echo $grafico[0]['ingredientes'] ?>,<?php echo $grafico[0]['productos'] ?>,<?php echo $grafico[0]['compras'] ?>,<?php echo $grafico[0]['ventas'] ?>]
                            }
                            ]
                        },
                        options: {
                            legend: { display: false },
                            title: {
                                display: true,
                                text: 'Cantidad de Registros'
                            }
                        }
                    });
                </script>
            </div>
        </div>
    </div>

<?php  
$compra = new Login();
$commes = $compra->SumaCompras();

$venta = new Login();
$venmes = $venta->SumaVentas();

?>

<div class="col-md-12 col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-uppercase mb-0">
                    Compras del Año <?php echo date("Y"); ?>
                </h5>
                    <div id="chart-container">
                    <canvas id="bar-chart3" width="800" height="400"></canvas>
                    </div>
                    <script>
                            // Bar chart
                            new Chart(document.getElementById("bar-chart3"), {
                                type: 'bar',
                                data: {
                                    labels: ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"],
                                    datasets: [
                                    {
                                        label: "Monto Mensual",
                                        backgroundColor: ["#ff7676","#3e95cd","#808080","#F38630","#25AECD","#008080","#00FFFF","#3cba9f","#2E64FE","#e8c3b9","#F7BE81","#FA5858"],
                                        data: [<?php 

                              if($commes[0]['totalmes'] == 0) { echo 0; } else {

                                  $meses = array(1 => 0, 2=> 0, 3=> 0, 4=> 0, 5=> 0, 6=> 0, 7=> 0, 8=> 0, 9=> 0, 10=> 0, 11=> 0, 12 => 0);
                                  foreach($commes as $row) {
                                    $mes = $row['mes'];
                                    $meses[$mes] = $row['totalmes'];
                                }
                                foreach($meses as $mes) {
                                    echo "{$mes},"; } } ?>]
                                }]
                            },
                            options: {
                                legend: { display: false },
                                title: {
                                    display: true,
                                    text: 'Suma de Monto Mensual'
                                }
                            }
                        });
                    </script>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-uppercase mb-0">
                    Ventas del Año <?php echo date("Y"); ?>
                </h5>
                <div id="chart-container">
                <canvas id="bar-chart4" width="800" height="400"></canvas>
                </div>
                <script>
                // Bar chart
                new Chart(document.getElementById("bar-chart4"), {
                    type: 'bar',
                    data: {
                    labels: ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"],
                    datasets: [
                          {
                            label: "Monto Mensual",
                            backgroundColor: ["#ff7676","#3e95cd","#808080","#F38630","#7B82EC","#8EE1BC","#D3E37D","#E8AC9E","#2E64FE","#E399DA","#F7BE81","#FA5858"],
                            data: [<?php 

                      if($venmes[0]['totalmes'] == 0) { echo 0; } else {

                        $meses = array(1 => 0, 2=> 0, 3=> 0, 4=> 0, 5=> 0, 6=> 0, 7=> 0, 8=> 0, 9=> 0, 10=> 0, 11=> 0, 12 => 0);
                          foreach($venmes as $row) {
                            $mes = $row['mes'];
                            $meses[$mes] = $row['totalmes'];
                        }
                        foreach($meses as $mes) {
                            echo "{$mes},"; } } ?>]
                        }]
                    },
                    options: {
                        legend: { display: false },
                        title: {
                        display: true,
                        text: 'Suma de Monto Mensual'
                        }
                    }
                });
                </script>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-uppercase mb-0">
                    8 Productos Mas Vendidos del Año <?php echo date("Y"); ?>
                </h5>
                    <div id="chart-container">
                    <canvas id="DoughnutChart" width="800" height="500"></canvas>
                    </div>
                    <script>
                    $(document).ready(function () {
                        showGraphDoughnutPV();
                    });
                    </script>
            </div>
        </div>
    </div>
</div>

<?php
/*for($i = 1; $i <= 10; $i++){
    echo $i."X7 = ".($i*7)."<br>";
}*/
?>
    

<?php } ?>
    
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
    <script src="assets/js/notes.js"></script>
    <!--Custom JavaScript -->
    <script src="assets/js/custom.js"></script>

    <!-- script jquery -->
    <script type="text/javascript" src="assets/script/titulos.js"></script>
    <script type="text/javascript" src="assets/script/jquery.mask.js"></script>
    <script type="text/javascript" src="assets/script/mask.js"></script>
    <script type="text/javascript" src="assets/script/script2.js"></script>
    <script type="text/javascript" src="assets/script/jsventas.js"></script>
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
    <!-- jQuery -->
    <?php if ($_SESSION['acceso'] == "cocinero") { ?>

    <script type="text/javascript">
    setInterval(function() {
    $("#all-todo").addClass("active");
    $("#all-category").removeClass("active");
    $("#note-business").removeClass("active");
    $("#note-social").removeClass("active");
    $('#mostrador').load("consultas?CargaMostrador=si&proceso="+'<?php echo encrypt("TODOS"); ?>');
     }, 10000);
    </script>

    <?php } elseif ($_SESSION['acceso'] == "repartidor") { ?>

    <script type="text/javascript">
    setInterval(function() {
    $("#all-todo").addClass("active");
    $("#note-social").removeClass("active");
    $('#delivery').load("consultas?CargaDelivery=si&proceso="+'<?php echo encrypt("TODOS"); ?>');
     }, 10000);
    </script>

    <?php } else { ?>

    <script type="text/javascript">
    $('#loading').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
    setTimeout(function() {
    $('#loading').load("salas_mesas?CargaMesas=si");
     }, 1000);
    </script>

    <?php } ?>

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