<?php

use Api\Database\Helper;

use Api\Container,
    Api\Factory\ModelFactory;

use Api\Exception\ApiException;

class IndexController extends \Zend_Controller_Action
{
    public
        $api,
        $container;

    public function init ()
    {
        $this->container = new Container(new ModelFactory);
    }



    public function indexAction()
    {
        $table = $this->container->get('ApiKeyTable');
        $this->view->results = $table->fetchAll();
    }



    /**
     * クライアントレコードを追加する
     *
     * @author suguru
     **/
    public function generateclientAction ()
    {
        try {
            $request = $this->getRequest();
            if (! $request->isPost()) {
                throw new \Exception('not PostRequest!');
            }

            $client = $request->getParam('client');

            // クライアントが既に登録されていないかどうか
            $model = $this->container->get('ApiKeyModel');
            $result = $model->isExistsClient($client);

            if ($result) {
                $this->_helper->viewRenderer->setNoRender();
                echo sprintf('<h2>%sは既に登録されているクライアントです。</h2>', $client);
                echo '<a href="/">BackPage</a>';
            }


            $params = new \stdClass;
            $params->client = $client;
            $model->insert($params);

            $this->_redirect('/');

        } catch (\Exception $e) {
            throw $e;
        }
    }




    /**
     * ApiKeyを生成する
     *
     * @author suguru
     **/
    public function generatekeyAction()
    {
        try {
            $db = Helper::getConnection('db');
            $db->beginTransaction();

            $request = $this->getRequest();

            if (! $request->isPost()) {
                throw new \Exception('not PostRequest!');
            }



            $result = true;
            $model = $this->container->get('ApiKeyModel');

            while ($result) {
                $pass = md5(uniqid('', true));
                $key = sha1($pass);
                $result = $model->isExistsApiKey($key);
            }


            $id = $request->getParam('id');
            $model->updateApiKey($id, $key);

            $db->commit();

        } catch (\Exception $e) {
            $db->rollBack();
            throw $e;
        }

        $this->_redirect('/');
    }


    /**
     * クライアントを削除する
     *
     * @author suguru
     **/
    public function deleteclientAction ()
    {
        try {
            $db = Helper::getConnection('db');
            $db->beginTransaction();

            $request = $this->getRequest();

            if (! $request->isPost()) {
                throw new \Exception('not PostRequest!');
            }

            
            $model = $this->container->get('ApiKeyModel');
            $model->fetchById($request->getParam('id'));
            $model->delete();

            $db->commit();
        
        } catch (\Exception $e) {
            $db->rollBack();
            throw $e;
        }

        $this->_redirect('/');
    }
}
