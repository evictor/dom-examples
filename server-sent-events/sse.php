<?php
date_default_timezone_set("America/New_York");
header("Content-Type: text/event-stream");

// While connection not aborted, send a message randomly with 10% (0.1) probability
for(
  $pctChanceSendMsg = 0.1;
  !connection_aborted();
  $shouldSendMsg = rand() < $pctChanceSendMsg
) {
  $curDate = date(DATE_ISO8601);
  echo "event: ping\n",
       'data: {"time": "' . $curDate . '"}', "\n\n";

  if ($shouldSendMsg) {
    echo 'data: This is a message at time ' . $curDate, "\n\n";
  }

  // flush the output buffer and send echoed messages to the browser
  while (ob_get_level() > 0) {
    ob_end_flush();
  }
  flush();

  // sleep for 1 second before running the loop again  
  sleep(1);
}
