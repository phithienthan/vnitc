/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function checkAll(checkall,field){           
    if(checkall.checked==true){          
        
//        if(field.length != 'undefined'){
//            field[0].checked = true ;
//        }
        for (i = 0; i < field.length; i++)            
            field[i].checked = true ;
    }else{
        for (i = 0; i < field.length; i++)
            field[i].checked = false ;
    }    
}
function delAll(frmGrid,field){  
    var chked = false;
    for (i = 0; i < field.length; i++){
        if(field[i].checked == true){
            chked = true;
        }
    }
    if(!chked){
        alert('Hãy chọn ít nhất 1 phần tử');
        return;
    }
    if(confirm('Xóa tất cả các phần tử được chọn?')){
        frmGrid.submit();
    }
}
