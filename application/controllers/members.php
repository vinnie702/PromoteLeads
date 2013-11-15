<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Members extends CI_Controller {

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

    function Members()
    {
        parent::__construct();

        $this->load->model('member_model', 'member', true);

    }

	public function index()
	{
		$this->load->view('template/header');
		$this->load->view('members/home');
		$this->load->view('template/footer');
    }

    public function profile($userid)
    {
        $header['headscript'] = "<script type='text/javascript' src='/min/?f=public/js/members.js{$this->config->item('min_debug')}&amp;{$this->config->item('min_version')}'></script>\n";
        $header['onload'] = "members.profileInit();";

        $body['user'] = $this->member->getUserInfo($userid);
        $body['videos'] = $this->member->getUserVideos($userid);
        $body['mainVideo'] = $url = $this->member->getMainYoutubeVideo($userid);

        $body['videoUrl'] = $this->member->getYoutubeVideoID($url->url);

		$this->load->view('template/header', $header);
		$this->load->view('members/profile', $body);
		$this->load->view('template/footer');
    }


}
