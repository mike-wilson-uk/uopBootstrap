<?php

global $CFG, $DB, $COURSE, $USER;

$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));
$hasheader = (empty($PAGE->layout_options['noheader']));

$hassidepre = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-pre', $OUTPUT));
$hassidepost = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-post', $OUTPUT));

$showsidepre = ($hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT));
$showsidepost = ($hassidepost && !$PAGE->blocks->region_completely_docked('side-post', $OUTPUT));

// TODO: Fix when docking fixed.
//$showsidepre = $hassidepre;
//$showsidepost = $hassidepost;

$haslogo = (!empty($PAGE->theme->settings->logo_url));
$custommenu = $OUTPUT->custom_menu();
$menu = $CFG->custommenuitems;

$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));

$courseheader = $coursecontentheader = $coursecontentfooter = $coursefooter = '';

if (empty($PAGE->layout_options['nocourseheaderfooter'])) {
    $courseheader = $OUTPUT->course_header();
    $coursecontentheader = $OUTPUT->course_content_header();
    if (empty($PAGE->layout_options['nocoursefooter'])) {
        $coursecontentfooter = $OUTPUT->course_content_footer();
        $coursefooter = $OUTPUT->course_footer();
    }
}

$layout = 'pre-and-post';
if ($showsidepre && !$showsidepost) {
    if (!right_to_left()) {
        $layout = 'side-pre-only';
    } else {
        $layout = 'side-post-only';
    }
} else if ($showsidepost && !$showsidepre) {
    if (!right_to_left()) {
        $layout = 'side-post-only';
    } else {
        $layout = 'side-pre-only';
    }
} else if (!$showsidepost && !$showsidepre) {
    $layout = 'content-only';
}
$bodyclasses[] = $layout;

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $PAGE->title ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join($bodyclasses)) ?>">

<?php echo $OUTPUT->standard_top_of_body_html() ?>

<header role="banner" class="navbar navbar-fixed-top">
    <nav role="navigation" class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="nav-collapse collapse">
            <?php if ($hascustommenu) {
				  echo $custommenu;
            }  ?>
			<?php echo $PAGE->headingmenu ?>
			<?php echo $OUTPUT->login_info() ?>
			
			<?php
					//Get current date and time, format and store as $date - will adjust automatically for day light savings time
					date_default_timezone_set('Europe/London');
					$time = time(); 
					$date = date('D jS M',$time);
					
					//Find number of users who have accessed Moodle in the last 10 minutes
					$fiveminutesago = time() - 300;
					$now = time();
					$onlineusersnow = $DB->count_records_sql("SELECT count(id) FROM {user} WHERE username != 'guest' and lastaccess between $fiveminutesago and $now"); 
			?>
			<div class='dateUsers'>Online Users (<?php echo $onlineusersnow; ?>)</div>
			<div class='dateUsers'><?php echo $date; ?></div>
            <ul class="nav pull-right">
            <li></li>
            <li class="navbar-text"></li>
            </ul>
            </div>
        </div>
    </nav>
</header>

<div id="page" class="container-fluid">

<?php if ($hasheader) { ?>
<header id="page-header" class="clearfix">
    <?php
        if (!$haslogo) { ?>

            <?php
        } else { ?>

             <h1><?php echo $PAGE->heading ?></h1>
            <?php
        } ?>
    <?php if ($hasnavbar) { 
		$course_title = "<div id='courseTitle'>$COURSE->fullname :</div>";
		?>
        <nav class="breadcrumb-button"><?php echo $PAGE->button; ?></nav>
        <?php 
				echo $course_title.$OUTPUT->navbar(); 
		?>
    <?php } ?>

    <?php if (!empty($courseheader)) { ?>
        <div id="course-header"><?php echo $courseheader; ?></div>
    <?php } ?>
</header>
<?php } ?>

<div id="page-content" class="row-fluid">

<?php if ($layout === 'pre-and-post') { ?>
    <div id="region-bs-main-and-pre" class="span9">
    <div class="row-fluid">
    <section id="region-main" class="span8 pull-right">
<?php } else if ($layout === 'side-post-only') { ?>
    <section id="region-main" class="span9">
<?php } else if ($layout === 'side-pre-only') { ?>
    <section id="region-main" class="span9 pull-right">
<?php } else if ($layout === 'content-only') { ?>
    <section id="region-main" class="span12">
<?php } ?>


    <?php echo $coursecontentheader; ?>
    <?php echo $OUTPUT->main_content() ?>
	<?php echo $coursecontentfooter; ?>
    </section>


<?php if ($layout !== 'content-only') { 
          if ($layout !== 'side-post-only') {
              if ($layout === 'pre-and-post') { ?>
                <aside class="span4 desktop-first-column">
        <?php } else if ($layout === 'side-pre-only') { ?>
                <aside class="span3 desktop-first-column">
        <?php } ?>
              <div id="region-pre" class="block-region">
              <div class="region-content">
              <?php
                    if (!right_to_left()) {
                        echo $OUTPUT->blocks_for_region('side-pre');
                    } else if ($hassidepost) {
                        echo $OUTPUT->blocks_for_region('side-post');
                    } ?>
              </div>
              </div>
              </aside>
        <?php if ($layout === 'pre-and-post') {
              ?></div></div><?php // Close row-fluid and span9.
        }
    }

    if ($layout === 'side-post-only' OR $layout === 'pre-and-post') { ?>
        <aside id="region-post" class="span3 block-region region-content">
        <?php if (!right_to_left()) {
                  echo $OUTPUT->blocks_for_region('side-post');
              } else {
                  echo $OUTPUT->blocks_for_region('side-pre');
              } ?>
        </aside>
    <?php } ?>
<?php } ?>
</div>

<?php echo $OUTPUT->standard_end_of_body_html() ?>

</div>
    <div class="helplink">
	<?php echo page_doc_link(get_string('moodledocslink')) ?>
    <?php echo $OUTPUT->standard_footer_html(); ?>
	</div>
<footer id="page-footer">
		<div id='siteLinks'>
			<div id='siteLinksWrapper'>
				<div id='siteLinksLeft'>
				<div id='siteLinksTitle'><a href='<?php $CFG->wwwroot; ?>'>Home</a></div>
					<div class='siteLinksSub'>
						<?php 
								$menu_item = explode('&nbsp;',$menu);
								
								$i = 0;
								$menu_items_sub = explode('-',$menu_item[1]);
								
								foreach($menu_items_sub as &$menu_items_subs){
								$menu_items_subs = explode('|',$menu_items_sub[$i]);
								${'menu_items_sub'.$i} = $menu_items_subs;
									if ($i > 0){
											$custMenuName = ${'menu_items_sub'.$i}[0];
											$custMenuURL = ${'menu_items_sub'.$i}[1];
											echo "<div class='siteItem'><a href='$custMenuURL'>$custMenuName</a></div>";
									}
									if ($i == 0){
											$custMenuName = ${'menu_items_sub'.$i}[0];
											echo "<div class='siteItemTitle'>$custMenuName</div>";
									}
								$i++;
								}
								echo '</div>';
						?>	
						<?php
						echo "<div class='siteLinksSub' id='siteLinksSubBorder'>";
								
								$c = 0;
								$menu_items2_sub = explode('-',$menu_item[2]);
								
								foreach($menu_items2_sub as &$menu_items2_subs){
								$menu_items2_subs = explode('|',$menu_items2_sub[$c]);
								${'menu_items2_sub'.$c} = $menu_items2_subs;
									if ($c > 0){
											$custMenuName2 = ${'menu_items2_sub'.$c}[0];
											$custMenuURL2 = ${'menu_items2_sub'.$c}[1];
											echo "<div class='siteItem'><a href='$custMenuURL2'>$custMenuName2</a></div>";
									}
									if ($c == 0){
											$custMenuName2 = ${'menu_items2_sub'.$c}[0];
											echo "<div class='siteItemTitle'>$custMenuName2</div>";
									}
								$c++;
								}
						
						?>
					</div>
				</div>
				<div id='siteLinksRight'>
				<div id='siteLinksTitle'>&nbsp;</div>
					<div class='siteLinksSub'>
						<div class='siteItemTitle'>Connect with us</div>
						<div class='siteItem'><a href='http://www.facebook.com/universityofportsmouth'><img id='socialIcons' src="<?php echo $OUTPUT->pix_url('fp/facebookIcon', 'theme'); ?>" alt="" />Facebook</a></div>
						<div class='siteItem'><a href='http://twitter.com/portsmouthuni'><img id='socialIcons' src="<?php echo $OUTPUT->pix_url('fp/twitterIcon', 'theme'); ?>" alt="" />Twitter</a></div>
						<div class='siteItem'><a href='http://www.youtube.com/user/uniofportsmouth'><img id='socialIcons' src="<?php echo $OUTPUT->pix_url('fp/youtubeIcon', 'theme'); ?>" alt="" />YouTube</a></div>
						<div class='siteItem'><a href='http://www.port.ac.uk/whatisrss'><img id='socialIcons' src="<?php echo $OUTPUT->pix_url('fp/rssIcon', 'theme'); ?>" alt="" />UoP News</a></div>
					</div>			
	
					<div class='siteLinksSub'>
						<div class='siteItemTitle'>Contact us</div>
						<div class='siteItem'>E: <a href='mailto:elearn@port.ac.uk'>elearn@port.ac.uk</a></div>
						<div class='siteItem'>T: 023 9284 3355</div>
						<div class='siteItem' id='footerLogo'><a href='http://www.port.ac.uk'><img src="<?php echo $OUTPUT->pix_url('fp/uopLogoWBG', 'theme'); ?>" /></a></div>
					</div>			
				</div>	
		</div>
		</div>
		<div id='bottomLinks'>
			<div id='bottomLinksWrapper'>
				<div id='bottomLinksLeft'><div class='bottomItem'>Accessibility</div>
				<div class='bottomItem'>Disclaimer</div><div class='bottomItem'>Feedback</div><div class='bottomItem'>Privacy</div><div class='bottomItem'>Site map</div></div>
				<div id='bottomLinksRight'>Copyright 2013 - University of Portsmouth</div>			
			</div>	
		</div>
</footer>
<?php if (!empty($PAGE->theme->settings->enablejquery)) {?>

<script src="<?php echo $CFG->wwwroot;?>/theme/bootstrap/javascript/jquery.js"></script>
<script src="<?php echo $CFG->wwwroot;?>/theme/bootstrap/javascript/bootstrap.min.js"></script>

<?php }?>

</body>
</html>
