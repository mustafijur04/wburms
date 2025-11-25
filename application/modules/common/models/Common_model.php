<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Common_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Always return an array, never null
    function get_session() {
        $user = $this->session->userdata('user');
        if (empty($user)) {
            return [];
        }
        $decoded = json_decode($this->encryption->decrypt($user), true);
        return is_array($decoded) ? $decoded : [];
    }

    function get_menu_list($level_id, $parent_id) {
        $session = $this->get_session();
        $role_id = $session['role_id'] ?? 0;
        $user_id = $session['user_id'] ?? 0;

        $this->db->select('m.id, m.name, m.class, m.link, m.has_child');
        $this->db->where(array(
            'm.level_id' => $level_id,
            'm.parent_id' => $parent_id,
            'm.isactive' => 1,
            'm.sequence >' => 0
        ));
        if ($role_id > 2) {
            $this->db->join(MENU_ROLE . ' mr', 'mr.menu_id=m.id AND mr.level_id=m.level_id AND mr.isactive=1');
            $this->db->join(USER . ' u', 'u.role_id=mr.role_id AND u.id=' . $user_id);
        }
        $this->db->order_by('m.sequence');
        $query = $this->db->get(MENU . ' m');
        return $query->result() ?: [];
    }

    function get_role_list() {
        $session = $this->get_session();
        $role_id = $session['role_id'] ?? 0;

        $this->db->select('id, name');
        $this->db->where(array(
            'isactive' => 1,
            'id > ' => 2
        ));
        if ($role_id > 2) {
            $this->db->where('parent_id', $role_id);
        }
        $this->db->order_by('sequence');
        $query = $this->db->get(ROLE);
        return $query->result() ?: [];
    }

    function get_district_list() {
        $session = $this->get_session();
        $district_ids = $session['district_id'] ?? 0;

        $this->db->distinct();
        $this->db->select('id, name');
        $this->db->where(array(
            'level_id' => 2,
            'isactive' => 1
        ));
        if ($district_ids > 0) {
            $this->db->where_in('id', explode(',', $district_ids));
        }
        $this->db->order_by('name');
        $query = $this->db->get(DIVISION);
        return $query->result() ?: [];
    }

    function get_block_list($district_id) {
        $session = $this->get_session();
        $block_ids = $session['block_id'] ?? 0;

        $this->db->distinct();
        $this->db->select('id, name');
        $this->db->where(array(
            'level_id' => 3,
            'parent_id' => $district_id,
            'isactive' => 1
        ));
        if ($block_ids > 0) {
            $this->db->where_in('id', explode(',', $block_ids));
        }
        $this->db->order_by('name');
        $query = $this->db->get(DIVISION);
        return $query->result() ?: [];
    }

    function get_gp_list($block_id) {
        $this->db->distinct();
        $this->db->select('id, name');
        $this->db->where(array(
            'level_id' => 4,
            'parent_id' => $block_id,
            'isactive' => 1
        ));
        $this->db->order_by('name');
        $query = $this->db->get(DIVISION);
        return $query->result() ?: [];
    }

    function get_project_list($district_id, $block_id) {
        $this->db->select('id, name');
        $this->db->where(array(
            'district_id' => $district_id,
            'isactive' => 1,
        ));
        if ($block_id > 0) {
            $this->db->where('FIND_IN_SET(' . $block_id . ', block_id) > 0');
        }
        $query = $this->db->get(PROJECT_HD);
        return $query->result() ?: [];
    }

    function get_table_id($table, $where = array()) {
        $this->db->select('id');
        $this->db->where($where);
        $query = $this->db->get($table);
        return $query->num_rows() > 0 ? $query->row()->id : 0;
    }

    function get_table_data($table, $where = array()) {
        $this->db->where('isactive', 1);
        $this->db->where($where);
        $query = $this->db->get($table);
        return $query->result() ?: [];
    }

}
?>
