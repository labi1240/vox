<?php

namespace Voxel\Post_Types\Fields;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Ui_Html_Field extends Base_Post_Field {
	use Traits\Ui_Field;

	protected $props = [
		'type' => 'ui-html',
		'label' => 'UI HTML',
		'content' => '',
	];

	public function get_models(): array {
		return [
			'label' => $this->get_model( 'label', [ 'classes' => 'x-col-6' ]),
			'key' => $this->get_model( 'key', [ 'classes' => 'x-col-6' ]),
			'content' => [
				'type' => \Voxel\Form_Models\Textarea_Model::class,
				'label' => 'Content',
				'classes' => 'x-col-12',
				'style' => 'min-height: 300px',
			],
		];
	}

	protected function frontend_props() {
		return [
			'content' => $this->props['content'],
		];
	}
}
