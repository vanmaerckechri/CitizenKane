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

	public function update($updateList)
    {
    	$dbh = $this->dbh;

		$upt = $dbh->prepare('UPDATE beerproject SET title = :title, date = :date, beers = :beers, link = :link WHERE id = :id');
		foreach ($updateList as $id => $brasserie)
		{
			$upt->bindParam(':id', $id, PDO::PARAM_INT);
			$upt->bindParam(':title', $brasserie["title"], PDO::PARAM_STR);
			if ($brasserie["date"] === false)
			{
				$currentDate = date('Y-m-d');
				$upt->bindParam(':date', $currentDate, PDO::PARAM_STR);
			}
			else
			{
				$upt->bindParam(':date', $brasserie["date"], PDO::PARAM_STR);
			}
			$upt->bindParam(':beers', $brasserie["beers"], PDO::PARAM_STR);
			$upt->bindParam(':link', $brasserie["link"], PDO::PARAM_STR);
			$upt->execute();
		}
	}

	public function delete($deleteList)
    {
    	$dbh = $this->dbh;

    	$del = $dbh->prepare("DELETE FROM beerproject WHERE id = :id");
		foreach ($deleteList as $key => $id)
		{
			$del->bindParam(':id', $id, PDO::PARAM_INT);   
			$del->execute();
		}
	}

	public function insert($newBrasserieList)
    {
    	$dbh = $this->dbh;
    	$ins = $dbh->prepare("INSERT INTO beerproject (title, date, beers, link) VALUES (:title, :date, :beers, :link)");

    	foreach ($newBrasserieList as $key => $brasserie)
    	{
			$ins->bindParam(':title', $brasserie["title"], PDO::PARAM_STR);
			if ($brasserie["date"] === false)
			{
				$currentDate = date('Y-m-d');
				$ins->bindParam(':date', $currentDate, PDO::PARAM_STR);
			}
			else
			{
				$ins->bindParam(':date', $brasserie["date"], PDO::PARAM_STR);
			}			
			$ins->bindParam(':beers', $brasserie["beers"], PDO::PARAM_STR);
			$ins->bindParam(':link', $brasserie["link"], PDO::PARAM_STR);
			$ins->execute();
    	}
    }
}
