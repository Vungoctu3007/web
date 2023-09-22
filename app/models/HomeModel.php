<?php
class HomeModel extends Model{
    protected $_table = '';

    function tableFill() {
        return '';
    }

    function fieldFill() {
        return '';
    }

    function primaryKey() {
        return '';
    }

    public function getUserByUsername($username) {
        $data = $this->db->table('user')->where('username', '=', $username)->get();
        return $data;
    }

    public function getList() {
        $data = $this->db->table('product')->get();
        return $data;
    }

    public function getAllCategories() {
        $data = $this->db->table('category')->get();
        return $data;
    }

    public function getAllAdvertisement() {
        $data = $this->db->table('advertisement')->get();
        return $data;
    }

    public function getFeatureProduct() {
        $data = $this->db->table('product')->where('created_at', '>', '2023-07-01')->get();
        return $data;
    }
}