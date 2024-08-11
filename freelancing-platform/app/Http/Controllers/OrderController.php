<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OrderCreatedNotification;
use App\Notifications\OrderSubmitted;
use App\Notifications\SubmissionApproved;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = Order::where('seller_id', $user->id)->latest()->paginate(10);
        return view('orders.index', compact('orders', 'user'));
    }

    public function create($serviceId)
    {
        $service = Service::findOrFail($serviceId);
        $user = Auth::user();
        return view('orders.create', compact('service', 'user'));
    }

    public function store(Request $request, $serviceId)
    {
        Log::info('Order creation request received', ['service_id' => $serviceId]);
        $service = Service::findOrFail($serviceId);
        $buyer = Auth::user();
        $seller = User::findOrFail($service->seller_id);

        $request->validate([
            'description' => 'nullable|string|max:500',
        ]);

        Log::info('Order creation request received', ['buyer_id' => $buyer->id, 'seller_id' => $seller->id, 'service_id' => $service->id]);

        $order = new Order();
        $order->buyer_id = $buyer->id;
        $order->seller_id = $seller->id;
        $order->service_id = $service->id;
        $order->amount = $service->price;
        $order->description = $request->description;
        $order->status = 'pending';
        $order->save();

        $seller->notify(new OrderCreatedNotification($order));
        Log::info('Order created successfully', ['order_id' => $order->id]);

        return redirect()->route('orders.show', $order->id)
                         ->with('success', 'Order placed successfully!');
    }

    public function show($id)
    {
        $order = Order::with(['buyer', 'seller', 'service'])->findOrFail($id);
        $user = Auth::user();
        return view('orders.show', compact('order', 'user'));
    }


    public function submitOrder($orderId)
    {
        $order = Order::findOrFail($orderId);
        $user = Auth::user();
        return view('orders.submit', compact('order', 'user'));
    }

    public function storeSubmission(Request $request, $orderId)
    {
        $request->validate([
            'attachments.*' => 'required|file',
            'description' => 'required|string|max:500',
        ]);
    
        $order = Order::findOrFail($orderId);
    
        $attachments = [];
        foreach ($request->file('attachments') as $file) {
            $path = $file->store('attachments/' . $orderId);
            $attachments[] = $path;
        }
    
        $order->update([
            'attachments' => $orderId,
            'description' => $request->description,
            'status' => 'on-hold',
        ]);
        //notify the buyer
        $order->buyer->notify(new OrderSubmitted($order));
        return redirect()->route('selling.dashboard')->with('success', 'Order submitted successfully');
    }


    public function approve($id)
    {
        $order = Order::findOrFail($id);
        if($order->status !== 'on-hold'){
            return redirect()->route('orders.index')->with('error', 'Order cannot be approved.');
        }
        $order->status = 'completed';
        $order->save();
        $order->offer->seller->balance += ($order->amount-$order->fee);
        $order->offer->seller->save();
        //notify the buyer
        $order->seller->notify(new SubmissionApproved($order));
        return redirect()->route('buying.dashboard')->with('success', 'Order approved successfully!');
    }

    public function reject($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'cancelled';
        $order->save();
        return redirect()->route('orders.index')->with('error', 'Order rejected.');
    }

    public function requestRevision($id, Request $request)
    {
        $request->validate([
            'revision_request' => 'required|string|max:500',
        ]);
        $order = Order::findOrFail($id);
        $offer=$order->offer;
        if($offer->revisions==0){
            return redirect()->route('orders.index')->with('error', 'You have no revisions left.');
        }else{
            $order->status = 'in-progress';
            $order->revision_request = $request->revision_request;
            $offer->revisions-=1;
            $offer->save();
            $order->save();
        }
        return redirect()->route('orders.index')->with('success', 'Revision requested successfully!');
    }

    public function download($id)
    {
        $order = Order::findOrFail($id);
        $attachmentDirectory = $order->attachment_directory; // Assuming you have a column for the directory name
    
        $zip = new ZipArchive;
        $zipFileName = 'attachments-' . $order->id . '.zip';
    
        if ($zip->open(public_path($zipFileName), ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE)
        {
            $files = Storage::files('public/' . $attachmentDirectory);
            
            if (empty($files)) {
                return redirect()->back()->with('error', 'No files found in the attachment directory.');
            }
    
            foreach ($files as $file)
            {
                $filePath = storage_path('app/' . $file);
                $relativePath = basename($filePath);
                $zip->addFile($filePath, $relativePath);
            }
            $zip->close();
        }
        else {
            return redirect()->back()->with('error', 'Could not create zip file.');
        }
    
        return response()->download(public_path($zipFileName))->deleteFileAfterSend(true);
    }
    
}
