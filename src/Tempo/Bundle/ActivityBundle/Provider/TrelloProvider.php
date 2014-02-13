<?php

/*
* This file is part of the Tempo-project package http://tempo.ikimea.com/>.
*
* (c) Mlanawo Mbechezi  <mlanawo.mbechezi@ikimea.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/


namespace Tempo\Bundle\ActivityBundle\Provider;

use Symfony\Component\HttpFoundation\Request;

class TrelloProvider  implements ProviderInterface
{
    /**
     * @var array
     */
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    protected function verifySignature(Request $request)
    {
        $callbackUrl = $request->getUri();
        $secret = $this->config['secret'];
        $content = $secret.$request->getContent().$callbackUrl;

        return base64_encode(hash_hmac('sha1', $content, $secret)) === $request->headers->get('X-Trello-Webhook');
    }

    /**
     * {inheritedDoc}
     */
    public function parse(Request $request)
    {
        if ($request->isMethod('HEAD')) {
            return false;
        }

        if (!$this->verifySignature($request)) {
            throw new \Exception('Signature verification failed');
        }

        $data = json_decode($request->getContent());

        $methodName = sprintf('%sEvent', $data->action->type);
        return $this->$methodName($data);
    }

    protected function commentCardEvent($data)
    {
        //TODO
    }

    /**
     * {inheritedDoc}
     */
    public function getName()
    {
        return 'Trello';
    }
}