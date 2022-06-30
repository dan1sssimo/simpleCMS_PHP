<?php

namespace models;

class SerchNews
{
    public function actionSearch($search)
    {
        if (!empty($search['search']))
            $strSearch = "title LIKE '%{$search['search']}%' COLLATE utf8_general_ci";
        else
            $strSearch = null;
        return \core\Core::getInstance()->getDB()->select('news', '*', $strSearch);
    }
}