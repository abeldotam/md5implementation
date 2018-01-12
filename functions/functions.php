<?php
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function generateDataSQL() {
	include 'sql.php';
	if ($connexionSql == 1)
 	{
 		$req = $bdd->query("TRUNCATE `table_md5`;");
		$req->execute();
 		for ($i=0; $i < 100; $i++)
 		{
 			$username = "id".$i;
 			$password = generateRandomString(rand(5, 15));
 			$password_hashed = implementMD5($password);
			$salt = implementMD5("I'am writing this code at 2 A.M. and I'm tired, but that's a good passphrase I guess");
 			$password_hashed_salted = implementMD5($salt.$password.strrev($salt));
 			$req = $bdd->prepare('INSERT INTO `table_md5` (`id`, `username`, `password`, `password_hash`, `password_hash_salt`) VALUES (NULL, ?, ?, ?, ?);');
    		$req->execute(array($username,
    							$password,
    							$password_hashed,
    							$password_hashed_salted,
    							));
    		
 		}
 	}
}

function getDataFromDatabase() {
	include 'sql.php';
	if ($connexionSql == 1)
 	{
 		$req = $bdd->prepare('SELECT * FROM `table_md5`');
	    $req->execute();
		$data = $req->fetchAll();
	}
  	else $data = 0;
  	return $data;
}
