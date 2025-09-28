<?php

use yii\helpers\Html;

$this->title = 'Авторы';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="author-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить автора', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="row">
        <?php foreach ($authors as $author): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= Html::encode($author->getFullName()) ?></h5>
                        <p class="card-text">
                            <strong>Количество книг:</strong> <?= $author->getBooksCount() ?><br>
                            <strong>Дата добавления:</strong> <?= $author->getFormattedCreatedAt() ?>
                        </p>
                        <div class="btn-group" role="group">
                            <?= Html::a('Просмотр', ['view', 'id' => $author->id], ['class' => 'btn btn-primary btn-sm']) ?>
                            <?= Html::a('Редактировать', ['update', 'id' => $author->id], ['class' => 'btn btn-warning btn-sm']) ?>
                            <?= Html::a('Удалить', ['delete', 'id' => $author->id], [
                                'class' => 'btn btn-danger btn-sm',
                                'data' => [
                                    'confirm' => 'Вы уверены, что хотите удалить этого автора?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
