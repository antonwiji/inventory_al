<?php
defined("BASEPATH") or exit();

Class MdQr extends CI_Model{

    public function get_stock($id) {
        $sql = query("SELECT jml FROM cc_terima WHERE id = '$id'");

        $sql2 = query("SELECT jml FROM cc_kirim WHERE id = '$id'");

        

        return $sql->result_array();
    }


}