<?php
  include('functions/md5.php');
  include('functions/functions.php');
  if (isset($_POST['message'])) $message_crypted = implementMD5($_POST['message']);
  if (isset($_GET['action']) && ($_GET['action'] == "newdatabase")) generateDataSQL();
  $data = getDataFromDatabase();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <title>MD5</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="style/images/icons/favicon.ico" />
  <link rel="stylesheet" type="text/css" href="style/vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="style/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="style/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
  <link rel="stylesheet" type="text/css" href="style/vendor/animate/animate.css">
  <link rel="stylesheet" type="text/css" href="style/vendor/css-hamburgers/hamburgers.min.css">
  <link rel="stylesheet" type="text/css" href="style/vendor/select2/select2.min.css">
  <link rel="stylesheet" type="text/css" href="style/css/util.css">
  <link rel="stylesheet" type="text/css" href="style/css/main.css">
</head>

<body>
  <div class="container-contact100" style="background-image: url('style/images/bg-01.jpg');">
    <div class="wrap-contact100">
      <form class="contact100-form validate-form" action="index.php" method="post">
        <span class="contact100-form-title">
          MD5 implementation project
        </span>
        <div class="wrap-input100 validate-input" data-validate="Message is required">
          <span class="label-input100">Message</span>
          <textarea class="input100" name="message" placeholder="Your message here..."></textarea>
        </div>
        <?php
        if (isset($_POST['message'])) {
          ?>
          <div class="alert alert-success" role="alert" style="width: 100%;text-align: center;">
            Clear message : <b><?php echo $_POST['message']; ?></b>
            <hr />Message crypted: <b><?php echo $message_crypted; ?></b>
          </div>
        <?php
        }
        ?>
        <div class="container-contact100-form-btn">
          <div class="wrap-contact100-form-btn">
            <div class="contact100-form-bgbtn"></div>
            <button class="contact100-form-btn">
              Crypt
            </button>
          </div>
        </div>
      </form>
      <br />
      <hr />
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">N°</th>
            <th scope="col">Username</th>
            <th scope="col">Password</th>
            <th scope="col">Password crypted</th>
            <th scope="col">Password crypted + salt</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $salt = implementMD5("I'am writing this code at 2 A.M. and I'm tired, but that's a good passphrase I guess");
          for ($i = 0; $i < 100; $i++) {
            ?>
            <tr>
              <th scope="row"><?php echo $i + 1; ?></th>
              <td><?php echo "id" . ($i + 1); ?></td>
              <td><?php echo $data[$i]['password']; ?></td>
              <td><?php echo $data[$i]['password_hash']; ?></td>
              <td><?php echo $data[$i]['password_hash_salt']; //The salt is the passphrase, the password, the passphrase reverted and all of this crypted in MD5
                    ?></td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>

      <div class="container-contact100-form-btn">
        <div class="wrap-contact100-form-btn">
          <div class="contact100-form-bgbtn"></div>
          <a href="index.php?action=newdatabase"><button class="contact100-form-btn">Generate a new database!</button></a>
        </div>
      </div>
    </div>
    <span class="contact100-more">
      Abel Derderian / Martin Prieur de la Comble / Gabriel Favot<br />
      Our project is open-source <a href="https://github.com/abeldotam/md5implementation" target="_blank">just here</a>, on GitHub
    </span>
  </div>
  <div id="dropDownSelect1"></div>
  <script src="style/vendor/jquery/jquery-3.2.1.min.js"></script>
  <script src="style/vendor/bootstrap/js/popper.js"></script>
  <script src="style/vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="style/vendor/select2/select2.min.js"></script>
  <script src="style/js/main.js"></script>
</body>
</html>