<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 31/12/2017
 * Time: 17:12
 */

namespace Mukadi\SettingsBundle\Model;


interface ParamManagerInterface {
    /**
     * @param string $value
     * @return mixed
     */
    public function processValue($value);
} 