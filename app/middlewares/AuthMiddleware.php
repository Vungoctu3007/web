<?php
class AuthMiddleware extends Middlewares {
    public function handle() {
        if(Session::data('admin_login')) {
            $response = new Response();
            $response->redirect('trang-chu');
        }
    }
}