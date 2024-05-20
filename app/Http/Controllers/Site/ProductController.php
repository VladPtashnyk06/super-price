<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Characteristic;
use App\Models\Color;
use App\Models\Material;
use App\Models\Package;
use App\Models\Price;
use App\Models\Producer;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\RecProduct;
use App\Models\Size;
use App\Models\Status;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $products = Product::all();
        $categories = Category::where('level', '1')->get();
        $queryParams = $request->only(['category_id']);
        $filteredParams = array_filter($queryParams);
        $query = Product::query();

        if (isset($filteredParams['category_id'])) {
            $query->where('category_id', $filteredParams['category_id']);
        }

        $products = $query->get();
        return view('site.catalog.first-part-catalog', compact('products', 'categories'));
    }

    /**
     * @param Category $category
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function show(Category $category)
    {
        $products = Product::where('category_id', $category->id)->get();

        if (!$products->count() > 0) {
            $categories = Category::where('parent_id', $category->id)->get();
        } else {
            $categories = [];
        }

        return view('site.product.cards-products', compact('products', 'categories'));
    }

    public function showOneProduct(Product $product)
    {
        $recProduct = RecProduct::where('product_id', $product->id)->first();
        $recProduct->update([
            'count_views' => $recProduct->count_views + 1,
        ]);
        if (!empty(session()->get('recentlyViewedProducts'))) {
            foreach (session()->get('recentlyViewedProducts') as $key => $recentlyViewedProduct) {
                foreach ($recentlyViewedProduct as $item) {
                    if ($item == $product->id) {
                        return view('site.product.card-product-one', compact('product'));
                    } else {
                        $recentlyViewedProducts = session()->get('recentlyViewedProducts');
                        $recentlyViewedProducts['product_id'][] = $product->id;
                        session()->put('recentlyViewedProducts', $recentlyViewedProducts);
                    }
                }
            }
        } else {
            $recentlyViewedProducts['product_id'][] = $product->id;
            session()->put('recentlyViewedProducts', $recentlyViewedProducts);
        }

        return view('site.product.card-product-one', compact('product'));
    }

    public function recentlyViewedProducts()
    {
        $recentlyViewedProducts = session()->get('recentlyViewedProducts');
        if (!empty($recentlyViewedProducts)) {
            foreach ($recentlyViewedProducts as $product) {
                foreach ($product as $idProduct) {
                    $viewedProducts[] = Product::find($idProduct);
                }
            }
        } else {
            $viewedProducts = [];
        }

        return view('site.product.viewed-products', compact('viewedProducts'));
    }

    public function recProducts()
    {
        $recommendProducts = RecProduct::all();
        foreach ($recommendProducts as $recommendProduct) {
            $recProducts[] = $recommendProduct;
        }
        return view('site.product.rec-products', compact('recProducts'));
    }

    public function getSizes($color_id)
    {
        $productVariants = ProductVariant::where('color_id', $color_id)->with('size')->get();
        $sizes = $productVariants->map(function($variant) {
            return [
                'size_id' => $variant->size->id,
                'size_title' => $variant->size->title,
            ];
        });
        return response()->json($sizes);
    }

    public function getProduct($productId)
    {
        $product = Product::with('productVariants.color')->findOrFail($productId);

        return response()->json(['productVariants' => $product->productVariants]);
    }
}
