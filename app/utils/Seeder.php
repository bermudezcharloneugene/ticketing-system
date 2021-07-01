<?php

    namespace app\utils;

    use app\utils\Query;

    /**
     * A custom class seeder for easier prototyping and testing.
     */

    class Seeder extends Query{

        /**
         * @param String $params
         * @return Mix
         */
        public function seed(String $params)
        {
           return $this->executeQuery($params);
        }

    }

?>