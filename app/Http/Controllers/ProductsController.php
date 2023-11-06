<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Parametros;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use App\Models\Product;
// use App\Models\Category;
use Cart;

class ProductsController extends Controller
{
    public $pagesize = 15;
    public $colors = [];
    public $categories = [];
    public $sortSelected = 'na';
    public $colorSelected = 'na';
    public $categorySelected = 'na';

    public function __construct()
    {
        $colorsDB = Parametros::where('parNombre', 'productColors')->first();
        $colors = explode(',',$colorsDB->parValor);
        $this->colors = $colors;

        //Getting the colors
        foreach($this->colors as $index => $color)
        {
            $color_count = Product::query()->where('color', 'LIKE', "%{$color}%")->count(); 
            $attributes = ['color' => $color, 'color_count' => $color_count];
            $this->colors[$index] = $attributes;
        }

        //Getting the categories
        $categories = Category::all();
        foreach($categories as $category){
            if($category->subtype !== null){
                array_push($this->categories,[
                    'type' => $category->type,
                    'subtype'=> explode(',',$category->subtype)
                ]);
            }else{
                array_push($this->categories,$category->type);
            }
        }

        // store sorting variables
        session()->put('parameters',[
            'sort' => 'na',
            'category' => 'na',
            'color' => 'na'
        ]);
        
    }

    use WithPagination;
    public function index()
    {
        $products = Product::paginate($this->pagesize);

        foreach($products as $product){
            if(str_contains($product->image, '["')){
                $product->image = json_decode($product->image);
            }
            else{
                $product->image = [$product->image];
            }
            $product->size_qty = json_decode($product->size_qty);
        }

        return view('livewire.products-component',[
            'products'=>$products,
            'colors' => $this->colors,
            'categories' => $this->categories,
            'sortSelected' => $this->sortSelected,
            'colorSelected' => $this->colorSelected,
            'categorySelected' => $this->categorySelected
        ]); 
    }

    use WithPagination;
    public function sortProduct($parameter,$category,$color)
    {
        $products = new Product;
        $sortLabel = '';

        //sorting
        if($parameter !== 'na'){
            if($parameter == 'date'){
                $products = $products::orderBy('created_at','DESC');
                $sortLabel = 'Sort by newness';
                session()->put('parameters.sort',$parameter);
    
            }elseif($parameter == 'low-to-high'){
                $products = $products::orderBy('regular_price','ASC');
                $sortLabel = 'Sort by price: low to high';
                session()->put('parameters.sort',$parameter);
    
            }elseif($parameter == 'high-to-low'){
                $products = $products::orderBy('regular_price','DESC');
                $sortLabel = 'Sort by price: high to low';
                session()->put('parameters.sort',$parameter);
    
            }elseif($parameter == 'default'){
                return $this->index();
            }

        }else{
            if(session()->get('parameters')['sort'] == 'date'){
                $products = $products::orderBy('created_at','DESC');
                $sortLabel = 'Sort by newness';
                session()->put('parameters.sort',$parameter);
    
            }elseif(session()->get('parameters')['sort'] == 'low-to-high'){
                $products = $products::orderBy('regular_price','ASC');
                $sortLabel = 'Sort by price: low to high';
                session()->put('parameters.sort',$parameter);
    
            }elseif(session()->get('parameters')['sort'] == 'high-to-low'){
                $products = $products::orderBy('regular_price','DESC');
                $sortLabel = 'Sort by price: high to low';
                session()->put('parameters.sort',$parameter);
            }
        }

        

        // filter by categories
        if(session()->get('parameters')['category'] !== 'na' || $category !== 'na'){
            session()->put('parameters.category',$category);

            $categoryObj = session()->get('parameters')['category'];
            if(session()->get('parameters')['color'] !== 'na' ||  session()->get('parameters')['sort'] !== 'na'){
                
                if(str_contains($categoryObj, '|')){ // if searching by subcategories
                    $categories = explode('|',$categoryObj);
                    $products = $products->where('category', 'LIKE', "%{$categories[0]}%")->where('subcategories', 'LIKE', "%{$categories[1]}%");
                }else{ // if searching only by category
                    $products = $products->where('category', 'LIKE', "%{$category}%");
                }
            }else{

                if(str_contains($categoryObj, '|')){ // if searching by subcategories
                    $categories = explode('|',$categoryObj);
                    $products = Product::query()->where('category', 'LIKE', "%{$categories[0]}%")->where('subcategories', 'LIKE', "%{$categories[1]}%");
                }else{ // if searching only by category
                    $products = Product::query()->where('category', 'LIKE', "%{$category}%");
                }
            }
        }

        //filter by colors
        if(session()->get('parameters')['color'] !== 'na' || $color !== 'na'){
            session()->put('parameters.color',$color);

            if(session()->get('parameters')['sort'] !== 'na' ||  session()->get('parameters')['category'] !== 'na'){
                $products = $products->where('color', 'LIKE', "%{$color}%");
            }else{
                $products = Product::query()->where('color', 'LIKE', "%{$color}%");
            }
        }

        $this->sortSelected = session()->get('parameters')['sort'];
        $this->colorSelected = session()->get('parameters')['color'];
        $this->categorySelected = session()->get('parameters')['category'];

        $products = $products->paginate($this->pagesize);
        foreach($products as $product){
            if(str_contains($product->image, '["')){
                $product->image = json_decode($product->image);
            }
            elseif(!is_array($product->image)){
                $product->image = [$product->image];
            }
            $product->size_qty = json_decode($product->size_qty);
        }

        return view('livewire.products-component',[
            'products'=> $products,
            'colors' => $this->colors,
            'categories' => $this->categories,
            'sortLabel'=>$sortLabel,
            'sortSelected' => $this->sortSelected,
            'colorSelected' => $this->colorSelected,
            'categorySelected' => $this->categorySelected
        ]); 
    }

    public static function addProductToCart($id,$page,$size,$qty)
    {
        $product = Product::find($id);

        if(str_contains($product->image, '["')){
            $product->image = json_decode($product->image);
        }
        else{
            $product->image = [$product->image];
        }

        if($size !== 'No Size'){
            $name = $product->name . ' - size: ' . $size;
        }else{
            $name = $product->name;
        }

        Cart::instance('cart')->add([
            'id' => $id, 
            'name' => $name, 
            'price' => $product->regular_price,
            'qty' => 1,
            'options' => [
                'image' => $product->image,
                'productType' => 'product',
                'category' => $product->category,
                'stock' => $qty,
                'size' => $size
            ]
        ]);
 
        session()->flash('message', 'Product has been added to cart!');
        $page = str_replace('|','=',$page);
        $page = str_replace('-','?',$page);
        return redirect('/'.$page);
    }

}
