$(function(){
    $(".cate_del").click(function(){
        var id=$(this).attr("date_supplier_id");
        var submitData = {id:id}
        if(confirm("确定要删除吗？"))
 {
     
        $.post("supplier_delete",submitData,function(data){
            if(data.success=="yes"){
                alert(data.msg);
                window.location.reload();
            }
               },"json");
 }
       
    })
})
