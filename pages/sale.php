<?php include('../conexionmongodb.php'); ?>
<?php include('../bisnes_logic/conexion.php'); ?>
<?php include('../bisnes_logic/code_sale.php'); ?>
<?php
$seleccionar=false;
$cantidad="";
$id_articulo_select;
//metodo de seleccionar
if(isset($_GET['sele'])){
    $idar=$_GET['sele'];
    $seleccionar=true;
    $colección = $cliente->store->venta;
    $resultado = $colección->find(  ['_id' => new \MongoDB\BSON\ObjectID($idar)] );
    foreach ($resultado as $entry) {
        $articulo=$entry['articulo'];
        $fecha=$entry['fecha'];
        $cantidad=$entry['cantidad'];
        $total=$entry['total'];
    }

    $colección = $cliente->store->articulo;
    $resultado = $colección->find(  ['nombre' => $articulo] );
    foreach ($resultado as $entry) {
        $id_articulo_select=$entry['_id'];
    }

    echo $id_articulo_select;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Category room</title>
    <link href="../shared/styles/sale.css" rel="stylesheet">
    <link href="../shared/styles/generic_style.css" rel="stylesheet">
    <link href="../shared/styles/index.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../shared/styles/style-h.css">

    <!-- Recurso adicional-->
    <link href="../shared/fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="../shared/fontawesome/css/brands.css" rel="stylesheet">
    <link href="../shared/fontawesome/css/solid.css" rel="stylesheet">
</head>
<body>
    <header>
            <h1>CLOTHING STORE</h1>
            <nav>
            <a href="../index.html"> Inicio</a>
          <a href="category_article.php">Categoría de artículos</a>
          <a href="article.php">Artículo</a>
          <a href="sale.php">Ventas</a>
          <a href="about.html">Acerca de </a>
            </nav>
    </header>
    <div class="wrapper">
    <section>
        <h2 class="tittle_page_page">Ventas</h2><br>
        <?php 

                $colección = $cliente->store->venta;
                $resultado = $colección->find(  [] );
                echo "<table align='center'>
                <tr>
                    <th>Articulo</th>
                    <th>Fecha</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th></th>
                </tr>";

                foreach ($resultado as $entry) {
                    echo "<td>".$entry['articulo']."</td> <td>".$entry['fecha']."</td> <td> ".$entry['cantidad']."</td> <td> $ ".$entry['total']."</td>";
                    echo "<td><a href=../pages/sale.php?sele=".$entry['_id']." ><i class='fas fa-hand-pointer'></i></a></td>   ";                 
                    ?>
                    </tr>
                    <?php }                
                echo "</table>";  
    ?>
   
   <br>
   <a href="sale.php">
   <i class="fas fa-plus-circle fa-2x" style="color: #17a2b8;"></i>
    
   </a>

    <div  class="form_data" id="container_button_add_sale">
        <form method="post" action="sale.php"> 
        <input  type="hidden" name="idar" value="<?php echo $idar; ?>"><br>
        <input  type="hidden" name="cantidad_anterior" value="<?php echo $cantidad; ?>"><br>
            <h3>Agregar</h3>
            
            <?php if($seleccionar == true): ?>
            <label>Artículo : $ <?php echo $articulo;?></label>
            <br>
            <label>Total: $ <?php echo $total;?></label>
            <?php else: ?> 
            <label>Articulo</label>
            <?php  
                $colección = $cliente->store->articulo;
                $resultado = $colección->find(  [] );
                ?>
                    <select selected="5ca4924a68f5b20bec001e85" name='articulo'>
                <?php
                
                $lista1="";
                foreach ($resultado as $entry) {
                    $lista1.="\n<option value='".$entry['_id']."'>".$entry['nombre']." - Existencia--  ".$entry['existencia']."  Precio :$ ".$entry['precio']." </option>"; 
                }                
                $lista1.="</select>"; 
                echo $lista1; 
            ?>

            <?php endif ?>
           
            <label>Cantidad</label>
            <input name="cantidad" type="number_format" value="<?php echo $cantidad; ?>" required>

            <?php if($seleccionar == true): ?>
            <label>Fecha</label>
            <input name="fecha" type="date" value="<?php echo $fecha; ?>" required>
        <button class="btn btn_update" type="submit" name="update">Actualizar <i class="fas fa-pen"></i></button>&nbsp;&nbsp;
        <button class="btn btn_delete" type="submit" name="eliminar">Eliminar <i class="fas fa-trash"></i></button><br><br>
        <?php else: ?>
     
         <button class="btn btn_add" type="submit" name="save">Guardar <i class="fas fa-save"></i></button>
       
<?php endif ?>
        </form>
    </div>


    </section>
    </div>
</body>
<footer>
    <div class="container-footer-all">
        <div class="container-body">
            <div class="colum1">
                <h1>Información de la página</h1>
                <p>La primer funcionalidad de la pagina es mostrar los articulos de moda en venta</p>
            </div>
            <div class="colum2">
                <h1>Desarrolladores</h1>
                <div class="row">
                    <label>Jorge Jacobo</label>
                </div>
                <div class="row">
                    <label>Amanda Franco</label>
                </div>
                <div class="row">
                    <label>Alexis Zamudio</label>
                </div>
                <div class="row">
                    <label>David Hernández</label>
                </div>
            </div>
            <div class="colum3">
                <h1>Información de la tienda</h1>
                <div class="row2">
                    <label>Clothing store es una tienda dedicada a vender moda desde el 2019</label>
                </div>
            </div>
        </div>
    </div>
    <div class="container-footer">
        <div class="footer">
            <div class="copyright">
                © 2019 Todos los Derechos Reservados para | Clothing Store
            </div>
        </div>
    </div>
</footer>
<script src="../js/sale.js"></script>
</html>