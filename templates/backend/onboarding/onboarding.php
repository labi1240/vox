<div id="voxel-onboarding" v-cloak class="x-container ts-theme-options" data-config="<?= esc_attr( wp_json_encode( [
	'license' => \Voxel\get_license_data(),
	'tab' => $_GET['tab'] ?? 'welcome',
	'default_page_builder' => ( class_exists( '\Elementor\Plugin' ) && ! function_exists( '\vxe_async_regenerate_css' ) ) ? 'elementor' : 'voxel-elements',
] ) ) ?>">
	<div class="ts-spacer"></div>
	<div class="ts-spacer"></div>
	<div class="inner-tab x-row h-center">
		<div v-if="tab === 'welcome'" class="x-col-10">

			<div class="x-row h-center onboard-step">

				<div class="x-col-7">
					<h1>Get started with Voxel</h1>
				</div>
				<div class="x-col-7 ts-form-group">


					<div class="ts-group">

						<div class="x-row">
							<div class="x-col-12 ts-form-group">
								<label style="white-space: normal;">Minimum requirements:</label>
								<ul style="opacity: .8; list-style-type: disc; padding-left: 10px;">

									<li>PHP 7.3 or higher</li>
									<li>MySQL 8 or MariaDB 10.3 or higher</li>
									<li>64MB of memory limit</li>
								</ul>

							</div>
							<div class="ts-form-group x-col-12">
								<label style="white-space: normal;">Please ensure minimum requirements are met before proceeding. Certain Voxel features will not work with older PHP and MySQL versions</label>
							</div>
							<div class="x-col-12">
								<button @click.prevent="setTab('prepare')" class="ts-button full-width btn-shadow ts-save-settings">Start setup</button>
							</div>
						</div>
					</div>
				</div>
				<div class="x-col-7">

				</div>
				<div class="x-col-7 ts-form-group">

				</div>
				<div class="x-col-7">

				</div>
			</div>
		</div>

		<div v-if="tab === 'prepare'" class="x-col-10">

				<div class="x-row h-center onboard-step">

					<div class="ts-form-group x-col-7">
						<h1>Choose page builder</h1>

					</div>

					<div class="x-col-7">
						<div class="ts-group">
							<div class="x-row">

								<div class="ts-form-group ts-checkbox x-col-12">

									<div class="ts-radio-container one-column min-scroll">
										<label class="container-radio">
											<h4>Voxel Elements</h4>

											<input type="radio" value="voxel-elements" v-model="prepare.page_builder">
											<span class="checkmark"></span>
										</label>
										<label class="container-radio">
											<h4>Elementor</h4>

											<input type="radio" value="elementor" v-model="prepare.page_builder">
											<span class="checkmark"></span>
										</label>
									</div>
								</div>
								<div class="ts-form-group x-col-12">
										<label>Learn more about supported page builders <a href="https://docs.getvoxel.io/articles/which-page-builders-does-voxel-support/" target="_blank">
										here
									</a></label>
								</div>
								<div class="ts-form-group x-col-12">
									<div v-if="prepare.running" class="ts-button ts-faded full-width">Preparing...</div>
									<button v-else @click.prevent="prepare_install" class="ts-button full-width ts-save-settings">Continue</button>
								</div>
							</div>
						</div>
					</div>

				</div>




		</div>

		<div v-if="tab === 'license'" class="x-col-10">

			<div class="x-row h-center onboard-step">
				<div class="x-col-7 ts-form-group">
						<h1>Verify license</h1>

				</div>
				<div class="x-col-7">
					<div class="ts-group">
						<div class="x-row">
							<div class="ts-form-group x-col-12">
								<label>License key</label>
								<input v-model="license.license_key" type="password">
							</div>

							<div class="ts-form-group x-col-12">
								<label>Environment</label>
								<select v-model="license.environment">
									<option value="production">Production</option>
									<option value="staging">Staging/Development</option>
								</select>
							</div>
							<div class="ts-form-group x-col-12">
								<button @click.prevent="verify_license" class="ts-button full-width ts-save-settings" :class="{'vx-disabled':pending}">Verify</button>
							</div>
						</div>
					</div>
				</div>


			</div>



		</div>

		<div v-if="tab === 'demo-import'" class="x-col-10">
			<div class="x-row h-center onboard-step">
				<div class="x-col-7">
						<h1>Import demo</h1>

				</div>
				<div class="x-col-7">
					<div class="ts-group">
						<div class="x-row">
							<div class="ts-form-group x-col-12">
								<label>Demo</label>
								<select v-model="demo_import.demo">
									<option value="city" selected>City demo (city.getvoxel.io)</option>
									<option value="stays">Stays demo (stays.getvoxel.io)</option>
									<option value="doctors">Doctors demo (doctors.getvoxel.io)</option>
									<option value="cars">Cars demo (cars.getvoxel.io)</option>
									<option value="gaming">Gaming demo (gaming.getvoxel.io)</option>
									<option value="docs">Docs demo (docs.getvoxel.io)</option>
								</select>
							</div>
							<div v-if="demo_import.running" class="ts-form-group x-col-12">
								<div class="ts-button ts-outline full-width">{{ demo_import.message }}</div>
							</div>
							<div v-else class="ts-form-group x-col-12">
								<div class="x-row">
									<div class="x-col-12">
										<button @click.prevent="run_import" class="ts-button full-width ts-save-settings">Import demo</button>
									</div>
									<div class="x-col-12 ts-form-group">

										<a href="#" class="ts-button ts-outline full-width" @click.prevent="start_blank">Or start from a blank site</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>


			</div>




		</div>
		<div v-if="tab === 'done'" class="x-col-10">

			<div class="x-row h-center onboard-step">
				<div class="x-col-7">
						<h1>Your Voxel site is ready!</h1>

				</div>
				<div class="x-col-7">
					<div class="ts-group">
						<div class="x-row">
							<div class="ts-form-group x-col-6">
								<a href="<?= esc_url( home_url('/') ) ?>" class="ts-button  full-width">Homepage</a>
							</div>
							<div class="ts-form-group x-col-6">
								<a href="<?= esc_url( admin_url('/') ) ?>" class="ts-button ts-outline full-width">Dashboard</a>
							</div>
						</div>
					</div>
				</div>
			</div>


		</div>
	</div>
</div>
