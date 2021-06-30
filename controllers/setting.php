<?php 

class Setting extends MY_Controller
{
    public $module_name;
	function __construct()
    {
        parent::__construct();
        
        $this->module_name = $this->router->fetch_module();
        $this->load->model('../extensions/'.$this->module_name.'/models/Company_model');
        $this->load->model('../extensions/'.$this->module_name.'/models/Employee_log_model');
            
        $this->load->library('email');
        $this->load->library('form_validation');
        $this->load->library('ckeditor');
        $this->load->library('ckfinder');

        $this->load->helper('ckeditor_helper');
        
        $view_data['menu_on'] = true;
        $this->load->vars($view_data);
        
    }

    function invoice_email()
    {
        $company_id = $this->session->userdata('current_company_id');           
        $data = array();
        
        $data['company'] = $this->Company_model->get_company($company_id);
        $data['selected_sidebar_link'] = 'Invoice Email';
        
        $this->ckeditor->basePath = base_url().'application/third_party/ckeditor/';
        $this->ckeditor->config['language'] = 'en';
        //Add Ckfinder to Ckeditor
        $this->ckfinder->SetupCKEditor($this->ckeditor,'../../ckfinder/'); 
        
        $files = get_asstes_files($this->module_assets_files, $this->module_name, $this->controller_name, $this->function_name);

        $data['main_content'] = '../extensions/'.$this->module_name.'/views/invoice_email';
        $this->template->load('bootstrapped_template', null , $data['main_content'], $data);
    }
    
    function save_invoice_email()
    {
        global $unsanitized_post;
        $this->form_validation->set_rules('tripadvisor_link', 'Tripadvisor Link', 'trim|valid_url|xss_clean'); 
        $company_id = $this->session->userdata('current_company_id');
        
        if ($this->form_validation->run() == TRUE)
        {
            $update_data['invoice_email_header'] = isset($unsanitized_post['invoice_email_header']) ? $unsanitized_post['invoice_email_header'] : "" ;
           
            $this->Company_model->update_company($company_id, $update_data);
            
            $this->_create_employee_log("Invoice email template updated");
            
        }
        //PRG
        redirect('/email/invoice_email'); 
    }

    function _create_employee_log($log) {
        $log_detail =  array(
                    "user_id" => $this->user_id,
                    "selling_date" => $this->selling_date,
                    "date_time" => gmdate('Y-m-d H:i:s'),
                    "log" => $log,
                );          
        $this->Employee_log_model->insert_log($log_detail);     
    }

    function booking_confirmation_email()
    {
        $company_id = $this->session->userdata('current_company_id');           
        $data = array();
        
        $data['company'] = $this->Company_model->get_company($company_id);
        $data['selected_sidebar_link'] = 'Booking Confirmation Email';
        
        $this->ckeditor->basePath = base_url().'application/third_party/ckeditor/';
        $this->ckeditor->config['language'] = 'en';
        //Add Ckfinder to Ckeditor
        $this->ckfinder->SetupCKEditor($this->ckeditor,'../../ckfinder/'); 

        $files = get_asstes_files($this->module_assets_files, $this->module_name, $this->controller_name, $this->function_name);

        $data['main_content'] = '../extensions/'.$this->module_name.'/views/booking_confirmation_email';
        $this->template->load('bootstrapped_template', null , $data['main_content'], $data);
    }
    // Create a booking log to indicate that the invoice has been read.
    // If the invoice has already been read, then return
    
    function save_booking_confirmation_email() {
        // update balance
        $update_data = array('booking_confirmation_email_header'=> trim($_REQUEST['booking_confirmation_email_header']));
        $this->Company_model->update_company($this->session->userdata('current_company_id'), $update_data);
        $this->_create_employee_log("Booking confirmation email updated");
        $this->booking_confirmation_email();

        redirect('/email/booking_confirmation_email'); 
    }
}