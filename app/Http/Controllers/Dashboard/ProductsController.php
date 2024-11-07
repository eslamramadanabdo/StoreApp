<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\Tag;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
 {
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index()
 {
        // eager loding to use relation to get category_name and store_name
        $products = Product::with( [ 'category', 'store' ] )->paginate();
        // dd( $products );
        return view( 'dashboard.products.index', compact( 'products' ) );
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function create()
 {
        $categories = Category::all();
        $user = Auth::user();

        // get store if user has store if not then is admin i will show all stores
        if ( $user->store_id ) {
            $stores = Store::where( 'id', '=', $user->store_id )->get();
        } else {
            $stores = Store::all();
        }

        $product = new Product();
        $tags = new Tag();

        return view( 'dashboard.products.create', compact( [ 'categories', 'stores', 'product' , 'tags' ] ) );

    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function store( Request $request )
 {

        // validate data
        $request->validate( Product::rules()  );

        // request merge
        $request->merge( [
            'slug' => Str::slug( $request->post( 'name' ) )
        ] );

        // save image
        $data = $request->except( ['image' , 'tags'] );
        $data[ 'image' ] = $this->uploadImage( $request );

        // send Data to store
        $product = Product::create( $data );


        // tags
        $tags = explode(',' , $request->post('tags'));
        $tag_ids = [];
        $saved_tages = Tag::all();
        foreach($tags as $t_name){  
            $slug = Str::slug($t_name);
            $tag = $saved_tages->where('slug' , '=' , $slug)->first();
            if(!$tag){
                $tag = Tag::create([
                    'name' => $t_name,
                    'slug' => $slug,
                ]);
            }
            $tag_ids[]= $tag->id;
        }
        $product->tags()->sync($tag_ids);

        // PRG  => Post Redirect Get
        return redirect()->route( 'dashboard.products.index' )
        ->with( 'success', 'Product Created Successfully' );

    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function show( $id )
 {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function edit( $id )
 {

        try {
            $product = Product::findOrFail( $id );

            $categories = Category::all();
            $user = Auth::user();
    
            // get store if user has store if not then is admin i will show all stores
            if ( $user->store_id ) {
                $stores = Store::where( 'id', '=', $user->store_id )->get();
            } else {
                $stores = Store::all();
            }

            $tags = implode(',' , $product->tags()->pluck('name')->toArray());

        } catch( Exception $e ) {
            return redirect()->route( 'dashboard.products.index' )
            ->with( 'info', 'Record Not Found' );
        }



        return view( 'dashboard.products.edit', compact( [ 'product', 'stores', 'categories' , 'tags' ] ) );
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function update( Request $request, Product $product )
 {

        $request->validate( Product::rules($product->id) );

        // get old image
        $old_image = $product->image;

        // upload new image
        $data = $request->except( ['image' , 'tags' ] );
        $newImage = $this->uploadImage( $request );
        if ( $newImage ) {
            $data[ 'image' ]  = $newImage;
        }


        //  update
        $product->update( $data );

        // tags
        $tags = explode(',' , $request->post('tags'));
        $tag_ids = [];
        $saved_tages = Tag::all();
        foreach($tags as $t_name){  
            $slug = Str::slug($t_name);
            $tag = $saved_tages->where('slug' , '=' , $slug)->first();
            if(!$tag){
                $tag = Tag::create([
                    'name' => $t_name,
                    'slug' => $slug,
                ]);
            }
            $tag_ids[] = $tag->id;
        }

        $product->tags()->sync($tag_ids);

        // remove old image from storage
        if ( $old_image && $newImage ) {
            Storage::disk( 'public' )->delete( $old_image );
        }

        return redirect()->route( 'dashboard.products.index' )
                ->with( 'success', 'Product Updated Successfully' );

    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function destroy( $id )
    {
        // get record
        $Product = Product::findOrFail($id);
        $Product->delete();

        // return
        return redirect()->route('dashboard.products.index')
                ->with('danger' , 'Product Deleted Successfully');
    }

    protected function uploadImage( Request $request ) {
        if ( !$request->hasFile( 'image' ) ) {
            return ;
        }

        $file = $request->file( 'image' );
        $path = $file->store( 'uploades', 'public' );
        return $path;
    }

    
    public function trash(){
        $products = Product::onlyTrashed()->paginate();
        return view('dashboard.products.trash' , compact('products'));
    }

    public function restore(Request $request , $id){
        $product  = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('dashboard.products.trash')->with('success' , 'Product Resotred!');
    }

    public function forceDelete( $id){
        $product  = Product::onlyTrashed()->findOrFail($id);
        $product->forceDelete();
        
        // remove image
        if( $product->image ){
            Storage::disk('public')->delete($product->image);
        }

        return redirect()->route('dashboard.products.trash')->with('success' , 'Product Deleted Forever!');
    }
}
