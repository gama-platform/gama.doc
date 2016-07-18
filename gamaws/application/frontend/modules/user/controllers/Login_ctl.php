<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login_ctl extends MX_Controller {

    function __construct()
    {
        parent::__construct();
        //$this->load->database();
        //$this->load->library(array('ion_auth','form_validation'));
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');

        $this->template->write_view("header","login_header");
        $this->template->write_view("metatag","metatag",array('meta_title'=>$this->config->item('meta_title'),'meta_keywords'=>$this->config->item('meta_keywords'),'meta_description'=>$this->config->item('meta_description')));
        $this->template->write_view("footer","footer");
        $this->template->write_view("scrolltotop","scrolltotop");
    }

    // redirect if needed, otherwise display the user list
    function index()
    {
        $this->load->library('user_agent');
        if ($this->ion_auth->logged_in())
        {
            // redirect them to the login page
            $redirect_to = 'home_page';
            if ($this->agent->is_referral())
            {
                $redirect_to = $this->agent->referrer();
            }
            if(strpos($redirect_to, 'login') === false && strpos($redirect_to, 'register')=== false
                && strpos($redirect_to, 'login_facebook') === false && strpos($redirect_to, 'forget_pwd') === false
                && strpos($redirect_to, 'change_pwd')=== false && strpos($redirect_to, 'reset_pwd')=== false
                && strpos($redirect_to, 'valid_account')=== false && strpos($redirect_to, 'logout')=== false
            )
            {
                redirect($redirect_to, 'refresh');
            }
            else
                redirect('home_page', 'refresh');
        }
        $this->login();
}



    // log the user in
    function login()
    {
        $data['title'] = "Login";

        if ($this->agent->is_referral())
        {
            if(!$this->session->userdata('redirect_to'))
                $this->session->set_userdata('redirect_to',$this->agent->referrer());
        }

        //validate form input
        $this->form_validation->set_rules('identity', 'Identity', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == true)
        {
            // check to see if the user is logging in
            // check for "remember me"
            $remember = (bool) $this->input->post('remember', TRUE);
            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
            {
                //if the login is successful
                //redirect them back to the home page
                $user_id = (int)$this->ion_auth->get_user_id();
                $user = $this->ion_auth->user($user_id)->row();
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                $old_last_login = $this->session->userdata("old_last_login");
                if($user->created_on == $old_last_login){
                    redirect('welcome', 'refresh');
                }
                if($this->session->userdata('redirect_to'))
                {
                    $redirect_to = $this->session->userdata('redirect_to');
                    $this->session->unset_userdata('redirect_to');
                    if(strpos($redirect_to, 'login')=== false && strpos($redirect_to, 'register')=== false
                        && strpos($redirect_to, 'login_facebook') === false && strpos($redirect_to, 'forget_pwd') === false
                        && strpos($redirect_to, 'change_pwd')=== false && strpos($redirect_to, 'reset_pwd')=== false
                        && strpos($redirect_to, 'valid_account')=== false && strpos($redirect_to, 'logout')=== false
                    )
                    {
                        redirect($redirect_to, 'refresh');
                    }
                    else
                        redirect('home_page', 'refresh');
                }
                else
                    redirect('home_page', 'refresh');

                //if the login is successful
                //redirect them back to the home page
                //$this->session->set_flashdata('message', $this->ion_auth->messages());
                //redirect('home_page', 'refresh');
            }
            else
            {
                // if the login was un-successful
                // redirect them back to the login page
                $this->session->set_flashdata('error', $this->ion_auth->errors());
                redirect('login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        }
        else
        {
            // the user is not logging in so display the login page
           /* $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $data['identity'] = array('name' => 'identity',
                'id'    => 'identity',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('identity'),
            );
            $data['password'] = array('name' => 'password',
                'id'   => 'password',
                'type' => 'password',
            );*/

            //the user is not logging in so display the login page
            //set the flash data error message if there is one
            $error = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $data['error'] = $error;
            $data['messages'] = $this->session->flashdata("message");
            $data['identity'] = $this->form_validation->set_value('identity');
            //$this->template->write_view("main_cls","main_cls",array("main_cls"=>"bg-gray"));
            $this->template->write_view('content','login/login',array('data' => $data));
            $this->template->render();
            //$this->_render_page('login/login', $data);

        }
    }

    // log the user out
    function logout()
    {
        //$this->data['title'] = "Logout";
        $data['title'] = "Logout";

        // log the user out
        $logout = $this->ion_auth->logout();

        // redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect('login', 'refresh');
    }

    function _render_page($view, $data=null, $returnhtml=false)//I think this makes more sense
    {
        $this->viewdata = (empty($data)) ? $this->data: $data;
        $view_html = $this->load->view($view, $this->viewdata, $returnhtml);
        if ($returnhtml) return $view_html;//This will return html on 3rd argument being true
    }

}
