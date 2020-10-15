<?php

namespace App\Console\Commands;

use App\Models\Comment;
use App\Models\Phone;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportDump extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:dump';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Импортировать данные со старой структуры базы'; // database/seeders/dumps

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $usersData = json_decode(file_get_contents(storage_path('dumps/user.json')), true)['rows'];
        $insert = []; //users table
        foreach ($usersData as $user) {
            $insert[] = [
                'id' => $user['id'],
                'name' => $user['username'],
                'email' => $user['email'],
                'password' => $user['password_hash'],
                'created_at' => date('Y-m-d H:i:s', $user['created_at']),
                'updated_at' => date('Y-m-d H:i:s', $user['updated_at']),
            ];
        }
        DB::table('users')->insertOrIgnore($insert);

        $fraudsData = json_decode(file_get_contents(storage_path('dumps/frauds.json')), true)['rows'];
        $insert = []; //phones table
        $phonesUnique = [];
        foreach ($fraudsData as $fraud) {
            if (is_numeric($fraud['phone1']) && 10 === strlen($fraud['phone1']) && !isset($phonesUnique[$fraud['phone1']])) {
                $insert[] = [
                    'number' => $fraud['phone1'],
                    'author_id' => $fraud['user_id'],
                    'created_at' => date('Y-m-d H:i:s', $fraud['created_at']),
                    'updated_at' => date('Y-m-d H:i:s', $fraud['updated_at']),
                ];
                $phonesUnique[$fraud['phone1']] = 1;
            }

            if (is_numeric($fraud['phone2']) && 10 === strlen($fraud['phone2']) && !isset($phonesUnique[$fraud['phone2']])) {
                $insert[] = [
                    'number' => $fraud['phone2'],
                    'author_id' => $fraud['user_id'],
                    'created_at' => date('Y-m-d H:i:s', $fraud['created_at']),
                    'updated_at' => date('Y-m-d H:i:s', $fraud['updated_at']),
                ];
                $phonesUnique[$fraud['phone2']] = 1;
            }
        }
        DB::table('phones')->insertOrIgnore($insert);

        $phones = Phone::all();
        $insert = []; //comments table
        foreach ($fraudsData as $fraud) {
            if (!strlen($fraud['description'])) {
                continue;
            }
            if (is_numeric($fraud['phone1']) && 10 === strlen($fraud['phone1'])) {
                $phone = $phones->where('number', $fraud['phone1'])->first();
                if ($phone) {
                    $insert[] = [
                        'description' => $fraud['description'],
                        'status' => Comment::APPROVED_STATUS,
                        'status_int' => 1,
                        'author_id' => $fraud['user_id'],
                        'phone_id' => $phone->id,
                        'created_at' => date('Y-m-d H:i:s', $fraud['created_at']),
                        'updated_at' => date('Y-m-d H:i:s', $fraud['updated_at']),
                    ];
                }
            }
            if (is_numeric($fraud['phone2']) && 10 === strlen($fraud['phone2'])) {
                $phone = $phones->where('number', $fraud['phone2'])->first();
                if ($phone) {
                    $insert[] = [
                        'description' => $fraud['description'],
                        'status' => Comment::APPROVED_STATUS,
                        'status_int' => 1,
                        'author_id' => $fraud['user_id'],
                        'phone_id' => $phone->id,
                        'created_at' => date('Y-m-d H:i:s', $fraud['created_at']),
                        'updated_at' => date('Y-m-d H:i:s', $fraud['updated_at']),
                    ];
                }
            }
        }
        DB::table('comments')->insertOrIgnore($insert);

        $comments = Comment::all();
        $insert = []; //cards table
        foreach ($fraudsData as $fraud) {
            if (!strlen($fraud['description']) || 16 != strlen($fraud['card1'])) {
                continue;
            }
            $comment = $comments->where('description', $fraud['description'])->first();
            if ($comment) {
                $insert[] = [
                    'card_num' => $fraud['card1'],
                    'comment_id' => $comment->id,
                    'created_at' => date('Y-m-d H:i:s', $fraud['created_at']),
                    'updated_at' => date('Y-m-d H:i:s', $fraud['updated_at']),
                ];
            }
        }
        DB::table('cards')->insertOrIgnore($insert);

        return 0;
    }
}
