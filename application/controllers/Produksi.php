<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produksi extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();

		$this->load->library('tank_auth');
		

		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$this->data['dataUser'] = $this->session->userdata('data_ldap');

			$this->data['user_id'] = $this->tank_auth->get_user_id();
			$this->data['username'] = $this->tank_auth->get_username();
			$this->data['email'] = $this->tank_auth->get_email();

			$profile = $this->tank_auth->get_user_profile($this->data['user_id']);

			$this->data['profile_name'] = $profile['name'];
			$this->data['profile_foto'] = $profile['foto'];

			foreach ($this->tank_auth->get_roles($this->data['user_id']) as $val) {
				$this->data['role_id'] = $val['role_id'];
				$this->data['role'] = $val['role'];
				$this->data['full_name_role'] = $val['full'];
			}

			$this->data['link_active'] = 'Produksi';

			//buat permission
			if (!$this->tank_auth->permit($this->data['link_active'])) {
				redirect('Produksi');
			}

			$this->load->model("Showmenu_model");
			$this->data['ShowMenu'] = $this->Showmenu_model->getShowMenu();

			$OpenShowMenu = $this->Showmenu_model->getOpenShowMenu($this->data);

			$this->data['openMenu'] = $this->Showmenu_model->getDataOpenMenu($OpenShowMenu->id_menu_parent);

			$this->load->model("Menu_model");
            $this->load->model("Produksi_model");
		}
	}
 
	public function index()
	{
		$this->data['title'] = 'Produksi';

		$this->data['breadcrumbs'] = [];

		$this->data['breadcrumbs'][] = [
			'active' => FALSE,
			'text' => 'Produksi',
			'class' => 'breadcrumb-item pe-3 text-gray-400',
			'href' => site_url('Produksi')
		];

        $this->data['listProduksi'] = $this->Produksi_model->getAllProduksi();

		$this->load->view('component/header', $this->data);
		$this->load->view('component/sidebar', $this->data);
		$this->load->view('component/navbar', $this->data);
		$this->load->view('produksi/views', $this->data);
		$this->load->view('component/footer', $this->data);
	}

    public function add()
	{
		$this->form_validation->set_rules('produk', 'Produk', 'required');
		$this->form_validation->set_rules('name', 'Pegawai', 'required');
		$this->form_validation->set_rules('status_pengiriman', 'Status', 'required');
		$this->form_validation->set_rules('target_produksi', 'Terget Produksi', 'required');
		$this->form_validation->set_rules('hasil_produksi', 'Hasil Produksi', 'required');
		$this->form_validation->set_rules('reject', 'Reject', 'required');
		$this->form_validation->set_rules('stok', 'Stok', 'required');

		if ($this->form_validation->run() == TRUE) {

			$data = array(
				'id_produk' => decrypt_url($this->input->post('produk')),
				'id_pegawai' => decrypt_url($this->input->post('name')),
				'status_pengiriman' => $this->input->post('status_pengiriman'),
				'target_produksi' => $this->input->post('target_produksi'),
				'hasil_produksi' => $this->input->post('hasil_produksi'),
				'reject' => $this->input->post('reject'),
				'stok' => $this->input->post('stok')
			);

			$this->Produksi_model->addProduksi($data);

			redirect('Produksi');
		} else {
			$this->data['selected_produk'] = $this->input->post('produk');
			$this->data['selected_pegawai'] = $this->input->post('name');
			$this->data['status_pengiriman'] = $this->input->post('status_pengiriman');
			$this->data['target_produksi'] = $this->input->post('target_produksi');
			$this->data['hasil_produksi'] = $this->input->post('hasil_produksi');
			$this->data['reject'] = $this->input->post('reject');
			$this->data['stok'] = $this->input->post('stok');

			$this->data['listProduksi'] = $this->Produksi_model->getAllProduksi();
			$this->data['list_produk'] = $this->Produksi_model->getAllProduk();
			$this->data['list_pegawai'] = $this->Produksi_model->getAllPegawai();

			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['action'] = site_url('Produksi/add');
			$this->data['url'] = site_url('Produksi');
			$this->data['title'] = "Produksi";
	
			$this->data['breadcrumbs'] = [];
	
			$this->data['breadcrumbs'][] = [
				'active' => FALSE,
				'text' => 'Produksi / ',
				'class' => 'breadcrumb-item pe-3',
				'href' => ''
			];
	
			$this->data['breadcrumbs'][] = [
				'active' => TRUE,
				'text' => 'Tambah Produksi',
				'class' => 'breadcrumb-item pe-3 text-gray-400',
				'href' => site_url('Produksi/add')
			];

			$this->load->view('component/header', $this->data);
			$this->load->view('component/sidebar', $this->data);
			$this->load->view('component/navbar', $this->data);
			$this->load->view('produksi/form', $this->data);
			$this->load->view('component/footer');
		}
	}

	public function update($id_produksi)
    {
        $this->form_validation->set_rules('produk', 'Produk', 'required');
		$this->form_validation->set_rules('name', 'Pegawai', 'required');
		$this->form_validation->set_rules('status_pengiriman', 'Status', 'required');
		$this->form_validation->set_rules('target_produksi', 'Terget Produksi', 'required');
		$this->form_validation->set_rules('hasil_produksi', 'Hasil Produksi', 'required');
		$this->form_validation->set_rules('reject', 'Reject', 'required');
		$this->form_validation->set_rules('stok', 'Stok', 'required');

        if ($this->form_validation->run() == TRUE) {
			$value_produksi_update = $this->Produksi_model->getDataProduksi($id_produksi);

			$data = array(
				'id_produk' => decrypt_url($this->input->post('produk')),
				'id_pegawai' => decrypt_url($this->input->post('name')),
				'status_pengiriman' => $this->input->post('status_pengiriman'),
				'target_produksi' => $this->input->post('target_produksi'),
				'hasil_produksi' => $this->input->post('hasil_produksi'),
				'reject' => $this->input->post('reject'),
				'stok' => $this->input->post('stok')
			);

			$condition['id_produksi'] = $id_produksi;

			$this->Produksi_model->updateProduksi($data, $condition);

			redirect('produksi');
			
		} else {
			$this->data['selected_produk'] = $this->input->post('id_produk');
			$this->data['selected_pegawai'] = $this->input->post('id_pegawai');
			$this->data['status_pengiriman'] = $this->input->post('status_pengiriman');
			$this->data['target_produksi'] = $this->input->post('target_produksi');
			$this->data['hasil_produksi'] = $this->input->post('hasil_produksi');
			$this->data['reject'] = $this->input->post('reject');
			$this->data['stok'] = $this->input->post('stok');

			$this->data['list_produksi'] = $this->Produksi_model->getAllProduksi();
			$this->data['list_produk'] = $this->Produksi_model->getAllProduk();
			$this->data['list_pegawai'] = $this->Produksi_model->getAllPegawai();

			$value_produksi = $this->Produksi_model->getProduksi($id_produksi);

			$this->data['id_produksi'] = $id_produksi;
			$this->data['selected_produk'] = $value_produksi->id_produk;
			$this->data['selected_pegawai'] = $value_produksi->id_pegawai;
			$this->data['status_pengiriman'] = $value_produksi->status_pengiriman;
			$this->data['target_produksi'] = $value_produksi->target_produksi;
			$this->data['hasil_produksi'] = $value_produksi->hasil_produksi;
			$this->data['reject'] = $value_produksi->reject;
			$this->data['stok'] = $value_produksi->stok;

			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['action'] = site_url('produksi/update/' . $id_produksi);
			$this->data['url'] = site_url('produksi');
			$this->data['title'] = "Produksi";

			$this->data['breadcrumbs'] = [];

			$this->data['breadcrumbs'][] = [
				'active' => FALSE,
				'text' => 'Kelola Produksi / ',
				'class' => 'breadcrumb-item pe-3',
				'href' => ''
			];

			$this->data['breadcrumbs'][] = [
				'active' => TRUE,
				'text' => 'Produksi',
				'class' => 'breadcrumb-item pe-3 text-gray-400',
				'href' => site_url('produksi')
			];

			$this->load->view('component/header', $this->data);
			$this->load->view('component/sidebar', $this->data);
			$this->load->view('component/navbar', $this->data);
			$this->load->view('produksi/edit', $this->data);
			$this->load->view('component/footer');
		}
    }



	public function delete($id_produksi)
	{
		$condition['id_produksi'] = $id_produksi;

		$this->Produksi_model->deleteProduksi($condition);

		redirect('Produksi');
	}
}
