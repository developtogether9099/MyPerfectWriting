<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\EmailsData as AdminEmailsData;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

class ImportEmailsController extends Controller
{
    public function index() 
    {
        $emails = AdminEmailsData::all();
        return view('admin.importEmails.index', compact('emails'));
    }


    public function import(Request $request)
    {
        $file = $request->file('file');

        $spreadsheet = IOFactory::load($file);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        foreach ($rows as $row) {
            AdminEmailsData::create([
                'firstname' => $row[0],
                'lastname' => $row[1],
                'email' => $row[2]
            ]);
        }

        return redirect()->back()->with('success', 'Emails imported successfully.');
    }


    public function create()
    {
        //return session('emailId');
        return view('admin.importEmails.create');
    }
    public function addEmailId(Request $request)
    {   session()->forget('emailId');

        $array = explode(",", $request->ids);

        session(['emailId'=>$array]);
        return 'done';
        return view('admin.importEmails.create');
    }


    public function send()
    {
        request()->validate([
            'notification-type' => 'required|string',
            'notification-action' => 'required|string',
            'notification-subject' => 'required|string',
            'notification-message' => 'required|string',
        ]);

        $notification = [
            'type' => htmlspecialchars(request('notification-type')),
            'action' => htmlspecialchars(request('notification-action')),
            'subject' => htmlspecialchars(request('notification-subject')),
            'message' => htmlspecialchars(request('notification-message')),
        ];
            
        $users = AdminEmailsData::whereIn('id', session('emailId'))->get();

        Notification::send($users, new GeneralNotification($notification));  

        toastr()->success(__('Email has been sent successfully'));
        return redirect()->route('admin.emails');
    }
}
