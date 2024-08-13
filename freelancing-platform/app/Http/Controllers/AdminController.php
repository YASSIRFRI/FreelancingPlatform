<?php


namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Offer;
use App\Models\User;
use App\Models\Withdrawal;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;


class AdminController extends Controller
{
public function dashboard()
{
    $user = auth()->user();
    $verificationRequests = VerificationRequest::with('user')->where('status', 'pending')->get();
    $todaysEarnings = Order::where('status', 'completed')->whereDate('created_at', now()->today())->sum('fee') + Offer::whereHas('order', function ($query) {
        $query->where('status', 'completed');
    })->whereDate('created_at', now()->today())->sum('fee');
    $overallEarnings = Order::where('status', 'completed')->sum('fee') + Offer::whereHas('order', function ($query) {
        $query->where('status', 'completed');
    })->sum('fee');
    $recentOrders = Order::with('seller')->latest()->take(10)->get();
    $withdrawalRequests = Withdrawal::where('state', 'pending')->get();

    // Load content from files
    $termsConditionsContent = Storage::get('terms_conditions.html');
    $contactContent = Storage::get('contact.html');
    $howItWorksContent = Storage::get('how_it_works.html');
    $users=User::All();

    return view('admin.dashboard', compact(
        'verificationRequests',
        'todaysEarnings',
        'overallEarnings',
        'recentOrders',
        'user',
        'termsConditionsContent',
        'contactContent',
        'howItWorksContent',
        'users',
        'withdrawalRequests'
    ));
}

    public function approveVerification($id)
    {
        $verificationRequest = VerificationRequest::findOrFail($id);
        $verificationRequest->status = 'approved';
        $verificationRequest->save();
        $verificationRequest->user->verified = true;
        $verificationRequest->user->save();

        return redirect()->route('admin.dashboard')->with('success', 'Verification request approved successfully.');
    }

    public function unverifyUser($id)
    {
        $user = User::findOrFail($id);
        $user->verified = false;
        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'User has been unverified.');
    }

    public function verify($id)
    {
        $verificationRequest = VerificationRequest::findOrFail($id);

        // Update the verification status to approved
        $verificationRequest->update(['status' => 'approved']);
        $verificationRequest->user->verified = true;
        $verificationRequest->user->save();

        // Optionally, you can add some notification logic or other actions

        return redirect()->route('admin.dashboard')->with('success', 'User has been verified successfully.');
    }


    public function editContent()
    {
        return view('admin.edit_content');
    }

    public function updateContent(Request $request)
    {
        $request->validate([
            'terms_conditions' => 'required|string',
            'contact' => 'required|string',
            'how_it_works' => 'required|string',
        ]);
    
        // Update the Terms and Conditions file
        Storage::disk('views')->put('terms_conditions.blade.php', $request->input('terms_conditions'));
    
        // Update the Contact file
        Storage::disk('views')->put('contact.blade.php', $request->input('contact'));
    
        // Update the How It Works file
        Storage::disk('views')->put('how_it_works.blade.php', $request->input('how_it_works'));
    
        return redirect()->route('admin.dashboard')->with('success', 'Content updated successfully.');
    }

    public function denyVerification($id)
    {
        $verificationRequest = VerificationRequest::findOrFail($id);
        $verificationRequest->status = 'rejected';
        $verificationRequest->save();

        return redirect()->route('admin.dashboard')->with('success', 'Verification request denied.');
    }


        /**
     * Approve a withdrawal request.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approveWithdrawal($id)
    {
        $withdrawal = Withdrawal::findOrFail($id);
        // Mark the withdrawal as approved and update the user's balance
        $withdrawal->update(['state' => 'completed']);
        $user = $withdrawal->user;
        $user->balance -= $withdrawal->amount;
        $user->save();
        return redirect()->route('admin.dashboard')->with('success', 'Withdrawal approved successfully.');
    }

    /**
     * Deny a withdrawal request.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function denyWithdrawal($id)
    {
        $withdrawal = Withdrawal::findOrFail($id);

        // Mark the withdrawal as denied
        $withdrawal->update(['state' => 'denied']);
        return redirect()->route('admin.dashboard')->with('success', 'Withdrawal denied.');
    }

        /**
     * Update the BUYER_FEE and SELLER_FEE in the .env file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateFees(Request $request)
    {
        $request->validate([
            'BUYER_FEE' => 'required|numeric',
            'SELLER_FEE' => 'required|numeric',
        ]);

        $this->setEnvironmentValue('BUYER_FEE', $request->BUYER_FEE);
        $this->setEnvironmentValue('SELLER_FEE', $request->SELLER_FEE);

        return redirect()->route('admin.dashboard')->with('success', 'Fees updated successfully.');
    }

    /**
     * Set or update the environment variable in the .env file.
     *
     * @param string $key
     * @param string $value
     */
    protected function setEnvironmentValue($key, $value)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        $keyValue = $key . '=' . $value;

        if (strpos($str, $key) !== false) {
            $str = preg_replace("/^$key=.*$/m", $keyValue, $str);
        } else {
            $str .= "\n" . $keyValue;
        }

        file_put_contents($envFile, $str);
        //Artisan::call('config:cache');
    }

}
