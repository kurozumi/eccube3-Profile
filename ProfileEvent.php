<?php

/*
 * This file is part of the Profile
 *
 * Copyright (C) 2017 会員プロフィール
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\Profile;

use Eccube\Application;
use Eccube\Event\EventArgs;
use Eccube\Event\TemplateEvent;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;
use Plugin\Profile\Entity\Profile;
use Symfony\Component\Validator\Constraints as Assert;

class ProfileEvent
{

    /** @var  \Eccube\Application $app */
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function onAdminCustomerEditIndexInitialize(EventArgs $event)
    {
        $this->indexInitialize($event);
    }

    public function onAdminCustomerEditIndexComplete(EventArgs $event)
    {
        $this->indexComplete($event);
    }

    public function onFrontEntryIndexInitialize(EventArgs $event)
    {
        $this->indexInitialize($event);
    }

    public function onFrontEntryIndexComplete(EventArgs $event)
    {
        $this->indexComplete($event);
    }

    public function onFrontMypageChangeIndexInitialize(EventArgs $event)
    {
        $this->indexInitialize($event);
    }

    public function onFrontMypageChangeIndexComplete(EventArgs $event)
    {
        $this->indexComplete($event);
    }

    /**
     * フォームに項目追加
     * 
     * @param EventArgs $event
     */
    public function indexInitialize(EventArgs $event)
    {
        $Customer = $event->getArgument('Customer');

        // DBからデータ取得
        $Profile = $this->app['eccube.plugin.profile.repository.profile']->findOneBy(array('Customer' => $Customer));

        // データがなれけばエンティティインスタンス生成
        if (!$Profile) {
            $Profile = new Profile();
        }

        $builder = $event->getArgument('builder');
        // ここからフォーム項目追加
        $builder
                ->add('plg_nickname', 'text', array(
                    'required' => false, // 必須かどうか
                    'label' => 'ニックネーム', // 項目名
                    'mapped' => false,
                    'data' => $Profile->getNickname()
        ));
    }

    /**
     * DBに登録
     * 
     * @param EventArgs $event
     */
    public function indexComplete(EventArgs $event)
    {
        $Customer = $event->getArgument('Customer');

        // DBからデータ取得
        $Profile = $this->app['eccube.plugin.profile.repository.profile']->findOneBy(array("Customer" => $Customer));

        // データがなれけばエンティティインスタンス生成
        if (!$Profile) {
            $Profile = new Profile();
        }

        // エンティティを更新
        $form = $event->getArgument('form');
        $Profile
                ->setCustomer($Customer)
                // ここからDBに保存したい項目を追加
                ->setNickame($form['plg_nickname']->getData());

        // DB更新
        $this->app['orm.em']->persist($Profile);
        $this->app['orm.em']->flush($Profile);
    }

}
