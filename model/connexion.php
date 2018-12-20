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

	public function getUrlRoot()
	{
		return "https://cvm.one/citizen_kane";
	}

	public function getHashPwd($pwd)
	{
		return hash('sha1', $pwd, true);
	}

	static function getCaptchaPublicKey()
	{
		return "6LcEPoMUAAAAAOCPW43mxGWFrg15qje1coKBmqB1";
	}

	static function checkCaptcha()
	{
		$secret = "6LcEPoMUAAAAAKIH0nIUju_Z8KPtwxhi-bgPckLE";
	    // Paramètre renvoyé par le recaptcha
    	$response = $_POST['g-recaptcha-response'];
    	// On récupère l'IP de l'utilisateur
    	$remoteip = $_SERVER['REMOTE_ADDR'];
    	$api_url = "https://www.google.com/recaptcha/api/siteverify?secret=" 
        . $secret
        . "&response=" . $response
        . "&remoteip=" . $remoteip ;    

    	$decode = json_decode(file_get_contents($api_url), true);

    	if ($decode['success'] == true)
    	{
    		return true;
    	}
    	else
    	{
    		return false;
    	}
	}

	public function checkConnexion($mail, $pwd)
	{
		$hashPwd = $this->getHashPwd($pwd);
		$dbh = $this->dbConnect();

		$sth = $dbh->prepare('SELECT id from auth WHERE mail = :mail AND mdp = :mdp');
		$sth->bindParam(':mail', $mail, PDO::PARAM_STR);
		$sth->bindParam(':mdp', $hashPwd, PDO::PARAM_STR);
		$sth->execute();
		$id = $sth->fetchAll(PDO::FETCH_COLUMN);

		if (empty($id) || isset($_POST["disco"]))
		{
			$_SESSION["nickname"] = "";
			$_SESSION["password"] = "";
			return false;
		}
		else
		{
			$_SESSION["nickname"] = $mail;
			$_SESSION["password"] = $pwd;
			return true;
		}
	}

    public function generateCode($codeLength = 10)
	{
	    $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charLength = strlen($char);
	    $randCode = '';
	    for ($i = 0; $i < $codeLength; $i++)
	    {
	        $randCode .= $char[rand(0, $charLength - 1)];
	    }
	    return $randCode;
	}

	public function sendMail($title, $message, $mail)
	{
		$_sujet = $title;
		$_message = $message
		$_destinataire = $mail;

		$_headers = "From: \"Citizen Kane - Wavre\"<robot@cvm.one>\n";
		$_headers .= "Content-Type: text/html; charset=\"UTF-8\"\n";
		$_headers .= "Content-Transfer-Encoding: 8bit";
		$_sendMail = mail($_destinataire, $_sujet, $_message, $_headers);
	}

	public function sendResetCode($pwdOrMail)
	{
    	$dbh = $this->dbConnect();

		// get admin mail
		$sth = $dbh->prepare('SELECT id, mail from auth');
		$sth->execute();
		$adminInfos = $sth->fetch(PDO::FETCH_ASSOC);		

		if (isset($adminInfos) && !empty($adminInfos))
		{
			$code = generateCode();
			$hashCode = $this->getHashPwd($code);

			// copy reset code in db
			$upt = $dbh->prepare('UPDATE auth SET reset_code = :reset_code WHERE id = :id');
			$upt->bindParam(':id', $adminInfos["id"], PDO::PARAM_INT);
			$upt->bindParam(':reset_code', $adminInfos["mail"], PDO::PARAM_STR);
			$upt->execute();

			// send mail
			$mail = $adminInfos["mail"];
			$title = "Modification du Compte Demandée";
			$urlRoot = getUrlRoot();
			$message = "Bonjour, voici le lien permettant de finaliser la modification demandée: " . $urlRoot . "index.php?action=" . $pwdOrMail . "&code=" . $hashCode;
			sendMail($title, $message, $mail);
		}
	}

	public function checkResetCode($resetCode)
    {
    	$dbh = $this->dbConnect();

		$sth = $dbh->prepare('SELECT id from auth WHERE reset_code = :resetCode');
		$sth->bindParam(':resetCode', $resetCode, PDO::PARAM_STR);
		$sth->execute();
		$id = $sth->fetch(PDO::FETCH_COLUMN);		

		if (isset($id) && !empty($id))
		{
			return true		
		}
		return false;
    }

	public function updatePwd($newPwd)
    {
    	$dbh = $this->dbConnect();

		$sth = $dbh->prepare('SELECT id from auth');
		$sth->execute();
		$id = $sth->fetch(PDO::FETCH_COLUMN);		

		if (isset($id) && !empty($id))
		{
			$id = $id[0];
			$hashPwd = $this->getHashPwd($newPwd);
			$reset_code = "";
			$upt = $dbh->prepare('UPDATE auth SET mdp = :mdp, reset_code = :reset_code WHERE id = :id');
			$upt->bindParam(':id', $id, PDO::PARAM_INT);
			$upt->bindParam(':mdp', $hashPwd, PDO::PARAM_STR);
			$upt->bindParam(':reset_code', $reset_code, PDO::PARAM_STR);
			$upt->execute();			
		}
    }

    public function updatePwdOrMail($newInput, $pwdOrMail)
    {
    	$dbh = $this->dbConnect();

		$sth = $dbh->prepare('SELECT id from auth');
		$sth->execute();
		$id = $sth->fetch(PDO::FETCH_COLUMN);		

		if (isset($id) && !empty($id))
		{
			$id = $id[0];
			$reset_code = "";
			if ($pwdOrMail == "pwd")
			{
				$input = $this->getHashPwd($newInput);
				$upt = $dbh->prepare('UPDATE auth SET mdp = :input, reset_code = :reset_code WHERE id = :id');
			}
			else
			{
				$input = $newInput;
				$upt = $dbh->prepare('UPDATE auth SET mail = :input, reset_code = :reset_code WHERE id = :id');
			}
			$upt->bindParam(':id', $id, PDO::PARAM_INT);
			$upt->bindParam(':input', $input, PDO::PARAM_STR);
			$upt->bindParam(':reset_code', $reset_code, PDO::PARAM_STR);
			$upt->execute();			
		}
    }
}