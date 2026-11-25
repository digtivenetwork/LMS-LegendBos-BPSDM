<?php
// This file is part of Moodle - https://moodle.org/

defined('MOODLE_INTERNAL') || die();

// No output hooks are registered. Non-admin users keep access to /my/, but
// the Dashboard navigation entry is hidden through theme CSS.
$callbacks = [];
