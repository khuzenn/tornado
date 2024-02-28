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

    public function add() {
        $this->form_validation->set_rules('kategori_produk', 'Kategori Produk', 'required');
        $this->form_validation->set_rules('produk', 'Produk', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'id_kategori_produk' => decrypt_url($this->input->post('kategori_produk')),
                'produk' => $this->input->post('produk'),
                'harga' => $this->input->post('harga')
            );

            $this->Produk_model->addProduk($data);

            redirect('Produk');
        } else {
            $this->data['selected_kategori_produk'] = $this->input->post('kategori_produk');
            $this->data['produk'] = $this->input->post('produk');
            $this->data['harga'] = $this->input->post('harga');

            $this->data['list_kategori_produk'] = $this->Produk_model->getAllKategoriProduk();

            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['action'] = site_url('Produk/add');
            $this->data['url'] = site_url('Produk');
            $this->data['title'] = "Produk";

            $this->data['breadcrumbs'] = [];

            $this->data['breadcrumbs'][] = [
                'active' => FALSE,
                'text' => 'Produk / ',
                'class' => 'breadcrumb-item pe-3',
                'href' => ''
            ];

            $this->data['breadcrumbs'][] = [
                'active' => TRUE,
                'text' => 'Tambah Produk',
                'class' => 'breadcrumb-item pe-3 text-gray-400',
                'href' => site_url('Produk/add')
            ];

            $this->load->view('component/header', $this->data);
            $this->load->view('component/sidebar', $this->data);
            $this->load->view('component/navbar', $this->data);
            $this->load->view('produk/form', $this->data);
            $this->load->view('component/footer');
        }
    }

	public function update($id_produk)
    {
        $this->form_validation->set_rules('kategori_produk', 'Kategori Produk', 'required');
        $this->form_validation->set_rules('produk', 'Produk', 'required|trim');
        $this->form_validation->set_rules('harga', 'Harga', 'required|trim');

        if ($this->form_validation->run() == TRUE) {
			$value_produk_update = $this->Produk_model->getDataProduk($id_produk);

			$data = array(
				'id_kategori_produk' => decrypt_url($this->input->post('kategori_produk')),
				'produk' => $this->input->post('produk'),
				'harga' => $this->input->post('harga')
			);

			$result = $this->Produk_model->updateProduk(($id_produk), $data);

			if ($result) {
				$this->session->set_flashdata('msg', 'Anda berhasil menyunting data produk');

				redirect('produk');
			}
		} else {
			$this->data['selected_kategori_produk'] = $this->input->post('kategori_produk');
			$this->data['produk'] = $this->input->post('produk');
			$this->data['harga'] = $this->input->post('harga');

			$this->data['list_kategori_produk'] = $this->Produk_model->getAllKategoriProduk();

			$value_produk = $this->Produk_model->getDataProduk($id_produk);

			$this->data['id_produk'] = $id_produk;
			$this->data['selected_kategori_produk'] = $value_produk->id_kategori_produk;
			$this->data['produk'] = $value_produk->produk;
			$this->data['harga'] = $value_produk->harga;

			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['action'] = site_url('produk/update/' . $id_produk);
			$this->data['url'] = site_url('produk');
			$this->data['title'] = "Produk";

			$this->data['breadcrumbs'] = [];

			$this->data['breadcrumbs'][] = [
				'active' => FALSE,
				'text' => 'Kelola Produk / ',
				'class' => 'breadcrumb-item pe-3',
				'href' => ''
			];

			$this->data['breadcrumbs'][] = [
				'active' => TRUE,
				'text' => 'Produk',
				'class' => 'breadcrumb-item pe-3 text-gray-400',
				'href' => site_url('produk')
			];

			$this->load->view('component/header', $this->data);
			$this->load->view('component/sidebar', $this->data);
			$this->load->view('component/navbar', $this->data);
			$this->load->view('produk/form', $this->data);
			$this->load->view('component/footer');
		}
    }



	public function delete($id_produk)
	{
		$condition['id_produk'] = $id_produk;

		$this->Produk_model->deleteProduk($condition);

		redirect('Produk');
	}
}
