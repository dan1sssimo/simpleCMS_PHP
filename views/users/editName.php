<?php
$UserModel = new \models\Users();
$user = $UserModel->GetCurrentUser();
?>
<form method="post" action="">
    <div>
        <div class="mb-3">
            <label for="lastname" class="form-label">Введіть нове прізвище або не змінюйте дане поле</label>
            <input type="text" name="lastname" class="form-control" id="lastname" value="<?= $user['lastname'] ?>">
        </div>
        <div class="mb-3">
            <label for="firstname" class="form-label">Введіть нове ім'я або не змінюйте дане поле</label>
            <input type="text" name="firstname" class="form-control" id="firstname" value="<?= $user['firstname'] ?>">
        </div>
        <button type="submit" class="btn btn-success">Змінити особисті дані</button>
        <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-primary">Повернутися назад</a>
    </div>
</form>