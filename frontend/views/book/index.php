<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Книги';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="book-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить книгу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <div class="row">
        <?php foreach ($books as $book): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="<?= $book->getCoverImageUrl() ?>" class="card-img-top" alt="Обложка" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?= Html::encode($book->title) ?></h5>
                        <p class="card-text">
                            <strong>Год:</strong> <?= $book->getFormattedYear() ?><br>
                            <strong>Авторы:</strong> <?= Html::encode($book->getAuthorsNames()) ?><br>
                            <strong>ISBN:</strong> <?= Html::encode($book->isbn) ?>
                        </p>
                        <p class="card-text"><?= $book->getShortDescription(100) ?></p>
                        <div class="btn-group" role="group">
                            <?= Html::a('Просмотр', ['view', 'id' => $book->id], ['class' => 'btn btn-primary btn-sm']) ?>
                            <?= Html::a('Редактировать', ['update', 'id' => $book->id], ['class' => 'btn btn-warning btn-sm']) ?>
                            <?= Html::a('Удалить', ['delete', 'id' => $book->id], [
                                'class' => 'btn btn-danger btn-sm',
                                'data' => [
                                    'confirm' => 'Вы уверены, что хотите удалить эту книгу?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php Pjax::end(); ?>
</div>
