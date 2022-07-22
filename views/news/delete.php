<p>
    Ви дійсно бажаєте видалити новину <b><?= $model['title'] ?></b>?
</p>
<p>
    <a href="/news/delete?id=<?= $model['id'] ?>&confirm=yes" class="btn btn-danger">Видалити</a>
    <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-primary">Відмінити</a>
</p>
