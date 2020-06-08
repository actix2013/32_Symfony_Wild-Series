<?php


namespace App\Service;

use App\Entity\User;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class Mailer
 *
 * @package App\Service
 */
class Mailer
{
    protected $mailer;
    protected $templating;
    private $from = "no-reply@example.fr";
    private $reply = "contact@example.fr";
    private $name = "Equipe Acme Blog";

    public function __construct($mailer, EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    /**
     * @param $to
     * @param $subject
     * @param $body
     */
    protected function sendMessage($to, $subject, $body)
    {
        $mail = \Swift_Message::newInstance();

        $mail
            ->setFrom($this->from, $this->name)
            ->setTo($to)
            ->setSubject($subject)
            ->setBody($body)
            ->setReplyTo($this->reply, $this->name)
            ->setContentType("text / html");

        $this->mailer->send($mail);
    }

    public function sendRefusMessage(User $user)
    {
        $subject = "Votre annonce à été refusée";
        $template = "AcmeBlogBundle:Mail:refus . html . twig";
        $to = $user->getEmail();
        $body = $this->templating->render($template, array("user" => $user));
        $this->sendMessage($to, $subject, $body);
    }

}
