const base = location.protocol + '//' + location.host;
const route = document.getElementsByName('routeName')[0].getAttribute('content');
const http = new XMLHttpRequest();
const csrfToken = document.getElementsByName('csrf-token')[0].getAttribute('content');
const currency = document.getElementsByName('currency')[0].getAttribute('content');
const auth = document.getElementsByName('auth')[0].getAttribute('content');
var page = 1;
var page_section = "";
var product_list_id_temp = [];
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

$(document).ready(function(){
  $('.slick-slider').slick({
    dots: true,
    infinite: true,
    autoplay: true,
    autoplaySpeed: 2000,
  });
});

window.onload = function(){
  loader.style.display = 'none'
}

document.addEventListener('DOMContentLoaded', function () {
  document.getElementsByClassName('lk-'+route)[0].classList.add('active');
  var loader = document.getElementById('loader');
  var form_avatar_change = document.getElementById('form_avatar_change');
  var btn_avatar_edit = document.getElementById('btn_avatar_edit');
  var avatar_change_overlay = document.getElementById('avatar_change_overlay');
  var input_file_avatar = document.getElementById('input_file_avatar');
  var products_list = document.getElementById('product_list');
  var load_more_products = document.getElementById('load_more_products');
  if (btn_avatar_edit) {
    btn_avatar_edit.addEventListener('click', function (e) {
      e.preventDefault();
      input_file_avatar.click();
    })
  }

  if (load_more_products) {
    load_more_products.addEventListener('click', function (e) {
      e.preventDefault();
      load_products(page_section);
    })
  }

  if (input_file_avatar) {
    input_file_avatar.addEventListener('change', function () {
      var load_img = '<img src="' + base + '/static/images/loader.svg"/>';
      avatar_change_overlay.innerHTML = load_img;
      avatar_change_overlay.style.display = 'flex';
      form_avatar_change.submit();
    })
  }
  if (route == "home") {
    load_products('home');
  }
  if (route == "store") {
    
    load_products('store');
  }
  if (route == "store_category") {
    
    load_products('store_category');
  }
  if (route == "search") {
    
    mark_user_favorites([document.getElementsByName('product_id')[0].getAttribute('content')]);
  }
  if(route=="product_single"){
    var inventory = document.getElementsByClassName('inventory');
    for (i=0; i< inventory.length; i++){
      inventory[i].addEventListener('click', function(e){
        e.preventDefault();
        load_product_variants(this.getAttribute('data-inventory-id'));
      });
     
    }
    mark_user_favorites([document.getElementsByName('product_id')[0].getAttribute('content')]);
  }
});
function load_products(section) {
  loader.style.display = "flex";
  page_section = section;
  if(section == 'store_category'){
  var object_id = document.getElementsByName('category_id')[0].getAttribute('content');
  var url = base + '/md/api/load/products/' + page_section+'?page='+page+'&object_id='+object_id;
  }
  else{
    var url = base + '/md/api/load/products/' + page_section+'?page='+page;
  }
  
  http.open('GET', url, true);
  http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      loader.style.display = "none";
      page = page +1;
      var data = this.responseText;
      data = JSON.parse(data);
      if (data.data.length == 0){
        load_more_products.style.display = "none";
      }
      data.data.forEach(function (product, index) {
        //product_list_id_temp.push(product.id);
        var div = "";
       
        div += "<div class=\"product card shadow\">";
          div += "<div class=\"image\">"
             div += "<div class=\"overlay\">";
                div += "<div class=\"btns\">";
                  div += "<a href=\""+base+"/product/"+product.id+"/"+product.slug+"\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Ver Producto\"><i class=\"far fa-eye\"></i></a>";
                  div += "<a href=\"#\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Agregar al Carrito\"><i class=\"fas fa-cart-plus\"></i></a>";
                  if(auth == "1"){
                    div += "<a href=\"#\" id=\"favorite_1_"+product.id+"\" onclick=\"add_to_favorites('"+product.id+"','1'); return false;\"data-toggle=\"tooltip\" data-placement=\"top\" title=\"Agregar a Favoritos\"><i class=\"fas fa-star\"></i></a>";
                  }else{
                    div += "<a href=\"#\" id=\"favorite_1_"+product.id+"\" onclick=\"Swal.fire('Ops....','Hola invitado, para agregar a favoritos, crea o iniciar sesión con una cuenta.', 'warning');\"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"Agregar a Favoritos\"><i class=\"fas fa-star\"></i></a>";
                  } 
                  div += "</div>";
              div += "</div>"
            div += "<img src=\"" + base + "/uploads/" + product.file_path + "/t_" + product.image + "\">";
          div += "</div>";
          div += "<a href=\""+base+"/product/"+product.id+"/"+product.slug+"\" title=\""+product.name+"\">";
            div += "<hr> "
            div += "<div class=\"title\">" + product.name + "</div>";
            div += "<div class=\"price\">" +currency+ product.price + "</div>";
            div += "<div class=\"options\"></div>";
          div += "</a>"
        div += "</div>";
        product_list.innerHTML += div;
      });
        if(auth == "1"){
          mark_user_favorites(product_list_id_temp);
          product_list_id_temp = "";
          
    }
    }
    else {

    }
   
  }
}
//Permite mostrar la animación creada en css, esta se muestra cuando carga la pagina.
function getQueryVariable(variable) {
  var query = window.location.search.substring(1);
  var vars = query.split("&");
  for (var i=0; i < vars.length; i++) {
      var pair = vars[i].split("=");
      if(pair[0] == variable) {
          return pair[1];
      }
  }
  return false;
}
//Permite marcar los elemtos que estan en favoritos y a su vez remueve el efecto on_click, para que no se agregue nuevamente.
function mark_user_favorites (objects){
  var url = base + '/md/api/load/user/favorites';
  var params = 'module=1&objects='+objects;
  http.open('POST', url, true);
  http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
  http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  http.send(params);
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      var data = this.responseText;
      data = JSON.parse(data);
      if(data.count > "0"){
        data.objects.forEach(function (favorite, index) {
            document.getElementById('favorite_1_'+favorite).removeAttribute('on_click');
            document.getElementById('favorite_1_'+favorite).classList.add('favorite_active');
        });
      }
    }
  }
}
//Permite usar la función para agregar productos a favoritos.
function add_to_favorites(object, module){
  url = base+'/md/api/favorites/add/'+object+'/'+module;
  http.open('POST', url, true);
  http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      var data = this.responseText;
      data = JSON.parse(data);
      if(data.status == "success"){
        document.getElementById('favorite_'+module+"_"+object).removeAttribute('on_click');
        document.getElementById('favorite_'+module+"_"+object).classList.add('favorite_active');
      }
    }
}
}

//Cargar variantes de productos
function load_product_variants(inventory_id){
  document.getElementById('variants_div').style.display = 'none';
  document.getElementById('variants').innerHTML = "";
  document.getElementById('field_variant').value=null;
  var inventory_list = document.getElementsByClassName('inventory');
  for (i=0; i< inventory_list.length; i++){
    inventory_list[i].classList.remove('active');
  }
  var product_id = document.getElementsByName('product_id')[0].getAttribute('content');
  var inv = inventory_id;
  document.getElementById('field_inventory').value = inv;
  document.getElementById('inventory_'+inv).classList.add('active');

  var url = base + '/md/api/load/product/inventory/'+inv+'/variants';
  http.open('POST', url, true);
  http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      var data = this.responseText;
      data = JSON.parse(data);
      if(data.length > 0){
        document.getElementById('variants_div').style.display = 'block';
        data.forEach(function (element, index) {
          variant = '';
          variant += '<li>';
            variant += '<a href="#" class="variant" onclick="variant_active_remove(); document.getElementById(\'field_variant\').value='+element.id+'; this.classList.add(\'active\'); return false;"  >';
              variant += element.name;
            variant += '</a>';
          variant += '</li>';
          document.getElementById('variants').innerHTML += variant;

      });

      }
      console.log(data);
    }
  }
 

}
function variant_active_remove(){
  var remove_variant = document.getElementsByClassName('variant');
  for (i=0; i< remove_variant.length; i++){
    remove_variant[i].classList.remove('active');
  }
}
$(document).ready(function () {

  $('.first-button').on('click', function () {

    $('.animated-icon1').toggleClass('open');
  });
  $('.second-button').on('click', function () {

    $('.animated-icon2').toggleClass('open');
  });
  $('.third-button').on('click', function () {

    $('.animated-icon3').toggleClass('open');
  });

});
