<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Check extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->service('Goods_service');
        $this->load->service('Cart_service');
        // $sql="select tc_title from t_configs where 1=1 and tc_type='order_date';";
     //  $date=$this->db->query($sql)->row();
     //  print_r($date); 
    }

    public function index()
    {
       $sql = "select t_goods.*,t_good_supplier_buildings.*,t_supplier.descr,t_supplier.name as supplier_name,t_supplier_good.* from t_good_supplier_buildings,t_goods,t_supplier,t_supplier_good where 
				 t_good_supplier_buildings.good_id= t_goods.id and t_goods.id=t_supplier_good.good_id and t_supplier_good.supplier_id = t_supplier.id and t_good_supplier_buildings.building_id = 43 order by t_goods.price desc,t_goods.cate_id asc";
            $query = $this->db->query($sql);
            $goods = $query->result(); 
               foreach ($goods as $key => $val) {
                    $goods[$key]->week = explode(',', $val->week);
                   if(in_array(1, $goods[$key]->week)){
                        $good_first1[]=$val->id;
                    }
                    if(in_array(2, $goods[$key]->week)){
                        $good_first2[]=$val->id;
                    }
                    if(in_array(3, $goods[$key]->week)){
                        $good_first3[]=$val->id;
                    }
                    if(in_array(4, $goods[$key]->week)){
                        $good_first4[]=$val->id;
                    }
                    if(in_array(5, $goods[$key]->week)){
                        $good_first5[]=$val->id;
                    }
               }
                 $first1= $good_first1[0];
                        $first2= $good_first2[0];
                        $first3= $good_first3[0];
                        $first4= $good_first4[0];
                        $first5= $good_first5[0];
                        $first=array($first1,$first2,$first3,$first4,$first5);
                        print_r($first);
    }
    
   function tee(){
            $res=$this->Cart_service->getCartInfo();
            print_r($res);exit;

}
}
