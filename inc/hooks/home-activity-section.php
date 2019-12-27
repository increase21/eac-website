<?php
if (!function_exists('charitize_activity_array')) :
    /**
     * Activity array creation.
     *
     * @since Charitize 1.0.0
     *
     * @param string $from_activity
     *
     * @return array
     */
    function charitize_activity_array($from_activity)
    {
        global $charitize_customizer_all_values;
        $charitize_activities_number = absint($charitize_customizer_all_values['charitize-activities-number']);
        $charitize_activities_single_words = absint($charitize_customizer_all_values['charitize-activities-word-count']);
        $charitize_activity_section_default_args = array(
            'post_type' => 'page',
            'posts_per_page' => 1,
            'orderby' => 'post__in',
        );
        $charitize_activity_section_default_post_query = new WP_Query($charitize_activity_section_default_args);
        while ($charitize_activity_section_default_post_query->have_posts()) : $charitize_activity_section_default_post_query->the_post();
        $charitize_activities_contents_array[0]['charitize-activities-title'] = get_the_title();
        $charitize_activities_contents_array[0]['charitize-activities-content'] = charitize_words_count($charitize_activities_single_words, get_the_content());
        $charitize_activities_contents_array[0]['charitize-activities-link'] = get_the_permalink();
        $charitize_activities_contents_array[0]['charitize-activities-image'] = get_the_post_thumbnail();
        endwhile;
        $repeated_page = array('charitize-activities-pages-ids');
        $charitize_activities_args = array();

        if ('from-category' == $from_activity) {
            $charitize_activities_category = $charitize_customizer_all_values['charitize-activities-category'];
            if (0 != $charitize_activities_category) {
                $charitize_activities_args = array(
                    'post_type' => 'post',
                    'cat' => $charitize_activities_category,
                    'ignore_sticky_posts' => true,
                );
            }
        } else {
            $charitize_activities_posts = evision_customizer_get_repeated_all_value(8, $repeated_page);
            $charitize_activities_posts_ids = array();
            if (null != $charitize_activities_posts) {
                foreach ($charitize_activities_posts as $charitize_activities_post) {
                    if (0 != $charitize_activities_post['charitize-activities-pages-ids']) {
                        $charitize_feature_section_posts_ids[] = $charitize_activities_post['charitize-activities-pages-ids'];
                    }
                }

                if (!empty($charitize_feature_section_posts_ids)) {
                    $charitize_activities_args = array(
                        'post_type' => 'page',
                        'post__in' => $charitize_feature_section_posts_ids,
                        'posts_per_page' => $charitize_activities_number,
                        'orderby' => 'post__in',
                    );
                }
            }
        }
        if (!empty($charitize_activities_args)) {
            // the query
            $charitize_activities_post_query = new WP_Query($charitize_activities_args);

            if ($charitize_activities_post_query->have_posts()) :
                $i = 0;
            while ($charitize_activities_post_query->have_posts()) : $charitize_activities_post_query->the_post();
            $url = '';
            if (has_post_thumbnail()) {
                $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'charitize-home-activities-image');
                $url = $thumb['0'];
            }
            $charitize_activities_contents_array[$i]['charitize-activities-title'] = get_the_title();
            $charitize_activities_contents_array[$i]['charitize-activities-content'] = charitize_words_count($charitize_activities_single_words, get_the_content());
            $charitize_activities_contents_array[$i]['charitize-activities-link'] = get_permalink();
            $charitize_activities_contents_array[$i]['charitize-activities-image'] = $url;
            ++$i;
            endwhile;
            wp_reset_postdata();
            endif;
        }

        return $charitize_activities_contents_array;
    }
endif;

if (!function_exists('charitize_activities_slider')) :
    /**
     * Featured Slider.
     *
     * @since Charitize 1.0.0
     *
     * @param null
     *
     * @return null
     */
    function charitize_activities_slider()
    {
        global $charitize_customizer_all_values;

        if (1 != $charitize_customizer_all_values['charitize-activities-enable']) {
            return null;
        }
        $charitize_activities_selection_options = $charitize_customizer_all_values['charitize-activities-selection'];
        $charitize_activities_slider_arrays = charitize_activity_array($charitize_activities_selection_options);

        if (is_array($charitize_activities_slider_arrays)) {
            $charitize_activities_number = absint($charitize_customizer_all_values['charitize-activities-number']); ?>
<section class="_segment">
         <div class="container">
            <section id="wrapper-activity" class="wrapper wrapper-activity">
            <div class="container">
                  <div class="row">
                  <div class="_heading _color">
                     <div class="_circle"></div>
                  <p class="_title">we are eac initiative</p>
                  </div>
                        <div class="col-sm-6">
                           <p class="_title">Our Vision</p>
                           <p>A society where every adolescent makes an informed decision as a result of their primary education qualification, regardless of their inadequate background or situation. </p>
                  
                           <p class="_title">Our Mission</p>
                           <p> To enroll, support and enable every child to complete primary education.</p>
                        </div>
                        <div class="col-sm-6">
                           <p class="_title">Our Goals</p>
                           <ul style="margin:0; padding:0 20px">
                              <li>To educate parents & guardians on the need for primary education</li>
                              <li>To provide support for children so they can attend school and learn.</li>
                              <li>To ensure children enroll and stay in school</li>
                              <li>To provide psycho-social assistance for the (children) victims of terrorism and natural disaster.</li>
                              <li>To provide a school for children who aren't enrolled because a school is not available.</li>
                           </ul>
                        </div>
                     </div>
               </div>
                <div class="carousel-group">
                    <?php
                    $i = 1;
            foreach ($charitize_activities_slider_arrays as $charitize_activities_slider_array) {
                if ($charitize_activities_number < $i) {
                    break;
                }
                if (empty($charitize_activities_slider_array['charitize-activities-image'])) {
                    $charitize_feature_slider_image = ''; //get_template_directory_uri().'/assets/img/activity.png';
                } else {
                    $charitize_feature_slider_image = $charitize_activities_slider_array['charitize-activities-image'];
                } ?>
                            <div class="carousel-item singlethumb pad0lr">
                                <a href="<?php echo esc_url($charitize_activities_slider_array['charitize-activities-link']); ?>">

                                    <div class="thumb-holder">
                                        <img class="<?php
                                        if (1 == $charitize_customizer_all_values['charitize-activities-thumbnail-color-enable']) {
                                            echo 'desaturate';
                                        } ?>" src="<?php echo esc_url($charitize_feature_slider_image); ?>">
                                    </div>
                                    <div class="content-area">
                                        <h2><?php echo esc_html($charitize_activities_slider_array['charitize-activities-title']); ?></h2>
                                        <span class="divider"></span>
                                        <div class="content-text">
                                            <?php echo wp_kses_post($charitize_activities_slider_array['charitize-activities-content']); ?>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php
                    ++$i;
            } ?>
                </div>
                </div>
               <section class="_segment _color">
                  <div class="container">
                     <div class="row">
                        <!-- <div class="_heading _nocolor">
                        <div class="_circle"></div>
                        <p class="_title">Stay at home children</p>
                     </div> -->
                     <div class="col-md-7">
                     <div>
                              <img style="width:100%; height:100%" src="<?php echo get_template_directory_uri(); ?>/assets/img/at-home.jpg" />
                           </div>
                        </div>
                        <div class="col-md-5 _desc">
                        <p class="_title">Children At home</p>
                             <p class="">There are quite alot of struggling parents whom have their children at home with them while their peers are enrolled and go to school. Often times, these parents & guardians have no idea the damage of their decisions. </p>
                        </div>
                     </div>
                  </div>
               </section>
               <!-- <section class="_segment">
                  <div class="container">
                     <div class="row">
                        <div class="_heading _color">
                        <div class="_circle"></div>
                        <p class="_title">Children not going to school begging for almin</p>
                     </div>
                        <div class="col-md-5 _desc">
                        <p class="_title">Street Begging</p>
                             <p>Every day increase in population with out some level of education has turned people including children to even go around begging for survival</p>
                        </div>
                        <div class="col-md-7">
                           <div>
                              <img style="width:100%; height:100%" src="<?php echo get_template_directory_uri(); ?>/assets/img/foodie.jpg" />
                           </div>
                        </div>
                     </div>
                  </div>
               </section> -->
               <section class="_segment">
                  <div class="container">
                     <div class="row">
                        <!-- <div class="_heading _nocolor">
                        <div class="_circle"></div>
                        <p class="_title">Children used as child labour</p>
                     </div> -->
                     <div class="col-md-7">
                           <div>
                           <img style="width:100%; height:100%" src="<?php echo get_template_directory_uri(); ?>/assets/img/agric.jpg" />
                           </div>
                        </div>
                        <div class="col-md-5 _desc" style="padding: 1rem">
                        <p class="_title">Child Labour</p>
                             <p class="">Over 43% of Nigerian Children from 5 years old and above are being used as labourers mostly in private establishments & homes (ILO). 
Many of these children are often deprived of the opportunity to be in school because their parents or guardians would rather prefer them on the farmland to help.</p>
                        </div>
                     </div>
                  </div>
               </section>

                <section class="_segment _color">
                  <div class="container">
                     <div class="row" style="align-items:center">
                        <!-- <div class="_heading _color">
                           <div class="_circle"></div>
                           <p class="_title">Building A Literate Society</p>
                        </div> -->
                        <div class="col-md-6 _desc">
                        <p class="_title">Building A Literate Society</p>
                           <p class="">Our goal is to build a society where literacy is not only for those that have money, but for every individual in the society. </p>
                        </div>
                        <div class="col-md-6">
                           <img style="width:100%; height:100%" src="<?php echo get_template_directory_uri(); ?>/assets/img/happy-life.jpg" />
                        </div>
                     </div>
                  </div>
               </section>

              <section class="_segment">
                  <div class="container">
                     <div class="row">
                     <div class="_heading _color">
                        <div class="_circle"></div>
                        <p class="_title"> EAC INITIATIVE OUTREACH</p>
                     </div>
                        <div class="col-lg-6 gallery-div">
                           <img  src="<?php echo get_template_directory_uri(); ?>/assets/img/visit4.jpg" />
                           <img  src="<?php echo get_template_directory_uri(); ?>/assets/img/visit1.jpg" />
                        </div>
                        <!-- <div class="col-sm-4">
                        </div> -->
                        <div class="col-lg-6 gallery-div">
                           <img   src="<?php echo get_template_directory_uri(); ?>/assets/img/visit5.jpg" />
                           <img  src="<?php echo get_template_directory_uri(); ?>/assets/img/visit3.jpg" />
                        </div>
                     </div>
                  </div>
               </section>

                    <?php
                    $the_query = new WP_Query('posts_per_page=3');
            if ($the_query->have_posts()):  ?>
                     <section class="_segment">
                        <div class="container">
                           <div class="row">
                              <div class="_heading _color">
                        <div class="_circle"></div>
                        <p class="_title">Latest From Our Blog</p>
                     </div>
                           <?php
            while ($the_query->have_posts()) :
                                    $the_query->the_post(); ?>
                              <div class="col-sm-4">
                                 <p>
                                    <a class="blog_link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                 </p>
                              <?php the_excerpt(__('(more…)')); ?>
                              </div>
                              <?php
                              endwhile;
            wp_reset_postdata();
            endif; ?>
                        </div>
         </div>
                        </section>
                  </div>
                </div>
                <div>
            </section>
        <?php
        }
    }
endif;
add_action('charitize_action_front_page', 'charitize_activities_slider', 20);
