<?php
/**
 * Silex Maintenance extension.
 *
 * PHP version 5.3
 *
 * Copyright (c) 2011-2012 Shinya Ohyanagi, All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Shinya Ohyanagi nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @use       \Silex\Application
 * @use       \Silex\ServiceProviderInterface
 * @category  \Silex
 * @package   \Silex\ServiceProviderInterface
 * @version   $id$
 * @copyright (c) 2011 Masao Maeda
 * @copyright (c) 2011-2012 Shinya Ohyanagi
 * @author    Masao Maeda <brt.river@gmail.com>
 * @author    Shinya Ohyanagi <sohyanagi@gmail.com>
 * @license   New BSD License
 */

use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Maintenance extension.
 *
 * @use       \Silex\Application
 * @use       \Silex\ServiceProviderInterface
 * @category  \Silex
 * @package   \Silex\ServiceProviderInterface
 * @version   $id$
 * @copyright (c) 2011 Masao Maeda
 * @copyright (c) 2011-2012 Shinya Ohyanagi
 * @author    Masao Maeda <brt.river@gmail.com>
 * @author    Shinya Ohyanagi <sohyanagi@gmail.com>
 * @license   New BSD License
 */
class MaintenanceExtension implements ServiceProviderInterface
{
    /**
     * Version.
     */
    const VERSION = '0.0.2';

    /**
     * Register extension.
     *
     * @param  Application $app Application
     * @access public
     * @return void
     */
    public function register(Application $app)
    {
        if (isset($app['maintenance.lock'])
                && isset($app['maintenance.file'])
                && is_file($app['maintenance.lock'])) {

            $app->match('/{path}', function () use ($app) {
                if (isset($app['twig'])) {
                    $ext = pathinfo(
                        $app['maintenance.file'], PATHINFO_EXTENSION
                    );
                    if ($ext === 'twig') {
                        return $app['twig']->render($app['maintenance.file']);
                    }
                }
                $html = file_get_contents($app['maintenance.file']);
                return new Response($html);
            })->assert('path', '.*');
        }
    }
}
