document.addEventListener('DOMContentLoaded',function(){
  var toggle=document.querySelector('.search-toggle');
  var header=document.querySelector('.site-header');
  var body=document.body;
  var box=document.querySelector('.header-search');
  if(!toggle||!header||!box) return;
  function open(){
    header.classList.add('search-open');
    body.classList.add('search-open');
    var input=box.querySelector('input[type="search"]');
    if(input) input.focus();
  }
  function close(){
    header.classList.remove('search-open');
    body.classList.remove('search-open');
    toggle.focus();
  }
  toggle.addEventListener('click',function(){
    if(header.classList.contains('search-open')) close(); else open();
  });
  var closeBtn=box.querySelector('.close-search');
  if(closeBtn){ closeBtn.addEventListener('click',close); }
  document.addEventListener('keydown',function(e){ if(e.key==='Escape') close(); });
  var back=document.querySelector('.back-to-top');
  if(back){
    back.addEventListener('click',function(ev){
      ev.preventDefault();
      window.scrollTo({top:0, behavior:'smooth'});
    });
  }
});
