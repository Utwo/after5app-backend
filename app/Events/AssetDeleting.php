<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class AssetDeleting
{
    use Dispatchable, SerializesModels;

	public $asset;

	/**
	 * Create a new event instance.
	 *
	 * @param Asset $asset
	 */
    public function __construct($asset)
    {
        $this->asset = $asset;
    }
}
