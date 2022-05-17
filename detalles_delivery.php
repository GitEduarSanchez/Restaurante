<?php
require_once("class/class.php");
?>
<script type="text/javascript" src="assets/script/jsdelivery.js"></script>
<script src="assets/script/jscalendario.js"></script>
<script src="assets/script/autocompleto.js"></script> 

<?php
$imp = new Login();
$imp = $imp->ImpuestosPorId();
$impuesto = ($imp == "" ? "Impuesto" : $imp[0]['nomimpuesto']);
$valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

$con = new Login();
$con = $con->ConfiguracionPorId();
$simbolo = ($con == "" ? "" : "<strong>".$con[0]['simbolo']."</strong>");

$new = new Login();
?>


<?php
##################################################################################################################
#                                                                                                                #
#                                  FUNCIONES PARA PEDIDOS DE PRODUCTOS EN DELIVERY                               #
#                                                                                                                #
##################################################################################################################
?>

<?php
############################ MUESTRA PEDIDOS EN DELIVERY ########################### 
if (isset($_GET['CargaPedidosDelivery']) && isset($_GET['codpedido'])):

$pedido = new Login();
$reg = $pedido->ListarPedidosDelivery();
?>
  <div class="row-horizon">
      <span style="font-size: 16px;" class="categorias <?php if(decrypt($_GET['codpedido']) == '0' || $_GET['codpedido'] == '0'){ ?> selectedGat <?php } else { ?> <?php } ?>" onClick="RecibeDelivery('0','0');"><i class="fa fa-plus-circle"></i></span>
      <?php 
      if($reg==""){ echo ""; } else {
      $a=1;
      for ($i = 0; $i < sizeof($reg); $i++) { ?>
      <span class="categorias <?php if(encrypt($reg[$i]['codpedido']) == $_GET['codpedido']){ ?> selectedGat <?php } ?>" onClick="RecibeDelivery('<?php echo encrypt($reg[$i]['codpedido']);?>','<?php echo encrypt($reg[$i]['codventa']);?>');"><span class="font-16"><?php echo $a++;?></span> <abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?>">  <span style="font-size: 12px;"><i class="fa fa-clock-o"></i>  <?php echo date("H:i:s",strtotime($reg[$i]['fechapedido']));?></span></abbr></span>
      <?php } } ?>
  </div><br>
<?php 
############################ MUESTRA PEDIDOS EN DELIVERY ###########################
endif; ?>


<?php
######################## BUSQUEDA DETALLE DE PRODUCTO #######################
if (isset($_GET['BuscaDetallesProducto']) && isset($_GET['d_codigo']) && isset($_GET['d_tipo']) && isset($_GET['d_cantidad']) && isset($_GET['d_observacion'])) { 

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
######################## BUSQUEDA DETALLE DE PRODUCTO ########################
?>


<?php 
######################## MOSTRAR PEDIDOS EN DELIVERY ########################
if (isset($_GET['BuscaPedidoDelivery']) && isset($_GET['codpedido']) && isset($_GET['codventa'])) {

$detalle = new Login();
$detalle = $detalle->VerificaDelivery(); 

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
      <input type="hidden" name="codpedido" id="codpedido" value="<?php echo encrypt($detalle[0]['codpedido']); ?>">
      <input type="hidden" name="codventa" id="codventa" value="<?php echo encrypt($detalle[0]['codventa']); ?>">
      <input type="hidden" name="proceso" id="proceso" value="agregarpedido"/>

      <div class="row">
          <div class="col-md-12">
              <label class="control-label">Búsqueda de Cliente: </label>
              <div class="input-group mb-3 has-feedback">
                  <div class="input-group-append">
                  <button type="button" class="btn btn-success waves-effect waves-light" data-placement="left" title="Nuevo Cliente" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCliente" data-backdrop="static" data-keyboard="false"><i class="fa fa-user-plus"></i></button>
                  </div>
                  <input type="hidden" name="codcliente" id="codcliente" value="<?php echo $detalle[0]['codcliente'] == '0' ? "0" : $detalle[0]['codcliente']; ?>">
                  <input type="text" class="form-control" name="busqueda" id="busqueda" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Criterio para la Búsqueda del Cliente" value="<?php echo $detalle[0]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $documento = ($detalle[0]['documcliente'] == '0' ? "DOCUMENTO" : $detalle[0]['documento']).": ".$detalle[0]['dnicliente'].": ".$detalle[0]['nomcliente']; ?>" autocomplete="off"/>
              </div>
          </div>
      </div>

      <div class="row">
         <div class="col-md-5">
           <div class="form-group">
          <label class="control-label">Tipo de Pedido: <span class="symbol required"></span></label><br>
          <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" id="evento1" name="tipopedido" 
             <?php if($detalle[0]['repartidor'] == 0) { ?> value="INTERNO" checked="checked" <?php } else { ?> checked="checked" <?php } ?> onClick="TipoPedido('this.form.tipopedido.value')">
            <label class="custom-control-label" for="evento1">EN ESTABLECIMIENTO</label>
          </div>

          <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" id="evento2" name="tipopedido" value="EXTERNO" <?php if($detalle[0]['repartidor'] != 0) { ?> checked="checked" <?php } ?> onClick="TipoPedido('this.form.tipopedido.value')">
            <label class="custom-control-label" for="evento2">PARA DOMICILIO</label>
          </div>
          </div>
      </div>

      <div class="col-md-7"> 
        <div class="form-group has-feedback"> 
          <label class="control-label">Nombre de Repartidor: <span class="symbol required"></span></label>
          <i class="fa fa-bars form-control-feedback"></i>
          <?php if($detalle[0]['repartidor'] != 0) { ?>
          <select name="repartidor" id="repartidor" class="form-control" required="" aria-required="true">
            <option value=""> -- SELECCIONE -- </option>
              <?php
              $usuario = new Login();
              $usuario = $usuario->ListarRepartidores();
              if($usuario==""){ 
                echo "";
              } else {
              for($i=0;$i<sizeof($usuario);$i++){ ?>
              <option value="<?php echo encrypt($usuario[$i]['codigo']); ?>"<?php if (!(strcmp($detalle[0]['repartidor'], htmlentities($usuario[$i]['codigo'])))) {echo "selected=\"selected\""; } ?>><?php echo $usuario[$i]['nombres'] ?></option>   
            <?php } } ?>
          </select>
        <?php } else { ?>
          <select name="repartidor" id="repartidor" class="form-control" disabled="" required="" aria-required="true">
            <option value=""> -- SELECCIONE -- </option>
              <?php
              $usuario = new Login();
              $usuario = $usuario->ListarRepartidores();
              if($usuario==""){ 
                echo "";
              } else {
              for($i=0;$i<sizeof($usuario);$i++){ ?>
              <option value="<?php echo encrypt($usuario[$i]['codigo']); ?>"><?php echo $usuario[$i]['nombres'] ?></option>   
            <?php } } ?>
          </select>
          <?php } ?>
        </div> 
      </div>
    </div>

    <div id="favoritos" style="display:none !important;"></div>

    <div class="table-responsive m-t-10 scroll">
        <table id="carrito" class="table2">
          <thead>
            <tr>
              <th width="16%">Cantidad</th>
              <th width="42%">Descripción</th>
              <th width="14%">Precio</th>
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
        <button type="button" onClick="MuestraFavoritos()" class="btn btn-success btn-lg btn-block waves-effect waves-light"><span class="fa fa-star"></span> Favoritos</button>
      </div>
      <div class="col-md-6">
        <button type="button" class="btn btn-info btn-lg btn-block waves-effect waves-light" onClick="RecargaPedidos('<?php echo encrypt("DELIVERY"); ?>');" data-placement="left" title="Ver Pedidos" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalPedidos" data-backdrop="static" data-keyboard="false"><i class="fa fa-cutlery"></i> Pedidos</button>
      </div>
    </div>
  
    <div class="table-responsive"><!-- if table-responsive -->

      <hr><h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cart-plus"></i> Detalles Agregados</h2><hr>

      <div id="div" class="table-responsive m-t-10" style="background: #f7ebda;"><!-- if div -->
        <table class="table2">
            <tbody>
 <?php 
for($i=0;$i<sizeof($detalle);$i++){
?>
            <tr class="font-12">
            <td class="alert-link" width="15%"><?php echo $detalle[$i]['cantventa']; ?></td>
            <td width="58%"><?php echo $detalle[$i]['producto']; ?>
            <small class="text-dark alert-link"><?php echo $detalle[$i]['observacionespedido'] == "" ? "" : "<br>(".$detalle[$i]['observacionespedido'].")"; ?></small></td>
            <td width="22%"><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>

            <td width="5%"><span class="text-danger" style="cursor:pointer;" title="Eliminar Detalle" onClick="EliminaPedidoDelivery('<?php echo encrypt($detalle[$i]["codpedido"]) ?>','<?php echo encrypt($detalle[$i]["pedido"]) ?>','<?php echo encrypt($detalle[$i]["codventa"]) ?>','<?php echo encrypt($detalle[0]["codcliente"]) ?>','<?php echo encrypt($detalle[$i]["codproducto"]) ?>','<?php echo encrypt($detalle[$i]["cantventa"]) ?>','<?php echo encrypt("ELIMINADETALLEPEDIDO") ?>')"><i style="font-size: 22px;" class="fa fa-trash"></i></span></td>

            </tr>
          <?php } ?>
           </tbody>
        </table>   
      </div><!-- if div --><br>

    <table id="carritototal" class="table-responsive">
    
    <tr>
    <td width="10"></td>
    <td width="180">
    <h5 class="text-left"><label>Gravado <?php echo number_format($detalle[0]['iva'], 2, '.', ','); ?>%:</label></h5>    
    </td>
    <td width="250">
    <h5 class="text-left"><?php echo $simbolo; ?><label><?php echo number_format($detalle[0]['subtotalivasi'], 2, '.', ','); ?></label></h5>
    </td>
    <td width="180">
    <h5 class="text-left"><label>Exento 0%:</label></h5>    
    </td>
    <td width="250">
    <h5 class="text-right"><?php echo $simbolo; ?><label><?php echo number_format($detalle[0]['subtotalivano'], 2, '.', ','); ?></label></h5>
    </td>
    <td width="10"></td>
    </tr>

    <tr>
    <td></td>
    <td>
    <h5 class="text-left"><label><?php echo $impuesto; ?> <?php echo number_format($detalle[0]['iva'], 2, '.', ','); ?>%:</label></h5>
    </td>
    <td>
    <h5 class="text-left"><?php echo $simbolo; ?><label><?php echo number_format($detalle[0]['totaliva'], 2, '.', ','); ?></label></h5></td>
    <td width="180">
    <h5 class="text-left"><label>Descontado %:</label></h5>
    </td>
    <td><h5 class="text-right"><?php echo $simbolo; ?><label id="lbldescontado" name="lbldescontado"><?php echo number_format($detalle[0]['descontado'], 2, '.', ','); ?></label></h5>
    </td>
    <td width="10"></td>      
    </tr>

    <tr>
    <td></td>
    <td colspan="2">
    <h5><label class="text-right">DESC: <input class="number" type="text" name="descuento2" id="descuento2" onKeyPress="EvaluateText('%f', this);" style="border-radius:4px;height:25px;width:45px;" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($detalle[0]['descuento'], 2, '.', ''); ?>">%:</label></h5>
    </td>
    <td colspan="2">
    <h5 class="text-right"> <?php echo $simbolo; ?><label id="lbldescuento2" name="lbldescuento2"><?php echo number_format($detalle[0]['totaldescuento'], 2, '.', ','); ?></label></h5>
    <input type="hidden" name="txtDescuento" id="txtDescuento" value="0.00"/>
    </td>
    <td width="10"></td>
    </tr>

    <tr>
    <td></td>
    <td colspan="2">
    <h4><label class="text-right">TOTAL A PAGAR:</label></h4>
    </td>
    <td colspan="2">
    <h4 class="text-right"> <?php echo $simbolo; ?><label id="lbltotal2" name="lbltotal2"><?php echo number_format($detalle[0]['totalpago'], 2, '.', ','); ?></label></h4>
    <input type="hidden" name="txtsubtotaliva" id="txtsubtotaliva" value="<?php echo number_format($detalle[0]['subtotalivasi'], 2, '.', ''); ?>"/>
    <input type="hidden" name="txtsubtotaliva2" id="txtsubtotaliva2" value="<?php echo number_format($detalle[0]['subtotalivano'], 2, '.', ''); ?>"/>
    <input type="hidden" name="iva2" id="iva2" autocomplete="off" value="<?php echo number_format($detalle[0]['iva'], 2, '.', ''); ?>">
    <input type="hidden" name="txtIva2" id="txtIva2" value="<?php echo number_format($detalle[0]['totaliva'], 2, '.', ''); ?>"/>
    <input type="hidden" name="txtdescontado2" id="txtdescontado2" value="<?php echo number_format($detalle[0]['descontado'], 2, '.', ''); ?>"/>
    <input type="hidden" name="txtDescuento2" id="txtDescuento2" value="<?php echo number_format($detalle[0]['totaldescuento'], 2, '.', ''); ?>"/>
    <input type="hidden" name="txtTotal2" id="txtTotal2" value="<?php echo number_format($detalle[0]['totalpago'], 2, '.', ''); ?>"/>
    </td>
    <td width="10"></td>
    </tr>

    </table>

  </div><!-- end table-responsive -->

  <div class="row">
    <div class="col-md-4">
      <a href="reportepdf?codpedido=<?php echo encrypt($detalle[0]['codpedido']); ?>&codventa=<?php echo encrypt($detalle[0]['codventa']); ?>&tipo=<?php echo encrypt("PRECUENTA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-info btn-lg btn-block waves-effect waves-light" title="Imprimir Precuenta"><span class="fa fa-print"></span> Precuenta</button></a>
    </div>

    <div class="col-md-4">
      <button type="button" class="btn btn-warning btn-lg btn-block waves-effect waves-light" data-placement="left" onClick="CerrarDelivery('<?php echo encrypt($detalle[0]["codpedido"]) ?>','<?php echo encrypt($detalle[0]["codventa"]) ?>',this.form.descuento2.value,this.form.txtDescuento2.value,this.form.txtTotal2.value,'<?php echo encrypt("DELIVERY") ?>')" title="Cobrar Venta" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalPago" data-backdrop="static" data-keyboard="false"><span class="fa fa-calculator"></span> Pagar</button>
    </div>

    <div class="col-md-4">
      <button type="button" class="btn btn-dark btn-lg btn-block" onClick="CancelarPedidoDelivery('<?php echo encrypt($detalle[0]["codpedido"]) ?>','<?php echo encrypt($detalle[0]["codventa"]) ?>','<?php echo encrypt("CANCELARPEDIDO") ?>')" title="Cancelar Pedido"><span class="fa fa-trash-o"></span> Cancelar</button>
    </div>
  </div>
            
<?php  
  }
######################## MOSTRAR PEDIDOS EN DELIVERY ########################
?>


<?php
################### MUESTRA MODAL CIERRE DE VENTA EN DELIVERY ########################
if (isset($_GET['CargaModalCierreDelivery']) && isset($_GET['codpedido']) && isset($_GET['codventa']) && isset($_GET['descuento']) && isset($_GET['totaldescuento']) && isset($_GET['totalpago'])) {

$detalle = new Login();
$detalle = $detalle->DetallesPedido(); 

$arqueo = new Login();
$arqueo = $arqueo->ArqueoCajaPorUsuario();

$codpedido = limpiar(decrypt($_GET['codpedido']));
$codventa = limpiar(decrypt($_GET['codventa']));
$descuento = limpiar($_GET['descuento']);
$totaldescuento = limpiar($_GET['totaldescuento']);
$totalpago = limpiar($_GET['totalpago']);
  
?>
    
      <div class="row">
        <div class="col-md-12">
          <div class="form-group has-feedback">
            <label class="control-label"><h4 class="mb-0 font-light">Búsqueda de Cliente: </h4></label>
            <input type="hidden" name="codcliente" id="codcliente" value="<?php echo $detalle[0]['codcliente'] == '' ? "0" : $detalle[0]['codcliente']; ?>">
            <input type="text" class="form-control" name="busqueda" id="busqueda" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Criterio para la Búsqueda del Cliente" value="<?php echo $detalle[0]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $documento = ($detalle[0]['documcliente'] == '0' ? "DOCUMENTO" : $detalle[0]['documento']).": ".$detalle[0]['dnicliente'].": ".$detalle[0]['nomcliente']; ?>" autocomplete="off"/>
            <i class="fa fa-search form-control-feedback"></i>
          </div>
        </div> 
      </div>

      <div class="row">
        <div class="col-md-4">
          <h4 class="mb-0 font-light">Total a Pagar</h4>
          <h3 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TextImporte" name="TextImporte"><?php echo number_format($totalpago, 2, '.', ',') ?></label></h4>
        </div>

        <div class="col-md-4">
          <h4 class="mb-0 font-light">Total Recibido</h4>
          <h3 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TextPagado" name="TextPagado"><?php echo number_format($totalpago, 2, '.', ',') ?></label></h4>
        </div>

        <div class="col-md-4">
          <h4 class="mb-0 font-light">Total Cambio</h4>
          <h3 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TextCambio" name="TextCambio">0.00</label></h4>
        </div>
      </div>
             
      <div class="row">
        <div class="col-md-8">
          <h4 class="mb-0 font-light">Nombre del Cliente</h4>
          <h4 class="mb-0 font-medium"> <label id="TextCliente" name="TextCliente"><?php echo $detalle[0]['codcliente'] == '0' || $detalle[0]['codcliente'] == '' ? "CONSUMIDOR FINAL" : $detalle[0]['nomcliente']; ?></label></h4>
        </div>

        <div class="col-md-4">
          <h4 class="mb-0 font-light">Limite de Crédito</h4>
          <h4 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TextCredito" name="TextCredito">0.00</label></h4>
        </div>
      </div>

      <hr>

      <div class="row">
           <div class="col-md-4">
             <div class="form-group">
            <label class="control-label">Tipo de Pedido: <span class="symbol required"></span></label><br>
            <div class="custom-control custom-radio">
              <input type="radio" class="custom-control-input" id="evento1" name="tipopedido" 
               <?php if($detalle[0]['repartidor'] == 0) { ?> value="INTERNO" checked="checked" <?php } else { ?> checked="checked" <?php } ?> onclick="TipoPedido('this.form.tipopedido.value')">
              <label class="custom-control-label" for="evento1">EN ESTABLECIMIENTO</label>
            </div>

            <div class="custom-control custom-radio">
              <input type="radio" class="custom-control-input" id="evento2" name="tipopedido" value="EXTERNO" <?php if($detalle[0]['repartidor'] != 0) { ?> checked="checked" <?php } ?> onclick="TipoPedido('this.form.tipopedido.value')">
              <label class="custom-control-label" for="evento2">PARA DOMICILIO</label>
            </div>
            </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label class="control-label">Tipo de Documento: <span class="symbol required"></span></label><br>
              <div class="form-check form-check-inline">
                <div class="custom-control custom-radio">
                  <input type="radio" class="custom-control-input" id="ticket" name="tipodocumento" value="TICKET" checked="checked">
                  <label class="custom-control-label" for="ticket">TICKET</label>
                </div>
              </div>

              <div class="form-check form-check-inline">
                <div class="custom-control custom-radio">
                  <input type="radio" class="custom-control-input" id="boleta" name="tipodocumento" value="BOLETA">
                  <label class="custom-control-label" for="boleta">BOLETA</label>
                </div>
              </div><br>

              <div class="form-check form-check-inline">
                <div class="custom-control custom-radio">
                  <input type="radio" class="custom-control-input" id="factura" name="tipodocumento" value="FACTURA">
                  <label class="custom-control-label" for="factura">FACTURA</label>
                </div>
              </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label class="control-label">Condición de Pago: <span class="symbol required"></span></label>
            <input type="hidden" name="proceso" id="proceso" value="cerrardelivery"/>
            <input type="hidden" name="codcaja" id="codcaja" value="<?php echo $arqueo[0]["codcaja"]; ?>">
            <input type="hidden" name="codpedido" id="codpedido" value="<?php echo $codpedido; ?>">
            <input type="hidden" name="codventa" id="codventa" value="<?php echo $codventa; ?>">
            <input type="hidden" name="venta" id="venta" value="<?php echo encrypt($codventa); ?>">
            <input type="hidden" name="subtotalivasi" id="subtotalivasi" value="<?php echo number_format($detalle[0]['subtotalivasi'], 2, '.', ''); ?>"/>
            <input type="hidden" name="subtotalivano" id="subtotalivano" value="<?php echo number_format($detalle[0]['subtotalivano'], 2, '.', ''); ?>"/>
            <input type="hidden" name="descuento" id="descuento" value="<?php echo number_format($descuento, 2, '.', ''); ?>"/>
            <input type="hidden" name="txtDescuento" id="txtDescuento" value="<?php echo number_format($totaldescuento, 2, '.', ''); ?>"/>
            <input type="hidden" name="iva" id="iva" value="<?php echo number_format($detalle[0]['iva'], 2, '.', ''); ?>"/>
            <input type="hidden" name="totaliva" id="totaliva" value="<?php echo number_format($detalle[0]['totaliva'], 2, '.', ''); ?>"/>
            <input type="hidden" name="txtdescontado" id="txtdescontado" value="<?php echo number_format($detalle[0]['totaliva'], 2, '.', ''); ?>"/>
            <input type="hidden" name="txtImporte" id="txtImporte" value="<?php echo number_format($totalpago, 2, '.', ''); ?>"/>
            <input type="hidden" name="txtTotal" id="txtTotal" value="<?php echo number_format($totalpago, 2, '.', ''); ?>"/>
            <input type="hidden" name="txtAgregado" id="txtAgregado" value="<?php echo number_format($totalpago, 2, '.', ''); ?>"/>
            <input type="hidden" name="fechaventa" id="fechaventa" value="<?php echo date("Y-m-d",strtotime($detalle[0]['fechaventa'])); ?>"/>
            <div class="custom-control custom-radio">
              <input type="radio" class="custom-control-input" id="contado" name="tipopago" value="CONTADO" onClick="CargaCondicionesPagos()" checked="checked">
              <label class="custom-control-label" for="contado">CONTADO</label>
            </div>

            <div class="custom-control custom-radio">
              <input type="radio" class="custom-control-input" id="credito" name="tipopago" value="CREDITO" onClick="CargaCondicionesPagos()">
              <label class="custom-control-label" for="credito">CRÉDITO</label>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-8"> 
          <div class="form-group has-feedback"> 
            <label class="control-label">Nombre de Repartidor: <span class="symbol required"></span></label>
            <i class="fa fa-bars form-control-feedback"></i>
            <?php if($detalle[0]['repartidor'] != 0) { ?>
            <select name="repartidor" id="repartidor" class="form-control" required="" aria-required="true">
              <option value=""> -- SELECCIONE -- </option>
                <?php
                $usuario = new Login();
                $usuario = $usuario->ListarRepartidores();
                if($usuario==""){ 
                  echo "";
                } else {
                for($i=0;$i<sizeof($usuario);$i++){ ?>
                <option value="<?php echo encrypt($usuario[$i]['codigo']); ?>"<?php if (!(strcmp($detalle[0]['repartidor'], htmlentities($usuario[$i]['codigo'])))) {echo "selected=\"selected\""; } ?>><?php echo $usuario[$i]['nombres'] ?></option>   
              <?php } } ?>
            </select>
          <?php } else { ?>
            <select name="repartidor" id="repartidor" class="form-control" disabled="" required="" aria-required="true">
              <option value=""> -- SELECCIONE -- </option>
                <?php
                $usuario = new Login();
                $usuario = $usuario->ListarRepartidores();
                if($usuario==""){ 
                  echo "";
                } else {
                for($i=0;$i<sizeof($usuario);$i++){ ?>
                <option value="<?php echo encrypt($usuario[$i]['codigo']); ?>"><?php echo $usuario[$i]['nombres'] ?></option>   
              <?php } } ?>
            </select>
            <?php } ?>
          </div> 
        </div>

        <div class="col-md-4"> 
          <div class="form-group has-feedback"> 
            <label class="control-label">Costo Delivery: <span class="symbol required"></span></label>
            <input class="form-control" type="text" name="montodelivery" id="montodelivery" onKeyUp="DevolucionDelivery();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" autocomplete="off" placeholder="Ingrese Costo Delivery" value="0.00" <?php if($detalle[0]['repartidor'] != 0) { ?> enabled="" <?php } else { ?> disabled="" <?php } ?> required="" aria-required="true"> 
            <i class="fa fa-dollar form-control-feedback"></i>
          </div> 
        </div>
      </div>

      <div id="muestra_condiciones"><!-- IF CONDICION PAGO -->

      <div class="row">

        
        <!-- .col -->
        <div class="col-md-4">

        <h4 class="card-subtitle m-0 text-dark"><i class="font-18 mdi mdi-cash-multiple"></i> Propina Recibida</h4><hr>
            
        <div class="row">
          <div class="col-md-12"> 
            <div class="form-group has-feedback"> 
              <label class="control-label">Pago de Propina: </label>
              <i class="fa fa-bars form-control-feedback"></i>
              <select name="formapropina" id="formapropina" class="form-control" required="" aria-required="true">
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
              <label class="control-label">Propina Recibida: </label>
              <input class="form-control" type="number" name="montopropina" id="montopropina" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" autocomplete="off" placeholder="Propina Recibida" value="0.00" disabled="" required="" aria-required="true"> 
              <i class="fa fa-dollar form-control-feedback"></i>
            </div> 
          </div>
        </div>

        </div>
        <!-- /.col -->

        <!-- .col -->
        <div class="col-md-4">

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
              <input class="form-control" type="number" name="montopagado" id="montopagado" onKeyUp="DevolucionDelivery();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" autocomplete="off" placeholder="Monto de Pago Nº 1" value="<?php echo number_format($totalpago, 2, '.', ''); ?>" required="" aria-required="true"> 
              <i class="fa fa-dollar form-control-feedback"></i>
            </div> 
          </div>
        </div>

        </div>
        <!-- /.col -->

        <!-- .col -->
        <div class="col-md-4">

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
              <input class="form-control" type="number" name="montopagado2" id="montopagado2" onKeyUp="DevolucionDelivery();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" autocomplete="off" placeholder="Monto de Pago Nº 2" value="0.00" disabled="" required="" aria-required="true"> 
              <i class="fa fa-dollar form-control-feedback"></i>
            </div>  
          </div>
        </div>

        </div>
        <!-- /.col -->

      </div>

    </div><!-- END CONDICION PAGO -->

    <div id="muestra_documentos"></div>

      <div class="row">
        <div class="col-md-12"> 
          <div class="form-group has-feedback2"> 
            <label class="control-label">Observaciones: </label> 
            <textarea class="form-control" type="text" name="observaciones" id="observaciones" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Observaciones" rows="1"></textarea>
            <i class="fa fa-comment-o form-control-feedback2"></i> 
          </div> 
        </div>
      </div> 

<?php
}
######################## MUESTRA MODAL CIERRE DE VENTA EN DELIVERY ########################
?>


<?php 
######################## MUESTRA CONDICIONES DE PAGO PARA DELIVERY ########################
if (isset($_GET['BuscaCondicionesPagos']) && isset($_GET['tipopago']) && isset($_GET['txtTotal'])) { 
  
$tra = new Login();

 if(limpiar($_GET['tipopago'])==""){ echo ""; 

 } elseif(limpiar($_GET['tipopago'])=="CONTADO"){  ?>

    <div class="row">

        
        <!-- .col -->
        <div class="col-md-4">

        <h4 class="card-subtitle m-0 text-dark"><i class="font-18 mdi mdi-cash-multiple"></i> Propina Recibida</h4><hr>
            
        <div class="row">
          <div class="col-md-12"> 
            <div class="form-group has-feedback"> 
              <label class="control-label">Pago de Propina: </label>
              <i class="fa fa-bars form-control-feedback"></i>
              <select name="formapropina" id="formapropina" class="form-control" required="" aria-required="true">
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
              <label class="control-label">Propina Recibida: </label>
              <input class="form-control number" type="text" name="montopropina" id="montopropina" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" autocomplete="off" placeholder="Propina Recibida" value="0.00" disabled="" required="" aria-required="true"> 
              <i class="fa fa-dollar form-control-feedback"></i>
            </div> 
          </div>
        </div>

        </div>
        <!-- /.col -->

        <!-- .col -->
        <div class="col-md-4">

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
              <input class="form-control" type="text" name="montopagado" id="montopagado" onKeyUp="DevolucionDelivery();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" autocomplete="off" placeholder="Monto de Pago Nº 1" value="<?php echo number_format($_GET['txtTotal'], 2, '.', ''); ?>" required="" aria-required="true"> 
              <i class="fa fa-dollar form-control-feedback"></i>
            </div> 
          </div>
        </div>

        </div>
        <!-- /.col -->

        <!-- .col -->
        <div class="col-md-4">

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
              <input class="form-control" type="text" name="montopagado2" id="montopagado2" onKeyUp="DevolucionDelivery();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" autocomplete="off" placeholder="Monto de Pago Nº 2" value="0.00" disabled="" required="" aria-required="true"> 
              <i class="fa fa-dollar form-control-feedback"></i>
            </div>  
          </div>
        </div>

        </div>
        <!-- /.col -->

      </div>
          
 <?php   } else if(limpiar($_GET['tipopago'])=="CREDITO"){  ?>

      <div class="row">
        <div class="col-md-4"> 
             <div class="form-group has-feedback"> 
                <label class="control-label">Fecha Vence Crédito: <span class="symbol required"></span></label> 
                <input type="text" class="form-control vencecredito" name="fechavencecredito" id="fechavencecredito" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo date("d-m-Y"); ?>" placeholder="Ingrese Fecha Vence Crédito" aria-required="true">
                <i class="fa fa-calendar form-control-feedback"></i>  
           </div> 
        </div>

        <div class="col-md-4"> 
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

        <div class="col-md-4"> 
          <div class="form-group has-feedback"> 
            <label class="control-label">Abono Crédito: <span class="symbol required"></span></label>
            <input type="hidden" name="formapago" id="formapago" value="">
            <input type="hidden" name="montopagado" id="montopagado" value="0.00">
            <input type="hidden" name="formapago2" id="formapago2" value="">
            <input type="hidden" name="montopagado2" id="montopagado2" value="0.00">
            <input type="hidden" name="montodevuelto" id="montodevuelto" value="0.00">
            <input type="hidden" name="montopropina" id="montopropina" value="0.00">
            <input class="form-control number" type="text" name="montoabono" id="montoabono" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" autocomplete="off" placeholder="Ingrese Monto de Abono" value="0.00" required="" aria-required="true"> 
            <i class="fa fa-dollar form-control-feedback"></i>
          </div> 
        </div>
      </div>
 
<?php  }
  }
######################## MUESTRA CONDICIONES DE PAGO PARA DELIVERY ########################
?>


<?php
##################################################################################################################
#                                                                                                                #
#                                  FUNCIONES PARA PEDIDOS DE PRODUCTOS EN DELIVERY                               #
#                                                                                                                #
##################################################################################################################
?>