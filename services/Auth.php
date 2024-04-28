<?php

class Auth
{
    public string $name;
    public string $username;
    public string $email;
    public string $password;
    public string $confirmPassword;
    private $db;

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
        $this->db = new Database();
    }

    public function signUp()
    {
        // Check if passwords match
        if ($this->password !== $this->confirmPassword) {
            echo "Passwords do not match.";
            return;
        }

        // Hash the password
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

        // Check if the username or email already exists
        if ($this->db->exists('users', 'username', $this->username)) {
            echo "Username already exists.";
            return;
        }

        if ($this->db->exists('users', 'email', $this->email)) {
            echo "Email already exists.";
            return;
        }

        // Insert user into database
        $inserted = $this->db->insert(
            'users',
            ['name', 'username', 'email', 'password'],
            [$this->name, $this->username, $this->email, $hashedPassword]
        );

        if ($inserted) {
            echo "User registered successfully.";
        } else {
            echo "Error registering user.";
        }
    }

    public static function signIn($username, $password)
    {
        $db = new Database();
        if (!$db->exists('users', 'username', $username)) {
            echo "Username does not exist.";
            return;
        }

        $user = $db->query('users', 'username', $username);

        if (password_verify($password, $user->password)) {
            return $user;
        } else {
            return null;
        }
    }
}
