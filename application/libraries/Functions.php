<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Functions
{

    private $ci, $email;

    public function __construct()
    {
        $this->ci =& get_instance();

        $this->ci->load->library('session');

        $this->email = $this->ci->session->userdata('email');

        // if connected to DB
        if (class_exists('CI_DB'))
        {

        }
    }

    /**
     * Checks if user is logged into backend
     *
     * @return boolean TRUE if logged in
     */
    public function checkLoggedIn()
    {
        // starts session if not already started

        $ci =& get_instance();

        $ci->load->helper('url');


        $pattern = '/^intranet\/login/';

        $login = preg_match($pattern, uri_string());

        if ($login == 0)
        {
            //if(!isset($_COOKIE['userid']))
            if($ci->session->userdata('logged_in') === true)
            {
                // do nothing
            }
            else
            {
                header("Location: /intranet/login?site-error=" . urlencode("You are not logged in") . "&ref=" . uri_string() . '&email=' . urlencode($this->email));
                exit;
            }
        }
    }


    /*
     * cleans an entire array
     */
    public function recursiveClean($array)
    {
        $ci =& get_instance();

        if (!empty($array))
        {
            foreach ($array as $k => $v)
            {
                if(is_array($v))
                {
                    $array[$k] = $ci->functions->recursiveClean($v);
                }
                else
                {
                    $array[$k] = $ci->db->escape_str($v);
                }
            }
        }

        return $array;
    }


    /**
     * Removes certain programming tags like PHP, JS, and certain HTML
     *
     * @param String $s 
     *
     * @return String
     */
    public function removeCode($s)
    {
        $s = str_ireplace("<?php" , '', $s);
        $s = str_ireplace("<?" , '', $s);
        $s = str_ireplace("?>" , '', $s);
        $s = str_ireplace("<script" , '', $s);
        $s = str_ireplace("</script>" , '', $s);
        $s = str_ireplace("type='application/javascript'" , '', $s);
        $s = str_ireplace("type=\"application/javascript\"" , '', $s);
        $s = str_ireplace("type='text/javascript'" , '', $s);
        $s = str_ireplace("type=\"text/javascript\"" , '', $s);


    return $s;
    }

    /**
     * Saves stack trace error in error log
     */
    public function sendStackTrace($e)
    {
        $ci =& get_instance();

        // $ci->load->library('session');

        $body = "Stack Trace Error:\n\n";
        $body .= "URL: {$_SERVER["SERVER_NAME"]}{$_SERVER["REQUEST_URI"]}\n";
        $body .= "Referer: {$_SERVER['HTTP_REFERER']}\n";
        $body .= "User ID: {$ci->session->userdata('userid')}\n\n";
        $body .= "Message: " . $e->getMessage() . "\n\n";
        $body .= $e;

        error_log($body);

    }


    /**
     * Used for ajax JSON post returns
     *
     * @param mixed $status   
     * @param mixed $msg      
     *
     * @return TODO
     */
    public function jsonReturn ($status, $msg, $id = 0, $html = null)
    {
        $return['status'] = $status;
        $return['msg'] = $msg;

        if (!empty($id)) $return['id'] = $id;

        if (!empty($html)) $return['html'] = $html;

        echo json_encode($return);

        exit;
    }

    public function getStates()
    {
        $state_list = array(
        'AL'=>"Alabama",
        'AK'=>"Alaska",
        'AZ'=>"Arizona",
        'AR'=>"Arkansas",
        'CA'=>"California",
        'CO'=>"Colorado",
        'CT'=>"Connecticut",
        'DE'=>"Delaware",
        'DC'=>"District Of Columbia",
        'FL'=>"Florida",
        'GA'=>"Georgia",
        'HI'=>"Hawaii",
        'ID'=>"Idaho",
        'IL'=>"Illinois",
        'IN'=>"Indiana",
        'IA'=>"Iowa",
        'KS'=>"Kansas",
        'KY'=>"Kentucky",
        'LA'=>"Louisiana",
        'ME'=>"Maine",
        'MD'=>"Maryland",
        'MA'=>"Massachusetts",
        'MI'=>"Michigan",
        'MN'=>"Minnesota",
        'MS'=>"Mississippi",
        'MO'=>"Missouri",
        'MT'=>"Montana",
        'NE'=>"Nebraska",
        'NV'=>"Nevada",
        'NH'=>"New Hampshire",
        'NJ'=>"New Jersey",
        'NM'=>"New Mexico",
        'NY'=>"New York",
        'NC'=>"North Carolina",
        'ND'=>"North Dakota",
        'OH'=>"Ohio",
        'OK'=>"Oklahoma",
        'OR'=>"Oregon",
        'PA'=>"Pennsylvania",
        'RI'=>"Rhode Island",
        'SC'=>"South Carolina",
        'SD'=>"South Dakota",
        'TN'=>"Tennessee",
        'TX'=>"Texas",
        'UT'=>"Utah",
        'VT'=>"Vermont",
        'VA'=>"Virginia",
        'WA'=>"Washington",
        'WV'=>"West Virginia",
        'WI'=>"Wisconsin",
        'WY'=>"Wyoming"
        );

        return $state_list;
    }

    /**
     * TODO: short description.
     *
     * @param mixed $headers Optional, defaults to 0. 
     *
     * @return TODO
     */
    public function getMenu($header = false, $parentMenu = null)
    {

        $ci =& get_instance();

        // $ci->load->library('session');
        $ci->load->driver('cache');

        $userid = $ci->session->userdata('userid');

        $data = $ci->cache->memcached->get("menu-{$userid}-{$header}-{$parentMenu}");

        $data = null;

        if (empty($data))
        {
            $ci->db->from('menu');
            $ci->db->where('company', $ci->session->userdata('company'));
            if ($header == true) $ci->db->where('header', '1');
            else $ci->db->where('header', '0');

            if (!empty($parentMenu)) $ci->db->where('parentMenu', $parentMenu);

            $ci->db->order_by('menuOrder', 'asc');

            $query = $ci->db->get();

            $data = $query->result();

            $ci->cache->memcached->save("menu-{$userid}-{$header}-{$parentMenu}", $data, $ci->config->item('cache_timeout'));
        }

        return $data;
    }

    /**
     * Checks if a position has access to a menu item
     *
     * @return boolean - True if position has access
     */
    public function checkMenuAccess ($menu, $position)
    {
        if (empty($menu)) throw new Exception("menu ID is empty!");
        if (empty($position)) throw new Exception("position ID is empty!");

        $ci =& get_instance();

        $mtag = "menuAccess-{$menu}-{$position}";

        $data = $ci->cache->memcached->get($mtag);

        if (!$data)
        {
            $ci->db->where('menu', $menu);
            $ci->db->where('position', $position);
            $ci->db->from('menuAccess');

            $data = $ci->db->count_all_results();

            $ci->cache->memcached->save($mtag, $data, $ci->config->item('cache_timeout'));
        }

        if ($data > 0) return true;

    return false;
    }

    /**
     * TODO: short description.
     *
     * @param mixed $group     
     * @param mixed $company   Optional, defaults to 0. 
     * @param mixed $orderCol  Optional, defaults to null. 
     * @param mixed $orderType Optional, defaults to null. 
     *
     * @return TODO
     */
    public function getCodes($group, $company = 0, $orderCol = 'display', $orderType = 'asc')
    {
        $tag = "codes{$group}-{$company}-{$orderCol}-{$orderType}";

        $ci =& get_instance();

        $data = $ci->cache->memcached->get($tag);

        if (empty($data))
        {
            $ci->db->from('codes');
            $ci->db->where('group', $group);
            $ci->db->where('code <>', 0);

            $companyArray = array('0');

            if (!empty($company)) $companyArray[] = $company;

            $ci->db->where_in('company', $companyArray);

            if (empty($orderCol)) $ci->db->order_by('display', 'asc');
            else $ci->db->order_by($orderCol, $orderType);

            $query = $ci->db->get();

            $data = $query->result();

            $ci->cache->memcached->save($tag, $data, $ci->config->item('cache_timeout'));
        }

    return $data;
    }

    /**
     * gets all groups of codes
     *
     * @return TODO
     */
    public function getCodeGroups ($company = 0)
    {
        if (empty($company)) $this->ci->session->userdata('company');

        $tag = "codeGroups-{$company}";

        $data = $this->ci->cache->memcached->get($tag);

        if (empty($data))
        {
            $this->ci->db->from('codes');
            $this->ci->db->where('code', 0);

            $companyArray = array('0');

            if (!empty($company)) $companyArray[] = $company;

            $this->ci->db->where_in('company', $companyArray);

            if (empty($orderCol)) $this->ci->db->order_by('display', 'asc');
            else $this->ci->db->order_by($orderCol, $orderType);

            $query = $this->ci->db->get();

            $data = $query->result();

            $this->ci->cache->memcached->save($tag, $data, $this->ci->config->item('cache_timeout'));
        }

    return $data;
    }


    /**
     * TODO: short description.
     *
     * @return TODO
     */
    public function getTimezones ()
    {
        static $regions = array
            (
                'Africa' => DateTimeZone::AFRICA,
                'America' => DateTimeZone::AMERICA,
                'Antarctica' => DateTimeZone::ANTARCTICA,
                'Asia' => DateTimeZone::ASIA,
                'Atlantic' => DateTimeZone::ATLANTIC,
                'Australia' => DateTimeZone::AUSTRALIA,
                'Europe' => DateTimeZone::EUROPE,
                'Indian' => DateTimeZone::INDIAN,
                'Pacific' => DateTimeZone::PACIFIC
            );

        foreach ($regions as $name => $mask)
        {
            $tzlist[] = DateTimeZone::listIdentifiers($mask);
        }

        return $tzlist;
    }

    public function codeDisplay($group, $code)
    {
        if (empty($group)) throw new Exception("Group is empty!");
        if (empty($code)) throw new Exception("code is empty!");


        $ci =& get_instance();

        $mtag = "code-$group-$code";

        $data = $ci->cache->memcached->get($mtag);

        if (empty($data))
        {
            $ci->db->select('display');
            $ci->db->from('codes');
            $ci->db->where('group', $group);
            $ci->db->where('code', $code);

            $query = $ci->db->get();

            $results = $query->result();

            $data = $results[0]->display;

            $ci->cache->memcached->save($mtag, $data, $ci->config->item('cache_timeout'));
        }

        return $data;
    }


    /**
     * creates directory if does not exist
     *
     * @param String $path - path to directory to create: Example $path = "public" . PATH_SEPARATOR . "uploads" . PATH_SEPARATOR . "folderName"
     *
     * @return boolean
     */
    public function createDir($path)
    {

        if (!is_dir($_SERVER['DOCUMENT_ROOT'] . $path))
        {
            $create = mkdir($_SERVER['DOCUMENT_ROOT'] . $path, 0777);

            if ($create === false) throw new exception("Unable to create directory:" . $_SERVER['DOCUMENT_ROOT'] . $path);
            // attempts to set permissions for folder to allow copy
            @chmod($_SERVER['DOCUMENT_ROOT'] . $path, 0777);
        }
        else
        {
            // already a directory
            return true;
        }

    return true;
    }

    /**
     * TODO: short description.
     *
     * @param mixed $name 
     *
     * @return TODO
     */
    public function jsScript($name, $path = 'public/js/')
    {
        $ci =& get_instance();

        return "<script type='text/javascript' src='/min/?f={$path}{$name}{$ci->config->item('min_debug')}&amp;{$ci->config->item('min_version')}'></script>" . PHP_EOL;
    }


    /**
     * gets the extension of a given file, Example: some_image.test.JPG
     *
     * @param string $file - filename
     *
     * @return string. E.g.: jpg
     */
    public function getFileExt($file)
    {
        $ld = strrpos($file, '.');

        // gets file extension
        $ext = strtolower(substr($file, $ld + 1, (strlen($file) - $ld)));

    return $ext;
    }

    /**
     * TODO: short description.
     *
     * @return TODO
     */
    public function headerLogo ()
    {
        $company = $this->ci->session->userdata('company');

        $logo_url = $this->ci->config->item('logo_url');

        $logo = $this->ci->companies->getTableValue('logo', $company);

        if (empty($logo))
        {
            $companyName = $this->ci->companies->getCompanyName($company);

            $html = "<a class='navbar-brand' href='/intranet/landing'>{$companyName}</a>";
        }
        else
        {

            $thumb = str_replace('.', '_thumb.', $logo);


            $img = "<img src='{$logo_url}{$company}/{$thumb}'>";

            $html = "<a class='navbar-brand' href='/intranet/landing'>{$img}</a>";
        }

        return $html;
    }

    /**
     * Gets the last time punch for a user for a paticular company
     *
     * @param mixed $user    Optional, defaults to 0. 
     * @param mixed $company Optional, defaults to 0. 
     *
     * @return datetime
     */
    public function getLastTimePunch($user = 0, $company = 0)
    {
        if (empty($user)) $user = $this->ci->session->userdata('userid');
        if (empty($company)) $company = $this->ci->session->userdata('company');

        $user = intval($user);
        $company = intval($company);

        if (empty($user)) throw new Exception("User ID is empty!");
        if (empty($company)) throw new Exception("Company ID is empty");

        $mtag = "latestTimePunch-{$user}-{$company}";

        $data = $this->ci->cache->memcached->get($mtag);

        if (!$data)
        {
            $this->ci->db->select('timepunch');
            $this->ci->db->from('userTimePunch');
            $this->ci->db->where('userid', $user);
            $this->ci->db->where('company', $company);
            $this->ci->db->order_by('timepunch', 'desc');
            $this->ci->db->limit(1);

            $query = $this->ci->db->get();

            $results = $query->result();

            $data = $results[0]->timepunch;

            $this->ci->cache->memcached->save($mtag, $data, $this->ci->config->item('cache_timeout'));
        }

        return $data;
    }

    /**
     * Gets ID's and name for all active reports for a company.
     *
     * @return array->object
     */
    public function getReportList ($company = 0)
    {
        if (empty($company)) $company = $this->ci->session->userdata('company');

        $company = intval($company);

        if (empty($company)) throw new Exception("Company ID is empty");

        $mtag = "reportList-{$company}";

        $data = $this->ci->cache->memcached->get($mtag);

        if (!$data)
        {
            $this->ci->db->select('id, name');
            $this->ci->db->from('reports');
            $this->ci->db->where('company', $company);
            $this->ci->db->where('active', 1);
            $this->ci->db->where('deleted', 0);
            $this->ci->db->order_by('name', 'asc');

            $query = $this->ci->db->get();

            $data = $query->result();

            $this->ci->cache->memcached->save($mtag, $data, $this->ci->config->item('cache_timeout'));
        }

        return $data;
    }

    /**
     * TODO: short description.
     *
     * @param mixed $string 
     *
     * @return 
     */
    public function onlyNumbers ($string)
    {

    }
}
