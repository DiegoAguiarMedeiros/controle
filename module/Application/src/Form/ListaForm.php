<?php

namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class ListaForm extends Form
{
    public function __construct($name)
    {
        parent::__construct($name);

        $this->add([
            'name' => 'quantidade',
            'type' => Element\Number::class,
            'options' => [
                'label' => 'Quantidade:',
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
