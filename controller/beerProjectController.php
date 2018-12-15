<?php

require('./model/beerproject.php');

if (isset($_POST) && !empty($_POST))
{
	if (isset($_POST["inputUpdate"]) && !empty($_POST["inputUpdate"]))
	{
		$updateList = json_decode($_POST["inputUpdate"], true);
		$beerProject = new BeerProject();
		$beerProject->update($updateList, $page);
	}

	if (isset($_POST["brasserieToDelete"]) && !empty($_POST["brasserieToDelete"]))
	{
		$deleteList = json_decode($_POST["brasserieToDelete"], true);
		$beerProject = new BeerProject();
		$beerProject->delete($deleteList, $page);
	}

	if (isset($_FILES) && !empty($_FILES) && isset($_POST["brasserieImgInputId"]) && !empty($_POST["brasserieImgInputId"]))
	{
		$brasserieImgInputId = json_decode($_POST["brasserieImgInputId"], true);
		$beerProject = new BeerProject();
		$imgSrcAndId = $beerProject->uploadImg("onAlreadyExistBrasserie", $brasserieImgInputId, $page);
		$imgSrcList = $imgSrcAndId[0];
		$imgIdList = $imgSrcAndId[1];
		$beerProject->updateImg($imgSrcList, $imgIdList, $page);
	}

	if (isset($_POST["insertNewBrasserie"]) && !empty($_POST["insertNewBrasserie"]))
	{
		$newBrasserieList = json_decode($_POST["insertNewBrasserie"], true);
		$beerProject = new BeerProject();
		$idList = $beerProject->insert($newBrasserieList, $page);
		// img
		if (isset($_FILES) && !empty($_FILES))
		{
			$imgSrcAndId = $beerProject->uploadImg("onNewBrasserie", $idList, $page);
			$imgSrcList = $imgSrcAndId[0];
			$imgIdList = $imgSrcAndId[1];
			$beerProject->updateImg($imgSrcList, $imgIdList, $page);
		}
	}
}

class DateManage
{
	static function translateMonth($month)
	{
		switch ($month) 
		{
		    case 1:
		    	return "janvier";
		    case 2:
		    	return "février";
		    case 3:
		    	return "mars";
		    case 4:
		    	return "avril";
		    case 5:
		    	return "mai";
		    case 6:
		    	return "juin";
		    case 7:
		    	return "juillet";
		    case 8:
		    	return "août";
		    case 9:
		    	return "septembre";
		    case 10:
		    	return "octobre";
		    case 11:
		    	return "novembre";
		    case 12:
		    	return "décembre";
		}
	}

	static function translateDateTime($dOpen, $dClose)
	{
		$date_open = date_create($dOpen)->format('Y-m-d');
		$time_open = date_create($dOpen)->format('H:i');
		$date_close = date_create($dClose)->format('Y-m-d');
		$time_close = date_create($dClose)->format('H:i');

		$day_open = date_create($dOpen)->format('d');
		$month_open = date_create($dOpen)->format('m');
		$year_open = date_create($dOpen)->format('Y');
		$monthWords_open = self::translateMonth($month_open);

		$day_close = date_create($dClose)->format('d');
		$month_close = date_create($dClose)->format('m');
		$year_close = date_create($dClose)->format('Y');
		$monthWords_close = self::translateMonth($month_close);

		$dateNewFormat = "";
		if ($date_open == $date_close)
		{
			$dateNewFormat .= $day_open . " " . $monthWords_open . " " . $year_open . " @ " . $time_open . " - " . $time_close;
		}
		else
		{
			$dateNewFormat .= "du " . $day_open . " " . $monthWords_open . " " . $year_open . " @ " . $time_open . " au " . $day_close . " " . $monthWords_close . " " . $year_close . " @ " . $time_close;		
		}
		return $dateNewFormat;
	}

	static function translateDate($date)
	{
		$day = date_create($date)->format('d');
		$month = date_create($date)->format('m');
		$year = date_create($date)->format('Y');
		$monthWords = self::translateMonth($month);

		$dateNewFormat = $day . " " . $monthWords . " " . $year;
		return $dateNewFormat;
	}
}