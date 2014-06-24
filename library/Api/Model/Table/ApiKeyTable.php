<?php


namespace Api\Model\Table;

use Api\Model\AbstractModel;

use Api\Container,
    Api\Factory\ModelFactory;

use Api\Database\Helper;

class ApiKeyTable implements TableInterface
{
    private
        $db;

    public
        $fields;


    public function __construct ()
    {
        $this->db = Helper::getConnection('api_db');

        $container = new Container(new ModelFactory);
        $this->fields = $container->get('ApiKeyFields');
    }


    /**
     * 新規レコードを挿入する
     *
     * @return stdClass
     * @author app2641
     **/
    public final function insert (\stdClass $params)
    {
        try {
            foreach ($params as $key => $val) {
                if (! in_array($key, $this->fields->getFields())) {
                    throw new \Exception('invalid field!');
                }
            }
            
            $sql = 'INSERT INTO apikey
                (client) VALUES (:client)';

            $this->db->state($sql, $params);

            $data = $this->fetchById($this->db->lastInsertId());
        
        } catch (\Exception $e) {
            throw $e;
        }

        return $data;
    }



    /**
     * 指定モデルの情報でレコードを上書きする
     *
     * @return stdClass
     * @author app2641
     **/
    public final function update (AbstractModel $model)
    {
        try {
            $record = $model->getRecord();
        
        } catch (\Exception $e) {
            throw $e;
        }
    }



    /**
     * 指定モデルのレコードを削除する
     *
     * @return boolean
     * @author app2641
     **/
    public final function delete (AbstractModel $model)
    {
        try {
            $sql = 'DELETE FROM apikey
                WHERE apikey.id = ?';

            $this->db->state($sql, $model->get('id'));
        
        } catch (\Exception $e) {
            throw $e;
        }
    }



    /**
     * 指定idのレコードをテーブルから取得するする
     *
     * @return stdClass
     * @author app2641
     **/
    public final function fetchById ($id)
    {
        try {
            $sql = 'SELECT * FROM apikey
                WHERE apikey.id = ?';

            $result = $this->db
                ->state($sql, $id)->fetch();
        
        } catch (\Exception $e) {
            throw $e;
        }

        return $result;
    }



    /**
     * レコードをすべて取得する
     *
     * @author suguru
     **/
    public function fetchAll ()
    {
        try {
            $sql = 'SELECT * FROM apikey
                ORDER BY apikey.id DESC';

            $results = $this->db->state($sql)->fetchAll();
        
        } catch (\Exception $e) {
            throw $e;
        }

        return $results;
    }



    /**
     * 指定keyがレコードを取得する
     *
     * @author app2641
     **/
    public function fetchByApiKey ($key)
    {
        try {
            $sql = 'SELECT * FROM apikey
                WHERE apikey.key = ?';

            $result = $this->db
                ->state($sql, $key)->fetch();
        
        } catch (\Exception $e) {
            throw $e;
        }

        return $result;
    }



    /**
     * クライアント名からレコードを取得する
     *
     * @author suguru
     **/
    public function fetchByClient ($client)
    {
        try {
            $sql = 'SELECT * FROM apikey
                WHERE apikey.client = ?';

            $result = $this->db
                ->state($sql, $client)->fetch();
        
        } catch (\Exception $e) {
            throw $e;
        }

        return $result;
    }



    /**
     * APIキーを更新する
     *
     * @author suguru
     **/
    public function updateApiKey ($id, $key)
    {
        try {
            $sql = 'UPDATE apikey
                SET apikey.key = ?
                WHERE apikey.id = ?';

            $this->db->state($sql, array($key, $id));
        
        } catch (\Exception $e) {
            throw $e;
        }
    }



    /**
     * APIキーをバリデートする
     *
     * @author suguru
     **/
    public function validateApiKey ($client, $key)
    {
        try {
            $sql = 'SELECT * FROM apikey
                WHERE apikey.client = ?
                AND apikey.key = ?';

            $result = $this->db
                ->state($sql, array($client, $key))->fetch();
        
        } catch (\Exception $e) {
            throw $e;
        }

        return ($result) ? true: false;
    }
}
