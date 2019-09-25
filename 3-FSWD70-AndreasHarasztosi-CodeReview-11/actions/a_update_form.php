<?php
  require_once '../classes/Database.php';
  require_once './dbconnect.php';
  ob_start();
  session_start();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
          crossorigin="anonymous">
    <style>
      .w250 {
        width: 200px !important;
      }
    </style>

    <title>Travel Omatic - CR 11</title>
  </head>
  <body>
    <div class="container flex-d justify-content-center">
      <form action="a_update.php" method="get">
        <div class="form-group">
          <?php if ($_SESSION['userStatus'] == 'Administrator') {

                  $result = $trvomatic->selectRow($_GET['tbl'], '*', 'WHERE '.$_GET['tbl'].'ID = '.$_GET['id']);
                  $row = $result->fetch_assoc();

                  switch ($_GET['tbl']) {
                    case 'restaurant':
                      echo '
                        <label>ID:&nbsp;<input type="text" class="form-control" value="'.$_GET['id'].'" readonly="readonly"></label>
                        <label for="name">Name:
                          <input class="form-control" type="text" name="name" value="'.html_entity_decode($row['name']).'">
                        </label>
                        <label for="tel">Tel. No.:
                          <input class="form-control" type="text" name="tel" value="'.html_entity_decode($row['tel']).'">
                        </label>
                        <label for="type">Type:
                          <input class="form-control" type="text" name="type" value="'.html_entity_decode($row['type']).'">
                        </label>
                        <label for="discription">Discription:
                          <input class="form-control" type="text" name="discription" value="'.html_entity_decode($row['discription']).'">
                        </label>
                        <label for="address">Address:
                          <input class="form-control" type="text" name="address" value="'.html_entity_decode($row['address']).'">
                        </label>
                        <label for="webaddress">Webaddress
                          <input class="form-control" type="text" name="webaddress" value="'.$row['webaddress'].'">
                        </label>
                        <a href="a_update.php?tbl='.$_GET['tbl'].'&id='.$_GET['id'].'" class="btn btn-success">Update</a>
                      ';
                      break;

                    case 'thtdo':
                      echo '
                        <label>ID:&nbsp;<input type="text" class="form-control" value="'.$_GET['id'].'" readonly="readonly"></label>
                        <label for="name">Name:
                          <input class="form-control" type="text" name="name" value="'.html_entity_decode($row['name']).'">
                        </label>
                        <label for="type">Type:
                          <input class="form-control" type="text" name="type" value="'.html_entity_decode($row['type']).'">
                        </label>
                        <label for="discription">Discription:
                          <input class="form-control" type="text" name="discription" value="'.html_entity_decode($row['discription']).'">
                        </label>
                        <label for="address">Address:
                          <input class="form-control" type="text" name="address" value="'.html_entity_decode($row['address']).'">
                        </label>
                        <label for="webaddress">Webaddress:
                          <input class="form-control" type="text" name="webaddress" value="'.$row['webaddress'].'">
                        </label>
                        <a href="a_update.php" class="btn btn-success">Update</a>
                      ';
                      break;

                    case 'event':
                      echo '
                        <label>ID:&nbsp;<input type="text" class="form-control" value="'.$_GET['id'].'" readonly="readonly"></label>
                        <label for="name">Name:
                          <input class="form-control" type="text" name="name" value="'.html_entity_decode($row['name']).'">
                        </label>
                        <label for="location">Location:
                          <input class="form-control" type="text" name="location" value="'.html_entity_decode($row['location']).'">
                        </label>
                        <label for="address">Address:
                          <input class="form-control" type="text" name="address" value="'.html_entity_decode($row['address']).'">
                        </label>
                        <label for="discription">Discription:
                          <input class="form-control" type="text" name="discription" value="'.html_entity_decode($row['discription']).'">
                        </label>
                        <label for="webaddress">Webaddress:
                          <input class="form-control" type="text" name="webaddress" value="'.$row['webaddress'].'">
                        </label>
                        <label for="eventStart">Begin:
                          <input class="form-control" type="text" name="eventStart" value="'.$row['eventStart'].'">
                        </label>
                        <label for="ticketprice">Ticketprice:
                          <input class="form-control" type="text" name="ticketprice" value="'.$row['ticketprice'].'">
                        </label>
                        <a href="a_update.php" class="btn btn-success">Update</a>
                      ';
                      break;
                  }
                }
          ?>

        </div>
      </form>
    </div>
  </body>
</html>
