<?php

namespace controllers;

use core\Controller;

class Diff extends Controller
{
    protected $user;
    protected $diffModel;
    protected $userModel;
    protected $filtersModel;

    public function __construct()
    {
        $this->userModel = new \models\Users();
        $this->diffModel = new \models\Diff();
        $this->filtersModel = new \models\SerchDiff();
        $this->user = $this->userModel->GetCurrentUser();
    }

    /**
     * Відображення початкової сторінки
     */
    public function actionIndex()
    {
        global $Config;
        $title = 'Публікації без конкретної теми';
        if (empty($_POST)) {
            $lastDiff = $this->diffModel->GetLastDiff($Config['DiffCount']);
        } else {
            $lastDiff = $this->filtersModel->actionSearch($_POST);
        }
        return $this->render('index', ['lastDiff' => $lastDiff], [
            'PageTitle' => $title,
            'MainTitle' => $title,
        ]);
    }

    public function actionView()
    {
        $id = $_GET['id'];
        $diff = $this->diffModel->GetDiffById($id);
        $title = $diff['title'];
        return $this->render('view', ['model' => $diff], [
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
        $title = 'Додавання публікації';
        if ($this->isPost()) {
            $result = $this->diffModel->AddDiff($_POST);
            if ($result['error'] === false) {
                return $this->renderMessage('ok', 'Публікацію успішно додано', null,
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
        $diff = $this->diffModel->GetDiffById($id);
        $titleForbidden = 'Доступ заборонено';
        if (empty($this->user) || ($this->userModel->GetCurrentUser()['access'] != 1 && $diff['user_id'] != $this->userModel->GetCurrentUser()['id']))
            return $this->render('forbidden', null, [
                'PageTitle' => $titleForbidden,
                'MainTitle' => $titleForbidden,
            ]);
        if ($diff['user_id'] == $this->userModel->GetCurrentUser()['id'] || ($this->userModel->GetCurrentUser()['access']) == 1) {
            $title = 'Редагування публікації';
            if ($this->isPost()) {
                $result = $this->diffModel->UpdateDiff($_POST, $id);
                if ($result === true) {
                    return $this->renderMessage('ok', 'Публікацію успішно збережено', null,
                        [
                            'PageTitle' => $title,
                            'MainTitle' => $title,]);
                } else {
                    $message = implode('<br/>', $result);
                    return $this->render('form', ['model' => $diff], [
                        'PageTitle' => $title,
                        'MainTitle' => $title,
                        'MessageText' => $message,
                        'MessageClass' => 'danger'
                    ]);
                }
            } else
                return $this->render('form', ['model' => $diff], [
                    'PageTitle' => $title,
                    'MainTitle' => $title,
                ]);
        }
    }

    public function actionDelete()
    {
        $title = 'Видалення публікації';
        $id = $_GET['id'];
        if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
            if ($this->diffModel->DeleteDiff($id))
                header('Location: /diff/');
            else {
                return $this->renderMessage('error', 'Помилка видалення публікації', null,
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title,]);
            }
        }
        $diff = $this->diffModel->GetDiffById($id);
        return $this->render('delete', ['model' => $diff], [
            'PageTitle' => $title,
            'MainTitle' => $title,
        ]);
    }
    /**
     * Відображення списку публікацій
     */
    public function actionList()
    {

    }
}