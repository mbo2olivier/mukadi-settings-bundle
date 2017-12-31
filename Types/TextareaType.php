<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 31/12/2017
 * Time: 17:24
 */

namespace Mukadi\SettingsBundle\Types;


class TextareaType extends TextType{

    public function getFormType()
    {
        return 'Symfony\Component\Form\Extension\Core\Type\TextareaType';
    }
} 