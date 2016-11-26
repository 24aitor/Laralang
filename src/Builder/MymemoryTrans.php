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
             $url = "http://$host/get?q=$urlString&langpair=$this->from%7C$this->to";
             $json = file_get_contents($url);
             $data = json_decode($json);

             // Checking response status
             if ($data->responseStatus != 200) {
                 if ($this->debug == true) {
                     $details = $data->responseDetails;
                     if ($data->responseStatus == 403) {
                         $details = ($data->responseDetails);
                     }
                     $this->translation = "<font style='color:red;'>Error ".$data->responseStatus.': '.$details.'</font>';
                 }

                 return;
             }


             $transObtained = $data->responseData->translatedText;

             $this->translation = ucfirst(strtolower(trim($transObtained)));

             $this->checkSave();

             return;
         }
     }
}
