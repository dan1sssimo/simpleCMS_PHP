<?php
$userModel = new \models\Users();
$user = $userModel->GetCurrentUser();
?>
    <form method="post">
        <h4>Пошук публікації:</h4>
        <input type="text" class="form-control" placeholder="Search..." aria-label="Search" name="search"
               value="<?php if (!empty($_POST['search'])): echo $_POST['search'];endif; ?>">
        <br>
        <button type="submit" class="btn btn-warning">Виконати пошук</button>
        <a href="/diff" class="btn btn-light">Відмінити пошук</a>
    </form>
<?php foreach ($lastDiff as $diff): ?>
    <div class="news-record textFam">
        <h4>Назва публікації: <?= $diff['title'] ?></h4>
        <h6>Публікація додана: <?= $diff['datetime'] ?></h6>
        <?php if ($diff['datetime'] != $diff['datetime_lastedit'] && $diff['datetime_lastedit'] != null) : ?>
            <h6>Публікація відредагована: <?= $diff['datetime_lastedit'] ?></h6>
        <? endif; ?>
        <div>
            <h6>Стислий опис публікації: </h6><?= $diff['short_text'] ?>
        </div>
        <div class="news_butt">
            <a href="/diff/view?id=<?= $diff['id'] ?>" class="btn btn-primary">Читати далі</a>
            <? if ($diff['user_id'] == $user['id'] || $user['access'] == 1): ?>
                <a href="/diff/edit?id=<?= $diff['id'] ?>" class="btn btn-success">Редагувати</a>
                <a href="/diff/delete?id=<?= $diff['id'] ?>" class="btn btn-danger">Видалити</a>
            <? endif; ?>
        </div>
    </div>
<?php endforeach; ?>