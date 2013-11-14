<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class chapter_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function getChapterInfo($chapterId)
    {
        $this->db->from('locations');
        $this->db->where('company', 6);
        $this->db->where('id', $chapterId);

        $query = $this->db->get();

        $results = $query->result();

        return $results[0];
    }

}
