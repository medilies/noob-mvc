<?php

namespace App\Helpers;

class Person
{
    protected $fname;
    protected $lname;
    protected $email;
    protected $phone;

    // Sanitisors
    protected function sanitise_email()
    {
        $email = $this->email;
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $this->email = strtolower($email);
    }

    // Validators
    protected function validate_email()
    {
        $email = $this->email;
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            echo json_encode(Utility::create_report('INVALID_DATA', "Email '$email' est invalid"));
            die;
        }
    }

    // GETTERS & SETTERS
    public function get_fname()
    {
        return $this->fname;
    }
    public function set_fname($fname)
    {
        $this->fname = $fname;
    }
    public function get_lname()
    {
        return $this->lname;
    }
    public function set_lname($lname)
    {
        $this->lname = $lname;
    }
    public function get_email()
    {
        return $this->email;
    }
    public function set_email($email)
    {
        $this->email = $email;
    }
    public function get_phone()
    {
        return $this->phone;
    }
    public function set_phone($phone)
    {
        $this->phone = $phone;
    }
}
