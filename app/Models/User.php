<?php


namespace App\Models;

use \App\Services\Call;

class User extends BaseModel
{

    public static function getUsersReports()
    {
        $users = self::selectWhereArray();
        $calls = new Call();

        foreach ($users as $user){
            $user->fields['totalCountCalls'] = $calls->getTotalCount($user->id);
            $user->fields['totalDurationCalls'] = $calls->getTotalDuration($user->id);

            $continentSum = $calls->getContinentSum($user->id);
            $user->fields['continentCountCalls'] = $continentSum['count'];
            $user->fields['continentDurationCalls'] = $continentSum['sum'];
        }

        return $users;
    }


    public static function selectWhereArray(){
        $calls = new Call();
        $usersArray = $calls->getUsers();

        if(!$usersArray){
            return null;
        }

        $class = get_called_class();

        $arResult = [];
        foreach ($usersArray as $key => $item){
            $arResult[] = new $class($item);
        }

        return $arResult;
    }
}