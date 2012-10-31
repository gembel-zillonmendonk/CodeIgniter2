<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Account extends CI_Controller
{    
    public function login()
    {
        if (count($_POST) > 0)
        {
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            $query = $this->db->query("select KODE_VENDOR, KODE_LOGIN, PASSWRD from EP_VENDOR where KODE_LOGIN = '$username'");
            $row = $query->row();

            if(count($row) > 0 && $row->PASSWRD == md5($password))
            {
                $this->session->set_userdata('user_id', $row->KODE_VENDOR);
                $this->session->set_userdata('username', $row->KODE_LOGIN);

                redirect('welcome/index');
            }
        }


        $this->load->view('account/layout_login');
    }

    public function registration()
    {
        if (count($_POST) > 0)
        {
            try
            {
                $query = $this->db->query("select max(NOMORURUT) + 1 as idx from ep_nomorurut where kode_nomorurut = 'VENDOR'");
                $row = $query->row();
                $_POST['EP_VENDOR']['KODE_VENDOR'] = $row->IDX;
                $_POST['EP_VENDOR']['PASSWRD'] = md5($_POST['EP_VENDOR']['PASSWRD']);
                $this->db->insert('EP_VENDOR', $_POST['EP_VENDOR']);
                $this->db->query("update ep_nomorurut set NOMORURUT = NOMORURUT + 1 where kode_nomorurut = 'VENDOR'");
            }
            catch(Exception $e)
            {
                print($e);
            }
        }
        
        $this->load->view('account/layout_registration');
    }

    public function resetpassword()
    {
        $this->layout->view('account/resetpassword');
    }
    
    public function changepassword()
    {
        $this->layout->view('account/changepassword');
    }
    
    public function logout()
    {
        unset($_SESSION);
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 42000, '/');
        }
        session_destroy();
        redirect('account/login');
    }

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */