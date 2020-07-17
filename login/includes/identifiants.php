<?php
try
{
        $db = new PDO('mysql:host=localhost:3308;dbname=projet', 'root', '');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
?>
