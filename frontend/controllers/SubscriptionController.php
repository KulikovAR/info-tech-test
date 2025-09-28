<?php

namespace frontend\controllers;

use common\models\AuthorSubscription;
use frontend\models\SubscriptionForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class SubscriptionController extends Controller
{
    private $authorService;

    public function init()
    {
        parent::init();
        $this->authorService = Yii::$app->get('authorService');
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['subscribe', 'unsubscribe'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    public function actionSubscribe($authorId)
    {
        $author = $this->authorService->getAuthor($authorId);
        if (!$author) {
            throw new NotFoundHttpException('Автор не найден');
        }

        $form = new SubscriptionForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $subscription = new AuthorSubscription();
            $subscription->author_id = $authorId;
            $subscription->phone = $form->phone;
            $subscription->created_at = time();

            if ($subscription->save()) {
                Yii::$app->session->setFlash('success', 'Вы успешно подписались на уведомления о новых книгах автора');
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка при подписке: ' . implode(', ', $subscription->getFirstErrors()));
            }
        } else {
            Yii::$app->session->setFlash('error', 'Ошибка валидации: ' . implode(', ', $form->getFirstErrors()));
        }

        return $this->redirect(['author/view', 'id' => $authorId]);
    }

    public function actionUnsubscribe($authorId)
    {
        $form = new SubscriptionForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $subscription = AuthorSubscription::findOne([
                'author_id' => $authorId,
                'phone' => $form->phone
            ]);

            if ($subscription && $subscription->delete()) {
                Yii::$app->session->setFlash('success', 'Вы успешно отписались от уведомлений');
            } else {
                Yii::$app->session->setFlash('error', 'Подписка не найдена');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Ошибка валидации: ' . implode(', ', $form->getFirstErrors()));
        }

        return $this->redirect(['author/view', 'id' => $authorId]);
    }
}
