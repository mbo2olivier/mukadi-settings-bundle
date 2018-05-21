<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 31/12/2017
 * Time: 17:27
 */

namespace Mukadi\SettingsBundle\Types;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType as FType;

class ChoiceType extends TextType{

    public function getFormType()
    {
        return FType::class;
    }

    public function configure(array $options)
    {
        if(isset($options['choices'])) {
            $choices = $options['choices'];
            $choices = substr($choices,1);
            $choices = substr($choices,0,strlen($choices)-1);
            $choices = explode(",",$choices);
            $c=[];
            foreach ($choices as $v) {
                if(preg_match("#:#",$v)){
                    $v = explode(":",$v);
                    $key = array_shift($v);
                    $label = array_shift($v);
                    $c[$label] = $key;
                }else{
                    $c[$v] = $v;
                }
            }
            $choices = $c;
        }else{
            $choices = [];
        }
        $options['choices'] = $choices;
        parent::configure($options);
    }

}