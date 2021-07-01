<?php

    namespace app\classes;

    use app\config\Connection;
    use app\utils\Utility;
    use app\utils\Query2 as DB;
    use app\utils\Request;
    use Rakit\Validation\Validator;

    class Tickets extends Utility{

        public function __construct() {
            $this->ticket_name = isset($_POST['ticket_name']) ? $_POST['ticket_name'] : '';
            $this->ticket_description = isset($_POST['ticket_description']) ? $_POST['ticket_description'] : '';
            $this->solution = isset($_POST['solution']) ? $_POST['solution'] : '';
            $this->root_cause = isset($_POST['root_cause']) ? $_POST['root_cause'] : '';
            $this->remarks = isset($_POST['remarks']) ? $_POST['remarks'] : '';
        }

        public function create() {

            $validator = new Validator;

            $validation = $validator->make($_POST, [
                'ticket_name' => 'required',
                'ticket_description' => 'required'
            ]);

            $validation->validate();

            if ($validation->fails()) {
                header('Content-Type: application/json');
                
                $errors = $validation->errors();
                $arrayResult = array(
                    'errors' => true,
                    'errorMessage' => $errors->firstOfAll()
                );
                http_response_code(402);
                return json_encode([$arrayResult]);

            } else {
                $sessionEmail = $_SESSION['email'];
                $id_val = '';
                $data = $this->getUserId($sessionEmail);

                if(($ticketId = $this->insertTicketDataAndGetId($data[0]['USER_ID'])))
                {

                    if($this->insertTicketStatus($ticketId))
                    {
                        $arrayResult = array(
                            'response' => 200,
                            'result' => true,
                            'ticket' => $ticketId
                        );
                        http_response_code(200);
    
                        return json_encode([$arrayResult]);
                    }
                }
            }

        }

        public function delete($id) {
            $db = new DB; 
            $query = "DELETE FROM TICKETS WHERE TICKET_ID = :id";
            $result = $db->executeQuery($query, [':id' => $id]);

            $arrayResult = array(
                'response' => 200,
                'result' => true,
            );
            http_response_code(200);

            return json_encode([$arrayResult]);
        }

        public function update($id) 
        {
            $validator = new Validator;

            $validation = $validator->make($_POST, [
                'ticket_name' => 'required',
                'ticket_description' => 'required'
            ]);

            $validation->validate();

            if ($validation->fails()) {
                header('Content-Type: application/json');
                
                $errors = $validation->errors();
                $arrayResult = array(
                    'errors' => true,
                    'errorMessage' => $errors->firstOfAll()
                );
                http_response_code(402);
                return json_encode([$arrayResult]);

            } else{ 
                $db = new DB;
                $query = "UPDATE TICKETS SET TICKET_NAME = '$this->ticket_name', TICKET_DESCRIPTION = '$this->ticket_description'
                            WHERE TICKET_ID = :id";
                $result = $db->executeQuery($query, [':id' => $id]);

                $arrayResult = array(
                    'response' => 200,
                    'result' => true,
                );
                http_response_code(200);

                return json_encode([$arrayResult]);
            }

        }

        
        public function list() {
            $query = "SELECT TICKETS.*, TICKET_PROGRESS.progress_id, ticket_status.ticket_status_name,
            TICKET_ENVIRONMENT.TICKET_ENVIRONMENT_NAME, TICKET_TYPE.TYPE_NAME, QA_ASSIGNEE.USER_ID_FK,
            PROGRAMMER_ASSIGNEE.USER_ID_FK, USERS.NAME
            FROM TICKETS
            INNER JOIN ticket_progress ON TICKETS.TICKET_ID = ticket_progress.ticket_id_fk
            INNER JOIN ticket_status ON ticket_progress.ticket_status_id_fk = ticket_status.ticket_status_id
            INNER JOIN USERS on TICKETS.CREATED_BY_FK = USERS.USER_ID
            INNER JOIN QA_ASSIGNEE ON TICKETS.TICKET_ID = QA_ASSIGNEE.TICKET_ID_FK
            INNER JOIN PROGRAMMER_ASSIGNEE ON TICKETS.TICKET_ID = PROGRAMMER_ASSIGNEE.TICKET_ID_FK
            INNER JOIN TICKET_ENVIRONMENT ON TICKET_PROGRESS.ENVIRONMENT_ID_FK = TICKET_ENVIRONMENT.ENVIRONMENT_ID
            INNER JOIN TICKET_TYPE ON TICKET_PROGRESS.TICKET_TYPE_ID_FK = TICKET_TYPE.TYPE_ID";

            $db = new DB;
            $result = $db->extractData($query);
            return $result;

        }

        public function getTicketEnv() {
            $query = "SELECT * FROM TICKET_ENVIRONMENT";
            $db = new DB;
            $result = $db->extractData($query);
            return $result;

        }

        public function graphsList()
        {
            $query = "SELECT TICKET_PROGRESS.PROGRESS_ID, TICKETS.TICKET_ID, TICKET_STATUS.TICKET_STATUS_ID, 
            TICKET_STATUS.TICKET_STATUS_NAME, TICKET_TYPE.TYPE_NAME, TICKET_TYPE.TYPE_ID, TICKET_ENVIRONMENT.TICKET_ENVIRONMENT_NAME FROM TICKET_PROGRESS
            INNER JOIN TICKETS ON ticket_progress.ticket_id_fk = TICKETS.TICKET_ID 
            INNER JOIN TICKET_STATUS ON TICKET_STATUS.TICKET_STATUS_ID = TICKET_PROGRESS.TICKET_STATUS_ID_FK
            INNER JOIN TICKET_ENVIRONMENT ON TICKET_PROGRESS.ENVIRONMENT_ID_FK = TICKET_ENVIRONMENT.ENVIRONMENT_ID
            INNER JOIN TICKET_TYPE ON TICKET_PROGRESS.TICKET_TYPE_ID_FK = TICKET_TYPE.TYPE_ID";
            $db = new DB;
            $result = $db->extractData($query);
            return $result;
        }

        public function byId($id)
        {
            $query = "SELECT TICKETS.*, TICKET_PROGRESS.progress_id, ticket_status.ticket_status_name, USERS.NAME,
            TICKET_ENVIRONMENT.TICKET_ENVIRONMENT_NAME, TICKET_TYPE.TYPE_NAME
            FROM TICKETS
            INNER JOIN ticket_progress ON TICKETS.TICKET_ID = ticket_progress.ticket_id_fk
            INNER JOIN ticket_status ON ticket_progress.ticket_status_id_fk = ticket_status.ticket_status_id
            INNER JOIN USERS ON users.user_id = tickets.created_by_fk
            INNER JOIN TICKET_ENVIRONMENT ON TICKET_PROGRESS.ENVIRONMENT_ID_FK = TICKET_ENVIRONMENT.ENVIRONMENT_ID
            INNER JOIN TICKET_TYPE ON TICKET_PROGRESS.TICKET_TYPE_ID_FK = TICKET_TYPE.TYPE_ID WHERE TICKET_ID =  :user_id";
            $db = new DB;
            $result = $db->extractData($query, [':user_id' => $id]);
            return $result;
        }

        private function getUserId(string $email)
        {
            $query = "SELECT USER_ID FROM USERS WHERE EMAIL = :email";
            $db = new DB;
            $result = $db->extractData($query,[
                ':email' => $email
            ]);
            return $result;
        }

        private function insertTicketDataAndGetId($userId) 
        {
            $id_val = '';
            $db = new DB;

            $query = "INSERT INTO TICKETS (TICKET_NAME, TICKET_DESCRIPTION, CREATED_AT, CREATED_BY_FK, ROOT_CAUSE,
                        SOLUTION, REMARKS) 
            VALUES (:ticket_name, :ticket_description, CURRENT_TIMESTAMP, :user_id, :solution, :root_cause, :remarks) 
            RETURNING TICKET_ID INTO :id_val";

            $stmt = $db->ociParse($query, $db->connect());

            $bindValues = [
                ':ticket_name'          => $this->ticket_name,
                ':ticket_description'   => $this->ticket_description,
                ':user_id'              => $userId,
                ':solution'             => $this->solution,
                ':root_cause'           => $this->root_cause,
                ':remarks'              => $this->remarks
            ];

            foreach($bindValues as $key => $val)
            {
                oci_bind_by_name($stmt, $key, $bindValues[$key]);
            }

            oci_bind_by_name($stmt, ':id_val', $id_val, 100);

            $result = oci_execute($stmt);

            return $result ? $id_val : false;
            
        }

        private function insertTicketStatus($ticketId)
        {
            $db = new DB;
            $ticketId = intval($ticketId);
            $query = "INSERT ALL INTO TICKET_PROGRESS(TICKET_STATUS_ID_FK, TICKET_ID_FK, ENVIRONMENT_ID_FK, TICKET_TYPE_ID_FK) 
            VALUES(:ticket_status_id_fk, :ticket_id_fk, :environment_id_fk, :ticket_type_id_fk)
            INTO QA_ASSIGNEE(TICKET_ID_FK, USER_ID_FK) VALUES (:ticket_id_fk_1, :user_id_fk_1)
            INTO PROGRAMMER_ASSIGNEE(TICKET_ID_FK, USER_ID_FK) VALUES (:ticket_id_fk_2, :user_id_fk_2)
            SELECT * FROM dual";
            return $db->executeQuery($query, 
                [
                    ':ticket_status_id_fk'  => 1,
                    ':ticket_id_fk'         => $ticketId,
                    ':environment_id_fk'    => 3,
                    ':ticket_type_id_fk'    => 2,
                    ':user_id_fk_1'         => 63,
                    ':user_id_fk_2'         => 41,
                    ':ticket_id_fk_1'       => $ticketId,
                    ':ticket_id_fk_2'       => $ticketId

                ]
            ) ? true : false;

        }

        /**
         * Initial ticket series. Later will refactor to make a dynamic ticket series.
         * @return String
         */
        private static function ticketSeries() : String
        {
            return '00000';
        }

        /**
         * Check existing ticket series number by using the id parameter. Will modify to be dynamic
         * @var String $id
         * @return String
         */
        private function calculateSeriesNumber(String $id) : String
        {
            $ticketSeriesLength = intval(strlen(Self::ticketSeries()));
            $difference = intval(strlen($id)) - 1;
            return substr(Self::ticketSeries(), $difference, $ticketSeriesLength);
        }

    }

?>