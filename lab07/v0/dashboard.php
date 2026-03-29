<?php

// logout is pressed
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {

  //delete cookie
  setcookie(
    'userSession',
    $token,
    [
      'expires' => 0,
      'path' => '/',
      'secure' => isset($_SERVER['HTTPS']),
      'httponly' => true
    ]
  );

  header('Location: index.php');
  exit;
}

// normal page
else {
  if (!isset($_COOKIE['userSession'])) {
    header("Location: index.php");
    exit;
  }

  // connected
  echo '
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="refresh" content="10">
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>lab7-dashboard</title>
  <meta name="description" content="user-specific dashboard" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="../xcelent.css" />
</head>

<body>
  <main>';

  // message
  echo "<p>welcome back, " . $_COOKIE['userSession'] . "</p>";
  echo "<p>you have 10 seconds</p>";

  // logout form
  echo '
  <form method="post">
    <button type="submit" name="logout">logout</button>
  </form>
  ';

  // old: <a href="index.php" class="anchor-button">logout</a>
  echo '
  </main>
</body>

</html>
  ';
}
