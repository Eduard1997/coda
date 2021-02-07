<?php

namespace App\Http\Controllers;

use App\Models\AdminUpdates;
use Illuminate\Http\Request;

class UpdatesController extends Controller
{
    protected Request $request;

    /**
     * UpdatesController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index() {
        $adminUpdates = AdminUpdates::get()->toArray();
        return view('dashboard.siteUpdates.index')->with(['adminUpdates' => $adminUpdates]);
    }

    public function deleteSiteUpdate($id) {
        AdminUpdates::where('id', $id)->delete();
        return redirect()->route('site.updates.index');
    }

    public function createSiteMessage() {
        return view('dashboard.siteUpdates.createSiteUpdates');
    }

    public function postCreateSiteMessage() {
        $data = $this->request->all();
        AdminUpdates::insert([
           'message' =>  $data['message']
        ]);
        return redirect()->route('site.updates.index');
    }


}
