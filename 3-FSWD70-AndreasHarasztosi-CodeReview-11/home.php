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
    <div class="container">
      <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="./">Home</a>
        <a class="navbar-brand" href="events.php">Events</a>
        <a class="navbar-brand" href="restaurants.php">Restaurants</a>
      </nav>
      <h1 class="text-center text-danger">Travel Omatic - CR 11</h1>
      <div class="row" style="margin-bottom: 1rem;">
        <span class="col-11">You're logged in as: <b><?php echo $_SESSION['user']; ?></b>&nbsp;
          (as an&nbsp;<i><?php echo $_SESSION['userStatus'] ?>)</i></span>
        <a href="actions/a_logout.php" class="col-1 btn btn-danger">Logout</a>
      </div>
      <h3 class="text-center text-danger">Restaurants</h3>
      <table class="table table-dark">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Telephone</th>
            <th scope="col">Address</th>
            <th scope="col">Type</th>
            <th scope="col">Discription</th>
            <th scope="col" class="w250">Webaddress</th>
          </tr>
        </thead>
        <tbody>
          <?php
              $user = $trvomatic->selectRow('user', 'status');
              $result = $trvomatic->selectRow('restaurant', '*');

              while ($_SESSION['row'] = $result->fetch_assoc()) {
                if ($_SESSION['userStatus'] == 'Administrator') {
                  echo '<tr>
                    <th scope=\"row\">'.$_SESSION['row']['restaurantID'].'</th>
                    <td>'.html_entity_decode($_SESSION['row']['name']).'</td>
                    <td>'.$_SESSION['row']['tel'].'</td>
                    <td>'.html_entity_decode($_SESSION['row']['address']).'</td>
                    <td>'.html_entity_decode($_SESSION['row']['type']).'</td>
                    <td>'.html_entity_decode($_SESSION['row']['discription']).'</td>
                    <td class="w250"><a href="'.$_SESSION['row']['webaddress'].'" target="_blank">'.$_SESSION['row']['webaddress'].'</a></td>
                    <td>
                      <a href="actions/a_update_form.php?tbl=restaurant&id='.$_SESSION['row']['restaurantID'].'" class="btn btn-success">Update</a><br>
                      <a href="actions/a_delete.php?tbl=restaurant&id='.$_SESSION['row']['restaurantID'].'" class="btn btn-danger" style="margin-top: 0.5rem;">Delete</a>
                    </td>
                  </tr>';
                } else {
                  echo '<tr>
                    <th scope=\"row\">'.$_SESSION['row']['restaurantID'].'</th>
                    <td>'.html_entity_decode($_SESSION['row']['name']).'</td>
                    <td>'.$_SESSION['row']['tel'].'</td>
                    <td>'.html_entity_decode($_SESSION['row']['address']).'</td>
                    <td>'.html_entity_decode($_SESSION['row']['type']).'</td>
                    <td>'.html_entity_decode($_SESSION['row']['discription']).'</td>
                    <td class="w250"><a href="'.$_SESSION['row']['webaddress'].'" target="_blank">'.$_SESSION['row']['webaddress'].'</a></td>
                  </tr>';
                }

              }
          ?>
        </tbody>
      </table>
      <h3 class="text-center text-danger">Things To Do/Sights</h3>
      <table class="table table-dark">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Address</th>
            <th scope="col">Type</th>
            <th scope="col">Discription</th>
            <th scope="col" class="w250">Webaddress</th>
          </tr>
        </thead>
        <tbody>
          <?php
              $result = $trvomatic->selectRow('thtdo', '*');

              while ($_SESSION['row'] = $result->fetch_assoc()) {
                if ($_SESSION['userStatus'] == 'Administrator') {
                  echo '<tr>
                    <th scope=\"row\">'.$_SESSION['row']['thtdoID'].'</th>
                    <td>'.html_entity_decode($_SESSION['row']['name']).'</td>
                    <td>'.html_entity_decode($_SESSION['row']['address']).'</td>
                    <td>'.html_entity_decode($_SESSION['row']['type']).'</td>
                    <td>'.html_entity_decode($_SESSION['row']['discription']).'</td>
                    <td class="w250"><a href="'.$_SESSION['row']['webaddress'].'" target="_blank">'.$_SESSION['row']['webaddress'].'</a></td><td>
                      <a href="actions/a_update.php?tbl=thtdo&id='.$_SESSION['row']['thtdoID'].'" class="btn btn-success">Update</a><br>
                      <a href="actions/a_delete.php?tbl=thtdo&id='.$_SESSION['row']['thtdoID'].'" class="btn btn-danger" style="margin-top: 0.5rem;">Delete</a>
                    </td>
                  </tr>';
                } else {
                  echo '<tr>
                    <th scope=\"row\">'.$row['thtdoID'].'</th>
                    <td>'.html_entity_decode($_SESSION['row']['name']).'</td>
                    <td>'.html_entity_decode($_SESSION['row']['address']).'</td>
                    <td>'.html_entity_decode($_SESSION['row']['type']).'</td>
                    <td>'.html_entity_decode($_SESSION['row']['discription']).'</td>
                    <td class="w250"><a href="'.$_SESSION['row']['webaddress'].'" target="_blank">'.$_SESSION['row']['webaddress'].'</a></td>
                  </tr>';
                }
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
            <th scope="col" class="w250">Webaddress</th>
            <th scope="col">Discription</th>
            <th scope="col">Begin</th>
            <th scope="col">Ticketprice in &euro;</th>
          </tr>
        </thead>
        <tbody>
          <?php
              $result = $trvomatic->selectRow('event', '*');

              while ($_SESSION['row'] = $result->fetch_assoc()) {
                if ($_SESSION['userStatus'] == 'Administrator') {          
                  echo '<tr>
                    <th scope=\"row\">'.$_SESSION['row']['eventID'].'</th>
                    <td>'.html_entity_decode($_SESSION['row']['name']).'</td>
                    <td>'.$_SESSION['row']['location'].'</td>
                    <td>'.html_entity_decode($_SESSION['row']['address']).'</td>
                    <td><a href="'.$_SESSION['row']['webaddress'].'" target="_blank">'.$_SESSION['row']['webaddress'].'</a></td>
                    <td>'.html_entity_decode($_SESSION['row']['discription']).'</td>
                    <td>'.$_SESSION['row']['eventStart'].'</td>
                    <td>'.$_SESSION['row']['ticketprice'].'</td>
                    <td class="w250"><a href="'.$_SESSION['row']['webaddress'].'" target="_blank">'.$_SESSION['row']['webaddress'].'</a></td>
                    <td>
                      <a href="actions/a_update.php?tbl=event&id='.$_SESSION['row']['eventID'].'" class="btn btn-success">Update</a><br>
                      <a href="actions/a_delete.php?tbl=event&id='.$_SESSION['row']['eventID'].'" class="btn btn-danger" style="margin-top: 0.5rem;">Delete</a>
                    </td>
                  </tr>';

                } else {

                  echo '<tr>
                    <th scope=\"row\">'.$_SESSION['row']['eventID'].'</th>
                    <td>'.html_entity_decode($_SESSION['row']['name']).'</td>
                    <td>'.$_SESSION['row']['location'].'</td>
                    <td>'.html_entity_decode($_SESSION['row']['address']).'</td>
                    <td><a href="'.$_SESSION['row']['webaddress'].'" target="_blank">'.$_SESSION['row']['webaddress'].'</a></td>
                    <td>'.html_entity_decode($_SESSION['row']['discription']).'</td>
                    <td>'.$_SESSION['row']['eventStart'].'</td>
                    <td>'.$_SESSION['row']['ticketprice'].'</td>
                    <td class="w250"><a href="'.$_SESSION['row']['webaddress'].'" target="_blank">'.$_SESSION['row']['webaddress'].'</a></td>';
                }
              }
          ?>
        </tbody>
      </table>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script>
      $(document).ready(function() {});
    </script>
  </body>
</html>
