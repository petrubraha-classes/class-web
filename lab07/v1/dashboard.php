<?php

function killLog()
{
  $_SESSION = array();
  if (ini_get('session.use_cookies')) {
    $cookie = session_get_cookie_params();
    setcookie(
      session_name(),
      '',
      0,
      $cookie['path'],
      $cookie['domain'],
      $cookie['secure'],
      $cookie['httponly']
    );
  }

  session_destroy();
  unset($_POST['logout']);
  header('Location: index.php');
  exit;
}

// logout is pressed
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
  killLog();
}

// normal page
else {
  session_start();
  if (!isset($_SESSION['userSession'])) {
    header("Location: index.php");
    exit;
  }

  if (
    isset($_SESSION['userSession']) &&
    (time() - $_SESSION['lastLogin'] >= 10)
  ) {
    killLog();
  }
}
?>

<!-- connected -->
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
  <main>
    <?php // message
    echo "<p>welcome back, " . $_SESSION['userSession'] . "</p>";
    echo "<p>you have 10 seconds</p>";
    // old: <a href="index.php" class="anchor-button">logout</a>
    ?>

    <!-- logout form -->
    <form method="post">
      <button type="submit" name="logout">logout</button>
    </form>
  </main>
</body>

</html>