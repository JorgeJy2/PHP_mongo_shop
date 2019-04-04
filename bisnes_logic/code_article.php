<?php
$idar=0;
$articulo="";
$precio="";
$existencia="";
$descripcion="";
$categoria=0;
    
/**Metodo guardar */
if(isset($_POST['guardar']))
    {
        $articulo=$_POST['articulo'];
        $precio=$_POST['precio'];
        $existencia=$_POST['existencia'];
        $descripcion=$_POST['descripcion'];
        $categoria=$_POST['categoria'];

        if($categoria=="Click aquí"){
            echo'<script type="text/javascript">
            alert("Ingresa una categoría");
            window.location.href="../pages/article.php";
            </script>';
        }else{
            $colección = $cliente->store->articulo;
            $resultado = $colección->find( ['nombre'=>$articulo] );
            $exist=false;
            foreach ($resultado as $entry) {
                $exist=TRUE;
            }

            if($exist==TRUE){
                echo'<script type="text/javascript">
                alert("Ese articulo ya existe");
                window.location.href="../pages/article.php";
                </script>';
            }else{
                    if($existencia<=0){
                        echo'<script type="text/javascript">
                        alert("Ingresa una existencia valida");
                        window.location.href="../pages/article.php";
                        </script>';
                    }else{

                        $fecha=strftime( "%Y-%m-%d", time() );
                        $data = array( 
                        "nombre" => $articulo, 
                        "precio"=>$precio,
                        "existencia"=>$existencia,
                        "descripcion"=>$descripcion,
                        "agregado" =>$fecha, 
                        "actualizado" => $fecha,
                        "categoria"=>$categoria
                        );
                        $colección = $cliente->store->articulo;
                        $colección->insertOne($data);           
                        header('location:../pages/article.php');  
                    }   
            
            }
       
        }
    }

     /*Metodo actualizar */
     if(isset($_POST['update'])){
        $idar=$_POST['idar'];
        $articulo=$_POST['articulo'];
        $precio=$_POST['precio'];
        $existencia=$_POST['existencia'];
        $descripcion=$_POST['descripcion'];
        $categoria=$_POST['categoria'];
       
        if($categoria=="----------------------"){
            echo'<script type="text/javascript">
            alert("Ingresa una categoría");
            window.location.href="../pages/article.php";
            </script>';
        }else{
            if($existencia<=0){
                        echo'<script type="text/javascript">
                        alert("Ingresa una existencia valida");
                        window.location.href="../pages/article.php";
                        </script>';
        }else{

            $fecha=strftime( "%Y-%m-%d", time() );
            $colección = $cliente->store->articulo;
            $updateResult = $colección->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectID($idar)],
                ['$set' => ['nombre' => $articulo,'actualizado'=>$fecha,"precio"=>$precio,
                "existencia"=>$existencia,"descripcion"=>$descripcion,"categoria"=>$categoria]]);
                        header('location:../pages/article.php');
                    }
            }
    }//llave grande

    /*Metodo eliminar */
    if(isset($_POST['eliminar'])){

        $idar=$_POST['idar'];
        $colección = $cliente->store->articulo;
        $updateResult = $colección->deleteOne(
            ['_id' => new \MongoDB\BSON\ObjectID($idar)]);
        header('location:../pages/article.php');
    }
    ?>