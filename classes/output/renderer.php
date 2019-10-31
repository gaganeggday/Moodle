<?php
/**
 * Created by PhpStorm.
 * User: ishineguy
 * Date: 2018/06/26
 * Time: 13:16
 */

namespace block_newblock\output;

use \block_newblock\constants;

require_once($CFG->dirroot.'/calendar/lib.php');

class renderer extends \plugin_renderer_base {

  

  public function fake_block_threemonths(calendar_information $calendar) {
    // Get the calendar type we are using.
    
    $calendartype = \core_calendar\type_factory::get_calendar_instance();
    $time = $calendartype->timestamp_to_date_array($calendar->time);
    $current = $calendar->time;
    $prevmonthyear = $calendartype->get_prev_month($time['year'], $time['mon']);
    $prev = $calendartype->convert_to_timestamp(
            $prevmonthyear[1],
            $prevmonthyear[0],
            1
        );
    $nextmonthyear = $calendartype->get_next_month($time['year'], $time['mon']);
    $next = $calendartype->convert_to_timestamp(
            $nextmonthyear[1],
            $nextmonthyear[0],
            1
        );
    $content = '';
    // Previous.
    $calendar->set_time($prev);
    list($previousmonth, ) = calendar_get_view($calendar, 'minithree', false, true);
    // Current month.
    $calendar->set_time($current);
    list($currentmonth, ) = calendar_get_view($calendar, 'minithree', false, true);
    // Next month.
    $calendar->set_time($next);
    list($nextmonth, ) = calendar_get_view($calendar, 'minithree', false, true);
    // Reset the time back.
    $calendar->set_time($current);
    $data = (object) [
        'previousmonth' => $previousmonth,
        'currentmonth' => $currentmonth,
        'nextmonth' => $nextmonth,
    ];
    $template = 'core_calendar/calendar_threemonth';
    $content .= $this->render_from_template($template, $data);
    

    //a page must have a header
    echo $this->output->header();
    //and of course our page content
    echo $content;
    //a page must have a footer
    echo $this->output->footer();

    return $content;

}
















  /*
    //In this function we prepare and display the content that goes in the block
    function fetch_block_content($blockid, $localconfig, $courseid){
        global $USER;


        //show our intro text
        //$content = file_get_contents("map.html");
        $content = '<html>Test content</html>';

        //$content .= '<br />' . get_string('welcomeuser', constants::M_COMP,$USER) . '<br />';

        //show "qtpi_map"  from our settings
       // $content .= '<br />' . $localconfig->qtpi_map . '<br />';

        //show our link to the view page
        //$link = new \moodle_url(constants::M_URL . '/view.php',array('blockid'=>$blockid,'courseid'=>$courseid));
       // $content .= \html_writer::link($link, get_string('gotoviewpage', constants::M_COMP));
        return $content;
    }

    //In this function we prepare and display the content for the page
    function display_view_page($blockid, $courseid){
      require_once($CFG->dirroot.'/calendar/lib.php');
        global $USER;

        $content = '';
        //$content .= '<p>view.php</p>';
        // . get_string('welcomeuser', constants::M_COMP,$USER) . '<br />';
        //$content .= $this->fetch_dosomething_button($blockid,$courseid);
        //$content .= $this->fetch_triggeralert_button();

        //a page must have a header
        echo $this->output->header();
        //and of course our page content
        echo $content;
        //a page must have a footer
        echo $this->output->footer();

    }

    /*function fetch_dosomething_button($blockid, $courseid){
        //single button is a Moodle helper class that creates simple form with a single button for you
        $triggerbutton = new \single_button(
            new \moodle_url(constants::M_URL . '/view.php',array('blockid'=>$blockid,'courseid'=>$courseid,'dosomething'=>1)),
            get_string('dosomething', constants::M_COMP), 'get');

        return \html_writer::div( $this->render($triggerbutton),constants::M_COMP . '_triggerbutton');
    }
    function fetch_triggeralert_button(){
        //these are attributes for a simple html button.
        $attributes = array();
        $attributes['type']='button';
        $attributes['id']= \html_writer::random_id(constants::M_COMP . '_');
        $attributes['class']=constants::M_COMP . '_triggerbutton';
        $button = \html_writer::tag('button',get_string('triggeralert', constants::M_COMP),$attributes);

        //we attach an event to it. The event comes from a JS AMD module also in this plugin
        $opts=array('buttonid' => $attributes['id']);
        $this->page->requires->js_call_amd(constants::M_COMP . "/triggeralert", 'init', array($opts));

        //we want to make our language strings available to our JS button too
        //strings for JS
        $this->page->requires->strings_for_js(array(
            'triggeralert_message'
        ),
            constants::M_COMP);

        //finally return our button for display
        return $button;
    }*/
}
//qtpi 45.112.20.146