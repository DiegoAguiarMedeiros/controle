<?php

namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Api\Model\Produto;

class EntradaSaidaEstoqueForm extends Form
{
    public function __construct($name)
    {
        parent::__construct($name);


        $produto = new Produto();
        $produtos = $produto->fetchAllNomeWithFornecedor();

        $this->add([
            'type' => Element\Select::class,
            'name' => 'produtoLista',
            'options' => [
                'label' => 'Produto: ',
                'empty_option' => 'SELECIONAR PRODUTO',
                'value_options' => $produtos
            ],
        ]);
        
        $this->add([
            'name' => 'quantidade',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Quantidade: '
            ],
        ]);

        $this->add([
            'name' => 'valor',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Valor: '
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
