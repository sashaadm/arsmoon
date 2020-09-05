<?php


namespace App\Services;


class CountryInfo
{
    /**
     * @var array
     */
    private static $continent_codes = ['AF', 'AN', 'AS', 'EU', 'NA', 'OC', 'SA'];


    /**
     * @medthod parse txt file
     * @return array
     */
    private static function parseDB()
    {
        $filePath = $_SERVER['DOCUMENT_ROOT'].'/storage/countryinfo.txt';

        $arr = [];

        if (file_exists($filePath)) {
            $row = 1;

            if (($handle = fopen($filePath, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                    $num = count($data);
                    $row++;
                    for ($c = 0; $c < $num; $c++) {
                        $r = $data[$c];
                        $lineArray = explode("\t", $r);
                        $arr[] = $lineArray;
                    }
                }
                fclose($handle);
            }
        }

        return $arr;
    }


    /**
     * @param $phoneNumber
     * @return bool|string
     */
    public static function getContinent($phoneNumber)
    {
        $arrDB = self::parseDB();

        if($arrDB) {

            foreach ($arrDB as $item) {
                $continent = '';
                foreach ($item as $item2) {
                    if ($item2) {
                        if (!$continent) {
                            if (in_array($item2, self::$continent_codes)) {
                                $continent = $item2;
                                continue;
                            } else {
                                continue;
                            }
                        } else {
                            $pos = strpos($phoneNumber, $item2);

                            if ($pos === 0) {
                                return $continent;
                            }

                        }
                    }
                }
            }

        }

        return false;
    }


}