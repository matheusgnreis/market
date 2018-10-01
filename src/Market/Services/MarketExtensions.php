<?php
namespace Market\Services;

class MarketExtensions extends \Slim\Views\TwigExtension
{
    use Dictionary;

    public function __construct()
    {
    }

    public function getName()
    {
        return 'reverse';
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('categories_name', array($this, 'categoryReverse'))
        ];
    }

    public function categoryReverse($category, $lang)
    {
        $dictionary = $this->getDictionary($lang);
        switch ($category) {
        case 'all': return $dictionary['word_all_categories'];
        case 'product-sourcing': return $dictionary['word_product_sourcing'];
        case 'marketing': return $dictionary['word_marketing'];
        case 'sales': return $dictionary['word_sales'];
        case 'social-media': return $dictionary['word_social_media'];
        case 'shipping': return $dictionary['word_shipping'];
        case 'inventory': return $dictionary['word_inventory'];
        case 'customer-service': return $dictionary['word_customer_service'];
        case 'tools': return $dictionary['word_tools'];
        case 'reporting': return $dictionary['word_reporting'];
        case 'sales-channels': return $dictionary['word_sales_channels'];
        case 'art-photography': return $dictionary['word_art_photography'];
        case 'clothing-fashion': return $dictionary['word_clothing_fashion'];
        case 'jewelry-accessories': return $dictionary['word_jewelry_accessories'];
        case 'electronics': return $dictionary['word_electronics'];
        case 'food-drinks': return $dictionary['word_food_drinks'];
        case 'home-garden': return $dictionary['word_home_garden'];
        case 'furniture': return $dictionary['word_furniture'];
        case 'health-beauty': return $dictionary['word_health_beauty'];
        case 'sports-recreation': return $dictionary['word_sports_recreation'];
        case 'toys-games': return $dictionary['word_toys_games'];
        case 'games': return $dictionary['word_games'];
        case 'sexshop': return $dictionary['word_sexshop'];
        case 'sex': return $dictionary['word_sexshop'];
        case 'petshop': return $dictionary['word_petshop'];
        case 'service': return $dictionary['word_service'];
        case 'fitness': return $dictionary['word_fitness'];
        case 'other': return $dictionary['word_other'];
        default:
            break;
        }
    }
}
