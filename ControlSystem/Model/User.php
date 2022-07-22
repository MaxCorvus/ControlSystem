<?php
namespace Model;
class User
{

public string $firstname;
public string $lastname;
public int $role;
public bool $status;

public function __construct(string $firstname, string $lastname, int $role, bool $status, $id = null) {
    $this->firstname = $firstname;
    $this->lastname = $lastname;
    $this->role = $role;
    $this->status = $status;
    $this->id = $id;
}
}