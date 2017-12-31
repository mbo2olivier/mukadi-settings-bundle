<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 31/12/2017
 * Time: 17:14
 */

namespace Mukadi\SettingsBundle\Types;

use Mukadi\SettingsBundle\Model\ParamManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;

abstract class ParamType implements ParamManagerInterface,DataTransformerInterface{

    /**
     * @var array
     */
    protected $options;

    function __construct()
    {
        $this->options = [];
    }


    abstract public function getFormType();

    /**
     * @param array $options
     */
    public function configure(array $options){
        $this->options = $options;
    }

    /**
     * @return array
     */
    public function getOptions(){
        return $this->options;
    }

} 