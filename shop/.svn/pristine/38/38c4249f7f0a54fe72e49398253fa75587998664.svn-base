<?php
class picup extends Model {
    function addpic($picture,$keywords,$id){
        //将图片地址存入数据库
        $arr=array($picture,$keywords,$id);
        error_log(print_r($arr, 1),3,"/data/www/xshc/shop/api_images/suppliers/1234.log");
                if($keywords=="update"){
                    $this->db->update('supplier_image',$picture,array('supplier_id'=>$id));
                   // $this->tickets->update('supplier_image',$picture,array('supplier_id'=>$id)); 
                }else if($keywords=="insert"){
                     $this->db->insert('supplier_image',$picture);
                   // $this->tickets->insert('supplier_image',$picture); 
                }
              
        
        
    }
    
    
    
    
}

?>