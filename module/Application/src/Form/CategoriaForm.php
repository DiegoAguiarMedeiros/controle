<?php

namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class CategoriaForm extends Form
{
    public function __construct($name)
    {
        parent::__construct($name);

        $this->add([
            'name' => 'nome',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Nome:',
            ],
        ]);

        $this->add([
            'name' => 'send',
            'type'  => Element\Submit::class,
            'attributes' => [
                'value' => 'Enviar',
            ],
        ]);
    }
}
