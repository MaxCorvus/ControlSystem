<?php
namespace Service;
use Db\Db;
use Model\User;

class UserService
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    public function list(){

        return $this->db->select('SELECT * FROM users');

    }

    public function add(User $user) {
        $this->db->insert([
            'FirstName' => "$user->firstname",
            'LastName' => "$user->lastname",
            'Role' => "$user->role",
            'Status' => $user->status
        ]);
    }

    public function remove($id) {

        $this->db->delete("id=$id");
    }

    public function get($id) {
        return $this->db->select("SELECT * FROM users WHERE id=$id");
    }


    public function update($id, $firstname, $lastname, $role, $status){

        $this->db->update([
            'FirstName' => "$firstname",
            'LastName' => "$lastname",
            'Role' => "$role",
            'Status' => "$status"
        ],
            "id=$id"
        );

    }
    public function setStatuses(array $id, $status){
        $this->db->update([
            'Status'=> (int) $status,
        ],
            "id IN (" . implode(",",$id) . ")"
        );
    }

}