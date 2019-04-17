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
    protected $class;
    protected $type;

    public function __construct(User $user, $antes, $class, $resource)
    {
        $this->user = $user;
        $this->class = $class;
        $this->creados = $antes;
        $this->type = __($resource);
    }

    public function handle()
    {
        $despues = $this->class::count();
        $this->creados = $despues-$this->creados;
        $this->user->notify(new ImportReadyNotification($this->creados, $this->type));
    }
}
