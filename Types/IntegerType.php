<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 31/12/2017
 * Time: 17:26
 */

namespace Mukadi\SettingsBundle\Types;

use Symfony\Component\Form\Extension\Core\Type\IntegerType as FType;

class IntegerType extends ParamType{

    public function transform($value)
    {
        return (integer) $value;
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
        return (integer) $value;
    }

    public function getFormType()
    {
        return FType::class;
    }

} 