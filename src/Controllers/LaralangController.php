<?php

namespace Aitor24\Laralang\Controllers;

use Aitor24\Laralang\Models\DB_Translation;
use App\Http\Controllers\Controller;
use Crypt;
use Illuminate\Http\Request;
use Response;

class LaralangController extends Controller
{
    public function showLogin()
    {
        if (session('laralang.password') && Crypt::decrypt(session('laralang.password')) == config('laralang.default.password')) {
            return redirect(Route('laralang::translations'));
        }

        return view('laralang::login');
    }

    public function login(Request $request)
    {
        session(['laralang.password' => Crypt::encrypt($request->input('password'))]);
        if (Crypt::decrypt(session('laralang.password')) != config('laralang.default.password')) {
            return redirect(Route('laralang::login'))
            ->with('status', 'Invalid password');
        }

        return redirect(Route('laralang::translations'));
    }

    public function logout(Request $request)
    {
        $request->session()->forget('laralang.password');

        return redirect(Route('laralang::login'));
    }

    public function showTranslations()
    {
        return view('laralang::translations');
    }

    public function api()
    {
        $cod = [];
        $to_cod = DB_Translation::all();
        foreach ($to_cod as $toc) {
            if (mb_check_encoding(utf8_decode($toc['translation']), 'UTF-8')) {
                $coded = utf8_decode($toc['translation']);
            } else {
                $coded = 'Error decoding, unkown chars';
            }
            $toc['translation'] = $coded;
            array_push($cod, $toc);
        }

        return Response::json($cod);
    }

    public function deleteTranslation(Request $request)
    {
        $trans = DB_Translation::findOrFail($request->id);
        $trans->delete();
    }

    public function editTranslation(Request $request)
    {
        $trans = DB_Translation::findOrFail($request->id);
        $trans->string = $request->string;
        $trans->to_lang = $request->to;
        $trans->from_lang = $request->from;
        $trans->translation = utf8_encode($request->translation);
        $trans->touch();
        $trans->save();
    }
}
