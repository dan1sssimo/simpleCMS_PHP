<form method="post" action="" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="title" class="form-label">Заголовок новини</label>
        <input type="text" name="title" value="<?= $model['title'] ?>" class="form-control" id="title">
    </div>
    <div class="mb-3">
        <label for="short_text" class="form-label">Короткий текст новини</label>
        <textarea name="short_text" class="form-control editor" id="short_text"><?= $model['short_text'] ?></textarea>
    </div>
    <div class="mb-3">
        <label for="text" class="form-label">Повний текст новини</label>
        <textarea name="text" class="form-control editor" id="text"><?= $model['text'] ?></textarea>
    </div>
    <div class="mb-3">
        <label for="text" class="form-label">Фотографія до новини</label>
        <input type="file" name="file" accept="image/jpeg, image/png" class="form-control" id="file">
    </div>
    <div class="mb-3">
        <? if (is_file('files/news/' . $model['photo'] . '_b.jpg')): ?>
            <img src="/files/news/<?= $model['photo'] ?>_b.jpg"/>
        <? endif; ?>
    </div>
    <button type="submit" class="btn btn-primary">Зберегти</button>
</form>