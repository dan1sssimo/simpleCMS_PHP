<?php

namespace controllers;

use core\Controller;

class Users extends Controller
{
    protected $usersModel;

    function __construct()
    {
        $this->usersModel = new \models\Users();
    }

    public
    function actionDelete()
    {
        if ($this->usersModel->GetCurrentUser()['access'] != 1)
            return $this->renderMessage('error', 'Помилка доступу.', null);
        else {
            $title = 'Видалення користувача';
            $id = $_GET['id'];
            if ($this->usersModel->GetCurrentUser()['id'] == $id)
                return $this->renderMessage('error', 'Помилка видалення користувача', null,
                    [
                        'PageTitle' => $title,
                        'MainTitle' => $title,]);
            if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
                if ($this->usersModel->DeleteUser($id))
                    header('Location: /users/deleteUser');
                else {
                    return $this->renderMessage('error', 'Помилка видалення користувача', null,
                        [
                            'PageTitle' => $title,
                            'MainTitle' => $title,]);
                }
            }
            $user1 = $this->usersModel->GetUserById($id);
            return $this->render('delete', ['lastUsers' => $user1], [
                'PageTitle' => $title,
                'MainTitle' => $title,
            ]);
        }
    }

    public function actionDeleteUser()
    {
        if ($this->usersModel->GetCurrentUser()['access'] != 1)
            return $this->renderMessage('error', 'Помилка доступу.', null);
        else {
            $user1 = $this->usersModel->GetUsers();
            $title = 'Видалення користувачів';
            if (!isset($_SESSION['user']))
                return $this->renderMessage('error', 'Ви не увійшли на сайт.', null);
            $params = [
                'PageTitle' => $title,
                'MainTitle' => $title,
            ];
            return $this->render('deleteUser', ['lastUsers' => $user1], $params);
        }
    }

    public function actionExitAdmin()
    {
        if ($this->usersModel->GetCurrentUser()['access'] != 1)
            return $this->renderMessage('error', 'Помилка доступу.', null);
        else
            if (!isset($_SESSION['user']))
                return $this->renderMessage('error', 'Ви не увійшли на сайт.', null);
            else {
                $title = 'Вихід з адмінки';
                if ($this->isPost()) {
                    $login = $this->usersModel->GetCurrentUser()['login'];
                    $result = $this->usersModel->ExitAdm($_POST, $login);
                    if ($result === true) {
                        {
                            unset($_SESSION['user']);
                            return $this->renderMessage('ok', 'Ви успішно вийшли з адмінки', null, [
                                    'PageTitle' => $title,
                                    'MainTitle' => $title,
                                ]
                            );
                        }
                    }
                } else {
                    $params = [
                        'PageTitle' => $title,
                        'MainTitle' => $title,
                    ];
                    return $this->render('exitAdmin', null, $params);
                }
            }
    }

    public function actionEdit()
    {
        $title = 'Особистий кабінет';
        if (!isset($_SESSION['user']))
            return $this->renderMessage('error', 'Ви не увійшли на сайт.', null);
        $params = [
            'PageTitle' => $title,
            'MainTitle' => $title,
        ];
        return $this->render('edit', null, $params);
    }

    public function actionEditPass()
    {
        if (!isset($_SESSION['user']))
            return $this->renderMessage('error', 'Ви не увійшли на сайт.', null);
        else {
            $title = 'Зміна пароля';
            if ($this->isPost()) {
                $login = $this->usersModel->GetCurrentUser()['login'];
                $result = $this->usersModel->ChangePassword($_POST, $login);
                if ($result === true) {
                    {
                        unset($_SESSION['user']);
                        return $this->renderMessage('ok', 'Дані змінено, увійдіть в аккаунт ще раз', null, [
                                'PageTitle' => $title,
                                'MainTitle' => $title,
                            ]
                        );
                    }
                } else {
                    $message = implode('<br/>', $result);
                    return $this->render('editPass', null, [
                        'PageTitle' => $title,
                        'MainTitle' => $title,
                        'MessageText' => $message,
                        'MessageClass' => 'danger'
                    ]);
                }
            } else {
                $params = [
                    'PageTitle' => $title,
                    'MainTitle' => $title,
                ];
                return $this->render('editPass', null, $params);
            }
        }
    }

    public function actionEditName()
    {
        if (!isset($_SESSION['user']))
            return $this->renderMessage('error', 'Ви не увійшли на сайт.', null);
        else {
            $title = 'Зміна особистих даних';
            if ($this->isPost()) {
                $login = $this->usersModel->GetCurrentUser()['login'];
                $result = $this->usersModel->ChangeName($_POST, $login);
                if ($result === true) {
                    {
                        unset($_SESSION['user']);
                        return $this->renderMessage('ok', 'Дані змінено, увійдіть в аккаунт ще раз', null, [
                                'PageTitle' => $title,
                                'MainTitle' => $title,
                            ]
                        );
                    }
                } else {
                    $message = implode('<br/>', $result);
                    return $this->render('editName', null, [
                        'PageTitle' => $title,
                        'MainTitle' => $title,
                        'MessageText' => $message,
                        'MessageClass' => 'danger'
                    ]);
                }
            } else {
                $params = [
                    'PageTitle' => $title,
                    'MainTitle' => $title,
                ];
                return $this->render('editName', null, $params);
            }
        }
    }

    public function actionLogout()
    {
        $title = 'Вихід з сайту';
        unset($_SESSION['user']);
        return $this->renderMessage('ok', 'Ви вийшли з Вашого аккаунту.', null, [
            'PageTitle' => $title,
            'MainTitle' => $title,]);
    }

    public function actionLogin()
    {
        $title = 'Вхід на сайт';
        if (isset($_SESSION['user']))
            return $this->renderMessage('ok', 'Ви вже увійшли на сайт.', null);
        if ($this->isPost()) {
            $user = $this->usersModel->AuthUser($_POST['login'], $_POST['password']);
            if (!empty($user)) {
                $_SESSION['user'] = $user;
                return $this->renderMessage('ok', 'Ви успішно увійшли на сайт', null, [
                    'PageTitle' => $title,
                    'MainTitle' => $title,]);
            } else {
                return $this->render('login', null, [
                    'PageTitle' => $title,
                    'MainTitle' => $title,
                    'MessageText' => 'Неправильний логін або пароль',
                    'MessageClass' => 'danger'
                ]);
            }
        } else {
            $params = [
                'PageTitle' => $title,
                'MainTitle' => $title,
            ];
            return $this->render('login', null, $params);
        }
    }

    public function actionRegister()
    {
        if ($this->isPost()) {

            $result = $this->usersModel->AddUser($_POST);
            if ($result === true) {
                {
                    return $this->renderMessage('ok', 'Користувач успішно зареєстрований!', null, [
                            'PageTitle' => 'Реєстрація на сайті',
                            'MainTitle' => 'Реєстрація на сайті',
                        ]
                    );
                }
            } else {
                $message = implode('<br/>', $result);
                return $this->render('register', null, [
                    'PageTitle' => 'Реєстрація на сайті',
                    'MainTitle' => 'Реєстрація на сайті',
                    'MessageText' => $message,
                    'MessageClass' => 'danger'
                ]);
            }
        } else {
            $params = [
                'PageTitle' => 'Реєстрація на сайті',
                'MainTitle' => 'Реєстрація на сайті',
            ];
            return $this->render('register', null, $params);
        }
    }
}