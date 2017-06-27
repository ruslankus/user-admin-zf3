<?php

namespace MailService\Service;


use Zend\View\Model\ViewModel;
use Zend\View\Renderer\RendererInterface;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Message;
use Zend\Mime\Mime;
use Zend\Mime\Part as MimePart;
use Zend\Mime\Message as MimeMessage;

class MailService
{
    protected $mailTransport;
    protected $mailTemplateRenderer;
    protected $from;


    public function __construct( SmtpTransport $mailTransport, RendererInterface $mailRenderer, $from)
    {
        $this->mailTransport = $mailTransport;
        $this->mailTemplateRenderer = $mailRenderer;
        $this->from = $from;

    }


    public function sendResetTokenMail($sendTo , $resetUrl)
    {

        $viewContent = new ViewModel(compact('resetUrl'));
        $viewContent->setTemplate('mail/reset-pass');
        $mailContent = $this->mailTemplateRenderer->render($viewContent);

        $message = new Message();
        $message->setFrom($this->from);
        $message->setSubject('Reset token');

        $htmlPart = new MimePart($mailContent);
        $htmlPart->type = Mime::TYPE_HTML;
        $htmlPart->charset = 'utf-8';
        $htmlPart->encoding = Mime::ENCODING_QUOTEDPRINTABLE;

        $body = new MimeMessage();
        $body->setParts([$htmlPart]);

        $message->setTo($sendTo);
        $message->setBody($body);
        $this->mailTransport->send($message);

        return true;
    }
}