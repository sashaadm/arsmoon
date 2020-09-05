<?php


namespace App\Services;

use PHPExcel_Exception;
use PHPExcel_IOFactory;
use PHPExcel_Reader_Exception;

class Call
{
    /**
     * @var array
     */
    private $calls_array = [];

    /**
     * Call constructor.
     * @param string $filePath
     * @throws PHPExcel_Exception
     */
    public function __construct($filePath='')
    {
        $this->getFileArray($filePath);
    }


    /**
     * @param string $filePath
     * @throws PHPExcel_Exception
     * @throws PHPExcel_Reader_Exception
     */
    public function getFileArray($filePath='')
    {
        if(!$filePath){
            $filePath = $_SERVER['DOCUMENT_ROOT'].'/storage/cdrs.csv';
        }

        if (file_exists($filePath)) {

            $objPHPExcel = PHPExcel_IOFactory::load($filePath);
            $worksheet = $objPHPExcel->getActiveSheet();

            foreach ($worksheet->getRowIterator() as $key => $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                foreach ($cellIterator as $key2 => $cell) {
                    if (!is_null($cell)) {
                        $this->calls_array[$key][$key2] = $cell->getValue();
                    }
                }
            }
        }
    }

    /**
     * @return array
     */
    public function getUsers()
    {
        $users = [];

        if($this->calls_array) {
            foreach ($this->calls_array as $item) {
                $id = intval($item['A']);

                if (!isset($users[$id])) {
                    $users[$id] = ['id' => $id];
                }
            }
        }

        return $users;
    }

    /**
     * @param int $user_id
     * @return array
     */
    public function getUserCalls(int $user_id)
    {
        $userCallsArr = [];

        if($this->calls_array) {
            foreach ($this->calls_array as $item){
                $id = intval($item['A']);
                if($user_id == $id){
                    $userCallsArr[] = [
                        'user_id' => $item['A'],
                        'date' => $item['B'],
                        'duration' => intval($item['C']),
                        'phone' => intval($item['D']),
                        'ip' => $item['E'],
                    ];
                }
            }
        }

        return $userCallsArr;
    }


    /**
     * @param $user_id
     * @return int
     */
    public function getTotalCount($user_id)
    {
        return count($this->getUserCalls($user_id));
    }

    /**
     * @param $user_id
     * @return int
     */
    public function getTotalDuration($user_id)
    {
        $sum = 0;
        foreach ($this->getUserCalls($user_id) as $item){
            $sum += $item['duration'];
        }

        return $sum;
    }

    /**
     * @param $user_id
     * @return array
     */
    public function getContinentSum($user_id)
    {
        $count = 0;
        $sum = 0;
        $userCalls = $this->getUserCalls($user_id);

        if($userCalls) {

            foreach ($userCalls as $item) {
                $ipService = new IPService($item['ip']);
                $continentIP = $ipService->getContinentCode();
                $continentPhone = CountryInfo::getContinent($item['phone']);

                if ($continentIP == $continentPhone) {
                    $count++;
                    $sum += $item['duration'];
                }
            }

        }

        return ['count' => $count, 'sum' => $sum];
    }
}