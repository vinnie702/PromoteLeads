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

    public function getChapterMembers($chapterId)
    {
        $this->db->from('userLocations');
        $this->db->where('location', $chapterId);

        $query = $this->db->get();

        $results = $query->result();

        return $results;
    }

    public function getChapterPresident($chapterId)
    {
        $this->db->from('users');
        $this->db->join('userCompanyPositions', 'users.id = userCompanyPositions.userid', 'left');
        $this->db->join('userLocations', 'users.id = userLocations.userid', 'left');
        $this->db->where('location', $chapterId);
        $this->db->where('position', 24);

        $query = $this->db->get();

        $results = $query->result();

        return $results[0];
    }

    public function getChapterPhoto($chapterId)
    {
        $this->db->select('fileName');
        $this->db->from('locationImages');
        $this->db->where('company', 6);
        $this->db->where('locationid', $chapterId);

        $query = $this->db->get();

        $results = $query->result();

        return $results[0];
    }
}
