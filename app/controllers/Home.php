<?php
class Home extends Controller {

    public $model_home, $data;
    
    public function __construct(){
        $this->model_home = $this->model('HomeModel');
    }

    public function index(){
        $this->data = $this->model_home->getList();
        $this->data['sub_content']['categories'] = $this->model_home->getAllCategories();
        $this->data['sub_content']['advertisement'] = $this->model_home->getAllAdvertisement();
        $this->data['sub_content']['featureProduct'] = $this->model_home->getFeatureProduct();
        $this->data['content'] = 'home/index';
        $this->render('layout/client_layout', $this->data);
    }

    public function login() {
        $this->data['errors'] = Session::flash('errors');
        $this->data['old'] = Session::flash('old');
        $this->render('blocks/login', $this->data);
    }

    public function signin() {
        $request = new Request();

        if($request->isPost()) {
            $request->rules([
                'username' => 'required|min:5|max:30',
                'password' => 'required|min:6'
            ]);

            $request->message([
                'username.required' => 'Họ tên không được để trống',
                'username.min' => 'Họ tên phải lớn hơn 5 ký tự',
                'username.max' => 'Họ tên phải nhỏ hơn 30 ký tự',
                'password.required' => 'Mật khẩu không được để trống',
                'password.min' => 'Mật khẩu phải lớn hơn 3 ký tự'
            ]);
            $validate = $request->validate();
            if(!$validate) {
                Session::flash('errors', $request->errors());
                Session::flash('old', $request->getFields());
            }
        }
        $response = new Response();
        
        $username = $request->getFields()['username'];
        $password = $request->getFields()['password'];
        $data = $this->model_home->getUserByUsername($username);

        if($data) {
            if($password == $data[0]['password'] && $data[0]['role_id'] == 1) {
                $name = $data[0]['ten'];
                Session::data('name', $name);
                Session::data('admin_login', true);
                $response->redirect('home');
            }elseif($password == $data[0]['password'] && $data[0]['role_id'] == 0){
                $response->redirect('admin/dashboard');
            }else {
                $response->redirect('home/login');
            }
        }else {
            $response->redirect('home/login');
        }
    }

    public function get_user() {
        $this->data['msg'] = Session::flash('msg');
        $this->data['errors'] = Session::flash('errors');
        $this->data['old'] = Session::flash('old');
        $this->render('users/add', $this->data);
    }

    public function post_user() {
        $request = new Request();

        if($request->isPost()) {
            // Set rules
            $request->rules([
                'fullname' => 'required|min:5|max:30',
                'email' => 'required|email|min:6|unique:users:email',
                'password' => 'required|min:3',
                'confirm_password' => 'required|match:password',
                'age' => 'required|callback_check_age'
            ]);

            // Set message
            $request->message([
                'fullname.required' => 'Họ tên không được để trống',
                'fullname.min' => 'Họ tên phải lớn hơn 5 ký tự',
                'fullname.max' => 'Họ tên phải nhỏ hơn 30 ký tự',
                'email.required' => 'Email không được để trống',
                'email.email' => 'Định dạng email không hợp lệ',
                'email.min' => 'Email phải lớn hơn 6 ký tự',
                'email.unique' => 'Email đã tồn tại trong hệ thống',
                'password.required' => 'Mật khẩu không được để trống',
                'password.min' => 'Mật khẩu phải lớn hơn 3 ký tự',
                'confirm_password.required' => 'Nhập lại mật khẩu không được để trống',
                'confirm_password.match' => 'Mật khẩu nhập lại không khớp',
                'age.required' => 'Tuổi không được để trống',
                'age.callback_check_age' => 'Tuổi không được nhỏ hơn 20'
            ]);

            $validate = $request->validate();
            if(!$validate) {
                Session::flash('msg', 'Đã có lỗi xảy ra. Vui lòng kiểm tra lại');
                Session::flash('errors', $request->errors());
                Session::flash('old', $request->getFields());
            }
        }
        $response = new Response();
        $response->redirect('home/get_user');

    }

    public function check_age($age){
        if ($age>=20) return true;
        return false;
    }
}