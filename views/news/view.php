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
        <h3> <?= ($model['text']) ?></h3>
    </div>
</div>
<div>
    <h5 class="char1">Новина додана: <?= $model['datetime'] ?></h5>
    <h5 style="color: coral; text-align: center">Лайки новини: <?= $counter[0] ?></h5>
</div>
<h3 style="padding-left: 45%">Коментарі</h3>
<div style="color: darkslategrey;">
    <?php foreach ($lastComments as $comment): ?>
        <h4>Користувач: <?= $comment['firstname'] ?></h4>
        <h5>Коментар: <?= $comment['text'] ?></h5>
        <h6>Коментар доданий: <?= $comment['datetime'] ?></h6>
    <?php endforeach; ?>
</div>
<h1 class="char1"><a href="/site" class="btn btn-info">Повернутися на головну сторінку</a></h1>
