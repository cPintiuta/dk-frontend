<?php

declare(strict_types=1);

namespace Frontend\User\Fieldset;

use Laminas\Form\Element\File;
use Laminas\Form\Fieldset;

/**
 * Class AvatarFieldset
 * @package Frontend\User\Fieldset
 */
class AvatarFieldset extends Fieldset
{
    /**
     * AvatarFieldset constructor.
     * @param null $name
     * @param array $options
     */
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);
    }

    public function init()
    {
        parent::init();

        $this->add([
            'name' => 'image',
            'attributes' => [
                'class' => 'img-input',
                'name' => 'image',
            ],
            'type' => File::class
        ]);
    }
}
