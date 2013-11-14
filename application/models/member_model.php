<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * TODO: short description.
 *
 * TODO: long description.
 *
 */
class member_model extends CI_Model
{

    /**
     * TODO: short description.
     *
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * TODO: short description.
     *
     * @param mixed $userid 
     *
     * @return TODO
     */
    public function getUserInfo($userid)
    {
        $sql = "SELECT * FROM users WHERE id = {$userid}";

        $query = $this->db->query($sql);

        $results = $query->result();

        return $results[0];
    }
}
