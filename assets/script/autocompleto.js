// FUNCION AUTOCOMPLETE 
$(function() {  
    var animales = ["Ardilla roja", "Gato", "Gorila occidental",  
      "Leon", "Oso pardo", "Perro", "Tigre de Bengala"];  
      
    $("#prueba").autocomplete({  
      source: animales  
    });  
});

$(function() {
       $("#categorias").autocomplete({
       source: "class/busqueda_autocompleto.php?Busqueda_Categorias=si",
       minLength: 1,
       select: function(event, ui) { 
       $('#codcategoria').val(ui.item.codcategoria);
       }  
    });
});


$(function() {
       $("#busqueda").autocomplete({
       source: "class/busqueda_autocompleto.php?Busqueda_Clientes=si",
       minLength: 1,
       select: function(event, ui) { 
      $('#codcliente').val(ui.item.codcliente);
      $('#creditoinicial').val(ui.item.limitecredito);
      $('#montocredito').val(ui.item.creditodisponible);
      $('#creditodisponible').val(ui.item.creditodisponible);
      $('#TextCliente').text((ui.item.tipocliente == "JURIDICO") ? ui.item.razoncliente : ui.item.nomcliente);
      $('#TextCredito').text(ui.item.creditodisponible);
       }  
    });
});

// FUNCION AUTOCOMPLETE PARA COMPRAS
$(function() {

    $("#busquedatipo").keyup(function() {

        var tipo = $('input:radio[name=tipoentrada]:checked').val(); 

        if (tipo == "") {

            $("#tipoentrada").focus();
            $('#tipoentrada').css('border-color', '#2cabe3');
            $("#busquedatipo").val("");
            swal("Oops", "POR FAVOR SELECCIONE EL TIPO DE COMPRA!", "error");
            return false;

        } else if (tipo == "PRODUCTO") {

            $("#busquedatipo").autocomplete({
            source: "class/busqueda_autocompleto.php?Busqueda_Productos_Ventas=si",
            minLength: 1,
            select: function(event, ui) {
                $('#idproducto').val(ui.item.idproducto);
                $('#codproducto').val(ui.item.codproducto);
                $('#producto').val(ui.item.producto);
                $('#codcategoria').val(ui.item.codcategoria);
                $('#categorias').val(ui.item.nomcategoria);
                $('#preciocompra').val(ui.item.preciocompra);
                $('#precioventa').val(ui.item.precioventa);
                $('#precioconiva').val((ui.item.ivaproducto == "SI") ? ui.item.preciocompra : "0.00");
                $('#existencia').val(ui.item.existencia);
                $('#ivaproducto').val(ui.item.ivaproducto);
                $('#descproducto').val(ui.item.descproducto);
                $("#cantidad").focus();
            }
          });

          return false;

        } else if (tipo == "INGREDIENTE") {

            $("#busquedatipo").autocomplete({
            source: "class/busqueda_autocompleto.php?Busqueda_Ingredientes=si",
            minLength: 1,
            select: function(event, ui) {
                $('#idproducto').val(ui.item.idingrediente);
                $('#codproducto').val(ui.item.codingrediente);
                $('#producto').val(ui.item.nomingrediente);
                $('#codcategoria').val(ui.item.codmedida);
                $('#categorias').val(ui.item.nommedida);
                $('#preciocompra').val(ui.item.preciocompra);
                $('#precioventa').val(ui.item.precioventa);
                $('#precioconiva').val((ui.item.ivaingrediente == "SI") ? ui.item.preciocompra : "0.00");
                $('#existencia').val(ui.item.cantingrediente);
                $('#ivaproducto').val(ui.item.ivaingrediente);
                $('#descproducto').val(ui.item.descingrediente);
                $("#cantidad").focus();
            }
          });

        }
    });
}); 

// FUNCION AUTOCOMPLETE PARA COTIZACIONES
$(function() {

    $("#search_producto").keyup(function() {

        var tipo = $('input:radio[name=tipo]:checked').val(); 

        if (tipo == "") {

            $("#tipo").focus();
            $('#tipo').css('border-color', '#2cabe3');
            $("#search_producto").val("");
            swal("Oops", "POR FAVOR SELECCIONE EL TIPO DE BUSQUEDA!", "error");
            return false;

        } else if (tipo == 1) {

            $("#search_producto").autocomplete({
            source: "class/busqueda_autocompleto.php?Busqueda_Productos_Ventas=si",
            minLength: 1,
            select: function(event, ui) {
                $('#idproducto').val(ui.item.idproducto);
                $('#codproducto').val(ui.item.codproducto);
                $('#producto').val(ui.item.producto);
                $('#codcategoria').val(ui.item.codcategoria);
                $('#categorias').val(ui.item.nomcategoria);
                $('#preciocompra').val(ui.item.preciocompra);
                $('#precioventa').val(ui.item.precioventa);
                $('#precioconiva').val((ui.item.ivaproducto == "SI") ? ui.item.precioventa : "0.00");
                $('#existencia').val(ui.item.existencia);
                $('#ivaproducto').val(ui.item.ivaproducto);
                $('#descproducto').val(ui.item.descproducto);
                $("#cantidad").focus();
            }
          });

          return false;

        } else if (tipo == 2) {

            $("#search_producto").autocomplete({
            source: "class/busqueda_autocompleto.php?Busqueda_Combos=si",
            minLength: 1,
            select: function(event, ui) {
                $('#idproducto').val(ui.item.idcombo);
                $('#codproducto').val(ui.item.codcombo);
                $('#producto').val(ui.item.nomcombo);
                $('#codcategoria').val("**********");
                $('#categorias').val("**********");
                $('#preciocompra').val(ui.item.preciocompra);
                $('#precioventa').val(ui.item.precioventa);
                $('#precioconiva').val((ui.item.ivacombo == "SI") ? ui.item.precioventa : "0.00");
                $('#existencia').val(ui.item.existencia);
                $('#ivaproducto').val(ui.item.ivacombo);
                $('#descproducto').val(ui.item.desccombo);
                $("#cantidad").focus();
            }
          });

        }
    });
}); 

$(function() {
    $("#busquedakardexingrediente").autocomplete({
        source: "class/busqueda_autocompleto.php?Busqueda_Kardex_Ingredientes=si",
        minLength: 1,
        select: function(event, ui) {
            $('#codingrediente').val(ui.item.codingrediente);
        }
    });
});

$(function() {
    $("#busquedakardexproducto").autocomplete({
        source: "class/busqueda_autocompleto.php?Busqueda_Kardex_Producto=si",
        minLength: 1,
        select: function(event, ui) {
            $('#codproducto').val(ui.item.codproducto);
        }
    });
});

$(function() {
    $("#busquedakardexcombo").autocomplete({
        source: "class/busqueda_autocompleto.php?Busqueda_Kardex_Combo=si",
        minLength: 1,
        select: function(event, ui) {
            $('#codcombo').val(ui.item.codcombo);
        }
    });
});

$(function() {
    $("#busquedaingrediente").autocomplete({
        source: "class/busqueda_autocompleto.php?Busqueda_Ingredientes=si",
        minLength: 1,
        select: function(event, ui) {
            $('#idingrediente').val(ui.item.idingrediente);
            $('#codingrediente').val(ui.item.codingrediente);
            $('#nomingrediente').val(ui.item.nomingrediente);
            $('#codmedida').val(ui.item.codmedida);
            $('#medida').val(ui.item.nommedida);
            $('#preciocompraing').val(ui.item.preciocompra);
            $('#precioventaing').val(ui.item.precioventa);
            $('#precioconiva').val((ui.item.ivaingrediente == "SI") ? ui.item.precioventa : "0.00");
            $('#cantingrediente').val(ui.item.cantingrediente);
            $('#ivaingrediente').val(ui.item.ivaingrediente);
            $('#descingrediente').val(ui.item.descingrediente);
            $('#fechaexpiracion').val((ui.item.fechaexpiracion == "0000-00-00") ? "" : ui.item.fechaexpiracion);
            $("#cantidad").focus();
        }
    });
});

$(function() {
    $("#busquedaproductoc").autocomplete({
        source: "class/busqueda_autocompleto.php?Busqueda_Productos_Compras=si",
        minLength: 1,
        select: function(event, ui) {
            $('#idproducto').val(ui.item.idproducto);
            $('#codproducto').val(ui.item.codproducto);
            $('#producto').val(ui.item.producto);
            $('#codcategoria').val(ui.item.codcategoria);
            $('#categoria').val(ui.item.nomcategoria);
            $('#preciocompra').val(ui.item.preciocompra);
            $('#precioventa').val(ui.item.precioventa);
            $('#precioconiva').val((ui.item.ivaproducto == "SI") ? ui.item.preciocompra : "0.00");
            $('#existencia').val(ui.item.existencia);
            $('#ivaproducto').val(ui.item.ivaproducto);
            $('#descproducto').val(ui.item.descproducto);
            $("#cantidad").focus();
        }
    });
});

$(function() {
    $("#busquedaproductov").autocomplete({
        source: "class/busqueda_autocompleto.php?Busqueda_Productos_Ventas=si",
        minLength: 1,
        select: function(event, ui) {
            $('#idproducto').val(ui.item.idproducto);
            $('#codproducto').val(ui.item.codproducto);
            $('#producto').val(ui.item.producto);
            $('#codcategoria').val(ui.item.codcategoria);
            $('#categorias').val(ui.item.nomcategoria);
            $('#preciocompra').val(ui.item.preciocompra);
            $('#precioventa').val(ui.item.precioventa);
            $('#precioconiva').val((ui.item.ivaproducto == "SI") ? ui.item.precioventa : "0.00");
            $('#existencia').val(ui.item.existencia);
            $('#ivaproducto').val(ui.item.ivaproducto);
            $('#descproducto').val(ui.item.descproducto);
            $('#fechaelaboracion').val((ui.item.fechaelaboracion == "0000-00-00") ? "" : ui.item.fechaelaboracion);
            $('#fechaexpiracion').val((ui.item.fechaexpiracion == "0000-00-00") ? "" : ui.item.fechaexpiracion);
            $('#tipo').val("1");
            $("#cantidad").focus();
            setTimeout(function() {
                var e = jQuery.Event("keypress");
                e.which = 13;
                e.keyCode = 13;
                $("#busquedaproductov").trigger(e);
            }, 100);
        }
    });
});

$(function() {
    $("#search_producto_combos").autocomplete({
        source: "class/busqueda_autocompleto.php?Busqueda_Productos_Ventas=si",
        minLength: 1,
        select: function(event, ui) {
            $('#idproducto').val(ui.item.idproducto);
            $('#codproducto').val(ui.item.codproducto);
            $('#producto').val(ui.item.producto);
            $('#codcategoria').val(ui.item.codcategoria);
            $('#categoria').val(ui.item.nomcategoria);
            $('#preciocompradet').val(ui.item.preciocompra);
            $('#precioventadet').val(ui.item.precioventa);
            $('#precioconiva').val((ui.item.ivaproducto == "SI") ? ui.item.precioventa : "0.00");
            //$('#existencia').val(ui.item.existencia);
            $('#ivaproducto').val(ui.item.ivaproducto);
            $('#descproducto').val(ui.item.descproducto);
            $('#tipo').val("1");
            $("#cantidad").focus();
        }
    });
});

function autocompletar(contador) {
    contador = contador.replace("agregaingrediente[]", "");
    $("#agregaingrediente" + contador).autocomplete({
        source: "class/busqueda_autocompleto.php?Busqueda_Ingredientes=si",
        minLength: 1,
        select: function(event, ui) {
            $('#codingrediente' + contador).val(ui.item.codingrediente);
            $('#medida' + contador).val(ui.item.nommedida);
        }
    });
}


$(function() {
      $("#numfactura").autocomplete({
      source: "class/busqueda_autocompleto.php?Busqueda_Facturas=si",
      minLength: 1,
      select: function(event, ui) { 
      $('#numeroventa').val(ui.item.codventa);
      }  
    });
});