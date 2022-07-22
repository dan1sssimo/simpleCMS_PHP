<p>
    Ви дійсно бажаєте видалити історію <b><?= $model['title'] ?></b>?
</p>
<p>
    <a href="/story/delete?id=<?= $model['id'] ?>&confirm=yes" class="btn btn-danger">Видалити</a>
    <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-primary">Відмінити</a>
</p>