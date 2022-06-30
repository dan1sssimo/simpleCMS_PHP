<?php

namespace models;

use core\Model;
use core\Utils;


class Admin extends Users
{
    public function CheckAdm($row, $login)
    {
        $userModel = new \models\Users();
        $user = $userModel->GetCurrentUser();
        if ($user == null)
            return false;
        $validateResult = $this->ValidateAdm($row);
        if (is_array($validateResult))
            return $validateResult;
        $fields = ['access'];
        $RowFiltered = Utils::ArrayFilter($row, $fields);
        \core\Core::getInstance()->getDB()->update('users', $RowFiltered, ['login' => $login]);
        return true;
    }

    public function ValidateAdm($formRow)
    {
        $errors = [];
        if (empty($formRow['password3']))
            $errors[] = 'Поле "Код доступу" не може бути порожнім';
        if ($formRow['password3'] != 'admin123')
            $errors[] = 'Код доступу не співпадає';
        if (empty($formRow['access']))
            $errors[] = 'Поле "Спеціальне значення" не може бути порожнім';
        if ($formRow['access'] != 1)
            $errors[] = 'Спеціальне значення не співпадає';
        if (count($errors) > 0)
            return $errors;
        else
            return true;
    }
}