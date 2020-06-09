<?php

namespace App\Repositories;

use App\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductsRepository implements ProductsInterface
{

    /**
     * Display All Products where status published
     */
    public function getAllProducts()
    {
        $products = DB::table('products as p')
            ->select('p.body', 'p.created_at', 'p.updated_at', 'p.title', 'p.status')
            ->where('status', 1)
            ->get();
        if ($products) {
            return $products;
        }
        return $products;
    }

    /**
     * show details product by id to all
     * @param  \App\Products  $id
     */
    public function getProductByID($id)
    {
        //

        $products = DB::table('products as p')
            ->select('p.body', 'p.created_at', 'p.updated_at', 'p.title', 'p.status')
            ->where('status', 1)
            ->where('id', $id)
            ->get();
        if ($products) {
            return $products;
        }
        return $products;
    }

    /**
     * Display Products Admin in session .
     */
    public function showAllProductsUser()
    {
        //
        $userAuth = Auth::user()->id;
        $data = Products::where('user', $userAuth)->get();
        return response()->json($data);
    }

    /**
     * Store a new product by Admin .
     * @param  \Illuminate\Http\Request  $request
     */
    public function storeNewProduct(Request $request)
    {
        //
        if (Auth::user()->role == 1) {
            if ($request->hasFile('photo')) {
                $files = $request->file('photo');
                $destinationPath = public_path("/image/students/");
                $imgfile = time() . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $imgfile);
            } else {
                $imgfile = null;
            }

            DB::table('Products')->insert(
                ['title' => $request->title, 'body' => $request->body, 'photo' => $imgfile, 'status' => $request->status, 'user' => Auth::user()->id]
            );

            return response()->json(['status' => 'Done']);
        } else {
            return response()->json(['status' => 'Erorr']);
        }
    }

    /**
     * update a products
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Products  $id
     */
    public function updateProduct(Request $request, $id)
    {
        //

        $findProduct = Products::find($id);
        if (Auth::user()->role == 1 && $findProduct->user == Auth::user()->id) {
            if ($request->hasFile('photo')) {
                $files = $request->file('photo');
                $destinationPath = public_path("/image/students/");
                $imgfile = time() . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $imgfile);
            } else {
                $imgfile = null;
            }

            DB::table('Products')
                ->where('id', $id)
                ->update(
                    ['title' => $request->title, 'body' => $request->body, 'photo' => $imgfile, 'status' => $request->status, 'user' => Auth::user()->id]
                );

            return response()->json(['status' => 'Done']);
        } else {
            return response()->json(['status' => 'Erorr']);
        }
    }

    /**
     * Request a product
     * @param  \Illuminate\Http\Request  $request
     */
    public function userAddRequestOfProduct(Request $request)
    {
        //
        if (Auth::user()->role == 2) {
            DB::table('Products')->insert(
                ['title' => $request->title,'user' => Auth::user()->id,'status' => '3']
            );
            return response()->json(['status' => 'Done']);
        } else {
            return response()->json(['status' => 'Erorr']);
        }
    }

    /**
     * softDelete a Product ...
     * @param  \App\Products  $id
     */
    public function softDeleteAProduct($id)
    {
        //
        if (Auth::user()->role == 1) {
            $findProduct = Products::withTrashed()->find($id);

            if ($findProduct->deleted_at == null) {
                $product = Products::find($id);
                $product->delete($id);
                return response()->json(['status' => 'Done']);
            } else {
                return response()->json(['status' => 'Erorr']);
            }
        } else {
            return response()->json(['status' => 'Erorr']);
        }

    }

    /**
     * get with Trashed Products ..
     */
    public function productsWithTrashed()
    {
        //
        if (Auth::user()->role == 1) {
            $products = Products::onlyTrashed()->get();
            return response()->json($products);
        } else {
            return response()->json(['status' => 'Erorr']);
        }
    }
    /**
     * forceDelete to Products
     * @param  \App\Products  $id
     */
    public function forceDeleteProduct($id)
    {

        if (Auth::user()->role == 1) {
            $findProduct = Products::withTrashed()->find($id);

            if ($findProduct->deleted_at == null) {
                return response()->json(['status' => 'Erorr']);
            } else {
                $product = Products::withTrashed()->find($id);
                $product->forceDelete();
                return response()->json(['status' => 'Done']);
            }
        } else {
            return response()->json(['status' => 'Erorr']);
        }

    }
    /**
     * restore to Products
     * @param  \App\Products  $id
     */
    public function restoreProduct($id)
    {
        //
        if (Auth::user()->role == 1) {
            $findProduct = Products::withTrashed()->find($id);
            if ($findProduct->deleted_at == null) {
                return response()->json(['status' => 'Erorr']);
            } else {
                Products::withTrashed()
                    ->where('id', $id)
                    ->restore();
                return response()->json(['status' => 'Done']);
            }
        } else {
            return response()->json(['status' => 'Erorr']);
        }

    }
    /**
     * get all products by clints
     */
    public function showproductbyclints()
    {
        $data = Products::where('status', 3)->get();
        return response()->json($data, Done);
    }
}
