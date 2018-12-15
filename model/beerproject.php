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
    	$idList = [];

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

			array_push($idList, $dbh->lastInsertId());
    	}
    	return $idList;
    }

    public function updateImg($imgSrcList, $imgIdList)
    {
    	$dbh = $this->dbh;

		$upt = $dbh->prepare('UPDATE beerproject SET imgSrc = :imgSrc WHERE id = :id');
		foreach ($imgIdList as $key => $id)
		{
			$upt->bindParam(':id', $id[$key], PDO::PARAM_INT);
			$upt->bindParam(':imgSrc', $imgSrcList[$key], PDO::PARAM_STR);
			$upt->execute();
		}
	}

    public function uploadImg($serie, $id)
    {
		$uploads_dir = './assets/img/test2/';
		$nameList = [];
		$idsList = [];
		$index = 0;

		foreach ($_FILES as $key => $file)
		{
		    if ($file["error"] == UPLOAD_ERR_OK && ($file["type"] == "image/jpeg" || $file["type"] == "image/png") && stripos($key, $serie) !== false)
		    {
		    	$type = $file["type"] == "image/jpeg" ? ".jpg" : ".png";
			    // -- Copy New File Into Img Folder --
		       	$tmp_name = $file["tmp_name"];
		        $fileName = basename($file["name"]);
		        $imgSrcTemp = $uploads_dir . $fileName;
		        $fileName = "beerproject_" . $id[$index] . $type;
		        $imgSrc = $uploads_dir . $fileName;
		        move_uploaded_file($tmp_name, $imgSrcTemp);
				rename($imgSrcTemp, $imgSrc);
				array_push($idsList, $id);
				$index += 1;

		        $img;
		        $newWidth = 150;

			    list($width, $height) = getimagesize($imgSrc);
			    if ($width > $newWidth)
			    {
				    $ratio = $width / $height;
				    $newHeight = ceil($newWidth / $ratio);
				    
				    // create file
				    if ($file["type"] == "image/jpeg")
				    {
				   		$img = imagecreatefromjpeg($imgSrc);
				    }
				    elseif ($file["type"] == "image/png")
				    {
				    	$img = imagecreatefrompng($imgSrc);
				    }
				    $dst = imagecreatetruecolor($newWidth, $newHeight);
				    imagecopyresampled($dst, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

				    //save file
				    if ($file["type"] == "image/jpeg")
				    {
						imagejpeg($dst, $imgSrc);
				    }
				    elseif ($file["type"] == "image/png")
				    {
				    	imagepng($dst, $imgSrc);
				    }
			    }
		        // prepare array with all new img src for db
		       	array_push($nameList, $fileName);
		        unset($_FILES[$key]);
		    }
		}
		return [$nameList, $idsList];
    }
}
