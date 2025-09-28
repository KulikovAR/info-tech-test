<?php

namespace frontend\controllers;

use common\decorators\AuthorDecorator;
use Yii;
use yii\web\Controller;

class ReportController extends Controller
{
    private $authorService;

    public function init()
    {
        parent::init();
        $this->authorService = Yii::$app->get('authorService');
    }

    public function actionTopAuthors()
    {
        $year = Yii::$app->request->get('year', date('Y'));
        $authors = $this->authorService->getTopAuthorsByBooksCount($year, 10);

        $decoratedAuthors = [];
        foreach ($authors as $author) {
            $decoratedAuthors[] = new AuthorDecorator($author);
        }

        return $this->render('top-authors', [
            'authors' => $decoratedAuthors,
            'year' => $year,
        ]);
    }
}
