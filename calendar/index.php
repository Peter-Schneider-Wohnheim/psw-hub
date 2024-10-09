<?php
include(dirname(__DIR__). '/includes/header.inc.php');
require_once(dirname(__DIR__). '/includes/config/config.php');
echo('<h2 class="h2 text-center mb-3">Event Calendar</h2>');

$id = EVENT_CALENDER_ID;
$event_calendar = <<<EVENTCALENDAR
<iframe style="height: 75vh; width: 100%;" src="https://cloud.psw-wuerzburg.de/index.php/apps/calendar/embed/$id/listMonth/now"></iframe>
<p class="mt-3">You can also subscribe to the calendar using this link: <a href="https://cloud.psw-wuerzburg.de/remote.php/dav/public-calendars/$id?export"/>https://cloud.psw-wuerzburg.de/remote.php/dav/public-calendars/$id?export</a></p>
EVENTCALENDAR;
echo($event_calendar);
include(dirname(__DIR__). '/includes/footer.inc.php');
