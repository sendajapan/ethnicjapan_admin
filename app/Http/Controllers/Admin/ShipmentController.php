<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ShipmentsDataTable;
use App\Enums\ShipmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Services\ApiService;
use App\Services\PartService;
use App\Services\RZDatabaseService;
use App\Services\VehicleService;
use App\Utils\Constant;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Session;
use stdClass;
use Str;

class ShipmentController extends Controller
{
    protected ApiService $apiService;
    protected RZDatabaseService $rzDatabaseService;
    protected VehicleService $vehicleService;
    protected PartService $partService;

    public ?object $shippingData = null;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
        $this->rzDatabaseService = RZDatabaseService::getInstance();
        $this->vehicleService = new VehicleService();
        $this->partService = new PartService();
        $this->shippingData = new stdClass();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(ShipmentsDataTable $dataTable)
    {
        $totalShipment = Shipment::count();
        return $dataTable->render('admin.shipment.index', compact('totalShipment'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {

        if ($request->filled('booking-id')) {
            $this->shippingData = $this->apiService->getBookingData($request->input('booking-id'));
            session()->put(Constant::KEY_SHIPPING, $this->shippingData);

            return view('admin.shipment.create')->with('shippingData', $this->shippingData);
        }

        return view('admin.shipment.create');
    }

    public function pendingShipments(): View
    {
        $customerId = 979;
        $bookings = $this->getPendingBookings($customerId);

        $data = $this->buildShipmentData($bookings, $customerId);

        return view('admin.shipment.pending', [
            'bookings' => $bookings,
            'pending_shipment' => $data
        ]);
    }

    private function getPendingBookings(int $customerId): Collection
    {
        $query = "SELECT * FROM tbl_booking LEFT JOIN tbl_shipment ON tbl_shipment.shipment_id = tbl_booking.shipment_id WHERE tbl_booking.cust_id = ? AND (uploaded_to_rz = 0 OR uploaded_to_rz IS NULL) AND vehicle_parts_sync = 0";

        return $this->rzDatabaseService->runCustomQuery($query, [$customerId]);
    }

    private function getPendingBookingById(int $bookingId)
    {
        $query = "SELECT * FROM tbl_booking
                LEFT JOIN tbl_shipment ON tbl_shipment.shipment_id = tbl_booking.shipment_id
                WHERE tbl_booking.booking_id = ?
                AND (uploaded_to_rz = 0 OR uploaded_to_rz IS NULL)";

        return $this->rzDatabaseService->runCustomQuery($query, [$bookingId])->first();
    }

    private function getShippingPort(string $placeId): string
    {
        $query = "SELECT place_name FROM tbl_places WHERE place_id = ?";
        return $this->rzDatabaseService->runCustomQuery($query, [$placeId])->first()->place_name ?? '';
    }

    private function getVehicles(int $customerId): Collection
    {
        $query = "SELECT tbl_vehicle.*, tbl_vehicle_make.make_name, tbl_vehicle_model.model_name FROM tbl_vehicle
                LEFT JOIN tbl_vehicle_make ON tbl_vehicle_make.make_id = tbl_vehicle.make_id
                LEFT JOIN tbl_vehicle_model ON tbl_vehicle_model.model_id = tbl_vehicle.model_id
                LEFT JOIN tbl_booking ON tbl_booking.booking_id = tbl_vehicle.booking_id
                WHERE tbl_booking.cust_id = ? AND tbl_vehicle.veh_is_recycle_fee_paid = 'yes'";

        return $this->rzDatabaseService->runCustomQuery($query, [$customerId]);
    }

    private function buildShipmentData(Collection $bookings, int $customerId): array
    {
        $data = [];

        foreach ($bookings as $booking) {
            $shipment = $this->mapShipment($booking);
            $data['shipment_data'][$booking->shipment_id]['shipment'] = $shipment;

            $vehicles = $this->getVehicles($customerId);
            $data['shipment_data'][$booking->shipment_id]['vehicles'] = $this->mapVehicles($vehicles->toArray(), $booking);
            $data['message'] = count($vehicles) . " vehicles data listed";
            $data['error'] = count($vehicles) > 0 ? 0 : 1;
        }

        return $data;
    }

    private function mapShipment(object $booking): array
    {
        return [
            'departure' => $booking->vessel_departure_date,
            'provider' => 'KARMEN',
            'destination_port' => 'APIA',
            'vessel' => $booking->vessel,
            'term' => $booking->term,
            'shipping_port' => $this->getShippingPort($booking->shipping_port),
            'invoice_customer' => 'SAM-' . $booking->invoice_number,
            'branch_id' => 2,
            'received' => '0'
        ];
    }

    private function mapVehicles(array $vehicles, object $booking): array
    {
        return array_map(function ($vehicle) use ($booking) {
            $month = $vehicle->lookupitem_id_veh_manufactured_month >= 38 ? $vehicle->lookupitem_id_veh_manufactured_month - 37 : 0;
            $sale_price = $vehicle->veh_sale_price + $vehicle->profit2;

            return [
                'input_date' => date('Y-m-d'),
                'buyer1' => 'RIZWAN',
                'provider_name' => 'KARMEN',
                'origin_id' => 'karmen_' . $vehicle->vehicle_id,
                'make_id' => $vehicle->make_id,
                'make_title' => $vehicle->make_name,
                'model_id' => $vehicle->model_id,
                'model_title' => $vehicle->model_name,
                'grade' => $vehicle->lookupitem_id_grade,
                'chassis_model' => $vehicle->veh_chassis_model,
                'chassis_number' => $vehicle->veh_chassis_number,
                'veh_fuel' => $vehicle->veh_fuel,
                'veh_trans' => $vehicle->veh_t_m,
                'veh_traction' => $vehicle->veh_traction,
                'veh_km' => $vehicle->veh_km,
                'veh_cc' => $vehicle->veh_cc,
                'veh_year' => $vehicle->veh_year,
                'veh_month' => $month,
                'veh_color' => $vehicle->veh_color,
                'gross_weight' => $vehicle->veh_gross_weight,
                'net_weight' => $vehicle->veh_net_weight,
                'veh_length' => $vehicle->veh_l,
                'veh_height' => $vehicle->veh_h,
                'veh_width' => $vehicle->veh_w,
                'other_info' => $vehicle->veh_other_option,
                'engine_type' => $vehicle->veh_engine_type,
                'engine_no' => $vehicle->veh_engine_number,
                'veh_doors' => $vehicle->veh_doors ?? '',
                'purchase_price' => $sale_price,
                'veh_steering' => $vehicle->veh_drive,
                'veh_condition' => $vehicle->veh_condition,
                'shipment_id' => $booking->shipment_id,
                'veh_status' => 'ONSEA',
                'branch_id' => 2,
                'provider' => 'KARMEN',
                'vessel' => $booking->vessel,
                'invoice_number' => $booking->invoice_number
            ];
        }, $vehicles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $bookingId = $request->input('booking-id');
            $apiService = new ApiService();

            $shipmentBookingData = $apiService->getBookingData($bookingId);

            if (!empty($shipmentBookingData)) {
                $shipmentBookingData = $shipmentBookingData->shipment_data;
                $firstShipmentId = key($shipmentBookingData);

                DB::beginTransaction();

                $shipment = $shipmentBookingData->$firstShipmentId->shipment;

                $shipmentObject = new Shipment();

                $shipmentObject->departure = $shipment->departure;
                $shipmentObject->provider = $shipment->provider;
                $shipmentObject->destination_port = $shipment->destination_port;
                $shipmentObject->vessel = $shipment->vessel;
                $shipmentObject->term = $shipment->term;
                $shipmentObject->shipping_port = $shipment->shipping_port;
                $shipmentObject->invoice_customer = $shipment->invoice_customer;
                $shipmentObject->status = !empty($shipment->received) ? $shipment->received : ShipmentStatus::IN_TRANSIT->value;

                $shipmentObject->save();

                foreach ($shipmentBookingData->$firstShipmentId->vehicles as $vehicleData) {
                    $vehicle = $this->vehicleService->storeVehiclesFromShipment($shipmentObject->id, $vehicleData);
                    $this->partService->storeVehicleParts($vehicle->id);
                }

                DB::commit();

                $query = "UPDATE tbl_booking SET vehicle_parts_sync = 1 WHERE shipment_id = ?";
                $this->rzDatabaseService->runCustomQuery($query, [$bookingId]);

            } else {
                return response()->json(['error' => 'No shipment data available'], 404);
            }

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Error inserting data: ' . $e->getMessage());

        } catch (NotFoundExceptionInterface|ContainerExceptionInterface|\Throwable $e) {
            return redirect()->back()->with('error', 'Error inserting data: ' . $e->getMessage());
        }

        return redirect()->route('admin.shipment.receive.request', $shipmentObject->id)->with('success', 'Data inserted successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Shipment $shipment): View
    {
        $vehicles = $shipment->vehicles;
        return view('admin.vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function handleReceiveRequest(string $id): View
    {
        $shipment = Shipment::find($id);

        $apiUrl = "https://api.exchangeratesapi.io/v1/latest?access_key=551c88f9880952686196f8e421ebda12&base=EUR&symbols=JPY,WST";

        $jpyToWstRate = 0.0188;
        $wstToJpyRate = 53.5861;
        $today = now()->toDateString();

        if (Session::has('exchange_rate') && Session::get('exchange_rate.date') === $today) {
            $wstToJpyRate = Session::get('exchange_rate.rate');
        } else {
            try {
                $response = Http::get($apiUrl);

                if ($response->successful()) {
                    $data = $response->json();

                    $jpyRate = $data['rates']['JPY'] ?? null;
                    $wstRate = $data['rates']['WST'] ?? null;

                    if ($jpyRate && $wstRate) {
                        $jpyToWstRate = number_format($wstRate / $jpyRate, 6);
                        $wstToJpyRate = number_format($jpyRate / $wstRate, 6);

                        Session::put('exchange_rate', [
                            'rate' => $wstToJpyRate,
                            'date' => $today
                        ]);
                    }
                }
            } catch (Exception $e) {
                logger()->error('Exchange rate API error: ' . $e->getMessage());
            }
        }

        return view('admin.shipment.receive-request', compact('shipment', 'wstToJpyRate'));
    }

    public function updateReceiveRequest(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'selectStatus' => 'required|string',
            'exchange-rate' => 'required|numeric',
            'cost_*' => 'required|numeric',
        ]);

        $shipment = Shipment::findOrFail($id);

        try {
            DB::beginTransaction();

            $shipment->exchange_rate = $request->input('exchange-rate');
            $shipment->status = $request->input('selectStatus');
            $shipment->save();

            $costs = [];
            foreach ($request->all() as $key => $value) {
                if (Str::startsWith($key, 'cost_')) {
                    $costId = (int) Str::after($key, 'cost_');
                    $costs[$costId] = ['amount' => $value];
                }
            }

            $shipment->costs()->sync($costs);

            DB::commit();

            return redirect()->route('admin.shipment.index')
                ->with('success', 'Shipment updated successfully.');

        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error updating data: ' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
