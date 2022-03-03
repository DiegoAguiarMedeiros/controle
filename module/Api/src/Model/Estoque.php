<?php

namespace Api\Model;

use Zend\Db\Sql\Sql;

class Estoque
{
    private $nome;
    private $id_medida;
    private $quantidade;
    private $id_categoria;
    private $valor;

    public function __construct($id = "", $nome = "", $medida = "", $quantidade = "",  $categoria = "", $valor = "")
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->id_medida = $medida;
        $this->quantidade = $quantidade;
        $this->id_categoria = $categoria;
        $this->valor = $valor;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }
    
    public function fetchAllProdutosEmEstoque()
    {

        $con = new Connection();
        $adapter = $con->getAdapter();

        $selectString = "SELECT e.qtde, e.valor_unitario, p.nome FROM estoque e JOIN produto p ON p.id = e.id_produto";

        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        $produtos = array();

        foreach ($results->toArray() as $value) {
            $produto = array();
            $produto['qtde'] = $value['qtde'];
            $produto['nome'] = $value['nome'];
            $produto['valor_unitario'] = $value['valor_unitario'];
            $produtos[] = $produto;
        }
        return $produtos;
    }

    public function fetchAllProdutosSaidaEstoque()
    {

        $con = new Connection();
        $adapter = $con->getAdapter();

        $selectString = "SELECT sp.qtde, sp.valor_unitario, sp.data_entrada, p.nome FROM saida_produto sp JOIN produto p ON p.id = ep.id_produto";

        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        $produtos = array();

        foreach ($results->toArray() as $value) {
            $produto = array();
            $produto['qtde'] = $value['qtde'];
            $produto['nome'] = $value['nome'];
            $produto['valor_unitario'] = $value['valor_unitario'];
            $produtos[] = $produto;
        }
        return $produtos;
    }
}
