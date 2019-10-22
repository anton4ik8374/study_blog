<?php

namespace App\Listeners;

use App\Events\ImagMiniEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Intervention\Image\Facades\Image;

class ImagMiniListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ImagMiniEvent $event
     * @return void
     */
    public function handle(ImagMiniEvent $event)
    {

        $img = Image::make(base_path('/storage/app/public/user/' . $event->path));
        if ($img->resize(100)->save(base_path('/storage/app/public/user/mini/' . $event->path))) {

            return true;

        }
        return false;
    }
}
