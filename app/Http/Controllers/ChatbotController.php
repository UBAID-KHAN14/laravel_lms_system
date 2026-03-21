<?php

namespace App\Http\Controllers;

use App\Models\Teacher\Course\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function message(Request $request)
    {
        $userMessage = $request->message;

        // i want to get all the database tables and their columns and send it to the chatbot as context for the question
        $tables = DB::select('SHOW TABLES');
        $schema = [];
        foreach ($tables as $table) {
            $tableName = $table->{'Tables_in_' . env('DB_DATABASE')};
            $columns = DB::select("SHOW COLUMNS FROM $tableName");
            $schema[$tableName] = array_map(function ($column) {
                return $column->Field;
            }, $columns);
        }
        $prompt = "You are a helpful assistant for a Learning Management System (LMS). The user will ask questions about the LMS, and you should provide accurate and concise answers based on the following database schema:\n\n";
        foreach ($schema as $table => $columns) {
            $prompt .= "Table: $table\nColumns: " . implode(', ', $columns) . "\n\n";
        }
        $prompt .= "User's question: $userMessage\nAnswer:";



        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
            'HTTP-Referer' => url('/'),
            'X-Title' => 'LMS Chatbot'
        ])->post('https://openrouter.ai/api/v1/chat/completions', [
            "model" => "openrouter/free",
            "messages" => [
                [
                    "role" => "user",
                    "content" => $prompt
                ]
            ]
        ]);

        /** @var \Illuminate\Http\Client\Response $response */
        $data = $response->json();

        if (!isset($data['choices'])) {
            return response()->json([
                'reply' => 'API Error: ' . ($data['error']['message'] ?? 'Something went wrong')
            ]);
        }

        $reply = $data['choices'][0]['message']['content'] ?? 'No response';

        return response()->json([
            'reply' => $reply
        ]);
    }
}
