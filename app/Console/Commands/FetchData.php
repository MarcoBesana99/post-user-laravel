<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch data from APIs';

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
        $res = Http::get('https://jsonplaceholder.typicode.com/users');
        $users = json_decode($res->getBody()->getContents(), true);
        foreach($users as $user) {
            $u = new User();
            $u->id = $user['id']; 
            $u->name = $user['name']; 
            $u->username = $user['username']; 
            $u->email = $user['email']; 
            $u->address = $user['address']['street'] . ', ' . $user['address']['suite'] . ', ' . $user['address']['city'] . ', ' . $user['address']['zipcode']; 
            $u->phone = $user['phone']; 
            $u->website = $user['website']; 
            $u->company = $user['company']['name']; 
            $u->save();
        }
        $res = Http::get('https://jsonplaceholder.typicode.com/posts');
        $posts = json_decode($res->getBody()->getContents(), true);
        foreach($posts as $post) {
            $p = new Post();
            $p->id = $post['id']; 
            $p->user_id = $post['userId']; 
            $p->title = $post['title']; 
            $p->body = $post['body']; 
            $p->save();
        }
    }
}
