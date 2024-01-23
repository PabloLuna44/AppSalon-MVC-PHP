document.addEventListener("DOMContentLoaded", function () {
    startApp();
  });
  

function startApp(){

    FindDate();
    
}


function FindDate(){

    const inputDate=document.querySelector('#fecha');
    inputDate.addEventListener('input', function(event){
    
      const date= event.target.value;
    

      window.location=`?fecha=${date}`;
    
    
    
    
    });
    
    
    }