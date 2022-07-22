<?php
namespace Routes;
use Db\Db;
use Model\User;
use Service\UserService;

class Controller
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function getUsers(){
        return ['status' => true, 'users' => $this->userService->list()];
    }

    public function addUser() {
        if (!$this->isValid()) {
            return ['status' => false, 'error' => ['code' => 253, 'message' => 'data not valid']];
        }

        $user = new User($_POST['FirstName'], $_POST['LastName'], $_POST['Role'], $_POST['Status'] === "true");
        $this->userService->add($user);
        return ['status' => true, 'error' => null, 'user' => ['name_first' => $_POST['FirstName'], 'name_last' => $_POST['LastName'], 'status' => $_POST['Status']]];
    }

    public function removeUser() {
        if (!$this->userService->get($_GET['id'])) {
            return ['status' => false, 'error' => ['code' => 100, 'message' => 'user not found']];
        }

        $this->userService->remove($_GET['id']);

        return ['status' => true, 'error' => null];
    }
    public function updateUser(){
        if (!$this->isValid()) {
            return ['status' => false, 'error' => ['code' => 253, 'message' => 'data not valid']];
        }
        $this->userService->update($_POST['id'], $_POST['FirstName'], $_POST['LastName'], $_POST['Role'], $_POST['Status']);
        return ['status' => true, 'error' => null, 'id' => $_POST['id']];
    }
    public function setUsersStatuses(){

        $id = $_POST['id'];
        $status = $_POST['status'];
        $this->userService->setStatuses($id, $status);
    }


    private function isValid(): bool {
        foreach($_POST as $key => &$value) {
            if (strlen($value) !== 0) {
                $value = rtrim($value);
                $value = stripslashes($value);
                $value = strip_tags($value);
                $value = htmlspecialchars($value);
            } else {
                return false;
            }
        }
        unset($value);

        return true;
    }
}