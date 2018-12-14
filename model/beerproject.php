<?php

class BeerProject
{
	function __construct()
	{
        $this->connect = new Connexion();
        $this->dbh = $this->connect->dbConnect();
    }

    public function getList()
    {
    	$dbh = $this->dbh;

    	$reqAll = $dbh->prepare('SELECT * from beerproject ORDER BY date DESC');
    	$reqAll->execute();
		$beerProjectList = $reqAll->fetchAll(PDO::FETCH_ASSOC);

		return $beerProjectList;
	}
}
