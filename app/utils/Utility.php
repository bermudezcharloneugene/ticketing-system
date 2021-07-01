<?php

    namespace app\utils;

    use Carbon\Carbon;
    use Rakit\Validation\Validator;

    class Utility {
        protected const SECRET = 'b2dbd7209d18720cab0d25d7c6371bca6073f0216c19c3ce8dcfc00d8';

        public static function redirect(String $uri)
        {
            header("Location: ".$uri);
        }

        /**
         * Accepts string as params
         * Method to get email domain.
         */
        public static function getDomain(String $email) {

            if (strrpos($email, '.') == strlen($email) - 3)
            $num_parts = 3;
            else
            $num_parts = 2;
  
            $domain = implode('.',
              array_slice( preg_split("/(\.|@)/", $email), - $num_parts)
            );
  
            return strtolower($domain);

        }


        public static function encrypt(String $enc)
        {

        }

        public static function decrypt(String $dec)
        {

        }

        /**
         * Generate a random hash using sha512
         */
        public static function hashAlgo()
        {
           return $randomAlgo = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
        }

        public static function generateKey(String $pass = '')
        {
            return $pass !== '' ? hash('sha512', $pass . self::SECRET) : hash('sha512', self::SECRET);
            
        }

        /**
         * Get current date and time using Carbon library
         */
        public static function getCurrentDate()
        {
            return Carbon::now(); // will refactor to use a formatted time
        }

        public static function hashPassword($pass, $salt)
        {
            $hashedPassword = hash('sha512', $pass . $salt);
            return $hashedPassword;
        }

        public static function unixTime()
        {
            date_default_timezone_set('Asia/Manila');
            $now = time();
            $today = date(' H:i a ',$now);
            
            return $today;
        }

        public static function validator($method, array $validateRequest)
        {   
            $validator = new Validator;

            $validation = $validator->make($method, $validateRequest);

            $validation->validate();

            if($validation->fails()) 
            {
                return $validation;

            } else {
                return false;
            }
        }


        public static function  encodedResult(array $result, int $statusCode)
        {
            http_response_code($statusCode);
            return json_encode($result);
        }

        public static function formatUnixTime(int $time)
        {
            return date('h:i:sa', $time);
        }
    }

?>