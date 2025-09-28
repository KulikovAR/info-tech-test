<?php

use yii\helpers\Html;
use frontend\models\SubscriptionForm;
use yii\widgets\ActiveForm;

$this->title = $author->getFullName();
$this->params['breadcrumbs'][] = ['label' => 'Авторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="author-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-8">
            <p><strong>Полное имя:</strong> <?= Html::encode($author->getFullName()) ?></p>
            <p><strong>Количество книг:</strong> <?= $author->getBooksCount() ?></p>
            <p><strong>Дата добавления:</strong> <?= $author->getFormattedCreatedAt() ?></p>
            
            <?php if (!empty($books)): ?>
                <h3>Книги автора:</h3>
                <div class="row">
                    <?php foreach ($books as $book): ?>
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?= Html::encode($book->title) ?></h5>
                                    <p class="card-text">
                                        <strong>Год:</strong> <?= $book->getFormattedYear() ?><br>
                                        <strong>ISBN:</strong> <?= Html::encode($book->isbn) ?>
                                    </p>
                                    <?= Html::a('Просмотр книги', ['book/view', 'id' => $book->id], ['class' => 'btn btn-primary btn-sm']) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="col-md-4">
            <?php if (Yii::$app->user->isGuest): ?>
                <div class="card">
                    <div class="card-header">
                        <h5>Подписка на уведомления</h5>
                    </div>
                    <div class="card-body">
                        <p>Получайте уведомления о новых книгах этого автора</p>
                        
                        <?php $subscriptionForm = new SubscriptionForm(); ?>
                        <?php $form = ActiveForm::begin(['action' => ['subscription/subscribe', 'authorId' => $author->id]]); ?>
                        
                        <?= $form->field($subscriptionForm, 'phone')->textInput(['placeholder' => '+7 (999) 123-45-67']) ?>
                        
                        <div class="form-group">
                            <?= Html::submitButton('Подписаться', ['class' => 'btn btn-success btn-sm']) ?>
                        </div>
                        
                        <?php ActiveForm::end(); ?>
                        
                        <hr>
                        
                        <?php $unsubscribeForm = new SubscriptionForm(); ?>
                        <?php $form = ActiveForm::begin(['action' => ['subscription/unsubscribe', 'authorId' => $author->id]]); ?>
                        
                        <?= $form->field($unsubscribeForm, 'phone')->textInput(['placeholder' => '+7 (999) 123-45-67']) ?>
                        
                        <div class="form-group">
                            <?= Html::submitButton('Отписаться', ['class' => 'btn btn-warning btn-sm']) ?>
                        </div>
                        
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::a('Редактировать', ['update', 'id' => $author->id], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $author->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этого автора?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Назад к списку', ['index'], ['class' => 'btn btn-default']) ?>
    </div>
</div>
