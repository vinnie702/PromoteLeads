<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chapters extends CI_Controller {

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

    function Chapters()
    {
        parent::__construct();
        $this->load->model('chapter_model', 'chapter', true);
        $this->load->model('member_model', '', true);
    }

    public function index()
	{
		$this->load->view('template/header');
		$this->load->view('chapters/home');
		$this->load->view('template/footer');
    }

    public function profile($chapterId)
    {
        try
        {
            $body['chapter'] = $this->chapter->getChapterInfo($chapterId);
            $body['members'] = $this->chapter->getChapterMembers($chapterId);
            $body['cp'] = $this->chapter->getChapterPresident($chapterId);
            $body['locationImg'] = $this->chapter->getChapterPhoto($chapterId);
        }
        catch(Exception $e)
        {
            $this->functions->sendStackTrace($e);
        }

        $this->load->view('template/header');
		$this->load->view('chapters/profile', $body);
		$this->load->view('template/footer');
    }
}
