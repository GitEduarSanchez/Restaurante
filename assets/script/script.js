/*Author: Ing. Ruben D. Chirinos R. Tlf: +58 0414-7225970, email: elsaiya@gmail.com

/* FUNCION JQUERY PARA VALIDAR ACCESO DE USUARIOS*/
$('document').ready(function() {
						   
	    $("#formlogin").validate({
        rules:
	    {
			usuario: { required: true, },
			password: { required: true, },
	    },
        messages:
	    {
		    usuario:{ required: "Ingrese Usuario de Acceso" },
			password:{ required: "Ingrese Clave de Acceso" },
        },
	    submitHandler: function(form) {
                     		
			var data = $("#formlogin").serialize();
				
			$.ajax({
			type : 'POST',
			url  : 'index.php',
			async : false,
			data : data,
			beforeSend: function()
			{	
				$("#login").fadeOut();
				
				 var n = noty({
                 text: "<span class='fa fa-refresh'></span> VERIFICANDO INFORMACI&Oacute;N, POR FAVOR ESPERE......",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 1000, });
                 $("#submit_login").html('<button type="button" class="btn btn-outline-warning btn-lg btn-block waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="Haga clic aquí para iniciar sesión"><span class="fa fa-sign-in"></span> Acceder</button>');
			},
			success :  function(response)
			   {						
					if(response==1){ 
								 
						   $("#login").fadeIn(1000, function(){ 
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000, });
                 $("#submit_login").html('<button type="submit" name="btn-login" id="btn-login" class="btn btn-outline-warning btn-lg btn-block waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="Haga clic aquí para iniciar sesión"><span class="fa fa-sign-in"></span> Acceder</button>');
				    
					                });
			   
	                } else if(response==2){
									 
							$("#login").fadeIn(1000, function(){
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> EL USUARIO INGRESADO NO EXISTE, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000, });
                 $("#submit_login").html('<button type="submit" name="btn-login" id="btn-login" class="btn btn-outline-warning btn-lg btn-block waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="Haga clic aquí para iniciar sesión"><span class="fa fa-sign-in"></span> Acceder</button>');
				 
				                    }); 
			   
					} else if(response==3){
									 
						    $("#login").fadeIn(1000, function(){
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ESTE USUARIO SE ENCUENTRA ACTUALMENTE INACTIVO, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000, });
                 $("#submit_login").html('<button type="submit" name="btn-login" id="btn-login" class="btn btn-outline-warning btn-lg btn-block waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="Haga clic aquí para iniciar sesión"><span class="fa fa-sign-in"></span> Acceder</button>');
				 
				                   });  
			   
					} else if(response==4){
									 
						    $("#login").fadeIn(1000, function(){
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> EL PASSWORD INGRESADO ES ERRONEO, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000, });
                 $("#submit_login").html('<button type="submit" name="btn-login" id="btn-login" class="btn btn-outline-warning btn-lg btn-block waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="Haga clic aquí para iniciar sesión"><span class="fa fa-sign-in"></span> Acceder</button>');
				 
				        }); 
			   
				} else {
									  
					$("#login").fadeIn(1000, function(){
				
				$("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
				setTimeout(' window.location.href = "panel"; ',500);
				 
				        });  
					}
			   }
		 });
				return false;
		}
	   /* login submit */
    }); 
});
/* FUNCION JQUERY PARA VALIDAR ACCESO DE USUARIOS*/


/* FUNCION JQUERY PARA VALIDAR ACCESO DE USUARIOS*/
$('document').ready(function()
{ 
	 $("#lockscreen").validate({
      rules:
	  {
			usuario: { required: true, },
			password: { required: true, },
	   },
       messages:
	   {
		    usuario:{ required: "Ingrese Usuario de Acceso" },
			password:{ required: "Ingrese Clave de Acceso" },
       },
	   submitHandler: function(form) {
                     		
			var data = $("#lockscreen").serialize();
				
			$.ajax({
			type : 'POST',
			url  : 'lockscreen.php',
			async : false,
			data : data,
			beforeSend: function()
			{	
				$("#login").fadeOut(1000);
				
				 var n = noty({
                 text: "<span class='fa fa-refresh'></span> VERIFICANDO INFORMACI&Oacute;N, POR FAVOR ESPERE......",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 1000, });
                 $("#submit_login").html('<button type="button" class="btn btn-outline-warning btn-lg btn-block waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="Haga clic aquí para iniciar sesión"><span class="fa fa-sign-in"></span> Acceder</button>');
			},
			success :  function(response)
			   {						
					if(response==1){ 
								 
								$("#login").fadeIn(1000, function(){ 
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000, });
                 $("#submit_login").html('<button type="submit" name="btn-login" id="btn-login" class="btn btn-outline-warning btn-lg btn-block waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="Haga clic aquí para iniciar sesión"><span class="fa fa-sign-in"></span> Acceder</button>');
				    
					                        });
			   
	                } else if(response==2){
									 
								$("#login").fadeIn(1000, function(){
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> LOS DATOS INGRESADOS NO EXISTEN, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000, });
                 $("#submit_login").html('<button type="submit" name="btn-login" id="btn-login" class="btn btn-outline-warning btn-lg btn-block waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="Haga clic aquí para iniciar sesión"><span class="fa fa-sign-in"></span> Acceder</button>');
				 
				                             });
			   
					} else if(response==3){
									 
						    $("#login").fadeIn(1000, function(){
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ESTE USUARIO SE ENCUENTRA ACTUALMENTE INACTIVO, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000, });
                 $("#submit_login").html('<button type="submit" name="btn-login" id="btn-login" class="btn btn-outline-warning btn-lg btn-block waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="Haga clic aquí para iniciar sesión"><span class="fa fa-sign-in"></span> Acceder</button>');
				 
				                   });  
			   
					} else if(response==4){
									 
						    $("#login").fadeIn(1000, function(){
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> EL PASSWORD INGRESADO ES ERRONEO, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000, });
                 $("#submit_login").html('<button type="submit" name="btn-login" id="btn-login" class="btn btn-outline-warning btn-lg btn-block waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="Haga clic aquí para iniciar sesión"><span class="fa fa-sign-in"></span> Acceder</button>');
				 
				        });  
			   
					} else {
									  
				$("#login").fadeIn(1000, function(){
				
				$("#btn-login").html('<i class="fa fa-sign-in"></i> Acceder');
				setTimeout(' window.location.href = "panel"; ',500);
				 
				        });  
					}
			   }
		 });
				return false;
	 }
	   /* login submit */
    }); 
});
/* FUNCION JQUERY PARA VALIDAR ACCESO DE USUARIOS*/



/* FUNCION JQUERY PARA RECUPERAR CONTRASEÑA DE USUARIOS */	 
$('document').ready(function()
{ 
     /* validation */
	$("#formrecover").validate({
      rules:
	  {
			email: { required: true,  email: true  },
	   },
       messages:
 	   {
			email:{ required: "Ingrese su Correo Electronico", email: "Ingrese un Correo Electronico Valido" },
       },
	   submitHandler: function(form) {
                     		
				var data = $("#formrecover").serialize();
				
				$.ajax({
				type : 'POST',
				url  : 'index.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#recover").fadeOut();
					$("#submit_password").html('<button type="button" class="btn btn-outline-warning btn-lg btn-block waves-effect waves-light"><i class="fa fa-refresh"></i> Verificando...</button>');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#recover").fadeIn(1000, function(){ 
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000, });
                 $("#submit_password").html('<button type="submit" name="btn-recuperar" id="btn-recuperar" class="btn btn-outline-warning btn-lg btn-block waves-effect waves-light"><span class="fa fa-check-square-o"></span> Recuperar Password</button>');
				    
					                                                 });																			
								}
								else if(data==2)
								{
									
					$("#recover").fadeIn(1000, function(){ 
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> EL CORREO INGRESADO NO FUE ENCONTRADO ACTUALMENTE, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000, });
                 $("#submit_password").html('<button type="submit" name="btn-recuperar" id="btn-recuperar" class="btn btn-outline-warning btn-lg btn-block waves-effect waves-light"><span class="fa fa-check-square-o"></span> Recuperar Password</button>');
				    
					                                                 });
					
								}
								else if(data==3)
								{
									
					$("#recover").fadeIn(1000, function(){ 
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> LA NUEVA CLAVE DE ACCESO NO PUDO SER ENVIADA A SU CORREO, INTENTE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000, });
                 $("#submit_password").html('<button type="submit" name="btn-recuperar" id="btn-recuperar" class="btn btn-outline-warning btn-lg btn-block waves-effect waves-light"><span class="fa fa-check-square-o"></span> Recuperar Password</button>');
				    
					                                                 });
					
								} else {
										
									$("#recover").fadeIn(1000, function(){
										
				$("#formrecover")[0].reset();
				 var n = noty({
				 text: '<center> &nbsp; '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000, });
                 $("#submit_password").html('<button type="submit" name="btn-recuperar" id="btn-recuperar" class="btn btn-outline-warning btn-lg btn-block waves-effect waves-light"><span class="fa fa-check-square-o"></span> Recuperar Password</button>');
				                                
												                      });
								       }
						   }
				});
			 return false;
		}
	   /* form submit */
    }); 
});
/*  FIN DE FUNCION PARA RECUPERAR CONTRASEÑA DE USUARIOS */
 
 
/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CONTRASEÑA */	 
$('document').ready(function()
{ 						
     /* validation */
	 $("#updatepassword").validate({
      rules:
	  {
			usuario: {required: true },
			password: {required: true, minlength: 8},  
            password2:   {required: true, minlength: 8, equalTo: "#txtPassword"}, 
	   },
       messages:
	   {
            usuario:{ required: "Ingrese Usuario de Acceso" },
            password:{ required: "Ingrese su Nuevo Password", minlength: "Ingrese 8 caracteres como minimo" },
		    password2:{ required: "Repita su Nuevo Password", minlength: "Ingrese 8 caracteres como minimo", equalTo: "Este Password no coincide" },
       },
	   submitHandler: function(form) {
                     		
				var data = $("#updatepassword").serialize();
				var id= $("#updatepassword").attr("data-id");
		        var codigo = id;
				
				$.ajax({
				type : 'POST',
				url  : 'password.php?codigo='+codigo,
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
						$("#save").fadeIn(1000, function(){ 
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000, });
			     $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
				    
					                                                 });									
																				
								}
								else if(data==2)
								{
									
					    $("#save").fadeIn(1000, function(){ 
			
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> NO PUEDE USAR LA CLAVE ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000, });
			     $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
				    
					                                                 });
					
								} else {
										
						$("#save").fadeIn(1000, function(){
										
				 
				 $("#updatepassword")[0].reset();
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000, });
				 $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');	
				 setTimeout(' window.location.href = "logout"; ',5000);
				 
												                      });									
								             }
						    }
				});
				return false;
		}
	   /* form submit */
    }); 
});
 /* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CONTRASEÑA */


















/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CONFIGURACION GENERAL */	 
$('document').ready(function()
{ 
     /* validation */
	 $("#configuracion").validate({
      rules:
	  {
			documsucursal: { required: false },
			cuit: { required: true, digits: false},
			nomsucursal: { required: true },
			codgiro: { required: true },
			girosucursal: { required: true },
			tlfsucursal: { required: true,  digits : false },
			correosucursal: { required: true,  email : true },
			id_provincia: { required: false },
			id_departamento: { required: false },
			direcsucursal: { required: true },
			documencargado: { required: false },
			dniencargado: { required: true, number: true },
			nomencargado: { required: true, lettersonly: true },
			tlfencargado: { required: true,  digits : false },
			codmoneda: { required: true },
			codmoneda2: { required: false },
			nroactividadsucursal: { required: true, },
			inicioticket: { required: true, digits : true },
			inicioboleta: { required: true, digits : true },
            iniciofactura: {required: true, digits : true },
            inicionota: {required: true, digits : true },	
			fechaautorizacion: { required: true },
			llevacontabilidad: { required: true },
			descuentoglobal: { required: true, number : true },
			propinasugerida: { required: true, number : true },
			infoapi: { required: true },
	   },
       messages:
	   {
            documsucursal:{ required: "Seleccione Tipo de Documento" },
            cuit:{ required: "Ingrese N&deg; de Empresa", digits: "Ingrese solo digitos para N&deg; de Empresa" },
			nomsucursal:{ required: "Ingrese Raz&oacute;n Social" },
			codgiro:{ required: "Ingrese N&deg; de Giro" },
			girosucursal:{ required: "Ingrese Giro de Empresa" },
			tlfsucursal: { required: "Ingrese N&deg; de Tel&eacute;fono de Empresa", digits: "Ingrese solo digitos para Tel&eacute;fono" },
			correosucursal: { required: "Ingrese Email de Empresa", email: "Ingrese un Correo v&aacute;lido" },
			id_provincia:{ required: "Seleccione Provincia" },
			id_departamento:{ required: "Seleccione Departamento" },
			direcsucursal: { required: "Ingrese Direcci&oacute;n de Empresa" },
			documencargado:{ required: "Seleccione Tipo de Documento" },
            dniencargado: { required: "Ingrese N&deg; de Documento de Encargado", number: "Ingrese solo numeros" },
			nomencargado:{ required: "Ingrese Nombre de Encargado", lettersonly: "Ingrese solo letras para Nombres" },
			tlfencargado: { required: "Ingrese N&deg; de Tel&eacute;fono de Encargado", digits: "Ingrese solo digitos para Tel&eacute;fono" },
			codmoneda:{ required: "Seleccione Moneda Nacional" },
			codmoneda2:{ required: "Seleccione Moneda para Cambio" },
			nroactividadsucursal:{ required: "Ingrese N&deg; de Actividad", digits: "Ingrese solo digitos para N&deg; de Actividad" },
			inicioticket:{ required: "Ingrese N&deg; de Inicio de Ticket", digits: "Ingrese solo digitos para N&deg; de Inicio de Ticket" },
			inicioboleta:{ required: "Ingrese N&deg; de Inicio de Boleta", digits: "Ingrese solo digitos para N&deg; de Inicio de Boleta" },
			iniciofactura:{ required: "Ingrese N&deg; de Inicio de Factura", digits: "Ingrese solo digitos para N&deg; de Inicio de Factura" },
			inicionota:{ required: "Ingrese N&deg; de Inicio de Nota Cr&eacute;dito", digits: "Ingrese solo digitos para N&deg; de Inicio de Nota" },
			fechaautorizacion:{ required: "Ingrese Fecha de Autorizaci&oacute;n" },
			llevacontabilidad:{ required: "Seleccione si lleva Contabilidad" },
			descuentoglobal:{ required: "Ingrese Descto Global para Ventas", number: "Ingrese solo digitos con 2 decimales" },
			propinasugerida:{ required: "Ingrese (%) Propina Sugerida", number: "Ingrese solo digitos con 2 decimales" },
			infoapi:{ required: "Seleccione si Procesa Documento Electr&oacute;nico" },
			
       },
	   submitHandler: function(form) {
                     		
				var data = $("#configuracion").serialize();
				var formData = new FormData($("#configuracion")[0]);
				
				$.ajax({
				type : 'POST',
				url  : 'configuracion.php',
			    async : false,
				data : formData,
				//necesario para subir archivos via ajax
                cache: false,
				contentType: false,
				processData: false,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
						$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'error',
                 timeout: 5000, });
				 $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
				 
				                                                      }); 
																				
								} else { 
								     
						$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'success',
                 timeout: 5000, });
				 $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');	
				                                
												                      });
							    }
					    }
			    });
		  return false;
	  }
	  /* form submit */	 
    });   
});
/* FIN DE  FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE CONFIGURACION GENERAL */
 
















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE USUARIOS */	 
$('document').ready(function()
{ 
        jQuery.validator.addMethod("lettersonly", function(value, element) {
          return this.optional(element) || /^[a-zA-ZñÑáéíóúÁÉÍÓÚ,. ]+$/i.test(value);
        });

     /* validation */
	 $("#saveuser").validate({
      rules:
	  {
			dni: { required: true,  digits : true, minlength: 7 },
			nombres: { required: true, lettersonly: true },
			sexo: { required: true, },
			direccion: { required: true, },
			telefono: { required: true, },
			email: { required: true, email: true },
			usuario: { required: true, },
			password: {required: true, minlength: 8},  
            password2:   {required: true, minlength: 8, equalTo: "#password"}, 
			nivel: { required: true, },
			status: { required: true, },
			comision: { required: true,  number : true },
	   },
       messages:
	   {
            dni:{ required: "Ingrese N&deg; de Documento", digits: "Ingrese solo d&iacute;gitos para N&deg; de Documento", minlength: "Ingrese 7 d&iacute;gitos como m&iacute;nimo" },
			nombres:{ required: "Ingrese Nombre de Usuario", lettersonly: "Ingrese solo letras para Nombres" },
            sexo:{ required: "Seleccione Sexo de Usuario" },
            direccion:{ required: "Ingrese Direcci&oacute;n Domiciliaria" },
            telefono:{ required: "Ingrese N&deg; de Tel&eacute;fono" },
			email:{ required: "Ingrese Email de Usuario", email: "Ingrese un Email V&aacute;lido" },
			usuario:{ required: "Ingrese Usuario de Acceso" },
			password:{ required: "Ingrese Password de Acceso", minlength: "Ingrese 8 caracteres como m&iacute;nimo" },
		    password2:{ required: "Repita Password de Acceso", minlength: "Ingrese 8 caracteres como m&iacute;nimo", equalTo: "Este Password no coincide" },
			nivel:{ required: "Seleccione Nivel de Acceso" },
			status:{ required: "Seleccione Status de Acceso" },
			comision:{ required: "Ingrese Comisi&oacute;n por Ventas", number: "Ingrese solo numeros con dos decimales" },
       },
	   submitHandler: function(form) {
                     		
				var data = $("#saveuser").serialize();
				var formData = new FormData($("#saveuser")[0]);
				
				$.ajax({
				type : 'POST',
				url  : 'usuarios.php',
			    async : false,
				data : formData,
				//necesario para subir archivos via ajax
                cache: false,
                contentType: false,
                processData: false,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
										
									});
								}   
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> YA EXISTE UN USUARIO CON ESTE N&deg; DE DNI, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}
								else if(data==3){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ESTE CORREO ELECTR&Oacute;NICO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
											
									});
								}
								else if(data==4)
								{
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ESTE USUARIO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');

									});
								}
								else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000, });
                 $('body').removeClass('modal-open');
                 $('#myModalUser').modal('hide');
				 $("#saveuser")[0].reset();
                 $("#proceso").val("save");	
				 $('#codusuario').val("");
				 $('#usuarios').html("");
				 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
				 $('#usuarios').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
				 setTimeout(function() {
				 	$('#usuarios').load("consultas?CargaUsuarios=si");
				 }, 2000);

									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE USUARIOS */


















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE PROVINCIAS */	 
$('document').ready(function()
{ 
     /* validation */
	 $("#saveprovincia").validate({
      rules:
	  {
			provincia: { required: true, },
	   },
       messages:
	   {
            provincia:{ required: "Ingrese Nombre de Provincia" },
       },
	   submitHandler: function(form) {
                     		
				var data = $("#saveprovincia").serialize();
				
				$.ajax({
				type : 'POST',
				url  : 'provincias.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
										
									});
								}   
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> YA EXISTE ESTE NOMBRE DE PROVINCIA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}
								else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000, });
				 $("#saveprovincia")[0].reset();
                 $("#proceso").val("save");	
				 $('#id_provincia').val("");	
				 $('#provincias').html("");
				 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
				 $('#provincias').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
				 setTimeout(function() {
				 	$('#provincias').load("consultas?CargaProvincias=si");
				 }, 2000);
										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE PROVINCIAS */


















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE DEPARTAMENTOS */	 
$('document').ready(function()
{ 
     /* validation */
	 $("#savedepartamento").validate({
      rules:
	  {
			departamento: { required: true, },
			id_provincia: { required: true, },
	   },
       messages:
	   {
            departamento:{ required: "Ingrese Nombre de Departamento"},
            id_provincia:{ required: "Seleccione Provincia para Departamento"},
       },
	   submitHandler: function(form) {
                     		
				var data = $("#savedepartamento").serialize();
				
				$.ajax({
				type : 'POST',
				url  : 'departamentos.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
										
									});
								}   
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> YA EXISTE ESTE DEPARTAMENTO PARA LA PROVINCIA SELECCIONADA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}
								else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000, });
				 $("#savedepartamento")[0].reset();
                 $("#proceso").val("save");	
				 $('#id_departamento').val("");
				 $('#departamentos').html("");
				 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
				 $('#departamentos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
				 setTimeout(function() {
				 	$('#departamentos').load("consultas?CargaDepartamentos=si");
				 }, 200);
										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE DEPARTAMENTOS */


















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE TIPOS DE DOCUMENTOS */	 
$('document').ready(function()
{ 
     /* validation */
	 $("#savedocumento").validate({
      rules:
	  {
			documento: { required: true, },
			descripcion: { required: true, },
	   },
       messages:
	   {
			documento:{ required: "Ingrese Nombre de Documento" },
            descripcion:{ required: "Ingrese Descripci&oacute;n de Documento" },
       },
	   submitHandler: function(form) {
                     		
				var data = $("#savedocumento").serialize();
				
				$.ajax({
				type : 'POST',
				url  : 'documentos.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
										
									});
								}   
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ESTE NOMBRE DE DOCUMENTO YA EXISTE, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}
								 else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000, });
				 $("#savedocumento")[0].reset();
                 $("#proceso").val("save");
				 $('#coddocumento').val("");
				 $('#documentos').html("");	
				 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
				 $('#documentos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
                 setTimeout(function() {
                 $('#documentos').load("consultas?CargaDocumentos=si");
                 }, 2000);
										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */	
    });    
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE TIPOS DE DOCUMENTOS */

















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE TIPOS DE MONEDA */	 
$('document').ready(function()
{ 
     /* validation */
	 $("#savemoneda").validate({
      rules:
	  {
			moneda: { required: true, },
			siglas: { required: true, },
			simbolo: { required: true, },
	   },
       messages:
	   {
			moneda:{ required: "Ingrese Nombre de Moneda" },
            siglas:{ required: "Ingrese Siglas de Moneda" },
            simbolo:{ required: "Ingrese Simbolo de Moneda" },
       },
	   submitHandler: function(form) {
                     		
				var data = $("#savemoneda").serialize();
				
				$.ajax({
				type : 'POST',
				url  : 'monedas.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
										
									});
								}   
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ESTE NOMBRE DE MONEDA YA EXISTE, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}
								 else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000, });
				 $("#savemoneda")[0].reset();
                 $("#proceso").val("save");
				 $('#codmoneda').val("");
				 $('#monedas').html("");	
				 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
				 $('#monedas').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
                 setTimeout(function() {
                 $('#monedas').load("consultas?CargaMonedas=si");
                 }, 2000);
										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE TIPOS DE MONEDA */


















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE TIPOS DE CAMBIO */	 
$('document').ready(function()
{ 
     /* validation */
	 $("#savecambio").validate({
      rules:
	  {
			descripcioncambio: { required: true, },
			montocambio:{ required: true, number : true},
			montocambio: { required: true, },
			codmoneda: { required: true, },
			fechacambio: { required: true, },
	   },
       messages:
	   {
			descripcioncambio:{ required: "Ingrese Descripci&oacute;n de Cambio" },
			montocambio:{ required: "Ingrese Monto de Cambio", number: "Ingrese solo digitos con 2 decimales" },
			codmoneda:{ required: "Seleccione Tipo de Moneda" },
			fechacambio:{ required: "Ingrese Fecha de Registro" },
       },
	   submitHandler: function(form) {
                     		
				var data = $("#savecambio").serialize();
				var montocambio = $('#montocambio').val();
	
	        if (montocambio==0.00 || montocambio==0) {
	            
				$("#montocambio").focus();
				$('#montocambio').css('border-color','#f0ad4e');
				swal("Oops", "POR FAVOR INGRESE UN MONTO DE CAMBIO VALIDO!", "error");

	        } else {


				$.ajax({
				type : 'POST',
				url  : 'cambios.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
										
									});
								}   
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> YA EXISTE UN TIPO DE CAMBIO EN LA FECHA ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}
								 else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000, });
				 $("#savecambio")[0].reset();
                 $("#proceso").val("save");
				 $('#codcambio').val("");
				 $('#cambios').html("");	
				 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
				 $('#cambios').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
                 setTimeout(function() {
                 $('#cambios').load("consultas?CargaCambios=si");
                 }, 2000);
										
									});
								}
						   }
				});
				return false;
			   }
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE TIPOS DE CAMBIO */





















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE IMPUESTOS */	 
$('document').ready(function()
{ 
     /* validation */
	 $("#saveimpuesto").validate({
      rules:
	  {
			nomimpuesto: { required: true, },
			valorimpuesto: { required: true, number : true},
			statusimpuesto: { required: true, },
			fechaimpuesto: { required: true, },
	   },
       messages:
	   {
			nomimpuesto:{ required: "Ingrese Nombre de Impuesto" },
			valorimpuesto:{ required: "Ingrese Valor de Impuesto", number: "Ingrese solo digitos con 2 decimales" },
			statusimpuesto: { required: "Seleccione Status de Impuesto" },
			fechaimpuesto:{ required: "Ingrese Fecha de Registro" },
       },
	   submitHandler: function(form) {
                     		
				var data = $("#saveimpuesto").serialize();
				
				$.ajax({
				type : 'POST',
				url  : 'impuestos.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
										
									});
								}   
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> YA EXISTE UN IMPUESTO ACTIVO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}  
								else if(data==3){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> YA EXISTE UN IMPUESTO CON ESTE NOMBRE, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}
								 else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000, });
				 $("#saveimpuesto")[0].reset();
                 $("#proceso").val("save");
				 $('#codimpuesto').val("");
				 $('#impuestos').html("");
				 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
				 $('#impuestos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
				 setTimeout(function() {
				 	$('#impuestos').load("consultas?CargaImpuestos=si");
				 }, 2000);
										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE IMPUESTOS */
 
 











/* FUNCION JQUERY PARA VALIDAR REGISTRO DE SALAS */	 
$(document).ready(function()
{ 
     
     /* validation */
	 $("#savesala").validate({
      rules:
	  {
			nomsala: { required: true },
	   },
       messages:
	   {
            nomsala:{ required: "Ingrese Nombre de Sala" },
       },
	   submitHandler: function(form) {
                     
               var data = $("#savesala").serialize();

				$.ajax({
				type : 'POST',
				url  : 'salas.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');	
										
									});
								}  
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ESTA SALA YA SE ENCUENTRA REGISTRADA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');	
																				
									});
								} 
								else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000, });
				 $("#savesala")[0].reset();
                 $("#proceso").val("save");
				 $('#codsala').val("");
				 $('#salas').html("");		
				 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');	
				 $('#salas').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
                 setTimeout(function() {
                 $('#salas').load("consultas?CargaSalas=si");
                 }, 2000);										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
    });
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE SALAS */
 
 

 
 
 
 










/* FUNCION JQUERY PARA VALIDAR REGISTRO DE MESAS */	 
$(document).ready(function()
{ 
     
     /* validation */
	 $("#savemesa").validate({
      rules:
	  {
			codsala: { required: true },
			nommesa: { required: true },
			puestos: { required: true },
	   },
       messages:
	   {
            codsala:{ required: "Seleccione Sala" },
            nommesa:{ required: "Ingrese Nombre de Mesa" },
            puestos:{ required: "Ingrese N&deg; de Asientos" },
       },
	   submitHandler: function(form) {
                     
               var data = $("#savemesa").serialize();

				$.ajax({
				type : 'POST',
				url  : 'mesas.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');	
										
									});
								}  
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ESTA MESA YA SE ENCUENTRA REGISTRADA EN ESTA SALA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');	
																				
									});
								} 
								else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000, });
				 $("#savemesa")[0].reset();
                 $("#proceso").val("save");
				 $('#codmesa').val("");
				 $('#mesas').html("");		
				 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');	
				 $('#mesas').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
                 setTimeout(function() {
                 $('#mesas').load("consultas?CargaMesas=si");
                 }, 2000);										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
    });
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE MESAS */
 
/* FUNCION JQUERY PARA VALIDAR CAMBIO DE MESA */	 
$(document).ready(function()
{ 
     
     /* validation */
	 $("#cambiarmesa").validate({
      rules:
	  {
			nuevasala: { required: true },
			nuevamesa: { required: true },
	   },
       messages:
	   {
            nuevasala:{ required: "Seleccione Sala" },
            nuevamesa:{ required: "Seleccione Mesa" },
       },
	   submitHandler: function(form) {
                     
           var data = $("#cambiarmesa").serialize();
           var codmesa = $('#nuevamesa').val();
           var codpedido = $('#codpedido').val();
           var codventa = $('#codventa').val();

			$.ajax({
			type : 'POST',
			url  : 'panel.php',
		    async : false,
			data : data,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-cambiar").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-cambiar").html('<span class="fa fa-save"></span> Cambiar Mesa');	
									
								});
							}  
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> ESTA MESA YA SE ENCUENTRA ASIGNADA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-cambiar").html('<span class="fa fa-save"></span> Cambiar Mesa');	
																			
								});
							} 
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 5000, });
             $('body').removeClass('modal-open');
             $('#myModalCambioMesa').modal('hide');
			 $("#cambiarmesa")[0].reset();
			 $('#mesa').val("");	
			 $('#codmesa').html("<option value=''>-- SIN RESULTADOS --</option>");
			 $('#pedidos').html("");
			 $('#pedidos').load("detalles_mesas.php?CargaPedidosMesa=si&codmesa="+codmesa+"&codpedido="+codpedido);
			 $('#muestradetallemesa').load("detalles_mesas.php?BuscaPedidosMesa=si&codmesa="+codmesa+"&codpedido="+codpedido+"&codventa="+codventa);
         	 $('#loading').load("salas_mesas?CargaProductos=si");	
			 $("#btn-cambiar").html('<span class="fa fa-save"></span> Cambiar Mesa');	
												
								});
							}
					   }
			});
			return false;
		}
	   /* form submit */
    });
});
/*  FIN DE FUNCION PARA VALIDAR CAMBIO DE MESA */ 
 
 
 
 
 











/* FUNCION JQUERY PARA VALIDAR REGISTRO DE CATEGORIAS */	 
$(document).ready(function()
{ 
     
     /* validation */
	 $("#savecategoria").validate({
      rules:
	  {
			nomcategoria: { required: true },
	   },
       messages:
	   {
            nomcategoria:{ required: "Ingrese Nombre de Categoria" },
       },
	   submitHandler: function(form) {
                     
               var data = $("#savecategoria").serialize();

				$.ajax({
				type : 'POST',
				url  : 'categorias.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');	
										
									});
								}  
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ESTA CATEGORIA YA SE ENCUENTRA REGISTRADA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');	
																				
									});
								} 
								else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000, });
				 $("#savecategoria")[0].reset();
                 $("#proceso").val("save");
				 $('#codcategoria').val("");
				 $('#categorias').html("");		
				 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');	
				 $('#categorias').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
                 setTimeout(function() {
                 $('#categorias').load("consultas?CargaCategorias=si");
                 }, 2000);										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
    });
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE CATEGORIAS */



 
 
 
 











/* FUNCION JQUERY PARA VALIDAR REGISTRO DE MEDIDAS */	 
$(document).ready(function()
{ 
     
     /* validation */
	 $("#savemedida").validate({
      rules:
	  {
			nommedida: { required: true },
	   },
       messages:
	   {
            nommedida:{ required: "Ingrese Nombre de Medida" },
       },
	   submitHandler: function(form) {
                     
               var data = $("#savemedida").serialize();

				$.ajax({
				type : 'POST',
				url  : 'medidas.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');	
										
									});
								}  
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ESTA MEDIDA YA SE ENCUENTRA REGISTRADA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');	
																				
									});
								} 
								else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000, });
				 $("#savemedida")[0].reset();
                 $("#proceso").val("save");
				 $('#codmedida').val("");
				 $('#medidas').html("");		
				 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');	
				 $('#medidas').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
                 setTimeout(function() {
                 $('#medidas').load("consultas?CargaMedidas=si");
                 }, 2000);										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
    });
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE UNIDADES */


















/* FUNCION JQUERY PARA CARGA MASIVA DE CLIENTES */	 
$('document').ready(function()
{ 
     /* validation */
	 $("#cargaclientes").validate({
      rules:
	  {
			sel_file: { required: true, },
	   },
       messages:
	   {
            sel_file:{ required: "Seleccione Archivo para Cargar" },
       },
	   submitHandler: function(form) {
                     		
				var data = $("#cargaclientes").serialize();
				var formData = new FormData($("#cargaclientes")[0]);
				
				$.ajax({
				type : 'POST',
				url  : 'clientes.php',
			    async : false,
				data : formData,
				//necesario para subir archivos via ajax
                cache: false,
                contentType: false,
                processData: false,
				beforeSend: function()
				{	
					$("#carga").fadeOut();
					$("#btn-cliente").html('<i class="fa fa-spin fa-spinner"></i> Cargando ....');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#carga").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> NO SE HA SELECCIONADO NINGUN ARCHIVO PARA CARGAR, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-cliente").html('<span class="fa fa-cloud-upload"></span> Cargar');
										
									});
								}  
								else if(data==2){
									
							   $("#carga").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ERROR! ARCHIVO INVALIDO PARA LA CARGA MASIVA DE CLIENTES, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-cliente").html('<span class="fa fa-cloud-upload"></span> Cargar');
																				
									});
								}
								else{
										
					$("#carga").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000, });
                 $('body').removeClass('modal-open');
                 $('#myModalCargaMasiva').modal('hide');
				 $("#cargaclientes")[0].reset();
				 $('#muestraclientes').html("");
				 $('#divcliente').html("");
				 $("#btn-cliente").html('<span class="fa fa-cloud-upload"></span> Cargar');
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
    }); 
});
/*  FIN DE FUNCION PARA CARGA MASIVA DE CLIENTES */

/* FUNCION JQUERY PARA VALIDAR REGISTRO DE CLIENTES */	  
$('document').ready(function()
{ 
        jQuery.validator.addMethod("lettersonly", function(value, element) {
          return this.optional(element) || /^[a-zA-ZñÑáéíóúÁÉÍÓÚ,. ]+$/i.test(value);
        });

     /* validation */
	 $("#savecliente").validate({
      rules:
	  {
			tipocliente: { required: true, },
			documcliente: { required: false, },
			dnicliente: { required: true,  digits : false, minlength: 7 },
			nomcliente: { required: true, lettersonly: true },
			razoncliente: { required: true },
			girocliente: { required: true },
			tlfcliente: { required: false, },
			id_provincia: { required: false, },
			id_departamento: { required: false, },
			direccliente: { required: true, },
			emailcliente: { required: false, email: true },
			limitecredito: { required: true, number : true},
	   },
       messages:
	   {
			tipocliente: { required: "Seleccione Tipo de Cliente" },
			documcliente:{ required: "Seleccione Tipo de Documento" },
			dnicliente:{ required: "Ingrese N&deg; de Documento", digits: "Ingrese solo d&iacute;gitos", minlength: "Ingrese 7 d&iacute;gitos como m&iacute;nimo" },
            nomcliente:{ required: "Ingrese Nombre de Cliente", lettersonly: "Ingrese solo letras para Nombres" },
			razoncliente:{ required: "Ingrese Raz&oacute;n Social" },
			girocliente:{ required: "Ingrese Giro de Cliente" },
			tlfcliente: { required: "Ingrese N&deg; de Tel&eacute;fono" },
			id_provincia:{ required: "Seleccione Provincia" },
			id_departamento: { required: "Seleccione Departamento" },
			direccliente: { required: "Ingrese Direcci&oacute;n Domiciliaria" },
			emailcliente:{ required: "Ingrese Email de Cliente", email: "Ingrese un Email V&aacute;lido" },
			limitecredito:{ required: "Ingrese Limite de Cr&eacute;dito", number: "Ingrese solo digitos con 2 decimales" },
       },
	   submitHandler: function(form) {
                     		
			var data = $("#savecliente").serialize();
			var criterio = $("input#criterio").val();
			
			$.ajax({
			type : 'POST',
			url  : 'clientes.php',
		    async : false,
			data : data,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
									
								});
							}  
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> YA EXISTE UN CLIENTE CON ESTE N&deg; DE DOCUMENTO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																			
								});
							}
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 5000, });
             $('body').removeClass('modal-open');
             $('#myModalCliente').modal('hide');
			 $("#savecliente")[0].reset();
             $("#proceso").val("save");	
			 $('#codcliente').val("");	
			 $('#muestraclientes').html("");
			 $('#id_departamento').html("<option value=''>-- SIN RESULTADOS --</option>");	
			 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
            $('#muestraclientes').load("search.php?CargaClientes=si&bclientes="+criterio); 
								});
							}
					   }
			});
			return false;
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE CLIENTES */


















/* FUNCION JQUERY PARA CARGA MASIVA DE PROVEEDORES */	 
$('document').ready(function()
{ 						
     /* validation */
	 $("#cargaproveedores").validate({
      rules:
	  {
			sel_file: { required: true, },
	   },
       messages:
	   {
            sel_file:{ required: "Seleccione Archivo para Cargar" },
       },
	   submitHandler: function(form) {
                     		
			var data = $("#cargaproveedores").serialize();
			var formData = new FormData($("#cargaproveedores")[0]);
			
			$.ajax({
			type : 'POST',
			url  : 'proveedores.php',
		    async : false,
			data : formData,
			//necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
			beforeSend: function()
			{	
				$("#carga").fadeOut();
				$("#btn-proveedor").html('<i class="fa fa-spin fa-spinner"></i> Cargando ....');
			},
			success :  function(data)
					   {						
							if(data==1){
								
								$("#carga").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> NO SE HA SELECCIONADO NINGUN ARCHIVO PARA CARGAR, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-proveedor").html('<span class="fa fa-cloud-upload"></span> Cargar');
									
								});
							}  
							else if(data==2){
								
						   $("#carga").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> ERROR! ARCHIVO INVALIDO PARA LA CARGA MASIVA DE PROVEEDORES, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-proveedor").html('<span class="fa fa-cloud-upload"></span> Cargar');
																			
								});
							}
							else{
									
				$("#carga").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 5000, });
             $('body').removeClass('modal-open');
             $('#myModalCargaMasiva').modal('hide');
			 $("#cargaproveedores")[0].reset();
			 $('#proveedores').html("");
			 $('#divproveedor').html("");
			 $("#btn-proveedor").html('<span class="fa fa-cloud-upload"></span> Cargar');
			 $('#proveedores').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
			 setTimeout(function() {
			 	$('#proveedores').load("consultas?CargaProveedores=si");
			 }, 200);
									
								});
							}
					   }
			});
			return false;
		}
	   /* form submit */
    }); 
});
/*  FIN DE FUNCION PARA CARGA MASIVA DE PROVEEDORES */

/* FUNCION JQUERY PARA VALIDAR REGISTRO DE PROVEEDORES */	  
$('document').ready(function()
{ 

        jQuery.validator.addMethod("lettersonly", function(value, element) {
          return this.optional(element) || /^[a-zA-ZñÑáéíóúÁÉÍÓÚ,. ]+$/i.test(value);
        });

     /* validation */
	 $("#saveproveedor").validate({
      rules:
	  {
			documproveedor: { required: false, },
			cuitproveedor: { required: true,  digits : false, minlength: 7 },
			nomproveedor: { required: true, lettersonly: false },
			tlfproveedor: { required: true, },
			id_provincia: { required: false, },
			id_departamento: { required: false, },
			direcproveedor: { required: true, },
			emailproveedor: { required: true, email: true },
			vendedor: { required: true, lettersonly: true },
			tlfvendedor: { required: true, },
	   },
       messages:
	   {
			documproveedor:{ required: "Seleccione Tipo de Documento" },
			cuitproveedor:{ required: "Ingrese N&deg; de Documento", digits: "Ingrese solo d&iacute;gitos para N&deg; de Documento", minlength: "Ingrese 7 d&iacute;gitos como m&iacute;nimo" },
            nomproveedor:{ required: "Ingrese Nombre de Proveedor", lettersonly: "Ingrese solo letras para Nombres" },
			tlfproveedor: { required: "Ingrese N&deg; de Tel&eacute;fono" },
			id_provincia:{ required: "Seleccione Provincia" },
			id_departamento: { required: "Seleccione Departamento" },
			direcproveedor: { required: "Ingrese Direcci&oacute;n de Proveedor" },
			emailproveedor:{ required: "Ingrese Email de Proveedor", email: "Ingrese un Email V&aacute;lido" },
            vendedor:{ required: "Ingrese Nombre de Encargado", lettersonly: "Ingrese solo letras para Nombres" },
            tlfvendedor: { required: "Ingrese N&deg; de Tel&eacute;fono" },
       },
	   submitHandler: function(form) {
                     		
			var data = $("#saveproveedor").serialize();
			
			$.ajax({
			type : 'POST',
			url  : 'proveedores.php',
		    async : false,
			data : data,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
									
								});
							}  
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> YA EXISTE UN PROVEEDOR CON ESTE N&deg; DE DOCUMENTO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																			
								});
							}
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 5000, });
             $('body').removeClass('modal-open');
             $('#myModalProveedor').modal('hide');
			 $("#saveproveedor")[0].reset();
             $("#proceso").val("save");	
			 $('#codproveedor').val("");	
			 $('#id_departamento').html("<option value=''>-- SIN RESULTADOS --</option>");	
			 $('#proveedores').html("");
			 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
			 $('#proveedores').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
			 setTimeout(function() {
			 	$('#proveedores').load("consultas?CargaProveedores=si");
			 }, 200);
								});
							}
					   }
			});
			return false;
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE PROVEEDORES */





















/* FUNCION JQUERY PARA CARGA MASIVA DE INGREDIENTES */	 
$('document').ready(function()
{ 
								
     /* validation */
	 $("#cargaingredientes").validate({
      rules:
	  {
			sel_file: { required: true, },
	   },
       messages:
	   {
            sel_file:{ required: "Seleccione Archivo para Cargar" },
       },
	   submitHandler: function(form) {
                     		
				var data = $("#cargaingredientes").serialize();
				var formData = new FormData($("#cargaingredientes")[0]);
				
				$.ajax({
				type : 'POST',
				url  : 'ingredientes.php',
			    async : false,
				data : formData,
				//necesario para subir archivos via ajax
                cache: false,
                contentType: false,
                processData: false,
				beforeSend: function()
				{	
					$("#carga").fadeOut();
					$("#btn-ingrediente").html('<i class="fa fa-spin fa-spinner"></i> Cargando ....');
				},
				success :  function(data)
						   {						
								if(data==1){
									
									$("#carga").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> NO SE HA SELECCIONADO NINGUN ARCHIVO PARA CARGAR, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-ingrediente").html('<span class="fa fa-cloud-upload"></span> Cargar');
										
									});
								}  
								else if(data==2){
									
							   $("#carga").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ERROR! ARCHIVO INVALIDO PARA LA CARGA MASIVA DE PRODUCTOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-ingrediente").html('<span class="fa fa-cloud-upload"></span> Cargar');
																				
									});
								}
								else{
										
					$("#carga").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000, });
                 $('body').removeClass('modal-open');
				 $('#myModalCargaMasiva').modal('hide');
				 $("#cargaingredientes")[0].reset();
				 $('#ingredientes').html("");
				 $('#divingrediente').html("");
				 $("#btn-ingrediente").html('<span class="fa fa-cloud-upload"></span> Cargar');
				 $('#ingredientes').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
				 setTimeout(function() {
				 	$('#ingredientes').load("consultas?CargaIngredientes=si");
				 }, 200);
										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
    }); 
});
/*  FIN DE FUNCION PARA CARGA MASIVA DE INGREDIENTES */

/* FUNCION JQUERY PARA VALIDAR REGISTRO DE INGREDIENTES */	  
$('document').ready(function()
{ 
     /* validation */
	 $("#saveingredientes").validate({
	  rules:
	  {
			codingrediente: { required: true, },
			nomingrediente: { required: true,},
			codmedida: { required: true, },
			preciocompra: { required: true, number : true},
			precioventa: { required: true, number : true},
			cantingrediente: { required: true, number : true },
			stockminimo: { required: true, number : true },
			stockmaximo: { required: true, number : true },
			ivaingrediente: { required: true, },
			descingrediente: { required: true, number : true },
			lote: { required: false, },
			fechaexpiracion: { required: false, },
			codproveedor: { required: false, },
			controlstocki: { required: true, },
	   },
       messages:
	   {
			codingrediente: { required: "Ingrese C&oacute;digo" },
			nomingrediente:{ required: "Ingrese Nombre o Descripci&oacute;n" },
			codmedida:{ required: "Seleccione Unidad Medida" },
			preciocompra:{ required: "Ingrese Precio de Compra", number: "Ingrese solo digitos con 2 decimales" },
			precioventa:{ required: "Ingrese Precio de Venta", number: "Ingrese solo digitos con 2 decimales" },
			cantingrediente:{ required: "Ingrese Cantidad o Existencia", number: "Ingrese solo digitos" },
            stockminimo:{ required: "Ingrese Stock Minimo", number: "Ingrese solo digitos" },
            stockmaximo:{ required: "Ingrese Stock Maximo", number: "Ingrese solo digitos" },
			ivaingrediente:{ required: "Seleccione Impuesto" },
			descingrediente:{ required: "Ingrese Descuento", number: "Ingrese solo digitos con 2 decimales" },
			lote:{ required: "Ingrese N&deg; de Lote" },
			fechaexpiracion: { required: "Ingrese Fecha de Expiraci&oacute;n" },
			codproveedor: { required: "Seleccione Proveedor" },
			controlstocki: { required: "Requerido" },
       },
	   submitHandler: function(form) {
                     		
				var data = $("#saveingredientes").serialize();
				var formData = new FormData($("#saveingredientes")[0]);

				var cant = $('#cantingrediente').val();
				var compra = $('#preciocompra').val();
				var venta = $('#precioventa').val();
				cantidad    = parseInt(cant);
	
	        if (parseFloat(compra) > parseFloat(venta)) {
	            
				$("#precioventa").focus();
				$("#preciocompra").focus();
				$('#precioventa').css('border-color','#f0ad4e');
				$('#preciocompra').css('border-color','#f0ad4e');
				swal("Oops", "EL PRECIO DE COMPRA NO PUEDE SER MAYOR QUE EL PRECIO DE VENTA DEL INGREDIENTE!", "error");
         
                return false;
	 
	        } else {
				
				$.ajax({
				type : 'POST',
				url  : 'foringrediente.php',
			    async : false,
				data : formData,
				//necesario para subir archivos via ajax
                cache: false,
                contentType: false,
                processData: false,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
										
									});
								}  
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ESTE INGREDIENTE YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}
								else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000, });
				 $("#saveingredientes")[0].reset();
				 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');	
									});
								}
						   }
				});
				return false;
			}
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE INGREDIENTES */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE INGREDIENTES */	  
$('document').ready(function()
{ 
     /* validation */
	 $("#updateingredientes").validate({
	  rules:
	  {
			codingrediente: { required: true, },
			nomingrediente: { required: true,},
			codmedida: { required: true, },
			preciocompra: { required: true, number : true},
			precioventa: { required: true, number : true},
			cantingrediente: { required: true, number : true },
			stockminimo: { required: true, number : true },
			stockmaximo: { required: true, number : true },
			ivaingrediente: { required: true, },
			descingrediente: { required: true, number : true },
			lote: { required: false, },
			fechaexpiracion: { required: false, },
			codproveedor: { required: false, },
			controlstockp: { required: true, },
	   },
       messages:
	   {
			codingrediente: { required: "Ingrese C&oacute;digo" },
			nomingrediente:{ required: "Ingrese Nombre o Descripci&oacute;n" },
			codmedida:{ required: "Seleccione Unidad Medida" },
			preciocompra:{ required: "Ingrese Precio de Compra", number: "Ingrese solo digitos con 2 decimales" },
			precioventa:{ required: "Ingrese Precio de Venta", number: "Ingrese solo digitos con 2 decimales" },
			cantingrediente:{ required: "Ingrese Cantidad o Existencia", number: "Ingrese solo digitos" },
            stockminimo:{ required: "Ingrese Stock Minimo", number: "Ingrese solo digitos" },
            stockmaximo:{ required: "Ingrese Stock Maximo", number: "Ingrese solo digitos" },
			ivaingrediente:{ required: "Seleccione Impuesto" },
			descingrediente:{ required: "Ingrese Descuento", number: "Ingrese solo digitos con 2 decimales" },
			lote:{ required: "Ingrese N&deg; de Lote" },
			fechaexpiracion: { required: "Ingrese Fecha de Expiraci&oacute;n" },
			codproveedor: { required: "Seleccione Proveedor" },
			controlstockp: { required: "Requerido" },
       },
	   submitHandler: function(form) {
                     		
	   	        var data = $("#updateingredientes").serialize();
				var formData = new FormData($("#updateingredientes")[0]);

				var cant = $('#cantingrediente').val();
				var compra = $('#preciocompra').val();
				var venta = $('#precioventa').val();
				cantidad    = parseInt(cant);
	
	        if (parseFloat(compra) > parseFloat(venta)) {
	            
				$("#precioventa").focus();
				$("#preciocompra").focus();
				$('#precioventa').css('border-color','#f0ad4e');
				$('#preciocompra').css('border-color','#f0ad4e');
				swal("Oops", "EL PRECIO DE COMPRA NO PUEDE SER MAYOR QUE EL PRECIO DE VENTA DEL PRODUCTO!", "error");
         
                return false;
	 
	        } else {
				
				$.ajax({
				type : 'POST',
				url  : 'foringrediente.php',
			    async : false,
				data : formData,
				//necesario para subir archivos via ajax
                cache: false,
                contentType: false,
                processData: false,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}  
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ESTE INGREDIENTE YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
																				
									});
								}
								else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'success',
                 timeout: 5000, });
				 $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
				 setTimeout("location.href='ingredientes'", 5000);	
									});
								}
						   }
				});
				return false;
			}
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR ACTUALIZACION DE INGREDIENTES */





















/* FUNCION JQUERY PARA CARGA MASIVA DE PRODUCTOS */	 
$('document').ready(function()
{ 
								
     /* validation */
	 $("#cargaproductos").validate({
      rules:
	  {
			sel_file: { required: true, },
	   },
       messages:
	   {
            sel_file:{ required: "Seleccione Archivo para Cargar" },
       },
	   submitHandler: function(form) {
             		
		var data = $("#cargaproductos").serialize();
		var formData = new FormData($("#cargaproductos")[0]);
		
		$.ajax({
		type : 'POST',
		url  : 'productos.php',
	    async : false,
		data : formData,
		//necesario para subir archivos via ajax
        cache: false,
        contentType: false,
        processData: false,
		beforeSend: function()
		{	
			$("#carga").fadeOut();
			$("#btn-producto").html('<i class="fa fa-spin fa-spinner"></i> Cargando ....');
		},
		success :  function(data)
				   {						
						if(data==1){
							
							$("#carga").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> NO SE HA SELECCIONADO NINGUN ARCHIVO PARA CARGAR, VERIFIQUE NUEVAMENTE POR FAVOR...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
		$("#btn-producto").html('<span class="fa fa-cloud-upload"></span> Cargar');
								
							});
						}  
						else if(data==2){
							
					   $("#carga").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> ERROR! ARCHIVO INVALIDO PARA LA CARGA MASIVA DE PRODUCTOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
		$("#btn-producto").html('<span class="fa fa-cloud-upload"></span> Cargar');
																		
							});
						}
						else{
								
			$("#carga").fadeIn(1000, function(){
								
		 var n = noty({
		 text: '<center> '+data+' </center>',
         theme: 'defaultTheme',
         layout: 'center',
         type: 'information',
         timeout: 5000, });
         $('body').removeClass('modal-open');
		 $('#myModalCargaMasiva').modal('hide');
		 $("#cargaproductos")[0].reset();
		 $('#productos').html("");
		 $('#divproducto').html("");
		 $("#btn-producto").html('<span class="fa fa-cloud-upload"></span> Cargar');
		 $('#productos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
		 setTimeout(function() {
		 	$('#productos').load("consultas?CargaProductos=si");
		 }, 200);
								
							});
						}
				   }
		});
		return false;
		}
	   /* form submit */
    }); 
});
/*  FIN DE FUNCION PARA CARGA MASIVA DE PRODUCTOS */

/* FUNCION JQUERY PARA VALIDAR REGISTRO DE PRODUCTOS */	  
$('document').ready(function()
{ 
     /* validation */
	 $("#saveproductos").validate({
	  rules:
	  {
			codproducto: { required: true, },
			producto: { required: true,},
			codcategoria: { required: true, },
			preciocompra: { required: true, number : true},
			precioventa: { required: true, number : true},
			existencia: { required: true, number : true },
			stockminimo: { required: true, number : true },
			stockmaximo: { required: true, number : true },
			ivaproducto: { required: true, },
			descproducto: { required: true, number : true },
			codigobarra: { required: false, },
			lote: { required: false, },
			fechaelaboracion: { required: false, },
			fechaexpiracion: { required: false, },
			codproveedor: { required: false, },
			favorito: { required: true, },
			controlstockp: { required: true, },
	   },
       messages:
	   {
			codproducto: { required: "Ingrese C&oacute;digo" },
			producto:{ required: "Ingrese Nombre o Descripci&oacute;n" },
			codcategoria:{ required: "Seleccione Categoria" },
			preciocompra:{ required: "Ingrese Precio de Compra", number: "Ingrese solo digitos con 2 decimales" },
			precioventa:{ required: "Ingrese Precio de Venta", number: "Ingrese solo digitos con 2 decimales" },
			existencia:{ required: "Ingrese Cantidad o Existencia", number: "Ingrese solo digitos" },
            stockminimo:{ required: "Ingrese Stock Minimo", number: "Ingrese solo digitos" },
            stockmaximo:{ required: "Ingrese Stock Maximo", number: "Ingrese solo digitos" },
			ivaproducto:{ required: "Seleccione Impuesto" },
			descproducto:{ required: "Ingrese Descuento", number: "Ingrese solo digitos con 2 decimales" },
			codigobarra: { required: "Ingrese C&oacute;digo de Barra" },
			lote:{ required: "Ingrese N&deg; de Lote" },
			fechaelaboracion: { required: "Ingrese Fecha de Elaboraci&oacute;n" },
			fechaexpiracion: { required: "Ingrese Fecha de Expiraci&oacute;n" },
			codproveedor: { required: "Seleccione Proveedor" },
			favorito: { required: "Requerido" },
			controlstockp: { required: "Requerido" },
       },
	   submitHandler: function(form) {
                     		
			var data = $("#saveproductos").serialize();
			var formData = new FormData($("#saveproductos")[0]);
	   	    var nuevaFila ="<tr>"+"<td class='text-center' colspan=6><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";

			var cant = $('#existencia').val();
			var compra = $('#preciocompra').val();
			var venta = $('#precioventa').val();
			cantidad    = parseInt(cant);

        if (venta==0.00 || venta==0) {
            
			$("#precioventa").focus();
			$('#precioventa').val("");
			$('#precioventa').css('border-color','#f0ad4e');
			swal("Oops", "INGRESE UN COSTO VALIDO PARA EL PRECIO DE VENTA DE PRODUCTO!", "error");
     
            return false;

        } else if (parseFloat(compra) > parseFloat(venta)) {
            
			$("#precioventa").focus();
			$("#preciocompra").focus();
			$('#precioventa').css('border-color','#f0ad4e');
			$('#preciocompra').css('border-color','#f0ad4e');
			swal("Oops", "EL PRECIO DE COMPRA NO PUEDE SER MAYOR QUE EL PRECIO DE VENTA DEL PRODUCTO!", "error");
     
            return false;
 
        } else {
			
			$.ajax({
			type : 'POST',
			url  : 'forproducto.php',
		    async : false,
			data : formData,
			//necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
									
								});
							}   
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> LA CANTIDAD DE INGREDIENTES ASIGNADOS NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																			
								});
							}     
							else if(data==3){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> INGRESE UNA RACION VALIDA PARA INGREDIENTE, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																			
								});
							} 
							else if(data==4){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> ESTE PRODUCTO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																			
								});
							}
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 5000, });
			 $("#saveproductos")[0].reset();
			 $("#carrito tbody").html("");
			 $(nuevaFila).appendTo("#carrito tbody");
			 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');	
								});
							}
					   }
			});
			return false;
			}
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE PRODUCTOS */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE PRODUCTOS */	  
$('document').ready(function()
{ 
     /* validation */
	 $("#updateproductos").validate({
	  rules:
	  {
			codproducto: { required: true, },
			producto: { required: true,},
			codcategoria: { required: true, },
			preciocompra: { required: true, number : true},
			precioventa: { required: true, number : true},
			existencia: { required: true, number : true },
			stockminimo: { required: true, number : true },
			stockmaximo: { required: true, number : true },
			ivaproducto: { required: true, },
			descproducto: { required: true, number : true },
			codigobarra: { required: false, },
			lote: { required: false, },
			fechaelaboracion: { required: false, },
			fechaexpiracion: { required: false, },
			codproveedor: { required: false, },
			favorito: { required: true, },
			controlstockp: { required: true, },
	   },
       messages:
	   {
			codproducto: { required: "Ingrese C&oacute;digo" },
			producto:{ required: "Ingrese Nombre o Descripci&oacute;n" },
			codcategoria:{ required: "Seleccione Categoria" },
			preciocompra:{ required: "Ingrese Precio de Compra", number: "Ingrese solo digitos con 2 decimales" },
			precioventa:{ required: "Ingrese Precio de Venta", number: "Ingrese solo digitos con 2 decimales" },
			existencia:{ required: "Ingrese Cantidad o Existencia", number: "Ingrese solo digitos" },
            stockminimo:{ required: "Ingrese Stock Minimo", number: "Ingrese solo digitos" },
            stockmaximo:{ required: "Ingrese Stock Maximo", number: "Ingrese solo digitos" },
			ivaproducto:{ required: "Seleccione Impuesto" },
			descproducto:{ required: "Ingrese Descuento", number: "Ingrese solo digitos con 2 decimales" },
			codigobarra: { required: "Ingrese C&oacute;digo de Barra" },
			lote:{ required: "Ingrese N&deg; de Lote" },
			fechaelaboracion: { required: "Ingrese Fecha de Elaboraci&oacute;n" },
			fechaexpiracion: { required: "Ingrese Fecha de Expiraci&oacute;n" },
			codproveedor: { required: "Seleccione Proveedor" },
			favorito: { required: "Seleccione Favorito" },
			controlstockp: { required: "Requerido" },
       },
	   submitHandler: function(form) {
                     		
   	        var data = $("#updateproductos").serialize();
			var formData = new FormData($("#updateproductos")[0]);

			var cant = $('#existencia').val();
			var compra = $('#preciocompra').val();
			var venta = $('#precioventa').val();
			cantidad    = parseInt(cant);

        if (venta==0.00 || venta==0) {
            
			$("#precioventa").focus();
			$('#precioventa').val("");
			$('#precioventa').css('border-color','#f0ad4e');
			swal("Oops", "INGRESE UN COSTO VALIDO PARA EL PRECIO DE VENTA DE PRODUCTO!", "error");

            return false;

        } else if (parseFloat(compra) > parseFloat(venta)) {
            
			$("#precioventa").focus();
			$("#preciocompra").focus();
			$('#precioventa').css('border-color','#f0ad4e');
			$('#preciocompra').css('border-color','#f0ad4e');
			swal("Oops", "EL PRECIO DE COMPRA NO PUEDE SER MAYOR QUE EL PRECIO DE VENTA DEL PRODUCTO!", "error");
     
            return false;
 
        } else {
			
			$.ajax({
			type : 'POST',
			url  : 'forproducto.php',
		    async : false,
			data : formData,
			//necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
									
								});
							}    
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> INGRESE UNA RACION VALIDA PARA INGREDIENTE, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
																			
								});
							} 
							else if(data==3){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> ESTE PRODUCTO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
																			
								});
							}
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'success',
             timeout: 5000, });
			 $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
			 setTimeout("location.href='productos'", 5000);	
								});
							}
					   }
			});
			return false;
			}
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR ACTUALIZACION DE PRODUCTOS */

/* FUNCION JQUERY PARA VALIDAR AGREGAR INGREDIENTES A PRODUCTOS */	  
$('document').ready(function()
{ 
     /* validation */
	 $("#agregaingredientes").validate({
	  rules:
	  {
			codproducto: { required: true, },
	   },
       messages:
	   {
			codproducto: { required: "Ingrese C&oacute;digo" },
       },
	   submitHandler: function(form) {
                     		
	    var data = $("#agregaingredientes").serialize();
		var formData = new FormData($("#agregaingredientes")[0]);
	    var nuevaFila ="<tr>"+"<td class='text-center' colspan=6><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
		var id= $("#agregaingredientes").attr("data-id");
        var producto = id;
        var codproducto = $('#producto').val();				
		
		$.ajax({
		type : 'POST',
		url  : 'foragregaingredientes.php?codproducto='+producto,
	    async : false,
		data : formData,
		//necesario para subir archivos via ajax
        cache: false,
        contentType: false,
        processData: false,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success :  function(data)
				   {						
						if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Agregar');
								
							});
						}     
						else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> INGRESE UNA RACION VALIDA PARA INGREDIENTE, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Agregar');
																		
							});
						}   
						else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> LA CANTIDAD DE INGREDIENTES ASIGNADOS NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Agregar');
																		
							});
						} 
						else{
								
			$("#save").fadeIn(1000, function(){
								
		 var n = noty({
		 text: '<center> '+data+' </center>',
         theme: 'defaultTheme',
         layout: 'center',
         type: 'success',
         timeout: 5000, });
		 $("#agregaingredientes")[0].reset();
		$("#carrito tbody").html("");
		$(nuevaFila).appendTo("#carrito tbody");
         $("#cargaingredientes").load("funciones.php?BuscaIngredienteAgregados=si&codproducto="+codproducto);
		 $("#btn-submit").html('<span class="fa fa-save"></span> Agregar');
							});
						}
				   }
		});
		return false;
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR AGREGAR INGREDIENTES A PRODUCTOS */



/* FUNCION JQUERY PARA VALIDAR SUMAR DE STOCK A PRODUCTO  */	 
$('document').ready(function()
{ 
     /* validation */
	 $("#savestockproducto").validate({
      rules:
	  {
			cantidad: { required: true, number : true},
	   },
       messages:
	   {
			cantidad:{ required: "Ingrese Cantidad a Sumar", number: "Ingrese solo digitos con 2 decimales" },
       },
	   submitHandler: function(form) {
                     		
			var data = $("#savestockproducto").serialize();
			
			$.ajax({
			type : 'POST',
			url  : 'productos.php',
		    async : false,
			data : data,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
									
								});
							}   
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> DEBE DE INGRESAR UNA CANTIDAD VALIDA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																			
								});
							}
							 else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 5000, });
             $('body').removeClass('modal-open');
             $('#myModalStock').modal('hide');
			 $("#savestockproducto")[0].reset();
			 $('#productos').html("");
			 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
			 $('#productos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
			 setTimeout(function() {
			 	$('#productos').load("consultas?CargaProductos=si");
			 }, 2000);
									
								});
							}
					   }
				});
				return false;
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR SUMAR DE STOCK A PRODUCTO */





















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE COMBOS */	  
$('document').ready(function()
{ 
    /* validation */
    $("#savecombos").validate({
	    rules:
	    {
			codcombo: { required: true, },
			nomcombo: { required: true,},
			preciocompra: { required: true, number : true},
			precioventa: { required: true, number : true},
			existencia: { required: true, number : true },
			stockminimo: { required: true, number : true },
			stockmaximo: { required: true, number : true },
			ivacombo: { required: true, },
			desccombo: { required: true, number : true },
	    },
        messages:
	    {
			codcombo: { required: "Ingrese C&oacute;digo" },
			nomcombo:{ required: "Ingrese Nombre o Descripci&oacute;n" },
			preciocompra:{ required: "Ingrese Precio de Compra", number: "Ingrese solo digitos con 2 decimales" },
			precioventa:{ required: "Ingrese Precio de Venta", number: "Ingrese solo digitos con 2 decimales" },
			existencia:{ required: "Ingrese Cantidad o Existencia", number: "Ingrese solo digitos" },
            stockminimo:{ required: "Ingrese Stock Minimo", number: "Ingrese solo digitos" },
            stockmaximo:{ required: "Ingrese Stock Maximo", number: "Ingrese solo digitos" },
			ivacombo:{ required: "Seleccione Impuesto" },
			desccombo:{ required: "Ingrese Descuento", number: "Ingrese solo digitos con 2 decimales" },
        },
	    submitHandler: function(form) {
                     		
	   	var data = $("#savecombos").serialize();
	   	var formData = new FormData($("#savecombos")[0]);
	   	var nuevaFila ="<tr>"+"<td class='text-center' colspan=6><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
	   	var cant = $('#existencia').val();
	   	var compra = $('#preciocompra').val();
	   	var venta = $('#precioventa').val();
	   	cantidad    = parseInt(cant);
	
	        if (venta==0.00 || venta==0) {
	            
				$("#precioventa").focus();
				$('#precioventa').val("");
				$('#precioventa').css('border-color','#f0ad4e');
				swal("Oops", "INGRESE UN COSTO VALIDO PARA EL PRECIO DE VENTA DE PRODUCTO!", "error");
         
                return false;

            } else if (parseFloat(compra) > parseFloat(venta)) {
	            
				$("#precioventa").focus();
				$("#preciocompra").focus();
				$('#precioventa').css('border-color','#f0ad4e');
				$('#preciocompra').css('border-color','#f0ad4e');
				swal("Oops", "EL PRECIO DE COMPRA NO PUEDE SER MAYOR QUE EL PRECIO DE VENTA DEL PRODUCTO!", "error");
         
                return false;
	 
	        } else {
				
			$.ajax({
			type : 'POST',
			url  : 'forcombo.php',
		    async : false,
			data : formData,
			//necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
									
								});
							}    
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> LA CANTIDAD DE PRODUCTOS ASIGNADOS NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																			
								});
							}    
							else if(data==3){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> INGRESE UNA CANTIDAD VALIDA PARA PRODUCTO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																			
								});
							}
							else if(data==4){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> ESTE COMBO YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																			
								});
							}
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 5000, });
			 $("#savecombos")[0].reset();
			 $("#carrito tbody").html("");
			 $(nuevaFila).appendTo("#carrito tbody");
			 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');	
								});
							}
					   }
			});
			return false;
			}
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE COMBOS */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE COMBOS */	  
$('document').ready(function()
{ 
    /* validation */
	$("#updatecombos").validate({
	    rules:
	    {
			codcombo: { required: true, },
			nomcombo: { required: true,},
			preciocompra: { required: true, number : true},
			precioventa: { required: true, number : true},
			existencia: { required: true, number : true },
			stockminimo: { required: true, number : true },
			stockmaximo: { required: true, number : true },
			ivacombo: { required: true, },
			desccombo: { required: true, number : true },
	    },
        messages:
	    {
			codcombo: { required: "Ingrese C&oacute;digo" },
			nomcombo:{ required: "Ingrese Nombre o Descripci&oacute;n" },
			preciocompra:{ required: "Ingrese Precio de Compra", number: "Ingrese solo digitos con 2 decimales" },
			precioventa:{ required: "Ingrese Precio de Venta", number: "Ingrese solo digitos con 2 decimales" },
			existencia:{ required: "Ingrese Cantidad o Existencia", number: "Ingrese solo digitos" },
            stockminimo:{ required: "Ingrese Stock Minimo", number: "Ingrese solo digitos" },
            stockmaximo:{ required: "Ingrese Stock Maximo", number: "Ingrese solo digitos" },
			ivacombo:{ required: "Seleccione Impuesto" },
			desccombo:{ required: "Ingrese Descuento", number: "Ingrese solo digitos con 2 decimales" },
        },
	    submitHandler: function(form) {
                     		
	   	    var data = $("#updatecombos").serialize();
			var formData = new FormData($("#updatecombos")[0]);
			var id= $("#updatecombos").attr("data-id");
			var combo = id;
			var codcombo = $('#codcombo').val();
			var cant = $('#existencia').val();
			var compra = $('#preciocompra').val();
			var venta = $('#precioventa').val();
			cantidad    = parseInt(cant);
	
	        if (venta==0.00 || venta==0) {
	            
				$("#precioventa").focus();
				$('#precioventa').val("");
				$('#precioventa').css('border-color','#f0ad4e');
				swal("Oops", "INGRESE UN COSTO VALIDO PARA EL PRECIO DE VENTA DE COMBO!", "error");

                return false;
	 
	        } else {
				
		    $.ajax({
		    type : 'POST',
		    url  : 'forcombo.php?codcombo='+combo,
		    async : false,
			data : formData,
			//necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
									
								});
							}  
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> INGRESE UNA CANTIDAD VALIDA PARA PRODUCTO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
																			
								});
							}
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'success',
             timeout: 5000, });
			 $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
			 setTimeout("location.href='combos'", 5000);	
								});
							}
					   }
			});
			return false;
			}
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR ACTUALIZACION DE COMBOS */

/* FUNCION JQUERY PARA VALIDAR AGREGAR PRODUCTOS A COMBOS */	  
$('document').ready(function()
{ 
     /* validation */
	 $("#agregaproductos").validate({
	  rules:
	  {
			codproducto: { required: true, },
	   },
       messages:
	   {
			codproducto: { required: "Ingrese C&oacute;digo" },
       },
	   submitHandler: function(form) {
                     		
	   	var data = $("#agregaproductos").serialize();
	    var formData = new FormData($("#agregaproductos")[0]);
	   	var nuevaFila ="<tr>"+"<td class='text-center' colspan=6><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
		var id= $("#agregaproductos").attr("data-id");
        var combo = id;
        var codcombo = $('#combo').val();
		
		$.ajax({
		type : 'POST',
		url  : 'foragregaproductos.php?codcombo='+combo,
	    async : false,
		data : formData,
		//necesario para subir archivos via ajax
        cache: false,
        contentType: false,
        processData: false,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success :  function(data)
				   {						
						if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Agregar');
								
							});
						}
						else if(data==2){
						
		$("#save").fadeIn(1000, function(){
						
	 var n = noty({
     text: "<span class='fa fa-warning'></span> INGRESE UNA CANTIDAD VALIDA PARA PRODUCTO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
     theme: 'defaultTheme',
     layout: 'center',
     type: 'warning',
     timeout: 5000, });
	$("#btn-submit").html('<span class="fa fa-save"></span> Agregar');
																	
						});
					}    
					else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> LA CANTIDAD DE PRODUCTOS ASIGNADOS NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Agregar');
																		
							});
						}
						else{
								
			$("#save").fadeIn(1000, function(){
								
		 var n = noty({
		 text: '<center> '+data+' </center>',
         theme: 'defaultTheme',
         layout: 'center',
         type: 'success',
         timeout: 5000, });
		 $("#agregaproductos")[0].reset();
		$("#carrito tbody").html("");
		$(nuevaFila).appendTo("#carrito tbody");
         $("#cargaproductos").load("funciones.php?BuscaProductosAgregados=si&codcombo="+codcombo);
		 $("#btn-submit").html('<span class="fa fa-save"></span> Agregar');
							});
						}
				   }
		});
		return false;
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR AGREGAR PRODUCTOS A COMBOS */


/* FUNCION JQUERY PARA VALIDAR SUMAR DE STOCK A PRODUCTO  */	 
$('document').ready(function()
{ 
    /* validation */
	$("#savestockcombo").validate({
        rules:
	    {
			cantidad: { required: true, number : true},
	    },
        messages:
	    {
			cantidad:{ required: "Ingrese Cantidad a Sumar", number: "Ingrese solo digitos con 2 decimales" },
        },
	    submitHandler: function(form) {
                     		
		var data = $("#savestockcombo").serialize();
		
		$.ajax({
		type : 'POST',
		url  : 'combos.php',
	    async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success :  function(data)
				   {						
						if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
								
							});
						}   
						else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> DEBE DE INGRESAR UNA CANTIDAD VALIDA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
		$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																		
							});
						}
						 else{
								
			$("#save").fadeIn(1000, function(){
								
		 var n = noty({
		 text: '<center> '+data+' </center>',
         theme: 'defaultTheme',
         layout: 'center',
         type: 'information',
         timeout: 5000, });
         $('#myModalStock').modal('hide');
		 $("#savestockcombo")[0].reset();
		 $('#combos').html("");
		 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
		 $('#combos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
		 setTimeout(function() {
		 	$('#combos').load("consultas?CargaCombos=si");
		 }, 2000);
								
							});
						}
				   }
			});
			return false;
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR SUMAR DE STOCK A COMBO */






















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE PEDIDOS */	 	 
$('document').ready(function()
{ 
     /* validation */
	 $("#savepedidos").validate({
      rules:
	  {
			codproveedor: { required: true, },
			codpedido: { required: true, },
			observacionpedido: { required: true, },
			fechapedido: { required: true, },
			codigo: { required: true, },
	   },
       messages:
	   {
            codproveedor:{ required: "Seleccione Proveedor" },
            codpedido:{ required: "Ingrese C&oacute;digo de Pedido" },
            observacionpedido:{ required: "Ingrese Observaci&oacute;n de Pedido" },
			fechapedido:{ required: "Ingrese Fecha de Pedido" },
            codigo:{ required: "Seleccione Vendedor" },
       },
	   submitHandler: function(form) {
                     		
			var data = $("#savepedidos").serialize();
		    var nuevaFila ="<tr>"+"<td class='text-center' colspan=6><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
				
				$.ajax({
				type : 'POST',
				url  : 'forpedido.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
										
									});
								}  
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES PARA PEDIDO AL PROVEEDOR, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}
								else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 8000, });
				 $("#savepedidos")[0].reset();
				 $("#carrito tbody").html("");
				 $(nuevaFila).appendTo("#carrito tbody");
				 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');	
										
									});
								}
						   }
				});
				return false;
			}
	   /* form submit */	
    });    
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE PEDIDOS */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE PEDIDOS */	 
$('document').ready(function()
{ 
     /* validation */
$("#updatepedidos").validate({
       rules:
	  {
			codproveedor: { required: true, },
			codpedido: { required: true, },
			observacionpedido: { required: true, },
			fechapedido: { required: true, },
			codigo: { required: true, },
	   },
       messages:
	   {
            codproveedor:{ required: "Seleccione Proveedor" },
            codpedido:{ required: "Ingrese C&oacute;digo de Pedido" },
            observacionpedido:{ required: "Ingrese Observaci&oacute;n de Pedido" },
			fechapedido:{ required: "Ingrese Fecha de Pedido" },
            codigo:{ required: "Seleccione Vendedor" },
       },
	   submitHandler: function(form) {
                     		
			var data = $("#updatepedidos").serialize();
            var id= $("#updatepedidos").attr("data-id");
            var codpedido = $('#pedido').val();
            var codsucursal = $('#sucursal').val();
				
				$.ajax({
				type : 'POST',
				url  : 'forpedido.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}  
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> NO DEBEN DE EXISTIR DETALLES DE PEDIDOS CON CANTIDAD IGUAL A CERO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
																				
									});
								}
								else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 8000, });
				 $('#detallespedidosupdate').load("funciones.php?MuestraDetallesPedidosUpdate=si&codpedido="+codpedido+"&codsucursal="+codsucursal); 
				 $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
				 setTimeout("location.href='pedidos'", 5000);	
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR ACTUALIZACION DE PEDIDOS */


/* FUNCION JQUERY PARA VALIDAR AGREGAR DETALLES A PEDIDOS */	 
$('document').ready(function()
{ 
     /* validation */
$("#agregapedidos").validate({
       rules:
	  {
			codproveedor: { required: true, },
			codpedido: { required: true, },
			observacionpedido: { required: true, },
			fechapedido: { required: true, },
			codigo: { required: true, },
	   },
       messages:
	   {
            codproveedor:{ required: "Seleccione Proveedor" },
            codpedido:{ required: "Ingrese C&oacute;digo de Pedido" },
            observacionpedido:{ required: "Ingrese Observaci&oacute;n de Pedido" },
			fechapedido:{ required: "Ingrese Fecha de Pedido" },
            codigo:{ required: "Seleccione Vendedor" },
       },
	   submitHandler: function(form) {
                     		
			var data = $("#agregapedidos").serialize();
            var id= $("#agregapedidos").attr("data-id");
            var codpedido = $('#pedido').val();
            var codsucursal = $('#sucursal').val();
            var nuevaFila ="<tr>"+"<td class='text-center' colspan=6><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";

				
				$.ajax({
				type : 'POST',
				url  : 'forpedido.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-agregar").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-agregar").html('<span class="fa fa-plus"></span> Agregar');
										
									});
								}  
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES PARA PEDIDO AL PROVEEDOR, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-agregar").html('<span class="fa fa-plus"></span> Agregar');
																				
									});
								}    
								else if(data==3){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> NO DEBEN DE EXISTIR DETALLES DE PEDIDOS CON CANTIDAD IGUAL A CERO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-agregar").html('<span class="fa fa-plus"></span> Agregar');
																				
									});
								}
								else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 8000, });
				 $("#agregapedidos")[0].reset();
				 $("#carrito tbody").html("");
				 $(nuevaFila).appendTo("#carrito tbody");	 
				 $('#detallespedidosagregar').load("funciones.php?MuestraDetallesPedidosAgregar=si&codpedido="+codpedido+"&codsucursal="+codsucursal); 
				 $("#btn-agregar").html('<span class="fa fa-plus"></span> Agregar');
				 setTimeout("location.href='pedidos'", 5000);	
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
    }); 	   
});
/* FUNCION JQUERY PARA VALIDAR AGREGAR DETALLES A PEDIDOS */	 























/* FUNCION JQUERY PARA VALIDAR REGISTRO DE COMPRAS */	 	 
$('document').ready(function()
{ 
     /* validation */
	 $("#savecompras").validate({
        rules:
	    {
			codcompra: { required: true, },
			fechaemision: { required: true, },
			fecharecepcion: { required: true, },
			codproveedor: { required: true, },
			tipocompra: { required: true, },
			formacompra: { required: true, },
			fechavencecredito: { required: true, },
			observaciones: { required: false, },
	    },
        messages:
	    {
            codcompra:{ required: "Ingrese N&deg; de Compra" },
			fechaemision:{ required: "Ingrese Fecha de Emisi&oacute;n" },
			fecharecepcion:{ required: "Ingrese Fecha de Recepci&oacute;n" },
			codproveedor:{ required: "Seleccione Proveedor" },
			tipocompra:{ required: "Seleccione Tipo Compra" },
			formacompra:{ required: "Seleccione Forma de Pago" },
			fechavencecredito:{ required: "Ingrese Fecha Vence Cr&eacute;dito" },
			observaciones:{ required: "Ingrese Observaciones" },
        },
	   submitHandler: function(form) {
                     		
		var data = $("#savecompras").serialize();
	    var nuevaFila ="<tr>"+"<td class='text-center' colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
	    var total = $('#txtTotal').val();

        if (total==0.00) {
            
           $("#busquedaproductoc").focus();
           $('#busquedaproductoc').css('border-color','#f0ad4e');
           swal("Oops", "POR FAVOR AGREGUE DETALLES PARA CONTINUAR CON LA COMPRA DE PRODUCTOS!", "error");
   
           return false;
 
        } else {
			
			$.ajax({
			type : 'POST',
			url  : 'forcompra.php',
		    async : false,
			data : data,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
									
								});
							}  
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> LA FECHA DE VENCIMIENTO DE COMPRA A CREDITO, NO PUEDE SER MENOR QUE LA FECHA ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																			
								});
							} 
							else if(data==3){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES PARA COMPRAS DE PRODUCTOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																			
								});
							} 
							else if(data==4){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> ESTE CODIGO DE COMPRA YA SE ENCUENTRA REGISTRADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																			
								});
							}
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 8000, });
			 $("#savecompras")[0].reset();
			 $("#carrito tbody").html("");
			 $(nuevaFila).appendTo("#carrito tbody");
			 $("#lblsubtotal").text("0.00");
			 $("#lblsubtotal2").text("0.00");
			 $("#lbliva").text("0.00");
			 $("#lbldescuento").text("0.00");
			 $("#lbltotal").text("0.00");
			 $("#txtsubtotal").val("0.00");
			 $("#txtsubtotal2").val("0.00");
			 $("#txtIva").val("0.00");
			 $("#txtDescuento").val("0.00");
			 $("#txtTotal").val("0.00");
			 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');	
									
								});
							}
					   }
			});
				return false;
			 }
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE COMPRAS */


/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE COMPRAS */	 
$('document').ready(function()
{ 
     /* validation */
$("#updatecompras").validate({
        rules:
	    {
			codcompra: { required: true, },
			fechaemision: { required: true, },
			fecharecepcion: { required: true, },
			codproveedor: { required: true, },
			tipocompra: { required: true, },
			formacompra: { required: true, },
			fechavencecredito: { required: true, },
			observaciones: { required: false, },
	    },
        messages:
	    {
            codcompra:{ required: "Ingrese N&deg; de Compra" },
			fechaemision:{ required: "Ingrese Fecha de Emisi&oacute;n" },
			fecharecepcion:{ required: "Ingrese Fecha de Recepci&oacute;n" },
			codproveedor:{ required: "Seleccione Proveedor" },
			tipocompra:{ required: "Seleccione Tipo Compra" },
			formacompra:{ required: "Seleccione Forma de Pago" },
			fechavencecredito:{ required: "Ingrese Fecha Vence Cr&eacute;dito" },
			observaciones:{ required: "Ingrese Observaciones" },
        },
	    submitHandler: function(form) {
                     		
		var data = $("#updatecompras").serialize();
        var id= $("#updatecompras").attr("data-id");
        var codcompra = $('#compra').val();
        var status = $('#status').val();
			
			$.ajax({
			type : 'POST',
			url  : 'forcompra.php',
		    async : false,
			data : data,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
									
								});
							}  
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> LA FECHA DE VENCIMIENTO DE COMPRA A CREDITO, NO PUEDE SER MENOR QUE LA FECHA ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
																			
								});
							} 
							else if(data==3){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> NO DEBEN DE EXISTIR DETALLES DE COMPRAS CON CANTIDAD IGUAL A CERO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
																			
								});
							} 
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 8000, });
			 $('#detallescomprasupdate').load("funciones.php?MuestraDetallesComprasUpdate=si&codcompra="+codcompra); 
			 $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
			 if (status=="P") {
			 	setTimeout("location.href='compras'", 5000);
			 } else {
			 	setTimeout("location.href='cuentasxpagar'", 5000);
			 }
						
								});
							}
					   }
			});
			return false;
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR ACTUALIZACION DE COMPRAS */ 



















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE CLIENTES EN COTIZACIONES */	  
$('document').ready(function()
{ 
    jQuery.validator.addMethod("lettersonly", function(value, element) {
      return this.optional(element) || /^[a-zA-ZñÑáéíóúÁÉÍÓÚ,. ]+$/i.test(value);
    });

    /* validation */
	$("#clientecotizacion").validate({
        rules:
	    {
			tipocliente: { required: true, },
			documcliente: { required: false, },
			dnicliente: { required: true,  digits : false, minlength: 7 },
			nomcliente: { required: true, lettersonly: true },
			razoncliente: { required: true },
			girocliente: { required: true },
			tlfcliente: { required: false, },
			id_provincia: { required: false, },
			id_departamento: { required: false, },
			direccliente: { required: true, },
			emailcliente: { required: false, email: true },
			limitecredito: { required: true, number : true},
	    },
        messages:
	    {
			tipocliente: { required: "Seleccione Tipo de Cliente" },
			documcliente:{ required: "Seleccione Tipo de Documento" },
			dnicliente:{ required: "Ingrese N&deg; de Documento", digits: "Ingrese solo d&iacute;gitos", minlength: "Ingrese 7 d&iacute;gitos como m&iacute;nimo" },
            nomcliente:{ required: "Ingrese Nombre de Cliente", lettersonly: "Ingrese solo letras para Nombres" },
			razoncliente:{ required: "Ingrese Raz&oacute;n Social" },
			girocliente:{ required: "Ingrese Giro de Cliente" },
			tlfcliente: { required: "Ingrese N&deg; de Tel&eacute;fono" },
			id_provincia:{ required: "Seleccione Provincia" },
			id_departamento: { required: "Seleccione Departamento" },
			direccliente: { required: "Ingrese Direcci&oacute;n Domiciliaria" },
			emailcliente:{ required: "Ingrese Email de Cliente", email: "Ingrese un Email V&aacute;lido" },
			limitecredito:{ required: "Ingrese Limite de Cr&eacute;dito", number: "Ingrese solo digitos con 2 decimales" },
        }, 
	    submitHandler: function(form) {
	   			
			var data = $("#clientecotizacion").serialize();
			
			$.ajax({
			type : 'POST',
			url  : 'forcotizacion.php',
		    async : false,
			data : data,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-cliente").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-cliente").html('<span class="fa fa-save"></span> Guardar');
									
								});
							}  
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> YA EXISTE UN CLIENTE CON ESTE N&deg; DE DOCUMENTO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-cliente").html('<span class="fa fa-save"></span> Guardar');
																			
								});
							}
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 5000, });
             $('body').removeClass('modal-open');
             $('#myModalCliente').modal('hide');
			 $("#clientecotizacion")[0].reset();
			 $("#btn-cliente").html('<span class="fa fa-save"></span> Guardar');
								});
							}
					   }
			});
			return false;
		}
	   /* form submit */	
    });    
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE CLIENTES EN COTIZACIONES */

/* FUNCION JQUERY PARA VALIDAR REGISTRO DE COTIZACIONES */	 	 
$('document').ready(function()
{ 
     /* validation */
	 $("#savecotizaciones").validate({
      rules:
	  {
			busqueda: { required: false },
			codcotizacion: { required: true },
			observaciones: { required: false },
			fechacotizacion: { required: true },
	   },
       messages:
	   {
            busqueda:{ required: "Realice la B&uacute;squeda del Cliente correctamente" },
            codcotizacion:{ required: "Ingrese C&oacute;digo de Cotizaci&oacute;n" },
			observaciones: { required: "Ingrese Observaciones en Cotizaci&oacute;n" },
			fechacotizacion:{ required: "Ingrese Fecha de Pedido" },
       },
	   submitHandler: function(form) {
	   			
			var data = $("#savecotizaciones").serialize();
		    var nuevaFila ="<tr>"+"<td class='text-center' colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
		    var total = $('#txtTotal').val();
	
	    if (total==0.00) {
	            
	        $("#search_producto").focus();
            $('#search_producto').css('border-color','#ff7676');
            swal("Oops", "POR FAVOR AGREGUE DETALLES PARA CONTINUAR CON LA COTIZACION DE PRODUCTOS!", "error");

            return false;
	 
	    } else {
				
			$.ajax({
			type : 'POST',
			url  : 'forcotizacion.php',
		    async : false,
			data : data,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#submit_guardar").html('<button type="button" class="btn btn-warning"><i class="fa fa-refresh"></i> Verificando...</button>');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
             $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-warning"><span class="fa fa-save"></span> Guardar</button>');
									
								});
							}  
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES PARA COTIZACIONES DE PRODUCTOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
             $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-warning"><span class="fa fa-save"></span> Guardar</button>');
																			
								});
							}
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 8000, });
			 $("#savecotizaciones")[0].reset();
             $("#codcliente").val("0");
			 $("#carrito tbody").html("");
			 $(nuevaFila).appendTo("#carrito tbody");
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
			 $("#txtTotalCompra").val("0.00");
             $("#loadproductos").html(""); 
             $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-warning"><span class="fa fa-save"></span> Guardar</button>');
									
								});
							}
					   }
				});
				return false;
			}
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE COTIZACIONES */

/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE COTIZACIONES */	 
$('document').ready(function()
{ 
     /* validation */
$("#updatecotizaciones").validate({
       rules:
	  {
			busqueda: { required: false },
			codcotizacion: { required: true },
			observaciones: { required: false },
			fechacotizacion: { required: true },
	   },
       messages:
	   {
            busqueda:{ required: "Realice la B&uacute;squeda del Cliente correctamente" },
            codcotizacion:{ required: "Ingrese C&oacute;digo de Cotizaci&oacute;n" },
			observaciones: { required: "Ingrese Observaciones en Cotizaci&oacute;n" },
			fechacotizacion:{ required: "Ingrese Fecha de Pedido" },
       },
	   submitHandler: function(form) {
	   			
			var data = $("#updatecotizaciones").serialize();
            var id= $("#updatecotizaciones").attr("data-id");
            var codcotizacion = $('#cotizacion').val();
				
			$.ajax({
			type : 'POST',
			url  : 'forcotizacion.php',
		    async : false,
			data : data,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#submit_update").html('<button type="button" class="btn btn-warning"><i class="fa fa-refresh"></i> Verificando...</button>');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
             $("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-warning"><span class="fa fa-edit"></span> Actualizar</button>');
									
								});
							}    
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> NO DEBEN DE EXISTIR DETALLES DE COTIZACIONES CON CANTIDAD IGUAL A CERO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
             $("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-warning"><span class="fa fa-edit"></span> Actualizar</button>');
																			
								});
							}
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 8000, });
			 $('#detallescotizacionesupdate').load("funciones.php?MuestraDetallesCotizacionesUpdate=si&codcotizacion="+codcotizacion); 
             $("#submit_update").html('<button type="submit" name="btn-update" id="btn-update" class="btn btn-warning"><span class="fa fa-edit"></span> Actualizar</button>');
			 setTimeout("location.href='cotizaciones'", 5000);											
						});
					}
				}
			});
			return false;
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR ACTUALIZACION DE COTIZACIONES */


/* FUNCION JQUERY PARA VALIDAR AGREGAR DETALLES A COTIZACIONES */	 
$('document').ready(function()
{ 
     /* validation */
$("#agregacotizaciones").validate({
       rules:
	  {
			busqueda: { required: false },
			codcotizacion: { required: true },
			observaciones: { required: false },
			fechacotizacion: { required: true },
	   },
       messages:
	   {
            busqueda:{ required: "Realice la B&uacute;squeda del Cliente correctamente" },
            codcotizacion:{ required: "Ingrese C&oacute;digo de Cotizaci&oacute;n" },
			observaciones: { required: "Ingrese Observaciones en Cotizaci&oacute;n" },
			fechacotizacion:{ required: "Ingrese Fecha de Pedido" },
       },
	   submitHandler: function(form) {
	   			
			var data = $("#agregacotizaciones").serialize();
            var id= $("#agregacotizaciones").attr("data-id");
            var codcotizacion = $('#cotizacion').val();
            var nuevaFila ="<tr>"+"<td class='text-center' colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
				
			$.ajax({
			type : 'POST',
			url  : 'forcotizacion.php',
		    async : false,
			data : data,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#submit_agregar").html('<button type="button" class="btn btn-warning"><i class="fa fa-refresh"></i> Verificando...</button>');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
             $("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-warning"><span class="fa fa-plus-circle"></span> Agregar</button>');
									
								});
							}  
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES PARA COTIZACIONES AL CLIENTE, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
             $("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-warning"><span class="fa fa-plus-circle"></span> Agregar</button>');
																			
								});
							}    
							else if(data==3){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> NO DEBEN DE EXISTIR DETALLES DE COTIZACIONES CON CANTIDAD IGUAL A CERO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
             $("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-warning"><span class="fa fa-plus-circle"></span> Agregar</button>');
																			
								});
							}
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 8000, });
			 $("#agregacotizaciones")[0].reset();
			 $("#carrito tbody").html("");
			 $(nuevaFila).appendTo("#carrito tbody");
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
			 $("#txtTotalCompra").val("0.00");
             $("#loadproductos").html(""); 
			 $('#detallescotizacionesagregar').load("funciones.php?MuestraDetallesCotizacionesAgregar=si&codcotizacion="+codcotizacion);  
             $("#submit_agregar").html('<button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-warning"><span class="fa fa-plus-circle"></span> Agregar</button>');
			 setTimeout("location.href='cotizaciones'", 5000);	
								});
							}
					   }
			});
			return false;
		}
	   /* form submit */	
    });    
});
/* FUNCION JQUERY PARA VALIDAR AGREGAR DETALLES A COTIZACIONES */	 

/* FUNCION JQUERY PARA PROCESAR COTIZACION A VENTA */	 	 
$('document').ready(function()
{ 
        /* validation */
	    $("#procesacotizacion").validate({
        rules:
	    {
			busqueda: { required: false, },
			tipodocumento: { required: true, },
			repartidores: { required: false, },
			montodelivery: { required: false, },
			tipopago: { required: true, },
			formapago: { required: true, },
			montopagado: { required: true, },
			formapago2: { required: false, },
			montopagado2: { required: true, },
			fechavencecredito: { required: true, },
			medioabono: { required: false, },
			montoabono: { required: true, },
			bancoemisor: { required: true, },
			tipotarjeta: { required: true, },
			digitos: { required: true, digits : true, minlength: 4, maxlength: 4},
			nomresponsable: { required: true, },
			observaciones: { required: false, },
	    },
        messages:
	    {
            busqueda:{ required: "Realice la B&uacute;squeda del Cliente correctamente" },
			tipodocumento:{ required: "Seleccione Tipo de Documento" },
			repartidores:{ required: "Seleccione Repartidor de Pedido" },
			montodelivery:{ required: "Ingrese Monto Delivery" },
			tipopago:{ required: "Seleccione Condici&oacute;n de Pago" },
			formapago:{ required: "Seleccione Forma de Pago" },
			montopagado:{ required: "Ingrese Monto Pagado" },
			formapago2:{ required: "Seleccione Forma de Pago" },
			montopagado:{ required: "Ingrese Monto de Pago" },
			fechavencecredito:{ required: "Ingrese Fecha Vence Cr&eacute;dito" },
			medioabono:{ required: "Seleccione Medio de Abono" },
			montoabono:{ required: "Ingrese Monto de Abono" },
			bancoemisor:{ required: "Ingrese Nombre de Banco" },
			tipotarjeta:{ required: "Seleccione Tipo de Tarjeta" },
            digitos:{ required: "Ingrese &Uacute;timo 4 Digitos", digits: "Ingrese solo digitos", minlength: "Ingrese 4 digitos como minimo", maxlength: "Ingrese 4 digitos como maximo" },
			nomresponsable:{ required: "Ingrese Nombre Responsable" },
			observaciones: { required: "Ingrese Observaciones en Venta" },
        },
	    submitHandler: function(form) {
	   			
			var data = $("#procesacotizacion").serialize();
		    var nuevaFila ="<tr>"+"<td class='text-center' colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
		    var codcliente = $('input#codcliente').val();
		    var TipoDocumento = $('input:radio[name=tipodocumento]:checked').val();
		    var FormaPago = $('select#formapago').val();
		    var MontoPagado = $('input#montopagado').val();
		    var FormaPago2 = $('select#formapago2').val();
		    var MontoPagado2 = $('input#montopagado2').val();
		    var TxtImporte = $('input#txtImporte').val();
		    var TotalPago = parseFloat(TxtImporte);
		    var TotalPagado = parseFloat(MontoPagado) + parseFloat(MontoPagado2);

		    var MedioAbono = $('select#medioabono').val();
		    var TotalAbono = $('input#montoabono').val();
		    var CreditoInicial = $('input#creditoinicial').val();
		    var CreditoDisponible = $('input#creditodisponible').val();
		    var TipoPago = $('input:radio[name=tipopago]:checked').val();
		    var criterio = $('#criterio').val();

		if (TipoDocumento=="FACTURA" && codcliente=="0") {

            swal("Oops", "POR FAVOR ASIGNE UN CLIENTE PARA LA FACTURA DE VENTA!", "error");
            return false;
	 
	    } else if ($('input#txtImporte').val()==0.00 || $('input#txtImporte').val()==0 || $('input#txtImporte').val()=="") {

            swal("Oops", "POR FAVOR AGREGUE DETALLES DE PRODUCTOS PARA CONTINUAR CON LA VENTA!", "error");
            return false;
	 
	    } else if (TipoPago == "CONTADO" && FormaPago == FormaPago2){ 
	            
	        $('select#formapago2').focus();
            $('select#formapago2').css('border-color','#f0ad4e');
            swal("Oops", "LAS FORMAS DE PAGO NO DEBEN DE COINCIDIR, VERIFIQUE NUEVAMENTE POR FAVOR!", "error");
            return false;
	 
	    } else if (TipoPago == "CONTADO" && FormaPago != "" && FormaPago2 != "" && parseFloat(TotalPagado) > parseFloat(TotalPago)){ 
	            
	        $('input#montopagado').focus();
            $('input#montopagado').css('border-color','#f0ad4e');
            swal("Oops", "EL MONTO RECIBIDO NO PUEDE SER MAYOR AL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR!", "error");

            return false;
	 
	    } else if (TipoPago == "CONTADO" && FormaPago != "" && FormaPago2 == "" && parseFloat(TotalPagado) < parseFloat(TotalPago)){ 
	            
	        $('input#montopagado').focus();
            $('input#montopagado').css('border-color','#f0ad4e');
            swal("Oops", "POR FAVOR COMPLETE EL MONTO TOTAL A PAGAR, VERIFIQUE NUEVAMENTE POR FAVOR!", "error");

            return false;
	 
	    } else if (TipoPago == "CONTADO" && parseFloat(TotalPagado) < parseFloat(TotalPago)){ 
	            
	        $('input#montopagado').focus();
            $('input#montopagado').css('border-color','#f0ad4e');
            swal("Oops", "EL MONTO TOTAL A PAGAR NO PUEDE SER MAYOR AL MONTO CANCELADO, VERIFIQUE NUEVAMENTE POR FAVOR!", "error");

            return false;
	 
	    } else if (TipoPago == "CREDITO" && TotalAbono != "0.00" && MedioAbono == "") {
	            
	        $("select#medioabono").focus();
            $('select#medioabono').css('border-color','#f0ad4e');
            swal("Oops", "SELECCIONE LA FORMA DE ABONO A ESTA VENTA!", "error");

            return false;
	 
	    } else if (TipoPago == "CREDITO" && CreditoInicial != "0.00" && parseFloat(TotalPago-TotalAbono) > parseFloat(CreditoDisponible)) {
	            
	        $("input#TotalAbono").focus();
            $('input#TotalAbono').css('border-color','#f0ad4e');
            swal("Oops", "SE HA EXCEDIDO DEL LIMITE DE CREDITO PARA COMPRAS DE PRODUCTOS, VERIFIQUE Y CANCELE SUS DEUDAS POR FAVOR!", "error");

            return false;
	 
	    } else if (TipoPago == "CREDITO" && parseFloat(TotalAbono) >= parseFloat(TotalPago)) {
	            
	        $("input#TotalAbono").focus();
            $('input#TotalAbono').css('border-color','#f0ad4e');
            swal("Oops", "EL ABONO DE CREDITO NO PUEDE SER MAYOR O IGUAL QUE EL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR!", "error");

            return false;
	 
	    } else {
	 				
		$.ajax({
		type : 'POST',
		url  : 'cotizaciones.php',
	    async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#submit_guardar").html('<button type="button" class="btn btn-warning"><i class="fa fa-refresh"></i> Verificando...</button>');
		},
		success :  function(data)
				   {						
						if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> DEBE DE REALIZAR EL ARQUEO DE SU CAJA ASIGNADA PARA PROCESAR LA COTIZACION A VENTA, VERIFIQUE NUEVAMENTE POR FAVOR...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
	    $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-warning"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
								
							});
						}   
						else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
	    $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-warning"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
							});
						} 
						else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES DE PRODUCTOS PARA CERRAR ESTA VENTA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
	    $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-warning"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
							});
						}
						else if(data==4){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> EL MONTO TOTAL A PAGAR NO PUEDE SER MAYOR AL MONTO CANCELADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
	    $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-warning"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
							});
						}  
						else if(data==5){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> POR FAVOR ASIGNE UN CLIENTE PARA LA FACTURA DE VENTA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
	    $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-warning"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
							});
						} 
						else if(data==6){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> LA CANTIDAD PROCESADA NO SE EN CUENTRA DISPONIBLE EN STOCK, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
	    $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-warning"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
							});
						} 
						else if(data==7){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> LAS FACTURAS SERAN ENTREGADAS SOLO A CLIENTES JURIDICOS, VERIFIQUE SU CREDITO DISPONIBLE POR FAVOR ...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
	    $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-warning"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
							});
						}  
						else if(data==8){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> POR FAVOR ASIGNE UN CLIENTE A ESTA VENTA DE CREDITO PARA CONTROL DE ABONOS DEL MISMO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
	    $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-warning"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
							});
						}
						else if(data==9){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> LA FECHA DE VENCIMIENTO DE CREDITO NO PUEDER SER MENOR QUE LA ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
	    $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-warning"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
							});
						}
						else if(data==10){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> SELECCIONE EL MEDIO DE ABONO A ESTA VENTA DE CREDITO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
	    $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-warning"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
							});
						}
						else if(data==11){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> SE HA EXCEDIDO DEL LIMITE DE CREDITO PARA COMPRAS DE PRODUCTOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
	    $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-warning"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
							});
						}
						else if(data==12){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> EL ABONO DE CREDITO NO PUEDE SER MAYOR O IGUAL QUE EL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
	    $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-warning"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
																		
							});
						}
						else{
								
			$("#save").fadeIn(1000, function(){
								
		 var n = noty({
		 text: '<center> '+data+' </center>',
         theme: 'defaultTheme',
         layout: 'center',
         type: 'information',
         timeout: 8000, });
		 $("#procesacotizacion")[0].reset();
         $("#codcliente").val("0");
         $("#TextImporte").text("0");
         $("#TextPagado").text("0");
         $("#TextCambio").text("0");
         $('body').removeClass('modal-open');
         $('#myModalPago').modal('hide');
         $("#muestra_condiciones").load("funciones.php?BuscaCondicionesPagosCotizacion=si&tipopago=CONTADO&txtTotal=0.00");
		 $('#muestracotizaciones').load("search.php?CargaCotizaciones=si&bcotizaciones="+criterio);
	     $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-warning"><span class="fa fa-print"></span> Facturar e Imprimir</button>');
								
								});
							}
					   }
				});
				return false;
			}
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA PROCESAR COTIZACION A VENTA */




















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE CAJAS PARA VENTAS */	 
$('document').ready(function()
{ 
     /* validation */
	 $("#savecaja").validate({
      rules:
	  {
			nrocaja: { required: true, },
			nomcaja: { required: true, },
			codigo: { required: true, },
	   },
       messages:
	   {
			serie:{ required: "Ingrese Secuencia de Serie", digits: "Ingrese solo digitos", maxlength: "Ingrese 6 digitos como m&aacute;ximo" },
            nrocaja:{ required: "Ingrese N&deg; de Caja" },
            nomcaja:{ required: "Ingrese Nombre de Caja" },
			codigo:{ required: "Seleccione Responsable de Caja" },
       },
	   submitHandler: function(form) {
                     		
				var data = $("#savecaja").serialize();
				
				$.ajax({
				type : 'POST',
				url  : 'cajas.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
										
									});
								} 
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ESTE N&deg; DE CAJA YA SE ENCUENTRA ASIGNADA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								} 
								else if(data==3){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ESTE NOMBRE DE CAJA YA SE ENCUENTRA ASIGNADA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}
								else if(data==4){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ESTE USUARIO YA TIENE UNA CAJA ASIGNADA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}
								 else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000, });
                 $('body').removeClass('modal-open');
                 $('#myModalCajas').modal('hide');
				 $("#savecaja")[0].reset();
                 $("#proceso").val("save");
				 $('#cajas').html("");
				 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
				 $('#cajas').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
				 setTimeout(function() {
				 	$('#cajas').load("consultas?CargaCajas=si");
				 }, 2000);
										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE CAJAS PARA VENTAS */


















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE ARQUEO DE CAJAS */	 
$('document').ready(function()
{ 
     /* validation */
	 $("#savearqueo").validate({
      rules:
	  {
			codcaja: { required: true, },
			fecharegistro: { required: true, },
			montoinicial: { required: true, number : true},
	   },
       messages:
	   {
			codcaja: { required: "Seleccione Caja para Arqueo" },
			fecharegistro:{ required: "Ingrese Hora de Apertura", number: "Ingrese solo digitos con 2 decimales" },
			montoinicial:{ required: "Ingrese Monto Inicial", number: "Ingrese solo digitos con 2 decimales" },
       },
	   submitHandler: function(form) {
                     		
				var data = $("#savearqueo").serialize();
				
				$.ajax({
				type : 'POST',
				url  : 'arqueos.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
										
									});
								}   
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> YA EXISTE UN ARQUEO DE ESTA CAJA DE COBRO ACTUALMENTE, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}
								 else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000, });
                 $('body').removeClass('modal-open');
                 $('#myModalArqueo').modal('hide');
				 $("#savearqueo")[0].reset();
				 $('#arqueos').html("");
				 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
				 $('#arqueos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
				 setTimeout(function() {
				 	$('#arqueos').load("consultas?CargaArqueos=si");
				 }, 2000);
										
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE ARQUEO DE CAJAS */

/* FUNCION JQUERY PARA VALIDAR CERRAR ARQUEO DE CAJAS  */	 
$('document').ready(function()
{ 
     /* validation */
	 $("#savecerrararqueo").validate({
      rules:
	  {
			fecharegistro: { required: true, },
			montoinicial: { required: true, number : true},
			dineroefectivo: { required: true, number : true},
			comentarios: { required: false, },
	   },
       messages:
	   {
			fecharegistro:{ required: "Ingrese Hora de Apertura", number: "Ingrese solo digitos con 2 decimales" },
			montoinicial:{ required: "Ingrese Monto Inicial", number: "Ingrese solo digitos con 2 decimales" },
			dineroefectivo:{ required: "Ingrese Monto en Efectivo", number: "Ingrese solo digitos con 2 decimales" },
			comentarios: { required: "Ingrese Observaci&oacute;n de Cierre" },
       },
	   submitHandler: function(form) {
                     		
				var data = $("#savecerrararqueo").serialize();
				var dineroefectivo = $('#dineroefectivo').val();
	
	        /*if (dineroefectivo==0.00 || dineroefectivo==0) {
	            
				$("#dineroefectivo").focus();
				$('#dineroefectivo').val("");
				$('#dineroefectivo').css('border-color','#f0ad4e');
				swal("Oops", "POR FAVOR INGRESE UN MONTO VALIDO PARA EFECTIVO DISPONIBLE EN CAJA!", "error");
         
                return false;
	 
	        } else {*/
				
				$.ajax({
				type : 'POST',
				url  : 'forcierre.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-save").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-save").html('<span class="fa fa-archive"></span> Cerrar Caja');
										
									});
								}   
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR INGRESE UN MONTO VALIDO PARA EFECTIVO DISPONIBLE EN CAJA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-save").html('<span class="fa fa-archive"></span> Cerrar Caja');
																				
									});
								}
								 else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000, });
				 $("#btn-save").attr('disabled', true);
				 $("#btn-save").html('<span class="fa fa-archive"></span> Cerrar Caja');
				 setTimeout("location.href='arqueos'", 3000);
										
									});
								}
						   }
				});
				return false;
			//}
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR CERRAR ARQUEO DE CAJAS */


















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE MOVIMIENTOS EN CAJAS */	 
$('document').ready(function()
{ 
     /* validation */
	 $("#savemovimiento").validate({
      rules:
	  {
			codcaja: { required: true, },
			tipomovimiento: { required: true, },
			descripcionmovimiento: { required: true, },
			montomovimiento: { required: true, number : true },
			mediomovimiento: { required: true, },
	   },
       messages:
	   {
			codcaja:{ required: "Seleccione Caja" },
            tipomovimiento:{ required: "Seleccione Tipo de Movimiento" },
			descripcionmovimiento:{ required: "Ingrese Descripci&oacute;n de Movimiento" },
			montomovimiento:{ required: "Ingrese Monto de Movimiento", number: "Ingrese solo digitos con 2 decimales" },
			mediomovimiento:{ required: "Seleccione Medio de Movimiento" },
       },
	   submitHandler: function(form) {
                     		
				var data = $("#savemovimiento").serialize();
				var monto = $('#montomovimiento').val();
	
	        if (monto==0.00 || monto==0) {
	            
				$("#montomovimiento").focus();
				$('#montomovimiento').val("");
				$('#montomovimiento').css('border-color','#f0ad4e');
				swal("Oops", "POR FAVOR INGRESE UN MONTO VALIDO PARA MOVIMIENTO EN CAJA!", "error");

                return false;

            } else {
				
				$.ajax({
				type : 'POST',
				url  : 'movimientos.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
										
									});
								}   
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR INGRESE UN MONTO VALIDO PARA MOVIMIENTO EN CAJA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}     
								else if(data==3){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> NO PUEDE REALIZAR CAMBIO EN EL TIPO Y MEDIO DE MOVIMIENTO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}  
								else if(data==4){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ESTA CAJA NO SE ENCUENTRA ABIERTA PARA REALIZAR MOVIMIENTOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}  
								else if(data==5){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> EL MOVIMIENTO DE EGRESO DEBE DE SER SOLO EFECTIVO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}  
								else if(data==6){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> EL MONTO A RETIRAR EN EFECTIVO NO EXISTE EN CAJA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}  
								else if(data==7){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> ESTE MOVIMIENTO NO PUEDE SER ACTUALIZADO, EL ARQUEO DE CAJA ASOCIADO SE ENCUENTRA CERRADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}  
								else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000, });
                 $('body').removeClass('modal-open');
                 $('#myModalMovimiento').modal('hide');
				 $("#savemovimiento")[0].reset();
                 $("#proceso").val("save");	
				 $('#movimientos').html("");
				 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
				 $('#movimientos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
				 setTimeout(function() {
				 	$('#movimientos').load("consultas?CargaMovimientos=si");
				 }, 2000);
										
									});
								}
						   }
				});
				return false;
			}		}
	   /* form submit */	
    });    
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE MOVIMIENTOS EN CAJAS */



























/* FUNCION JQUERY PARA VALIDAR REGISTRO DE CLIENTES EN MESA */	  
$('document').ready(function()
{ 
    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-zA-ZñÑáéíóúÁÉÍÓÚ,. ]+$/i.test(value);
    });

     /* validation */
	 $("#clienteventa").validate({
        rules:
	    {
			tipocliente: { required: true, },
			documcliente: { required: false, },
			dnicliente: { required: true,  digits : false, minlength: 7 },
			nomcliente: { required: true, lettersonly: true },
			razoncliente: { required: true },
			girocliente: { required: true },
			tlfcliente: { required: false, },
			id_provincia: { required: false, },
			id_departamento: { required: false, },
			direccliente: { required: true, },
			emailcliente: { required: false, email: true },
			limitecredito: { required: true, number : true},
	    },
        messages:
	    {
			tipocliente: { required: "Seleccione Tipo de Cliente" },
			documcliente:{ required: "Seleccione Tipo de Documento" },
			dnicliente:{ required: "Ingrese N&deg; de Documento", digits: "Ingrese solo d&iacute;gitos", minlength: "Ingrese 7 d&iacute;gitos como m&iacute;nimo" },
            nomcliente:{ required: "Ingrese Nombre de Cliente", lettersonly: "Ingrese solo letras para Nombres" },
			razoncliente:{ required: "Ingrese Raz&oacute;n Social" },
			girocliente:{ required: "Ingrese Giro de Cliente" },
			tlfcliente: { required: "Ingrese N&deg; de Tel&eacute;fono" },
			id_provincia:{ required: "Seleccione Provincia" },
			id_departamento: { required: "Seleccione Departamento" },
			direccliente: { required: "Ingrese Direcci&oacute;n Domiciliaria" },
			emailcliente:{ required: "Ingrese Email de Cliente", email: "Ingrese un Email V&aacute;lido" },
			limitecredito:{ required: "Ingrese Limite de Cr&eacute;dito", number: "Ingrese solo digitos con 2 decimales" },
        },
	    submitHandler: function(form) {
                     		
		var data = $("#clienteventa").serialize();
		
		$.ajax({
		type : 'POST',
		url  : 'panel.php',
	    async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			$("#btn-cliente").html('<i class="fa fa-refresh"></i> Verificando...');
		},
		success :  function(data)
				   {						
						if(data==1){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
		$("#btn-cliente").html('<span class="fa fa-save"></span> Guardar');
								
							});
						}  
						else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> YA EXISTE UN CLIENTE CON ESTE N&deg; DE DOCUMENTO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
		$("#btn-cliente").html('<span class="fa fa-save"></span> Guardar');
																		
							});
						}
						else{
								
			$("#save").fadeIn(1000, function(){
								
		 var n = noty({
		 text: '<center> '+data+' </center>',
         theme: 'defaultTheme',
         layout: 'center',
         type: 'information',
         timeout: 5000, });
         $('body').removeClass('modal-open');
         $('#myModalCliente').modal('hide');
		 $("#clienteventa")[0].reset();
		 $('#id_departamento').html("<option value=''>-- SIN RESULTADOS --</option>");	
		 $("#btn-cliente").html('<span class="fa fa-save"></span> Guardar');
							});
						}
				   }
			});
			return false;
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE CLIENTES EN MESA */

/* FUNCION JQUERY PARA VALIDAR REGISTRO DE PEDIDOS EN MESA */
$('document').ready(function()
{	
    /* validation */
	$("#saveventas").validate({
        rules:
	    {
			busqueda: { required: false, },
			observacionespedido: { required: false, },
	    },
        messages:
	    {
            busqueda:{ required: "Realice la B&uacute;squeda del Cliente correctamente" },
			observacionespedido: { required: "Ingrese Observaciones para el Pedido" },
        },
	    submitHandler: function(form) {
                     		
		var data = $("#saveventas").serialize();
	    var nuevaFila ="<tr>"+"<td class='text-center' colspan=5><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
	    var codpedido = $('input#pedido').val();
	    var codventa = $('input#venta').val();
	    var codmesa = $('input#mesa').val();
 				
		$.ajax({
		type : 'POST',
		url  : 'panel.php',
	    async : false,
		data : data,
		beforeSend: function()
		{	
			$("#save").fadeOut();
			var n = noty({
            text: "<span class='fa fa-refresh'></span> VERIFICANDO INFORMACI&Oacute;N, POR FAVOR ESPERE......",
            theme: 'defaultTheme',
            layout: 'center',
            type: 'information',
            timeout: 1000, });
			$("#submit_guardar").html('<button type="button" class="btn btn-warning btn-lg btn-block waves-effect waves-light"><i class="fa fa-save"></i> Confirmar</button>');
		},
		success :  function(data)
				   {						
						if(data==1){
							
			$("#save").fadeIn(500, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES DE PRODUCTOS PARA CONFIRMAR PEDIDO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
        $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-warning btn-lg btn-block waves-effect waves-light"><span class="fa fa-save"></span> Confirmar</button>');
																		
							});
						}
						else if(data==2){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> LA CANTIDAD SOLICITADA DE PRODUCTOS NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
        $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-warning btn-lg btn-block waves-effect waves-light"><span class="fa fa-save"></span> Confirmar</button>');
																									
							});
						}
						else if(data==3){
							
			$("#save").fadeIn(1000, function(){
							
		 var n = noty({
         text: "<span class='fa fa-warning'></span> ESTA MESA SE ENCUENTRA ACTIVA CON PEDIDOS POR PAGAR, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
         theme: 'defaultTheme',
         layout: 'center',
         type: 'warning',
         timeout: 5000, });
        $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-warning btn-lg btn-block waves-effect waves-light"><span class="fa fa-save"></span> Confirmar</button>');
																									
							});
						}
						else{
								
			$("#save").fadeIn(1000, function(){
								
		 var n = noty({
		 text: '<center> '+data+' </center>',
         theme: 'defaultTheme',
         layout: 'center',
         type: 'information',
         timeout: 8000, });
		 $("#saveventas")[0].reset();
		 $('#pedidos').load("detalles_mesas.php?CargaPedidosMesa=si&codmesa="+codmesa+"&codpedido="+codpedido);
		 $('#muestradetallemesa').load("detalles_mesas.php?BuscaPedidosMesa=si&codmesa="+codmesa+"&codpedido="+codpedido+"&codventa="+codventa);
         $('#loading').load("salas_mesas?CargaProductos=si");
         $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-warning btn-lg btn-block waves-effect waves-light"><span class="fa fa-save"></span> Confirmar</button>');
								
							});
						}
				   }
			   });
			return false;
			}
	   /* form submit */
      }); 
 });  
 /* FIN DE FUNCION PARA VALIDAR REGISTRO DE PEDIDOS EN MESA */

/* FUNCION JQUERY PARA VALIDAR CERRAR PEDIDOS EN MESA */
$('document').ready(function()
{	
    /* validation */
	$("#cerrarventa").validate({
        rules:
	    {
			busqueda: { required: false, },
			descuento: { required: true, number : true },
			tipodocumento: { required: true, },
			tipopago: { required: true, },
			formapago: { required: true, },
			totalpagado: { required: true, },
			formapago2: { required: false, },
			totalpagado2: { required: true, },
			formapropina: { required: false, },
			montopropina: { required: true, },
			fechavencecredito: { required: true, },
			medioabono: { required: false, },
			montoabono: { required: true, },
			observaciones: { required: false, },
	    },
        messages:
	    {
            busqueda:{ required: "Realice la B&uacute;squeda del Cliente correctamente" },
			descuento:{ required: "Ingrese Descuento", number: "Ingrese solo digitos con 2 decimales" },
			tipodocumento:{ required: "Seleccione Tipo de Documento" },
			tipopago:{ required: "Seleccione Condici&oacute;n de Pago" },
			formapago:{ required: "Seleccione Forma de Pago" },
			totalpagado:{ required: "Ingrese Monto Pagado" },
			formapago2:{ required: "Seleccione Forma de Pago" },
			totalpagado2:{ required: "Ingrese Monto de Pago" },
			formapropina:{ required: "Seleccione Forma de Propina" },
			montopropina:{ required: "Ingrese Monto Propina" },
			fechavencecredito:{ required: "Ingrese Fecha Vence Cr&eacute;dito" },
			medioabono:{ required: "Seleccione Medio de Abono" },
			montoabono:{ required: "Ingrese Monto de Abono" },
			observaciones: { required: "Ingrese Observaciones en Venta" },
        },
	    submitHandler: function(form) {
                     		
			var data = $("#cerrarventa").serialize();
		    var nuevaFila ="<tr>"+"<td class='text-center' colspan=5><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
		    var codcliente = $('input#codcliente').val();
		    var TipoDocumento = $('input:radio[name=tipodocumento]:checked').val();	
			var codmesa = $('input#mesa').val();
			var FormaPago = $('select#formapago').val();
		    var MontoPagado = $('input#montopagado').val();
		    var FormaPago2 = $('select#formapago2').val();
		    var MontoPagado2 = $('input#montopagado2').val();
		    var TxtImporte = $('input#txtImporte').val();
		    var TxtPropina = $('input#montopropina').val();
		    var TotalPago = parseFloat(TxtImporte);
		    var TotalPagado = parseFloat(MontoPagado) + parseFloat(MontoPagado2);

		    var MedioAbono = $('select#medioabono').val();
		    var TotalAbono = $('input#montoabono').val();
		    var CreditoInicial = $('input#creditoinicial').val();
		    var CreditoDisponible = $('input#creditodisponible').val();
		    var TipoPago = $('input:radio[name=tipopago]:checked').val();

		if (TipoDocumento=="FACTURA" && codcliente=="0") {

            swal("Oops", "POR FAVOR ASIGNE UN CLIENTE PARA LA FACTURA DE VENTA!", "error");
            return false;
	 
	    } else if ($('input#txtImporte').val()==0.00 || $('input#txtImporte').val()==0 || $('input#txtImporte').val()=="") {

	        $("input#busquedaproducto").focus();
            $('input#busquedaproducto').css('border-color','#f0ad4e');
            swal("Oops", "POR FAVOR AGREGUE DETALLES DE PRODUCTOS PARA CONTINUAR CON LA VENTA!", "error");

            return false;
	 
	    } else if (TipoPago == "CONTADO" && FormaPago == FormaPago2){ 
	            
	        $('select#formapago2').focus();
            $('select#formapago2').css('border-color','#f0ad4e');
            swal("Oops", "LAS FORMAS DE PAGO NO DEBEN DE COINCIDIR, VERIFIQUE NUEVAMENTE POR FAVOR!", "error");

            return false;
	 
	    } else if (TipoPago == "CONTADO" && FormaPago != "" && FormaPago2 != "" && parseFloat(TotalPagado) > parseFloat(TotalPago)){ 
	            
	        $('input#montopagado').focus();
            $('input#montopagado').css('border-color','#f0ad4e');
            swal("Oops", "EL MONTO RECIBIDO NO PUEDE SER MAYOR AL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR!", "error");

            return false;
	 
	    } else if (TipoPago == "CONTADO" && FormaPago != "" && FormaPago2 == "" && parseFloat(TotalPagado) < parseFloat(TotalPago)){ 
	            
	        $('input#montopagado').focus();
            $('input#montopagado').css('border-color','#f0ad4e');
            swal("Oops", "POR FAVOR COMPLETE EL MONTO TOTAL A PAGAR, VERIFIQUE NUEVAMENTE POR FAVOR!", "error");

            return false;
	 
	    } else if (TipoPago == "CONTADO" && parseFloat(TotalPagado) < parseFloat(TotalPago)){ 
	            
	        $('input#montopagado').focus();
            $('input#montopagado').css('border-color','#f0ad4e');
            swal("Oops", "EL MONTO TOTAL A PAGAR NO PUEDE SER MAYOR AL MONTO CANCELADO, VERIFIQUE NUEVAMENTE POR FAVOR!", "error");

            return false;
	 
	    } else if (TipoPago == "CREDITO" && TotalAbono != "0.00" && MedioAbono == "") {
	            
	        $("select#medioabono").focus();
            $('select#medioabono').css('border-color','#f0ad4e');
            swal("Oops", "Seleccione LA FORMA DE ABONO A ESTA VENTA!", "error");

            return false;
	 
	    } else if (TipoPago == "CREDITO" && CreditoInicial != "0.00" && parseFloat(TotalPago-TotalAbono) > parseFloat(CreditoDisponible)) {
	            
	        $("input#TotalAbono").focus();
            $('input#TotalAbono').css('border-color','#f0ad4e');
            swal("Oops", "SE HA EXCEDIDO DEL LIMITE DE CREDITO PARA COMPRAS DE PRODUCTOS, VERIFIQUE Y CANCELE SUS DEUDAS POR FAVOR!", "error");

            return false;
	 
	    } else if (TipoPago == "CREDITO" && parseFloat(TotalAbono) >= parseFloat(TotalPago)) {
	            
	        $("input#TotalAbono").focus();
            $('input#TotalAbono').css('border-color','#f0ad4e');
            swal("Oops", "EL ABONO DE CREDITO NO PUEDE SER MAYOR O IGUAL QUE EL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR!", "error");

            return false;
	 
	    } else {
	 				
			$.ajax({
			type : 'POST',
			url  : 'panel.php',
		    async : false,
			data : data,
			beforeSend: function()
			{	
				$("#save").fadeOut();
			    $("#submit_cerrar").html('<button type="button" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-refresh"></i> Procesando...</button>');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> DEBE DE REALIZAR EL ARQUEO DE CAJA ASIGNADA PARA PROCESAR COBROS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#submit_cerrar").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-print"></i> Facturar e Imprimir</button>');
									
								});
							}  
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#submit_cerrar").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-print"></i> Facturar e Imprimir</button>');
																			
								});
							}   
							else if(data==3){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES DE PRODUCTOS PARA CERRAR ESTA VENTA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#submit_cerrar").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-print"></i> Facturar e Imprimir</button>');
																			
								});
							}   
							else if(data==4){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> EL MONTO TOTAL A PAGAR NO PUEDE SER MAYOR AL MONTO CANCELADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#submit_cerrar").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-print"></i> Facturar e Imprimir</button>');
																			
								});
							}
							else if(data==5){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR ASIGNE UN CLIENTE PARA LA FACTURA DE VENTA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#submit_cerrar").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-print"></i> Facturar e Imprimir</button>');
																			
								});
							}  
							else if(data==6){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> LAS FACTURAS SERA ENTREGADA SOLO A CLIENTES JURIDICOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#submit_cerrar").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-print"></i> Facturar e Imprimir</button>');
																			
								});
							}
							else if(data==7){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR ASIGNE UN CLIENTE A ESTA VENTA DE CREDITO PARA CONTROL DE ABONOS DEL MISMO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#submit_cerrar").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-print"></i> Facturar e Imprimir</button>');
																			
								});
							}    
							else if(data==8){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> LA FECHA DE VENCIMIENTO DE CREDITO NO PUEDER SER MENOR QUE LA ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#submit_cerrar").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-print"></i> Facturar e Imprimir</button>');
																			
								});
							}   
							else if(data==9){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> SELECCIONE EL MEDIO DE ABONO A ESTA VENTA DE CREDITO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#submit_cerrar").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-print"></i> Facturar e Imprimir</button>');
																			
								});
							}
							else if(data==10){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> SE HA EXCEDIDO DEL LIMITE DE CREDITO PARA COMPRAS DE PRODUCTOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#submit_cerrar").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-print"></i> Facturar e Imprimir</button>');
																			
								});
							}  
							else if(data==11){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> EL ABONO DE CREDITO NO PUEDE SER MAYOR O IGUAL QUE EL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#submit_cerrar").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-print"></i> Facturar e Imprimir</button>');
																			
								});
							}  
							else if(data==12){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> HA OCURRIDO UN PROBLEMA CON EL PROCESAMIENTO Y ENVIO DE LA INFORMACI&Oacute;N A LA API, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#submit_cerrar").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-print"></i> Facturar e Imprimir</button>');
																			
								});
							}  
							else if(data==13){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> HA OCURRIDO UN PROBLEMA CON LA INFORMACI&Oacute;N ENVIADA A LA API, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#submit_cerrar").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-print"></i> Facturar e Imprimir</button>');
																			
								});
							}
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 8000, });
			 $("#cerrarventa")[0].reset();
			 $('#favoritos').hide();
             $('body').removeClass('modal-open');
             $('#myModalPago').modal('hide');
			 $('#cierremesa').html("");  
			 $("#carrito tbody").html("");
			 $(nuevaFila).appendTo("#carrito tbody");
             $('#loading').load("salas_mesas?CargaMesas=si");
			 $('#muestradetallemesa').load("detalles_mesas.php?BuscaDetallesPedidosMesa=si&codmesa="+codmesa);
			 $("#submit_cerrar").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-print"></i> Facturar e Imprimir</button>');
									
								});
							}
					   }
			   });
				return false;
			    }
			}
	   /* form submit */
      }); 
 });  
 /* FIN DE FUNCION PARA VALIDAR CERRAR PEDIDOS EN MESA */




















/* FUNCION JQUERY PARA VALIDAR REGISTRO DE CLIENTES EN DELIVERY */	  
$('document').ready(function()
{ 
        jQuery.validator.addMethod("lettersonly", function(value, element) {
          return this.optional(element) || /^[a-zA-ZñÑáéíóúÁÉÍÓÚ,. ]+$/i.test(value);
        });

     /* validation */
	 $("#clientedelivery").validate({
      rules:
	  {
			tipocliente: { required: true, },
			documcliente: { required: false, },
			dnicliente: { required: true,  digits : false, minlength: 7 },
			nomcliente: { required: true, lettersonly: true },
			razoncliente: { required: true },
			girocliente: { required: true },
			tlfcliente: { required: false, },
			id_provincia: { required: false, },
			id_departamento: { required: false, },
			direccliente: { required: true, },
			emailcliente: { required: false, email: true },
			limitecredito: { required: true, number : true},
	   },
       messages:
	   {
			tipocliente: { required: "Seleccione Tipo de Cliente" },
			documcliente:{ required: "Seleccione Tipo de Documento" },
			dnicliente:{ required: "Ingrese N&deg; de Documento", digits: "Ingrese solo d&iacute;gitos", minlength: "Ingrese 7 d&iacute;gitos como m&iacute;nimo" },
            nomcliente:{ required: "Ingrese Nombre de Cliente", lettersonly: "Ingrese solo letras para Nombres" },
			razoncliente:{ required: "Ingrese Raz&oacute;n Social" },
			girocliente:{ required: "Ingrese Giro de Cliente" },
			tlfcliente: { required: "Ingrese N&deg; de Tel&eacute;fono" },
			id_provincia:{ required: "Seleccione Provincia" },
			id_departamento: { required: "Seleccione Departamento" },
			direccliente: { required: "Ingrese Direcci&oacute;n Domiciliaria" },
			emailcliente:{ required: "Ingrese Email de Cliente", email: "Ingrese un Email V&aacute;lido" },
			limitecredito:{ required: "Ingrese Limite de Cr&eacute;dito", number: "Ingrese solo digitos con 2 decimales" },
       },
	   submitHandler: function(form) {
                     		
			var data = $("#clientedelivery").serialize();
			
			$.ajax({
			type : 'POST',
			url  : 'delivery.php',
		    async : false,
			data : data,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				$("#btn-cliente").html('<i class="fa fa-refresh"></i> Verificando...');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-cliente").html('<span class="fa fa-save"></span> Guardar');
									
								});
							}  
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> YA EXISTE UN CLIENTE CON ESTE N&deg; DE DOCUMENTO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
			$("#btn-cliente").html('<span class="fa fa-save"></span> Guardar');
																			
								});
							}
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 5000, });
             $('body').removeClass('modal-open');
             $('#myModalCliente').modal('hide');
			 $("#clientedelivery")[0].reset();
			 $('#id_departamento').html("<option value=''>-- SIN RESULTADOS --</option>");	
			 $("#btn-cliente").html('<span class="fa fa-save"></span> Guardar');
								});
							}
					   }
			});
			return false;
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE CLIENTES EN DELIVERY */

/* FUNCION JQUERY PARA VALIDAR REGISTRO DE PEDIDOS EN DELIVERY */
$('document').ready(function()
{	
    /* validation */
	$("#savedelivery").validate({
        rules:
	    {
			busqueda: { required: false, },
			tipopedido: { required: true, },
			repartidor: { required: true, },
			observaciones: { required: false, },
	    },
        messages:
	    {
            busqueda:{ required: "Realice la B&uacute;squeda del Cliente correctamente" },
			tipopedido:{ required: "Seleccione Tipo de Pedido" },
			repartidor:{ required: "Seleccione Repartidor de Pedido" },
			observaciones: { required: "Ingrese Observaciones de Pedido" },
        },
	    submitHandler: function(form) {
                     		
		var data = $("#savedelivery").serialize();
	    var nuevaFila ="<tr>"+"<td class='text-center' colspan=5><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
	    var codpedido = $('input#codpedido').val();
	    var codventa = $('input#codventa').val();
 				
			$.ajax({
			type : 'POST',
			url  : 'delivery.php',
		    async : false,
			data : data,
			beforeSend: function()
			{	
				$("#save").fadeOut();
				var n = noty({
                text: "<span class='fa fa-refresh'></span> VERIFICANDO INFORMACI&Oacute;N, POR FAVOR ESPERE......",
                theme: 'defaultTheme',
                layout: 'center',
                type: 'information',
                timeout: 1000, });
			    $("#submit_guardar").html('<button type="button" class="btn btn-warning btn-lg btn-block waves-effect waves-light"><i class="fa fa-save"></i> Confirmar</button>');
			},
			success :  function(data)
					   {						
							if(data==1){
								
				$("#save").fadeIn(500, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES DE PRODUCTOS PARA CONFIRMAR PEDIDO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
             $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-warning btn-lg btn-block waves-effect waves-light"><span class="fa fa-save"></span> Confirmar</button>');
																			
								});
							}
							else if(data==2){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> LA CANTIDAD SOLICITADA DE PRODUCTOS NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
             $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-warning btn-lg btn-block waves-effect waves-light"><span class="fa fa-save"></span> Confirmar</button>');
																			
								});
							}
							else if(data==3){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> SI EL TIPO DE PEDIDO ES A DOMICILIO, DEBE DE SELECCIONAR EL REPARTIDOR PARA LA ENTREGA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
             $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-warning btn-lg btn-block waves-effect waves-light"><span class="fa fa-save"></span> Confirmar</button>');
																			
								});
							}
							else if(data==4){
								
				$("#save").fadeIn(1000, function(){
								
			 var n = noty({
             text: "<span class='fa fa-warning'></span> SI EL TIPO DE PEDIDO ES A DOMICILIO, DEBE DE ASIGNAR EL CLIENTE PARA LA ENTREGA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
             theme: 'defaultTheme',
             layout: 'center',
             type: 'warning',
             timeout: 5000, });
             $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-warning btn-lg btn-block waves-effect waves-light"><span class="fa fa-save"></span> Confirmar</button>');
																			
								});
							}
							else{
									
				$("#save").fadeIn(1000, function(){
									
			 var n = noty({
			 text: '<center> '+data+' </center>',
             theme: 'defaultTheme',
             layout: 'center',
             type: 'information',
             timeout: 8000, });
			 $("#savedelivery")[0].reset();
			 $("#carrito tbody").html("");
			 $(nuevaFila).appendTo("#carrito tbody");
			 $('#pedidos').load("detalles_delivery.php?CargaPedidosDelivery=si&codpedido="+codpedido+"&codventa="+codventa);
			 $('#muestradetalledelivery').load("detalles_delivery.php?BuscaPedidoDelivery=si&codpedido="+codpedido+"&codventa="+codventa);
             $('#loading').load("salas_mesas?CargaProductos=si");
             $("#submit_guardar").html('<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-warning btn-lg btn-block waves-effect waves-light"><span class="fa fa-save"></span> Confirmar</button>'); 
									
								});
							}
					   }
			   });
				return false;
			}
	   /* form submit */
      }); 
 });  
 /* FIN DE FUNCION PARA VALIDAR REGISTRO DE PEDIDOS EN DELIVERY */

/* FUNCION JQUERY PARA VALIDAR CERRAR PEDIDOS EN DELIVERY */
$('document').ready(function()
{	
    /* validation */
	$("#cerrardelivery").validate({
        rules:
	    {
			busqueda: { required: false, },
			repartidor: { required: true, },
			tipodocumento: { required: true, },
			tipopago: { required: true, },
			formapago: { required: true, },
			montopagado: { required: true, },
			formapago2: { required: false, },
			montopagado2: { required: true, },
			formapropina: { required: false, },
			montopropina: { required: true, },
			fechavencecredito: { required: true, },
			medioabono: { required: false, },
			montoabono: { required: true, },
			bancoemisor: { required: true, },
			tipotarjeta: { required: true, },
			digitos: { required: true, digits : true, minlength: 4, maxlength: 4},
			nomresponsable: { required: true, },
			observaciones: { required: false, },
	    },
        messages:
	    {
            busqueda:{ required: "Realice la B&uacute;squeda del Cliente correctamente" },
			repartidor:{ required: "Seleccione Repartidor de Pedido" },
			tipodocumento:{ required: "Seleccione Tipo de Documento" },
			tipopago:{ required: "Seleccione Condici&oacute;n de Pago" },
			formapago:{ required: "Seleccione Forma de Pago" },
			montopagado:{ required: "Ingrese Monto Pagado" },
			formapago2:{ required: "Seleccione Forma de Pago" },
			montopagado:{ required: "Ingrese Monto de Pago" },
			formapropina:{ required: "Seleccione Forma de Propina" },
			montopropina:{ required: "Ingrese Monto Propina" },
			fechavencecredito:{ required: "Ingrese Fecha Vence Cr&eacute;dito" },
			medioabono:{ required: "Seleccione Medio de Abono" },
			montoabono:{ required: "Ingrese Monto de Abono" },
			bancoemisor:{ required: "Ingrese Nombre de Banco" },
			tipotarjeta:{ required: "Seleccione Tipo de Tarjeta" },
            digitos:{ required: "Ingrese &Uacute;timo 4 Digitos", digits: "Ingrese solo digitos", minlength: "Ingrese 4 digitos como minimo", maxlength: "Ingrese 4 digitos como maximo" },
			nomresponsable:{ required: "Ingrese Nombre Responsable" },
			observaciones: { required: "Ingrese Observaciones en Venta" },
        },
	    submitHandler: function(form) {
                     		
			var data = $("#cerrardelivery").serialize();
		    var nuevaFila ="<tr>"+"<td class='text-center' colspan=5><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
		    var codcliente = $('input#codcliente').val();
		    var TipoDocumento = $('input:radio[name=tipodocumento]:checked').val();	
			var codpedido = $('input#codpedido').val();
			var FormaPago = $('select#formapago').val();
		    var MontoPagado = $('input#montopagado').val();
		    var FormaPago2 = $('select#formapago2').val();
		    var MontoPagado2 = $('input#montopagado2').val();
		    var TxtImporte = $('input#txtImporte').val();
		    var TxtPropina = $('input#montopropina').val();
		    var TotalPago = parseFloat(TxtImporte);
		    var TotalPagado = parseFloat(MontoPagado) + parseFloat(MontoPagado2);

		    var MedioAbono = $('select#medioabono').val();
		    var TotalAbono = $('input#montoabono').val();
		    var CreditoInicial = $('input#creditoinicial').val();
		    var CreditoDisponible = $('input#creditodisponible').val();
		    var TipoPago = $('input:radio[name=tipopago]:checked').val();

		if (TipoDocumento=="FACTURA" && codcliente=="0") {

            swal("Oops", "POR FAVOR ASIGNE UN CLIENTE PARA LA FACTURA DE VENTA!", "error");
            return false;
	 
	    } else if ($('input#txtImporte').val()==0.00 || $('input#txtImporte').val()==0 || $('input#txtImporte').val()=="") {

	        $("input#busquedaproducto").focus();
            $('input#busquedaproducto').css('border-color','#f0ad4e');
            swal("Oops", "POR FAVOR AGREGUE DETALLES DE PRODUCTOS PARA CONTINUAR CON LA VENTA!", "error");

            return false;
	 
	    } else if (TipoPago == "CONTADO" && FormaPago == FormaPago2){ 
	            
	        $('select#formapago2').focus();
            $('select#formapago2').css('border-color','#f0ad4e');
            swal("Oops", "LAS FORMAS DE PAGO NO DEBEN DE COINCIDIR, VERIFIQUE NUEVAMENTE POR FAVOR!", "error");

            return false;
	 
	    } else if (TipoPago == "CONTADO" && FormaPago != "" && FormaPago2 != "" && parseFloat(TotalPagado) > parseFloat(TotalPago)){ 
	            
	        $('input#montopagado').focus();
            $('input#montopagado').css('border-color','#f0ad4e');
            swal("Oops", "EL MONTO RECIBIDO NO PUEDE SER MAYOR AL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR!", "error");

            return false;
	 
	    } else if (TipoPago == "CONTADO" && FormaPago != "" && FormaPago2 == "" && parseFloat(TotalPagado) < parseFloat(TotalPago)){ 
	            
	        $('input#montopagado').focus();
            $('input#montopagado').css('border-color','#f0ad4e');
            swal("Oops", "POR FAVOR COMPLETE EL MONTO TOTAL A PAGAR, VERIFIQUE NUEVAMENTE POR FAVOR!", "error");

            return false;
	 
	    } else if (TipoPago == "CONTADO" && parseFloat(TotalPagado) < parseFloat(TotalPago)){ 
	            
	        $('input#montopagado').focus();
            $('input#montopagado').css('border-color','#f0ad4e');
            swal("Oops", "EL MONTO TOTAL A PAGAR NO PUEDE SER MAYOR AL MONTO CANCELADO, VERIFIQUE NUEVAMENTE POR FAVOR!", "error");

            return false;
	 
	    } else if (TipoPago == "CREDITO" && TotalAbono != "0.00" && MedioAbono == "") {
	            
	        $("select#medioabono").focus();
            $('select#medioabono').css('border-color','#f0ad4e');
            swal("Oops", "SELECCIONE LA FORMA DE ABONO A ESTA VENTA!", "error");

            return false;
	 
	    } else if (TipoPago == "CREDITO" && CreditoInicial != "0.00" && parseFloat(TotalPago-TotalAbono) > parseFloat(CreditoDisponible)) {
	            
	        $("input#TotalAbono").focus();
            $('input#TotalAbono').css('border-color','#f0ad4e');
            swal("Oops", "SE HA EXCEDIDO DEL LIMITE DE CREDITO PARA COMPRAS DE PRODUCTOS, VERIFIQUE Y CANCELE SUS DEUDAS POR FAVOR!", "error");

            return false;
	 
	    } else if (TipoPago == "CREDITO" && parseFloat(TotalAbono) >= parseFloat(TotalPago)) {
	            
	        $("input#TotalAbono").focus();
            $('input#TotalAbono').css('border-color','#f0ad4e');
            swal("Oops", "EL ABONO DE CREDITO NO PUEDE SER MAYOR O IGUAL QUE EL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR!", "error");

            return false;
	 
	    } else {
	 				
				$.ajax({
				type : 'POST',
				url  : 'delivery.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
			        $("#submit_cerrar").html('<button type="button" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-refresh"></i> Procesando...</button>');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> DEBE DE REALIZAR EL ARQUEO DE SU CAJA ASIGNADA PARA PROCESAR COBROS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
			     $("#submit_cerrar").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-print"></i> Facturar e Imprimir</button>');
										
									});
								}   
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
			     $("#submit_cerrar").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-print"></i> Facturar e Imprimir</button>');
																				
									});
								}   
								else if(data==3){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES DE PRODUCTOS PARA CERRAR ESTA VENTA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
			     $("#submit_cerrar").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-print"></i> Facturar e Imprimir</button>');
																				
									});
								}    
								else if(data==4){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> EL MONTO TOTAL A PAGAR NO PUEDE SER MAYOR AL MONTO CANCELADO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
			     $("#submit_cerrar").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-print"></i> Facturar e Imprimir</button>');
																				
									});
								}
								else if(data==5){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> SI EL TIPO DE PEDIDO ES A DOMICILIO, DEBE DE SELECCIONAR EL REPARTIDOR PARA LA ENTREGA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
			     $("#submit_cerrar").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-print"></i> Facturar e Imprimir</button>');
																				
									});
								}
								else if(data==6){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> SI EL TIPO DE PEDIDO ES A DOMICILIO, DEBE DE ASIGNAR EL CLIENTE PARA LA ENTREGA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
			     $("#submit_cerrar").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-print"></i> Facturar e Imprimir</button>');
																				
									});
								} 
								else if(data==7){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR ASIGNE UN CLIENTE PARA LA FACTURA DE VENTA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
			     $("#submit_cerrar").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-print"></i> Facturar e Imprimir</button>');
																				
									});
								} 
								else if(data==8){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> LAS FACTURAS SERAN ENTREGADAS SOLO A CLIENTES JURIDICOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
			     $("#submit_cerrar").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-print"></i> Facturar e Imprimir</button>');
																				
									});
								} 
								else if(data==9){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR ASIGNE UN CLIENTE A ESTA VENTA DE CREDITO PARA CONTROL DE ABONOS DEL MISMO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
			     $("#submit_cerrar").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-print"></i> Facturar e Imprimir</button>');
																				
									});
								}   
								else if(data==10){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> LA FECHA DE VENCIMIENTO DE CREDITO NO PUEDER SER MENOR QUE LA ACTUAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
			     $("#submit_cerrar").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-print"></i> Facturar e Imprimir</button>');
																				
									});
								}   
								else if(data==11){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> SELECCIONE EL MEDIO DE ABONO A ESTA VENTA DE CREDITO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
			     $("#submit_cerrar").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-print"></i> Facturar e Imprimir</button>');
																				
									});
								}
								else if(data==12){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> SE HA EXCEDIDO DEL LIMITE DE CREDITO PARA COMPRAS DE PRODUCTOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
			     $("#submit_cerrar").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-print"></i> Facturar e Imprimir</button>');
																				
									});
								}  
								else if(data==13){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> EL ABONO DE CREDITO NO PUEDE SER MAYOR O IGUAL QUE EL PAGO TOTAL, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
			     $("#submit_cerrar").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-print"></i> Facturar e Imprimir</button>');
																				
									});
								}
								else if(data==14){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> HA OCURRIDO UN PROBLEMA CON EL PROCESAMIENTO Y ENVIO DE LA INFORMACI&Oacute;N A LA API, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
			     $("#submit_cerrar").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-print"></i> Facturar e Imprimir</button>');
																				
									});
								}  
								else if(data==15){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> HA OCURRIDO UN PROBLEMA CON LA INFORMACI&Oacute;N ENVIADA A LA API, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
			     $("#submit_cerrar").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-print"></i> Facturar e Imprimir</button>');
																				
									});
								}  
								else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 8000, });
                 $('body').removeClass('modal-open');
                 $('#myModalPago').modal('hide');
				 $("#savedelivery")[0].reset(); 
	             $('#cierredelivery').html("");
				 $('#favoritos').hide();
				 $("#carrito tbody").html("");
				 $(nuevaFila).appendTo("#carrito tbody");
	             $('#loading').load("salas_mesas?CargaProductos=si");
	             $('#pedidos').load("detalles_delivery?CargaPedidosDelivery=si&codpedido=0&codventa=0");
				 $('#muestradetalledelivery').load("detalles_delivery.php?BuscaPedidoDelivery=si&codpedido=0&codventa=0");
			     $("#submit_cerrar").html('<button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-primary btn-lg btn-block waves-effect waves-light"><i class="fa fa-print"></i> Facturar e Imprimir</button>');
										
									});
								}
						   }
				   });
				return false;
			    }
			}
	   /* form submit */
      }); 
 });  
 /* FIN DE FUNCION PARA VALIDAR CERRAR PEDIDOS EN DELIVERY */






/* FUNCION JQUERY PARA VALIDAR ACTUALIZACION DE VENTAS */	 
$('document').ready(function()
{ 
     /* validation */
$("#updateventas").validate({
       rules:
	  {
			busqueda: { required: false, },
			tipodocumento: { required: true, },
			tipopago: { required: true, },
			formapago: { required: true, },
			formapago2: { required: false, },
			montopagado: { required: false, },
			fechavencecredito: { required: true, },
			montoabono: { required: false, },
	   },
       messages:
	   {
            busqueda:{ required: "Realice la B&uacute;squeda del Cliente correctamente" },
			tipodocumento:{ required: "Seleccione Tipo de Documento" },
			tipopago:{ required: "Seleccione Condici&oacute;n de Pago" },
			formapago:{ required: "Seleccione Forma de Pago N&deg 1" },
			formapago2:{ required: "Seleccione Forma de Pago N&deg 2" },
			montopagado:{ required: "Ingrese Monto Pagado" },
			fechavencecredito:{ required: "Ingrese Fecha Vence Cr&eacute;dito" },
			montoabono:{ required: "Ingrese Monto de Abono" },
       },
	   submitHandler: function(form) {
                     		
			var data = $("#updateventas").serialize();
            var id= $("#updateventas").attr("data-id");
            var codventa = $('#venta').val();
				
				$.ajax({
				type : 'POST',
				url  : 'forventa.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-update").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
										
									});
								}  
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> NO DEBEN DE EXISTIR DETALLES DE VENTAS CON CANTIDAD IGUAL A CERO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
																				
									});
								}   
								else if(data==3){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> SE HA EXCEDIDO DEL LIMITE DE CREDITO PARA COMPRAS DE PRODUCTOS EN ESTA SUCURSAL, VERIFIQUE SU CREDITO DISPONIBLE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
																				
									});
								} 
								else if(data==4){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> LA CANTIDAD SOLICITADA DE PRODUCTOS, NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
																				
									});
								} 
								else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 8000, });
				 $('#detallesventasupdate').load("funciones.php?MuestraDetallesVentasUpdate=si&codventa="+codventa); 
				 $("#btn-update").html('<span class="fa fa-edit"></span> Actualizar');
				 setTimeout("location.href='ventas'", 5000);											
									});
								}
						   }
				});
				return false;
		}
	   /* form submit */	
    });    
});
/*  FIN DE FUNCION PARA VALIDAR ACTUALIZACION DE VENTAS */


/* FUNCION JQUERY PARA VALIDAR AGREGAR DETALLES A VENTAS */	 
$('document').ready(function()
{ 
     /* validation */
$("#agregaventas").validate({
       rules:
	  {
			busqueda: { required: false, },
			tipodocumento: { required: true, },
			tipopago: { required: true, },
			formapago: { required: true, },
			formapago2: { required: false, },
			montopagado: { required: false, },
			fechavencecredito: { required: true, },
			montoabono: { required: false, },
	   },
       messages:
	   {
            busqueda:{ required: "Realice la B&uacute;squeda del Cliente correctamente" },
			tipodocumento:{ required: "Seleccione Tipo de Documento" },
			tipopago:{ required: "Seleccione Condici&oacute;n de Pago" },
			formapago:{ required: "Seleccione Forma de Pago N&deg 1" },
			formapago2:{ required: "Seleccione Forma de Pago N&deg 2" },
			montopagado:{ required: "Ingrese Monto Pagado" },
			fechavencecredito:{ required: "Ingrese Fecha Vence Cr&eacute;dito" },
			montoabono:{ required: "Ingrese Monto de Abono" },
       },
	   submitHandler: function(form) {
                     		
			var data = $("#agregaventas").serialize();
            var nuevaFila ="<tr>"+"<td class='text-center' colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
            var id= $("#agregaventas").attr("data-id");
            var codventa = $('#venta').val();
		    var TotalPago = $('#txtTotal').val();
		    var CreditoInicial = $('#creditoinicial').val();
		    var CreditoDisponible = $('#creditodisponible').val();
		    var TipoPago = $('input:radio[name=tipopago]:checked').val();

		if (TotalPago==0.00) {
	            
	        $("#busquedaproductov").focus();
            $('#busquedaproductov').css('border-color','#f0ad4e');
            swal("Oops", "POR FAVOR AGREGUE DETALLES PARA CONTINUAR CON LA VENTA DE PRODUCTOS!", "error");

            return false;
	 
	    } else if (TipoPago=="CREDITO" && CreditoInicial!="0.00" && parseFloat(TotalPago) > parseFloat(CreditoDisponible)) {
	            
	        $("#TotalAbono").focus();
            $('#TotalAbono').css('border-color','#f0ad4e');
            swal("Oops", "SE HA EXCEDIDO DEL LIMITE DE CREDITO PARA COMPRAS DE PRODUCTOS EN ESTA SUCURSAL, VERIFIQUE Y CANCELE SUS DEUDAS POR FAVOR!", "error");

            return false;
	 
	    } else {
				
				$.ajax({
				type : 'POST',
				url  : 'forventa.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-agregar").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-agregar").html('<span class="fa fa-plus"></span> Agregar');
										
									});
								}  
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> NO HA INGRESADO DETALLES PARA VENTAS AL CLIENTE, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-agregar").html('<span class="fa fa-plus"></span> Agregar');
																				
									});
								}  
								else if(data==3){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> SE HA EXCEDIDO DEL LIMITE DE CREDITO PARA COMPRAS DE PRODUCTOS EN ESTA SUCURSAL, VERIFIQUE SU CREDITO DISPONIBLE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-agregar").html('<span class="fa fa-plus"></span> Agregar');
																				
									});
								}   
								else if(data==4){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> NO DEBEN DE EXISTIR DETALLES DE VENTAS CON CANTIDAD IGUAL A CERO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-agregar").html('<span class="fa fa-plus"></span> Agregar');
																				
									});
								} 
								else if(data==5){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> LA CANTIDAD SOLICITADA DE PRODUCTOS, NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-agregar").html('<span class="fa fa-edit"></span> Agregar');
																				
									});
								}
								else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 8000, });
				 $("#agregaventas")[0].reset();
				 $("#carrito tbody").html("");
				 $(nuevaFila).appendTo("#carrito tbody");
				 $("#lblsubtotal").text("0.00");
				 $("#lblsubtotal2").text("0.00");
				 $("#lbliva").text("0.00");
				 $("#lbldescuento").text("0.00");
				 $("#lbltotal").text("0.00");
                 $("#TextImporte").text("0.00");
                 $("#TextPagado").text("0.00");
                 $("#TextCambio").text("0.00");
				 $("#txtsubtotal").val("0.00");
				 $("#txtsubtotal2").val("0.00");
				 $("#txtIva").val("0.00");
				 $("#txtDescuento").val("0.00");
				 $("#txtTotal").val("0.00");
				 $("#txtTotalCompra").val("0.00");		 
				 $('#detallesventasagregar').load("funciones.php?MuestraDetallesVentasAgregar=si&codventa="+codventa);  
	             $("#loadproductos").load("funciones.php?prod_familias=si");
				 $("#btn-agregar").html('<span class="fa fa-plus"></span> Agregar');
				 setTimeout("location.href='ventas'", 5000);	
									});
								}
						   }
				});
				return false;
			}
		}
	   /* form submit */
    }); 	   
});
/* FUNCION JQUERY PARA VALIDAR AGREGAR DETALLES A VENTAS */	






























/* FUNCION JQUERY PARA VALIDAR REGISTRO DE PAGOS A CREDITOS */	 	 
$('document').ready(function()
{ 
     /* validation */
	 $("#savepago").validate({
      rules:
	  {
			codcliente: { required: false, },
			montoabono: { required: true, number : true},
			formaabono: { required: true, },
	   },
       messages:
	   {
            codcliente:{ required: "Seleccione al Cliente correctamente" },
			montoabono:{ required: "Ingrese Monto de Abono", number: "Ingrese solo digitos con 2 decimales" },
			formaabono:{ required: "Seleccione Forma de Pago" },
       },
	   submitHandler: function(form) {
                     		
			var data = $("#savepago").serialize();
		    var codcaja = $('#codcaja').val();
		    var codcliente = $('#codcliente').val();
		    var montoabono = $('#montoabono').val();

		if (codcaja=='') {
	            
            swal("Oops", "POR FAVOR DEBE DE REALIZAR EL ARQUEO DE SU CAJA PARA PROCESAR ABONOS DE CREDITOS!", "error");
            return false;
	 
	    } else if (codcliente=='') {
	            
            swal("Oops", "SELECCIONE LA FACTURA ABONAR CORRECTAMENTE!", "error");
            return false;
	 
	    } else if (montoabono==0.00) {
	            
	        $("#montoabono").focus();
            $('#montoabono').css('border-color','#f0ad4e');
            swal("Oops", "POR FAVOR INGRESE UN MONTO DE ABONO VALIDO!", "error");
            return false;
	 
	    } else {
				
				$.ajax({
				type : 'POST',
				url  : 'creditos.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> DEBE DE REALIZAR EL ARQUEO DE SU CAJA ASIGNADA PARA REALIZAR VENTAS, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
										
									});
								}   
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR DEBE DE COMPLETAR LOS CAMPOS REQUERIDOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}    
								else if(data==3){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> EL MONTO ABONADO NO PUEDE SER MAYOR AL TOTAL DE FACTURA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar');
																				
									});
								}
								else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 5000, });
                 $('body').removeClass('modal-open');
                 $('#myModalCredito').modal('hide');
				 $("#savepago")[0].reset();
				 $("#btn-submit").html('<span class="fa fa-save"></span> Guardar');	
				 $('#creditos').html("");
				 $('#creditos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
				 setTimeout(function() {
				 $('#creditos').load("consultas?CargaCreditos=si");
				 }, 200);
										
									});
								}
						   }
				});
				return false;
			}
		}
	   /* form submit */
    }); 	   
});
/*  FIN DE FUNCION PARA VALIDAR REGISTRO DE PAGOS A CREDITOS */




































/* FUNCION JQUERY PARA VALIDAR REGISTRO DE NOTA DE CREDITO*/
$('document').ready(function()
{	
    /* validation */
	$("#savenota").validate({
        rules:
	  {
			numfactura: { required: true, },
			observacion: { required: true, },
	   },
       messages:
	   {
            numfactura:{ required: "Realice la B&uacute;squeda del Documento correctamente" },
            observacion:{ required: "Requerido"}
       },
	   submitHandler: function(form) {
                     		
			var data = $("#savenota").serialize();

			if ($('input[type=radio]:checked').length === 0) {
	 
	        swal("Oops", "POR FAVOR DEBE DE SELECCIONAR AL MENOS UN PROCEDIMIENTO PARA NOTA DE CREDITO!", "save");
    
            return false;
	 
	    } else {
	 				
				$.ajax({
				type : 'POST',
				url  : 'fornota.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> DEBE DE REALIZAR EL ARQUEO DE SU CAJA ASIGNADA PARA PROCESAR NOTA DE CREDITO, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar Nota');
										
									});
								}   
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar Nota');
																				
									});
								}  
								else if(data==3){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR INGRESE LA CANTIDAD PARA DEVOLUCIÓN DE PRODUCTOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar Nota');
																				
									});
								}      
								else if(data==4){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> NO EXISTE SALDO SUFICIENTE EN CAJA PARA PROCESAR LA NOTA DE CREDITO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar Nota');
																				
									});
								}      
								else if(data==5){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> LA CANTIDAD DEVUELTA NO PUEDE SER MAYOR QUE LA CANTIDAD VENDIDA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar Nota');
																				
									});
								}
								else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 8000, });
				 $("#savenota")[0].reset();
				 $("#codarqueo").attr('disabled', false);
	             $('#numeroventa').val("");
	             $('#muestrafactura').html("");
	             $("#btn-submit").html('<span class="fa fa-save"></span> Guardar Nota');
										
									});
								}
						   }
				   });
				return false;
			    }
			}
	   /* form submit */
      }); 
 });  
 /* FIN DE FUNCION PARA VALIDAR REGISTRO DE NOTA DE CREDITO */


/* FUNCION JQUERY PARA VALIDAR REGISTRO DE NOTA DE CREDITO
$('document').ready(function()
{	
	$("#savenota").validate({
        rules:
	  {
			numfactura: { required: true, },
			observacion: { required: true, },
	   },
       messages:
	   {
            numfactura:{ required: "Realice la B&uacute;squeda del Documento correctamente" },
            observacion:{ required: "Requerido"}
       },
	   submitHandler: function(form) {
                     		
			var data = $("#savenota").serialize();

			if ($('input[type=radio]:checked').length === 0) {
	 
	        swal("Oops", "POR FAVOR DEBE DE SELECCIONAR AL MENOS UN PROCEDIMIENTO PARA NOTA DE CREDITO!", "save");
    
            return false;
	 
	    } else {
	 				
				$.ajax({
				type : 'POST',
				url  : 'fornota.php',
			    async : false,
				data : data,
				beforeSend: function()
				{	
					$("#save").fadeOut();
					$("#btn-submit").html('<i class="fa fa-refresh"></i> Verificando...');
				},
				success :  function(data)
						   {						
								if(data==1){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> DEBE DE REALIZAR EL ARQUEO DE SU CAJA ASIGNADA PARA PROCESAR NOTA DE CREDITO, VERIFIQUE NUEVAMENTE POR FAVOR...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar Nota');
										
									});
								}   
								else if(data==2){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> LOS CAMPOS NO PUEDEN IR VACIOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar Nota');
																				
									});
								}  
								else if(data==3){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> POR FAVOR INGRESE LA CANTIDAD PARA DEVOLUCIÓN DE PRODUCTOS, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar Nota');
																				
									});
								}      
								else if(data==4){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> NO EXISTE SALDO SUFICIENTE EN CAJA PARA PROCESAR LA NOTA DE CREDITO, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar Nota');
																				
									});
								}      
								else if(data==5){
									
					$("#save").fadeIn(1000, function(){
									
				 var n = noty({
                 text: "<span class='fa fa-warning'></span> LA CANTIDAD DEVUELTA NO PUEDE SER MAYOR QUE LA CANTIDAD VENDIDA, VERIFIQUE NUEVAMENTE POR FAVOR ...!",
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'warning',
                 timeout: 5000, });
				$("#btn-submit").html('<span class="fa fa-save"></span> Guardar Nota');
																				
									});
								}
								else{
										
					$("#save").fadeIn(1000, function(){
										
				 var n = noty({
				 text: '<center> '+data+' </center>',
                 theme: 'defaultTheme',
                 layout: 'center',
                 type: 'information',
                 timeout: 8000, });
				 $("#savenota")[0].reset();
	             $('#muestrafactura').html("");
	             $("#btn-submit").html('<span class="fa fa-save"></span> Guardar Nota');
										
									});
								}
						   }
				   });
				return false;
			    }
			}
      }); 
 });  
 FIN DE FUNCION PARA VALIDAR REGISTRO DE NOTA DE CREDITO */