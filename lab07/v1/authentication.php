<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  die('error: only the POST method is allowed');
}

// warning: signup with null username is interpreted as login
$username = $_POST["username"] ?? '';
$email = $_POST["email"] ?? '';
$password = $_POST["password"] ?? '';
$hash = password_hash($password, PASSWORD_DEFAULT);

if ('' === $email || '' === $password) {
  die('error: invalid input');
}

// database query
$db = new mysqli(
  'localhost',
  'root',
  $_ENV['DB_PASSWORD'] ?? '',
  'test'
);

if ($db->connect_error) {
  die('error: ' . $db->connect_error);
}

$result = $db->prepare(
  "SELECT email, hashed_password
  FROM user
    WHERE email = ?"
);
$result->bind_param("s", $email);
$result->execute();
$result = $result->get_result();

if (!$result) {
  die('error: query failed');
}

// login
if ('' === $username) {

  if (0 == $result->num_rows) {
    die('error: invalid email');
  }

  $row = $result->fetch_assoc();
  if (
    !password_verify(
      $password,
      $row['hashed_password']
    )
  ) {
    die('error: invalid password');
  }

  $token = json_encode(
    ['email' => $email, 'username' => $username]
  );
  session_start([
    'cookie_lifetime' => 10,
    'cookie_path' => '/',
    'cookie_secure' => isset($_SERVER['HTTPS']),
    'cookie_httponly' => true
  ]);
  $_SESSION['userSession'] = $token;
  $_SESSION['lastLogin'] = time();

  header('Location: dashboard.php');
  $db->close();
  exit(0);
}

// signup
if (0 != $result->num_rows) {
  die('error: email already in use');
}

$stmt = $db->prepare(
  "INSERT INTO user (username, email, hashed_password) VALUES (?, ?, ?)"
);
$stmt->bind_param('sss', $username, $email, $hash);
$result = $stmt->execute();

if (!$result) {
  die("error: data insertion failed");
}

$db->close();
header('Location: index.php');
