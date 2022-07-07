<?php

require_once __DIR__ . '/core/db.php';

if(isset($_SESSION['error'])) {
    unset($_SESSION['error']); 
}

if(isset($_SESSION['id'])) {
    header("Location: index.php");
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(isset($username) && isset($email) && isset($password)) {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Lütfen geçerli mail adresi giriniz.";
        }
        else if(strlen($username) < 6) {
            $_SESSION['error'] = "Kullanıcı adı en az 6 karakter olmalıdır.";
        }
        else if(strlen($password) < 6) {
            $_SESSION['error'] = "Şifre en az 6 karakter olmalıdır.";
        } else {
            $existing_query = $db->prepare("SELECT * FROM users WHERE name = :name OR email = :email");
            $existing_query->bindParam(':name', $username);
            $existing_query->bindParam(':email', $email);
            $existing_query->execute();
            $existing_count = $existing_query->rowCount();

            if($existing_count > 0) {
                $_SESSION['error'] = "Üye mevcut!";
            } else {
                $create_user_query = $db->prepare('INSERT INTO users(name, email, password) VALUES(:name, :email, :password)');
                $create_user_query->execute([
                    ':name'     => $username,
                    ':email'    => $email,
                    ':password' => password_hash($password, PASSWORD_BCRYPT)
                ]);
                header("Location: login.php");
            }
        }
    }
}

?>

<?php if(isset($_SESSION['error'])): ?>
<?php echo $_SESSION['error']; ?>
<?php endif; ?>

<h3>Kayıt ol</h3>
<form method="POST">
    <input type="text" name="username" placeholder="Username"><br>
    <input type="email" name="email" placeholder="Email"><br>
    <input type="password" name="password" placeholder="Password"><br><br>
    <button type="submit">
        Gönder
    </button>
</form>