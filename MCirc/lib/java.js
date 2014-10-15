function tsub(){
        var element=document.getElementById('myform');
        var element2=document.getElementById('time');
        var t= new Date();
        var x=t.getTime();
        element2.value = x;
        element.submit();
}

