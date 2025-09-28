<?php

namespace frontend\controllers;

use common\decorators\AuthorDecorator;
use common\decorators\BookDecorator;
use common\models\Author;
use frontend\models\AuthorForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class AuthorController extends Controller
{
    private $authorService;
    private $bookService;

    public function init()
    {
        parent::init();
        $this->authorService = Yii::$app->get('authorService');
        $this->bookService = Yii::$app->get('bookService');
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $authors = $this->authorService->getAllAuthors();
        $decoratedAuthors = [];

        foreach ($authors as $author) {
            $decoratedAuthors[] = AuthorDecorator::decorate($author);
        }

        return $this->render('index', [
            'authors' => $decoratedAuthors,
        ]);
    }

    public function actionView($id)
    {
        $author = $this->authorService->getAuthor($id);
        if (!$author) {
            throw new NotFoundHttpException('Автор не найден');
        }

        $decoratedAuthor = AuthorDecorator::decorate($author);
        $books = $this->bookService->getBooksByAuthor($id);
        $decoratedBooks = [];

        foreach ($books as $book) {
            $decoratedBooks[] = BookDecorator::decorate($book);
        }

        return $this->render('view', [
            'author' => $decoratedAuthor,
            'books' => $decoratedBooks,
        ]);
    }

    public function actionCreate()
    {
        $form = new AuthorForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $author = new Author();
                $form->saveToAuthor($author);
                $author = $this->authorService->createAuthor($author->attributes);
                Yii::$app->session->setFlash('success', 'Автор успешно создан');
                return $this->redirect(['view', 'id' => $author->id]);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', compact('form'));
    }

    public function actionUpdate($id)
    {
        $author = $this->authorService->getAuthor($id);
        if (!$author) {
            throw new NotFoundHttpException('Автор не найден');
        }

        $form = new AuthorForm();
        $form->loadFromAuthor($author);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $form->saveToAuthor($author);
                $this->authorService->updateAuthor($author, $author->attributes);
                Yii::$app->session->setFlash('success', 'Автор успешно обновлен');
                return $this->redirect(['view', 'id' => $author->id]);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', compact('form', 'author'));
    }

    public function actionDelete($id)
    {
        $author = $this->authorService->getAuthor($id);
        if (!$author) {
            throw new NotFoundHttpException('Автор не найден');
        }

        try {
            $this->authorService->deleteAuthor($author);
            Yii::$app->session->setFlash('success', 'Автор успешно удален');
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['index']);
    }
}
