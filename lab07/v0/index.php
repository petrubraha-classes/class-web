<?php
if (isset($_COOKIE['userSession'])) {
  header("Location: dashboard.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>lab7-login</title>
  <meta name="description" content="login page for my users" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="../xcelent.css" />
</head>

<body>
  <main>
    <form method="post" action="authentication.php">
      <label for="emailAddress"> email: </label><br />
      <input type="email" id="emailAddress" name="email" /><br />

      <label for="password"> password: </label><br />
      <input type="password" id="password" name="password" /><br />
      <input type="submit" value="login" class="anchor-button" />
    </form>

    <a href="inreg.php" class="anchor-button">signup</a>
  </main>
</body>

</html>