<?php


use Api\Container,
    Api\Factory\ModelFactory;

use Api\Database\Helper;

class SectionController extends \Zend_Controller_Action
{
    public
        $container;

    public function init ()
    {
        $this->_helper->viewRenderer->setNoRender();

        $this->container = new Container(new ModelFactory);
    }



    /**
     * 指定セクションをアンロックする
     *
     * @author suguru
     **/
    public function unlockAction ()
    {
        $model = $this->container->get('SectionModel');
        $data = $this->_updateStatus($this->getRequest(), $model::MAINTENANCE);

        $this->_helper->json($data);
    }



    /**
     * 指定セクションをロックする
     *
     * @author suguru
     **/
    public function lockAction ()
    {
        $model = $this->container->get('SectionModel');
        $data = $this->_updateStatus($this->getRequest(), $model::LOCK);

        $this->_helper->json($data);
    }



    /**
     * ステータス更新共通化処理
     *
     * @author suguru
     **/
    private function _updateStatus ($request, $to_status)
    {
        try {
            if (! $request->isPost()) {
                throw new \Exception('not PostRequest!');
            }


            $model = $this->container->get('ApiKeyModel');
            $client = $request->getParam('client');
            $key = $request->getParam('key');
            $result = $model->validateApiKey($client, $key);

            if (! $result) {
                throw new \Exception('APIキーが正しくありません！');
            }


            //$client = 'local_gemini';
            $db = Helper::getConnection($client);
            $db->beginTransaction();
            
            // セクションIDの整理
            $sections = $this->_explodeValues($request->getParam('val'));
            $model = $this->container->get('SectionModel');
            $model->setConnection($client);

            $txt = '';
            $hit_sections = 0;

            foreach ($sections as $section) {
                $result = $model->table->fetchByNameFull($section);

                if (! $result) {
                    throw new \Exception(sprintf('%sは存在しないセクションです', $section));
                }


                $model->setRecord($result);

                if ($to_status == $model::LOCK) {
                    if ($model->getStatus() == $model::LOCK) {
                        $txt .= $section.'は既にロック化されています'.PHP_EOL;
                        $hit_sections++;
                        continue;
                    }
                
                } else {
                    if ($model->getStatus() != $model::LOCK) {
                        $txt .= $section.'は既にアンロック化されています'.PHP_EOL;
                        $hit_sections++;
                        continue;
                    }
                }
                
                $model->updateStatus($to_status);
                $hit_sections++;
            }


            if ($hit_sections == 0) {
                $msg = $txt.PHP_EOL.'該当するセクションは見つかりませんでした！';
            } else {
                $msg = $txt.PHP_EOL.$hit_sections.'件のセクションに対してAPIコールを実行しました！';
            }

            $data = array(
                'success' => true,
                'msg' => $msg
            );

            $db->commit();
        
        } catch (\Exception $e) {
            if (isset($db)) {
                $db->rollBack();
            }

            $data = array(
                'success' => false,
                'msg' => $e->getMessage()
            );
        }

        return $data;
    }



    /**
     * セクションIDを整理する
     *
     * @author suguru
     **/
    private function _explodeValues ($values)
    {
        $values = explode(' ', $values);
        $sections = array();

        foreach ($values as $value) {
            $value = trim($value);

            if ((preg_match('/^[0-9]{8}-[0-9]+[a-z]{2}$/', $value)) && !in_array($value, $sections)) {
                $sections[] = $value;
            }
        }

        return $sections;
    }
}
