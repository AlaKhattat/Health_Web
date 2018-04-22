<?php

namespace HealthAdvisorBundle\Controller;

use HealthAdvisorBundle\Entity\Commande;
use HealthAdvisorBundle\Entity\LigneCommande;
use HealthAdvisorBundle\Entity\Orders;
use JMS\Payment\CoreBundle\Form\ChoosePaymentMethodType;
use JMS\Payment\CoreBundle\Plugin\Exception\Action\VisitUrl;
use JMS\Payment\CoreBundle\Plugin\Exception\ActionRequiredException;
use JMS\Payment\CoreBundle\PluginController\Result;
use JMS\Serializer\Tests\Fixtures\Order;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class OrderController extends Controller
{
    public function newAction($amount)
    {
        $em = $this->getDoctrine()->getManager();

        $order = new Orders($amount);
        $em->persist($order);
        $em->flush();

        return $this->redirect($this->generateUrl('show', [
            'id' => $order->getId(),
        ]));
    }

    public function showAction(Request $request,Orders $order)
    {
        $config = [
            'paypal_express_checkout' => [
                'return_url' => $this->generateUrl('paymentCreate', [
                    'id' => $order->getId(),
                ], UrlGeneratorInterface::ABSOLUTE_URL),
                'cancel_url' => $this->generateUrl('paymentComplete', [
                    'id' => $order->getId(),
                ], UrlGeneratorInterface::ABSOLUTE_URL),
                'useraction' => 'commit',
            ],
        ];



        $form = $this->createForm(ChoosePaymentMethodType::class, null, [
            'amount'   => $order->getAmount(),
            'currency' => 'USD',
            'predefined_data' => $config,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ppc = $this->get('payment.plugin_controller');
            $ppc->createPaymentInstruction($instruction = $form->getData());

            $order->setPaymentInstruction($instruction);

            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush($order);

            return $this->redirect($this->generateUrl('paymentCreate', [
                'id' => $order->getId(),
            ]));
        }

        return $this->render(':payements:ShowAmount.html.twig',array('form'=>$form->createView(),'order'=>$order));

    }

    private function createPayment($order)
    {
        $instruction = $order->getPaymentInstruction();
        $pendingTransaction = $instruction->getPendingTransaction();

        if ($pendingTransaction !== null) {
            return $pendingTransaction->getPayment();
        }

        $ppc = $this->get('payment.plugin_controller');
        $amount = $instruction->getAmount() - $instruction->getDepositedAmount();

        return $ppc->createPayment($instruction->getId(), $amount);
    }

    public function paymentCreateAction(Orders $order)
    {
        $payment = $this->createPayment($order);

        $ppc = $this->get('payment.plugin_controller');
        $result = $ppc->approveAndDeposit($payment->getId(), $payment->getTargetAmount());

        if ($result->getStatus() === Result::STATUS_SUCCESS) {
            return $this->redirect($this->generateUrl('paymentComplete', [
                'id' => $order->getId(),
            ]));
        }
        if ($result->getStatus() === Result::STATUS_PENDING) {
            $ex = $result->getPluginException();

            if ($ex instanceof ActionRequiredException) {
                $action = $ex->getAction();

                if ($action instanceof VisitUrl) {
                    return $this->redirect($action->getUrl());
                }
            }
        }


        throw $result->getPluginException();

        // In a real-world application you wouldn't throw the exception. You would,
        // for example, redirect to the showAction with a flash message informing
        // the user that the payment was not successful.
    }

    public function paymentCompleteAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $panier = $this->get('session')->get('panier');

        var_dump($panier);

                $key = array_keys($panier);
                var_dump($key);
                for ($i = 0; $i < count($key); $i++) {
                    $commande = new Commande();
                    $ligne_commande = new LigneCommande();
                    var_dump("i  ".$i);
                    $id_produit = $key[$i];
                    var_dump("idproduit ".$id_produit);
                    $em = $this->getDoctrine()->getManager();
                    $produit = $em->getRepository('HealthAdvisorBundle:Produit')->find($id_produit);

                    $ref_cmd=rand(1,100000);
                    var_dump($ref_cmd);
                    $date_cmd = date_create_from_format('Y-m-d', date('Y-m-d'));
                    $commande->setReferenceCommande($ref_cmd);
                    $commande->setDatePayement($date_cmd);
                    $commande->setModePayement("PayPal");
                    $commande->setIdClient($user->getId());
                    $em->persist($commande);
                    $em->flush();
                    $cmd = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Commande')->findOneBy(['referenceCommande' => $commande->getReferenceCommande()]);
                    var_dump($cmd->getNumeroCommande());

                    $ligne_commande->setIdProduit($produit);
                    $ligne_commande->setIdCommande($cmd);
                    $ligne_commande->setQuantite($panier[$key[$i]]);
                    var_dump($panier[$key[$i]]);
                    $prix_av = $panier[$key[$i]] * $produit->getPrixVente();
                    $prom = ($panier[$key[$i]] * $produit->getPrixVente() * $produit->getPromotion()) / 100;
                    $ligne_commande->setPrix($prix_av - $prom);
                    $em->persist($ligne_commande);
                    $em->flush();


                        $produit->setQuantite($produit->getQuantite() - $panier[$key[$i]]);
                        var_dump($produit->getQuantite());
                        var_dump($produit->getQuantite() - $panier[$key[$i]]);
                        $em->persist($produit);
                        $em->flush();

                    $message = (new \Swift_Message('Réclamation résolue'))
                        ->setFrom('healthadvisoresprit@gmail.com')
                        ->setTo('habib.hentati@esprit.tn')
                        ->setBody(
                           "jawék béhi"
                        );

                    $this->get('mailer')->send($message);


                }


            $this->get('session')->clear();

            return $this->render("payements/payement_complet.html.twig");
        }


}
