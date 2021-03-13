var base = location.protocol+'//'+location.host;
const route = document.getElementsByName('routeName')[0].getAttribute('content');
const http = new XMLHttpRequest();
const csrfToken = document.getElementsByName('csrf-token')[0].getAttribute('content');
document.addEventListener('DOMContentLoaded', function(){
    var btn_search = document.getElementById('btn_search');
    var form_search = document.getElementById('form_search');
    var category = document.getElementById('category');
    if(btn_search){
        btn_search.addEventListener('click', function(e){
            e.preventDefault();
            if(form_search.style.display === 'block'){
                form_search.style.display = 'none';
            }
            else{form_search.style.display = 'block';} 
        });
    }
    if (route == "product_add"){
        setSubCategoriesToProducts();
    }
    if ( route == "product_edit"){
        setSubCategoriesToProducts();
        var btn_product_file_image = document.getElementById('btn_product_file_image');
        var product_file_image = document.getElementById('product_file_image');
        btn_product_file_image.addEventListener('click', function(){
            product_file_image.click();
        }, false);
        product_file_image.addEventListener('change', function(){
            document.getElementById('form_product_gallery').submit();
        });
    }
    document.getElementsByClassName('lk-'+route)[0].classList.add('active');
    btn_deleted = document.getElementsByClassName('btn-deleted');
    for (i = 0; i < btn_deleted.length; i++) {
        btn_deleted[i].addEventListener('click', delete_object);
        
    }
    if(category){
        
        category.addEventListener('change', setSubCategoriesToProducts);
    }
    // Listen for click on toggle checkbox
$('#select-all').click(function(event) {   
    if(this.checked) {
        // Iterate each checkbox
        $(':checkbox').each(function() {
            this.checked = true;                        
        });
    } else {
        $(':checkbox').each(function() {
            this.checked = false;                       
        });
    }
});
});

$(document).ready(function(){
    editor_init('editor');
})

//Muestra el "editor de texto", al crear o editar productos.
function editor_init(field){
    CKEDITOR.replace(field,{
        toolbar:[
            { name: 'clipboard', items:['Cut','Copy','Paste','PasteText','-','Undo','Redo']},
            { name: 'basicstyles', items:['Bold','Italic','BulletedList','Strike','Image','Link']},
            { name: 'document', items:['CodeSnippet','EmojiPanel','Preview','Source']}
        ]
    });


}

//Permite cargar automaticamente las subcategorias al elegir una categoria.
function setSubCategoriesToProducts(){
    var parent_id = category.value;
    var subcategory_actual =  document.getElementById('subcategory_actual').value;
    select = document.getElementById('subcategory');
    select.innerHTML = "";
    var url = base + '/admin/md/api/load/subcategories/'+parent_id;
    http.open('GET', url, true);
    http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    http.send();
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        var data = this.responseText;
        data = JSON.parse(data);
        data.forEach(function(element, index){
            if(subcategory_actual == element.id){
               select.innerHTML += "<option value =\""+element.id+"\" selected>"+element.name+"</option>";
            }else{
            select.innerHTML += "<option value =\""+element.id+"\">"+element.name+"</option>";
            }
        });
        
      }
}

}

//Muestra las ventanas utilizadas al momento de eliminar algun elemento.
//tambien cuando se restaura alguno.

function delete_object(e){
    e.preventDefault(); 
    var object = this.getAttribute('data-object');
    var path = this.getAttribute('data-path');
    var action = this.getAttribute('data-action')
    var url = base + '/'+ path +'/'+ object+'/'+action;

    if(action =="delete"){
        title = "¿Estas seguro de eliminar este objeto?";
        text = "Una vez eliminado, el elemento se enviará a la papelera";
        icon = "warning";

        title2 = "Eliminado";
        text2 = "Elemento enviado a la papelera con éxito";
        icon2 = "success";
        conf = "Si, Eliminar!"
    }

    if(action =="deleted"){
        title = "¿Estas seguro de eliminar este objeto?";
        text = "Una vez eliminado, el elemento no se podrá recuperar";
        icon = "warning";

        title2 = "Eliminado";
        text2 = "Elemento enviado a la papelera con éxito";
        icon2 = "success";
        conf = "Si, Eliminar!"
    }

    if(action =="restore"){
        title = "¿Desea recuperar este objeto?";
        text ="Una vez recuperado, el elemento se eliminará de la papelera";
        icon = "info";

        title2 = "Restaurando";
        text2 = "Elemento restaurado con éxito";
        icon2 = "success";
        conf = "Si, Restaurar!"
    }

      Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: conf
      }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
          Swal.fire(
            title2,
            text2,
            icon2
          )
        }
      })
}
