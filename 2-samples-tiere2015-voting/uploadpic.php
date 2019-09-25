<?php
session_start();


if (!isset($_SESSION['startIdent']) || empty($_SESSION['startIdent']) ||
		header('Location: ../start.php?startIdent='.$_SESSION['startIdent']);

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

						Foto nicht mehr austauschbar.</div>


	$uploadbutton = ' hide';

if (isset($_POST["upload"])) {

		$uploadfile = $uploaddir . $_FILES["myPic"]["name"];
		$_pathParts = pathinfo($uploadfile);

	if (!in_array($_pathParts['extension'], $_allowedPics)) {


						Kein g&uuml;ltiges Datei-Format!<br>

											jpg, jpeg, png &amp; gif</div>
																<div class="seperator20"></div>';
	else {
				if (move_uploaded_file($_FILES["myPic"]["tmp_name"], $uploadfile)) {
					$message = '<div class="seperator20"></div>


										<div class="seperator20"></div>';

					$newPicName = 'PIC-'.$userId.'.'.$_pathParts['extension'];
					rename($_pathParts['dirname'].'/'.$_pathParts['basename'], $_pathParts['dirname'].'/'.$newPicName);

		} else {
						$message = '<div class="seperator20"></div>


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

		$update3->execute();

		$sql4 = 'SELECT picName, picDispName, picDispWidth, picDispHeight FROM userpics WHERE picId = ?';
		$result3 = $db->prepare($sql4);
		$result3->bind_param('i', $userId);
		$result3->execute();
		$result3->bind_result($picName, $picDispName, $picDispWidth, $picDispHeight);
		$result3->fetch();

		$newThumbnail = '<div class="thumbnail">
					<img src="../images/userPhotos/'.$newPicName.'" width="'.$picDispWidth*0.2.'px" height="'.$picDispHeight*0.2.'px" />


		$baseNameNewPic = basename($uploaddir.$newPicName);

		$_SESSION['userId'] = $userId;
		$_SESSION['newPicBaseNameImgTag'] = $baseNameNewPic;
		$_SESSION['picDispName'] = $_POST['picDispName'];
		$_SESSION['newPicNameImgTag'] = 'PIC-'.$userId;
		$_SESSION['photoDispWidth'] = $photoDispWidth;
		$_SESSION['photoDispHeight'] = $photoDispHeight;
	}


if (isset($_POST['storePic'])) {
	$message = '<div class="seperator20"></div>
					<div class="bgGreen" style="font-size: 24px;">



	$_SESSION['html'] = '<h3 align="center" style="text-decoration: none;">'.$_SESSION['picDispName'].'</h3>

							<img src="../../images/userPhotos/'.$_SESSION['newPicBaseNameImgTag'].'"
													width="'.$_SESSION['photoDispWidth'].'px" height="'.$_SESSION['photoDispHeight'].'px">


	file_put_contents('userPages/'.$_SESSION['newPicNameImgTag'].'.htm', $_SESSION['html'], LOCK_EX);
	$_SESSION['startIdent'] = $_GET['startIdent'];
}

if (isset($_POST['refusePic'])) {
	$_SESSION['startIdent'] = $_GET['startIdent'];
	header('Location: uploadpic.php?startIdent='.$_GET['startIdent']);
}

$db->close();
if (isset($_POST['votingPage'])) {
	$_SESSION['startIdent'] = $_GET['startIdent'];
	header('Location: systemrun.php?startIdent='.$_GET['startIdent']);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">


			<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
			<link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
			<link rel="icon" href="../images/favicon.ico" type="image/x-icon">
			<link rel="stylesheet" type="text/css" href="../css/main.css">

			<title>TierFoto-Voting 2015 - Bild hochladen</title>




		<div class="seperator20"></div>


			<h1 align="center">Bildupload:</h1>


	<input type="hidden" name="MAX_FILE_SIZE" value="2097152">
	<div class="fieldset">



				<table border="0" cellpadding="0" cellspacing="0" width="685px" height="200px" style="margin: auto;">

		<td width="348px" align="left">
			<label for="myPic">Bild hochladen:</label></td>
	</tr>





		<td colspan="2" align="center">

	</table>







		<table border="0" cellpadding="0" cellspacing="0" width="685px" height="200px" style="margin: auto;">

	<?php


	?>
	</td>

		<td colspan="2" align="center">
			<div class="seperator20"></div>


			<div class="seperator20"></div>




	</table>



	</div>


</html>
<?php } ?>