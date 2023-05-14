<?php

namespace App\Http\Controllers;

use App\database\Connection;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class AuthController
{
    public $db;

    public function __construct()
    {
        $this->db = Connection::connect();
    }

    public function login()
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        $prepare = $this->db->prepare("select * from users where email = :email");

        $prepare->execute([
            'email' => $email,
        ]);

        $userFound = $prepare->fetch();

        if (!$userFound) {
            http_response_code(401);
            echo 'deu ruim';
        }

        if ($password != $userFound->password) {
            http_response_code(401);
            echo 'deu ruim';
        }

        $payload = [
            "exp" => time() + 10,
            "iat" => time(),
            "email" => $email,
        ];

        $encode = JWT::encode($payload, $_ENV['KEY'], 'HS256');
        
        $r_payload  = [
            "exp" => time() + 2592000,
            "iat" => time(),
            "email" => $email,
        ];

        $r_encode = JWT::encode($r_payload, $_ENV['KEY'], 'HS256');

        echo json_encode(['jwt' => $encode, 'rjwt' => $r_encode]);
    }

    public function auth()
    {
        $authorization = $_SERVER["HTTP_AUTHORIZATION"];
        
        $token = str_replace("Bearer ", "", $authorization);

        try {
            $decode = JWT::decode($token,  new Key($_ENV['KEY'], 'HS256'));
            echo json_encode($decode);
        } catch (\Throwable $th) {
            echo json_encode(['status' => 401, 'message' => $th->getMessage()]);
        }

        echo json_decode($token);
    }

    public function refreshToken()
    {
        $authorization = $_SERVER["HTTP_AUTHORIZATION"];

        $token = str_replace("Bearer ", "", $authorization);

        try {
            $decode = JWT::decode($token,  new Key($_ENV['KEY'], 'HS256'));
            $this->createNewToken($decode->email);
        } catch (\Throwable $th) {
            echo json_encode(['status' => 401, 'message' => $th->getMessage()]);
        }
    }

    public function createNewToken($email)
    {
        
        $payload = [
            "exp" => time() + 10,
            "iat" => time(),
            "email" => $email,
        ];

        $encode = JWT::encode($payload, $_ENV['KEY'], 'HS256');

        echo json_encode(['jwt' => $encode]);
    }
}
