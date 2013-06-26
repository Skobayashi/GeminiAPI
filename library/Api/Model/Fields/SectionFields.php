<?php


namespace Api\Model\Fields;

class SectionFields implements FieldsInterface
{
    protected
        $fields = array(
            'id',
            'svn_root_id',
            'book_type_id',
            'ec_id',
            'name',
            'name_full',
            'rev',
            'title',
            'user_id',
            'language_id',
            'description',
            'maintenance',
            'maintenance_end',
            'maintenance_user',
            'editor',
            'void',
            'book',
            'is_lock',
            'cite',
            'updated_at',
            'created_at'
        );


    // フィールドを取得する
    public function getFields ()
    {
        return $this->fields;
    }

}
