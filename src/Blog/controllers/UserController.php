<?php
/**
 * Created by PhpStorm.
 * User: dgilan
 * Date: 10/17/14
 * Time: 12:41 PM
 */

namespace Blog\Controllers;

use Blog\Models\User;
use Blog\Models\UserSession;
use Framework\Config\Config;
use Framework\Controller\Controller;
use Framework\Exception\FrameworkException;
use Framework\Model\Form;
use Framework\Security\Hash;
use Framework\Validation\Validator;

class UserController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = new User();

        $sessionName = Config::getSetting('user_session');
        $cookieName  = Config::getSetting('remember');

        $session = $this->getRequest()->getSession();
        $cookie  = $this->getRequest()->getCookie();

        if ($session->exists($sessionName)) {
            $id = $session->get($sessionName);

            $this->user->load(
                array(
                    'id' => $id
                )
            );
        } elseif ($cookie->exists($cookieName)) {
            $hash        = $cookie->get($cookieName);
            $userSession = new UserSession();
            $userSession->load(
                array(
                    'hash' => $hash
                )
            );

            $this->user->load(array(
                'id' => $userSession->getUserId())
            );
        }
    }

    public function signinAction()
    {

        $request        = $this->getRequest();
        $templateEngine = $this->getTemplateEngine();

        if ($request->isMethod('POST')) {
            try{
                $user = new User();
                $form = new Form($user);

                if ($form->isValid()) {

                    $form->bindDataToModel();
                    $user->setSalt(Hash::salt(32));
                    $user->setPassword(Hash::make($user->getPassword(), $user->getSalt()));
                    $user->setRole('USER');
                    $user->setJoined(date('Y-m-d H:i:s'));
                    $user->save();

                    $router   = $this->getRouter();
                    $session  = $request->getSession();
                    $redirect = $this->getResponseRedirect();

                    $session->flash('home', 'You have been registered and can now log in!');
                    $redirect->to($router->generateRoute('home'));
                    exit();
                } else {
                    $errors = Validator::getErrorList();
                    $templateEngine->setData('errors', $errors);
                    $templateEngine->render('signin.html');
                }
            } catch(FrameworkException $e){
                $templateEngine->setData('message', $e->getMessage());
                $templateEngine->render('500.html.php');
            }
        } else {
            $templateEngine->render('signin.html');
        }
    }

    public function loginAction()
    {

        $templateEngine = $this->getTemplateEngine();
        $request        = $this->getRequest();

        if ($request->isMethod('POST')) {
            try{
                $user = new User();
                $user->load(
                    array(
                        'login' => $request->getPost('login')
                    )
                );

                if (!empty($user->login)) {
                    $password = Hash::make($request->getPost('password'), $user->getSalt());
                    if ($user->getPassword() === $password) {
                        $remember = $request->getPost('remember');
                        $path     = '/';
                        if ($remember === 'yes') {
                            $hash = Hash::unique();

                            $userSession = new UserSession();
                            $userSession->setUserId($user->getId());
                            $userSession->setHash($hash);
                            $userSession->save();

                            $cookie = $request->getCookie();
                            $cookie->add(Config::getSetting('remember'), $hash);
                            $cookie->send();

                            $path = $cookie->get('previousPage');
                        }

                        $redirect = $this->getResponseRedirect();
                        $redirect->to($path);
                        exit();
                    }
                }
                $templateEngine->setData('message', 'Invalid login or password');
                $templateEngine->render('login.html');
            } catch(FrameworkException $e){
                $templateEngine->render('500.html.php');
            }
        } else {
            $templateEngine->render('login.html');
        }
    }

    public function isAuthenticated()
    {
        $id = $this->user->getId();
        return isset($id);
    }

    public function logoutAction()
    {
        $userSession = new UserSession();
        $userSession->load(
            array(
                'user_id' => $this->user->getId()
            )
        );
        $userSession->remove();
        $session = $this->getRequest()->getSession();
        $cookie  = $this->getRequest()->getCookie();

        $session->remove(Config::getSetting('user_session'));
        $cookie->remove(Config::getSetting('remember'));
        $redirect = $this->getResponseRedirect();
        $redirect->to('/');
    }
}