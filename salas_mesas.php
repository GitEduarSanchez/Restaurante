<?php
require_once("class/class.php");

$con = new Login();
$con = $con->ConfiguracionPorId();
$simbolo = ($con == '' ? "" : "<strong>".$con[0]['simbolo']."</strong>");
?>


<?php if (isset($_GET['CargaMesas'])): ?>

<?php
$sala = new Login();
$sala = $sala->ListarSalas();
?>
    <div class="row-horizon">
        <?php 
        if($sala==""){ echo ""; } else {
        $a=1;
        for ($i = 0; $i < sizeof($sala); $i++) { ?>
        <span class="categories <?php echo $activo = ( $sala[$i]['codsala'] == 1 ? "selectedGat" : ""); ?>" id="<?php echo $sala[$i]['nomsala'];?>"><i class="fa fa-tasks"></i> <?php echo $sala[$i]['nomsala'];?></span>
        <?php } } ?>
    </div><br>

    <div id="productList2">

        <div class="row-vertical-mesas">
        <?php
        $mesa = new Login();
        $mesa = $mesa->ListarMesas(); 

        if($mesa==""){

        echo "<div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN MESAS REGISTRADAS ACTUALMENTE</center>";
        echo "</div>";    

        } else {

        for ($ii = 0; $ii < sizeof($mesa); $ii++) { ?>
   
        <a style="float: left; margin-right: 4px; <?php echo $activo = ( $mesa[$ii]['codsala'] == 1 ? "display: block;" : "display: none;"); ?>" id="<?php echo $mesa[$ii]['nomsala'];?>">
            
      
      <?php if ($_SESSION["acceso"]=="mesero") { ?>
            
            <div class="users-list-name codMesa" title="<?php echo $mesa[$ii]['nommesa']; ?> <?php echo $var = ($mesa[$ii]['statusmesa'] == '0' || $mesa[$ii]['statusmesa'] == '2' ? '(DISPONIBLE)' : '(OCUPADA)'); ?>" style="cursor:pointer;" onclick="VerificaMesa('<?php echo encrypt($mesa[$ii]['codmesa']); ?>','0','0')">
                <div id="<?php echo $mesa[$ii]['codmesa']; ?>">
                <input type="hidden" id="category" name="category" value="<?php echo $mesa[$ii]['nomsala']; ?>">
                  <div id="<?php echo $mesa[$ii]['nommesa']; ?>" style="width: 90px;height: 90px;-moz-border-radius: 50%;-webkit-border-radius: 50%;border-radius: 50%;background:

                  <?php echo $var = ($mesa[$ii]['statusmesa'] == '0' || $mesa[$ii]['statusmesa'] == '2' ? '#5cb85c;' : 'red;'); ?>" class="miMesa"><img src="<?php echo $var = ($mesa[$ii]['statusmesa'] == '0' || $mesa[$ii]['statusmesa'] == '2' ? 'fotos/mesa1.png' : 'fotos/mesa2.png'); ?>" style="display:inline;margin:22px;float:left;width:60px;height:48px;"></div> 
                </div>
                <center><label><?php echo $mesa[$ii]['nommesa']; ?><br>(<?php echo $mesa[$ii]['puestos']; ?> PERSONAS)</label></center>
            </div>

      <?php } elseif ($_SESSION["acceso"]!="mesero") { ?>     

            <div class="users-list-name codMesa" title="<?php echo $mesa[$ii]['nommesa']; ?> <?php echo $var = ($mesa[$ii]['statusmesa'] == '0' || $mesa[$ii]['statusmesa'] == '2' ? '(DISPONIBLE)' : '(PENDIENTE DE COBRO)'); ?>" style="cursor:pointer;" <?php if ($mesa[$ii]['statusmesa'] == '0') { ?> onclick="MesaDisponible();" <?php } else { ?> onclick="ProcesarMesa('<?php echo encrypt($mesa[$ii]['codmesa']); ?>')" <?php } ?>>
                <div id="<?php echo $mesa[$ii]['codmesa']; ?>">
                <input type="hidden" id="category" name="category" value="<?php echo $mesa[$ii]['nomsala']; ?>">
                  <div id="<?php echo $mesa[$ii]['nommesa']; ?>" style="width: 90px;height: 90px;-moz-border-radius: 50%;-webkit-border-radius: 50%;border-radius: 50%;background:

                  <?php echo $var = ($mesa[$ii]['statusmesa'] == '0' ? '#5cb85c;' : '#0D89F1;'); ?>

                  " class="miMesa"><img src="fotos/mesa1.png" style="display:inline;margin:22px;float:left;width:60px;height:48px;"></div> 
                </div>
                <center class="text-dark alert-link font-12"><?php echo $mesa[$ii]['nommesa']; ?><br>(<?php echo $mesa[$ii]['puestos']; ?> PERSONAS)</center>
                <!----><center class="text-dark alert-link font-12"><?php echo $mesa[$ii]['total_deudas']=="" ? $simbolo."0.00" : $simbolo.number_format($mesa[$ii]['total_deudas'], 2, '.', ','); ?></center>
            </div>

      <?php } ?>


        </a>
    
        <?php } } ?>

        </div> 
    </div>

<?php endif; ?>






<?php if (isset($_GET['CargaProductos'])): ?>

<?php
$categoria = new Login();
$categoria = $categoria->ListarCategorias();
?>
    <div class="row-horizon">
        <span class="categories selectedGat" id=""><i class="fa fa-home"></i></span>
        <?php 
        if($categoria==""){ echo ""; } else {
        $a=1;
        for ($i = 0; $i < sizeof($categoria); $i++) { ?>
        <span class="categories" id="<?php echo $categoria[$i]['nomcategoria'];?>"><i class="fa fa-tasks"></i> <?php echo $categoria[$i]['nomcategoria'];?></span>
        <?php } } ?>
    </div>

    <div class="col-md-12">
        <div id="searchContaner"> 
            <div class="form-group has-feedback2"> 
                <label class="control-label"></label>
                <input type="text" class="form-control" name="busquedaproducto" id="busquedaproducto" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Realice la Búsqueda del Producto por Nombre">
                  <i class="fa fa-search form-control-feedback2"></i> 
            </div> 
        </div>
    </div>
    

    <div id="productList2">
        <?php
        $producto = new Login();
        $producto = $producto->ListarProductosModal();

        $monedap = new Login();
        $cambio = $monedap->MonedaProductoId(); 

        if($producto==""){

        echo "<div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN PRODUCTOS REGISTRADOS ACTUALMENTE</center>";
        echo "</div>";  

        } else { ?>

        <div class="row-vertical">
            <div class="row">
        <?php for ($ii = 0; $ii < sizeof($producto); $ii++) { ?>
        
        <!-- column -->
        <div ng-click="afterClick()" ng-repeat="product in ::getFavouriteProducts()" OnClick="DoAction(
        '<?php echo $producto[$ii]['idproducto']; ?>',
        '<?php echo $producto[$ii]['codproducto']; ?>',
        '<?php echo $producto[$ii]['producto']; ?>',
        '<?php echo $producto[$ii]['codcategoria']; ?>',
        '<?php echo $producto[$ii]['nomcategoria']; ?>',
        '<?php echo number_format($producto[$ii]['preciocompra'], 2, '.', ''); ?>',
        '<?php echo number_format($producto[$ii]['precioventa'], 2, '.', ''); ?>',
        '<?php echo number_format($producto[$ii]['descproducto'], 2, '.', ''); ?>',
        '<?php echo $producto[$ii]['ivaproducto']; ?>',
        '<?php echo number_format($producto[$ii]['existencia'], 2, '.', ''); ?>',
        '<?php echo $precioconiva = ( $producto[$ii]['ivaproducto'] == 'SI' ? number_format($producto[$ii]['precioventa'], 2, '.', '') : "0.00"); ?>',
        '<?php echo "1"; ?>',
        '');">
        <div id="<?php echo $producto[$ii]['codproducto']; ?>">
            <div class="darkblue-panel pn" title="<?php echo $producto[$ii]['producto'].' | ('.$producto[$ii]['nomcategoria'].')';?>">
                <div class="darkblue-header">
                   <div id="proname" class="text-white font-12"><?php echo getSubString($producto[$ii]['producto'],18);?></div>
                </div>
                <?php if (file_exists("./fotos/productos/".$producto[$ii]["codproducto"].".jpg")){
                echo "<img src='fotos/productos/".$producto[$ii]['codproducto'].".jpg?' class='rounded-circle' style='width:140px;height:134px;'>"; 
                } else {
                echo "<img src='fotos/producto.png' class='rounded-circle' style='width:140px;height:130px;'>";  } ?>
                <input type="hidden" id="category" name="category" value="<?php echo $producto[$ii]['nomcategoria']; ?>">

                <div class="mask">
                <h5 style="font-size: 11.5px;" class="text-white pull-left"><i class="fa fa-bars"></i> <?php echo number_format($producto[$ii]['existencia'], 2, '.', ','); ?></h5>
                <abbr title="<?php echo $cambio == '' ? "" : $cambio[0]['simbolo'].number_format($producto[$ii]['precioventa']/$cambio[0]['montocambio'], 2, '.', ','); ?>"><h5 style="font-size: 11.5px;" class="text-warning pull-right"><?php echo $simbolo.number_format($producto[$ii]['precioventa'], 2, '.', ',');?> </h5></abbr> 
                </div>
            </div>
        </div>

        </div>
        <!-- column -->
                
        <?php } // fin for ?>
        </div><!-- fin row -->
       </div><!-- fin row-vertical -->

        <?php } // fin if ?>

        </div> 
    </div>

<?php endif; ?>




<?php if (isset($_GET['CargaCombos'])): ?>

    <div class="col-md-12">
        <div id="searchContaner"> 
            <div class="form-group has-feedback2"> 
                <label class="control-label"></label>
                <input type="text" class="form-control" name="busquedaproducto" id="busquedaproducto" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Realice la Búsqueda del Combo por Nombre">
                  <i class="fa fa-search form-control-feedback2"></i> 
            </div> 
        </div>
    </div>
    

    <div id="productList2">
        <?php
        $combo = new Login();
        $combo = $combo->ListarCombosModal();

        $monedap = new Login();
        $cambio = $monedap->MonedaProductoId();  

        if($combo==""){

        echo "<div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN COMBOS REGISTRADOS ACTUALMENTE</center>";
        echo "</div>";  

        } else { ?>

        <div class="row-vertical">
            <div class="row">
        <?php for ($ii = 0; $ii < sizeof($combo); $ii++) { ?>
        
        <!-- column -->
        <div ng-click="afterClick()" ng-repeat="product in ::getFavouriteProducts()" OnClick="DoAction(
        '<?php echo $combo[$ii]['idcombo']; ?>',
        '<?php echo $combo[$ii]['codcombo']; ?>',
        '<?php echo $combo[$ii]['nomcombo']; ?>',
        '<?php echo "********"; ?>',
        '<?php echo "********"; ?>',
        '<?php echo number_format($combo[$ii]['preciocompra'], 2, '.', ''); ?>',
        '<?php echo number_format($combo[$ii]['precioventa'], 2, '.', ''); ?>',
        '<?php echo number_format($combo[$ii]['desccombo'], 2, '.', ''); ?>',
        '<?php echo $combo[$ii]['ivacombo']; ?>',
        '<?php echo number_format($combo[$ii]['existencia'], 2, '.', ''); ?>',
        '<?php echo $precioconiva = ( $combo[$ii]['ivacombo'] == 'SI' ? number_format($combo[$ii]['precioventa'], 2, '.', '') : "0.00"); ?>',
        '<?php echo "2"; ?>',
        '<?php echo ""; ?>');">
        <div id="<?php echo $combo[$ii]['codcombo']; ?>">
            <div class="darkblue-panel pn" title="<?php echo $combo[$ii]['nomcombo'].'';?>">
                <div class="darkblue-header">
                   <div id="proname" class="text-white font-12"><?php echo getSubString($combo[$ii]['nomcombo'],18);?></div>
                </div>
                <?php if (file_exists("./fotos/combos/".$combo[$ii]["codcombo"].".jpg")){
                echo "<img src='fotos/combos/".$combo[$ii]['codcombo'].".jpg?' class='rounded-circle' style='width:140px;height:134px;'>"; 
                } else {
                echo "<img src='fotos/producto.png' class='rounded-circle' style='width:140px;height:130px;'>";  } ?>
                <input type="hidden" id="category" name="category" value="*******">

                <div class="mask">
                <h5 style="font-size: 11.5px;" class="text-white pull-left"><i class="fa fa-bars"></i> <?php echo number_format($combo[$ii]['existencia'], 2, '.', ',');?></h5>
                <abbr title="<?php echo $cambio == '' ? "" : $cambio[0]['simbolo'].number_format($combo[$ii]['precioventa']/$cambio[0]['montocambio'], 2, '.', ','); ?>"><h5 style="font-size: 11.5px;" class="text-warning pull-right"><?php echo $simbolo.number_format($combo[$ii]['precioventa'], 2, '.', ',');?> </h5></abbr> 
                </div>
            </div>
        </div>

        </div>
        <!-- column -->
                
        <?php } // fin for ?>
        </div><!-- fin row -->
       </div><!-- fin row-vertical -->

        <?php } // fin if ?>

        </div> 
    </div>

<?php endif; ?>




<?php if (isset($_GET['CargaExtras'])): ?>

<?php
$medida = new Login();
$medida = $medida->ListarMedidas();
?>
    <div class="row-horizon">
        <span class="categories selectedGat" id=""><i class="fa fa-home"></i></span>
        <?php 
        if($medida==""){ echo ""; } else {
        $a=1;
        for ($i = 0; $i < sizeof($medida); $i++) { ?>
        <span class="categories" id="<?php echo $medida[$i]['nommedida'];?>"><i class="fa fa-tasks"></i> <?php echo $medida[$i]['nommedida'];?></span>
        <?php } } ?>
    </div>

    <div class="col-md-12">
        <div id="searchContaner"> 
            <div class="form-group has-feedback2"> 
                <label class="control-label"></label>
                <input type="text" class="form-control" name="busquedaproducto" id="busquedaproducto" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Realice la Búsqueda del Producto por Nombre">
                  <i class="fa fa-search form-control-feedback2"></i> 
            </div> 
        </div>
    </div>
    

    <div id="productList2">
        <?php
        $ingrediente = new Login();
        $ingrediente = $ingrediente->ListarIngredientesModal();

        $monedap = new Login();
        $cambio = $monedap->MonedaProductoId(); 

        if($ingrediente==""){

        echo "<div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN EXTRAS REGISTRADOS ACTUALMENTE</center>";
        echo "</div>";  

        } else { ?>

        <!--<div id="divheight">-->
           <div class="row row-vertical">
        <?php for ($ii = 0; $ii < sizeof($ingrediente); $ii++) { ?>

    <div ng-click="afterClick()" ng-repeat="product in ::getFavouriteProducts()" OnClick="DoAction(
    '<?php echo $ingrediente[$ii]['idingrediente']; ?>',
    '<?php echo $ingrediente[$ii]['codingrediente']; ?>',
    '<?php echo $ingrediente[$ii]['nomingrediente']; ?>',
    '<?php echo $ingrediente[$ii]['codmedida']; ?>',
    '<?php echo $ingrediente[$ii]['nommedida']; ?>',
    '<?php echo number_format($ingrediente[$ii]['preciocompra'], 2, '.', ''); ?>',
    '<?php echo number_format($ingrediente[$ii]['precioventa'], 2, '.', ''); ?>',
    '<?php echo number_format($ingrediente[$ii]['descingrediente'], 2, '.', ''); ?>',
    '<?php echo $ingrediente[$ii]['ivaingrediente']; ?>',
    '<?php echo number_format($ingrediente[$ii]['cantingrediente'], 2, '.', ''); ?>',
    '<?php echo $precioconiva = ( $ingrediente[$ii]['ivaingrediente'] == 'SI' ? number_format($ingrediente[$ii]['precioventa'], 2, '.', '') : "0.00"); ?>',
    '<?php echo ""; ?>');"> 
        <div id="<?php echo $ingrediente[$ii]['codingrediente']; ?>">
            <div class="darkblue-panel pn" title="<?php echo $ingrediente[$ii]['nomingrediente'].' | ('.$ingrediente[$ii]['nommedida'].')';?>">
                    <div class="darkblue-header">
                        <div id="proname" class="text-white font-12"><?php echo getSubString($ingrediente[$ii]['nomingrediente'],18);?></div>
                    </div>
        <?php if (file_exists("./fotos/productos/".$ingrediente[$ii]["codingrediente"].".jpg")){

        echo "<img src='fotos/productos/".$ingrediente[$ii]['codingrediente'].".jpg?' class='rounded-circle' style='width:140px;height:134px;'>"; 

        } else {

        echo "<img src='fotos/producto.png' class='rounded-circle' style='width:140px;height:134px;'>";  } ?>

                <input type="hidden" id="category" name="category" value="<?php echo $ingrediente[$ii]['nommedida']; ?>">
                <div class="mask">
                    <a class="text-white">
                    <abbr title="<?php echo $cambio == '' ? "" : $cambio[0]['simbolo'].number_format($ingrediente[$ii]['precioventa']/$cambio[0]['montocambio'], 2, '.', ','); ?>"><?php echo $simbolo.number_format($ingrediente[$ii]['precioventa'], 2, '.', ',');?></abbr>
                    </a>
                </div>

            </div>
        </div>
    </div>
                 
        <?php } } ?>
</div> 
        <!--</div>--> 
    </div>

<?php endif; ?>





<?php 
############################ MUESTRA PRODUCTOS FAVORITOS ###########################
if (isset($_GET['Muestra_Favoritos'])) { 

    $favoritos = new Login();
    $favoritos = $favoritos->ListarProductosFavoritos();
    $x=1;

    echo $status = ($favoritos == '' ? '' : '<hr><label class="control-label">Productos Favoritos:</label><br>');

    if($favoritos==""){

        echo "";      

    } else {

    for($i=0;$i<sizeof($favoritos);$i++){  ?>

    <button type="button" class="button ng-scope" style="font-size:8px;border-radius:5px;width:90px; height:32px;cursor:pointer;" ng-click="afterClick()" ng-repeat="product in ::getFavouriteProducts()" OnClick="DoAction('<?php echo $favoritos[$i]['idproducto']; ?>','<?php echo $favoritos[$i]['codproducto']; ?>','<?php echo $favoritos[$i]['producto']; ?>','<?php echo $favoritos[$i]['codcategoria']; ?>','<?php echo $favoritos[$i]['nomcategoria']; ?>','<?php echo number_format($favoritos[$i]['preciocompra'], 2, '.', ''); ?>','<?php echo number_format($favoritos[$i]['precioventa'], 2, '.', ''); ?>','<?php echo number_format($favoritos[$i]['descproducto'], 2, '.', ''); ?>','<?php echo $favoritos[$i]['ivaproducto']; ?>','<?php echo number_format($favoritos[$i]['existencia'], 2, '.', ''); ?>','<?php echo $precioconiva = ( $favoritos[$i]['ivaproducto'] == 'SI' ? number_format($favoritos[$i]['precioventa'], 2, '.', '') : "0.00"); ?>','<?php echo "1"; ?>','<?php echo ""; ?>');" title="<?php echo $favoritos[$i]['producto'];?>"><span class="product-label ng-binding "><?php echo getSubString($favoritos[$i]['producto'], 13);?></span></button>

     <?php /*if($x==5){ echo "<div class='clearfix'></div>"; $x=0; } $x++;*/ } } ?><hr>

<?php  }
############################ MUESTRA PRODUCTOS FAVORITOS ###########################
?>







<script type="text/javascript">
$(document).ready(function() {

    //  search product
   $("#busquedaproducto").keyup(function(){
      // Retrieve the input field text
      var filter = $(this).val();
      // Loop through the list
      $("#productList2 #proname").each(function(){
         // If the list item does not contain the text phrase fade it out
         if ($(this).text().search(new RegExp(filter, "i")) < 0) {
             $(this).parent().parent().parent().hide();
         // Show the list item if the phrase matches
         } else {
             $(this).parent().parent().parent().show();
         }
      });
   });
});


$(".categorias").on("click", function () {
   // Retrieve the input field text
   var filter = $(this).attr('id');
   $(this).parent().children().removeClass('selectedGat');
   $(this).addClass('selectedGat');
});


$(".categories").on("click", function () {
   // Retrieve the input field text
   var filter = $(this).attr('id');
   $(this).parent().children().removeClass('selectedGat');

   $(this).addClass('selectedGat');
   // Loop through the list
   $("#productList2 #category").each(function(){
      // If the list item does not contain the text phrase fade it out
      if ($(this).val().search(new RegExp(filter, "i")) < 0) {
         $(this).parent().parent().parent().hide();
         // Show the list item if the phrase matches
      } else {
         $(this).parent().parent().parent().show();
      }
   });
});

</script>