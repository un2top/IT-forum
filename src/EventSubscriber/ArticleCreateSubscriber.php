<?php

namespace App\EventSubscriber;

use App\Events\ArticleCreateEvent;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class ArticleCreateSubscriber implements EventSubscriberInterface
{

    /**
     * @var MailerInterface
     */
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function onArticleCreated(ArticleCreateEvent $event)
    {

        if ($event->getArticle()->getAuthor()->getFirstName() !== 'admin') {

            $email = (new TemplatedEmail())
                ->from(new Address('noreply@symfony.skillbox', 'Spill-Coffee-On-The-Keyboard'))
                ->to(new Address('admin@symfony.skillbox', 'admin'))
                ->subject(sprintf('Была создана статья %s', $event->getArticle()->getTitle()))
                ->htmlTemplate('email/newarticle.html.twig')
                ->context(['article' => $event->getArticle()]);

            $this->mailer->send($email);
        }

    }

    public static function getSubscribedEvents()
    {
        return [
            ArticleCreateEvent::class => 'onArticleCreated'
        ];
    }
}
