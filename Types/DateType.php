<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 31/12/2017
 * Time: 17:24
 */

namespace Mukadi\SettingsBundle\Types;

use Symfony\Component\Form\Extension\Core\Type\DateType as FType;

class DateType extends DateTimeType{
    
    const INTERNAL_FORMAT = "Y-m-d";

    public function getFormType()
    {
        return FType::class;
    }

} 