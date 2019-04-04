
<?php
    if(isset($_POST['insert'])) {
        $categoria = $_POST['categoria'];
        $colección = $cliente->store->categoria_articulos;
        $resultado = $colección->find( ['nombre'=>$categoria] );
        $exist=false;
        foreach ($resultado as $entry) {
            $exist=TRUE;
        }
        if($exist==TRUE){
            echo'<script type="text/javascript">
            alert("Esta categoría ya existe");
            window.location.href="../pages/category_article.php";
            </script>';
        } else{
            $fecha=strftime( "%Y-%m-%d", time() );
            $data = array( 
            "nombre" => $categoria, 
            "agregado" =>$fecha, 
            "actualizado" => $fecha
            );
            $colección = $cliente->store->categoria_articulos;
            $colección->insertOne($data);
            echo "<script>window.open('category_article.php','_self')</script>";
        }
    }

?> 

    <?php 
    if(isset($_POST['update'])){
        $actualizar_categoria = $_POST['categoria'];
        $id_actu=$_POST['id'];

        $colección = $cliente->store->categoria_articulos;
        $resultado = $colección->find( ['nombre'=>$actualizar_categoria] );
        $exist=false;
        foreach ($resultado as $entry) {
            $exist=TRUE;
        }

        if($exist==TRUE){
            echo'<script type="text/javascript">
            alert("Esta categoría ya existe");
            window.location.href="../pages/category_article.php";
            </script>';
        }else {
            $fecha=strftime( "%Y-%m-%d", time() );
            $colección = $cliente->store->categoria_articulos;
            $updateResult = $colección->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectID($id_actu)],
                ['$set' => ['nombre' => $actualizar_categoria,'actualizado'=>$fecha]]
            );
        echo "<script>window.open('../pages/category_article.php','_self')</script>";
    }
    }
    ?> 

 <?php 
    if(isset($_POST['eliminar'])){

        $borrar_id = $_POST['id'];
        $colección = $cliente->store->categoria_articulos;
        $updateResult = $colección->deleteOne(
            ['_id' => new \MongoDB\BSON\ObjectID($borrar_id)]);
            echo "<script>window.open('../pages/category_article.php','_self')</script>";        
        }   
 ?>
