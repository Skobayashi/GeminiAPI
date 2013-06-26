<?php

namespace Api;

use Api\Container,
    Api\Factory\ModelFactory;

class LevelManager
{
    private
        $level;

    public function __construct ($level)
    {
        $this->level = $level;
    }



    /**
     * レベルに応じた素材idを返す
     *
     * @return string
     * @author app2641
     **/
    public function generateMaterialId ()
    {
        $container = new Container(new ModelFactory);
        $material_table = $container->get('MaterialTable');

        $rand = rand(1, 100);

        switch ($this->level) {
            // level1のとき
            case 1:
                $i = 60;
                // 60%
                if ($rand <= $i) {
                    $result = $material_table->getRarityMaterial('D', 1);
                    
                // 40%
                } else {
                    $result = $material_table->getRarityMaterial('D', 2);
                }
                break;

            // level2のとき
            case 2:
                $prob = array(20, 30, 35, 15); // 確率
                $key = $this->_getProbKey($prob, $rand);

                switch ($key) {
                    case 0:
                        $result = $material_table->getRarityMaterial('D', 1);
                        break;

                    case 1:
                        $result = $material_table->getRarityMaterial('D', 2);
                        break;

                    case 2:
                        $result = $material_table->getRarityMaterial('D', 3);
                        break;

                    case 3:
                        $result = $material_table->getRarityMaterial('D', 4);
                        break;
                }
                break;

            // level3のとき
            case 3:
                $prob = array(10, 10, 15, 20, 25, 20); // 確率
                $key = $this->_getProbKey($prob, $rand);

                switch ($key) {
                    case 0:
                        $result = $material_table->getRarityMaterial('D', 1);
                        break;

                    case 1:
                        $result = $material_table->getRarityMaterial('D', 2);
                        break;

                    case 2:
                        $result = $material_table->getRarityMaterial('D', 3);
                        break;

                    case 3:
                        $result = $material_table->getRarityMaterial('D', 4);
                        break;

                    case 4:
                        $result = $material_table->getRarityMaterial('C', 1);
                        break;

                    case 5:
                        $result = $material_table->getRarityMaterial('C', 2);
                        break;
                }
                break;

            // level4のとき
            case 4:
                $prob = array(5, 5, 10, 10, 15, 20, 25, 10);
                $key = $this->_getProbKey($prob, $rand);

                switch ($key) {
                    case 0:
                        $result = $material_table->getRarityMaterial('D', 1);
                        break;

                    case 1:
                        $result = $material_table->getRarityMaterial('D', 2);
                        break;

                    case 2:
                        $result = $material_table->getRarityMaterial('D', 3);
                        break;

                    case 3:
                        $result = $material_table->getRarityMaterial('D', 4);
                        break;

                    case 4:
                        $result = $material_table->getRarityMaterial('C', 1);
                        break;

                    case 5:
                        $result = $material_table->getRarityMaterial('C', 2);
                        break;

                    case 6:
                        $result = $material_table->getRarityMaterial('C', 3);
                        break;

                    case 7:
                        $result = $material_table->getRarityMaterial('C', 4);
                        break;
                }
                break;

            // level5のとき
            case 5:
                $prob = array(10, 10, 10, 15, 20, 20, 15);
                $key = $this->_getProbKey($prob, $rand);

                switch ($key) {
                    case 0:
                        $result = $material_table->getRarityMaterial('D', false);
                        break;

                    case 1:
                        $result = $material_table->getRarityMaterial('C', 1);
                        break;

                    case 2:
                        $result = $material_table->getRarityMaterial('C', 2);
                        break;

                    case 3:
                        $result = $material_table->getRarityMaterial('C', 3);
                        break;

                    case 4:
                        $result = $material_table->getRarityMaterial('C', 4);
                        break;

                    case 5:
                        $result = $material_table->getRarityMaterial('B', 1);
                        break;

                    case 6:
                        $result = $material_table->getRarityMaterial('B', 2);
                        break;
                }
                break;
            
            // level6のとき
            case 6:
                $prob = array(7, 7, 8, 9, 11, 13, 15, 20, 10);
                $key = $this->_getProbKey($prob, $rand);

                switch ($key) {
                    case 0:
                        $result = $material_table->getRarityMaterial('D', false);
                        break;

                    case 1:
                        $result = $material_table->getRarityMaterial('C', 1);
                        break;

                    case 2:
                        $result = $material_table->getRarityMaterial('C', 2);
                        break;

                    case 3:
                        $result = $material_table->getRarityMaterial('C', 3);
                        break;

                    case 4:
                        $result = $material_table->getRarityMaterial('C', 4);
                        break;

                    case 5:
                        $result = $material_table->getRarityMaterial('B', 1);
                        break;

                    case 6:
                        $result = $material_table->getRarityMaterial('B', 2);
                        break;

                    case 7:
                        $result = $material_table->getRarityMaterial('B', 3);
                        break;

                    case 8:
                        $result = $material_table->getRarityMaterial('B', 4);
                        break;
                }
                break;

            // level7のとき
            case 7:
                $prob = array(5, 7, 9, 9, 15, 20, 20, 15);
                $key = $this->_getProbKey($prob, $rand);
                break;

                switch ($key) {
                    case 0:
                        $result = $material_table->getRarityMaterial('D', false);
                        break;

                    case 1:
                        $result = $material_table->getRarityMaterial('C', false);
                        break;

                    case 2:
                        $result = $material_table->getRarityMaterial('B', 1);
                        break;

                    case 3:
                        $result = $material_table->getRarityMaterial('B', 2);
                        break;

                    case 4:
                        $result = $material_table->getRarityMaterial('B', 3);
                        break;

                    case 5:
                        $result = $material_table->getRarityMaterial('B', 4);
                        break;

                    case 6:
                        $result = $material_table->getRarityMaterial('A', 1);
                        break;

                    case 7:
                        $result = $material_table->getRarityMaterial('A', 2);
                        break;
                }

            // level8のとき
            case 8:
                $prob = array(3, 5, 7, 7, 9, 10, 12, 15, 20, 15);
                $key = $this->_getProbKey($prob, $rand);

                switch ($key) {
                    case 0:
                        $result = $material_table->getRarityMaterial('D', false);
                        break;

                    case 1:
                        $result = $material_table->getRarityMaterial('C', false);
                        break;

                    case 2:
                        $result = $material_table->getRarityMaterial('B', 1);
                        break;

                    case 3:
                        $result = $material_table->getRarityMaterial('B', 2);
                        break;

                    case 4:
                        $result = $material_table->getRarityMaterial('B', 3);
                        break;

                    case 5:
                        $result = $material_table->getRarityMaterial('B', 4);
                        break;

                    case 6:
                        $result = $material_table->getRarityMaterial('A', 1);
                        break;

                    case 7:
                        $result = $material_table->getRarityMaterial('A', 2);
                        break;

                    case 8:
                        $result = $material_table->getRarityMaterial('A', 3);
                        break;

                    case 9:
                        $result = $material_table->getRarityMaterial('A', 4);
                        break;
                }
                break;

            // level9のとき
            case 9:
                $prob = array(3, 5, 7, 9, 10, 13, 18, 20, 15);
                $key = $this->_getProbKey($prob, $rand);

                switch ($key) {
                    case 0:
                        $result = $material_table->getRarityMaterial('D', false);
                        break;

                    case 1:
                        $result = $material_table->getRarityMaterial('C', false);
                        break;

                    case 2:
                        $result = $material_table->getRarityMaterial('B', false);
                        break;

                    case 3:
                        $result = $material_table->getRarityMaterial('A', 1);
                        break;

                    case 4:
                        $result = $material_table->getRarityMaterial('A', 2);
                        break;

                    case 5:
                        $result = $material_table->getRarityMaterial('A', 3);
                        break;

                    case 6:
                        $result = $material_table->getRarityMaterial('A', 4);
                        break;

                    case 7:
                        $result = $material_table->getRarityMaterial('S', 1);
                        break;

                    case 8:
                        $result = $material_table->getRarityMaterial('S', 1);
                        break;
                }
                break;

            // levelが10のとき
            case 10:
                $prob = array(3, 3, 5, 5, 7, 8, 11, 14, 17, 20, 7);
                $key = $this->_getProbKey($prob, $rand);

                switch ($key) {
                    case 0:
                        $result = $material_table->getRarityMaterial('D', false);
                        break;

                    case 1:
                        $result = $material_table->getRarityMaterial('C', false);
                        break;

                    case 2:
                        $result = $material_table->getRarityMaterial('B', false);
                        break;

                    case 3:
                        $result = $material_table->getRarityMaterial('A', 1);
                        break;

                    case 4:
                        $result = $material_table->getRarityMaterial('A', 2);
                        break;

                    case 5:
                        $result = $material_table->getRarityMaterial('A', 3);
                        break;

                    case 6:
                        $result = $material_table->getRarityMaterial('A', 4);
                        break;

                    case 7:
                        $result = $material_table->getRarityMaterial('S', 1);
                        break;

                    case 8:
                        $result = $material_table->getRarityMaterial('S', 2);
                        break;

                    case 9:
                        $result = $material_table->getRarityMaterial('S', 3);
                        break;

                    case 10:
                        $result = $material_table->getRarityMaterial('S', 4);
                        break;
                }
                break;
        }

        return $result->id;
    }



    /**
     * 乱数が指定確率に対応するキーを返す
     *
     * @author app2641
     **/
    private function _getProbKey($prob, $rand)
    {
        $i = 0;
        $key = 0;
        foreach ($prob as $k => $v) {
            $i += $v;

            // どの確率に収まるかをkeyに保存
            if ($rand <= $i) {
                $key = $k;
                break;
            }
        }
        return $key;
    }



    /**
     * levelやレア度で素材レアidを生成する
     *
     * @author app2641
     **/
    public function generateRareId ()
    {
        $container = new Container(new ModelFactory);
        $material_table = $container->get('MaterialTable');

        switch ($this->level) {
            case 1:
                $result = $material_table->getRarityMaterial('D', 3);
                break;

            case 2:
                $result = $material_table->getRarityMaterial('D', 4);
                break;

            case 3:
                $result = $material_table->getRarityMaterial('C', 3);
                break;

            case 4:
                $result = $material_table->getRarityMaterial('C', 4);
                break;

            case 5:
                $result = $material_table->getRarityMaterial('B', 3);
                break;

            case 6:
                $result = $material_table->getRarityMaterial('B', 4);
                break;

            case 7:
                $result = $material_table->getRarityMaterial('A', 3);
                break;

            case 8:
                $result = $material_table->getRarityMaterial('A', 4);
                break;

            case 9:
                $result = $material_table->getRarityMaterial('S', 3);
                break;

            case 10:
                $result = $material_table->getRarityMaterial('S', 4);
                break;
        }

        return $result->id;
    }
}
