<?php

        if(isset($_POST['username'])) {
            var_dump($result);
            session_start();
            $_SESSION['username'] = $result['author'];
            header('Location: ../recettes.php');
        } else{
            header('Location: ../index.php');
        }    
?>

                