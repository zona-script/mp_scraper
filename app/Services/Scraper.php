<?php
namespace App\Services;
use App\Item;
use App\Category;
use App\Feed;
use App\Marketplace;
use App\Replacer;
use Goutte;


class Scraper
{
	public function feedProcessor($mk_slug)
	{
		$mp = Marketplace::whereSlug($mk_slug)->first(); 
    	
    	$feed = Feed::where('marketplace_id', $mp->id)
    	->whereEnabled('1')
    	->whereProcessed('0');

   		if ($feed->count() != 0)

    	{
    		$selected_feed = $feed->get()->random();

    		$crawler = Goutte::request('GET', $selected_feed->url);
      		
            if ($mp->slug == "bukalapak"){

                $urls = $crawler->filter('item > guid')->each (function ($node){
    						return trim($node->text());
    					});   	

    	     	foreach ($urls as $url) {
    	     		$url = str_replace('/m.bukalapak','/www.bukalapak', $url); // special bukalapak
                    $url = trim($url);
                    $item =Item::firstOrNew(['item_url' => $url]);
                    $item->feed_id = $selected_feed->id;
                    $item->save();
    	     	}	
            } 


            if ($mp->slug == "tokopedia"){                
                $crawler = json_decode(file_get_contents($selected_feed->url));
                foreach ($crawler->data->products as $item){
                    $title = explode('?trkid=',$item->url);
                    $item = Item::firstOrNew(['item_url' => $title[0]]);
                    $item->feed_id = $selected_feed->id;
                    $item->save();
                }                    
            }
            
            if ($mp->slug == "blibli"){

                $urls = $crawler->filter('.product-list a.single-product')->each (function ($node){
                            return trim($node->attr('href'));
                        });     

                foreach ($urls as $url) {
                    $item =Item::firstOrNew(['item_url' => $url]);
                    $item->feed_id = $selected_feed->id;
                    $item->save();
                }   
            }    

            if ($mp->slug == "lazada"){      
                if ( $crawler->filter('.product_list .product-card')->count()) {
                    $urls = $crawler->filter('.product_list .product-card')->each (function ($node){
                        return $node->attr('data-original');
                    });
                } elseif ($crawler->filter('.c-product-card__description a.c-product-card__name')->count()){ 
                     $urls = $crawler->filter('.c-product-card__description a.c-product-card__name')->each (function ($node){
                        $itm = $node->attr('href');
                        $itm = explode('?ff=', $itm)[0];
                        return 'http://www.lazada.co.id'.$itm;
                    });
                }     

                foreach ($urls as $url) {
                    $item =Item::firstOrNew(['item_url' => $url]);
                    $item->feed_id = $selected_feed->id;
                    $item->save();
                }   
            }                 
 
    		Feed::whereId($selected_feed->id)->update(['processed' => 1]);
    	}
    	return $mp;
	}	















	public function selectItem($mp)
	{
	    $select = Item::whereIn('feed_id', $mp->feed->pluck('id') )
            ->whereProcessed(0)
            ->get();
            
        if ($select->count() != 0 )    
        {
        	$selected_item = $select->random();
        	return $selected_item;
        } else {
        	Feed::whereMarketplace_id($mp->id)->update(['processed' => 0]);
        	return "$mp->name Feed Reset";
        }
    	
    }

    public function getCatId($cats)
    {
    	$depth0 = null;
        foreach ($cats as $key=>$cat)
        {
            $key1 = $key+1;
            $rep = Replacer::whereDepartment($cat)->whereLevel($key)->first();
            if (count($rep) != 0)
            {
                $cat = $rep->replacer;               
            }            

            $slug = new Slug;
            $cat_slug = $slug -> createSlug($cat);

            ${'depth'.$key1} = Category::firstOrCreate([
                'name' => $cat, 
                'level' => $key, 
                'parent' => ${'depth'.$key}['id'],
                'slug' => $cat_slug ]);
            
            ${'depth'.$key1} -> save();
        }      
        return ${'depth'.$key1}->id;
    }
    	
}