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

        $img = Image::make(base_path('/storage/app/public/' . $event->path . '/'. $event->name));
        $img->resize(237, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(base_path('/storage/app/public/' . $event->path .'/mini/' . $event->name));

        return true;


    }
}
