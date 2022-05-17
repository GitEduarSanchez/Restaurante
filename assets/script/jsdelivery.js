function DoAction(idproducto, codproducto, producto, codcategoria, categorias, preciocompra, precioventa, descproducto, ivaproducto, existencia, precioconiva, tipo, observacion) 
{
    addItem(idproducto, codproducto, 1.00, producto, codcategoria, categorias, preciocompra, precioventa, descproducto, ivaproducto, existencia, precioconiva, tipo, observacion, '+=');
}

function DoActionObservacion(idproducto, codproducto, producto, codcategoria, categorias, preciocompra, precioventa, descproducto, ivaproducto, existencia, precioconiva, tipo, observacion) 
{
    addItem(idproducto, codproducto, 0.00, producto, codcategoria, categorias, preciocompra, precioventa, descproducto, ivaproducto, existencia, precioconiva, tipo, observacion, '+=');
}

// FUNCION PARA ASIGNAR OBSERVACION A DETALLES
function AsignaObservacion(codigo,tipo,cantidad,observacion)
{
  $("#agregaobservaciones #d_codigo").val(codigo);
  $("#agregaobservaciones #agrega_detalle_observacion").load("detalles_delivery?BuscaDetallesProducto=si&d_codigo="+codigo+"&d_tipo="+tipo+"&d_cantidad="+cantidad+"&d_observacion="+observacion);
}


function pulsar(e, valor) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 13) comprueba(valor)
}

$(document).ready(function() {

    $("#busquedaproducto").keypress(function(e) {
        if (e.charCode == 13 || e.keyCode == 13) { //ENTER

            var code = $('input#codproducto').val();
            var prod = $('input#producto').val();
            var cantp = $('input#cantidad').val();
            var exist = $('input#existencia').val();
            var prec = $('input#preciocompra').val();
            var prec2 = $('input#precioventa').val();
            var descuen = $('input#descproducto').val();
            var ivgprod = $('input#ivaproducto').val();
            localStorage.setItem('commentProd1', $('#observacion').val());
            var er_num = /^([0-9])*[.]?[0-9]*$/;
            cantp = parseInt(cantp);
            exist = parseInt(exist);
            cantp = cantp;

            if (code == "") {
                $("#busquedaproducto").focus();
                $("#busquedaproducto").css('border-color', '#f0ad4e');
                swal("Oops", "POR FAVOR REALICE LA BÚSQUEDA DEL PRODUCTO CORRECTAMENTE!", "error");
                return false;

            } else if ($('#cantidad').val() == "" || $('#cantidad').val() == "0") {
                $("#cantidad").focus();
                $("#cantidad").css('border-color', '#f0ad4e');
                swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA EN VENTAS!", "error");
                return false;

            } else if (isNaN($('#cantidad').val())) {
                $("#cantidad").focus();
                $("#cantidad").css('border-color', '#f0ad4e');
                swal("Oops", "POR FAVOR INGRESE SOLO DIGITOS EN CANTIDAD DE VENTAS!", "error");
                return false;
                
           } else if(cantp > exist){
                $("#cantidad").focus();
                $('#cantidad').css('border-color','#f0ad4e');
                $("#existencia").focus();
                $('#existencia').css('border-color','#f0ad4e');
                swal("Oops", "LA CANTIDAD DE PRODUCTOS SOLICITADA NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR!", "error");
                return false;

            } else {

                var Carrito = new Object();
                Carrito.Id = $('input#idproducto').val();
                Carrito.Codigo = $('input#codproducto').val();
                Carrito.Producto = $('input#producto').val();
                Carrito.Codcategoria = $('input#codcategoria').val();
                Carrito.Categorias = $('input#categorias').val();
                Carrito.Precio      = $('input#preciocompra').val();
                Carrito.Precio2      = $('input#precioventa').val();
                Carrito.Descproducto      = $('input#descproducto').val();
                Carrito.Ivaproducto = $('input#ivaproducto').val();
                Carrito.Existencia = $('input#existencia').val();
                Carrito.Precioconiva = $('input#precioconiva').val();
                Carrito.Tipo = $('input#tipo').val();
                Carrito.Observacion = $('input#observacion').val();
                Carrito.Cantidad = $('input#cantidad').val();
                Carrito.opCantidad = '+=';
                var DatosJson = JSON.stringify(Carrito);
                $.post('carritoventa.php', {
                        MiCarrito: DatosJson
                    },
                function(data, textStatus) {
                    $("#carrito tbody").html("");
                    var TotalDescuento = 0;
                    var SubtotalFact = 0;
                    var BaseImpIva1 = 0;
                    var contador = 0;
                    var iva = 0;
                    var total = 0;
                    var TotalCompra = 0;

                    $.each(data, function(i, item) {
                        var cantsincero = item.cantidad;
                        cantsincero = parseFloat(cantsincero);
                        if (cantsincero != 0) {
                            contador = contador + 1;

                //CALCULO DEL TOTAL DE ITEMS
                var Items= parseFloat(cantsincero);
                OperacionItems = parseFloat(OperacionItems) + parseFloat(Items);

                //CALCULO DEL TOTAL DE COMPRAS
                var OperacionCompra= parseFloat(item.precio) * parseFloat(item.cantidad);
                TotalCompra = parseFloat(TotalCompra) + parseFloat(OperacionCompra);

                //CALCULO DEL VALOR TOTAL
                var ValorTotal= parseFloat(item.precio2) * parseFloat(item.cantidad);

                //CALCULO DEL TOTAL DEL DESCUENTO %
                var Descuento = ValorTotal * item.descproducto / 100;
                TotalDescuento = parseFloat(TotalDescuento) + parseFloat(Descuento);

                //OBTENEMOS DESCUENTO INDIVIDUAL POR PRODUCTOS
                var descsiniva = item.precio2 * item.descproducto / 100;
                var descconiva = item.precioconiva * item.descproducto / 100;

                //CALCULO DE BASE IMPONIBLE IVA SIN PORCENTAJE
                var Operac= parseFloat(item.precio2) - parseFloat(descsiniva);
                var Operacion= parseFloat(Operac) * parseFloat(item.cantidad);
                var Subtotal = Operacion.toFixed(2);

                //CALCULO DE BASE IMPONIBLE IVA CON PORCENTAJE
                var Operac3 = parseFloat(item.precioconiva) - parseFloat(descconiva);
                var Operacion3 = parseFloat(Operac3) * parseFloat(item.cantidad);
                var Subbaseimponiva = Operacion3.toFixed(2);

                //BASE IMPONIBLE IVA CON PORCENTAJE
                BaseImpIva1 = parseFloat(BaseImpIva1) + parseFloat(Subbaseimponiva);
                
                //CALCULO GENERAL DE IVA CON BASE IVA * IVA %
                var ivg = $('input#iva').val();
                ivg2  = ivg/100;
                TotalIvaGeneral = parseFloat(BaseImpIva1) * parseFloat(ivg2.toFixed(2));
                
                //SUBTOTAL GENERAL DE FACTURA
                SubtotalFact = parseFloat(SubtotalFact) + parseFloat(Subtotal);
                //BASE IMPONIBLE IVA SIN PORCENTAJE
                BaseImpIva2 = parseFloat(SubtotalFact) - parseFloat(BaseImpIva1);
                
                //CALCULAMOS DESCUENTO POR PRODUCTO
                var desc = $('input#descuento').val();
                desc2  = desc/100;
                
                //CALCULO DEL TOTAL DE FACTURA
                Total = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2) + parseFloat(TotalIvaGeneral);
                TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
                TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));

                var nuevaFila =
                "<tr align='center' style='background:#f9d655;'>" +
                    "<td>" +
                    '<button class="btn btn-sm" style="cursor:pointer;border-radius:5px 0px 0px 5px;background-color:#cd874a;" onclick="addItem(' +
                    "'" + item.id + "'," +
                    "'" + item.txtCodigo + "'," +
                    "'-1'," +
                    "'" + item.producto + "'," +
                    "'" + item.codcategoria + "'," +
                    "'" + item.categorias + "'," +
                    "'" + item.precio + "', " +
                    "'" + item.precio2 + "', " +
                    "'" + item.descproducto + "', " +
                    "'" + item.ivaproducto + "', " +
                    "'" + item.existencia + "', " +
                    "'" + item.precioconiva + "', " +
                    "'" + item.tipo + "', " +
                    "'" + item.observacion + "', " +
                    "'-'" +
                    ')"' +
                    " type='button'><span class='fa fa-minus'></span></button>" +
                    "<input type='text' id='" + item.cantidad + "' class='bold' style='width:40px;height:25px;border:#f9d655;' value='" + item.cantidad + "'>" +
                    '<button class="btn btn-sm" style="cursor:pointer;border-radius:0px 5px 5px 0px;background-color:#cd874a;" onclick="addItem(' +
                    "'" + item.id + "'," +
                    "'" + item.txtCodigo + "'," +
                    "'+1'," +
                    "'" + item.producto + "'," +
                    "'" + item.codcategoria + "'," +
                    "'" + item.categorias + "'," +
                    "'" + item.precio + "', " +
                    "'" + item.precio2 + "', " +
                    "'" + item.descproducto + "', " +
                    "'" + item.ivaproducto + "', " +
                    "'" + item.existencia + "', " +
                    "'" + item.precioconiva + "', " +
                    "'" + item.tipo + "', " +
                    "'" + item.observacion + "', " +
                    "'+'" +
                    ')"' +
                    " type='button'><span class='fa fa-plus'></span></button></td>" +
                    "<td align='left'><h6><abbr title='" + item.categorias + "'><label>" + item.producto + "</label></abbr></h6></td>" +
                    "<td><h6><label>" + item.precio2 + "</label></h6></td>" +
                    "<td><h6><label>" + Operacion.toFixed(2) + "</label></h6></td>" +
                    "<td>" +
                    '<span style="cursor:pointer;color:#cd874a;" ' +
                    'onclick="AsignaObservacion(' +
                    "'" + item.txtCodigo + "'," +
                    "'" + item.tipo + "'," +
                    "'" + item.cantidad + "'," +
                    "'" + (item.observacion == "" || item.observacion == ", " ? "" : item.observacion.replace(/\s/g,"_")) + "'" +
                    ')"' +
                    ' data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalObservacion" data-backdrop="static" data-keyboard="false" class="mdi mdi-comment-text-outline font-24"></span>' +
                    '<span style="cursor:pointer;color:#cd874a;" ' +
                    'onclick="addItem(' +
                    "'" + item.id + "'," +
                    "'" + item.txtCodigo + "'," +
                    "'0'," +
                    "'" + item.producto + "'," +
                    "'" + item.codcategoria + "'," +
                    "'" + item.categorias + "'," +
                    "'" + item.precio + "', " +
                    "'" + item.precio2 + "', " +
                    "'" + item.descproducto + "', " +
                    "'" + item.ivaproducto + "', " +
                    "'" + item.existencia + "', " +
                    "'" + item.precioconiva + "', " +
                    "'" + item.tipo + "', " +
                    "'" + item.observacion + "', " +
                    "'='" +
                    ')"' +
                    ' class="mdi mdi-delete font-24"></span>' +"</td>" +
                    "</tr>" +
                    "<tr style='background:#f9d655;'>" +
                    "<td></td>" +
                    "<td colspan=4>" +
                    "<h6><abbr class='text-dark alert-link' title='Observación de Detalle'>" + (item.observacion == "" || item.observacion == ", " ? "" : item.observacion) + "</abbr></h6>" +
                    "</td>" +
                    "</tr>";

                    $(nuevaFila).appendTo("#carrito tbody");
                                
                        $("#lblsubtotal").text(BaseImpIva1.toFixed(2));
                        $("#lblsubtotal2").text(BaseImpIva2.toFixed(2));
                        $("#lbliva").text(TotalIvaGeneral.toFixed(2));
                        $("#lbldescontado").text(TotalDescuento.toFixed(2));
                        $("#lbldescuento").text(TotalDescuentoGeneral.toFixed(2));
                        $("#lblitems").text(OperacionItems.toFixed(2));
                        $("#lbltotal").text(TotalFactura.toFixed(2));

                        $("#txtsubtotal").val(BaseImpIva1.toFixed(2));
                        $("#txtsubtotal2").val(BaseImpIva2.toFixed(2));
                        $("#txtIva").val(TotalIvaGeneral.toFixed(2));
                        $("#txtdescontado").val(TotalDescuento.toFixed(2));
                        $("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));
                        $("#txtTotal").val(TotalFactura.toFixed(2));
                        $("#txtTotalCompra").val(TotalCompra.toFixed(2));

                        /*####### ACTIVAR BOTON DE PAGO #######*/
                        $("#buttonpago").attr('disabled', false);
                        $("#TextImporte").text(TotalFactura.toFixed(2));
                        $("#TextPagado").text(TotalFactura.toFixed(2));
                        $("#montopagado").val(TotalFactura.toFixed(2));
                                
                        }

                    });

                    $("#busquedaproducto").focus();
                    LimpiarTexto();
                },
                "json"
            );
            return false;
        }
    }
});

/* CANCELAR LOS ITEM AGREGADOS EN REGISTRO */
$(document).ready(function() {
    $("#limpiar").click(function() {
        var Carrito = new Object();
        Carrito.Id = "vaciar";
        Carrito.Codigo = "vaciar";
        Carrito.Producto = "vaciar";
        Carrito.Codcategoria = "vaciar";
        Carrito.Categorias = "vaciar";
        Carrito.Precio      = "0";
        Carrito.Precio2      = "0";
        Carrito.Descproducto      = "0";
        Carrito.Ivaproducto = "vaciar";
        Carrito.Existencia = "vaciar";
        Carrito.Precioconiva      = "0";
        Carrito.Tipo      = "vaciar";
        Carrito.Observacion      = "vaciar";
        Carrito.Cantidad = "0";
        var DatosJson = JSON.stringify(Carrito);
        $.post('carritoventa.php', {
                MiCarrito: DatosJson
            },
            function(data, textStatus) {
                $("#carrito tbody").html("");
                var nuevaFila =
                "<tr>"+"<td class='text-center' colspan=5><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
                $(nuevaFila).appendTo("#carrito tbody");
                LimpiarTexto();
            },
            "json"
        );
        return false;
    });
});


$(document).ready(function() {
    $('#limpiar').click(function() {
        $("#carrito tbody").html("");
        var nuevaFila =
        "<tr>"+"<td class='text-center' colspan=5><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
        $(nuevaFila).appendTo("#carrito tbody");
        $("#savedelivery")[0].reset();
        $("#codcliente").val(($("#codcliente").val() == 0) ? "0" : $("#codcliente").val());
        $("#busqueda").val(($("#busqueda").val() == "") ? "CONSUMIDOR FINAL" : $("#busqueda").val());
        $("#lblsubtotal").text("0.00");
        $("#lblsubtotal2").text("0.00");
        $("#lbliva").text("0.00");
        $("#lbldescontado").text("0.00");
        $("#lbldescuento").text("0.00");
        $("#lblitems").text("0.00");
        $("#lbltotal").text("0.00");

        $("#txtsubtotal").val("0.00");
        $("#txtsubtotal2").val("0.00");
        $("#txtIva").val("0.00");
        $("#txtdescontado").val("0.00");
        $("#txtDescuento").val("0.00");
        $("#txtTotal").val("0.00");
    });
});

//FUNCION PARA ACTUALIZAR CALCULO EN FACTURA DE COMPRAS CON DESCUENTO
$(document).ready(function(){
    $('#descuento').keyup(function(){
        
        var txtsubtotal = $('input#txtsubtotal').val();
        var txtsubtotal2 = $('input#txtsubtotal2').val();
        var txtIva = $('input#txtIva').val();
        var desc = $('input#descuento').val();
        descuento  = desc/100;
                        
        //REALIZO EL CALCULO CON EL DESCUENTO INDICADO
        Subtotal = parseFloat(txtsubtotal) + parseFloat(txtsubtotal2) + parseFloat(txtIva); 
        TotalDescuentoGeneral   = parseFloat(Subtotal.toFixed(2)) * parseFloat(descuento.toFixed(2));
        TotalFactura   = parseFloat(Subtotal.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));        
        
        $("#lbldescuento").text(TotalDescuentoGeneral.toFixed(2));
        $("#lbltotal").text(TotalFactura.toFixed(2));
        $("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));
        $("#txtTotal").val(TotalFactura.toFixed(2));

        $("#TextImporte").text(TotalFactura.toFixed(2));
        $("#TextPagado").text(TotalFactura.toFixed(2));
        $("#montopagado").val(TotalFactura.toFixed(2));
    });
});



//FUNCION PARA ACTUALIZAR CALCULO CON DESCUENTO
$(document).ready(function(){
    $('#descuento2').keyup(function(){
        
        var txtsubtotal = $('input#txtsubtotaliva').val();
        var txtsubtotal2 = $('input#txtsubtotaliva2').val();
        var txtIva = $('input#txtIva2').val();
        var desc = $('input#descuento2').val();
        descuento  = desc/100;
                        
        //REALIZO EL CALCULO CON EL DESCUENTO INDICADO
        Subtotal = parseFloat(txtsubtotal) + parseFloat(txtsubtotal2) + parseFloat(txtIva); 
        TotalDescuentoGeneral   = parseFloat(Subtotal.toFixed(2)) * parseFloat(descuento.toFixed(2));
        TotalFactura   = parseFloat(Subtotal.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));        
        
        $("#lbldescuento2").text(TotalDescuentoGeneral.toFixed(2));
        $("#lbltotal2").text(TotalFactura.toFixed(2));
        $("#txtDescuento2").val(TotalDescuentoGeneral.toFixed(2));
        $("#txtTotal2").val(TotalFactura.toFixed(2));

        $("#TextImporte").text(TotalFactura.toFixed(2));
        $("#TextPagado").text(TotalFactura.toFixed(2));
        $("#montopagado").val(TotalFactura.toFixed(2));
    });
});


//FUNCION PARA ACTUALIZAR CALCULO EN FACTURA DE COMPRAS CON IVA
$(document).ready(function(){
    $('#iva').keyup(function(){
        
        var txtsubtotal = $('input#txtsubtotal').val();
        var txtsubtotal2 = $('input#txtsubtotal2').val();
        var txtIva = $('input#txtIva').val();
        var iva = $('input#iva').val();
        var desc = $('input#descuento').val();
        ivg2  = iva/100;
        descuento  = desc/100;
                        
        //REALIZO EL CALCULO CON EL IVA INDICADO
        TotalIvaGeneral = parseFloat(txtsubtotal) * parseFloat(ivg2.toFixed(2));

        Subtotal = parseFloat(txtsubtotal) + parseFloat(txtsubtotal2) + parseFloat(TotalIvaGeneral); 
        TotalDescuentoGeneral   = parseFloat(Subtotal.toFixed(2)) * parseFloat(descuento.toFixed(2));
        TotalFactura   = parseFloat(Subtotal.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));        
        
        $("#lbliva").text(TotalIvaGeneral.toFixed(2));
        $("#txtIva").text(TotalIvaGeneral.toFixed(2));
            
        $("#lbldescuento").text(TotalDescuentoGeneral.toFixed(2));
        $("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));
            
        $("#lbltotal").text(TotalFactura.toFixed(2));
        $("#txtTotal").val(TotalFactura.toFixed(2));
    });
});


    $("#carrito tbody").on('keydown', 'input', function(e) {
        var element = $(this);
        var pvalue = element.val();
        /*var code = e.charCode || e.keyCode;
        var avalue = String.fromCharCode(code);*/
        var regx = /^[A-Za-z0-9 _.-]+$/;
        var action = element.siblings('button').first().attr('onclick');
        var params;
        //if (code !== 11 && /[^\d]/ig.test(avalue)) {
        if (!regx.test(e.charCode) || !regx.test(e.keyCode)){
            e.preventDefault();
            return;
        }

        if (element.attr('data-proc') == '1') {
            return true;
        }
        element.attr('data-proc', '1');
        params = action.match(/\'([^\']+)\'/g).map(function(v) {
            return v.replace(/\'/g, '');
        });
        setTimeout(function() {
            if (element.attr('data-proc') == '1') {
                var value = element.val() || 0;
                addItem(
                    params[0],
                    params[1],
                    value,
                    params[3],
                    params[4],
                    params[5],
                    params[6],
                    params[7],
                    params[8],
                    params[9],
                    params[10],
                    params[11],
                    params[12],
                    params[13],
                    '='
                );
                element.attr('data-proc', '0');
            }
        }, 300);
    });
});


// FUNCION PARA MOSTRAR PEDIDOS
function RecibeDelivery(codpedido,codventa){

$('#muestradetalledelivery').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = "BuscaPedidoDelivery=si&codpedido="+codpedido+"&codventa="+codventa;

$.ajax({
        type: "GET",
        url: "detalles_delivery.php",
        data: dataString,
        success: function(response) { 
            $("#loading").load("salas_mesas.php?CargaProductos=si");           
            $('#muestradetalledelivery').empty();
            $('#muestradetalledelivery').append(''+response+'').fadeIn("slow");
        }
    });
}


/////FUNCION PARA ELIMINAR DETALLE DE PEDIDOS
function EliminaPedidoDelivery(codpedido,pedido,codventa,codcliente,codproducto,cantventa,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle en Pedido?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codpedido="+codpedido+"&pedido="+pedido+"&codventa="+codventa+"&codcliente="+codcliente+"&codproducto="+codproducto+"&cantventa="+cantventa+"&tipo="+tipo,
                  success: function(data){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#muestradetalledelivery').load("detalles_delivery.php?BuscaPedidoDelivery=si&codpedido="+codpedido+"&codventa="+codventa); 
            $('#pedidos').load("detalles_delivery?CargaPedidosDelivery=si&codpedido="+codpedido+"&codventa="+codventa);
            }
        })
    });
}

/////FUNCION PARA CANCELAR PEDIDOS
function CancelarPedidoDelivery(codpedido,codventa,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Cancelar tods los Detalles de este Pedido?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Continuar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codpedido="+codpedido+"&codventa="+codventa+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Cancelado!", "El Pedido en Delivery fue Cancelado Exitosamente!", "success");
            $('#muestradetalledelivery').load("detalles_delivery.php?BuscaPedidoDelivery=si&codpedido=0&codventa=0");
            $('#pedidos').load("detalles_delivery?CargaPedidosDelivery=si&codpedido=0&codventa=0"); 
            $('#loading').load("salas_mesas?CargaProductos=si");

           }
         }
      })
  });
}

// FUNCION PARA COBRAR PEDIDO
function CerrarDelivery(codpedido,codventa,descuento,totaldescuento,totalpago,tipo){

$('#cierredelivery').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'CargaModalCierreDelivery=si&codpedido='+codpedido+"&codventa="+codventa+"&descuento="+descuento+"&totaldescuento="+totaldescuento+"&totalpago="+totalpago+"&tipo="+tipo;

$.ajax({
        type: "GET",
        url: "detalles_delivery.php",
        data: dataString,
        success: function(response) { 
            $('#cierredelivery').empty();
            $('#cierredelivery').append(''+response+'').fadeIn("slow");
        }
   });
}

//FUNCION PARA SELECCIONAR REPARTIDOR DE PEDIDO EXTERNO
function TipoPedido(tipopedido){

    var valor = $('input[name="tipopedido"]:checked').val(); 
    var montototal = $('input#txtTotal').val();
    var montodelivery = $('input#montodelivery').val();

    if (valor === "" || valor === true) {

    // deshabilitamos
    $("#repartidor").attr('disabled', true);
    $("#montodelivery").attr('disabled', true);
    $("#repartidor").val("");
    $("#montodelivery").val("0.00");

    } else if (valor === "INTERNO" || valor === true) {

    // habilitamos
    $("#repartidor").attr('disabled', true);
    $("#montodelivery").attr('disabled', true);
    $("#repartidor").val("");
    $("#montodelivery").val("0.00");

    } else if (valor === "EXTERNO" || valor === true) {

    // deshabilitamos
    $("#repartidor").attr('disabled', false);
    $("#montodelivery").attr('disabled', false);
    }
}

//FUNCION PARA CALCULAR DEVOLUCION DE MONTO
function DevolucionDelivery(){
      
    if ($('input#txtTotal').val()==0.00 || $('input#txtTotal').val()==0 || $('input#txtTotal').val()=="") {
              
        $("#montopagado").val("0.00");
        $("#montopagado2").val("0.00");
        swal("Oops", "POR FAVOR AGREGUE DETALLES PARA CONTINUAR CON LA VENTA DE PRODUCTOS!", "error");
        return false;
   
    } else {
      
    var montototal = $('input#txtTotal').val();
    var montodelivery = $('input#montodelivery').val();
    var montopagado = $('input#montopagado').val();
    var montopagado2 = $('input#montopagado2').val();
    var montodevuelto = $('input#montodevuelto').val(); 
    var montopropina = $('input#montopropina').val(); 
            
    //REALIZO EL CALCULO Y MUESTRO LA DEVOLUCION
    var sumtotal = parseFloat(montototal) + parseFloat(montodelivery) + parseFloat(montopropina);
    var Sumatoria = parseFloat(sumtotal.toFixed(2));

    var sumpagado = parseFloat(montopagado) + parseFloat(montopagado2);
    var subtotal= parseFloat(sumpagado) + parseFloat(montopropina);
    total = parseFloat(sumpagado) - parseFloat(sumtotal);
    var original = parseFloat(total.toFixed(2));

    $("#TextImporte").text((montopagado == "" || montopagado == "0" || montopagado == "0.00") ? Sumatoria.toFixed(2) : Sumatoria.toFixed(2));
    $("#txtImporte").val((montopagado == "" || montopagado == "0" || montopagado == "0.00") ? Sumatoria.toFixed(2) : Sumatoria.toFixed(2));
    $("#TextPagado").text((montopagado == "" || montopagado == "0" || montopagado == "0.00") ? sumtotal : sumpagado.toFixed(2));
    $("#TextCambio").text((montopagado == "" || montopagado == "0" || montopagado == "0.00") ? sumtotal : original.toFixed(2));
    $("#montodevuelto").val((montopagado == "" || montopagado == "0" || montopagado == "0.00") ? sumtotal : original.toFixed(2));
   }
}


// FUNCION PARA MOSTRAR CONDICIONES DE PAGO
function CargaCondicionesPagos(){
    
var tipopago = $('input:radio[name=tipopago]:checked').val();
var montototal = $('input#txtTotal').val();
var montodelivery = $('input#montodelivery').val(); 

var sumtotal = parseFloat(montototal) + parseFloat(montodelivery);
var Sumatoria = parseFloat(sumtotal.toFixed(2));

$("#TextImporte").text(Sumatoria.toFixed(2));
$("#TextPagado").text(tipopago == "CREDITO" ? "0.00" : montototal);
$("#TextCambio").text("0.00");

var dataString = 'BuscaCondicionesPagos=si&tipopago='+tipopago+"&txtTotal="+montototal;

    $.ajax({
        type: "GET",
            url: "detalles_delivery.php",
            data: dataString,
            success: function(response) {            
            $('#muestra_condiciones').empty();
            $('#muestra_condiciones').append(''+response+'').fadeIn("slow");                
        }
    });
}


//FUNCIONES PARA ACTIVAR-DESACTIVAR MONTO PAGO #2
$(document).ready(function(){
   $('#formapago2').on('change', function() {

    var two = $('select#formapago2').val();

        if (two != "" || two === true) {

        $("#montopagado2").attr('disabled', false);
        $("#montopagado2").focus();

        } else {

        $("#montopagado2").attr('disabled', true);

        } 
    });
});


//FUNCIONES PARA ACTIVAR-DESACTIVAR MONTO PROPINA
$(document).ready(function(){
   $('#formapropina').on('change', function() {

    var propina = $('select#formapropina').val();

        if (propina != "" || propina === true) {

        $("#montopropina").attr('disabled', false);
        $("#montopropina").focus();

        } else {

        $("#montopropina").attr('disabled', true);

        } 
    });
});


//FUNCION PARA MOSTRAR/OCULTAR FAVORITOS
function MuestraFavoritos(){
  var favorito = $('#favoritos');
    if(favorito.is(':visible')){
       favorito.hide(100);
       $('#favoritos').html("");

    } else {
       favorito.show(100);
       $('#favoritos').load("salas_mesas?Muestra_Favoritos=si");
    }
};


//FUNCION PARA MOSTRAR/OCULTAR INPUT OBSERVACION
function Refres(id){
  var ocultable = $('#ocultable'+id);
    if(ocultable.is(':visible')){
       ocultable.hide(300);
    } else {
       ocultable.show(300);
    }
};


//FUNCION PARA LIMPIAR INPUT
function LimpiarTexto() {
    $("#busquedaproducto").val("");
    $("#idproducto").val("");
    $("#codproducto").val("");
    $("#producto").val("");
    $("#codcategoria").val("");
    $("#categorias").val("");
    $("#preciocompra").val("");
    $("#precioventa").val("");
    $("#descproducto").val("");
    $("#ivaproducto").val("");
    $("#existencia").val("");
    $("#precioconiva").val("");
    $("#tipo").val("");
    //$("#observacion").val("");
    $("#cantidad").val("1");
}


function addItem(id, codigo, cantidad, producto, codcategoria, categorias, precio, precio2, descproducto, ivaproducto, existencia, precioconiva, tipo, observacion, opCantidad) {
    var Carrito = new Object();
    Carrito.Id = id;
    Carrito.Codigo = codigo;
    Carrito.Producto = producto;
    Carrito.Codcategoria = codcategoria;
    Carrito.Categorias = categorias;
    Carrito.Precio = precio;
    Carrito.Precio2 = precio2;
    Carrito.Descproducto = descproducto;
    Carrito.Ivaproducto = ivaproducto;
    Carrito.Existencia = existencia;
    Carrito.Precioconiva      = precioconiva;
    Carrito.Tipo      = tipo;
    Carrito.Observacion      = observacion;
    Carrito.Cantidad = cantidad;
    Carrito.opCantidad = opCantidad;
    var DatosJson = JSON.stringify(Carrito);
    $.post('carritoventa.php', {
            MiCarrito: DatosJson
        },
        function(data, textStatus) {
            $("#carrito tbody").html("");
            var TotalDescuento = 0;
            var SubtotalFact = 0;
            var BaseImpIva1 = 0;
            var contador = 0;
            var OperacionItems = 0;
            var iva = 0;
            var total = 0;
            var TotalCompra = 0;

            $.each(data, function(i, item) {
                var cantsincero = item.cantidad;
                cantsincero = parseFloat(cantsincero);
                if (cantsincero != 0) {
                    contador = contador + 1;

                //CALCULO DEL TOTAL DE ITEMS
                var Items= parseFloat(cantsincero);
                OperacionItems = parseFloat(OperacionItems) + parseFloat(Items);

                //CALCULO DEL TOTAL DE COMPRAS
                var OperacionCompra= parseFloat(item.precio) * parseFloat(item.cantidad);
                TotalCompra = parseFloat(TotalCompra) + parseFloat(OperacionCompra);

                //CALCULO DEL VALOR TOTAL
                var ValorTotal= parseFloat(item.precio2) * parseFloat(item.cantidad);

                //CALCULO DEL TOTAL DEL DESCUENTO %
                var Descuento = ValorTotal * item.descproducto / 100;
                TotalDescuento = parseFloat(TotalDescuento) + parseFloat(Descuento);

                //OBTENEMOS DESCUENTO INDIVIDUAL POR PRODUCTOS
                var descsiniva = item.precio2 * item.descproducto / 100;
                var descconiva = item.precioconiva * item.descproducto / 100;

                //CALCULO DE BASE IMPONIBLE IVA SIN PORCENTAJE
                var Operac= parseFloat(item.precio2) - parseFloat(descsiniva);
                var Operacion= parseFloat(Operac) * parseFloat(item.cantidad);
                var Subtotal = Operacion.toFixed(2);

                //CALCULO DE BASE IMPONIBLE IVA CON PORCENTAJE
                var Operac3 = parseFloat(item.precioconiva) - parseFloat(descconiva);
                var Operacion3 = parseFloat(Operac3) * parseFloat(item.cantidad);
                var Subbaseimponiva = Operacion3.toFixed(2);

                //BASE IMPONIBLE IVA CON PORCENTAJE
                BaseImpIva1 = parseFloat(BaseImpIva1) + parseFloat(Subbaseimponiva);
                
                //CALCULO GENERAL DE IVA CON BASE IVA * IVA %
                var ivg = $('input#iva').val();
                ivg2  = ivg/100;
                TotalIvaGeneral = parseFloat(BaseImpIva1) * parseFloat(ivg2.toFixed(2));
                
                //SUBTOTAL GENERAL DE FACTURA
                SubtotalFact = parseFloat(SubtotalFact) + parseFloat(Subtotal);
                //BASE IMPONIBLE IVA SIN PORCENTAJE
                BaseImpIva2 = parseFloat(SubtotalFact) - parseFloat(BaseImpIva1);
                
                //CALCULAMOS DESCUENTO POR PRODUCTO
                var desc = $('input#descuento').val();
                desc2  = desc/100;
                
                //CALCULO DEL TOTAL DE FACTURA
                Total = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2) + parseFloat(TotalIvaGeneral);
                TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
                TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));

                var nuevaFila =
                "<tr align='center' style='background:#f9d655;'>" +
                    "<td>" +
                    '<button class="btn btn-sm" style="cursor:pointer;border-radius:5px 0px 0px 5px;background-color:#cd874a;" onclick="addItem(' +
                    "'" + item.id + "'," +
                    "'" + item.txtCodigo + "'," +
                    "'-1'," +
                    "'" + item.producto + "'," +
                    "'" + item.codcategoria + "'," +
                    "'" + item.categorias + "'," +
                    "'" + item.precio + "', " +
                    "'" + item.precio2 + "', " +
                    "'" + item.descproducto + "', " +
                    "'" + item.ivaproducto + "', " +
                    "'" + item.existencia + "', " +
                    "'" + item.precioconiva + "', " +
                    "'" + item.tipo + "', " +
                    "'" + item.observacion + "', " +
                    "'-'" +
                    ')"' +
                    " type='button'><span class='fa fa-minus'></span></button>" +
                    "<input type='text' id='" + item.cantidad + "' class='bold' style='width:40px;height:25px;border:#f9d655;' value='" + item.cantidad + "'>" +
                    '<button class="btn btn-sm" style="cursor:pointer;border-radius:0px 5px 5px 0px;background-color:#cd874a;" onclick="addItem(' +
                    "'" + item.id + "'," +
                    "'" + item.txtCodigo + "'," +
                    "'+1'," +
                    "'" + item.producto + "'," +
                    "'" + item.codcategoria + "'," +
                    "'" + item.categorias + "'," +
                    "'" + item.precio + "', " +
                    "'" + item.precio2 + "', " +
                    "'" + item.descproducto + "', " +
                    "'" + item.ivaproducto + "', " +
                    "'" + item.existencia + "', " +
                    "'" + item.precioconiva + "', " +
                    "'" + item.tipo + "', " +
                    "'" + item.observacion + "', " +
                    "'+'" +
                    ')"' +
                    " type='button'><span class='fa fa-plus'></span></button></div></div></td>" +
                    "<td align='left'><h6><abbr title='" + item.categorias + "'><label>" + item.producto + "</label></abbr></h6></td>" +
                    "<td><h6><label>" + item.precio2 + "</label></h6></td>" +
                    "<td><h6><label>" + Operacion.toFixed(2) + "</label></h6></td>" +
                    "<td>" +
                    '<span style="cursor:pointer;color:#cd874a;" ' +
                    'onclick="AsignaObservacion(' +
                    "'" + item.txtCodigo + "'," +
                    "'" + item.tipo + "'," +
                    "'" + item.cantidad + "', " +
                    "'" + (item.observacion == "" || item.observacion == ", " ? "" : item.observacion.replace(/\s/g,"_")) + "'" +
                    ')"' +
                    ' data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalObservacion" data-backdrop="static" data-keyboard="false" class="mdi mdi-comment-text-outline font-24"></span>' +
                    '<span style="cursor:pointer;color:#cd874a;" ' +
                    'onclick="addItem(' +
                    "'" + item.id + "'," +
                    "'" + item.txtCodigo + "'," +
                    "'0'," +
                    "'" + item.producto + "'," +
                    "'" + item.codcategoria + "'," +
                    "'" + item.categorias + "'," +
                    "'" + item.precio + "', " +
                    "'" + item.precio2 + "', " +
                    "'" + item.descproducto + "', " +
                    "'" + item.ivaproducto + "', " +
                    "'" + item.existencia + "', " +
                    "'" + item.precioconiva + "', " +
                    "'" + item.tipo + "', " +
                    "'" + item.observacion + "', " +
                    "'='" +
                    ')"' +
                    ' class="mdi mdi-delete font-24"></span>' +"</td>" +
                    "</tr>" +
                    "<tr style='background:#f9d655;'>" +
                    "<td></td>" +
                    "<td colspan=4>" +
                    "<h6><abbr class='text-dark alert-link' title='Observación de Detalle'>" + (item.observacion == "" || item.observacion == ", " ? "" : item.observacion) + "</abbr></h6>" +
                    "</td>" +
                    "</tr>";

                $(nuevaFila).appendTo("#carrito tbody");
                                
                $("#lblsubtotal").text(BaseImpIva1.toFixed(2));
                $("#lblsubtotal2").text(BaseImpIva2.toFixed(2));
                $("#lbliva").text(TotalIvaGeneral.toFixed(2));
                $("#lbldescontado").text(TotalDescuento.toFixed(2));
                $("#lbldescuento").text(TotalDescuentoGeneral.toFixed(2));
                $("#lblitems").text(OperacionItems.toFixed(2));
                $("#lbltotal").text(TotalFactura.toFixed(2));

                $("#txtsubtotal").val(BaseImpIva1.toFixed(2));
                $("#txtsubtotal2").val(BaseImpIva2.toFixed(2));
                $("#txtIva").val(TotalIvaGeneral.toFixed(2));
                $("#txtdescontado").val(TotalDescuento.toFixed(2));
                $("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));
                $("#txtTotal").val(TotalFactura.toFixed(2));
                $("#txtTotalCompra").val(TotalCompra.toFixed(2));

                /*####### ACTIVAR BOTON DE PAGO #######*/
                $("#buttonpago").attr('disabled', false);
                $("#TextImporte").text(TotalFactura.toFixed(2));
                $("#TextPagado").text(TotalFactura.toFixed(2));
                $("#montopagado").val(TotalFactura.toFixed(2));

            }
        });
        if (contador == 0) {

            $("#carrito tbody").html("");

            var nuevaFila =
            "<tr>"+"<td class='text-center' colspan=5><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
            $(nuevaFila).appendTo("#carrito tbody");

            //alert("ELIMINAMOS TODOS LOS SUBTOTAL Y TOTALES");
            //$("#savedelivery")[0].reset();
            $("#lblsubtotal").text("0.00");
            $("#lblsubtotal2").text("0.00");
            $("#lbliva").text("0.00");
            $("#lbldescontado").text("0.00");
            $("#lbldescuento").text("0.00");
            $("#lblitems").text("0.00");
            $("#lbltotal").text("0.00");
            
            $("#txtsubtotal").val("0.00");
            $("#txtsubtotal2").val("0.00");
            $("#txtIva").val("0.00");
            $("#txtdescontado").val("0.00");
            $("#txtDescuento").val("0.00");
            $("#txtTotal").val("0.00");
            $("#txtTotalCompra").val("0.00");

            /*####### ACTIVAR BOTON DE PAGO #######*/
            $("#buttonpago").attr('disabled', true);
            $("#TextImporte").text("0.00");
            $("#TextPagado").text("0.00");
            $("#montopagado").text("0.00");

            }
            LimpiarTexto();
        },
        "json"
    );
    return false;
}