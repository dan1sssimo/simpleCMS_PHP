<form method="post" action="" enctype="multipart/form-data">
    <p>
        Ви дійсно бажаєте оцінити новину ( <?= $news['title']?> )? <br>( Оцінити новину можна тільки 1 раз )<b></b>
    </p>
    <button type="submit" class="btn btn-success">Оцінити</button>
    <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-primary">Відмінити</a>
</form>