
<?php

    trait Request {
        function getRequestMethod($request)
        {
            return $_SERVER['REQUEST_METHOD'] === $request ? $_SERVER['REQUEST_METHOD'] : false;
        }

    }

?>