<?php


namespace App\Controllers;

use App\Models\User;
use App\Services\View;

class ReportController extends Controller
{

    public static function report()
    {
        $usersReports = User::getUsersReports();

        return (new View('report', compact('usersReports')))->display();
    }
}