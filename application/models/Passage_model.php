<?php
/**
 * Created by PhpStorm.
 * Admin: 15185
 * Date: 2017/8/7
 * Time: 14:59
 */
class Passage_model extends CI_Model{

    public function __construct()
    {
        $this->load->database();
    }

    public function get_each($id = FALSE)
    {
        if ($id) {
            $this->db->where('passage.passage_id', $id);
            $this->db->from('passage');
            return $num = $this->db->count_all_results();
        } else {
            $this->db->from('passage');
            return $num = $this->db->count_all_results();
        }
    }

    public function get_passages($passage_id = FALSE,$limit = FALSE,$offset = FALSE)
    {
        if($passage_id){
            $this->db->join('administrator','administrator.admin_id = passage.admin_id');
            $query = $this->db->get_where('passage',array('passage_id' => $passage_id));
            return $query->row_array();
        } else {
            if($limit && ($offset !== FALSE)){
                $this->db->order_by('update_time','DESC');
                $this->db->limit($limit,$offset);
                $this->db->join('administrator','administrator.admin_id = passage.admin_id');
                $query = $this->db->get('passage');
                return $query->result_array();
            } else {
                $this->db->order_by('update_time','DESC');
                $this->db->join('administrator','administrator.admin_id = passage.admin_id');
                $query = $this->db->get('passage');
                return $query->result_array();
            }
        }
    }

    public function create_passage(){

        date_default_timezone_set('PRC');
        $time = date('Y-m-d H:i:s');

        $data = array(
            'passage_title' => $this->input->post('title'),
            'passage_content' => $this->input->post('content'),
            'admin_id' => $_SESSION['admin_id'],
            'update_time' => $time
        );

        return $this->db->insert('passage',$data);
    }

    public function delete_passage($id){
        $this->db->where('passage_id',$id);
        return $this->db->delete('passage');
    }

    public function delete_batch($data){
        $this->db->where_in('passage_id',$data);
        return $this->db->delete('passage');
    }

    public function alter_passage($id){
        date_default_timezone_set('PRC');

        $data = array(
            'passage_title' => $this->input->post('title'),
            'passage_content' => $this->input->post('content'),
            'admin_id' => $_SESSION['admin_id'],
            'update_time' => date('Y-m-d H:i:s')
        );

        $this->db->where('passage_id',$id);
        return $this->db->update('passage',$data);
    }

    public function search_passage(){
        $title =  $this->input->post('search');
        $query = $this->db->get_where('passage',array('passage_title'=>$title));
        $row = $query->row_array();
        if(empty($row)){
            return FALSE;
        } else {
            return $row['passage_id'];
        }
    }









//Check if title exists
    public function check_title_exists($title_input){
        $query = $this->db->get_where('passage',array('passage_id'=>$_SESSION['passage_id']));
        $query_sec = $this->db->get_where('passage',array('passage_title'=>$title_input));
        $row = $query->row_array();
        $row_sec = $query_sec->row_array();
        if(($row['passage_title']===$title_input)||empty($row_sec)){
            return true;
        } else {
            return false;
        }
    }

}