<?php//ini_set('display_errors', '1');//error_reporting(-1);
session_start();
require_once 'dbDefine.php';

if (!isset($_SESSION['startIdent']) || empty($_SESSION['startIdent']) ||	$_GET['startIdent'] != $_SESSION['startIdent']) {
		header('Location: ../start.php?startIdent='.$_SESSION['startIdent']);
} else {
	$db = new mysqli(DBHOST, DBUSER, DBPW, DBNAME);
	$uploaddir = NULL;
	$newPicName = NULL;
	$newThumbnail = '[Noch keine Vorschau vorhanden]';
	$baseNameNewPic = '[Bildname]';
	$message = NULL;
	$userId = $_SESSION['loginUserDetails'][$_SESSION['loginUserName']]['userId'];

	$sql3 = 'SELECT userId FROM user WHERE userId = ? AND userStatus = 2';
	$result2 = $db->prepare($sql3);
	$result2->bind_param('i', $userId);
	$result2->execute();
	$result2->store_result();
	$lastUserId = $result2->num_rows;
	$_allowedPics = array('gif', 'jpg', 'jpeg', 'png', 'GIF', 'JPG', 'JPEG', 'PNG');

if (microtime(true) > mktime(0, 10, 0, 4, 12, 2015)) {
	$message = '<div class="seperator20"></div>
					<div class="bgRed" style="font-size: 24px;">
						Foto nicht mehr austauschbar.</div>
					<div class="seperator20"></div>';

	$uploadbutton = ' hide';} else {$uploadbutton = NULL;

if (isset($_POST["upload"])) {
	$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/images/userPhotos/';
		$uploadfile = $uploaddir . $_FILES["myPic"]["name"];
		$_pathParts = pathinfo($uploadfile);

	if (!in_array($_pathParts['extension'], $_allowedPics)) {
		$message = '<div class="seperator20"></div>
					<div class="bgRed" style="font-size: 24px;">
						Kein g&uuml;ltiges Datei-Format!<br>
					Es sind nur folgende Datei-Endungen g&uuml;ltig:<br>
											jpg, jpeg, png &amp; gif</div>
																<div class="seperator20"></div>';	}
	else {
				if (move_uploaded_file($_FILES["myPic"]["tmp_name"], $uploadfile)) {
					$message = '<div class="seperator20"></div>
					<div class="bgGreen" style="font-size: 24px;">
					Bild wurde erfolgreich hochgeladen!</div>
										<div class="seperator20"></div>';

					$newPicName = 'PIC-'.$userId.'.'.$_pathParts['extension'];
					rename($_pathParts['dirname'].'/'.$_pathParts['basename'], $_pathParts['dirname'].'/'.$newPicName);

		} else {
						$message = '<div class="seperator20"></div>
					<div class="bgRed" style="font-size: 24px;">
					Hochladen fehlgeschlagen!</div>
											<div class="seperator20"></div>';

			if (filesize($newPicName) > 2097152) {
				$message .= '<div class="seperator20"></div>
									<div class="bgRed" style="font-size: 24px;">
														Datei ist zu gro&szlig; (max. 2 MB)!</div>
																			<div class="seperator20"></div>';
			}
		}

		require_once 'photocheck.php';

		$sql14 = 'UPDATE userpics SET picName=?, picDispName=?, picDispWidth=?,
													picDispHeight=?, lastPicUpdate = NOW() WHERE picId = ?';
		$update3 = $db->prepare($sql14);
		$update3->bind_param('ssiii', $newPicName, $_POST['picDispName'],
								$photoDispWidth, $photoDispHeight, $userId);
		$update3->execute();

		$sql4 = 'SELECT picName, picDispName, picDispWidth, picDispHeight FROM userpics WHERE picId = ?';
		$result3 = $db->prepare($sql4);
		$result3->bind_param('i', $userId);
		$result3->execute();
		$result3->bind_result($picName, $picDispName, $picDispWidth, $picDispHeight);
		$result3->fetch();

		$newThumbnail = '<div class="thumbnail">
					<img src="../images/userPhotos/'.$newPicName.'" width="'.$picDispWidth*0.2.'px" height="'.$picDispHeight*0.2.'px" />
			<p>'.$_POST['picDispName'].'</p>
			</div>';
		$baseNameNewPic = basename($uploaddir.$newPicName);

		$_SESSION['userId'] = $userId;
		$_SESSION['newPicBaseNameImgTag'] = $baseNameNewPic;
		$_SESSION['picDispName'] = $_POST['picDispName'];
		$_SESSION['newPicNameImgTag'] = 'PIC-'.$userId;
		$_SESSION['photoDispWidth'] = $photoDispWidth;
		$_SESSION['photoDispHeight'] = $photoDispHeight;
	}
}

if (isset($_POST['storePic'])) {
	$message = '<div class="seperator20"></div>
					<div class="bgGreen" style="font-size: 24px;">
				Bild wurde erfolgreich gespeichert!</div>
				<div class="seperator20"></div>';

	$_SESSION['html'] = '<h3 align="center" style="text-decoration: none;">'.$_SESSION['picDispName'].'</h3>
						<div class="seperator20"></div>
							<img src="../../images/userPhotos/'.$_SESSION['newPicBaseNameImgTag'].'"
													width="'.$_SESSION['photoDispWidth'].'px" height="'.$_SESSION['photoDispHeight'].'px">
						<div class="layer" title="zur&uuml;ck: HIER KLICKEN"></div>';

	file_put_contents('userPages/'.$_SESSION['newPicNameImgTag'].'.htm', $_SESSION['html'], LOCK_EX);
	$_SESSION['startIdent'] = $_GET['startIdent'];
}

if (isset($_POST['refusePic'])) {
	$_SESSION['startIdent'] = $_GET['startIdent'];
	header('Location: uploadpic.php?startIdent='.$_GET['startIdent']);
}

$db->close();} // end "else" for "uploadlock"
if (isset($_POST['votingPage'])) {
	$_SESSION['startIdent'] = $_GET['startIdent'];
	header('Location: systemrun.php?startIdent='.$_GET['startIdent']);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
			<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
			<link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
			<link rel="icon" href="../images/favicon.ico" type="image/x-icon">
			<link rel="stylesheet" type="text/css" href="../css/main.css">

			<title>TierFoto-Voting 2015 - Bild hochladen</title>
</head>
<body>
<div id="container">
<div><?php include_once 'countdown.php'; ?></div>
		<div class="seperator20"></div>
<div id="maincontent">
<?php echo $message; ?>
			<h1 align="center">Bildupload:</h1>

<form action="uploadpic.php?startIdent=<?php echo $_GET['startIdent']; ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="MAX_FILE_SIZE" value="2097152">
	<div class="fieldset">
<fieldset><legend>Schritt 1 - hochladen</legend>
<div class="seperator20"></div>
<div class="seperator20"></div>
				<table border="0" cellpadding="0" cellspacing="0" width="685px" height="200px" style="margin: auto;">
<tr>
		<td width="348px" align="left">
			<label for="myPic">Bild hochladen:</label></td><td width="348px" align="left"><input class="button" type="file" name="myPic"></td>
	</tr>
<tr>
<td width="348px" align="left"><label for="picDispName">Anzeigename des Fotos:</label></td>
<td width="348px" align="right"><input type="text" name="picDispName" size="27" maxlength="25" value="[kein Name angegeben]" />&nbsp;(max. 25 Zeichen)</td>
</tr>
<tr>
		<td colspan="2" align="center"><input class="button<?php echo $uploadbutton; ?>" type="submit" name="upload" value="Bild hochladen"></td>
</tr>
	</table>

</fieldset>

<div class="seperator20"></div>
<div class="seperator20"></div>

<fieldset><legend>Schritt 2 - Vorschau</legend>
		<table border="0" cellpadding="0" cellspacing="0" width="685px" height="200px" style="margin: auto;">
<tr><td width="348px" align="center"><?php echo $newThumbnail; ?></td><td width="348px" align="left">
	<?php
echo '<p><b>' . $baseNameNewPic . ':</b>&nbsp;' . number_format(
				round(filesize($uploaddir.$newPicName)/1024/1024, 2), 2, ',', '.') . '&nbsp;MByte(s)</p>';
	?>
	</td></tr>
<tr>
		<td colspan="2" align="center">
			<div class="seperator20"></div>
<input class="button<?php echo $uploadbutton; ?>" type="submit" name="storePic" value="&raquo;&nbsp;Foto verwenden" />&nbsp;
<input class="button<?php echo $uploadbutton; ?>" type="submit" name="refusePic" value="&raquo;&nbsp;Foto verwerfen" />
			<div class="seperator20"></div>
<input class="button" type="submit" name="votingPage" value="&raquo;&nbsp;zur Votingseite" />
<div class="seperator20"></div>
</td>
</tr>
	</table>
</fieldset>
</div>
</form>
	</div>
</div>
</body>
</html>
<?php } ?>
