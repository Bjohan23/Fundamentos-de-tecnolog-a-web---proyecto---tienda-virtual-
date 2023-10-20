<?php
require('fpdf186/fpdf.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    // El usuario no ha iniciado sesión, redirígelo al formulario de inicio de sesión o al registro.
    header("Location: ../usuario/login.php");
    exit();
}

// Obtén los datos del carrito de compras desde la base de datos
require("../config/conexion.php");

$id_usuario = $_SESSION['user_id'];
$usuario = $_SESSION['username'];


$sql = "SELECT p.nombre, p.precio_rebajado, c.cantidad FROM carrito_compras c
        JOIN productos p ON c.id_productos = p.id
        WHERE c.id_clientes = ?";

$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_usuario);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 10, 'Detalle del Cliente', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(40, 10, 'ID: '. $id_usuario,0,1);
$pdf->Cell(40, 10, 'NOMBRE: '. $usuario,0,1);

// Agregar título
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 10, 'Detalle del Pedido', 0, 1);

// Generar tabla con los detalles de los productos
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(40, 10, 'Producto', 1);
$pdf->Cell(40, 10, 'Precio', 1);
$pdf->Cell(40, 10, 'Cantidad', 1);
$pdf->Cell(40, 10, 'Subtotal', 1);
$pdf->Ln();

$total_pedido = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $nombre_producto = $row["nombre"];
    $precio = $row["precio_rebajado"];
    $cantidad = $row["cantidad"];
    $subtotal = $precio * $cantidad;
    $total_pedido += $subtotal;

    $pdf->Cell(40, 10, $nombre_producto, 1);
    $pdf->Cell(40, 10, "$" . $precio, 1);
    $pdf->Cell(40, 10, $cantidad, 1);
    $pdf->Cell(40, 10, "$" . $subtotal, 1);
    $pdf->Ln();
}

// Mostrar el total del pedido
$pdf->Cell(160, 10, 'Total del Pedido:', 1);
$pdf->Cell(40, 10, "$" . $total_pedido, 1);

// Nombre del archivo PDF
$nombre_archivo = 'detalle_pedido.pdf';

// Salida del PDF
$pdf->Output($nombre_archivo, 'D');
?>
