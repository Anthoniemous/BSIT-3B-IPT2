<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class XmlStorageService
{
    protected $disk = 'local';
    protected $directory = 'xml';

    public function save($filename, $data)
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0"?><root></root>');
        $this->arrayToXml($data, $xml);
        
        $xmlContent = $xml->asXML();
        $path = $this->directory . '/' . $filename;
        
        Storage::disk($this->disk)->put($path, $xmlContent);
        return $path;
    }

    public function read($filename)
    {
        $path = $this->directory . '/' . $filename;
        
        if (!Storage::disk($this->disk)->exists($path)) {
            return null;
        }
        
        $xmlContent = Storage::disk($this->disk)->get($path);
        $xml = simplexml_load_string($xmlContent);
        return json_decode(json_encode($xml), true);
    }

    public function delete($filename)
    {
        $path = $this->directory . '/' . $filename;
        return Storage::disk($this->disk)->delete($path);
    }

    private function arrayToXml($data, &$xml)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (is_numeric($key)) {
                    $key = 'item';
                }
                $subnode = $xml->addChild($key);
                $this->arrayToXml($value, $subnode);
            } else {
                $xml->addChild($key, htmlspecialchars($value));
            }
        }
    }
}