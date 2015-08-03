<?php
class shopproduct extends Model {
	


function _get_all_valid_buildings($default_building_id=0,$uid = '',$main_index=0){
 
	    	$where = '1=1';
	    	  
                
	    	if($default_building_id){
	    		$where.=" and id = ".$default_building_id." ";
	    	}
	    	
	    	$building_sql = "select name,id,start_time,end_time from t_service_buildings where ".$where;
	   
	    	$service_buildings = $this->tickets->personal_select($building_sql);
	    	 
		    $now_time = date('Y-m-d H:i:s');
                    //价格筛选
               
                    $sql="select tu_groupid from t_users where tu_id='$uid'";
		    foreach($service_buildings as $k=>$v){
	    		$sql = "select t_goods.*,t_good_supplier_buildings.*,t_supplier.name as supplier_name,t_supplier_good.*  from t_good_supplier_buildings,t_goods,t_supplier,t_supplier_good where
				 t_good_supplier_buildings.end_time > '".$now_time."' and t_good_supplier_buildings.good_id= t_goods.id and t_goods.id=t_supplier_good.good_id and t_supplier_good.supplier_id = t_supplier.id and t_good_supplier_buildings.building_id = ".$v->id." order by t_goods.price desc,t_goods.cate_id asc" ;
			
		    	$goods = $this->tickets->personal_select($sql);
		    	 
		    	if(!$goods){
		    			unset($service_buildings[$k]);
		    	}else{
		    		foreach($goods as $key=>$val){
			    		$goods[$key]->week = explode(',',$val->week);
				    }
				    $service_buildings[$k]->temp_goods = $goods;
				}
			}
		 
			$final_data = array();
				$final_buildings = array();
					foreach($service_buildings as $k=>$v){
							$final_buildings[] = array('id'=>$v->id,'name'=>$v->name,'start_time'=>$v->start_time,'end_time'=>$v->end_time);
							$final_data[] = $v;
                                                        
			}
                        /*
                                foreach($final_data[0] as $k=>$v){
                                if($v->price>=0&&$v->price<20){
                                    $final_data[1][]=haha2;
                                }else if($v->price>=20&&$v->price<30){
                                    $final_data[2][]=haha3;
                                }else if($v->price>=30){
                                    $final_data[3][]=haha4;
                                }
                                }       */                        
			$sys_mobile = $this->tickets->select('configs',array('tc_type'=>'jifen_config'));
			$sys_mobile = $sys_mobile[0]->tc_content;
			
			return array('final_goods'=>$final_data,'final_buildings'=>$final_buildings,'sys_mobile'=>$sys_mobile);
		}
                
}