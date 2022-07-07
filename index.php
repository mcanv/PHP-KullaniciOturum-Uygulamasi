<?php

require_once __DIR__ . '/core/db.php';

$users_query = $db->prepare("SELECT * FROM users ORDER BY created_at DESC");
$users_query->execute();
$users = $users_query->fetchAll(PDO::FETCH_OBJ);

if(isset($_SESSION['id'])) {
    $authenticated_user_query = $db->prepare("SELECT * FROM users WHERE id = :id");
    $authenticated_user_query->bindParam(":id", $_SESSION['id']);
    $authenticated_user_query->execute();
    $auth = $authenticated_user_query->fetch(PDO::FETCH_OBJ);

    if($auth == null) {
        header("Location: logout.php");
    }
}

?>

<?php if(isset($_SESSION['id'])): ?>
Merhabalar, <?php echo $auth->name; ?> <br>
Rolünüz: <?php echo $auth->is_admin == true ? "Admin" : "Üye" ?> <br>
<?php endif; ?>

<nav>
    <ul>
        <?php if(isset($_SESSION['id'])): ?>
        <?php if($auth->is_admin): ?>
        <li>
            <a target="_blank" href="admin.php">
                Admin paneli
            </a>
        </li>
        <?php endif; ?>
        <li>
            <a href="logout.php">
                Çıkış yap
            </a>
        </li>
        <?php else: ?>
        <li>
            <a href="login.php">
                Giriş yap
            </a>
        </li>
        <li>
            <a href="register.php">
                Kayıt ol
            </a>
        </li>
        <?php endif; ?>
    </ul>
</nav>


<h3>USERS</h3>

<?php if(count($users) > 0): ?>

<table border="1">
    <tr>
        <td>Username</td>
        <td>Email address</td>
        <td>Register date</td>
    </tr>
    <?php foreach($users as $user): ?>
    <tr>
        <td><?php echo $user->name; ?></td>
        <td><?php echo $user->email; ?></td>
        <td><?php echo $user->created_at; ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<?php else: ?>
<p>No user found.</p>

<?php endif; ?>