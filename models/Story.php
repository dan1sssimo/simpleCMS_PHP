<?php

namespace models;

use core\Utils;

class Story extends \core\Model
{
    public function AddStory($row)
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
        $id = \core\Core::getInstance()->getDB()->insert('story', $RowFiltered);
        return [
            'error' => false,
            'id' => $id
        ];
    }

    public function GetLastStory($count)
    {
        return \core\Core::getInstance()->getDB()->select('story', '*', null, ['datetime' => 'DESC'], $count);
    }

    public function Validate($row)
    {
        $errors = [];
        if (empty($row['title']))
            $errors[] = 'Поле "Заголовок історії" не може бути порожнім';
        if (empty($row['short_text']))
            $errors[] = 'Поле "Короткий текст історії" не може бути порожнім';
        if (empty($row['text']))
            $errors[] = 'Поле "Повний текст історії" не може бути порожнім';
        if (count($errors) > 0)
            return $errors;
        else
            return true;
    }

    public function GetStoryById($id)
    {
        $story = \core\Core::getInstance()->getDB()->select('story', '*', ['id' => $id]);
        if (!empty($story))
            return $story[0];
        else
            return null;
    }

    public function UpdateStory($row, $id)
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
        \core\Core::getInstance()->getDB()->update('story', $RowFiltered, ['id' => $id]);
        return true;
    }

    public function DeleteStory($id)
    {
        $story = $this->GetStoryById($id);
        $userModel = new \models\Users();
        $user = $userModel->GetCurrentUser();
        if ($user['id'] == $story['user_id'] || $user['access'] == 1) {
            \core\Core::getInstance()->getDB()->delete('story', ['id' => $id]);
            return true;
        } else
            return false;
    }
}