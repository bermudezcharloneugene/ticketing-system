<?php 

    require_once "./vendor/autoload.php";
    use Faker\Factory;
    use app\utils\Seeder;
    use app\utils\Query as DB;
    use Carbon\Carbon;

    $time = Carbon::now();

    if($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        $id_val = '';
        $seed = new Seeder;
        $db = new DB;
        $faker = Factory::create();
        $userId = [4,22,41];

        for($i=0;$i<2;$i++)
        {
            $text = $faker->text($maxNbChars = 50);
            $query = "INSERT INTO TICKETS(TICKET_NAME, TICKET_DESCRIPTION, CREATED_AT, CREATED_BY_FK, ROOT_CAUSE, SOLUTION, REMARKS)
                        VALUES ('$faker->catchPhrase', '$text',  TO_DATE('23-04-2021 11:30', 'dd-mm-yyyy hh12:mi:ss'), '41', '$text', '$text', '$text') 
                        RETURNING TICKET_ID INTO :id_val";
                                    $stmt = $db->ociParse($query);

            oci_bind_by_name($stmt, ':id_val', $id_val, 100);

            oci_execute($stmt);

            $query = "INSERT ALL 
                        INTO TICKET_PROGRESS(TICKET_STATUS_ID_FK, TICKET_ID_FK, ENVIRONMENT_ID_FK, TICKET_TYPE_ID_FK) 
                        VALUES(:ticket_status_id_fk, :ticket_id_fk, :environment_id_fk, :ticket_type_id_fk)
                        INTO QA_ASSIGNEE(TICKET_ID_FK, USER_ID_FK) VALUES (:ticket_id_fk_1, :user_id_fk_1)
                        INTO PROGRAMMER_ASSIGNEE(TICKET_ID_FK, USER_ID_FK) VALUES (:ticket_id_fk_2, :user_id_fk_2)
                        SELECT * FROM dual";
            $arr = [
                    ':ticket_status_id_fk'      => 3,
                    ':ticket_id_fk'             => $id_val,
                    ':environment_id_fk'        => 3,
                    ':ticket_type_id_fk'        => 2,
                    ':user_id_fk_1'             => 63,
                    'user_id_fk_2'              => 41,
                    ':ticket_id_fk_1'           => $id_val,
                    ':ticket_id_fk_2'           => $id_val

                ];
            $db->executeQuery2($query, $arr);
        }

    }

?>