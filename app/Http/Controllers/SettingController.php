<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;

class SettingController extends Controller
{
    /**
     * Settings page dikhane ke liye
     */
    public function index() 
    {
        // Pehla record uthao, agar nahi hai toh khali model bhej do
        $settings = Setting::first() ?? new Setting();
        return view('pages.settings', compact('settings'));
    }

    /**
     * General settings update karne ke liye
     */
    public function updateGeneral(Request $request) 
    {
        // 1. Validation
        $data = $request->validate([
            'pharmacy_name' => 'required|string|max:255',
            'user_name'     => 'required|string|max:255',
            'phone_number'  => 'nullable|string|max:20',
            'email'         => 'nullable|email|max:255',
            'tax_id'        => 'nullable|string|max:100',
            'address'       => 'nullable|string',
            'logo'          => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048'
        ]);

        try {
            // Maujooda settings uthao ya naya instance banao
            $settings = Setting::first() ?? new Setting();

            // 2. Logo Handling
            if ($request->hasFile('logo')) {
                // Purani image delete karein agar database mein path maujood hai
                if ($settings->logo && Storage::disk('public')->exists($settings->logo)) { 
                    Storage::disk('public')->delete($settings->logo); 
                }
                
                // Nayi image store karein
                $path = $request->file('logo')->store('uploads/branding', 'public');
                $data['logo'] = $path;
            }

            // 3. Update or Create Logic
            // Ye ensure karega ke hamesha ID: 1 wala ya pehla record hi update ho
            Setting::updateOrCreate(
                ['id' => $settings->id ?? 1], // Condition
                $data // Data to update
            );

            return back()->with('success', 'Pharmacy branding updated successfully!');

        } catch (Exception $e) {
            // Agar koi error aaye toh back bhejein error message ke saath
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}