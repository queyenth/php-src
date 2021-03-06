--TEST--
imap_savebody() errors: ValueError and Warnings
--SKIPIF--
<?php
require_once(__DIR__.'/setup/skipif.inc');
?>
--FILE--
<?php

require_once(__DIR__.'/setup/imap_include.inc');

$imap_mail_box = setup_test_mailbox("imapsavebodyerrors", 0);

$section = '';

try {
    imap_savebody($imap_mail_box, '', -1, $section);
} catch (\ValueError $e) {
    echo $e->getMessage() . \PHP_EOL;
}
try {
    imap_savebody($imap_mail_box, '', 1, $section, -1);
} catch (\ValueError $e) {
    echo $e->getMessage() . \PHP_EOL;
}

// Access not existing
var_dump(imap_savebody($imap_mail_box, '', 255, $section));
var_dump(imap_savebody($imap_mail_box, '', 255, $section, FT_UID));

imap_close($imap_mail_box);

?>
--CLEAN--
<?php
$mailbox_suffix = 'imapsavebodyerrors';
require_once(__DIR__ . '/setup/clean.inc');
?>
--EXPECTF--
Create a temporary mailbox and add 0 msgs
New mailbox created
imap_savebody(): Argument #3 ($message_num) must be greater than 0
imap_savebody(): Argument #5 ($flags) must be a bitmask of FT_UID, FT_PEEK, and FT_INTERNAL

Warning: imap_savebody(): Bad message number in %s on line %d
bool(false)

Warning: imap_savebody(): UID does not exist in %s on line %d
bool(false)
