<p>
    Ви дійсно бажаєте видалити користувача <b><?= $lastUsers['login'] ?></b>?
</p>
<p>
    <a href="/users/delete?id=<?= $lastUsers['id'] ?>&confirm=yes" class="btn btn-danger">Видалити</a>
    <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-primary">Відмінити</a>
</p>