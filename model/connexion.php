<?php

class Connexion
{
	public function dbConnect()
	{
		$host = 'localhost';
		$db = 'citizen_kane';
		$charset = 'utf8';		
		$user = 'root';
		$pass = '';

		$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
		$options = [
	    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	    PDO::ATTR_EMULATE_PREPARES   => false,
		];
		
		try
		{
			$dbh = new PDO($dsn, $user, $pass, $options);
		}
		catch (\PDOException $e) 
		{
     		throw new \PDOException($e->getMessage(), (int)$e->getCode());
		}
		return $dbh;		
	}
}

class Session
{
	public function testAdmin()
	{
		$_SESSION["name"] = "chef";
		$_SESSION["pwd"] = "1234";

		if (isset($_SESSION["name"]) && isset($_SESSION["pwd"]) && $_SESSION["name"] == "" && $_SESSION["pwd"] == "1234")
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}