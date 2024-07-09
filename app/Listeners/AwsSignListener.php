<?php

namespace App\Listeners;

use App\Events\ImageLoaded;
use App\Services\Aws\S3;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\App;

class AwsSignListener
{
    private static bool $_disabled = false;

    /**
     * Create the event listener.
     */
    public function __construct(
        private S3 $s3,
    ) {
    }

    public static function disable(): void
    {
        self::$_disabled = true;
    }

    public static function enable(): void
    {
        self::$_disabled = false;
    }

    /**
     * Handle the event.
     */
    public function handle(ImageLoaded $event): void
    {
        if(self::$_disabled === true) {
            return;
        }

        $image = $event->getImage();

        $image->image = $this->s3->signedUrl($image->image, '20 minutes');
    }
}
