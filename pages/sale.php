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
}
?>
<script>
    function soloLetras(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = "áéíóúabcdefghijklmnñopqrstuvwxyz ";

        if(letras.indexOf(tecla)==-1){
            return false;
        }
    }

    function soloNumeros(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = "0123456789.";

        if(letras.indexOf(tecla)==-1){
            return false;
        }
    }

    function soloNumeros2(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = "0123456789";

        if(letras.indexOf(tecla)==-1){
            return false;
        }
    }


    function filterFloat(evt,input){
    // Backspace = 8, Enter = 13, ‘0' = 48, ‘9' = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode;    
    var chark = String.fromCharCode(key);
    var tempValue = input.value+chark;
    if(key >= 48 && key <= 57){
        if(filter(tempValue)=== false){
            return false;
        }else{       
            return true;
        }
    }else{
          if(key == 8 || key == 13 || key == 0) {     
              return true;              
          }else if(key == 46){
                if(filter(tempValue)=== false){
                    return false;
                }else{       
                    return true;
                }
          }else{
              return false;
          }
    }
}
function filter(__val__){
    var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
    if(preg.test(__val__) === true){
        return true;
    }else{
       return false;
    }
    
}
 
</script>

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
            <input  type="text" value="<?php echo $id_articulo_select;?>"  name='articulo'>
            <?php else: ?> 
            <label>Articulo</label>
            <?php  
                $colección = $cliente->store->articulo;
                $resultado = $colección->find(  [] );
                ?>
                    <select name='articulo'>
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
            <input name="cantidad" onkeypress="return soloNumeros(event)" type="text"  maxlength="20" value="<?php echo $cantidad; ?>" required>

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