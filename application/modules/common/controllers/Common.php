<?php

/**
 * P&RD Development
 *
 * It's controlling the login activity
 *
 * @package		p&rd
 * @author		EMDEE
 * @copyright	Copyright (c) 2020, Emdee Digitronics Pvt. Ltd.
 * @license		Emdee Digitronics Pvt. Ltd.
 * @author		Sujay Bandyopadhyay (sujay.bandyopadhyay@gmail.com) & Imtiaz Kabir
 * @since		Version 1.0,[Created: 01-Apr-2020]
 */
// ------------------------------------------------------------------------
defined('BASEPATH') or exit('No direct script access allowed');

class Common extends MX_Controller
{

    var $data;

    function __construct()
    {
        parent::__construct(); //csrf_check();
        $this->load->model('common_model');
        $this->data = array();
    }

    function is_authorised()
    {
        $pwd = $this->input->post('pwd');
        $flag = 0;
        if ($pwd == MENU_PWD) {
            $flag = 1;
        }
        echo json_encode($flag);
    }

    function get_division_list()
    {
        $level_id = $this->input->get('level_id');
        $parent_id = $this->input->get('parent_id');
        echo json_encode($this->common_model->get_division_list($level_id, $parent_id));
    }

    function get_road_list()
    {
        $district_id = $this->input->get('district_id');
        $block_id = $this->input->get('block_id');
        $panchayat_id = $this->input->get('panchayat_id');
        echo json_encode($this->common_model->get_road_list($district_id, $block_id, $panchayat_id));
    }

    function get_designation_list()
    {
        echo json_encode($this->common_model->get_designation_list());
    }

    function insert_user_district_level()
    {
        //        echo $this->encryption->encrypt('password');
        //        echo $this->encryption->decrypt('54c47e0c2649bc034e35f8427ae97698d99d9be506f1123605a91e152b8aba54f43d034a6509d03ff336d39316206b764f22d425e24dc4f1745093836a2253221eY07CIBDdLyN8cWKgfldnYUo9lEjpGGq/RKHwgTHfY=');
        //        exit;
        $this->db->distinct();
        $this->db->where(array(
            'level_id' => 2,
            'isactive' => 1
        ));
        $this->db->order_by('name');
        //        $this->db->limit(1);
        $query = $this->db->get(DIVISION);
        $result = $query->result();
        foreach ($result as $r) {
            $sql = 'INSERT INTO um_user (created, name, level_id, division_id, role_id, designation_id, parent_id) '
                . 'VALUES ("2021-01-11", "' . ucwords(strtolower($r->name)) . ' Admin", 2, ' . $r->id . ', 2, 1, 2)';
            $this->db->query($sql);
            $user_id = $this->db->insert_id();
            $sql = 'INSERT INTO um_user_login (created, user_id, username, password) '
                . 'VALUES ("2021-01-11", ' . $user_id . ', "' . str_replace(' ', '', strtolower($r->name)) . '", "54c47e0c2649bc034e35f8427ae97698d99d9be506f1123605a91e152b8aba54f43d034a6509d03ff336d39316206b764f22d425e24dc4f1745093836a2253221eY07CIBDdLyN8cWKgfldnYUo9lEjpGGq/RKHwgTHfY=")';
            $this->db->query($sql);
        }
    }

    function dmlogin()
    {
        $sql = 'select id, code, name from division where level_id=2 order by code';
        $query = $this->db->query($sql);
        $result = $query->result();
        foreach ($result as $row) {
            $input = array(
                'created' => date('Y-m-d'),
                'role_id' => 12,
                'district_id' => $row->id,
                'block_id' => 0,
                'name' => 'DM ' . $row->name
            );
            $this->db->insert(USER, $input);
            $user_id = $this->db->insert_id();
            $input = array(
                'created' => date('Y-m-d'),
                'user_id' => $user_id,
                'username' => 'dm19' . $row->code . '01',
                'password' => $this->encryption->encrypt(DEFAULT_PWD),
                'isactive' => 1
            );
            $this->db->insert(LOGIN, $input);
        }
    }

    function zplogin()
    {
        $sql = 'select id, code, name from division where level_id=2 order by code';
        $query = $this->db->query($sql);
        $result = $query->result();
        foreach ($result as $row) {
            $input = array(
                'created' => date('Y-m-d'),
                'role_id' => 13,
                'district_id' => $row->id,
                'block_id' => 0,
                'name' => 'ZP ' . $row->name
            );
            $this->db->insert(USER, $input);
            $user_id = $this->db->insert_id();
            $input = array(
                'created' => date('Y-m-d'),
                'user_id' => $user_id,
                'username' => 'aeo19' . $row->code . '01',
                'password' => $this->encryption->encrypt(DEFAULT_PWD),
                'isactive' => 1
            );
            $this->db->insert(LOGIN, $input);
        }
    }

    function srdalogin()
    {
        $sql = 'select id, code, name from division where level_id=2 order by code';
        $query = $this->db->query($sql);
        $result = $query->result();
        foreach ($result as $row) {
            $input = array(
                'created' => date('Y-m-d'),
                'role_id' => 15,
                'district_id' => $row->id,
                'block_id' => 0,
                'name' => 'WBSRDA ' . $row->name
            );
            $this->db->insert(USER, $input);
            $user_id = $this->db->insert_id();
            $input = array(
                'created' => date('Y-m-d'),
                'user_id' => $user_id,
                'username' => 'srda19' . $row->code . '01',
                'password' => $this->encryption->encrypt(DEFAULT_PWD),
                'isactive' => 1
            );
            $this->db->insert(LOGIN, $input);
        }
    }

    function bdologin()
    {
        $sql = 'select id, parent_id, code, name from division where level_id=3 order by code';
        $query = $this->db->query($sql);
        $result = $query->result();
        foreach ($result as $row) {
            $input = array(
                'created' => date('Y-m-d'),
                'role_id' => 14,
                'district_id' => $row->parent_id,
                'block_id' => $row->id,
                'name' => 'BDO ' . $row->name
            );
            $this->db->insert(USER, $input);
            $user_id = $this->db->insert_id();
            $input = array(
                'created' => date('Y-m-d'),
                'user_id' => $user_id,
                'username' => 'bdo19' . $row->code . '01',
                'password' => $this->encryption->encrypt(DEFAULT_PWD),
                'isactive' => 1
            );
            $this->db->insert(LOGIN, $input);
        }
    }

    // function districtid()
    // {
    //     $sql = 'SELECT DISTINCT d.id, s.district FROM srr_project s JOIN division d on lower(REPLACE(d.name, " ", ""))=lower(REPLACE(s.district, " ", "")) where d.level_id=2 and s.district_id=0';
    //     $query = $this->db->query($sql);
    //     $result = $query->result();
    //     $i = 1;
    //     foreach ($result as $row) {
    //         $sql = 'UPDATE srr_project SET district_id=' . $row->id . ' WHERE lower(REPLACE(district, " ", ""))="' . strtolower(str_replace(' ', '', $row->district)) . '"';
    //         $this->db->query($sql);
    //         $i++;
    //     }
    //     echo 'total: ' . $i;
    // }

    // function blockid()
    // {
    //     $sql = 'SELECT DISTINCT district_id as id FROM srr_project WHERE district_id > 0';
    //     $query = $this->db->query($sql);
    //     $district = $query->result();
    //     foreach ($district as $d) {
    //         $sql = 'SELECT DISTINCT d.id, s.block FROM srr_project s JOIN division d on lower(REPLACE(d.name, " ", ""))=lower(REPLACE(s.block, " ", "")) where d.level_id=3 and s.block_id=0 and s.district_id=d.parent_id and s.district_id=' . $d->id;
    //         $query = $this->db->query($sql);
    //         $result = $query->result();
    //         $i = 1;
    //         foreach ($result as $row) {
    //             $sql = 'UPDATE srr_project SET block_id=' . $row->id . ' WHERE lower(REPLACE(block, " ", ""))="' . strtolower(str_replace(' ', '', $row->block)) . '" and district_id=' . $d->id;
    //             $this->db->query($sql);
    //             $i++;
    //         }
    //     }
    //     echo 'total: ' . $i;
    // }

    // function gpid()
    // {
    //     $sql = 'SELECT DISTINCT block_id as id FROM srr_project WHERE block_id > 0';
    //     $query = $this->db->query($sql);
    //     $block = $query->result();
    //     foreach ($block as $b) {
    //         $sql = 'SELECT DISTINCT d.id, s.gp FROM srr_project s JOIN division d on lower(REPLACE(d.name, " ", ""))=lower(REPLACE(s.gp, " ", "")) where d.level_id=4 and s.gp_id=0 and s.block_id=d.parent_id and s.block_id=' . $b->id;
    //         $query = $this->db->query($sql);
    //         $result = $query->result();
    //         $i = 1;
    //         foreach ($result as $row) {
    //             $sql = 'UPDATE srr_project SET gp_id=' . $row->id . ' WHERE lower(REPLACE(gp, " ", ""))="' . strtolower(str_replace(' ', '', $row->gp)) . '" and block_id=' . $b->id;
    //             $this->db->query($sql);
    //             $i++;
    //         }
    //     }
    //     echo 'total: ' . $i;
    // }

    // function schemeid()
    // {
    //     $sql = 'select id from srrp where ref_no is null';
    //     $query = $this->db->query($sql);
    //     $result = $query->result();
    //     foreach ($result as $row) {
    //         var_dump($row);
    //     }
    // }

    

    
}
