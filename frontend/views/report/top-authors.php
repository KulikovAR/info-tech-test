<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'ТОП 10 авторов';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="report-top-authors">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row mb-4">
        <div class="col-md-6">
            <?php $form = ActiveForm::begin(['method' => 'get']); ?>
            
            <div class="form-group">
                <label>Выберите год:</label>
                <?= Html::dropDownList('year', $year, array_combine(range(2020, date('Y') + 1), range(2020, date('Y') + 1)), [
                    'class' => 'form-control',
                    'onchange' => 'this.form.submit()'
                ]) ?>
            </div>
            
            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <h3>ТОП 10 авторов за <?= $year ?> год</h3>

    <?php if (empty($authors)): ?>
        <div class="alert alert-info">
            <p>За выбранный год книги не найдены.</p>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Место</th>
                        <th>Автор</th>
                        <th>Количество книг</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($authors as $index => $author): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= Html::encode($author->getFullName()) ?></td>
                            <td><?= $author->getBooksCount() ?></td>
                            <td>
                                <?= Html::a('Просмотр', ['author/view', 'id' => $author->id], ['class' => 'btn btn-primary btn-sm']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
