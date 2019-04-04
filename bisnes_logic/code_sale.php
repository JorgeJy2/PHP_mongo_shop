<?php

    if(isset($_POST["save"]))
    {
        $articulo= $_POST['articulo'];  
        $cantidad=$_POST['cantidad'];     
        $colección = $cliente->store->articulo;
        $resultado = $colección->find(  ['_id' => new \MongoDB\BSON\ObjectID($articulo)] );
        foreach ($resultado as $entry) {
            $articulo_nombre=$entry['nombre'];
            $precio=$entry['precio'];
            $existencia=$entry['existencia'];
        }
        if($existencia<$cantidad){
            echo'<script type="text/javascript">
            alert("La cantidad selecionada supera a la existente en tienda");
            </script>';
        }else { $total=$cantidad*$precio;
            $fecha=strftime( "%Y-%m-%d", time() );
                            $data = array( 
                            "articulo" => $articulo_nombre, 
                            "fecha"=>$fecha,
                            "cantidad"=>$cantidad,
                            "total"=>$total
                            );
                            
            $colección = $cliente->store->venta;
            $colección->insertOne($data);   
            $new_existencia=$existencia-$cantidad;
            $colección = $cliente->store->articulo;
            $updateResult = $colección->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectID($articulo)],
                ['$set' => ["existencia"=>$new_existencia]]);
            }
       
    }

    if(isset($_POST['update'])){
        $articulo= $_POST['articulo'];  
        $cantidad=$_POST['cantidad']; 
        $fecha=$_POST['fecha'];    
        $idar=$_POST['idar'];  
        $cantidad_anterior=$_POST['cantidad_anterior'];     

        $colección = $cliente->store->articulo;
        $resultado = $colección->find(  ['_id' => new \MongoDB\BSON\ObjectID($articulo)] );
        $articulo_nombre;
        $precio;
        $existencia;
        $num_new=$cantidad_anterior-$cantidad;
        echo $num_new;

        foreach ($resultado as $entry) {
            $articulo_nombre=$entry['nombre'];
            $precio=$entry['precio'];
            $existencia=$entry['existencia'];
        }

        if($num_new<0){
            echo "menor";
            $new_catidad_articulo=$existencia+$num_new;
            if($new_catidad_articulo>=0)
            {
                echo "Cantidad aceptable";
                echo $new_catidad_articulo;
                $updateResult = $colección->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectID($articulo)],
                ['$set' => ["existencia"=>$new_catidad_articulo]]);


                $total=$cantidad*$precio;
                $colección = $cliente->store->venta;
                $updateResult = $colección->updateOne(
                    ['_id' => new \MongoDB\BSON\ObjectID($idar)],
                    ['$set' => ['articulo' => $articulo_nombre,"cantidad"=>$cantidad,"total"=>$total,"fecha"=>$fecha]]);
            }else {
                echo'<script type="text/javascript">
                alert("La cantidad selecionada supera a la existente en tienda");
                </script>';
            }
        }else {
            echo "mayor";
            $new_catidad_articulo=$existencia+$num_new;
            echo $new_catidad_articulo;
            $updateResult = $colección->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectID($articulo)],
                ['$set' => ["existencia"=>$new_catidad_articulo]]);

                $total=$cantidad*$precio;
                $colección = $cliente->store->venta;
                $updateResult = $colección->updateOne(
                    ['_id' => new \MongoDB\BSON\ObjectID($idar)],
                    ['$set' => ['articulo' => $articulo_nombre,"cantidad"=>$cantidad,"total"=>$total,"fecha"=>$fecha]]);    
        }

      
    }
    
    if(isset($_POST['eliminar'])){ 
        $id=$_POST['idar'];
        $articulo= $_POST['articulo'];  
        $cantidad=$_POST['cantidad'];  
        $colección = $cliente->store->articulo;
        $resultado = $colección->find(  ['_id' => new \MongoDB\BSON\ObjectID($articulo)] );
        foreach ($resultado as $entry) {
            $existencia=$entry['existencia'];
        }
        $new_existencia=$existencia+$cantidad;
        $colección = $cliente->store->articulo;
        $updateResult = $colección->updateOne(
            ['_id' => new \MongoDB\BSON\ObjectID($articulo)],
            ['$set' => ["existencia"=>$new_existencia]]);
        $colección = $cliente->store->venta;
        $updateResult = $colección->deleteOne(
            ['_id' => new \MongoDB\BSON\ObjectID($id)]);
    }
?>