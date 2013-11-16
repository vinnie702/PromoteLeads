<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * TODO: short description.
 *
 * TODO: long description.
 *
 */
class welcome_model extends CI_Model
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
     * @param mixed          
     * @param mixed          
     * @param mixed          
     * @param mixed          
     *
     * @return TODO
     */
    public function saveContactus($p)
    {
        $data = array(
            'name' => $p['name'],
            'email' => $p['email'],
            'phone' => $p['phone'],
            'message' => $p['message'],
            'timestamp' => DATESTAMP,
        );
        if(!empty($p['userid'])) $data['userid'] = $p['userid'];

        $this->db->insert('contactUs', $data);

        return 'SUCCESS';
    }
}
