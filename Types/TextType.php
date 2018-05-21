<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 31/12/2017
 * Time: 17:16
 */

namespace Mukadi\SettingsBundle\Types;

use Symfony\Component\Form\Extension\Core\Type\TextType as FType;

class TextType extends ParamType{

    /**
     * @param string $value
     * @return mixed
     */
    public function processValue($value)
    {
        return (string)$value;
    }

    public function getFormType()
    {
        return FType::class;
    }

    public function transform($value)
    {
        return (string)$value;
    }

    public function reverseTransform($value)
    {
        return (string)$value;
    }

} 