<?php

namespace controllers;

use core\Controller;

class Site extends Controller
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

    public function actionIndex()
    {
        global $Config;
        $title = 'Головна сторінка';
        if (empty($_POST)) {
            $lastNews = $this->newsModel->GetLastNews($Config['NewsCount2']);
        } else {
            $lastNews = $this->filtersModel->actionSearch($_POST);
        }
        return $this->render('index', ['lastNews' => $lastNews], [
            'PageTitle' => $title,
            'MainTitle' => $title,
        ]);
    }
}