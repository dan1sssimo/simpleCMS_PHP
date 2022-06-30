<form method="post" action="">
    <div>
        <div class="mb-3">
            <label for="password2" class="form-label">Введіть старий пароль</label>
            <input minlength="8" type="password" name="password2" class="form-control" id="password2">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Введіть новий пароль</label>
            <input minlength="8" type="password" name="password" class="form-control" id="password">
        </div>
        <button type="submit" class="btn btn-success">Змінити особисті дані</button>
        <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-primary">Повернутися назад</a>
    </div>
</form>