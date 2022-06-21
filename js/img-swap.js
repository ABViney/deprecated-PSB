let active_ele;
let img_count;

window.onload = function() {
  active_ele = document.getElementById('0');
  img_count = document.getElementsByName('thumbnail').length;
  
  document.getElementsByClassName('scroller')[0].addEventListener('click', swap_target);
  document.getElementById('l').addEventListener('click', cycleImg);
  document.getElementById('r').addEventListener('click', cycleImg);
  
  active_ele.checked = true;
  window.scrollTo(0, 0); //reset view after autofocus
}

function cycleImg(e) {
  let i = parseInt(document.getElementById('active').querySelector('input[name=thumbnail]').id);
  switch(e.target.id) {
    case 'r':
      i = (++i == img_count) ? 0 : i;
      break;
    case 'l':
      i = (i != 0) ? i-1 : img_count-1;
      break;
  }
  active_ele = document.getElementById(i);
  active_ele.checked = true;
  
  swap_target();
}

function swap_target() {
  active_ele = document.querySelector('input[name=thumbnail]:checked');
  document.getElementById('active').removeAttribute('id');
  document.getElementById('target').src = active_ele.value;
  active_ele.closest('.selector').id = "active";
}