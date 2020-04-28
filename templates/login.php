<form method="post">
    <div>
        <input type="text" name="username" value="<?= htmlspecialchars($username) ?>">
    </div>
    <div>
        <input type="password" name="password" value="<?= htmlspecialchars($password) ?>">
    </div>
    <div>
        <input type="submit" value="Sign in">
    </div>
</form>
