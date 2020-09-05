<?php


namespace App\Controllers;


use App\Services\View;

class MainController extends Controller
{
    public static function request(){
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            static::showForm();
        }elseif ($_SERVER['REQUEST_METHOD'] == 'POST'){
            static::post();
        }
    }

    public static function showForm()
    {
        return (new View('form'))->display();
    }

    public static function post(){

        if(isset($_FILES['file']) && $_FILES['file']['type'] == 'text/csv' && !$_FILES['file']['error']){

            $uploadFile = $_SERVER['DOCUMENT_ROOT'].'/storage/cdrs.csv';

            if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {

                return ReportController::report();

            }
        }

        echo 'error';
        return false;
    }
}