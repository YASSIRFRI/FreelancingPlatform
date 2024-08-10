<?php


namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OfferNotification;
use App\Notifications\OfferAccepted;
use App\Notifications\OfferRejected;
use App\Notifications\OrderCreated;
use App\Notifications\NewDeposit;
use App\Notifications\NewWithdrawal;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Support\Facades\Log;

class OfferController extends Controller
{
    public function create($sellerId)
    {
        $seller = User::findOrFail($sellerId);
        $user = auth()->user();
        return view('offers.create', compact('seller', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'seller_id' => 'required|exists:users,id',
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'deadline' => 'required|date',
            'revisions' => 'required|numeric',
        ]);

        $seller_id = $request->input('seller_id');
        $user = auth()->user();
        if ($user->balance < $request->amount) {
            return redirect()->route('offers.create', $seller_id)->with('error', 'Insufficient balance');
        }

        $offer = Offer::create([
            'buyer_id' => auth()->id(),
            'seller_id' => $seller_id,
            'description' => $request->input('description'),
            'amount' => $request->input('amount'),
            'deadline' => $request->input('deadline'),
            'status' => 'pending',
        ]);

        $seller = User::find($seller_id);
        $seller->notify(new OfferNotification($offer));
        return redirect()->route('buying.dashboard')->with('success', 'Offer created successfully');
    }

    public function buyingDashboard()
    {
        $offers = Offer::where('buyer_id', auth()->id())->get();
        $orders = Order::where('buyer_id', auth()->id())->get();
        $user = auth()->user();

        return view('dashboards.buying', compact('offers', 'orders', 'user'));
    }

    public function sellingDashboard()
    {
        $offers = Offer::where('seller_id', auth()->id())->get();
        $orders = Order::where('seller_id', auth()->id())->get();
        $user = auth()->user();

        return view('dashboards.selling', compact('offers', 'orders', 'user'));
    }

    public function approveOffer($offerId)
    {
        $offer = Offer::findOrFail($offerId);

        if ($offer->status === 'pending') {
            $offer->update(['status' => 'approved']);
            
            $order = Order::create([
                'offer_id' => $offer->id,
                'buyer_id' => $offer->buyer_id,
                'seller_id' => $offer->seller_id,
                'review_id' => null,
                'status' => 'in-progress',
                'amount' => $offer->amount,
                'deadline' => $offer->deadline,
                'description' => $offer->description,
            ]);
            $buyer = User::find($offer->buyer_id);
            $buyer->notify(new OfferAccepted($offer));
            $buyer->balance -= $offer->amount;
            $buyer->save();
            Log::info('Offer approved successfully', ['offer_id' => $offer->id, 'buyer_id' => $buyer->id]);
            $seller = User::find($offer->seller_id);
            $seller->notify(new OrderCreatedNotification($order));
            return redirect()->route('selling.dashboard')->with('success', 'Offer approved and order created successfully');
        }

        return redirect()->route('selling.dashboard')->with('error', 'Offer cannot be approved');
    }

    public function rejectOffer($offerId)
    {
        $offer = Offer::findOrFail($offerId);

        if ($offer->status === 'pending') {
            $offer->update(['status' => 'rejected']);

            $buyer = User::find($offer->buyer_id);
            $buyer->balance += $offer->amount;
            $buyer->save();

            $buyer->notify(new OfferRejected($offer));

            return redirect()->route('buying.dashboard')->with('success', 'Offer rejected successfully');
        }

        return redirect()->route('buying.dashboard')->with('error', 'Offer cannot be rejected');
    }

    public function edit(Offer $offer)
    {
        $user = auth()->user();
        return view('offers.edit', compact('offer', 'user'));
    }

    public function update(Request $request, Offer $offer)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'deadline' => 'required|date',
        ]);

        $offer->update($request->only(['description', 'amount', 'deadline']));
        $user = auth()->user();

        return redirect()->route('buying.dashboard', 'user')->with('success', 'Offer updated successfully');
    }

    public function destroy(Offer $offer)
    {
        $buyer = User::find($offer->buyer_id);
        $buyer->balance += $offer->amount;
        $offer->delete();
        $user = auth()->user();
        return redirect()->route('buying.dashboard', 'user')->with('success', 'Offer removed successfully');
    }
}
