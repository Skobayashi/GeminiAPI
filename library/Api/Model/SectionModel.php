<?php


namespace Api\Model;

use Api\Container,
    Api\Factory\ModelFactory;

class SectionModel extends AbstractModel
{
    // セクションステータスの定数
    const LOCK        = 'lock';
    const CLOSE       = 'close';
    const MAINTENANCE = 'maintenance';


    public
        $table;


    public function __construct ()
    {
        $container    = new Container(new ModelFactory);
        $this->table  = $container->get('SectionTable');
    }


    public function setConnection ($client)
    {
        $this->table->setConnection($client);
    }



    /**
     * @retrun string
     * 内包レコードのステータスを取得する
     */
    public function getStatus ()
    {
        $record = $this->getRecord();


        if ($this->get('is_lock')) {
            $status = $this::LOCK;

        } else if ($this->get('maintenance')) {
            $status = $this::MAINTENANCE;

        } else {
            $status = $this::CLOSE;
        }

        return $status;
    }



    /**
     * レコードを指定ステータスへ更新する
     *
     * @author suguru
     **/
    public function updateStatus ($to_status)
    {
        try {

            if ($to_status === $this::LOCK) {
                // ロックする場合
                $this->set('is_lock', true);
                $this->set('maintenance', false);
            
            } else {
                // アンロックする場合
                $this->set('is_lock', false);
            }

            $this->update($this);

        } catch (\Exception $e) {
            throw $e;
        }

        return $this->getRecord();
    }
}
