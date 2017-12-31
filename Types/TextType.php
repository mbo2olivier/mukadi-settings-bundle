<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 31/12/2017
 * Time: 17:16
 */

namespace Mukadi\SettingsBundle\Types;


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
        return 'Symfony\Component\Form\Extension\Core\Type\TextType';
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