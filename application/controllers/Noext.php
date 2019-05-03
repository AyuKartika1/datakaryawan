<?php
Class Noext extends CI_Controller{
    
    var $API ="";
    
    function __construct() {
        parent::__construct();
        $this->API="http://api.tehsipp.com/index.php/noext";
                $this->load->library('session');
        $this->load->library('curl');
        $this->load->helper('form');
        $this->load->helper('url');
    }
    
    // menampilkan data kontak
    function index(){
        $data['kontak'] = json_decode($this->curl->simple_get($this->API.'/noext'));
        $this->load->view('noext/list',$data);
    }

    // insert data kontak
    function create(){
        if(isset($_POST['submit'])){
            $data = array(
                'id'=>$this->input->post('id'),
                'nik'=> $this->input->post('nik'),
                  'nama'=>$this->input->post('nama'),
                    'no'=>  $this->input->post('no'),
                      'jabatan'=>$this->input->post('jabatan'),
                        'divisi'=>$this->input->post('divisi'),
                'alamat'=>$this->input->post('alamat'));
            $insert =  $this->curl->simple_post($this->API.'/noext', $data, array(CURLOPT_BUFFERSIZE => 10)); 
            if($insert)
            {
                $this->session->set_flashdata('hasil','Insert Data Berhasil');
            }else
            {
               $this->session->set_flashdata('hasil','Insert Data Gagal');
            }
            redirect('noext');
        }else{
            $this->load->view('noext/create');
        }
    }

    // edit data kontak
    function edit(){
        if(isset($_POST['submit'])){
                $data = array(
                'id'       =>  $this->input->post('id'),
                'nik'      =>  $this->input->post('nik'),
                  'nama'      =>  $this->input->post('nama'),
                    'no'      =>  $this->input->post('no'),
                      'jabatan'      =>  $this->input->post('jabatan'),
                        'divisi'      =>  $this->input->post('divisi'),
                'alamat'=>  $this->input->post('alamat'));
            $update =  $this->curl->simple_put($this->API.'/noext', $data, array(CURLOPT_BUFFERSIZE => 10)); 
            if($update)
            {
                $this->session->set_flashdata('hasil','Update Data Berhasil');
            }else
            {
               $this->session->set_flashdata('hasil','Update Data Gagal');
            }
            redirect('noext');
        }else{
            $params = array('id'=>  $this->uri->segment(7));
            $data['kontak'] = json_decode($this->curl->simple_get($this->API.'/noext',$params));
            $this->load->view('noext/edit',$data);
        }
    }

    // delete data kontak
    function delete($id){
        if(empty($id)){
            redirect('noext');
        }else{
            $delete =  $this->curl->simple_delete($this->API.'/noext', array('id'=>$id), array(CURLOPT_BUFFERSIZE => 10)); 
            if($delete)
            {
                $this->session->set_flashdata('hasil','Delete Data Berhasil');
            }else
            {
               $this->session->set_flashdata('hasil','Delete Data Gagal');
            }
            redirect('noext');
        }
    }
}