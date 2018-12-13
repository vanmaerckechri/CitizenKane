<?php

class Cartes
{
	function __construct()
	{
        $this->connect = new Connexion();
        $this->dbh = $this->connect->dbConnect();
    }

    public function insertPlats($newPlats)
    {
    	$dbh = $this->dbh;

		$insPlat = $dbh->prepare("INSERT INTO plats (name, price, compo) VALUES (:name, :prix, :compo)");
		$insRelId = $dbh->prepare("INSERT INTO rel_cartes_plats (id_carte, id_plat) VALUES (:id_carte, :id_plat)");

		foreach ($newPlats as $carteId => $carte)
		{
			foreach ($carte as $platTitle => $plat) 
			{
				$price = !empty($plat["price"]) ? $plat["price"] : 0; 
				$insPlat->bindParam(':name', $platTitle, PDO::PARAM_STR);
				$insPlat->bindParam(':prix', $price, PDO::PARAM_INT);
				$insPlat->bindParam(':compo', $plat["compo"], PDO::PARAM_STR);
				$insPlat->execute();

				$lastId = $dbh->lastInsertId();

				$insRelId->bindParam(':id_carte', $carteId, PDO::PARAM_INT);
				$insRelId->bindParam(':id_plat', $lastId, PDO::PARAM_INT);
				$insRelId->execute();
			}
		}
    }

    public function uploadPdf($serie)
    {
		$uploads_dir = './assets/pdf/';
		$nameList = [];
		$index = 0;

		foreach ($_FILES as $key => $file)
		{
		    if ($file["error"] == UPLOAD_ERR_OK && $file["type"] == "application/pdf" && stripos($key, $serie) !== false)
		    {
			    // -- Copy New File Into Pdf Folder --
		       	$tmp_name = $file["tmp_name"];
		        $name = basename($file["name"]);
		        move_uploaded_file($tmp_name, "$uploads_dir/$name");

		        // prepare array with all new pdf src for db
		       	array_push($nameList, $name);
		        unset($_FILES[$key]);
		    }
		    $index += 1;
		}
		return $nameList;
    }

    public function importCartesFromOtherPage($importList)
    {
    	$dbh = $this->dbh;
    	$insCarte = $dbh->prepare("INSERT INTO pages (name, family, id_carte) VALUES (:name, :family, :id_carte)");

    	foreach ($importList as $page => $ids)
    	{
	  		foreach ($ids as $id_carte => $name)
			{
				$insCarte->bindParam(':id_carte', $id_carte, PDO::PARAM_INT);						  	
				$insCarte->bindParam(':name', $page, PDO::PARAM_STR);	
				$insCarte->bindParam(':family', $name, PDO::PARAM_STR);
				$insCarte->execute();
			}
    	}
    }

    public function insertCartes($newCartes)
    {
    	$dbh = $this->dbh;

    	$newCarteId = [];
    	$newCarteLinkStyleId = [];

    	$styleCarte = "folder";
		$cartePdfId = [];

		$insCarte = $dbh->prepare("INSERT INTO cartes (title, style) VALUES (:title, :style)");

		$insPage = $dbh->prepare("INSERT INTO pages (name, family, id_carte) VALUES (:name, :family, :id_carte)");

		foreach ($newCartes as $pageName => $fams)
		{
			foreach ($fams as $famTitle => $cartes)
			{
				foreach ($cartes as $carteTitle => $plats) 
				{
					$styleCarte = $plats['styleCarte'];
					unset($plats['styleCarte']);

					$insCarte->bindParam(':title', $carteTitle, PDO::PARAM_STR);			
					$insCarte->bindParam(':style', $styleCarte, PDO::PARAM_STR);
					$insCarte->execute();

					$idCarte = $dbh->lastInsertId();

					array_push($newCarteId, $idCarte);

					if ($styleCarte != "link")
					{
						$platsInCarteId = [];
						$platsInCarteId[$idCarte] = $plats;
						$this->insertPlats($platsInCarteId);
					}

					$insPage->bindParam(':name', $pageName, PDO::PARAM_STR);
					$insPage->bindParam(':family', $famTitle, PDO::PARAM_STR);
					$insPage->bindParam(':id_carte', $idCarte, PDO::PARAM_INT);
					$insPage->execute();
				}
			}
		}
		return($newCarteId);
    }

    public function deleteCartes($deleteCartesList)
    {
    	$dbh = $this->dbh;

    	$delCarteInPage = $dbh->prepare("DELETE FROM pages WHERE id_carte = :id AND name = :name");
		$delCarteInRel_cartes_plats = $dbh->prepare("DELETE FROM rel_cartes_plats WHERE id_carte = :id");
		$delCarteInCartes = $dbh->prepare("DELETE FROM cartes WHERE id = :id");

		$sth = $dbh->prepare('SELECT id_plat from rel_cartes_plats WHERE id_carte = :id_carte');
    	$delPlat = $dbh->prepare("DELETE FROM plats WHERE id = :id");

		foreach ($deleteCartesList as $idCarte => $page)
		{
			// delete link between page and carte
			$delCarteInPage->bindParam(':id', $idCarte, PDO::PARAM_INT);   
			$delCarteInPage->bindParam(':name', $page, PDO::PARAM_STR);   
			$delCarteInPage->execute();
			// check if the carte exist on another page
			$carteExistOnAnotherPage = $dbh->prepare('SELECT id from pages WHERE id_carte = :id_carte');
			$carteExistOnAnotherPage->bindParam(':id_carte', $idCarte, PDO::PARAM_INT);   
			$carteExistOnAnotherPage->execute();
			$carteExistOnAnotherPage = $carteExistOnAnotherPage->fetchAll(PDO::FETCH_COLUMN);


			// if carte doesn t exist on another page then delete carte and plats
			if (empty($carteExistOnAnotherPage))
			{
				// select plats to delete them with id cartes
				$sth->bindParam(':id_carte', $idCarte, PDO::PARAM_INT);
				$sth->execute();
				$idPlats = $sth->fetchAll(PDO::FETCH_COLUMN);

				foreach ($idPlats as $key => $idPlat)
				{
					$delPlat->bindParam(':id', $idPlat, PDO::PARAM_INT);   
					$delPlat->execute();
				}

				// delete link between plats and carte
				$delCarteInRel_cartes_plats->bindParam(':id', $idCarte, PDO::PARAM_INT);
				$delCarteInRel_cartes_plats->execute();
				
				// delete carte infos
				$delCarteInCartes->bindParam(':id', $idCarte, PDO::PARAM_INT);
				$delCarteInCartes->execute();
			}
		}
    }

    public function deletePlats($deletePlatsList)
    {
    	$dbh = $this->dbh;

		$delPlat = $dbh->prepare("DELETE FROM plats WHERE id =  :id");
		$delRel_cartes_plats = $dbh->prepare("DELETE FROM rel_cartes_plats WHERE id_plat =  :id");

		foreach ($deletePlatsList as $idPlat => $empty)
		{
			$delPlat->bindParam(':id', $idPlat, PDO::PARAM_INT);   
			$delPlat->execute();
			$delRel_cartes_plats->bindParam(':id', $idPlat, PDO::PARAM_INT); 
			$delRel_cartes_plats->execute();  
		}
    }

    public function getImgSrc($cartesId)
    {
		$dbh = $this->dbh;

		$sth = $dbh->prepare('SELECT imgSrc from cartes WHERE id = :id');
		$oldImgSrc = [];
		foreach ($cartesId as $key => $id)
		{
			$sth->bindParam(':id', $id, PDO::PARAM_INT);
			$sth->execute();
			$src = $sth->fetch(PDO::FETCH_COLUMN);
			array_push($oldImgSrc, $src);
		}
		return $oldImgSrc;
	}

    public function updateCartes($cartesId, $srcList, $style = "folder")
    {
		$dbh = $this->dbh;

		if ($style == "link")
		{
			$upt = $dbh->prepare('UPDATE cartes SET link = :link WHERE id = :id');
		}
		else
		{
			$upt = $dbh->prepare('UPDATE cartes SET imgSrc = :imgSrc WHERE id = :id');			
		}

		foreach ($cartesId as $key => $id)
		{
			if (isset($srcList[$key]) && !empty($srcList[$key]))
			{

				$upt->bindParam(':id', $id, PDO::PARAM_INT);


				if ($style == "link")
				{
					$upt->bindParam(':link', $srcList[$key], PDO::PARAM_STR);
				}
				else
				{
					$upt->bindParam(':imgSrc', $srcList[$key], PDO::PARAM_STR);
				}
				$upt->execute();
			}
		}
    }

    public function detectTypeImgFile($file)
    {
    	// detect type img file
    	$types = [".png", ".jpg"];
    	$index;
    	$imgSrcWithoutExt;
    	$ext;
    	$test = 0;
    	foreach ($types as $key => $type)
    	{
    		$extPos = stripos($file, $type);
    		if ($extPos !== false)
    		{   
    			return $extPos;
    		}
    	}
    	return false; 	
    }

    public function is_alpha_png($file)
    {
      	return (ord(@file_get_contents($fn, NULL, NULL, 25, 1)) == 6);
    }

    public function createSmallImg($imgDir, $imgSrc, $newWidth)
    {
    	// detect type img file
    	$extPos = $this->detectTypeImgFile($imgSrc);
		if ($extPos != false)
		{
			// one file for name without ext and one file for ext
			$ext = substr($imgSrc, $extPos, strlen($imgSrc));
			$imgSrcWithoutExt = substr($imgSrc, 0, $extPos);
			// get img file proportions
			$file = $imgDir . $imgSrc;
		    list($width, $height) = getimagesize($file);
		    if ($width > $newWidth)
		    {
			    $r = $width / $height;
			    $newHeight = ceil($newWidth / $r);
			    // create file
			    if ($ext == ".jpg")
			    {
			   		$src = imagecreatefromjpeg($file);
			    }
			    else
			    {
			    	$src = imagecreatefrompng($file);
			    }
			    $dst = imagecreatetruecolor($newWidth, $newHeight);
			    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
			    // save img
			    $imgSrcSmall = $imgSrcWithoutExt . "_small" . $ext;
			    if ($ext == ".jpg")
			    {
					imagejpeg($dst, $imgDir . $imgSrcSmall);
			    }
			    else
			    {
			    	imagepng($dst, $imgDir . $imgSrcSmall);
			    }
				return $imgSrcSmall;
		    }
		    else
		    {
		    	return false;
		    }
		}
    }

    //public function uploadImg($oldImgDir, $oldImgSrc = false)
    public function uploadImg($serie)
    {
		$uploads_dir = './assets/img/test/';
		$nameList = [];
		$index = 0;

		foreach ($_FILES as $key => $file)
		{
		    if ($file["error"] == UPLOAD_ERR_OK && ($file["type"] == "image/jpeg" || $file["type"] == "image/png") && stripos($key, $serie) !== false)
		    {
		    	/*
		    	if (isset($oldImgSrc[$index]) && !empty($oldImgSrc[$index]))
		    	{
			    	// -- Delete OldImg Small Version and Move OldImg Original Version to OldImgDir --
			    	// check if oldImg is the small version
			    	$oldImg = $oldImgSrc[$index];
			    	$smallPos = stripos($oldImg, "_small");
			    	$oldImgSrcSmall;
			    	// if oldImg is the small version transform oldImg in original version
			    	if ($smallPos !== false)
			    	{
			    		$oldImgSrcSmall = $oldImg;
			    		$ext = substr($oldImg, $smallPos + 6, strlen($oldImg));
			    		$oldImg = substr($oldImg, 0, $smallPos);
			    		$oldImg .= $ext;
			    	}
			    	else
			    	{
				    	$extPos = $this->detectTypeImgFile($oldImg);
						if ($extPos != false)
						{
				    		$ext = substr($oldImg, $extPos, strlen($oldImg));
				    		$oldImgSrcSmall = substr($oldImg, 0, $extPos);
							$oldImgSrcSmall = $oldImgSrcSmall . "_small" . $ext;
						}
			    	}
			    	// delete old smallImg version
			    	if (file_exists ($uploads_dir.$oldImgSrcSmall))
			    	{
						unlink($uploads_dir.$oldImgSrcSmall);
			    	}
			    	// move old original version to oldSaveDir
			    	if (file_exists ($uploads_dir.$oldImg))
			    	{
			        	rename($uploads_dir . $oldImg, $uploads_dir . $oldImgDir . $oldImg);
			    	}
			    }
			    */

			    // -- Copy New File Into Img Folder --
		       	$tmp_name = $file["tmp_name"];
		        $name = basename($file["name"]);
		        move_uploaded_file($tmp_name, "$uploads_dir/$name");
		        // create small img for new img
		        $imgNewSmall = $this->createSmallImg($uploads_dir, $name, 250);
		        // prepare array with all new img src for db
		        // if a imgSmall version exist push it in array else push big version
		        if ($imgNewSmall != false)
		        {
		        	array_push($nameList, $imgNewSmall);
		        }
		        else
		        {
		       		array_push($nameList, $name);
		        }
		        unset($_FILES[$key]);
		    }
		    $index += 1;
		}
		return $nameList;
    }

    public function updateFamilyCarteTitle($FamilyCarteTitle)
    {
 		$dbh = $this->dbh;
		$upt = $dbh->prepare('UPDATE pages SET family = :family WHERE id = :id');
		foreach ($FamilyCarteTitle as $id => $fam)
		{
			$upt->bindParam(':id', $id, PDO::PARAM_INT);
			$upt->bindParam(':family', $fam, PDO::PARAM_STR);
			$upt->execute();
		}   	
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

	public function updateCartesTitle($cartesTitle)
	{
		$dbh = $this->dbh;
		$upt = $dbh->prepare('UPDATE cartes SET title = :title WHERE id = :id');
		foreach ($cartesTitle as $id => $title)
		{
			if (isset($title))
			{
				$upt->bindParam(':id', $id, PDO::PARAM_INT);
				$upt->bindParam(':title', $title, PDO::PARAM_STR);
				$upt->execute();
			}
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
		$sth = $dbh->prepare('SELECT id, id_carte, family, name from pages');
		$sth->execute();
		$cartes = $sth->fetchAll(PDO::FETCH_ASSOC);

		// -- Reorganize Result --
		// current page
		$cartesSorted = [];
		$idsFam = [];

		// other pages
		$cartesSortedForOtherPages = [];
		$idsFamForOtherPages = [];

		foreach ($cartes as $key => $carte)
		{
			// current page
			if ($carte["name"] == $page)
			{
				$idsFam[$carte["family"]]["idsFam"] = !isset($idsFam[$carte["family"]]["idsFam"]) ? [] : $idsFam[$carte["family"]]["idsFam"];
				array_push($idsFam[$carte["family"]]["idsFam"], $carte["id"]);

				$cartesSorted[$carte["family"]][$carte["id_carte"]] = [];		
			}
			// other pages
			else
			{
				$idsFamForOtherPages[$carte["family"]]["idsFam"] = !isset($idsFamForOtherPages[$carte["family"]]["idsFam"]) ? [] : $idsFamForOtherPages[$carte["family"]]["idsFam"];
				array_push($idsFamForOtherPages[$carte["family"]]["idsFam"], $carte["id"]);

				$cartesSortedForOtherPages[$carte["family"]][$carte["id_carte"]] = [];
			}
		}

		// -- Cartes Description --
		$sth = $dbh->prepare('SELECT title, imgSrc, style, link from cartes WHERE id = :id');
		// current page
		foreach ($cartesSorted as $keyFamily => $family)
		{
			foreach ($family as $keyCarte => $carte)
			{
				$sth->bindParam(':id', $keyCarte, PDO::PARAM_INT);
				$sth->execute();
				$cartesSorted[$keyFamily][$keyCarte]["description"] = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
			}
		}

		// other pages
		foreach ($cartesSortedForOtherPages as $keyFamily => $family)
		{
			foreach ($family as $keyCarte => $carte)
			{
				$sth->bindParam(':id', $keyCarte, PDO::PARAM_INT);
				$sth->execute();
				$cartesSortedForOtherPages[$keyFamily][$keyCarte]["description"] = $sth->fetchAll(PDO::FETCH_ASSOC)[0];
			}
		}

		// -- Plats --
		$sth = $dbh->prepare('SELECT plats.* from rel_cartes_plats as rel, plats WHERE rel.id_carte = :id && rel.id_plat = plats.id');
		// current page
		foreach ($cartesSorted as $keyFamily => $family)
		{
			foreach ($family as $keyCarte => $carte)
			{
				$sth->bindParam(':id', $keyCarte, PDO::PARAM_INT);
				$sth->execute();
				$cartesSorted[$keyFamily][$keyCarte]["plats"] = $sth->fetchAll(PDO::FETCH_ASSOC);
			}
		}

		// other pages
		foreach ($cartesSortedForOtherPages as $keyFamily => $family)
		{
			foreach ($family as $keyCarte => $carte)
			{
				$sth->bindParam(':id', $keyCarte, PDO::PARAM_INT);
				$sth->execute();
				$cartesSortedForOtherPages[$keyFamily][$keyCarte]["plats"] = $sth->fetchAll(PDO::FETCH_ASSOC);
			}
		}

		// -- Reorganize Result --
		// current page
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

		// other pages
		$finalCarteForOtherPages = [];
		foreach ($cartesSortedForOtherPages as $keyFam => $family)
		{
			$finalCarteForOtherPages[$keyFam] = [];
			foreach ($family as $keyCarte => $carte)
			{
				$finalCarteForOtherPages[$keyFam][$keyCarte]["description"] = $carte["description"];
				foreach ($carte["plats"] as $keyPlats => $plat)
				{
					$id = $plat["id"];
					unset($plat["id"]);
					$finalCarteForOtherPages[$keyFam][$keyCarte]["plats"][$id] = $plat;
				}
			}
		}

		$finalCarte = array_merge_recursive($finalCarte, $idsFam);
		$finalCarteForOtherPages = array_merge_recursive($finalCarteForOtherPages, $idsFamForOtherPages);

		return [$finalCarte, $finalCarteForOtherPages];
	}
}
