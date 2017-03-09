<?php
require_once('../model/users.php');


class SiteController{
    public function index(){
        require_once('../view/site/index.php');
    }
    public function upload(){
        if(isset($_FILES['file']['name'])) {
            global $link;
            $data = $_FILES;
            $ext = end(explode('.', $data['file']['name']));
            if ($ext == 'json') {
                $model = new Users();
                $sql = $model->insertUsers($data);
                if ($link->multi_query($sql) === TRUE) {
                    echo json_encode(['success' => true, 'message' => 'Users was successfully imported.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Import failed.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'File format is not json.']);
            }
            die;
        }

    }


    public function users(){
        $model = new Users();
        $users = $model->selectUsers();
        require_once('../view/site/users.php');
    }


    public function create(){
        if (isset($_POST['firstname'])){
            $model = new Users();
            $result = $model->insert($_POST);
            if($result){
                echo json_encode(['success' => true, 'message' => 'User was successfully created.']);
            }else{
                echo json_encode(['success' => false, 'message' => 'There are some error.']);
            }
            die;
        }
        require_once('../view/site/create.php');
    }

    public function update(){
        if (isset($_POST['id']) && (int)$_POST['id']){
            $model = new Users();
            $result = $model->updateUserById($_POST);
            if($result){
                echo json_encode(['success' => true, 'message' => 'User was successfully updated.']);
            }else{
                echo json_encode(['success' => false, 'message' => 'There are some error.']);
            }
            die;
        }


        if($_GET['id'] && (int)$_GET['id']) {
            $model = new Users();
            $user = $model->selectUserById((int)$_GET['id']);
            if(isset($user[0])){
                $user = $user[0];
            }
            require_once('../view/site/update.php');
        }else{
            header('Location: /site/index');
        }
    }


    public function delete(){
        if(isset($_POST['ids']) && !empty($_POST['ids'])) {
            $model = new Users();
            $result = $model->deleteUsers($_POST['ids']);
            if($result){
                echo json_encode(['success' => true, 'message' => 'Success.']);
            }else{
                echo json_encode(['success' => false, 'message' => 'There are some error.']);
            }
        }else{
            header('Location: /site/index');
        }
    }

}