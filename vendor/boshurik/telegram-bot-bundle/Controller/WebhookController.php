<?php
/**
 * User: boshurik
 * Date: 25.04.16
 * Time: 16:10
 */

namespace BoShurik\TelegramBotBundle\Controller;

use BoShurik\TelegramBotBundle\Event\Telegram\WebhookEvent;
use BoShurik\TelegramBotBundle\Event\TelegramEvents;
use HealthAdvisorBundle\Controller\BiennetreController;
use HealthAdvisorBundle\Entity\Conseillesante;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Doctrine\ORM\Mapping as ORM;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Types\Update;

class WebhookController extends Controller
{
    public function indexAction(Request $request)
    {
      if($request->get('action')=="Je veux un conseille de sante")
      {
          $tab = array();
          $conseilleSante = new Conseillesante();
          $conseilleSante = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Conseillesante')->findAll();
          foreach ($conseilleSante as $conseil)
          {
              $tab[mt_rand(0,2000)]=$conseil->getConseille();
          }
          $conseille = $tab;
          krsort($conseille);
          $serializer = new Serializer(array(new ObjectNormalizer()));
          $valeur = $serializer->normalize($conseille[array_keys($conseille)[0]]);
          return new JsonResponse($valeur);
      }
      else {
          $api = $this->container->get('bo_shurik_telegram_bot.api');
          $update = new Update();
          if ($data = BotApi::jsonValidate($request->getContent(), true)) {
              $update = Update::fromResponse($data);
              $this->getTelegram()->processUpdate($update);
          } else {
              throw new BadRequestHttpException('Empty data');
          }

          $event = $this->getEventDispatcher()->dispatch(
              TelegramEvents::WEBHOOK,
              new WebhookEvent($request, $update)
          );

          return $event->getResponse() ? $event->getResponse() : new Response();
      }
    }

    /**
     * @return \BoShurik\TelegramBotBundle\Telegram\Telegram
     */
    private function getTelegram()
    {
        return $this->get('bo_shurik_telegram_bot.telegram');
    }

    /**
     * @return object|\Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher
     */
    private function getEventDispatcher()
    {
        return $this->get('event_dispatcher');
    }
}