<?php
defined("BASEPATH") or exit();

Class Qr extends CI_Controller{
	
	public function index(){
        $curr = shortcode_login();
        $data['curr'] = $curr;

        $this->load->model("mdqr");
        $content['id'] = $_GET['id'];
        $tes = $this->mdqr->get_stock($content['id']);
        $jml = $tes[0]["jml"];
        $row = $this->cms->get_page("cc_master", $content['id']);
        $data['title'] = "Detail Items : $row[nama]";
        $data['nama'] = $row['nama'];
        $tgl = date_create($row['tgl']);
        $data['tanggal'] = date_format($tgl, 'd/M/Y');
        $data['harga'] =  $row['harga'];
        $data['jml'] = $jml;

		$this->load->view("header",$data);
		$this->load->view("qr", $content);
		$this->load->view("footer");
	}
}