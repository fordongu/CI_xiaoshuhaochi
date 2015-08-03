<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('lang_config'))
{
       function substr_zh($in,$num){ 
        $pos=0; 
        $out=""; 
         while($c=mb_substr($in,$pos,1,'utf-8')){ 
             if($c=="\n") break; 
             if(ord($c)>128){ 
                $out.=$c; 
                $pos++; 
                $c=mb_substr($in,$pos,1,'utf-8'); 
                $out.=$c; 
             }else{ 
                $out.=$c; 
             } 
            $pos++; 
             if($pos>=$num) break; 
         } 
         if($out!=$in) $out = $out; 
         return $out; 
     } 

}