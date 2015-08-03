<?php

/*
 * 调出商品详情以及数据
 */

class Product_model extends CI_Model {
//调出当前building_id下的商品信息饼获得最贵的菜
    /*
     * $default_building_id 当前的building_id
     */
    public function getGoodsValid($default_building_id = 0) {
        $this->load->model("Base_model");
        $where = '1=1';
        if ($default_building_id) {
            $where.=" and id = " . $default_building_id . " ";
        }
        $building_sql = "select name,id,start_time,end_time from t_service_buildings where " . $where;
        $query = $this->db->query($building_sql, array($where));
        $service_buildings = $query->result();
        $now_time = date('Y-m-d H:i:s');
        //价格筛选              
        // $sql="select tu_groupid from t_users where tu_id='$uid'";
        foreach ($service_buildings as $k => $v) {
            $sql = "select t_goods.*,t_good_supplier_buildings.*,t_supplier.descr,t_supplier.name as supplier_name,t_supplier_good.*,t_supplier_image.*  from t_supplier_image,t_good_supplier_buildings,t_goods,t_supplier,t_supplier_good where t_supplier.id=t_supplier_image.supplier_id and
				 t_good_supplier_buildings.end_time > ? and t_good_supplier_buildings.good_id= t_goods.id and t_goods.id=t_supplier_good.good_id and t_supplier_good.supplier_id = t_supplier.id and t_good_supplier_buildings.building_id = ? order by t_goods.price desc,t_goods.cate_id asc";
            $query = $this->db->query($sql, array($now_time, $v->id));
            $goods = $query->result();
            if(!$goods){
                $sql = "select t_goods.*,t_good_supplier_buildings.*,t_supplier.descr,t_supplier.name as supplier_name,t_supplier_good.* from t_good_supplier_buildings,t_goods,t_supplier,t_supplier_good where 
				 t_good_supplier_buildings.end_time > ? and t_good_supplier_buildings.good_id= t_goods.id and t_goods.id=t_supplier_good.good_id and t_supplier_good.supplier_id = t_supplier.id and t_good_supplier_buildings.building_id = ? order by t_goods.price desc,t_goods.cate_id asc";
            $query = $this->db->query($sql, array($now_time, $v->id));
            $goods = $query->result(); 
            }
            if (!$goods) {
                unset($service_buildings[$k]);
            } else {
             
                foreach ($goods as $key => $val) {
                    $goods[$key]->week = explode(',', $val->week);
                         if(in_array(1, $goods[$key]->week)){
                        $good_first1[]=$val->good_id;
                    }
                    if(in_array(2, $goods[$key]->week)){
                        $good_first2[]=$val->good_id;
                    }
                    if(in_array(3, $goods[$key]->week)){
                        $good_first3[]=$val->good_id;
                    }
                    if(in_array(4, $goods[$key]->week)){
                        $good_first4[]=$val->good_id;
                    }
                    if(in_array(5, $goods[$key]->week)){
                        $good_first5[]=$val->good_id;
                    }
                                               
                }
                        $first1= $good_first1[0];
                        $first2= $good_first2[0];
                        $first3= $good_first3[0];
                        $first4= $good_first4[0];
                        $first5= $good_first5[0];
                        $first=array($first1,$first2,$first3,$first4,$first5);
                $service_buildings[$k]->temp_goods = $goods;
            }
        }

        $final_data = array();
        $final_buildings = array();
        foreach ($service_buildings as $k => $v) {
            $final_buildings[] = array('id' => $v->id, 'name' => $v->name, 'start_time' => $v->start_time, 'end_time' => $v->end_time);
            $final_data[] = $v;
        }

        $sys_mobile = $this->Base_model->select('configs', array('tc_type' => 'jifen_config'));
        $sys_mobile = $sys_mobile[0]->tc_content;

        return array('final_goods' => $final_data, 'final_buildings' => $final_buildings, 'sys_mobile' => $sys_mobile,'first'=>$first);
    }
 /**
     * 获取时间如果超过规定时间就显示第二天的菜
     *
     * @param 
     * @param 
     */
    public function getDate(){
        
        $sql="select tc_title from t_configs where 1=1 and tc_type='order_date';";
       $date=$this->db->query($sql)->row();
       
       return $date;
    }
}
