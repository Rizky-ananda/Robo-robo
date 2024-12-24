<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Bluerhinos\phpMQTT;
use Illuminate\Support\Facades\Storage;

class MqttSubscriber extends Command
{
    protected $signature = 'mqtt:subscribe';
    protected $description = 'Subscribe to MQTT topic and save data to CSV';

    public function handle()
    {
        $server = '192.168.94.158'; // Ganti dengan server MQTT Anda
        $port = 1883; // Port MQTT
        $username = ''; // Ganti dengan username Anda
        $password = ''; // Ganti dengan password Anda
        $client_id = 'phpMQTT-subscriber-' . uniqid(); // Pastikan ini unik

        $mqtt = new phpMQTT($server, $port, $client_id);
        if (!$mqtt->connect(true, NULL, $username, $password)) {
            exit(1);
        }

        $topics['coba'] = array('qos' => 0, 'function' => 'procMsg');
        $mqtt->subscribe($topics, 0);

        while ($mqtt->proc()) {
            // Proses MQTT
        }

        $mqtt->close();
    }

    public function procMsg($topic, $msg)
    {
        // Simpan data ke CSV
        $this->saveToCsv($msg);
        echo 'Msg Received: ' . date('r') . "\n";
        echo "Topic: {$topic}\n\n";
        echo "\t$msg\n\n";
    }

    private function saveToCsv($data)
    {
        $filePath = storage_path('app/data.csv');
        $csvData = [$data];

        // Append data to CSV file
        $file = fopen($filePath, 'a');
        fputcsv($file, $csvData);
        fclose($file);
    }
}