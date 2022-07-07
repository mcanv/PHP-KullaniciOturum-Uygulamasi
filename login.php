<?php

require_once __DIR__ . '/core/db.php';

unset($_SESSION['error']);

if(isset($_SESSION['id'])) {
    header("Location: index.php");
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    if(isset($email) && isset($password)) {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Lütfen geçerli mail adresi giriniz.";
        }
        else if(strlen($password) < 6) {
            $_SESSION['error'] = "Şifre en az 6 karakter olmalıdır.";
        } else {
            $existing_query = $db->prepare("SELECT * FROM users WHERE email = :email");
            $existing_query->bindParam(':email', $email);
            $existing_query->execute();
            $existing_user = $existing_query->fetch(PDO::FETCH_OBJ);

            if($existing_user) {
                if(password_verify($password, $existing_user->password)) {
                    $_SESSION['id'] = $existing_user->id;
                    header("Location: index.php");
                } else {
                    $_SESSION['error'] = "Hatalı şifre girdiniz!";
                }
            } else {
                $_SESSION['error'] = "Giriş bilgilerinizi kontrol edin.";
            }
        }
    }
}
?>

<?php if(isset($_SESSION['error'])): ?>
<?php echo $_SESSION['error']; ?>
<?php endif; ?>

<h3>Giriş yap</h3>
<form method="POST">
    <input type="email" name="email" placeholder="Email"><br>
    <input type="password" name="password" placeholder="Password"><br><br>
    <button type="submit">
        Gönder
    </button>
</form>