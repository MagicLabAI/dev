<?php

namespace MagicLensAI;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class MagicLensAIService
{
    private $baseUrl = 'https://api.thenextleg.io';
    private $version = 'v2';
    private $loadBalancer = 'loadBalancer';
    private $bearerToken = '8c086293-daf3-43d8-ae80-9e3b28831fa6';

    private function buildUrl()
    {
        $url =  $this->baseUrl . '/' . $this->version;
        return $url;
    }
    private function loadBalancerUrl()
    {
        $url =  $this->baseUrl . '/' . $this->loadBalancer;
        return $url;
    }
    private function buildHeader()
    {
        return [
            'Authorization' => 'Bearer ' . $this->bearerToken,
            'Accept' => 'application/json',
        ];
    }
    public function imagine(Request $request)
    {
        try {
            $userInput = $request->input('msg');
            $client = new Client();
            $response = $client->post($this->loadBalancerUrl($this->baseUrl, $this->loadBalancer) . '/imagine', [
                'headers' => $this->buildHeader(),
                'json' => [
                    'msg' => $userInput,
                ],
            ]);
            $data = json_decode($response->getBody(), true);
            return response()->json($data);
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            return $e->getResponse()->getBody()->getContents();
        }
    }

    public function message($messageId,$loadBalanceId)
    {
        $client = new Client();
        $response = $client->get($this->loadBalancerUrl($this->baseUrl, $this->loadBalancer) . "/message/{$messageId}", [
            'headers' => $this->buildHeader(),
            'query' => ['loadBalanceId' => $loadBalanceId],
        ]);
        $data = json_decode($response->getBody(), true);
        return response()->json($data);
    }
    
    public function button(Request $request)
    {
        try {
            $userInputButton = $request->input('button');
            $userInputButtonMessageId = $request->input('buttonMessageId');
            $loadBalanceId = $request->input('loadBalanceId');
            $client = new Client();

            $response = $client->post($this->loadBalancerUrl($this->baseUrl, $this->loadBalancer) . '/button', [
                'headers' => $this->buildHeader(),
                'json' => [
                    'button' => $userInputButton,
                    'buttonMessageId' => $userInputButtonMessageId,
                    'loadBalanceId' => $loadBalanceId
                ],
            ]);
            $data = json_decode($response->getBody(), true);
            return response()->json($data);
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            return $e->getResponse()->getBody()->getContents();
        }
    }
    public function badWords(Request $request)
    {
        try {
            $userInput = $request->input('msg');
            $client = new Client();

            $response = $client->post($this->buildUrl($this->baseUrl, $this->version) . '/is-this-naughty', [
                'headers' => $this->buildHeader(),
                'json' => [
                    'msg' => $userInput,
                    'cmd' => 'imagine',
                ],
            ]);
            $data = json_decode($response->getBody(), true);
            return response()->json($data);
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            return $e->getResponse()->getBody()->getContents();
        }
    }
}
