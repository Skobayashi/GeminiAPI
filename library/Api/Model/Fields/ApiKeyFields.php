<?php


namespace Api\Model\Fields;

class ApiKeyFields implements FieldsInterface
{
    protected
        $fields = array(
            'id',
            'client',
            'key'
        );


    /**
     * テーブルのフィールド情報を取得する
     *
     * @return array
     * @author app2641
     **/
    public function getFields ()
    {
        return $this->fields;
    }
}
