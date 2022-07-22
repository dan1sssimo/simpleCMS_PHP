<?php
$userModel = new \models\Users();
$user = $userModel->GetCurrentUser();
?>
    <form method="post">
        <h4>Пошук історії:</h4>
        <input type="text" class="form-control" placeholder="Search..." aria-label="Search" name="search"
               value="<?php if (!empty($_POST['search'])): echo $_POST['search'];endif; ?>">
        <br>
        <button type="submit" class="btn btn-warning">Виконати пошук</button>
        <a href="/story" class="btn btn-light">Відмінити пошук</a>
    </form>
<?php foreach ($lastStory as $story): ?>
    <div class="news-record textFam">
        <h4>Назва історії: <?= $story['title'] ?></h4>
        <h6>Історія додана: <?= $story['datetime'] ?></h6>
        <?php if ($story['datetime'] != $story['datetime_lastedit'] && $story['datetime_lastedit'] != null) : ?>
            <h6>Історія відредагована: <?= $story['datetime_lastedit'] ?></h6>
        <? endif; ?>
        <div>
            <h6>Стислий опис історії: </h6><?= $story['short_text'] ?>
        </div>
        <div class="news_butt">
            <a href="/story/view?id=<?= $story['id'] ?>" class="btn btn-primary">Читати далі</a>
            <? if ($story['user_id'] == $user['id'] || $user['access'] == 1): ?>
                <a href="/story/edit?id=<?= $story['id'] ?>" class="btn btn-success">Редагувати</a>
                <a href="/story/delete?id=<?= $story['id'] ?>" class="btn btn-danger">Видалити</a>
            <? endif; ?>
        </div>
    </div>
<?php endforeach; ?>