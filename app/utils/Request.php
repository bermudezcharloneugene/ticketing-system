<?php
    namespace app\utils;

    class Request {

        public function __construct()
        {
            
        }

        public static function make(array $request)
        {
            print_r($request);
        }

        public static function messages(array $message) {

        }
    }

?>