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
  $("#agregaobservaciones #agrega_detalle_observacion").load("funciones?BuscaDetallesProductoCotizacion=si&d_codigo="+codigo+"&d_tipo="+tipo+"&d_cantidad="+cantidad+"&d_observacion="+observacion);
}


function pulsar(e, valor) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 13) comprueba(valor)
}

$(document).ready(function() {

    $('#AgregaCotizacion').click(function() {
        AgregaCotizaciones();
    });

    $('.agregacotizacion').keypress(function(e) {
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == '13') {
          AgregaCotizaciones();
          e.preventDefault();
          return false;
      }
  });

    function AgregaCotizaciones () {

            var code = $('input#codproducto').val();
            var prod = $('input#producto').val();
            var cantp = $('input#cantidad').val();
            var exist = $('input#existencia').val();
            var prec = $('input#preciocompra').val();
            var prec2 = $('input#precioventa').val();
            var descuen = $('input#descproducto').val();
            var ivgprod = $('input#ivaproducto').val();
            var er_num = /^([0-9])*[.]?[0-9]*$/;
            cantp = parseInt(cantp);
            exist = parseInt(exist);
            cantp = cantp;

            if (code == "") {
                $("#search_producto").focus();
                $("#search_producto").css('border-color', '#ff7676');
                swal("Oops", "POR FAVOR REALICE LA BÚSQUEDA DEL PRODUCTO CORRECTAMENTE!", "error");
                return false;
                
            } else if(prec2=="" || prec2=="0" || prec2=="0.00"){
                $("#precioventa").focus();
                $('#precioventa').css('border-color','#ff7676');
                $("#precioventa").val("");
                swal("Oops", "POR FAVOR SELECCIONE PRECIO DE VENTA PARA PRODUCTO!", "error");  
                return false;
                
            } else if(!er_num.test($('#precioventa').val())){
                $("#precioventa").focus();
                $('#precioventa').css('border-color','#ff7676');
                $("#precioventa").val("");
                swal("Oops", "POR FAVOR INGRESE SOLO NUMEROS POSITIVOS EN PRECIO VENTA!", "error");  
                return false;

            } else if ($('#cantidad').val() == "" || $('#cantidad').val() == "0.00") {
                $("#cantidad").focus();
                $("#cantidad").css('border-color', '#ff7676');
                swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA EN COTIZACIONES!", "error");
                return false;

            } else if (isNaN($('#cantidad').val())) {
                $("#cantidad").focus();
                $("#cantidad").css('border-color', '#ff7676');
                swal("Oops", "POR FAVOR INGRESE SOLO DIGITOS EN CANTIDAD DE COTIZACIONES!", "error");
                return false;
                
           } else if(cantp > exist){
                $("#cantidad").focus();
                $('#cantidad').css('border-color','#ff7676');
                $("#existencia").focus();
                $('#existencia').css('border-color','#ff7676');
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
                Carrito.Precioconiva = ($('input#ivaproducto').val() == "SI" ? $('input#precioventa').val() : "0.00");
                Carrito.Tipo      = $('input:radio[name=tipo]:checked').val();
                Carrito.Observacion = $('input#observacion').val();
                Carrito.Cantidad = $('input#cantidad').val();
                Carrito.opCantidad = '+=';
                var DatosJson = JSON.stringify(Carrito);
                $.post('carritocotizacion.php', {
                        MiCarrito: DatosJson
                },
                function(data, textStatus) {
                    $("#carrito tbody").html("");
                    var TotalDescuento = 0;
                    var SubtotalFact = 0;
                    var BaseImpIva1 = 0;
                    var Descontado = 0;
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
                "<tr align='center'>" +
                    "<td>" +
                    '<button class="btn btn-xs" style="cursor:pointer;border-radius:5px 0px 0px 5px;background-color:#cd874a;" onclick="addItem(' +
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
                    "<input type='text' id='" + item.cantidad + "' class='bold' style='width:40px;height:34px;border:#f9d655;' value='" + item.cantidad + "'>" +
                    '<button class="btn btn-xs" style="cursor:pointer;border-radius:0px 5px 5px 0px;background-color:#cd874a;" onclick="addItem(' +
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
                    "<td><h6><label>" + item.txtCodigo + "</label></h6></td>" +
                    "<td align='left'><h6><abbr title='" + item.categorias + "'><label>" + item.producto + "</label></abbr></h6></td>" +
                    "<td><h6><label>" + item.precio2 + "</label></h6></td>" +
                    "<td><h6><label>" + ValorTotal.toFixed(2) + "</label></h6></td>" +
                    "<td><h6><label>" + Descuento.toFixed(2) + "<sup>" + item.descproducto + "%</sup></label></h6></td>" +
                    "<td><h6><label>" + item.ivaproducto + "</label></h6></td>" +
                    "<td><h6><label>" + Operacion.toFixed(2) + "</label></h6></td>" +
                    "<td>" +
                    '<button class="btn btn-danger btn-sm btn-rounded" style="cursor:pointer;border-radius:5px 5px 5px 5px;color:#fff;" ' +
                    'onclick="AsignaObservacion(' +
                    "'" + item.txtCodigo + "'," +
                    "'" + item.tipo + "'," +
                    "'" + item.cantidad + "', " +
                    "'" + (item.observacion == "" || item.observacion == ", " ? "" : item.observacion.replace(/\s/g,"_")) + "'" +
                    ')"' +
                    ' data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalObservacion" data-backdrop="static" data-keyboard="false" type="button"><span class="fa fa-comment"></span></button> ' +
                    ' <button class="btn btn-dark btn-sm btn-rounded" style="cursor:pointer;border-radius:5px 5px 5px 5px;color:#fff;" ' +
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
                    ' type="button"><span class="fa fa-trash-o"></span></button>' +
                    "</td>" +
                    "</tr>" +
                    "<tr>" +
                    "<td></td>" +
                    "<td></td>" +
                    "<td colspan=7>" +
                    "<h6><abbr class='text-danger alert-link' title='Observación de Detalle'>" + (item.observacion == "" || item.observacion == ", " ? "" : item.observacion) + "</abbr></h6>" +
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

                    $("#search_producto").focus();
                    LimpiarTexto();
                },
                "json"
            );
            return false;
        }
    }

/* CANCELAR LOS ITEM AGREGADOS EN REGISTRO */
$("#vaciar").click(function() {
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
    $.post('carritocotizacion.php', {
            MiCarrito: DatosJson
        },
        function(data, textStatus) {
            $("#carrito tbody").html("");
            var nuevaFila =
            "<tr>"+"<td class='text-center' colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
            $(nuevaFila).appendTo("#carrito tbody");
            LimpiarTexto();
        },
        "json"
    );
    return false;
});


$(document).ready(function() {
    $('#vaciar').click(function() {
        $("#carrito tbody").html("");
        var nuevaFila =
        "<tr>"+"<td class='text-center' colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
        $(nuevaFila).appendTo("#carrito tbody");
        $("#savecotizaciones")[0].reset();
        $("#codcliente").val("0.00");
        $("#lblsubtotal").text("0.00");
        $("#lblsubtotal2").text("0.00");
        $("#lbliva").text("0.00");
        $("#lbldescontado").text("0.00");
        $("#lbldescuento").text("0.00");
        $("#lbltotal").text("0.00");

        $("#txtsubtotal").val("0.00");
        $("#txtsubtotal2").val("0.00");
        $("#txtIva").val("0.00");
        $("#txtdescontado").val("0.00");
        $("#txtDescuento").val("0.00");
        $("#txtTotal").val("0.00");
    });
});


/* CANCELAR LOS ITEM AGREGADOS EN AGREGAR DETALLES */
$("#vaciar2").click(function() {
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
        Carrito.Cantidad = "0.00";
        var DatosJson = JSON.stringify(Carrito);
        $.post('carritocotizacion.php', {
                MiCarrito: DatosJson
            },
            function(data, textStatus) {
                $("#carrito tbody").html("");
                var nuevaFila =
         "<tr>"+"<td class='text-center' colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
                $(nuevaFila).appendTo("#carrito tbody");
                LimpiarTexto();
            },
            "json"
        );
        return false;
    });

$(document).ready(function() {
    $('#vaciar2').click(function() {
        $("#carrito tbody").html("");
        var nuevaFila =
        "<tr>"+"<td class='text-center' colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
        $(nuevaFila).appendTo("#carrito tbody");
        $("#agregacotizaciones")[0].reset();
        $("#codcliente").val("0.00");
        $("#lblsubtotal").text("0.00");
        $("#lblsubtotal2").text("0.00");
        $("#lbliva").text("0.00");
        $("#lbldescontado").text("0.00");
        $("#lbldescuento").text("0.00");
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
$(document).ready(function (){
      $('#descuento').keyup(function (){
    
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
     });
});


//FUNCION PARA ACTUALIZAR CALCULO EN FACTURA DE COMPRAS CON IVA
$(document).ready(function (){
      $('#iva').keyup(function (){
    
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


function LimpiarTexto() {
    $("#search_producto").val("");
    $("#idproducto").val("");
    $("#codproducto").val("");
    $("#producto").val("");
    $("#codcategoria").val("");
    $("#categorias").val("");
    $("#preciocompra").val("");
    $('#precioventa').val("");
    $("#descproducto").val("0.00");
    $("#ivaproducto").val("");
    $("#existencia").val("");
    $("#precioconiva").val("");
    $("#tipo").val("");
    $("#observacion").val("");
    $("#cantidad").val("");
}


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
    $.post('carritocotizacion.php', {
            MiCarrito: DatosJson
        },
        function(data, textStatus) {
            $("#carrito tbody").html("");
            var TotalDescuento = 0;
            var SubtotalFact = 0;
            var BaseImpIva1 = 0;
            var Descontado = 0;
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
                "<tr align='center'>" +
                    "<td>" +
                    '<button class="btn btn-xs" style="cursor:pointer;border-radius:5px 0px 0px 5px;background-color:#cd874a;" onclick="addItem(' +
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
                    "<input type='text' id='" + item.cantidad + "' class='bold' style='width:40px;height:34px;border:#f9d655;' value='" + item.cantidad + "'>" +
                    '<button class="btn btn-xs" style="cursor:pointer;border-radius:0px 5px 5px 0px;background-color:#cd874a;" onclick="addItem(' +
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
                    "<td><h6><label>" + item.txtCodigo + "</label></h6></td>" +
                    "<td align='left'><h6><abbr title='" + item.categorias + "'><label>" + item.producto + "</label></abbr></h6></td>" +
                    "<td><h6><label>" + item.precio2 + "</label></h6></td>" +
                    "<td><h6><label>" + ValorTotal.toFixed(2) + "</label></h6></td>" +
                    "<td><h6><label>" + Descuento.toFixed(2) + "<sup>" + item.descproducto + "%</sup></label></h6></td>" +
                    "<td><h6><label>" + item.ivaproducto + "</label></h6></td>" +
                    "<td><h6><label>" + Operacion.toFixed(2) + "</label></h6></td>" +
                    "<td>" +
                    '<button class="btn btn-danger btn-sm btn-rounded" style="cursor:pointer;border-radius:5px 5px 5px 5px;color:#fff;" ' +
                    'onclick="AsignaObservacion(' +
                    "'" + item.txtCodigo + "'," +
                    "'" + item.tipo + "'," +
                    "'" + item.cantidad + "', " +
                    "'" + (item.observacion == "" || item.observacion == ", " ? "" : item.observacion.replace(/\s/g,"_")) + "'" +
                    ')"' +
                    ' data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalObservacion" data-backdrop="static" data-keyboard="false" type="button"><span class="fa fa-comment"></span></button> ' +
                    ' <button class="btn btn-dark btn-sm btn-rounded" style="cursor:pointer;border-radius:5px 5px 5px 5px;color:#fff;" ' +
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
                    ' type="button"><span class="fa fa-trash-o"></span></button>' +
                    "</td>" +
                    "</tr>" +
                    "<tr>" +
                    "<td></td>" +
                    "<td></td>" +
                    "<td colspan=7>" +
                    "<h6><abbr class='text-danger alert-link' title='Observación de Detalle'>" + (item.observacion == "" || item.observacion == ", " ? "" : item.observacion) + "</abbr></h6>" +
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

            }
        });
        if (contador == 0) {

            $("#carrito tbody").html("");

            var nuevaFila =
            "<tr>"+"<td class='text-center' colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
            $(nuevaFila).appendTo("#carrito tbody");

            //alert("ELIMINAMOS TODOS LOS SUBTOTAL Y TOTALES");
            $("#savecotizaciones")[0].reset();
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

            }
            LimpiarTexto();
        },
        "json"
    );
    return false;
}