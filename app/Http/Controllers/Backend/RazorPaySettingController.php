<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\RazorPaySetting;
use Illuminate\Http\Request;

class RazorPaySettingController extends Controller
{
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => ['required', 'integer'],
            'country_name' => ['required', 'max:255'],
            'currency_name' => ['required', 'max:255'],
            'currency_rate' => ['required'],
            'razorpay_key' => ['required'],
            'razorpay_secret_key' => ['required'],
        ]);

        RazorPaySetting::updateOrCreate(
            ['id' => $id],
            [
                'status' => $request->status,
                'country_name' => $request->country_name,
                'currency_name' => $request->currency_name,
                'currency_rate' => $request->currency_rate,
                'razorpay_key' => $request->razorpay_key,
                'razorpay_secret_key' => $request->razorpay_secret_key,
            ]
        );

        flash()->flash('success', 'Update Successfully!', [], 'RazorPay Setting');

        return redirect()->back();
    }
}
