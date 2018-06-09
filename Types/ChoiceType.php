<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 31/12/2017
 * Time: 17:27
 */

namespace Mukadi\SettingsBundle\Types;

use Mukadi\SettingsBundle\Utils\Interpretor;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType as FType;

class ChoiceType extends TextType{

    public function getFormType()
    {
        return FType::class;
    }

    public function configure(array $options)
    {
        if(isset($options['choices'])) {
            $choices = Interpretor::getArray($options['choices']);
        }else{
            $choices = [];
        }
        $options['choices'] = $choices;
        parent::configure($options);
    }

}