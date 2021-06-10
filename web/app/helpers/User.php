<?php

namespace App\Helpers;

class User extends Person
{
    private $hashed_password;
    private $user_id;
    private $authenticated = false;

    public function __construct($data)
    {
        $this->user_id = $data['user_id'];
        $this->fname = $data['user_fname'];
        $this->lname = $data['user_lname'];
        $this->email = $data['user_email'];
        $this->phone = $data['user_phone'];
        $this->hashed_password = $data['pass'];
    }

    public function authenticate($pass)
    {

        if (password_verify($pass, $this->hashed_password)) {
            $this->authenticated = true;
        } else {
            $this->authenticated = false;
        }

        return $this->authenticated;
    }

    public function set_session()
    {
        $_SESSION['id'] = $this->user_id;
        $_SESSION['user_fname'] = $this->fname;
        $_SESSION['user_lname'] = $this->lname;
        $_SESSION['user_email'] = $this->email;
        $_SESSION['user_phone'] = $this->phone;
    }
}
