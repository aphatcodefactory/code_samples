<?php
  require_once 'classes/Database.php';
  require_once 'actions/dbconnect.php';
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

    <title>Travel Omatic - CR 11</title>
  </head>
  <body>
    <div class="container">
      <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="./">Home</a>
        <a class="navbar-brand" href="events.php">Events</a>
        <a class="navbar-brand" href="restaurants.php">Restaurants</a>
      </nav>
      <h1 class="text-center text-danger">Travel Omatic - CR 11</h1>
      <div class="row" style="margin-bottom: 1rem;">
        <span class="col-11">You're logged in as: <b><?php echo $_SESSION['user'] . "</b>"; ?></span>
        <a href="actions/a_logout.php" class="col-1 btn btn-danger">Logout</a>
      </div>
      
      <h3 class="text-center text-danger">Things To Do/Sights</h3>
      <table class="table table-dark">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Address</th>
            <th scope="col">Type</th>
            <th scope="col">Discription</th>
            <th scope="col">Webaddress</th>
          </tr>
        </thead>
        <tbody>
          <?php
              $result = $trvomatic->selectRow('thtdo', '*');
              while ($row = $result->fetch_assoc()) {
                echo '<tr>
                  <th scope=\"row\">'.$row['thtdoID'].'</th>
                  <td>'.html_entity_decode($row['name']).'</td>
                  <td>'.html_entity_decode($row['address']).'</td>
                  <td>'.html_entity_decode($row['type']).'</td>
                  <td>'.html_entity_decode($row['discription']).'</td>
                  <td><a href="'.$row['webaddress'].'" target="_blank">'.$row['webaddress'].'</a></td>
                </tr>';
              }
          ?>
        </tbody>
      </table>
      <h3 class="text-center text-danger">Events</h3>
      <table class="table table-dark">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Location</th>
            <th scope="col">Address</th>
            <th scope="col">Webaddress</th>
            <th scope="col">Discription</th>
            <th scope="col">Begin</th>
            <th scope="col">Ticketprice in &euro;</th>
          </tr>
        </thead>
        <tbody>
          <?php
              $result = $trvomatic->selectRow('event', '*');
              while ($row = $result->fetch_assoc()) {
                echo '<tr>
                  <th scope=\"row\">'.$row['eventID'].'</th>
                  <td>'.html_entity_decode($row['name']).'</td>
                  <td>'.$row['location'].'</td>
                  <td>'.html_entity_decode($row['address']).'</td>
                  <td><a href="'.$row['webaddress'].'" target="_blank">'.$row['webaddress'].'</a></td>
                  <td>'.html_entity_decode($row['discription']).'</td>
                  <td>'.$row['eventStart'].'</td>
                  <td>'.$row['ticketprice'].'</td>
                </tr>';
              }
          ?>
        </tbody>
      </table>
    </div>
  </body>
</html>