<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        
        // Homepage
        $sitemap .= '<url>';
        $sitemap .= '<loc>https://casestudio.shop/</loc>';
        $sitemap .= '<lastmod>' . date('Y-m-d') . '</lastmod>';
        $sitemap .= '<changefreq>daily</changefreq>';
        $sitemap .= '<priority>1.0</priority>';
        $sitemap .= '</url>';
        
        // Shop page
        $sitemap .= '<url>';
        $sitemap .= '<loc>https://casestudio.shop/shop</loc>';
        $sitemap .= '<lastmod>' . date('Y-m-d') . '</lastmod>';
        $sitemap .= '<changefreq>daily</changefreq>';
        $sitemap .= '<priority>0.9</priority>';
        $sitemap .= '</url>';
        
        // Contact page
        $sitemap .= '<url>';
        $sitemap .= '<loc>https://casestudio.shop/contact</loc>';
        $sitemap .= '<lastmod>' . date('Y-m-d') . '</lastmod>';
        $sitemap .= '<changefreq>monthly</changefreq>';
        $sitemap .= '<priority>0.7</priority>';
        $sitemap .= '</url>';
        
        // Categories
        $categories = Category::all();
        foreach ($categories as $category) {
            $sitemap .= '<url>';
            $sitemap .= '<loc>https://casestudio.shop/category/' . $category->slug . '</loc>';
            $sitemap .= '<lastmod>' . $category->updated_at->format('Y-m-d') . '</lastmod>';
            $sitemap .= '<changefreq>weekly</changefreq>';
            $sitemap .= '<priority>0.8</priority>';
            $sitemap .= '</url>';
            
            // Subcategories
            $subcategories = $category->subcategories;
            foreach ($subcategories as $subcategory) {
                $sitemap .= '<url>';
                $sitemap .= '<loc>https://casestudio.shop/category/' . $category->slug . '/' . $subcategory->id . '</loc>';
                $sitemap .= '<lastmod>' . $subcategory->updated_at->format('Y-m-d') . '</lastmod>';
                $sitemap .= '<changefreq>weekly</changefreq>';
                $sitemap .= '<priority>0.7</priority>';
                $sitemap .= '</url>';
            }
        }
        
        // Products
        $products = Product::where('is_active', true)->get();
        foreach ($products as $product) {
            $sitemap .= '<url>';
            $sitemap .= '<loc>https://casestudio.shop/shop/' . $product->slug . '</loc>';
            $sitemap .= '<lastmod>' . $product->updated_at->format('Y-m-d') . '</lastmod>';
            $sitemap .= '<changefreq>weekly</changefreq>';
            $sitemap .= '<priority>0.6</priority>';
            $sitemap .= '</url>';
        }
        
        $sitemap .= '</urlset>';
        
        return response($sitemap, 200, [
            'Content-Type' => 'application/xml'
        ]);
    }
}
