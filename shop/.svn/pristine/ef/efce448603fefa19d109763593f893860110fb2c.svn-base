<?php
class picup extends Model {
    function addpic($picture,$keywords,$id){
        //将图片地址存入数据库
          
                if($keywords=="update"){
                    $this->tickets->update('supplier_image',$picture,array('supplier_id'=>$id)); 
                }else if($keywords=="insert"){
                    $this->tickets->insert('supplier_image',$picture); 
                }
              
        
        
    }
    
    
    
    
}

?>