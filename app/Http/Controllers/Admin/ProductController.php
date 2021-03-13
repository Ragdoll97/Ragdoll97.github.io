<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Category;
use App\Http\Models\Product;
use App\Http\Models\Inventory;
use App\Http\Models\Variant;
use App\Http\Models\ProductGallery;
use Validator, Str, Config, Image;

class ProductController extends Controller
{
    //Constructor encargado de cargar los middleware
    //Auth se encarga de verificar si el usuario ha inciado sesión.
    //IsAdmin se encarga de verificar si el usuario cuenta con el rol de administrador
    //User Status verifica si el usuario esta bloqueado o activo dentro de la web.
    // User Permissions verifica los permisos del usuario.
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user.status');
        $this->middleware('user.permissions');
        $this->middleware('isadmin');
    }

    //función encargada de retornar los productos, en este caso se utiliza un switch, dado que la sección productos
    //cuenta con un filtro, el cual funciona evaluando el estado del producto.
    //todo esto se muestra en la vista principal de productos.
    public function getHome($status)
    {
        switch ($status){
            case '0':
                $products = Product::with(['cat', 'getSubCategory'])->where('status', '0')->orderBy('id', 'Desc')->paginate(15);
                break;
            case '1':
                $products = Product::with(['cat', 'getSubCategory'])->where('status', '1')->orderBy('id', 'Desc')->paginate(10);
                break;
            case 'all':
                $products = Product::with(['cat', 'getSubCategory'])->orderBy('id', 'Desc')->paginate(10);
                break;
            case 'trash':
                $products = Product::with(['cat', 'getSubCategory'])->onlyTrashed()->orderBy('id', 'Desc')->paginate(10);
                break;   
        }
       
        $data = ['products' => $products];
        return view('admin.products.home', $data);
    }

    //Función encargada de mostrar en la vista "agregar productos" las categorias y sub-categorias.
    public function getProductAdd()
    {
        $cats = Category::where('module', '0')->where('parent', '0')->pluck('name', 'id');
        $data = ['cats' => $cats];
        return view('admin.products.add', $data);
    }
    //Función encargada de enviar los datos ingresados al momento de agregar un producto.
    //esto permite registrar los productos en la base de datos.
    public function postProductAdd(Request $request)
    {
        $rules = [
            'name' => 'required',
            'img' => 'required|image',
            'content' => 'required'
        ];
        $messages = [
            'name.required' => 'El nombre del producto es requerido',
            'img.required' => 'Seleccione una imagen destacada',
            'img.image' => 'El archivo no es una imagen',
            'content.required' => 'ingrese una descripción del producto'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) :
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')
                ->with('typealert', 'danger')->withInput();
        else :
            
            $path = '/' . date('Y-m-d'); // organiza las imagenes en carpetas usando la fecha.
            $fileExt = trim($request->file('img')->getClientOriginalExtension());
            $upload_path = Config::get('filesystems.disks.uploads.root');
            $name = Str::slug(str_replace($fileExt, '', $request->file('img')->getClientOriginalName()));
            $filename = rand(1, 999) . '-' . $name . '.' . $fileExt;
            $file_file = $upload_path . '/' . $path . '/' . $filename;


            $product = new Product;
            $product->status = '0';
            $product->code = e($request->input('code'));
            $product->name = e($request->input('name'));
            $product->slug = Str::slug($request->input('name'));
            $product->category_id = $request->input('category');
            $product->subcategory_id = $request->input('subcategory');
            $product->file_path = date('Y-m-d');
            $product->image = $filename;
            $product->in_discount = $request->input('indiscount');
            $product->discount = $request->input('discount');
            $product->content = e($request->input('content'));
            if ($product->save()) :
                if ($request->hasFile('img')) :
                    $fl = $request->img->storeAs($path, $filename, "uploads");
                    $img = Image::make($file_file);
                    $img->fit(256, 256, function ($constraint) {  //Se crea una miniatura de las imagenes guardadas
                        $constraint->upsize();
                    });
                    $img->save($upload_path . '/' . $path . '/t_' . $filename);
                endif;
                return redirect('/admin/products/1')->with('message', 'Guardado con éxito')
                    ->with('typealert', 'success');
            endif;
        endif;
    }


    //Función encargada de obtener los datos de un producto registrado en la base de datos
    //permitiendo al usuario editar lo que crea necesario.
    public function getProductEdit($id)
    {
        $products = Product::findOrFail($id);
        $cats = Category::where('module', '0')->where('parent', '0')->pluck('name', 'id');
        $data = ['cats' => $cats, 'p' => $products];
        return view('admin.products.edit', $data);
    }
    //Función que permite enviar los datos editados previamente de algun producto.
    //guardando los cambios en la base de datos.
    public function postProductEdit($id, Request $request)
    {

        $rules = [
            'name' => 'required',
            'content' => 'required'
        ];
        $messages = [
            'name.required' => 'El nombre del producto es requerido',
            'img.image' => 'El archivo no es una imagen',
            'content.required' => 'ingrese una descripción del producto'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) :
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')
                ->with('typealert', 'danger')->withInput();
        else :
            $product = Product::findOrFail($id);
            $imgprepath = $product -> file_path;
            $imgpre = $product -> image;
            $product->status = $request->input('status');
            $product->code = e($request->input('code'));
            $product->name = e($request->input('name'));
            $product->category_id = $request->input('category');
            $product->subcategory_id = $request->input('subcategory');
            if ($request->hasFile('img')) :
                $path = '/' . date('Y-m-d'); // organiza las imagenes en carpetas usando la fecha.
                $fileExt = trim($request->file('img')->getClientOriginalExtension());
                $upload_path = Config::get('filesystems.disks.uploads.root');
                $name = Str::slug(str_replace($fileExt, '', $request->file('img')->getClientOriginalName()));
                $filename = rand(1, 999) . '-' . $name . '.' . $fileExt;
                $file_file = $upload_path . '/' . $path . '/' . $filename;
                $product->file_path = date('Y-m-d');
                $product->image = $filename;
            endif;
            $product->in_discount = $request->input('indiscount');
            $product->discount = $request->input('discount');
            $product->discount_until_date = $request->input('discount_until_date');
            $product->content = e($request->input('content'));
            if ($product->save()) :
                $this->getUpdateMinPrice($product->id);
                if ($request->hasFile('img')) :
                    $fl = $request->img->storeAs($path, $filename, "uploads");
                    $img = Image::make($file_file);
                    $img->fit(256, 256, function ($constraint) {  //Se crea una miniatura de las imagenes guardadas
                        $constraint->upsize();
                    });
                    $img->save($upload_path . '/' . $path . '/t_' . $filename);
                    unlink($upload_path.'/'.$imgprepath.'/'.$imgpre);
                    unlink($upload_path.'/'.$imgprepath.'/t_'.$imgpre);
                endif;
                return back()->with('message', 'Actualizado con éxito')
                    ->with('typealert', 'success');
            endif;
        endif;
    }
    //Función que permite al usuario agregar imagenes a una galeria, permitiendo que estas se muestren en la vista 
    //del producto, presentada en la tienda.
    public function postProductGalleryAdd($id ,Request $request)
    {
        
        $rules = [
            'file_image' => 'required',

        ];
        $messages = [

            'file_image.required' => 'El archivo no es una imagen',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) :
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')
                ->with('typealert', 'danger')->withInput();

        else :
            if ($request->hasFile('file_image')) :
                $path = '/' . date('Y-m-d'); // organiza las imagenes en carpetas usando la fecha.
                $fileExt = trim($request->file('file_image')->getClientOriginalExtension());
                $upload_path = Config::get('filesystems.disks.uploads.root');
                $name = Str::slug(str_replace($fileExt, '', $request->file('file_image')->getClientOriginalName()));
                $filename = rand(1, 999) . '-' . $name . '.' . $fileExt;
                $file_file = $upload_path . '/' . $path . '/' . $filename;
  

                $g = new ProductGallery;
                $g->product_id = $id;
                $g->file_path = date('Y-m-d');
                $g->file_name = $filename;
                if ($g->save()) :
                    if ($request->hasFile('file_image')) :
                        $fl = $request->file_image->storeAs($path, $filename, "uploads");
                        $img = Image::make($file_file);
                        $img->fit(512, 512, function ($constraint) {  //Se crea una miniatura de las imagenes guardadas
                            $constraint->upsize();
                        });
                        $img->save($upload_path.'/'.$path.'/t_'.$filename);
                    endif;
                    return back()->with('message', 'imagen subida con éxito')
                        ->with('typealert', 'success');
                endif;
            endif;
        endif;
    }
    //Función que permite eliminar las imagenes de la galeria utilizando el identificador de esta.
    function getProductGalleryDelete($id, $gid){
        $g = ProductGallery::findOrFail($gid);
        $path =$g -> file_path;
        $file =$g -> file_name;
        $upload_path = Config::get('filesystems.disks.uploads.root');
        if ($g->product_id != $id){
            return back()->with('message', 'No se puede eliminar')->with('typealert', 'danger');
        }else{
            if($g->delete()):
                unlink($upload_path.'/'.$path.'/'.$file);
                unlink($upload_path.'/'.$path.'/t_'.$file);
                return back()->with('message', 'Imagen borrada con exito')->with('typealert', 'success');
            endif;
        }
        

    }
    //función que permite realizar busquedas dentro de la sección productos.
    //se puede buscar por nombre o codigo de producto.
    public function postProductSearch(Request $request){
        $rules = [
            'search' => 'required'
           
        ];
        $messages = [
            'search.required' => 'La busqueda es requerida'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) :
            return redirect('/admin/products/1')->withErrors($validator)->with('message', 'Se ha producido un error')
                ->with('typealert', 'danger')->withInput();
        else :
            switch ($request->input('filter')): 
                case '0':
                    $products = Product::with(['Cat'])->where('name', 'LIKE', '%'.$request->input('search').'%')
                    ->where('status', $request->input('status'))->orderBy('id', 'Desc')->get();
                    break;
                case '1':
                    $products = Product::with(['Cat'])->where('code', $request->input('search'))
                    ->orderBy('id', 'Desc')->get();
                    break;
                endswitch;

            $data = ['products' => $products];
            return view('admin.products.search', $data);
        endif;
    }
    //Permite eliminar productos utilizando el id de este.
    //No obstante estos no se eliminan, solo se envian a la papelera.
    public function getProductDelete($id){
        $p = Product::findOrFail($id);
        if($p->delete()):
           
            return back()->with('message', 'Producto enviado a la papelera de reciclaje')->with('typealert', 'success');
        endif;
    }
    //Permite restaurar algun producto desde la papelera.
    public function getProductRestore($id){
        $p = Product::onlyTrashed()->where('id' , $id)->first();
        if($p->restore()):
            return redirect('/admin/products/'.$p->id.'/edit')->with('message', 'Producto restaurado con éxito')->with('typealert', 'success');
        endif;
    }
    //Función que permite obtener el inventario de los productos.
    public function getProductInventory($id){
        $product = Product::findOrFail($id);
        $data = ['product' => $product];
        return view('admin.products.inventory', $data);
    }
    //Función que permite enviar los datos al momento de crear un inventario para algun producto.
    //El precio ingresado se reflejara en el producto. 
    //Pero para ello se deben cambiar las variables, ya que la base de datos aun tiene a productos con
    //precio e inventario. (Aun no se utlizan los valores que se guardan en inventario)
    public function postProductInventory(Request $request,$id){
        $rules = [
            'name' => 'required',
            'price' => 'required',
          
        ];
        $messages = [
            'name.required' => 'El nombre del inventario es requerido',
           
            'price.required' => 'Ingrese el precio del inventario',
           
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) :
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')
                ->with('typealert', 'danger')->withInput();
        else :
            $inventory = new Inventory;
            $inventory -> product_id = $id;
            $inventory -> name = e($request->input('name'));
            $inventory -> quantity = $request->input('quantity');
            $inventory -> price = $request->input('price');
            $inventory -> limited = $request->input('limited');
            $inventory -> minimum = $request->input('minimum');
            if ($inventory->save()) :
                $this->getUpdateMinPrice($inventory->product_id);
                return back()->withErrors($validator)->with('message', 'Guardado con Éxito')
                ->with('typealert', 'success')->withInput();
            endif;
        endif;
    }

    //Función que permite obtener los datos de un inventario en especifico
    //así se pueden cambiar datos como el precio, nombre, etc.
    public function getInventoryEdit($id){
        $inventory = Inventory::findOrFail($id);
        $data = ['inventory' => $inventory];
        return view('admin.products.inventory_edit', $data);
    }

    //Función que envia los datos editados a la base de datos, para que los cambios sean permanentes
    //hasta realizar otra edición al inventario.
    public function postInventoryEdit($id, Request $request){
        $rules = [
            'name' => 'required',
            'price' => 'required',
          
        ];
        $messages = [
            'name.required' => 'El nombre del inventario es requerido',
           
            'price.required' => 'Ingrese el precio del inventario',
           
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) :
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')
                ->with('typealert', 'danger')->withInput();
        else :

            $inventory = Inventory::findOrFail($id);
            $inventory -> name = e($request->input('name'));
            $inventory -> quantity = $request->input('quantity');
            $inventory -> price = $request->input('price');
            $inventory -> limited = $request->input('limited');
            $inventory -> minimum = $request->input('minimum');
           
            if ($inventory->save()) :
                $this->getUpdateMinPrice($inventory->product_id);
                return back()->withErrors($validator)->with('message', 'Guardado con Éxito')
                ->with('typealert', 'success')->withInput();
            endif;
        endif;
    }


    //Función que elimina inventarios utilizando el id.
    public function getInventoryDelete($id){
        $inventory = inventory::findOrFail($id);
        if($inventory->delete()):
            $this->getUpdateMinPrice($inventory->product_id);
            return back()->with('message', 'Inventario eliminado')->with('typealert', 'success');
        endif;
    }

    //Función que permite guardar variantes de inventario, osea se pueden crear mas de un
    //inventario por producto.
    public function postInventoryVariantAdd($id, Request $request){
        $rules = [
            'name' => 'required'
        ];
        $messages = [
            'name.required' => 'El nombre de la variante es requerido'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) :
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')
                ->with('typealert', 'danger')->withInput();
        else :

            $inventory = Inventory::findOrFail($id);
            $variant = new Variant;
            $variant -> product_id = $inventory->product_id;
            $variant -> inventory_id = $id;
            $variant -> name = e($request->input('name'));
            if ($variant->save()) :
                return back()->withErrors($validator)->with('message', 'Guardado con Éxito')
                ->with('typealert', 'success')->withInput();
            endif;
        endif;
    }
    //Elimina variantes de inventario utilizando el id.
    public function getVariantDelete($id){
        $variant = Variant::findOrFail($id);
        if($variant->delete()):
           
            return back()->with('message', 'Variante eliminado')->with('typealert', 'success');
        endif;
    }

    public function getUpdateMinPrice($id){
        $product = Product::find($id);
        $price = $product->getPrice->min('price');
        $product->price = $price;
        $product->save();
    }
}
