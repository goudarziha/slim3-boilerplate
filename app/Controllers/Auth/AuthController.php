<?php
    namespace App\Controllers\Auth;
    use App\Controllers\Controller;
    use App\Models\User;
    use Respect\Validation\Validator as v;

    class AuthController extends Controller {


        public function getAdminSignIn($request, $response) {
            if ($this->auth->checkAdmin()) {
                return $response->withRedirect($this->router->pathFor('admin.dash'));
            };
            return $this->view->render($response, 'auth/adminsignin.twig');
        }


        public function postAdminSignIn($request, $response) {

            $authAdmin = $this->auth->verifyAdmin(
                $request->getParam('email'),
                $request->getParam('password')
            );

            if (!$authAdmin) {
                $this->flash->addMessage('error', 'Could not sign you in.');
                return $response->withRedirect($this->router->pathFor('admin.signin'));
            };

            return $response->withRedirect($this->router->pathFor('admin.dash'));
        }


        public function getAdminDashboard($request, $response) {
            return $this->view->render($response, 'admin/dashboard.twig');
        }


        public function getSignOut($request, $response) {
            $this->auth->logout();
            return $response->withRedirect($this->router->pathFor('home'));
        }


        public function getSignIn($request, $response) {
            return $this->view->render($response, 'auth/signin.twig');
        }


        public function postSignIn($request, $response) {
            $auth = $this->auth->attempt(
                $request->getParam('email'),
                $request->getParam('password')
            );
            
            if (!$auth) {
                $this->flash.addMessage('error', 'Could not sign you in.');
                return $response->withRedirect($this->router->pathFor('auth.signin'));
            };

            return $response->withRedirect($this->router->pathFor('home'));
        }


        public function getSignUp($request, $response) {
            return $this->view->render($response, 'auth/signup.twig');
        }


        public function postSignUp($request, $response) {
            $validation = $this->validator->validate($request, [
                'email' => v::noWhitespace()->notEmpty()->email()->EmailAvailable(),
                'name' => v::notEmpty()->alpha(),
                'password' => v::noWhitespace()->notEmpty()
            ]);

            if ($validation->failed()) {
                return $response->withRedirect($this->router->pathFor('auth.signup'));
            }

            $user = User::create([
                'email' => $request->getParam('email'),
                'name' => $request->getParam('name'),
                'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT, ['cost' => 10]),
                'admin' => 0
            ]);

            $this->flash->addMessage('info', 'You have been signed up!');

            $this->auth->attempt($user->email, $request->getParam('password'));

            return $response->withRedirect($this->router->pathFor('home'));
        }
    }
?>
