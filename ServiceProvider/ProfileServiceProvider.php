<?php

/*
 * This file is part of the Profile
 *
 * Copyright (C) 2017 kurozumi
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\Profile\ServiceProvider;

use Monolog\Handler\FingersCrossed\ErrorLevelActivationStrategy;
use Monolog\Handler\FingersCrossedHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Plugin\Profile\Form\Type\ProfileConfigType;
use Silex\Application as BaseApplication;
use Silex\ServiceProviderInterface;

class ProfileServiceProvider implements ServiceProviderInterface
{

    public function register(BaseApplication $app)
    {

        // Repository
        $app['eccube.plugin.profile.repository.profile'] = $app->share(function() use ($app) {
                return $app['orm.em']->getRepository('Plugin\Profile\Entity\Profile');
        });

        // ログファイル設定
        $app['monolog.logger.profile'] = $app->share(function ($app) {

            $logger = new $app['monolog.logger.class']('profile');

            $filename = $app['config']['root_dir'].'/app/log/profile.log';
            $RotateHandler = new RotatingFileHandler($filename, $app['config']['log']['max_files'], Logger::INFO);
            $RotateHandler->setFilenameFormat(
                'profile_{date}',
                'Y-m-d'
            );

            $logger->pushHandler(
                new FingersCrossedHandler(
                    $RotateHandler,
                    new ErrorLevelActivationStrategy(Logger::ERROR),
                    0,
                    true,
                    true,
                    Logger::INFO
                )
            );

            return $logger;
        });

    }

    public function boot(BaseApplication $app)
    {
    }

}
