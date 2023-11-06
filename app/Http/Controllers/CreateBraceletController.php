<?php

namespace App\Http\Controllers;

use App\Models\Bracelet;
use Illuminate\Http\Request;
use App\Providers\AWS\S3;
use Cart;

class CreateBraceletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.create-bracelet');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // save bracelet into db
        $input = $request->all();
        $bracelet = new Bracelet();
        $bracelet->type = $input['type'];
        $bracelet->size = $input['size'];
        $bracelet->name = $input['name'];
        $bracelet->colors = $input['color'];
        $bracelet->quantity = $input['quantity'];
        $bracelet->price = $input['price'];
        $url = self::getTempFileUrl($input['bracelet_image'], $input['type']); // convert image base64 to file and upload it to S3
        $bracelet->image = $url;        
        $bracelet->save();

        // retrieve bracelet just created in db and add it to cart 
        $braceletDB = $bracelet->refresh();
        self::addBraceletToCart($braceletDB);

        session()->flash('success_message', 'Item added in cart');
        return redirect('/cart');
    }

    public function addBraceletToCart($braceletDB)
    {
        $colors = self::getBraceletColors($braceletDB['colors']);
        $nameFormat = strtoupper($braceletDB['name']) . ' - ' . $braceletDB['type'] . ' - ' . $colors . ' - ' . strtoupper($braceletDB['size']);

        Cart::instance('cart')->add([
            'id' => $braceletDB['id'], 
            'name' => $nameFormat, 
            'price' => $braceletDB['price'],
            'qty' => $braceletDB['quantity'],
            'options' => [
                'size' => $braceletDB['size'],
                'color' => $colors,
                'image' => $braceletDB['image'],
                'productType' => 'custom_bracelet'
            ]
        ]);
    }

    public function getBraceletColors($data)
    {
        $colorsObj = json_decode($data,true);
        if($colorsObj['colors_number'] == 1){
            $colors = $colorsObj['color_full'];
        }elseif($colorsObj['colors_number'] == 2){
            $colors = $colorsObj['color_sides'] . '(sides) & ' .  $colorsObj['color_center'] . '(center)';
        }elseif($colorsObj['colors_number'] == 3){
            $colors = $colorsObj['color_left'] . '(left), ' .  $colorsObj['color_center'] . '(center) & ' . $colorsObj['color_right'] . '(right)';
        }
        return $colors;
    }

    public function getTempFileUrl($data, $prefix)
    {
        $name = 'image-'.$prefix.'.png';
        $data = explode( ',', $data);
        $tmpfname = tempnam("/tmp", $name);
        $handle = fopen($tmpfname, "w");
        fwrite($handle, base64_decode($data[1]));
        fclose($handle);
        $url = S3::subirArchivoS3($tmpfname , $name);
        unlink($tmpfname);
        return $url;
    }
    
}
