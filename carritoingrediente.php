<?php
//CARRITO DE ENTRADAS DE PRODUCTOS
session_start();
$ObjetoCarrito   = json_decode($_POST['MiCarrito']);
if ($ObjetoCarrito->Codigo=="vaciar") {
    unset($_SESSION["CarritoIngrediente"]);
} else {
    if (isset($_SESSION['CarritoIngrediente'])) {
        $carrito=$_SESSION['CarritoIngrediente'];
        if (isset($ObjetoCarrito->Codigo)) {
            $txtCodigo = $ObjetoCarrito->Codigo;
            $producto= $ObjetoCarrito->Producto;
            $medida = $ObjetoCarrito->Medida;
            $precio = $ObjetoCarrito->Precio;
            $precio2 = $ObjetoCarrito->Precio2;
            $cantidad = $ObjetoCarrito->Cantidad;
            $opCantidad = $ObjetoCarrito->opCantidad;

            $donde  = array_search($txtCodigo, array_column($carrito, 'txtCodigo'));

            if ($donde !== FALSE) {
                if ($opCantidad === '=') {
                    $cuanto = $cantidad;
                } else {
                    $cuanto = $carrito[$donde]['cantidad'] + $cantidad;
                }
                $carrito[$donde] = array(
                    "txtCodigo"=>$txtCodigo,
                    "producto"=>$producto,
                    "medida"=>$medida,
                    "precio"=>$precio,
                    "precio2"=>$precio2,
                    "cantidad"=>$cuanto
                );
            } else {
                $carrito[]=array(
                    "txtCodigo"=>$txtCodigo,
                    "producto"=>$producto,
                    "medida"=>$medida,
                    "precio"=>$precio,
                    "precio2"=>$precio2,
                    "cantidad"=>$cantidad
                );
            }
        }
    } else {
        $txtCodigo = $ObjetoCarrito->Codigo;
        $producto = $ObjetoCarrito->Producto;
        $medida = $ObjetoCarrito->Medida;
        $precio = $ObjetoCarrito->Precio;
        $precio2 = $ObjetoCarrito->Precio2;
        $cantidad = $ObjetoCarrito->Cantidad;
        $carrito[] = array(
            "txtCodigo"=>$txtCodigo,
            "producto"=>$producto,
            "medida"=>$medida,
            "precio"=>$precio,
            "precio2"=>$precio2,
            "cantidad"=>$cantidad
        );
    }
    $carrito = array_values(
        array_filter($carrito, function($v) {
            return $v['cantidad'] > 0;
        })
    );
    $_SESSION['CarritoIngrediente'] = $carrito;
    echo json_encode($_SESSION['CarritoIngrediente']);
}
