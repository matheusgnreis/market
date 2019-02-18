<?php
namespace Market\Services;

/**
 *
 */
trait Categories
{
    public function appsCategories($dictionary)
    {
        $categories = [
            [
                'id' => 0,
                'name' => $dictionary['word_all_categories'],
                'page' => 'all',
            ],
            [
                'id' => 1,
                'name' => $dictionary['word_product_sourcing'],
                'page' => 'product-sourcing',
            ],
            [
                'id' => 2,
                'name' => $dictionary['word_marketing'],
                'page' => 'marketing',
            ],
            [
                'id' => 3,
                'name' => $dictionary['word_sales'],
                'page' => 'sales',
            ],
            [
                'id' => 4,
                'name' => $dictionary['word_social_media'],
                'page' => 'social-media',
            ],
            [
                'id' => 5,
                'name' => $dictionary['word_shipping'],
                'page' => 'shipping',
            ],
            [
                'id' => 6,
                'name' => $dictionary['word_inventory'],
                'page' => 'inventory',
            ],
            [
                'id' => 7,
                'name' => $dictionary['word_customer_service'],
                'page' => 'customer-service',
            ],
            [
                'id' => 8,
                'name' => $dictionary['word_tools'],
                'page' => 'tools',
            ],
            [
                'id' => 9,
                'name' => $dictionary['word_reporting'],
                'page' => 'reporting',
            ],
            [
                'id' => 10,
                'name' => $dictionary['word_sales_channels'],
                'page' => 'sales-channels',
            ],
        ];
        return $categories;
    }

    public function themesCategories($dictionary)
    {
        $categories = [
            [
                'id' => 0,
                'name' => $dictionary['word_art_photography'],
                'page' => 'art-photography',
            ],
            [
                'id' => 1,
                'name' => $dictionary['word_clothing_fashion'],
                'page' => 'clothing-fashion',
            ],
            [
                'id' => 2,
                'name' => $dictionary['word_jewelry_accessories'],
                'page' => 'jewelry-accessories',
            ],
            [
                'id' => 3,
                'name' => $dictionary['word_electronics'],
                'page' => 'electronics',
            ],
            [
                'id' => 3,
                'name' => $dictionary['word_food_drinks'],
                'page' => 'food-drinks',
            ],
            [
                'id' => 4,
                'name' => $dictionary['word_home_garden'],
                'page' => 'home-garden',
            ],
            [
                'id' => 5,
                'name' => $dictionary['word_furniture'],
                'page' => 'furniture',
            ],
            [
                'id' => 6,
                'name' => $dictionary['word_health_beauty'],
                'page' => 'health-beauty',
            ],
            [
                'id' => 7,
                'name' => $dictionary['word_sports_recreation'],
                'page' => 'sports-recreation',
            ],
            [
                'id' => 8,
                'name' => $dictionary['word_toys_games'],
                'page' => 'toys-games',
            ],
            [
                'id' => 9,
                'name' => $dictionary['word_games'],
                'page' => 'games',
            ],
            [
                'id' => 10,
                'name' => $dictionary['word_sexshop'],
                'page' => 'sexshop',
            ],
            [
                'id' => 11,
                'name' => $dictionary['word_petshop'],
                'page' => 'petshop',
            ],
            [
                'id' => 12,
                'name' => $dictionary['word_service'],
                'page' => 'service',
            ],
            [
                'id' => 13,
                'name' => $dictionary['word_fitness'],
                'page' => 'fitness',
            ],
            [
                'id' => 14,
                'name' => $dictionary['word_other'],
                'page' => 'other',
            ],
            [
                'id' => 15,
                'name' => $dictionary['word_all_categories'],
                'page' => 'all',
            ],
        ];
        return $categories;
    }

    public function searchCategories($dictionary)
    {
        $categories = [
            [
                'id' => 1,
                'name' => $dictionary['word_app'],
                'slug' => 'apps',
            ],
            [
                'id' => 0,
                'name' => $dictionary['word_theme'],
                'slug' => 'themes',
            ],
        ];
        return $categories;
    }

    public function resources()
    {
        return [
            "applications",
            "authentications",
            "brands",
            "carts",
            "categories",
            "collections",
            "customers",
            "grids",
            "orders",
            "procedures",
            "products",
            "stores",
            "triggers",
        ];
    }
}
