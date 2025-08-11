<?php

class Md_ftl_booking extends CI_Model {
    public function MDL_Select($page, $limit){
        $tbl_room       = $this->config->item('tmst_room');
        $tbl_unit       = $this->config->item('tmst_unit');
        $tbl_booking    = $this->config->item('ttrs_booking_meeting');
        $tbl_typevar    = $this->config->item('tmst_typevar');
        
        // Hitung total data
        $countSQL = "
            SELECT COUNT(*) as total
            FROM $tbl_booking b
            JOIN $tbl_room r ON b.room_id = r.id
            JOIN $tbl_unit u ON b.unit_id = u.id
        ";
        $queryCount = $this->db->query($countSQL);
        $totalData = $queryCount->row()->total;
        
        // Hitung offset
        $offset = ($page - 1) * $limit;
        
        $sSQL = "
                SELECT b.id, u.unit_name, r.room_name, r.capacity, b.meeting_date, b.meeting_starttime, b.meeting_endtime,
                    b.participant_amount, b.consumption_type
                FROM $tbl_booking b
                    JOIN $tbl_room r ON b.room_id = r.id
                    JOIN $tbl_unit u ON b.unit_id = u.id
                ORDER BY b.meeting_date ASC
                    LIMIT $limit OFFSET $offset
                ";
                
        $ambil = $this->db->query($sSQL);
        $hasil = array();
        if ($ambil->num_rows() > 0) {
            foreach ($ambil->result() as $data) {
                $type_name = array();
                $AryConsumType = explode(',', $data->consumption_type);
                foreach ($AryConsumType as $ty){
                    $getType = $this->db->get_where($tbl_typevar, array('id'=>$ty))->row();
                    
                    $type_name[] = $getType->type_name;
                }
                $data->consum_name = implode(', ', $type_name);
                $hasil[] = $data;
            }
        }
        return [
            'data' => $hasil,
            'total' => $totalData
        ];
    }
    
    public function MDL_SelectByID($id) {        
        $tblName = $this->config->item('ttrs_booking_meeting');
        
        $sSQL = "
                SELECT *
                    FROM $tblName
                WHERE id = '$id'
                ";
        
        $result = $this->db->query($sSQL)->row();
        
        return $result;
    }
    
    public function MDL_isPermInsert($id){
        $tblName = $this->config->item('ttrs_booking_meeting');

        $res = $this->db->get_where($tblName, array('id' => $id))->num_rows();

        if($res) {
            return 0;
        } else {
            return 1;
        }
    }
    
    public function MDL_Insert($edata){       
        $tbl_booking    = $this->config->item('ttrs_booking_meeting');
        
//        $meeting_date       = date("Y-m-d", strtotime($edata->meeting_date));
//        $meeting_starttime  = date("H:i:s", strtotime($edata->meeting_starttime));
//        $meeting_endtime    = date("H:i:s", strtotime($edata->meeting_endtime));
        
        $capacity = isset($edata->capacity) ? (int) $edata->capacity : 0;
        $participant_amount = isset($edata->participant_amount) ? (int) $edata->participant_amount : 0;
        $nominal = isset($edata->consumption_nominal) ? (int) $edata->consumption_nominal : 0;
        
        $data = array(
            'unit_id'   => (int) $edata->unit_id,
            'room_id'   => (int) $edata->room_id,
            'capacity'  => $capacity,
            'meeting_date'      => $edata->meeting_date,
            'meeting_starttime' => $edata->meeting_starttime,
            'meeting_endtime'   => $edata->meeting_endtime,
            'participant_amount'    => $participant_amount,
            'consumption_type'      => implode(',', $edata->consumption_type),
            'consumption_nominal'   => $nominal,
            'recdate'   => date('Y-m-d H:i:s')
        );
                
        $this->db->insert($tbl_booking, $data);
        $id = $this->db->insert_id();
        
        return $id;
    }
    
    public function MDL_Update($edata){       
        $tbl_booking    = $this->config->item('ttrs_booking_meeting');
        
        $meeting_date = date("Y-m-d", strtotime($edata->meeting_date));
        $meeting_starttime  = date("H:i:s", strtotime($edata->meeting_starttime));
        $meeting_endtime    = date("H:i:s", strtotime($edata->meeting_endtime));
        
        $data = array(
            'unit_id'   => $edata->unit_id,
            'room_id'   => $edata->room_id,
            'capacity'  => $edata->capacity,
            'meeting_date'      => $meeting_date,
            'meeting_starttime' => $meeting_starttime,
            'meeting_endtime'   => $meeting_endtime,
            'participant_amount'    => $edata->participant_amount,
            'consumption_type'      => implode(',', $edata->consumption_type),
            'consumption_nominal'   => $edata->consumption_nominal
        );
        
        $this->db->where('id', $edata->id);
        $this->db->update($tbl_booking, $data);
        
        return $edata->id;
    }
    
    public function MDL_Delete($id){
        $tbl_booking    = $this->config->item('ttrs_booking_meeting');

        $res = $this->db->delete($tbl_booking, array('id' => $id));
        
        return $res;
    }
}
