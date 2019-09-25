<?php

//ini_set('display_errors', '1');
//error_reporting(-1);

session_start();
require_once 'dbDefine.php';
$message = NULL;

if (!isset($_SESSION['startIdent']) || empty($_SESSION['startIdent']) ||
$_GET['startIdent'] != $_SESSION['startIdent'])
{
	header('Location: ../sponsors.php');
}
else
{
	$_regUserNameDb = array();

	$db = new mysqli(DBHOST, DBUSER, DBPW, DBNAME);

	$sql8 = 'SELECT userName FROM user';
	$result2 = $db->prepare($sql8);
	$result2->execute();
	$result2->bind_result($regUserNameDb);

	while ($result2->fetch())
	{
		$_regUserNameDb[] = $regUserNameDb;
	}

	if (isset($_POST['register']))
	{
		$regUserName = $_POST['regUserName'];
		$regUserPw = hash('sha256', $_POST['regUserPw']);
		$regUserPwAgain = hash('sha256', $_POST['regUserPwAgain']);
		$userRegIp = $_SERVER['REMOTE_ADDR'];
		$userFirstLoginIP = $userRegIp.$regUserName;

		if ($regUserName==NULL || $regUserPw==hash('sha256', ''))
		{
			$message = '<div class="bgRed" style="font-size: 24px;">Bitte f&uuml;llen Sie alle Felder aus.</div><div class="seperator20"></div>';
		}
		elseif ($regUserPw != $regUserPwAgain)
		{
			$message = '<div class="bgRed" style="font-size: 24px;">Passw&ouml;rter stimmen nicht &uuml;berein.</div><div class="seperator20"></div>';
		}
		elseif (in_array($regUserName, $_regUserNameDb))
		{
			$message = '<div class="bgRed" style="font-size: 24px;">User bereits vorhanden.</div><div class="seperator20"></div>';
		}
		else
		{
			$nowTime = mktime(date('H'), date('i'), date('s'), date('m'), date('d'), date('Y'));
			$activationcode = md5($nowTime);
			$deleteAccountCode = $activationcode.'deactdelete';
			$userCapture = $activationcode;

			$sql7 = 'INSERT INTO user
					(userName, userPw, userRegDate, userRegIp, userFirstLoginIP, userCapture, userLastUpdate)
					VALUES (?, ?, NOW(), ?, ?, ?, NOW())';
			$insert1 = $db->prepare($sql7);
			$insert1->bind_param('sssss', $regUserName, $regUserPwAgain, $userRegIp, $userFirstLoginIP, $userCapture);
			$insert1->execute();

			$lastInsertId = $insert1->insert_id;

			$sql12 = 'SELECT userId FROM user WHERE userId = ?';
			$result4 = $db->prepare($sql12);
			$result4->bind_param('i', $lastInsertId);
			$result4->execute();
			$result4->bind_result($userId);
			$result4->fetch();

			$messageHead = '<div class="bgGreen" style="font-size: 24px;">Registrierung erfolgreich.</div>';

			$messageBody = '<div class="seperator20"></div>
						<div align="center"
						style="margin: auto; border: 5px dotted #339900; width: 823px;">
						<div class="seperator20"></div>
						<h3><b>Bitte &uuml;berpr&uuml;fen Sie Ihr Emailkonto (auch Spam Ordner).</b></h3>
						Es wurde ein Aktivierungslink an Ihre angegebene Emailadresse:<br><b>'.$regUserName.'</b><br>... gesendet.<br>
						Dieser Aktivierungslink ist <b>2 Stunden ab Erhalt der <u>Meldung "Email erfolgreich versendet"</u> g&uuml;ltig.</b>
						<div class="seperator20"></div></div><div class="seperator20"></div>';

			$emailbody = '<body><h3>Sehr geehrter User,</h3>
						<p>
						Ihr Aktivierungslink lautet wie folgt:<br>
						<a href="http://tiere2015.aph-web.net/pages/act-deactacc.php?actIdent='.$activationcode.'&time='.$nowTime.'&userId='.$userId.'
						">http://tiere2015.aph-web.net/pages/act-deactacc.php?actIdent='.$activationcode.'&time='.$nowTime.'&userId='.$userId.'</a>
						</p>
						<hr>
						<p>
						Falls Sie sich "irrt&uuml;mlich" regestriert haben, k&ouml;nnen Sie mit folgendem Link Ihren Account wieder l&ouml;schen:<br>
						<a href="http://tiere2015.aph-web.net/pages/act-deactacc.php?actIdent='.$deleteAccountCode.'&time='.$nowTime.'&userId='.$userId.
						'">http://tiere2015.aph-web.net/pages/act-deactacc.php?actIdent='.$deleteAccountCode.'&time='.$nowTime.'&userId='.$userId.'</a>
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
						Das Initiatorenteam
						</p></body>';

			//include_once 'email.php';

			$message = $messageHead.$messageEmail.$messageBody;

			$db->close();
		}
	}

	$_SESSION['startIdent'] = $_GET['startIdent'];

	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">

<link rel="shortcut icon" href="../images/favicon.ico"
	type="image/x-icon">

<link rel="icon" href="../images/favicon.ico" type="image/x-icon">

<link rel="stylesheet" type="text/css" href="../css/main.css">
<title>TierFoto-Voting 2015 - Registrierung</title>


</head>

<body>

	<div id="container">
		<div>
		<?php include_once 'countdown.php'; ?>
		</div>
		<div class="seperator20"></div>

		<div id="maincontent">
		<?php echo $message; ?>

			<h1 align="center">Registrierung</h1>

			<form
				action="register.php?startIdent=<?php echo $_SESSION['startIdent']; ?>"	method="post">
				<div class="fieldset">

					<fieldset>
						<legend>Schritt 2</legend>
						<div class="seperator20"></div>
						<div class="seperator20"></div>

						<!-- register details -->

						<table border="0" cellpadding="0" cellspacing="0" width="685px"
							height="200px" style="margin: auto;">
							<tr>
								<td width="348px" align="left"><label for="regUserName"><b>Benutzername
									</b>(= Emailadresse)<b>:</b> </label></td>
								<td width="348px" align="right"><input type="text"
									name="regUserName" size="27" maxlength="45"
									placeholder="max@mustermann.at" />&nbsp;(max. 45 Zeichen)</td>
							</tr>
							<tr>
								<td width="348px" align="left"><label for="regUserPw"><b>Passwort:</b>
								</label></td>
								<td width="348px" align="right"><input type="password"
									name="regUserPw" size="27" maxlength="12" />&nbsp;(max. 12
									Zeichen)</td>
							</tr>
							<tr>
								<td width="348px" align="left"><label for="regUserPwAgain"><b>Passwort
											wiederholen:</b> </label></td>
								<td width="348px" align="right"><input type="password"
									name="regUserPwAgain" size="27" maxlength="12" />&nbsp;(max. 12
									Zeichen)</td>
							</tr>
							<tr>
								<td colspan="2" align="center">
									<div class="seperator20"></div> <input class="button"
									type="submit" name="register"
									value="&raquo;&nbsp;Registrierung" />&nbsp; <input
									class="button" type="reset" name="registerReset"
									value="&raquo;&nbsp;Zur&uuml;cksetzen" />
								</td>
							</tr>
						</table>

						<div class="seperator20"></div>
					</fieldset>
					<div class="seperator20"></div>
					<p align="center">
						<a
							href="../start.php?startIdent=<?php echo $_GET['startIdent']; ?>">&raquo;&nbsp;zur&uuml;ck</a>
					</p>
					<div class="seperator20"></div>
					<p align="center">
						<a href="../index.php">&raquo;&nbsp;zur&uuml;ck zur Hauptseite</a>
					</p>
				</div>
			</form>

		</div>

	</div>

</body>
</html>
<?php
}
?>
