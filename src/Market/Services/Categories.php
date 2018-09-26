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
                'id' => 0 ,
               'name' => $dictionary['word_all_categories'],
               'page' => 'all'
            ],
            [
                'id' => 1 ,
               'name' => $dictionary['word_product_sourcing'],
               'page' => 'product-sourcing'
            ],
            [
                'id' => 2 ,
              'name' => $dictionary['word_marketing'],
              'page' => 'marketing'
            ],
            [
                'id' => 3 ,
              'name' => $dictionary['word_sales'],
              'page' => 'sales'
            ],
            [
                'id' => 4 ,
              'name' => $dictionary['word_social_media'],
              'page' => 'social-media'
            ],
            [
                'id' => 5 ,
              'name' => $dictionary['word_shipping'],
              'page' => 'shipping'
            ],
            [
                'id' => 6 ,
              'name' => $dictionary['word_inventory'],
              'page' => 'inventory'
            ],
            [
                'id' => 7 ,
              'name' => $dictionary['word_customer_service'],
              'page' => 'customer-service'
            ],
            [
                'id' => 8 ,
              'name' => $dictionary['word_tools'],
              'page' => 'tools'
            ],
            [
                'id' => 9 ,
              'name' => $dictionary['word_reporting'],
              'page' => 'reporting'
            ],
            [
                'id' => 10 ,
              'name' => $dictionary['word_sales_channels'],
              'page' => 'sales-channels'
            ]
        ];
        return $categories;
    }

    public function themesCategories($dictionary)
    {
        $categories = [
                [
                    'id' => 0,
                    'name' => $dictionary['word_art_photography'],
                    'page' => 'art-photography'
                ],
                [
                    'id' => 1,
                    'name' => $dictionary ['word_clothing_fashion'],
                    'page' => 'clothing-fashion'
                ],
                [
                    'id' => 2,
                    'name' => $dictionary ['word_jewelry_accessories'],
                    'page' => 'jewelry-accessories'
                ],
                [
                    'id' => 3,
                    'name' => $dictionary ['word_electronics'],
                    'page' => 'electronics'
                ],
                [
                    'id' => 3,
                    'name' => $dictionary ['word_food_drinks'],
                    'page' => 'food-drinks'
                ],
                [
                    'id' => 4,
                    'name' => $dictionary ['word_home_garden'],
                    'page' => 'home-garden'
                ],
                [
                    'id' => 5,
                    'name' => $dictionary ['word_furniture'],
                    'page' => 'furniture'
                ],
                [
                    'id' => 6,
                    'name' => $dictionary ['word_health_beauty'],
                    'page' => 'health-beauty'
                ],
                [
                    'id' => 7,
                    'name' => $dictionary ['word_sports_recreation'],
                    'page' => 'sports-recreation'
                ],
                [
                    'id' => 8,
                    'name' => $dictionary ['word_toys_games'],
                    'page' => 'toys-games'
                ],
                [
                    'id' => 9,
                    'name' => $dictionary['word_games'],
                    'page' => 'games'
                ],
                [
                    'id' => 10,
                    'name' => $dictionary['word_sexshop'],
                    'page' => 'sexshop'
                ],
                [
                    'id' => 11,
                    'name' => $dictionary['word_petshop'],
                    'page' => 'petshop'
                ],
                [
                    'id' => 12,
                    'name' => $dictionary['word_service'],
                    'page' => 'service'
                ],
                [
                    'id' => 13,
                    'name' => $dictionary['word_fitness'],
                    'page' => 'fitness'
                ],
                [
                    'id' => 14,
                    'name' => $dictionary ['word_other'],
                    'page' => 'other'
                ],
                [
                    'id' => 15,
                    'name' => $dictionary ['word_all_categories'],
                    'page' => 'all'
                ]
            ];
        return $categories;
    }

    public function searchCategories($dictionary)
    {
        $categories = [
            [
                'id' => 1 ,
                'name' => $dictionary['word_app'],
                'slug' => 'apps'
            ],
            [
                'id' => 0 ,
                'name' => $dictionary['word_theme'],
                'slug' => 'themes'
            ]
        ];
        return $categories;
    }

    public function resources()
    {
        return [
            "regate",
            "@_token",
            "@analytics",
            "@channels",
            "@domains",
            "@logs",
            "@notifications",
            "@searches",
            "@visits",
            "applications/data",
            "applications/hidden_data",
            "applications",
            "authentications/api_key",
            "authentications/panel_cards",
            "authentications/panel_form_fields",
            "authentications/permissions",
            "authentications",
            "brands/i18n",
            "brands/metafields",
            "brands/pictures",
            "brands",
            "carts/customers",
            "carts/items",
            "carts/metafields",
            "carts/orders",
            "carts",
            "categories/childs",
            "categories/grids",
            "categories/i18n",
            "categories/metafields",
            "categories/parent",
            "categories/pictures",
            "categories",
            "collections/i18n",
            "collections/metafields",
            "collections/pictures",
            "collections/products",
            "collections",
            "customers/addresses",
            "customers/favorites",
            "customers/gifts_list",
            "customers/gifts_list_info",
            "customers/hidden_metafields",
            "customers/lists",
            "customers/loyalty_points",
            "customers/metafields",
            "customers/oauth_providers",
            "customers/orders",
            "customers/seller_recommendations",
            "customers",
            "grids/i18n",
            "grids/metafields",
            "grids/options",
            "grids",
            "orders/amount",
            "orders/buyers",
            "orders/fullfilments",
            "orders/gift_to",
            "orders/hidden_metafields",
            "orders/items",
            "orders/loyalty_points",
            "orders/metafields",
            "orders/payments_history",
            "orders/shipping_lines",
            "orders/transactions",
            "orders",
            "procedures",
            "products/brands",
            "products/categories",
            "products/customizations/options",
            "products/customizations",
            "products/grids",
            "products/hidden_metafields",
            "products/i18n",
            "products/inventory_records",
            "products/kit_composition",
            "products/metafields",
            "products/other_discounts",
            "products/other_prices",
            "products/payment_methods",
            "products/pictures",
            "products/price",
            "products/price_change_records",
            "products/quantity",
            "products/related_produts",
            "products/shipping_methods",
            "products/specifications",
            "products/variations/price",
            "products/variations/quantity",
            "products/variations/specifications",
            "products/variations",
            "products",
            "stores",
            "triggers"
        ];
    }
}
