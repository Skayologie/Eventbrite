<?php

namespace App\core;



use PDO;
use App\Models\UserModel;
use App\models\RegisteredUser;

class Auth
{
    private Model $CRUD;
    public function __construct() {}

    public function index($type)
    {
        $isAuth = Session::get("isAuth");
        if ($isAuth) {
            header("Location:/");
            return;
        }
        if ($type === "Login") {
            View::render("front/AuthPage", ["type" => "false"]);
        } else if ($type === "Register") {
            View::render("front/AuthPage", ["type" => "true"]);
        } else {
            View::render("layouts/404", ["type" => "true"]);
        }
    }
    public function register() {}
    public function login($email, $password)
    {
        $res = "hello this is your email, $email";
        return $res;
    }
    public function logout()
    {
        session_destroy();
        header("location:/Auth/Login");
    }

    public function googleLogin()
    {
        $clientId = '557785413491-op4gk9dar8jlji9t4d27s626ibg92mpc.apps.googleusercontent.com';
        $redirectUri = 'https://localhost:4444/auth/google/callback';
        $scope = 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email';
        $responseType = 'code';
        $url = "https://accounts.google.com/o/oauth2/auth?client_id={$clientId}&redirect_uri={$redirectUri}&scope={$scope}&response_type={$responseType}";

        header("Location: {$url}");
        exit();
    }

    public function googleCallback()
    {
        if (isset($_GET['code'])) {
            $code = $_GET['code'];
            $clientId = '557785413491-op4gk9dar8jlji9t4d27s626ibg92mpc.apps.googleusercontent.com';
            $clientSecret = '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';
            $redirectUri = 'https://localhost:4444/auth/google/callback';
            $tokenUrl = 'https://oauth2.googleapis.com/token';

            $tokenData = [
                'code' => $code,
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'redirect_uri' => $redirectUri,
                'grant_type' => 'authorization_code',
            ];

            $options = [
                'http' => [
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => http_build_query($tokenData),
                ],
            ];
            $context = stream_context_create($options);
            $result = file_get_contents($tokenUrl, false, $context);
            $tokenInfo = json_decode($result, true);

            if (isset($tokenInfo['access_token'])) {
                $accessToken = $tokenInfo['access_token'];
                $userInfoUrl = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $accessToken;
                $userInfo = file_get_contents($userInfoUrl);
                $userInfo = json_decode($userInfo, true);

                $userModel = new UserModel();
                $user = $userModel->findOrCreateByGoogleId($userInfo['id'], $userInfo);

                Session::set("userID", $user->getUserId());
                Session::set("roleID", $user->getRoleId());
                Session::set("email", $user->getEmail());
                Session::set("isAuth", true);

                header("Location: /");
                exit();
            }
        }

        echo "Failed to authenticate with Google.";
        exit();
    }
}
