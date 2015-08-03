<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//微信详情页控制方法
class WechatDetail extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->service('Goods_service');
    }
    public function index(){
           /*if($this->input->post("good_id")&&$this->input->post("building_id")){
 
             $good_id=$this->input->post("good_id");                     
            $building_id=$_POST['building_id'];
             $good_detail = $this->Goods_service->getGoodDetail($good_id,$building_id);
             $data["good_detail"]=$good_detail;
             $this->load->view('wechat/goods_detail',$data);
        }*/
         $good_id=30;
            
            $building_id=43;
           
             $good_detail = $this->Goods_service->getGoodDetail($good_id,$building_id);
             $data["good_detail"]=$good_detail;
             $this->load->view('wechat/goods_detail',$data);
    }



}
