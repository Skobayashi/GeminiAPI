<?php


namespace Api\Model;

use Api\Container,
    Api\Factory\ModelFactory;

class ApiKeyModel extends AbstractModel
{
    public
        $table;


    public function __construct ()
    {
        $container    = new Container(new ModelFactory);
        $this->table  = $container->get('ApiKeyTable');
    }



    /**
     * APIキーを生成する
     *
     * @author suguru
     **/
    public function updateApiKey ($id, $key)
    {
        $this->table->updateApiKey($id, $key);
    }



    /**
     * 指定キーが登録されているかを確認する
     *
     * @return boolean
     * @author app2641
     **/
    public function isExistsApiKey ($key)
    {
        $record = $this->table->fetchByApiKey($key);
        return ($record) ? true: false;
    }



    /**
     * 既に登録されたクライアントかどうか
     *
     * @author suguru
     **/
    public function isExistsClient ($client)
    {
        $record = $this->table->fetchByClient($client);
        return ($record) ? true: false;
    }



    /**
     * APIキーをバリデートする
     *
     * @author suguru
     **/
    public function validateApiKey ($client, $key)
    {
        $result = $this->table->validateApiKey($client, $key);
        return $result;
    }
}
