<?php

namespace App\Listeners;

use App\Events\AssetDeleting;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;
use function PHPSTORM_META\map;

class DeleteAssetsFile implements ShouldQueue {
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct() {
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  AssetDeleting $event
	 *
	 * @return void
	 */
	public function handle($event) {
		$assets = is_a($event, AssetDeleting::class) ? $event->asset : $event->project->Asset;
		if (count($assets) === 1) {
			$this->deleteAssetFile($assets);

			return;
		}
		foreach ($assets as $asset) {
			$this->deleteAssetFile($asset);
		}
	}

	private function deleteAssetFile($asset) {
		if (Storage::exists($asset->path)) {
			Storage::delete($asset->path);
		}
	}
}
