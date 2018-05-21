<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 31/12/2017
 * Time: 17:25
 */

namespace Mukadi\SettingsBundle\Types;

use Symfony\Component\Form\Extension\Core\Type\NumberType as FType;

class NumberType extends ParamType{

    public function transform($value)
    {
        return (double) $value;
    }


    public function reverseTransform($value)
    {
        return $value;
    }

    /**
     * @param string $value
     * @return mixed
     */
    public function processValue($value)
    {
        return (double) $value;
    }

    public function getFormType()
    {
        return FType::class;
    }

}