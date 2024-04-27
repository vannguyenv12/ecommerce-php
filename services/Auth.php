<?php

class Auth
{
    public string $name;
    public string $username;
    public string $email;
    public string $password;
    public string $confirmPassword;

    public function __construct(
        $name,
        $username,
        $email,
        $password,
        $confirmPassword
    ) {
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->confirmPassword = $confirmPassword;
    }

    public function signUp()
    {
        $db = new Database();

        $db->insert(
            "users",
            ['name', 'username', 'email', 'password', 'role'],
            [$this->name, $this->username, $this->email, $this->password, 'user']
        );
    }
}
