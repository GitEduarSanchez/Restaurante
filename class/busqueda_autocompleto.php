<?php
include('class.consultas.php');

if (isset($_GET['Busqueda_Categorias'])):

$filtro = $_GET["term"];
$Json = new Json;
$categoria = $Json->BuscaCategoria($filtro);
echo json_encode($categoria);

endif;

if (isset($_GET['Busqueda_Clientes'])):

$filtro = $_GET["term"];
$Json = new Json;
$clientes = $Json->BuscaClientes($filtro);
echo json_encode($clientes);

endif;

if (isset($_GET['Busqueda_Kardex_Ingredientes']) or isset($_GET['Busqueda_Ingredientes'])):

$filtro = $_GET["term"];
$Json = new Json;
$kardex = $Json->BuscaIngrediente($filtro);
echo json_encode($kardex);

endif;

if (isset($_GET['Busqueda_Kardex_Producto']) or isset($_GET['Busqueda_Productos_Ventas'])):

$filtro = $_GET["term"];
$Json = new Json;
$producto  = $Json->BuscaProducto($filtro);
echo json_encode($producto);

endif;

if (isset($_GET['Busqueda_Productos_Compras'])):

$filtro = $_GET["term"];
$Json = new Json;
$producto = $Json->BuscaProducto($filtro);
echo json_encode($producto);

endif;

if (isset($_GET['Busqueda_Kardex_Combo']) or isset($_GET['Busqueda_Combos'])):

$filtro = $_GET["term"];
$Json = new Json;
$combo  = $Json->BuscaCombo($filtro);
echo json_encode($combo);

endif;

if (isset($_GET['Busqueda_Facturas'])):

$filtro = $_GET["term"];
$Json = new Json;
$facturas = $Json->BuscaFactura($filtro);
echo json_encode($facturas);

endif;

?>  