<?php

namespace controllers;

use core\Controller;

class Story extends Controller
{
    protected $user;
    protected $storyModel;
    protected $userModel;
    protected $filtersModel;

    public function __construct()
    {
        $this->userModel = new \models\Users();
        $this->storyModel = new \models\Story();
        $this->filtersModel = new \models\SerchStory();
        $this->user = $this->userModel->GetCurrentUser();
    }

    /**
     * Відображення початкової сторінки
     */
    public function actionIndex()
    {
        global $Config;
        $title = 'Історії';
        if (empty($_POST)) {
            $lastStory = $this->storyModel->GetLastStory($Config['StoryCount']);
        } else {
            $lastStory = $this->filtersModel->actionSearch($_POST);
        }
        return $this->render('index', ['lastStory' => $lastStory], [
            'PageTitle' => $title,
            'MainTitle' => $title,
        ]);
    }

    public function actionView()
    {
        $id = $_GET['id'];
        $story = $this->storyModel->GetStoryById($id);
        $title = $story['title'];
        return $this->render('view', ['model' => $story], [
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
        $title = 'Додавання історії';
        if ($this->isPost()) {
            $result = $this->storyModel->AddStory($_POST);
            if ($result['error'] === false) {
                return $this->renderMessage('ok', 'Історію успішно додано', null,
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

    public function actionEdit()
    {
        $id = $_GET['id'];
        $story = $this->storyModel->GetStoryById($id);
        $titleForbidden = 'Доступ заборонено';
        if (empty($this->user) || ($this->userModel->GetCurrentUser()['access'] != 1 && $story['user_id'] != $this->userModel->GetCurrentUser()['id']))
            return $this->render('forbidden', null, [
                'PageTitle' => $titleForbidden,
                'MainTitle' => $titleForbidden,
            ]);
        if ($story['user_id'] == $this->userModel->GetCurrentUser()['id'] || ($this->userModel->GetCurrentUser()['access']) == 1) {
            $title = 'Редагування історії';
            if ($this->isPost()) {
                $result = $this->storyModel->UpdateStory($_POST, $id);
                if ($result === true) {
                    return $this->renderMessage('ok', 'Історію успішно збережено', null,
                        [
                            'PageTitle' => $title,
                            'MainTitle' => $title,]);
                } else {
                    $message = implode('<br/>', $result);
                    return $this->render('form', ['model' => $story], [
                        'PageTitle' => $title,
                        'MainTitle' => $title,
                        'MessageText' => $message,
                        'MessageClass' => 'danger'
                    ]);
                }
            } else
                return $this->render('form', ['model' => $story], [
                    'PageTitle' => $title,
                    'MainTitle' => $title,
                ]);
        }
    }

    public function actionDelete()
    {
        $title = 'Видалення історії';
        $id = $_GET['id'];
        if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
            if ($this->storyModel->DeleteStory($id))
                header('Location: /story/');
            else {
                return $this->renderMessage('error', 'Помилка видалення історії', null,
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title,]);
            }
        }
        $story = $this->storyModel->GetStoryById($id);
        return $this->render('delete', ['model' => $story], [
            'PageTitle' => $title,
            'MainTitle' => $title,
        ]);
    }
    /**
     * Відображення списку історій
     */
    public function actionList()
    {

    }

}