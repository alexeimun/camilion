<?php

    class Rbca
    {
        private $CI;

        public function __construct()
        {
            //Define CI based variables (so you can use CI functions)
            $this->CI =& get_instance();
        }

        public function can($verb, $redirect = true)
        {
            if($redirect)
            {
                if(!isset($this->CI->session->userdata['can'][$verb]))
                {
                    redirect(site_url(), 'refresh');
                }
            }
            else
            {
                return isset($this->CI->session->userdata['can'][$verb]);
            }
        }

        public function load_permissions()
        {
            $can = [];
            $id_user = $this->CI->session->userdata('ID_USUARIO');
            $this->CI->db->select('item_name');
            $this->CI->db->where('user_id', $id_user);
            $permissions = $this->CI->db->get('t_auth_assignment')->result();
            foreach ($permissions as $permision)
            {
                $can[$permision->item_name] = $permision->item_name;
            }
            $this->CI->session->set_userdata(['can' => $can]);
        }

        public function is_authorized($data)
        {
            if(!$this->_authorized($data))
            {
                redirect(site_url(), 'refresh');
            }
        }

        /**
         * @param $data
         * @return bool
         */
        private function _authorized($data)
        {
            switch ($data)
            {
                case '*':
                    return true;
                case
                '~':
                    return false;
                default:
                    if(!is_array($data))
                    {
                        return false;
                    }
                    extract($data);
                    /**
                     * @var
                     */
                    $actor = $this->CI->session->userdata('CURRENT_USER');
                    $action = isset($this->CI->uri->segments[2]) ? $this->CI->uri->segments[2] : 'index';

                    foreach ($data as $key => $value)
                    {
                        if($actor == $key)
                        {
                            if(is_array($value))
                            {
                                if(isset($value['~']))
                                {
                                    foreach ($value['~'] as $act)
                                    {
                                        if($action == $act)
                                        {
                                            return false;
                                        }
                                    }
                                    return true;
                                }
                                else
                                {
                                    foreach ($value as $kkey => $act)
                                    {
                                        if($action == $act)
                                        {
                                            return true;
                                        }
                                    }
                                }
                            }
                            else if($value == $action)
                            {
                                return true;
                            }
                            else if($value == '*')
                            {
                                return true;
                            }
                            else
                            {
                                return false;
                            }
                        }
                        else if($key == '~')
                        {
                            foreach ($value as $act)
                            {
                                if($action == $act)
                                {
                                    return false;
                                }
                            }
                            return true;
                        }
                    }
                    return false;
            }
        }
    }