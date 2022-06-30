<?php
$userModel = new \models\Users();
$user = $userModel->GetCurrentUser();
$dateToday = date('Y-m-d H:i:s');
?>
<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner image-wrapper">
        <div class="carousel-item active image-inner">
            <img src="/files/news/slide1.jpg" class="d-block w-100 rounded" alt="...">
        </div>
        <div class="carousel-item image-inner">
            <img src="/files/news/slide1.jpg" class="d-block w-100 rounded" alt="...">
        </div>
        <div class="carousel-item image-inner">
            <img src="/files/news/slide1.jpg" class="d-block w-100 rounded" alt="...">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<table class="table table-dark table-bordered border-light textSize">
    <thead>
    <h1 class="mt-5 char1">Найновіші новини</h1>
    </thead>
    <tbody table table-bordered border-primary >
    <?php foreach ($lastNews as $news): ?>
            <tr>
                <td><a class="btn-dark text-decoration-none "
                       href="/news/view?id=<?= $news['id'] ?>"><?= $news['short_text'] ?></a></td>
                <td ><a>Дата публікації: <?= $news['datetime'] ?></a></td>
            </tr>
    <?php endforeach; ?>
    </tbody>
</table>