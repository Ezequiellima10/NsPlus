<?php
require_once('../../config.php');
require_once('lib.php');

$id = required_param('id', PARAM_INT); // course_module ID, or
$n  = optional_param('n', 0, PARAM_INT);  // helloworld instance ID

if ($id) {
    $cm         = get_coursemodule_from_id('helloworld', $id, 0, false, MUST_EXIST);
    $course     = get_course($cm->course);
    $helloworld  = $DB->get_record('helloworld', array('id' => $cm->instance), '*', MUST_EXIST);
} elseif ($n) {
    $helloworld  = $DB->get_record('helloworld', array('id' => $n), '*', MUST_EXIST);
    $course     = get_course($helloworld->course);
    $cm         = get_coursemodule_from_instance('helloworld', $helloworld->id, $course->id, false, MUST_EXIST);
} else {
    print_error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);

$PAGE->set_url('/mod/helloworld/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($helloworld->name));
$PAGE->set_heading(format_string($course->fullname));

// Encolar los archivos CSS y JS necesarios
$PAGE->requires->css('/mod/helloworld/ns/css/XNSDiagram.css');
$PAGE->requires->js('/mod/helloworld/ns/js/XNS-core/html2canvas.js');
$PAGE->requires->js('/mod/helloworld/js/XNS-core/Enumeration.js');
$PAGE->requires->js('/mod/helloworld/js/XNS-core/ClassConstructor.js');
$PAGE->requires->js('/mod/helloworld/js/XNS-core/BaseDiagram.js');
$PAGE->requires->js('/mod/helloworld/js/XNS-core/DiagramObject.js');
$PAGE->requires->js('/mod/helloworld/js/XNS-core/XNSDiagram.js');

//echo $OUTPUT->header();
echo $OUTPUT->header();
echo $OUTPUT->heading('<iframe src="ns/index.html" width="100%" height="800px"></iframe>');
echo $OUTPUT->footer();


// Incluir el contenido de documentation.html
include('ns/documentation.html');


echo $OUTPUT->footer();
