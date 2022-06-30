<?php
$UserModel = new \models\Users();
$user = $UserModel->GetCurrentUser();
?>
<form method="post" action="">
    <div>
        <div class="mb-3">
            <label for="password3" class="form-label">Введіть пароль для вмикання адмін панелі:</label>
            <input minlength="8" type="password" name="password3" class="form-control" id="password3">
        </div>
        <div class="mb-3">
            <label for="access" class="form-label">Введіть спеціальне значення для вмикання панелі:</label>
            <input type="password" name="access" class="form-control" id="access">
        </div>
        <button type="submit" class="btn btn-success">Отримати доступ</button>
        <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-primary">Повернутися назад</a>
    </div>
</form>

