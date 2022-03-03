<?php

namespace Api\Model;

use Zend\Db\Sql\Sql;

class EntradaEstoque
{
    private $nome;
    private $id_medida;
    private $quantidade;
    private $id_categoria;
    private $id_produto;
    private $data_entrada;
    private $valor_unitario;

    public function __construct($id = "", $nome = "", $medida = "", $quantidade = "",  $categoria = "", $valor = "",$id_produto = "")
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->id_medida = $medida;
        $this->quantidade = $quantidade;
        $this->id_categoria = $categoria;
        $this->valor = $valor;
        $this->id_produto = $id_produto;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }
    

    public function fetchAllProdutosEntradaEstoque()
    {

        $con = new Connection();
        $adapter = $con->getAdapter();

        $selectString = "SELECT ep.qtde, ep.valor_unitario, ep.data_entrada, p.nome FROM entrada_produto ep JOIN produto p ON p.id = ep.id_produto";

        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        $produtos = array();

        foreach ($results->toArray() as $value) {
            $produto = array();
            $produto['qtde'] = $value['qtde'];
            $produto['nome'] = $value['nome'];
            $produto['data_entrada'] = $value['data_entrada'];
            $produto['valor_unitario'] = $value['valor_unitario'];
            $produtos[] = $produto;
        }
        return $produtos;
    }

    public function insert()
    {
        $con = new Connection();
        $adapter = $con->getAdapter();
        $sql = new Sql($adapter);
        $insert = $sql->insert('entrada_produto');
        $insert->values([
            'qtde' => $this->quantidade,
            'valor_unitario' => $this->valor_unitario,
            'data_entrada' => date('Y-m-d'),
            'id_produto' => $this->id_produto,
        ]);
        $insertString = $sql->buildSqlString($insert);
        $result = $adapter->query($insertString, $adapter::QUERY_MODE_EXECUTE);

        return $result->getAffectedRows();
    }
}
