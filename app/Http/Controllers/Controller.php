<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function return_api($status, $msg, $info = '')
    {
        $arr = array(
            'status' => $status,
            'msg' => $msg,
            'info' => $info
        );
        return $arr;
    }

    public function config_set($name, $value_array)//name为config的文件名(不带.php)，value_array为要修改的键值对
    {
        $config_file = self::config_vali($name, $value_array);
        if (!is_array($config_file)) {
            return false;
        }
        foreach ($value_array as $k => $v) {
            if (!array_key_exists($k, $config_file)) {
                unset($value_array[$k]);
            }
            if (is_numeric($v) && $k != 'badWordSymbol') {
                $value_array[$k] = $v + 0;
            }
            if ($v === true || $v === 'true') {
                $value_array[$k] = true;
            }
            if ($v === false || $v === 'false') {
                $value_array[$k] = false;
            }
        }
        $is_ass = self::is_assoc($config_file, $value_array);
        if ($is_ass) {
            $new_array = $value_array;
        } else {
            $new_array = array_merge($config_file, $value_array);
        }
        $configpath = config_path();
        $configpath = $configpath . '/' . $name . '.php';
        $info = '<?php' . "\r\n" . 'return ' . var_export($new_array, true) . ';';
        file_put_contents($configpath, $info);
        return true;
    }

    public function config_add($name, $value_array)//往某个配置文件增加键值对
    {
        $config_file = self::config_vali($name, $value_array);
        if (!is_array($config_file)) {
            return false;
        }
        $is_ass = self::is_assoc($config_file, $value_array);
        if ($is_ass) {
            $new_array = array_values(array_filter($value_array));
        } else {
            $new_array = array_merge($config_file, $value_array);
        }
        $configpath = config_path();
        $configpath = $configpath . '/' . $name . '.php';
        $info = '<?php' . "\r\n" . 'return ' . var_export($new_array, true) . ';';
        file_put_contents($configpath, $info);
        return true;
    }

    public function is_assoc($config_array, $value_array)//判断是否为索引数组
    {
        if (!is_array($config_array) || !is_array($value_array)) {
            return false;
        }
        $new_config = array_values($config_array);
        $new_value = array_values($value_array);
        if (($new_config === $config_array) && ($new_value === $value_array)) {
            return true;
        }
        return false;
    }

    public function config_vali($name, $value_array)//检测config配置合法性
    {
        if (count($value_array) < 1) {
            return false;
        }
        $config_file = config($name);
        if (empty($config_file) || !is_array($config_file)) {
            return false;
        }
        return $config_file;
    }

}
