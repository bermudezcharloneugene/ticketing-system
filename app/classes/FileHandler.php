<?php
    namespace app\classes;
    
    use app\utils\Utility;
    use app\utils\Session;
    use app\utils\Query2 as DB;
    use Rakit\Validation\Validator;

    class FileHandler 
    {
        private $dir = "../../public/assets/images/";

        public function handleFile()
        {
            
            $validator = new Validator;

            $validation = $validator->make($_FILES, [
                'avatar' => 'required|uploaded_file:0,1M,png,jpeg'
            ]);

            $validation->validate();

            if($validation->fails()) 
            {
                $errors = $validation->errors();
                return $this->jsonEncodedResult($errors->firstOfAll(), true, 401);

            } else {
                $baseName = $_FILES['avatar']['name'];
                $targetFile = $this->dir . baseName($_FILES['avatar']['name']);
                $id = $this->getUserId($_SESSION['email']);
                $fileName = $this->getNewFileName($targetFile);

                if(count($userProfileData=$this->checkIfProfileExists($id[0]['USER_ID'])) > 0)
                {
                    unlink($this->dir . $userProfileData[0]['PROFILE_PATH']);
                    $this->updateProfile($id[0]['USER_ID'], $fileName);
                    $this->uploadFile($_FILES['avatar']['tmp_name'], $this->dir . $fileName);
                    
                    return $this->jsonEncodedResult();

                } else {
                    if($this->validateFile($targetFile) === true)
                    {
                        
                        if($this->insertPathIntoDb($fileName, $id[0]['USER_ID']))
                        {

                            $this->uploadFile($_FILES['avatar']['tmp_name'], $this->dir . $fileName);
                            return $this->jsonEncodedResult();
                        } else{
                            $error = array(
                                'error' => 'THERE IS AN ERROR'
                            );
        
                            return $this->jsonEncodedResult($error, true, 402);
                        }
    
    
                    }else {
                        $error = array(
                            'error' => 'Not a valid Image'
                        );
                        return $this->jsonEncodedResult($error, true, 402);
                    }
                }

            }
        }


        private function validateFile($fileToCheck)
        {
            $imageFileType = strtolower(pathinfo($fileToCheck,PATHINFO_EXTENSION));
            return $imageFileType === "jpg" || $imageFileType === "png" || $imageFileType === "jpeg" ? true : false;
        }


        private function getNewFileName($fileToRename)
        {
            $name = explode('.', $fileToRename);
            return round(microtime(true)) . '.' . end($name);
        }

        private function insertPathIntoDb($file, $id)
        {
            $db = new DB;
            $query = "INSERT INTO USER_PROFILE (PROFILE_PATH, USER_ID_FK) VALUES (:image_path, :user_id)";
            $result = $db->executeQuery($query, [
                ':image_path' => $file,
                ':user_id'    => $id
            ]);

            return $result === true ? true : false;
        }

        private function checkIfProfileExists($id) 
        {
            $db = new DB;
            $query = "SELECT USER_ID_FK, PROFILE_PATH FROM USER_PROFILE WHERE USER_ID_FK = :user_id";
            $result = $db->extractData($query, [
                ':user_id'    => $id
            ]);

            return $result;
        }

        private function updateProfile($id, $profile_path)
        {
            $db = new DB;
            $query = "UPDATE USER_PROFILE SET PROFILE_PATH = :profile_path WHERE USER_ID_FK = :user_id";
            $result = $db->executeQuery($query, [
                ':profile_path' => $profile_path,
                ':user_id'      => $id
            ]);

            return $result;
        }

        private function getUserId($params) 
        {
            $db = new DB;
            $query = "SELECT USER_ID from USERS WHERE EMAIL = :params";
            $result = $db->extractData($query, [
                ':params' => $params
            ]);

            return $result;
        }

        private function uploadFile($temp_file, $file_name)
        {
            return move_uploaded_file($temp_file, $file_name);
            
        }

        private function jsonEncodedResult($errorMessage = '', bool $error = false, int $statusCode = 200)
        {
            return Utility::encodedResult([
                'error' => $error,
                'errorMessage' => $errorMessage
            ], $statusCode);
        }
    } 
?>