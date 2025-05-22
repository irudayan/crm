<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Maatwebsite\Excel\Excel as ExcelFile;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;


class ProductsController extends Controller
{

    use CsvImportTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $products = Products::with('category')->get(); // Eager load category
    $categories = ProductCategory::all();

    if ($categories->isEmpty()) {
        return view('admin.products.index', compact('products', 'categories'))
            ->with('message', 'No categories found.');
    }
        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ProductCategory::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Products::create($request->all());
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Products $products)
    {
        return view('admin.products.show', compact('products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(Products $products)
    {
        return view('admin.products.edit', compact('products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Products $products, $id)
    {
      // Validate the request
      $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:product_categories,id',
        'description' => 'string|max:1000',
        'price' => 'required|numeric',
        'tax' => 'required|numeric',
        // 'assigned_name' => 'required|string|max:255',
    ]);

    // Fetch product by ID
    $product = Products::findOrFail($id);

    // Update product
    $updated = $product->update($request->all());

    // Debugging
    if ($updated) {
        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    } else {
        return redirect()->back()->with('error', 'Failed to update product.');
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products $product)
    {
        // DD('in');
        $product->forcedelete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }


    public function getProductDetails($id)
{
    $product = Products::where('id', $id)->select('name', 'price')->first();

    if ($product) {
        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Product not found'
        ]);
    }
}



public function bulkImport()
{

    return view('admin.products.bulkImport');
}

    public function bulkImportStore(Request $request)
    {


        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx,csv'
        ]);

        $path1 = $request->file('file')->store('temp', 'public');
        $path = storage_path('app/public/' . $path1);

        if (!file_exists($path)) {
            return back()->with('error', 'File does not exist and can therefore not be imported.');
        }

        $data = Excel::toArray([], $path);
// dd($data);

                    foreach ($data as $key => $value) {
                        foreach ($value as $key => $row) {
                        if ($key != 0) {
                            $row0 = (trim($row[0]) == '') ? null : trim($row[0]);
                            $row1 = (trim($row[1]) == '') ? null : trim($row[1]);
                            $row2 = (trim($row[2]) == '') ? null : trim($row[2]);
                            $row3 = (trim($row[3]) == '') ? null : trim($row[3]);
                            $row4 = (trim($row[4]) == '') ? null : trim($row[4]);
                            $row5 = (trim($row[5]) == '') ? null : trim($row[5]);


                                $categoryName = ProductCategory::where('name', $row2)->first();

                                if (!$categoryName) {
                                    return back()->with('message', 'Category Name not found!Name: ' . $row2);
                                }

                                // Insert data into the product
                                // $productsAddData = array(

                                //     'name'    => $row0,
                                //     'description'    => $row1,
                                //     'category_id'    => $categoryName->id,
                                //     'price'    => $row3,
                                //     'tax' =>$row4,
                                //     'assigned_name' =>$row5,
                                // );
                                // $productsAdd = Products::create($productsAddData);
                                $existingProducts = Products::where('name', $row0)->first();

                                if (!$existingProducts) {
                                    // Insert data Branch
                                    $productsAddData = array(
                                            'name'    => $row0,
                                            'description'    => $row1,
                                            'category_id'    => $categoryName->id,
                                            'price'    => $row3,
                                            'tax' =>$row4,
                                            'assigned_name' =>$row5,
                                    );
                                    $productsAdd = Products::create($productsAddData);

                                } else {
                                    return back()->with('message', 'Already exists! Products Name: ' . $row0);
                                }

                                //dd($productsAdd);
                        }
                    }
                }
            return back()->with('message', __(trans('global.imported')));

    }

}
