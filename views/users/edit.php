<?php
$UserModel = new \models\Users();
$user = $UserModel->GetCurrentUser();
?>
<table class="table table-bordered border-primary ">
    <thead>
    <tr class="table-info">
        <th scope="col">Логін</th>
        <th scope="col">Прізвище</th>
        <th scope="col">Ім'я</th>
    </tr>
    </thead>
    <tbody>
    <tr class="table-info">
        <td><?= $user['login'] ?></td>
        <td><?= $user['lastname'] ?></td>
        <td><?= $user['firstname'] ?></td>
    </tr>
    </tbody>
</table>
<div class="char1">
    <a href="editName" class="btn btn-info"><h5>Змінити особисті дані</h5></a>
    <a href="editPass" class="btn btn-info"><h5>Змінити пароль</h5></a>
    <?php if ($user['access'] != 1): ?>
        <a href="/admin" class="btn btn-danger"><h5>Режим адміністратора</h5></a>
    <?php endif; ?>
    <?php if ($user['access'] != 0): ?>
        <a href="deleteUser" class="btn btn-danger"><h5>Видалення користувачів</h5></a>
    <?php endif; ?>
    <?php if ($user['access'] != 0): ?>
        <a href="exitadmin" class="btn btn-danger"><h5>Вийти з режиму адміністратора</h5></a>
    <?php endif; ?>
</div>
