<?php


namespace Api\Factory;

use Api\Model\Fields\ApiKeyFields,
    Api\Model\Fields\SectionFields;

use Api\Model\Table\ApiKeyTable,
    Api\Model\Table\SectionTable;

use Api\Model\ApiKeyModel,
    Api\Model\SectionModel;

class ModelFactory extends AbstractFactory
{

    ////////////////////
    // Fields
    ////////////////////

    public function buildApiKeyFields ()
    {
        return new ApiKeyFields();
    }


    public function buildSectionFields ()
    {
        return new SectionFields();
    }




    ////////////////////
    // Table
    ////////////////////

    public function buildApiKeyTable ()
    {
        return new ApiKeyTable();
    }


    public function buildSectionTable ()
    {
        return new SectionTable();
    }





    ////////////////////
    // Model
    ////////////////////

    public function buildApiKeyModel ()
    {
        return new ApiKeyModel();
    }


    public function buildSectionModel ()
    {
        return new SectionModel();
    }


}
