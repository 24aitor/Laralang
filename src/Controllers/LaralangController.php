<?php

namespace Aitor24\Laralang\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Aitor24\Laralang\Models\DB_Translation;

class LaralangController extends Controller
{
    public function retView()
    {
        return view('laralang::translations');
    }

    public function api()
    {
        return DB_Translation::all();
    }

    public function deleteTrans($id)
    {
        $trans = DB_Translation::findOrFail($id);
        $trans->delete();
        return;
    }
    public function editTrans($id, $translation)
    {
        $trans = DB_Translation::findOrFail($id);
        $trans->translation = $translation;
        $trans->touch();
        $trans->save();
    }
}
