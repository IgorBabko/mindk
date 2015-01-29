<?php
/**
 * Created by PhpStorm.
 * User: dgilan
 * Date: 10/17/14
 * Time: 12:41 PM
 */

namespace Blog\Controllers;

use Blog\Models\Post;
use Blog\Models\User;
use Blog\Models\Category;
use Framework\Config\Config;
use Framework\Controller\Controller;
use Framework\Exception\FrameworkException;
use Framework\Model\Form;
use Framework\Security\Hash;
use Framework\Validation\Validator;

class UserController extends Controller
{
    public function signupAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        $session->start();
        $templateEngine = $this->getTemplateEngine();

        if ($request->isMethod('POST')) {
            $user = new User();
            $form = new Form($user, 'signup');

            $wrongFile   = false;
            $picturePath = null;
            $pictureName = null;
            if (empty($_FILES['profile_image']['name'])) {
                $wrongFile = false;
            } else {
                $allowed = array('jpg', 'jpeg', 'gif', 'png');

                $fileName     = $_FILES['profile_image']['name'];
                $fileInfo     = explode('.', $fileName);
                $fileExtn     = strtolower(end($fileInfo));
                $fileTempPath = $_FILES['profile_image']['tmp_name'];

                if (in_array($fileExtn, $allowed) === true) {
                    $pictureName = substr(md5(time()), 0, 10).'.'.$fileExtn;
                    $picturePath = 'uploads/'.$pictureName;
                    move_uploaded_file($fileTempPath, $picturePath);
                } else {
                    $wrongFile = true;
                    $templateEngine->setData('wrongFile', 'File type must be "jpg", "jpeg", "gif" or "png"');
                }
            }

            if ($form->isValid() && $wrongFile == false) {

                $form->bindDataToModel();
                $user->setPicturePath(
                    ($pictureName != null)?'/web/uploads/'.$pictureName:'/web/uploads/profile_icon_trim.png'
                );
                $user->setSalt(Hash::generateSalt(32));
                $user->setPassword(Hash::generatePass($user->getPassword(), $user->getSalt()));
                $user->setRole('USER');
                $user->setJoinedDate(date('Y-m-d H:i:s'));
                $user->save();

                $redirect = $this->getResponseRedirect();
                $session->flash(
                    'registered',
                    "<div class='flash-success well well-sm'>You have been registered and can now log in!</div>"
                );
                $redirect->route('signup');
                exit();
            } else {
                $errors = Validator::getErrorList();
                $templateEngine->setData('errors', $errors);
            }
        }

        $categories = Category::query('SELECT * FROM ?i', array(Category::getTable()));
        foreach ($categories as &$category) {
            $count             = Post::query(
                "SELECT COUNT(*) AS 'count' FROM ?i WHERE ?i = ?s",
                array(Post::getTable(), 'category', $category['name'])
            );
            $category['count'] = $count[0]['count'];
        }
        $totalAmountOfPosts = Post::query('SELECT COUNT(*) AS "count" FROM ?i', array(Post::getTable()))[0]['count'];
        array_unshift($categories, array('id' => 0, 'name' => 'All', 'count' => $totalAmountOfPosts));

        $templateEngine->setData('categories', $categories);
        $templateEngine->render(BLOG_LAYOUT, BLOG_VIEWS.'user/signup.html.php');
    }

    public function loginAction()
    {
        $templateEngine = $this->getTemplateEngine();
        $request        = $this->getRequest();
        $session        = $request->getSession();

        $categories = Category::query('SELECT * FROM ?i', array(Category::getTable()));
        foreach ($categories as &$category) {
            $count             = Post::query(
                "SELECT COUNT(*) AS 'count' FROM ?i WHERE ?i = ?s",
                array(Post::getTable(), 'category', $category['name'])
            );
            $category['count'] = $count[0]['count'];
        }
        $totalAmountOfPosts = Post::query('SELECT COUNT(*) AS "count" FROM ?i', array(Post::getTable()))[0]['count'];
        array_unshift($categories, array('id' => 0, 'name' => 'All', 'count' => $totalAmountOfPosts));

        $templateEngine->setData('categories', $categories);

        if ($request->isMethod('POST')) {
            try{
                $user = new User();
                $user->load(array('username' => $request->getPost('_username')));
                $username = $user->getUsername();
                if (isset($username)) {
                    $hashedPassword = Hash::generatePass($request->getPost('_password'), $user->getSalt());
                    if ($hashedPassword === $user->getPassword()) {

                        $remember = $request->getPost('remember');
                        if ($remember === 'yes') {
                            session_set_cookie_params(Config::getSetting('session_cookie_lifetime'));
                        }
                        $session->start();
                        $session->add(
                            'user',
                            array(
                                'name'    => $user->getUsername(),
                                'email'   => $user->getEmail(),
                                'picture' => $user->getPicturePath(),
                                'role'    => $user->getRole()
                            )
                        );
                        $redirect = $this->getResponseRedirect();
                        $session->flash(
                            'authenticated',
                            "<div class='flash-success well well-sm'>You have been logged in successfully!</div>"
                        );
                        $redirect->route('home');
                        exit();
                    }
                }
                $templateEngine->setData('fail', 'Invalid login or password');
            } catch(FrameworkException $e){
                $templateEngine->render(BLOG_LAYOUT, BLOG_VIEWS.'error.html.php');
            }
        }
        $templateEngine->render(BLOG_LAYOUT, BLOG_VIEWS.'user/login.html.php');
    }

    public function updateAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        $session->start();
        $templateEngine = $this->getTemplateEngine();

        $user = new User();
        $user->load(array('username' => $session->get('user')['name']));

        $categories = Category::query('SELECT * FROM ?i', array(Category::getTable()));
        foreach ($categories as &$category) {
            $count             = Post::query(
                "SELECT COUNT(*) AS 'count' FROM ?i WHERE ?i = ?s",
                array(Post::getTable(), 'category', $category['name'])
            );
            $category['count'] = $count[0]['count'];
        }
        $totalAmountOfPosts = Post::query('SELECT COUNT(*) AS "count" FROM ?i', array(Post::getTable()))[0]['count'];
        array_unshift($categories, array('id' => 0, 'name' => 'All', 'count' => $totalAmountOfPosts));

        $templateEngine->setData('categories', $categories);

        if ($request->isMethod('POST')) {
            try{
                $redirect = $this->getResponseRedirect();
                $form     = new Form($user, 'update');

                $wrongFile   = false;
                $picturePath = null;
                $pictureName = null;
                if (empty($_FILES['profile_image']['name'])) {
                    $wrongFile = false;
                } else {
                    $allowed = array('jpg', 'jpeg', 'gif', 'png');

                    $fileName     = $_FILES['profile_image']['name'];
                    $fileInfo     = explode('.', $fileName);
                    $fileExtn     = strtolower(end($fileInfo));
                    $fileTempPath = $_FILES['profile_image']['tmp_name'];

                    if (in_array($fileExtn, $allowed) === true) {
                        $pictureName = substr(md5(time()), 0, 10).'.'.$fileExtn;
                        $picturePath = 'uploads/'.$pictureName;
                        move_uploaded_file($fileTempPath, $picturePath);
                    } else {
                        $wrongFile = true;
                        $templateEngine->setData('wrongFile', 'File type must be "jpg", "jpeg", "gif" or "png"');
                    }
                }

                if ($form->isValid() && $wrongFile == false) {
                    $form->bindDataToModel();
                    $user->setPicturePath(
                        ($pictureName != null)?'/web/uploads/'.$pictureName:'/web/uploads/profile_icon_trim.png'
                    );
                    $user->save(array('username' => $session->get('user')['name']));
                    $session->add(
                        'user',
                        array(
                            'name'    => $user->getUsername(),
                            'email'   => $user->getEmail(),
                            'picture' => $user->getPicturePath(),
                            'role'    => $user->getRole()
                        )
                    );
                    $session->flash(
                        'updated',
                        "<div class='flash-success well well-sm'>Your data has been updated successfully!</div>"
                    );
                    $redirect->route('update');
                    exit();
                } else {
                    $errors = Validator::getErrorList();
                    $templateEngine->setData('errors', $errors);
                    $templateEngine->render(BLOG_LAYOUT, BLOG_VIEWS.'user/update.html.php');
                }
            } catch(FrameworkException $e){
                $templateEngine->setData('exception', $e);
                $templateEngine->render(BLOG_LAYOUT, BLOG_VIEWS.'error.html.php');
            }
        } else {
            $_POST['_username'] = $user->getUsername();
            $_POST['_email']    = $user->getEmail();
            $templateEngine->render(BLOG_LAYOUT, BLOG_VIEWS.'user/update.html.php');
        }
    }

    public function changePasswordAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        $session->start();
        $templateEngine = $this->getTemplateEngine();

        $categories = Category::query('SELECT * FROM ?i', array(Category::getTable()));
        foreach ($categories as &$category) {
            $count             = Post::query(
                "SELECT COUNT(*) AS 'count' FROM ?i WHERE ?i = ?s",
                array(Post::getTable(), 'category', $category['name'])
            );
            $category['count'] = $count[0]['count'];
        }
        $totalAmountOfPosts = Post::query('SELECT COUNT(*) AS "count" FROM ?i', array(Post::getTable()))[0]['count'];
        array_unshift($categories, array('id' => 0, 'name' => 'All', 'count' => $totalAmountOfPosts));

        $templateEngine->setData('categories', $categories);

        $user = new User();
        $user->load(array('username' => $session->get('user')['name']));

        if ($request->isMethod('POST')) {

            $currentPassword = $user->getPassword();
            $salt            = $user->getSalt();

            $form = new Form($user, 'change_password');
            if ($form->isValid()) {

                $redirect = $this->getResponseRedirect();
                if (Hash::generatePass($_POST['current_password'], $salt) !== $currentPassword) {
                    $session->flash(
                        'wrong_password',
                        "<div class='flash-error well well-sm-error'>Current password is wrong!</div>"
                    );
                    $redirect->route('change_password');
                    exit();
                }

                $user->setSalt(Hash::generateSalt(32));
                $user->setPassword(Hash::generatePass($request->getPost('_password'), $user->getSalt()));
                $user->save(array('username' => $session->get('user')['name']));

                $session->flash(
                    'password_changed',
                    "<div class='flash-success well well-sm'>Your password has been updated successfully!</div>"
                );
                $redirect->route('change_password');
                exit();
            } else {
                $errors = Validator::getErrorList();
                $templateEngine->setData('errors', $errors);
                $templateEngine->render(BLOG_LAYOUT, BLOG_VIEWS.'user/change_password.html.php');
            }
        } else {
            $templateEngine->render(BLOG_LAYOUT, BLOG_VIEWS.'user/change_password.html.php');
        }
    }

    public function logoutAction()
    {
        $session = $this->getRequest()->getSession();
        $session->start();
        $session->destroy();
        $this->getResponseRedirect()->to('/');
    }

    public function isAuthenticated()
    {
        $session = $this->getRequest()->getSession();
        if (!$session->isstarted()) {
            $session->start();
        }
        return $session->exists('user');
    }
}