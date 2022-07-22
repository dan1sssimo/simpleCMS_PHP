<?php

namespace models;
use core\Utils;

class Diff extends \core\Model
{
    public function AddDiff($row)
    {
        $userModel = new \models\Users();
        $user = $userModel->GetCurrentUser();
        if ($user == null) {
            $result = [
                'error' => true,
                'messages' => ['Користувач не аунтефікований']
            ];
            return $result;
        }
        $validateResult = $this->Validate($row);
        if (is_array($validateResult)) {
            $result = [
                'error' => true,
                'messages' => $validateResult
            ];
            return $result;
        }
        $fields = ['title', 'short_text', 'text'];
        $RowFiltered = Utils::ArrayFilter($row, $fields);
        $RowFiltered['datetime'] = date('Y-m-d H:i:s');
        $RowFiltered['user_id'] = $user['id'];
        $id = \core\Core::getInstance()->getDB()->insert('difftext', $RowFiltered);
        return [
            'error' => false,
            'id' => $id
        ];
    }

    public function GetLastDiff($count)
    {
        return \core\Core::getInstance()->getDB()->select('difftext', '*', null, ['datetime' => 'DESC'], $count);
    }

    public function Validate($row)
    {
        $errors = [];
        if (empty($row['title']))
            $errors[] = 'Поле "Заголовок публікації" не може бути порожнім';
        if (empty($row['short_text']))
            $errors[] = 'Поле "Короткий текст публікації" не може бути порожнім';
        if (empty($row['text']))
            $errors[] = 'Поле "Повний текст публікації" не може бути порожнім';
        if (count($errors) > 0)
            return $errors;
        else
            return true;
    }

    public function GetDiffById($id)
    {
        $diff = \core\Core::getInstance()->getDB()->select('difftext', '*', ['id' => $id]);
        if (!empty($diff))
            return $diff[0];
        else
            return null;
    }

    public function UpdateDiff($row, $id)
    {
        $userModel = new \models\Users();
        $user = $userModel->GetCurrentUser();
        if ($user == null)
            return false;
        $validateResult = $this->Validate($row);
        if (is_array($validateResult))
            return $validateResult;
        $fields = ['title', 'short_text', 'text'];
        $RowFiltered = Utils::ArrayFilter($row, $fields);
        $RowFiltered['datetime_lastedit'] = date('Y-m-d H:i:s');
        \core\Core::getInstance()->getDB()->update('difftext', $RowFiltered, ['id' => $id]);
        return true;
    }

    public function DeleteDiff($id)
    {
        $diff = $this->GetDiffById($id);
        $userModel = new \models\Users();
        $user = $userModel->GetCurrentUser();
        if ($user['id'] == $diff['user_id'] || $user['access'] == 1) {
            \core\Core::getInstance()->getDB()->delete('difftext', ['id' => $id]);
            return true;
        } else
            return false;
    }
}