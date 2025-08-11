<?php

class Md_ref_json extends CI_Model {
    public function MDL_SelectRoom(){
        $tbl_room = $this->config->item('tmst_room');
        
        $hasil = array();
        $sSQL = "
            SELECT r.id, r.room_name
                FROM $tbl_room r
            WHERE 1=1
                ORDER BY r.room_name
        ";

        $ambil = $this->db->query($sSQL);
        if ($ambil->num_rows() > 0) {
            foreach ($ambil->result() as $data) {
                $hasil[] = $data;
            }
        }
        return $hasil;
    }
    
    public function MDL_SelectRoomCapacity($room_id){
        $tbl_room = $this->config->item('tmst_room');
        
        $sSQL = "
            SELECT r.id, r.room_name, r.capacity
                FROM $tbl_room r
            WHERE 1=1
                AND r.id = '$room_id'
        ";
        
        $hasil = $this->db->query($sSQL)->row();
        
        return $hasil;
    }
    
    public function MDL_SelectUnit(){
        $tbl_unit   = $this->config->item('tmst_unit');
        
        $hasil = array();
        $sSQL = "
            SELECT u.id, u.unit_name
                FROM $tbl_unit u
            WHERE 1=1
                ORDER BY u.unit_name
        ";

        $ambil = $this->db->query($sSQL);
        if ($ambil->num_rows() > 0) {
            foreach ($ambil->result() as $data) {
                $hasil[] = $data;
            }
        }
        return $hasil;
    }
    
    public function MDL_SelectConsumption(){
        $tbl_typevar = $this->config->item('tmst_typevar');
        
        $hasil = array();
        $sSQL = "
            SELECT id, type_name
                FROM $tbl_typevar
            WHERE 1=1
                ORDER BY id
        ";

        $ambil = $this->db->query($sSQL);
        if ($ambil->num_rows() > 0) {
            foreach ($ambil->result() as $data) {
                $hasil[] = $data;
            }
        }
        return $hasil;
        
    }
}

