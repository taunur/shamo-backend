<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class ProductCategoryController extends Controller
{
    public function all(Request $request)
    {
        $id           = $request->input('id');
        $limit        = $request->input('limit');
        $name         = $request->input('id');
        $show_product = $request->input('show_product');

        // get By Id
        if ($id) {
            $category = ProductCategory::with(['products'])->find($id);

            if ($category) {
                return ResponseFormatter::success(
                    $category,
                    'Data kategori berhasil diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data kategori tidak ada',
                    404
                );
            }
        }

        // get All
        $category = ProductCategory::query();

        // filter
        if ($name) {
            $category->where('name', 'like' . '%' . $name . '%');
        }

        if ($show_product) {
            $category->with('products');
        }

        // pagination
        return ResponseFormatter::success(
            $category->paginate($limit),
            'Data list kategori berhasil diambil'
        );
    }
}
