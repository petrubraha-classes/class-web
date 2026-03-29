<?php
define('COOKIE_NAME', 'userSession');
define('COOKIE_EXPIRY', 3600); // 1 hour

define('DB_HOST', 'localhost');
define('DB_NAME', 'user_system');
define('DB_USER', 'root');
define('DB_PASS', '');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
  die('Connection failed: ' . $conn->connect_error);
}

function setUserCookie($email)
{
  $expiry = time() + COOKIE_EXPIRY;
  $token = base64_encode(json_encode(['email' => $email, 'expiry' => $expiry]));
  setcookie(COOKIE_NAME, $token, [
    'expires' => $expiry,
    'path' => '/',
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Strict'
  ]);
}

function getUserFromCookie()
{
  if (!isset($_COOKIE[COOKIE_NAME]))
    return null;
  $data = json_decode(base64_decode($_COOKIE[COOKIE_NAME]), true);
  if (!isset($data['email'], $data['expiry']))
    return null;
  if (time() > $data['expiry'])
    return null;
  return $data;
}

function clearUserCookie()
{
  setcookie(COOKIE_NAME, '', time() - 3600, '/');
}

if (isset($_GET['logout'])) {
  clearUserCookie();
  header('Location: index.php');
  exit;
}

$error = '';
$mode = $_GET['action'] ?? 'choose'; // register, login, choose

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
  $password = $_POST['password'] ?? '';

  if (!$email || strlen($password) < 6) {
    $error = 'Invalid email or password.';
  } elseif ($_POST['mode'] === 'register') {
    $stmt = $conn->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
      $error = 'User already exists.';
    } else {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $stmt = $conn->prepare('INSERT INTO users (email, password_hash) VALUES (?, ?)');
      $stmt->bind_param('ss', $email, $hash);
      $stmt->execute();
      setUserCookie($email);
      header('Location: index.php');
      exit;
    }
    $stmt->close();
  } elseif ($_POST['mode'] === 'login') {
    $stmt = $conn->prepare('SELECT password_hash FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($hash);
    if ($stmt->fetch() && password_verify($password, $hash)) {
      setUserCookie($email);
      header('Location: index.php');
      exit;
    } else {
      $error = 'Invalid login credentials.';
    }
    $stmt->close();
  }
}

$user = getUserFromCookie();

echo '<!DOCTYPE html>';
echo '<html lang="en">';
echo '<head>';
echo '    <meta charset="UTF-8">';
echo '    <meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '    <title>User System</title>';
echo '</head>';
echo '<body>';

if ($user) {
  echo '<h2>Welcome, ' . htmlspecialchars($user['email']) . '</h2>';
  echo '<p>Session expires in ' . ($user['expiry'] - time()) . ' seconds.</p>';
  echo '<p><a href="?logout=1">Logout</a></p>';
} else {
  if ($mode === 'choose') {
    echo '<h2>Choose an Action</h2>';
    echo '<p><a href="?action=register">Register</a> | <a href="?action=login">Login</a></p>';
  } elseif (in_array($mode, ['register', 'login'])) {
    echo '<h2>' . ucfirst($mode) . '</h2>';
    if (!empty($error)) {
      echo '<p style="color:red;">' . htmlspecialchars($error) . '</p>';
    }
    echo '<form method="post">';
    echo '    <input type="hidden" name="mode" value="' . htmlspecialchars($mode) . '">';
    echo '    <label>Email: <input type="email" name="email" required></label><br><br>';
    echo '    <label>Password: <input type="password" name="password" minlength="6" required></label><br><br>';
    echo '    <button type="submit">' . ucfirst($mode) . '</button>';
    echo '</form>';
    echo '<p><a href="index.php">Back</a></p>';
  } else {
    echo '<p>Invalid action.</p>';
    echo '<p><a href="index.php">Back</a></p>';
  }
}

echo '</body>';
echo '</html>';

$conn->close();