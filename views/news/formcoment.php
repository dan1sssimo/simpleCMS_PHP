<form method="post" action="" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="text" class="form-label">Коментар:</label>
        <textarea name="text" class="form-control editor" id="text"><?= $model['text'] ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Зберегти</button>
</form>