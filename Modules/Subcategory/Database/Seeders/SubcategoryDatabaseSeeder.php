<?php

namespace Modules\Subcategory\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Entities\Category;
use Carbon\Carbon;

class SubcategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        
        $arrayCatAndSubCat = [
            'Beauty & Personal Care' => [
                'Body Care',
                'Hair Care',
                'Face Care',
                'Eyes Care',
                'Lips Care',
                'Nail Care',
                'Perfume & Cologne',
                'Other Accessories'
            ],
            'Furniture' => [
                'Office',
                'Living Room',
                'Bedroom',
                'Dining Room',
                'Patio',
                'Accent Furniture',
                'Furniture Accessories'
            ],
            'Toys & Games' => [
                'Video Games',
                'Sports & Outdoors',
                'Learning',
                'Toddler & Baby Toys',
                'Board/Card Games',
                'Stuffed Toys',
                'Bicycles & Electric Vehicles',
                'Other things ',
            ],
            'Garden & Outdoor' => [
                'Camera',
                'Mobile/Phone',
                'PC/Laptop Accessories',
                'Plants & Seeds',
                'Planters & Pots',
                'Fertilizer',
                'Tools & Accessories',
            ],
            'Vehicle' => [
                'Sedan',
                'Motorbike',
                'Hatchback',
                'SUV',
                'Truck',
                'Bus',
                'Pick Up',
                'Sports Car',
                'Wagon',
                'Other Types'
            ],
            'Fashion' => [
                "Men's Shoes",
                "Men's clothing",
                "Men's Watches & Jewelry",
                "Men's Accessories",
                "Women's Clothing",
                "Women's Shoes",
                "Women's Watches & Jewelry",
                "Women's Accessories"
            ],
            'Property' => [
                'Condo',
                'Landed House',
                'Office/Retail',
                'Land',
                'Industrial Zone'
            ],
            'Babies & Kids' => [
                'Apparel',
                'Accessories',
                'Bathing & Skin Care',
            ],
            'Food and Drinks' => [
                'Snacks',
                'Canned Food',
                'Dairy Products',
                'Cooking & Baking',
                'Dried Food',
                'Others',
            ],
            'Appliances' => [
                'Air Conditioners',
                'Fans',
                'Ovens',
                'Freezers & Refrigerators',
                'Washers & Dryers',
                'Cooktops',
                'Vacuum Cleaners',
                'Parts & Accessories',
            ],
            'Automotive Parts & Accessories' => [
                'Exhaust & Emissions',
                'Lighting',
                'Tires',
                'Oils',
                'Shocks & Suspension',
                'Batteries & Accessories',
                'Transmission',
                'Exterior Accessories',
                'infotainment',
                'Filter',
            ],
            'Books' => [
                'Fiction',
                'Nonfiction',
            ],
            'Computers' => [
                'Desktop PC',
                'Laptops',
                'Monitors',
                'Networking',
                'Drives & Storage',
                'Computer Components',
                'Computer Accessories',
                'PC Gaming',
            ],
            'Phones & Accessories' => [
                'Mobile Phones',
                'Smart Watches & Wearables',
                'Phone Accessories',
            ],
            'Electronics' => [
                'Photography & Videography',
                'Audio',
                'TVs & Entertainment',
                'Electronics Accessories',
            ],
            'Services' => [
                'Electronics Repair Service',
                'Tutoring',
                'Home Repair Services',
                'Other Services',
            ],
            'Tickets' => [
                'Event Tickets',
                'Gift Vouchers & Cards',
                'Other tickets', 
            ],
            'Others' => [
                'Everything Else'
            ]
        ];

        foreach ($arrayCatAndSubCat as $singleCat => $arrSubCat) {
            $catObject = Category::where('name', $singleCat)->first();
            if ($catObject) {
                $arrSubCatInsert = [];
                $singleArrSubCatInsert = [];
                
                foreach ($arrSubCat as $singleSubCat) {
                    $singleArrSubCatInsert['name'] = $singleSubCat;
                    $singleArrSubCatInsert['category_id'] = $catObject->id;
                    $singleArrSubCatInsert['status'] = 'publish';
                    $singleArrSubCatInsert['created_at'] = Carbon::now();
                    $singleArrSubCatInsert['updated_at'] = Carbon::now();
                    $arrSubCatInsert[] = $singleArrSubCatInsert;
                }
                \DB::table('subcategory__subcategories')->insert($arrSubCatInsert);
            }
        }
    }
}
