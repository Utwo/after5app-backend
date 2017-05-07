<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class ProjectDeleting
{
    use Dispatchable, SerializesModels;

    public $project;

	/**
	 * Create a new event instance.
	 *
	 * @param $project
	 */
    public function __construct($project)
    {
        $this->project = $project;
    }
}
