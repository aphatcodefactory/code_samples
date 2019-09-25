<?php
//ini_set('display_errors', '1'); 
//error_reporting(-1);

session_start();

require_once 'dbDefine.php';
$nowTime = mktime(date('H'), date('i'), date('s'), date('m'), date('d'), date('Y'));
$message = NULL;
$button = NULL;

$db = new mysqli(DBHOST, DBUSER, DBPW, DBNAME);

$sql29 = 'SELECT userName FROM user';
$result10 = $db->prepare($sql29);
$result10->execute();
$result10->bind_result($uName);

while ($result10->fetch())
{
	$_SESSION['uName'][] = $uName;
}

if (!isset($_GET['actIdent']) || empty($_GET['actIdent']) ||
	$nowTime > intval($_GET['time'])+3600*2 )
	
{	
	$message = '<div class="bgRed" style="width: 733px; font-size: 24px;">Ihr Account konnte nicht<br>
				aktiviert/deaktiviert/gel&ouml;scht<br>
				werden.</div>
			<div class="seperator20"></div>
			<div align="center" style="margin: auto; border: 5px dotted #fd3333; width: 733px;">
			<div class="seperator20"></div>
			<p>
			<b>Der Link ist ung&uuml;ltig.</b><br>
			Bitte klicken Sie auf den entsprechenden Link in der Ihnen zugesendeten Email.
			</p>
			<div class="seperator20"></div>
			</div>
			<div class="seperator20"></div>
			<div class="seperator20"></div>
			<div align="center">
			<p><b>Oder fordern Sie hier einen neuen an:</b></p>
			<div class="seperator20"></div>
			<p><label for="newActivateLinkTo"><b>Benutzername </b>(= Emailadresse)<b>:</b></label><br><br>
			<input type="text" name="newActivateLinkTo" size="37" maxlength="45" placeholder="Adresse mit der Sie sich registriert haben" />
			<br>
			(max. 45 Zeichen)
			</p>
			<div class="seperator20"></div>
			<p><input class="button" type="submit" name="newActivateLink" value="&raquo;&nbsp;neuen Aktivierungslink anfordern" /></p>
			</div>
			<div class="seperator20"></div>
			';
	$_SESSION['startIdent'] = $_GET['actIdent'];
	
	if (isset($_POST['newActivateLink']))
	{		
		if (!in_array($_POST['newActivateLinkTo'], $_SESSION['uName']))
		{
			$message = '<div class="bgRed" style="font-size: 24px;">User nicht existent.</div><div class="seperator20"></div>';
		}
		else
		{
			$activationcode = md5($nowTime);
			$deleteAccountCode = md5('2000'.$nowTime).'deactdelete';
			
			$emailbody = '<body><h3>Sehr geehrter User,</h3>
						<p>
						Sie haben einen neuen Aktivierungslink angefordert, der wie folgt lautet:<br>
						<a href="http://tiere2015.aph-web.net/pages/act-deactacc.php?actIdent='.$activationcode.'&time='.$nowTime.'&userId='.$_GET['userId'].'
						">http://tiere2015.aph-web.net/pages/act-deactacc.php?actIdent='.$activationcode.'&time='.$nowTime.'&userId='.$_GET['userId'].'</a>
						</p>
						<hr>
						<p>
						Falls Sie sich "irrt&uuml;mlich" regestriert haben, k&ouml;nnen Sie mit folgendem Link Ihren Account wieder l&ouml;schen:<br>
						<a href="http://tiere2015.aph-web.net/pages/act-deactacc.php?actIdent='.$deleteAccountCode.'&time='.$nowTime.'&userId='.$_GET['userId'].
						'">http://tiere2015.aph-web.net/pages/act-deactacc.php?actIdent='.$deleteAccountCode.'&time='.$nowTime.'&userId='.$_GET['userId'].'</a>
						</p>
						<hr>
						<p>Beide Links sind bis: <b>'.date('D, d.m.Y, ').date('H', $nowTime+3600*2).date(':i:s').'<b/> g&uuml;ltig.</p>
						<hr>
						<p>Falls Sie den Link durch Anklicken nicht &ouml;ffnen k&ouml;nnen, kopieren Sie den entsprechenden und f&uuml;gen Sie ihn
						in die Browser-Adresszeile ein.</p>
						<hr>
						<p>Wenn Sie als Gewinner hervorgehen, bekommen Sie einen Gutschein f&uuml;r <b>&quot;Eulenspiegel - Das Bierlokal&quot;</b></p>
						<hr>
						<p><b><i>Bitte antworten Sie NICHT auf diese Email.</i></b><br>
						<br>
						<br>
						<br>
						Viel Spa&szlig; beim Voten w&uuml;nscht<br>
						Andreas Harasztosi
						</p></body>';
			
			$regUserName = $_POST['newActivateLinkTo'];
			$_SESSION['startIdent'] = $_GET['actIdent'];
			
			include_once 'email.php';
			
			$message = $messageEmail.
			'<div class="seperator20"></div>
						<div align="center"
						style="margin: auto; border: 5px dotted #339900; width: 823px;">
						<div class="seperator20"></div>
						<h3><b>Bitte &uuml;berpr&uuml;fen Sie Ihr Emailkonto (auch Spam Ordner).</b></h3>
						Es wurde ein neuer Aktivierungslink an Ihre angegebene Emailadresse:<br><b>'.$_POST['newActivateLinkTo'].'</b><br>... gesendet.<br>
						Dieser Aktivierungslink ist <b>2 Stunden ab Erhalt der <u>Meldung "Email wurde erfolgreich versendet"</u> g&uuml;ltig.</b>						
						<div class="seperator20"></div></div><div class="seperator20"></div';
		}	
	}
	
	$link = '';
}
elseif (strpos($_GET['actIdent'], 'deactdelete') != 0 &&
		$nowTime <= intval($_GET['time'])+3600*2)
{	
	$message = '<div class="bgGreen" style="font-size: 24px; width: 693px;">Ihr Account wurde erfolgreich DE-aktiviert/gel&ouml;scht.</div>
				<div class="seperator20"></div>
					<div class="seperator20"></div>
					<div align="center"
						style="margin: auto; border: 5px dotted #339900; width: 693px;">
						<div class="seperator20"></div>
						<h3><b>Schade, dass Sie uns verlassen.</b></h3>
						<p><b>Wir w&uuml;nschen Ihnen noch einen sch&ouml;nen Tag.</b><br>
						Vielleicht &uuml;berlegen Sie sich es noch und m&ouml;chten als Gast am Voting teilnehmen:</p>
						<div class="seperator20"></div>
						<p><input class="button" type="submit" name="toGuestPage" value="&raquo;&nbsp;zur Gastanmeldung" /></p>
						<div class="seperator20"></div></div><div class="seperator20"></div>';
	
	$_SESSION['startIdent'] = substr($_GET['actIdent'], 0, 31);
	
	$sql11 = 'UPDATE user SET userStatus = 0, userLastUpdate = NOW()
				WHERE userId = ?
				AND userCapture = ?';
	$update3 = $db->prepare($sql11);
	$update3->bind_param('is', $_GET['userId'], $_SESSION['startIdent']);
	$update3->execute();
	
	$_SESSION['checked'] = 'checked="checked"';
	$link = '../start.php?startIdent='.substr($_GET['actIdent'], 0, 31);
}
else
{	
	$message = '<div class="bgGreen" style="font-size: 24px; width: 693px;">Ihr Account wurde erfolgreich aktiviert.</div>
					<div class="seperator20"></div>
					<div class="seperator20"></div>';
	
	$sql10 = 'UPDATE user SET userStatus = 2, userLastUpdate = NOW()
				WHERE userId = ?
				AND userStatus = 1
				AND userCapture = ?';
	$update2 = $db->prepare($sql10);
	$update2->bind_param('is', $_GET['userId'], $_GET['actIdent']);
	$update2->execute();
	$update2->store_result();
	
	if ($update2->affected_rows > 0)
	{	
		$firstPicName = 'PIC-'.$_GET['userId'];
		
		$sql13 = 'INSERT INTO userpics (picId, picName)
				VALUES(?, ?)';
		$insert2 = $db->prepare($sql13);
		$insert2->bind_param('is', $_GET['userId'], $firstPicName);
		$insert2->execute();
		$insert2->store_result();
		
		$sql18 = 'INSERT INTO votes (voteUserId)
					VALUES (?)';
		$insert3 = $db->prepare($sql18);
		$insert3->bind_param('i', $_GET['userId']);
		$insert3->execute();
	}
	else
	{
		$message .= '<div class="bgRed" style="font-size: 24px; width: 693px;">Fehler: '.$insert2->errno.' - '.$insert2->error.'.</div>
						<div class="seperator20"></div>';
	}
	
	$_SESSION['startIdent'] = $_GET['actIdent'];
	$_SESSION['userId'] = $_GET['userId'];
	$link = 'login.php?startIdent='.$_GET['actIdent'];
	$button = '<div class="seperator20"></div><div style="text-align: center;">
	<input class="button" type="submit" name="loginForm" value="&raquo;&nbsp;zum Login" /></div>';
}
$db->close();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">

  <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">

  <link rel="icon" href="../images/favicon.ico" type="image/x-icon">

  <link rel="stylesheet" type="text/css" href="../css/main.css">
  <title>TierFoto-Voting 2015 - Registrierung</title>


</head>

<body>

<div id="container">
<div><?php include_once 'countdown.php'; ?></div>
<div class="seperator20"></div>

<div id="maincontent">
<h1 align="center">Account-Aktivierung / Account-DeAktivierung</h1>

<form action="<?php echo $link; ?>" method="post">
<div class="fieldset">

<fieldset><legend>Aktivierung/Deaktivierung</legend>
<div class="seperator20"></div>
<div class="seperator20"></div>

<!-- activation details -->

<?php
echo $message;
echo $button;
?>

<div class="seperator20"></div>
</fieldset>
<div class="seperator20"></div>
<p align="center"><a href="../index.php">&raquo;&nbsp;zur&uuml;ck zur Hauptseite</a></p>

</div>
</form>

</div>

</div>

</body>
</html>