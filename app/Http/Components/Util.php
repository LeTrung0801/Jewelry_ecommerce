<?php

namespace App\Http\Components;
use App\Models\Category;
use App\Models\Collection;
use App\Models\City;
use App\Models\District;
use App\Models\Ward;
use App\Models\Payment;

class Util
{
    public static function getCat(){
        return Category::all()->pluck('cat_name', 'cat_id')->toArray();
    }

    public static function getCol(){
        return Collection::all()->pluck('collect_name', 'collect_id')->toArray();
    }

    public static function getCity(){
        return City::all()->pluck('name', 'matp')->toArray();
    }
    public static function getDistrict(){
        return District::all()->pluck('name', 'maqh')->toArray();
    }
    public static function getWard(){
        return Ward::all()->pluck('name', 'xaid')->toArray();
    }

    public static function getPayment(){
        return Payment::all()->pluck('p_name', 'p_id')->toArray();
    }

    public static function getImg($path){
        $imgs = [];
        if ($handle = opendir($path)) {

            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    array_push($imgs, $entry);
                }
            }
            closedir($handle);
        }
        return $imgs;
    }

    public static function unlinkFile($path, $namefile){
        if ($handle = opendir($path)) {

            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    if (current(explode('.',$entry)) == $namefile ) {
                        unlink($path.'/'.$entry);
                    }
                }
            }
            closedir($handle);
        }
    }

    public static function changeCharset($argv, $isImport = false)
    {
        $tmp = [];
        foreach ($argv as $value) {
            if (!$isImport) {
                $value = mb_convert_encoding($value, "Shift-JIS", "UTF-8");
            } else {
                $value = mb_convert_encoding($value, "UTF-8", "Shift-JIS");
            }
            array_push($tmp, $value);
        }
        return $tmp;
    }
}
