<?php
    namespace App\Controllers;
    use Slim\Views\Twig as View;
    use App\Models\User;

    class HomeController extends Controller {

        public function index($request, $response) {
            if ($this->auth->check()) {
                $this->auth->user()->updateLastTime();
                return $this->view->render($response, 'user.twig');
            }
            return $this->container->view->render($response, 'home.twig');
        }

        public function loggedIndex($request, $response) {
            $user = $this->auth->user();
            return $this->container->view(render($response, 'home.twig'));
        }
    }
?>
