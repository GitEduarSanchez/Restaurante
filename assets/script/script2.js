//SELECCIONAR/DESELECCIONAR TODOS LOS CHECKBOX
$("#checkTodos").change(function () {
      $("input:checkbox").prop('checked', $(this).prop("checked"));
      //$("input[type='checkbox']:checked:enabled").prop('checked', $(this).prop("checked"));
  });

// FUNCION PARA LIMPIAR CHECKBOX ACTIVOS
function LimpiarCheckbox(){
$("input[type='checkbox']:checked:enabled").attr('checked',false); 
}

//BUSQUEDA EN CONSULTAS
$(document).ready(function () {
   (function($) {
       $('#FiltrarContenido').keyup(function () {
            var ValorBusqueda = new RegExp($(this).val(), 'i');
            $('.BusquedaRapida tr').hide();
             $('.BusquedaRapida tr').filter(function () {
                return ValorBusqueda.test($(this).text());
              }).show();
                })
      }(jQuery));
});






/////////////////////////////////// FUNCIONES DE USUARIOS //////////////////////////////////////

// FUNCION PARA MOSTRAR USUARIOS EN VENTANA MODAL
function VerUsuario(codigo){

$('#muestrausuariomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaUsuarioModal=si&codigo='+codigo;

$.ajax({
            type: "GET",
                  url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestrausuariomodal').empty();
                $('#muestrausuariomodal').append(''+response+'').fadeIn("slow");
                
            }
      });
}

// FUNCION PARA ACTUALIZAR USUARIOS
function UpdateUsuario(codigo,dni,nombres,sexo,direccion,telefono,email,usuario,nivel,status,comision,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#saveuser #codigo").val(codigo);
  $("#saveuser #dni").val(dni);
  $("#saveuser #nombres").val(nombres);
  $("#saveuser #sexo").val(sexo);
  $("#saveuser #direccion").val(direccion);
  $("#saveuser #telefono").val(telefono);
  $("#saveuser #email").val(email);
  $("#saveuser #usuario").val(usuario);
  $("#saveuser #nivel").val(nivel);
  $("#saveuser #status").val(status);
  $("#saveuser #comision").val(comision);
  $("#saveuser #proceso").val(proceso);
}


/////FUNCION PARA ELIMINAR USUARIOS 
function EliminarUsuario(codigo,dni,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Usuario?", 
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
                  data: "codigo="+codigo+"&dni="+dni+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $("#usuarios").load("consultas.php?CargaUsuarios=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Usuario no puede ser Eliminado, tiene registros relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Usuarios, no eres el Administrador del Sistema!", "error"); 

                }

            }
        })
    });
}

// FUNCION PARA BUSCAR LOGS DE ACCESO
$(document).ready(function(){
//function BuscarPacientes() {  
    var consulta;
    //hacemos focus al campo de búsqueda
    $("#blogs").focus();
    //comprobamos si se pulsa una tecla
    $("#blogs").keyup(function(e){
      //obtenemos el texto introducido en el campo de búsqueda
      consulta = $("#blogs").val();

      if (consulta.trim() === '') {  

      $("#logs").html("<center><div class='alert alert-danger'><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BUSQUEDA CORRECTAMENTE</div></center>");
      return false;

      } else {
                                                                           
        //hace la búsqueda
        $.ajax({
          type: "POST",
          url: "search.php?CargaLogs=si",
          data: "b="+consulta,
          dataType: "html",
          beforeSend: function(){
              //imagen de carga
              $("#logs").html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>');
          },
          error: function(){
              swal("Oops", "Ha ocurrido un error en la petición Ajax, verifique por favor!", "error"); 
          },
          success: function(data){                                                    
            $("#logs").empty();
            $("#logs").append(data);
          }
      });
     }
   });                                                               
});












/////////////////////////////////// FUNCIONES DE PROVINCIAS //////////////////////////////////////

// FUNCION PARA ACTUALIZAR PROVINCIAS
function UpdateProvincia(id_provincia,provincia,proceso) 
{
  // aqui asigno cada valor a los campos correspondientes
  $("#saveprovincia #id_provincia").val(id_provincia);
  $("#saveprovincia #provincia").val(provincia);
  $("#saveprovincia #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR PROVINCIAS 
function EliminarProvincia(id_provincia,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Provincia?", 
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
                  data: "id_provincia="+id_provincia+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#provincias').load("consultas?CargaProvincias=si");
                  
          } else if(data==2){ 

             swal("Oops", "Esta Provincia no puede ser Eliminada, tiene Departamentos relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Provincias, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}











/////////////////////////////////// FUNCIONES DE DEPARTAMENTOS //////////////////////////////////////

// FUNCION PARA ACTUALIZAR DEPARTAMENTOS
function UpdateDepartamento(id_departamento,departamento,id_provincia,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savedepartamento #id_departamento").val(id_departamento);
  $("#savedepartamento #departamento").val(departamento);
  $("#savedepartamento #id_provincia").val(id_provincia);
  $("#savedepartamento #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR DEPARTAMENTOS 
function EliminarDepartamento(id_departamento,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Departamento de Provincia?", 
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
                  data: "id_departamento="+id_departamento+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#departamentos').load("consultas?CargaDepartamentos=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Departamento no puede ser Eliminado, tiene registros relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Departamento, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}

////FUNCION PARA MOSTRAR PROVINCIAS POR DEPARTAMENTOS
function CargaDepartamentos(id_provincia){

$('#id_departamento').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaDepartamentos=si&id_provincia='+id_provincia;

$.ajax({
            type: "GET",
                  url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#id_departamento').empty();
                $('#id_departamento').append(''+response+'').fadeIn("slow");
                
           }
      });
}




////FUNCION PARA MOSTRAR PROVINCIAS POR DEPARTAMENTOS #2
function CargaDepartamentos2(id_provincia2){

$('#id_departamento2').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaDepartamentos2=si&id_provincia2='+id_provincia2;

$.ajax({
            type: "GET",
                  url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#id_departamento2').empty();
                $('#id_departamento2').append(''+response+'').fadeIn("slow");
                
           }
      });
}

////FUNCION PARA MOSTRAR LOCALIDAD POR CIUDAD
function SelectDepartamento(id_provincia,id_departamento){

  $("#id_departamento").load("funciones.php?SeleccionaDepartamento=si&id_provincia="+id_provincia+"&id_departamento="+id_departamento);

}











/////////////////////////////////// FUNCIONES DE TIPOS DE DOCUMENTOS  //////////////////////////////////////

// FUNCION PARA ACTUALIZAR TIPOS DE DOCUMENTOS
function UpdateDocumento(coddocumento,documento,descripcion,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savedocumento #coddocumento").val(coddocumento);
  $("#savedocumento #documento").val(documento);
  $("#savedocumento #descripcion").val(descripcion);
  $("#savedocumento #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR TIPOS DE DOCUMENTOS 
function EliminarDocumento(coddocumento,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Tipo de Documento?", 
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
                  data: "coddocumento="+coddocumento+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#documentos').load("consultas?CargaDocumentos=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Documento no puede ser Eliminado, tiene registros relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Documentos, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}











/////////////////////////////////// FUNCIONES DE TIPOS DE MONEDA //////////////////////////////////////

// FUNCION PARA ACTUALIZAR TIPOS DE MONEDA
function UpdateTipoMoneda(codmoneda,moneda,siglas,simbolo,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savemoneda #codmoneda").val(codmoneda);
  $("#savemoneda #moneda").val(moneda);
  $("#savemoneda #siglas").val(siglas);
  $("#savemoneda #simbolo").val(simbolo);
  $("#savemoneda #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR TIPOS DE MONEDA 
function EliminarTipoMoneda(codmoneda,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Tipo de Moneda?", 
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
                  data: "codmoneda="+codmoneda+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#monedas').load("consultas?CargaMonedas=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Tipo de Moneda no puede ser Eliminado, tiene Tipos de Cambio relacionadas!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Tipos de Moneda, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}











/////////////////////////////////// FUNCIONES DE TIPOS DE CAMBIO  //////////////////////////////////////

// FUNCION PARA ACTUALIZAR TIPOS DE CAMBIO
function UpdateTipoCambio(codcambio,descripcioncambio,montocambio,codmoneda,fechacambio,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savecambio #codcambio").val(codcambio);
  $("#savecambio #descripcioncambio").val(descripcioncambio);
  $("#savecambio #montocambio").val(montocambio);
  $("#savecambio #codmoneda").val(codmoneda);
  $("#savecambio #fechacambio").val(fechacambio);
  $("#savecambio #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR TIPOS DE CAMBIO 
function EliminarTipoCambio(codcambio,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Tipo de Cambio?", 
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
                  data: "codcambio="+codcambio+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#cambios').load("consultas?CargaCambios=si");
                  
           } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Tipos de Cambio, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}












/////////////////////////////////// FUNCIONES DE IMPUESTOS //////////////////////////////////////

// FUNCION PARA ACTUALIZAR IMPUESTOS
function UpdateImpuesto(codimpuesto,nomimpuesto,valorimpuesto,statusimpuesto,fechaimpuesto,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#saveimpuesto #codimpuesto").val(codimpuesto);
  $("#saveimpuesto #nomimpuesto").val(nomimpuesto);
  $("#saveimpuesto #valorimpuesto").val(valorimpuesto);
  $("#saveimpuesto #statusimpuesto").val(statusimpuesto);
  $("#saveimpuesto #fechaimpuesto").val(fechaimpuesto);
  $("#saveimpuesto #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR IMPUESTOS
function EliminarImpuesto(codimpuesto,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Impuesto?", 
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
                  data: "codimpuesto="+codimpuesto+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#impuestos').load("consultas?CargaImpuestos=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Impuesto no puede ser Eliminado, se encuentra activo para Ventas!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Impuestos, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}













/////////////////////////////////// FUNCIONES DE SALAS //////////////////////////////////////

// FUNCION PARA ACTUALIZAR SALAS
function UpdateSala(codsala,nomsala,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savesala #codsala").val(codsala);
  $("#savesala #nomsala").val(nomsala);
  $("#savesala #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR SALAS 
function EliminarSala(codsala,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Sala?", 
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
                  data: "codsala="+codsala+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#salas').load("consultas.php?CargaSalas=si");
            $("#savesala")[0].reset();

          } else if(data==2) { 

             swal("Oops", "Esta Salas no puede ser Eliminada, tiene registros relacionados!", "error"); 

           } else {  

             swal("Oops", "Usted no tiene Acceso para Eliminar Salas, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}















/////////////////////////////////// FUNCIONES DE SALAS //////////////////////////////////////

// FUNCION PARA ACTUALIZAR SALAS
function UpdateMesa(codmesa,codsala,nommesa,puestos,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savemesa #codmesa").val(codmesa);
  $("#savemesa #codsala").val(codsala);
  $("#savemesa #nommesa").val(nommesa);
  $("#savemesa #puestos").val(puestos);
  $("#savemesa #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR SALAS 
function EliminarMesa(codmesa,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Mesa en Sala?", 
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
                  data: "codmesa="+codmesa+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#mesas').load("consultas.php?CargaMesas=si");
            $("#savemesa")[0].reset();

          } else if(data==2) { 

             swal("Oops", "Esta Mesa no puede ser Eliminada, tiene registros relacionados!", "error"); 

           } else {  

             swal("Oops", "Usted no tiene Acceso para Eliminar Mesas en Salas, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}

// FUNCION PARA MOSTRAR MESAS POR SALAS
function CargaMesas(nuevasala){

$('#nuevamesa').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaMesasxSalas=si&codsala='+nuevasala;

$.ajax({
  type: "GET",
    url: "funciones.php",
    data: dataString,
      success: function(response) {            
        $('#nuevamesa').empty();
        $('#nuevamesa').append(''+response+'').fadeIn("slow");
      }
  });
}











/////////////////////////////////// FUNCIONES DE CATEGORIAS //////////////////////////////////////

// FUNCION PARA ACTUALIZAR CATEGORIAS
function UpdateCategoria(codcategoria,nomcategoria,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savecategoria #codcategoria").val(codcategoria);
  $("#savecategoria #nomcategoria").val(nomcategoria);
  $("#savecategoria #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR CATEGORIAS 
function EliminarCategoria(codcategoria,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Categoria de Producto?", 
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
                  data: "codcategoria="+codcategoria+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#categorias').load("consultas.php?CargaCategorias=si");
            $("#savecategoria")[0].reset();

          } else if(data==2) { 

             swal("Oops", "Esta Categoria no puede ser Eliminada, tiene registros relacionados!", "error"); 

           } else {  

             swal("Oops", "Usted no tiene Acceso para Eliminar Categorias de Productos, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}















/////////////////////////////////// FUNCIONES DE MEDIDAS //////////////////////////////////////

// FUNCION PARA ACTUALIZAR MEDIDAS
function UpdateMedida(codmedida,nommedida,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savemedida #codmedida").val(codmedida);
  $("#savemedida #nommedida").val(nommedida);
  $("#savemedida #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR UNIDADES 
function EliminarMedida(codmedida,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Medida?", 
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
                  data: "codmedida="+codmedida+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#medidas').load("consultas.php?CargaMedidas=si");
            $("#savemedida")[0].reset();

          } else if(data==2) { 

             swal("Oops", "Esta Medida no puede ser Eliminada, tiene registros relacionados!", "error"); 

           } else {  

             swal("Oops", "Usted no tiene Acceso para Eliminar Medidas, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}











/////////////////////////////////// FUNCIONES DE CLIENTES //////////////////////////////////////

// FUNCION PARA BUSCAR CLIENTES
function BuscarClientes(){
                        
$('#muestraclientes').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var search = $("#bclientes").val();
var dataString = $("#busquedaclientes").serialize();
var url = 'search.php?CargaClientes=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
      success: function(response) {            
        $('#muestraclientes').empty();
        $('#muestraclientes').append(''+response+'').fadeIn("slow");
      }
  });
}

// FUNCION PARA MOSTRAR DIV DE CARGA MASIVA DE CLIENTES
function CargaDivClientes(){

$('#divcliente').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');
                
var dataString = 'BuscaDivCliente=si';

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#divcliente').empty();
                $('#divcliente').append(''+response+'').fadeIn("slow");
                
           }
      });
}

// FUNCION PARA LIMPIAR DIV DE CARGA MASIVA DE CLIENTES
function ModalCliente(){
  $("#divcliente").html("");
}

// FUNCION PARA MOSTRAR CLIENTES EN VENTANA MODAL
function VerCliente(codcliente){

$('#muestraclientemodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaClienteModal=si&codcliente='+codcliente;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestraclientemodal').empty();
                $('#muestraclientemodal').append(''+response+'').fadeIn("slow");
                
            }
      });
}

//SELECCIONA NOMBRE O RAZON SOCIAL DE CLIENTE
function CargaTipoCliente(tipocliente){

    var valor = $("#tipocliente").val();

    if (tipocliente === "NATURAL" || tipocliente === true) {
    
    $('#nomcliente').attr('disabled', false);
    $("#razoncliente").attr('disabled', true);
    $('#girocliente').attr('disabled', true);

    } else {

    // deshabilitamos
    $('#nomcliente').attr('disabled', true);
    $("#razoncliente").attr('disabled', false);
    $('#girocliente').attr('disabled', false);

    }
}


// FUNCION PARA ACTUALIZAR CLIENTES
function UpdateCliente(codcliente,tipocliente,documcliente,dnicliente,nomcliente,razoncliente,girocliente,tlfcliente,id_provincia,
  direccliente,emailcliente,limitecredito,criterio,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savecliente #codcliente").val(codcliente);
  $("#savecliente #tipocliente").val(tipocliente);
  $("#savecliente #documcliente").val(documcliente);
  $("#savecliente #dnicliente").val(dnicliente);
  $("#savecliente #nomcliente").val(nomcliente);
  $("#savecliente #razoncliente").val(razoncliente);
  $("#savecliente #girocliente").val(girocliente);
  $("#savecliente #tlfcliente").val(tlfcliente);
  $("#savecliente #id_provincia").val(id_provincia);
  $("#savecliente #direccliente").val(direccliente);
  $("#savecliente #emailcliente").val(emailcliente);
  $("#savecliente #limitecredito").val(limitecredito);
  $("#savecliente #criterio").val(criterio);
  $("#savecliente #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR CLIENTES 
function EliminarCliente(codcliente,criterio,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Cliente?", 
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
                  data: "codcliente="+codcliente+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#muestraclientes').load("search.php?CargaClientes=si&bclientes="+criterio);
                  
          } else if(data==2){ 

             swal("Oops", "Este Cliente no puede ser Eliminado, tiene Ventas relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Clientes, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}











/////////////////////////////////// FUNCIONES DE PROVEEDORES //////////////////////////////////////

// FUNCION PARA MOSTRAR DIV DE CARGA MASIVA DE PROVEEDORES
function CargaDivProveedores(){

$('#divproveedor').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');
                
var dataString = 'BuscaDivProveedor=si';

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#divproveedor').empty();
                $('#divproveedor').append(''+response+'').fadeIn("slow");
                
           }
      });
}


// FUNCION PARA LIMPIAR DIV DE CARGA MASIVA DE PROVEEDORES
function ModalProveedor(){
  $("#divproveedor").html("");
}

// FUNCION PARA MOSTRAR PROVEEDORES EN VENTANA MODAL
function VerProveedor(codproveedor){

$('#muestraproveedormodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaProveedorModal=si&codproveedor='+codproveedor;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestraproveedormodal').empty();
                $('#muestraproveedormodal').append(''+response+'').fadeIn("slow");
                
            }
      });
}

// FUNCION PARA ACTUALIZAR PROVEEDORES
function UpdateProveedor(codproveedor,documproveedor,cuitproveedor,nomproveedor,tlfproveedor,id_provincia,
  direcproveedor,emailproveedor,vendedor,tlfvendedor,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#saveproveedor #codproveedor").val(codproveedor);
  $("#saveproveedor #documproveedor").val(documproveedor);
  $("#saveproveedor #cuitproveedor").val(cuitproveedor);
  $("#saveproveedor #nomproveedor").val(nomproveedor);
  $("#saveproveedor #tlfproveedor").val(tlfproveedor);
  $("#saveproveedor #id_provincia").val(id_provincia);
  $("#saveproveedor #direcproveedor").val(direcproveedor);
  $("#saveproveedor #emailproveedor").val(emailproveedor);
  $("#saveproveedor #vendedor").val(vendedor);
  $("#saveproveedor #tlfvendedor").val(tlfvendedor);
  $("#saveproveedor #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR PROVEEDORES 
function EliminarProveedor(codproveedor,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Proveedor?", 
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
                  data: "codproveedor="+codproveedor+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#proveedores').load("consultas.php?CargaProveedores=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Proveedor no puede ser Eliminado, tiene Productos relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Proveedores, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}












/////////////////////////////////// FUNCIONES DE INGREDIENTES //////////////////////////////////////

// FUNCION PARA BUSCAR INGREDIENTES
$(document).ready(function(){
//function BuscarPacientes() {  
    var consulta;
    //hacemos focus al campo de búsqueda
    $("#bingredientes").focus();
    //comprobamos si se pulsa una tecla
    $("#bingredientes").keyup(function(e){
      //obtenemos el texto introducido en el campo de búsqueda
      consulta = $("#bingredientes").val();
                                                                           
        //hace la búsqueda
        $.ajax({
          type: "POST",
          url: "search.php?CargaIngredientes=si",
          data: "b="+consulta,
          dataType: "html",
          beforeSend: function(){
              //imagen de carga
              $("#ingredientes").html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>');
          },
          error: function(){
              swal("Oops", "Ha ocurrido un error en la petición Ajax, verifique por favor!", "error"); 
          },
          success: function(data){                                                    
            $("#ingredientes").empty();
            $("#ingredientes").append(data);
          }
      });
   });                                                               
});

// FUNCION PARA MOSTRAR DIV DE CARGA MASIVA DE INGREDIENTES
function CargaDivIngredientes(){

$('#divingrediente').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');
                
var dataString = 'BuscaDivIngrediente=si';

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#divingrediente').empty();
                $('#divingrediente').append(''+response+'').fadeIn("slow");
                
           }
      });
}

// FUNCION PARA LIMPIAR DIV DE CARGA MASIVA DE INGREDIENTES
function ModalIngrediente(){
  $("#divingrediente").html("");
}

// FUNCION PARA MOSTRAR INGREDIENTES EN VENTANA MODAL
function VerIngrediente(codingrediente){

$('#muestraingredientemodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaIngredienteModal=si&codingrediente='+codingrediente;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestraingredientemodal').empty();
                $('#muestraingredientemodal').append(''+response+'').fadeIn("slow");
                
            }
      });
}

// FUNCION PARA ACTUALIZAR INGREDIENTES
function UpdateIngrediente(codingrediente) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Actualizar este Ingrediente?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Actualizar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "foringrediente?codingrediente="+codingrediente;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}


/////FUNCION PARA ELIMINAR DETALLE DE INGREDIENTES 
function EliminaDetalleIngredienteNuevo(codproducto,codingrediente,cantracion,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Ingrediente del Producto?", 
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
                  data: "codproducto="+codproducto+"&codingrediente="+codingrediente+"&cantracion="+cantracion+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $("#cargaingredientes").load("funciones.php?BuscaIngredienteNuevo=si&codproducto="+codproducto);

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Ingrediente, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}


/////FUNCION PARA ELIMINAR DETALLE DE INGREDIENTES 
function EliminaDetalleIngredienteAgregado(codproducto,codingrediente,cantracion,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Ingrediente del Producto?", 
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
                  data: "codproducto="+codproducto+"&codingrediente="+codingrediente+"&cantracion="+cantracion+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $("#cargaingredientes").load("funciones.php?BuscaIngredienteAgregados=si&codproducto="+codproducto);

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Ingrediente, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}
/////FUNCION PARA ELIMINAR INGREDIENTES 
function EliminarIngrediente(codingrediente,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Ingrediente?", 
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
                  data: "codingrediente="+codingrediente+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            //hace la búsqueda
            $.ajax({
              type: "POST",
              url: "search.php?CargaIngredientes=si",
              data: "b="+$("#bingredientes").val(),
              dataType: "html",
              success: function(data){                                                    
                $("#ingredientes").empty();
                $("#ingredientes").append(data);
              }
            });
                  
          } else if(data==2){ 

             swal("Oops", "Este Ingrediente no puede ser Eliminado, tiene Productos relacionadas!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Ingrediente, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}

// FUNCION PARA BUSQUEDA DE INGREDIENTES VENDIDOS
function BuscaIngredientesVendidos(){
    
$('#muestraingredientesvendidos').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#ingredientesvendidos").serialize();
var url = 'funciones.php?BuscaIngredientesVendidos=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestraingredientesvendidos').empty();
                $('#muestraingredientesvendidos').append(''+response+'').fadeIn("slow");
                
            }
      }); 
}

// FUNCION PARA BUSQUEDA DE KARDEX POR INGREDIENTES
function BuscaKardexIngredientes(){

$('#muestrakardex').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codingrediente = $("#codingrediente").val();
var dataString = $("#buscakardexingredientes").serialize();
var url = 'funciones.php?BuscaKardexIngrediente=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestrakardex').empty();
                $('#muestrakardex').append(''+response+'').fadeIn("slow");
                
            }
      }); 
}

// FUNCION PARA BUSCAR KARDEX VALORIZADO DE INGREDIENTES
$(document).ready(function(){
//function BuscarPacientes() {  
    var consulta;
    //hacemos focus al campo de búsqueda
    $("#bkardexingredientes").focus();
    //comprobamos si se pulsa una tecla
    $("#bkardexingredientes").keyup(function(e){
      //obtenemos el texto introducido en el campo de búsqueda
      consulta = $("#bkardexingredientes").val();
                                                                           
        //hace la búsqueda
        $.ajax({
          type: "POST",
          url: "search.php?CargaKardexValorizadoIngredientes=si",
          data: "b="+consulta,
          dataType: "html",
          beforeSend: function(){
              //imagen de carga
              $("#valorizado_ingredientes").html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>');
          },
          error: function(){
              swal("Oops", "Ha ocurrido un error en la petición Ajax, verifique por favor!", "error"); 
          },
          success: function(data){                                                    
            $("#valorizado_ingredientes").empty();
            $("#valorizado_ingredientes").append(data);
          }
      });
   });                                                               
});

// FUNCION PARA BUSQUEDA DE KARDEX INGREDIENTES VALORIZADO POR FECHAS
function BuscaValorizadoIngredientesxFechas(){
    
$('#muestrakardexvalorizadofechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#valorizadoingredientesxfechas").serialize();
var url = 'funciones.php?BuscaKardexIngredientesxFechas=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestrakardexvalorizadofechas').empty();
                $('#muestrakardexvalorizadofechas').append(''+response+'').fadeIn("slow");
            }
      }); 
}
















/////////////////////////////////// FUNCIONES DE PRODUCTOS //////////////////////////////////////

// FUNCION PARA BUSCAR PRODUCTOS
$(document).ready(function(){
//function BuscarPacientes() {  
    var consulta;
    //hacemos focus al campo de búsqueda
    $("#bproductos").focus();
    //comprobamos si se pulsa una tecla
    $("#bproductos").keyup(function(e){
      //obtenemos el texto introducido en el campo de búsqueda
      consulta = $("#bproductos").val();
                                                                           
        //hace la búsqueda
        $.ajax({
          type: "POST",
          url: "search.php?CargaProductos=si",
          data: "b="+consulta,
          dataType: "html",
          beforeSend: function(){
              //imagen de carga
              $("#productos").html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>');
          },
          error: function(){
              swal("Oops", "Ha ocurrido un error en la petición Ajax, verifique por favor!", "error"); 
          },
          success: function(data){                                                    
            $("#productos").empty();
            $("#productos").append(data);
          }
      });
   });                                                               
});

//FUNCION PARA CALCULAR PRECIO VENTA
$(document).ready(function (){
    $('.calculoprecio').keyup(function (){
  
      var precio = $('input#preciocompra').val();
      var porcentaje = $('input#porcentaje').val()/100;

      //REALIZO EL CALCULO
      var calculo = parseFloat(precio)*parseFloat(porcentaje);
      precioventa = parseFloat(calculo)+parseFloat(precio);
      $("#precioventa").val((porcentaje == "0.00") ? "" : precioventa.toFixed(2));
  });
}); 

// FUNCION PARA MOSTRAR DIV DE CARGA MASIVA DE PRODUCTOS
function CargaDivProductos(){

$('#divproducto').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');
                
var dataString = 'BuscaDivProducto=si';

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#divproducto').empty();
                $('#divproducto').append(''+response+'').fadeIn("slow");
                
           }
      });
}

// FUNCION PARA LIMPIAR DIV DE CARGA MASIVA DE PRODUCTOS
function ModalProducto(){
  $("#divproducto").html("");
}

// FUNCION PARA MOSTRAR PRODUCTOS EN VENTANA MODAL
function VerProducto(codproducto){

$('#muestraproductomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaProductoModal=si&codproducto='+codproducto;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestraproductomodal').empty();
                $('#muestraproductomodal').append(''+response+'').fadeIn("slow");
                
            }
      });
}

// FUNCION PARA SUMAR STOCK A PRODUCTO
function SumarProducto(idproducto,codproducto,producto) 
{
  // aqui asigno cada valor a los campos correspondientes
  $("#savestockproducto #idproducto").val(idproducto);
  $("#savestockproducto #codproducto").val(codproducto);
  $("#savestockproducto #producto").val(producto);
}

// FUNCION PARA ACTUALIZAR PRODUCTOS
function UpdateProducto(codproducto) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Actualizar este Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Actualizar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forproducto?codproducto="+codproducto;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

// FUNCION PARA AGREGAR INGREDIENTES A PRODUCTOS
function AgregaIngrediente(codproducto) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Agregar Ingredientes a este Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Continuar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "foragregaingredientes?codproducto="+codproducto;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}


/////FUNCION PARA ELIMINAR DETALLE DE PRODUCTOS 
function EliminaDetalleProductoNuevo(codcombo,codproducto,cantidad,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Producto del Combo?", 
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
                  data: "codcombo="+codcombo+"&codproducto="+codproducto+"&cantidad="+cantidad+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $("#cargaproductos").load("funciones.php?BuscaProductosNuevo=si&codcombo="+codcombo);

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Productos, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR DETALLE DE PRODUCTOS 
function EliminaDetalleProductoAgregado(codcombo,codproducto,cantidad,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Producto del Combo?", 
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
                  data: "codcombo="+codcombo+"&codproducto="+codproducto+"&cantidad="+cantidad+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $("#cargaproductos").load("funciones.php?BuscaProductosAgregados=si&codcombo="+codcombo);

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Productos, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR PRODUCTOS 
function EliminarProducto(codproducto,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Producto?", 
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
                  data: "codproducto="+codproducto+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#productos').load("consultas.php?CargaProductos=si");
            //hace la búsqueda
            /*$.ajax({
              type: "POST",
              url: "search.php?CargaProductos=si",
              data: "b="+$("#bproductos").val(),
              dataType: "html",
              success: function(data){                                                    
                $("#productos").empty();
                $("#productos").append(data);
              }
            });*/
                  
          } else if(data==2){ 

             swal("Oops", "Este Producto no puede ser Eliminado, tiene Ventas relacionadas!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Productos, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}

// FUNCION PARA CALCULAR DETALLES COTIZACIONES EN ACTUALIZAR
function ProcesarCalculoIngrediente(indice){
    var cantidad = $('#cantidad_'+indice).val();
    var precioventa = $('#precioventaing_'+indice).val();
    var preciocompra = $('#preciocompraing_'+indice).val();
    var ValorNeto = 0;

    if (cantidad == "" || cantidad == "0.00") {

        $("#cantidad_"+indice).focus();
        $("#cantidad_"+indice).val("");
        $("#cantidad").css('border-color', '#f0ad4e');
        swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA!", "error");
        return false;
    }
    //REALIZAMOS LA MULTIPLICACION DE PRECIO COMPRA * CANTIDAD
    var ValorCompra = parseFloat(cantidad) * parseFloat(preciocompra);

    //REALIZAMOS LA MULTIPLICACION DE PRECIO VENTA * CANTIDAD
    var ValorVenta = parseFloat(cantidad) * parseFloat(precioventa);

    //CALCULO SUBTOTAL IVA SI
    $("#preciocompraing_"+indice).val(ValorCompra.toFixed(2));
    $("#txtmontocompra_"+indice).text(ValorCompra.toFixed(2));
    //CALCULO SUBTOTAL IVA NO
    $("#precioventaing_"+indice).val(ValorVenta.toFixed(2));
    $("#txtmontoventa_"+indice).text(ValorVenta.toFixed(2));

    //CALCULO DE PRECIO COMPRA
    var MontoCompra=0;
    $('.preciocompraing').each(function() {  
    MontoCompra += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#preciocompra').val(MontoCompra.toFixed(2));

    //CALCULO DE PRECIO VENTA
    var MontoVenta=0;
    $('.precioventaing').each(function() {  
    MontoVenta += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#precioventa').val(MontoVenta.toFixed(2));
}


// FUNCION PARA BUSQUEDA DE PRODUCTOS VENDIDOS
function BuscaProductosVendidos(){
    
$('#muestraproductosvendidos').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#productosvendidos").serialize();
var url = 'funciones.php?BuscaProductosVendidos=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestraproductosvendidos').empty();
                $('#muestraproductosvendidos').append(''+response+'').fadeIn("slow");
            }
      }); 
}


// FUNCION PARA BUSQUEDA DE PRODUCTOS POR MONEDA
function BuscaProductosxMoneda(){
    
$('#muestraproductosxmoneda').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codmoneda = $("select#codmoneda").val();
var dataString = $("#productosxmoneda").serialize();
var url = 'funciones.php?BuscaProductosxMoneda=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestraproductosxmoneda').empty();
                $('#muestraproductosxmoneda').append(''+response+'').fadeIn("slow");
                
            }
      }); 
}


// FUNCION PARA BUSQUEDA DE KARDEX POR PRODUCTOS
function BuscaKardexProductos(){

$('#muestrakardex').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codproducto = $("#codproducto").val();
var dataString = $("#buscakardexproductos").serialize();
var url = 'funciones.php?BuscaKardexProducto=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestrakardex').empty();
                $('#muestrakardex').append(''+response+'').fadeIn("slow");
                
            }
      }); 
}

// FUNCION PARA BUSCAR KARDEX VALORIZADO DE PRODUCTOS
$(document).ready(function(){
//function BuscarPacientes() {  
    var consulta;
    //hacemos focus al campo de búsqueda
    $("#bkardexproductos").focus();
    //comprobamos si se pulsa una tecla
    $("#bkardexproductos").keyup(function(e){
      //obtenemos el texto introducido en el campo de búsqueda
      consulta = $("#bkardexproductos").val();
                                                                           
        //hace la búsqueda
        $.ajax({
          type: "POST",
          url: "search.php?CargaKardexValorizadoProductos=si",
          data: "b="+consulta,
          dataType: "html",
          beforeSend: function(){
              //imagen de carga
              $("#valorizado_productos").html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>');
          },
          error: function(){
              swal("Oops", "Ha ocurrido un error en la petición Ajax, verifique por favor!", "error"); 
          },
          success: function(data){                                                    
            $("#valorizado_productos").empty();
            $("#valorizado_productos").append(data);
          }
      });
   });                                                               
});


// FUNCION PARA BUSQUEDA DE KARDEX PRODUCTOS VALORIZADO POR FECHAS
function BuscaValorizadoProductosxFechas(){
    
$('#muestrakardexvalorizadofechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#valorizadoproductosxfechas").serialize();
var url = 'funciones.php?BuscaKardexProductosxFechas=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestrakardexvalorizadofechas').empty();
                $('#muestrakardexvalorizadofechas').append(''+response+'').fadeIn("slow");
            }
      }); 
}

// FUNCION PARA CARGAR PRODUCTOS POR FAMILIAS EN VENTANA MODAL
function CargaProductos(){

$('#loadproductos').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var dataString = "CargaProductos=si";

$.ajax({
            type: "GET",
            url: "salas_mesas.php",
            data: dataString,
            success: function(response) {            
                $('#loadproductos').empty();
                $('#loadproductos').append(''+response+'').fadeIn("slow");  
            }
      });
}

// FUNCION PARA CARGAR MENU DE PRODUCTOS EN VENTANA MODAL
function CargarMenu(){

$('#muestra_menu').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var dataString = "Buscar_Menu=si";

$.ajax({
      type: "GET",
      url: "funciones.php",
      data: dataString,
      success: function(response) {            
          $('#muestra_menu').empty();
          $('#muestra_menu').append(''+response+'').fadeIn("slow");
          
      }
  });
}




















/////////////////////////////////// FUNCIONES DE COMBOS //////////////////////////////////////

// FUNCION PARA MOSTRAR COMBOS EN VENTANA MODAL
function VerCombo(codcombo){

$('#muestracombomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaComboModal=si&codcombo='+codcombo;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestracombomodal').empty();
                $('#muestracombomodal').append(''+response+'').fadeIn("slow");
                
            }
      });
}

// FUNCION PARA SUMAR STOCK A COMBO
function SumarCombo(idcombo,codcombo,nomcombo) 
{
  // aqui asigno cada valor a los campos correspondientes
  $("#savestockcombo #idcombo").val(idcombo);
  $("#savestockcombo #codcombo").val(codcombo);
  $("#savestockcombo #nomcombo").val(nomcombo);
}

// FUNCION PARA ACTUALIZAR COMBOS
function UpdateCombo(codcombo) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Actualizar este Combo?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Actualizar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forcombo?codcombo="+codcombo;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

// FUNCION PARA AGREGAR PRODUCTOS A COMBOS
function AgregaProducto(codcombo) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Agregar Productos a este Combo?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Continuar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "foragregaproductos?codcombo="+codcombo;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

/////FUNCION PARA ELIMINAR COMBOS 
function EliminarCombo(codcombo,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Combo?", 
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
                  data: "codcombo="+codcombo+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#combos').load("consultas.php?CargaCombos=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Combo no puede ser Eliminado, tiene Ventas relacionadas!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Combos, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}


// FUNCION PARA CALCULAR DETALLES COTIZACIONES EN ACTUALIZAR
function ProcesarCalculoProducto(indice){
    var cantidad = $('#cantidad_'+indice).val();
    var precioventa = $('#precioventadet_'+indice).val();
    var preciocompra = $('#preciocompradet_'+indice).val();
    var ValorNeto = 0;

    if (cantidad == "" || cantidad == "0" || cantidad == "0.00") {

        $("#cantidad_"+indice).focus();
        $("#cantidad").css('border-color', '#f0ad4e');
        swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA!", "error");
        return false;
    }
    //REALIZAMOS LA MULTIPLICACION DE PRECIO COMPRA * CANTIDAD
    var ValorCompra = parseFloat(cantidad) * parseFloat(preciocompra);

    //REALIZAMOS LA MULTIPLICACION DE PRECIO VENTA * CANTIDAD
    var ValorVenta = parseFloat(cantidad) * parseFloat(precioventa);

    //CALCULO SUBTOTAL IVA SI
    $("#montocompra_"+indice).val(ValorCompra.toFixed(2));
    $("#txtmontocompra_"+indice).text(ValorCompra.toFixed(2));
    //CALCULO SUBTOTAL IVA NO
    $("#montoventa_"+indice).val(ValorVenta.toFixed(2));
    $("#txtmontoventa_"+indice).text(ValorVenta.toFixed(2));

    //CALCULO DE PRECIO COMPRA
    var MontoCompra=0;
    $('.preciocompradet').each(function() {  
    MontoCompra += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#preciocompra').val(MontoCompra.toFixed(2));

    //CALCULO DE PRECIO VENTA
    var MontoVenta=0;
    $('.precioventadet').each(function() {  
    MontoVenta += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#precioventa').val(MontoVenta.toFixed(2));
}

// FUNCION PARA BUSQUEDA DE COMBOS VENDIDOS
function BuscaCombosVendidos(){
    
$('#muestracombosvendidos').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#combosvendidos").serialize();
var url = 'funciones.php?BuscaCombosVendidos=si';

        $.ajax({
            type: "GET",
      url: url,
            data: dataString,
            success: function(response) {
                $('#muestracombosvendidos').empty();
                $('#muestracombosvendidos').append(''+response+'').fadeIn("slow");
                
            }
      }); 
}

// FUNCION PARA BUSQUEDA DE COMBOS POR MONEDA
function BuscaCombosxMoneda(){
    
$('#muestracombosxmoneda').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codmoneda = $("select#codmoneda").val();
var dataString = $("#combosxmoneda").serialize();
var url = 'funciones.php?BuscaCombosxMoneda=si';

        $.ajax({
            type: "GET",
      url: url,
            data: dataString,
            success: function(response) {
                $('#muestracombosxmoneda').empty();
                $('#muestracombosxmoneda').append(''+response+'').fadeIn("slow");
            }
      }); 
}

// FUNCION PARA BUSQUEDA DE KARDEX POR COMBOS
function BuscaKardexCombos(){

$('#muestrakardex').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codcombo = $("#codcombo").val();
var dataString = $("#buscakardexcombos").serialize();
var url = 'funciones.php?BuscaKardexCombo=si';

        $.ajax({
            type: "GET",
      url: url,
            data: dataString,
            success: function(response) {
                $('#muestrakardex').empty();
                $('#muestrakardex').append(''+response+'').fadeIn("slow");
                
            }
      }); 
}


// FUNCION PARA BUSQUEDA DE KARDEX COMBOS VALORIZADO POR FECHAS
function BuscaValorizadoCombosxFechas(){
    
$('#muestrakardexvalorizadofechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#valorizadocombosxfechas").serialize();
var url = 'funciones.php?BuscaKardexCombosxFechas=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestrakardexvalorizadofechas').empty();
                $('#muestrakardexvalorizadofechas').append(''+response+'').fadeIn("slow");
            }
      }); 
}


// FUNCION PARA CARGAR COMBOS POR PRODUCTOS EN VENTANA MODAL
function CargaCombos(){

$('#loadcombos').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var dataString = "CargaCombos=si";

$.ajax({
            type: "GET",
            url: "salas_mesas.php",
            data: dataString,
            success: function(response) {            
                $('#loadcombos').empty();
                $('#loadcombos').append(''+response+'').fadeIn("slow");
                
            }
      });
}




























/////////////////////////////////// FUNCIONES DE COMPRAS //////////////////////////////////////


// FUNCION PARA BUSCAR COMPRAS PAGADAS
function BuscarCompras(){
                        
$('#muestracompras').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var search = $("#bcompras").val();
var dataString = $("#busquedacompras").serialize();
var url = 'search.php?CargaCompras=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
      success: function(response) {            
        $('#muestracompras').empty();
        $('#muestracompras').append(''+response+'').fadeIn("slow");
      }
  });
}

// FUNCION PARA BUSCAR COMPRAS PENDIENTES
function BuscarCuentasxPagar(){
                        
$('#muestracuentasxpagar').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var search = $("#bcompras").val();
var dataString = $("#busquedacuentasxpagar").serialize();
var url = 'search.php?CargaCuentasxPagar=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
      success: function(response) {            
        $('#muestracuentasxpagar').empty();
        $('#muestracuentasxpagar').append(''+response+'').fadeIn("slow");
      }
  });
}

// FUNCION PARA MOSTRAR FORMA DE PAGO EN COMPRAS
function CargaFormaPagosCompras(){

  var valor = $("#tipocompra").val();

      if (valor === "" || valor === true) {
         
          $("#formacompra").attr('disabled', true);
          $("#fechavencecredito").attr('disabled', true);

      } else if (valor === "CONTADO" || valor === true) {
         
          $("#formacompra").attr('disabled', false);
          $("#fechavencecredito").attr('disabled', true);

      } else {

          $("#formacompra").attr('disabled', true);
          $("#fechavencecredito").attr('disabled', false);
      }
}

// FUNCION PARA MOSTRAR COMPRA PAGADA EN VENTANA MODAL
function VerCompraPagada(codcompra){

$('#muestracompramodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaCompraPagadaModal=si&codcompra='+codcompra;

$.ajax({
            type: "GET",
                  url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestracompramodal').empty();
                $('#muestracompramodal').append(''+response+'').fadeIn("slow");
                
            }
      });
}


// FUNCION PARA MOSTRAR COMPRA PENDIENTE EN VENTANA MODAL
function VerCompraPendiente(codcompra){

$('#muestracompramodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaCompraPendienteModal=si&codcompra='+codcompra;

$.ajax({
            type: "GET",
                  url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestracompramodal').empty();
                $('#muestracompramodal').append(''+response+'').fadeIn("slow");
                
            }
      });
}

// FUNCION PARA ACTUALIZAR COMPRAS
function UpdateCompra(codcompra,proceso,status) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Actualizar esta Compra de Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Actualizar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forcompra?codcompra="+codcompra+"&proceso="+proceso+"&status="+status;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}


// FUNCION PARA CALCULAR DETALLES VENTAS EN ACTUALIZAR
function ProcesarCalculoCompra(indice){
    var cantidad = $('#cantcompra_'+indice).val();
    var preciocompra = $('#preciocompra_'+indice).val();
    var neto = $('#valorneto_'+indice).val();
    var descproducto = $('#descfactura_'+indice).val();
    var ivaproducto = $('#ivaproducto_'+indice).val();
    var ivg = $('#iva').val();
    var desc = $('#descuento').val();
    var ValorNeto = 0;

    if (cantidad == "" || cantidad == "0" || cantidad == "0.00") {

        $("#cantcompra_"+indice).focus();
        $("#cantcompra_"+indice).css('border-color', '#f0ad4e');
        swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA!", "error");
        return false;
    }
    //REALIZAMOS LA MULTIPLICACION DE PRECIO VENTA * CANTIDAD
    var ValorTotal = parseFloat(cantidad) * parseFloat(preciocompra);

    //CALCULO DEL TOTAL DEL DESCUENTO %
    var Descuento = ValorTotal * descproducto / 100;
    var ValorNeto = parseFloat(ValorTotal) - parseFloat(Descuento);
    
    //CALCULO VALOR TOTAL
    $("#valortotal_"+indice).val(ValorTotal.toFixed(2));
    $("#txtvalortotal_"+indice).text(ValorTotal.toFixed(2));

    //CALCULO TOTAL DESCUENTO
    $("#totaldescuentoc_"+indice).val(Descuento.toFixed(2));
    $("#txtdescproducto_"+indice).text(Descuento.toFixed(2));

    //CALCULO VALOR NETO
    $("#valorneto_"+indice).val(ValorNeto.toFixed(2));
    $("#txtvalorneto_"+indice).text(ValorNeto.toFixed(2));

    //CALCULO SUBTOTAL IVA SI
    $("#subtotalivasi_"+indice).val(ivaproducto == "SI" ? ValorNeto.toFixed(2) : "0.00");
    //CALCULO SUBTOTAL IVA NO
    $("#subtotalivano_"+indice).val(ivaproducto == "NO" ? ValorNeto.toFixed(2) : "0.00"); 

    //CALCULO DE SUBTOTAL CON IVA
    var BaseImpIva1=0;
    $('.subtotalivasi').each(function() {  
    BaseImpIva1 += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#txtsubtotal').val(BaseImpIva1.toFixed(2));
    $('#lblsubtotal').text(BaseImpIva1.toFixed(2));

    //CALCULO DE SUBTOTAL SIN IVA
    var BaseImpIva2=0;
    $('.subtotalivano').each(function() {  
    BaseImpIva2 += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#txtsubtotal2').val(BaseImpIva2.toFixed(2));
    $('#lblsubtotal2').text(BaseImpIva2.toFixed(2));

    //CALCULO DE TOTAL IVA
    var TotalIva = BaseImpIva1 * ivg / 100;
    $('#txtIva').val(TotalIva.toFixed(2));
    $('#lbliva').text(TotalIva.toFixed(2));

    //CALCULO DE TOTAL DESCONTADO
    var TotalDescontado=0;
    $('.totaldescuentoc').each(function() {  
    TotalDescontado += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    });
    $('#txtdescontado').val(TotalDescontado.toFixed(2));
    $('#lbldescontado').text(TotalDescontado.toFixed(2)); 

    //CALCULAMOS DESCUENTO POR PRODUCTO
    desc2  = desc/100;

    //CALCULO DEL TOTAL DE FACTURA
    var Total = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2) + parseFloat(TotalIva);
    SubTotal = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2);
    TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
    TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));

    $('#txtTotal').val(TotalFactura.toFixed(2));
    $('#lbltotal').text(TotalFactura.toFixed(2));
}


/////FUNCION PARA ELIMINAR DETALLES DE COMPRAS PAGADAS EN VENTANA MODAL
function EliminarDetallesComprasPagadasModal(coddetallecompra,codcompra,codproveedor,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Compra?", 
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
                  data: "coddetallecompra="+coddetallecompra+"&codcompra="+codcompra+"&codproveedor="+codproveedor+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#muestracompramodal').load("funciones.php?BuscaCompraPagadaModal=si&codcompra="+codcompra); 
            //hace la búsqueda
            $.ajax({
              type: "POST",
              url: "search.php?CargaCompras=si",
              data: "b="+$("#bcompras").val(),
              dataType: "html",
              success: function(data){                                                    
                $("#compras").empty();
                $("#compras").append(data);
              }
            });

          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Compras en este Módulo, realice la Eliminación completa de la Compra!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Compras, no eres el Administrador!", "error"); 

                }
            }
        })
    });
}


/////FUNCION PARA ELIMINAR DETALLES DE COMPRAS PENDIENTES EN VENTANA MODAL
function EliminarDetallesComprasPendientesModal(coddetallecompra,codcompra,codproveedor,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Compra?", 
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
                  data: "coddetallecompra="+coddetallecompra+"&codcompra="+codcompra+"&codproveedor="+codproveedor+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#muestracompramodal').load("funciones.php?BuscaCompraPendienteModal=si&codcompra="+codcompra); 
            //hace la búsqueda
            $.ajax({
              type: "POST",
              url: "search.php?CargaCuentasxPagar=si",
              data: "b="+$("#bcomprasp").val(),
              dataType: "html",
              success: function(data){                                                    
                $("#cuentasxpagar").empty();
                $("#cuentasxpagar").append(data);
              }
            });

          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Compras en este Módulo, realice la Eliminación completa de la Compra!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Compras, no eres el Administrador!", "error"); 

                }
            }
        })
    });
}


/////FUNCION PARA ELIMINAR DETALLES DE COMPRAS EN ACTUALIZAR
function EliminarDetallesComprasUpdate(coddetallecompra,codcompra,codproveedor,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Compra?", 
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
                  data: "coddetallecompra="+coddetallecompra+"&codcompra="+codcompra+"&codproveedor="+codproveedor+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#detallescomprasupdate').load("funciones.php?MuestraDetallesComprasUpdate=si&codcompra="+codcompra); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Compras en este Módulo, realice la Eliminación completa de la Compra!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Compras, no eres el Administrador!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR COMPRAS 
function EliminarCompra(codcompra,codproveedor,status,criterio,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Compra?", 
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
                  data: "codcompra="+codcompra+"&codproveedor="+codproveedor+"&tipo="+tipo,
                  success: function(data){

          if(data==1){
            swal("Eliminado!", "Datos eliminados con éxito!", "success");
             if (status=="P") {
            $('#muestracompras').load("search.php?CargaCompras=si&bcompras="+criterio); 
            } else {
            $('#muestracuentasxpagar').load("search.php?CargaCuentasxPagar=si&bcompras="+criterio);  
            }
          
          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Compras de Productos, no eres el Administrador!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA PAGAR FACTURA DE COMPRAS 
function PagarCompra(codcompra,criterio,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Pagar Esta Factura de Compra?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Pagar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codcompra="+codcompra+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Factura Pagada!", "La Compra a sido Pagada con éxito!", "success");
            $('#muestracuentasxpagar').load("search.php?CargaCuentasxPagar=si&bcompras="+criterio);
                  
          } else { 

             swal("Oops", "Usted no tiene Acceso para Pagar Compras de Productos, no eres el Administrador!", "error"); 

                }
            }
        })
    });
}


// FUNCION PARA BUSQUEDA DE COMPRAS POR PROVEEDORES
function BuscarComprasxProveedores(){
                        
$('#muestracomprasxproveedores').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var codproveedor = $("select#codproveedor").val();
var dataString = $("#comprasxproveedores").serialize();
var url = 'funciones.php?BuscaComprasxProvedores=si';

$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestracomprasxproveedores').empty();
                $('#muestracomprasxproveedores').append(''+response+'').fadeIn("slow");
                
             }
      });
}

// FUNCION PARA BUSQUEDA DE COMPRAS POR FECHAS
function BuscarComprasxFechas(){
                        
$('#muestracomprasxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#comprasxfechas").serialize();
var url = 'funciones.php?BuscaComprasxFechas=si';

$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestracomprasxfechas').empty();
                $('#muestracomprasxfechas').append(''+response+'').fadeIn("slow");
                
             }
      });
}



















/////////////////////////////////// FUNCIONES DE COTIZACIONES //////////////////////////////////////

//FUNCION PARA CALCULAR DEVOLUCION DE MONTO
function DevolucionCotizacion(){
      
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
            
    //REALIZO EL CALCULO Y MUESTRO LA DEVOLUCION
    var sumtotal = parseFloat(montototal) + parseFloat(montodelivery);
    var Sumatoria = parseFloat(sumtotal.toFixed(2));

    var sumpagado = parseFloat(montopagado) + parseFloat(montopagado2);
    var subtotal= parseFloat(sumpagado);
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
function CargaCondicionesPagosCotizacion(){
    
var tipopago = $('input:radio[name=tipopago]:checked').val();
var montototal = $('input#txtTotal').val();
var montodelivery = $('input#montodelivery').val(); 

var sumtotal = parseFloat(montototal) + parseFloat(montodelivery);
var Sumatoria = parseFloat(sumtotal.toFixed(2));

$("#TextImporte").text(Sumatoria.toFixed(2));
$("#TextPagado").text(tipopago == "CREDITO" ? "0.00" : montototal);
$("#TextCambio").text("0.00");

var dataString = 'BuscaCondicionesPagosCotizacion=si&tipopago='+tipopago+"&txtTotal="+montototal;

    $.ajax({
        type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
            $('#muestra_condiciones').empty();
            $('#muestra_condiciones').append(''+response+'').fadeIn("slow");                
        }
    });
}

// FUNCION PARA BUSCAR COTIZACIONES
function BuscarCotizaciones(){
                        
$('#muestracotizaciones').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var search = $("#bcotizaciones").val();
var dataString = $("#busquedacotizaciones").serialize();
var url = 'search.php?CargaCotizaciones=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
      success: function(response) {            
        $('#muestracotizaciones').empty();
        $('#muestracotizaciones').append(''+response+'').fadeIn("slow");
      }
  });
}

// FUNCION PARA MOSTRAR COTIZACIONES EN VENTANA MODAL
function VerCotizacion(codcotizacion){

$('#muestracotizacionmodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaCotizacionModal=si&codcotizacion='+codcotizacion;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestracotizacionmodal').empty();
                $('#muestracotizacionmodal').append(''+response+'').fadeIn("slow");
            }
      });
}

// FUNCION PARA CARGAR DATOS DE COTIZACION
function ProcesaCotizacion(codcotizacion,codcliente,busqueda,nombres,limitecredito,totalpago,criterio) 
{
  // aqui asigno cada valor a los campos correspondientes
  $("#procesacotizacion #codcotizacion").val(codcotizacion);
  $("#procesacotizacion #codcliente").val(codcliente);
  $("#procesacotizacion #busqueda").val(busqueda);
  $("#procesacotizacion #TextCliente").text(nombres);
  $("#procesacotizacion #TextCredito").text(limitecredito);
  $("#procesacotizacion #TextImporte").text(totalpago);
  $("#procesacotizacion #txtImporte").val(totalpago);
  $("#procesacotizacion #txtTotal").val(totalpago);
  $("#procesacotizacion #TextPagado").text(totalpago);
  $("#procesacotizacion #montopagado").val(totalpago);
  $("#procesacotizacion #criterio").val(criterio);
}


//FUNCIONES PARA ACTIVAR-DESACTIVAR MONTO DELIVERY
$(document).ready(function(){
   $('#repartidores').on('change', function() {

    var two = $('select#repartidores').val();

        if (two != "" || two === true) {

        $("#montodelivery").attr('disabled', false);
        $("#montodelivery").focus();

        } else {

        $("#montodelivery").attr('disabled', true);

        } 
    });
});

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


// FUNCION PARA ACTUALIZAR COTIZACIONES
function UpdateCotizacion(codcotizacion,proceso) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Actualizar esta Cotización de Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Actualizar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forcotizacion?codcotizacion="+codcotizacion+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

// FUNCION PARA CALCULAR DETALLES COTIZACIONES EN ACTUALIZAR
function ProcesarCalculoCotizacion(indice){
    var cantidad = $('#cantcotizacion_'+indice).val();
    var precioventa = $('#precioventa_'+indice).val();
    var preciocompra = $('#preciocompra_'+indice).val();
    var neto = $('#valorneto_'+indice).val();
    var descproducto = $('#descproducto_'+indice).val();
    var ivaproducto = $('#ivaproducto_'+indice).val();
    var ivg = $('#iva').val();
    var desc = $('#descuento').val();
    var ValorNeto = 0;

    if (cantidad == "" || cantidad == "0" || cantidad == "0.00") {

        $("#cantcotizacion_"+indice).focus();
        $("#cantcotizacion_"+indice).css('border-color', '#f0ad4e');
        swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA!", "error");
        return false;
    }
    //REALIZAMOS LA MULTIPLICACION DE PRECIO VENTA * CANTIDAD
    var ValorTotal = parseFloat(cantidad) * parseFloat(precioventa);

    //REALIZAMOS LA MULTIPLICACION DE PRECIO COMPRA * CANTIDAD
    var ValorTotal2 = parseFloat(cantidad) * parseFloat(preciocompra);

    //CALCULO DEL TOTAL DEL DESCUENTO %
    var Descuento = ValorTotal * descproducto / 100;
    var ValorNeto = parseFloat(ValorTotal) - parseFloat(Descuento);

    //CALCULO DEL TOTAL PARA COMPRA

    //CALCULO VALOR TOTAL
    $("#valortotal_"+indice).val(ValorTotal.toFixed(2));
    $("#txtvalortotal_"+indice).text(ValorTotal.toFixed(2));

    //CALCULO TOTAL DESCUENTO
    $("#totaldescuentov_"+indice).val(Descuento.toFixed(2));
    $("#txtdescproducto_"+indice).text(Descuento.toFixed(2));

    //CALCULO VALOR NETO
    $("#valorneto_"+indice).val(ValorNeto.toFixed(2));
    $("#txtvalorneto_"+indice).text(ValorNeto.toFixed(2));

    //CALCULO VALOR NETO 2
    $("#valorneto2_"+indice).val(ValorTotal2.toFixed(2));

    //CALCULO SUBTOTAL IVA SI
    $("#subtotalivasi_"+indice).val(ivaproducto == "SI" ? ValorNeto.toFixed(2) : "0.00");
    //CALCULO SUBTOTAL IVA NO
    $("#subtotalivano_"+indice).val(ivaproducto == "NO" ? ValorNeto.toFixed(2) : "0.00");

    //CALCULO DE VALOR NETO PARA COMPRAS
    var NetoCompra=0;
    $('.valorneto2').each(function() {  
    NetoCompra += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    });  

    //CALCULO DE SUBTOTAL CON IVA
    var BaseImpIva1=0;
    $('.subtotalivasi').each(function() {  
    BaseImpIva1 += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#txtsubtotal').val(BaseImpIva1.toFixed(2));
    $('#lblsubtotal').text(BaseImpIva1.toFixed(2));

    //CALCULO DE SUBTOTAL SIN IVA
    var BaseImpIva2=0;
    $('.subtotalivano').each(function() {  
    BaseImpIva2 += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#txtsubtotal2').val(BaseImpIva2.toFixed(2));
    $('#lblsubtotal2').text(BaseImpIva2.toFixed(2));

    //CALCULO DE TOTAL IVA
    var TotalIva = BaseImpIva1 * ivg / 100;
    $('#txtIva').val(TotalIva.toFixed(2));
    $('#lbliva').text(TotalIva.toFixed(2));

    //CALCULO DE TOTAL DESCONTADO
    var TotalDescontado=0;
    $('.totaldescuentov').each(function() {  
    TotalDescontado += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    });
    $('#txtdescontado').val(TotalDescontado.toFixed(2));
    $('#lbldescontado').text(TotalDescontado.toFixed(2)); 

    //CALCULAMOS DESCUENTO POR PRODUCTO
    desc2  = desc/100;

    //CALCULO DEL TOTAL DE FACTURA
    var Total = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2) + parseFloat(TotalIva);
    SubTotal = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2);
    TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
    TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));

    $('#txtTotal').val(TotalFactura.toFixed(2));
    $('#txtTotalCompra').val(NetoCompra.toFixed(2));
    $('#lbltotal').text(TotalFactura.toFixed(2));
}

// FUNCION PARA AGREGAR DETALLES A COTIZACIONES
function AgregaDetalleCotizacion(codcotizacion,proceso) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Agregar Detalles de Productos a esta Cotización?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Continuar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forcotizacion?codcotizacion="+codcotizacion+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}


/////FUNCION PARA ELIMINAR DETALLES DE COTIZACIONES EN VENTANA MODAL
function EliminarDetallesCotizacionModal(coddetallecotizacion,codcotizacion,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Cotización?", 
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
                  data: "coddetallecotizacion="+coddetallecotizacion+"&codcotizacion="+codcotizacion+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#muestracotizacionmodal').load("funciones.php?BuscaCotizacionModal=si&codcotizacion="+codcotizacionl); 
            $('#cotizaciones').load("consultas.php?CargaCotizaciones=si");    
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Cotizaciones en este Módulo, realice la Eliminación completa de la Cotización!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Cotizaciones, no eres el Administrador!", "error"); 

                }
            }
        })
    });
}


/////FUNCION PARA ELIMINAR DETALLES DE COTIZACIONES EN ACTUALIZAR
function EliminarDetallesCotizacionesUpdate(coddetallecotizacion,codcotizacion,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Cotización?", 
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
                  data: "coddetallecotizacion="+coddetallecotizacion+"&codcotizacion="+codcotizacion+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#detallescotizacionesupdate').load("funciones.php?MuestraDetallesCotizacionesUpdate=si&codcotizacion="+codcotizacion); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Cotizaciones en este Módulo, realice la Eliminación completa de la Cotización!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Cotizaciones, no eres el Administrador!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR DETALLES DE COTIZACIONES EN AGREGAR
function EliminarDetallesCotizacionesAgregar(coddetallecotizacion,codcotizacion,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Cotización?", 
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
                  data: "coddetallecotizacion="+coddetallecotizacion+"&codcotizacion="+codcotizacion+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#detallescotizacionesagregar').load("funciones.php?MuestraDetallesCotizacionesAgregar=si&codcotizacion="+codcotizacion); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Cotizaciones en este Módulo, realice la Eliminación completa de la Cotización!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Cotizaciones, no eres el Administrador!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR COTIZACIONES 
function EliminarCotizacion(codcotizacion,criterio,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Cotización?", 
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
                  data: "codcotizacion="+codcotizacion+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#muestracotizaciones').load("search.php?CargaCotizaciones=si&bcotizaciones="+criterio);
                  
          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Cotizaciones de Productos, no eres el Administrador!", "error"); 

                }
            }
        })
    });
}


// FUNCION PARA BUSQUEDA DE COTIZACIONES POR FECHAS
function BuscarCotizacionesxFechas(){
                        
$('#muestracotizacionesxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#cotizacionesxfechas").serialize();
var url = 'funciones.php?BuscaCotizacionesxFechas=si';


$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestracotizacionesxfechas').empty();
                $('#muestracotizacionesxfechas').append(''+response+'').fadeIn("slow");
             }
      });
}

// FUNCION PARA BUSQUEDA DE PRODUCTOS COTIZADOS
function BuscaProductosCotizados(){
    
$('#muestraproductoscotizados').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#productoscotizados").serialize();
var url = 'funciones.php?BuscaProductoCotizados=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestraproductoscotizados').empty();
                $('#muestraproductoscotizados').append(''+response+'').fadeIn("slow");
            }
      }); 
}

// FUNCION PARA BUSQUEDA DE PRODUCTOS COTIZADOS POR VENDEDOR
function BuscaCotizacionesxVendedor(){
    
$('#muestracotizacionesxvendedor').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codigo = $("#codigo").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#cotizacionesxvendedor").serialize();
var url = 'funciones.php?BuscaCotizacionesxVendedor=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestracotizacionesxvendedor').empty();
                $('#muestracotizacionesxvendedor').append(''+response+'').fadeIn("slow");
            }
      }); 
}
















/////////////////////////////////// FUNCIONES DE CAJAS DE VENTAS //////////////////////////////////////

// FUNCION PARA MOSTRAR CAJAS DE VENTAS EN VENTANA MODAL
function VerCaja(codcaja){

$('#muestracajamodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaCajaModal=si&codcaja='+codcaja;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestracajamodal').empty();
                $('#muestracajamodal').append(''+response+'').fadeIn("slow");
                
            }
      });
}

// FUNCION PARA ACTUALIZAR CAJAS DE VENTAS
function UpdateCaja(codcaja,nrocaja,nomcaja,codigo,proceso) 
{
  // aqui asigno cada valor a los campos correspondientes
  $("#savecaja #codcaja").val(codcaja);
  $("#savecaja #nrocaja").val(nrocaja);
  $("#savecaja #nomcaja").val(nomcaja);
  $("#savecaja #codigo").val(codigo);
  $("#savecaja #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR CAJAS DE VENTAS 
function EliminarCaja(codcaja,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta CAJA?", 
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
                  data: "codcaja="+codcaja+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#cajas').load("consultas?CargaCajas=si");
                  
          } else if(data==2){ 

             swal("Oops", "Esta Caja para Venta no puede ser Eliminada, tiene Ventas relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Cajas, no eres el Administrador!", "error"); 

                }
            }
        })
    });
}
















/////////////////////////////////// FUNCIONES DE ARQUEOS DE Cajas //////////////////////////////////////

// FUNCION PARA MOSTRAR ARQUEO DE CAJA EN VENTANA MODAL
function VerArqueo(codarqueo){

$('#muestraarqueomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaArqueoModal=si&codarqueo='+codarqueo;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestraarqueomodal').empty();
                $('#muestraarqueomodal').append(''+response+'').fadeIn("slow");
                
            }
      });
}

// FUNCION PARA CERRAR ARQUEO DE CAJA
function CerrarCaja(codarqueo) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Realizar el Cierre de Caja?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Continuar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forcierre?codarqueo="+codarqueo;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

//FUNCION PARA CALCULAR LA DIFERENCIA EN CIERRE DE CAJA
$(document).ready(function (){
  $('.cierrecaja').keyup(function (){
      
    var efectivo = $('input#dineroefectivo').val();
    var estimado = $('input#estimado').val();
            
    //REALIZO EL CALCULO Y MUESTRO LA DEVOLUCION
    total=efectivo - estimado;
    var original=parseFloat(total.toFixed(2));
    $("#diferencia").val((efectivo == "" || efectivo == "0" || efectivo == "0.00") ? "0.00" : original.toFixed(2));
    //$("#diferencia").val(original.toFixed(2));
      
  });
});

//FUNCION PARA BUSQUEDA DE ARQUEOS DE CAJAS POR FECHAS PARA REPORTES
function BuscarArqueosxFechas(){
                  
$('#muestraarqueosxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codcaja = $("#codcaja").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#arqueosxfechas").serialize();
var url = 'funciones.php?BuscaArqueosxFechas=si';

$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestraarqueosxfechas').empty();
                $('#muestraarqueosxfechas').append(''+response+'').fadeIn("slow");
                
               }
      }); 
}

















/////////////////////////////////// FUNCIONES DE MOVIMIENTOS EN CAJAS DE VENTAS //////////////////////////////////////

// FUNCION PARA MOSTRAR MOVIMIENTO EN CAJAS DE VENTAS EN VENTANA MODAL
function VerMovimiento(codmovimiento){

$('#muestramovimientomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaMovimientoModal=si&codmovimiento='+codmovimiento;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestramovimientomodal').empty();
                $('#muestramovimientomodal').append(''+response+'').fadeIn("slow");
                
            }
      });
}

// FUNCION PARA ACTUALIZAR MOVIMIENTOS EN CAJAS DE VENTAS
function UpdateMovimiento(codmovimiento,codcaja,tipomovimiento,descripcionmovimiento,montomovimiento,mediomovimiento,fechamovimiento,codarqueo,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savemovimiento #codmovimiento").val(codmovimiento);
  $("#savemovimiento #codcaja").val(codcaja);
  $("#savemovimiento #tipomovimiento").val(tipomovimiento);
  $("#savemovimiento #tipomovimientobd").val(tipomovimiento);
  $("#savemovimiento #descripcionmovimiento").val(descripcionmovimiento);
  $("#savemovimiento #montomovimiento").val(montomovimiento);
  $("#savemovimiento #montomovimientobd").val(montomovimiento);
  $("#savemovimiento #mediomovimiento").val(mediomovimiento);
  $("#savemovimiento #mediomovimientobd").val(mediomovimiento);
  $("#savemovimiento #fecharegistro").val(fechamovimiento);
  $("#savemovimiento #codarqueo").val(codarqueo);
  $("#savemovimiento #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR MOVIMIENTOS EN CAJAS DE VENTAS 
function EliminarMovimiento(codmovimiento,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Movimiento en CAJA?", 
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
                  data: "codmovimiento="+codmovimiento+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#movimientos').load("consultas?CargaMovimientos=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Movimiento en Caja no puede ser Eliminado, el Arqueo de Caja asociado se encuentra Cerrado!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Movimiento en Cajas, no eres el Administrador o Cajero del Sistema!", "error"); 

                }
            }
        })
    });
}

//FUNCION PARA BUSQUEDA DE MOVIMIENTOS DE CAJAS POR FECHAS PARA REPORTES
function BuscarMovimientosxFechas(){
                  
$('#muestramovimientosxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codcaja = $("#codcaja").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#movimientosxfechas").serialize();
var url = 'funciones.php?BuscaMovimientosxFechas=si';

$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestramovimientosxfechas').empty();
                $('#muestramovimientosxfechas').append(''+response+'').fadeIn("slow");
                
               }
      }); 
}

























/////////////////////////////////// FUNCIONES DE VENTAS //////////////////////////////////////

////FUNCION MENSAJE FACTURA ANULADA
function MsjAnulado(){
  
  swal("Mensaje!", "Esta Factura se encuentra Anulada, verifique en las Notas de Crédito por favor!", "danger");
}

////FUNCION MUESTRA BOTON MESAS
function MostrarMesas(){
  
  $('#loading').load("salas_mesas?CargaMesas=si");
}

////FUNCION MUESTRA BOTON PRODUCTOS
function MostrarProductos(){
  
  $('#loading').load("salas_mesas?CargaProductos=si");
}

////FUNCION MUESTRA BOTON COMBOS
function MostrarCombos(){
  
  $('#loading').load("salas_mesas?CargaCombos=si");
}

////FUNCION MUESTRA BOTON EXTRAS
function MostrarExtras(){
  
  $('#loading').load("salas_mesas?CargaExtras=si");
}

////FUNCION RECARGAR COMANDA
function RecargaComanda(proceso){

  $("#all-todo").addClass("active");
  $("#all-category").removeClass("active");
  $("#note-business").removeClass("active");
  $("#note-social").removeClass("active");
  $('#mostrador').html("");
  $('#mostrador').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
  setTimeout(function() {
  $('#mostrador').load("consultas?CargaMostrador=si&proceso="+proceso);
  }, 1000);
}

////FUNCION MUESTRA COMANDA POR SELECCION
function MuestraComanda(proceso){

  $('#mostrador').html("");
  $('#mostrador').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
  setTimeout(function() {
  $('#mostrador').load("consultas?CargaMostrador=si&proceso="+proceso);
  }, 1000);
}


/////FUNCION PARA ENTREGAR PEDIDOS DE MOSTRADOR
function EntregarPedidos(codpedido,pedido,codventa,delivery,proceso,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Realizar la Entrega de este Pedido?", 
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
                  data: "codpedido="+codpedido+"&pedido="+pedido+"&codventa="+codventa+"&delivery="+delivery+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Entregado!", "El Pedido en Mesa fue entregado Exitosamente!", "success");
            $('#mostrador').load("consultas.php?CargaMostrador=si&proceso="+proceso);    
          
          } else if(data==2){

            swal("Entregado!", "El Pedido de Delivery fue entregado Exitosamente!", "success");
            $('#mostrador').load("consultas.php?CargaMostrador=si&proceso="+proceso);  

             }
          }
        })
    });
}


////FUNCION RECARGAR DELIVERY
function RecargaDelivery(proceso){

  $("#all-todo").addClass("active");
  $("#note-social").removeClass("active");
  $('#delivery').html("");
  $('#delivery').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
  setTimeout(function() {
  $('#delivery').load("consultas?CargaDelivery=si&proceso="+proceso);
  }, 1000);
}

////FUNCION MUESTRA DELIVERY POR SELECCION
function MuestraDelivery(proceso){

  $('#delivery').html("");
  $('#delivery').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
  setTimeout(function() {
  $('#delivery').load("consultas?CargaDelivery=si&proceso="+proceso);
  }, 1000);
}


/////FUNCION PARA ENTREGAR PEDIDOS DE DELIVERY
function EntregarDelivery(codpedido,pedido,codventa,delivery,proceso,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Realizar la Entrega de este Pedido al Cliente?", 
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
                  data: "codpedido="+codpedido+"&pedido="+pedido+"&codventa="+codventa+"&delivery="+delivery+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Entregado!", "El Pedido fue entregado al Cliente Exitosamente!", "success");
            $('#delivery').load("consultas.php?CargaDelivery=si&proceso="+proceso); 
          
            }
          }
        })
    });
}


////FUNCION RECARGAR PEDIDOS EN VENTANA MODAL
function RecargaPedidos(proceso){

  $('#detallescocina').html("");
  $('#detallescocina').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
  setTimeout(function() {
  $('#detallescocina').load("consultas?CargaDetallesPedidos=si&proceso="+proceso);
  }, 100);
}


////FUNCION MENSAJE MESA DISPONIBLE
function MesaDisponible() {

  swal("Mesa Disponible?", "No existen cuentas pendientes por cobrar en la Mesa seleccionada!", "success");

}

////FUNCION MENSAJE MESA OCUPADA
function MesaOcupada() {

  swal("Mesa Ocupada?", "La Mesa seleccionada se encuentra Ocupada actualmente, aún no puede ser procesado el Cobro de la misma!", "info");

}

// FUNCION PARA BUSCAR VENTAS
function BuscarVentas(){
                        
$('#muestraventas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var search = $("#bventas").val();
var dataString = $("#busquedaventas").serialize();
var url = 'search.php?CargaVentas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
      success: function(response) {            
        $('#muestraventas').empty();
        $('#muestraventas').append(''+response+'').fadeIn("slow");
      }
  });
}

// FUNCION PARA MOSTRAR VENTAS EN VENTANA MODAL
function VerVenta(codventa){

$('#muestraventamodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaVentaModal=si&codventa='+codventa;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestraventamodal').empty();
                $('#muestraventamodal').append(''+response+'').fadeIn("slow");
                
            }
      });
}

// FUNCION PARA ACTUALIZAR VENTAS
function UpdateVenta(codventa,proceso) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Actualizar esta Venta de Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Actualizar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forventa?codventa="+codventa+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}


// FUNCION PARA CALCULAR DETALLES VENTAS EN ACTUALIZAR
function ProcesarCalculoVenta(indice){
    var cantidad = $('#cantventa_'+indice).val();
    var precioventa = $('#precioventa_'+indice).val();
    var preciocompra = $('#preciocompra_'+indice).val();
    var neto = $('#valorneto_'+indice).val();
    var descproducto = $('#descproducto_'+indice).val();
    var ivaproducto = $('#ivaproducto_'+indice).val();
    var ivg = $('#iva').val();
    var desc = $('#descuento').val();
    var ValorNeto = 0;

    if (cantidad == "" || cantidad == "0" || cantidad == "0.00") {

        $("#cantventa_"+indice).focus();
        $("#cantventa_"+indice).css('border-color', '#f0ad4e');
        swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA!", "error");
        return false;
    }
    //REALIZAMOS LA MULTIPLICACION DE PRECIO VENTA * CANTIDAD
    var ValorTotal = parseFloat(cantidad) * parseFloat(precioventa);

    //REALIZAMOS LA MULTIPLICACION DE PRECIO COMPRA * CANTIDAD
    var ValorTotal2 = parseFloat(cantidad) * parseFloat(preciocompra);

    //CALCULO DEL TOTAL DEL DESCUENTO %
    var Descuento = ValorTotal * descproducto / 100;
    var ValorNeto = parseFloat(ValorTotal) - parseFloat(Descuento);

    //CALCULO DEL TOTAL PARA COMPRA

    //CALCULO VALOR TOTAL
    $("#valortotal_"+indice).val(ValorTotal.toFixed(2));
    $("#txtvalortotal_"+indice).text(ValorTotal.toFixed(2));

    //CALCULO TOTAL DESCUENTO
    $("#totaldescuentov_"+indice).val(Descuento.toFixed(2));
    $("#txtdescproducto_"+indice).text(Descuento.toFixed(2));

    //CALCULO VALOR NETO
    $("#valorneto_"+indice).val(ValorNeto.toFixed(2));
    $("#txtvalorneto_"+indice).text(ValorNeto.toFixed(2));

    //CALCULO VALOR NETO 2
    $("#valorneto2_"+indice).val(ValorTotal2.toFixed(2));

    //CALCULO SUBTOTAL IVA SI
    $("#subtotalivasi_"+indice).val(ivaproducto == "SI" ? ValorNeto.toFixed(2) : "0.00");
    //CALCULO SUBTOTAL IVA NO
    $("#subtotalivano_"+indice).val(ivaproducto == "NO" ? ValorNeto.toFixed(2) : "0.00");

    //CALCULO DE VALOR NETO PARA COMPRAS
    var NetoCompra=0;
    $('.valorneto2').each(function() {  
    NetoCompra += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    });  

    //CALCULO DE SUBTOTAL CON IVA
    var BaseImpIva1=0;
    $('.subtotalivasi').each(function() {  
    BaseImpIva1 += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#txtsubtotal').val(BaseImpIva1.toFixed(2));
    $('#lblsubtotal').text(BaseImpIva1.toFixed(2));

    //CALCULO DE SUBTOTAL SIN IVA
    var BaseImpIva2=0;
    $('.subtotalivano').each(function() {  
    BaseImpIva2 += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#txtsubtotal2').val(BaseImpIva2.toFixed(2));
    $('#lblsubtotal2').text(BaseImpIva2.toFixed(2));

    //CALCULO DE TOTAL IVA
    var TotalIva = BaseImpIva1 * ivg / 100;
    $('#txtIva').val(TotalIva.toFixed(2));
    $('#lbliva').text(TotalIva.toFixed(2));

    //CALCULO DE TOTAL DESCONTADO
    var TotalDescontado=0;
    $('.totaldescuentov').each(function() {  
    TotalDescontado += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    });
    $('#txtdescontado').val(TotalDescontado.toFixed(2));
    $('#lbldescontado').text(TotalDescontado.toFixed(2)); 

    //CALCULAMOS DESCUENTO POR PRODUCTO
    desc2  = desc/100;

    //CALCULO DEL TOTAL DE FACTURA
    var Total = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2) + parseFloat(TotalIva);
    SubTotal = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2);
    TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
    TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));

    $('#txtTotal').val(TotalFactura.toFixed(2));
    $('#txtTotal2').val(TotalFactura.toFixed(2));
    $('#txtTotalCompra').val(NetoCompra.toFixed(2));
    $('#lbltotal').text(TotalFactura.toFixed(2));
}


// FUNCION PARA AGREGAR DETALLES A VENTAS
function AgregaDetalleVenta(codventa,proceso) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Agregar Detalles de Productos a esta Venta?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Continuar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forventa?codventa="+codventa+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}


/////FUNCION PARA ELIMINAR DETALLES DE VENTAS EN VENTANA MODAL
function EliminarDetallesVentaModal(coddetalleventa,codventa,codcliente,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Venta?", 
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
                  data: "coddetalleventa="+coddetalleventa+"&codventa="+codventa+"&codcliente="+codcliente+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#muestraventamodal').load("funciones.php?BuscaVentaModal=si&codventa="+codventa); 
            //hace la búsqueda
            $.ajax({
              type: "POST",
              url: "search.php?CargaVentas=si",
              data: "b="+$("#bventas").val(),
              dataType: "html",
              success: function(data){                                                    
                $("#ventas").empty();
                $("#ventas").append(data);
              }
            });
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Ventas en este Módulo, realice la Eliminación completa de la Venta!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Ventas, no eres el Administrador!", "error"); 

                }
            }
        })
    });
}


/////FUNCION PARA ELIMINAR DETALLES DE VENTAS EN ACTUALIZAR
function EliminarDetallesVentaUpdate(coddetalleventa,codventa,codcliente,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Venta?", 
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
                  data: "coddetalleventa="+coddetalleventa+"&codventa="+codventa+"&codcliente="+codcliente+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#detallesventasupdate').load("funciones.php?MuestraDetallesVentasUpdate=si&codventa="+codventa); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Ventas en este Módulo, realice la Eliminación completa de la Venta!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Ventas, no eres el Administrador!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR DETALLES DE VENTAS EN AGREGAR
function EliminarDetallesVentaAgregar(coddetalleventa,codventa,codcliente,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Venta?", 
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
                  data: "coddetalleventa="+coddetalleventa+"&codventa="+codventa+"&codcliente="+codcliente+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#detallesventasagregar').load("funciones.php?MuestraDetallesVentasAgregar=si&codventa="+codventa); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Ventas en este Módulo, realice la Eliminación completa de la Venta!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Ventas, no eres el Administrador!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR VENTAS 
function EliminarVenta(codventa,codcliente,criterio,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Venta?", 
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
                  data: "codventa="+codventa+"&codcliente="+codcliente+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Datos eliminados con éxito!", "success");
            $('#muestraventas').load("search.php?CargaVentas=si&bventas="+criterio);
                  
          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Ventas de Productos, no eres el Administrador!", "error"); 

                }
            }
        })
    });
}


//FUNCION PARA BUSQUEDA DE VENTAS POR CAJAS Y FECHAS
function BuscarVentasxCajas(){
                  
$('#muestraventasxcajas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codcaja = $("#codcaja").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#ventasxcajas").serialize();
var url = 'funciones.php?BuscaVentasxCajas=si';

$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestraventasxcajas').empty();
                $('#muestraventasxcajas').append(''+response+'').fadeIn("slow");
                
               }
      }); 
}

// FUNCION PARA BUSQUEDA DE VENTAS POR FECHAS
function BuscarVentasxFechas(){
                        
$('#muestraventasxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#ventasxfechas").serialize();
var url = 'funciones.php?BuscaVentasxFechas=si';

$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestraventasxfechas').empty();
                $('#muestraventasxfechas').append(''+response+'').fadeIn("slow");
                
             }
      });
}


//FUNCION PARA BUSQUEDA DE VENTAS POR CONDICION DE PAGO Y FECHAS
function BuscarVentasxCondiciones(){
                  
$('#muestraventasxcondiciones').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var formapago = $("select#formapago").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#ventasxcondiciones").serialize();
var url = 'funciones.php?BuscaVentasxCondiciones=si';

$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestraventasxcondiciones').empty();
                $('#muestraventasxcondiciones').append(''+response+'').fadeIn("slow");
                
               }
      }); 
}


//FUNCION PARA BUSQUEDA DE VENTAS POR TIPOS DE CLIENTES Y FECHAS
function BuscarVentasxTipos(){
                  
$('#muestraventasxtipos').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var tipocliente = $("select#tipocliente").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#ventasxtipos").serialize();
var url = 'funciones.php?BuscaVentasxTipos=si';

$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestraventasxtipos').empty();
                $('#muestraventasxtipos').append(''+response+'').fadeIn("slow");
                
               }
      }); 
}


//FUNCION PARA BUSQUEDA DE VENTAS POR CLIENTES Y FECHAS
function BuscarVentasxClientes(){
                  
$('#muestraventasxclientes').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codcliente = $("input#codcliente").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#ventasxclientes").serialize();
var url = 'funciones.php?BuscaVentasxClientes=si';

$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestraventasxclientes').empty();
                $('#muestraventasxclientes').append(''+response+'').fadeIn("slow");
                
               }
      }); 
}


// FUNCION PARA BUSQUEDA DE COMISION POR DELIVERY
function BuscaDeliveryxFechas(){
    
$('#muestradeliveryxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codigo = $("#codigo").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#deliveryxfechas").serialize();
var url = 'funciones.php?BuscaDeliveryxFechas=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestradeliveryxfechas').empty();
                $('#muestradeliveryxfechas').append(''+response+'').fadeIn("slow");
            }
      }); 
}

// FUNCION PARA BUSQUEDA DE COMISION POR VENDEDOR
function BuscaComisionxVentas(){
    
$('#muestracomisionxventas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codigo = $("#codigo").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#comisionxventas").serialize();
var url = 'funciones.php?BuscaComisionxVentas=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestracomisionxventas').empty();
                $('#muestracomisionxventas').append(''+response+'').fadeIn("slow");
            }
      }); 
}












/////////////////////////////////// FUNCIONES DE CREDITOS //////////////////////////////////////

// FUNCION PARA MOSTRAR VENTA DE CREDITO EN VENTANA MODAL
function VerCredito(codventa){

$('#muestracreditomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaCreditoModal=si&codventa='+codventa;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestracreditomodal').empty();
                $('#muestracreditomodal').append(''+response+'').fadeIn("slow");
                
            }
      });
}

// FUNCION PARA ABONAR PAGO A CREDITOS
function AbonoCredito(codcliente,codventa,totaldebe,dnicliente,nomcliente,codfactura,totalfactura,fechaventa,totalabono,debe) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savepago #codcliente").val(codcliente);
  $("#savepago #codventa").val(codventa);
  $("#savepago #totaldebe").val(totaldebe);
  $("#savepago #dnicliente").val(dnicliente);
  $("#savepago #nomcliente").val(nomcliente);
  $("#savepago #codfactura").val(codfactura);
  $("#savepago #totalfactura").val(totalfactura);
  $("#savepago #fechaventa").val(fechaventa);
  $("#savepago #abono").val(totalabono);
  $("#savepago #totalabono").val(totalabono);
  $("#savepago #debe").val(debe);
}

//FUNCION PARA BUSQUEDA DE CREDITOS POR CLIENTES Y FECHAS
function BuscarCreditosxClientes(){
                  
$('#muestracreditosxclientes').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codcliente = $("#codcliente").val();
var dataString = $("#creditosxclientes").serialize();
var url = 'funciones.php?BuscaCreditosxClientes=si';

$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestracreditosxclientes').empty();
                $('#muestracreditosxclientes').append(''+response+'').fadeIn("slow");
                
               }
      }); 
}

// FUNCION PARA BUSQUEDA DE CREDITOS POR FECHAS
function BuscarCreditosxFechas(){
                        
$('#muestracreditosxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#creditosxfechas").serialize();
var url = 'funciones.php?BuscaCreditosxFechas=si';

$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestracreditosxfechas').empty();
                $('#muestracreditosxfechas').append(''+response+'').fadeIn("slow");
                
             }
      });
}


























/////////////////////////////////// FUNCIONES DE NOTAS DE CREDITO //////////////////////////////////////

// FUNCION PARA BUSQUEDA DE FACTURA PARA NOTA DE CREDITO
function BuscarFactura(){
                        
$('#muestrafactura').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var numeroventa = $("input#numeroventa").val();
var status = $('input:radio[name=descontar]:checked').val();
var codarqueo = $("input#codarqueo").val();
var dataString = $("#savenota").serialize();
var url = 'funciones.php?ProcesaNotaCredito=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function(response) {            
      $('#muestrafactura').empty();
      $('#muestrafactura').append(''+response+'').fadeIn("slow");
    }
  });
}

//FUNCIONES PARA VERIFICAR NOTA CREDITO
function VerificaDescuentoCaja(){

    var status = $('input:radio[name=descontar]:checked').val();

    if (status == 1 || status == true) {
         
      //deshabilitamos
      $("#codarqueo").attr('disabled', false);

    } else {

      // habilitamos
      $("#codarqueo").attr('disabled', true);

    }
}

// FUNCION PARA CALCULAR DETALLES VENTAS PARA NOTA DE CREDITO
function ProcesarCalculoDevolucion(indice){

    var devuelto = $('#devuelto_'+indice).val();
    var cantidad = $('#cantidad_'+indice).val();
    var preciocompra = $('#preciocompra_'+indice).val();
    var precioventa = $('#precioventa_'+indice).val();
    var valortotal = $('#valortotal_'+indice).val();
    var neto = $('#valorneto_'+indice).val();
    var descproducto = $('#descproducto_'+indice).val();
    var ivaproducto = $('#ivaproducto_'+indice).val();
    var ivg = $('#iva').val();
    var desc = $('#descuento').val();
    var ValorNeto = 0;

    if (devuelto > cantidad) {

        $("#devuelto_"+indice).val("0");
        $("#devuelto_"+indice).focus();
        $("#devuelto").css('border-color', '#f0ad4e');
        swal("Oops", "LA DEVOLUCIÓN NO PUEDE SER MAYOR QUE LA CANTIDAD!", "error");
        return false;
    }

    //REALIZAMOS LA MULTIPLICACION DE PRECIO VENTA * CANTIDAD
    var ValorTotal = parseFloat(devuelto) * parseFloat(precioventa);

    //CALCULO DEL TOTAL DEL DESCUENTO %
    var Descuento = ValorTotal * descproducto / 100;
    var ValorNeto = parseFloat(ValorTotal) - parseFloat(Descuento);

    //CALCULO VALOR TOTAL
    $("#valortotal_"+indice).val(ValorTotal.toFixed(2));
    $("#txtvalortotal_"+indice).text(ValorTotal.toFixed(2));

    //CALCULO TOTAL DESCUENTO
    $("#totaldescuentov_"+indice).val(Descuento.toFixed(2));
    $("#txtdescproducto_"+indice).text(Descuento.toFixed(2));

    //CALCULO VALOR NETO
    $("#valorneto_"+indice).val(ValorNeto.toFixed(2));
    $("#txtvalorneto_"+indice).text(ValorNeto.toFixed(2));

    //CALCULO SUBTOTAL IVA SI
    $("#subtotalivasi_"+indice).val(ivaproducto == "SI" ? ValorNeto.toFixed(2) : "0.00");
    //CALCULO SUBTOTAL IVA NO
    $("#subtotalivano_"+indice).val(ivaproducto == "NO" ? ValorNeto.toFixed(2) : "0.00"); 

    //CALCULO DE SUBTOTAL CON IVA
    var BaseImpIva1=0;
    $('.subtotalivasi').each(function() {  
    BaseImpIva1 += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#txtsubtotal').val(BaseImpIva1.toFixed(2));
    $('#lblsubtotal').text(BaseImpIva1.toFixed(2));

    //CALCULO DE SUBTOTAL SIN IVA
    var BaseImpIva2=0;
    $('.subtotalivano').each(function() {  
    BaseImpIva2 += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#txtsubtotal2').val(BaseImpIva2.toFixed(2));
    $('#lblsubtotal2').text(BaseImpIva2.toFixed(2));

    //CALCULO DE TOTAL IVA
    var TotalIva = BaseImpIva1 * ivg / 100;
    $('#txtIva').val(TotalIva.toFixed(2));
    $('#lbliva').text(TotalIva.toFixed(2));

    //CALCULO DE TOTAL DESCONTADO
    var TotalDescontado=0;
    $('.totaldescuentov').each(function() {  
    TotalDescontado += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    });
    $('#txtdescontado').val(TotalDescontado.toFixed(2));
    $('#lbldescontado').text(TotalDescontado.toFixed(2)); 

    //CALCULAMOS DESCUENTO POR PRODUCTO
    desc2  = desc/100;

    //CALCULO DEL TOTAL DE FACTURA
    var Total = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2) + parseFloat(TotalIva);
    TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
    TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));

    $('#txtTotal').val(TotalFactura.toFixed(2));
    $('#lbltotal').text(TotalFactura.toFixed(2));

}

// FUNCION PARA MOSTRAR NOTA DE CREDITO EN VENTANA MODAL
function VerNota(codnota){

$('#muestranotamodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaNotaCreditoModal=si&codnota='+codnota;

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
    success: function(response) {            
      $('#muestranotamodal').empty();
      $('#muestranotamodal').append(''+response+'').fadeIn("slow");
    }
  });
}

// FUNCION PARA BUSQUEDA DE NOTAS POR CAJAS
function BuscarNotasxCajas(){
                        
$('#muestranotasxcajas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codcaja = $("#codcaja").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#notasxcajas").serialize();
var url = 'funciones.php?BuscaNotasxCajas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function(response) {            
      $('#muestranotasxcajas').empty();
      $('#muestranotasxcajas').append(''+response+'').fadeIn("slow");  
    }
  });
}

// FUNCION PARA BUSQUEDA DE NOTAS POR FECHAS
function BuscarNotasxFechas(){
                        
$('#muestranotasxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#notasxfechas").serialize();
var url = 'funciones.php?BuscaNotasxFechas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function(response) {            
      $('#muestranotasxfechas').empty();
      $('#muestranotasxfechas').append(''+response+'').fadeIn("slow");  
    }
  });
}


// FUNCION PARA BUSQUEDA DE NOTAS POR CLIENTE
function BuscarNotasxClientes(){
                        
$('#muestranotasxclientes').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var codcliente = $("input#codcliente").val();
var dataString = $("#notasxclientes").serialize();
var url = 'funciones.php?BuscaNotasxClientes=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function(response) {            
      $('#muestranotasxclientes').empty();
      $('#muestranotasxclientes').append(''+response+'').fadeIn("slow");
    }
  });
}