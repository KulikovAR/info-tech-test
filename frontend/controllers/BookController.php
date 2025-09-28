<?php

namespace frontend\controllers;

use common\decorators\AuthorDecorator;
use common\decorators\BookDecorator;
use common\models\Book;
use frontend\models\BookForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BookController extends Controller
{
    private $bookService;
    private $authorService;

    public function init()
    {
        parent::init();
        $this->bookService = Yii::$app->get('bookService');
        $this->authorService = Yii::$app->get('authorService');
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
        $books = $this->bookService->getAllBooks();
        $decoratedBooks = [];

        foreach ($books as $book) {
            $decoratedBooks[] = BookDecorator::decorate($book);
        }

        return $this->render('index', [
            'books' => $decoratedBooks,
        ]);
    }

    public function actionView($id)
    {
        $book = $this->bookService->getBook($id);
        if (!$book) {
            throw new NotFoundHttpException('Книга не найдена');
        }

        $decoratedBook = BookDecorator::decorate($book);
        $decoratedAuthors = [];

        foreach ($book->authors as $author) {
            $decoratedAuthors[] = AuthorDecorator::decorate($author);
        }

        return $this->render('view', [
            'book' => $decoratedBook,
            'authors' => $decoratedAuthors,
        ]);
    }

    public function actionCreate()
    {
        $form = new BookForm();
        $authors = $this->authorService->getAllAuthors();
        $decoratedAuthors = [];

        foreach ($authors as $author) {
            $decoratedAuthors[] = AuthorDecorator::decorate($author);
        }

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $book = new Book();
                $form->saveToBook($book);
                $this->bookService->createBook($book->attributes, $form->authorIds);
                Yii::$app->session->setFlash('success', 'Книга успешно создана');
                return $this->redirect(['view', 'id' => $book->id]);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'form' => $form,
            'authors' => $decoratedAuthors,
        ]);
    }

    public function actionUpdate($id)
    {
        $book = $this->bookService->getBook($id);
        if (!$book) {
            throw new NotFoundHttpException('Книга не найдена');
        }

        $form = new BookForm();
        $form->loadFromBook($book);

        $authors = $this->authorService->getAllAuthors();
        $decoratedAuthors = [];

        foreach ($authors as $author) {
            $decoratedAuthors[] = AuthorDecorator::decorate($author);
        }

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $form->saveToBook($book);
                $this->bookService->updateBook($book, $book->attributes, $form->authorIds);
                Yii::$app->session->setFlash('success', 'Книга успешно обновлена');
                return $this->redirect(['view', 'id' => $book->id]);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'form' => $form,
            'book' => $book,
            'authors' => $decoratedAuthors,
        ]);
    }

    public function actionDelete($id)
    {
        $book = $this->bookService->getBook($id);
        if (!$book) {
            throw new NotFoundHttpException('Книга не найдена');
        }

        try {
            $this->bookService->deleteBook($book);
            Yii::$app->session->setFlash('success', 'Книга успешно удалена');
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['index']);
    }
}
