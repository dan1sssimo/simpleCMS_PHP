<?php

namespace controllers;

use core\Controller;

/**
 * Контроллер для метода News
 * @package controllers
 */
class News extends Controller
{
    protected $user;
    protected $newsModel;
    protected $userModel;
    protected $filtersModel;

    public function __construct()
    {
        $this->userModel = new \models\Users();
        $this->newsModel = new \models\News();
        $this->filtersModel = new \models\SerchNews();
        $this->user = $this->userModel->GetCurrentUser();
    }

    /**
     * Відображення початкової сторінки
     */
    public function actionIndex()
    {
        global $Config;
        $title = 'Новини';
        if (empty($_POST)) {
            $lastNews = $this->newsModel->GetLastNews($Config['NewsCount']);
        } else {
            $lastNews = $this->filtersModel->actionSearch($_POST);
        }
        return $this->render('index', ['lastNews' => $lastNews], [
            'PageTitle' => $title,
            'MainTitle' => $title,
        ]);
    }

    public function actionView()
    {
        global $Config;
        $id = $_GET['id'];
        $counter = $this->newsModel->GetAllLikes($id);
        $news = $this->newsModel->GetNewsById($id);
        if (empty($_POST))
            $lastComments = $this->newsModel->GetLastComments($Config['CommentsCount'], $id);
        $title = $news['title'];
        return $this->render('view', ['model' => $news, 'lastComments' => $lastComments, 'counter' => $counter], [
            'PageTitle' => $title,
            'MainTitle' => $title,
        ]);
    }

    public function actionAddLike()
    {
        $id = $_GET['id'];
        $news = $this->newsModel->GetNewsById($id);
        $user = $this->userModel->GetCurrentUser();
        $titleForbidden = 'Доступ заборонено';
        if (empty($this->user))
            return $this->render('forbidden', null, [
                'PageTitle' => $titleForbidden,
                'MainTitle' => $titleForbidden,
            ]);
        $title = 'Додавання лайку';
        if ($this->isPost()) {
            $result = $this->newsModel->AddLike($_POST, $id);
            if ($result['error'] === false) {
                return $this->renderMessage('ok', 'Новина успішно оцінена', null,
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title,]);
            } else {
                $message = implode('<br/>', $result['messages']);
                return $this->render('addlike', ['model' => $_POST, 'news' => $news, 'user' => $user], [
                    'PageTitle' => $title,
                    'MainTitle' => $title,
                    'MessageText' => $message,
                    'MessageClass' => 'danger'
                ]);
            }
        } else
            return $this->render('addlike', ['model' => $_POST, 'news' => $news, 'user' => $user], [
                'PageTitle' => $title,
                'MainTitle' => $title,
            ]);
    }

    public function actionAddComment()
    {
        $id = $_GET['id'];
        $titleForbidden = 'Доступ заборонено';
        if (empty($this->user))
            return $this->render('forbidden', null, [
                'PageTitle' => $titleForbidden,
                'MainTitle' => $titleForbidden,
            ]);
        $title = 'Додавання коментаря';
        if ($this->isPost()) {
            $result = $this->newsModel->AddComment($_POST, $id);
            if ($result['error'] === false) {
                return $this->renderMessage('ok', 'Коментар успішно додано', null,
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title,]);
            } else {
                $message = implode('<br/>', $result['messages']);
                return $this->render('formcoment', ['model' => $_POST], [
                    'PageTitle' => $title,
                    'MainTitle' => $title,
                    'MessageText' => $message,
                    'MessageClass' => 'danger'
                ]);
            }
        } else
            return $this->render('formcoment', ['model' => $_POST], [
                'PageTitle' => $title,
                'MainTitle' => $title,
            ]);
    }

    public function actionAdd()
    {
        $titleForbidden = 'Доступ заборонено';
        if (empty($this->user))
            return $this->render('forbidden', null, [
                'PageTitle' => $titleForbidden,
                'MainTitle' => $titleForbidden,
            ]);
        $title = 'Додавання новини';
        if ($this->isPost()) {
            $result = $this->newsModel->AddNews($_POST);
            if ($result['error'] === false) {
                $allowed_types = ['image/png', 'image/jpeg'];
                if (is_file($_FILES['file']['tmp_name']) && in_array($_FILES['file']['type'], $allowed_types)) {
                    switch ($_FILES['file']['type']) {
                        case 'image/png':
                            $extension = 'png';
                            break;
                        default:
                            $extension = 'jpg';
                    }
                    $name = $result['id'] . '_' . uniqid() . '.' . $extension;
                    move_uploaded_file($_FILES['file']['tmp_name'], 'files/news/' . $name);
                    $this->newsModel->ChangePhoto($result['id'], $name);
                }
                return $this->renderMessage('ok', 'Новину успішно додано', null,
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title,]);
            } else {
                $message = implode('<br/>', $result['messages']);
                return $this->render('form', ['model' => $_POST], [
                    'PageTitle' => $title,
                    'MainTitle' => $title,
                    'MessageText' => $message,
                    'MessageClass' => 'danger'
                ]);
            }
        } else
            return $this->render('form', ['model' => $_POST], [
                'PageTitle' => $title,
                'MainTitle' => $title,
            ]);

    }

    public
    function actionEdit()
    {
        $id = $_GET['id'];
        $news = $this->newsModel->GetNewsById($id);
        $titleForbidden = 'Доступ заборонено';
        if (empty($this->user) || ($this->userModel->GetCurrentUser()['access'] != 1 && $news['user_id'] != $this->userModel->GetCurrentUser()['id']))
            return $this->render('forbidden', null, [
                'PageTitle' => $titleForbidden,
                'MainTitle' => $titleForbidden,
            ]);
        if ($news['user_id'] == $this->userModel->GetCurrentUser()['id'] || ($this->userModel->GetCurrentUser()['access']) == 1) {
            $title = 'Редагування новини';
            if ($this->isPost()) {
                $result = $this->newsModel->UpdateNews($_POST, $id);
                if ($result === true) {
                    $allowed_types = ['image/png', 'image/jpeg'];
                    if (is_file($_FILES['file']['tmp_name']) && in_array($_FILES['file']['type'], $allowed_types)) {
                        switch ($_FILES['file']['type']) {
                            case 'image/png':
                                $extension = 'png';
                                break;
                            default:
                                $extension = 'jpg';
                        }
                        $name = $result['id'] . '_' . uniqid() . '.' . $extension;
                        move_uploaded_file($_FILES['file']['tmp_name'], 'files/news/' . $name);
                        $this->newsModel->ChangePhoto($id, $name);
                    }
                    return $this->renderMessage('ok', 'Новину успішно збережено', null,
                        [
                            'PageTitle' => $title,
                            'MainTitle' => $title,]);
                } else {
                    $message = implode('<br/>', $result);
                    return $this->render('form', ['model' => $news], [
                        'PageTitle' => $title,
                        'MainTitle' => $title,
                        'MessageText' => $message,
                        'MessageClass' => 'danger'
                    ]);
                }
            } else
                return $this->render('form', ['model' => $news], [
                    'PageTitle' => $title,
                    'MainTitle' => $title,
                ]);
        }
    }

    public
    function actionDelete()
    {
        $title = 'Видалення новини';
        $id = $_GET['id'];
        if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
            if ($this->newsModel->DeleteNews($id))
                header('Location: /news/');
            else {
                return $this->renderMessage('error', 'Помилка видалення новини', null,
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title,]);
            }
        }
        $news = $this->newsModel->GetNewsById($id);
        return $this->render('delete', ['model' => $news], [
            'PageTitle' => $title,
            'MainTitle' => $title,
        ]);
    }

    /**
     * Відображення списку новин
     */
    public
    function actionList()
    {

    }
}