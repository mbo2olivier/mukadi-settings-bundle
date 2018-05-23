<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 31/12/2017
 * Time: 17:16
 */

namespace Mukadi\SettingsBundle\Types;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType as FType;

class ToggleType extends ParamType{

    /**
     * @param string $value
     * @return mixed
     */
    public function processValue($value)
    {
        return $this->transform($value);
    }

    public function getFormType()
    {
        return FType::class;
    }

    public function transform($value)
    {
        return (bool)$value;
    }

    public function reverseTransform($value)
    {
        return (int)$value;
    }

} 