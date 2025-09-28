<?php

use yii\helpers\Html;

$this->title = 'Каталог книг';
?>

<div class="site-index">
    <div class="jumbotron">
        <h1>Добро пожаловать в каталог книг!</h1>
        <p class="lead">Здесь вы можете просматривать книги, авторов и подписываться на уведомления.</p>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-4">
                <h2>Книги</h2>
                <p><?= Html::a('Перейти к книгам', ['book/index'], ['class' => 'btn btn-primary']) ?></p>
            </div>
            <div class="col-lg-4">
                <h2>Авторы</h2>
                <p><?= Html::a('Перейти к авторам', ['author/index'], ['class' => 'btn btn-primary']) ?></p>
            </div>
            <div class="col-lg-4">
                <h2>Отчеты</h2>
                <p><?= Html::a('Перейти к отчетам', ['report/top-authors'], ['class' => 'btn btn-primary']) ?></p>
            </div>
        </div>
    </div>
</div>