<?php

class cartes
{
	function __construct()
	{
        $this->connect = new Connexion();
        $this->dbh = $this->connect->dbConnect();
    }

	public function updatePlats($plats)
	{
		$dbh = $this->dbh;
		foreach ($plats as $keyCarte => $carte)
		{
			$name = false;
			$price = false;
			$compo = false;
			$updPrepare = "UPDATE plats SET";
			foreach ($carte as $keyProp => $propery)
			{
				if ($keyProp == "name")
				{
					$updPrepare .= " name = :name,";
					$name = true;
				}
				if ($keyProp == "price") 
				{
					$updPrepare .= " price = :price,";
					$price = true;
				}
				if ($keyProp == "compo")
				{
					$updPrepare .= " compo = :compo,";
					$compo = true;
				}
			}
			$updPrepare[strlen($updPrepare) - 1] = " ";
			$updPrepare .= "WHERE id = :id";
			$upd = $dbh->prepare($updPrepare);
			if ($name === true)
			{
				$upd->bindParam(':name', $carte["name"], PDO::PARAM_STR);
			}
			if ($price === true)
			{
				$upd->bindParam(':price',  $carte["price"], PDO::PARAM_STR);
			}
			if ($compo === true)
			{
				$upd->bindParam(':compo',  $carte["compo"], PDO::PARAM_STR);
			}
			$upd->bindParam(':id',  $keyCarte, PDO::PARAM_STR);
			$upd->execute();
		}
	}
	public function updatePlatsOrder($cartes)
	{
		$dbh = $this->dbh;
		// select all const id
		$sth = $dbh->prepare('SELECT id from rel_cartes_plats WHERE id_carte = :id_carte');
		$upt = $dbh->prepare('UPDATE rel_cartes_plats SET id_plat = :newId_plat WHERE id = :id');
		foreach ($cartes as $keyCarte => $carte)
		{
			$sth->bindParam(':id_carte', $keyCarte, PDO::PARAM_STR);
			$sth->execute();
			$ids = $sth->fetchAll(PDO::FETCH_COLUMN);

			foreach ($carte as $keyPlat => $idPlat) 
			{
				$upt->bindParam(':newId_plat', $idPlat, PDO::PARAM_INT);
				$upt->bindParam(':id', $ids[$keyPlat], PDO::PARAM_INT);
				$upt->execute();
			}
		}
	}

	public function getCartes($page)
	{
		$dbh = $this->dbh;
		// cartes Family
		$sth = $dbh->prepare('SELECT id_carte, family from pages WHERE name = :name');
		$carte = [];
		$sth->bindParam(':name', $page, PDO::PARAM_STR);
		$sth->execute();
		$carte = $sth->fetchAll(PDO::FETCH_ASSOC);

		// reorganize result
		$cartesSorted = [];
		foreach ($carte as $key => $carte)
		{
			$cartesSorted[$carte["family"]][$carte["id_carte"]] = [];
		}

		// cartes Description
		$sth = $dbh->prepare('SELECT title, buttonDescription, imgSrc, imgAlt from cartes WHERE id = :id');
		foreach ($cartesSorted as $keyFamily => $family)
		{
			foreach ($family as $keyCarte => $carte)
			{
				$sth->bindParam(':id', $keyCarte, PDO::PARAM_INT);
				$sth->execute();
				$cartesSorted[$keyFamily][$keyCarte]["description"] = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
			}
		}

		// plats
		$sth = $dbh->prepare('SELECT plats.* from rel_cartes_plats as rel, plats WHERE rel.id_carte = :id && rel.id_plat = plats.id');
		foreach ($cartesSorted as $keyFamily => $family)
		{
			foreach ($family as $keyCarte => $carte)
			{
				$sth->bindParam(':id', $keyCarte, PDO::PARAM_INT);
				$sth->execute();
				$cartesSorted[$keyFamily][$keyCarte]["plats"] = $sth->fetchAll(PDO::FETCH_ASSOC);
			}
		}

		// reorganize result
		$finalCarte = [];
		foreach ($cartesSorted as $keyFam => $family)
		{
			$finalCarte[$keyFam] = [];
			foreach ($family as $keyCarte => $carte)
			{
				$finalCarte[$keyFam][$keyCarte]["description"] = $carte["description"];
				foreach ($carte["plats"] as $keyPlats => $plat)
				{
					$id = $plat["id"];
					unset($plat["id"]);
					$finalCarte[$keyFam][$keyCarte]["plats"][$id] = $plat;
				}
			}
		}
		return $finalCarte;
	}
}
