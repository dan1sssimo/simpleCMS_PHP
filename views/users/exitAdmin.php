<form method="post" action="">
    <div class="mb-3">
        <label for="access" class="form-label">Введіть спеціальне значення для вимикання панелі:</label>
        <input type="password" name="access" class="form-control" id="access" value="0" readonly>
    </div>
    <button type="submit" class="btn btn-danger">Вийти з панелі адміністратора</button>
    <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-primary">Повернутися назад</a>
</form>