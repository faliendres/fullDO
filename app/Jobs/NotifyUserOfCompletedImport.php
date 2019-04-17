<?php

namespace App\Jobs;

use App\Notifications\ImportReadyNotification;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notifiable;
use Illuminate\Queue\SerializesModels;

class NotifyUserOfCompletedImport implements ShouldQueue
{
    use Queueable, SerializesModels, Notifiable;

    public $user;
    protected $creados;
    protected $type;
    public function __construct(User $user,array $creados,$type)
    {
        $this->user = $user;
        $this->creados=$creados;
        $this->type=$type;
    }

    public function handle()
    {
//        $this->user->notify(new ImportReadyNotification($this->creados,$this->type));
    }
}
