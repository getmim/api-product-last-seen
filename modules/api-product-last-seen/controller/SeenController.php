<?php
/**
 * SeenController
 * @package api-product-last-seen
 * @version 0.0.1
 */

namespace ApiProductLastSeen\Controller;

use Product\Model\Product;
use LibFormatter\Library\Formatter;
use ProductLastSeen\Library\Seen;
use ProductLastSeen\Model\ProductLastSeen as PLSeen;

class SeenController extends \Api\Controller
{
    public function indexAction(){
        if(!$this->user->isLogin())
            return $this->resp(401);

        list($page, $rpp) = $this->req->getPager(12, 24);
        $cond = [
            'user' => $this->user->id,
            'product.status' => 2
        ];
        $pls = PLSeen::get($cond, $rpp, $page, ['updated'=>false]);

        $result = [];
        if($pls){
            $pids = array_column($pls, 'product');
            $products = Product::get(['id'=>$pids]);
            if($products){
                $products = Formatter::formatMany('product', $products, ['user'], 'id');
                foreach($pls as $pl){
                    if(!isset($products[$pl->product]))
                        continue;
                    $product = $products[$pl->product];
                    $product->content = null;
                    $product->meta    = null;
                    $product->gallery = [];
                    $result[] = $product;
                }
            }
        }
        $total = PLSeen::count($cond);

        $this->resp(0, $result, null, [
            'meta' => [
                'page'  => $page,
                'rpp'   => $rpp,
                'total' => $total
            ]
        ]);
    }

    public function truncateAction(){
        if(!$this->user->isLogin())
            return $this->resp(401);

        PLSeen::remove(['user' => $this->user->id]);

        $this->resp(0, 'Success');
    }
}