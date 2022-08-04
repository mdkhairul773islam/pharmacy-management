<?php

class Users extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->data['meta_title'] = 'Login';
        $this->data['title'] = config_item('heading');

    }

    public function login() {

        if($this->membership_m->loggedin() == TRUE){
            
            // get Ip Info
    
            $this->load->helper('ip');
            
            $ip = get_client_ip();
            
            $url = file_get_contents("http://ip-api.com/php/$ip?fields=regionName,isp");
            //http://ip-api.com/php/103.83.206.3?fields=country,countryCode,region,regionName,city,zip,lat,lon,timezone,isp,org,as,query,status,message
    
            if($url != null){
                
                function clean($string) {
                    $string = str_replace('a:2:',"",$string);
                    $string = str_replace('{',"",$string);
                    $string = str_replace('}',"",$string);
                    
                    return $string;
                }
        
                $s = clean($url);
                $s = explode(";",$s);
                
                $division = explode(":",$s[1]);
                $isp = explode(":",$s[3]);
                
                $data = array(
                    'regionName' => $division[2],
                    'ISP' => $isp[2]
                );
                
                $ip_info = json_encode($data);
                
                $this->load->model('action');
                $where = array('ip_address' => $ip);
                if($this->action->exists('sessions',$where)){
                    $status = $this->action->update('sessions',array('ip_info' => $ip_info), $where);
                }
                
            }
            redirect($this->session->userdata('privilege') . '/dashboard');
        }

        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[6]|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|xss_clean');

        if($this->form_validation->run() == TRUE) {
            if($this->membership_m->login() == TRUE) {
                redirect($this->session->userdata('privilege') . '/dashboard');
            } else {
                $messArr = array(
                    "title" => "login warning",
                    "icon" => "home",
                    "emit" => "Wrong Username or Password!",
                    "btn" => false
                );
                $this->session->set_flashdata('error', message('warning-login', $messArr));

                redirect('access/users/login', 'refresh');
            }
        }

        $this->load->view('access/login', $this->data);
    }

    public function directAccess($id) {
    	if($this->membership_m->directLogin($id) == TRUE) {
            redirect($this->session->userdata('privilege') . '/dashboard');
        }
    }

    public function logout(){
        $this->membership_m->logout();
        redirect('access/users/login');
    }


}
