<?php

namespace App\controllers;

use App\core\Auth;
use App\core\Database;
use App\core\Model;
use App\core\Session;
use App\core\View;
use App\mail\Mail;
use App\models\Orgnizer;
use App\models\Participant;
use App\models\RegisteredUser;
use App\models\User;
use App\models\UserModel;

class UserController
{
    private $db;
    private $Auth;
    public function __construct()
    {
        $UserDatabase = new Database();
    }
    public function index()
    {
        View::render("back/users", []);
    }
    public function register()
    {
        header('Content-Type: application/json');
        try {
            extract($_POST);

            $user = new RegisteredUser();
            $user->setFirstName($Registerfname);
            $user->setLastName($Registerlname);
            $user->setEmail($Registeremail);
            $user->setPassword($Registerpassword);
            $user->setBirthdate($Registerbirthdate);
            $user->setBio($Registerbio);
            $user->setRoleid(1);

            $userModel = new UserModel();
            if ($userModel->save($user)) {
                $WelcomeMail = new Mail();
                $WelcomeMail->Send($user);
                $resultQ = [
                    "status" => true,
                    "role" => "admin",
                    "message" => "Account Created Successfully !"
                ];
            } else {
                $resultQ = [
                    "status" => false,
                    "message" => "Failed , Account not created !"
                ];
            }
            echo json_encode($resultQ);
        } catch (\Exception $e) {
            Session::set("Error", $e->getMessage());
            $message = Session::get("Error");
            $resultQ = [
                "status" => false,
                "message" => $e->getMessage()
            ];
            echo json_encode($resultQ);
        }
    }

    public function login()
    {
        header('Content-Type: application/json');
        try {
            extract($_POST);

            $user = new RegisteredUser();
            $user->setEmail($Loginemail);

            $userModel = new UserModel();
            if ($userModel->check($user, $Loginpassword)) {
                $Crud = new Model();
                $result = $Crud->GetCheck("users", "email", $Loginemail)[0];
                Session::set("userID", $result["user_id"] ?? "");
                Session::set("roleID", $result["role_id"]);
                Session::set("email", $result["email"]);
                Session::set("avatar", $result["photo"]);
                Session::set("isAuth", true);
                $role = Session::get("roleID");
                if ($role === 3) {
                    $resultQ = [
                        "status" => true,
                        "role" => "admin",
                        "message" => "Logged Successfully"
                    ];
                } elseif ($role === 1) {
                    $resultQ = [
                        "status" => true,
                        "role" => "user",
                        "message" => "Logged Successfully"
                    ];
                }
            } else {
                Session::set("isAuth", false);
                $resultQ = [
                    "status" => false,
                    "role" => "notLogged",
                    "message" => "Failed , Informations incorrect !",
                ];
            }
            echo json_encode($resultQ);
        } catch (\Exception $e) {
            Session::set("isAuth", false);
            Session::set("Error", $e->getMessage());
            $message = Session::get("Error");
            $resultQ = [
                "status" => false,
                "role" => "notLogged",
                "message" => $e->getMessage()
            ];
            echo json_encode($resultQ);
        }
    }
    public function checkRole()
    {
        $role = Session::get("roleID");
        if ($role === 3) {
            header("Location:/Admin/Dashboard");
        } elseif ($role === 1) {
            header("Location:/");
        }
    }

    public function switch_role()
    {
        $role = Session::get("roleID");
        if ($role === 1) { //to be organizer
            $participant = new Participant();
            $participant->switch_role();
            Session::set("roleID", 2);
            header('location:/');
        } elseif ($role === 2) {
            //            $organizer = new Orgnizer();
            //            $organizer->switch_role();
            Session::set("roleID", 1);
            header('location:/');
        } else {
            echo "You dont have permission";
        }
    }

    // google

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
