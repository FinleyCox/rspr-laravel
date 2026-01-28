<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Info;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class PageController extends Controller
{
    public function about()
    {
        return view('about');
    }

    public function info()
    {
        $infos = Info::orderBy('created_at', 'desc')->paginate(10);
        return view('info', compact('infos'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'message' => 'required',
        ]);

        // 管理者メールアドレスへ送信 (環境変数MAIL_FROM_ADDRESSなどを利用するか、固定アドレス)
        $adminEmail = config('mail.from.address');
        
        Mail::to($adminEmail)->send(new ContactMail($validated));
        
        return back()->with('success', 'お問い合わせを送信しました。');
    }
}
