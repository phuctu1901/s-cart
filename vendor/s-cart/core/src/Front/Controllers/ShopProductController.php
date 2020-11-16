<?php
namespace SCart\Core\Front\Controllers;

use App\Http\Controllers\RootFrontController;
use SCart\Core\Front\Models\ShopProduct;

class ShopProductController extends RootFrontController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * All products
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    public function allProducts()
    {
        $sortBy = 'sort';
        $sortOrder = 'asc';
        $filter_sort = request('filter_sort') ?? '';
        $filterArr = [
            'price_desc' => ['price', 'desc'],
            'price_asc' => ['price', 'asc'],
            'sort_desc' => ['sort', 'desc'],
            'sort_asc' => ['sort', 'asc'],
            'id_desc' => ['id', 'desc'],
            'id_asc' => ['id', 'asc'],
        ];
        if (array_key_exists($filter_sort, $filterArr)) {
            $sortBy = $filterArr[$filter_sort][0];
            $sortOrder = $filterArr[$filter_sort][1];
        }

        $products = (new ShopProduct)
            ->setLimit(sc_config('product_list'))
            ->setPaginate()
            ->setSort([$sortBy, $sortOrder])
            ->getData();

        sc_check_view($this->templatePath . '.screen.shop_product_list');
        return view(
            $this->templatePath . '.screen.shop_product_list',
            array(
                'title' => trans('front.all_product'),
                'keyword' => '',
                'description' => '',
                'products' => $products,
                'layout_page' => 'product_list',
                'filter_sort' => $filter_sort,
        ));
    }

    /**
     * Get product detail
     *
     * @param   [string]  $alias      [$alias description]
     * @param   [string]  $storeCode  [$storeCode description]
     *
     * @return  [type]              [return description]
     */
    public function productDetail($alias, $storeId)
    {
        $product = (new ShopProduct)->getDetail($alias, $type = 'alias', $storeId);
        if ($product && $product->status && (!sc_config('product_stock', $storeId) || sc_config('product_display_out_of_stock', $storeId) || $product->stock > 0)) {
            //Update last view
            $product->view += 1;
            $product->date_lastview = date('Y-m-d H:i:s');
            $product->save();
            //End last viewed

            //Product last view
                $arrlastView = empty(\Cookie::get('productsLastView')) ? array() : json_decode(\Cookie::get('productsLastView'), true);
                $arrlastView[$product->id] = date('Y-m-d H:i:s');
                arsort($arrlastView);
                \Cookie::queue('productsLastView', json_encode($arrlastView), (86400 * 30));
            //End product last view

            $categories = $product->categories->keyBy('id')->toArray();
            $arrCategoriId = array_keys($categories);

            $productRelation = (new ShopProduct)
                ->getProductToCategory($arrCategoriId)
                ->setLimit(sc_config('product_relation', $storeId))
                ->setRandom()
                ->getData();
            sc_check_view($this->templatePath . '.screen.shop_product_detail');
            return view($this->templatePath . '.screen.shop_product_detail',
                array(
                    'title' => $product->name,
                    'description' => $product->description,
                    'keyword' => $product->keyword,
                    'thumb' => $product->image,
                    'product' => $product,
                    'productRelation' => $productRelation,
                    'goToStore' => $product->goToStore(),
                    'og_image' => asset($product->getImage()),
                    'layout_page' => 'product_detail',
                )
            );
        } else {
            return $this->itemNotFound();
        }
    }
}
