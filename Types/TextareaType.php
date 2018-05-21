<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 31/12/2017
 * Time: 17:24
 */

namespace Mukadi\SettingsBundle\Types;

use Symfony\Component\Form\Extension\Core\Type\TextareaType as FType;

class TextareaType extends TextType{

    public function getFormType()
    {
        return FType::class;
    }
} 