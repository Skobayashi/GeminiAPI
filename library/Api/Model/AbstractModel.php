<?php


namespace Api\Model;

abstract class AbstractModel
{
    public
        $table;

    protected
        $record;


    /**
     * 新規レコードを挿入する
     *
     * @return stdClass
     * @author app2641
     **/
    public final function insert (\stdClass $params)
    {
        return $this->table->insert($params);
    }



    /**
     * 指定レコードを更新する
     *
     * @return stdClass
     * @author app2641
     **/
    public final function update ()
    {
        return $this->table->update($this);
    }



    /**
     * 指定 レコードを削除する
     *
     * @return void
     * @author app2641
     **/
    public final function delete ()
    {
        $thia->table->delete($this);
    }



    /**
     * 指定フィールドの値を取得する
     *
     * @return string
     * @author app2641
     **/
    public final function get ($key)
    {
        if (in_array($key, $this->table->fields->getFields())) {
            $record = $this->getRecord();
            return $record->{$key};
        }

        return false;
    }



    /**
     * 指定フィールドの値を設定する
     *
     * @return void
     * @author app2641
     **/
    public final function set ($key, $val)
    {
        if (in_array($key, $this->table->fields->getFields())) {
            $record = $this->getRecord();
            $record->{$key} = $val;
            return true;
        }

        return false;
    }



    /**
     * レコード情報を取得する
     *
     * @return stdClass
     * @author app2641
     **/
    public function getRecord ()
    {
        if (is_null($this->record)) {
            throw new Err('did not set record!');
        }

        return $this->record;
    }



    /**
     * レコード情報を取得する
     *
     * @return void
     * @author app2641
     **/
    public final function setRecord (\stdClass $params)
    {
        foreach ($params as $key => $param) {
            if (! in_array($key, $this->table->fields->getFields())) {
                unset($params->{$key});
            }
        }

        $this->record = $params;
    }



    /**
     * 指定idのレコードを取得する
     *
     * @author app2641
     */
    public function fetchById ($id)
    {
        $record = $this->table->fetchById($id);

        if (! $record) {
            $this->record = null;
            return false;
        }

        $this->setRecord($record);
    }
}
