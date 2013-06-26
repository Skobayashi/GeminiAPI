<?php

namespace Api\Model\Table;

use Api\Model\AbstractModel;

use Api\Container,
    Api\Factory\ModelFactory;

use Api\Database\Helper;

class SectionTable implements TableInterface
{
    protected
        $db;

    public
        $fields;


    public function __construct ()
    {
        $container = new Container(new ModelFactory);
        $this->fields = $container->get('SectionFields');
    }


    public function setConnection ($client)
    {
        $this->db = Helper::getConnection($client);
    }



    public final function insert (\stdClass $params)
    {
        
    }


    public final function update (AbstractModel $model)
    {
        try {
            $record = $model->getRecord();

            foreach ($record as $key => $val) {
                if (! in_array($key, $this->fields->getFields())) {
                    throw new \Exception('invalid field!');
                }
            }

            $sql = 'UPDATE section
                SET is_lock = :is_lock,
                    maintenance = :maintenance
                WHERE id = :id';

            $bind = array(
                'is_lock' => $model->get('is_lock'),
                'maintenance' => $model->get('maintenance'),
                'id' => $model->get('id')
            );

            $this->db->state($sql, $bind);

        } catch (\Exception $e) {
            throw $e;
        }
    }


    public final function delete (AbstractModel $model)
    {
        
    }


    public final function fetchById ($id)
    {
        try {
            $sql = 'SELECT
                section.id,
                section.ec_id,
                section.name,
                section.name_full,
                section.rev,
                section.title,
                section.user_id,
                section.language_id,
                section.maintenance,
                section.maintenance_end,
                section.maintenance_user,
                section.editor,
                section.book,
                section.is_lock,
                section.cite,
                section.created_at,
                section.updated_at
                FROM section
                WHERE section.id = ?';

            $result = $this->db
                ->state($sql, $id)->fetch();

        } catch (\Exception $e) {
            throw $e;
        }

        return $result;
    }



    public function fetchByNameFull ($name_full)
    {
        try {
            $sql = 'SELECT * FROM section
                WHERE section.name_full = ?';

            $result = $this->db
                ->state($sql, $name_full)->fetch();
        
        } catch (\Exception $e) {
            throw $e;
        }

        return $result;
    }
}
