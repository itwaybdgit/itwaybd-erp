<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class MailConfigService
{
    public static function configure($settings)
    {
        if($settings['mailer'] && $settings['host'] && $settings['port'] && $settings['username'] && $settings['password']){
            $config = array(
                'driver'     => $settings['mailer'],
                'host'       => $settings['host'],
                'port'       => $settings['port'],
                'from'       => array('address' => $settings['from_address'], 'name' => $settings['from_name']),
                'encryption' => $settings['encryption'],
                'username'   => $settings['username'],
                'password'   => $settings['password'],
                'sendmail'   => '/usr/sbin/sendmail -bs',
                'pretend'    => false,
            );
            Config::set('mail', $config);
        }
    }
}
