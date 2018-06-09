<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 31/12/2017
 * Time: 17:24
 */

namespace Mukadi\SettingsBundle\Types;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType as FType;
use Mukadi\SettingsBundle\Utils\Interpretor;

class DateTimeType extends ParamType{
    
    const INTERNAL_FORMAT = "Y-m-d H:i:s";
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
        return ($value)? new \DateTime($value): null;
    }

    public function reverseTransform($value)
    {
        return $value->format(self::INTERNAL_FORMAT);
    }

    public function configure(array $options){
        $fields = ['days','hours','minutes','months','seconds','years'];
        foreach($options as $key => $option){
            if(is_string($option) && in_array($key,$fields)){
                if(Interpretor::isRange($option)){
                    $options[$key] = Interpretor::range($option);
                }else if(Interpretor::isArray($option)){
                    $options[$key] = Interpretor::getArray($option);
                }
            }
        }
        parent::configure($options);
    }
} 