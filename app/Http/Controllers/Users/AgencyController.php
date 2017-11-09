<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Option;

/**
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class AgencyController extends Controller
{
    public function show()
    {
        return view('users.agency.show');
    }

    public function edit()
    {
        return view('users.agency.edit');
    }

    public function update()
    {
        Option::set('agency_name', request('name'));
        Option::set('agency_tagline', request('tagline'));
        Option::set('agency_email', request('email'));
        Option::set('agency_website', request('website'));
        Option::set('agency_address', request('address'));
        Option::set('agency_phone', request('phone'));

        flash(trans('agency.updated'), 'success');

        return redirect()->route('users.agency.show');
    }

    public function logoUpload()
    {
        $file = request()->validate([
            'logo' => 'required|max:100|file_extension:png,jpg',
        ]);

        \File::delete(public_path('assets/imgs/'.Option::get('agency_logo_path')));

        $filename = $file['logo']->getClientOriginalName();

        $file['logo']->move(public_path('assets/imgs'), $filename);

        Option::set('agency_logo_path', $filename);

        flash(trans('agency.updated'), 'success');
        return redirect()->route('users.agency.show');
    }
}
