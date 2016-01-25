<?php

namespace Uca\Jobs;

use Uca\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Uca\User;
use Storage;

class UpdateProfilePicture extends Job implements SelfHandling, ShouldQueue {
    use InteractsWithQueue, SerializesModels;

    protected $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function handle() {
        $gravatar = md5(strtolower(trim($this->user->email)));
        $this->user->photo = $gravatar;
        $this->user->save();
        Storage::disk('s3-aruma')->put('/aruma/profiles/' . $gravatar, file_get_contents('http://www.gravatar.com/avatar/'.$gravatar.'?d=identicon'), 'public');
        if ($this->attempts() > 1) {
            $this->release(2);
        }

    }
}

