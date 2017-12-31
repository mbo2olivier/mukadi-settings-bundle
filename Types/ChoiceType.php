<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 31/12/2017
 * Time: 17:27
 */

namespace Mukadi\SettingsBundle\Types;


class ChoiceType extends TextType{

    public function getFormType()
    {
        return 'Symfony\Component\Form\Extension\Core\Type\ChoiceType';
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
                    $c[$key] = array_shift($v);
                }else{
                    $c[] = $v;
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