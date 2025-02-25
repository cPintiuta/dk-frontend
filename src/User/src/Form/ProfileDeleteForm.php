<?php

declare(strict_types=1);

namespace Frontend\User\Form;

use Frontend\User\Entity\User;
use Frontend\User\InputFilter\ProfileDeleteInputFilter;
use Laminas\Form\Element\Submit;
use Laminas\Form\Form;
use Laminas\InputFilter\InputFilterInterface;

/**
 * Class ProfileDeleteForm
 * @package Frontend\User\Form
 */
class ProfileDeleteForm extends Form
{
    protected InputFilterInterface $inputFilter;

    /**
     * ProfileDeleteForm constructor.
     * @param null $name
     * @param array $options
     */
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->init();

        $this->inputFilter = new ProfileDeleteInputFilter();
        $this->inputFilter->init();
    }

    public function init()
    {
        parent::init();

        $this->add([
            'name' => 'isDeleted',
            'type' => 'checkbox',
            'attributes' => [
                'class' => 'tooltips',
                'data-toggle' => 'tooltip',
                'title' => 'Delete account',
            ],
            'options' => [
                'label' => 'I want to delete account',
                'use_hidden_element' => true,
                'checked_value' => (string)User::IS_DELETED_YES,
                'unchecked_value' => (string)User::IS_DELETED_NO,
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'attributes' => [
                'type' => 'submit',
                'value' => 'Delete'
            ],
            'type' => Submit::class
        ]);
    }

    /**
     * @return InputFilterInterface
     */
    public function getInputFilter(): InputFilterInterface
    {
        return $this->inputFilter;
    }
}
