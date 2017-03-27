<?php
ini_set('default_charset', 'utf-8');
/**
* 
*/
class MakeArrays
{
    public $clid;
    public $perid;
    public $wind;

    private $_config;


    /**
    * В конструкторе включаем файл config.php и присваиваем его $_config
    */
    public function __construct()
    {
        include dirname(__FILE__) . '/config.php';
        $this->_config = $config;
    }
    /**
    * Метод для добавления нулей в зависимости от разрядности числа
    *
    * @param string &$elem 
    * @param int $k
    * @param int $i 
    */
    public function addZero(&$elem,$k,$i)
    {
        if(is_numeric($elem)){
            $elem = $this->_config['voice_path'] . $this->_config['voice'] . "/" . str_pad($elem, $i - $k, '0') . "." . $this->_config['extension'];
            $i--;
            } else {
            $elem = $this->_config['voice_path'] . $this->_config['voice'] . "/" . $elem . "." . $this->_config['extension'];
            }
    }
    /**
    * Метод проверки существования файла по пути указанному в каждом элементе массива
    *
    * @param array $array массив для проверки
    * @return array $result_arr массив с null вместо несуществующих путей
    */
    public function checkPath($array)
    {
        $result_arr = [];
        foreach ($array as $item) {
            if(file_exists($item)){
                array_push($result_arr, $item);
            } else {
                array_push($result_arr, null);;
            }
            }
        return $result_arr;
    }
    /**
    * Метод создания массива из строки с выделением каждого элемента строки
    *
    * @param string $str_name имя строки которую превратим в массив
    * @param string $arr_name массив имя массива который хотим получить
    * @return array $arr_name массив из элементов строки
    */
    public function makeArr($str_name,$arr_name)
    {
        $arr_name = preg_split("//u",$str_name,null, PREG_SPLIT_NO_EMPTY);
    //$arr_name = preg_split("//", $str_name,null,PREG_SPLIT_NO_EMPTY);
        array_walk($arr_name, function(&$elem,$k,$i){
        $this->addZero($elem,$k,$i);
        }, count($arr_name));
        return $arr_name;
    }
    /**
    * Метод формирующий путь к гонгу
    *
    * @return string $gong путь к гонгу
    * @return null если файла не существует
    */
    public function getGong()
    {
        $gong = $this->_config['voice_path'] . $this->_config['gong_path'] . $this->_config['gong'] . "." . $this->_config['extension'];
        if(file_exists($gong)){
            return $gong;
        } else {
            return null;
        }
    }
    /**
    * Метод формирующий путь к номеру
    *
    * @return string $num путь к файлу номер
    * @return null если файла не существует
    */
    public function getNum()
    {
        $num = $this->_config['voice_path'] . $this->_config['voice'] . "/" . $this->_config['nomer'] . "." . $this->_config['extension'];
        if(file_exists($num)){
            return $num;
        } else {
            return null;
        }
    }
    /**
    * Метод формирующий путь к файлу подойдите
    *
    * @return string $proydite путь к файлу подойдите
    * @return null если файла не существует
    */
    public function getProydite()
    {
        $proydite = $this->_config['voice_path'] . $this->_config['voice'] . "/" . $this->_config['proydite_v_okno'] . "." . $this->_config['extension'];
        if(file_exists($proydite)){
            return $proydite;
        } else {
            return null;
        }
    }
    /**
    * Метод формирования массива по id клиента
    *
    * @param string $clid имя строки которую превратим в массив
    * @return array результат метода checkPath
    */
    public function getArrayClid($clid)
    {
        $array_clid = $this->makeArr($clid,$array_clid);
        return $this->checkPath($array_clid);
    }
    /**
    * Метод формирования массива по id принимающего
    *
    * @param string $perid имя строки которую превратим в массив
    * @return array результат метода checkPath
    */
    public function getArrayPerid($perid)
    {
        $array_perid = $this->makeArr($perid,$array_perid);
        return $this->checkPath($array_perid);
    }
    /**
    * Метод формирования массива по третьему параметру
    *
    * @param string $wind имя строки которую превратим в массив
    * @return array результат метода checkPath
    * @return null если параметр не указан
    */
    public function getArrayWind($wind)
    {
        if(!empty($wind)){
            $array_wind = $this->makeArr($wind,$array_wind);
            return $this->checkPath($array_wind);
        } else {
            return null;
        }
    }
    /**
    * Метод возвращающий массив со всеми данными
    *
    * @return array массив из всех данных
    * @return null если данные не получены
    */
    public function getResult()
    {
        if(!empty($_GET['clid']) && !empty($_GET['perid'])){
            $clid = $_GET['clid'];
            $perid = $_GET['perid'];
            $wind = $_GET['wind'];
            $result = [
                $this->getGong(),
                $this->getNum(),
                $this->getArrayClid($clid),
                $this->getProydite(),
                $this->getArrayPerid($perid),
                $this->getArrayWind($wind),
            ];
            return $result;
        } else {
            return null;
        }
    }
} 
