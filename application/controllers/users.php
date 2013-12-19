<?php

use Shared\Controller as Controller;
use Framework\Registry as Registry;
use Framework\RequestMethods as RequestMethods;

class Users extends Controller
{
    public function register()
    {
        if (RequestMethods::post("register"))
        {
            $first = RequestMethods::post("first");
            $last = RequestMethods::post("last");
            $email = RequestMethods::post("email");
            $password = RequestMethods::post("password");

            $view = $this->getActionView();
            $error = false;

            if (empty($first))
            {
                $view->set("first_error", "Nie podano imienia");
                $error = true;
            }

            if (empty($last))
            {
                $view->set("last_error", "Nie podano nazwiska");
                $error = true;
            }

            if (empty($email))
            {
                $view->set("email_error", "Nie podano adresu e-mail");
                $error = true;
            }

            if (empty($password))
            {
               $view->set("password_error", "Nie podano hasła");
               $error = true;
            }

            if (!$error)
            {
                $user = new User(array(
                    "first" => $first,
                    "last" => $last,
                    "email" => $email,
                    "password" => $password
                ));

                $user->save();
                $view->set("success", true);
            }
        }
    }

    public function login()
    {
        if (RequestMethods::post("login"))
        {
            $email = RequestMethods::post("email");
            $password = RequestMethods::post("password");

            $view = $this->getActionView();
            $error = false;

            if (empty($email))
            {
                $view->set("email_error", "Nie podano adresu e-mail");
                $error = true;
            }

            if (empty($password))
            {
               $view->set("password_error", "Nie podano hasła");
               $error = true;
            }

            if (!$error)
            {
                $user = User::first(array(
                    "email = ?" => $email,
                    "password = ?" => $password,
                    "live = ?" => true,
                    "deleted = ?" => false
                ));

                if (!empty($user))
                {
                    $session = Registry::get("session");
                    $session->set("user", serialize($user));

                    header("Location: /mvc2/public/users/profile.html");
                    exit();
                }
                else
                {
                    $view->set("password_error", "Niepoprawny adres e-mail lub niewłaściwe hasło");
                }
            }
        }
    }

    public function profile()
    {
        $session = Registry::get("session");
        $user = unserialize($session->get("user", null));

        if (empty($user))
        {
            $user = new StdClass();
            $user->first = "Pan";
            $user->last = "Kowalski";
        }

        $this->getActionView()->set("user", $user);
    }
}
