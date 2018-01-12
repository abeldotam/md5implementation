<?php
try
{
	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$bdd = new PDO('mysql:host=HOST;dbname=DBNAME', 'USER', 'PASSWORD',$pdo_options);
	$connexionSql = 1;
}
catch(PDOException $e)
{
        echo "PDO a retourné ce message d'erreur: " . $e->getMessage();
} 
catch (Exception $e) {
	echo "Problem with database connexion";
	$connexionSql = 0;
}
?>