<?php

class BeerProject
{
	function __construct()
	{
        $this->connect = new Connexion();
        $this->dbh = $this->connect->dbConnect();
    }

    public function getList($page)
    {
    	$dbh = $this->dbh;

    	$reqAll = $page == "beerProject" ? $dbh->prepare('SELECT * from citizen_beerproject ORDER BY date DESC') : $dbh->prepare('SELECT * from citizen_agenda ORDER BY date_close DESC');
    	$reqAll->execute();
		$beerProjectList = $reqAll->fetchAll(PDO::FETCH_ASSOC);

		return $beerProjectList;
	}

	public function update($updateList, $page)
    {
    	$dbh = $this->dbh;

		$upt = $page == "beerProject" ? $dbh->prepare('UPDATE citizen_beerproject SET title = :title, date = :date, beers = :beers, link = :link WHERE id = :id') : $dbh->prepare('UPDATE citizen_agenda SET title = :title, date_open = :date_open, date_close = :date_close, summary = :summary WHERE id = :id');
		foreach ($updateList as $id => $brasserie)
		{
			$upt->bindParam(':id', $id, PDO::PARAM_INT);

			// beerProject
			if ($page == "beerProject")
			{
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
			}
			// agenda
			else
			{
				$upt->bindParam(':title', $brasserie["title"], PDO::PARAM_STR);
				if ($brasserie["date_open"] === false || $brasserie["date_close"] === false)
				{
					$currentDate = date('Y-m-d H:i:s');
					$upt->bindParam(':date_open', $currentDate, PDO::PARAM_STR);
					$upt->bindParam(':date_close', $currentDate, PDO::PARAM_STR);
				}
				else
				{
					$upt->bindParam(':date_open', $brasserie["date_open"], PDO::PARAM_STR);
					$upt->bindParam(':date_close', $brasserie["date_close"], PDO::PARAM_STR);
				}
				$upt->bindParam(':summary', $brasserie["summary"], PDO::PARAM_STR);				
			}

			$upt->execute();
		}
	}

	public function delete($deleteList, $page)
    {
    	$dbh = $this->dbh;

    	$del = $page == "beerProject" ? $dbh->prepare("DELETE FROM citizen_beerproject WHERE id = :id") : $dbh->prepare("DELETE FROM citizen_agenda WHERE id = :id");
		foreach ($deleteList as $key => $id)
		{
			$del->bindParam(':id', $id, PDO::PARAM_INT);   
			$del->execute();
		}
	}

	public function insert($newBrasserieList, $page)
    {
    	$dbh = $this->dbh;
    	$ins = $page == "beerProject" ? $dbh->prepare("INSERT INTO citizen_beerproject (title, date, beers, link) VALUES (:title, :date, :beers, :link)") : $dbh->prepare("INSERT INTO citizen_agenda (title, date_open, date_close, summary) VALUES (:title, :date_open, :date_close, :summary)");
    	$idList = [];

    	foreach ($newBrasserieList as $key => $brasserie)
    	{
			$ins->bindParam(':title', $brasserie["title"], PDO::PARAM_STR);

			// beerProject
			if ($page == "beerProject")
			{
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
			}
			// agenda
			else
			{
				if ($brasserie["date_open"] === false || $brasserie["date_close"] === false)
				{
					$currentDate = date('Y-m-d H:i:s');
					$ins->bindParam(':date_open', $currentDate, PDO::PARAM_STR);
					$ins->bindParam(':date_close', $currentDate, PDO::PARAM_STR);
				}
				else
				{
					$ins->bindParam(':date_open', $brasserie["date_open"], PDO::PARAM_STR);
					$ins->bindParam(':date_close', $brasserie["date_close"], PDO::PARAM_STR);
				}			
				$ins->bindParam(':summary', $brasserie["summary"], PDO::PARAM_STR);
			}
			$ins->execute();

			array_push($idList, $dbh->lastInsertId());
    	}
    	return $idList;
    }

    public function updateImg($imgSrcList, $imgIdList, $page)
    {
    	$dbh = $this->dbh;

		$upt = $page == "beerProject" ? $dbh->prepare('UPDATE citizen_beerproject SET imgSrc = :imgSrc WHERE id = :id') : $dbh->prepare('UPDATE citizen_agenda SET imgSrc = :imgSrc WHERE id = :id');
		foreach ($imgIdList as $key => $id)
		{
			$upt->bindParam(':id', $id[$key], PDO::PARAM_INT);
			$upt->bindParam(':imgSrc', $imgSrcList[$key], PDO::PARAM_STR);
			$upt->execute();
		}
	}

    public function uploadImg($serie, $id, $page)
    {
		$uploads_dir = './assets/img/upload/';
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
		        $fileName = $page == "beerProject" ? "beerproject_" . $id[$index] . $type :  "agenda_" . $id[$index] . $type;
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
