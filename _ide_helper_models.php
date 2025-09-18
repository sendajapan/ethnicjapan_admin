<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $account_name
 * @property string|null $account_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Accounts newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Accounts newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Accounts query()
 */
	class Accounts extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $agent_name
 * @property string|null $agent_email
 * @property string|null $agent_age
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Agent query()
 */
	class Agent extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $bank_name
 * @property string|null $bank_account_no
 * @property string|null $bank_account_title
 * @property string|null $bank_branch
 * @property string|null $bank_country
 * @property string|null $bank_currency
 * @property string|null $bank_details
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BankAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BankAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BankAccount query()
 */
	class BankAccount extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $bank_account_id
 * @property int $accounts_id
 * @property string|null $transaction_date
 * @property float|null $transaction_amount
 * @property float|null $bank_charges
 * @property float|null $final_amount
 * @property float|null $ex_rate
 * @property float|null $usd_amount
 * @property string|null $reference
 * @property string|null $type
 * @property string|null $transaction_pdf
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BankTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BankTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BankTransaction query()
 */
	class BankTransaction extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $category_name
 * @property string|null $category_description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $country_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Countries newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Countries newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Countries query()
 */
	class Countries extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $customer_name
 * @property string|null $customer_country_name
 * @property string|null $customer_office_phone
 * @property string|null $customer_primary_contact_name
 * @property string|null $customer_primary_contact_email
 * @property string|null $customer_address
 * @property string|null $customer_description
 * @property int|null $account_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer query()
 */
	class Customer extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $container_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataContainerType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataContainerType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataContainerType query()
 */
	class DataContainerType extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $incoterm
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataIncoterm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataIncoterm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataIncoterm query()
 */
	class DataIncoterm extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $package_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataPackageType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataPackageType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataPackageType query()
 */
	class DataPackageType extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $unit_type
 * @property numeric|null $unit_power
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSellingUnit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSellingUnit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataSellingUnit query()
 */
	class DataSellingUnit extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $shelflife
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataShelflife newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataShelflife newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataShelflife query()
 */
	class DataShelflife extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $item_name
 * @property string|null $item_category
 * @property int $category_id
 * @property string|null $item_description
 * @property string|null $item_origin
 * @property string|null $hts_code
 * @property string|null $item_photo
 * @property string|null $organic_certification_jas_exporter_jas
 * @property string|null $organic_certification_jas_exporter_nop
 * @property string|null $organic_certification_jas_exporter_cor
 * @property string|null $organic_certification_jas_exporter_eu
 * @property string|null $producer_organic_certification_jas
 * @property string|null $producer_organic_certification_nop
 * @property string|null $producer_organic_certification_cor
 * @property string|null $producer_organic_certification_eu
 * @property string|null $spec_sheet
 * @property string|null $halal_certification_if_needed
 * @property string|null $kosher_certification_if_needed
 * @property string|null $product_flow_chart
 * @property string|null $fair_trade
 * @property string|null $rainforest_alliance
 * @property string|null $security_plan
 * @property string|null $heavy_metals_declaration
 * @property string|null $gluten_free
 * @property string|null $nutrition_chart
 * @property string|null $non_gmo_declaration
 * @property string|null $traceability_exercise
 * @property string|null $vegan_declaration
 * @property string|null $default_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item query()
 */
	class Item extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $shipment_id
 * @property string|null $lot_number
 * @property string|null $lot_unique
 * @property string|null $item_id
 * @property string|null $item_description
 * @property string|null $package_kg
 * @property string|null $type_of_package
 * @property string|null $total_packages
 * @property string|null $unit
 * @property string|null $total_qty
 * @property string|null $price_per_unit
 * @property string|null $total_price
 * @property string|null $container_no
 * @property string|null $manufacture_date
 * @property string|null $crop_year
 * @property string|null $shelf_life
 * @property string|null $best_before
 * @property string|null $lot_comment
 * @property string|null $loading_report
 * @property string|null $loading_date
 * @property string|null $surveyor_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Item|null $item
 * @property-read \App\Models\Shipment $shipment
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lot query()
 */
	class Lot extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $sale_item_id
 * @property int|null $item_id
 * @property string|null $lot_unique
 * @property string|null $item_quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Item|null $item
 * @property-read \App\Models\SaleItem $saleItem
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LotTracking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LotTracking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LotTracking query()
 */
	class LotTracking extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $port_name
 * @property string|null $country_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ports newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ports newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ports query()
 */
	class Ports extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $provider_name
 * @property string|null $provider_country_name
 * @property string|null $provider_company_name
 * @property string|null $provider_physical_address
 * @property string|null $provider_pickup_address
 * @property string|null $provider_remit_address
 * @property string|null $provider_office_phone
 * @property string|null $provider_primary_contact_name
 * @property string|null $provider_primary_contact_email
 * @property string|null $provider_account_receivable_contact_email
 * @property string|null $provider_food_safety_contact_email
 * @property string|null $provider_food_safety_contact_phone
 * @property string|null $provider_emergency_recall_contact_phone
 * @property string|null $provider_emergency_recall_contact_email
 * @property string|null $provider_list_of_products
 * @property string|null $gfsi_processing_plant_certification_file
 * @property string|null $gfsi_processing_plant_certification_type
 * @property string|null $social_certification_smeta
 * @property string|null $fda_registration
 * @property string|null $supplier_questionary_sheet
 * @property int|null $account_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Purchase> $purchases
 * @property-read int|null $purchases_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Provider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Provider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Provider query()
 */
	class Provider extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $purchase_no
 * @property string|null $purchase_date
 * @property float|null $purchase_amount
 * @property string|null $purchase_invoice
 * @property int $provider_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Provider $provider
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PurchaseItem> $purchasedItems
 * @property-read int|null $purchased_items_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Purchase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Purchase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Purchase query()
 */
	class Purchase extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $shipment_id
 * @property string|null $cost_date
 * @property string|null $cost_name
 * @property float|null $cost_amount
 * @property string|null $description
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\Purchase|null $purchase
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseCosts newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseCosts newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseCosts query()
 */
	class PurchaseCosts extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $purchase_id
 * @property int $item_id
 * @property float|null $item_qty
 * @property string|null $item_description
 * @property string|null $item_hts_code
 * @property float|null $item_unit_price
 * @property float|null $item_line_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Item $item
 * @property-read \App\Models\Purchase $purchase
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseItem query()
 */
	class PurchaseItem extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReport query()
 */
	class PurchaseReport extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $sale_no
 * @property string|null $sale_date
 * @property float|null $net_sale
 * @property float|null $tax
 * @property float|null $total_sale
 * @property string|null $sale_invoice
 * @property int $customer_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Customer $customer
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SaleItem> $saledItems
 * @property-read int|null $saled_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SaleItem> $salesItems
 * @property-read int|null $sales_items_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sale newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sale query()
 */
	class Sale extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $sale_id
 * @property int $item_id
 * @property float|null $item_qty
 * @property string|null $item_unit
 * @property string|null $item_description
 * @property string|null $item_hts_code
 * @property float|null $item_unit_price
 * @property float|null $item_line_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Item $item
 * @property-read \App\Models\Sale $sale
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SaleItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SaleItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SaleItem query()
 */
	class SaleItem extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SaleReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SaleReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SaleReport query()
 */
	class SaleReport extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $provider_id
 * @property string|null $invoice_number
 * @property string|null $invoice_date
 * @property string|null $port_of_loading
 * @property string|null $port_of_landing
 * @property string|null $incoterm
 * @property float|null $freight
 * @property float|null $insurance
 * @property float|null $exchange_rate
 * @property float|null $duties
 * @property float|null $tax
 * @property float|null $unpack
 * @property float|null $transport
 * @property float|null $penalty
 * @property float|null $other_fee
 * @property string|null $container_type
 * @property string|null $bl_number
 * @property string|null $shipping_line
 * @property string|null $vessel
 * @property string|null $eta
 * @property string|null $etd
 * @property string|null $country_of_destination
 * @property string|null $shipment_comment
 * @property string|null $commercial_invoice
 * @property string|null $bl_telex_release
 * @property string|null $packing_list
 * @property string|null $origin_certificate
 * @property string|null $phytosanitary
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Lot> $lots
 * @property-read int|null $lots_count
 * @property-read \App\Models\Provider $provider
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PurchaseCosts> $purchase_costs
 * @property-read int|null $purchase_costs_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shipment query()
 */
	class Shipment extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stock query()
 */
	class Stock extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $username
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $image
 * @property string|null $phone
 * @property string $role
 * @property string $status
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $lot_unique
 * @property string|null $photo_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|lot_photos newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|lot_photos newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|lot_photos query()
 */
	class lot_photos extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|shipment_photos newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|shipment_photos newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|shipment_photos query()
 */
	class shipment_photos extends \Eloquent {}
}

