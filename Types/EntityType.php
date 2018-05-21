<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 31/12/2017
 * Time: 17:29
 */

namespace Mukadi\SettingsBundle\Types;

use Symfony\Bridge\Doctrine\Form\Type\EntityType as FType;
use Doctrine\Common\Persistence\ObjectManager;

class EntityType  extends ParamType{
    /**
     * @var ObjectManager
     */
    protected $om;

    function __construct(ObjectManager $om)
    {
        parent::__construct();
        $this->om = $om;
    }

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
        if(!$value)
            return null;

        return $this->om
            ->getRepository($this->options['class'])
            ->find($value)
            ;
    }

    public function reverseTransform($value)
    {
        if(!$value)
            return null;

        return $value->getId();
    }

} 