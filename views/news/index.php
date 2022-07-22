<?php
$userModel = new \models\Users();
$user = $userModel->GetCurrentUser();
?>
    <form method="post">
        <h4>Пошук новини:</h4>
        <input type="text" class="form-control" placeholder="Search..." aria-label="Search" name="search"
               value="<?php if (!empty($_POST['search'])): echo $_POST['search'];endif; ?>">
        <br>
        <button type="submit" class="btn btn-warning">Виконати пошук</button>
        <a href="/news" class="btn btn-light">Відмінити пошук</a>
    </form>
<?php foreach ($lastNews as $news): ?>
    <div class="news-record textFam">
        <h4>Назва новини: <?= $news['title'] ?></h4>
        <h6>Новина додана: <?= $news['datetime'] ?></h6>
        <?php if ($news['datetime'] != $news['datetime_lastedit'] && $news['datetime_lastedit'] != null) : ?>
            <h6>Новина відредагована: <?= $news['datetime_lastedit'] ?></h6>
        <? endif; ?>
        <div class="photo">
            <? if (is_file('files/news/' . $news['photo'] . '_s.jpg')): ?>
                <img class="bd-placeholder-img img-thumbnail float-start"
                     src="/files/news/<?= $news['photo'] ?>_s.jpg"/>
            <? else: ?>
                <svg class="bd-placeholder-img img-thumbnail float-start" width="200" height="200"
                     xmlns="http://www.w3.org/2000/svg" role="img"
                     preserveAspectRatio="xMidYMid slice" focusable="false">
                    <rect width="100%" height="100%" fill="#868e96"></rect>
                </svg>
            <? endif; ?>
        </div>
        <div class="news_butt">
            <a href="/news/view?id=<?= $news['id'] ?>" class="btn btn-primary">Читати далі</a>
            <? if ($news['user_id'] == $user['id'] || $user['access'] == 1): ?>
                <a href="/news/edit?id=<?= $news['id'] ?>" class="btn btn-success">Редагувати</a>
                <a href="/news/addcomment?id=<?= $news['id'] ?>" class="btn btn-warning">Додати коментар</a>
                <a href="/news/delete?id=<?= $news['id'] ?>" class="btn btn-danger">Видалити</a>
                <a href="/news/addlike?id=<?= $news['id'] ?>" class="btn btn-success">Лайк</a>
            <? endif; ?>
        </div>
        <div>
            <h6>Стислий опис новини: </h6><?= $news['short_text'] ?>
        </div>

    </div>
<?php endforeach; ?>