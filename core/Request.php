<?php
class Request {

    // tao mang luu gia tri truyen vao
    private $__rules = [], $__messages = [], $__errors = [];
    public $db;

    function __construct(){
        $this->db = new Database();
    }
    /**
     * 1. Method
     * 2. Body
     */
    public function getMethod() {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isPost() {
        if($this->getMethod() == 'post') {
            return true;
        }
        return false;
    }

    public function isGet() {
        if($this->getMethod() == 'get') {
            return true;
        }
        return false;
    }

    public function getFields() {
        $dataFields = [];

        if ($this->isGet()){
            //Xử lý lấy dữ liệu với phương thức get
            if (!empty($_GET)){
                foreach ($_GET as $key=>$value){
                    // Nếu dữ liệu là dạng mảng mới thêm FILTER_REQUIRE_ARRAY
                    if (is_array($value)){
                        $dataFields[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    }else{
                        $dataFields[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }

        if ($this->isPost()){
            //Xử lý lấy dữ liệu với phương thức post
            if (!empty($_POST)){
                foreach ($_POST as $key=>$value){
                    if (is_array($value)){
                        $dataFields[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    }else{
                        $dataFields[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }
        return $dataFields;
    }

    //set rules
        public function rules($rules=[]){
        $this->__rules = $rules;

    }

    //set message
    public function message($messages=[]) {
        $this->__messages = $messages;

    }

    //run validate

    public function validate() {
        
        $this->__rules = array_filter($this->__rules);

        $checkValidate = true;

        if(!empty($this->__rules)) {
            $dataFields = $this->getFields();

            foreach($this->__rules as $fieldName=>$ruleItem) {
                $ruleItemArr = explode('|', $ruleItem);
                foreach($ruleItemArr as $rules) {
                    $ruleName = null;
                    $ruleValue = null;

                    $rulesArr = explode(':', $rules);

                    // đưa con trỏ về phần tử đầu tiên của mảng
                    $ruleName = reset($rulesArr);

                    if(count($rulesArr) > 1) {
                        // lấy phần tử cuối mảng
                        $ruleValue = end($rulesArr);
                    }

                    if($ruleName == 'required') {
                        // Kiểm tra xem input có trống không
                        if(empty($dataFields[$fieldName])) {
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if ($ruleName=='min'){
                        if (strlen(trim($dataFields[$fieldName]))<$ruleValue){
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if ($ruleName=='max'){
                        if (strlen(trim($dataFields[$fieldName]))>$ruleValue){
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if ($ruleName=='email'){
                        if (!filter_var($dataFields[$fieldName], FILTER_VALIDATE_EMAIL)){
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if ($ruleName=='match'){

                        if (trim($dataFields[$fieldName])!=trim($dataFields[$ruleValue])){
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }
                
                }
            }
        }
        return $checkValidate;
    }

    //get errors
    public function errors($fieldName=''){
        if (!empty($this->__errors)){
            if (empty($fieldName)){
                $errorsArr = [];
                foreach ($this->__errors as $key=>$error){
                    $errorsArr[$key] = reset($error);
                }
                return $errorsArr;
            }

            return reset($this->__errors[$fieldName]);
        }

        return false;
    }

    public function setErrors($fieldName, $ruleName) {
        $this->__errors[$fieldName][$ruleName] = $this->__messages[$fieldName.'.'.$ruleName];
    }
}