document.addEventListener('DOMContentLoaded',function(){
  var btn=document.querySelector('.headlines .load-more');
  var list=document.querySelector('.headlines .headlines-list');
  if(!btn||!list||!window.upiAjax) return;
  var page=2;
  btn.addEventListener('click',function(){
    btn.disabled=true;
    btn.classList.add('loading');
    fetch(upiAjax.url,{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:'action=upi_load_more&page='+page})
      .then(function(r){return r.json();})
      .then(function(data){
        if(data && data.html){ 
          var wrap=document.createElement('div'); 
          wrap.innerHTML=data.html; 
          while(wrap.firstChild){ list.appendChild(wrap.firstChild); }
          page+=1;
        }
        if(data && data.has_more){ btn.disabled=false; btn.classList.remove('loading'); } else { btn.style.display='none'; }
      })
      .catch(function(){ btn.disabled=false; btn.classList.remove('loading'); });
  });
});
