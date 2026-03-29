<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>lab9-posts</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="small.css" />
</head>

<body>
  <main>

    <?php
    foreach ($posts as $post) {
      echo '<article>';
      echo '<h2>' . htmlspecialchars($post['username']) . ':</h2>';
      echo '<p>' . htmlspecialchars($post['description']) . '</p>';
      echo '<img src="' . htmlspecialchars($post['imageUrl']) . '" alt="Post image" style="height: 300px;">';
      echo '</article>';
    }
    ?>

  </main>
</body>

</html>