<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get('user_role')->result_array();

        $this->form_validation->set_rules('role', 'Role', 'required');
        
        if($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/role', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_role', ['role' => $this->input->post('role')]);
            $this->session->set_flashdata('message', '
                <div class="alert alert-success" role="alert">
                    Add Role Success! 
                </div>');
                redirect('admin/role');
        }
    }

    public function roleaccess($role_id)
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/roleaccess', $data);
        $this->load->view('templates/footer');
    }

    public function changeaccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');
    
        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }

        $this->session->set_flashdata('message', '
        <div class="alert alert-success" role="alert">
            Access Changed! 
        </div>');
    }

    public function editRole($id)
    {
        $data['role'] = $this->db->get('user_role')->result_array();
        $this->form_validation->set_rules('role', 'Role', 'required');

        if($this->form_validation->run() == true){

            $this->db->where('id', $id);
            $this->db->update('user_role', ['role' => $this->input->post('role')]);
                $this->session->set_flashdata('message', '
                    <div class="alert alert-success" role="alert">
                        Edit Role Success! 
                    </div>');
                    redirect('admin/role');
        } else {
            $this->session->set_flashdata('message', '
                    <div class="alert alert-danger" role="alert">
                        Edit Menu Failed! 
                    </div>');
            redirect('menu');
        }
    }

    public function deleteRole($id)
    {
        $data = $this->db->where('id', $id);
        $this->db->delete('user_role', $data);
        $this->session->set_flashdata('message', '
                <div class="alert alert-success" role="alert">
                    Delete Role Success! 
                </div>');
        redirect('admin/role');
    }

    public function userManagement()
    {
        $data['title'] = 'User Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['users'] = $this->db->get('user')->result_array();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/usermanagement', $data);
        $this->load->view('templates/footer');
    }

    public function userDetail($user_id)
    {
        {
            $data['title'] = 'User Detail';
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    
            $data['users'] = $this->db->get_where('user', ['id' => $user_id])->result_array();
            
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/userdetail', $data);
            $this->load->view('templates/footer');
        }
    }

    public function deleteUser($id)
    {
        {
            $data = $this->db->where('id', $id);
            $this->db->delete('user', $data);
            $this->session->set_flashdata('message', '
                    <div class="alert alert-success" role="alert">
                        Delete User Success! 
                    </div>');
            redirect('admin/usermanagement');
        }
    }

    public function editUserManagement($id)
    {
        $data['user'] = $this->db->get('user')->result_array();
        $this->form_validation->set_rules('name', 'Name', 'required');


        if($this->form_validation->run() == true){

            $data = [
                'name' => $this->input->post('name'), 
                'role_id' => $this->input->post('role_id'),
                'is_active' => $this->input->post('is_active')
            ];

            $this->db->where('id', $id);
            $this->db->update('user', $data);
                $this->session->set_flashdata('message', '
                    <div class="alert alert-success" role="alert">
                        Edit User Success! 
                    </div>');
                    redirect('admin/usermanagement');
        } else {
            
            $this->session->set_flashdata('message', '
                    <div class="alert alert-danger" role="alert">
                        Edit User Failed! 
                    </div>');
            redirect('admin/usermanagement');
        }
    }


}