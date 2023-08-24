<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class AudioController extends Controller
{

    public function index()
    {
        return view('record');
    }
    public function uploadAudio(Request $request)
    {
        if ($request->has('audio')) {
            $audioBlob = $request->file('audio');
            $fileName = time() . '_audio.wav';
            Storage::disk('public')->put($fileName, file_get_contents($audioBlob));

            $path = public_path('storage/' . $fileName);


            $response = Http::attach(
                'file',
                file_get_contents($path),
                $fileName
            )
                ->withHeaders([
                    'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                ])
                ->post('https://api.openai.com/v1/audio/translations', [
                    'model' => 'whisper-1',
                ]);

            if ($response->successful()) {
                $text_result = $response->json();

                if($text_result['text'] == "" || $text_result['text'] == null || $text_result['text'] == " "){
                    return response()->json($text_result['text'],422);
                }
                if ($request->chat_id == "null" || $request->chat_id == null) {
                    $chat = Chat::create([
                        'user_id' => auth()->id(),
                        'message' => $text_result['text'],
                    ]);
                } else {
                    $chat = Chat::find($request->chat_id);
                }

                // $result = $this->getAnswer($text_result['text'], $chat);
                return response()->json(["text" => $text_result['text'], "chat_id" => $chat->id]);

            } else {
                $error = $response->json();
                return response()->json($error);
            }
        }
        return response()->json('No audio file found',422);
    }

    public function getAnswer(Request $request)//$text, $chat
    {
        $text = $request->text;

        $chat = Chat::find($request->chat_id);
        if($chat == null){
            $chat = Chat::create([
                'user_id' => auth()->id(),
                'message' => $text,
            ]);
        }
        $contexts = $chat->contexts;
        $json[] = ['role' => 'system', 'content' => 'You are a helpful assistant that answers questions.'];
        foreach ($contexts as $context) {
            $json[] = [
                'role' => 'user',
                'content' => $context->user_response,
            ];
            $json[] = [
                'role' => 'system',
                'content' => $context->asisstant_response,
            ];
        }
        $json[] = [
            'role' => 'user',
            'content' => $text,
        ];
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', [
            'messages' =>
            $json,
            "model" => "gpt-3.5-turbo",
            // 'temperature' => 0.5,         // Adjust temperature for response randomness
            // 'max_tokens' => 100,           // Adjust max_tokens for response length
        ]);


        $result = $response->json();
        $chat->contexts()->create([
            'user_response' => $text,
            'asisstant_response' => $result['choices'][0]['message']['content'],
        ]);
        return response()->json(['text' => $result['choices'][0]['message']['content'],'chat_id' =>$chat->id],200);
    }
}
