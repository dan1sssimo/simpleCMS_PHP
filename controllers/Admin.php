<?php

namespace controllers;

use core\Controller;

class Admin extends Users
{
    protected $adminModel;
    protected $usersModel;

    function __construct()
    {
        $this->adminModel = new \models\Admin();
        $this->usersModel = new \models\Users();
    }

    public
    function actionIndex()
    {
        $title = 'Панель адміністратора';
        $params = [
            'PageTitle' => $title,
            'MainTitle' => $title,
        ];
        if ($this->usersModel->GetCurrentUser()['access'] != 0)
            return $this->renderMessage('error', 'Помилка доступу.', null);
        if ($this->usersModel->GetCurrentUser()['access'] != 1) {
            if (!isset($_SESSION['user']))
                return $this->renderMessage('error', 'Ви не увійшли на сайт.', null);
            else {
                if ($this->isPost()) {
                    $login = $this->usersModel->GetCurrentUser()['login'];
                    $result = $this->adminModel->CheckAdm($_POST, $login);
                    if ($result === true) {
                        {
                            unset($_SESSION['user']);
                            return $this->renderMessage('ok', 'Ви успішно увійшли у систему адміністрування', null, [
                                    'PageTitle' => $title,
                                    'MainTitle' => $title,
                                ]
                            );
                        }
                    } else {
                        $message = implode('<br/>', $result);
                        return $this->render('index', null, [
                            'PageTitle' => $title,
                            'MainTitle' => $title,
                            'MessageText' => $message,
                            'MessageClass' => 'danger'
                        ]);
                    }
                } else {
                    return $this->render('index', null, $params);
                }
            }
        } else {
            return $this->render('mainpanel', null, [
                'PageTitle' => $title,
                'MainTitle' => $title,
            ]);
        }
    }
}