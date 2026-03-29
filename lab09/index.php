<?php

// database
$DB = new mysqli(
  'localhost',
  'root',
  $_ENV['DB_PASSWORD'] ?? '',
  'facebook'
);

if (mysqli_connect_errno()) {
  die('error: database connection failed');
}

if (
  !($statement = $DB->query(
    'SELECT username, description, imageUrl FROM post'
  ))
) {
  die('error: query failed' . $DB->error);
}

$DB->close();

// html
echo '
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>lab9-posts</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>

      body {
        background-color: antiquewhite;
        display: flex;
        justify-content: center;
      }
      
      article {
        background-color: cornflowerblue;
      }
      
      article h2 {
        margin: 5%;
      }
      
      article p {
        margin: 5%;
      }
      
      article img {
        display: block;
        margin: 0 auto;
      }

    </style>
  </head>
  <body>
    <main>';

while ($row = $statement->fetch_assoc()) {
  echo '<article>';
  echo '<h2>' . $row['username'] . ':</h2>';
  echo '<p>' . $row['description'] . '</p>';
  echo '<img src="' . $row['imageUrl'] . '" style="height: 300px;">';
  echo '</article>';
}

echo '
    </main>
  </body>
</html>';
