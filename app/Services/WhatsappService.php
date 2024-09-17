<?php

namespace App\Services;

class WhatsappService
{
    protected $nodeScriptPath;
    protected $pythonScriptPath;

    public function __construct()
    {
        $this->nodeScriptPath = base_path('scripts/sendMessage.js'); // Path ke skrip Puppeteer
        $this->pythonScriptPath = base_path('scripts/send_message.py'); // Path ke skrip Selenium
    }

    public function sendMessage($to, $message)
    {
        // Untuk Puppeteer
        $command = "node {$this->nodeScriptPath} '{$to}' '{$message}'";
        $output = shell_exec($command);

        // Untuk Selenium (Hapus komentar pada salah satu yang Anda pilih)
        // $command = "python3 {$this->pythonScriptPath} '{$to}' '{$message}'";
        // $output = shell_exec($command);

        return $output;
    }
}
