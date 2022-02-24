<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Post;

 
class delOldPost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:deloldpost';//コマンド名

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        //最も古いものを削除
       $post=Post::oldest()->first()->delete();
       //dd($post);
    }
}
