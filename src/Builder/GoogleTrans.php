<?php

namespace Aitor24\Laralang\Builder;

class GoogleTrans extends Translation
{
    /**
      * Get translation from Google.
      */
     public function main()
     {
         $host = 'translate.googleapis.com';

         // Check if host is online.
         if ($this->checkHost($host)) {

             // Host online
             $urlString = urlencode($this->string);
             $urldata = file_get_contents("https://translate.googleapis.com/translate_a/single?client=gtx&sl=$this->from&tl=$this->to&dt=t&q=$urlString");
             $tr = $urldata;
             $tr = substr($tr, 3, -6);
             $tr = $tr.'["';
             $tr = explode('],[', $tr);
             $trans = [];
             foreach ($tr as $tran) {
                 $transl = explode('","', $tran);
                 array_push($trans, str_replace('\"', '"', ucfirst(substr($transl[0], 1))));
             }
             $this->translation = implode(' ', $trans);
             $this->checkSave();

             return;
         }
     }
}
