<?php
/**
	Holds start and stop connection to the database
*/

	$pdo;
	function startConnection()
	{
		global $pdo;
		try
		{
			$connString = "mysql:host=localhost;dbname=art;charset=utf8";
			$user="testuser";
			$password="mypassword";
		
			$pdo = new PDO($connString,$user,$password);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (PDOException $e)
		{
			die($e -> getMessage());
		}
	}

	function getRow($sql)
	{
		global $pdo;
		$result = $pdo->query($sql);
		$row = $result->fetch();
		return $row;
	}

	function getPDO($sql)
	{
		global $pdo;
		$result = $pdo->query($sql);
		return $result;
	}
	
	function getNext($result)
	{
		$row = $result->fetch();
		return $row;
	}
		
	function killDBConnection()
	{
		global $pdo;
		$pdo=null;
	}


?>