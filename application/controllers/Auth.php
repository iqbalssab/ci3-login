<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        // Kalo udah login, tendang pake fungsi dibawah,
        // biar gabisa masuk login lg, sebelum logout
        $this->goToDefaultPage();
        
        // Validasi
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if($this->form_validation->run() == false){
            $data['title'] = 'Login Form';
    
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login' );
            $this->load->view('templates/auth_footer');
        } else {
            // Validasi success
            $this->_login();
        }

    }

    private function _login()
    {

        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();
        
        // kalo user nya ada
        if($user){
            // kalo usernya aktif
            if($user['is_active'] == 1){
                // cek password
                if(password_verify($password, $user['password'])){
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];

                    $this->session->set_userdata($data);
                    if($user['role_id'] == 1){
                        redirect('admin');
                    } else {
                        redirect('user');
                    }

                } else{
                    $this->session->set_flashdata('message', '
                <div class="alert alert-danger" role="alert">
                    Wrong Password! 
                </div>');
            redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '
                <div class="alert alert-danger" role="alert">
                    This email, hasnt been activated! 
                </div>');
            redirect('auth');
            }

        } else {
            // user ga ada
            $this->session->set_flashdata('message', '
                <div class="alert alert-warning" role="alert">
                    Email is not registered yet!
                </div>');
            redirect('auth');
        }
    }
    
    public function registration()
    { 
        // Kalo udah login, tendang pake fungsi dibawah,
        // biar gabisa masuk registration lg, sebelum logout
        $this->goToDefaultPage();

        // Menentukan aturan untuk pengisian form registration
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'this email has already registered'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[4]|matches[password2]', [
            'matches' => 'password not match!',
            'min_length' => 'Password to short!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Registrasi Akun';
    
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');   
        } else {
            $email = $this->input->post('email', true);
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($email),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 0,
                'date_created' => time()
            ];

            // siapkan token
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' => time()
            ];

            // insert ke table 'user'
            $this->db->insert('user', $data);
            // insert ke table user_token'
            $this->db->insert('user_token', $user_token);

            $this->_sendEmail($token, 'verify');

            $this->session->set_flashdata('message', '
                <div class="alert alert-success" role="alert">
                    Your Account has been created! Please Activate in your email!
                </div>');
            redirect('auth');
        }
    }

    private function _sendEmail($token, $type){
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'ibenkjazzy@gmail.com',
            'smtp_pass' => 'jtqnnsznjlpytbit',
            'smtp_port' => 465,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];

        // Load Library dari Codeigniter
        $this->email->initialize($config);

        $this->email->from('ibenkjazzy@gmail.com', 'Admin Ibenk');
        $this->email->to($this->input->post('email'));

        if($type == 'verify'){
            $this->email->subject('Account Verification');
            $this->email->message('Click this link, to verify your account : <a href="'. base_url() .'auth/verify?email=' . $this->input->post('email') . '&token=' .urlencode($token). '">Activate!</a>');
        }

        if($this->email->send()){
            return true;
        } else{
            echo $this->email->print_debugger();
            die;
        }
        
    }

    public function verify()
    {
        // ambil email dari url, dgn method GET
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        // cek email di url sama dg email di table user apa engga?
        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        // cek, kalo emailnya sama dg di tabel user
        if($user){
            // cek token di url sama dg email di table user_token apa engga?
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            // cek, kalo tokennya sama dg di tabel user_token
            if($user_token){
                // cek masa berlaku token, < 24jam?
                if(time() - $user_token['date_created'] < (60*60*24)) {
                    
                    // kalo masih berlaku, aktifin
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    // delete token dari tabel user_token
                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('message', '
                    <div class="alert alert-success" role="alert">
                        '. $email .' has been activated! Please Login
                    </div>');
                    redirect('auth');
                } else {
                    // kalo expired (>24 jam)
                    // delete user yg baru dibuat
                    $this->db->delete('user', ['email' => $email]);
                    // delete token nya juga
                    $this->db->delete('user_token', ['email' => $email]);
                    // tampilin pesan erornya
                    $this->session->set_flashdata('message', '
                    <div class="alert alert-warning" role="alert">
                        TOKEN EXPIRED!
                    </div>');
                redirect('auth'); 
                }
            } else{
                // kalo tokennya gada di DB
                $this->session->set_flashdata('message', '
                <div class="alert alert-danger" role="alert">
                    Account Activation Failed! Wrong Token!
                </div>');
            redirect('auth');
            }
        } else {
            // kalo ga ada email di db
            $this->session->set_flashdata('message', '
                <div class="alert alert-danger" role="alert">
                    Account Activation Failed! Wrong Email!
                </div>');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata('message', '
                <div class="alert alert-success" role="alert">
                    You Has been Logout
                </div>');
            redirect('auth');
    }

    public function blocked()
    {
        $this->load->view('auth/blocked');
    }

    public function goToDefaultPage() {
        if ($this->session->userdata('role_id') == 1) {
          redirect('admin');
        } else if ($this->session->userdata('role_id') == 2) {
          redirect('user');
        } else {
          // jika ada role_id yg lain maka tambahkan disini
        }
      }

}