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
        $this->db->from('users');
        $this->db->where('users.id', $userid);

        $query = $this->db->get();

        $results = $query->result();

        return $results[0];
    }

    public function getUserVideos($userid)
    {
        $this->db->from('userYouTubeVideos');
        $this->db->where('company', 6);
        $this->db->where('userid', $userid);
        $this->db->order_by('videoOrder', 'ASC');

        $query = $this->db->get();

        $results = $query->result();

        return $results;
    }


    public function getMainYoutubeVideo($userid)
    {
        $this->db->select('url');
        $this->db->from('userYouTubeVideos');
        $this->db->where('company', 6);
        $this->db->where('userid', $userid);
        $this->db->where('videoOrder', 0);

        $query = $this->db->get();

        $results = $query->result();

        return $results[0];
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



    public function getYoutubeVideoID ($url)
    {
        $videoID = null;

        $pattern = '/youtu\.be\//i';

        $standardPattern = "/watch\?v\=/";

        $shareURL = preg_match($pattern, $url);

        $standardURLcheck = preg_match($standardPattern, $url);

        if ($shareURL > 0)
        {
            //does not use youtu.be link
            // echo "YES youtu.be : {$url}";
            $pos = strpos($url, "youtu.be/");
            $videoID = substr($url, ($pos + 9));
        }
        else if ($standardURLcheck > 0)
        {

            $pos = strpos($url, "watch?v=");


            $videoID = substr($url, ($pos  + 8));


            $stop = strpos($videoID, "&");

            if ($stop !== false)
            {
                $videoID = substr($videoID, 0, $stop);
            }

            // echo "VID: {$videoID}<br>";

            // echo "YES Standard : {$url}";
        }
        else
        {
            return false;
            // echo "NO MATCH : {$url}";
        }

        return $videoID;
    }


}
