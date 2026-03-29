<?php

function getPosts()
{
  $db = new mysqli(
    'localhost',
    'root',
    $_ENV['DB_PASSWORD'] ?? '',
    'facebook'
  );

  if ($db->connect_errno) {
    die('error: database connection failed');
  }

  $result = $db->query(
    'SELECT username, description, imageUrl FROM post'
  );

  if (!$result) {
    die('error: query failed ' . $db->error);
  }

  $posts = [];
  while ($row = $result->fetch_assoc()) {
    $posts[] = $row;
  }

  $db->close();
  return $posts;
}
