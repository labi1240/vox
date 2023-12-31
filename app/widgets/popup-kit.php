<?php

namespace Voxel\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Popup_Kit extends Base_Widget {

	public function get_name() {
		return 'ts-test-widget-1';
	}

	public function get_title() {
		return __( 'Popup Kit (VX)', 'voxel-elementor' );
	}



	public function get_categories() {
		return [ 'voxel', 'basic' ];
	}

	protected function register_controls() {
		/*
		==============
		Popup: General
		==============
		*/



		$this->apply_controls( Option_Groups\Popup_General::class );

		/*
		===================
		Popup: Head
		===================
		*/



		$this->apply_controls( Option_Groups\Popup_Head::class );

		/*
		==============
		Popup: Controller
		==============
		*/



		$this->apply_controls( Option_Groups\Popup_Controller::class );

		/*
		==============
		Popup: Label and description
		==============
		*/



		$this->apply_controls( Option_Groups\Popup_Label::class );


		/*
		===================
		Popup: Menu styling
		===================
		*/

		$this->apply_controls( Option_Groups\Popup_Menu::class );


		/*
		==============
		Popup: Empty/No results
		==============
		*/

		$this->start_controls_section(
			'ts_popup_noresults',
			[
				'label' => __( 'Popup: No results', 'voxel-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);



			$this->add_responsive_control(
				'ts_empty_notf_padding',
				[
					'label' => __( 'Padding', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'.ts-field-popup .ts-empty-user-tab' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'ts_empty_icon_size',
				[
					'label' => __( 'Icon size', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px'],
					'range' => [
						'px' => [
							'min' => 20,
							'max' => 50,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 35,
					],
					'selectors' => [
						'.ts-field-popup .ts-empty-user-tab i' => 'font-size: {{SIZE}}{{UNIT}};',
						'.ts-field-popup .ts-empty-user-tab svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					],
				]
			);


			$this->add_control(
				'ts_empty_icon_color',
				[
					'label' => __( 'Icon color', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'.ts-field-popup .ts-empty-user-tab i' => 'color: {{VALUE}}',
						'.ts-field-popup .ts-empty-user-tab svg' => 'fill: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'ts_empty_title_color',
				[
					'label' => __( 'Title color', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'.ts-field-popup .ts-empty-user-tab p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'ts_empty_title_text',
					'label' => __( 'Title typography', 'voxel-elementor' ),
					'selector' => '.ts-field-popup .ts-empty-user-tab p',
				]
			);

		$this->end_controls_section();






		/*
		===================
		Popup: Checkbox
		===================
		*/

		$this->apply_controls( Option_Groups\Popup_Checkbox::class );

		/*
		===================
		Popup: Radio
		===================
		*/

		$this->apply_controls( Option_Groups\Popup_Radio::class );


		/*
		===================
		Popup: Input styling
		===================
		*/



		$this->apply_controls( Option_Groups\Popup_Input::class );

		/*
		===================
		Popup: Popup: File gallery
		===================
		*/


		$this->start_controls_section(
			'ts_form_file',
			[
				'label' => __( 'Popup: File/Gallery', 'voxel-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);



			$this->start_controls_tabs(
				'file_field_tabs'
			);

				/* Normal tab */

				$this->start_controls_tab(
					'file_field_normal',
					[
						'label' => __( 'Normal', 'voxel-elementor' ),
					]
				);

					$this->add_responsive_control(
						'ts_file_col_no',
						[
							'label' => __( 'Number of columns', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::NUMBER,
							'min' => 1,
							'max' => 6,
							'step' => 1,
							'default' => 3,
							'selectors' => [
								'.ts-field-popup .ts-file-list' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
							],
						]
					);

					$this->add_responsive_control(
						'ts_file_col_gap',
						[
							'label' => __( 'Item gap', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px' ],
							'range' => [
								'.ts-field-popup px' => [
									'min' => 0,
									'max' => 100,
									'step' => 1,
								],
							],
							'selectors' => [
								'.ts-field-popup .ts-file-list' => 'grid-gap: {{SIZE}}{{UNIT}};',
							],
						]
					);

					$this->add_responsive_control(
						'ts_file_col_height',
						[
							'label' => __( 'Item height', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px' ],
							'range' => [
								'.ts-field-popup px' => [
									'min' => 50,
									'max' => 500,
									'step' => 1,
								],
							],
							'selectors' => [
								'.ts-field-popup .ts-file, .pick-file-input' => 'height: {{SIZE}}{{UNIT}};',
							],
						]
					);



					$this->add_control(
						'ts_file_add',
						[
							'label' => __( 'Select files', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::HEADING,
							'separator' => 'before',
						]
					);

					$this->add_control(
						'ts_file_icon_color',
						[
							'label' => __( 'Icon color', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-field-popup .pick-file-input a i'
								=> 'color: {{VALUE}}',
								'.ts-field-popup .pick-file-input a svg'
								=> 'fill: {{VALUE}}',
							],

						]
					);

					$this->add_responsive_control(
						'ts_file_icon_size',
						[
							'label' => __( 'Icon size', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px', '%' ],
							'range' => [
								'.ts-field-popup px' => [
									'min' => 0,
									'max' => 100,
									'step' => 1,
								],
								'%' => [
									'min' => 0,
									'max' => 100,
								],
							],
							'selectors' => [
								'.ts-field-popup .pick-file-input a i' => 'font-size: {{SIZE}}{{UNIT}};',
								'.ts-field-popup .pick-file-input a svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
							],
						]
					);

					$this->add_control(
						'ts_file_bg',
						[
							'label' => __( 'Background', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-field-popup .pick-file-input'
								=> 'background-color: {{VALUE}}',
							],

						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Border::get_type(),
						[
							'name' => 'ts_file_border',
							'label' => __( 'Border', 'voxel-elementor' ),
							'selector' => '.pick-file-input',
						]
					);

					$this->add_responsive_control(
						'ts_file_radius',
						[
							'label' => __( 'Border radius', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px', '%' ],
							'range' => [
								'.ts-field-popup px' => [
									'min' => 0,
									'max' => 100,
									'step' => 1,
								],
								'%' => [
									'min' => 0,
									'max' => 100,
								],
							],
							'selectors' => [
								'.ts-field-popup .pick-file-input' => 'border-radius: {{SIZE}}{{UNIT}};',
							],
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Typography::get_type(),
						[
							'name' => 'ts_file_text',
							'label' => __( 'Typography' ),
							'selector' => '.pick-file-input a',
						]
					);

					$this->add_control(
						'ts_file_text_color',
						[
							'label' => __( 'Text color', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-field-popup .pick-file-input a'
								=> 'color: {{VALUE}}',
							],

						]
					);

					$this->add_control(
						'ts_file_added',
						[
							'label' => __( 'Added file/image', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::HEADING,
							'separator' => 'before',
						]
					);

					$this->add_responsive_control(
						'ts_added_radius',
						[
							'label' => __( 'Border radius', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px', '%' ],
							'range' => [
								'.ts-field-popup px' => [
									'min' => 0,
									'max' => 100,
									'step' => 1,
								],
								'%' => [
									'min' => 0,
									'max' => 100,
								],
							],
							'selectors' => [
								'.ts-field-popup .ts-file' => 'border-radius: {{SIZE}}{{UNIT}};',
							],
						]
					);

					$this->add_control(
						'ts_added_bg',
						[
							'label' => __( 'Background', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-field-popup .ts-file'
								=> 'background-color: {{VALUE}}',
							],

						]
					);

					$this->add_control(
						'ts_added_icon_color',
						[
							'label' => __( 'Icon color', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-field-popup .ts-file-info i'
								=> 'color: {{VALUE}}',
								'.ts-field-popup .ts-file-info svg'
								=> 'fill: {{VALUE}}',
							],

						]
					);

					$this->add_responsive_control(
						'ts_added_icon_size',
						[
							'label' => __( 'Icon size', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px', '%' ],
							'range' => [
								'.ts-field-popup px' => [
									'min' => 0,
									'max' => 100,
									'step' => 1,
								],
								'%' => [
									'min' => 0,
									'max' => 100,
								],
							],
							'selectors' => [
								'.ts-field-popup .ts-file-info i' => 'font-size: {{SIZE}}{{UNIT}};',
								'.ts-file-info svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
							],
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Typography::get_type(),
						[
							'name' => 'ts_added_text',
							'label' => __( 'Typography' ),
							'selector' => '.ts-file-info code',
						]
					);

					$this->add_control(
						'ts_added_text_color',
						[
							'label' => __( 'Text color', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-field-popup .ts-file-info code'
								=> 'color: {{VALUE}}',
							],

						]
					);

					$this->add_control(
						'ts_remove_file',
						[
							'label' => __( 'Remove/Check button', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::HEADING,
							'separator' => 'before',
						]
					);

					$this->add_control(
						'ts_rmf_bg',
						[
							'label' => __( 'Background', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-field-popup .ts-remove-file'
								=> 'background-color: {{VALUE}}',
							],

						]
					);

					$this->add_control(
						'ts_rmf_bg_h',
						[
							'label' => __( 'Background (Hover)', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-field-popup .ts-remove-file:hover'
								=> 'background-color: {{VALUE}}',
							],

						]
					);

					$this->add_control(
						'ts_rmf_color',
						[
							'label' => __( 'Color', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-field-popup .ts-remove-file i'
								=> 'color: {{VALUE}}',
								'.ts-field-popup .ts-remove-file svg'
								=> 'fill: {{VALUE}}',
							],

						]
					);

					$this->add_control(
						'ts_rmf_color_h',
						[
							'label' => __( 'Color (Hover)', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-field-popup .ts-remove-file:hover i'
								=> 'color: {{VALUE}}',
								'.ts-field-popup .ts-remove-file:hover svg'
								=> 'fill: {{VALUE}}',
							],

						]
					);

					$this->add_responsive_control(
						'ts_rmf_radius',
						[
							'label' => __( 'Border radius', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px', '%' ],
							'range' => [
								'.ts-field-popup px' => [
									'min' => 0,
									'max' => 100,
									'step' => 1,
								],
								'%' => [
									'min' => 0,
									'max' => 100,
								],
							],
							'selectors' => [
								'.ts-field-popup .ts-remove-file' => 'border-radius: {{SIZE}}{{UNIT}};',
							],
						]
					);

					$this->add_responsive_control(
						'ts_rmf_size',
						[
							'label' => __( 'Size', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px' ],
							'range' => [
								'.ts-field-popup px' => [
									'min' => 0,
									'max' => 100,
									'step' => 1,
								],
							],
							'selectors' => [
								'.ts-field-popup .ts-remove-file' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
							],
						]
					);

					$this->add_responsive_control(
						'ts_rmf_icon_size',
						[
							'label' => __( 'Icon size', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px' ],
							'range' => [
								'.ts-field-popup px' => [
									'min' => 0,
									'max' => 100,
									'step' => 1,
								],
							],
							'selectors' => [
								'.ts-field-popup .ts-remove-file i' => 'font-size: {{SIZE}}{{UNIT}};',
								'.ts-field-popup .ts-remove-file svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
							],
						]
					);





				$this->end_controls_tab();


				/* Hover tab */

				$this->start_controls_tab(
					'ts_file_hover',
					[
						'label' => __( 'Hover', 'voxel-elementor' ),
					]
				);

					$this->add_control(
						'ts_file_add_h',
						[
							'label' => __( 'Select files', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::HEADING,
							'separator' => 'before',
						]
					);

					$this->add_control(
						'ts_file_icon_color_h',
						[
							'label' => __( 'Button icon color', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-field-popup .pick-file-input a:hover i'
								=> 'color: {{VALUE}}',
								'.ts-field-popup .pick-file-input a:hover svg'
								=> 'fill: {{VALUE}}',
							],

						]
					);

					$this->add_control(
						'ts_file_bg_h',
						[
							'label' => __( 'Button background', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-field-popup .pick-file-input:hover'
								=> 'background-color: {{VALUE}}',
							],

						]
					);

					$this->add_control(
						'ts_file_border_h',
						[
							'label' => __( 'Border color', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-field-popup .pick-file-input:hover'
								=> 'border-color: {{VALUE}}',
							],

						]
					);

					$this->add_control(
						'ts_file_color_h',
						[
							'label' => __( 'Text color', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-field-popup .pick-file-input a:hover'
								=> 'color: {{VALUE}}',
							],

						]
					);


				$this->end_controls_tab();

			$this->end_controls_tabs();



		$this->end_controls_section();



		$this->start_controls_section(
			'ts_sf_popup_number',
			[
				'label' => __( 'Popup: Number', 'voxel-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


				$this->add_control(
					'ts_popup_number',
					[
						'label' => __( 'Number popup', 'voxel-elementor' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);


				$this->add_control(
					'popup_number_input_size',
					[
						'label' => __( 'Input value size', 'voxel-elementor' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'size_units' => [ 'px'],
						'range' => [
							'px' => [
								'min' => 13,
								'max' => 30,
								'step' => 1,
							],
						],
						'default' => [
							'unit' => 'px',
							'size' => 20,
						],
						'selectors' => [
							'.ts-field-popup .ts-stepper-input input' => 'font-size: {{SIZE}}{{UNIT}};',
						],
					]
				);


		$this->end_controls_section();

		$this->start_controls_section(
			'ts_sf_popup_range',
			[
				'label' => __( 'Popup: Range slider', 'voxel-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'ts_popup_range',
				[
					'label' => __( 'Range slider', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'ts_popup_range_size',
				[
					'label' => __( 'Range value size', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px'],
					'range' => [
						'px' => [
							'min' => 13,
							'max' => 30,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 20,
					],
					'selectors' => [
						'.ts-field-popup .range-slider-wrapper .range-value' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'ts_popup_range_val',
				[
					'label' => __( 'Range value color', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'.ts-field-popup .range-slider-wrapper .range-value'
						=> 'color: {{VALUE}}',
					],

				]
			);

			$this->add_control(
				'ts_popup_range_bg',
				[
					'label' => __( 'Range background', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'.ts-field-popup .noUi-target'
						=> 'background-color: {{VALUE}}',
					],

				]
			);

			$this->add_control(
				'ts_popup_range_bg_selected',
				[
					'label' => __( 'Selected range background', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'.ts-field-popup .noUi-connect'
						=> 'background-color: {{VALUE}}',
					],

				]
			);

			$this->add_control(
				'ts_popup_range_handle',
				[
					'label' => __( 'Handle background color', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'.ts-field-popup .noUi-handle' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'ts_popup_range_handle_border',
					'label' => __( 'Handle border', 'voxel-elementor' ),
					'selector' => '.ts-field-popup .noUi-handle',
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'ts_sf_popup_switch',
			[
				'label' => __( 'Popup: Switch', 'voxel-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

				$this->add_control(
					'ts_popup_switch',
					[
						'label' => __( 'Switch slider', 'voxel-elementor' ),
						'type' => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);

				$this->add_control(
					'ts_popup_switch_bg',
					[
						'label' => __( 'Switch slider background (Inactive)', 'voxel-elementor' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'.ts-field-popup .onoffswitch .onoffswitch-label'
							=> 'background-color: {{VALUE}}',
						],

					]
				);

				$this->add_control(
					'ts_popup_switch_bg_active',
					[
						'label' => __( 'Switch slider background (Active)', 'voxel-elementor' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'.ts-field-popup .onoffswitch .onoffswitch-checkbox:checked + .onoffswitch-label'
							=> 'background-color: {{VALUE}}',
						],

					]
				);

				$this->add_control(
					'ts_field_switch_bg_handle',
					[
						'label' => __( 'Handle background', 'voxel-elementor' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'.ts-field-popup .onoffswitch .onoffswitch-label:before'
							=> 'background-color: {{VALUE}}',
						],

					]
				);



		$this->end_controls_section();





		/*
		===================
		Popup: Icon button
		===================
		*/

		$this->apply_controls( Option_Groups\Popup_Icon_Button::class );

		/*
		===================
		Popup: Calendar
		===================
		*/

		/*
		===================
		Popup: Tertiary button
		===================
		*/


		$this->start_controls_section(
			'ts_scndry_btn_popup',
			[
				'label' => __( 'Popup: Tertiary button', 'voxel-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->start_controls_tabs(
				'scndry_btn_tabsn_popup'
			);

				/* Normal tab */

				$this->start_controls_tab(
					'scndry_btn_normaln_popup',
					[
						'label' => __( 'Normal', 'voxel-elementor' ),
					]
				);

					$this->add_control(
						'scndry_btn_icon_colorn_popup',
						[
							'label' => __( 'Button icon color', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-field-popup .ts-btn-4 i'
								=> 'color: {{VALUE}}',
								'.ts-field-popup .ts-btn-4 svg'
								=> 'fill: {{VALUE}}',
							],

						]
					);

					$this->add_responsive_control(
						'scndry_btn_height_popup',
						[
							'label' => __( 'Height', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px' ],
							'range' => [
								'px' => [
									'min' => 0,
									'max' => 100,
									'step' => 1,
								],
							],
							'selectors' => [
								'.ts-field-popup .ts-btn-4' => 'height: {{SIZE}}{{UNIT}};',
							],
						]
					);

					$this->add_responsive_control(
						'scndry_btn_icon_sizen_popup',
						[
							'label' => __( 'Button icon size', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px', '%' ],
							'range' => [
								'px' => [
									'min' => 0,
									'max' => 100,
									'step' => 1,
								],
								'%' => [
									'min' => 0,
									'max' => 100,
								],
							],
							'selectors' => [
								'.ts-field-popup .ts-btn-4 i' => 'font-size: {{SIZE}}{{UNIT}};',
								'.ts-field-popup .ts-btn-4 svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
							],
						]
					);

					$this->add_control(
						'scndry_btn_bgn_popup',
						[
							'label' => __( 'Button background', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-field-popup .ts-btn-4'
								=> 'background-color: {{VALUE}}',
							],

						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Border::get_type(),
						[
							'name' => 'scndry_btn_bordern_popup',
							'label' => __( 'Button border', 'voxel-elementor' ),
							'selector' => '.ts-field-popup .ts-btn-4',
						]
					);

					$this->add_responsive_control(
						'scndry_btn_radiusn_popup',
						[
							'label' => __( 'Button border radius', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px', '%' ],
							'range' => [
								'px' => [
									'min' => 0,
									'max' => 100,
									'step' => 1,
								],
								'%' => [
									'min' => 0,
									'max' => 100,
								],
							],
							'selectors' => [
								'.ts-field-popup .ts-btn-4' => 'border-radius: {{SIZE}}{{UNIT}};',
							],
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Typography::get_type(),
						[
							'name' => 'scndry_btn_textn_popup',
							'label' => __( 'Typography' ),
							'selector' => '.ts-field-popup .ts-btn-4',
						]
					);

					$this->add_control(
						'scndry_btn_text_colorn_popup',
						[
							'label' => __( 'Text color', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-field-popup .ts-btn-4'
								=> 'color: {{VALUE}}',
							],

						]
					);


				$this->end_controls_tab();


				/* Hover tab */

				$this->start_controls_tab(
					'scndry_btn_hovern_popup',
					[
						'label' => __( 'Hover', 'voxel-elementor' ),
					]
				);

					$this->add_control(
						'scndry_btn_icon_color_h_popup',
						[
							'label' => __( 'Button icon color', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-field-popup .ts-btn-4:hover i'
								=> 'color: {{VALUE}}',
							],

						]
					);

					$this->add_control(
						'scndry_btn_bg_hn_popup',
						[
							'label' => __( 'Button background', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-field-popup .ts-btn-4:hover'
								=> 'background-color: {{VALUE}}',
							],

						]
					);

					$this->add_control(
						'scndry_btn_border_h_popup',
						[
							'label' => __( 'Border color', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-field-popup .ts-btn-4:hover'
								=> 'border-color: {{VALUE}}',
							],

						]
					);

					$this->add_control(
						'scndry_btn_text_color_h_popup',
						[
							'label' => __( 'Text color', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-field-popup .ts-btn-4:hover'
								=> 'color: {{VALUE}}',
							],

						]
					);


				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();

		/*
		===================
		Popup: Notification button
		===================
		*/


		$this->start_controls_section(
			'ts_notification_btn_popup',
			[
				'label' => __( 'Popup: Notifications button', 'voxel-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->start_controls_tabs(
				'notification_btn_tabsn_popup'
			);

				/* Normal tab */

				$this->start_controls_tab(
					'notification_btn_normaln_popup',
					[
						'label' => __( 'Normal', 'voxel-elementor' ),
					]
				);


					$this->add_responsive_control(
						'notification_btn_height_popup',
						[
							'label' => __( 'Height', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px' ],
							'range' => [
								'px' => [
									'min' => 0,
									'max' => 100,
									'step' => 1,
								],
							],
							'selectors' => [
								'.ts-notification-actions .ts-btn-1' => 'height: {{SIZE}}{{UNIT}};',
							],
						]
					);


					$this->add_control(
						'notification_btn_bgn_popup',
						[
							'label' => __( 'Button background', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-notification-actions .ts-btn-1'
								=> 'background-color: {{VALUE}}',
							],

						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Border::get_type(),
						[
							'name' => 'notification_btn_bordern_popup',
							'label' => __( 'Button border', 'voxel-elementor' ),
							'selector' => '.ts-notification-actions .ts-btn-1',
						]
					);

					$this->add_responsive_control(
						'notification_btn_radiusn_popup',
						[
							'label' => __( 'Button border radius', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px', '%' ],
							'range' => [
								'px' => [
									'min' => 0,
									'max' => 100,
									'step' => 1,
								],
								'%' => [
									'min' => 0,
									'max' => 100,
								],
							],
							'selectors' => [
								'.ts-notification-actions .ts-btn-1' => 'border-radius: {{SIZE}}{{UNIT}};',
							],
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Typography::get_type(),
						[
							'name' => 'notification_btn_textn_popup',
							'label' => __( 'Typography' ),
							'selector' => '.ts-notification-actions .ts-btn-1',
						]
					);

					$this->add_control(
						'notification_btn_text_colorn_popup',
						[
							'label' => __( 'Text color', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-notification-actions .ts-btn-1'
								=> 'color: {{VALUE}}',
							],

						]
					);


				$this->end_controls_tab();


				/* Hover tab */

				$this->start_controls_tab(
					'notification_btn_hovern_popup',
					[
						'label' => __( 'Hover', 'voxel-elementor' ),
					]
				);


					$this->add_control(
						'notification_btn_bg_hn_popup',
						[
							'label' => __( 'Button background', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-notification-actions .ts-btn-1:hover'
								=> 'background-color: {{VALUE}}',
							],

						]
					);

					$this->add_control(
						'notification_btn_border_h_popup',
						[
							'label' => __( 'Border color', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-notification-actions .ts-btn-1:hover'
								=> 'border-color: {{VALUE}}',
							],

						]
					);

					$this->add_control(
						'notification_btn_text_color_h_popup',
						[
							'label' => __( 'Text color', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-notification-actions .ts-btn-1:hover'
								=> 'color: {{VALUE}}',
							],

						]
					);


				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();

		/*
		==============
		Popup: Calendar
		==============
		*/

		$this->apply_controls( Option_Groups\Popup_Calendar::class );

		/*
		==============
		Popup: Notifications
		==============
		*/



		$this->apply_controls( Option_Groups\Popup_Notifications::class );

		/*
		==============
		Popup: Conversation
		==============
		*/



		// $this->apply_controls( Option_Groups\Popup_Conversation::class );

		/*
		==============
		Popup: Textarea
		==============
		*/

		$this->start_controls_section(
			'ts_popup_textarea',
			[
				'label' => __( 'Popup: Textarea', 'voxel-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->start_controls_tabs(
				'ts_popup_textarea_tabs'
			);

				/* Normal tab */

				$this->start_controls_tab(
					'ts_textarea_normal',
					[
						'label' => __( 'Normal', 'voxel-elementor' ),
					]
				);

					$this->add_control(
						'ts_popup_x_heading',
						[
							'label' => __( 'Textarea', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::HEADING,
							'separator' => 'before',
						]
					);

					$this->add_control(
						'ts_sf_popup_textarea_height',
						[
							'label' => __( 'Textarea height', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::SLIDER,
							'size_units' => [ 'px', '%' ],
							'range' => [
								'px' => [
									'min' => 0,
									'max' => 100,
									'step' => 1,
								],
								'%' => [
									'min' => 0,
									'max' => 100,
								],
							],
							'selectors' => [
								'.ts-field-popup textarea' => 'height: {{SIZE}}{{UNIT}};',
							],
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Typography::get_type(),
						[
							'name' => 'popup_textarea_font',
							'label' => __( 'Typography' ),
							'selector' => '.ts-field-popup textarea',
						]
					);


					$this->add_control(
						'popup_textarea_bg',
						[
							'label' => __( 'Background color', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-field-popup textarea' => 'background: {{VALUE}}',
							],

						]
					);

					$this->add_control(
						'popup_textarea_bg_filled',
						[
							'label' => __( 'Background color (Focus)', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-field-popup textarea:focus' => 'background-color: {{VALUE}}',
							],

						]
					);

					$this->add_control(
						'popup_textarea_value_col',
						[
							'label' => __( 'Text color', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-field-popup textarea' => 'color: {{VALUE}}',
							],

						]
					);

					$this->add_control(
						'ts_textarea_plc_color',
						[
							'label' => __( 'Placeholder color', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-field-popup textarea::-webkit-input-placeholder' => 'color: {{VALUE}}',
								'.ts-field-popup textarea:-moz-placeholder' => 'color: {{VALUE}}',
								'.ts-field-popup textarea::-moz-placeholder' => 'color: {{VALUE}}',
								'.ts-field-popup textarea:-ms-input-placeholder' => 'color: {{VALUE}}',
							],

						]
					);

					$this->add_control(
						'ts_textarea_padding',
						[
							'label' => __( 'Textarea padding', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', '%', 'em' ],
							'selectors' => [
								'.ts-field-popup textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
						]
					);


					$this->add_group_control(
						\Elementor\Group_Control_Border::get_type(),
						[
							'name' => 'ts_popup_textarea_border',
							'label' => __( 'Border', 'voxel-elementor' ),
							'selector' => '.ts-field-popup textarea',
						]
					);


				$this->end_controls_tab();


				/* Hover tab */

				$this->start_controls_tab(
					'ts_textarea_hover',
					[
						'label' => __( 'Hover', 'voxel-elementor' ),
					]
				);


					$this->add_control(
						'ts_popup_textarea_h',
						[
							'label' => __( 'Textarea', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::HEADING,
							'separator' => 'before',
						]
					);

					$this->add_control(
						'ts_sf_popup_textarea_bg_h',
						[
							'label' => __( 'Background color', 'voxel-elementor' ),
							'type' => \Elementor\Controls_Manager::COLOR,
							'selectors' => [
								'.ts-field-popup textarea:hover' => 'background: {{VALUE}}',
							],

						]
					);


				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();

		/*
		==============
		Popup: Rating
		==============
		*/

		$this->start_controls_section(
			'nr1',
			[
				'label' => __( 'Popup: Numeric rating', 'voxel-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);






			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'nr1_typography',
					'label' => __( 'Typography', 'voxel-elementor' ),
					'selector' => '.rs-num li',
				]
			);

			$this->add_control(
				'nr1_text_color',
				[
					'label' => __( 'Text color', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'.rs-num li, .rs-num li span' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'nr1_typography_s',
					'label' => __( 'Typography (Selected)', 'voxel-elementor' ),
					'selector' => '.rs-num li.active',
				]
			);



			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'nr1rev_border',
					'label' => __( 'Border', 'voxel-elementor' ),
					'selector' => '.rs-num li',
				]
			);



			$this->add_control(
				'nr1rev_bg_col',
				[
					'label' => __( 'Background color', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'.rs-num li'
						=> 'background-color: {{VALUE}};',
					],

				]
			);

			$this->add_control(
				'nr1rev_bg_col_sel',
				[
					'label' => __( 'Background color (Selected)', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'.rs-num li.active'
						=> 'background-color: {{VALUE}};',
					],

				]
			);



			$this->add_responsive_control(
				'nr1ts_rating_radius',
				[
					'label' => __( 'Border radius', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'.ts-field-popup px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						],
					],
					'selectors' => [
						'.rs-num' => '--side-radius: {{SIZE}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'nr2',
			[
				'label' => __( 'Popup: Star rating', 'voxel-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);




			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'nr2typo',
					'label' => __( 'Typography' ),
					'selector' => '.review-categories label span',
				]
			);


			$this->add_responsive_control(
				'nr2_col',
				[
					'label' => __( 'Color', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'.review-categories label span' => 'color: {{VALUE}}',
					],

				]
			);


			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'nr2rev_border',
					'label' => __( 'Border', 'voxel-elementor' ),
					'selector' => '.rs-stars li',
				]
			);



			$this->add_control(
				'nr2rev_bg_col',
				[
					'label' => __( 'Background color', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'.rs-stars li'
						=> 'background-color: {{VALUE}};',
					],

				]
			);


			$this->add_responsive_control(
				'nr2ts_rating_radius',
				[
					'label' => __( 'Border radius', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'.ts-field-popup px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						],
					],
					'selectors' => [
						'.rs-stars li' => '--side-radius: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'nr2_icon_size',
				[
					'label' => __( 'Icon size', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px'],
					'range' => [
						'px' => [
							'min' => 10,
							'max' => 50,
							'step' => 1,
						],
					],
					'selectors' => [
						'.rs-stars li .ts-star-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
						'.rs-stars li .ts-star-icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'nr2_icon_color',
				[
					'label' => __( 'Icon color (Inactive)', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'.rs-stars li:not(.active) .ts-star-icon i' => 'color: {{VALUE}};',
						'.rs-stars li:not(.active) .ts-star-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'nr2auto',
				[
					'label' => __( 'Minimal style?', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'return_value' => 'auto',
					'selectors' => [
						'.rs-stars li' => 'border: none; padding: 0; width: auto; height: auto',
					],
				]
			);

			$this->add_responsive_control(
				'nr2_justify',
				[
					'label' => __( 'Justify', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'flex-start',
					'condition' => [ 'nr2auto' => 'auto' ],
					'options' => [
						'flex-start'  => __( 'Left', 'voxel-elementor' ),
						'center' => __( 'Center', 'voxel-elementor' ),
						'right' => __( 'Right', 'voxel-elementor' ),
						'space-between' => __( 'Space between', 'voxel-elementor' ),
						'space-around' => __( 'Space around', 'voxel-elementor' ),
					],

					'selectors' => [
						'.rs-stars' => 'justify-content: {{VALUE}}',
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'alertstyle',
			[
				'label' => __( 'Alert', 'voxel-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'alert_shadow',
					'label' => __( 'Box Shadow', 'voxel-elementor' ),
					'selector' => '.ts-notice',
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'pg_alert_border',
					'label' => __( 'Border', 'voxel-elementor' ),
					'selector' => '.ts-notice',
				]
			);

			$this->add_responsive_control(
				'alert_radius',
				[
					'label' => __( 'Border radius', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						],
					],
					'selectors' => [
						'.ts-notice' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'alertbg',
				[
					'label' => __( 'Background color', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'.ts-notice' => 'background-color: {{VALUE}}',
					],

				]
			);

			$this->add_control(
				'alertdiv',
				[
					'label' => __( 'Divider color', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'.a-btn' => ' --alert-divider: {{VALUE}}',
					],

				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'alt_text',
					'label' => __( 'Typography' ),
					'selector' => '.ts-notice .alert-msg',
				]
			);

			$this->add_control(
				'alert_text_color',
				[
					'label' => __( 'Text color', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'.ts-notice .alert-msg' => 'color: {{VALUE}}',
					],

				]
			);

			$this->add_control(
				'alert_info_color',
				[
					'label' => __( 'Info icon color', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'.ts-notice' => '--al-info: {{VALUE}}',
					],

				]
			);

			$this->add_control(
				'alert_warning_color',
				[
					'label' => __( 'Error icon color', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'.ts-notice' => '--al-error: {{VALUE}}',
					],

				]
			);

			$this->add_control(
				'alert_success_color',
				[
					'label' => __( 'Success icon color', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'.ts-notice' => '--al-success: {{VALUE}}',
					],

				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'al_link_text',
					'label' => __( 'Link Typography' ),
					'selector' => '.a-btn a',
				]
			);

			$this->add_control(
				'alert_link_color',
				[
					'label' => __( 'Link color', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'.a-btn a' => 'color: {{VALUE}}',
					],

				]
			);

			$this->add_control(
				'alert_link_color_h',
				[
					'label' => __( 'Link color (Hover)', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'.a-btn a:hover' => 'color: {{VALUE}}',
					],

				]
			);

			$this->add_control(
				'alert_link_bgcolor',
				[
					'label' => __( 'Link background (Hover)', 'voxel-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'.a-btn a:hover' => 'background-color: {{VALUE}}',
					],

				]
			);

		$this->end_controls_section();


	}

	protected function render( $instance = [] ) {
		require locate_template( 'templates/widgets/popup-kit.php' );
	}

	public function get_style_depends() {
		return [ 'vx:forms.css', 'vx:popup-kit.css' ];
	}

	protected function content_template() {}
	public function render_plain_content( $instance = [] ) {}

	protected function register_runtime_controls() {

	}
}
