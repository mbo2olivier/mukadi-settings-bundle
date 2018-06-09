<?php

namespace Mukadi\SettingsBundle\Utils;

class Interpretor
{
    /**
     * @return bool
     */
    public function isArray($value){
        return preg_match('/^\(.+\)$/',$value);
    }
    /**
     * @return array
     */
    public static function getArray($choices){
        if(!self::isArray($choices))
            return [];
        $choices = substr($choices,1);
        $choices = substr($choices,0,strlen($choices)-1);
        $choices = explode(",",$choices);
        $c=[];
        foreach ($choices as $v) {
            if(preg_match("#:#",$v)){
                $v = explode(":",$v);
                $key = array_shift($v);
                $label = array_shift($v);
                $c[$label] = $key;
            }else{
                $c[$v] = $v;
            }
        }
        return $c;
    }
    /**
     * @return bool
     */
    public function isRange($value){
        return preg_match("/^\[([0-9]+)-([0-9]+)(,([0-9]+)){0,1}\]$/",$value);
    }
    /**
     * @return array
     */
    public static function range($value){
        $d = [];
        if(preg_match("/^\[([0-9]+)-([0-9]+)(,([0-9]+)){0,1}\]$/",$value,$d)){
            $l = count($d);
            if($l === 5){
                return range($d[1],$d[2],$d[4]);
            }else if($l === 3){
                return range($d[1],$d[2]);
            }
        }
        return [];
    }
}
