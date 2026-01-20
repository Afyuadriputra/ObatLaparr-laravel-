<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;



class SettingController extends Controller
{
    public function edit()
    {
        $adminPhone = Setting::getValue('admin_phone');

        return view('admin.settings.edit', compact('adminPhone'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'admin_phone' => ['required', 'regex:/^62[0-9]{9,13}$/'],
        ]);

        Setting::setValue('admin_phone', $data['admin_phone']);

        return back()->with('success', 'Nomor admin berhasil diperbarui.');
    }
}
