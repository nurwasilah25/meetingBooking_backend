<?php
header("Access-Control-Allow-Origin: http://192.168.104.114:3000");

require APPPATH . '/libraries/REST_Controller.php';

class Api_typevar extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('md_ref_json');
    }

    public function room_get() {
        $AryRoom = $this->md_ref_json->MDL_SelectRoom();

        if (count($AryRoom) <= 0) {
            $this->response(['status' => 400, 'message' => 'Data tidak ditemukan','data' =>['kode' =>'A02' ,'keterangan' =>'Invalid Schema Validation']], 400);
        } else {
           foreach ($AryRoom as $key => $val) {
               $data[] = array(
                   'id'   => $val->id,
                   'name'   => $val->room_name,
               );
           }
           $this->response($data);
        }
    }
    
    public function room_capacity_get(){
        $room_id = $_GET['id'];
        
        $getData = $this->md_ref_json->MDL_SelectRoomCapacity($room_id);
                        
        if (empty($getData)) {
            $this->response(['status' => 400, 'message' => 'Data tidak ditemukan','data' =>['kode' =>'A02' ,'keterangan' =>'Invalid Schema Validation']], 400);
        } else {
            $data = $getData->capacity;
            $this->response(['capacity'=>$data]);
        }
    }
    
    public function unit_get() {
        $AryUnit = $this->md_ref_json->MDL_SelectUnit();

        if (count($AryUnit) <= 0) {
            $this->response(['status' => 400, 'message' => 'Data tidak ditemukan','data' =>['kode' =>'A02' ,'keterangan' =>'Invalid Schema Validation']], 400);
        } else {
           foreach ($AryUnit as $key => $val) {
               $data[] = array(
                   'id'   => $val->id,
                   'name'   => $val->unit_name,
               );
           }
           $this->response($data);
        }
    }
    
    public function consumptions_get(){
        $AryConsum = $this->md_ref_json->MDL_SelectConsumption();

        if (count($AryConsum) <= 0) {
            $this->response(['status' => 400, 'message' => 'Data tidak ditemukan','data' =>['kode' =>'A02' ,'keterangan' =>'Invalid Schema Validation']], 400);
        } else {
           foreach ($AryConsum as $key => $val) {
               $data[] = array(
                   'id'   => $val->id,
                   'name'   => $val->type_name,
               );
           }
           $this->response($data);
        }
    }

}
