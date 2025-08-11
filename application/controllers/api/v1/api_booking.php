<?php
header("Access-Control-Allow-Origin: http://192.168.104.114:3000");

require APPPATH . '/libraries/REST_Controller.php';

class Api_booking extends REST_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('md_ftl_booking');
        $this->load->library('Auth');
    }
    
    public function index_options() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Content-Length: 0");
        header("Content-Type: text/plain");
        exit(0);
    }

    public function index_post(){
        $obj   = file_get_contents('php://input');
        $edata = json_decode($obj);
               
        $id = $edata->id;

        $isAllowInsert = $this->md_ftl_booking->MDL_isPermInsert($id);
        if($isAllowInsert) {
            $res = $this->md_ftl_booking->MDL_Insert($edata);
        } else {
            $res = $this->md_ftl_booking->MDL_Update($edata);
        }  

        if($res){
            $data = array(
                "id" => $res,
            ); 
            $this->response($data, 200);
        }  else {
            $this->response(['status' => 400, 'message' => 'Data Failed'], 400);
        }
    }
    
    public function index_get() {
        $page = $_GET['page'];
        $limit = $_GET['limit'];
        
        $result = $this->md_ftl_booking->MDL_Select($page, $limit);
        if (count($result) <= 0){
            $this->response(['status' => 400, 'message' => 'Data tidak ditemukan','data' =>['kode' =>'A02' ,'keterangan' =>'Data Not Found!']], 400);
        } else {
        foreach ($result['data'] as $key => $val) {
            $data[] = array(
                'id'        => $val->id,
                'unit_name' => $val->unit_name,
                'room_name' => $val->room_name,
                'capacity'  => $val->capacity, 
                'meeting_date'  => $this->format_tanggal_indonesia($val->meeting_date),
                'meeting_starttime'   => date('H:i', strtotime($val->meeting_starttime)),
                'meeting_endtime'     => date('H:i', strtotime($val->meeting_endtime)),
                'participant_amount'  => $val->participant_amount,
                'consumption_type'  => $val->consumption_type,
                'consum_name'       => $val->consum_name
            );
        }
        $this->response(array('data'=>$data, 'total'=>$result['total']));
        }
    }
    
    public function format_tanggal_indonesia($tanggal) {
        // Array nama bulan dalam Bahasa Indonesia
        $bulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];
        
        // Pecah tanggal
        $pecah = explode('-', $tanggal);
        $tahun = $pecah[0];
        $bulan_angka = $pecah[1];
        $hari = $pecah[2];

        return $hari . ' ' . $bulan[$bulan_angka] . ' ' . $tahun;
    }
    
    public function bookingByID_get ($id) {        
        $AryData = $this->md_ftl_booking->MDL_SelectByID($id);
        
        $AryData->consumption_type = explode(',', $AryData->consumption_type);
        $AryData->participant_amount = (int) $AryData->participant_amount;
        
        $data[] = $AryData;
        
        if($AryData){            
            $this->response($data);
        } else{
            $this->response(['status' => 400, 'message' => 'Data tidak ditemukan','data' =>['kode' =>'A02' ,'keterangan' =>'Data Not Found!']], 400);
        }                
    }
    
    public function deleteData_delete($id){
        if ($this->md_ftl_booking->MDL_Delete($id)) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Booking deleted successfully'
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'status' => 'error',
                'message' => 'Booking not found'
            ]);
        }
    }
}
