<div class="news">
    <div>
        <? if (is_file('files/news/' . $model['photo'] . '_m.jpg')): ?>
            <? if (is_file('files/news/' . $model['photo'] . '_m.jpg')): ?>
                <a href="/files/news/<?= $model['photo'] ?>_b.jpg"  target="_blank" >
            <? endif; ?>
            <img class="bd-placeholder-img rounded float-start "
                 src="/files/news/<?= $model['photo'] ?>_m.jpg"/>
            <? if (is_file('files/news/' . $model['photo'] . '_m.jpg')): ?>
                </a>
            <? endif; ?>
        <? endif; ?>
    </div>
    <div>
        <h3> <?= $model['text'] ?></h3>
    </div>
</div>
<div>
    <h5 class="char1">Новина додана: <?= $model['datetime'] ?></h5>
    <h1 class="char1"><a href="/site" class="btn btn-info">Повернутися на головну сторінку</a></h1>
</div>
