<?php
/**
 * Created by PhpStorm.
 * User: tymek
 * Date: 25.03.19
 * Time: 19:52
 */

namespace App\EventSubscriber;


use App\User\Exception\UserNotFoundException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class UserExceptionSubscriber implements EventSubscriberInterface
{

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => [
                ['onException', 1]
            ]
        ];
    }

    public function onException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if($exception instanceof UserNotFoundException) {

            $response = new JsonResponse();
            $response->setStatusCode(JsonResponse::HTTP_BAD_REQUEST);
            $response->setData([
                'auth' => [
                    'success' => false
                ],
                'error_message' => $exception->getMessage()
            ]);

            $event->setResponse($response);
        }
    }
}
