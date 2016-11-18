<?php

namespace Aitor24\Laralang\Controllers;

use Aitor24\Laralang\Models\DB_Translation;
use App\Http\Controllers\Controller;

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
    }

    public function editTrans($id, $translation)
    {
        $trans = DB_Translation::findOrFail($id);
        $trans->translation = $translation;
        $trans->touch();
        $trans->save();
    }
}
