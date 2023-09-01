<?php

namespace Frontend\App\Form\Element;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\NotSupported;
use Doctrine\ORM\Mapping\Entity;
use Frontend\User\Entity\UserRole;
use Laminas\Form\Element\Select;

class EntitySelect extends Select
{
    private string $entity;

    private string $keyColumn;

    private string $valueColumn;

    private EntityManager $entityManager;

    public function setOptions(iterable $options)
    {
       parent::setOptions($options);

       if(isset($options['entity_manager'])){
           $this->setEntityManager($options['entity_manager']);
       }

       if(isset($options['entity'])){
           $this->setEntity($options['entity']);
       }

        if(isset($options['key_column'])){
            $this->setKeyColumn($options['key_column']);
        }

        if(isset($options['value_column'])){
            $this->setValueColumn($options['value_column']);
        }

       return $this;
    }

    /**
     * @throws NotSupported
     */
    public function getValueOptions(): array
    {
        $roles = $this->entityManager->getRepository($this->entity)->findAll();

        /** @var UserRole $role */
        foreach ($roles as $role){
            $role = $role->getArrayCopy();
            $this->valueOptions[$role[$this->keyColumn]] = $role[$this->valueColumn];
        }

        $this->setValueOptions($this->valueOptions);
        return $this->valueOptions;
    }

    public function getEntity(): string
    {
        return $this->entity;
    }

    public function setEntity(string $entity): void
    {
        $this->entity = $entity;
    }

    /**
     * @return string
     */
    public function getKeyColumn(): string
    {
        return $this->keyColumn;
    }

    /**
     * @param string $keyColumn
     */
    public function setKeyColumn(string $keyColumn): void
    {
        $this->keyColumn = $keyColumn;
    }

    /**
     * @return string
     */
    public function getValueColumn(): string
    {
        return $this->valueColumn;
    }

    /**
     * @param string $valueColumn
     */
    public function setValueColumn(string $valueColumn): void
    {
        $this->valueColumn = $valueColumn;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager): void
    {
        $this->entityManager = $entityManager;
    }

}
