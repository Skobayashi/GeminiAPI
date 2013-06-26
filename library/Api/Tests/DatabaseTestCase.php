<?php


namespace Api\Tests;

use Api\Db;

class DatabaseTestCase extends \PHPUnit_Extensions_Database_TestCase
{
    /**
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    protected function getConnection ()
    {
        try {
            $config = new \Zend_Config_Ini(APPLICATION_PATH . '/configs/database.ini', APPLICATION_ENV);
            $dsn = $config->db->dsn;
            $user = $config->db->username;
            $password = $config->db->password;

            $conn = new Db($dsn, $user, $password);
            $conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        } catch (\PDOException $e) {
            $msg = $e->getMessage().PHP_EOL.PHP_EOL;

            $msg .= 'データベースのテストにはテスト用DBが必要です！'.PHP_EOL;
            $msg .= 'data/fixture/tests_schema.dbからデータベースを作成してください！';

            die($msg);
        }


        // Zend_RegistryへGemini\Dbを登録する
        \Zend_Registry::set('conn', $conn);

        return $this->createDefaultDBConnection($conn);
    }


    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet ()
    {
        $ds = $this->createFlatXmlDataSet(ROOT_PATH.'/data/fixture/tests.xml');
        $rds = new \PHPUnit_Extensions_Database_Dataset_ReplacementDataSet($ds);
        $rds->addFullReplacement('##null##', null);

        return $rds;
    }


    /**
     * @return void
     * 初期化処理を記載する
     */
    public function setUp()
    {
        parent::setUp();


        // テーブルを空にする
        $this->_truncateTables();
    }



    /**
     * PHPUnitでTruncateしきれないテーブルを空にする
     *
     * @return void
     * @author app2641
     **/
    private function _truncateTables ()
    {
        try {
            $conn = \Zend_Registry::get('conn');

            $sql = 'truncate table code';
            $conn->state($sql);

        
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
