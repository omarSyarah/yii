<?php

namespace common;

    class Status
    {
        const ACTIVE = 1;
        const INACTIVE = 0;

        // Post status:
        private static $postArray = [self::INACTIVE => 'Sold out car',self::ACTIVE => 'Available car'];
        private static $cityArray = [self::INACTIVE => 'City out of stock',self::ACTIVE => 'Stock available in city'];

        //basta5dem 2l const value as index key

        static public function getAllPostStatus()
        {
            return [
                self::ACTIVE => 'Active',
                self::INACTIVE=>'inactive'
                ];
        }


        public function getPostStatus($status_id)
        {
            return self::$postArray[$status_id];
        }

        static public function getAllCityStatus()
        {
            return [
                self::ACTIVE => 'Active',
                self::INACTIVE=>'inactive'
            ];
        }

        public function getCityStatus($status_id)
        {
            return self::$cityArray[$status_id];
        }

        static public function getAllMakeStatus()
        {
            return [
                self::ACTIVE => 'Active',
                self::INACTIVE=>'inactive'
            ];
        }

        public function getMakeStatus($status_id)
        {
            return self::$postArray[$status_id];
        }

        static public function getAllModelStatus()
        {
            return [
                self::ACTIVE => 'Active',
                self::INACTIVE=>'inactive'
            ];
        }

        public function getModelStatus($status_id)
        {
            return self::$postArray[$status_id];
        }




    }

