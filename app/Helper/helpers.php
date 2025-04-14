<?php
function extendExecutionTime() {
    set_time_limit(120); // 2 minutes
    ini_set('max_execution_time', 120);
}
