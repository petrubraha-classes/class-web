<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>lab7-signup</title>
  <meta name="description" content="registration page for my users" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="../xcelent.css" />
</head>

<body>
  <main>
    <form method="post" action="authentication.php">
      <label for="username"> username: </label><br />
      <input type="text" id="username" name="username" /><br />

      <label for="emailAddress"> email: </label><br />
      <input type="email" id="emailAddress" name="email" /><br />
      <label for="password"> password: </label><br />
      <input type="password" id="password" name="password" /><br />

      <input type="submit" value="signup" class="anchor-button" />
    </form>

    <a href="index.php" class="anchor-button">login</a>
  </main>
</body>

</html>