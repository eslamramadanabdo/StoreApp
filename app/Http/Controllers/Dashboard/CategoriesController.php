<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $request = request();

        $categories = Category::with('parent')
        /*leftJoin('categories as parents' , 'parents.id' , '=' , 'categories.parent_id')
        ->select([
            'categories.*' ,
            'parents.name as parent_name'
        ])*/
        // ->select('categories.*')
        // ->selectRaw('(SELECT COUNT(*) FROM products WHERE category_id = categories.id) as products_count')
        ->withCount([
            'products as products_count' => function($query){
                $query->WHERE('status' , '=' , 'active');
            }
        ])
        ->filter($request->query())
        ->orderBy('categories.name')
        ->paginate();

        // dd($categories);


        return view('dashboard.categories.index' , compact(['categories'])); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parents = Category::all();
        $category = new Category();
        return view('dashboard.categories.create' , compact(['category' , 'parents']) );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate(Category::rules());

        // request merge
        $request->merge( [
            'slug' => Str::slug($request->post('name'))
        ]);

        $data = $request->except('image');

        $data['image'] = $this->uploadImage($request);

        // send Data to store
        $category = Category::create($data); 

        // PRG  => Post Redirect Get
        return redirect()->route('dashboard.categories.index')
                ->with('success' , 'Category Created Successfully');
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {   
        return view('dashboard.categories.show' , compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        try{
            $category = Category::findOrFail($id);
        }catch(Exception $e){
            return redirect()->route('dashboard.categories.index')
                    ->with('info' , 'Record Not Found');
        }

        $parents = Category::where('id' , '<>' , $id)
            ->where(function($query) use($id){
                $query->whereNull('parent_id')
                    ->orWhere('parent_id' , '<>' , $id);
            })->get();

        return view('dashboard.categories.edit' , compact(['category' , 'parents']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(Category::rules($id));

        $category = Category::findOrFail($id);

        // get old image
        $old_image = $category->image;

        // upload new image
        $data = $request->except('image');
        $newImage = $this->uploadImage($request);
        if($newImage){
            $data['image']  = $newImage;
        }
        //  update  
        $category->update($data);

        // remove old image from storage
        if( $old_image && $newImage ){
            Storage::disk('public')->delete($old_image);
        }

        return redirect()->route('dashboard.categories.index')
                ->with('success' , 'Category Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // get record
        $category = Category::findOrFail($id);
        $category->delete();

        // return
        return redirect()->route('dashboard.categories.index')
                ->with('danger' , 'Category Deleted Successfully');
    }


    protected function uploadImage(Request $request){
        if(!$request->hasFile('image')){
            return ;
        }

        $file = $request->file('image');
        $path = $file->store('uploades' , 'public');
        return $path;
    }


    public function trash(){
        $categories = Category::onlyTrashed()->paginate();
        return view('dashboard.categories.trash' , compact('categories'));
    }

    public function restore(Request $request , $id){
        $category  = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('dashboard.categories.trash')->with('success' , 'Category Resotred!');
    }

    public function forceDelete( $id){
        $category  = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();
        
        // remove image
        if( $category->image ){
            Storage::disk('public')->delete($category->image);
        }

        return redirect()->route('dashboard.categories.trash')->with('success' , 'Category Deleted Forever!');
    }

}
