<?php foreach ($lastUsers as $users): ?>
    <h4 class="char1">Ім'я користувача: <?= $users['login'] ?></h4>
    <h6 class="char1"><a href="/users/delete?id=<?= $users['id'] ?>" class="btn btn-danger">Видалити</a>
    </h6>
<?php endforeach; ?>