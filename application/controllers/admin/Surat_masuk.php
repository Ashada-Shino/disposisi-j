<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Surat_masuk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Masuk_model");
        cek_login();
        cek_user();
        $this->load->library('form_validation');
    }
    public function index()
    {
        $data = array(
            'title' => 'View Data Surat Masuk',
            'surat' => $this->Masuk_model->getAll(),
            'content' => 'admin/surat_masuk/index'
        );
        $this->load->view('admin/template/main', $data);
    }
    public function add()
    {
        $data = array(
            'title' => 'Tambah Data Surat Masuk',
            'content'=> 'admin/surat_masuk/add_form'  
        );
        $this->load->view('admin/template/main',$data);
    }

    public function save()
    {
        $this->Masuk_model->Save();
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata("success", "Data Surat Masuk Berhasil DiSimpan");
        }
        redirect('admin/surat_masuk');
    }
    public function getedit($id)
    {
        $data = array(
            'title' => 'Update Data Surat Masuk',
            'surat' => $this->Masuk_model->getById($id),
            'content' => 'admin/surat_masuk/edit_form'
        );
        $this->load->view('admin/template/main', $data);
    }
    public function edit()
    {
        $this->Masuk_model->editData();
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata("success", "Data user Berhasil DiUpdate");
        }
        redirect('admin/surat_masuk');
    }
    public function editData()
    {
        $id = $this->input->post('id');
        $updateimage = '';
        if (!empty($_FILES["image"]["name"])) {
            $updateimage = $this->do_upload();
        } else {
            $updateimage = $this->input->post('old_image');
        }
        $data = [
            'no_surat' => $this->input->post('no_surat'),
            'tgl_surat' => $this->input->post('tgl_surat'),
            'surat_from' => $this->input->post('surat_from'),
            'surat_to' => $this->input->post('surat_to'),
            'tgl_terima' => $this->input->post('tgl_terima'),
            'perihal' => $this->input->post('perihal'),
            'keterangan' => $this->input->post('keterangan'),
            'image' => $updateimage,
            'is_active' => '1',
        ];
        return $this->db->set($data)->where($this->primary, $id)->update($this->_table);
    }
    function delete($id)
    {
        $this->Masuk_model->delete($id);
        redirect('admin/surat_masuk');
    }


}