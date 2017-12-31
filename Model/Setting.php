<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 31/12/2017
 * Time: 18:51
 */

namespace Mukadi\SettingsBundle\Model;

use Mukadi\SettingsBundle\Types\ParamType;
use Mukadi\SettingsBundle\Model\Param;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class Setting {

    /**
     * @var ObjectManager
     */
    private $om;
    /**
     * @var array
     */
    private $settings;
    /**
     * @var array
     */
    private $types;
    /**
     * @var FormFactoryInterface
     */
    private $ffactory;
    /**
     * @var string
     */
    private $class;

    public function __construct(FormFactoryInterface $ffactory,ObjectManager $om, $class, $settings = array()) {
        $this->ffactory = $ffactory;
        $this->om = $om;
        $this->class = $class;
        $this->settings = $settings;
        $this->types = array();
    }

    public function addType($alias, ParamType $type){
        $this->types[$alias] = $type;
    }

    /**
     * @param $alias
     * @return ParamType
     */
    public function getType($alias){
        if(!isset($this->types[$alias]))
            throw new \InvalidArgumentException(sprintf("Unable to find Configuration Type with alias '%s'",$alias));
        return $this->types[$alias];
    }

    public function get($key) {
        /** @var Param $p */
        $p = $this->om->getRepository($this->class)->findOneBy(["name" => $key]);
        if($p) {
            $value = $p->getValue();
            if(isset($this->settings[$key])) {
                $s = $this->settings[$key];
                $alias = $s['type'];
                $type = $this->getType($alias);
                $type->configure($s['options']);
                return $type->processValue($value);
            }else{
                return $value;
            }
        }
        return null;
    }

    protected function getRawData(){
        $data = [];
        $result = $this->om->getRepository($this->class)->findAll();
        ;
        /** @var Param $p */
        foreach ($result as $p) {
            $data[$p->getName()] = $p->getValue();
        }
        $s = array_map(function($e){
            return null;
        },$this->settings);
        return array_merge($s,$data);
    }

    public function saveData(FormInterface $form){
        $data = array_merge($this->getRawData(),(array)$form->getData());
        foreach ($data as $name => $value) {
            $construct = $this->class;
            $p  = new $construct($name,$value);
            $this->saveParam($p);
        }
    }

    private function saveParam(Param $p){
        /** @var Param $param */
        $param = $this->om->getRepository($this->class)->findOneBy(array("name" => $p->getName()));
        if($param){
            $param->setValue($p->getValue());
        }else{
            $param = $p;
        }
        $this->om->persist($param);
        $this->om->flush();
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getForm(){
        $fb = $this->ffactory
            ->createBuilder('Symfony\Component\Form\Extension\Core\Type\FormType',$this->getRawData())
            ->setMethod("POST")
        ;
        foreach ($this->settings as $key => $config) {
            $type = $config['type'];
            $paramType = $this->getType($type);
            $paramType->configure($config['options']);
            $fb->add($key,$paramType->getFormType(),$paramType->getOptions());
            $fb->get($key)->addModelTransformer($paramType);
        }

        return $fb->getForm();
    }

}