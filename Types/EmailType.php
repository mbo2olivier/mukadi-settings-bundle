<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 31/12/2017
 * Time: 17:24
 */

namespace Mukadi\SettingsBundle\Types;

use Symfony\Component\Form\Extension\Core\Type\EmailType as FType;

class EmailType extends TextType{

    public function getFormType()
    {
        return FType::class;
    }
} 