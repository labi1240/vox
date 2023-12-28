<!-- The markup on this page is entirely static for preview purposes -->
<div class="popup-kit-holder">
   <style type="text/css">
      .popup-kit-holder {
      padding: 30px;
      width: 450px;
      margin: auto;
      display: flex;
      flex-direction: column;
      }
      @media (max-width:768px) {
      .popup-kit-holder, .popup-kit-holder1 {
      display: none;
      }
      }
   </style>
   <details>
     <summary>What's the purpose of this widget?</summary>
     <br>
     <p>This widget is used to apply global styles to Voxel popups. <br><br> It should be added in <code>WP-admin > Theme builder > General > Style kits > Popup styles.</code><br><br> This is a static representation of each popup component. Click on the widget and browse styling options in the widget area. <br><br>Once saving changes, your settings are applied to all popups sitewide.</p>
   </details>
   <br>
   <!--
      <div class="ts-pop-kit" style="padding: 25px; margin: 20px;

          border-radius: 10px;"><h3 style="margin-top: 0;">Popup Style kit</h3><ul><li>The purpose of this widget is to style all the popups on the site collectively.</li><li>This widget is intended to be used on <b>WP-admin > Templates > Style Kits > Popup styles template.</b></li><li>You can click on this widget to view all popup styling options on the elementor widget area.</li><li>Once you are done adjusting the styling, just save the changes and all popups on the site will be affected</li><li>If you want to see changes right away, just drag and drop any elementor widget that includes popups to this template, then remove it when you are finished editing.</li><li>This template does not appear anywhere, so don't worry about this text.</li><li>The CSS generated from this template is output on site footer.</li></ul></div> -->
   <div class="ts-form elementor-element elementor-element-14b73b99">
      <div class="ts-field-popup-container">
         <div class="ts-field-popup triggers-blur">
            <div class="ts-popup-head flexify ts-sticky-top">
               <div class="ts-popup-name flexify">
                  <?= \Voxel\get_svg( 'notification.svg' ) ?>
                  <span>Popup head</span>
               </div>
               <ul class="flexify simplify-ul">
                  <li class="flexify">
                     <a href="#" class="ts-icon-btn">
                        <?= \Voxel\get_svg( 'trash-can.svg' ) ?>
                     </a>
                  </li>
               </ul>
            </div>
            <div class="ts-popup-content-wrapper min-scroll">
               <div class="ts-form-group" style="padding-bottom: 0;">
                  <label>Label <small>Some description</small>
                  </label>
               </div>
            </div>
            <div class="ts-popup-controller">
               <ul class="flexify simplify-ul">
                  <li class="flexify">
                     <a href="#" class="ts-btn ts-btn-1">Clear</a>
                  </li>
                  <li class="flexify">
                     <a href="#" class="ts-btn ts-btn-2">Save</a>
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </div>



   <div class="ts-form elementor-element elementor-element-14b73b99">
      <div class="ts-field-popup-container">
         <div class="ts-field-popup triggers-blur">
            <div class="ts-popup-content-wrapper min-scroll">
               <div class="ts-form-group">
                  <label>Switcher </label>
                  <div class="switch-slider">
                     <div class="onoffswitch">
                        <input type="checkbox" class="onoffswitch-checkbox" tabindex="0">
                        <label class="onoffswitch-label"></label>
                     </div>
                  </div>
               </div>
               <div class="ts-form-group">

                  <div class="switch-slider">
                     <div class="onoffswitch">
                        <input type="checkbox" checked="checked" class="onoffswitch-checkbox" tabindex="0">
                        <label class="onoffswitch-label"></label>
                     </div>
                  </div>
               </div>
               <div class="ts-form-group">
                  <label>
                     Stepper
                     <!--v-if-->
                  </label>
                  <div class="ts-stepper-input flexify">
                     <button class="ts-stepper-left ts-icon-btn">
                         <?= \Voxel\get_svg( 'minus.svg' ) ?>
                     </button>
                     <input type="number" class="ts-input-box" min="0" max="1000" step="1" placeholder="0">
                     <button class="ts-stepper-right ts-icon-btn">
                        <?= \Voxel\get_svg( 'plus.svg' ) ?>
                     </button>
                  </div>
               </div>
               <div class="ts-form-group">
                  <label>
                     Range
                     <!--v-if-->
                  </label>
                  <div class="range-slider-wrapper">
                     <div class="range-value">276 — 774</div>
                     <div class="range-slider noUi-target noUi-ltr noUi-horizontal noUi-txt-dir-ltr">
                        <div class="noUi-base">
                           <div class="noUi-connects">
                              <div class="noUi-connect" style="transform: translate(27.6%, 0px) scale(0.498, 1);"></div>
                           </div>
                           <div class="noUi-origin" style="transform: translate(-724%, 0px); z-index: 5;">
                              <div class="noUi-handle noUi-handle-lower" data-handle="0" tabindex="0" role="slider" aria-orientation="horizontal" aria-valuemin="0.0" aria-valuemax="774.0" aria-valuenow="276.0" aria-valuetext="276.00">
                                 <div class="noUi-touch-area"></div>
                              </div>
                           </div>
                           <div class="noUi-origin" style="transform: translate(-226%, 0px); z-index: 4;">
                              <div class="noUi-handle noUi-handle-upper" data-handle="1" tabindex="0" role="slider" aria-orientation="horizontal" aria-valuemin="276.0" aria-valuemax="1000.0" aria-valuenow="774.0" aria-valuetext="774.00">
                                 <div class="noUi-touch-area"></div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="ts-form elementor-element elementor-element-14b73b99">
      <div class="ts-field-popup-container">
         <div class="ts-field-popup triggers-blur">
            <div class="ts-popup-head flexify ts-sticky-top">
               <div class="ts-popup-name flexify">
                  <?= \Voxel\get_svg( 'notification.svg' ) ?>
                  <span>No results</span>
               </div>
            </div>
            <div class="ts-popup-content-wrapper min-scroll">
               <div class="ts-empty-user-tab">
                   <?= \Voxel\get_svg( 'notification.svg' ) ?>
                  <p>No notifications received.</p>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="ts-form elementor-element elementor-element-14b73b99">
      <div class="ts-field-popup triggers-blur">
         <div class="ts-popup-content-wrapper min-scroll" style="max-height: none;">
            <div class="ts-popup-head flexify ts-sticky-top">
               <div class="ts-popup-name flexify">
                   <?= \Voxel\get_svg( 'notification.svg' ) ?>
                  <span>Notifications</span>
               </div>

            </div>
            <ul class="ts-notification-list simplify-ul">
               <li class="ts-unread-notification ts-new-notification">
                  <a href="#">
                     <div class="notification-image">
	                       <?= \Voxel\get_svg( 'notification.svg' ) ?>
                     </div>
                     <div class="notification-details">
                        <b>Unseen and unvisited notification</b>
                        <span>9 hours ago</span>
                     </div>
                  </a>
               </li>
               <li class="ts-unread-notification">
                  <a href="#">
                     <div class="notification-image">
                         <?= \Voxel\get_svg( 'notification.svg' ) ?>
                     </div>
                     <div class="notification-details">
                        <b>Unvisited notification</b>
                        <span>9 hours ago</span>
                     </div>
                  </a>
               </li>
               <li class="">
                  <a href="#">
                     <div class="notification-image">
                         <?= \Voxel\get_svg( 'notification.svg' ) ?>
                     </div>
                     <div class="notification-details">
                        <b>Seen and visited notification</b>
                        <span>9 hours ago</span>
                     </div>
                  </a>
               </li>
               <li class="ts-unread-notification ts-new-notification">
                  <a href="#">
                     <div class="notification-image">
                        <img src="
                           <?php echo get_template_directory_uri(); ?>/assets/images/bg.jpg">
                     </div>
                     <div class="notification-details">
                        <b>Unseen and unvisited with image</b>
                        <span>9 hours ago</span>
                     </div>
                  </a>
               </li>
               <li class="ts-unread-notification">
                  <a href="#">
                     <div class="notification-image">
                        <img src="
                           <?php echo get_template_directory_uri(); ?>/assets/images/bg.jpg">
                     </div>
                     <div class="notification-details">
                        <b>Unvisited with image</b>
                        <span>15 hours ago</span>
                     </div>
                  </a>
               </li>
               <li class="">
                  <a href="#">
                     <div class="notification-image">
                        <img src="
                           <?php echo get_template_directory_uri(); ?>/assets/images/bg.jpg">
                     </div>
                     <div class="notification-details">
                        <b>Seen and visited with image</b>
                        <span>15 hours ago</span>
                     </div>
                  </a>
               </li>
               <li><a href="http://three-stays.test/hello-world/"><div class="notification-image"><img width="150" height="150" src="<?php echo get_template_directory_uri(); ?>/assets/images/bg.jpg" class="ts-status-avatar" alt="" decoding="async" loading="lazy"></div><div class="notification-details"><b>Notification prompt with actions</b><!----></div></a><div class="ts-notification-actions"><a href="#" class="ts-btn ts-btn-1">Approve</a><a href="#" class="ts-btn ts-btn-1">Decline</a></div></li>
            </ul>
            <div class="ts-form-group">
               <div class="n-load-more">
                  <a href="#" class="ts-btn ts-btn-4">
                      <?= \Voxel\get_svg( 'reload.svg' ) ?>
                     Load more
                  </a>
               </div>
            </div>
         </div>
         <!---->
      </div>
   </div>

   <div class="ts-form elementor-element elementor-element-14b73b99">
      <div class="ts-field-popup-container">
         <div class="ts-field-popup triggers-blur">
            <div class="ts-popup-content-wrapper min-scroll">
               <div class="ts-sticky-top uib b-bottom">
                  <div class="ts-input-icon flexify">
                      <?= \Voxel\get_svg( 'search.svg' ) ?>
                     <input type="text" placeholder="Search" class="autofocus" maxlength="100">
                  </div>
               </div>
               <!--v-if-->
               <div class="ts-term-dropdown ts-multilevel-dropdown ts-md-group">
                  <ul class="simplify-ul ts-term-dropdown-list">
                     <li class="ts-selected">
                        <a href="#" class="flexify">
                           <div class="ts-checkbox-container">
                              <label class="container-checkbox">
                              <input type="checkbox" disabled="" hidden="" value="attractions" checked="checked">
                              <span class="checkmark"></span>
                              </label>
                           </div>
                           <span>Attractions</span>
                           <div class="ts-term-icon">
                               <?= \Voxel\get_svg( 'file.svg' ) ?>
                           </div>
                        </a>
                     </li>
                     <li class="">
                        <a href="#" class="flexify">
                           <div class="ts-checkbox-container">
                              <label class="container-checkbox">
                              <input type="checkbox" disabled="" hidden="" value="bars">
                              <span class="checkmark"></span>
                              </label>
                           </div>
                           <span>Bars</span>
                           <div class="ts-right-icon"></div>
                           <div class="ts-term-icon">
                               <?= \Voxel\get_svg( 'file.svg' ) ?>
                           </div>
                        </a>
                     </li>
                     <li class="">
                        <a href="#" class="flexify">
                           <div class="ts-checkbox-container">
                              <label class="container-checkbox">
                              <input type="checkbox" disabled="" hidden="" value="cinema">
                              <span class="checkmark"></span>
                              </label>
                           </div>
                           <span>Cinema</span>
                           <div class="ts-term-icon">
                               <?= \Voxel\get_svg( 'file.svg' ) ?>
                           </div>
                        </a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="ts-form elementor-element elementor-element-14b73b99">
      <div class="ts-field-popup-container">
         <div class="ts-field-popup triggers-blur">
            <div class="ts-term-dropdown ts-multilevel-dropdown ts-md-group">
               <!--v-if-->
               <ul class="simplify-ul ts-term-dropdown-list">
                  <li class="ts-term-centered">
                  	<a href="#" class="flexify">
                  	   <div class="ts-left-icon"></div>
                  	  	<span>Go back</span>
                  	</a>
                  </li>
                  <li class="ts-parent-item">
                     <a href="#" class="flexify">
                        <div class="ts-checkbox-container">
                           <label class="container-radio">
                           <input type="radio" disabled="" hidden="" value="bars">
                           <span class="checkmark"></span>
                           </label>
                        </div>
                        <span>All in Bars</span>
                        <div class="ts-term-icon">
                          <?= \Voxel\get_svg( 'file.svg' ) ?>
                        </div>
                     </a>
                  </li>
                  <li class="">
                     <a href="#" class="flexify">
                        <div class="ts-checkbox-container">
                           <label class="container-radio">
                           <input type="radio" disabled="" hidden="" value="nightlife">
                           <span class="checkmark"></span>
                           </label>
                        </div>
                        <span>Nightlife</span>
                        <!--v-if-->
                        <div class="ts-term-icon">
                           <?= \Voxel\get_svg( 'file.svg' ) ?>
                        </div>
                     </a>
                  </li>
                  <!--v-if-->
               </ul>
            </div>
         </div>
      </div>
   </div>

   <div class="ts-form elementor-element elementor-element-14b73b99">
      <div class="ts-field-popup-container">
         <div class="ts-field-popup triggers-blur">
            <div class="ts-popup-content-wrapper min-scroll">
               <div class="ts-term-dropdown ts-md-group ts-multilevel-dropdown">
                  <ul class="simplify-ul ts-term-dropdown-list sub-menu">
                     <li id="menu-item-28" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-28">
                        <a href="#" class="flexify">
                           <div class="ts-term-icon">
                              <!--?xml version="1.0" encoding="UTF-8"?-->
                               <?= \Voxel\get_svg( 'file.svg' ) ?>
                           </div>
                           <span>Places</span>
                           <div class="ts-right-icon"></div>
                        </a>
                     </li>
                     <li id="menu-item-29" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-29">
                        <a href="#" class="flexify">
                           <div class="ts-term-icon">
                               <?= \Voxel\get_svg( 'file.svg' ) ?>
                           </div>
                           <span>Events</span>
                           <div class="ts-right-icon"></div>
                        </a>
                     </li>
                     <li id="menu-item-2588" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-2588">
                        <a href="#" class="flexify">
                           <div class="ts-term-icon">
                               <?= \Voxel\get_svg( 'file.svg' ) ?>
                           </div>
                           <span>Jobs</span>
                           <div class="ts-right-icon"></div>
                        </a>
                     </li>
                     <li id="menu-item-2589" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-2589">
                        <a href="#" class="flexify">
                           <div class="ts-term-icon">
                               <?= \Voxel\get_svg( 'file.svg' ) ?>
                           </div>
                           <span>Groups</span>
                           <div class="ts-right-icon"></div>
                        </a>
                     </li>
                     <li id="menu-item-6070" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-6070">
                        <a href="http://192.168.178.55/city/collections/" class="flexify">
                           <div class="ts-term-icon">
                               <?= \Voxel\get_svg( 'file.svg' ) ?>
                           </div>
                           <span>Collections</span>
                        </a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="ts-form elementor-element elementor-element-14b73b99">
      <div class="ts-field-popup-container">
         <div class="ts-field-popup triggers-blur">
            <div class="ts-popup-content-wrapper min-scroll">
               <div class="ts-booking-date ts-booking-date-single ts-form-group">
                  <input type="hidden">
                  <div class="pika-single">
                     <div class="pika-lendar">
                        <div id="pika-title-ln" class="pika-title" role="heading" aria-live="assertive">
                           <div class="pika-label">
                              January
                              <select class="pika-select pika-select-month" tabindex="-1">
                                 <option value="0" selected="selected">January</option>
                                 <option value="1">February</option>
                                 <option value="2">March</option>
                                 <option value="3">April</option>
                                 <option value="4">May</option>
                                 <option value="5">June</option>
                                 <option value="6">July</option>
                                 <option value="7">August</option>
                                 <option value="8">September</option>
                                 <option value="9">October</option>
                                 <option value="10">November</option>
                                 <option value="11">December</option>
                              </select>
                           </div>
                           <div class="pika-label">
                              2023
                              <select class="pika-select pika-select-year" tabindex="-1">
                                 <option value="2013">2013</option>
                                 <option value="2014">2014</option>
                                 <option value="2015">2015</option>
                                 <option value="2016">2016</option>
                                 <option value="2017">2017</option>
                                 <option value="2018">2018</option>
                                 <option value="2019">2019</option>
                                 <option value="2020">2020</option>
                                 <option value="2021">2021</option>
                                 <option value="2022">2022</option>
                                 <option value="2023" selected="selected">2023</option>
                                 <option value="2024">2024</option>
                                 <option value="2025">2025</option>
                                 <option value="2026">2026</option>
                                 <option value="2027">2027</option>
                                 <option value="2028">2028</option>
                                 <option value="2029">2029</option>
                                 <option value="2030">2030</option>
                                 <option value="2031">2031</option>
                                 <option value="2032">2032</option>
                                 <option value="2033">2033</option>
                              </select>
                           </div>
                           <button class="pika-prev ts-icon-btn" type="button">
                               <?= \Voxel\get_svg( 'chevron-left.svg' ) ?>
                           </button>
                           <button class="pika-next ts-icon-btn" type="button">
                              <?= \Voxel\get_svg( 'chevron-right.svg' ) ?>
                           </button>
                        </div>
                        <table cellpadding="0" cellspacing="0" class="pika-table" role="grid" aria-labelledby="pika-title-ln">
                           <thead>
                              <tr>
                                 <th scope="col">
                                    <abbr title="Monday">Mon</abbr>
                                 </th>
                                 <th scope="col">
                                    <abbr title="Tuesday">Tue</abbr>
                                 </th>
                                 <th scope="col">
                                    <abbr title="Wednesday">Wed</abbr>
                                 </th>
                                 <th scope="col">
                                    <abbr title="Thursday">Thu</abbr>
                                 </th>
                                 <th scope="col">
                                    <abbr title="Friday">Fri</abbr>
                                 </th>
                                 <th scope="col">
                                    <abbr title="Saturday">Sat</abbr>
                                 </th>
                                 <th scope="col">
                                    <abbr title="Sunday">Sun</abbr>
                                 </th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr class="pika-row">
                                 <td class="is-empty"></td>
                                 <td class="is-empty"></td>
                                 <td class="is-empty"></td>
                                 <td class="is-empty"></td>
                                 <td class="is-empty"></td>
                                 <td class="is-empty"></td>
                                 <td data-day="1" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="1">1</button>
                                 </td>
                              </tr>
                              <tr class="pika-row">
                                 <td data-day="2" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="2">2</button>
                                 </td>
                                 <td data-day="3" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="3">3</button>
                                 </td>
                                 <td data-day="4" class="is-today" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="4">4</button>
                                 </td>
                                 <td data-day="5" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="5">5</button>
                                 </td>
                                 <td data-day="6" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="6">6</button>
                                 </td>
                                 <td data-day="7" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="7">7</button>
                                 </td>
                                 <td data-day="8" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="8">8</button>
                                 </td>
                              </tr>
                              <tr class="pika-row">
                                 <td data-day="9" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="9">9</button>
                                 </td>
                                 <td data-day="10" class="is-selected" aria-selected="true">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="10">10</button>
                                 </td>
                                 <td data-day="11" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="11">11</button>
                                 </td>
                                 <td data-day="12" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="12">12</button>
                                 </td>
                                 <td data-day="13" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="13">13</button>
                                 </td>
                                 <td data-day="14" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="14">14</button>
                                 </td>
                                 <td data-day="15" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="15">15</button>
                                 </td>
                              </tr>
                              <tr class="pika-row">
                                 <td data-day="16" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="16">16</button>
                                 </td>
                                 <td data-day="17" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="17">17</button>
                                 </td>
                                 <td data-day="18" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="18">18</button>
                                 </td>
                                 <td data-day="19" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="19">19</button>
                                 </td>
                                 <td data-day="20" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="20">20</button>
                                 </td>
                                 <td data-day="21" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="21">21</button>
                                 </td>
                                 <td data-day="22" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="22">22</button>
                                 </td>
                              </tr>
                              <tr class="pika-row">
                                 <td data-day="23" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="23">23</button>
                                 </td>
                                 <td data-day="24" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="24">24</button>
                                 </td>
                                 <td data-day="25" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="25">25</button>
                                 </td>
                                 <td data-day="26" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="26">26</button>
                                 </td>
                                 <td data-day="27" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="27">27</button>
                                 </td>
                                 <td data-day="28" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="28">28</button>
                                 </td>
                                 <td data-day="29" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="29">29</button>
                                 </td>
                              </tr>
                              <tr class="pika-row">
                                 <td data-day="30" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="30">30</button>
                                 </td>
                                 <td data-day="31" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="0" data-pika-day="31">31</button>
                                 </td>
                                 <td class="is-empty"></td>
                                 <td class="is-empty"></td>
                                 <td class="is-empty"></td>
                                 <td class="is-empty"></td>
                                 <td class="is-empty"></td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

</div>
</div>
<div class="popup-kit-holder1">
   <style type="text/css">
      .popup-kit-holder1 {
      padding: 30px;
      width: 700px;
      margin: auto;
      display: flex;
      flex-direction: column;
      }

   </style>
   <div class="ts-form elementor-element elementor-element-14b73b99" style="grid-column-end: span 2;">
      <div class="ts-field-popup-container">
         <div class="ts-field-popup triggers-blur">
            <div class="ts-popup-content-wrapper min-scroll">
               <div class="ts-popup-head flexify">
                  <div class="ts-popup-name flexify">
                     <svg fill="#000000" width="52" height="52" version="1.1" id="lni_lni-calender-alt-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" xml:space="preserve">
                        <g>
                           <path d="M57,10.4h-6.3V7.6c0-1-0.8-1.8-1.8-1.8s-1.8,0.8-1.8,1.8v2.8H16.8V7.6c0-1-0.8-1.8-1.8-1.8s-1.8,0.8-1.8,1.8v2.8H7
                              c-3.2,0-5.8,2.6-5.8,5.8v36.3c0,3.2,2.6,5.8,5.8,5.8h50c3.2,0,5.8-2.6,5.8-5.8V16.1C62.8,12.9,60.2,10.4,57,10.4z M7,13.9h6.3v2.7
                              c0,1,0.8,1.8,1.8,1.8s1.8-0.8,1.8-1.8v-2.7h30.4v2.7c0,1,0.8,1.8,1.8,1.8s1.8-0.8,1.8-1.8v-2.7H57c1.2,0,2.3,1,2.3,2.3v7.6H4.8
                              v-7.6C4.8,14.9,5.8,13.9,7,13.9z M57,54.7H7c-1.2,0-2.3-1-2.3-2.3V27.2h54.5v25.2C59.3,53.7,58.2,54.7,57,54.7z"></path>
                           <path d="M50.4,32.2h-2.2c-0.6,0-1,0.4-1,1v2.2c0,0.6,0.4,1,1,1h2.2c0.6,0,1-0.4,1-1v-2.2C51.4,32.6,50.9,32.2,50.4,32.2z"></path>
                           <path d="M24.5,32.2h-2.2c-0.6,0-1,0.4-1,1v2.2c0,0.6,0.4,1,1,1h2.2c0.6,0,1-0.4,1-1v-2.2C25.5,32.6,25,32.2,24.5,32.2z"></path>
                           <path d="M33.1,32.2h-2.2c-0.6,0-1,0.4-1,1v2.2c0,0.6,0.4,1,1,1h2.2c0.6,0,1-0.4,1-1v-2.2C34.1,32.6,33.7,32.2,33.1,32.2z"></path>
                           <path d="M41.7,32.2h-2.2c-0.6,0-1,0.4-1,1v2.2c0,0.6,0.4,1,1,1h2.2c0.6,0,1-0.4,1-1v-2.2C42.7,32.6,42.3,32.2,41.7,32.2z"></path>
                           <path d="M50.4,38.9h-2.2c-0.6,0-1,0.4-1,1v2.2c0,0.6,0.4,1,1,1h2.2c0.6,0,1-0.4,1-1v-2.2C51.4,39.3,50.9,38.9,50.4,38.9z"></path>
                           <path d="M15.9,38.9h-2.2c-0.6,0-1,0.4-1,1v2.2c0,0.6,0.4,1,1,1h2.2c0.6,0,1-0.4,1-1v-2.2C16.9,39.3,16.4,38.9,15.9,38.9z"></path>
                           <path d="M24.5,38.9h-2.2c-0.6,0-1,0.4-1,1v2.2c0,0.6,0.4,1,1,1h2.2c0.6,0,1-0.4,1-1v-2.2C25.5,39.3,25,38.9,24.5,38.9z"></path>
                           <path d="M33.1,38.9h-2.2c-0.6,0-1,0.4-1,1v2.2c0,0.6,0.4,1,1,1h2.2c0.6,0,1-0.4,1-1v-2.2C34.1,39.3,33.7,38.9,33.1,38.9z"></path>
                           <path d="M41.7,38.9h-2.2c-0.6,0-1,0.4-1,1v2.2c0,0.6,0.4,1,1,1h2.2c0.6,0,1-0.4,1-1v-2.2C42.7,39.3,42.3,38.9,41.7,38.9z"></path>
                           <path d="M15.9,45.6h-2.2c-0.6,0-1,0.4-1,1v2.2c0,0.6,0.4,1,1,1h2.2c0.6,0,1-0.4,1-1v-2.2C16.9,46,16.4,45.6,15.9,45.6z"></path>
                           <path d="M24.5,45.6h-2.2c-0.6,0-1,0.4-1,1v2.2c0,0.6,0.4,1,1,1h2.2c0.6,0,1-0.4,1-1v-2.2C25.5,46,25,45.6,24.5,45.6z"></path>
                           <path d="M33.1,45.6h-2.2c-0.6,0-1,0.4-1,1v2.2c0,0.6,0.4,1,1,1h2.2c0.6,0,1-0.4,1-1v-2.2C34.1,46,33.7,45.6,33.1,45.6z"></path>
                           <path d="M41.7,45.6h-2.2c-0.6,0-1,0.4-1,1v2.2c0,0.6,0.4,1,1,1h2.2c0.6,0,1-0.4,1-1v-2.2C42.7,46,42.3,45.6,41.7,45.6z"></path>
                        </g>
                     </svg>
                     <span>
                     <span class="chosen">Feb 7, 2023</span>
                     <span> — </span>
                     <span class="">Feb 16, 2023</span>
                     </span>
                  </div>
               </div>
               <div class="ts-booking-date ts-booking-date-range ts-form-group">
                  <input type="hidden">
                  <div class="pika-single pika-range">
                     <div class="pika-lendar">
                        <div id="pika-title-ml" class="pika-title" role="heading" aria-live="assertive">
                           <div class="pika-label">
                              February
                              <select class="pika-select pika-select-month" tabindex="-1">
                                 <option value="0">January</option>
                                 <option value="1" selected="selected">February</option>
                                 <option value="2">March</option>
                                 <option value="3">April</option>
                                 <option value="4">May</option>
                                 <option value="5">June</option>
                                 <option value="6">July</option>
                                 <option value="7">August</option>
                                 <option value="8">September</option>
                                 <option value="9">October</option>
                                 <option value="10">November</option>
                                 <option value="11">December</option>
                              </select>
                           </div>
                           <div class="pika-label">
                              2023
                              <select class="pika-select pika-select-year" tabindex="-1">
                                 <option value="2023" selected="selected">2023</option>
                                 <option value="2024">2024</option>
                                 <option value="2025">2025</option>
                                 <option value="2026">2026</option>
                                 <option value="2027">2027</option>
                                 <option value="2028">2028</option>
                                 <option value="2029">2029</option>
                                 <option value="2030">2030</option>
                                 <option value="2031">2031</option>
                                 <option value="2032">2032</option>
                                 <option value="2033">2033</option>
                              </select>
                           </div>
                           <button class="pika-prev ts-icon-btn" type="button">
                              <svg fill="#000000" width="52" height="52" version="1.1" id="lni_lni-chevron-left" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" xml:space="preserve">
                                 <g>
                                    <path d="M45,62.8c-0.5,0-0.9-0.2-1.3-0.6L18.6,35.4c-1.7-1.9-1.7-4.9,0-6.7L43.7,1.8c0.7-0.7,1.8-0.7,2.5-0.1c0.7,0.7,0.7,1.8,0.1,2.5L21.1,31c-0.5,0.5-0.5,1.4,0,2l25.2,26.8c0.7,0.7,0.6,1.8-0.1,2.5C45.9,62.6,45.4,62.8,45,62.8z"></path>
                                 </g>
                              </svg>
                           </button>
                        </div>
                        <table cellpadding="0" cellspacing="0" class="pika-table" role="grid" aria-labelledby="pika-title-ml">
                           <thead>
                              <tr>
                                 <th scope="col">
                                    <abbr title="Monday">Mon</abbr>
                                 </th>
                                 <th scope="col">
                                    <abbr title="Tuesday">Tue</abbr>
                                 </th>
                                 <th scope="col">
                                    <abbr title="Wednesday">Wed</abbr>
                                 </th>
                                 <th scope="col">
                                    <abbr title="Thursday">Thu</abbr>
                                 </th>
                                 <th scope="col">
                                    <abbr title="Friday">Fri</abbr>
                                 </th>
                                 <th scope="col">
                                    <abbr title="Saturday">Sat</abbr>
                                 </th>
                                 <th scope="col">
                                    <abbr title="Sunday">Sun</abbr>
                                 </th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr class="pika-row">
                                 <td class="is-empty"></td>
                                 <td class="is-empty"></td>
                                 <td data-day="1" class="is-disabled" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="1" data-pika-day="1">1</button>
                                 </td>
                                 <td data-day="2" class="is-disabled" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="1" data-pika-day="2">2</button>
                                 </td>
                                 <td data-day="3" class="is-disabled" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="1" data-pika-day="3">3</button>
                                 </td>
                                 <td data-day="4" class="is-disabled" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="1" data-pika-day="4">4</button>
                                 </td>
                                 <td data-day="5" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="1" data-pika-day="5">5</button>
                                 </td>
                              </tr>
                              <tr class="pika-row">
                                 <td data-day="6" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="1" data-pika-day="6">6</button>
                                 </td>
                                 <td data-day="7" class="is-selected is-startrange" aria-selected="true">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="1" data-pika-day="7">7</button>
                                 </td>
                                 <td data-day="8" class="is-inrange" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="1" data-pika-day="8">8</button>
                                 </td>
                                 <td data-day="9" class="is-inrange" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="1" data-pika-day="9">9</button>
                                 </td>
                                 <td data-day="10" class="is-inrange" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="1" data-pika-day="10">10</button>
                                 </td>
                                 <td data-day="11" class="is-inrange" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="1" data-pika-day="11">11</button>
                                 </td>
                                 <td data-day="12" class="is-inrange" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="1" data-pika-day="12">12</button>
                                 </td>
                              </tr>
                              <tr class="pika-row">
                                 <td data-day="13" class="is-inrange" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="1" data-pika-day="13">13</button>
                                 </td>
                                 <td data-day="14" class="is-inrange" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="1" data-pika-day="14">14</button>
                                 </td>
                                 <td data-day="15" class="is-inrange" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="1" data-pika-day="15">15</button>
                                 </td>
                                 <td data-day="16" class="is-selected is-endrange" aria-selected="true">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="1" data-pika-day="16">16</button>
                                 </td>
                                 <td data-day="17" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="1" data-pika-day="17">17</button>
                                 </td>
                                 <td data-day="18" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="1" data-pika-day="18">18</button>
                                 </td>
                                 <td data-day="19" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="1" data-pika-day="19">19</button>
                                 </td>
                              </tr>
                              <tr class="pika-row">
                                 <td data-day="20" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="1" data-pika-day="20">20</button>
                                 </td>
                                 <td data-day="21" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="1" data-pika-day="21">21</button>
                                 </td>
                                 <td data-day="22" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="1" data-pika-day="22">22</button>
                                 </td>
                                 <td data-day="23" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="1" data-pika-day="23">23</button>
                                 </td>
                                 <td data-day="24" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="1" data-pika-day="24">24</button>
                                 </td>
                                 <td data-day="25" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="1" data-pika-day="25">25</button>
                                 </td>
                                 <td data-day="26" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="1" data-pika-day="26">26</button>
                                 </td>
                              </tr>
                              <tr class="pika-row">
                                 <td data-day="27" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="1" data-pika-day="27">27</button>
                                 </td>
                                 <td data-day="28" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="1" data-pika-day="28">28</button>
                                 </td>
                                 <td class="is-empty"></td>
                                 <td class="is-empty"></td>
                                 <td class="is-empty"></td>
                                 <td class="is-empty"></td>
                                 <td class="is-empty"></td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                     <div class="pika-lendar">
                        <div id="pika-title-nl" class="pika-title" role="heading" aria-live="assertive">
                           <div class="pika-label">
                              March
                              <select class="pika-select pika-select-month" tabindex="-1">
                                 <option value="-1">January</option>
                                 <option value="0">February</option>
                                 <option value="1" selected="selected">March</option>
                                 <option value="2">April</option>
                                 <option value="3">May</option>
                                 <option value="4">June</option>
                                 <option value="5">July</option>
                                 <option value="6">August</option>
                                 <option value="7">September</option>
                                 <option value="8">October</option>
                                 <option value="9">November</option>
                                 <option value="10">December</option>
                              </select>
                           </div>
                           <div class="pika-label">
                              2023
                              <select class="pika-select pika-select-year" tabindex="-1">
                                 <option value="2023" selected="selected">2023</option>
                                 <option value="2024">2024</option>
                                 <option value="2025">2025</option>
                                 <option value="2026">2026</option>
                                 <option value="2027">2027</option>
                                 <option value="2028">2028</option>
                                 <option value="2029">2029</option>
                                 <option value="2030">2030</option>
                                 <option value="2031">2031</option>
                                 <option value="2032">2032</option>
                                 <option value="2033">2033</option>
                              </select>
                           </div>
                           <button class="pika-next ts-icon-btn" type="button">
                              <svg fill="#000000" width="52" height="52" version="1.1" id="lni_lni-chevron-right" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" xml:space="preserve">
                                 <g>
                                    <path d="M19,62.8c-0.4,0-0.9-0.2-1.2-0.5c-0.7-0.7-0.7-1.8-0.1-2.5L42.9,33c0.5-0.5,0.5-1.4,0-2L17.7,4.2c-0.7-0.7-0.6-1.8,0.1-2.5c0.7-0.7,1.8-0.6,2.5,0.1l25.2,26.8c1.7,1.9,1.7,4.9,0,6.7L20.3,62.2C19.9,62.6,19.5,62.8,19,62.8z"></path>
                                 </g>
                              </svg>
                           </button>
                        </div>
                        <table cellpadding="0" cellspacing="0" class="pika-table" role="grid" aria-labelledby="pika-title-nl">
                           <thead>
                              <tr>
                                 <th scope="col">
                                    <abbr title="Monday">Mon</abbr>
                                 </th>
                                 <th scope="col">
                                    <abbr title="Tuesday">Tue</abbr>
                                 </th>
                                 <th scope="col">
                                    <abbr title="Wednesday">Wed</abbr>
                                 </th>
                                 <th scope="col">
                                    <abbr title="Thursday">Thu</abbr>
                                 </th>
                                 <th scope="col">
                                    <abbr title="Friday">Fri</abbr>
                                 </th>
                                 <th scope="col">
                                    <abbr title="Saturday">Sat</abbr>
                                 </th>
                                 <th scope="col">
                                    <abbr title="Sunday">Sun</abbr>
                                 </th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr class="pika-row">
                                 <td class="is-empty"></td>
                                 <td class="is-empty"></td>
                                 <td data-day="1" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="1">1</button>
                                 </td>
                                 <td data-day="2" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="2">2</button>
                                 </td>
                                 <td data-day="3" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="3">3</button>
                                 </td>
                                 <td data-day="4" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="4">4</button>
                                 </td>
                                 <td data-day="5" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="5">5</button>
                                 </td>
                              </tr>
                              <tr class="pika-row">
                                 <td data-day="6" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="6">6</button>
                                 </td>
                                 <td data-day="7" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="7">7</button>
                                 </td>
                                 <td data-day="8" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="8">8</button>
                                 </td>
                                 <td data-day="9" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="9">9</button>
                                 </td>
                                 <td data-day="10" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="10">10</button>
                                 </td>
                                 <td data-day="11" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="11">11</button>
                                 </td>
                                 <td data-day="12" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="12">12</button>
                                 </td>
                              </tr>
                              <tr class="pika-row">
                                 <td data-day="13" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="13">13</button>
                                 </td>
                                 <td data-day="14" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="14">14</button>
                                 </td>
                                 <td data-day="15" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="15">15</button>
                                 </td>
                                 <td data-day="16" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="16">16</button>
                                 </td>
                                 <td data-day="17" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="17">17</button>
                                 </td>
                                 <td data-day="18" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="18">18</button>
                                 </td>
                                 <td data-day="19" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="19">19</button>
                                 </td>
                              </tr>
                              <tr class="pika-row">
                                 <td data-day="20" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="20">20</button>
                                 </td>
                                 <td data-day="21" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="21">21</button>
                                 </td>
                                 <td data-day="22" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="22">22</button>
                                 </td>
                                 <td data-day="23" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="23">23</button>
                                 </td>
                                 <td data-day="24" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="24">24</button>
                                 </td>
                                 <td data-day="25" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="25">25</button>
                                 </td>
                                 <td data-day="26" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="26">26</button>
                                 </td>
                              </tr>
                              <tr class="pika-row">
                                 <td data-day="27" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="27">27</button>
                                 </td>
                                 <td data-day="28" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="28">28</button>
                                 </td>
                                 <td data-day="29" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="29">29</button>
                                 </td>
                                 <td data-day="30" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="30">30</button>
                                 </td>
                                 <td data-day="31" class="" aria-selected="false">
                                    <button class="pika-button pika-day" type="button" data-pika-year="2023" data-pika-month="2" data-pika-day="31">31</button>
                                 </td>
                                 <td class="is-empty"></td>
                                 <td class="is-empty"></td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
            <div class="ts-popup-controller">
               <ul class="flexify simplify-ul">
                  <li class="flexify">
                     <a href="#" class="ts-btn ts-btn-1">Clear</a>
                  </li>
                  <li class="flexify">
                     <a href="#" class="ts-btn ts-btn-2">Save</a>
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </div>
   <div class="ts-form elementor-element elementor-element-14b73b99" style="grid-column-end: span 2;">
      <div class="ts-field-popup-container">
         <div class="ts-field-popup triggers-blur">
            <div class="ts-popup-content-wrapper min-scroll" style="    max-height: 600px;">
               <div class="ts-popup-head flexify ts-sticky-top">
                  <div class="ts-popup-name flexify">
                     <span>
                     <img alt="" src="
                        <?php echo get_template_directory_uri(); ?>/assets/images/bg.jpg" class="avatar avatar-96 photo ts-status-avatar" height="96" width="96" loading="lazy" decoding="async">
                     </span>
                     <span>Display name</span>
                  </div>
               </div>
               <div class="ts-compose-textarea">
                  <textarea placeholder="What's on your mind?" class="autofocus min-scroll" maxlength="5000"></textarea>
               </div>
               <div class="ts-form-group review-categories">
                  <label>Hospitality
                  </label>
                  <ul class="rs-num simplify-ul flexify">
                     <li class="">1 <span>Poor</span>
                     </li>
                     <li class="">2 <span>Fair</span>
                     </li>
                     <li class="">3 <span>Good</span>
                     </li>
                     <li class="active">4 <span>Very good</span>
                     </li>
                     <li class="">5 <span>Excellent</span>
                     </li>
                  </ul>
               </div>
               <div class="ts-form-group review-categories">
                  <label>
                     Value
                     <!---->
                     <span>Good</span>
                  </label>
                  <ul class="rs-stars simplify-ul flexify">
                     <li class="flexify active">
                        <div class="ts-star-icon">
                           <!--?xml version="1.0" encoding="UTF-8"?-->
                           <svg xmlns="http://www.w3.org/2000/svg" fill="#1C2033" width="52" height="52" viewBox="0 0 24 24">
                              <path d="M11.2024 2.54494C11.5076 1.81835 12.4924 1.81835 12.7976 2.54494L15.0171 7.82918C15.1435 8.13023 15.415 8.3367 15.7276 8.36955L21.2146 8.9462C21.9691 9.02549 22.2734 10.0059 21.7076 10.5342L17.5923 14.3767C17.3578 14.5956 17.2541 14.9297 17.3209 15.251L18.4925 20.8917C18.6536 21.6673 17.8569 22.2732 17.202 21.8731L12.4391 18.9637C12.3035 18.8808 12.1517 18.8394 12 18.8394C11.8483 18.8394 11.6965 18.8808 11.5609 18.9637L6.79798 21.8731C6.14308 22.2732 5.34636 21.6673 5.50746 20.8917L6.67911 15.251C6.74587 14.9297 6.64216 14.5956 6.40771 14.3767L2.29243 10.5342C1.72658 10.0059 2.0309 9.02549 2.78537 8.9462L8.27237 8.36955C8.58497 8.3367 8.85647 8.13023 8.98292 7.82918L11.2024 2.54494Z"></path>
                           </svg>
                        </div>
                        <div class="ray-holder">
                           <div class="ray"></div>
                           <div class="ray"></div>
                           <div class="ray"></div>
                           <div class="ray"></div>
                           <div class="ray"></div>
                           <div class="ray"></div>
                           <div class="ray"></div>
                           <div class="ray"></div>
                        </div>
                     </li>
                     <li class="flexify active">
                        <div class="ts-star-icon">
                           <!--?xml version="1.0" encoding="UTF-8"?-->
                           <svg xmlns="http://www.w3.org/2000/svg" fill="#1C2033" width="52" height="52" viewBox="0 0 24 24">
                              <path d="M11.2024 2.54494C11.5076 1.81835 12.4924 1.81835 12.7976 2.54494L15.0171 7.82918C15.1435 8.13023 15.415 8.3367 15.7276 8.36955L21.2146 8.9462C21.9691 9.02549 22.2734 10.0059 21.7076 10.5342L17.5923 14.3767C17.3578 14.5956 17.2541 14.9297 17.3209 15.251L18.4925 20.8917C18.6536 21.6673 17.8569 22.2732 17.202 21.8731L12.4391 18.9637C12.3035 18.8808 12.1517 18.8394 12 18.8394C11.8483 18.8394 11.6965 18.8808 11.5609 18.9637L6.79798 21.8731C6.14308 22.2732 5.34636 21.6673 5.50746 20.8917L6.67911 15.251C6.74587 14.9297 6.64216 14.5956 6.40771 14.3767L2.29243 10.5342C1.72658 10.0059 2.0309 9.02549 2.78537 8.9462L8.27237 8.36955C8.58497 8.3367 8.85647 8.13023 8.98292 7.82918L11.2024 2.54494Z"></path>
                           </svg>
                        </div>
                        <div class="ray-holder">
                           <div class="ray"></div>
                           <div class="ray"></div>
                           <div class="ray"></div>
                           <div class="ray"></div>
                           <div class="ray"></div>
                           <div class="ray"></div>
                           <div class="ray"></div>
                           <div class="ray"></div>
                        </div>
                     </li>
                     <li class="flexify active">
                        <div class="ts-star-icon">
                           <!--?xml version="1.0" encoding="UTF-8"?-->
                           <svg xmlns="http://www.w3.org/2000/svg" fill="#1C2033" width="52" height="52" viewBox="0 0 24 24">
                              <path d="M11.2024 2.54494C11.5076 1.81835 12.4924 1.81835 12.7976 2.54494L15.0171 7.82918C15.1435 8.13023 15.415 8.3367 15.7276 8.36955L21.2146 8.9462C21.9691 9.02549 22.2734 10.0059 21.7076 10.5342L17.5923 14.3767C17.3578 14.5956 17.2541 14.9297 17.3209 15.251L18.4925 20.8917C18.6536 21.6673 17.8569 22.2732 17.202 21.8731L12.4391 18.9637C12.3035 18.8808 12.1517 18.8394 12 18.8394C11.8483 18.8394 11.6965 18.8808 11.5609 18.9637L6.79798 21.8731C6.14308 22.2732 5.34636 21.6673 5.50746 20.8917L6.67911 15.251C6.74587 14.9297 6.64216 14.5956 6.40771 14.3767L2.29243 10.5342C1.72658 10.0059 2.0309 9.02549 2.78537 8.9462L8.27237 8.36955C8.58497 8.3367 8.85647 8.13023 8.98292 7.82918L11.2024 2.54494Z"></path>
                           </svg>
                        </div>
                        <div class="ray-holder">
                           <div class="ray"></div>
                           <div class="ray"></div>
                           <div class="ray"></div>
                           <div class="ray"></div>
                           <div class="ray"></div>
                           <div class="ray"></div>
                           <div class="ray"></div>
                           <div class="ray"></div>
                        </div>
                     </li>
                     <li class="flexify">
                        <div class="ts-star-icon">
                           <!--?xml version="1.0" encoding="UTF-8"?-->
                           <svg xmlns="http://www.w3.org/2000/svg" fill="#1C2033" width="52" height="52" viewBox="0 0 24 24">
                              <path d="M11.2024 2.54494C11.5076 1.81835 12.4924 1.81835 12.7976 2.54494L15.0171 7.82918C15.1435 8.13023 15.415 8.3367 15.7276 8.36955L21.2146 8.9462C21.9691 9.02549 22.2734 10.0059 21.7076 10.5342L17.5923 14.3767C17.3578 14.5956 17.2541 14.9297 17.3209 15.251L18.4925 20.8917C18.6536 21.6673 17.8569 22.2732 17.202 21.8731L12.4391 18.9637C12.3035 18.8808 12.1517 18.8394 12 18.8394C11.8483 18.8394 11.6965 18.8808 11.5609 18.9637L6.79798 21.8731C6.14308 22.2732 5.34636 21.6673 5.50746 20.8917L6.67911 15.251C6.74587 14.9297 6.64216 14.5956 6.40771 14.3767L2.29243 10.5342C1.72658 10.0059 2.0309 9.02549 2.78537 8.9462L8.27237 8.36955C8.58497 8.3367 8.85647 8.13023 8.98292 7.82918L11.2024 2.54494Z"></path>
                           </svg>
                        </div>
                        <div class="ray-holder">
                           <div class="ray"></div>
                           <div class="ray"></div>
                           <div class="ray"></div>
                           <div class="ray"></div>
                           <div class="ray"></div>
                           <div class="ray"></div>
                           <div class="ray"></div>
                           <div class="ray"></div>
                        </div>
                     </li>
                     <li class="flexify">
                        <div class="ts-star-icon">
                           <!--?xml version="1.0" encoding="UTF-8"?-->
                           <svg xmlns="http://www.w3.org/2000/svg" fill="#1C2033" width="52" height="52" viewBox="0 0 24 24">
                              <path d="M11.2024 2.54494C11.5076 1.81835 12.4924 1.81835 12.7976 2.54494L15.0171 7.82918C15.1435 8.13023 15.415 8.3367 15.7276 8.36955L21.2146 8.9462C21.9691 9.02549 22.2734 10.0059 21.7076 10.5342L17.5923 14.3767C17.3578 14.5956 17.2541 14.9297 17.3209 15.251L18.4925 20.8917C18.6536 21.6673 17.8569 22.2732 17.202 21.8731L12.4391 18.9637C12.3035 18.8808 12.1517 18.8394 12 18.8394C11.8483 18.8394 11.6965 18.8808 11.5609 18.9637L6.79798 21.8731C6.14308 22.2732 5.34636 21.6673 5.50746 20.8917L6.67911 15.251C6.74587 14.9297 6.64216 14.5956 6.40771 14.3767L2.29243 10.5342C1.72658 10.0059 2.0309 9.02549 2.78537 8.9462L8.27237 8.36955C8.58497 8.3367 8.85647 8.13023 8.98292 7.82918L11.2024 2.54494Z"></path>
                           </svg>
                        </div>
                        <div class="ray-holder">
                           <div class="ray"></div>
                           <div class="ray"></div>
                           <div class="ray"></div>
                           <div class="ray"></div>
                           <div class="ray"></div>
                           <div class="ray"></div>
                           <div class="ray"></div>
                           <div class="ray"></div>
                        </div>
                     </li>
                  </ul>
               </div>
               <!--v-if-->
               <div class="ts-form-group ts-file-upload ts-status-files">
                  <label>Attach images</label>
                  <div class="ts-file-list">
                     <div class="pick-file-input">
                        <a href="#">
                           <svg fill="#000000" width="52" height="52" version="1.1" id="lni_lni-cloud-upload" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" xml:space="preserve">
                              <g>
                                 <path d="M34.3,27.3c-0.5-0.5-1.1-0.8-1.8-0.8c-0.7,0-1.3,0.3-1.8,0.8l-4.9,5.1c-0.7,0.7-0.7,1.8,0,2.5c0.7,0.7,1.8,0.7,2.5,0
                                    l2.5-2.6v9.5c0,1,0.8,1.8,1.8,1.8c1,0,1.8-0.8,1.8-1.8v-9.5l2.5,2.6c0.3,0.4,0.8,0.5,1.3,0.5c0.4,0,0.9-0.2,1.2-0.5
                                    c0.7-0.7,0.7-1.8,0-2.5L34.3,27.3z"></path>
                                 <path d="M57.8,23.7c-2.7-2.9-6.6-4.9-10.6-5.6c-2.2-3.5-5.5-6.1-9.3-7.4c-1.7-0.6-3.7-1-5.8-1c-9.6,0-17.5,7.5-17.9,16.9
                                    C6.9,27.2,1.3,33.2,1.3,40.4c0,7.6,6.3,13.8,14.1,13.9c0,0,0,0,0,0h28.8c10.3,0,18.6-8.2,18.6-18.2C62.8,31.5,61,27.1,57.8,23.7z
                                    M44.1,50.8H15.4c-6,0-10.6-4.6-10.6-10.4S9.4,30,15.4,30h0.5c1,0,1.8-0.8,1.8-1.8v-1.1c0-7.7,6.5-14,14.4-14
                                    c1.7,0,3.2,0.3,4.6,0.8c3.3,1.1,6.1,3.5,7.9,6.6c0.3,0.5,0.8,0.8,1.3,0.9c3.6,0.4,7,2,9.3,4.6c2.6,2.8,4,6.3,4,10
                                    C59.3,44.2,52.5,50.8,44.1,50.8z"></path>
                              </g>
                           </svg>
                           Upload
                        </a>
                     </div>
                     <div class="ts-file ts-file-img" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/bg.jpg');">
                        <div class="ts-file-info">
                           <svg fill="#000000" width="52" height="52" version="1.1" id="lni_lni-cloud-upload" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                              <g>
                                 <path d="M34.3,27.3c-0.5-0.5-1.1-0.8-1.8-0.8c-0.7,0-1.3,0.3-1.8,0.8l-4.9,5.1c-0.7,0.7-0.7,1.8,0,2.5c0.7,0.7,1.8,0.7,2.5,0
                                    l2.5-2.6v9.5c0,1,0.8,1.8,1.8,1.8c1,0,1.8-0.8,1.8-1.8v-9.5l2.5,2.6c0.3,0.4,0.8,0.5,1.3,0.5c0.4,0,0.9-0.2,1.2-0.5
                                    c0.7-0.7,0.7-1.8,0-2.5L34.3,27.3z"></path>
                                 <path d="M57.8,23.7c-2.7-2.9-6.6-4.9-10.6-5.6c-2.2-3.5-5.5-6.1-9.3-7.4c-1.7-0.6-3.7-1-5.8-1c-9.6,0-17.5,7.5-17.9,16.9
                                    C6.9,27.2,1.3,33.2,1.3,40.4c0,7.6,6.3,13.8,14.1,13.9c0,0,0,0,0,0h28.8c10.3,0,18.6-8.2,18.6-18.2C62.8,31.5,61,27.1,57.8,23.7z
                                    M44.1,50.8H15.4c-6,0-10.6-4.6-10.6-10.4S9.4,30,15.4,30h0.5c1,0,1.8-0.8,1.8-1.8v-1.1c0-7.7,6.5-14,14.4-14
                                    c1.7,0,3.2,0.3,4.6,0.8c3.3,1.1,6.1,3.5,7.9,6.6c0.3,0.5,0.8,0.8,1.3,0.9c3.6,0.4,7,2,9.3,4.6c2.6,2.8,4,6.3,4,10
                                    C59.3,44.2,52.5,50.8,44.1,50.8z"></path>
                              </g>
                           </svg>
                           <code>1a293e475131d6-1.jpg</code>
                        </div>
                        <a href="#" class="ts-remove-file flexify">
                           <svg fill="#000000" width="52" height="52" version="1.1" id="lni_lni-close" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                              <path d="M34.5,32L62.2,4.2c0.7-0.7,0.7-1.8,0-2.5c-0.7-0.7-1.8-0.7-2.5,0L32,29.5L4.2,1.8c-0.7-0.7-1.8-0.7-2.5,0
                                 c-0.7,0.7-0.7,1.8,0,2.5L29.5,32L1.8,59.8c-0.7,0.7-0.7,1.8,0,2.5c0.3,0.3,0.8,0.5,1.2,0.5s0.9-0.2,1.2-0.5L32,34.5l27.7,27.8
                                 c0.3,0.3,0.8,0.5,1.2,0.5c0.4,0,0.9-0.2,1.2-0.5c0.7-0.7,0.7-1.8,0-2.5L34.5,32z"></path>
                           </svg>
                        </a>
                     </div>
                     <div class="ts-file ts-file-img" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/bg.jpg');">
                        <div class="ts-file-info">
                           <svg fill="#000000" width="52" height="52" version="1.1" id="lni_lni-cloud-upload" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                              <g>
                                 <path d="M34.3,27.3c-0.5-0.5-1.1-0.8-1.8-0.8c-0.7,0-1.3,0.3-1.8,0.8l-4.9,5.1c-0.7,0.7-0.7,1.8,0,2.5c0.7,0.7,1.8,0.7,2.5,0
                                    l2.5-2.6v9.5c0,1,0.8,1.8,1.8,1.8c1,0,1.8-0.8,1.8-1.8v-9.5l2.5,2.6c0.3,0.4,0.8,0.5,1.3,0.5c0.4,0,0.9-0.2,1.2-0.5
                                    c0.7-0.7,0.7-1.8,0-2.5L34.3,27.3z"></path>
                                 <path d="M57.8,23.7c-2.7-2.9-6.6-4.9-10.6-5.6c-2.2-3.5-5.5-6.1-9.3-7.4c-1.7-0.6-3.7-1-5.8-1c-9.6,0-17.5,7.5-17.9,16.9
                                    C6.9,27.2,1.3,33.2,1.3,40.4c0,7.6,6.3,13.8,14.1,13.9c0,0,0,0,0,0h28.8c10.3,0,18.6-8.2,18.6-18.2C62.8,31.5,61,27.1,57.8,23.7z
                                    M44.1,50.8H15.4c-6,0-10.6-4.6-10.6-10.4S9.4,30,15.4,30h0.5c1,0,1.8-0.8,1.8-1.8v-1.1c0-7.7,6.5-14,14.4-14
                                    c1.7,0,3.2,0.3,4.6,0.8c3.3,1.1,6.1,3.5,7.9,6.6c0.3,0.5,0.8,0.8,1.3,0.9c3.6,0.4,7,2,9.3,4.6c2.6,2.8,4,6.3,4,10
                                    C59.3,44.2,52.5,50.8,44.1,50.8z"></path>
                              </g>
                           </svg>
                           <code>62539639a0e8c8-1.jpg</code>
                        </div>
                        <a href="#" class="ts-remove-file flexify">
                           <svg fill="#000000" width="52" height="52" version="1.1" id="lni_lni-close" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
                              <path d="M34.5,32L62.2,4.2c0.7-0.7,0.7-1.8,0-2.5c-0.7-0.7-1.8-0.7-2.5,0L32,29.5L4.2,1.8c-0.7-0.7-1.8-0.7-2.5,0
                                 c-0.7,0.7-0.7,1.8,0,2.5L29.5,32L1.8,59.8c-0.7,0.7-0.7,1.8,0,2.5c0.3,0.3,0.8,0.5,1.2,0.5s0.9-0.2,1.2-0.5L32,34.5l27.7,27.8
                                 c0.3,0.3,0.8,0.5,1.2,0.5c0.4,0,0.9-0.2,1.2-0.5c0.7-0.7,0.7-1.8,0-2.5L34.5,32z"></path>
                           </svg>
                        </a>
                     </div>
                  </div>
                  <a href="#" class="ts-btn ts-btn-4 create-btn">
                     <svg fill="#000000" width="52" height="52" version="1.1" id="lni_lni-gallery" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" xml:space="preserve">
                        <g>
                           <path d="M23.1,41.5c3.1,0,5.7-2.5,5.7-5.6c0-3.1-2.5-5.6-5.7-5.6s-5.7,2.5-5.7,5.6C17.5,39,20,41.5,23.1,41.5z M23.1,33.7
                              c1.2,0,2.2,1,2.2,2.1c0,1.2-1,2.1-2.2,2.1C22,38,21,37,21,35.9C21,34.7,22,33.7,23.1,33.7z"></path>
                           <path d="M49.2,20.9c3.1,0,5.7-2.5,5.7-5.6c0-3.1-2.5-5.6-5.7-5.6s-5.7,2.5-5.7,5.6C43.5,18.4,46.1,20.9,49.2,20.9z M49.2,13.2
                              c1.2,0,2.2,1,2.2,2.1s-1,2.1-2.2,2.1s-2.2-1-2.2-2.1S48,13.2,49.2,13.2z"></path>
                           <path d="M55.5,1.5H35c-4,0-7.2,3.2-7.2,7.2V22H7.5c-3.2,0-5.8,2.6-5.8,5.8v29c0,3.2,2.6,5.8,5.8,5.8H31c3.2,0,5.8-2.6,5.8-5.8V42
                              h18.8c4,0,7.2-3.2,7.2-7.2v-26C62.8,4.7,59.5,1.5,55.5,1.5z M35,5h20.6c2.1,0,3.7,1.7,3.7,3.7v15.1c-0.8,0.5-2,1.3-2.2,1.5
                              c-0.9,0.6-1.8,1.4-2.7,2.1c-2.6,2.3-4.4,3.6-6.8,2.7c-0.4-0.2-0.9-0.6-1.4-1l-0.4-0.3c-1.5-1.2-3.2-2.6-5.3-3.2
                              c-1.3-0.4-2.7-0.4-4.1-0.1c-0.8-2-2.8-3.5-5.1-3.6V8.7C31.2,6.6,32.9,5,35,5z M7.5,25.5H31c1.2,0,2.3,1,2.3,2.3v16.5
                              c-0.5,0.3-1.2,0.8-2.2,1.5c-0.9,0.6-1.8,1.4-2.7,2.1c-2.6,2.3-4.4,3.6-6.8,2.7c-0.5-0.2-1-0.6-1.6-1.1l-0.2-0.2
                              c-1.5-1.2-3.2-2.6-5.3-3.2c-3.5-1.1-6.6,0.7-9.2,2.3V27.8C5.2,26.5,6.2,25.5,7.5,25.5z M31,59H7.5c-1.2,0-2.3-1-2.3-2.3v-4.1
                              c0.5-0.3,0.9-0.6,1.4-0.8c2.4-1.5,4.6-2.9,6.8-2.2c1.5,0.4,2.8,1.5,4.1,2.6l0.2,0.2c0.7,0.6,1.5,1.3,2.6,1.7
                              c0.9,0.3,1.8,0.5,2.7,0.5c3.1,0,5.6-2.1,7.6-3.9c0.8-0.7,1.6-1.4,2.3-1.9c0.1-0.1,0.2-0.1,0.3-0.2v8.2C33.2,58,32.2,59,31,59z
                              M55.5,38.5H36.7v-9.4c1-0.3,1.8-0.3,2.7-0.1c1.5,0.4,2.8,1.5,4.1,2.6l0.3,0.2c0.7,0.6,1.5,1.3,2.5,1.6c1,0.3,1.8,0.5,2.7,0.5
                              c3.1,0,5.6-2.1,7.6-3.9c0.8-0.7,1.6-1.4,2.4-1.9c0.1-0.1,0.2-0.1,0.3-0.2v6.8C59.3,36.8,57.6,38.5,55.5,38.5z"></path>
                        </g>
                     </svg>
                     <span>Media library</span>
                  </a>
                  <!--teleport start-->
                  <!--teleport end-->
                  <input type="file" class="hidden" multiple="" accept="">
               </div>
            </div>
            <div class="ts-popup-controller">
               <ul class="flexify simplify-ul">
                  <li class="flexify">
                     <a href="#" class="ts-btn ts-btn-1">Clear</a>
                  </li>
                  <li class="flexify">
                     <a href="#" class="ts-btn ts-btn-2">Save</a>
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</div>


<div class="popup-kit-holder">
	<div class="ts-notice ts-notice-info" style="position: static; transform: none; left: auto;    animation: none;">
			<div class="alert-msg">
				<div class="alert-ic">
					<!--?xml version="1.0" encoding="utf-8"?-->
	<!-- Generator: Adobe Illustrator 22.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
	<svg fill="#1C2033" width="52" height="52" version="1.1" id="lni_lni-checkmark-circle" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
	<g>
		<path d="M32,1.8C15.3,1.8,1.8,15.3,1.8,32S15.3,62.3,32,62.3S62.3,48.7,62.3,32S48.7,1.8,32,1.8z M32,57.8
			C17.8,57.8,6.3,46.2,6.3,32C6.3,17.8,17.8,6.3,32,6.3c14.2,0,25.8,11.6,25.8,25.8C57.8,46.2,46.2,57.8,32,57.8z"></path>
		<path d="M40.6,22.7L28.7,34.3L23.3,29c-0.9-0.9-2.3-0.8-3.2,0c-0.9,0.9-0.8,2.3,0,3.2l6.4,6.2c0.6,0.6,1.4,0.9,2.2,0.9
			c0.8,0,1.6-0.3,2.2-0.9L43.8,26c0.9-0.9,0.9-2.3,0-3.2S41.5,21.9,40.6,22.7z"></path>
	</g>
	</svg>
					<!--?xml version="1.0" encoding="utf-8"?-->
	<!-- Generator: Adobe Illustrator 22.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
	<svg fill="#1C2033" width="52" height="52" version="1.1" id="lni_lni-cross-circle" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
	<g>
		<path d="M32,1.8C15.3,1.8,1.8,15.3,1.8,32S15.3,62.3,32,62.3S62.3,48.7,62.3,32S48.7,1.8,32,1.8z M32,57.8
			C17.8,57.8,6.3,46.2,6.3,32C6.3,17.8,17.8,6.3,32,6.3c14.2,0,25.8,11.6,25.8,25.8C57.8,46.2,46.2,57.8,32,57.8z"></path>
		<path d="M41.2,22.7c-0.9-0.9-2.3-0.9-3.2,0L32,28.8l-6.1-6.1c-0.9-0.9-2.3-0.9-3.2,0c-0.9,0.9-0.9,2.3,0,3.2l6.1,6.1l-6.1,6.1
			c-0.9,0.9-0.9,2.3,0,3.2c0.4,0.4,1,0.7,1.6,0.7c0.6,0,1.2-0.2,1.6-0.7l6.1-6.1l6.1,6.1c0.4,0.4,1,0.7,1.6,0.7
			c0.6,0,1.2-0.2,1.6-0.7c0.9-0.9,0.9-2.3,0-3.2L35.2,32l6.1-6.1C42.1,25,42.1,23.6,41.2,22.7z"></path>
	</g>
	</svg>
					<!--?xml version="1.0" encoding="utf-8"?-->
	<!-- Generator: Adobe Illustrator 22.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
	<svg fill="#1C2033" width="52" height="52" version="1.1" id="lni_lni-alarm" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
	<path d="M57.6,53.1l-2-3.1c-0.4-0.6-0.6-1.2-0.6-1.9V27.3c0-5.9-2.5-11.4-7.1-15.5C44.2,8.5,39.4,6.4,34.3,6V4c0-1.2-1-2.3-2.3-2.3
		c-1.2,0-2.3,1-2.3,2.3v1.9c-0.2,0-0.4,0-0.6,0.1C17.5,7.3,8.8,16.6,8.8,27.7v20.4c-0.1,1-0.3,1.5-0.5,1.8l-1.9,3.2
		c-0.6,1-0.6,2.2,0,3.2c0.6,0.9,1.6,1.5,2.7,1.5h20.7V60c0,1.2,1,2.3,2.3,2.3c1.2,0,2.3-1,2.3-2.3v-2.2H55c1.1,0,2.1-0.6,2.7-1.5
		C58.3,55.3,58.3,54.1,57.6,53.1z M11.5,53.3l0.7-1.2c0.6-1,0.9-2.2,1.1-3.6l0-20.8c0-8.8,7-16.2,16.3-17.2
		c5.7-0.6,11.3,1.1,15.4,4.7c3.6,3.2,5.6,7.5,5.6,12.1v20.8c0,1.5,0.4,2.9,1.3,4.3l0.6,0.9H11.5z"></path>
	</svg>
				</div>
				An account is required to perform this action
			</div>

			<div class="a-btn alert-actions"><a class="ts-btn ts-btn-4" href="http://three-stays.test/auth/">Log-in</a><a class="ts-btn ts-btn-4" href="http://three-stays.test/auth/?register">Register</a>
				<a href="#" class="ts-btn ts-btn-4 close-alert">Close</a>
			</div>
		</div>

</div>