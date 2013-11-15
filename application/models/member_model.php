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

    public function getUserVideos($userid)
    {
        $this->db->from('userYouTubeVideos');
        $this->db->where('company', 6);
        $this->db->where('userid', $userid);

        $query = $this->db->get();

        $results = $query->result();

        return $results;
    }

    /**
     * TODO: short description.
     *
     * @return TODO
     */
    public function getYouTubeVideos ($user)
    {
        // $mtag = "userYouTubeVideos-{$user}";

        // $data = $this->ci->cache->memcached->get($mtag);

        // if (!$data)
        // {
            $this->ci->db->select("id, url");
            $this->ci->db->from('userYouTubeVideos');
            $this->ci->db->where('userid', $user);
            $this->ci->db->order_by('videoOrder', 'ASC');

            $query = $this->ci->db->get();

            $data = $query->result();

            // $this->ci->cache->memcached->save($mtag, $data, $this->ci->config->item('cache_timeout'));
        // }

        return $data;
    }

}
