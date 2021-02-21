<?php

declare(strict_types=1);

// phpcs:disable Generic.Files.LineLength.MaxExceeded

return [

    // This is not valid IBAN, so it should fail in Mobile Bank app
    // AirBank complains, but Fio accepts it
    'bank_acc' => 'CZ7812340000000199488011',

    'flags' => [
        'default'   => 'fa-plus',

        'secondary' => 'fa-snowflake',
        'info'      => 'fa-lightbulb',
        'success'   => 'fa-thumbs-up',
        'warning'   => 'fa-bullhorn',
        'danger'    => 'fa-fire',
        'dark'      => 'fa-skull',
    ],

    'student' => [
        'minimum_age_term_starts' => 4,
        // Kolik dní před začátkem kurzu lze vytvářet přihlášky nebo upravovat přihlášky
        // 0 znamená první den kurzu, 8 je týden před (kurz začíná v pondělí, pak neděle týden před ještě jde)
        'login_before_start' => 8,
        'edit_before_start' => 8,
        // Kolik dní před koncem kurzu lze žáka odhlásit
        'logout_before_end' => 0,
    ],

    'admin_mail' => 'akademie@czechitas-app.cz',
];
