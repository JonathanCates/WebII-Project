<?php
/**
	Holds start and stop connection to the database
*/

	function startConnection()
	{
		try
		{
			$connString = "mysql:host=localhost;dbname=art;charset=utf8";
			$user="testuser";
			$password="mypassword";
		
			$pdo = new PDO($connString,$user,$password);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $pdo;
		}
		catch (PDOException $e)
		{
			die($e -> getMessage());
		}
	}

	function getRow($pdo, $sql)
	{
		$result = $pdo->query($sql);
		$row = $result->fetch();
		return $row;
	}

	function getPDO($pdo, $sql)
	{
		$result = $pdo->query($sql);
		return $result;
	}
	
	function getNext($pdo)
	{
		$row = $pdo->fetch();
		return $row;
	}
		
	function killDBConnection($pdo)
	{
		$pdo=null;
	}


?>