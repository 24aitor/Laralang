<?php

namespace Aitor24\Laralang\Builder;

class MymemoryTrans extends Translation
{
    /**
      * Get translation from mymemory API.
      */
     public function main()
     {
         $host = 'api.mymemory.translated.net';

         // Check if host is online.
         if ($this->checkHost($host)) {

             // Host online
             $urlString = urlencode($this->string);
             $urldata = file_get_contents("http://$host/get?q=$urlString&langpair=$this->from|$this->to");
             $data = json_decode($urldata, true);

             if ($data['responseStatus'] != 200) {
                 if ($this->debug == true) {
                     if ($data['responseStatus'] == 403) {
                         $details = ($data['responseDetails']);
                     } else {
                         $details = $data['responseDetails'];
                     }
                     $this->translation = "<font style='color:red;'>Error ".$data->responseStatus.': '.$details.'</font>';
                 }

                 return;
             }

             // Checking if any translation provides from 24aitor to use it
             foreach ($data['matches']  as $match) {
                 if ($match['last-updated-by'] == '24aitor') {
                     $this->translation = $match['translation'];
                     $this->checkSave();

                     return;
                 }
             }

             $this->translation = $data['responseData']['translatedText'];
             $this->checkSave();

             return;
         }
     }
}
