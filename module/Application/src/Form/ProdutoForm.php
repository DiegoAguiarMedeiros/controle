<?php

namespace Application\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Api\Model\Medida;
use Api\Model\Categoria;
use Api\Model\Fornecedor;
use Api\Model\Produto;

class ProdutoForm extends Form
{
    public function __construct($name, $fornecedor = null)
    {
        parent::__construct($name);

        $this->add([
            'name' => 'nome',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Nome:',
            ],
        ]);

        $produto = new Produto();
            $produtos = $produto->fetchAllNome(null,null,'id','ASC',$fornecedor);

        $this->add([
            'type' => Element\Select::class,
            'name' => 'produto',
            'options' => [
                'label' => 'Produto: ',
                'value_options' => $produtos
            ],
        ]);
        $this->add([
            'type' => Element\Hidden::class,
            'name' => 'fornecedorhidden',
        ]);

        $medida = new Medida();
        $medidas = $medida->fetchAll();



        $this->add([
            'type' => Element\Select::class,
            'name' => 'medida',
            'options' => [
                'label' => 'Medida: ',
                'value_options' => $medidas
            ],
        ]);
        $categoria = new Categoria();
        $categorias = $categoria->fetchAll();
        $this->add([
            'type' => Element\Select::class,
            'name' => 'categoria',
            'options' => [
                'label' => 'Categoria: ',
                'value_options' => $categorias
            ],
        ]);
        $fornecedor = new Fornecedor();
        $fornecedores = $fornecedor->fetchAll();
        $this->add([
            'type' => Element\Select::class,
            'name' => 'fornecedor',
            'options' => [
                'label' => 'Fornecedor: ',
                'value_options' => $fornecedores
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
