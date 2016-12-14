<?php

namespace Aitor24\Laralang\Controllers;

use Aitor24\Laralang\Facades\Laralang;
use Aitor24\Laralang\Models\DB_Translation;
use App\Http\Controllers\Controller;
use Crypt;
use Illuminate\Http\Request;

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

    public function showTranslationsFilter()
    {
        return view('laralang::filter', ['languagesFrom' => Laralang::fromLanguages(), 'languagesTo' => Laralang::toLanguages()]);
    }

    public function translationsFilter(Request $request)
    {
        return redirect()->route('laralang::filterFromTo', [$request->from_lang, $request->to_lang]);
    }

    public function showTranslationsFiltered($from_lang, $to_lang)
    {
        return view('laralang::translations', ['from_lang' => $from_lang, 'to_lang' => $to_lang]);
    }

    public function api()
    {
        return DB_Translation::all();
    }

    public function apiTranslate(Request $request)
    {
        $translatedText = Laralang::trans($request->string)->to($request->to);

        return ['translatedText' => strval($translatedText)];
    }

    public function apiFilterFromTo($from_lang, $to_lang)
    {
        // filter wich translation showld send
        if ($to_lang == 'all' && $from_lang == 'all') {
            return DB_Translation::all();
        } elseif ($to_lang == 'all') {

            //return translation where from_lang == $from
            return DB_Translation::where([['from_lang', $from_lang]])->get();
        } elseif ($from_lang == 'all') {

            //return translation where to_lang == $to
            return DB_Translation::where([['to_lang', $to_lang]])->get();
        } else {

            //return translation where from_lang == $from and to_lang == $to
            return DB_Translation::where([['from_lang', $from_lang], ['to_lang', $to_lang]])->get();
        }
    }

    public function deleteTranslation(Request $request)
    {
        $trans = DB_Translation::findOrFail($request->id);
        $trans->delete();
    }

    public function deleteAllTranslations()
    {
        $trans = DB_Translation::all();
        foreach ($trans as $tran) {
            $tran->delete();
        }
    }

    public function editTranslation(Request $request)
    {
        $trans = DB_Translation::findOrFail($request->id);
        $trans->string = $request->string;
        $trans->to_lang = $request->to;
        $trans->from_lang = $request->from;
        $trans->translation = $request->translation;
        $trans->touch();
        $trans->save();
    }
}
