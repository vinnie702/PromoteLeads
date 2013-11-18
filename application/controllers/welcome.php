<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
	 * @see http://codeigniter.com/user_guide/general/urls.html
     */

    function Welcome()
    {
        parent::__construct();

        $this->load->model('welcome_model', 'welcome', true);
    }

	public function index()
	{
		$this->load->view('template/headerHome');
		$this->load->view('welcome/home');
		$this->load->view('template/footer');
    }

    public function aboutpl()
    {
        $this->load->view('template/header');
        $this->load->view('welcome/aboutpl');
        $this->load->view('template/footer');
    }

    public function contactUs()
    {
        $this->load->view('template/header');
        $this->load->view('welcome/contactus');
        $this->load->view('template/footer');
    }

    public function saveContactForm()
    {
        if($_POST)
        {
            try
            {
                $saved = $this->welcome->saveContactUs($_POST);
                $site = $_POST['page'];
            }
            catch(Exception $e)
            {
                $this->function->sendStackTrace($e);
                header("Location: {$site}?site-error=" . urlencode("Error submitting contact form!<br>" . $e->getMessage()));
            }
            if(!empty($saved))
            {
                header("Location: {$site}?site-success=" .urlencode('Your contact form has been submitted. Thank you!'));
            }
        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
